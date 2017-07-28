<?php 
	include("../function/sendmail.php");
	$email = 'thaitv91@gmail.com';
	$name  = "Tran Van Thai"
	$title = 'You have a new matched PH-GH';
	$content = 'Your PH request has been successfully processed. Please log-in to <a href="https://system.ebank.tv/login.php">www.eBank.tv</a> now to complete the PH.';
	sendMail($email,$name,$title,$content);	
?>