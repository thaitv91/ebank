<?php
$newp = $_GET['p'];
$plimit = "15";
$my_id=$_SESSION['ebank_user_id'];

$sql="SELECT t2.username, t3.username,t1.amount,t1.date,t1.mode FROM income_transfer t1 
LEFT JOIN users t2 ON t1.user_id=t2.id_user 
LEFT JOIN users t3 ON t1.paying_id=t3.id_user 
where paying_id IN (SELECT id_user FROM users where real_parent='$my_id')";

$querya = mysql_query($sql);
$totalrows = mysql_num_rows($querya);
if($totalrows == 0)
{
	echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>"; 
}
else 
{ ?>
<table id="example2" class="table table-bordered table-hover">
	<tr>
		<th><?=$giver_name;?></th>	
		<th><?=$rec_name;?></th>
		<th><?=$amount;?></th>
		<th><?=$date;?></th>
		<th><?=$Status;?></th>
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
	$query = mysql_query("$sql LIMIT $start,$plimit ");

	while($row = mysql_fetch_array($query))
	{
		$date = $row[3];
		$date = date('d/m/Y' , strtotime($date));
		
		if($row[4]!=2){$states="<B style=\"color:#CC0000;\">Pending</B>";}
		else{$states="<B style=\"color:#008000;\">Confirm</B>";}
	?>
		<tr>
			<td><?=$row[1];?></td>			
			<td><?=$row[0];?></td>
			<td><?=$row[2];?></td>				
			<td><?=$date;?></td>
			<td><?=$states;?></td>	
		</tr>
	<?php
	}
?>
</table>
	<div class="col-xs-6">
	<div class="dataTables_paginate paging_bootstrap">
	<ul class="pagination">
		<?php
		if ($newp>1)
		{ ?> 
			<li class="prev">
				<a href="<?="index.php?page=downline_pd&p=".($newp-1);?>">&larr; <?=$Previous;?></a>
			</li> <?php  
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li><a href="<?="index.php?page=downline_pd&p=$i";?>"><?php print_r("$i");?></a></li>
				<?php 
			}
			else
			{ ?><li class="active"><a href="#"><?php print_r("$i"); ?></a></li> <?php }
		} 
		if ($newp<$pnums) 
		{ ?> 
			<li class="next">
			<a href="<?php echo "index.php?page=downline_pd&p=".($newp+1);?>"><?=$Next;?> &rarr;</a>
			</li> <?php  
		} ?>
	</ul>
	</div>
	</div>
<?php }?>