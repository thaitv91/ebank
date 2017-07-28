<?php
session_start();
include("condition.php");
include("../function/functions.php");

?>
		<table width="800" border="0">

<?php
	$query = mysql_query("select * from e_pin where mode = 0 ");
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		print "<tr>
			<td class=\"message tip\">E-pin</td>
			<td class=\"message tip\">User Id</td>
			<td class=\"message tip\">Date</td>
			<td class=\"message tip\">Used Id</td>
			<td class=\"message tip\">Used Date</td>
		  </tr>";
		while($row = mysql_fetch_array($query))
		{
			$epin = $row['epin'];
			$date = $row['date'];
			$product_id = $row['product_id'];
			$used_id = get_user_name($row['used_id']);
			$user_id = get_user_name($row['user_id']);
			$used_date = $row['used_date'];
			
			print "<tr>
					<td class=\"input-medium\"><small>$epin</small></td>
					<td class=\"input-medium\"><small>$user_id</small></td>
					<td class=\"input-medium\"><small>$date</small></td>
					<td class=\"input-medium\"><small>$used_id</small></td>
					<td class=\"input-medium\"><small>$used_date</small></td>
				  </tr>";
		}
	}
	else 
	{
		print "<tr>
					<td colspan=5>There is no E-pin to show !</td>		  
				</tr>";
	}
	print "</table>";
?>
