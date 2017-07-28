<?php
include("function/functions.php");
$user_id=$_SESSION['ebank_user_id'];
?>
<div class="widget"> 
	<div class="widget-head"><h4 class="heading">E-pin Transfer History</h4></div>
<?php	
$sql="SELECT t1.*,t2.epin,t2.amount FROM epin_history t1 
LEFT JOIN e_pin t2 on t1.epin_id = t2.id
WHERE t1.user_id = '$user_id' ";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
if($num > 0)
{ ?>
	<table class="table table-bordered table-hover">
		<tr class="trbg">
			<th class="text-center">E-pin</th>
			<th class="text-center">Amount</th>
			<th class="text-center">Seller</th>
			<th class="text-center">Buyer</th>
			<th class="text-center">Date</th>
		</tr>
		<?php
		while($row = mysql_fetch_array($query))
		{
			$epin = $row['epin'];
			$user_id = get_user_name($row['user_id']);
			$transfer_to = get_user_name($row['transfer_to']);
			$date = $row['date'];
			
			$amount = number_format($row['amount']);
			$date = date('d/M/Y',strtotime($date));
			?>
			<tr>
				<td class="text-center"><?=$epin;?></td>
				<td class="text-center"><?=$amount;?></td>
				<td class="text-center"><?=$user_id;?></td>
				<td class="text-center"><?=$transfer_to;?></td>
				<td class="text-center"><?=$date;?></td>
			</tr>
		<?php
		}
		print "</table>";
}			
else 
{ echo "<B style=\"color:#FF0000; font-size:14px;\">There is no E-pin to show !</B>"; }
?>
</div>