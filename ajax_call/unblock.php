<?php 
ini_set('display_errors','off');
session_start();
include "../config.php";
include('../function/setting.php');
include('../function/functions.php');

$id_user = $_POST['id'];
$mode    = $mode_report[6] ;
$date = date('Y-m-d H:i:s');

//remove user into report
$remove_report = mysql_query("DELETE FROM report WHERE reported = ".$id_user."");

//insert into tb_report_history
mysql_query("INSERT INTO tb_report_history (user_id , mode , date)  VALUES ('$id_user' , '$mode' , '$date')");

if($remove_report){
	echo 'ok';
}
?>