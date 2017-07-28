<?php
error_reporting(0);
session_start();
include('config.php');
include("function/functions.php");
include("function/setting.php");
$br = "<br>";

$sql = "select paying_id,date from income_transfer it $br
		where  DATE_ADD(it.`date`, INTERVAL 48 HOUR) <= '$systems_date' and it.mode < 2$br
		group by it.investment_id,it.paying_id$br
		having count(it.investment_id) < 6$br
		order by id desc$br ";
$sql = str_replace("<br>"," ",$sql);
$quer = mysql_query($sql);
$num = mysql_num_rows($quer);
if($num > 0) {
while($row = mysql_fetch_array($quer)) {
 	$freeze_time = $systems_date;
	$end_date = $row['date'];
	$user_id = $row['paying_id'];
	$sql = "select * from users where id_user = '$user_id' and freeze_cnt < 3";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num > 0) {
		while($ro = mysql_fetch_array($query)) {
			$level = $ro['level'];
		}
		$hour = $max_time[$level];
		$end_date = date("Y-m-d",strtotime($end_date."+ $hour hour"));
		if($freeze_time >= $end_date) {
			$real_p = real_parent($user_id);
			mysql_query("update users set freeze=1,freeze_date='$systems_date_time',freeze_cnt = freeze_cnt + 1 where id_user='$user_id' ");
			mysql_query("update users set freeze=1,freeze_date='$systems_date_time',freeze_cnt = freeze_cnt + 1 where id_user='$real_p'");
		}
	}
 }
}
?>