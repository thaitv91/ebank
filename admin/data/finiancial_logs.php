<?php
session_start();
include("condition.php");
include("../function/logs_messages.php");

$newp = $_GET['p'];
$plimit = "15";

$query = mysql_query("select * from logs where type = '$log_type[4]' ");
$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{?>
<table class="table table-bordered">
	<thead>
	<tr>
		<th>Date</th>
		<th>Title</th>
		<th>Massage</th>
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
				
	$query = mysql_query("select * from logs where type = '$log_type[4]' LIMIT $start,$plimit ");			
	while($row = mysql_fetch_array($query))
	{
		$title = $row['title'];
		$message = $row['message'];
		$date = $row['date'];
		echo  "
			<tr>
				<td>$date</td>
				<td>$title</td>
				<td>$message </td>
			</tr>";
	}
	print "</table>";
	?>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
	if ($newp>1)
	{ ?>
		<li id="DataTables_Table_0_previous" class="paginate_button previous">
			<a href="<?="index.php?page=finiancial_logs&p=".($newp-1);?>">Previous</a>
		</li>
	<?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ ?>
			<li class="paginate_button ">
				<a href="<?="index.php?page=finiancial_logs&p=$i";?>"><?php print_r("$i");?></a>
			</li>
			<?php 
		}
		else
		{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
	} 
	if ($newp<$pnums) 
	{ ?>
	   <li id="DataTables_Table_0_next" class="paginate_button next" >
			<a href="<?="index.php?page=finiancial_logs&p=".($newp+1);?>">Next</a>
	   </li>
	<?php 
	} 
	?>
	</ul></div>
	<?php
}
else { echo "<B style=\"color:#ff0000;\">There are no logs !</B>"; }
?>
