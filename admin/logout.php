<?php
session_start();
ini_set('display_errors','off');
include("condition.php");
if(isset($_SESSION['temp_dennisn_user_login']))
{
	session_unset();
	mysql_close($con);
	echo '<script type="text/javascript">' . "\n";
	echo 'window.location="login.php";';
	echo '</script>';
}
else
{
	session_unset();
	mysql_close($con);
	echo '<script type="text/javascript">' . "\n";
	echo 'window.location="login.php";';
	echo '</script>'; 
}