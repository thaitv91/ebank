<?php
session_start();
include("condition.php");
include("function/setting.php");

$user_id = $_SESSION['ebank_user_id'];
$newp = $_GET['p'];
$plimit = "12";
$sql ="select * from user_income where user_id = '$user_id' and  (type = '$income_type[4]' or type = '$income_type[5]' or type = '$income_type[7]') ";
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{
?>
<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info"> 
<tbody role="alert" aria-live="polite" aria-relevant="all">
<?php
	while($row1 = mysql_fetch_array($query))
	{ 
		$tatal_amt = $tatal_amt+$row1['income']; 
		$tatal_amt_usd = round($tatal_amt/$usd_value_current,2);
	}
	print "<tr>
			<td align=\"center\"><strong>Total Manager  Income</strong></td>
			<td align=\"center\" colspan=2>
				<strong>$$tatal_amt_usd <font color=DodgerBlue>USD</font> Or $tatal_amt 
					<font color=dark>$ </font></strong>
			</td>
		</tr>
		<tr><td colspan=3>&nbsp;</td></tr>
		<tr><td align=\"center\"><strong>Date</strong></th> 
		<td align=\"center\"><strong>Amount</strong></td>
		</tr>";

	$pnums = ceil ($totalrows/$plimit);
	
	if ($newp==''){ $newp='1'; }
	
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
	
	
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }

	$query1 = mysql_query("$sql LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query1))
	{
		$date = $row['date'];
		$amount = $row['income'];
		$amount_usd = round($amount/$usd_value_current,2);
		//$level = $row['level'];
		print "<tr><td align=\"center\" width=200>$date</td>
		<td align=\"center\" width=200>
			$$amount_usd <font color=DodgerBlue>USD</font> Or 
			$amount <font color=dark>$ </font>
		</td>
		</tr>";
		$j = 1;
	}
	print"</tbody></table>";
	print "<ul class=\"pagination pagination-sm pull-right margin-0px\">";
	if ($newp>1)
	{ 
		?> <li><a href="<?php echo "index.php?page=manager_bonus&p=".($newp-1);?>">&laquo;</a></li> <?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ 
			?> <li><a href="<?php echo "index.php?page=manager_bonus&p=$i";?>"><?php print_r("$i");?></a></li> <?php 
		}
		else
		{
			 ?><li class="active"><a href="#"><?php print_r("$i");?></a></li><?php
		}
	} 
	if ($newp<$pnums) 
	{ 
		?> <li><a href="<?php echo "index.php?page=manager_bonus&p=".($newp+1);?>">&raquo;</a></li> <?php 
	} 
}		
else{ print "<strong>There is No information to show !!</strong>"; }

?>
