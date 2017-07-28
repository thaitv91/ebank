<?php

function calculate_level_income($user_id,$investment_amount,$date)
{
	include("setting.php");
	$id = $user_id;
	$qer = mysql_query("select * from level_plan ");
	while($row = mysql_fetch_array($qer))
	{
		for($j = 1; $j < 11; $j++)
		{ 
			$levels[$j] = $row['level_income_'.$j];
		}
	}
	for($i = 1; $i < 11; $i++)
	{
		if($levels[$i] > 0)
		{
			$par_id = get_parent($id);
			if($par_id > 0)
			{
				$inc_id = $par_id;	
				$inc_id_type = get_type($inc_id);		
				if($inc_id_type == 'B' or $inc_id_type == 'C' or $inc_id_type == 'D')
				{
					$level = $levels[$i];
					if($level > 0)
					{
						$income = $investment_amount*($level/100);
						mysql_query("insert into user_income (user_id , income , date , type , level) values ('$inc_id' , '$income' , '$date' ,  '$income_type[3]' , '$i') ");
	
						update_member_wallet($inc_id,$income,$income_type[3],$date);
					}
				}
			}
			else
			{
				$i = 12;
			}		
			$id = $par_id;
		}
		else
			$i = 12;	
	}			
}

function calculate_ten_level_income($user_id,$investment_amount,$date)
{
	include("setting.php");
	$id = $user_id;
	$qer = mysql_query("select * from manager_level ");
	while($row = mysql_fetch_array($qer))
	{
		for($j = 1; $j < 6; $j++)
		{ 
			$levels[$j] = $row['level_income_'.$j];
		}
	}
	for($i = 1; $i < 6; $i++)
	{
		if($levels[$i] > 0)
		{
			$par_id = get_parent_ids($id);
			if($par_id > 0)
			{
				$inc_id = $par_id;	
				$inc_id_type = get_type($inc_id);		
				if($inc_id_type == 'C' or $inc_id_type == 'D')
				{
					$level = $levels[$i];
					if($level > 0)
					{
						$income = $investment_amount*($level/100);
						mysql_query("insert into user_income (user_id , income , date , type , level) values ('$inc_id' , '$income' , '$date' ,  '$income_type[4]' , '$i') ");
	
						update_member_wallet($inc_id,$income,$income_type[4],$date);
					}
				}
			}
			else
			{
				$i = 6;
			}		
			$id = $par_id;
		}
		else
			$i = 6;	
	}			
}

function calculate_thousand_income($user_id,$investment_amount,$date)
{
	include("setting.php");
	$id = $user_id;
	do
	{
		$par_id = get_parent_ids($id);
		if($par_id > 0)
		{
			$inc_id = $par_id;	
			$inc_id_type = get_type($inc_id);		
			if($inc_id_type == 'D')
			{
				$income = $investment_amount*($setting_thou_nnager_income/100);
				mysql_query("insert into user_income (user_id , income , date , type) values ('$inc_id' , '$income' , '$date' ,  '$income_type[5]') ");

				update_member_wallet($inc_id,$income,$income_type[5],$date);
				
				$par_id = 0;
			}
		}
		$id = $par_id;
	}while($par_id > 1);			
}

function get_parent_ids($user_id) //gettinf real parent 
{
	$query = mysql_query("select * from users where id_user = '$user_id' ");
	while($row = mysql_fetch_array($query))
	{
		$parent = $row['parent_id'];
	}
	return $parent;
}

function get_parent($user_id) //gettinf real parent 
{
	$query = mysql_query("select * from users where id_user = '$user_id' ");
	while($row = mysql_fetch_array($query))
	{
		$parent = $row['real_parent'];
	}
	return $parent;
}


function get_type($user_id)  //getting type
{
	$query = mysql_query("select * from users where id_user = '$user_id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
	}
	return $type;
}


function calculate_magic_bonus($user_id,$income_transfer_amount,$date)
{
	include("setting.php");
	$bonus_inc = $income_transfer_amount*($setting_real_parent_bonus_inc/100);
	if($bonus_inc > 0)
	{
		$inc_real_par = get_bonus_real_parent($user_id);
		do
		{
			$real_parent_type = get_bonus_real_parent_type($inc_real_par);
			if($real_parent_type == 'C')
			{
				mysql_query("insert into user_income (user_id , income , date , type , level) values ('$inc_real_par' , '$bonus_inc' , '$date' , '$income_type[4]' , '$user_id') ");
				update_member_wallet($inc_real_par,$bonus_inc,$income_type[4],$date);
			}
			$inc_real_par = get_bonus_real_parent($inc_real_par);
		}while($inc_real_par > 0);
	}
}

function get_bonus_real_parent($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$real_parent  = $row['real_parent'];
		return $real_parent ;
	}	
}

function get_bonus_real_parent_type($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
		return $type;
	}	
}

function get_speed_bonus($giver_id,$amount,$table_id,$date)
{
	include("setting.php");
	$maximum_time = 24*60*60;
	$sql = "SELECT TIMESTAMPDIFF(SECOND, time_link, time_reciept) as table_diff from income_transfer where id='$table_id'";

	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	$table_diff = $row['table_diff'];
	
	if($maximum_time >= $table_diff)
	{
		$income = $amount * $speed_bonus_percent /100;
		mysql_query("insert into income (user_id , amount , date , type ) values ('$giver_id' , '$income' , '$date' , '".$income_type[8]."') ");
		update_member_wallet($giver_id,$income,$income_type[8]);	
	}
	
}
function get_confirmation_bonus($recver_id,$amount,$table_id,$date)
{
	include("setting.php");
	$date = 
	$maximum_time = 24*60*60;
	$sql = "SELECT TIMESTAMPDIFF(SECOND, time_link, time_confirm) as table_diff from income_transfer where id='$table_id'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	$table_diff = $row['table_diff'];
	if($maximum_time >= $table_diff)
	{
		$income = $amount * $confirmation_bonus_percent /100;
		mysql_query("insert into income (user_id , amount , date , type ) values ('$recver_id' , '$income' , '$date' , '".$income_type[9]."') ");
		update_member_wallet($recver_id,$income,$income_type[9]);
	}
}

