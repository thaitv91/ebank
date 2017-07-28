<?php
session_start();
include("condition.php");

$user_id = $_SESSION['ebank_user_id'];
$sql = "select * from e_pin where user_id = '$user_id' and mode = 1 ";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
if($num != 0)
{?>
<table id="example2" class="table table-bordered table-hover">
	<tr>
		<th>E-pin</th>
		<!--<th>E-pin Type</th>-->
		<th>Date</th>
	</tr>
	<?php
	while($row = mysql_fetch_array($query))
	{
		$epin = $row['epin'];
		$date = $row['date'];
		$date = date('d/M/Y', strtotime($date));
		/*$epin_type = $row['epin_type'];
		if($epin_type == 0)
		{
			$epin_type_status = "Registration E-pin";
			$amount = "Free"; 
		}	
		else
		{
			$amount = $row['amount']; 
			$qu = mysql_query("select * from plan_setting  ");
			while($rrr = mysql_fetch_array($qu))
			{ 
				$epin_type_status = $rrr['plan_name'];
			}
		}*/	
		?>
		<tr>
			<td><?=$epin;?></td>
			<!--<td><?=$epin_type_status;?></td>-->
			<td><?=$date;?></td>
		</tr>
	<?php
	}
print "</table>";
}
else 
{ echo "<B style=\"color:#FF0000; font-size:14px;\">There is no E-pin to show !</B>"; }
?>
			
		