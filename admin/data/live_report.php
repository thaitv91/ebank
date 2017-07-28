<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";
?>
<div style="width:100%; text-align:right; height:40px;">
<form action="index.php?page=live_report" method="post">
	<font style="color:#002953; font-style:normal;">User Id : </font>
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
			$qur_set_search = " where paying_id = '$search_id' ";
		}	
	}
	else
	{	
		$search_id = $_SESSION['session_search_username'];
		$qur_set_search = " where paying_id = '$search_id' ";
	}		
}
else
{
	unset($_SESSION['session_search_username']);
}
$total_investment_amount = 0;
$que1 = mysql_query("SELECT sum(amount) FROM income_transfer $qur_set_search ");
while($r1 = mysql_fetch_array($que1))
		$total_investment_amount = $r1[0];
if($total_investment_amount >0)
{ ?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th colspan=2>Total Approvals</th>
			<th colspan=4><?=$total_investment_amount;?> <font color=dark>$ </font></th>
		</tr>
		<tr>
			<th>Payee Id</th>
			<th>Payee Name</th>
			<th>E-mail</th>
			<th>Investment</th>
			<th>Receiver Id</th>
			<th>Receiver Name</th>
		</tr>
		</thead>
	<?php
	$query = mysql_query("SELECT * FROM income_transfer $qur_set_search");
	$totalrows = mysql_num_rows($query);
	
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
	
	
	$query = mysql_query("SELECT * FROM income_transfer $qur_set_search order by id desc LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		$paying_id  = $row['paying_id'];
		$user_id = $row['user_id'];
		$amount = $row['amount'];
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
			$name = ucfirst($rrr['f_name'])." ".ucfirst($rrr['l_name']);	
		}	
		
		$recvr_id = get_user_name($user_id);
		$recvr_name = ucfirst(get_full_name($user_id));
		$recvr_phone_no = get_user_phone($user_id);
		?>
		<tr> 
			<td><?=$username;?></td>
			<td><?=$name;?> ( <?=$phone_no;?> )</td>
			<td><?=$email;?></td>
			<td><?=$amount;?> <font color=dark>$ </font></td>
			<td><?=$recvr_id;?></td>
			<td><?=$recvr_name;?> ( <?=$recvr_phone_no;?> )</td>
	 	</tr>
	<?php			
	}
	?>
	</table>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
	if ($newp>1)
	{ ?>
		<li id="DataTables_Table_0_previous" class="paginate_button previous">
			<a href="<?="index.php?page=live_report&p=".($newp-1);?>">Previous</a>
		</li>
	<?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ ?>
			<li class="paginate_button ">
				<a href="<?="index.php?page=live_report&p=$i";?>"><?php print_r("$i");?></a>
			</li>
			<?php 
		}
		else
		{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
	} 
	if ($newp<$pnums) 
	{ ?>
	   <li id="DataTables_Table_0_next" class="paginate_button next">
			<a href="<?="index.php?page=live_report&p=".($newp+1);?>">Next</a>
	   </li>
	<?php 
	} 
	?>
	</ul></div>
<?php 
}
else
{ echo "<B style=\"color:#ff0000;\">No Information Found !</B>"; }
?>