<?php
ini_set("display_errors",'off');
session_start();
if(isset($_POST["sponsor_username"])){
	require_once("config.php");
	$sponsor_username =  $_POST["sponsor_username"]; 

	//check username in db
	$results = mysql_query("SELECT * FROM users WHERE username = '$sponsor_username'");
	
	//return total count
	$username_exist = mysql_num_rows($results); //total records
	
	//if value is more than 0, username is not available
	if($username_exist) {
		while($rrrrr = mysql_fetch_array($results)) {
			$name = $rrrrr['f_name']; 
			$_SESSION['sponsor_email_id'] = $name;	
		}
		die('<font color=green><strong>'.ucfirst($name).'</strong></font>');
	}else{
		die('<font color=red><strong>Incorrect Sponsor Id !</strong></font>');
	}
}

if(isset($_POST["change_username"])) {
	require_once("config.php");
	$username =  $_POST["change_username"]; 

	//check username in db
	$results = mysql_query("SELECT * FROM users WHERE username = '$username'");
	
	//return total count
	$username_exist = mysql_num_rows($results); //total records
	
	//if value is more than 0, username is not available
	if($username_exist) 
	{
		die('<font color=red><strong> Username Already Exist </strong></font>');
	}else{
		die('<font color=green><strong>OK</strong></font>');
	}
}
?>