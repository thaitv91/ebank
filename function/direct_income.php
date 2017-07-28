<?php

/*include("../config.php"); 
include("functions.php");*/

function get_direct_income($id , $amount , $direct_income_percent , $date)
{
	$real_parent = real_par($id);
	//include("setting.php");

	$income = $amount*($direct_income_percent/100);
	mysql_query("insert into user_income (user_id , income , date , type ) values ('$real_parent' , '$income' , '$date' , '$income_type[1]') ");
	update_member_wallet($real_parent,$income,$income_type[1] , $date);
}

//get_direct_income(2);

function get_ten_level_sponsor_income($user_id,$investment,$direct_percent,$date)
{
	include("setting.php");
	$cnt = 1;
	$id = $user_id;
	do
	{
		$id = real_par($id);
		if($id > 0)
			$income_real_parent[$cnt] = $id;
		$cnt++;
	}while($id > 0 and $cnt < 10);
	//$date = date('Y-m-d');
	$real_p_count = count($income_real_parent);
	$income = ($investment*($direct_percent/100))/10;
	for($i = 1; $i <= $real_p_count; $i++)
	{
		$income_id = $income_real_parent[$i];
		mysql_query("insert into income (user_id , amount , date , type ) values ('$income_id' , '$income' , '$date' , '$income_type[5]') ");
		update_member_wallet($income_id,$income,$income_type[5]);
	}	
}

function insert_into_reg_fees_structure($user_id,$fees)
{
	$date = date('Y-m-d');
	mysql_query("insert into reg_fees_structure (user_id , reg_fees , date ) values ('$user_id' , '$fees' , '$date' ) ");
}

function update_reg_fees_structure($user_id,$fees)
{
	$date = date('Y-m-d');
	$end_date = date('Y-m-d', strtotime($date . ' +100 days'));
	mysql_query("update reg_fees_structure set date = '$date' , end_date = '$end_date' , mode = 1 where user_id = '$user_id' and reg_fees = '$fees' and mode = 2 ");
}

function get_investment_direct_income($id,$investments,$date)
{
	$real_parent = real_par($id);
	include("setting.php");
	//$date = date('Y-m-d');
	$income = $investments*($direct_income_percent/100);
	mysql_query("insert into income (user_id , amount , date , type ) values ('$real_parent' , '$income' , '$date' , '$income_type[1]') ");
	update_member_wallet($real_parent,$income,$data_log,$log_type);
}

function get_reward_income($date)
{
	$real_parent = real_par($id);
	include("setting.php");
	$query = mysql_query("select * from pair_point group by user_id ");
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$id = $row['user_id'];
			$incquery = mysql_query("select SUM(left_point) , SUM(right_point) from pair_point where user_id = '$id' ");
			while($inc_row = mysql_fetch_array($incquery))
			{
				$left_pair = $inc_row[0];
				$right_pair = $inc_row[1];
				$total_pair = min($left_pair,$right_pair);
				
				for($j = 1; $j < 11; $j++)
				{
					if($reward_lvl_pair_db[$j] <= $total_pair)
					{
						$chk_rwd = chk_reward_inc($id,$j);
						if($chk_rwd == 1)
						{
							$income = $reward_lvl_inc_db[$j];
							mysql_query("insert into income (user_id , amount , date , type , incomed_id) values ('$id' , '$income' , '$date' , '$income_type[5]' , '$j') ");
							update_member_wallet($id,$income,$data_log,$log_type);
						}
					}
				}		
			}	
		}	
	}	
}

function chk_reward_inc($id,$leveles)
{
	include("setting.php");
	$query = mysql_query("select * from income where type = '$income_type[5]' and user_id = '$id' and incomed_id = '$leveles' ");
	$num = mysql_num_rows($query);
	if($num > 0)
		return 0;
	else
		return 1;	
		
		
}


