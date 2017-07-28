<?php
function give_total_children($id)  //give all children
{
	$query = mysql_query("select * from users where parent_id = '$id' and position = 0 ");
	$num = mysql_num_rows($query);
	if($num == 0)
	{
		$children[0][0] = $children[0][1] = $children[0][2] = $children[0][3] = $children[0][4] = 0;
	}
	while($row = mysql_fetch_array($query))
	{
		$left = $row['id_user'];
		$left_invst = get_total_investment($left);
		$left_total_link_send = get_total_link_send($left);
		$left_total_pending_investment = get_total_pending_investment($left);
		$left_total_user_commitment = get_user_full_investment($left);
		$children[0] = get_all_total_child($left,$left_invst,$left_total_link_send,$left_total_pending_investment,$left_total_user_commitment);
	}
	$query = mysql_query("select * from users where parent_id = '$id' and position = 1 ");
	$num1 = mysql_num_rows($query);
	if($num1 == 0)
	{
		$children[1][0] = $children[1][1] = $children[1][2] = $children[1][3] = $children[1][4] = 0;
	}
	while($row = mysql_fetch_array($query))
	{
		$right = $row['id_user'];
		$right_invst = get_total_investment($right);
		$right_total_link_send = get_total_link_send($right);
		$right_total_pending_investment = get_total_pending_investment($right);
		$right_total_user_commitment = get_user_full_investment($right);
		$children[1] = get_all_total_child($right,$right_invst,$right_total_link_send,$right_total_pending_investment,$right_total_user_commitment);
	}
	return $children;
}



function get_all_total_child($id,$total_inv_amount,$total_link_send,$total_pending_investment,$total_user_commitment)  // get all child in id network
{
	$total = 1;
	$child[0] = $id;
	$count = count($child);
	for($i = 0; $i <$count; $i++)
	{
	
			$result = mysql_query("select * from users where parent_id = '$child[$i]' ");
			$num = mysql_num_rows($result);
			if($num != 0)
			{
				while($row = mysql_fetch_array($result))
				{
					$child[] = $user_id = $row['id_user'];
					$total_inv_amount = $total_inv_amount+get_total_investment($user_id);
					$total_link_send = $total_link_send+get_total_link_send($user_id);
					$total_pending_investment = $total_pending_investment+get_total_pending_investment($user_id);
					$total_user_commitment = $total_user_commitment+get_user_full_investment($user_id);
					
					$total++;
				}
			}
		$count = count($child);
	}
	$total_info[0] = $total;
	$total_info[1] = $total_inv_amount;
	$total_info[2] = $total_link_send;
	$total_info[3] = $total_pending_investment;
	$total_info[4] = $total_user_commitment;
	return $total_info;
}

function get_total_investment($user_id)
{
	$result = mysql_query("select sum(amount) from income_transfer where paying_id = '$user_id' and mode = 2 ");
	while($row = mysql_fetch_array($result))
	{
		$invst_amount = $row[0];
		if($invst_amount == 0 or $invst_amount == '')
			$invst_amount = 0;
	}		
	return $invst_amount;
}


function get_total_link_send($user_id)
{
	$result = mysql_query("select sum(amount) from income_transfer where paying_id = '$user_id' and mode = 0 ");
	while($row = mysql_fetch_array($result))
	{
		$invst_amount = $row[0];
		if($invst_amount == 0 or $invst_amount == '')
			$invst_amount = 0;
	}		
	return $invst_amount;
}


function get_total_pending_investment($user_id)
{
	$result = mysql_query("select sum(amount) from income_transfer where paying_id = '$user_id' and mode = 1 ");
	while($row = mysql_fetch_array($result))
	{
		$invst_amount = $row[0];
		if($invst_amount == 0 or $invst_amount == '')
			$invst_amount = 0;
	}		
	return $invst_amount;
}
