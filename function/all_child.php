<?php
/*include("../config.php");

$r =  give_all_children(1);
print $rfr = count($r[0]);
for($e=0; $e< $rfr; $e++)
	print $r[0][$e][0]." ".$r[0][$e][1]."<br>";
*/	
function give_all_children($id)  //give all children
{
	$query = mysql_query("select * from users where parent_id = '$id' and position = 0 ");
	$num = mysql_num_rows($query);
	if($num == 0)
	{
		$children[0][0] = 0;
	}
	else
	{
		while($row = mysql_fetch_array($query))
		{
			$left[0] = $row['id_user'];
			$left[1] = $row['type'];
			$children[0] = get_all_child($left);
		}
	}	
	$query = mysql_query("select * from users where parent_id = '$id' and position = 1 ");
	$num1 = mysql_num_rows($query);
	if($num1 == 0)
	{
		$children[1][0] = 0;
	}
	else
	{
		while($row = mysql_fetch_array($query))
		{
			$right[0] = $row['id_user'];
			$right[1] = $row['type'];
			$children[1] = get_all_child($right);
		}
	}	
	return $children;
}



function get_all_child($id)  // get all child in id network
{
	$child[0][0] = $id[0];
	$child[0][1] = $id[1];
	$block = 1;
	$count = count($child);
	for($i = 0; $i <$count; $i++)
	{
		$idds = $child[$i][0];
			$result = mysql_query("select * from users where parent_id = '$idds' ");
			$num = mysql_num_rows($result);
			if($num != 0)
			{
				while($row = mysql_fetch_array($result))
				{
					$child[$block][0] = $row['id_user'];
					$child[$block][1] = $row['type'];
					$block++;
				}
			}
		$count = count($child);
	}
	return $child;
}

