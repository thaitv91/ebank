<?php
session_start();
include('../condition.php');

require_once("../config.php");
$id = $_SESSION['ebank_user_id'];
$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
$num = mysql_num_rows($query);
if($num == 0)
{
	echo "There is no information  to show!"; 
}
else {
	while($row = mysql_fetch_array($query))
	{
	$f_name = $row['f_name'];
	$l_name = $row['l_name'];
	$gender = $row['gender'];
	$age = $row['dob'];
	$email = $row['email'];
	$phone_no = $row['phone_no'];
	$city = $row['city'];
	
	$parent_id = $row['parent_id'];
	$real_parent = $row['real_parent'];
	$position = $row['position'];
	$user_name = $row['username'];
	$step = $row['step'];
	$address = $row['address'];
	$provience = $row['provience'];
	$country = $row['country'];
	
	} ?>
	
	
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>User Panel</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body> 
<h2>Welcome to Royal Trader Group</h2>
	<div class="entry">
<div id="content" class="narrowcolumn"><div class="comment odd alt thread-odd thread-alt depth-1"  style="width:90%">

<?php	
		print "
	<table align=\"center\" class=\"look\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=100%>
	<tr><td width=200 class=\"td_title\">First Name</th><td width=400>$f_name</th></tr>
	<tr><td width=200 class=\"td_title\">Last Name</th><td width=400>$l_name</th></tr>
	<tr><td width=200 class=\"td_title\">Gender</th><td width=400>$gender</th></tr>
	<tr><td width=200 class=\"td_title\">Age</th><td width=400>$age</th></tr>
	<tr><td width=200 class=\"td_title\">E-Mail</th><td width=400>$email</th></tr>
	<tr><td width=200 class=\"td_title\">Phone Number</th><td width=400>$phone_no</th></tr>
	<tr><td width=200 class=\"td_title\">City</th><td width=400>$city</th></tr>
	<tr><td width=200 class=\"td_title\">Parent Id</th><td width=400>$parent_id</th></tr>
	<tr><td width=200 class=\"td_title\">Real Parent</th><td width=400>$real_parent</th></tr>
	<tr><td width=200 class=\"td_title\">Position</th><td width=400>$position</th></tr>
	<tr><td width=200 class=\"td_title\">User Name</th><td width=400>$user_name</th></tr>
	<tr><td width=200 class=\"td_title\">Step</th><td width=400>$step</th></tr>
	<tr><td width=200 class=\"td_title\">Address</th><td width=400>$address</th></tr>
	<tr><td width=200 class=\"td_title\">Provience City</th><td width=400>$provience</th></tr>
	<tr><td width=200 class=\"td_title\">Country</th><td width=400>$country</th></tr>
	
	</table>";
	
}	
?>
</div>
</div>
</div>
</body>
</html>