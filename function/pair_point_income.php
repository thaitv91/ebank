<?php
/*include("../config.php");
include("../function/functions.php");
$income_dates = '2013-07-03';
do
{
	$income_dates = date("Y-m-d", strtotime($income_dates."+1 day") );
	pair_point_income($income_dates);
	
}while($income_dates <= $systems_date);*/
function pair_point_income($date)
{
	include("setting.php");
	$done = 0;
	$income_dates = $date; //date("Y-m-d");
	 "select * from user_income where date = '$income_dates' and type = $income_type[2] ";
	$chk_query = mysql_query("select * from user_income where date = '$income_dates' and type = $income_type[2] ");
	$chk_num = 0; //mysql_num_rows($chk_query);
	if($chk_num == 0)
	{	
		$q = mysql_query("select * from pair_point group by user_id ");
		$n = mysql_num_rows($q);
		if($n > 0)
		{
			while($rrr = mysql_fetch_array($q))
			{
				 $id = $rrr['user_id'];
				
				$type = get_type_user($id);
				if($type == 'B' or $type == 'C')
				{
					$chk_bin = 1;	//check_transfer_condition($id)
					if($chk_bin == 1)
					{
						
						$income_date = date("Y-m-d", strtotime($income_dates."-1 day") );
						$query = mysql_query("select * from pair_point where user_id = '$id' and date = '$income_date' ");
						$num = mysql_num_rows($query);
						if($num > 0)
						{
							$done = 1;
							while($row = mysql_fetch_array($query))
							{
								//$date = date("Y-m-d");
								$left_point = $row['left_point'];
								$right_point = $row['right_point'];
								$income = get_pair_point_income($left_point,$right_point);
								if($income > 0)
								{
									$cccc = chk_prev_inc($id,$date);							
									if($cccc == 1)
									{
									//	print "insert into user_income (user_id , income , date , type) values ('$id' , '$income' , '$date' , '$income_type[2]' ) <br>";
										mysql_query("insert into user_income (user_id , income , date , type) values ('$id' , '$income' , '$date' , '$income_type[2]' ) ");
										update_member_wallet($id,$income,$income_type[2],$date);
									}	
								}	
							}
						}	
					}
					
				}
			}	
		}
		if($done == 1)
			print "<font size=5 color=\"#004080\">Binary Income Successfully Distributed on Today ! </font><br>";
		else { 	print "<font size=5 color=\"#FF0000\">Alert - There Are No Binary Pair Today ! </font><br>"; }	
	}
	else { print "<font size=5 color=\"#FF0000\">Alert - Binary Income Already Distributed Today ! </font><br>"; }	
}

function chk_prev_inc($id,$date)
{
	$chk_query = mysql_query("select * from user_income where user_id = '$id' and date = '$date' and type = 2 ");
	$chk_num = mysql_num_rows($chk_query);
	if($chk_num == 0)
		return 1;
	else	
		return 0;
}	


//pair_point_income();

function get_pair_point_income($left_point,$right_point)
{
	include("setting.php");
	//echo $left_point,$right_point,"<br>";
	$pc = 1;
	$max_pair = min($left_point,$right_point);
	if($max_pair >= $per_day_multiple_binary_pair)
	{
		$income = $max_pair*($pair_point_percent/100);
		if($income > $per_day_max_binary_inc_db)
			return $per_day_max_binary_inc_db;
		else
			return $income;	
	}	
	else
		return 0;
}
//print "<br>".check_transfer_condition(336);
function check_transfer_condition($id)
{
	$q = mysql_query("select * from income where user_id = '$id' ");
	$num = mysql_num_rows($q);
	if($num > 0)
	{
		$queryl = mysql_query("select * from users where parent_id = '$id' and position = 0 ");
		$numl = mysql_num_rows($queryl);
		if($numl == 0)
		{
			return 0;	
		}else
		{
			while($rowl = mysql_fetch_array($queryl))
			{
				$left = $rowl['id_user'];
				$chk_left = child_investment_chk_for_binary($id,$left);
			}
			$queryr = mysql_query("select * from users where parent_id = '$id' and position = 1 ");
			$numr = mysql_num_rows($queryr);
			if($numr == 0)
			{
				return 0;	
			}
			else
			{
				while($rowr = mysql_fetch_array($queryr))
				{
					$right = $rowr['id_user'];
					$chk_right = child_investment_chk_for_binary($id,$right);
				}
				if($chk_left == 1 and $chk_right == 1)
					return 1;
				else
					return 0;	
			}		
		}				
	}
	else
		return 0;	
}


function child_investment_chk_for_binary($real_p,$id)
{
	$child[0] = $id;
	
	$resultss = mysql_query("select * from users where id_user = '$id' ");
	while($rows = mysql_fetch_array($resultss))
	{
		$real_parent = $rows['real_parent'];
		if($real_parent == $real_p)
		{
			$q = mysql_query("select * from income where user_id = '$id' ");
			$chk_inv = mysql_num_rows($q);
			if($chk_inv > 0)
				return 1;
		}	
		else
		{
			$count = 1;
			for($i = 0; $i <$count; $i++)
			{
				$result = mysql_query("select * from users where parent_id = '$child[$i]' ");
				$num = mysql_num_rows($result);
				if($num > 0)
				{
					while($row = mysql_fetch_array($result))
					{
						$child[] = $user_idss = $row['id_user'];
						$real_parent = $row['real_parent'];
						if($real_parent == $real_p)
						{
							$qq = mysql_query("select * from daily_intrest where member_id = '$user_idss' ");
							$chk_invq = mysql_num_rows($qq);
							if($chk_invq > 0)
							{
								$i = $count+100;
								return 1;
								break;
							}	
						}	
					}
				}
				$count = count($child);
			}
			return 0;
		}
	}		
}			