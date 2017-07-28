<?php
session_start();
include("../config.php");
include("condition.php");

?>

<link rel="stylesheet" type="text/css" href="../css/style.css" />

<?php

$user_id = $_SESSION['ipayindia_user_id'];
if(isset($_POST['submit']))
{
	$username = $_REQUEST['username'];
	$user_query = mysql_query("select * from users where username = '$username' ");
	$user_num = mysql_num_rows($user_query);
	if($user_num != 0)
	{
		while($row = mysql_fetch_array($user_query))
		{
			$user_id = $row['id_user'];
		}
		$query = mysql_query("select * from tax where user_id = '$user_id' ");
		$num = mysql_num_rows($query);
		if($num != 0)
		{
			print "<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=600>	
				  <tr>
					<td><strong>Total Amount</strong></td>
					<td><strong>Tax Amount</strong></td>
					<td><strong>Deducted Amount</strong></td>
					<td><strong>Date</strong></td>
				  </tr>
				  <tr>
					<td colspan=\"4\">&nbsp;</td>
				  </tr>";	
				
			while($row = mysql_fetch_array($query))
			{
				$total_amount = $row['total_amount'];
				$tax_amount = $row['tax_amount'];
				$deducted_amount = $row['deducted_amount'];
				$date = $row['date'];
				
				print "<tr>
						<td class=\"message success\">$total_amount</td>
						<td class=\"message success\">$tax_amount</td>
						<td class=\"message success\">$deducted_amount</td>
						<td class=\"message success\">$date</td>
					  </tr>";
			}
			print "</table>";
		}
		else { print "There is no roport to show !"; }
	}	
	else { print "Please enter correct Username !"; }	
}
else
{ ?>
<table width="500" border="0">
<form action="" method="post" >
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Enetr Username :</td>
    <td><input type="text" name="username" class="input-medium" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><p align="center"><input type="submit" value="Report" name="submit" class="btn btn-info" /></p></td>
  </tr>
  </form>
</table>

<?php
}