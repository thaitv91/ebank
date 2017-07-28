<?php
/*include("../config.php");
print $r = geting_best_position(1,0);*/

function geting_best_position($id,$position)
{
	$result = mysql_query("select * from users where parent_id = '$id' and position = '$position' ");
	$num = mysql_num_rows($result);
	if($num != 0)
	{
		while($row = mysql_fetch_array($result))
		{
			$position_user_id = $row['id_user'];
		}
		$best_child = get_chld_best_pos($position_user_id,$position);	
	}
	else $best_child = $id;
	return $best_child;
}

function get_chld_best_pos($user_id,$position)
{
	$parent[0] = $user_id;
	$count = 1;
	for($i = 0; $i < $count; $i++)
	{
		$result = mysql_query("select * from users where parent_id = '$parent[$i]' and position = '$position' ");
		$num = mysql_num_rows($result);
		if($num != 0)
		{
			while($row = mysql_fetch_array($result))
			{
				$parent[] = $row['id_user'];
			}
			/*if($num == 1)
			{
				$virtual_parents = $parent[$i];
				$i = count($parent)+20;
			}*/
		}
		if($num == 0)
		{
			$virtual_parents = $parent[$i];
			$i = count($parent)+20;
		}
		$count = count($parent);
	}
	return $virtual_parents;
}

function check_virtual_parent_position($id,$position)
{
	$result = mysql_query("select * from users where parent_id = '$id' and position = '$position' ");
	$num = mysql_num_rows($result);
	return $num;		
}

