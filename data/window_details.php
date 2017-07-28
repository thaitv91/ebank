<?php
error_reporting(0);
session_start();
include("../condition.php");
include("../config.php");
include("../function/functions.php");
$user_id = $_SESSION['ebank_user_id'];
$id = $_REQUEST['id'];

//$phone = get_user_phone($id);
//$email = get_user_email($id);

if($id != ''){
//$query = mysql_query("SELECT * FROM user_bank WHERE user_id = '$id' order by id limit 1");
$query = mysql_query("SELECT * FROM users WHERE id_user = '$id'");
while($rrr = mysql_fetch_array($query))
{
	$user_ids = $rrr['user_id'];
	$bank = $rrr['bank'];
	$branch = $rrr['branch'];
	$ac_no = $rrr['ac_no'];
	$benef_name = $rrr['beneficiery_name'];
	$per_mon_acc = $rrr['perfect_money_acc'];
	$bit_coin_acc = $rrr['bit_coin_acc'];
	$ifsc_code = $rrr['bank_code'];
	$phone = $rrr['phone_no'];
	$email = $rrr['email'];
	$name = $rrr['f_name']." ".$rrr['l_name'];
	
	//$name = get_full_name($user_ids);
} ?>

<div class="window detail" style="width: 888px; z-index: 9006; text-align:left;">
	<div class="panel-header panel-header-noborder window-header" style="width: 888px;">
		<div class="panel-title">Detailed order information</div>
		<div class="panel-tool"><a class="panel-tool-close" onclick="javascript:close_popup()"></a></div>
	</div>
	<div class="panel-body panel-body-noborder window-body" style="overflow: hidden;width: 886px; height: 465px;">
		<div class="panel" style="width: 886px;">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 30px;overflow: auto; height: 368px; width: 826px;" title="">
				<div style="font-size: 16px; font-weight: bold;">Order: </div><br>
				<div>
					Member of the Cdbv has requested assistance in the amount of: 
					<b><span id="lblamount"></span>&nbsp; <span id="lbldetctype"></span></b>
				</div><br><br>
				<div class="light_border">
					Bank name: <span><?=$bank;?></span><br>
					Phone No. : <span><?=$phone;?></span><br>
					E-mail: <span><?=$email;?></span><br>
					IFSC Code: <span><?=$ifsc_code;?></span><br>
					Account Name: <span><?=$name;?></span><br>
					Account Number: <span><?=$ac_no;?></span><br>
					Branch Name: <span><?=$branch;?></span><br>
					Beneficiery Name: <span><?=$benef_name;?></span><br>
					Perfact Money Account No: <span><?=$per_mon_acc;?></span><br>
					Bit Coin Address: <span><?=$bit_coin_acc;?></span><br><br>
				</div><br><br>
				<div class="light_border">
				<table class="data_grid" cellspacing="0" border="1" style="width:100%;">
				<tr><th colspan="7"><h6><B>Other Bank Account Details :</B></h6></th></tr>
				<tr>
					<th>Bank name</th>
					<th>IFSC Code</th>
					<th>Account Name</th>
					<th>Account Number</th>
					<th>Branch Name</th>
					<th>Perfact Money Account No</th>
					<th>Bit Coin Address</th>
				</tr>
				<?php
					$sqles = "SELECT * FROM user_bank WHERE user_id = '$id'";
					$quse = mysql_query($sqles);
					while($rse = mysql_fetch_array($quse))
					{
						$user_ide = $rse['user_id'];
						$banke = $rse['bank'];
						$branche = $rse['branch'];
						$ac_noe = $rse['acc_no'];
						$per_mon_acce = $rse['perfect_money_acc'];
						$bit_coin_acce = $rse['bit_coin_acc'];
						$ifsc_codee = $rse['ifsc_code'];
						$namee = get_full_name($user_ide);
				?>
				<tr>
					<td><?=$banke;?></td>
					<td><?=$ifsc_codee;?></td>
					<td><?=$namee;?></td>
					<td><?=$ac_noe;?></td>
					<td><?=$branche;?></td>
					<td><?=$per_mon_acce;?></td>
					<td><?=$bit_coin_acce;?></td>
				</tr>
				<?php
					}
					?>
				</table>
				</div><br><br>
				After you receive assistance you need to confirm it by clicking appropriate button.<br>
				<div style="color: red;">
					Never confirm payment before funds reception, as confirmation can not be reversed
					and the system will believe, that you have received funds.
				</div><br><br>
				<?php
				$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
				while($rrr = mysql_fetch_array($query))
				{
					$real_p = $rrr['real_parent'];
					$real_par = get_full_name($real_p);
					
					$manager = active_by_real_p($id);
					$manager_name = ucfirst(get_full_name($manager));
				} 
				
				
				$send_spo_id = real_parent($user_id);
				$send_spo_name = ucfirst(get_full_name($send_spo_id));
				
				$Send_mang_id = active_by_real_p($user_id);
				$Send_mang_name = ucfirst(get_full_name($manager));
				
				$spons_phones = get_user_phone($send_spo_id);
				$spons_emails = get_user_email($send_spo_id);
				?>
				<div style="line-height: 20px" class="light_border">
					Recepient: <span><?=$name;?></span><br>
					Recipient Sponsor: <span><?=$real_par; ?></span><br>
					Recipient manager: <span><?=$manager_name; ?></span><br>
					Sender: <span><?=get_full_name($user_id);?></span><br>
					Sender Sponsor: <span><?=$send_spo_name;?></span><br>
					Sponsor Phone No. : <span><?=$spons_phones;?></span><br />
					Sponsor E-mail : <span><?=$spons_emails;?></span><br />
					Sender manager: <span><?=$Send_mang_name;?></span>
				</div><br>
				<div style="color: red;">
					ATTENTION!!<br><br>
					1) SENDER HAS TO PROVIDE HELP IN THE AMOUNT ASSIGNED.<br>
					IN CASE OF CASH TRANSFER, OR PERSONAL CARD USE (ONE, NOT LINKED TO THE SYSTEM) 
					COMMISSIONS ARE PAID BY SENDER; IN CASE OF TRANSFER MADE FORM A SYSTEM ACCOUNT, 
					COMMISSIONS ARE PAID BY THE SYSTEM. YOU WILL HAVE TO SHOW COMMISSIONS AMOUNT IN 
					APPROPRIATE FIELD.<br><br>
					2) IN CASE ORDER WAS NOT COMPLETED ON <span id="lbltime"></span>, YOUR ACCOUNT WILL
					BE BLOCKED AND YOU WILL NOT BE ABLE TO USE THE SYSTEM. YOUR ORDER WOULD BE GIVEN
					(redirected) TO ANOTHER PARTICIPANT.
				<div>
			</div>
		</div>
				<!--<div><br><br><div></div></div><br>
				<div id="detailhour">Extend Payment Expectation(Hour) :
					<input id="txtdhour" style="width: 70px" type="text">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input value="Extend" id="Button2" onclick="javascript:add_d_24hour()" class="success" type="button">
					<span style="color: Red" id="spdhour"></span>
				</div>-->
				<!--<form action="data/help_link.php" method="post" enctype="multipart/form-data" id="help_link" >
				<input type="hidden" name="table_id" value="<?=$_SESSION['table_id']; ?>" />
				<input type="hidden" name="ran" value="Test" />
				<div id="detailupload"><br>
					Please Upload Reciept :
					<input id="payment_receipt" name="payment_receipt" class="qq-upload-button" type="file"><br>
					<div id="imgfile2" style="width: 50px; height: 50px"></div>
					<input name="submit" value="Upload" style="float: left; margin-left: 42px; margin-top: 7px;" class="success" type="submit">
				</div>
				</form>
				<div><br><br><div></div></div>-->
				<div style="height: 1px; overflow: hidden; margin-top: 10px; margin-bottom: 10px;">
					<div class="arrg" style="width: 400px; margin-left: 70px;">
						<table width="100%" border="0" cellpadding="6" cellspacing="0"></table>
					</div>
				</div>
				<div><br><br>
					<i>P.S. In case if the request came not for the full amount indicated in the application.
					Do not worry! Requests for remaining sum will be received within 10 days of the
					filing of your application. :-))</i>
				<div>
		</div>
	</div>
			</div>
		</div>
		<div class="dialog-button">
			<a href="#" class="easyui-linkbutton l-btn" onclick="javascript:close_popup()">
				<span class="l-btn-left">
					<span class="l-btn-text">
						<span class="l-btn-text icon-cancel" style="padding-left: 20px;">Close</span>
					</span>
				</span>
			</a>
		</div>
	</div>
</div>

<?php
}
$pay_id = $_REQUEST['pay_id'];

//$phone1 = get_user_phone($pay_id);
//$email1 = get_user_email($pay_id);

if($pay_id != ''){
//$sql = "SELECT * FROM user_bank WHERE user_id = '$pay_id' order by id limit 1";
$sql = "SELECT * FROM users WHERE id_user = '$pay_id'";
$query1 = mysql_query($sql);
while($row = mysql_fetch_array($query1))
{
	$user_ids1 = $row['user_id'];
	$bank1 = $row['bank'];
	$branch1 = $row['branch'];
	$ac_no1 = $row['ac_no'];
	$benef_name1 = $row['beneficiery_name'];
	$per_mon_acc1 = $row['perfect_money_acc'];
	$bit_coin_acc1 = $row['bit_coin_acc'];
	$ifsc_code1 = $row['bank_code'];
	$phone1 = $row['phone_no'];
	$email1 = $row['email'];
	$name1 = $row['f_name']." ".$row['l_name'];

	//$name1 = get_full_name($user_ids1);
	
} ?>
<div class="window detail_user" style="width: 888px; z-index: 9006; text-align:left;">
	<div class="panel-header panel-header-noborder window-header" style="width: 888px;">
		<div class="panel-title">Detailed order information</div>
		<div class="panel-tool"><a class="panel-tool-close" onclick="javascript:close_popup()"></a></div>
	</div>
	<div class="panel-body panel-body-noborder window-body" style="overflow: hidden;width: 886px; height: 465px;">
		<div class="panel" style="width: 886px;">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 30px;overflow: auto; height: 368px; width: 826px;" title="">
				<div style="font-size: 16px; font-weight: bold;">Order:</div><br>
				<div>
					Member of the Cdbv has requested assistance in the amount of: 
					<b><span id="lblamount"></span>&nbsp; <span id="lbldetctype"></span></b>
				</div><br><br>
				<div class="light_border">
					Bank name: <span><?=$bank1;?></span><br>
					Phone No. : <span><?=$phone1;?></span><br>
					E-mail: <span><?=$email1;?></span><br>
					IFSC Code: <span><?=$ifsc_code1;?></span><br>
					Account Name: <span><?=$name1;?></span><br>
					Account Number: <span><?=$ac_no1;?></span><br>
					Branch Name: <span><?=$branch1;?></span><br>
					Beneficiery Name: <span><?=$benef_name1;?></span><br>
					Perfact Money Account No: <span><?=$per_mon_acc1;?></span><br>
					Bit Coin Address: <span><?=$bit_coin_acc1;?></span><br><br>
				</div><br><br>
				<div class="light_border">
				<table class="data_grid" cellspacing="0" border="1" style="width:100%;">
				<tr><th colspan="7"><h6><B>Other Bank Account Details :</B></h6></th></tr>
				<tr>
					<th>Bank name</th>
					<th>IFSC Code</th>
					<th>Account Name</th>
					<th>Account Number</th>
					<th>Branch Name</th>
					<th>Perfact Money Account No</th>
					<th>Bit Coin Address</th>
				</tr>
				<?php
					$sqlss = "SELECT * FROM user_bank WHERE user_id = '$pay_id'";
					$quss = mysql_query($sqlss);
					while($rss = mysql_fetch_array($quss))
					{
						$user_idss = $rss['user_id'];
						$banks = $rss['bank'];
						$branchs = $rss['branch'];
						$ac_nos = $rss['acc_no'];
						$per_mon_accs = $rss['perfect_money_acc'];
						$bit_coin_accs = $rss['bit_coin_acc'];
						$ifsc_codes = $rss['ifsc_code'];
						$names = get_full_name($user_idss);
				?>
				<tr>
					<td><?=$banks;?></td>
					<td><?=$ifsc_codes;?></td>
					<td><?=$names;?></td>
					<td><?=$ac_nos;?></td>
					<td><?=$branchs;?></td>
					<td><?=$per_mon_accs;?></td>
					<td><?=$bit_coin_accs;?></td>
				</tr>
				<?php
					}
					?>
				</table>
				</div><br><br>
				After you receive assistance you need to confirm it by clicking appropriate button.<br>
				<div style="color: red;">
					Never confirm payment before funds reception, as confirmation can not be reversed
					and the system will believe, that you have received funds.
				</div><br><br>
				<?php
				
				$qu = mysql_query("SELECT * FROM users WHERE id_user = '$pay_id' ");
				while($ro = mysql_fetch_array($qu))
				{
					$real_p1 = $ro['real_parent'];
					$real_par1 = get_full_name($real_p1);
					
					$manager1 = active_by_real_p($pay_id);
					$manager_name1 = ucfirst(get_full_name($manager1));
				} 
				
				
				$send_spo_id1 = real_parent($user_id);
				$send_spo_name1 = ucfirst(get_full_name($send_spo_id1));
				
				$Send_mang_id1 = active_by_real_p($user_id);
				$Send_mang_name1 = ucfirst(get_full_name($manager1));
				
				$spons_phone = get_user_phone($send_spo_id1);
				$spons_email = get_user_email($send_spo_id1);
				?>
				<div style="line-height: 20px" class="light_border">
					Recepient: <span><?=$name1;?></span><br>
					Recipient Sponsor: <span><?=$real_par1; ?></span><br>
					Recipient manager: <span><?=$manager_name1; ?></span><br>
					Sender: <span><?=get_full_name($user_id);?></span><br>
					Sender Sponsor: <span><?=$send_spo_name1;?></span><br>
					Sponsor Phone No. : <span><?=$spons_phone;?></span><br />
					Sponsor E-mail : <span><?=$spons_email;?></span><br />
					Sender manager: <span><?=$Send_mang_name1;?></span>
				</div><br>
				<div style="color: red;">
					ATTENTION!!<br><br>
					1) SENDER HAS TO PROVIDE HELP IN THE AMOUNT ASSIGNED.<br>
					IN CASE OF CASH TRANSFER, OR PERSONAL CARD USE (ONE, NOT LINKED TO THE SYSTEM) 
					COMMISSIONS ARE PAID BY SENDER; IN CASE OF TRANSFER MADE FORM A SYSTEM ACCOUNT, 
					COMMISSIONS ARE PAID BY THE SYSTEM. YOU WILL HAVE TO SHOW COMMISSIONS AMOUNT IN 
					APPROPRIATE FIELD.<br><br>
					2) IN CASE ORDER WAS NOT COMPLETED ON <span id="lbltime"></span>, YOUR ACCOUNT WILL
					BE BLOCKED AND YOU WILL NOT BE ABLE TO USE THE SYSTEM. YOUR ORDER WOULD BE GIVEN
					(redirected) TO ANOTHER PARTICIPANT.
				<div>
			</div>
		</div>
				<!--<div><br><br><div></div></div><br>
				<div id="detailhour">Extend Payment Expectation(Hour) :
					<input id="txtdhour" style="width: 70px" type="text">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input value="Extend" id="Button2" onclick="javascript:add_d_24hour()" class="success" type="button">
					<span style="color: Red" id="spdhour"></span>
				</div>-->
				<!--<form action="data/help_link.php" method="post" enctype="multipart/form-data" id="help_link" >
				<input type="hidden" name="table_id" value="<?=$_SESSION['table_id']; ?>" />
				<input type="hidden" name="ran" value="Test" />
				<div id="detailupload"><br>
					Please Upload Reciept :
					<input id="payment_receipt" name="payment_receipt" class="qq-upload-button" type="file"><br>
					<div id="imgfile2" style="width: 50px; height: 50px"></div>
					<input name="submit" value="Upload" style="float: left; margin-left: 42px; margin-top: 7px;" class="success" type="submit">
				</div>
				</form>
				<div><br><br><div></div></div>-->
				<div style="height: 1px; overflow: hidden; margin-top: 10px; margin-bottom: 10px;">
					<div class="arrg" style="width: 400px; margin-left: 70px;">
						<table width="100%" border="0" cellpadding="6" cellspacing="0"></table>
					</div>
				</div>
				<div><br><br>
					<i>P.S. In case if the request came not for the full amount indicated in the application.
					Do not worry! Requests for remaining sum will be received within 10 days of the
					filing of your application. :-))</i>
				<div>
		</div>
	</div>
			</div>
		</div>
		<div class="dialog-button">
			<a href="#" class="easyui-linkbutton l-btn" onclick="javascript:close_popup()">
				<span class="l-btn-left">
					<span class="l-btn-text">
						<span class="l-btn-text icon-cancel" style="padding-left: 20px;">Close</span>
					</span>
				</span>
			</a>
		</div>
	</div>
</div>
<? }?>