<?php
session_start();
include("condition.php");

$newp = $_GET['p'];
$plimit = "25";

$q = mysql_query("select * from users ");
$totalrows = mysql_num_rows($q);
?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th class="text-center">User Name</th>
			<th class="text-center">IP Address</th>
			<th class="text-center">Wallet Amount</th>
			<th class="text-center">E-mail</th>
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
	
	$q1 = mysql_query("select * from users LIMIT $start,$plimit ");		
	
	while($id_row = mysql_fetch_array($q1))
	{
		$id_user = $id_row['id_user'];
		$username = $id_row['username'];
		$email = $id_row['email'];			
		$query = mysql_query("select * from wallet where id = '$id_user' ");
		$num = mysql_num_rows($query);
		while($row = mysql_fetch_array($query))
		{
			$amount = $row['amount'];
			$amount_usd = round($amount/$usd_value_current,2);
		}
		$query = mysql_query("select * from ips_address where user_id = '$id_user' order by 
		id desc limit 1 ");
		$num = mysql_num_rows($query);
		if($num > 0)
		{
			while($row = mysql_fetch_array($query))
			{ 
				$ip_add = $row['ip_add'];
			}
		}
		else { $ip_add = ''; }	
		?>
		<tr>
			<td class="text-center"><?=$username;?></td>
			<td class="text-center"><?=$ip_add;?></td>	
			<td class="text-center"><?=$amount;?> <font color=dark>$ </font></td>	
			<td class="text-center"><?=$email;?></td>	
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
				<a href="<?="index.php?page=all_user_amount&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=all_user_amount&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=all_user_amount&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
	</ul>
	</div>

	
