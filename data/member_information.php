<?php
session_start();
include('condition.php');
include('function/setting.php');
include("function/functions.php");
/*include("function/pair_point_calculation.php");
include("function/pair_point_income.php");*/
include("function/send_mail.php");
include("function/income.php");
?>
<h2 align="left">Dashboard</h2>	
<?php
$allowedfiletypes = array("jpg");
$uploadfolder = $payment_receipt_img_path;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;

if(isset($_POST['Submit']))
{
	$user_id = $_POST['showing_user_id'];
	
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
	
	<!--Help Bonus Start-->
	
	<?php
	$que = mysql_query("select * from income where user_id = '$user_id' and mode = 1 ");
	$total_pay_row = mysql_num_rows($que);
	if($total_pay_row > 0)
	{ ?>
		<div class="fullwidth_box3">
		<div style="background:#999999; border-bottom:1px solid #333333;">
			<h4 style="padding-left:20px;">Help Bonus Information</h4>
		</div>
		<div style="font-size:10pt; line-height:25px; padding-left:15px; margin-top:10px;">  
		<table width="865" border="0" cellspacing="2" cellpadding="0" style="font-style:normal;">
	  <tr>
		<td style="background:#57904c; border-color:#116F47; width:190px;" class="table_head">Total Income </td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Maturity Date</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Paid Income </td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Left Amount</td>
	  </tr>
	<?php
		$jc = 0;
		$lvl_cc = 1;	
		while($row = mysql_fetch_array($que))
		{ 
			$jc++;
			$total_amount = $row['total_amount'];
			$paid_amount = $row['paid_amount'];
			$date = $row['date'];
			?>
			
			<form action="index.php?page=welcome_action" method="post" enctype="multipart/form-data"> 
			  <input type="hidden" name="table_id" value="<?php print $table_id; ?>" />
			<tr>
				<td style="background:#d8fbd0; border-color:#666666; font-size:12px; padding-left:30px;" class="table_data" >
				<?php print $total_amount; ?></td>
				<td style="background:#d8fbd0; border-color:#666666; font-size:12px; padding-left:30px;" class="table_data"><?php print $date; ?></td>
			<td style="background:#d8fbd0; border-color:#666666; font-size:12px; text-align:right; padding-right:30px;" class="table_data"><?php print $paid_amount; ?> <font color=dark>$ </font></td>
			<td style="background:#d8fbd0; border-color:#666666; font-size:12px; text-align:right; padding-right:30px;" class="table_data"><?php print $total_amount-$paid_amount; ?> <font color=dark>$ </font></td>
	<?php 	}  ?>
	</table>
		</div>
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
		<div class="fullwidth_box3">
		<div style="background:#999999; border-bottom:1px solid #333333;">
			<h4 style="padding-left:20px;">Payment Information</h4>
		</div>
		<div style="font-size:10pt; line-height:25px; padding-left:15px; margin-top:10px;">  
		<table width="100%" border="0" cellspacing="2" cellpadding="0" style="font-style:normal;">
	  <tr>
		<td style="background:#57904c; border-color:#116F47; width:80px;" class="table_head">User Id</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">E-mail</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Phone No.</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Bank Name</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Beneficiery Name</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">A/c No.</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">IFSC Code.</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Amount</td>
	  </tr>
	<?php
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
			   <tr>
				<td style="background:#d8fbd0; border-color:#666666; font-size:11px;" class="table_data" id="trigger<?php print $jc; ?>"><a id="trigger<?php print $jc; ?>" style="cursor:pointer;"><?php print $payee_username; ?></a><br />Mouse Over
				<div id="pop-up<?php print $jc; ?>" class="css_popup">     	 
				<table class="MyTable" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse; margin:6px;" cellpadding="0" cellspacing="0" width="300" >
						<tr>
							<td align="center" height="25" colspan="2" style="padding-left:0px;" bgcolor="#B8C8DC"><strong>My Self</strong></td>
							</tr>
						  <tr>
							<td width="120">Sponsor Id </td>
							<td><?php print $real_par; ?></td>
							</tr>
							 <tr>
							<td width="120">Name </td>
							<td><?php print $name; ?></td>
							</tr>
						  <tr>
							<td>User Id</td>
							<td><?php print $payee_username; ?></td>
							</tr>
						  <tr>
							<td>City </td>
							<td><?php print $city; ?></td>
							</tr>
						  <tr>
							<td>Phone No.</td>
							<td><?php print $phone_no; ?></td>
							</tr>
						  <tr>
							<td>Sponsor Name</td>
							<td><?php print $real_psar_name; ?></td>
						  </tr>
						 
	<?php
					$nxtss = $real_p;
					for($rty = 0; $rty < 2; $rty++)
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
							<td align="center" height="25" colspan="2" bgcolor="#B8C8DC"><strong>Sponsor <?php print $rty+1; ?></strong></td>
							</tr>
						  <tr>
							<td width="120">Sponsor Id </td>
							<td><?php print $real_pars; ?></td>
							</tr>
							 <tr>
							<td width="120">Name </td>
							<td><?php print $names; ?></td>
							</tr>
						  <tr>
							<td>User Id</td>
							<td><?php print $payee_usernames; ?></td>
							</tr>
						  <tr>
							<td>City </td>
							<td><?php print $citys; ?></td>
							</tr>
						  <tr>
							<td>Phone No.</td>
							<td><?php print $phone_nos; ?></td>
							</tr>
						  <tr>
							<td>Sponsor Name</td>
							<td><?php print $real_par_names; ?></td>
						  </tr>
							<?php
						}
						$nxtss = $real_ps;
					}	?>	
				</table>
				</div>
				</td>
				<td style="background:#d8fbd0; border-color:#666666; font-size:11px; padding-left:5px;" class="table_data"><?php print $email; ?></td>
				<td style="background:#d8fbd0; border-color:#666666; font-size:11px; padding-left:5px;" class="table_data"><?php print $phone_no; ?></td>
				<td style="background:#d8fbd0; border-color:#666666; font-size:11px; padding-left:5px;" class="table_data"><?php print $bank; ?></td>
				<td style="background:#d8fbd0; border-color:#666666; font-size:11px; padding-left:5px;" class="table_data"><?php print $beneficiery_name; ?></td>
				<td style="background:#d8fbd0; border-color:#666666; font-size:11px; padding-left:5px;" class="table_data"><?php print $ac_no; ?></td>
				<td style="background:#d8fbd0; border-color:#666666; font-size:11px; padding-left:5px;" class="table_data"><?php print $bank_code; ?></td>
				<td style="background:#d8fbd0; border-color:#666666; font-size:11px; padding-left:5px;" class="table_data"><?php print round($amount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$amount; ?>$  </td>
	<?php 	}  ?>
	</table>
		</div>
	</div>
	<?php
	} ?>
	
	<!--First Box End-->	
	<!--Second Box Start-->
	
	
		
			
			<?php
	$que = mysql_query("select * from income_transfer where mode = 1 and user_id = '$user_id' " );
	$numm = mysql_num_rows($que);
	if($numm > 0)
	{  ?>
		<div class="fullwidth_box4">
		<div style="background:#999999; border-bottom:1px solid #333333;">
			<h4 style="padding-left:20px;">Income Information</h4>
		</div>
		<div style="font-size:10pt; line-height:25px; padding-left:15px; margin-top:10px;">   
		<table width="865" border="0" cellspacing="2" cellpadding="0" style="font-style:normal;">
		  <tr>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">User Id</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">E-mail</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Phone No.</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Bank Name</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">A/c No.</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">IFSC Code.</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Payment Receipt</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Amount</td>
		  </tr>
	<?php
		$_SESSION['send_income_fo_user'] = 1;
		$jcd = $jc+1;
		$total_pay_row = $total_pay_row+$numm;
		$tr = 0;
		while($row = mysql_fetch_array($que))
		{ 
			$tr++;
			$paying_id = $row['paying_id'];
			$table_id = $row['id'];
			$amount = $row['amount'];
			$mode = $row['mode'];
			$payment_receipt = $row['payment_receipt'];	
			$query = mysql_query("SELECT * FROM users WHERE id_user = '$paying_id' ");
			while($rrr = mysql_fetch_array($query))
			{
				$f_name_acc = $rrr['f_name'];
				$l_name_acc = $rrr['l_name'];
				$payee_username_acc = $rrr['username'];
				$city_acc = $rrr['city'];
				$real_p_acc = $rrr['real_parent'];
				$real_pars_acc = get_user_name($rrr['real_parent']);
				$real_par_name_acc = get_full_name($real_p);
				$name_acc = $f_name_acc." ".$l_name_acc;
				$phone_no_acc = $rrr['phone_no'];
				$ac_no_acc = $rrr['ac_no'];
				$bank_acc = $rrr['bank'];
				$email_acc = $rrr['email'];
				$bank_code = $rrr['bank_code'];
			} ?>
	
			   <tr>
				<td style="background:#fdfbdc; line-height:18px; border-color:#645f10; font-size:12px;" class="table_data"><a id="trigger<?php print $jcd; ?>" style="cursor:pointer;"><?php print $payee_username_acc; ?></a><br />Mouse Over
				
				<div id="pop-up<?php print $jcd; ?>" class="css_popup">  	
					<table class="MyTable" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse; margin:6px;" cellpadding="0" cellspacing="0" width="300" >
						<tr>
							<td align="center" height="25" colspan="2" style="padding-left:0px;" bgcolor="#B8C8DC"><strong>My Self</strong></td>
							</tr>
						  <tr>
							<td width="120">Sponsor Id </td>
							<td><?php print $real_par; ?></td>
							</tr>
							 <tr>
							<td width="120">Name </td>
							<td><?php print $name_acc; ?></td>
							</tr>
						  <tr>
							<td>User Id</td>
							<td><?php print $payee_username_acc; ?></td>
							</tr>
						  <tr>
							<td>City </td>
							<td><?php print $city_acc; ?></td>
							</tr>
						  <tr>
							<td>Phone No.</td>
							<td><?php print $phone_no_acc; ?></td>
							</tr>
						  <tr>
							<td>Sponsor Name</td>
							<td><?php print $real_par_name_acc; ?></td>
						  </tr>
	
				
	<?php			$nxts = $real_p_acc;
					for($rty = 0; $rty < 2; $rty++)
					{	
						$query = mysql_query("SELECT * FROM users WHERE id_user = '$nxts' ");
						while($rrr = mysql_fetch_array($query))
						{
							$f_name_pop = $rrr['f_name'];
							$l_name_pop = $rrr['l_name'];
							$payee_username_pop = $rrr['username'];
							$city_pop = $rrr['city'];
							$real_p_pop = $rrr['real_parent'];
							$real_par_pop = get_user_name($rrr['real_parent']);
							$real_par_name_pop = get_full_name($real_p_pop);
							$name_pop = $f_name_pop." ".$l_name_pop;
							$phone_no_pop = $rrr['phone_no'];
							$ac_no_pop = $rrr['ac_no'];
							$bank_pop = $rrr['bank'];
							$email_pop = $rrr['email'];
							?>
							
							<tr>
							<td align="center" height="25" colspan="2" bgcolor="#B8C8DC"><strong>Sponsor <?php print $rty+1; ?></strong></td>
							</tr>
						  <tr>
							<td width="120">Sponsor Id </td>
							<td><?php print $real_par_pop; ?></td>
							</tr>
							 <tr>
							<td width="120">Name </td>
							<td><?php print $name_pop; ?></td>
							</tr>
						  <tr>
							<td>User Id</td>
							<td><?php print $payee_username_pop; ?></td>
							</tr>
						  <tr>
							<td>City </td>
							<td><?php print $city_pop; ?></td>
							</tr>
						  <tr>
							<td>Phone No.</td>
							<td><?php print $phone_no_pop; ?></td>
							</tr>
						  <tr>
							<td>Sponsor Name</td>
							<td><?php print $real_par_name_pop; ?></td>
						  </tr>
							<?php
							
						}
						$nxts = $real_p_pop;
					}	?>
				</table>
				</div>	
				</td>
				<td style="background:#fdfbdc; border-color:#645f10; font-size:12px;" class="table_data"><?php print $email_acc; ?></td>
				<td style="background:#fdfbdc; border-color:#645f10; font-size:12px;" class="table_data"><?php print $phone_no_acc; ?></td>
				<td style="background:#fdfbdc; border-color:#645f10; font-size:12px;" class="table_data"><?php print $bank_acc; ?></td>
				<td style="background:#fdfbdc; border-color:#645f10; font-size:12px;" class="table_data"><?php print $ac_no_acc; ?></td>
				<td style="background:#fdfbdc; border-color:#645f10; font-size:12px;" class="table_data"><?php print $bank_code; ?></td>
				<td style="background:#fdfbdc; line-height:18px; border-color:#645f10; font-size:12px;" class="table_data">
					<a id="trigger-rec<?php print $tr; ?>" style="cursor:pointer;"><?php print $payment_receipt; ?></a><br />Mouse Over
					<div id="pop-up-rec<?php print $tr; ?>" class="css_popup_rec"> 	 
					<table class="MyTable" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse; margin:6px;" cellpadding="0" cellspacing="0" width="95%" >
						<tr>
							<td align="center" height="25" colspan="2" style="padding-left:0px;" bgcolor="#B8C8DC"><strong>Payment Receipt</strong></td>
						</tr>
						<tr>
							<td width="120">Receipt No. </td>
							<td><?php print $payment_receipt; ?></td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">
							<img src="payment_receipt/<?php print $payment_receipt; ?>.jpg"  height="370" width="640" />
							</td>
						</tr>
					</table>
					</div>		  
				</td>
				<td style="background:#fdfbdc; border-color:#645f10; font-size:12px;" class="table_data"><?php print $amount; ?></td>
	<?php 			$jcd++;
		} ?>
		</table>
		</div>
	</div>
	<?php
	}  ?>
	
	
	<!--Second Box End-->	
	<!--Third Box Start-->
	
	<?php
	$que = mysql_query("select * from income_transfer where mode = 1 and paying_id = '$user_id' " );
	$num = mysql_num_rows($que);
	if($num > 0)
	{ ?>
		<div class="fullwidth_box5">
		<div style="background:#999999; border-bottom:1px solid #333333;">
			<h4 style="padding-left:20px;">Payment Status</h4>
		</div>
		<div style="font-size:10pt; line-height:25px; padding-left:15px; margin-top:10px;">
		<table width="865" border="0" cellspacing="2" cellpadding="0" style="font-style:normal;">
		<tr>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">User Id</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">E-mail</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Phone No.</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Bank Name</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">A/c No.</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">IFSC Code.</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Amount</td>
		<td style="background:#57904c; border-color:#116F47;" class="table_head">Status</td>
		</tr>
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
			
			   <tr>
				<td style="background:#f3e6f8; border-color:#502a5e; font-size:12px;" class="table_data"><?php print $payee_username; ?></td>
				<td style="background:#f3e6f8; border-color:#502a5e; font-size:12px;" class="table_data"><?php print $email; ?></td>
				<td style="background:#f3e6f8; border-color:#502a5e; font-size:12px;" class="table_data"><?php print $phone_no; ?></td>
				<td style="background:#f3e6f8; border-color:#502a5e; font-size:12px;" class="table_data"><?php print $bank; ?></td>
				<td style="background:#f3e6f8; border-color:#502a5e; font-size:12px;" class="table_data"><?php print $ac_no; ?></td>
				<td style="background:#f3e6f8; border-color:#502a5e; font-size:12px;" class="table_data"><?php print $bank_code; ?></td>
				<td style="background:#f3e6f8; border-color:#502a5e; font-size:12px;" class="table_data"><?php print $amount; ?></td>
				<td style="width:100px; background:#f3e6f8; border-color:#502a5e; text-align:center; font-size:12px;" class="table_data"> Pending</td>
			  </tr>
	<?php 	} ?>
		</table>
	</div>
	</div>
	
	<?php
	}  ?>
	
	<!--Third Box End-->	
	<!-- Four Box Start-->
	<?php
	
	$que = mysql_query("select * from income_transfer where mode = 0 and user_id = '$user_id' " );
	$num = mysql_num_rows($que);
	if($num > 0)
	{ ?>
		<div class="fullwidth_box6">
		<div style="background:#999999; border-bottom:1px solid #333333;">
			<h4 style="padding-left:20px;">Income Information</h4>
		</div>
		<div style="font-size:10pt; line-height:25px; padding-left:15px; margin-top:10px;">
		<table width="865" border="0" cellspacing="2" cellpadding="0" style="font-style:normal;">
		  <tr>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">User Id</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">User Name</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Sponsor Name</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Phone No.</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Amount</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Date</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Last Date</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Pay Code</td>
			<td style="background:#57904c; border-color:#116F47;" class="table_head">Status</td>
		  </tr>
	
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
				$real_parent = get_full_name($rrr['real_parent']);
			} ?>
		   <tr>
			<td style="background:#e7f8f3; border-color:#22493d; font-size:12px;" class="table_data"><?php print $payee_username; ?></td>
			<td style="background:#e7f8f3; border-color:#22493d; font-size:12px;" class="table_data"><?php print $name; ?></td>
			<td style="background:#e7f8f3; border-color:#22493d; font-size:12px;" class="table_data"><?php print $real_parent; ?></td>
			<td style="background:#e7f8f3; border-color:#22493d; font-size:12px;" class="table_data"><?php print $phone_no; ?></td>
			<td style="background:#e7f8f3; border-color:#22493d; font-size:12px;" class="table_data"><?php print $amount; ?></td>
			<td style="background:#e7f8f3; border-color:#22493d; font-size:12px;" class="table_data"><?php print $inv_date; ?></td>
			<td style="background:#e7f8f3; border-color:#22493d; font-size:12px;" class="table_data"><?php print $lastd_date; ?></td>
			<td style="background:#e7f8f3; border-color:#22493d; font-size:12px;" class="table_data"><?php print $pay_code; ?></td>
			<td style="background:#e7f8f3; border-color:#22493d; text-align:center; width:90px; padding-left:0px;" class="table_data">Comming</td>
			</tr>
	<?php	}  ?>
	</table>
	</div>
	</div>
	<?php
	} 
}	
 ?>
<!--Four Box End-->

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
	
    <script type="text/javascript"> 
      $(function() {
        var moveLeft = 20;
        var moveDown = -150;
		<?php for($tr = 1; $tr <= $total_pay_row; $tr++)
		{ ?>
		$('a#trigger<?php print $tr; ?>').hover(function(e) {
          $('div#pop-up<?php print $tr; ?>').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() { 
          $('div#pop-up<?php print $tr; ?>').hide();
        });
        
        $('a#trigger<?php print $tr; ?>').mousemove(function(e) {
          $('div#pop-up<?php print $tr; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
		
		<?php } ?>
      });
	  
	</script>
	
	 <script type="text/javascript"> 
      $(function() {
         var moveLeft = -350;
         var moveDown = -470;
		<?php for($rcp = 1; $rcp <= $numm; $rcp++)
		{ ?>
		$('a#trigger-rec<?php print $rcp; ?>').hover(function(e) {
          $('div#pop-up-rec<?php print $rcp; ?>').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() { 
          $('div#pop-up-rec<?php print $rcp; ?>').hide();
        });
        
        $('a#trigger-rec<?php print $rcp; ?>').mousemove(function(e) {
          $('div#pop-up-rec<?php print $rcp; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
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

	
