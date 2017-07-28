<?php
session_start();
include("condition.php");

if(isset($_POST['submit']))
{
	$ip_address_id = $_REQUEST['ip_address'];
	$q = mysql_query("delete from block_ip_address where id = '$ip_address_id' ");
	echo "<B style=\"color:#ff0000;\">IP Address Remove Successfully !!</B>"; 
}
else
{
	$q = mysql_query("select * from block_ip_address ");
	$num = mysql_num_rows($q);
	if($num == 0)
	{
		echo "<B style=\"color:#ff0000;\">There Are No Blocked Ip Address !</B>"; 
	}
	else
	{ ?> 
		<table class="table table-bordered">  
			<thead>
			<tr><th colspan="3">Blocked IP Adderss Information</strong></th></tr>
			<tr>
				<th class="text-center">Sr. No.</th>
				<th class="text-center">IP Address</th>
				<th class="text-center">Action</th>
			</tr>
			</thead>
		<?php
		$u = 0;
		while($row = mysql_fetch_array($q))
		{ 
			$u++;
			$block_ip_address = $row['block_ip_address'];
			$id = $row['id'];
		?> 
			<tr>
			<form name="my_form" action="index.php?page=block_ip_add_list" method="post">
				<input type="hidden" name="ip_address" value="<?php print $id; ?>"  />
				<td class="text-center"><?=$u;?></td>
				<td class="text-center"><?=$block_ip_address;?></td>
				<td class="text-center">
					<input type="submit" name="submit" value="Delete" class="btn btn-info" />
				</td>
			</form>
			</tr>
		  
	<?php }
		echo "</table>";
	}
}  
?>

