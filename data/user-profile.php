<?php
session_start();
include('condition.php');
include("function/setting.php");
include("function/send_mail.php");
include("function/functions.php");

$id = $_SESSION['ebank_user_id'];

$title = 'Display';
$message = 'Display Profile';
data_logs($id,$title,$message,0);

$query = mysql_query("SELECT * FROM users WHERE id_user = '$id'");
while($row = mysql_fetch_array($query))
{
	$f_name = $row['f_name'];
	$l_name = $row['l_name'];
	$gender = $row['gender'];
	$age = $row['dob'];
	$email = $row['email'];
	$phone = $row['phone_no'];
	$city = $row['city'];
	
	$parent_id = get_user_name($row['parent_id']);
	$real_parent = get_user_name($row['real_parent']);
	$pos = $row['position'];
	if($pos == 0)
		$position = "Left Power Leg";
	else
		$position = "Right Power Leg";	
	
	$user_name = $row['username'];
	$step = $row['step'];
	$address = $row['address'];
	$provience = $row['provience'];
	$country = $row['country'];
	$district =$row['district'];
	$state = $row['state'];
	$pan_no = $row['pan_no'];
	
	$ac_no = $row['ac_no'];
	$bank = $row['bank'];
	$branch = $row['branch'];
	$bank_code = $row['bank_code'];
	$beneficiery_name = $row['beneficiery_name'];
	$account_type = $row['account_type'];
	
} ?>
	
<table id="example2" class="table table-bordered table-hover">
	<tr>
		<td colspan="3">
			<div class="box-header"><h3 class="box-title"><?=$Sponsor_Details;?></h3></div>
		</td>
	</tr>
	<tr>
		<td><?=$Sponsor_ID;?></td>
		<td><?=$real_parent; ?></td>
	</tr>
	<tr><td colspan="3"><h4><?=$Personal_Details;?></h4></td></tr>
	<tr>
		<td><?=$Name;?></td>
		<td><?=ucfirst($f_name)." ".ucfirst($l_name); ?></td>
	</tr>
	<tr>
		<td><?=$Gender;?></td>
		<td><?php if($gender == 0){print "Male";} else { print "Female";}?></td>
	</tr>
	<tr>
		<td colspan="3">
			<div class="box-header"><h3 class="box-title"><?=$Contact_Details;?></h3></div>
		</td>
	</tr>
	<tr>
		<td><?=$Address;?></td>
		<td><?=$address; ?></td>
	</tr>
	<tr>
		<td><?=$City;?></td>
		<td><?=$city; ?></td>
	</tr>
	<tr>
		<td><?=$District;?></td>
		<td><?=$district; ?></td>
	</tr>
	<tr>
		<td><?=$State;?></td>
		<td><?=$state; ?></td>
	</tr>
	<tr>
		<td><?=$Country;?></td>
		<td><?=$country; ?></td> 
	</tr> 
	<tr>
		<td><?=$mob_no;?></td>
		<td><?=$phone; ?></td> 
	</tr> 
	<tr>
		<td><?=$e_mail;?></td>
		<td><?=$email; ?></td>
	</tr>
	<tr>
		<td colspan="3">
			<div class="box-header"><h3 class="box-title"><?=$Bank_Details;?></h3></div>
		</td>
	</tr>
	<tr>
		<td><?=$Beneficiery_Name;?></td>
		<td><?=$beneficiery_name; ?></td>
	</tr>
	<tr>
		<td><?=$Account_No;?></td>
		<td><?=$ac_no; ?></td>
	</tr>
	<tr>
		<td><?=$Account_Type;?></td>
		<td><?php if($account_type == 0){ print "Savings";} else{print "Current";} ?></td>
	</tr>
	<tr>
		<td><?=$Bank_Name;?></td>
		<td><?=$bank; ?></td>
	</tr>
	<tr>
		<td><?=$Branch_Name;?></td>
		<td><?=$branch; ?></td>
	</tr>
	<tr>
		<td><?=$IFSC_Code;?></td>
		<td><?=$bank_code; ?></td>
	</tr>

	<tr>
		<td><?=$PAN_No;?></td>
		<td><?=$pan_no; ?></td>
	</tr>
</table>
