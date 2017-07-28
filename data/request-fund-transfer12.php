<?php
include("condition.php");
include("function/setting.php");
include("function/send_mail.php");
include("function/functions.php");
$id = $_SESSION['ebank_user_id'];
include("function/wallet_message.php");
?>
<h2 align="left">Withdraw Balance</h2>
<?php

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
	<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=500>
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
		<td class="td_title" style="color:#FF0000; font-size:14px; font-weight:bold;"> <?php echo $curr_amnt; ?>  <font color=dark>$ </font></strong></td>
	  </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>   
	  </tr>
	  <tr>
		<td class="td_title"  style="color:#FF0000; font-size:14px; font-weight:bold;">Minimum Withdrawal Balance   </td>
		<td class="td_title" style="color:#FF0000; font-size:14px; font-weight:bold;"> <?php echo $minimum_withdrawal; ?>  <font color=dark>$ </font></strong></td>
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

			$query_mode2 = mysql_query("select * from income_transfer where paying_id = '$id' and (mode = 0 or mode = 1)");
			
			$var_te1 = mysql_num_rows($query_mode2);
						
			if($inv_mode == 1 or $var_te > 0 or $var_te1 > 0)	
			{
				print "<p style=\"color:#BC0007\">Last Withdrawal is Not Yet Completed or There should not any pending get help and send help.<br /><br /></p>";
			}
			else
			{
				$que = mysql_query("select sum(amount) from income_transfer where paying_id  = '$id' and mode = 2 ");
				while($row = mysql_fetch_array($que))
				{
					$max_amnt = $row[0];
				}
					
				$max_withdrawal_amount = $max_amnt/2;
				if($max_withdrawal_amount > 2000)
				{
					$min_limit = $setting_inv_amount/1;
				}
				else
				{
					$min_limit = $setting_inv_amount/2;
				}
				
				$chkdate = date('D', strtotime(" $systems_date "));
				
				if($chkdate != 'Sat' and $chkdate != 'Sun')
				{
				  ?>
			  <tr>
				<td >Your Request Amount :</td>
				<td >
				<select name="request" class="textInput" style="width:144px; height:auto; font-size:13px;">
	<?php			for($i = ($min_limit); $i <= $max_withdrawal_amount; $i = $i+($min_limit))
				{ 
				
				?>
				
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
			  </tr>
			<?php	}
				else
				{
				print "Withdral is not working for saturday and sunday !";
				}	
			}
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
	</table>

<?php 
}  ?>
