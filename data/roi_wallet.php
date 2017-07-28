<?php
$user_id=$_SESSION['ebank_user_id'];
?>
<div class="widget"> 
	<div class="widget-head"><h4 class="heading">ROI Wallet History</h4></div>
	
<?php
$sql = "select * from account where user_id = '$user_id' and wall_type = 'ROI Wallet'";	
$query = mysql_query($sql);
$num = mysql_num_rows($query);
if($num > 0)
{
?>
<table class="table table-bordered table-hover">
	<thead>
	<tr class="trbg">
		<th>Transaction ID</th>
		<th>Credit ($ )</th>
		<th>Debit ($ )</th>
		<th>Balance ($ )</th>
		<th>Description</th>
		<th>Date</th>
	</tr>
	</thead>
	<?php
	$sr_no = 1;
	while($row = mysql_fetch_array($query))
	{
		$cr = $row['cr'];
		$dr = $row['dr'];
		$date = $row['date'];
		$desc = $row['account'];
		$wal_bal = $row['wallet_balance'];
		
		$date = date('d M Y H:i:s A');
	?>
		<tr>
			<td><?=$sr_no;?></td>
			<td><?=$cr;?></td>
			<td><?=$dr;?></td>
			<td><?=$wal_bal;?></td>
			<td><?=$desc;?></td>
			<td><?=$date;?></td>
		</tr>
		
	<?php
		$sr_no++;
	}
	?>
</table>
<?php
}
else { echo "<p></p><B style=\"color:#ff0000;\">&nbsp;There are no information to show</B><p></p>";}
?>
</div>