<?php
$user_id=$_SESSION['ebank_user_id'];

$sql="SELECT epin_wallet FROM wallet WHERE id = '$user_id' ";

$query = mysql_query($sql);
 ?>
<table class="table table-bordered table-hover">
	<tr><th style="text-align:center;">Buy Epin</th><th style="text-align:center;">Used EPin</th></tr>
	<tr>
		<td>
			<?php
			$sql = "select * from e_pin where user_id = '$user_id' and mode = 1 ";
			$query = mysql_query($sql);
			$num = mysql_num_rows($query);
			if($num != 0)
			{?>
			<table class="table table-bordered table-hover">
				<tr>
					<th>E-pin</th>
					<th>Date</th>
				</tr>
				<?php
				while($row = mysql_fetch_array($query))
				{
					$epin = $row['epin'];
					$date = $row['date'];
					$amount = number_format($row['amount']);
					$epin_type = $row['epin_type'];
					$date = date('d/M/Y',strtotime($date));
					?>
					<tr>
						<td><?=$epin;?></td>
						<td><?=$amount;?></td>
						<td><?=$date;?></td>
					</tr>
				<?php
				}
			print "</table>";
			}
			else 
			{ echo "<B style=\"color:#FF0000; font-size:14px;\">There is no E-pin to show !</B>"; }
			?>
		</td>
		<td>
			<?php
			$sql = "select * from e_pin where user_id = '$user_id' and mode = 0 ";
			$query = mysql_query($sql);
			$num = mysql_num_rows($query);
			if($num != 0)
			{?>
			<table class="table table-bordered table-hover">
				<tr>
					<th>E-pin</th>
					<th>Amount</th>
					<th>Date</th>
				</tr>
				<?php
				while($row = mysql_fetch_array($query))
				{
					$epin = $row['epin'];
					$date = $row['date'];
					$amount = number_format($row['amount']);
					$epin_type = $row['epin_type'];
					$date = date('d/M/Y',strtotime($date));
					?>
					<tr>
						<td><?=$epin; ?></td>
						<td><?=$amount;?></td>
						<td><?=$date;?></td>
					</tr>
				<?php
				}
			print "</table>";
			}
			else 
			{ echo "<B style=\"color:#FF0000; font-size:14px;\">There is no E-pin to show !</B>"; }
			?>
		</td>
	</tr>
</table>
