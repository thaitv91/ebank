<?php 
ini_set('display_errors','off');
session_start();
include "../config.php";
include('../function/setting.php');
include('../function/functions.php');
include("function/sendmail.php");


$id_user = $_POST['id'];
$repd    = $_POST['repd'];
$time = date('Y-m-d H:i:s');


$q_fro = mysql_query("SELECT * FROM report WHERE reported = $id_user AND mode = 2");
if(mysql_num_rows($q_fro) > 0){
}else{
	$insert_block = mysql_query("INSERT INTO report (reported , report , mode , date , frozen_date) values ('$id_user' , '$alert_report[5]' , '$mode_report[2]' , '$time' , '$time') ");
	mysql_query("INSERT INTO tb_report_history (user_id , mode , date)  VALUES ('$id_user' , '$mode_report[2]' , '$time')");
	
	//send mail
	$email = get_user_email($id_user);
   	$name  = get_user_name($id_user);
    	$title = 'Your account has been frozen.';
    	$content = "Your account have been frozen!<br>You have 36 hours from now to solve your account's problems. Otherwise, it will be blocked.";
    	sendMail($email,$name,$title,$content);	
}



$query_usr = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
$row_usr = mysql_fetch_array($query_usr);

$query_gd_limit = mysql_query("SELECT * FROM re_pd_time WHERE level = ".$row_usr['level']." ");
$row_gd_limit   = mysql_fetch_array($query_gd_limit);

$rel_time_repd = time() + ($row_gd_limit['hour']*3600);

$date = date('Y-m-d H:i:s', $rel_time_repd);

$update = mysql_query("UPDATE tb_repd SET gd_time = '$date' WHERE id = $repd");
if($update){
	echo 'ok';
}


?>