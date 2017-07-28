<?php
include("function/functions.php");
$id = $_SESSION['ebank_user_id'];

if(isset($_SESSION['msg_com']))
{
	echo $_SESSION['msg_com'];
	unset($_SESSION['msg_com']);
}

if(isset($_POST['submit']))
{ 
	$title = $_REQUEST['title'];
	$message = $_REQUEST['message'];
	$send_to = $_REQUEST['send_to'];
	$time = $systems_date_time;
	
	$send_to = get_new_user_id($send_to);
	$real_par = real_parent($send_to);
	
	$sql = "Select username from users where id_user = '$send_to' and id_user != '$id'";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num == 1)
	{
		if($real_par == $id)
		{
			mysql_query("INSERT INTO message (id_user , receive_id , title,message,message_date,time) 
			VALUES ('$id' , '$send_to' , '$title' , '$message' , '$systems_date' , '$time')");
		
			$_SESSION['msg_com'] = "<B style=\"color:#008000;\">Message send successfully!</B>";
						
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=compose_all\"";
			echo "</script>";
		}
		else
		{ echo "<B style=\"color:#FF0000; font-size:14px;\">Please Enter Your Downline username !!</B>"; }
	}
	else
	{ echo "<B style=\"color:#FF0000; font-size:14px;\">Please Enter correct username !!</B>"; }
}

?>
<form name="message" action="" method="post">
<table id="example2" class="table table-bordered table-hover">
	<tr>
		<th>Send To</th>
		<td><input type="text" name="send_to" style="width:390px;" /></td>
	</tr>
	<tr>
		<th>Title</th>
		<td><input type="text" name="title" style="width:390px;" /></td>
	</tr>
	<tr>
		<th>Message</th>
		<td><textarea name="message" cols="60" rows="5"></textarea></td>
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" name="submit" value="Send Message" class="btn btn-success"/>
		</td>
	</tr>
</table>
</form>


