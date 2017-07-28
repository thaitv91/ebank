<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "20";
if(isset($_REQUEST['active']) and $_REQUEST['active'] == 'Activate')
{
	$id = $_REQUEST['id'];
	$sql = "update users set type='B' where id_user ='$id'";
	$query = mysql_query($sql);
	$time_confirm = date("Y-m-d H:i:s",strtotime($systems_date.date("H:i:s")));
	$sql = "update income_transfer set mode='2',time_confirm='$time_confirm' where paying_id ='$id' and type=1 and mode=0";
	$query = mysql_query($sql);
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=join_member\"";
	echo "</script>";
}
$sql ="SELECT t1.* FROM users t1
	  inner join income_transfer t2 on t1.id_user = t2.paying_id
	  where t1.type='A' and t2.type=1 and t2.mode=0
	  group by t1.id_user";
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
if($totalrows == 0)
{
	echo "<B style=\"color:#FF0000;\">There is no information !!</B>";
}
else{
?>
	<table class="table table-bordered">
		<thead>
		<tr>
			<th class="text-center">SR NO.</th>
			<th class="text-center">User Name</th>
			<th class="text-center">Name</th>
			<th class="text-center">Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">&nbsp;</th>
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
	
	$sr_no = $plimit*($newp-1);
	
	$query = mysql_query("$sql LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		$sr_no++;
		$id = $row['id_user'];
		$username = get_user_name($id);
		$name = $row['f_name']." ".$row['l_name'];
		$type = $row['type'];
		if($type == 'B') { $status = "Active"; }
		elseif($type == 'C') {  $status = "Blocked"; }
		else { $status = "Deactive"; }
		$date = $row['activate_date'];
		$form = "<form method='post'>
					<input type='hidden' name='id' value='$id'>
					<input type='submit' name='active' value='Activate' class='btn btn-info'>
				</form>";
		print "<tr>
			<td class=\"text-center\">$sr_no</td>
			<td class=\"text-center\">$username</td>
			<td class=\"text-center\">$name</td>
			<td class=\"text-center\">$date</td>
			<td class=\"text-center\">$status</td>
			<td class=\"text-center\">$form</td>
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
				<a href="<?="index.php?page=member_list&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=member_list&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=member_list&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
		</ul></div>
<?php } ?>
