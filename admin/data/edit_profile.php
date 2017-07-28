<?PHP
session_start();
include("condition.php");
require_once "../function/formvalidator.php";
include("../function/setting.php");
include("../function/functions.php");

if(isset($_POST['submit']))
{
	if($_POST['submit'] == 'Submit')
	{
		$u_name = $_REQUEST[user_name];
		$query = mysql_query("select * from users where username = '$u_name' ");
		$num = mysql_num_rows($query);
		if($num == 0)
		{
			echo "<B style=\"color:#ff0000;\">Please Enter right User Name !</B>";
		}
		else
		{
			while($row = mysql_fetch_array($query))
			{
				$id_user = $row['id_user'];
				$f_name = ucfirst($row['f_name']);
				$l_name = ucfirst($row['l_name']);
				$gender = $row['gender'];
				$dob = $row['dob'];
				$phone = $row['phone_no'];
				$city = $row['city'];
				$mg = $_REQUEST['mg'];
				$country = $row['country'];
				$provience = $row['provience'];
				
				$username = $row['username'];
				$password = $row['password'];
				
				$email = $row['email'];
				$address = $row['address'];
				$alert_email = $row['alert_email'];
				$liberty_email = $row['liberty_email'];
				$ac_no = $row['ac_no'];
				$bank = $row['bank'];
				$branch = $row['branch'];
				$bank_code = $row['bank_code'];
				$beneficiery_name = $row['beneficiery_name'];
				$parent_id = $row['real_parent'];
			}
?>
		<form name="register" action="index.php?page=edit_profile" method="post" id="commentform">
		<input type="hidden" name="user_id" value="<?=$id_user;?>"  />	
		<table class="table table-bordered">
			<thead><tr><th colspan="2">User Information</th></tr></thead>
			<tr>
				<td>First Name</td>			
				<td><input type="text" name="f_name" value="<?=$f_name;?>" required/></td>
			</tr>
			<tr>
				<td>Last Name</td>			
				<td><input type="text" name="l_name" value="<?=$l_name;?>" required/></td>
			</tr>
			<tr>
				<td>Gender</td>			
				<td>
					<input type="radio" name="gender" value="male" <?php if($gender == 'male') { ?>  checked="checked" <?php } ?> /> <B>Male</B>
					<input type="radio" name="gender" value="female" <?php if($gender == 'female') { ?>  checked="checked" <?php } ?>  /> <B>Female</B>
				</td>
			</tr>
			<!--<tr>
				<td>Date of Birth</td>			
				<td><input type="text" name="dob" value="<?=$dob;?>" /></td>
			</tr>
			<tr>
				<td>Address</td>			
				<td><input type="text" name="address" value="<?=$address;?>" /></td>
			</tr>
			<tr>
				<td>City</td>			
				<td><input type="text" name="city" value="<?=$city;?>" /></td>
			</tr>
			<tr>
				<td>Provience</td>			
				<td><input type="text" name="provience" value="<?=$provience;?>" /></td>
			</tr>
			<tr>
				<td>Country</td>			
				<td><input type="text" name="country" value="<?=$country;?>" /></td>
			</tr>-->
			<tr>
				<td>Phone No.</td>			
				<td><input type="text" name="phone" value="<?=$phone;?>" required/></td>
			</tr>
			<tr>
				<td>E-mail</td>			
				<td><input type="text" name="email" value="<?=$email;?>" required/></td>
			</tr>
			<!--<tr>
				<td>Alert</td>			
				<td><input type="text" name="alert_email" value="<?=$alert_email;?>" /></td>
			</tr>
			<tr>
				<td>Liberty</td>			
				<td><input type="text" name="liberty_email" value="<?=$liberty_email;?>" /></td>
			</tr>
			<tr>
				<td>Username</td>			
				<td><input type="text" name="username" value="<?=$username;?>" /></td>
			</tr>-->
			<tr>
				<td>Password</td>			
				<td><input type="text" name="password" value="<?=$password;?>" required/></td>
			</tr>
			<tr>
				<td>Beneficiery Name</td>			
				<td><input type="text" name="beneficiery_name" value="<?=$beneficiery_name;?>" required /></td>
			</tr>
			<tr>
				<td>A/C No.</td>			
				<td><input type="text" name="ac_no" value="<?=$ac_no;?>" required/></td>
			</tr>
			<tr>
				<td>Bank Name</td>			
				<td><input type="text" name="bank" value="<?=$bank;?>" required/></td>
			</tr>
			<tr>
				<td>Branch</td>			
				<td><input type="text" name="branch" value="<?=$branch;?>" required/></td>
			</tr>
			<tr>
				<td>IFSC Code</td>			
				<td><input type="text" name="bank_code" value="<?=$bank_code;?>" /></td>
			</tr>
			<tr>
				<td colspan="2" class="text-center">
					<input type="submit" name="submit" value="Update" class="btn btn-info"/>
				</td>
			</tr>
		</table>
		</form>	
<?php					
		}
	}		
	elseif($_POST['submit'] == 'Update')
	{

		// $validator = new FormValidator();
		// $validator->addValidation("f_name","req","Please fill in First Name");
		// $validator->addValidation("l_name","req","Please fill in Last Name");
		// $validator->addValidation("dob","req","Please fill Date of Birth");
		// $validator->addValidation("gender","req","Please fill in Gender");
		// $validator->addValidation("address","req","Please fill in Address");
		// $validator->addValidation("city","req","Please fill City");
		// $validator->addValidation("provience","req","Please fill in Provience");
		// $validator->addValidation("country","req","Please fill in Country");
		// $validator->addValidation("phone","req","Please fill in Phone");
		//var_dump($validator->ValidateForm()); exit;
		//if($validator->ValidateForm())
		//{
			$id = $_POST['user_id'];
			$f_name = $_POST['f_name'];
			$l_name = $_POST['l_name'];
			$gender = $_POST['gender'];
			$phone_no = $_POST['phone'];

			$email = $_POST['email'];
			$password = $_POST['password'];
				
			$ac_no = $_POST['ac_no'];
			$bank = $_POST['bank'];
			$branch = $_POST['branch'];
			$bank_code = $_POST['bank_code'];
			$beneficiery_name = $_POST['beneficiery_name'];
			
			
			$insert_q = mysql_query("UPDATE users SET f_name = '$f_name', l_name = '$l_name', gender = '$gender', phone_no = '$phone_no', email = '$email' , password = '$password' , ac_no = '$ac_no', bank = '$bank', branch = '$branch', bank_code = '$bank_code' , beneficiery_name = '$beneficiery_name'  WHERE id_user = '$id'");
			
			$date = date('Y-m-d');
			$username = get_user_name($id);
			$updated_by = $username." Your self";
			include("../function/logs_messages.php");
			data_logs($id,$data_log[1][0],$data_log[1][1],$log_type[1]);
			echo "<B style=\"color:#008000; font-size:12pt;\">Successfully Updated</B>";
			
		//}	
		// else
		// {
		// 	echo "<B>Validation Errors:</B>";
		// 	$error_hash = $validator->GetErrors();
		// 	foreach($error_hash as $inpname => $inp_err)
		// 	{
		// 		echo "<p>$inpname : $inp_err</p>\n";
		// 	}        
		// }	
	}
}	
else
{ ?> 
<form name="my_form" action="index.php?page=edit_profile" method="post">
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
<?php  }  ?>

