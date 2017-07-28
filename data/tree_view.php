<?php
include("condition.php");
include("function/binary_layout/display.php");
include("function/total_child_count.php");
include("function/functions.php");

$u_id = $_REQUEST[id];
if($u_id == 0) $u_id = '';
if($u_id == '') 
{ 
	$id = $_SESSION['ebank_user_id'];

} 
else {$id = $u_id; }

$c = 1;
$j = 1;
$pos[0] = $id;
$id_query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");

while($id_row = mysql_fetch_array($id_query))
		{
			$type = $id_row['type'];
			$position[0] = get_user_pos($id);
			$mode[0] = get_mode($id);
			$date[0] = $id_row['date'];
			$gender[0] = $id_row['gender'];
			$img[0] = get_img($id,$type,$systems_date);
			$user_invest[0] = get_user_investment_for_tree($id);
			$full_invest[0] = get_user_full_investment($id);
			$user_name[0] = $id_row['username'];
			$all_child = give_total_children($id);
			$left_child[0] = $all_child[0];
			$right_child[0] = $all_child[1];
			$name[0] = $id_row['f_name']." ".$id_row['l_name']; 
			$parent_u_name[0] = get_username($id_row['real_parent']);	
			$parent_full_name[0] = get_full_name($id_row['real_parent']);
			$act_date[0] = $id_row['activate_date'];
		}
for($i = 0; $i <7; $i++)
{
	if($pos[$i] == 0)
	{
		$pos[$j] = 0;
		$left_child[$j] = 0;
		$right_child[$j] = 0;
		$j++;
		$pos[$j] = 0;
		$left_child[$j] = 0;
		$right_child[$j] = 0;
		$j++;
	}
	else
	{
		$n_id = $pos[$i];
		for($ps = 0; $ps < 2; $ps++)
		{
			$query = mysql_query("SELECT * FROM users WHERE parent_id = '$n_id' and position = '$ps' ");
			while($row = mysql_fetch_array($query))
			{
				$pos[$j] = $row['id_user'];
				$mode[$j] = get_mode($pos[$j]);
				$position[$j] = get_user_pos($pos[$j]);
				$user_name[$j] = $row['username'];
				$parent_u_name[$j] = get_username($row['real_parent']);
				$parent_full_name[$j] = get_full_name($row['real_parent']);
				$type = $row['type'];
				$date[$j] = $row['date']; 
				$gender[$j] = $row['gender'];
				$all_child = give_total_children($pos[$j]);
				$left_child[$j] = $all_child[0];
				$right_child[$j] = $all_child[1];
				$name[$j] = $row['f_name']." ".$row['l_name']; 
				$img[$j] = get_img($pos[$j],$type,$systems_date);
				$user_invest[$j] = get_user_investment_for_tree($pos[$j]);
				$full_invest[$j] = get_user_full_investment($pos[$j]);
				$act_date[$j] = $row['activate_date'];
				$j++;	
			}
			$num = mysql_num_rows($query);
			if($num == 0)  
			{
				$pos[$j] = 0; 
				$left_child[$j] = 0;
				$right_child[$j] = 0;
				$j++; 
			} 
		}					 
	}
	
}
$c = count($new_reg);
for($i = 0; $i < $c; $i++) {
	print $new_reg[$i][0].$new_reg[$i][1]; print "<br>"; }
$page = "index.php?val=tree_view&open=3";
display($pos,$page,$img,$user_name,$name,$parent_u_name,$parent_full_name,$mode,$position,$date,$act_date,$left_child,$right_child,$gender,$user_invest,$full_invest);	

function get_img($id,$type,$date)	
{
	$q = mysql_query("select * from income where user_id = '$id' ");
	$num = mysql_num_rows($q);
	if($type == 'A') { $imges = "d"; }
	if($type == 'B' and $num > 0) { $imges = "p"; }
	if($type == 'B' and $num == 0) { $imges = "f"; }
	if($type == 'D') { $imges = "b"; }
	return $imges;
}

function get_user_investment_for_tree($id)
{
	$q = mysql_query("select sum(amount) from income_transfer where paying_id = '$id' and mode = 2 ");
	while($row = mysql_fetch_array($q))
	{
		$total_invst = $row[0];
	}
	if($total_invst == '')
		$total_invst = 0;
	return $total_invst;		
}

function get_user_full_investment($id)
{
	$q = mysql_query("select sum(amount) from investment_request where user_id = '$id' ");
	while($row = mysql_fetch_array($q))
	{
		$total_invst = $row[0];
	}
	if($total_invst == '')
		$total_invst = 0;
	return $total_invst;		
}


function get_mode($id)
{
	$query = mysql_query("select * from users where id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
	}
	if($type == 'A') { $mode = "Deactivate";  }
	if($type == 'B') { $mode = "Activate";  }
	if($type == 'B') { $mode = "Blocked";  }
	return $mode;
}

function get_username($parent)
{
	$query = mysql_query("select * from users where	id_user = $parent ");
	while($row = mysql_fetch_array($query))
	{
		$username = $row['username'];
		return $username;	
	}
}
	
	
/*	$mode[$j] = '';
			$position[$j] = 0;
			$user_name[$j] = '';
			$parent_u_name[$j] = '';
			$parent_full_name[$j] = '';
			$type = '';
			$date[$j] = ''; 
			$gender[$j] = 
			$all_child = 0;
			$left_child[$j] = 0;
			$right_child[$j] = 0;
			$name[$j] = ''; 
			$img[$j] = '';*/