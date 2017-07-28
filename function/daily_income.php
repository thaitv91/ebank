<?php
/*include("../config.php"); 
include("functions.php");
 get_daily_income('2015-12-17');*/
function get_daily_income($date)
{
	include("setting.php");
	$chk = mysql_query("select * from user_income where type = '$income_type[6]' and date = '$date' ");
	$chk_num = mysql_num_rows($chk);
	if($chk_num == 0)
	{	 
	 $qu = "select * from daily_interest where   `count` < `max_count`  and start_date <= '$date' and end_date >'$date'";				
		$query = mysql_query($qu);
		$num = mysql_num_rows($query);
		if($num > 0)
		{
			while($r = mysql_fetch_array($query))
			{
				$user_id = $r['member_id'];
				$table_id = $r['id'];
				$deduction = $r['deduction'];
				$type = get_type_user($user_id);
				if($type == 'B')
				{
					$amount = $r['amount'];
					$percent = $r['percent'];
					$amount = $amount - ( $amount*($deduction/100) );
					$income = $amount*($percent/100);
					// roi deduction conditions
					
					mysql_query("insert into user_income (user_id , income , type , date ) 
					values ('$user_id' , '$income' , '$income_type[6]' , '$date') ");
				
					mysql_query("update wallet set  roi = roi+'$income' where id = '$user_id' ");
					mysql_query("update daily_interest set `count` = `count` + 1 where id = '$table_id' and member_id='$user_id' ");
					
					$time = date('Y-m-d H:i:s');
					$roi_wal = get_wallet_roi_amt($user_id);
					insert_wallet_account($user_id,$user_id,$income,$time,$acount_type[1],$acount_type_desc[1], 1, $roi_wal , $wallet_type[2]); 
				}
			}
		}
	}	
}

function get_monthly_only_income($date)
{
	include("setting.php");
	//$date = date('y-m-d');
	$chk = mysql_query("select * from income where type = '$income_type[4]' ");
	$chk_num = mysql_num_rows($chk);
	if($chk_num == 0)
	{
		$query = mysql_query("select * from reg_fees_structure where end_date = '$date' and invest_type > 1 ");
		$num = mysql_num_rows($query);
		if($num > 0)
		{
			while($r = mysql_fetch_array($query))
			{
				$user_id = $r['user_id'];
				$type = get_type_user($user_id);
				if($type == 'B')
				{
					$reg_fees = $r['reg_fees'];
					$percent = $r['profit'];
					$update_fees = $r['update_fees'];
					if($update_fees == 0)
						$total_amount = $reg_fees;
					else
						$total_amount = $update_fees;

					$income = $total_amount+($total_amount*($percent/100));
					mysql_query("insert into income (user_id , amount , type , date ) 
					values ('$user_id' , '$income' , '$income_type[4]' , '$date') ");
					
					update_member_wallet($user_id,$income,$income_type[4]);
				}
			}
		}
		print "<br>Oil or Gold distributed Successfully ";
	}
	else { print "<font size=5 color=\"#FF0000\"><br>Alert - Oil or Gold income already distributed today ! </font>"; }	
}


/*function daily_total_income_percent($total_amount)
{
	include("setting.php");
	$count = count($daily_income_percent);
	for($i = 0; $i < $count; $i++)
	{
		if($daily_income_percent[$i][0] >= $total_amount)
		{
			if($daily_income_percent[$i][0] == $total_amount)
			{
				$amount = $daily_income_percent[$i][1];
				return $amount;
			}
			else
			{
				$amount = $daily_income_percent[$i-1][1];
				return $amount;
			}
		}
	}
	if($daily_income_percent[$count-1][0] < $total_amount)
	{
		$amount = $daily_income_percent[$count-1][1];
		return $amount;
	}	
	
	return $amount;	



}
*/
//$end =  date('Y-m-d', strtotime($date . ' +99 days'));
//get_daily_income();