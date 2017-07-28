<?php
session_start();
include("condition.php");

?>
<table width="600" border="0">
<?php
	$sql = "select * from e_pin where mode = 0 ";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		print "<tr>
			<td>E-pin</td>
			<td>Date</td>
			<td>Product Id
			
		  </tr>";
		while($row = mysql_fetch_array($query))
		{
			$epin = $row['epin'];
			$date = $row['date'];
			$product_id = $row['product_id'];
			
			
			print "<tr>
					<td><small>$epin</small></td>
					<td><small>$date</small></td>
					<td><small>$product_id</small></td>
					
				  </tr>";
		}
	}
	else 
	{
		print "<tr>
					<td colspan=3>There is no E-pin to show !</td>		  
				</tr>";
	}
	print "</table>";
?>
