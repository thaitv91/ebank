<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";

if(isset($_REQUEST['date_search']))
{
	$dte_sch = $_REQUEST['date_search'];
	$_SESSION['serch'] = $search = "select * from investment_request where date = '$dte_sch' ";
	$sql = $_SESSION['serch'];
}
else
{
	if(isset($_SESSION['serch']))
	{ $sql = $_SESSION['serch']; }
	else
	{	
		unset($_SESSION['serch']);
		$sql = "select * from investment_request";
	}
}

$query = mysql_query($sql); 

$totalrows = mysql_num_rows($query);
if($totalrows != 0)
{ ?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th colspan="5"> 
				<form method="post" action="index.php?page=commitment_info">
					Date <input id="dp1400563245101" type="text" name="date_search" />
					<input type="submit" name="submit" value="Submit"  class="btn btn-info" />
				</form>
			</th>
		</tr>
		<tr>
			<th>Sr No</th>
			<th>User Name</th>
			<th>Amount</th>
			<th>Investment</th>
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
	
	$srno = $starting_no;
	while($row = mysql_fetch_array($query))
	{  
		$rec_mode = $row['rec_mode'];
		$commitment = 'Recommitment';
		if(!in_array($row['user_id'],$arr)){
			$arr[] = $row['user_id'];
			$commitment = 'Commitment';
		}
	?>	
		<tr> 
			<td><?=$srno;?></td>
			<td><?=$user_name = get_user_name($row['user_id']);?></td>
			<td><?=$amount = $row['amount'];?></td>
			<td><?=$commitment;?></td>
			<td><?=$date = $row['date'];?></td>
	 	</tr>
	<?php
	$srno++;
	} 
  	?>
	</table>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
	if ($newp>1)
	{ ?>
		<li id="DataTables_Table_0_previous" class="paginate_button previous">
			<a href="<?="index.php?page=commitment_info&p=".($newp-1);?>">Previous</a>
		</li>
	<?php 
	}
	for ($i=1; $i<=$pnums; $i++) 
	{ 
		if ($i!=$newp)
		{ ?>
			<li class="paginate_button ">
				<a href="<?="index.php?page=commitment_info&p=$i";?>"><?php print_r("$i");?></a>
			</li>
			<?php 
		}
		else
		{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
	} 
	if ($newp<$pnums) 
	{ ?>
	   <li id="DataTables_Table_0_next" class="paginate_button next">
			<a href="<?="index.php?page=commitment_info&p=".($newp+1);?>">Next</a>
	   </li>
	<?php 
	} 
	?>
	</ul></div>
<?php 
}
else 
{  
	echo "<B style=\"color:#ff0000;\">There is no Investment to show !</B>";
	// unset($_SESSION['serch']); 
}			 
?>  
