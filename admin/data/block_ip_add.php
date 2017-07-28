<?php
session_start();
include("condition.php");

if(isset($_POST['submit']))
{
	$ip_address = $_REQUEST['ip_address'];
	if($ip_address != '')
	{
		$q = mysql_query("select * from block_ip_address where block_ip_address = '$ip_address' ");
		$num = mysql_num_rows($q);
		if($num > 0)
		{ echo "<B style=\"color:#ff0000;\">This Ip Address Already Blocked!</B>";  }
		else
		{
			$date = date('Y-m-d');
			mysql_query("insert into block_ip_address (block_ip_address , date) 
			values ('$ip_address' , '$date') ");
			
			echo "<B style=\"color:#008000;\">Ip Address Successfully Saved !!</B>";
		}
	}
	else { echo "<B style=\"color:#ff0000;\">Please Enter IP Address !!</B>"; }	
}

else{ ?> 
<form name="my_form" action="index.php?page=block_ip_add" method="post">
<table class="table table-bordered"> 
	<thead><tr><th colspan="2">Block Ip Address</th></tr></thead>
	<tr>
		<th>Enter Ip Address</th>
		<td><input type="text" name="ip_address" /></td>
	</tr>
	<tr>
		<td class="text-center" colspan="2">
			<input type="submit" name="submit" value="Submit" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>
<?php  }  ?>

