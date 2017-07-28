<?php
session_start();
ini_set('display_errors','off');
include("condition.php");
include("config.php");
$user_id = $_SESSION['ebank_user_id'];
$title = 'Logout';
$message = 'Logout Distributor ';
data_logs($user_id,$title,$message,0);
session_unset();
echo '<script type="text/javascript">' . "\n";
echo 'window.location="index.php";';
echo '</script>'; 