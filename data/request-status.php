<?php
include("condition.php");
$id = $_SESSION['ebank_user_id'];

$title = 'Display';
$message = 'Display Withdrawal Request';
data_logs($id,$title,$message,0);

$query = mysql_query("select * from income where user_id = '$id' and type = 2 ");
$num = mysql_num_rows($query);
if($num != 0)
{
?>
	<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info"> 
	<tbody role="alert" aria-live="polite" aria-relevant="all">			
		<tr>
			<th><strong>Sr. No.</strong></th>
			<th><strong>Request Amount</strong></th>
			<th><strong>Paid Amount</strong></th>
			<th><strong>Request Date</strong></th>
		</tr>
<?php
		$i = 1;
	while($row = mysql_fetch_array($query))
	{
		$request_amount = $row['total_amount'];
		$paid_amount = $row['paid_amount'];
		$request_date = $row['date'];

		print "<tr>
			<td style=\"padding-left:40px\">$i</td>
			<td style=\"padding-left:20px\"><small>$request_amount</small></td>
			<td style=\"padding-left:40px\"><small>$paid_amount</small></td>
			<td style=\"padding-left:40px\"><small>$request_date</small></td>
		</tr>";
		$i++;
	}
	print "</tbody></table>";	
}
else{ print "<strong>There is no fund for approved !!</strong>"; }
?>
