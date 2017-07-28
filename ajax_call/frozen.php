<?php 
ini_set('display_errors','off');
session_start();
include "../config.php";

include('../function/setting.php');

include('../function/functions.php');


$id_user = $_POST['id'];
$mode = $_POST['mode'];
$time = $_POST['time'];
$date = date('Y-m-d H:i:s');


//remove user into report
$remove_report = mysql_query("DELETE FROM report WHERE reported = ".$id_user."");

//insert into tb_report_history
mysql_query("INSERT INTO tb_report_history (user_id , mode , date)  VALUES ('$id_user' , '$mode_report[4]' , '$date')");

//update time in income_transfer by id_user
$q_income_transfer = mysql_query("SELECT * fROM income_transfer WHERE mode = 1 OR mode = 0 AND paying_id = ".$id_user."");
while($r_income_transfer = mysql_fetch_array($q_income_transfer)){
	if($r_income_transfer['mode'] == 0){
		mysql_query("UPDATE income_transfer SET time_link = '".$date."' WHERE id =  ".$r_income_transfer['id']."");
	}
	// if($r_income_transfer['mode'] == 1){
	// 	mysql_query("UPDATE income_transfer SET time_reciept = '".$date."' WHERE id =  ".$r_income_transfer['id']."");
	// }
}

//update time in investment_request by id_user 
$q_investment_request = mysql_query("SELECT * fROM investment_request WHERE mode = 5 AND user_id = ".$id_user."");
while($r_investment_request = mysql_fetch_array($q_investment_request)){
	mysql_query("UPDATE investment_request SET mode = 1 WHERE id =  ".$r_investment_request['id']."");
}

//update time in income by id_user
$q_income = mysql_query("SELECT * fROM income WHERE mode = 5 AND user_id = ".$id_user."");
while($r_income = mysql_fetch_array($q_income)){
	mysql_query("UPDATE income SET mode = 1 WHERE id =  ".$r_income['id']."");
}

echo 'ok';
?>