<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "20";
$sql = "SELECT t1.*,t2.* FROM users t1
		left join ac_activation t2 on t1.id_user = t2.user_id";
//$sql = "SELECT * FROM users ";
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
?>
	<table class="table table-bordered">
		<thead>
		<tr>
			<th class="text-center">SR NO.</th>
			<th class="text-center">User Name</th>
			<th class="text-center">Name</th>
			<th class="text-center">Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">Photo Id</th>
			<th class="text-center">Selfie Id</th>
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
		$date = $row['date'];
		$photo_id = $row['photo_id'];
		$selfie_id = $row['selfie_id'];
		$date = date('d/m/Y' , strtotime($date));
		
		
		if($type == 'B') { $status = "Active"; }
		elseif($type == 'C') {  $status = "Blocked"; }
		else { $status = "Deactive"; }
		
		
		$photo_id = "<img width='50' height='50'  src=../images/profile_image/$photo_id>";
		$selfie_id = "<img width='50' height='50' src=../images/profile_image/$selfie_id>";
		
		print "<tr>
			<td class=\"text-center\">$sr_no</td>
			<td class=\"text-center\">$username</td>
			<td class=\"text-center\">$name</td>
			<td class=\"text-center\">$date</td>
			<td class=\"text-center\">$status</td>
			<td class=\"text-center\">$photo_id</td>
			<td class=\"text-center\">$selfie_id</td>
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
