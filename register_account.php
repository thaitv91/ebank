<?php 
	$db_host = "localhost";
	$db_username = "ebank_live";
	$db_password = "xt2Jk9?0";
	$db = "ebank_live";
	$con=mysql_connect($db_host,$db_username,$db_password);
	mysql_select_db($db,$con);

	if($con){
		echo 'ok';
	}
?>