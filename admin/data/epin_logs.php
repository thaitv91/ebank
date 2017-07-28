<?php
include("../function/functions.php");

if(isset($_POST['Submit']))
{
	$epin = $_POST['epin'];
	
	$sql = "select * from e_pin as t1 inner join epin_history as t2 on t1.id = t2.epin_id and 
	epin = '$epin' ";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num > 0)
	{ ?>
		<table class="table table-bordered">  
	<?php
		while($row = mysql_fetch_array($query))
		{
			$gen_id = $row['generate_id'];
			$pin_date = $row['date'];
			
			if($gen_id == 0){
				$generate_id = 'Admin';	
			}
			else{
				$generate_id = get_user_name($row['generate_id']);
			}
			
			$owner = $row['transfer_to'];
			$transfer_id = $row['user_id'];
			if($transfer_id == $owner)
			{
				$transfer_id = 'No Transfer';
				$owner = get_user_name($owner);
			}
			else
			{
				$transfer_id = get_user_name($transfer_id);
				$owner = get_user_name($owner);
			}
			$used_id = get_user_name($row['used_id']);
			$used_date = $row['used_date'];
			if($used_id == '')
			{
				$used_id = "<font color=red>Not Used</font>";
				$used_date = "<font color=red>No Date</font>";
			}
			$date = $row['date'];
			$epin = $row['epin'];
		?>
			<tr><th>Generate By</th>	<td><?=$generate_id;?></td></tr>
			<tr><th>Transfer To</th>	<td><?=$owner;?></td></tr>
			<tr><th>Generate Date</th>	<td><?=$pin_date;?></td></tr>
			<tr><th>Used By</th>		<td><?=$used_id;?></td></tr>
			<tr><th>Used Date</th>		<td><?=$used_date;?></td></tr>
		<?php
		}
		echo "</table>";			
	}		
	else
	{
		$sql = "select * from e_pin where epin = '$epin' ";
		$query = mysql_query($sql);
		?>
		<table class="table table-bordered">  
	<?php
		while($row = mysql_fetch_array($query))
		{
			$used_id = get_user_name($row['used_id']);
			$used_date = $row['used_date'];
			$pin_date = $row['date'];
			if($used_id == '')
			{
				$used_id = "<font color=red>Not Used</font>";
				$used_date = "<font color=red>No Date</font>";
			}
			$generate_id = "No Information";
			$transfer_id = get_user_name($row['user_id']);
		?>
			<tr><th>Generate By</th>	<td><?=$generate_id;?></td></tr>
			<tr><th>Transfer To</th>	<td><?=$transfer_id;?></td></tr>
			<tr><th>Generate Date</th>	<td><?=$pin_date;?></td></tr>
			<tr><th>Used By</th>		<td><?=$used_id;?></td></tr>
			<tr><th>Used Date</th>		<td><?=$used_date;?></td></tr>
		<?php	
		}
		print "</table>";	
	}
}
else
{
?>
<form method="post" action="index.php?page=epin_logs">
<table class="table table-bordered">  
	<tr>
		<th width="40%">E-pin</th>
		<td><input type="text" name="epin" placeholder="Insert E-pin" /></td>
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" value="Submit" name="Submit" class="btn btn-info" />		
		</td>
	</tr>
</table>
</form>	
<?php
}
?>