<?php
ini_set("display_erros","off");
session_start();
include('config.php');
include("function/functions.php");
$br = "<br>";
$sql = "select paying_id,`time_link`,DATE_ADD(`time_link`, INTERVAL 48 HOUR) b_time,`extend_time` e_time 
		$brfrom income_transfer $br
		where mode=0 $br
		having b_time < '$systems_date_time'$br
		or e_time < '$systems_date_time'$br";
$sql = str_replace("<br>"," ",$sql);
$quer = mysql_query($sql);
$num = mysql_num_rows($quer);

if($num > 0) {
	while($row = mysql_fetch_array($quer)) {
		$freeze_time = $systems_date;
		$user_id = $row['paying_id'];
		$e_time = strtotime($row['e_time']);
		if($row['e_time'] == NULL or (strtotime($systems_date_time) > $e_time) ) {
			$real_p = real_parent($user_id);
			mysql_query("update users set type='D',block_date = '$systems_date_time',block_cnt = (block_cnt + 1) where id_user='$user_id'");
			mysql_query("update users set freeze=1,freeze_date = '$systems_date_time',freeze_cnt = (freeze_cnt + 1) where id_user='$real_p'");
		}
	}
}
?>
