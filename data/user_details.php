<?php
include 'function/functions.php';

$get_user = $_REQUEST['val'];
$sql = "select 
		t1.f_name as t1_f , t1.l_name as t1_l ,t1.email as t1_mail , t1.phone_no as t1_phone , 
		t1.username as t1_username ,t1.country as t1_country , t1.beneficiery_name as t1_ben_name ,
		t1.ac_no as t1_ac_no , t1.bank as t1_bank , t1.branch as t1_branch , t1.bank_code as t1_b_code ,
		t1.alert_email as t1_skype, t1.real_parent as t1_real_parent ,

		t2.f_name as t2_f , t2.l_name as t2_l ,t2.email as t2_mail , t2.phone_no as t2_phone , 
		t2.username as t2_username ,t2.country as t2_country , t2.beneficiery_name as t2_ben_name ,
		t2.ac_no as t2_ac_no , t2.bank as t2_bank , t2.branch as t2_branch , t2.bank_code as t2_b_code ,
		t2.alert_email as t2_skype      	
		from users as t1 inner join users as t2 on t1.real_parent = t2.id_user and t1.username = '$get_user' ";
?>
<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info">
<?php 
$query = mysql_query($sql);

	while($row = mysql_fetch_array($query))
	{
	 	$real_pearent_id = $row['t1_real_parent'];
		$username = $row['t1_username'];
		$name = $row['t1_f'].' '.$row['t1_l'];
		$email = $row['t1_mail'];
		$phone = $row['t1_phone'];
		$country = $row['t1_country'];
		$beneficiery_name = $row['t1_ben_name'];
		$ac_no = $row['t1_ac_no'];
		$bank = $row['t1_bank'];
		$branch = $row['t1_branch'];
		$bank_code = $row['t1_b_code'];
		$skype = $row['t1_skype'];
		$spons_name = get_user_name($real_pearent_id);
	}

?>
	<tr><td>Sponsor Name : </td><td><?=$spons_name;?> </td></tr>
	<tr><td>User Name : </td><td><?=$username;?> </td></tr>
	<tr><td>Full Name : </td><td><?=$name;?> </td></tr>
	<tr><td>Email : </td><td><?=$email;?> </td></tr>
	<tr><td>Phone No : </td><td><?=$phone;?> </td></tr>
	<tr><td>Country : </td><td><?=$country;?> </td></tr>
	<tr><td>Bank : </td><td><?=$bank;?> </td></tr>
	<tr><td>Branch : </td><td><?=$branch;?> </td></tr>
	<tr><td>Beneficiery Name : </td><td><?=$beneficiery_name;?> </td></tr>
	<tr><td>A/c No: </td><td><?=$ac_no;?> </td></tr>
	<tr><td>Bank Code: </td><td><?=$bank_code;?> </td></tr>
	<tr><td>Skype: </td><td><?=$skype;?> </td></tr>
</table>