<?php
session_start();
include("condition.php");
include("../function/functions.php");


$newp = $_GET['p'];
$plimit = "15";

$id = $_SESSION['id'];
$date = date('Y-m-d');
$query = mysql_query("SELECT * FROM users ");
$totalrows = mysql_num_rows($query);
if($totalrows > 0)
{
print "

	<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 height=\"40\" width=50%>
	<tr>
	<th colspan=2 class=\"message tip\" height=40><strong style=\"font-size:20px\">To Create Excel File <a href=\"index.php?page=create_excel_file_phone\">Click Here</a></strong></th>
	</tr>
	<tr>
	<th>&nbsp;</th>
	</tr>
	<tr>
	<th  height=40 class=\"message tip\"><strong>Name</strong></th>
	<th class=\"message tip\"><strong>Phone No.</strong></th>
	</tr>";
	
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
	
	
	$query = mysql_query("SELECT * FROM users LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		//$id = $row['id_user'];
		//$username = get_user_name($id);
		$name = $row['f_name']." ".$row['l_name'];
		$phone = $row['phone_no'];
		
		$alert_email = $row['alert_email'];
		print "<tr>
		<td class=\"input-medium\" style=\"padding-left:25px\"><small>$name</small></td>
		<td class=\"input-medium\" style=\"padding-left:45px\"><small>$phone</small></td>
		</tr>";
			
	}
	print "<tr><td colspan=2>&nbsp;</td></tr><td colspan=2 height=30px width=400 class=\"message tip\"><strong>";
		if ($newp>1)
		{ ?>
			<a href="<?php echo "index.php?page=all_users_phone&p=".($newp-1);?>">&laquo;</a>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<a href="<?php echo "index.php?page=all_users_phone&p=$i";?>"><?php print_r("$i");?></a>
				<?php 
			}
			else
			{
				 print_r("$i");
			}
		} 
		if ($newp<$pnums) 
		{ ?>
		   <a href="<?php echo "index.php?page=all_users_phone&p=".($newp+1);?>">&raquo;</a>
		<?php 
		} 
		print"</strong></td></tr></table>";
}
else{ print "There is no joining to Show !!"; }
?>
