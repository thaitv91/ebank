<?php
error_reporting(0);
session_start();
include("../condition.php");
include("../config.php");
require_once("../function/functions.php");
include("../function/setting.php");
$user_id = $_SESSION['ebank_user_id'];

$curr_amnt = get_wallet_amount($user_id);

$request_amount = $_POST['request'];
$sec_code = $_POST['sec_code'];

$query = mysql_query("SELECT * FROM user_code WHERE user_id = '$user_id' ");
while($row = mysql_fetch_array($query))
{
	$code1 = $row['code1'];
}

if($sec_code == $code1)
{
	if($request_amount <= $curr_amnt)
	{
		if($request_amount >= $minimum_withdrawal and $request_amount <= $maximum_withdrawal)
		{
			$time = date('Y-m-d H:i:s');
			$sql = "insert into income (user_id , total_amount , paid_limit , date , mode , 
			priority ,  rec_mode , time) values ('$user_id' , '$request_amount' , '$request_amount' ,
			 '$systems_date' , 1 , 1 , 1 , '$time')";
			mysql_query($sql);
					
			$left_bal = $curr_amnt-$request_amount;
			mysql_query("update wallet set amount = '$left_bal' where id = '$user_id' ");
			
			$acc_username_log = get_user_name($id);
			$income_log = $request_amount;
			$date = $systems_date;
			$wallet_amount_log = $curr_amnt;
			$total_wallet_amount = $left_wallet_amount;
			include("function/logs_messages.php");
			data_logs($id,$data_log[16][0],$data_log[16][1],$log_type[4]);
			
			$phone = get_user_phone($id);
			$db_msg = $setting_sms_user_investment_request;
			include("function/full_message.php");
			send_sms($phone,$full_message);	
			
			echo "<B style=\"color:#008000;\">You request for Withdrawal amount ".$request_amount." has been completed successfully!!</B>";
		}
		else{ echo "<B style=\"color:#FF0000;\">Please Enter Correct Amount!!</B>"; }
		
	}
	else{ echo "<B style=\"color:#FF0000;\">Error : insufficient Balance !!</B>"; }
}
else
{
	echo "<B style=\"color:#FF0000;\">Please enter correct code !!</B>";
}

?>
