<?php
include("condition.php");
include("../function/functions.php");
?>
<h2 align="left"> Total Approval Pending</h2>
<?php
$newp = $_GET['p'];
$plimit = "15";
?>
<div style="width:80%; text-align:right; height:70px;">
<form action="index.php?page=approval_pending" method="post"><font style="color:#002953; font-style:normal;">User Id : </font>
<input type="text" name="search_username"  />
<input type="submit" name="Search" value="Search" class="btn btn-info" />
</form>
</div>


<?php
$qur_set_search = '';
if((isset($_POST['Search'])) or ((isset($newp)) and (isset($_POST['search_username']))))
{
	if(!isset($newp))
	{
		$search_username = $_POST['search_username'];
		$search_id = get_new_user_id($search_username);
		if($search_id == 0)
			print "<div style=\"width:80%; text-align:right; color:#FF0000; font-style:normal; font-size:14px; height:50px; padding-right:100px;\">Enter Correct User Id !</div>";
		else
		{
			$_SESSION['session_search_username'] = $search_id;
			$qur_set_search = " and paying_id = '$search_id' ";
		}	
	}
	else
	{	
		$search_id = $_SESSION['session_search_username'];
		$qur_set_search = " and paying_id = '$search_id' ";
	}		
}
else
{
	unset($_SESSION['session_search_username']);
}

print "
	<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 height=\"40\" width=100%>";

$total_investment_amount = 0;
$que1 = mysql_query("SELECT sum(amount) FROM income_transfer where mode = 1 $qur_set_search ");
while($r1 = mysql_fetch_array($que1))
		$total_investment_amount = $r1[0];
		$total_investment_amount_usd = round($total_investment_amount/$usd_value_current,2);
if($total_investment_amount >0)
{		
	print "<tr>
	<th colspan=3  class=\"message tip1\"><strong>Total Approvals</strong></th>
	<th colspan=3 class=\"message tip1\" style=\"text-align:left; padding-left:10px;\"><strong>$$total_investment_amount_usd <font color=DodgerBlue>USD</font> Or  $total_investment_amount <font color=dark>$ </font></strong></th>
	</tr>
	<tr>
	<th class=\"message tip1\"><strong>Payee Id</strong></th>
	<th class=\"message tip1\"><strong>Payee Name</strong></th>
	<th class=\"message tip1\"><strong>E-mail</strong></th>
	<th class=\"message tip1\"><strong>Investment</strong></th>
	<th class=\"message tip1\"><strong>Receiver Id</strong></th>
	<th class=\"message tip1\"><strong>Receiver Name</strong></th>
	</tr>";
	
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
	
	
	$query = mysql_query("SELECT * FROM income_transfer where mode = 1 $qur_set_search order by id desc LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		$paying_id  = $row['paying_id'];
		$user_id = $row['user_id'];
		$amount = $row['amount'];
		$amount_usd = round($amount/$usd_value_current,2);
		$mode = $row['mode'];
		if($mode == 0)
			$inv_status = "Current Comming";
		elseif($mode == 1)
			$inv_status = "Current Wait For Approval";
		else
			$inv_status = "Current Approval";
			
		$que = mysql_query("SELECT * FROM users where id_user = '$paying_id' ");
		while($rrr = mysql_fetch_array($que))
		{
			$username = $rrr['username'];
			$email = $rrr['email'];
			$phone_no = $rrr['phone_no'];
			$beneficiery_name = $rrr['beneficiery_name'];
			$ac_no = $rrr['ac_no'];
			$bank = $rrr['bank'];
			$bank_code = $rrr['bank_code'];
			$name = $rrr['f_name']." ".$rrr['l_name'];	
		}	
		
		$recvr_id = get_user_name($user_id);
		$recvr_name = get_full_name($user_id);
		$recvr_phone_no = get_user_phone($user_id);
		
		print "<tr>
		<td class=\"input-medium\" style=\"padding-left:10px; width:200px; color:$col;\">$username</td>
		<td class=\"input-medium\" style=\"padding-left:10px; color:$col;\"><small>$name ( $phone_no )</small></td>
		<td class=\"input-medium\" style=\"padding-left:10px; color:$col;\"><small>$email</small></td>
		<td class=\"input-medium\" style=\"padding-left:10px; width:160px; color:$col;\"><small>$$amount_usd <font color=DodgerBlue>USD</font> Or  $amount <font color=dark>$ </font></small></td>
		<td class=\"input-medium\" style=\"padding-left:10px; width:160px; color:$col;\"><small>$recvr_id</small></th>
		<td class=\"input-medium\" style=\"padding-left:10px; width:200px; color:$col;\"><small>$recvr_name ( $recvr_phone_no )</small></td>
		</tr>";
			
	}
	print "<tr><td colspan=4>&nbsp;</td></tr><td style=\"padding-left:10px;\" colspan=11 height=30px width=400 class=\"message tip\"><strong>";
	if ($newp>1)
	{ ?>
		<a href="<?php echo "index.php?page=approval_pending&p=".($newp-1);?>">&laquo;</a>
	<?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ ?>
			<a href="<?php echo "index.php?page=approval_pending&p=$i";?>"><?php print_r("$i");?></a>
			<?php 
		}
		else
		{
			 print_r("$i");
		}
	} 
	if ($newp<$pnums) 
	{ ?>
	   <a href="<?php echo "index.php?page=approval_pending&p=".($newp+1);?>">&raquo;</a>
	<?php 
	} 
	print"</strong></td></tr>";
}
else
{	
	print "<tr><td>No Information Found !</td></tr></table>";
}
?>
