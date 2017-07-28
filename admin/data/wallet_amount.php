<?php
session_start();
include("condition.php");

if(isset($_POST['submit']))
{
	$u_name = $_REQUEST[user_name];
	$q = mysql_query("select * from users where username = '$u_name' ");
	$num = mysql_num_rows($q);
	if($num == 0)
	{ echo "<B style=\"color:#ff0000;\">Please Enter right User Name!</B>"; }
	else 
	{ ?>
		<table class="table table-bordered">  
			<thead>
			<tr>
				<th class="text-center">User Name</th>
				<th class="text-center">Amount</th>
				<th class="text-center">Date</th>
			</tr>
			</thead>
	<?php
		while($id_row = mysql_fetch_array($q))
		{
			$id_user = $id_row['id_user'];
		}		
		
		$query = mysql_query("select * from wallet where id = '$id_user' ");
		$num = mysql_num_rows($query);
		if($num != 0)
		{
			while($row = mysql_fetch_array($query))
			{
				$date = $row['date'];
				$amount = $row['amount']; ?>
				<tr>
					<td class="text-center"><?=$u_name;?></td>
					<td class="text-center"><?=$amount;?> <font color=dark>$ </font></td>
					<td class="text-center"><?=$date;?></td>
				</tr> 
	<?php
			}	
			print "</table>";
		}
		else
		{ echo "<B style=\"color:#ff0000;\">$j</B>"; }
	}
}
else{ ?> 
<form name="my_form" action="index.php?page=wallet_amount" method="post">
<table class="table table-bordered"> 
	<thead><tr><th colspan="2">Wallet Information</th></tr></thead>
	<tr>
		<th>Enter Member UserName</th>
		<td><input type="text" name="user_name" /></td>
	</tr>
	<tr>
		<td class="text-center" colspan="2">	
			<input type="submit" name="submit" value="Submit" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>
<?php  
}  ?>

