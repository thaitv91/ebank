<?php
session_start();
include('condition.php');
include('function/setting.php');
include("function/functions.php");
include("function/pair_point_calculation.php");
include("function/pair_point_income.php");
include("function/send_mail.php");
include("function/income.php");
?>

<script type="text/javascript" src="js/future.js"></script>

<?php
$allowedfiletypes = array("jpg");
$uploadfolder = $payment_receipt_img_full_path;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;


$user_id = $_SESSION['ebank_user_id'];

$user_manager_id = active_by_real_p($user_id);

$_SESSION['show_message'];
$_SESSION['show_message'] = "";


$query = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
while($row = mysql_fetch_array($query))
{
	$f_name = $row['f_name'];
	$l_name = $row['l_name'];
	$user_name = $row['username'];
	$name = $f_name." ".$l_name;
	$phone_no = $row['phone_no'];
	$date = $row['date'];
	$real_parent = get_user_name($row['real_parent']);
	$email = $row['email'];
	$phone_no = $row['phone_no'];
	$city = $row['city'];
	$country = $row['country'];
	$address = $row['address'];
}

?>
<div style="color:#990000; padding:10px 0px 10px 50px;text-decoration: blink">
	<?php
		$inv_count = first_invest_count($user_id);
		if($inv_count == 0){ print "<blink>Note : Your Cmmitment is Not Yet Confirmed.</blink>";
		// Accept Button will be appeared once your commitment confirmed.
		}
		else{}
	?>
</div>

<!--<a href="index.php?page=edit-profile" style="text-decoration:none;">
	<div class="red box btn" style="width:100%; text-align:left;">
		For International Update Your Nettler & Perfect Money Account 
	</div>
</a>-->
<div style="height:80px; text-align:left; color:#00274F; background:#EDECEC; font-size:15px; padding:20px; border:solid 1px; font-family:Courier; font-weight:bold;">
<?=$welcome_message;?>
</div>

<br />
<style>
.table_man tr th,td { padding-left:10px;}
</style>
<div style="  text-align:left; color:#00274F; background:#EDECEC; font-size:15px;font-weight:bold;">
<?php
	 $sql = "SELECT t2.* FROM user_manager as t1 inner join users as t2 on t1.active_by = t2.id_user and  t1.type != 'A' where t1.manager_id = '$user_id' ";
	$query = mysql_query($sql);
	$totalrows = mysql_num_rows($query);
	if($totalrows == 0)
	{
		echo "There is no information to show!"; 
	}
	else 
	{
		print "<h4>Your Manager</h4>
			<table width=100% class=table>
			<thead>
			<tr>
				<th>Username</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
			</tr></thead>";
		
		while($row = mysql_fetch_array($query))
		{			
			print "<tr class=\"input-small\" style=\"height:35px;;background:#fff\">
					<td>".$row['username']."</td>
					<td>".$row['f_name'].'&nbsp;'.$row['l_name']."</td>
					<td>".$row['email']."</td>
					<td>".$row['phone_no']."</td>
				  </tr>";		
		}
		print "</table>";	
	}
?>
</div>

<div style="font-family:verdana; font-weight:bold; font-size:16px; width:100%; height:70px; text-align:center; padding-top:20px;">Referral Link :- <a href="<?=$refferal_link."/".$user_name; ?>" target="_new"><?=$refferal_link."/".$user_name; ?></a></div>

<!--<div style="width:100%; height:100px; text-align:center; color:#FFFFFF; font-size:25px; font-family:Courier; font-weight:bold;">
	<a style="color:#FFFFFF;" href="index.php?page=user-investment"><div style="width:49%; height:60px; float:left; background-color: #18d3da; border: thin solid #B5B9BC; box-shadow: 0 0 4em #030905 inset; padding-top:35px;">
		Send Gift
	</div></a>
	<a style="color:#FFFFFF;" href="index.php?page=request-fund-transfer"><div style="width:49%; height:60px; float:right; background-color: #da18ca; border: thin solid #B5B9BC; box-shadow: 0 0 4em #030905 inset; padding-top:35px;">
		Request For Gift
	</div></a> 
</div>-->


	<table class="table table-dark">
	<tr>
	<th class="num" style="width:100%; font-size:21px;">
	<a style="color:#FFFFFF;" href="index.php?page=request-fund-transfer">Request For Gift</a>
	</th>
	</tr>
	</table>
		

<table style="width:100%;" class="table">
<tr>
<td style="vertical-align:top;">
	<table class="table table-dark ">
		<thead>
		<tr>
			<th colspan="2">User Profile</th>
		</tr>
		</thead>
		<tr>	
			<th>Name </th>
			<th><?=$name; ?></th>
		</tr>	
		<tr>	
			<th>User Id </th>
			<th><?=$user_name; ?></th>
		</tr>
		<tr>	
			<th>Sponsor Id </th>
			<th><?=$real_parent; ?></th>
		</tr>
		<tr>	
			<th>Date Of Joining</th>
			<th><?=$date; ?></th>
		</tr>
		<tr>	
			<th>Phone No.</th>
			<th><?=$phone_no; ?></th>
		</tr>
		<tr>	
			<th>E-mail </th>
			<th><?=$email; ?> </th>
		</tr>
		<tr>	
			<th>City </th>
			<th><?=$city; ?></th>
		</tr>
		<tr>	
			<th>Country </th>
			<th><?=$country; ?></th>
		</tr>
		<tr>	
			<th>Address </th>
			<th><?=$address; ?></th>
		</tr>
	
	</table>	
</td>
<td style="vertical-align:top;">

	<table class="table table-dark ">
		<thead>
		<tr>
			<th colspan="2">Financial Information</th>
		</tr>
		</thead>
		<tr>	
			<th>Wallet Balance </th>
			<th><?php $wallet_bl = get_wallet_amount($user_id); print round($wallet_bl/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$wallet_bl; ?>  <font color=dark>$ </font></th>
		</tr>
		<tr>	
			<th>Sent Help</th>
			<th><?php  $sent_hlp = get_user_approved_investment($user_id); print round($sent_hlp/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$sent_hlp; ?>  <font color=dark>$ </font></th>
		</tr>
		<tr>	
			<th>Non Approved</th>
			<th><?php  $non_appro = get_user_not_approved_investment($user_id); print round($non_appro/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$non_appro; ?> <font color=dark>$ </font></th>
		</tr>
		<tr>	
			<th>Help Received</th>
			<th><?php  $usr_invst_inc = get_user_investment_income($user_id); print round($usr_invst_inc/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$usr_invst_inc; ?>  <font color=dark>$ </font></th>
		</tr>
		<tr>	
			<th>Commitment Amount</th>
			<th><?php $usr_comit =  get_user_commitments($user_id); print round($usr_comit/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$usr_comit ?>  <font color=dark>$ </font></th>
		</tr>
	</table>
</td>
</tr>
</table>

<!--Help Bonus Start-->

<?php
$que = mysql_query("select * from income where user_id = '$user_id' and mode = 1 ");
$total_pay_row = mysql_num_rows($que);
if($total_pay_row > 0)
{ ?>
	<h4 style="padding-left:20px;">Help Bonus Information</h4>
	<div style="margin-top:10px; border-radius:15px; border:1px solid #fff;background:#FAAFBA; font-weight:bold; width:100%; ">   
	<table style="font-style:normal; width:100%; line-height:40px;">
  <tr style="background:#F778A1; color:#FFFFFF">
    <td>Total Income </td>
	<td>Maturity Date</td>
	<td>Paid Income </td>
    <td>Left Amount</td>
  </tr>
<?php
	$jc = 0;
	$lvl_cc = 1;	
	while($row = mysql_fetch_array($que))
	{ 
		$jc++;
		$total_amount = $row['total_amount'];
		$paid_amount = $row['paid_amount'];
		$total_left = $total_amount-$paid_amount;
		$date = $row['date'];
		?>
		
		<form action="index.php?page=welcome_action" method="post" enctype="multipart/form-data"> 
		  <input type="hidden" name="table_id" value="<?=$table_id; ?>" />
		<tr>
			<td>
			<?=round($total_amount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$total_amount; ?> <font color=dark>$ </font></td>
			<td><?=$date; ?></td>
		<td><?=round($paid_amount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$paid_amount; ?> <font color=dark>$ </font></td>
		<td><?=round($total_left/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$total_left; ?> <font color=dark>$ </font></td>
		</tr>
		</form>
<?php 	}  ?>
		
</table>
	</div>

<?php
}  ?>


<!--Help Bonus End-->	


<!--First Box Start-->

<?php
$que = mysql_query("select * from income_transfer where mode = 0 and paying_id = '$user_id' " );
$total_pay_row = mysql_num_rows($que);
if($total_pay_row > 0)
{ ?>

	<h4>Payment Information</h4>
<?php
	$pay_err = $_REQUEST['pay_err'];
	if($pay_err == 1)
		print "<strong><font color=\"#FF0000\">Error: Invalid file extension!</font></strong>";
	elseif($pay_err == 2)
		print "<strong><font color=\"#FF0000\">Error: Payment Slip not saved !</font></strong>";
	elseif($pay_err == 3)
		print "<strong><font color=\"#FF0000\">Error: Payment Slip Not Found !</font></strong>" ; 
	elseif($pay_err == 4)
		print "<strong><font color=\"#FF0000\">Error: Invalid Pay Code !</font></strong>" ; 		
	$jc = 0;
	$lvl_cc = 1;	
	while($row = mysql_fetch_array($que))
	{ 
		$jc++;
		$pay_id = $row['user_id'];
		$table_id = $row['id'];
		$amount = $row['amount'];
		$mode = $row['mode'];
		
		
		$query = mysql_query("SELECT * FROM users WHERE id_user = '$pay_id' ");
		while($rrr = mysql_fetch_array($query))
		{
			$f_name = $rrr['f_name'];
			$l_name = $rrr['l_name'];
			$payee_username = $rrr['username'];
			$city = $rrr['city'];
			$real_p = $rrr['real_parent'];
			$real_par = get_user_name($rrr['real_parent']);
			$real_psar_name = get_full_name($real_p);
			$name = $f_name." ".$l_name;
			$phone_no = $rrr['phone_no'];
			$ac_no = $rrr['ac_no'];
			$bank_code = $rrr['bank_code'];
			$bank = $rrr['bank'];
			$beneficiery_name = $rrr['beneficiery_name'];
			$email = $rrr['email'];
		} ?>
		
		<form action="index.php?page=welcome_action" method="post" enctype="multipart/form-data">
		  <input type="hidden" name="table_id" value="<?=$table_id; ?>" />

		<div style="margin-top:10px; border-radius:15px; border:1px solid;background:#FF0000; color:#FFFFFF; font-weight:bold; height:105px; width:100%; clear:both;"> 
			<div id="trigger<?=$jc; ?>" style="float:left; width:10%; padding-left:10px;">
			   <a id="trigger<?=$jc; ?>" style="">
				<?="<h2 style=\"line-height: 80px;\">You</h2>"; ?></a>
				<div id="pop-up<?=$jc; ?>" class="css_popup">     	 
				<table class="MyTable" border="1" bordercolor="#C5C5C3" style="border-collapse:collapse; margin:6px;" cellpadding="0" cellspacing="0" width="300" >
						<tr>
							<td align="center" height="25" colspan="2" style="padding-left:0px;" bgcolor="#cdbfd7"><strong>My Self</strong></td>
							</tr>
						  <tr>
							<td width="120">Sponsor Id </td>
							<td><?=$real_par; ?></td>
							</tr>
							 <tr>
							<td width="120">Name </td>
							<td><?=$name; ?></td>
							</tr>
						  <tr>
							<td>User Id</td>
							<td><?=$payee_username; ?></td>
							</tr>
						  <tr>
							<td>City </td>
							<td><?=$city; ?></td>
							</tr>
						  <tr>
							<td>Phone No.</td>
							<td><?=$phone_no; ?></td>
							</tr>
						  <tr>
							<td>Sponsor Name</td>
							<td><?=$real_psar_name; ?></td>
						  </tr>
						 
	<?php
					$nxtss = $real_p;
					for($rty = 0; $rty < 1; $rty++)
					{	
						$lvl_cc++;
						$f_names = $l_names = $payee_usernames = $citys = $real_ps = $real_pars = $real_par_names = $phone_nos = $ac_nos = $banks = $emails = "";
						$query = mysql_query("SELECT * FROM users WHERE id_user = '$nxtss' ");
						while($rrr = mysql_fetch_array($query))
						{
							$f_names = $rrr['f_name'];
							$l_names = $rrr['l_name'];
							$payee_usernames = $rrr['username'];
							$citys = $rrr['city'];
							$real_ps = $rrr['real_parent'];
							$real_pars = get_user_name($real_ps);
							$real_par_names = get_full_name($real_ps);
							$names = $f_names." ".$l_names;
							$phone_nos = $rrr['phone_no'];
							$ac_nos = $rrr['ac_no'];
							$banks = $rrr['bank'];
							$emails = $rrr['email'];
							?>
						<tr>
							<td align="center" height="25" colspan="2" bgcolor="#B8C8DC"><strong>Sponsor <?=$rty+1; ?></strong></td>
							</tr>
						  <tr>
							<td width="120">Sponsor Id </td>
							<td><?=$real_pars; ?></td>
							</tr>
							 <tr>
							<td width="120">Name </td>
							<td><?=$names; ?></td>
							</tr>
						  <tr>
							<td>User Id</td>
							<td><?=$payee_usernames; ?></td>
							</tr>
						  <tr>
							<td>City </td>
							<td><?=$citys; ?></td>
							</tr>
						  <tr>
							<td>Phone No.</td>
							<td><?=$phone_nos; ?></td>
							</tr>
						  <tr>
							<td>Sponsor Name</td>
							<td><?=$real_par_names; ?></td>
						  </tr>
							<?php
						}
						$nxtss = $real_ps;
					}	?>	
				</table>
				</div>
			</div>
			<div style="float:left; width:20%;"><img src="images/arrows.png"></div>
			<div style="float:left; width:25%;line-height: 17px;">
				<?="Name - ".$f_name." ".$l_name; ?><br />
				<?="A/C Details -<br /> Bank - ".$bank; ?><br />
				<?="A/C No - ".$ac_no; ?><br />
				<?="Bank Code - ".$bank_code; ?><br />
				<?="Phone No - ".$phone_no; ?>..<a href="index.php?page=user_details&val=<?= $payee_username;?>" target="_blank">More</a>
			</div>
			<div style="float:left; width:15%;line-height: 100px;"><?="Amount - ".$amount; ?></div>
			<div style="float:left;line-height: 100px;">
			<input type="file" name="payment_receipt" size="2"  style="background: none"/>
			</div>
			<div style="float:left;line-height: 50px;">
			<input type="submit" name="Submit" value="Pay" class="btn btn-info" /><br /><a href="javascript:void(0);" onClick="OpenChatWindow(<?=$pay_id;?>,<?="'chat'";?>,<?=$user_id;?>)" style="color:#4a326e; text-decoration:none;" role="button" class="btn btn-default" data-toggle="modal">Chat</a>
			</div>
			<div style="clear:both"></div>
		</div>	
		  </form>
<?php 	}  
} ?>

<!--First Box End-->	
<!--Second Box Start-->


	
<?php
$que = mysql_query("select * from income_transfer where mode = 1 and user_id = '$user_id' " );
$numm = mysql_num_rows($que);
if($numm > 0)
{  ?>
	<h3>Income Information</h3>
<?php
	$_SESSION['send_income_fo_user'] = 1;
	$jcd = $jc+1;
	$total_pay_row = $total_pay_row+$numm;
	$tr = 0;
	while($row = mysql_fetch_array($que))
	{ 
		$tr++;
		$paying_id = $row['paying_id'];
		$investment_id = $row['investment_id'];
		$table_id = $row['id'];
		$amount = $row['amount'];
		$mode = $row['mode'];
		$payment_receipt = $row['payment_receipt'];	
		$query = mysql_query("SELECT * FROM users WHERE id_user = '$paying_id' ");
		while($rrr = mysql_fetch_array($query))
		{
			$f_name_acc = $rrr['f_name'];
			$l_name_acc = $rrr['l_name'];
			$phn_acc = $rrr['phone_no'];
			$mail_acc = $rrr['email'];
			$real_phn_acc = get_user_phone($rrr['real_parent']);
		} ?>
		<form action="index.php?page=welcome_action" method="post">
		  <input type="hidden" name="table_id" value="<?=$table_id; ?>" />
		  <input type="hidden" name="table_inv_id" value="<?=$investment_id; ?>" />
			<div style="margin-top:10px; border-radius:15px; border:1px solid;background:#008000; color:#FFFFFF; font-weight:bold; line-height:23px; height:105px; width:100%; clear:both;"> 
			
			<div style="float:left; width:10%;padding-left:10px;"><?="<h2 style=\"line-height: 80px;\">You</h2>"; ?></div>
			<div style="float:left; width:20%;"><img src="images/arrow_left.png"></div>
			<div style="float:left; width:25%;line-height: 24px;"><?="Name - ".$f_name_acc." ".$l_name_acc; ?><br />
				<?="Phone No - ".$phn_acc; ?><br />
				<?="Email - ".$mail_acc; ?><br />
				<?="Sponsor Phone - ".$real_phn_acc; ?>
			</div>	
			<div style="float:left; width:13%;line-height: 50px;">
				
				<a style="color:#fff;" href="payment_rec.php?payment_receipt=<?= $payment_receipt;?>" target="_blank"><blink>Receipt Click here !</blink></a>
				
				
				<!--<a id="trigger-rec<?=$tr; ?>" style="cursor:pointer;">
					<?=$payment_receipt; ?></a><br />Mouse Over
				
				<div id="pop-up-rec<?=$tr; ?>" class="css_popup_rec"> 	 
				<table class="MyTable" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse; margin:0px;" cellpadding="0" cellspacing="0" width="95%" >
					<tr>
						<td align="center" height="25" colspan="2" style="padding-left:0px;" bgcolor="#B8C8DC"><strong>Payment Receipt</strong></td>
					</tr>
					<tr>
						<td width="120">Receipt No. </td>
						<td><?=$payment_receipt; ?></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
						<img src="payment_receipt/<?=$payment_receipt; ?>.jpg"  height="370" width="580" />
						</td>
					</tr>
				</table>
				</div>
				-->
				
				
			</div>
			<div style="float:left; width:18%;line-height: 50px;"><?="Amount -<br /> ".round($amount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$amount; ?> <font color=dark>$ </font></div>
			<div style="float:left;line-height: 50px;">
		<input type="submit" name="Accept" value="Accept" class="btn btn-info" /><br />
		<a href="javascript:void(0);" onClick="OpenChatWindow(<?=$paying_id;?>,<?="'chat'";?>,<?=$user_id;?>)" style="color:#000; text-decoration:none;" role="button" class="btn btn-default" data-toggle="modal">Chat</a>
			</div>
		  <div style="clear:both"></div>
		  </div>
		  </form>
<?php 			$jcd++;
	} ?>
<?php
}  ?>


<!--Second Box End-->	
<!--Third Box Start-->

<?php
$que = mysql_query("select * from income_transfer where mode = 1 and paying_id = '$user_id' " );
$num = mysql_num_rows($que);
if($num > 0)
{ ?>
	<h3>Payment Status</h3>
<?php
	while($row = mysql_fetch_array($que))
	{ ?>
	
<?php	
		$pay_id = $row['user_id'];
		$table_id = $row['id'];
		$amount = $row['amount'];
		$mode = $row['mode'];
		
		$query = mysql_query("SELECT * FROM users WHERE id_user = '$pay_id' ");
		while($rrr = mysql_fetch_array($query))
		{
			$f_name = $rrr['f_name'];
			$l_name = $rrr['l_name'];
			$payee_username = $rrr['username'];
			$name = $f_name." ".$l_name;
			$phone_no = $rrr['phone_no'];
			$ac_no = $rrr['ac_no'];
			$bank = $rrr['bank'];
			$email = $rrr['email'];
			$bank_code = $rrr['bank_code'];
		} ?>
		<div style="border-radius:15px; border:1px solid #bbb; background:#FFFF00; color:#000; font-weight:bold; line-height:23px; height:105px; width:100%; clear:both;">
			<div style="float:left; width:170px; padding-left:20px;"><?="<h2 style=\"line-height: 80px;\">You</h2>"; ?></div>
			<div style="float:left; width:230px;"><img src="images/arrows.png"></div>
			<div style="float:left; width:350px;line-height: 25px;"><?="Name - ".$f_name." ".$l_name."<br />"; ?>
				<?="Email - ".$email."<br />"; ?>
				<?="Phone No - ".$phone_no."<br />"; ?>
				<?="A/C No - ".$ac_no; ?>
			</div>
			<div style="float:left; width:150px;line-height: 100px;"><?="Amount - ".$amount; ?></div>
			<div style="float:left;line-height: 40px;"> Pending
			<a href="javascript:void(0);" onClick="OpenChatWindow(<?=$paying_id;?>,<?="'chat'";?>,<?=$user_id;?>)" style="text-decoration:none;" role="button" class="btn btn-default" data-toggle="modal"><br />Chat</a>
			</div>
			<div style="clear:both"></div>
		</div>	
<?php 	} ?>


<?php
}  ?>

<!--Third Box End-->	
<!-- Four Box Start-->
<?php

$que = mysql_query("select * from income_transfer where mode = 0 and user_id = '$user_id' " );
$num = mysql_num_rows($que);
if($num > 0)
{ ?>
	<h3>Income Information</h3>
<?php
	$tr = 0;
	while($row = mysql_fetch_array($que))
	{ 
		$tr++;
		$paying_id = $row['paying_id'];
		$table_id = $row['id'];
		$amount = $row['amount'];
		$mode = $row['mode'];
		$payment_receipt = $row['payment_receipt'];	
		$pay_code = $row['pay_code'];
		
		$inv_date = $row['date'];
		
		$block_date = date('Y-m-d', strtotime(" $inv_date , + 2 days"));	
		
		$lastd_date = date('Y-m-d', strtotime(" $inv_date , + 1 days"));	
		
		$query = mysql_query("SELECT * FROM users WHERE id_user = '$paying_id' ");
		while($rrr = mysql_fetch_array($query))
		{
			$f_name = $rrr['f_name'];
			$l_name = $rrr['l_name'];
			$payee_username = $rrr['username'];
			$name = $f_name." ".$l_name;
			$phone_no = $rrr['phone_no'];
			$ac_no = $rrr['ac_no'];
			$bank = $rrr['bank'];
			$email = $rrr['email'];
			$bank_code = $rrr['bank_code'];
			$usr_type = $rrr['type'];
			$real_parent = get_full_name($rrr['real_parent']);
			$real_parent_phone = get_user_phone($rrr['real_parent']);
			
		} ?>
	  <div style="margin-top:10px; border-radius:15px; border:1px solid;background:#6A287E; color:#FFFFFF; font-weight:bold; height:105px; width:100%; clear:both;"> 
	   
	   
		<div style="float:left; width:10%; padding-left:10px;"><?="<h2 style=\"line-height: 80px;\">You</h2>"; ?></div>
		<div style="float:left; width:20%;"><img src="images/arrow_left.png"></div>
		<div style="float:left; width:19%;line-height: 32px;">
			<?="Name - ".$name; ?><br>
		 	<?="Sponsor Ph. - ".$real_parent_phone; ?><br />
			<?="Phone No - ".$phone_no; ?></div>
		<div style="float:left; width:18%; line-height:40px;"><?="Amount - <br />".round($amount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$amount; ?> <font color=dark>$ </font>
		</div>
		<div style="float:left; width:18%; line-height:25px;">
			<?="Date - ".$inv_date; ?><br>
			<?="Last Date - ".$lastd_date; ?><br>
			
				<?php
				$val1 = $block_date.' 00:00:00';//'2015-11-17 24:00:00';
				$val2 = date('Y-m-d H:i:s');
				$datetime1 = new DateTime($val1);
				$datetime2 = new DateTime($val2);
				if($block_date < $val2 )
				{
					print '<div>Time Out</div>';
				}else{
				?>
				
				<div class="countTime">
				<?php
				echo $datetime1->diff($datetime2)->format("%d:%H:%I:%S");
				?>
				
			</div>
			<?php } ?>
			<?="Pay Code - ".$pay_code; ?>
		</div>
<?php	
		if($systems_date >= $block_date)
		{	?>	
			<form action="index.php?page=welcome_action" method="post">
        	<input type="hidden" name="table_id" value="<?=$table_id; ?>" />		
			<input type="hidden" name="block_user_id" value="<?=$paying_id; ?>" />		
			<div style="float:left; width:10%; line-height:50px;">
			<!--<input type="submit" name="Block_inv" value="Block" class="submit_button" style="background:url(images/gray_button.png) no-repeat; height:24px; width:81px; font-size:12px; padding-left:20px; padding-bottom:5px; font-weight:bold;" />-->
			<?php if($usr_type == 'X'){?>
				<input type="button" name="" value="Waiting" class="btn btn-info"  />
				<a href="javascript:void(0);" onClick="OpenChatWindow(<?=$paying_id;?>,<?="'chat'";?>,<?=$user_id;?>)" role="button" class="btn btn-default" data-toggle="modal">Chat</a>
				<?php }
				else{?>
				<input type="submit" name="Inv_Blok_Usr" value="Block" class="btn btn-info" />	<br />
				<a href="javascript:void(0);" onClick="OpenChatWindow(<?=$paying_id;?>,<?="'chat'";?>,<?=$user_id;?>)" role="button" class="btn btn-default" data-toggle="modal">Chat</a>	
				<?php }?>
			</div>
			</form>
<?php 		} 
		else
		{ ?>			
			<div style="float:left; width:50px;">Comming<br /><a href="#chat_box" onClick="OpenChatWindow(<?=$paying_id;?>,<?="'chat'";?>,<?=$user_id;?>)" role="button" class="btn btn-default" data-toggle="chat_box">Chat</a>
			</div>
		 <?php
		} ?>
		</div>
		
<?php	}  ?>
<?php
} 
 ?><div style="clear:both"></div>
<!--Four Box End-->
<div id="loading_div"></div>
<div id="chat_box" class="chat_box" style="position: fixed; padding: 10px; top: 24%; top: -500px; left:500px; z-index: 999; opacity: 0.9;">
<style>
.chat_log
{ 
	width:500px;
	min-height:248px;
	border:solid 1px #C7D5E0;
	background: bottom left #FEFEFF repeat-x;
} 
</style>
<div class="chat_log" >
	
	<div id="chat"></div>
	<div id="chatlogContentArea" > </div>
</div>
 
 </div>
	<style>
      div#container {
        width: 580px;
        margin: 100px auto 0 auto;
        padding: 20px;
        background: #000;
        border: 1px solid #064879;
      }
      
      /* HOVER STYLES */
	  .css_popup
	  {
        display: none;
        position:absolute;
        width:310px;
        padding:0;
        background-color:#FFFFFF;
        color: #000000;
        border: 1px solid #064879;
        font-size: 90%;
		line-height:15px;

      }
	  
	  .css_popup_rec
	  {
        display: none;
        position:absolute;
        width:670px;
        padding:0;
        background-color:#FFFFFF;
        color: #000000;
        border: 1px solid #064879;
        font-size: 90%;
		line-height:15px;
		height:450px;padding-left: 20px;
      }

	  .MyTable td {
	  padding-left:20px; }
	        
    </style>
	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript"> 
      $(function() {
	  	
        var moveLeft = 20;
        var moveDown = -150;
		<?php for($tr = 1; $tr <= $total_pay_row; $tr++)
		{ ?>
		$('a#trigger<?=$tr; ?>').hover(function(e) {
          $('div#pop-up<?=$tr; ?>').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() { 
          $('div#pop-up<?=$tr; ?>').hide();
        });
        
        $('a#trigger<?=$tr; ?>').mousemove(function(e) {
          $('div#pop-up<?=$tr; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
		
		<?php } ?>
      });
	  
	</script>
	
	 <script type="text/javascript"> 
      $(function() {
	  
         var moveLeft = -600;
         var moveDown = -100;
		<?php for($rcp = 1; $rcp <= $numm; $rcp++)
		{ ?>
		$('a#trigger-rec<?=$rcp; ?>').hover(function(e) {
          $('div#pop-up-rec<?=$rcp; ?>').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() { 
          $('div#pop-up-rec<?=$rcp; ?>').hide();
        });
        
        $('a#trigger-rec<?=$rcp; ?>').mousemove(function(e) {
          $('div#pop-up-rec<?=$rcp; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
		
		<?php } ?>
      });
	  
	</script>

<?php



function get_bank_info_for_log($user_id)
{
	$qu = mysql_query("select * from users where id_user = '$user_id' ");
	while($row = mysql_fetch_array($qu))
	{
		$results[0] = $row['ac_no'];
		$results[1] = $row['bank']; 	
	}
	return $results;
}

function get_user_commitments($user_id)
{
	$res = 0;
	$qu = mysql_query("select sum(amount) from investment_request where user_id = '$user_id' and mode = 1 ");
	while($row = mysql_fetch_array($qu))
	{
		$res = $row[0];
	}
	if($res == '')
		$res =0;
	return $res;
}

?>

	
