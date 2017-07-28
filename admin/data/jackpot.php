<?php
session_start();
include("condition.php");
require("../function/functions.php");
include("../function/setting.php");
?>
<h2 align="left"> Rewards</h2>
<p>	</p>
<form name="my_form" action="" method="post">
	<table align="center" border="0">
	 <tr>
		<td class="td_title"><p>From Date</p></td>
		<td width="200"><p><input type="text" name="from_date" id="" style="width:154px;"  class="input-medium flexy_datepicker_input" required/></p></td>
		<td class="td_title"><p>To Date</p></td>
		<td width="200"><p><input type="text" name="to_date" id="" style="width:154px;"  class="input-medium flexy_datepicker_input"required/></p></td>
		<td class="td_title"><p>Amount</p></td>
		<td width="200"><p><select name="amount" class="textInput" style="width:144px; font-size:13px; color:#000000;" required>
		<?php	for($i = $setting_inv_amount; $i <= $setting_inv_end_amount; $i = $i+$setting_inv_amount)
				{ ?>
					<option <?php if($request_amount == $i) { ?> selected="selected" <?php } ?> value="<?php print $i; ?>"><?php print $i; ?> <font color=dark>$ </font></option>
		<?php		} ?>				
				</select></p></td>
		<td width="200"><p><input type="submit" name="submit" value="Request"  style="width:154px;"  class="btn btn-info"/></p></td>
	  </tr>
	</table>
</form>
<?php
if(isset($_REQUEST['submit']))
{	
	$_SESSION['jack_from_date']= $from_date = $_REQUEST['from_date'];
	$_SESSION['jack_to_date'] = $to_date = $_REQUEST['to_date'];
	$_SESSION['jack_amount'] = $amount = $_REQUEST['amount'];
	
}
else
{
	 $from_date = date('Y-m-d');
	 $to_date = date('Y').'-'.date('m').'-'.(date('d')-7);
	 $amount = 2000;
}
if(isset($_REQUEST['p']))
{
	$from_date = $_SESSION['jack_from_date'];
	$to_date = $_SESSION['jack_to_date'];
	$amount = $_SESSION['jack_amount'];
}
$newp = $_GET['p'];
$plimit = 15;
$sql = "select table1.* ,table2.*,tbl3.username,tbl3.f_name,tbl3.l_name,tbl3.real_parent,tbl3.email,tbl3.phone_no
from(
	SELECT t2.investment_id as investment_id, t1.user_id, t2.paying_id, t1.amount as amnt1,sum(t2.amount) 
	as amnt2
	FROM investment_request as t1 
	inner join income_transfer as t2
	on t1.rec_mode = 1
	and t2.investment_id = t1.id
	and t1.user_id = t2.paying_id
	and t2.mode = 2
	AND t2.date between '$from_date' and '$to_date'
	group by t2.paying_id
) as table1
inner join investment_request as table2 
on table1.investment_id = table2.id and table1.amnt2 = table2.amount and table2.rec_mode = 1
inner join users as tbl3 on tbl3.id_user = table2.user_id
where table2.amount = $amount"; 
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{
	print "<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=100%>
			<tr><th  height=30px width=200 class=\"message tip\"><strong>S.No.</strong></th>
				<th height=30px width=200 class=\"message tip\"><strong>Username</strong></th>
				<th width=200 class=\"message tip\"><strong>Name</strong></th>
				<th width=200 class=\"message tip\"><strong>Sponsor</strong></th>
				<th width=200 class=\"message tip\"><strong>Email</strong></th>
				<th width=200 class=\"message tip\"><strong>Phone No.</strong></th>
				</tr>";
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
	$sql =
	 "select table1.*,table2.*,tbl3.username,tbl3.f_name,tbl3.l_name,
	  tbl3.real_parent,tbl3.email,tbl3.phone_no
	  from(
		SELECT t2.investment_id as investment_id, t1.user_id, t2.paying_id, t1.amount as 
		amnt1,sum(t2.amount) 
		as amnt2
		FROM investment_request as t1 
		inner join income_transfer as t2
		on t1.rec_mode = 1
		and t2.investment_id = t1.id
		and t1.user_id = t2.paying_id
		and t2.mode = 2
		AND t2.date between '$from_date' and '$to_date'
		group by t2.paying_id
	 ) as table1
	 inner join investment_request as table2 
	 on table1.investment_id = table2.id and table1.amnt2 = table2.amount and table2.rec_mode = 1
	 inner join users as tbl3 on tbl3.id_user = table2.user_id
	 where table2.amount = $amount
	 LIMIT $start,$plimit";			
	$query = mysql_query($sql);
		 $ii = 1;			
	while($row = mysql_fetch_array($query))
	{	
		$username = $row['username'];
		$name = $row['f_name'].' '.$row['l_name'];
		$sponsor_id = get_user_name($row['real_parent']);
		$email = $row['email'];
		$phone_no = $row['phone_no'];
		print  "<tr>
		<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$ii</small></td>
		<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$username</small></td>
					<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$name</small></td>
					<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$sponsor_id</small></td>
					<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$email</small></td>
					<td width=200 class=\"input-small\" style=\"padding-left:0px\" align=\"center\"><small>$phone_no</small></td>
					</tr>";
		$ii++;
	}
	print "<tr><td colspan=6>&nbsp;</td></tr><td colspan=6 height=30px width=400 class=\"message tip\"><strong>";
		if ($newp>1)
		{ ?>
			<a href="<?php echo "index.php?page=jackpot&p=".($newp-1);?>">&laquo;</a>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<a href="<?php echo "index.php?page=jackpot&p=$i";?>"><?php print_r("$i");?></a>
				<?php 
			}
			else
			{
				 print_r("$i");
			}
		} 
		if ($newp<$pnums) 
		{ ?>
		   <a href="<?php echo "index.php?page=jackpot&p=".($newp+1);?>">&raquo;</a>
		<?php 
		} 
		print"</strong></td></tr></table>";

}
else { print "<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=800><tr><td colspan=\"5\" width=200 class=\"td_title\">There is no logs !</td></tr></table>"; }

?>
