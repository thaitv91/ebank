<?php
include("../config.php");
include("functions.php");

function pair_point_calculation()
{
	include("setting.php");
	$q = mysql_query("select * from users ");
	$n = mysql_num_rows($q);
	for($id = 1; $id <= $n; $id++)
	{
		$user_info = all_child($id);  // $child[0][1]  $child[1][1]
		print $left_point = $user_info[0][1];
		print $right_point = $user_info[1][1];
		$carry_forward = point_carry_forward($id);
			if($carry_forward[1] == 0) { print $left_point = $left_point+$carry_forward[0]; }
			if($carry_forward[1] == 1) { print $right_point = $right_point+$carry_forward[0]; }
		$date = date('Y-m-d');
		if($left_point != 0 or $right_point != 0)
		{	
			mysql_query("insert into pair_point (user_id , left_point , right_point , date) values ('$id' , '$left_point' , '$right_point' , '$date') ");
			
			$income = get_pair_point_income($left_point,$right_point);
			if($income >0)
			{
				mysql_query("insert into income (user_id , amount , date , type ) values ('$id' , '$income' , '$date' , '$income_type[3]') ");
				update_member_wallet($id,$income,$data_log,$log_type);
			}
		}
	}
}

pair_point_calculation();

function get_child($id)
{
	$reg_point = 0;
	$total_child = 0;
	$child[0] = $id;
	$q = mysql_query("select * from users where id_user = '$child[0]' ");
	while($row = mysql_fetch_array($q))
	{
			$reg_point = $reg_point+get_uses_points($child[0]);
			$total_child++;
	}
	$count = count($child);
	for($i = 0; $i <$count; $i++)
	{
			$child_id = $child[$i];
			$query = mysql_query("select * from users where parent_id = '$child_id' ");
			$num = mysql_num_rows($query);
			if($num != 0)
			{
				while($row = mysql_fetch_array($query))
				{
					$u_id = $row['id_user'];
					$reg_point = $reg_point+get_uses_points($u_id);
					$child[] = $u_id;
					$total_child++;
				}
			}
		$count = count($child);
	}
	$result[0] = $total_child;
	$result[1] = $reg_point;
	return $result;
}

function get_uses_points($id)
{
	$point = 0;
	$previous_start_date =  date("Y-m-1", strtotime("-1 month") ) ;
	$previous_last_date = date("Y-m-t", strtotime("-1 month") ) ;
	$query = mysql_query("select * from reg_fees_structure where user_id = '$id' and date >= '$previous_start_date' and date <= '$previous_last_date' ");
	$num = mysql_num_rows($query);
	while($row = mysql_fetch_array($query))
	{
		$point = $point+$row['reg_fees'];
		$point = $point+$row['update_fees'];
	}	
	return $point;
}

function all_child($id)  //give number of child which have type 'c' and currenr date joined
{
	$query = mysql_query("select * from users where parent_id = '$id' and position = 0 ");
	$num = mysql_num_rows($query);
	if($num == 0)
	{
		$child[0] = 0;
		$child[1] = 0;
		return $child;
	}
	while($row = mysql_fetch_array($query))
	{
		$left = $row['id_user'];
		$child[0] = get_child($left);
	}
	$query = mysql_query("select * from users where parent_id = '$id' and position = 1 ");
	$num1 = mysql_num_rows($query);
	if($num1 == 0)
	{
		$child[1] = 0;
		return $child;
	}
	while($row = mysql_fetch_array($query))
	{
		$right = $row['id_user'];
		$child[1] = get_child($right);
	}
	return $child;
}

/*$child = all_child(1);
print "left clild".$child[0][0]."  right point".$child[0][1]."<br>"."left clild".$child[1][0]."  right point".$child[1][1]; */


function point_carry_forward($id)
{
	$curr_date = date("Y-m-t", strtotime("-1 month") );
	$query = mysql_query("select * from pair_point where user_id = '$id' and date < '$curr_date' ORDER BY id DESC LIMIT 1 ");
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$child[0] = $row['left_point'];
			$child[1] = $row['right_point'];
		}
		if($child[0] < $child[1])
		{
			$max[0] = $child[1]-$child[0];
			$max[1] = 1;
		}
		else
		{
			$max[0] = $child[0]-$child[1];
			$max[1] = 0;
		}
	}
	else { 	
			$max[0] = 0;
			$max[1] = 0;
		 }
	return $max;
}

function get_pair_point_income($left_point,$right_point)
{
	include("setting.php");
	$pair = min($left_point,$right_point);
	$income = $pair*($pair_point_percent/100);
	return $income;
}


/*$check_date_end = date('Y-m-d');
	$check_date_start =  date("Y-m-1", strtotime("-0 month") ) ;
	$qu = mysql_query("select * from income where date >= '$check_date_start' and date <= '$check_date_end' " );
	$check_num = mysql_num_rows($qu);
	if($check_num == 0)
	{
		include("setting.php");
		$curr_date = date('Y-m');
		
		$previous_start_date =  date("Y-m-1", strtotime("-1 month") ) ;
		$previous_last_date = date("Y-m-t", strtotime("-1 month") ) ;*/