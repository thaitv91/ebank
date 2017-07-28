<?php

include("condition.php");
include("../function/functions.php");
?>
<h2 align="left"> Direct Member</h2>
<?php


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
		{
			print "<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 height=\"40\" width=700>
					<tr><td height=30 class=\"message tip\"><strong>Total Direct members :</strong></td>
					<td colspan=2 class=\"message tip\"><strong>&nbsp; $totalrows</strong></td></tr>
					<tr><td colspan=3>&nbsp;</td></tr>
					<tr><td height=30 class=\"message tip\"><strong>User Name</strong></td>
						<td class=\"message tip\"><strong>Name</strong></td>
						<td class=\"message tip\"><strong>Status</strong></td>
					</tr>";
					
				
		
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
				print "<tr><td class=\"input-medium\">$username</td>
							<td class=\"input-medium\">$name</td>
							<td class=\"input-medium\">$status</td>
							</tr>";
			}
			print "<tr><td colspan=5>&nbsp;</td></tr><td colspan=5 height=30px width=400 class=\"message tip\"><strong>";
			if ($newp>1)
			{ ?>
				<a href="<?php echo "index.php?page=direct_member&p=".($newp-1);?>">&laquo;</a>
			<?php 
			}
			for ($i=1; $i<=$pnums; $i++) 
			{ 
				if ($i!=$newp)
				{ ?>
					<a href="<?php echo "index.php?page=direct_member&p=$i";?>"><?php print_r("$i");?></a>
					<?php 
				}
				else
				{
					 print_r("$i");
				}
			} 
			if ($newp<$pnums) 
			{ ?>
			   <a href="<?php echo "index.php?page=direct_member&p=".($newp+1);?>">&raquo;</a>
			<?php 
			} 	
				print "</table>";
	
			}
	}	
}
else
{ ?>

<table width="50%" border="0">
<form name="myform" action="index.php?page=direct_member" method="post">
  <tr>
    <td colspan="2">&nbsp;</td>
  
  </tr>
  <tr>
    <td><p>Enter Username :</p></td>
    <td><p><input type="text" name="username" class="input-medium"  /></p></td>
  </tr>
  <tr>
    <td colspan="2"><p align="center"><input type="submit" name="submit" value="submit" class="btn btn-info"  /></p></td>
  </tr>
</table>

<?php  } ?>
