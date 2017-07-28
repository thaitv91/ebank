<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
include("../function/pair_point_calculation.php");
?>

<h2>User Investment</h2>

<?php

$link_date = $systems_date; //date('Y-m-d', strtotime("$systems_date  +$income_hold_days day "));

if(isset($_POST['calculate']))
{
	if($_SESSION['accept_user_investment_Request'] == 1)
	{
		$total_approval_payment = $tttttt = $_POST['send_total_amount'];
		$qqq = mysql_query("select sum(paid_limit-per_day_paid) , sum(total_amount-paid_amount) from income where mode = 1 and date <= '$link_date'  order by priority , date , id ");
		while($rrr = mysql_fetch_array($qqq))
		{
			$paid_lmt = $rrr[0];
			$total_pad_inc = $rrr[1];
			if($paid_lmt > $total_pad_inc)
			{
				$paid_limit = $total_pad_inc;
			}
			else
			{
				$paid_limit = $paid_lmt;
			}
		}	
		if($total_approval_payment <= $paid_limit and $total_approval_payment > 0)
		{
			$inc_qqq = mysql_query("select * from investment_request where mode = 1 and date <= '$systems_date' and priority > 0 order by priority ");
			while($inc_row = mysql_fetch_array($inc_qqq))
			{
				$curr_investments = $investment = $inc_row['amount'];
				$investment_user_id = $inc_row['user_id'];
				$investment_req_tbl_id = $inc_row['id'];
				
				if($investment <= $total_approval_payment)
				{
					$total_approval_payment = $total_approval_payment-$investment;
					do
					{
						$time = date('h:i:s');
						$qqq = mysql_query("select * from income where mode = 1 and date <= '$link_date'  and user_id != '$investment_user_id' order by priority , date , id limit 1 ");
						$num = mysql_num_rows($qqq);
						if($num == 0)
						{
							$qqq = mysql_query("select * from income where mode = 1 and date <= '$link_date' order by priority , date , id limit 1 ");
							$num = mysql_num_rows($qqq);
						}
						if($num > 0)			
						{
							while($rrr = mysql_fetch_array($qqq))
							{
								$total_inv_amount = $rrr['total_amount'];
								$prev_paid_amount = $rrr['paid_amount'];
								$income_id = $rrr['id'];
								$pay_user_id = $rrr['user_id'];
								$paid_limit = $rrr['paid_limit'];
								$previous_paid_date = $rrr['date'];
								$per_day_paid = $rrr['per_day_paid'];
								
								$one_day_recived_amount = $paid_limit-$per_day_paid;
			
								$prev_left_amount = $total_inv_amount-$prev_paid_amount;
								
								if(($curr_investments >= $one_day_recived_amount) or ($prev_left_amount < $curr_investments))
								{
									if($prev_left_amount > $one_day_recived_amount)
									{
										$income_mode = 1;
										$nxtd = date('Y-m-d', strtotime("$systems_date  +1 day "));	
										$current_pay_amount = $one_day_recived_amount;
										$total_receive_amount = $prev_paid_amount+$one_day_recived_amount;
										$user_investment_left_amount = $curr_investments-$one_day_recived_amount;
										$total_per_day_paid = 0;
									}	
									else
									{
										$income_mode = 0;
										$nxtd = $previous_paid_date; 
										$current_pay_amount = $prev_left_amount;
										$total_receive_amount = $total_inv_amount;
										$user_investment_left_amount = $curr_investments-$prev_left_amount;
										$total_per_day_paid = $per_day_paid+$prev_left_amount;
									}	
								}
								else
								{
									$income_mode = 1;
									$nxtd = $previous_paid_date; 
									$current_pay_amount = $curr_investments;
									$total_receive_amount = $prev_paid_amount+$curr_investments;
									$user_investment_left_amount = 0;
									$total_per_day_paid = $per_day_paid+$curr_investments;
								}	
										
								
								$qyq = mysql_query("select * from users where id_user = '$pay_user_id' ");
								while($rtrr = mysql_fetch_array($qyq))
								{
									$pay_username = $rtrr['username'];
									$pay_ac_no = $rtrr['ac_no'];
									$pay_bank = $rtrr['bank'];
									$pay_full_name = $rtrr['f_name']." ".$rtrr['l_name'];
								}
								
								$pay_code = mt_rand(1000, 9999);	
								mysql_query("insert into income_transfer (investment_id , paid_limit , income_id , user_id , username , name , bank_name , bank_acc , paying_id , amount , pay_code , date) values ('$investment_req_tbl_id' , '$current_pay_amount' , '$income_id' , '$pay_user_id' , '$pay_username' , '$pay_full_name' , '$pay_bank' , '$pay_ac_no' , '$investment_user_id' , '$current_pay_amount' , '$pay_code' , '$systems_date') ");	
			
								mysql_query("update income set paid_amount = '$total_receive_amount' , mode = '$income_mode' , per_day_paid = '$total_per_day_paid' , date = '$nxtd' where id = '$income_id' ");
								
								mysql_query("update investment_request set mode = 0 , priority = 0 , app_date = '$systems_date' , app_time  = '$time' where mode = 1 and id = '$investment_req_tbl_id' ");
								
							}
							
							$receiver_username = $pay_username;
							$sender_username = get_user_name($investment_user_id);
							$title = "Payment Transfer Link";
							$to = get_user_email($investment_user_id);
							$db_msg = $email_payment_transfer_link_message;
							include("../function/full_message.php");
							$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);	
							$SMTPChat = $SMTPMail->SendMail();
							
							$phone = get_user_phone($investment_user_id);
							$investment_link_amount = $current_pay_amount;
							$db_msg = $setting_sms_invsetment_link_sender;
							include("../function/full_message.php");
							send_sms($phone,$full_message);	
							
							$phone = get_user_phone($pay_user_id);
							$receiver_username = $pay_username;
							$investment_pay_code = $pay_code;
							$db_msg = $setting_sms_invsetment_link_receiver;
							include("../function/full_message.php");
							send_sms($phone,$full_message);
							
						}
						else
						{
						
						}
						$curr_investments = $user_investment_left_amount;
					}while($user_investment_left_amount > 0);
				}	
			}
			$_SESSION['accept_user_investment_Request'] = 0;
			mysql_query("insert into chk_pay (date) values ('$systems_date') ");
			mysql_query("delete from income_transfer where amount = 0 ");
			print "Investment Request of amount $tttttt <font color=dark>$ </font> accepted Successfully !!";
		}
		else
		{	
			print "<font color=red>Error : Invaild Amount</font>";
		}		
		
	}	
}
if(isset($_POST['Cancel_withdrawal']))
{
	$withdral_id = $_POST['cancel_withdrawal_id'];
	
	$qqq = mysql_query("select * from income where mode = 1 and id = '$withdral_id' ");
	while($rrr = mysql_fetch_array($qqq))
	{
		$total_amount = $rrr['total_amount']; 	 	
		$paid_amount = $rrr['paid_amount'];
		$user_id = $rrr['user_id']; 
	}
	mysql_query("update income set total_amount = '$paid_amount' , mode = 0 where mode = 1 and id = '$withdral_id' ");
	
	$left_amount = $total_amount-$paid_amount;	

	$tot_que = mysql_query("select * from wallet where id = '$user_id' ");
	while($rrrrr = mysql_fetch_array($tot_que))
	{
		$wallet_amount = $rrrrr['amount'];	
	}
	$total_wallet_bal = $wallet_amount+$left_amount;
	mysql_query("update wallet set amount = '$total_wallet_bal' where id = '$user_id' ");
}

if(isset($_POST['Cancel_commitment']))
{
	$commit_id = $_POST['cancel_commitment_id'];
	mysql_query("update investment_request set amount = 0 , mode = 0 where id = '$commit_id' ");
}		
else
{
	$_SESSION['accept_user_investment_Request'] = 1;
	$q = mysql_query("select * from chk_pay where date = '$systems_date' ");
	$chk_nm = mysql_num_rows($q);
	if($chk_nm == 0)
		mysql_query("update income set per_day_paid  = 0 where date <= '$systems_date' and mode = 1 ");
	
	$total_inv_amount_in_queue = 0;
	$qqq = mysql_query("select (paid_limit-per_day_paid) , (total_amount-paid_amount) from income where mode = 1 and date < '$link_date' order by priority , date , id ");
	while($rrr = mysql_fetch_array($qqq))
	{
		$total_inv_amnt_in_queue = $rrr[0];
		$total_pnd_amount_in_queue = $rrr[1];
		if($total_inv_amnt_in_queue > $total_pnd_amount_in_queue)
		{
			$total_inv_amount_in_queue = $total_inv_amount_in_queue+$total_pnd_amount_in_queue;
		}
		else
		{
			$total_inv_amount_in_queue = $total_inv_amount_in_queue+$total_inv_amnt_in_queue;
		}
	}
	
	$qqqq = mysql_query("select sum(amount) from investment_request where mode = 1 and date <= '$systems_date' ");
	while($rrrq = mysql_fetch_array($qqqq))
	$total_investment_amount = $rrrq[0];
	if($total_investment_amount == '')
		$total_investment_amount = 0;


	?> 
	
	<table width="400" border="0">
<?php if($total_investment_amount > 0)
{ 
	if($total_inv_amount_in_queue >= $total_investment_amount)
		$total_investment_amount_snd = $total_investment_amount;
	else
		$total_investment_amount_snd = $total_inv_amount_in_queue;	
?>	
	<form action="index.php?page=investment_status" method="post">
	<tr>
		<td height="100" align="right" style="text-align:right; padding-right:30px;"><strong style="font-size:16px;">Commitment Amount : </strong><input type="text" name="send_total_amount" value="<?php print $total_investment_amount_snd; ?>" /> <strong style="font-size:14px;">$ </strong></td>
		<td height="100"><input type="submit" name="calculate" value="Calculate" class="btn btn-info" /></td>
	</tr>
	</form>	
<?php	} ?>	
	<tr>
		<td valign="top">	
			<table width="550" border="0">
			<tr>
				<td colspan="3" align="center" height="30" class="message tip"><strong>Total Commitment Amount</strong></td>
				<td colspan="3" class="message tip" style="padding-left:50px;"><strong><?php print $total_investment_amount; ?> <font color=dark>$ </font></strong></td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="message tip"><strong>User Id</strong></td>
				<td align="center" class="message tip"><strong>Name</strong></td>
				<td align="center" class="message tip"><strong>Phone No.</strong></td>
				<td align="center" class="message tip"><strong>Amount</strong></td>
				<td align="center" class="message tip"><strong>Date</strong></td>
				<td align="center" class="message tip"><strong>Action</strong></td>
			</tr>
<?php
	$qqq = mysql_query("select * from investment_request where mode = 1 and date <= '$systems_date' and priority > 0 order by priority ");
	while($rrr = mysql_fetch_array($qqq))
	{
		$amount = $rrr['amount'];
		$date = $rrr['date'];
		$user_id = get_user_name($rrr['user_id']);
		$name = get_full_name($rrr['user_id']);
		$phone = get_user_phone($rrr['user_id']);
		$invtbl_id = $rrr['id'];
?>			
			<tr>
				<td class="input-medium" style="padding-left:10px;"><?php print $user_id; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?php print $name; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?php print $phone; ?></td>
				<td align="right" class="input-medium" style="padding-right:10px;"><?php print $amount; ?> <font color=dark>$ </font></td>
				<td align="center" class="input-medium" style="width:80px;"><?php print $date; ?></td>
				<td align="center" class="input-medium" style="width:80px;">
				<form action="index.php?page=investment_status" method="post">
				<input type="hidden" name="cancel_commitment_id" value="<?php print $invtbl_id; ?>" />
				<input type="submit" name="Cancel_commitment" value="Cancel" />
				</form>
				</td>
			</tr>
<?php 	} ?>			
			</table>
		</td>
		<td valign="top">	
			<table width="550" border="0">
			<tr>
				<td colspan="3" align="center" height="30" class="message tip"><strong>Total Unpaid Amount</strong></td>
				<td colspan="3" class="message tip" style="padding-left:50px;"><strong><?php print $total_inv_amount_in_queue; ?> <font color=dark>$ </font></strong></td>
			</tr>
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
				<td align="center" class="message tip"><strong>User Id</strong></td>
				<td align="center" class="message tip"><strong>Name</strong></td>
				<td align="center" class="message tip"><strong>Phone No.</strong></td>
				<td class="message tip"><strong>Amount</strong></td>
				<td align="center" class="message tip"><strong>Date</strong></td>
				<td align="center" class="message tip"><strong>Action</strong></td>
			</tr>
<?php
	$qqq = mysql_query("select (paid_limit-per_day_paid) , (total_amount-paid_amount) , user_id , date , id from income where mode = 1 and date <= '$link_date' and (total_amount-paid_amount) > 0  order by priority , date , id ");
	while($rrr = mysql_fetch_array($qqq))
	{
		$paid_lmt = $rrr[0];
		$total_pad_inc = $rrr[1];
		$date = $rrr[3];
		$tbl_id = $rrr[4];
		if($paid_lmt > $total_pad_inc)
		{
			$paid_limit = $total_pad_inc;
		}
		else
		{
			$paid_limit = $paid_lmt;
		}
		
		$user_id = get_user_name($rrr['user_id']);
		$name = get_full_name($rrr['user_id']);
		$phone = get_user_phone($rrr['user_id']);
?>			
			<tr>
				<td class="input-medium" style="padding-left:10px;"><?php print $user_id; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?php print $name; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?php print $phone; ?></td>
				<td align="right" class="input-medium" style="padding-right:10px;"><?php print $paid_limit; ?> <font color=dark>$ </font></td>
				<td align="center" class="input-medium" style="width:80px;"><?php print $date; ?></td>
				<td align="center" class="input-medium" style="width:80px;">
				<form action="index.php?page=investment_status" method="post">
				<input type="submit" name="Cancel_withdrawal" value="Cancel" />
				<input type="hidden" name="cancel_withdrawal_id" value="<?php print $tbl_id; ?>" />
				</form>
				</td>
			</tr>
<?php 	} ?>			
			</table>
		</td>
	</tr>
	</table>		
<?php 
}	 