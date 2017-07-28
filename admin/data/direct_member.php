<?php
include("condition.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";

if((isset($_POST['submit'])) or $newp != '')
{
	if($newp == '')
	{
		$_SESSION['save_username_ednet'] = $_REQUEST['username'];
	}
	$username = $_SESSION['save_username_ednet'];
	
	$id_query = mysql_query("SELECT * FROM users WHERE username = '$username' ");
	$num = mysql_num_rows($id_query);
	if($num == 0)
	{
		print "Please enter correct Username !";
	}
	else
	{
		while($row = mysql_fetch_array($id_query))
		{
			$id = $row['id_user'];
		}
		$query = mysql_query("SELECT * FROM users WHERE real_parent = '$id' ");
		$totalrows = mysql_num_rows($query);
		if($totalrows == '')
		{
			print "$username have no child !";
		}
		else
		{ ?>
			<table class="table table-bordered">
				<thead>
				<tr><th>Total Direct members :</th>	<th colspan="2"><?=$totalrows;?></th></tr>
				<tr><th>User Name</th>	<th>Name</th>	<th>Status</th></tr>
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
				
			$query = mysql_query("SELECT * FROM users WHERE real_parent = '$id' LIMIT $start,$plimit ");		
			while($id_row = mysql_fetch_array($query))
			{
				$id = $id_row['id_user'];
				$username = get_user_name($id);
				$type = $id_row['type'];
				if($type == 'B') { $status = "Active"; }
				elseif($type == 'C') {  $status = "Blocked"; }
				else { $status = "Deactive"; }
				$name = $id_row['f_name']." ".$id_row['l_name'];
				
				print "<tr>
						<td>$username</td>
						<td>$name</td>
						<td>$status</td>
					</tr>";
			}
			?>
			</table>
			<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
			<ul class="pagination">
			<?php
			if ($newp>1)
			{ ?>
				<li id="DataTables_Table_0_previous" class="paginate_button previous">
					<a href="<?="index.php?page=direct_member&p=".($newp-1);?>">Previous</a>
				</li>
			<?php 
			}
			for ($i=1; $i<=$pnums; $i++) 
			{ 
				if ($i!=$newp)
				{ ?>
					<li class="paginate_button ">
						<a href="<?="index.php?page=direct_member&p=$i";?>"><?php print_r("$i");?></a>
					</li>
					<?php 
				}
				else
				{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
			} 
			if ($newp<$pnums) 
			{ ?>
			   <li id="DataTables_Table_0_next" class="paginate_button next" >
					<a href="<?="index.php?page=direct_member&p=".($newp+1);?>">Next</a>
			   </li>
			<?php 
			} 
			?>
			</ul></div>
			<?php
		}
	}	
}
else
{ ?>
<form name="myform" action="index.php?page=direct_member" method="post"> 
<table class="table table-bordered">
	<thead><tr><th colspan="2">User Information</th></tr></thead>
	<tr>
		<th>Enter Username :</th>
		<td><input type="text" name="username" /></td>
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" name="submit" value="submit" class="btn btn-info"  />
		</td>
	</tr>
</table>
</form>
<?php  } ?>
