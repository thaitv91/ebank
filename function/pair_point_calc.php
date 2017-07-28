<?php
/*ini_set("display_errors",'off');
include("../config.php");
$sql = "select * from daily_interest";
$query = mysql_query($sql);
while($rr = mysql_fetch_array($query))
{
	$user_id = $rr['member_id'];
	$date = $rr['date'];
	pair_point_calculation($user_id,$date);
}*/

	

/*print_r(point_carry_forward(77,'2015-10-29'));*/
function pair_point_calculation($id,$date)
{

$sql = "select * from daily_interest where member_id = '$id' and date= '$date'";
$query = mysql_query($sql);
$cnt = mysql_num_rows($query);
	if($cnt > 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$amount = $row['amount'];
		}
		$parents = get_all_parent($id);
		$cnt_parent = count($parents[0]); 
		for($i = 1; $i < $cnt_parent ; $i++)
		{
			$pair_field = '';
			switch($parents[1][$i])
			{
				case 0 : $pair_field = 'left_point';
						  break;
				case 1 : $pair_field = 'right_point';
						  break;
			}
			$chk = chk_pair_poin_id_exist($parents[0][$i]);
			$user_id = $parents[0][$i];
			if($user_id > 0)
			{
				if($chk == 0)
				{	
				 	$sql_insert = "insert into pair_point (user_id, $pair_field, date) values('$user_id','$amount','$date')";
					mysql_query($sql_insert);
				
				}
				else
				{
					$carry_day = date("D", strtotime($date));
					
					$chk_2 = chk_pair_poin_id_exist_with_date($parents[0][$i],$pair_field,$date);
					if($chk_2[0][0] == 1)
					{
						$pair_amount = $chk_2[0][1];
						$pair_id = $chk_2[0][2];

					 	$sql_update = "update  pair_point set  $pair_field = $amount+$pair_amount
						where id = '$pair_id' and user_id = '$user_id' ";
						mysql_query($sql_update);					
					}
					
					if($chk_2[0][0] == 0)
					{				
					
						$carry_forward = point_carry_forward($user_id,$date);


							$left_point = 	$carry_forward[0];

						$right_point = 	$carry_forward[1];

/*						 
						$max_point = min($left_point ,$right_point);
						if($max_point >= 100)
						{
							$left_point = 	$carry_forward[0];
							$right_point = 	$carry_forward[1];
						}
						else
						{
							$left_point = 0;
							$right_point = 0;
						}
*/
						if($pair_field == 'right_point')
						{
							$right_point = $amount + $right_point;
							$left_point = $left_point;
						}
						
						if($pair_field == 'left_point')
						{
							$left_point = $amount + $left_point;
							$right_point = $right_point;
						}
						
						$insert_left_point = $left_point;
						$insert_right_point = $right_point;

					 	$sql = "insert into pair_point (user_id, left_point,right_point, date) values('$user_id','$insert_left_point','$insert_right_point','$date')";
						mysql_query($sql);
							
					}
				}
			}
		
		}
			
	}

}


function get_all_parent($id)
{	
	require_once "functions.php";
	$parent[0][0] = $id;
	$pos = get_user_pos($id);
	if($pos == 'Left')
	{
		$pos = 0;
	}
	if($pos == 'Right')
	{
		$pos = 1;
	}
	$parent[1][0] = $pos;
	$count = count($parent[0]);
	for($i = 0; $i <$count; $i++)
	{ $user_id =  $parent[0][$i];
		$sql = "select parent_id, position from users where id_user = '$user_id'";
		
			$result = mysql_query($sql);
			$num = mysql_num_rows($result); 
			if($num > 0)
			{
				while($row = mysql_fetch_array($result))
				{
					$parent[0][] = $row[0];
					$parent[1][] = $row[1];
				}
			}
		$count = count($parent[0]);
	}
	return $parent;
}

function chk_pair_poin_id_exist($id)
{
	 $sql = "select * from pair_point where user_id = '$id'";
	$query = mysql_query($sql);
	$cnt = mysql_num_rows($query);
	if($cnt == 0)
	return 0;
	else
	return 1;
}

function chk_pair_poin_id_exist_with_date($id,$pair_field,$date)
{
	$sql = "select * from pair_point where user_id = '$id' and date = '$date'";
	$query = mysql_query($sql);
	$cnt = mysql_num_rows($query);
	$user_info = array();
	if($cnt == 0)
	{
			$user_info[0][0] = 0;
			$user_info[0][1] = 0;
			$user_info[0][2] = 0;
		
	}
	else
	{
		$user_info[0][0] = 1;
		while($row = mysql_fetch_array($query))
		{
			$user_info[0][1] = $row[$pair_field];
			$user_info[0][2] = $row['id'];
		}
	}
	return $user_info;	
}


function point_carry_forward($id,$date)
{
	include("setting.php");
	$per_day_multiple_pair = 1;
	$date = $date; //date("Y-m-d") ;	
 	$sql = "select * from pair_point where user_id = '$id'   order by id desc limit 1 ";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		while($row = mysql_fetch_array($query))
		{
	$left_point = $child[0] = $row['left_point'];
			$right_point = $child[1] = $row['right_point'];
		}
		$pc = 1;
		$max_pair = max($left_point,$right_point);
		if($left_point == $per_day_multiple_pair and $right_point == $per_day_multiple_pair)
		{
			$max[0] = 0;
			$max[1] = 0;
		}
		else
		{
			
			$max_pair = min($child[0],$child[1]);
			do
			{
				$pair_calc = $per_day_multiple_pair*$pc;
				$pc++;
			}
			while($pair_calc <= $max_pair);
			$total_pair = $pair_calc-$per_day_multiple_pair;
			
			
			$max[0] = $child[0]-$total_pair;
			$max[1] = $child[1]-$total_pair;
		}	
			
	}
	else { 	
			$max[0] = 0;
			$max[1] = 0;
		 }
	return $max;
}
?>