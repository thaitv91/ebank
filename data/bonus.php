<?php
session_start();
include("condition.php");
include("function/setting.php");
$user_id = $_SESSION['ebank_user_id'];

$newp = $_GET['p'];
$plimit = "12";

$query = mysql_query("select * from user_income where user_id = '$user_id' order by date DESC");
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{ 
	while($row1 = mysql_fetch_array($query))
	{ $total_amt = $total_amt+$row1['income']; }
?>
	<table id="example2" class="table table-bordered table-hover">
		<tr>
			<th colspan="2"><?=$Total_Income;?></th>
			<th colspan="2"><?=$total_amt?><font color=dark> <?=$inr;?></font></th>
		</tr>
		<tr>
			<th class="text-center" width="8%"><?=$sr_no;?></th>
			<th class="text-center"><?=$Bonus_Date;?></th>
			<th class="text-center"><?=$Bonus_Amount;?></th>
			<th><?=$Bonus_Type;?></th>
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
	
	$sr_no = $start+1;
	$query1 = mysql_query("select * from user_income where user_id = '$user_id'  order by date DESC LIMIT $start,$plimit" );
	while($row = mysql_fetch_array($query1))
	{
		$date = $row['date'];
		$amount = $row['income'];
		$type = $row['type'];
		$date = date('d/m/Y' , strtotime($date));
		
		if($type == 1){ $type = $Investment_Income;}
		elseif($type == 3){ $type = $Level_Income;}
		elseif($type == 4){ $type = $ten_manager;}
		elseif($type == 5){ $type = $hundred_manager;}
		elseif($type == 6){ $type = $Investment_Daily_Income;}
		elseif($type == 7){ $type = $Manager_Income;}
		elseif($type == 8){ $type = $Speed_Bonus_Income;}
		elseif($type == 9){ $type = $Confirmation_Bonus_Income;}
	?>	
		<tr>
			<td class="text-center"><?=$sr_no;?></td>
			<td class="text-center"><?=$date;?></td>
			<td class="text-center"><?=$amount;?> <font color=dark><?=$inr;?></font></td>
			<td><?=$type;?></td>
		</tr>
	<?php	
		$sr_no++;
	}?>
	</table>
	<div class="col-xs-6">
		<div class="dataTables_paginate paging_bootstrap">
			<ul class="pagination">
				<?php
				if ($newp>1)
				{ ?> 
					<li class="prev">
						<a href="<?="index.php?page=bonus&p=".($newp-1);?>">&larr; <?=$Previous;?></a>
					</li> <?php  
				}
				for ($i=1; $i<=$pnums; $i++) 
				{ 
					if ($i!=$newp)
					{ ?>
						<li><a href="<?="index.php?page=bonus&p=$i";?>"><?php print_r("$i");?></a></li>
						<?php 
					}
					else
					{ ?><li class="active"><a href="#"><?php print_r("$i"); ?></a></li> <?php }
				} 
				if ($newp<$pnums) 
				{ ?> 
					<li class="next">
						<a href="<?php echo "index.php?page=bonus&p=".($newp+1);?>"><?=$Next;?> &rarr;</a>
					</li> <?php  
				} ?>
			</ul>
		</div>
	</div>
	<?php
}		
else{ echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>"; }

?>