<?php
ini_set("display_errors" , "off");
session_start();
require("function/functions.php");
$user_id = $_SESSION['ebank_user_id'];

$sr_no = 1;
$sql = "SELECT * FROM investment_request WHERE user_id = '$user_id'";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
if($num > 0)
{ ?>
	<table id="example2" class="table table-bordered table-hover">
		<tr>
			<th><?=$Sr_no;?></th>				<th><?=$ID;?></th>
			<th><?=$Ctype;?></th>				<th><?=$Type;?></th>
			<th><?=$Date_of_Creating;?></th>	<th><?=$Principal_Amount; ?></th>
			<th><?=$Confirm_Amount;?></th>		<th><?=$My_Crypto;?></th>
			<th><?=$Withdraw_Amount;?></th>	<th><?=$Type;?></th>
		</tr>
	<?php
	
	while($row = mysql_fetch_array($query))
	{
		$id = $row['id'];
		$user_id = $row['user_id'];
		$amount = $row['amount'];
		$percent = $row['inv_profit'];
		$mode = $row['mode'];
		$date = $row['date'];
		$date = date('d/m/Y' , strtotime($date));
		$income = $amount*$percent/100;
		
		$tot_income += $income;
		
		if($mode == 3)
		{ 
			$status = "<span class=\"Confirmed\">$Confirmed</span>"; 
			$class = "inv_green";
		}
		else
		{ 
			$status = "<span class=\"Unconfirmed\">$Unconfirmed</span>"; 
			$class = "inv_blue";
		} ?>	
		<tr>
			<td><?=$sr_no;?></td>
			<td><?=$CH323113;?><?=$id;?></td>
			<td><?=$inr;?></td>
			<td><?=$status;?></td>
			<td><?=$date;?></td>
			<td><?=$amount;?></td>
			<td>0</td>
			<td><span class="<?=$class;?>"><?=$income;?></span></td>
			<td>0</td>
			<td>60%</td>
		</tr>
	<?php
		$sr_no++;
	}
	?>
		<tr>
			<td colspan="7" align="right"><B><?=$Total_Amount;?></B></td>
			<td><B><?=$tot_income + $amount ;?></B></td>
			<td colspan="3">&nbsp;</td>
		</tr>
		</tbody>
	</table>
	<span style="color: Green"><?=$Green;?></span><?=$Available_Withdraw;?> 
	<span style="color: Blue"><?=$Blue;?></span><?=$Not_Confirm;?>
	<span style="color: Red"><?=$Red;?></span><?=$Already_Withdraw;?>

<?php
}
else{ echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>"; }

?>
<style type="text/css">
.inv_blue
{
	color: Blue;
	font-weight: bold;
}
.inv_green
{
	color: Green;
	font-weight: bold;
}
.inv_red
{
	color: Red;
	font-weight: bold;
}

.Confirmed
{
	color: Green;
	font-weight: bold;
}
.Unconfirmed
{
	color: Red;
	font-weight: bold;
}

</style>