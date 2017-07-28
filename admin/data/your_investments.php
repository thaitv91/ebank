<?php
session_start();
include("condition.php");

?>

<h2 align="left">Help Status</h4>	

<?php
session_start();

$id = $_SESSION['ebank_user_id'];

$newp = $_GET['p'];
$plimit = "10";

if($newp == '')
{
	$title = 'Display';
	$message = 'Display User Investments';
	data_logs($id,$title,$message,0);
}


$tamount = 0;
$q = mysql_query("select * from income_transfer where paying_id = '$id' ");
$totalrows = mysql_num_rows($q);
if($totalrows == 0)
{
	echo "There is no information to show!"; 
}
else
{
	while($row = mysql_fetch_array($q))
	{
		$update_fees = $row['update_fees'];
		$tamount = $tamount+$row['amount'];
		
	}		
	?>
	<table align=\"center\"  border=0 width=600>
	<tr>
		<td class="messageheadbox" colspan="2" align="center"><strong>Total Investment</strong></td>
		 <td class="messageheadbox" colspan="2" align="center"><strong>$ <?php print $tamount; ?></strong></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td class="messageheadbox" align="center"><strong>Date</strong></td>
		 <td class="messageheadbox" align="center"><strong>Investment</strong></td>
		 <td class="messageheadbox" align="center"><strong>Profit (%)</strong></td>
		 <td class="messageheadbox" align="center"><strong>Status</strong></td>
	  </tr>
	  

	<?php 
	
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }
	
	$q = mysql_query("select * from income_transfer where paying_id = '$id' LIMIT $start,$plimit ");
	while($r = mysql_fetch_array($q))
	{
		$date = $r['date'];
		$profit = $r['profit'];
		$investment_id = $r['investment_id'];
		$amount = $r['amount'];
		$update_fees = $r['update_fees'];
		$mode = $r['mode'];
		if($mode == 0)
			$invst_status = "Pending";
		elseif($mode == 1)
			$invst_status = "Payable";
		else
			$invst_status = "Confirm";	
				
		
		$que = mysql_query("select * from investment_request where id = '$investment_id' ");
		while($rrr = mysql_fetch_array($que))
		{
			$profit = $rrr['inv_profit'];
		}	
		
		print "<tr>
			<td  align=\"center\" class=\"messagemessagebox\">$date</td>
			<td align=\"center\" class=\"messagemessagebox\">$amount</td>
			<td align=\"center\" class=\"messagemessagebox\">$profit</td>
			<td align=\"center\" class=\"messagemessagebox\">$invst_status</td>
		  </tr>";
	}
	print "<tr><td colspan=6>&nbsp;</td></tr><td colspan=6 height=30px width=400 class=\"messageheadbox\"><strong>";
		if ($newp>1)
		{ ?>
			<a href="<?php echo "index.php?page=your_investments&open=4&p=".($newp-1);?>">&laquo;</a>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<a href="<?php echo "index.php?page=your_investments&open=4&p=$i";?>"><?php print_r("$i");?></a>
				<?php 
			}
			else
			{
				 print_r("$i");
			}
		} 
		if ($newp<$pnums) 
		{ ?>
		   <a href="<?php echo "index.php?page=your_investments&open=4&p=".($newp+1);?>">&raquo;</a>
		<?php 
		} 
		print"</strong></td></tr></table>";
	
}	
?>

