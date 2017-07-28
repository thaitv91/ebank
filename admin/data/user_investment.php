<?php
include("condition.php");

if(isset($_POST['submit']))
{
	$username = $_REQUEST['username'];
	$query = mysql_query("select * from users where username = '$username' ");
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$id = $row['id_user'];
			$_SESSION['real_par_admin_user_$id'] = $id;
		}
		$tamount = 0;
		$q = mysql_query("select * from reg_fees_structure where user_id = '$id' ");
		$num = mysql_num_rows($q);
		if($num > 0)
		{
			while($row = mysql_fetch_array($q))
			{
				$update_fees = $row['update_fees'];
				$reg_fees = $row['reg_fees'];
				if($update_fees == 0)
					$tamount = $tamount+$reg_fees;
				else
					$tamount = $tamount+$update_fees;
			}	
			$q = mysql_query("select * from reg_fees_structure where user_id = '$id' ");
			 ?>
			<table class="table table-bordered">
				<thead>
				<tr>
					<th colspan="2">Total Investment</th>
					<th colspan="2"><?=$tamount;?></th>
				</tr>
				<tr>
					<th class="text-center">Date</th>
					<th class="text-center">Investment</th>
					<th class="text-center">Profit (%)</th>
					<th class="text-center">Total Days</th>
				</tr>
				</thead>
			<?php
			while($r = mysql_fetch_array($q))
			{
				$date = $r['date'];
				$profit = $r['profit'];
				$total_days = $r['total_days'];
				$reg_fees = $r['reg_fees'];
				$update_fees = $r['update_fees'];
				
				if($update_fees == 0)
					$amount = $reg_fees;
				else
					$amount = $update_fees;
				print "<tr>
					<td>$date</td>
					<td>$amount</td>
					<td>$profit</td>
					<td>$total_days</td>
				  </tr>";
			}
			print "</table>";
		}
		else 
		{ echo "<B style=\"color:#FF0000;\">Sorry Username ".$username." have no Investments !</B>"; }
	}
	else
	{ echo "<B style=\"color:#FF0000;\">Please Enter Correct Username !</B>"; }	
}
else
{ ?> 
<form name="parent" action="index.php?page=user_investment" method="post">
<table class="table table-bordered">  
	<tr>
		<th>User Name</th>
    	<td><input type="text" name="username" /></td>
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" name="submit" value="check" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>
<?php
}
?>	