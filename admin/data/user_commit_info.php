<?php
include("condition.php");
include("../function/functions.php");
?>
<h2 align="left">User Commitment Information</h2>
	
	<table width="100%">
		<tr class="message tip" height="32px">
			<th>
				Sr No
			</th>
			<th>
				User Id
			</th>
			<th>
				Name
			</th>
			<th>
				1st Commitment
			</th>
			<th>
				Confirm Date
			</th>
			<th>
				Groth
			</th>
			<th>
				Level
			</th>
			<th>
				Wallet Balance
			</th>
		</tr>
<?PHP
$query = mysql_query("SELECT * FROM `investment_request` WHERE rec_mode =1 AND MODE =0 ORDER BY user_id ASC");	
$srno = 1;
while($row = mysql_fetch_array($query))
{	
	$id_user = $row['id_user'];
print	"<tr class=\"input-small\" height=\"32px\">
			<th>
				$srno - ".$row['user_id']."
			</th>
			<th align=\"left\" style=\"padding-left:20px;\">
				".$username = get_user_name($row['user_id'])."
			</th>
			<th align=\"left\" style=\"padding-left:20px;\">
				".$f_name = get_full_name($row['user_id'])."
			</th>
			<th>
				".$amount = $row['amount']."
			</th>
			<th>
				".$date = $row['date']."
			</th>
			<th>
				".$ttl_groth = totl_groth($row['user_id'])."
			</th>
			<th>
				".$totl_level = totl_level($row['user_id'])."
			</th>
			<th>
				".$ttl_groth = get_wallet_amount($row['user_id'])."
			</th>
		</tr>";
$srno++;
}
?>	
	</table>
	
	
<?php
/*//$sql = "select tbl1.*, tbl2.*, tbl3.*, tbl4.* from 
				(	select * from
					(
					select t1.id_user,t1.username,t1.f_name
					FROM users AS t1
					) as tb1
				) tbl1 
			inner join 
				(	select * from
					(
					select t2.amount as amount_inv,t2.date,t2.user_id as inv_user_id
					FROM investment_request AS t2
					where t2.rec_mode = 1
					GROUP BY t2.user_id
					) as tb2	
				) tbl2
			inner join 
				(	select * from
					(
					select t3.income,t3.level, t3.user_id as inc_user_id
					FROM user_income AS t3
					GROUP BY t3.user_id
					) as tb3	
				) tbl3
			inner join 
				(	select * from
					(
					select t4.amount as ttl_amnt, t4.id as wallet_id
					FROM wallet AS t4
					) as tb4	
				) tbl4		
				
				on tbl1.id_user = tbl2.inv_user_id and tbl1.id_user = tbl3.inc_user_id 
				and tbl3.inc_user_id = tbl4.wallet_id ";*/

function get_approve_date($id)
{
	$q = mysql_query("select date from income_transfer where paying_id = '$id' and mode = 2 ");
	while($row = mysql_fetch_array($q))
		$tatalamount = $row[0];
	if($tatalamount > 0)
	{
		return $tatalamount;
	}
	else
	{
		return 0;	
	}	
}

function totl_groth($id)
{
	$q = mysql_query("SELECT sum(income) FROM `user_income` WHERE `user_id` = '$id' AND `type` = 6 ");
	while($row = mysql_fetch_array($q))
		$totl_groth = $row[0];
	if($totl_groth == 0)
	{
		return $totl_groth = 0;
	}
	else
		return $totl_groth;
}

function totl_level($id)
{
	$q = mysql_query("SELECT sum(income) FROM `user_income` WHERE `user_id` = '$id' AND `type` != 6 ");
	while($row = mysql_fetch_array($q))
		$totl_level = $row[0];
	if($totl_level == 0)
	{
		return $totl_level = 0;
	}
	else
		return $totl_level;
}

?>			