<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
/*include("../function/pair_point_calculation.php");*/
?>

<h2>User Investment</h2>

<?php

$link_date = $systems_date; //date('Y-m-d', strtotime("$systems_date  +$income_hold_days day "));

if($_POST['Giv_Money'])
{
	
$taker_ids=$_POST['taker_ids'];
$taker_amount=$_POST['taker_amount'];
$giver_id=$_POST['giver_id'];

/*
$qqq = mysql_query("select (paid_limit-per_day_paid) , (total_amount-paid_amount) from income where mode = 1 and date < '$link_date' and id IN (".implode(',', $taker_ids).") order by priority , date , id ");
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
		
	}*/
	


$sql="select * from investment_request where mode = 1 and date <= '$link_date' and id='$giver_id'";
	
$giver_table_row = mysql_fetch_object(mysql_query($sql));
$total_investment_amount_snd=$giver_table_row->amount;	
if(array_sum($taker_amount)==$total_investment_amount_snd)
{
$count=count($taker_amount);
$investment_user_id=$giver_table_row->user_id;
$time=date("Y-m-d H:i:s");
$testa=1;
for ($x = 1; $x <= $count; $x++) 
{
	$income_id=$taker_ids[$x-1];
	$taker_table_row = mysql_fetch_object(mysql_query("select * from income where mode = 1 and date <= '$link_date' and id='$income_id'"));
	$current_pay_amount=$taker_amount[$x-1];

	if(($taker_table_row->total_amount- $taker_table_row->paid_amount) < $current_pay_amount){$testa=0;break;}
	
}
if($testa==1)
{
for ($x = 1; $x <= $count; $x++) {
$income_id=$taker_ids[$x-1];
$current_pay_amount=$taker_amount[$x-1];
$taker_table_row = mysql_fetch_object(mysql_query("select * from income where mode = 1 and date <= '$link_date' and id='$income_id'"));
$pay_user_id=$taker_table_row->user_id; 
$taker_user_table_row = mysql_fetch_object(mysql_query("select * from users where id_user ='$pay_user_id'"));
$pay_username=$taker_user_table_row->username;  
$pay_full_name =$taker_user_table_row->f_name." ".$taker_user_table_row->l_name;
$pay_ac_no = $taker_user_table_row->ac_no;
$pay_bank =$taker_user_table_row->bank;
$pay_code = mt_rand(1000, 9999);	
	mysql_query("insert into income_transfer (investment_id , paid_limit , income_id , user_id , username , name , bank_name , bank_acc , paying_id , amount , pay_code , date, time_link) values ('$giver_id' , '$current_pay_amount' , '$income_id' , '$pay_user_id' , '$pay_username' , '$pay_full_name' , '$pay_bank' , '$pay_ac_no' , '$investment_user_id' , '$current_pay_amount' , '$pay_code' , '$systems_date', '$time') ");	
	if(($taker_table_row->paid_amount+$current_pay_amount)==$taker_table_row->total_amount)
	{
	$income_mode=0;
	}else{$income_mode=1;}
	
	mysql_query("update income set paid_amount = (paid_amount+'$current_pay_amount') , mode = '$income_mode'  where id = '$income_id' ");
	$receiver_username = $pay_username;
	$sender_username = get_user_name($investment_user_id);
	$title = "Payment Transfer Link";
	$to = get_user_email($investment_user_id);
	$db_msg = $email_payment_transfer_link_message;
	/*include("../function/full_message.php");
	$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);	
	$SMTPChat = $SMTPMail->SendMail();*/
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
mysql_query("update investment_request set mode = 0 , priority = 0 , app_date = '$systems_date' , app_time  = '$time' where mode = 1 and id = '$giver_id' ");
print "<font color=DodgerBlue>Investment Request accepted Successfully !!</font>";
}else
{
	print "<font color=red>Error : Invaild Amount</font>";
}
}else
{
	print "<font color=red>Error : Invaild Amount</font>";
}
}	
else if($_POST['All_tack'])
{
	
	$taker_ids=$_POST['taker_ids'];
	$giver_id=$_POST['giver_id'];
	$total_inv_amount_in_queue = 0;
	$qqq = mysql_query("select (paid_limit-per_day_paid) , (total_amount-paid_amount) from income where mode = 1 and date < '$link_date' and id IN (".implode(',', $taker_ids).") order by priority , date , id ");
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
	
	$qqqq = mysql_query("select sum(amount) from investment_request where mode = 1 and id='$giver_id' and  date <= '$systems_date' ");
	while($rrrq = mysql_fetch_array($qqqq))
	{
		$total_investment_amount = $rrrq[0];
		$total_investment_amount_usd = round($total_investment_amount/$usd_value_current,2);
	}	
	if($total_investment_amount == '')
		$total_investment_amount = 0;
    ?> 
	 <table width="1000" border="0">
	<?php 
	
	if($total_investment_amount > 0)
	{ 
			 
		?>	
		<form action="index.php?page=send_link" method="post">
		<tr>
			<td colspan="6" height="100" align="right" style="text-align:right; padding-right:30px;">
				<B style="font-size:16px;">Commitment Amount : </B>
				<input type="text" readonly min="1" name="send_total_amount" value="<?=$total_investment_amount; ?>" />
				<B style="font-size:14px;">  
					<font color=dark>$ </font> Or <?=round($total_investment_amount/$usd_value_current,2); ?> USD
				</B>
			</td>
			<td height="100">
				<input type="hidden" name="giver_id" value="<?=$giver_id?>" />
			</td>
		</tr>	
<?php	
	} 
?>	
	<tr>	
			 <td colspan="3" align="center" height="30" class="message tip"><strong>Total Unpaid Amount</strong></td>
				<td colspan="3" class="message tip" style="padding-left:50px;"><strong><?=round($total_inv_amount_in_queue/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$total_inv_amount_in_queue; ?> <font color=dark>$ </font></strong></td>
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
				<td align="center" class="message tip"><strong>Amount</strong></td>
			</tr>
			<form>
<?php
  $qqq = mysql_query("select (paid_limit-per_day_paid) , (total_amount-paid_amount) , user_id , date , id from income where mode = 1 and date <= '$link_date' and (total_amount-paid_amount) > 0 and id IN (".implode(',', $taker_ids).")  order by priority , date , id ");
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
				<td class="input-medium" style="padding-left:10px;"><?=$user_id; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?=$name; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?=$phone; ?></td>
				<td align="right" class="input-medium" style="padding-right:10px;"><?=round($total_pad_inc/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$total_pad_inc; ?> <font color=dark>$ </font></td>
				<td align="center" class="input-medium" style="width:80px;"><?=$date; ?></td>
				<td align="center" class="input-medium" style="width:80px;">
				<input style="width:80px;" value="<?=$tbl_id; ?>" type="hidden"  name="taker_ids[]"/>
				<input style="width:80px;" value="" type="number" required min="1" max="<?=$total_pad_inc?>" name="taker_amount[]"/>
			</td>
				
			</tr>
<?php 	} ?>
<tr>
<td colspan="5" align="right"><input type="submit" name="Giv_Money" value="Submit Now" class="btn btn-info" /></td>
</tr>

		
</form>
	</table>		
<?php 
}	











		
else
{
	$_SESSION['accept_user_investment_Request'] = 1;
	$q = mysql_query("select * from chk_pay where date = '$systems_date' ");
	$chk_nm = mysql_num_rows($q);
	if($chk_nm == 0)
	mysql_query("update income set per_day_paid  = 0 where date <= '$systems_date' and mode = 1 ");
	$total_inv_amount_in_queue = 0;
	$qqq = mysql_query("select sum(total_amount-paid_amount) from income where mode = 1 and date < '$link_date' order by priority , date , id "); 
	while($rrr = mysql_fetch_array($qqq))
	{
		$total_inv_amount_in_queue = $rrr[0];
		
		
	}
	$qqqq = mysql_query("select sum(amount) from investment_request where mode = 1 and date <= '$systems_date' ");
	while($rrrq = mysql_fetch_array($qqqq))
	{
		$total_investment_amount = $rrrq[0];
		$total_investment_amount_usd = round($total_investment_amount/$usd_value_current,2);
	}	
	if($total_investment_amount == '')
		$total_investment_amount = 0;


	?> 
	
<table width="400" border="0">
	<tr>
		<td valign="top">	
			<table width="550" border="0">
			<tr>
				<td colspan="3" align="center" height="30" class="message tip">
					<B>Total Commitment Amount</B>
				</td>
				<td colspan="3" class="message tip" style="padding-left:50px;">
					<B>$<?=$total_investment_amount_usd." <font color=DodgerBlue>USD</font> Or  ".
					$total_investment_amount; ?> <font color=dark>$ </font>
					</B>
				</td>
			</tr>
			<tr><td colspan="5">&nbsp;</td></tr>
			<tr>
				<td align="center" class="message tip"><B>User Id</B></td>
				<td align="center" class="message tip"><B>Name</B></td>
				<td align="center" class="message tip"><B>Phone No.</B></td>
				<td align="center" class="message tip"><B>Amount</B></td>
				<td align="center" class="message tip"><B>Date</B></td>
				<td align="center" class="message tip"><B>Action</B></td>
			</tr>
<form method="post" action="index.php?page=send_link">
<?php
	$qqq = mysql_query("select * from investment_request where mode = 1 and date <= '$systems_date' and priority > 0 order by priority ");
	while($rrr = mysql_fetch_array($qqq))
	{
		$amount = $rrr['amount'];
		$amount_usd = round($amount/$usd_value_current,2);
		$date = $rrr['date'];
		$user_id = get_user_name($rrr['user_id']);
		$name = get_full_name($rrr['user_id']);
		$phone = get_user_phone($rrr['user_id']);
		$invtbl_id = $rrr['id'];
?>			
			<tr>
				<td class="input-medium" style="padding-left:10px;"><?=$user_id; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?=$name; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?=$phone; ?></td>
				<td align="right" class="input-medium" style="padding-right:10px;">$<?=$amount_usd." <font color=DodgerBlue>USD</font> Or  ".$amount; ?> <font color=dark>$ </font></td>
				<td align="center" class="input-medium" style="width:80px;"><?=$date; ?></td>
				<td align="center" class="input-medium" style="width:80px;">
			     <input type="radio" checked name="giver_id" value="<?=$invtbl_id; ?>" />    
				
				</td>
			</tr>
<?php 	} ?>			
			</table>
		 </td>
		<td valign="top">	
			<table width="550" border="0">
			<tr>
			
			 <td colspan="3" align="center" height="30" class="message tip"><strong>Total Unpaid Amount</strong></td>
				<td colspan="3" class="message tip" style="padding-left:50px;"><strong><?=round($total_inv_amount_in_queue/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$total_inv_amount_in_queue; ?> <font color=dark>$ </font></strong></td>
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
				<td align="center" class="message tip"><strong>Amount</strong></td>
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
				<td class="input-medium" style="padding-left:10px;"><?=$user_id; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?=$name; ?></td>
				<td class="input-medium" style="padding-left:10px;"><?=$phone; ?></td>
				<td align="right" class="input-medium" style="padding-right:10px;"><?=round($total_pad_inc/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$total_pad_inc; ?> <font color=dark>$ </font></td>
				<td align="center" class="input-medium" style="width:80px;"><?=$date; ?></td>
				<td align="center" class="input-medium" style="width:80px;">
				<input style="width:80px;" value="<?=$tbl_id; ?>" type="checkbox" name="taker_ids[]"/>
			</td>
				
			</tr>
<?php 	} ?>

		 </table>
		</td>
	</tr>
	<tr>
<td colspan="5" align="right"><input type="submit" name="All_tack" value="Submit Now" class="btn btn-info" /></td>
</tr>

</form>	
	</table>		
<?php 
}	 