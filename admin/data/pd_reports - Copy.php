<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";
 /*$sql = "SELECT  t1.user_id, t1.mode, t2.paying_id,t2.payment_receipt,t2.mode,
			 CASE 
				 WHEN t1.mode = 1 and t2.mode = 0 THEN 'Request Pending'
				 WHEN t1.mode = 0 and t2.mode = 1 THEN 'Request in Process'
				 WHEN t1.mode = 0 and t2.mode = 2 THEN 'Request Approve'
			 END as status ,t1.amount, t1.date FROM investment_request t1 
			LEFT JOIN income_transfer t2 on t1.id = t2.investment_id";*/
print $sql = "SELECT t1.* , t1.user_id , t2.mode as int_mode ,t2.user_id , t2.paying_id FROM investment_request t1 
LEFT JOIN income_transfer t2 on t1.id = t2.investment_id ";
			
$query = mysql_query($sql); 
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{ ?>
	<table class="table table-bordered">  
		<thead>
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
	$sql = $sql." LIMIT $start,$plimit ";
	$query = mysql_query($sql); 
	$srno = $plimit*($newp-1);
	while($row = mysql_fetch_array($query))
	{  
		$srno++;
		$paying_id = $row['paying_id'];
		$user_id = $row['user_id'];
		$mode = $row['mode'];
		$status = $row['status'];
		$amount = $row['amount'];
		$Receipt = $row['payment_receipt'];
		$date = $row['date'];
		$date = date('d/m/Y' , strtotime($date));
		
		$rp = '';
		if($mode != 1)
		{
			$rp = "<a href=\"payment_receipt.php?rp=$Receipt&m=1\" target=\"_blank\">Click View</a>";
		}
		else{
			$rp = "&nbsp;";
		}
		
		if($mode == 1){ $status = "Request processed"; }
			
		elseif($mode == 0 and $int_mode == 0)
		{ 
			$status = "Request in Processing"; 
		}
		
		elseif($mode == 0 and $int_mode == 1)
		{ $status = "Request Pending"; }
		
		elseif($mode == 0 and $int_mode == 2)
		{ 
			$status = "Request Confirmed"; 
		}
		?>
		<tr> 
			<td><?=$srno;?></td>
			<td><?=$giver_name = get_user_name($paying_id);?></td>
			<td><?=$user_name = get_user_name($user_id);?></td>
			<td><?=$status;?> </td>
			<td><?=$amount;?><font color=dark>$ </font></td>
			<td><?=$rp;?></td>
			<td><?=$date;?></td>
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