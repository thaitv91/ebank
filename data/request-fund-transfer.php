<?php
include("condition.php");
include("function/setting.php");
include("function/send_mail.php");
include("function/functions.php");
$id = $_SESSION['ebank_user_id'];
include("function/wallet_message.php");

if($id > 0)
{
	if(isset($_POST['submit']))
	{
		$user_pin = $_POST['user_pin'];
		$request_amount = $_POST['request'];
		
		$inv_prfit = $setting_inv_profit;
		$inv_days = $setting_inv_days;
		
		$query = mysql_query("select amount from wallet where id = '$id' ");
		while($row = mysql_fetch_array($query))
		{
			$curr_amnt = $row[0];
		}
		if($request_amount <= $curr_amnt)
		{
			$query = mysql_query("select * from users where id_user = '$id' and user_pin = '$user_pin' ");
			$num = mysql_num_rows($query);
			if($num > 0)
			{
				$income_time = date('H:i:s');
				mysql_query("insert into income (user_id,total_amount,paid_limit,date,mode,priority, rec_mode) values ('$id' , '$request_amount' , '$request_amount' , '$systems_date' , 1 , 1, 1) ");
				
				$left_bal = $curr_amnt-$request_amount;
				mysql_query("update wallet set amount = '$left_bal' where id = '$id' ");
				
				$time = date('Y-m-d H:i:s');
				$cash_wal = get_wallet_amount($id);
				insert_wallet_account($id, $id, $request_amount, $time, $acount_type[6],$acount_type_desc[6], 2, $cash_wal , $wallet_type[1]); 
				
				$acc_username_log = get_user_name($id);
				$income_log = $request_amount;
				$date = $systems_date;
				$wallet_amount_log = $curr_amnt;
				$total_wallet_amount = $left_wallet_amount;
				include("function/logs_messages.php");
				data_logs($id,$data_log[16][0],$data_log[16][1],$log_type[4]);
				
				$phone = get_user_phone($id);
				$db_msg = $setting_sms_user_investment_request;
				include("function/full_message.php");
				send_sms($phone,$full_message);	
				
				print "You request for Withdrawal amount ".$request_amount."  <font color=dark>$ </font> has been completed successfully!";
			}
			else
			{  
				print "<font style=\"color:#FF0000\"><strong>Please enter correct user pin !</strong></font>";
			}
		}
		else
		{
			print "<font style=\"color:#FF0000\"><strong>Error : insufficient Balance !</strong></font>";
		}	
	}
	else
	{
		$date = date('Y-m-d');
	
		$query = mysql_query("select amount from wallet where id = '$id' ");
		while($row = mysql_fetch_array($query))
		{
			$curr_amnt = $row[0];
		}	
		
		?>
		<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info"> 
		<tbody role="alert" aria-live="polite" aria-relevant="all">		
		<form name="money" action="index.php?page=request-fund-transfer" method="post">
		<input type="hidden" name="curr_amnt" value="<?php echo $curr_amnt; ?>"  />
		  <tr>
			<td colspan="2" class="td_title"><span style="color:#006666; font-size:17px;"> <strong>Your Wallet Information</strong><p></p></td>   
		  </tr>
		  <tr>
			<td colspan="2" height="40">&nbsp;</td>   
		  </tr>
		  <tr>
			<td class="td_title" style="color:#FF0000; font-size:14px; font-weight:bold;">Your Current Wallet Balance
			</td>
			<td class="td_title" style="color:#FF0000; font-size:14px; font-weight:bold;"> <?php echo round($curr_amnt/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$curr_amnt; ?>  <font color=dark>$ </font></strong></td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;</td>   
		  </tr>
		  <tr>
			<td class="td_title"  style="color:#FF0000; font-size:14px; font-weight:bold;">Minimum Withdrawal Balance   </td>
			<td class="td_title" style="color:#FF0000; font-size:14px; font-weight:bold;"> <?php echo round($minimum_withdrawal/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$minimum_withdrawal; ?>  <font color=dark>$ </font></strong></td>
		  </tr>
		  <tr>
			<td colspan="2">&nbsp;</td>   
		  </tr>
		<?php 
			$query = mysql_query("select * from income where user_id = '$id' and date = '$systems_date' and total_amount > 0");
			
			$num = mysql_num_rows($query);
			if($num == 0)
			{
				$query_mode = mysql_query("select * from income where user_id = '$id' and total_amount > 0");
				while($rows = mysql_fetch_array($query_mode))
				{
					$inv_mode = $rows['mode'];
				}
				
				$query_mode1 = mysql_query("select * from income_transfer where user_id = '$id' and (mode = 0 or mode = 1)");
				
				$var_te = mysql_num_rows($query_mode1);
				$sql = "select * from income_transfer where paying_id = '$id' and (mode = 0 or mode = 1)";
				$query_mode2 = mysql_query($sql);
				
				$var_te1 = mysql_num_rows($query_mode2);
				
				$sql_2 = "SELECT * FROM `investment_request` WHERE `user_id`='$id' and mode = 1";
				$query_2 = mysql_query($sql_2);
	  			$query_cnt_2 = mysql_num_rows($query_2);
							
				if($inv_mode == 1 or $var_te > 0 or $var_te1 > 0 or $query_cnt_2 > 0)	
				{
					print "<p style=\"color:#BC0007\">Last Withdrawal is Not Yet Completed or There should not any pending get help and send help. or you are getting link for send payment shortly .<br /><br /></p>";
				}
				else
				{	
					 $sql_1 = "SELECT * FROM `investment_request` WHERE `user_id`='$id' and `rec_mode`=0";
					 $query_1 = mysql_query($sql_1);
					 $query_cnt_1 = mysql_num_rows($query_1);
					 if($query_cnt_1 == 0)
					 {
						withdrawl_fun($setting_inv_amount, $id);
					 }
					 else
					 {
						$cur_date = date("Y-m-d");
						$last_date = date('Y-m-d', strtotime("-20 days"));
						$sql_chk = "SELECT t1.id_user,t2.user_id
									FROM `users`as t1 
									inner join investment_request as t2 on t2.user_id = t1.id_user
									and t2.date between '$last_date' and '$cur_date' and t2.mode = 0 
									and t2.rec_mode = 1
									inner join income_transfer as t3 
									on t2.user_id = t3.paying_id
									and t3.mode = 2
									where
									t1.real_parent='$id'";
						$query_chk = mysql_query($sql_chk);
						$query_cnt_chk = mysql_num_rows($query_chk);
						/*if($query_cnt_chk > 0)
						{
							withdrawl_fun($setting_inv_amount, $id);
						}
						else
						{
							print "<br><br><font color=\"990000\"><b>Alert : Invite 1 Direct Sponsor in Last 10 Days of any amount for continue your withdrawal! </b></font><br><br>";
						}*/
						
					 
					 }
					 
					 //withdrawl
					 /*?>$que = mysql_query("select sum(amount) from income_transfer where paying_id  = '$id' and mode = 2 ");
					while($row = mysql_fetch_array($que))
					{
						$max_amnt = $row[0];
					}
						
					$max_withdrawal_amount = $max_amnt/2;
					
					$chkdate = date('D', strtotime(" $systems_date "));
					if($chkdate != 'Sat' and $chkdate != 'Sun')
					{
					  ?>
				  <tr>
					<td >Your Request Amount :</td>
					<td >
					<select name="request" class="textInput" style="width:144px; height:auto; font-size:13px;">
		<?php			for($i = ($setting_inv_amount/2); $i <= $max_withdrawal_amount; $i = $i+($setting_inv_amount/2))
					{ ?>
						<option value="<?php print $i; ?>"><?php print $i; ?> <font color=dark>$ </font></option>
			<?php		} ?>				
					</select>
					</td>
				  </tr>
				  <tr>
					<td>Transaction Password :</td>
					<td>
					<input type="text" name="user_pin" style="width:143px;" class="textInput" />
					<?php
						$t_pass = mysql_query("select user_pin from users where id_user = '$id'");
						while($row = mysql_fetch_array($t_pass))
						{
							print "&nbsp;&nbsp;&nbsp;".$trans_pass = $row['user_pin'];
						}
					?>
					</td>
				  </tr>
				  <tr>
					<td colspan="2">&nbsp;</td>   
				  </tr>
				  <tr>
					<td colspan="2" align="center" style="padding-left:70px"><input type="submit" name="submit" value="Request" class="btn btn-info" /></td>   
				  </tr><?php */
				}
					/*else
					{
					print "Withdral is not working for saturday and sunday !";
					}*/	
				
	?>	  
			  
			  </form>
		<?php	}
			else
			{  ?>		  
			<tr>
				<td colspan="2" style="font-size:20px; color:#990000;"><blink>Todays Withdrawal Limit is over !!</blink></td>   
			</tr>
	<?php		} 
	?>		  		
		</tbody>
		</table>
	
	<?php 
	} 
}
else
{
	print "<h1 style=\"color:#FF0000;font-size:18px;\">Please Cash Your Wallet</h1>";
}	
 
function withdrawl_fun($setting_inv_amount, $id)
{
 	$sql ="select sum(amount) from income_transfer where paying_id  = '$id' and mode = 2 ";
	$que = mysql_query($sql);
	while($row = mysql_fetch_array($que))
	{
		 $max_amnt = $row[0];
	}
	$max_withdrawal_amount = $max_amnt/2;
	if($max_withdrawal_amount <= $setting_inv_amount)
	{
		$max_withdrawal_amount = $max_amnt;
	}
	$chkdate = date('D', strtotime(" $systems_date "));
	if(1)
	{
	  ?>
	  <tr>
		<td >Your Request Amount :</td>
		<td >
		<select name="request" class="textInput" style="width:144px; height:auto; font-size:13px;">
<?php			for($i = ($setting_inv_amount/2); $i <= $max_withdrawal_amount; $i = $i+($setting_inv_amount/2))
		{ ?>
			<option value="<?php print $i; ?>"><?php print $i; ?> <font color=dark>$ </font></option>
<?php		} ?>				
		</select>
		</td>
	  </tr>
	  <tr>
		<td>Transaction Password :</td>
		<td>
		<input type="text" name="user_pin" style="width:143px;" class="textInput" />
		<?php
			$t_pass = mysql_query("select user_pin from users where id_user = '$id'");
			while($row = mysql_fetch_array($t_pass))
			{
				print "&nbsp;&nbsp;&nbsp;".$trans_pass = $row['user_pin'];
			}
		?>
		</td>
	  </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>   
	  </tr>
	  <tr>
		<td colspan="2" align="center" style="padding-left:70px"><input type="submit" name="submit" value="Request" class="btn btn-info" /></td>   
	  </tr><?php
	}
	else
	{
		print "Withdral is not working for saturday and sunday !";
	}
}
 ?>
