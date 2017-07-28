<?php
include("condition.php");
include("../function/functions.php");

$query = mysql_query("select * from paid_unpaid where paid = 1 and amount > 0 ");
$num = mysql_num_rows($query);
if($num != 0)
{ ?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th>User Name</th>
			<th>Request Amount</th>
			<th>Date</th>
		</tr>
		</thead>
	<?php
	while($row = mysql_fetch_array($query))
	{
		$id = $row['id'];
		$u_id = $row['user_id'];
		$username = get_user_name($u_id);
		$request_amount = $row['amount'];
		$request_amount_usd = $amount_usd = round($request_amount/$usd_value_current,2);
		$paid_date = $row['paid_date'];
		?>
		<tr> 
			<td><?=$username;?></td>
			<td><?=$request_amount;?></td>
			<td><?=$paid_date;?></td>
	 	</tr>
	<?php	
	}
	print "</table>";	
}
else { echo "<B style=\"color:#ff0000;\">There is no fund for approved !</B>"; }
?>

