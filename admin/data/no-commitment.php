<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";


$sql = "SELECT t1.*,t2.user_id FROM `users` t1 
		left join `investment_request` t2 on t1.id_user = t2.user_id 
		where t2.user_id is NULL
		group by t1.id_user,t2.user_id 
		order by t1.id_user";
$query = mysql_query($sql); 

$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{ ?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th colspan="6" class="text-right">
			<form method="post" action="index.php?page=commit_receive">
				Date <input id="dp1400563245101" type="text" name="date_search" />
				<input type="submit" name="submit" value="Submit"  class="btn btn-info" />
			</form>
			</th>
		</tr>
		<tr>
			<th>Sr No</th>
			<th>User Name</th>
			<th>Full Name</th>
			<th>Email</th>
			<th>Phone</th>
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
		$username = $row['username'];
		$fullname = $row['f_name']."&nbsp;".$row['l_name'];
		$email = $row['email'];
		$phone = $row['phone_no'];
	?>
		<tr> 
			<td><?=$srno;?></td>
			<td><?=$username;?></td>
			<td><?=$fullname;?></td>
			<td><?=$email;?> </td>
			<td><?=$phone;?></td>
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
			<a href="<?="index.php?page=no-commitment&p=".($newp-1);?>">Previous</a>
		</li>
	<?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ ?>
			<li class="paginate_button ">
				<a href="<?="index.php?page=no-commitment&p=$i";?>"><?php print_r("$i");?></a>
			</li>
			<?php 
		}
		else
		{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
	} 
	if ($newp<$pnums) 
	{ ?>
	   <li id="DataTables_Table_0_next" class="paginate_button next">
			<a href="<?="index.php?page=no-commitment&p=".($newp+1);?>">Next</a>
	   </li>
	<?php 
	} 
	?>
	</ul></div>
<?php 
}
else 
{ 
	echo "<B style=\"color:#ff0000;\">There is no Investment to show !!</B>"; 
	// unset($_SESSION['serch']); 
}
?>  
