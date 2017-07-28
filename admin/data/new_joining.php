<?php
session_start();
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";

$id = $_SESSION['id'];
$date = date('Y-m-d');
$query = mysql_query("SELECT * FROM users WHERE date = '$date' ");
$totalrows = mysql_num_rows($query);
if($totalrows > 0)
{ ?>
<table class="table table-bordered">
	<thead>
	<tr>
		<th class="text-center">User Name</th>
		<th class="text-center">Name</th>
		<th class="text-center">Date</th>
		<th class="text-center">Status</th>
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
	
	
	$query = mysql_query("SELECT * FROM users where date = '$date' LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		$id = $row['id_user'];
		$username = get_user_name($id);
		$name = $row['f_name']." ".$row['l_name'];
		$type = $row['type'];
		if($type == 'B') { $status = "Active"; }
		elseif($type == 'C') {  $status = "Blocked"; }
		else { $status = "Deactive"; }
		$date = $row['date'];
		print "<tr>
			<td class=\"text-center\">$username</td>
			<td class=\"text-center\">$name</td>
			<td class=\"text-center\">$date</td>
			<td class=\"text-center\">$status</th>
		</tr>";
			
	}
	echo "</table>";
	?>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=new_joining&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=new_joining&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=new_joining&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
		</ul></div>
	<?php	
}
else { echo "<B style=\"color:#ff0000;\">There are No Joining to Show !!</B>"; }		

?>
