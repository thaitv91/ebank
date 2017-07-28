<?php
error_reporting(0);
include "../config.php";
function chk_commitment($user_id){
	$sql = "select * from income_transfer where mode < 2 and paying_id='$user_id'";
	$qu = mysql_query($sql);
	$num =mysql_num_rows($qu);
	if($num > 0)
		return false;
	else
		return true;
}
function chk_block($user_id){
	$sql = "select * from users where type='D' and id_user='$user_id'";
	$qu = mysql_query($sql);
	$num =mysql_num_rows($qu);
	if($num > 0)
		return true;
	else
		return false;
}
function chk_freeze($user_id){
	$sql = "select * from users where type='F' and id_user='$user_id'";
	$qu = mysql_query($sql);
	$num =mysql_num_rows($qu);
	if($num > 0)
		return true;
	else
		return false;
}
/*function chk_protected($user_id){
	$sql = "select * from users where protected='0' and id_user='$user_id'";
	$qu = mysql_query($sql);
	$num =mysql_num_rows($qu);
	if($num > 0)
		return false;
	else
		return true;
}*/
?>