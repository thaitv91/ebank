<?php
include("../function/functions.php");

$sql = "SELECT id,amount,date,`user_id` , count( * ) AS c FROM `investment_request` 
WHERE rec_mode = '0' AND mode = '1' GROUP BY `user_id` HAVING c >1 ";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
if(isset($_POST['merge']))
{		
	while($rows = mysql_fetch_array($query))
	{
		if($rows['c'] > 1)
		{
			$id = $rows['id'];
			$user_id = $rows['user_id'];
			
			$sql = "select sum(amount) as amount from investment_request where user_id = '$user_id' 
			and rec_mode = '0' AND mode = '1' ";
			$query1 = mysql_query($sql);
			$amount_row = mysql_fetch_array($query1);
			$amount_row = $amount_row['amount'];

			//mysql_query("UPDATE investment_request set amount = (select sum(amount) as amount from investment_request where id = '$id' )");
			
			$update_amt = " update investment_request t set
amount = '$amount_row' where id = '$id'";
			mysql_query($update_amt);
		}	
	}
	
	$sel_dup_sql = "delete FROM `investment_request`
					WHERE `user_id` IN
					(
						SELECT `user_id`
						FROM (
						
								SELECT `user_id` , count( * ) AS c
								FROM `investment_request`
								WHERE rec_mode = '0' AND mode = '1 '
								GROUP BY `user_id`
								HAVING c >1
							 ) AS dctbl
					)
						AND `id` NOT IN
						(
							SELECT `mi`
							FROM (
									SELECT `user_id` , min( `id` ) AS mi
									FROM `investment_request`
									WHERE rec_mode = '0' AND mode = '1 '
									GROUP BY `user_id`
								 ) AS idtbl
						)
						and  rec_mode = '0' AND mode = '1' ";
	$sel_dup_query = mysql_query($sel_dup_sql);
	/*while($roa = mysql_fetch_array($sel_dup_query))
	{
		$id = $roa['id'];
		$sql = "delete from investment_request where id = '$id' ";
		mysql_query($sql);
	}*/
	
	mysql_query("ALTER TABLE `investment_request` DROP `id`");
	mysql_query("ALTER TABLE `investment_request` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST ,ADD PRIMARY KEY ( id )");

}
else
{
	if($num > 0)
	{ ?>
	<table class="table table-bordered">
		<thead>
		<tr>
			<th>Id</th>
			<th>User Name</th>
			<th>Amount</th>
			<th>Date</th>
		</tr>
		</thead>
	<?php 
		$id = 1;
		while($ro = mysql_fetch_array($query))
		{
			$user_name=get_user_name($ro['user_id']);
			
			echo  "<tr>
				<td>$id</td>
				<td>$user_name</td>
				<td>".$amount12 = $ro['amount']."</td>
				<td>".$date = $ro['date']."</td>
			</tr>";
			$id++;
		}
?>		
	<tr>
	<td colspan="4" class="text-right">
	<form method="post" action="index.php?page=invest_merge">
		<input type="submit" name="merge" value="Merge" class="btn btn-info" />
	</form>
	</td>
	</tr>
	</table>
<?php  }
	else { echo "<B style=\"color:#ff0000;\">There are No Users !</B>"; }
}	
?>