<?php
session_start();
require_once("../config.php");
$id = $_SESSION['ebank_user_admin_login'];
if(isset($_POST['submit']))
{ 
	
	$title = $_REQUEST['title'];
	$message = $_REQUEST['message'];
	$message_date = date('y-m-d');
	$username = $_REQUEST['username'];
	$time = date('Y-m-d H:i:s');
	if($title != '')
	{		
		if(in_array( "all" ,$username ))
		{
			$quu = mysql_query("select * from users");
			while($rrr = mysql_fetch_array($quu))
			{
				$all_user[] = $rrr ['id_user'];	
			}
			
			$cnt = count($all_user);
			for($i = 0; $i < $cnt; $i++)
			{
			 	$all_user[$i];
			 	mysql_query("INSERT INTO message (id_user,receive_id, title, message, message_date,time)
				 VALUES ('0','$all_user[$i]' , '$title' , '$message', '$message_date','$time') ");	
			}
			$_SESSION['success'] = "<font color=green size=2><strong>Message send successfully!</strong></font>";
				
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=compose\"";
			echo "</script>";
		}
		else
		{
			$querys = mysql_query("select * from message order by id DESC LIMIT 1");
			while($rwo = mysql_fetch_array($querys))
			{
				$old_ticket_no =$rwo['id'];
			}
		  	$tic_inc_no = $old_ticket_no; 
			
			$query = mysql_query("select * from users where id_user IN (".implode(',',$username).") ");
			$num = mysql_num_rows($query);
			$tic_no = "CHRT5213";
			
			if($num > 0)
			{
				while($row = mysql_fetch_array($query))
					$receive_id = $row['id_user'];
				 	$ticket_no = $tic_no.$tic_inc_no;
					
				mysql_query("INSERT INTO message (id_user,receive_id, title, message, message_date,ticket_no ) VALUES ('0','$receive_id' , '$title' , '$message', '$message_date' , '$ticket_no') ");	
				$_SESSION['success'] = "<font color=green size=2><strong>Message send successfully!</strong></font>";
				
				echo "<script type=\"text/javascript\">";
				echo "window.location = \"index.php?page=compose\"";
				echo "</script>";
				
			}
			else
			{
				$_SESSION['error'] = "<font color=red size=2><strong>Please Enter Correct Username!</strong></font>";
				echo "<script type=\"text/javascript\">";
				echo "window.location = \"index.php?page=compose\"";
				echo "</script>";
			}
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
