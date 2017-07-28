<?php
ini_set("display_errors" , "off");
session_start();
//include("condition.php");
require("function/functions.php");

$newp = $_GET['p'];
$plimit = "5";
$id = $_SESSION['ebank_user_id'];

$spons_email = get_user_email($id);
$sql = "SELECT t1.*,t2.income,t2.date as last_date FROM users t1 LEFT JOIN (SELECT user_id, sum(income) as income,date FROM user_income where type='5' group by user_id) t2 ON t1.id_user=t2.user_id WHERE real_parent = '$id'";
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
if($totalrows == 0)
{
	echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>"; 
}
else 
{ 
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }


	/*$sql3 = "select sum(t3.income),t3.date
			from
			(SELECT t2.income,t2.date FROM users t1 
			LEFT JOIN 
			(SELECT user_id, sum(income) as income,date FROM user_income where type='5' group by user_id
ORDER BY `date` DESC) 
			t2 ON t1.id_user=t2.user_id 
			WHERE t1.real_parent = '$id'
			order by t2.date desc) as t3";*/
	$sql3 = "SELECT t2.income,t2.date FROM users t1 
			LEFT JOIN 
			(SELECT user_id, sum(income) as income,date FROM user_income where type='5' group by user_id) 
			t2 ON t1.id_user=t2.user_id 
			WHERE t1.real_parent = '$id'";

	$queryaa = mysql_query($sql3);
	while($abc=mysql_fetch_array($queryaa))
	{
		$totincome += $abc[0];
		$lastincome = $abc[0];
		$date_inc = $abc[1];
		
		if($date_inc == NULL or $date_inc == '')$date_inc = "No Date";
		else{$date_inc = date('d M Y' , strtotime($date_inc)); }
	}
?>
	<table class="table table-bordered table-hover">
		<thead>
			<tr class="trbg">
				<th class="text-center">Commission</th>
				<th class="text-center">Last Commission</th>
				<th class="text-center">Amount</th>
			</tr>
		</thead>
		
		<tr>
			<th class="text-center">Referral Bonus</th>
			<th class="text-center"><?=$date_inc;?></th>
			<th class="text-right"><?=number_format($lastincome);?></th>
		</tr>
		<tr>
			<th colspan="3" class="text-right">
				Total Bonus &nbsp;:&nbsp; <?=number_format($totincome);?>
			</th>
		</tr>
	</table><p></p>
	<div class="widget"> 
	<div class="widget-head"><h4 class="heading">Commission Summary - Referral Bonus</h4></div><p></p>
	<table class="table table-bordered table-hover">
		<thead>
			<tr class="trbg">
				<th class="text-center">Date</th>
				<th class="text-center">User Refferred</th>	
				<th class="text-center">Amount</th>
			</tr> 
		</thead>
	<?php	
	
	
	$sr_no = $start+1;
	$query = mysql_query("$sql LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		$child_id = $row['id_user'];
		$username = $row['username'];
		$name= $row['f_name']." ".$row['l_name'];
		$date = $row['last_date'];
		$email = $row['email'];
		$phone_no = $row['phone_no'];
		$id_user = $row['id_user'];
		$full_investment = $row['income'];
		
		if($full_investment == NULL or $full_investment == '')$full_investment = "0";
		
		if($date == NULL or $date == '')$date = "No Date";
		else{$date = date('d M Y' , strtotime($date)); }
		
		 ?>
		 <tr>
			<th class="text-center"><?=$date;?></th>
			<th><?=$username;?></th>
			<th><?=$full_investment;?> <?=$inr;?></th>
		</tr>
<?php
		$sr_no++;
	} ?>
	</table>
	</div>
	<div class="col-xs-6">
		<div class="dataTables_paginate paging_bootstrap">
			<ul class="pagination">
				<?php
				if ($newp>1)
				{ ?> 
					<li class="prev">
						<a href="<?="index.php?page=direct-members&p=".($newp-1);?>">&larr; <?=$Previous;?></a>
					</li> <?php  
				}
				for ($i=1; $i<=$pnums; $i++) 
				{ 
					if ($i!=$newp)
					{ ?>
						<li>
						<a href="<?="index.php?page=direct-members&p=$i";?>"><?php print_r("$i");?></a>
						</li>
						<?php 
					}
					else
					{ ?><li class="active"><a href="#"><?php print_r("$i"); ?></a></li> <?php }
				} 
				if ($newp<$pnums) 
				{ ?> 
					<li class="next">
					<a href="<?php echo "index.php?page=direct-members&p=".($newp+1);?>"><?=$Next;?> &rarr;</a>
					</li> <?php  
				} ?>
			</ul>
		</div>
	</div>
	
<?php	
}

function get_user_full_investment($id)
{
	$q = mysql_query("select sum(amount) from investment_request where user_id = '$id' ");
	while($row = mysql_fetch_array($q))
	{
		$total_invst = $row[0];
	}
	if($total_invst == '')
		$total_invst = 0;
	return $total_invst;		
}
?>

