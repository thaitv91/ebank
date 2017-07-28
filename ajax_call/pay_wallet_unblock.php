<?php
	ini_set('display_errors','off');
	session_start();
	include "../config.php";
	include('../function/setting.php');
	include('../function/functions.php');



	$mode    = $mode_report[6] ;
	$date = date('Y-m-d H:i:s');



	$id     = $_POST['id'];
	$amount = $_POST['amount'];
	$mode   = $_POST['mode'];

	$q_wallet = mysql_query("SELECT * FROM wallet WHERE id = ".$id."");
	$r_wallet = mysql_fetch_array($q_wallet);
	$main_wallet = $r_wallet['amount'];
	$comm_wallet = $r_wallet['com_wallet'];
	$sum_amount = $main_wallet + $comm_wallet;
	$deduct_mw  = $main_wallet - $amount;
	$deduct_cw  = $comm_wallet - ($amount - $main_wallet);

	if($main_wallet >= $amount){
		$update_wallet = mysql_query("UPDATE wallet SET amount = ".$deduct_mw." WHERE id = ".$id."");
	}else{
		$update_wallet = mysql_query("UPDATE wallet SET amount = 0 , com_wallet = ".$deduct_cw." WHERE id = ".$id."");
	}

	if($update_wallet){
		//remove user into report
		$remove_report = mysql_query("DELETE FROM report WHERE reported = ".$id."");

		//insert into tb_report_history
		mysql_query("INSERT INTO tb_report_history (user_id , mode , date)  VALUES ('$id' , '$mode' , '$date')");

		echo 'ok';
	}else{
		echo 'ko ok';
	}
		
?>