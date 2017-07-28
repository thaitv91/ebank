<?php
session_start();
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/wallet_message.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
include("../function/pair_point_calculation.php");

?>

<h2 align="left">Remove Help</h4>	

<?php
session_start();

$id = $_SESSION['ebank_user_id'];

if(isset($_POST['Remove']))
{
	$inv_id = $_POST['inv_id'];
	mysql_query("update investment_request set amount = 0 , mode = 4 where id = '$inv_id' ");
	print "Success : Investment Removed Successfully !<br><br>";
}

$newp = $_GET['p'];
$plimit = "10";

$tamount = 0;
$q = mysql_query("select * from investment_request where mode = 0 ");
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
	<table align=\"center\"  border=0 width=700>
	<tr>
		<td class="message tip" colspan="2" align="center"><strong>Total Investment</strong></td>
		 <td class="message tip" colspan="3" align="center"><strong>$ <?php print $tamount; ?></strong></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td class="message tip" align="center"><strong>Username</strong></td>
		 <td class="message tip" align="center"><strong>Name</strong></td>
		 <td class="message tip" align="center"><strong>Investment</strong></td>
		 <td class="message tip" align="center"><strong>Date</strong></td>
		 <td class="message tip" align="center"><strong>Remove</strong></td>
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
	
	$q = mysql_query("select * from investment_request where mode = 0 LIMIT $start,$plimit ");
	while($r = mysql_fetch_array($q))
	{
		$date = $r['date'];
		$username = get_user_name($r['user_id']);
		$name = get_full_name($r['user_id']);
		$investment_id = $r['id'];
		$amount = $r['amount'];
		
		print "<tr>
			<td  align=\"center\" class=\"input-medium\">$username</td>
			<td align=\"center\" class=\"input-medium\">$name</td>
			<td align=\"center\" class=\"input-medium\">$amount <font color=dark>$ </font></td>
			<td  align=\"center\" class=\"input-medium\">$date</td>
			<td  align=\"center\" class=\"input-medium\">"; ?>
			<form action="index.php?page=remove _investment" method="post">
			<input type="hidden" name="inv_id" value="<?php print $investment_id; ?>" />
			<input type="submit" name="Remove" value="Remove" style="padding:2px 5px 3px 5px;" class="btn btn-info" />
			</form>
			</td>
		  </tr> <?php
	}
	print "<tr><td colspan=6>&nbsp;</td></tr><td colspan=6 height=30px width=400 class=\"message tip\"><strong>&nbsp;&nbsp;";
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

