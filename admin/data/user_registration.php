<?php
session_start();

require_once("../config.php");
	include("../function/setting.php");
	include("../function/functions.php");
	include("../function/virtual_parent.php");
	include("../function/best_position.php");
	include("../function/send_mail.php");
	include("../function/e_pin.php");
	require_once("../function/country_list.php");
	include("../function/income.php");
include("../function/insert_into_wallet.php");
include("../function/check_income_condition.php");
include("../function/direct_income.php");

include("../function/pair_point_calculation.php");

	require_once("../validation/validation.php"); 
	?>
<h2 align="left">User Registration Panel</h2> <p></p>
<?php

if(isset($_POST['submit']))
{
	$reg_position = $_REQUEST['position'];
	$epin = $_REQUEST['reg_epin'];
	$real_parent = $_REQUEST['real_perent_id'];
	$registration_product = $_REQUEST['registration_product'];
	$f_name =$_POST['f_name']; 
	$m_name =$_POST['m_name'];
	$l_name =$_POST['l_name'];
	$gender =$_POST['gender'];
	$country =$_POST['country'];
	$email =$_POST['email'];
	$phone =$_POST['phone'];
	$username = $_POST['username'];
	$password =$_POST['password'];
	$re_password =$_POST['re_password'];
	$date = $systems_date; //date('Y-m-d');
	$bank = $_POST['bank'];
	$bank_code =$_POST['bank_code'];
	$beneficiery_name = $_POST['beneficiery_name'];
	$ac_no =$_POST['ac_no'];
	$ifsc_code =$_POST['ifsc_code'];
	$branch = $_POST['branch'];
	$pan_no = $_POST['pan_no'];
	$pin_code = $_POST['pin_code'];
	$district =$_POST['district'];
	$state = $_POST['state'];
	$nominee =$_POST['nominee'];
	$relation = $_POST['relation'];
	$pin_code = $_POST['pin_code'];
	$mobile_no = $_POST['mobile'];
	$ge_currency =$_POST['ge_currency'];
	$liberty =$_POST['liberty'];
	$state =$_POST['state'];
	$address =$_POST['address'];
	$city =$_POST['city'];
	$dob =$_POST['dob'];
	$placement_username = $_POST['placement_username'];

	$id_query = mysql_query("SELECT * FROM users WHERE username = '$real_parent' ");
	$num = mysql_num_rows($id_query);
	if($num == 0)
	{
		$error_sponsor = "<font color=\"#FF0000\" size=\"2\"><center>Please enter correct Sponsor Id !</center></font>";
	}
	else
	{
		while($row = mysql_fetch_array($id_query))
		{
			$real_p = $real_parent_id = $_SESSION['rbhgrocery_real_parent_id'] = $row['id_user'];
		}
		

			//$id_query = mysql_query("SELECT * FROM users WHERE pan_no = '$pan_no' ");
			$num = 0;  //mysql_num_rows($id_query);
			if($num > 0)
			{
				$error_pan_no = "<font color=\"#FF0000\" size=\"2\"><center>PAN Number alerady Store !</center></font>";
			}
			else
			{
				
				if(!validateName($_POST['f_name']) || !validateLname($_POST['l_name']) || !validateName($_POST['city']) || !validateMessage($_POST['address']) || !validateName($_POST['district']) || !validateName($_POST['state']) || !validatePhone($_POST['phone']) || !validateName($_POST['pan_no']) || !validateEmail($_POST['email']) || !validateUsername($_POST['username']) || !validatePasswords($_POST['password'], $_POST['re_password']))
				{ ?>  
						<div id="error">  
						 <ul>  
							
						
						<?php if(!validatePhone($_POST['phone'])):  
							$error_phone = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Phone No:</center></font>";
						endif?> 
						<?php 
							if(!validateUsername($_POST['username'])):  
								$error_username = "<font color=\"#FF0000\" size=\"2\"><center>Please Enter Username:</center></font>"; 
							endif?>
						<?php 
							//if(!validateCountry($_POST['country'])):  
								//$error_country = "<font color=\"#FF0000\" size=\"2\"><center>Please Enter Country:</center></font>"; 
							//endif?>
						<?php 
							if(!validateEmail($_POST['email'])):  
								$error_email = "<font color=\"#FF0000\" size=\"2\"><center>Invalid E-mail:</center></font>";  
							endif?>  
						<?php 
							if(!validateMessage($_POST['address'])):
								$error_address = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Address:</center></font>";
						endif?> 
						<?php 
							/*if(!validateName($_POST['beneficiery_name'])):
								$error_beneficiery_name = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Beneficiery Name !</center></font>";
							endif*/?>  
						<?php 
							/*if(!validateName($_POST['ac_no'])):
								$error_ac_no = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Account No. !:</center></font>";
							endif*/?>  
						<?php 
							/*if(!validateName($_POST['bank_code'])):
								$error_bank_code = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Branch Cade !</center></font>";
							endif*/?>  
						<?php 
							/*if(!validateName($_POST['branch'])):
								$error_branch = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Branch Name !</center></font>";
							endif*/?>  
						<?php 
							if(!validateName($_POST['pan_no'])):
								$error_pan_no = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Pan No !</center></font>";
							endif?>  
							
						<?php 
							/*if(!validateName($_POST['bank'])):
								$error_bank = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Bank Name !</center></font>";
							endif*/?>  		
							
						<?php 
							if(!validateName($_POST['city'])):
								$error_city = "<font color=\"#FF0000\" size=\"2\"><center>Invalid City :</center></font>";
							endif?>  	
						<?php 
							if(!validateName($_POST['f_name'])): 
								$error_f_name = "<font color=\"#FF0000\" size=\"2\"><center>Invalid First Name:</center></font>";
						    endif?> 
						<?php 
							if(!validateLname($_POST['l_name'])):  
								$error_l_name = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Last Name:</center></font>";
							endif?> 
						<?php 
							if(!validateName($_POST['state'])): 
								$error_state = "<font color=\"#FF0000\" size=\"2\"><center>Invalid State Name:</center></font>";
						    endif?> 
						<?php 
							if(!validateLname($_POST['district'])):  
								$error_district = "<font color=\"#FF0000\" size=\"2\"><center>Invalid District Name:</center></font>";
							endif?> 	
						<?php if(!validatePasswords($_POST['password'], $_POST['re_password'])):  
								$error_password = "<font color=\"#FF0000\" size=\"2\"><center>Passwords are invalid:</center></font>";
							endif?>	 
								
						</ul>  
						</div>  
		   <?php 
				}
				else
				{
					$type = "B";
					$reg_position = $_POST['reg_position'];
					$f_name =$_POST['f_name'];
					$m_name =$_POST['m_name'];
					$l_name =$_POST['l_name'];
					$user_name = $f_name." ".$l_name;
					$dob =$_POST['dob'];
					$gender =$_POST['gender'];
					$address =$_POST['address'];
					$city =$_POST['city'];
					$provience =$_POST['provience'];
					$country =$_POST['country'];
					$email =$_POST['email'];
					$phone =$_POST['phone'];
					
					$alert = $_POST['alert'];
					$liberty =$_POST['liberty'];
					$re_password =$_POST['re_password'];
					$date = $systems_date; //date('Y-m-d');
					$reg_mode =$_POST['reg_mode'];
					$reg_amount = $_SESSION['registration_amount'];	
					$number =2;
					
					$provience =$_POST['provience'];
					$country =$_POST['country'];
					$email =$_POST['email'];
					$phone =$_POST['phone'];
					$country =$_POST['country'];
					$email =$_POST['email'];
					$phone =$_POST['phone'];
					$pan_no = $_POST['pan_no'];
					$district =$_POST['district'];
					$state = $_POST['state'];
					$pincode = $_POST['pincode'];
				
					$user_pin = mt_rand(100000, 999999);
					$ge_currency =$_POST['ge_currency'];
					$liberty =$_POST['liberty'];
					$username = $_POST['username'];
					$account_type = $_POST['account_type'];
					
					$chk = user_exist($username);
					if($chk > 0)
					{
						$error_username = "<font color=\"#FF0000\" size=\"2\"><center>Username Already Used:</center></font>"; 
					}
					else
					{
							$chk_quer = mysql_query("select * from users where real_parent = '$real_p' ");
							$total_real_child = mysql_num_rows($chk_quer);
							
							mysql_query("INSERT INTO users (username,real_parent) VALUES ('$username' , '$real_p') ");
							$real_parent_username_log = get_user_name($real_p);
							
							$query = mysql_query("SELECT id_user FROM users WHERE username = '$username' ");
							while($row = mysql_fetch_array($query))
							{
								$user_id = $row[0];
							}
							insert_wallet();  // inserting in wallet
							
							mysql_query("UPDATE users SET parent_id = '$real_p' , real_parent = '$real_p' , position =  '$total_real_child' , f_name = '$f_name' , l_name = '$l_name' , activate_date = '$date' , email = '$email' , phone_no = '$phone' , password = '$password' , user_pin = '$user_pin' , date = '$date' , type = '$type' , bank = '$bank' , bank_code = '$bank_code' , beneficiery_name = '$beneficiery_name' , ac_no = '$ac_no' , branch = '$branch' , account_type = '$account_type' , pan_no = '$pan_no' , city = '$city' , address = '$address'  , gender = '$gender' , district = '$district' , state = '$state' WHERE id_user = '$user_id' ");


							if($total_real_child == 10)
							{
								mysql_query("update users set type = 'C' where id_user = '$real_p' ");
							}	
								
							$virtual_parent_username = get_user_name($virtual_parent);
							$real_parent_username = get_user_name($real_parent_id);
							if($reg_position == 0) $user_position = "Left Power Leg";
							else $user_position = "Right Power Leg";
							//new registration message
							$title = "new User register";
							$to = $email;
							$db_msg = $email_welcome_message;
							include("../function/full_message.php");
							$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);	
							$SMTPChat = $SMTPMail->SendMail();	
							$user_id = get_new_user_id($username); //newlly entered user id
															
							//insert_child_in_left_right($user_id);
							$par_id = real_par($user_id);
							
							$db_msg = $setting_sms_registration_user;
							include("../function/full_message.php");
							send_sms($phone,$full_message);
														
							$user_id = get_new_user_id($username); //newlly entered user id
							$real_parent_username_log = $real_parent_username;
							include("../function/logs_messages.php");
							data_logs($from,$data_log[3][0],$data_log[3][1],$log_type[2]);

							echo "<script type=\"text/javascript\">";
							echo "window.location = \"index.php?page=message\"";
							echo "</script>";
						}
						
				} 
			}	
	}	
}
  ?>

<table id=table-example class=table width="630" height="700" border="0">  
<form name="form" id="registrarionForm" action="index.php?page=user_registration" method="post"  > 
<tbody>
<tr>
	<td colspan="3" style="color:#002953; font-size:18px; font-weight:bold; text-align:left;">Sponsor Details : </td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="name">Sponsor Id <font color="#FF0000">*</font></label></td>
<td><input style="width:170px;" type="text" name="real_perent_id" class="logininput" value="<?php if($real_parent != "") { print $real_parent; } else { print get_user_name(1); } ?>" /></td>
<td><?php print $error_sponsor; ?></td>
</tr>
<!--<tr>
<td style="padding-left:20px; width:180px; text-align:left; border-right:none;"><label for="name">Placement Id <font color="#FF0000">*</font></label></td>
<td> <input type=text  style="width:170px;" id="name" name="placement_username" value="<?php if($placement_username != "") { print $placement_username;  } else { print get_user_name(1); } ?>" class="logininput" />
</td>
<td><?php print $error_placement_username; ?></td>
</tr>
<tr>
<td width=180 style="padding-left:20px"><label for="name">Position<font color="#FF0000">*</font></label></td>
	<td>
		<select class="logininput" name="reg_position" style="width:172px;">
		<option value="0">Left Power Leg</option>
		<option value="1">Right Power Leg</option>
		</select>	
	</td>
</tr>

<tr>
<td style="padding-left:20px; width:180px; text-align:left; border-right:none;"><label for="name">E-pin <font color="#FF0000">*</font></label></td>
<td> <input type=text  style="width:170px;" id="name" name="reg_epin" value="<?php print $epin; ?>" class="input-medium" />
</td>
<td><?php print $error_reg_epin; ?></td>
</tr>-->
<tr>
	<td colspan="3" style="color:#002953; font-size:18px; font-weight:bold; text-align:left;">Personal Details : </td>
</tr>

<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="name">First Name <font color="#FF0000">*</font></label></td>
<td> <input type=text  style="width:170px;" id="name" name=f_name class="logininput" value="<?php print $f_name; ?>" />
</td>
<td><?php print $error_f_name; ?></td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="l_name"> Last Name <font color="#FF0000">*</font></label></td>
<td> <input type=text  style="width:170px;" id="l_name" name=l_name class="logininput" value="<?php print $l_name; ?>" />
</td>
<td><?php print $error_l_name; ?></td>
</tr>
<!--<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="date">Date of Birth</label></td><td> <input type=text  style="width:170px;" name=dob class="logininput" value="<?php print $dob; ?>" id="datepicker"  /><span id="dateInfo"></td>
<td><?php print $error_dob; ?></td>
</tr>
--><tr>
<td style="padding-left:20px; width:180px; text-align:left;"> Gender <font color="#FF0000">*</font></td>
<td style="text-align:left; padding-left:0px;"><input type="radio" style="width:27px;" name=gender value="male" checked="checked" />&nbsp;Male
<input type="radio" style="width:50px;" name=gender value="female" />&nbsp;Female</td>
<td><?php print $error_gender; ?></td>
</tr>
<tr>
	<td colspan="3" style="color:#002953; font-size:18px; font-weight:bold; text-align:left;">Contact Details : </td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;" valign="top"><label for="message">Address <font color="#FF0000">*</font></label></td>
<td><textarea name=address  class="logininput" id="message" style="height:50px; width:170px" /><?php print $address; ?></textarea><span id="messageInfo"></td>
<td><?php print $error_address; ?></td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="city">City <font color="#FF0000">*</font></label></td><td> <input type=text  style="width:170px;" name="city" id="city" class="logininput" value="<?php print $city; ?>" /><span id="cityInfo"></td>
<td><?php print $error_city; ?></td></tr>
</tr>

<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="city">District <font color="#FF0000">*</font></label></td><td> <input type=text  style="width:170px;" name="district" id="district" class="logininput" value="<?php print $district; ?>" /><span id="cityInfo"></td>
<td><?php print $error_district; ?></td></tr>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="city">State <font color="#FF0000">*</font></label></td><td> <input type=text  style="width:170px;" name="state" id="state" class="logininput" value="<?php print $state; ?>" /><span id="cityInfo"></td>
<td><?php print $error_state; ?></td></tr>
</tr>
<!--<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="country"> Country <font color="#FF0000">*</font></label></td>
<td >
	<select class="logininput" style="width:172px;" name=country >
	<option value="">Select One</option>
	<?php
		$list = count($country_list);
		for($cl = 0; $cl < $list; $cl++)
		{ ?>
			<option value="<?php print $country_list[$cl]; ?>" <?php if($country_list[$cl] == $country) { ?> selected="selected" <?php } ?>><?php print $country_list[$cl]; ?></option>
		<?php } ?>
		</select>
			
</td>
<td><?php print $error_country; ?></td>
</tr>
--><tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="phone"> Phone No. <font color="#FF0000">*</font></label></td>
<td> <input type=text  style="width:170px;" name=phone id="phone" class="logininput" value="<?php print $phone; ?>" />
</td> 
<td><?php print $error_phone; ?></td>
</tr> 
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="email">E-mail <font color="#FF0000">*</font></label></td>
<td> <input type=text  style="width:170px;" id="email" name=email class="logininput" value="<?php print $email; ?>" />
</td>
<td><?php print $error_email; ?></td>
</tr>
<tr>
	<td colspan="3" style="color:#002953; font-size:18px; font-weight:bold; text-align:left;">Login Details : </td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="alerts">Username <font color="#FF0000">*</font></label></td>
<td> <input type=text  style="width:170px;" id="username" name="username" class="logininput" value="<?php print $username; ?>" />
</td>
<td><?php print $error_username; ?></td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="liberty">Password <font color="#FF0000">*</font></label></td>
<td> <input type="password" id="password"  style="width:170px;" name="password" class="logininput" value="<?php print $password; ?>" />
</td>
<td><?php print $error_password; ?></td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="liberty">Confirm Password <font color="#FF0000">*</font></label></td>
<td> <input type="password" id="re_password"  style="width:170px;" name="re_password" class="logininput" value="<?php print $re_password; ?>" />
</td>
<td><?php print $error_re_password; ?></td>
</tr>
<tr>
	<td colspan="3" style="color:#002953; font-size:18px; font-weight:bold; text-align:left;">Bank Details : </td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="alerts">Beneficiery Name <font color="#FF0000"></font></label></td>
<td> <input type=text  style="width:170px;" id="beneficiery_name" name="beneficiery_name" class="logininput" value="<?php print $beneficiery_name; ?>" />
</td>
<td><?php print $error_beneficiery_name; ?></td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="liberty">Account No. <font color="#FF0000"></font></label></td>
<td> <input type=text id="ac_no"  style="width:170px;" name="ac_no" class="logininput" value="<?php print $ac_no; ?>" />
</td>
<td><?php print $error_ac_no; ?></td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="liberty">Account Type <font color="#FF0000"></font></label></td>
	<td>
		<select class="account_type" name="position" style="width:172px;">
		<option value="0">Savings</option>
		<option value="1">Current</option>
		</select>	
	</td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="alerts">Bank Name <font color="#FF0000"></font></label></td>
<td> <input type=text  style="width:170px;" id="bank" name="bank" class="logininput" value="<?php print $bank; ?>" />
</td>
<td><?php print $error_bank; ?></td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="alerts">Branch Name<font color="#FF0000"></font></label></td>
<td> <input type=text  style="width:170px;" id="bank" name="branch" class="logininput" value="<?php print $branch; ?>" />
</td>
<td><?php print $error_branch; ?></td>
</tr>
<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="liberty">IFSC/MIRC Code <font color="#FF0000"></font></label></td>
<td> <input type=text id="bank_code"  style="width:170px;" name=bank_code class="logininput" value="<?php print $bank_code; ?>" />
</td>
<td><?php print $error_bank_code; ?></td>
</tr>

<tr>
<td style="padding-left:20px; width:180px; text-align:left;"><label for="liberty">PAN No. <font color="#FF0000">*</font></label></td>
<td> <input type=text id="ac_no"  style="width:170px;" name="pan_no" class="logininput" value="<?php print $pan_no; ?>" />
</td>
<td><?php print $error_pan_no; ?></td>
</tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr>
<td colspan="3" style="padding-left:150px">
				<input type="submit" name="submit" value="Submit" class="btn btn-info" /> </td></tr>
				<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr><td colspan="3" style="text-align:left; color:#FF0000; font-size:12pt; font-weight:bold;">* Mendatory Fields</td></tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
				</tbody>
				</form>
				</table>


</div>
