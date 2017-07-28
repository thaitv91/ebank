<?php
//include("config.php");
$id = $_SESSION['ebank_user_id'];
$query = mysql_query("select * from users where id_user = '$id' ");
while($row = mysql_fetch_array($query))
{
	$welcome_name = $row['f_name']." ".$row['l_name'];
} 
?>