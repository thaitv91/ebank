<?php
session_start();
require_once("config.php");
$id = $_SESSION['ebank_user_id'];

if(isset($_POST['submit']))
{ 
	$title = $_REQUEST['title'];
	$message = $_REQUEST['message'];
	$username = $_REQUEST['username'];
	$message_date = date('y-m-d');
	$time = date('Y-m-d H:i:s');
	
	if($title != '')
	{		
		if($username == 'Admin' or $username == 'admin')
		{
				/*$quu = mysql_query("select * from admin");
				while($rrr = mysql_fetch_array($quu))
				{
					$admin = $rrr ['admin'];	
				}*/
			$querys = mysql_query("select * from message order by id DESC LIMIT 1");
			while($rwo = mysql_fetch_array($querys))
			{
			 	$old_ticket_no =$rwo['id'];
			}
		  	$tic_inc_no = $old_ticket_no;
			$tic_no = "CHRT5213";
			$ticket_no = $tic_no.$tic_inc_no;
			
			mysql_query("INSERT INTO message (id_user,receive_id, title, message, message_date, time , ticket_no) VALUES ('$id','0' , '$title' , '$message', '$message_date' , '$time','$ticket_no') ");
			
			$_SESSION['success'] = "<font color=green size=2><strong>Message send successfully!</strong></font>";
				
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=compose\"";
			echo "</script>";
		}
		/*else
		{
		$query = mysql_query("select * from users where username = '$username' ");
		$num = mysql_num_rows($query);
		if($num > 0)
		{
			while($row = mysql_fetch_array($query))
				$receive_id = $row['id_user'];
				
			mysql_query("INSERT INTO message (id_user,receive_id, title, message, message_date) VALUES ('$id','$receive_id' , '$title' , '$message', '$message_date') ");	
			print "Message send successfully!";
		}
		}*/
		else
		{
			$_SESSION['error'] = "<font color=red size=2><strong>Please Enter Correct Admin Username!</strong></font>";
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=compose\"";
			echo "</script>";
			
		}
	}	
	else
	{
		$_SESSION['error'] = "<font color=red size=2><strong>Please Enter Title!</strong></font>";
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=compose\"";
		echo "</script>";
		
	}	
}
