<?php

function calculate_level_income($user_id,$investment_amount,$date)
{
	include("setting.php");
	$id = $user_id;
	$qer = mysql_query("select * from level_plan ");
	while($row = mysql_fetch_array($qer))
	{
		for($j = 1; $j < 12; $j++)
		{ 
			$levels[$j] = $row['level_income_'.$j];
		}
	}
	
	$query = mysql_query("select * from users ");
	while($urow = mysql_fetch_array($query))
	{
		$par_id = urow['id_user'];
		
		$quu = mysql_query("select * from users where real_parent = '$par_id' ");
		$total_child = mysql_num_rows($quu);

		$que = mysql_query("select * from user_income where user_id = '$par_id' and type = 3 and income > 0 ");
		$total_child_income = mysql_num_rows($que);
		
		if($total_child > $total_child_income)
		{
			$count = $total_child-$total_child_income;
		
			for($i = 1; $i <= $count; $i++)
			{
				$inc_id = $par_id;	
				$inc_id_type = get_type($inc_id);		
				if($inc_id_type == 'B' or $inc_id_type == 'C')
				{
					$level = $levels[1];
					if($level > 0)
					{
						$income = $investment_amount*($level/100);
						mysql_query("insert into user_income (user_id , income , date , type , level) values ('$inc_id' , '$income' , '$date' ,  '$income_type[3]' , '$i') ");
		
						update_member_wallet($inc_id,$income,$income_type[3],$date);
					}
				}
			}
		}
	}
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

