<?php
include('condition.php');
require_once("../config.php");
include("../function/functions.php");

if(isset($_POST['submit']))
{
	$u_name = $_REQUEST[user_name];
	$query = mysql_query("select * from users where username = '$u_name' ");
	$num = mysql_num_rows($query);
	if($num == 0)
	{
		echo "<B style=\"color:#ff0000; font-size:12pt;\">Please Enter right User Name !</B>";
	}
	else
	{
		while($row = mysql_fetch_array($query))
		{
			$f_name = $row['f_name'];
			$l_name = $row['l_name'];
			$gender = $row['gender'];
			$age = $row['dob'];
			$email = $row['email'];
			$phone_no = $row['phone_no'];
			$name = ucfirst($f_name)." ".ucfirst($l_name);
			
			$parent_id = $row['parent_id'];
			$real_parent = $row['real_parent'];
			$position = $row['position'];
			$user_name = $row['username'];
			$step = $row['step'];
			$address = $row['address'];
			$provience = $row['provience'];
			$country = $row['country'];
			$username = $row['username'];
			$password = $row['password'];
			$photo = $row['photo'];
			
			$alert_email = $row['alert_email'];
			$liberty_email = $row['liberty_email']; 
	
			
			$ac_no = $row['ac_no'];
			$bank = $row['bank'];
			$branch = $row['branch'];
			$bank_code = $row['bank_code'];
			$beneficiery_name = $row['beneficiery_name'];
			
			$real_parent = get_user_name($parent_id);
		
		} ?>
		<table class="table table-bordered">
			<thead><tr><th colspan="2">User Information</th></tr></thead>
			<tr>
				<th>Photo </th>
				<td><img src="../images/profile_image/<?=$photo; ?>" width="100" height="100" /></td>
			</tr>
			<tr><th>Name</th>				<td><?=$name;?></td></tr>
			<!--<tr><td>Address</td>			<td><?=$address;?></td></tr>-->
			<tr><th>Gender</th>				<td><?=$gender;?></td></tr>
			<!--<tr><td>Age</td>				<td><?=$age;?></td></tr>-->
			<tr><th>E-Mail</th>				<td><?=$email;?></td></tr>
			<tr><th>Phone Number</th>		<td><?=$phone_no;?></td></tr>
			<!--<tr><td>City</td>				<td><?=$city;?></td></tr>
			<tr><td>Provience</td>			<td><?=$provience;?></td></tr>
			<tr><td>Country</td>			<td><?=$country;?></td></tr>
			<tr><td>Alert</td>				<td><?=$alert_email;?></td></tr>
			<tr><td>Liberty</td>			<td><?=$liberty_email;?></td></tr>-->
			<tr><th>Username</th>			<td><?=$username;?></td></tr>
			<tr><th>Password</th>			<td><?=$password;?></td></tr>
			<tr><th>Beneficiery Name</th>	<td><?=$beneficiery_name;?></td></tr>
			<tr><th>A/C No.</th>			<td><?=$ac_no;?></td></tr>
			<tr><th>Bank Name</th>			<td><?=$bank;?></td></tr>
			<tr><th>Branch</th>				<td><?=$branch;?></td></tr>
			<tr><th>IFSC Code</th>			<td><?=$bank_code;?></td></tr>
			<tr><th>Refferal Link</th>		<td><?=$refferal_link."/".$user_name;?></td></tr>
			<tr><th>My Sponsor</th>			<td><?=$real_parent;?></td></tr>
			<!--<tr><td>Spill Sponsor</td>		<td><?=$bank_code;?></td></tr>
			<tr><td>Parent Leg</td>			<td><?=$position;?></td></tr>
			<tr><td>User Name</td>			<td><?=$user_name;?></td></tr>-->
			
		</table>
	<?php	
	}	
}	
else
{ ?> 
<form name="my_form" action="index.php?page=user_profile" method="post">
<table class="table table-bordered">
	<thead><tr><th colspan="2">User Information</th></tr></thead>
	<tr>
		<td>Enter Member UserName</td>
		<td><input type="text" name="user_name" /></td>
  </tr>
  <tr>
    <td class="text-center" colspan="2">
		<input type="submit" name="submit" value="Submit" class="btn btn-info" />
	</td>
  </tr>
</table>
</form>
<?php  
}  ?>
