<?php
include("condition.php");
include("../function/setting.php");
include("../function/e_pin.php");
include("../function/functions.php");
include("../function/sendmail.php");

$sys_limit = epin_per_day_limit();
$tot_epin_day = tot_epin_generate_day($systems_date);
if(isset($_POST['submit']))
{
	$total_epin = $tot_epin_day + $_POST['epin_number']; 
	if($tot_epin_day >= $sys_limit and $total_epin >= $sys_limit)
	{ echo "<B style=\"color:#ff0000;\">Today E-pin Limit is Over !!</B>"; }
	else
	{
		if($_SESSION['generate_pin_for_user'] == 1)
		{
			$new_user = $_REQUEST['username'];
			$epin_amount = $_POST['epin_amount'];
			$epin_number = $_POST['epin_number'];
			
			if($epin_amount == 0)
			{
				$amount = $epin_type = 0;
			}	
			else
			{
				$amount = $epin_amount;
				$epin_type = 1;
			}	
			
			$q = mysql_query("select * from users where username = '$new_user' ");
			$num = mysql_num_rows($q);
			if($num != 0)
			{
				while($row = mysql_fetch_array($q))
				{
					$new_user_id = $row['id_user'];
				}
				$epin = "$epin_number E-pin ";
				for($ii = 0; $ii < $epin_number; $ii++)
				{
					do
					{
						$unique_epin = mt_rand(1000000000, 9999999999);
						$query = mysql_query("select * from e_pin where epin = '$unique_epin' ");
						$num = mysql_num_rows($query);
					}while($num > 0);
					
					$mode = 1;
					$date = date('Y-m-d');
					$t = date('h:i:s');
					mysql_query("insert into e_pin (epin,amount,user_id , mode , time , date , plan_id) 
					values ('$unique_epin' ,'$epin_amount', '$new_user_id' , '$mode' , '$t' , '$date' , 0)");
					
					$epin .= $unique_epin."<br>";
				}
				$epin_generate_username = "rapidforx2";
				$epin_amount = $fees;
				$payee_epin_username = $mew_user;
				//$title = "E-pin mail";
				//$to = get_user_email($new_user_id);
				$from = 0;
				
				$db_msg = $epin_generate_message;
				
				
				//send mail
				$sender_username = get_user_name($new_user_id);
				$to = get_user_email($new_user_id);
				$title = $epin_number.' e-PINs have been added to your account.';
				$contentmail = $epin_number.' e-PINs have been added to your account. Please log in to do a PH to help the community.';
				$message = contentEmail($sender_username, $contentmail);
				$send_mail = sendmail($to, $title, $message);
				
				//include("../function/full_message.php");
					
				//$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);
				//$SMTPChat = $SMTPMail->SendMail();
				print "<B style=\"color:#008000;\">E pin generated Successfully !</B>";	
				$_SESSION['generate_pin_for_user'] = 0;	
			}
			else { echo "<B style=\"color:#ff0000;\">Enter Correct Username !!</B>"; }	
		}
		else{ echo "<B style=\"color:#ff0000;\">There are some conflicts !!</B>"; }
	}
}
else
{  $_SESSION['generate_pin_for_user'] = 1; ?>
<form method="post" action="">
<table class="table table-bordered table-condensed"> 
	<tr>
		<th width="40%">User Id</th>
		<td><input type="text" name="username"  /></td>
	</tr>
	<tr>
		<th>No of E-pin</th>
		<td><input type="text" name="epin_number"  /></td>
	</tr>
	<!--<tr>
		<th>E-pin Type </th>
		<td>
		<select name="epin_amount" style="width:200px;">
			<option value="0">Registration Epin</option>-->
		<?php
			for($i = $setting_inv_amount; $i <= $setting_inv_amount;$i++ ){?>			
			<input type="hidden" name="epin_amount" value="<?=$i;?>" />
			<!--<option value="<?=$i; ?>"><?=$i." $ ";?></option>--><?php		
			}
		?>				
		<!--</select>
		</td>
	</tr>-->
	<tr>
		<td class="text-center" colspan="2">
			<input type="submit" name="submit" value="Generate" class="btn btn-info" />
		</td>
	</tr>
  </form>
</table>

<?php 
} ?>
