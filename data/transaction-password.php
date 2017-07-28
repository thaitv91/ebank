<?php
session_start();
include("condition.php");
include("function/setting.php");
include("function/functions.php");
include("function/send_mail.php");

$user_id = $_SESSION['ebank_user_id'];
if(isset($_POST['submit']))
{
	$old_tr_pass = $_POST['old_tr_pass'];
	$que = mysql_query("select * from users where user_pin = '$old_tr_pass' and id_user = '$user_id' ");
	$chk_num = mysql_num_rows($que);
	if($chk_num > 0)
	{
		$title = 'Regenerate';
		$message = 'Regenerate Transaction Password';
		data_logs($user_id,$title,$message,0);
		
		$user_pin = mt_rand(100000, 999999);
		mysql_query("update users set user_pin = '$user_pin' where id_user = '$user_id' ");
		
		$title = "Transaction Password generate message";
		$to = get_user_email($user_id);
		$username = $_SESSION['ebank_user_name'];
		$db_msg = $user_pin_generate_message;
		include("function/full_message.php");
		$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);
		$SMTPChat = $SMTPMail->SendMail();
		
		print "<strong>Success : Transaction Password Regenerate Successfully !!</strong>";
	}
	else
	{
		print "<font color=red><strong>Error : Enter Correct Transaction Password !</strong></font>";
	}	
}
else
{ 
?>
	<form name="user_pin_form" action="index.php?page=transaction-password" method="post" >
	<table class="table table-bordered table-hover">
		<thead><tr><th class="align-left" colspan="2">Transaction Password</th></tr></thead>	
		<tr>
			<td colspan="2" style="font-size:14px; color:#CC0000; font-weight:bold;">
				Regenerate Transaction Password
			</td>
		</tr>
		<tr class="even">
			<td><strong>Old Password</strong></td>
			<td><input type="text" name="old_tr_pass"  /> </td>
		</tr>
		<tr>
			<td colspan="2" class="text-center">
			<input type="submit" name="submit" value="Generate" class="btn btn-info" />
			</td>
		</tr>
	</table>
	</form>
<?php 
} ?>