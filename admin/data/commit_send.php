<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";
$sql = $sql = "SELECT  user_id, paying_id,mode,payment_receipt,
			 CASE 
				 WHEN mode = 0 THEN 'Request Pending'
				 WHEN mode = 1 THEN 'Approvel Request Pending'
				 WHEN mode = 2 THEN 'Request Approve'
				 WHEN mode = 10 THEN 'Request Approve By Admin'
			 END as status
			,amount, date
			FROM income_transfer";
if($_REQUEST['username'] != '')
{
	 $username = $_REQUEST['username'];
	 $paying_id = get_user_id($username);
	 $sql1 = $sql." paying_id = '$paying_id' and mode !=10 ";
}

if($_REQUEST['date_search'] != '')
{
	 $dte_sch = $_REQUEST['date_search'];
	 $sql1 = $sql." date = '$dte_sch' and mode !=10 ";
}

if($_REQUEST['date_search'] != '' and $_REQUEST['username'] != '')
{
	$username = $_REQUEST['username'];
	$name = $username;
	$paying_id = get_user_id($username);
	$sql1 = $sql." paying_id = '$paying_id' and date = '$dte_sch' and mode !=10 ";
}
if($_REQUEST['date_search'] == '' and $_REQUEST['username'] == '')
{
	
	$sql1 = "SELECT user_id, paying_id,mode,payment_receipt,
			 CASE 
				 WHEN mode = 0 THEN 'Request Pending'
				 WHEN mode = 1 THEN 'Approvel Request Pending'
				 WHEN mode = 2 THEN 'Request Approve'
			 END as status
			,amount, date
			
			FROM income_transfer
			where mode !=10";
}

$query = mysql_query($sql1); 
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{ ?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th colspan="7" class="text-right">
			<form method="post" action="index.php?page=commit_send">
				Username <input type="text" name="username" />
				Date <input id="dp1400563245101" type="text" name="date_search" />
				<input type="submit" name="submit" value="Submit"  class="btn btn-info" />
			</form>
			</th>
		</tr>
		<tr>
			<th>Sr No</th>
			<th>Giver</th>
			<th>Receiver</th>
			<th>Status</th>
			<th>Amount</th>
			<th>Receipt</th>
			<th>Date</th>
		</tr>
		</thead>
	<?php
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; } 
	$sql = $sql1." LIMIT $start,$plimit ";
	$query = mysql_query($sql); 
	$srno = $plimit*($newp-1);
	while($row = mysql_fetch_array($query))
	{  
		$srno++;
		$mode = $row['mode'];
		$Receipt = $row['payment_receipt'];
		$rp = '';
		if($mode != 0 and $mode != 10)
		{
			$rp = "<a href=\"payment_receipt.php?rp=$Receipt&m=1\" target=\"_blank\">Click View</a>";
		}
		else{
			$rp = "&nbsp;";
		}
		?>
		<tr> 
			<td><?=$srno;?></td>
			<td><?=$giver_name = get_user_name($row['paying_id']);?></td>
			<td><?=$user_name = get_user_name($row['user_id']);?></td>
			<td><?=$status = $row['status'];?> </td>
			<td><?=$amount = $row['amount'];?><font color=dark>$ </font></td>
			<td><?=$rp;?></td>
			<td><?=$date = $row['date'];?></td>
	 	</tr>
	<?php	
	$amount1 = $amount1+$row['amount'];
	} 
  ?>
	</table>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
	if ($newp>1)
	{ ?>
		<li id="DataTables_Table_0_previous" class="paginate_button previous">
			<a href="<?="index.php?page=commit_send&p=".($newp-1);?>">Previous</a>
		</li>
	<?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ ?>
			<li class="paginate_button ">
				<a href="<?="index.php?page=commit_send&p=$i";?>"><?php print_r("$i");?></a>
			</li>
			<?php 
		}
		else
		{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
	} 
	if ($newp<$pnums) 
	{ ?>
	   <li id="DataTables_Table_0_next" class="paginate_button next">
			<a href="<?="index.php?page=commit_send&p=".($newp+1);?>">Next</a>
	   </li>
	<?php 
	} 
	?>
	</ul></div>
<?php 
}
else { echo "<B style=\"color:#ff0000;\">No Information Found !</B>"; }