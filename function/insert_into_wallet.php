<?php
function insert_into_wallet($user_id,$wallet_income,$inc_type)
{
	require_once("functions.php");
	include("setting.php");
	$query = mysql_query("select * from wallet where id = '$user_id' ");
	while($row = mysql_fetch_array($query))
	{
		$amount = $row['amount'];
	}
	$total_income = $amount+$wallet_income;	
	$date = date('Y-m-d');
	mysql_query("update wallet set amount = '$total_income' , date = '$date'  where id = '$user_id' ");
	if($inc_type == 1) { $wallet_income_type = "Survey"; }
	if($inc_type == 2) { $wallet_income_type = "Direct member"; }
	if($inc_type == 3) { $wallet_income_type = "Binary"; }
	
	$username = get_user_name($user_id);
	$position = get_user_position($user_id);
	$amount = $wallet_income;
	$date = date('Y-M-d');
	
	$time = date('Y-m-d H:i:s');
	$cash_wal = get_wallet_amount($user_id);
	insert_wallet_account($user_id,$user_id,$wallet_income,$time,$acount_type[12],$acount_type_desc[12], 1, $cash_wal , $wallet_type[1]); 
	
	include("setting.php");
	$full_msg = $wallet_log[1][1];
	$wallet_log[1][0];
	data_logs($user_id,$position,$wallet_log[1][0],$full_msg,$log_type[4]);
}	