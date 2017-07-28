<?php
error_reporting(0);
session_start();
include("../condition.php");
include("../config.php");
include("../function/functions.php");
$user_id = $_SESSION['ebank_user_id'];
$phone = get_user_phone($user_id);

$date = date('Y-m-d');
$code_1 = rand(1000 , 9999);
$code_2 = rand(1000 , 9999);
$code_3 = rand(1000 , 9999);
$code_4 = rand(1000 , 9999);	
$code_5 = rand(1000 , 9999);
$code_6 = rand(1000 , 9999);
$code_7 = rand(1000 , 9999);
$code_8 = rand(1000 , 9999);
$code_9 = rand(1000 , 9999);
$code_10 = rand(1000 , 9999);
		 
$sql = "UPDATE user_code SET code1 = '$code_1' , code2 = '$code_2' , code3 = '$code_3' , code4 = '$code_4' , code5 = '$code_5' , code6 = '$code_6' , code7 = '$code_7' , code8 = '$code_8' , code9 = '$code_9' , code10 = '$code_10' , date = '$date' WHERE user_id = '$user_id' ";
mysql_query($sql);

$message_code = "Your verification code is ".$code_1." - ".$code_2." - ".$code_3." - ".$code_4." - ".$code_5." - ".$code_6." - ".$code_7." - ".$code_8." - ".$code_9." - ".$code_10." www.cryptohelps.net";
send_sms($phone,$message_code);

echo "<B style=\"color:#008000;\">Your Code has been sent to your mobile no. please check your mobile !!</B>";

?>
