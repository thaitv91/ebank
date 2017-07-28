<?php
//include("../config.php");


function geting_virtual_parent($id)
{
	$query = mysql_query("select * from users where parent_id = '$id' ");
	$number = mysql_num_rows($query);
	return $number;
}


function geting_virtual_parent_with_position($id,$position)
{
	$query = mysql_query("select * from users where parent_id = '$id' and position = '$position' ");
	$number = mysql_num_rows($query);
	return $number;
}

function geting_best_parent_position($id,$position)
{
	$parent[0] = $id;
	$count = 1;
	$rt = 1;
	for($i = 0; $i <$count; $i++)
	{
		$result = mysql_query("select * from users where parent_id = '$parent[$i]' and position = '$position' ");
		$num = mysql_num_rows($result);
		if($num == 1)
		{
			while($row = mysql_fetch_array($result))
			{
				$parent[$rt] = $row['id_user'];
				$rt++;
			}
		}
		if($num == 0)
		{
			return $parent[$i];	
		}
		$count = count($parent);
	}
}

function geting_all_blank_position_with_adding_position($id,$position)
{
	$result = mysql_query("select * from users where parent_id = '$id' and position = '$position' ");
	$num = mysql_num_rows($result);
	if($num != 0)
	{
		while($row = mysql_fetch_array($result))
		{
			$position_user_id = $row['id_user'];
		}
	}
	$all_child = geting_all_blank_position($position_user_id);	
	return $all_child;		
}


function geting_all_blank_position($id)
{
	$parent[0] = $id;
	$count = 1;
	for($i = 0; $i <$count; $i++)
	{
			$result = mysql_query("select * from users where parent_id = '$parent[$i]' ");
			$num = mysql_num_rows($result);
			if($num != 0)
			{
				while($row = mysql_fetch_array($result))
				{
					$parent[] = $row['id_user'];
				}
				if($num == 1)
				{
					$virtual_parent[] = $parent[$i];
				}
			}
			if($num == 0)
			{
				$virtual_parent[] = $parent[$i];
			}
		$count = count($parent);
	}
	return $virtual_parent;
}

function get_virtual_posotion_fro_Reg($id)
{
	$parent[0] = $id;
	$i = 0;
	do
	{
		$result = mysql_query("select * from users where parent_id = '$parent[$i]' ");
		$num = mysql_num_rows($result);
		if($num == 2)
		{
			while($row = mysql_fetch_array($result))
			{
				$parent[] = $row['id_user'];
			}
			$i++;
		}
		else
		{
			$res[0] = $parent[$i];
			$res[1] = $num;
		}
	}while($num == 2);
	return $res;
}

function get_virtual_parent_position($id,$position)
{
	$parent[0] = $id;
	$i = 0;
	do
	{
		$result = mysql_query("select * from users where parent_id = '$parent[$i]' and position = '$position' ");
		$num = mysql_num_rows($result);
		if($num == 1)
		{
			while($row = mysql_fetch_array($result))
			{
				$parent[] = $row['id_user'];
				$i++;
			}
		}
		else
			return $parent[$i];
	}while($num == 1);	
}


function get_par($a)
{
	$d[0][0] = $a;
	$d[1][0] = $a%2;
	for($i = 0; $i <3; $i++)
	{
		$d[0][$i+1] = intval($a/2);
		if($d[0][$i+1] == 1)
		{
			$d[1][$i+1] = 0;
		}
		else{	
		$d[1][$i+1] = $d[0][$i+1]%2; }
		$a = $d[0][$i+1];
		//echo $d[0][$i+1];
	}
return $d;
}