<?php
session_start();
include("condition.php");
?>
<h2 align="left"> Rewards</h2>
<p>	</p>
<form name="my_form" action="" method="post">
	<table align="center" border="0">
	 <tr>
		<td class="td_title"><p>From Date</p></td>
		<td width="200"><p><input type="text" name="from_date" id="" style="width:154px;"  class="input-medium flexy_datepicker_input"/></p></td>
		<td class="td_title"><p>To Date</p></td>
		<td width="200"><p><input type="text" name="to_date" id="" style="width:154px;"  class="input-medium flexy_datepicker_input"/></p></td>
		<td width="200"><p><input type="submit" name="submit" value="Request"  style="width:154px;"  class="btn btn-info"/></p></td>
	  </tr>
	</table>
</form>
<?php
if(isset($_REQUEST['submit']))
{		
	$_SESSION['rewd_from_date']= $from_date = $_REQUEST['from_date'];
	$_SESSION['rewd_to_date'] = $to_date = $_REQUEST['to_date'];
	
}
else
{
	 $from_date = date('Y-m-d');
	 $to_date = date('Y').'-'.date('m').'-'.(date('d')-7);
}
if(isset($_REQUEST['p']))
{
	$from_date = $_SESSION['rewd_from_date'];
	$to_date = $_SESSION['rewd_to_date'];
}
$newp = $_GET['p'];
$plimit = 15;
$sql = "SELECT tbl1.username as name, tbl1.real_parent, sum(tbl1.amount) as amnt,(tb2.amount) as 								
			self_amnt,count(*) as child
			FROM (
				SELECT t1.username AS username, t2.real_parent AS real_parent, t2.id_user,
				count(t2.id_user) , t3.id as inv_id, t4.id tran_id,
				t4.investment_id, t4.mode, sum(t4.amount) as amount
				FROM users AS t1
				INNER JOIN users AS t2 ON t1.id_user = t2.real_parent
				INNER JOIN investment_request AS t3 ON t2.id_user = t3.user_id
				AND t3.rec_mode =1
				INNER JOIN income_transfer AS t4 ON t4.paying_id = t3.user_id
				AND t3.id = t4.investment_id
				AND t4.mode =2
				AND t4.date between '$from_date' and '$to_date'
				WHERE t3.id != 'NULL'
				GROUP BY t2.real_parent, t3.user_id, t4.paying_id
				ORDER BY t2.real_parent, t2.id_user
			
			) AS tbl1
			INNER JOIN investment_request AS tb2 ON tbl1.real_parent = tb2.user_id
			AND tb2.rec_mode =1
			GROUP BY tbl1.real_parent
			order by child desc"; 
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{
	print "<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=800>
			<tr><th  height=30px width=200 class=\"message tip\"><strong>S.No.</strong></th>
				<th height=30px width=200 class=\"message tip\"><strong>Username</strong></th>
				<th width=200 class=\"message tip\"><strong>Total Direct</strong></th>
				<th width=200 class=\"message tip\"><strong>Amount</strong></th>
				<th width=200 class=\"message tip\"><strong>Self Amount</strong></th></tr>";
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
	$sql = "SELECT tbl1.username as name, tbl1.real_parent, sum(tbl1.amount) as amnt,(tb2.amount) as 								
			self_amnt,count(*) as child
			FROM (
				SELECT t1.username AS username, t2.real_parent AS real_parent, t2.id_user,
				count(t2.id_user) , t3.id as inv_id, t4.id tran_id,
				t4.investment_id, t4.mode, sum(t4.amount) as amount
				FROM users AS t1
				INNER JOIN users AS t2 ON t1.id_user = t2.real_parent
				INNER JOIN investment_request AS t3 ON t2.id_user = t3.user_id
				AND t3.rec_mode =1
				INNER JOIN income_transfer AS t4 ON t4.paying_id = t3.user_id
				AND t3.id = t4.investment_id
				AND t4.mode =2
				AND t4.date between '$from_date' and '$to_date'
				WHERE t3.id != 'NULL'
				GROUP BY t2.real_parent, t3.user_id, t4.paying_id
				ORDER BY t2.real_parent, t2.id_user
			
			) AS tbl1
			INNER JOIN investment_request AS tb2 ON tbl1.real_parent = tb2.user_id
			AND tb2.rec_mode =1
			GROUP BY tbl1.real_parent
			order by child desc
			LIMIT $start,$plimit";			
	$query = mysql_query($sql);
		 $ii = 1;			
	while($row = mysql_fetch_array($query))
	{	
		$username = $row['name'];
		$tot_dirct = $row['child'];
		$amnt = $row['amnt'];
		$self_amnt = $row['self_amnt'];
		print  "<tr>
		<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$ii</small></td>
		<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$username</small></td>
					<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$tot_dirct</small></td>
					<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$amnt</small></td>
					<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$self_amnt</small></td></tr>";
		$ii++;
	}
	print "<tr><td colspan=5>&nbsp;</td></tr><td colspan=5 height=30px width=400 class=\"message tip\"><strong>";
		if ($newp>1)
		{ ?>
			<a href="<?php echo "index.php?page=reward&p=".($newp-1);?>">&laquo;</a>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<a href="<?php echo "index.php?page=reward&p=$i";?>"><?php print_r("$i");?></a>
				<?php 
			}
			else
			{
				 print_r("$i");
			}
		} 
		if ($newp<$pnums) 
		{ ?>
		   <a href="<?php echo "index.php?page=reward&p=".($newp+1);?>">&raquo;</a>
		<?php 
		} 
		print"</strong></td></tr></table>";

}
else { print "<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=800><tr><td colspan=\"5\" width=200 class=\"td_title\">There is no logs !</td></tr></table>"; }

?>
