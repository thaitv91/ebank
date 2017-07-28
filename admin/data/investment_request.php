<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/wallet_message.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
include("../function/pair_point_calculation.php");

?>

<h2 align="left">Investment Requests</h2><p></p>
<?php

if(isset($_POST['submit']) and ($_SESSION['ebank_user_admin_login'] == 1))
{
	if($_POST['submit'] == 'Accept')
	{

		$req_id = $_REQUEST['id'];
		$information = $_REQUEST['information'];
		
		$query = mysql_query("select * from investment_request where id = '$req_id' ");
		while($row = mysql_fetch_array($query))
		{
			$user_id = $row['user_id'];
			$plan_type = $row['plan_type'];
			$request_amount = $row['amount'];
			$package_id = $row['plan_setting_id'];
		}	
		
		
		$qr = mysql_query("select * from plan_setting where id = '$package_id' ");
		while($rr = mysql_fetch_array($qr))
		{
			$profit = $rr['profit']; 	
		}
		
		$total_amount = $request_amount+($request_amount*($profit/100));
		
		
		$date = $systems_date; //date('Y-m-d');

		mysql_query("insert into reg_fees_structure (user_id , update_fees , date , profit , invest_type) values ('$user_id' , '$request_amount' , '$date' , '$profit' , '$plan_type') ");
		
		mysql_query("insert into income (user_id , total_amount , profit , date , type , mode) values ('$user_id' , '$total_amount' , '$profit' , '$date' , 1 , 1) ");
		
		mysql_query("update investment_request set app_date = '$date' , information = '$information' , mode = 1 where id = '$req_id' ");
							
		
		/*pair_point_calculation($user_id,$systems_date);*/
		
		$username_log = get_user_name($user_id);
		$username = $username_log;
		$invest_amount = $request_amount;
		include("../function/logs_messages.php");
		$phone_no = get_user_phone($user_id);
		send_sms($phone_no,$message1);
						
		$invest_amount = $request_amount;
		$invest_plan = $daily_income_percent[$package_id][3];
		include("../function/logs_messages.php");
		data_logs($user_id,$data_log[11][0],$data_log[11][1],$log_type[5]);
		
		print "Investment Request Accepted Successfully!";
	}
	elseif($_POST['submit'] == 'Cancel')
	{
		$req_id = $_REQUEST['id'];
		$u_id = $_REQUEST['u_id'];
		$accept_date= $systems_date; //date('Y-m-d');
		$information = $_REQUEST['information'];
		$req_amount = $_REQUEST['req_amount'];
		mysql_query("update investment_request set app_date = '$accept_date' , information = '$information' , mode = 2 where id = '$req_id' ");
		
		$username_log = get_user_name($u_id);
		
		$paymode_logs = " By Liberty Reserve";
		$invest_amount = $req_amount;
		$date = $accept_date;
		include("../function/logs_messages.php");
		data_logs($u_id,$data_log[22][0],$data_log[22][1],$log_type[5]);
		
		print "Investment Request Cancelled Successfully !";
	}
	else { }	
}
else
{
	
	$newp = $_GET['p'];
	$plimit = "15";
	
	$mg = $_REQUEST[mg]; echo $mg;
	$query = mysql_query("select * from investment_request where mode = 0 and amount > 0 ");
	$totalrows = mysql_num_rows($query);
	if($totalrows != 0)
	{
		print " 
					
			<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 height=\"40\" width=940>
			
			<tr>
			<td class=\"message tip\" align=\"center\"><strong>User Name</strong></td>
			<td class=\"message tip\" align=\"center\"><strong>Request Amount</strong></td>
			<td class=\"message tip\" align=\"center\"><strong>Payment Mode</strong></td>
			<td class=\"message tip\" align=\"center\"><strong>Investment Plan</strong></td>
			<td class=\"message tip\" align=\"center\"><strong>Date</strong></td>
			<td class=\"message tip\" align=\"center\"><strong>Information</strong></td>
			<td class=\"message tip\" align=\"center\"><strong>Action</strong></td>
			</tr>";
		
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
	
	
		$query = mysql_query("select * from investment_request where mode = 0 and amount > 0 LIMIT $start,$plimit ");
		while($row = mysql_fetch_array($query))
		{
			$id = $row['id'];
			$u_id = $row['user_id'];
			$plan_setting_id = $row['plan_setting_id'];
			$username = get_user_name($u_id);
			$request_amount = $row['amount'];
			$request_amount_usd = round($request_amount/$usd_value_current,2);
			$request_date = $row['date'];
			$payment_mode = $row['payment_mode'];
			$plan_type = $row['plan_type'];
			if($plan_type == 1)
				$inv_plan_type = "Forex Trading";
			elseif($plan_type == 2)
				$inv_plan_type = "Oil Trading";
			else
				$inv_plan_type = "Gold Trading";
			
				
			print "<tr>
			<td class=\"input-medium\" align=\"center\"><a href=\"index.php?page=requested_add_funds_info&inf=$id\">$username</a></td>
			<td class=\"input-medium\" align=\"center\"><small>$$request_amount_usd <font color=DodgerBlue>USD</font> Or  $request_amount  <font color=dark>$ </font></small></td>
			<td class=\"input-medium\" align=\"center\"><small>$payment_mode</small></td>
			<td class=\"input-medium\" align=\"center\"><small>$inv_plan_type</small></td>
			<td class=\"input-medium\" align=\"center\"><small>$request_date</small></td>
			<td  class=\"input-medium\"><center><form name=\"inact\" action=\"index.php?page=investment_request\" method=\"post\">
					<textarea name=\"information\" class=\"input-medium\" style=\"height:30px; width:110px\" > </textarea></td>
			<td class=\"input-medium\">
					<input type=\"hidden\" name=\"id\" value=\"$id\" />
					<input type=\"hidden\" name=\"req_amount\" value=\"$request_amount\" />
					<input type=\"submit\" name=\"submit\" value=\"Cancel\" />	</center>
					<input type=\"submit\" name=\"submit\" value=\"Accept\" />	</center>					
			</td></form></tr>";
		}
		print "<tr><td colspan=6 >&nbsp;</td></tr><td colspan=7 height=30px width=400 class=\"message tip\"><strong>";
		if ($newp>1)
		{ ?>
			<a href="<?php echo "index.php?page=investment_request&p=".($newp-1);?>">&laquo;</a>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<a href="<?php echo "index.php?page=investment_request&p=$i";?>"><?php print_r("$i");?></a>
				<?php 
			}
			else
			{
				 print_r("$i");
			}
		} 
		if ($newp<$pnums) 
		{ ?>
		   <a href="<?php echo "index.php?page=investment_request&p=".($newp+1);?>">&raquo;</a>
		<?php 
		} 
		print "</table>";	
	}
	else{ print "There is no request !"; }
 }
 
 

function get_date_after_given_days($date,$days) 
{
	$i = 1;
	$given_date = $date;
	do
	{
		$temp_day = date('D', strtotime($given_date . ' +1 days'));
		if($temp_day == 'Sat' or $temp_day == 'Sun')
			$given_date = date('Y-m-d', strtotime($given_date . ' +1 days'));
		else
		{
			$given_date = date('Y-m-d', strtotime($given_date . ' +1 days'));
			$i++;
		}	
	}
	while($i <= $days);
	return $given_date;
}	

?>
 