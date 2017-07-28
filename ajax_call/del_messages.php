<?php 
ini_set('display_errors','off');
session_start();
include "../config.php";

include('../function/setting.php');

include('../function/functions.php');

$string_id = $_POST['string_id'];
if(!empty($string_id)){
	$str_arr = explode(",",$string_id);
	foreach ($str_arr as $key => $value) {
		mysql_query("DELETE FROM message WHERE id =  $value");
	}
	echo 'ok';
}
?>