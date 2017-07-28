<?php
session_start();
include("condition.php");
include("function/setting.php");
include("function/all_month.php");	
?>
<h2 align="left">Team History</h2>	
<center>
<?php


$user_id = $_SESSION['ebank_user_id'];

$newp = $_GET['p'];
$plimit = "12";

if($newp == '')
{
	$title = 'Display';
	$message = 'Display Network History';
	data_logs($user_id,$title,$message,0);
}


$query1 = mysql_query("select * from logs where user_id = '$user_id' and type = '$log_type[3]' ");
$totalrows = mysql_num_rows($query1);
if($totalrows != 0)
{
	print "<table align=\"center\" border=0 width=600>
			<tr><th width=200 class=\"messageheadbox\"><strong>Date</strong></th>
				<th width=200 class=\"messageheadbox\"><strong>Title</strong></th>
				<th width=200 class=\"messageheadbox\"><strong>Massage</strong></th></tr>";
				
	$pnums = ceil ($totalrows/$plimit);
	
	if ($newp==''){ $newp='1'; }
	
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
	
	
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }
				
	$query = mysql_query("select * from logs where user_id = '$user_id' and type = '$log_type[3]'  LIMIT $start,$plimit ");		
	while($row = mysql_fetch_array($query))
	{
		$title = $row['title'];
		$message = $row['message'];
		$date = $row['date'];
		print  "<tr><td class=\"messagemessagebox\" width=200 style=\"padding-left:80px\"><small>$date</small></td>
					<td class=\"messagemessagebox\" width=200 style=\"padding-left:70px\"><small>$title</small></td>
					<td class=\"messagemessagebox\" width=200 style=\"padding-left:45px\"><small>$message</small></td></tr>";
	}
	print "<tr><td colspan=3>&nbsp;</td></tr><td colspan=3 height=30px width=400 class=\"messageheadbox\"><strong>";
	if ($newp>1)
	{ ?>
		<a href="<?php echo "index.php?page=network_logs&p=".($newp-1);?>">&laquo;</a>
	<?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ ?>
			<a href="<?php echo "index.php?page=network_logs&p=$i";?>"><?php print_r("$i");?></a>
			<?php 
		}
		else
		{
			 print_r("$i");
		}
	} 
	if ($newp<$pnums) 
	{ ?>
	   <a href="<?php echo "index.php?page=network_logs&p=".($newp+1);?>">&raquo;</a>
	<?php 
	} 
	print"</strong></td></tr></table>";
	
}
else { print "<tr><td colspan=\"3\" width=200 class=\"td_title\">There is no logs !</td></tr></table>"; }


?>

</center>