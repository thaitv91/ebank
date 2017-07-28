<?php
session_start();
ini_set('display_errors','off');
include('config.php');
include('function/setting.php');
$user_id = $_SESSION['ebank_user_id'];
$pin = $_REQUEST['pin']*$epin_value;
$pin = $pin / ($epin_value*$plan_diff);
$sql = "select count(*) req_pin  from e_pin where mode=1 and user_id='$user_id' having req_pin >= '$pin'";
$sql = mysql_query($sql);
$num = mysql_num_rows($sql);
if($num < 1) {
	print "Pin Wallet Not Sufficent !!";
}
?>