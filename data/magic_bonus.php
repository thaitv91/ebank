<?php
session_start();
include("condition.php");
include("function/setting.php");
include("function/functions.php");
?>
<h2 align="left">Magic Bonus</h2><p></p>
<?php
$user_id = $_SESSION['ebank_user_id'];


$newp = $_GET['p'];
$plimit = "12";


$query = mysql_query("select * from user_income where user_id = '$user_id' and type = '$income_type[4]' ");
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{
	print "<table align=\"center\"  border=0 width=500>";
	while($row1 = mysql_fetch_array($query))
	{ $tatal_amt = $tatal_amt+$row1['income']; }
	print "<tr><td align=\"center\" width=200 class=\"messageheadbox\"><strong>Total Magic Bonus</strong></td><td align=\"center\" width=200 colspan=2 class=\"messageheadbox\"><strong> $tatal_amt <font color=dark>$ </font></strong></td></tr>
		</tr><tr><td colspan=2>&nbsp;</td></tr>
		
		<tr><td align=\"center\" width=200 class=\"messageheadbox\"><strong>Date</strong></th> 
		<td align=\"center\" width=200 class=\"messageheadbox\"><strong>Amount</strong></td>
		<td align=\"center\" width=200 class=\"messageheadbox\"><strong>Incomed Id</strong></td></tr>";

	$pnums = ceil ($totalrows/$plimit);
	
	if ($newp==''){ $newp='1'; }
	
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
	
	
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }

	$query1 = mysql_query("select * from user_income where user_id = '$user_id' and type = '$income_type[4]' LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query1))
	{
		$date = $row['date'];
		$amount = $row['income'];
		$incomed_id = get_user_name($row['level']);
		print "<tr><td align=\"center\" width=200 class=\"messagemessagebox\">$date</td>
		<td align=\"center\" width=200 class=\"messagemessagebox\"> $amount <font color=dark>$ </font></td>
		<td align=\"center\" width=200 class=\"messagemessagebox\"> $incomed_id</td></tr>";
		$j = 1;
	}
print "<tr><td colspan=2>&nbsp;</td></tr><td colspan=3 height=30px width=400 class=\"messageheadbox\"><strong>";
	if ($newp>1)
	{ ?>
		<a href="<?php echo "index.php?page=magic_bonus&p=".($newp-1);?>">&laquo;</a>
	<?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ ?>
			<a href="<?php echo "index.php?page=magic_bonus&p=$i";?>"><?php print_r("$i");?></a>
			<?php 
		}
		else
		{
			 print_r("$i");
		}
	} 
	if ($newp<$pnums) 
	{ ?>
	   <a href="<?php echo "index.php?page=magic_bonus&p=".($newp+1);?>">&raquo;</a>
	<?php 
	} 
	print"</strong></td></tr></table>";
}		
else{ print "There is No information to show !"; }

?>
