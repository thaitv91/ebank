<?php
//include("../config.php");



function check_transfer_condition($id)
{
	$res = 0;
	$q = mysql_query("select * from users where parent_id = '$id' and position = 0 ");
	$num = mysql_num_rows($q);
	if($num == 0)
	{
		$res = 0; 
		return $res;
	}
	else
	{
		while($row = mysql_fetch_array($q))
		{
			$left = $row['id_user'];
			$left_result = check_transfer_condition_to_all_child($left,$id);
			$left_result[0];
			$left_result[1];
		}
	}	
	$query = mysql_query("select * from users where parent_id = '$id' and position = 1 ");
	$num1 = mysql_num_rows($query);
	if($num1 == 0)
	{
		$res = 0;
		return $res;
	}
	else
	{
		while($row = mysql_fetch_array($query))
		{
			$right = $row['id_user'];
			$right_result = check_transfer_condition_to_all_child($right,$id);
			$right_result[0];
			$right_result[1];
		}
	}
	if($left_result[0] == 1 and $right_result[0] == 1)
	{
		$tot = $left_result[1]+$right_result[1];
		if($left_result[0] != 0 and $tot > 2)
		$res = 1;
	}	
	return $res;
}

function check_transfer_condition_to_all_child($id,$real_parent)
{
	$child[0] = $id;
	$count = count($child);
	$total_childd = $c = 0;
	$q = mysql_query("select * from users where id_user = '$child[0]' ");
	while($row = mysql_fetch_array($q))
	{
			$db_type = $row['type'];
			$db_real_parent = $row['real_parent'];
			$j=0;
			if($db_type == 'B' and $real_parent == $db_real_parent) 
			{
				$c = 1; 
			}
			if($db_type == 'B')
			{
				$total_childd = $total_childd+1;
			}
	}
	for($i = 0; $i <$count; $i++)
	{
			$child_id = $child[$i];
			$result = mysql_query("select * from users where parent_id = '$child_id' ");
			$num = mysql_num_rows($result);
			if($num != 0)
			{
				while($row = mysql_fetch_array($result))
				{
					$db_real_parent = $row['real_parent'];
					$db_type = $row['type'];
					$child[] = $row['id_user'];
					$date = $systems_date;
					if($db_type == 'B' and $real_parent == $db_real_parent and $c != 1) 
						$c = 1; 
					if($db_type == 'B')
					{
						$total_childd = $total_childd+1;
						if($total_childd == 2 and $c == 1)
							$i = $count+10;
					}
				}
			}
		$count = count($child);
	}
	$all_res[0] = $c;
	$all_res[1] = $total_childd;
	return $all_res;
}

/*$c = check_transfer_condition(12);
print $c;

*/