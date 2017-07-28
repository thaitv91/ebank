<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";

$query = mysql_query("select * from add_funds where ( mode = 1 or mode = 2 ) and amount > 0 ");
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{ ?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th class="text-center">User Name</th>
			<th class="text-center">Request Amount</th>
			<th class="text-center">Status</th>
			<th class="text-center">Pay Mode</th>
			<th class="text-center">Information</th>
			<th class="text-center">Request Date</th>
			<th class="text-center">Cancelled Date</th>
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
	
	$query = mysql_query("select * from add_funds where ( mode = 1 or mode = 2 ) and amount > 0 
	LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		$id = $row['id'];
		$u_id = $row['user_id'];
		$username = get_user_name($u_id);
		$request_amount = $row['amount'];
		$request_amount_usd = round($request_amount/$usd_value_current,2);
		$paid_date = $row['app_date'];
		$date = $row['date'];
		$payment_mode = $row['payment_mode'];
		$information = $row['information'];
		$mode = $row['mode'];
		if($mode == 1)
			$pay_mode = "Accepted";
		else	
			$pay_mode = "Cancelled";
		?>
		<tr>
			<td class="text-center"><?=$username;?></td>
			<td class="text-center"><?=$request_amount;?> <font color=dark>$ </font></td>	
			<td class="text-center"><?=$pay_mode;?></td>	
			<td class="text-center"><?=$payment_mode;?></td>	
			<td class="text-center"><?=$information;?></td>	
			<td class="text-center"><?=$date;?></td>	
			<td class="text-center"><?=$paid_date;?></td>	
		</tr>	
<?php		
	} ?>
	</table>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=approved_add_funds&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=approved_add_funds&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=approved_add_funds&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
	</ul>
	</div>
<?php
}
else{ echo "<B style=\"color:#FF0000;\">There is no fund for approved !!</B>"; }
?>

