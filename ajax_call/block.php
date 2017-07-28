<?php 
ini_set('display_errors','off');
session_start();
include "../config.php";
include('../function/setting.php');
include('../function/functions.php');
include("../function/sendmail.php");




$id_user = $_POST['id'];
$mode    = $_POST['mode'];
$date = date('Y-m-d H:i:s');


if(!empty($_POST['time'])){
	$time    = $_POST['time'];
	//get tb_time_report
	$sql_time_block = mysql_query("SELECT * FROM tb_time_block");
	$row_time_report = mysql_fetch_array($sql_time_block);

	$time_block = $row_time_report['time_block'];
	$time_frozen = $row_time_report['time_frozen'];
	$frozen_downline = $row_time_report['frozen_downline'];
	$time_report = $row_time_report['time_report'];
	if($mode == 1){
		$rel_time = date('Y-m-d H:i:s',(strtotime($time) + $time_block*3600));
	}
	if($mode == 2){
		$rel_time = date('Y-m-d H:i:s',(strtotime($time) + $time_frozen*3600));
	}
	
}else{
	$rel_time = date('Y-m-d H:i:s');
}


$se_report = mysql_query("SELECT * fROM report WHERE reported = ".$id_user." AND mode = ".$mode."");
$re_report = mysql_fetch_array($se_report);
$update_block = mysql_query("UPDATE report SET mode = ".$mode_report[3]." , block_date = '".$rel_time."' WHERE id = ".$re_report['id']." ");
$delete_block = mysql_query("DELETE FROM report WHERE reported = ".$id_user." AND id <> ".$re_report['id']."");


if($update_block){
	//send mail
	$email = get_user_email($id_user);
    	$name  = get_user_name($id_user);
    	$title = 'Your account has been blocked.';
    	$content = "Your account have been blocked!<br>Please log in to solve your account's problems.";
    	sendMail($email,$name,$title,$content);
}



//update block time
mysql_query("UPDATE users SET block_time = block_time+1 , time_block = '".$date."' WHERE id_user = ".$id_user."");


if($delete_block){
	//insert into tb_report_history
	mysql_query("INSERT INTO tb_report_history (user_id , mode , date)  VALUES ('$id_user' , '$mode_report[3]' , '$date')");
	
	$real_parent = real_parent($id_user);
	if(!empty($real_parent)){
		$name_user = get_user_name($id_user);
		//kiểm tra user đã bị đóng băng chưa
		$check_fro = mysql_query("SELECT *  FROM report WHERE reported = ".$real_parent." AND mode = ".$mode_report[2]."");
		$count_fro = mysql_num_rows($check_fro);
		if(empty($count_fro)){
			//frozen this user_id
			mysql_query("INSERT INTO report (reported , report , mode , date, frozen_date) values ('$real_parent' , '$alert_report[2]' , '$mode_report[2]' , '$date', '$date') ");
			// insert into report history
			mysql_query("INSERT INTO tb_report_history (reported , report , mode , date)  VALUES ('$real_parent' , '".$name_user." ".$alert_report[3]."' , $mode_report[2]' , '$date')");
			 //update frozen time
			mysql_query("UPDATE users SET frozen_time = frozen_time+1 WHERE id_user = ".$real_parent."");
			
			//send mail
			$sender_username = get_user_name($real_parent);
			$to              = get_user_email($real_parent);
			$title           = 'Your account has been frozen.';
			$contentmail     = "Your account have been frozen!<br>You have 36 hours from now to solve your account's problems. Otherwise, it will be blocked.";
			$message         = contentEmail($sender_username, $contentmail);
			sendmail($to, $title, $message);
			
		}
	}
	
}


//delete investment_request by id_user 
$q_investment_request = mysql_query("SELECT * fROM investment_request WHERE mode = 1 AND user_id = ".$id_user."");
while($r_investment_request = mysql_fetch_array($q_investment_request)){
	$delete_invest = mysql_query("DELETE FROM investment_request WHERE id = ".$r_investment_request['id']."");
	
}



// chuyển income_transfer của các user giao dịch với id_user vào cột phải
$q_income_transfer = mysql_query("SELECT * fROM income_transfer WHERE mode = 1 OR mode = 0 AND paying_id = ".$id_user."");
while($r_income_transfer = mysql_fetch_array($q_income_transfer)){
	$move_income = mysql_query("INSERT INTO income (user_id , total_amount , paid_limit , date , mode , priority , rec_mode , time)  VALUES ('".$r_income_transfer['user_id']."' , '".$r_income_transfer['amount']."' , '".$r_income_transfer['paid_limit']."' , '".$r_income_transfer['date']."' , '1' , '1' , '1' , '".$r_income_transfer['time_link']."')");

	// xóa income_transfer của id_user
	$remove_incom_transfer = mysql_query("DELETE FROM income_transfer WHERE id = ".$r_income_transfer['id']."");
}



if($update_block){
	echo '<span class="approve_remaining_time text-red">Account being blocked</span>
		<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Detail</button>
		<button data-id="'.$id_user.'" type="button" class="block_user btn btn-danger">Unblock</button>';
}
?>