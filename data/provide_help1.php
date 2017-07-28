<?php
error_reporting(0);
session_start();
include("../condition.php");
include("../config.php");
require_once("../function/functions.php");
include("../function/setting.php");
$user_id = $_SESSION['ebank_user_id'];

$request_amount = $_POST['request'];
$sec_code = $_POST['sec_code'];

$query = mysql_query("SELECT * FROM user_code WHERE user_id = '$user_id' ");
while($row = mysql_fetch_array($query))
{
	$code1 = $row['code1'];
}

if($sec_code == $code1)
{
	$sqls = "SELECT t1.mode as ir_mode , t2.mode as it_mode FROM investment_request t1
			left join income_transfer t2 on t1.id = t2.investment_id and t1.user_id = t2.paying_id
			WHERE t1.user_id = '$user_id'";
	$query = mysql_query($sqls);
	while($row = mysql_fetch_array($query))
	{
	 	$ir_mode = $row['ir_mode'];
		$it_mode = $row['it_mode'];
	}
	if(($ir_mode != '1' or $ir_mode == NULL) and ($it_mode == '2' or $it_mode == NULL) )
	//if($ir_mode != '1' or $it_mode == '2')
	{
		$income_time = date('H:i:s');
		$sql = "insert into investment_request (user_id , amount , inv_profit , date , time , mode , 
		rec_mode , priority) values ('$user_id' , '$request_amount', '$setting_inv_profit' , 
		'$systems_date' , '$income_time' , 1 , 0 , 1)";
		//mysql_query($sql);
		mysql_query($sql, $con );
		$invest_id = mysql_insert_id();
		
		$start_date = get_date_without_sun_sat($systems_date,0);
		$end_date = get_date_without_sun_sat($systems_date,20);
		$sqli = "insert into daily_interest (investment_id , member_id , amount , percent, date , start_date , end_date , count , max_count) values ('$invest_id' ,'$user_id' , '$request_amount' , '$setting_inv_profit' , '$systems_date' , '$start_date' , '$end_date' , 0 , '$setting_inv_days') ";
	
		mysql_query($sqli);
	
		echo "<B style=\"color:#008000;\">Commitment Done Successfully !!</B>";
	}
	else{ echo "<B style=\"color:#FF0000;\">Commitment Already Done By You !!</B>"; }
}
else
{
	echo "<B style=\"color:#FF0000;\">Please enter correct code !!</B>";
}

?>
