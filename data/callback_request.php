<?php
session_start();
include("condition.php");
include("function/message.php");
include("function/setting.php");
include("function/functions.php");
include("function/send_mail.php");

$user_id = $_SESSION['ebank_user_id'];
?>

<h2 align="left">Admin Support</h2>	
<?php
if(isset($_POST['submit']))
{ 
	$title = $_REQUEST['title'];
	$message = $_REQUEST['message'];
		$q = mysql_query("select * from admin ");
		while($r = mysql_fetch_array($q))
		{
			$message_to = $r['email'];
		}
		$full_message = "Message :".$message."<br><br> From : ".$_SESSION['ebank_user_name'];
		$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $message_to, $title, $full_message);
		$SMTPChat = $SMTPMail->SendMail();
		
		/*$msg_to = get_new_user_id($message_to);
		request_message($id,$title,$message,$msg_to);
		$position = get_user_position($id);
		data_logs($id,$position,$data_log[7][7],$data_log[6][1],$log_type[6]);*/
		$title = 'Message';
		$message = 'Message E-mailed To Admin';
		data_logs($user_id,$title,$message,0);
		print "Message send successfully!";
}
else
{				
?>

<table border="0">
<form name="message" action="index.php?page=callback_request" method="post">
  <tr>
    <td class="form_label"><strong>Title</strong></td>
    <td><textarea name="title" style="height:20px; width:400px">
		</textarea>
	</td>
  </tr>
  <tr>
    <td class="form_label" valign=top><strong>Message</strong></td>
    <td class="form_data"><textarea name="message"  style="height:175px; width:400px">
		</textarea>
	</td>
  </tr>
  <tr>
    <td align="right" colspan="2"><input type="submit" value="Send" name="submit" class="btn btn-info"/></td>
  </tr>
</table>

<?php  }  ?>

