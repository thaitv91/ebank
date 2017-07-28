<?php
session_start();
ini_set('display_errors','off');
include('../config.php');

$username = mysql_real_escape_string($_REQUEST['username'],$con);
$password = mysql_real_escape_string($_REQUEST['password'],$con);

$sql = "select * from admin where username='".$username."' && password='".$password."' ";

$sql1=mysql_query($sql);
$f_p = $_POST['forgetPassword'];
$count = mysql_num_rows($sql1);

if($count > 0)
{	
	$_SESSION['dennisn_admin_name']=$_REQUEST['username'];
	$_SESSION['dennisn_admin_email']=$_REQUEST['email'];
	$_SESSION['dennisn_admin_login']=1;
	
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php\"";
	echo "</script>";
}
else
{
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"login.php?err=d\"";
	echo "</script>";
}

?>