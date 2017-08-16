<?php
//error_reporting(1);
//require ("../config.php");
//require ("functions.php");
function get_speed_bonus($giver_id,$amount,$table_id,$date)
{
	include("setting.php");
	$time = date('Y-m-d H:i:s', time());
	$sql = "SELECT TIMESTAMPDIFF(SECOND, time_link, time_reciept) as table_diff from income_transfer where id='$table_id'";

	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	$table_diff = $row['table_diff'];
	
	// find real parent of $giver_id
	$user = mysql_query("select * from users where id_user = ".$investment_user_ids." ");
	$trrr = mysql_fetch_array($user);
	$parent_sponsor = $trrr['real_parent'];
	//find investment id
	$investment_id = mysql_query('select * from income_transfer where id = '.$table_id.'');
	$row_investment_id = mysql_fetch_array($investment_id);
	//find plansetting id from investment_request
	$investment_request = mysql_query('select * from investment_request where id = '.$row_investment_id['investment_id'].'');
	$row_investment_request = mysql_fetch_array($investment_request);
	//select plansetting
	$plan_setting = mysql_query('select * from plan_setting where id = '.$row_investment_request['plan_setting_id'].'');
	$row_plan_setting = mysql_fetch_array($plan_setting);

	//incomedays 
	$incomedays = $row_plan_setting['days'];
	//profit
	$profit = $row_plan_setting['profit'];
	
	//số ngày từ khi Pd đến khi Automated Link
	$date_from = $row_investment_request['date'].' '.$row_investment_request['time'];
	$date_to = $row_investment_request['app_date'].' '.$row_investment_request['app_time'];

	$datetime1 = new DateTime($date_from);
	$datetime2 = new DateTime($date_to);

	$diff = $datetime1->diff($datetime2);
	$array = get_object_vars($diff);
	
	$date_income_fee = $array['days'] ;
	
	
	//if($speed_bonus_maximum_time >= $table_diff)
	//{
		//$income = $amount * $speed_bonus_percent /100;
		//$income = $amount * ($profit /100) * $date_income_fee;

		$income = ($amount * (33 / 25)) - $amount;
		//mysql_query("insert into user_income (user_id , income , date , type ) values ('$giver_id' , '$income' , '$date' , '".$income_type[8]."') ");
		mysql_query("insert into user_income (user_id , income, income_id, investment_id , date , type ) 
		values ('".$parent_sponsor."' , '$income', '".$row_investment_id['id']."', '".$row_investment_id['investment_id']."' , '".$time."' , '".$income_type[8]."') ");
		update_member_wallet($giver_id,$income,$income_type[8],$amount,$row_investment_id['investment_id']);	
		
		$pac_roi = $amount + $income;
		//get wallet_balance from user_id
		$tb_wallet = mysql_query("SELECT * FROM  wallet WHERE id = $giver_id"); 
		$row_wallet = mysql_fetch_array($tb_wallet);
		// update into account for Main wallet
		$account = mysql_query("INSERT INTO account (user_id, cr, type, date, account, wallet_balance, wall_type)  VALUES ($giver_id, $pac_roi, '".$acount_type[13]."', '".$time."', '".$acount_type_desc[27].$table_id."', ".$row_wallet['amount'].", '".$wallet_type[1]."')");
		
		$cash_wal = get_wallet_amount($giver_id);
		//insert_wallet_account($giver_id, $giver_id, $income, $time, $acount_type[13],$acount_type_desc[13], 1, $cash_wal , $wallet_type[1]); 
	//}
	
}
 
function get_ten_level_sponsor_income($user_id,$investment,$direct_percent1,$date,$level1)
{
	
	include("setting.php");
	$time = date('Y-m-d H:i:s');
	$cnt = 1;
	$id = $user_id;
	do
	{
		$id = real_par($id);
		if($id > 0)
			$income_real_parent[$cnt] = $id;
		$cnt++;
	}while($id > 0 and $cnt < 3);
	//$date = date('Y-m-d');
	$real_p_count = count($income_real_parent);
	
	$q = mysql_query("select * from level_plan ");
	while($row = mysql_fetch_array($q))
	{
		for($l = 1; $l < 12; $l++)
		{ 
			$level_income_setting[$l] = $row['level_income_'.$l];
		}
	}
	$level_arraay = array();
	for($i = 1; $i <= $real_p_count; $i++)
	{
		$level_income_setting[$level1];
	 	$direct_percent = $direct_percent1 * $level_income_setting[$level1]/100;
		$income = ($investment*($direct_percent/100));
		$income_id = $income_real_parent[$i];
		$user_level = get_user_level($income_id);
		
		if(!in_array($user_level,$level_arraay) and $level1 < $user_level and $income > 0){
		 $level_arraay[] = $user_level; 
		mysql_query("insert into user_income (user_id , income , income_id, date , type, level ) values ('$income_id' , '$income' , '$user_id' ,'$date' , '$income_type[5]','$i') ");
		update_member_wallet($income_id,$income,$income_type[5]);
		$cash_wal = get_wallet_amount($income_id);
		//insert_wallet_account($income_id, $income_id, $income, $time, $acount_type[14],$acount_type_desc[14], 1, $cash_wal , $wallet_type[1]); 
		}
	}	
}
