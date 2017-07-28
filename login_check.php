<?php
session_start();
ini_set('display_errors','off');
include('config.php');
include('function/functions.php');
$username = mysql_real_escape_string($_POST['username'],$con);
$password = mysql_real_escape_string($_POST['password'],$con);
$sql = "select t1.*,t2.type as manager_type from users t1
left join user_manager as t2 on t1.id_user = t2.manager_id where t1.username='$username' && t1.password='$password' ";

$sql1=mysql_query($sql);
$f_p = $_POST['forgetPassword'];
$count = mysql_num_rows($sql1);
if($count>0) {	
	while($row = mysql_fetch_array($sql1)) {
		$_SESSION['user_manager_type'] = $row['manager_type'];
		$ip_id = $_SESSION['ebank_user_id'] = $row['id_user'];
		$cnt = 1;
		$dw_li[0] = $ip_id;
		for($i = 0; $i < $cnt; $i++) {
			$id = $dw_li[$i];
			$sql = "select id_user from users where parent_id='$id'";
			$qu = mysql_query($sql);
			$numq = mysql_num_rows($qu);
			if($numq > 0) {
				while($rt = mysql_fetch_array($qu)) {
					$dw_li[$cnt] = $rt['id_user'];
					$cnt++;
				}
			}
		}
		unset($dw_li[0]);
		$dw_li = array_values($dw_li);
		$_SESSION['ebank_user_network'] = $dw_li;
		$_SESSION['ebank_user_type'] = $row['type'];
		$_SESSION['ebank_user_freeze_mode'] = $row['freeze'];
		$_SESSION['ebank_user_block_mode'] = $row['block'];
		$_SESSION['ebank_user_protect_mode'] = $row['protected'];
		$_SESSION['ebank_user_mode'] = $row['mode'];
		$_SESSION['ebank_user_status'] = $row['status'];
		$_SESSION['ebank_user_full_name'] = $row['f_name']." ".$row['l_name'];
	}
	$ip_Add = $_SERVER['REMOTE_ADDR']."(".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].")";
	$datess = date('Y-m-d');
	mysql_query("insert into ips_address (user_id , ip_add , date) values ('$ip_id' , '$ip_Add' , '$datess') ");
	
	$_SESSION['ebank_user_name']=$_POST['username'];
	$_SESSION['ebank_user_position']=$_POST['position'];
	$_SESSION['ebank_user_email']=$_POST['email'];
	
	$client_ip_add = $_SERVER['REMOTE_ADDR'];
	$q = mysql_query("select * from block_ip_address where block_ip_address = '$client_ip_add' ");
	$num = mysql_num_rows($q);
	if($num > 0) {
		$_SESSION['royalforexgroup_client_ip_blocked'] = 1; 
	}
	else { 
		$_SESSION['royalforexgroup_client_ip_blocked'] = 0;  
	}
	
	$_SESSION['ebank_user_login'] = 1;
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php\"";
	echo "</script>";
} else {
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"login.php?err=1\"";
	echo "</script>";
}
?>