<?php
session_start();
require_once("config.php");
include("condition.php");
require_once("function/functions.php");
include("function/setting.php");

$newp = $_GET['p'];
$plimit = "15";

 $id = $_SESSION['ebank_user_id'];

 $sql = "SELECT t2.* FROM user_manager as t1 inner join users as t2 on t1.manager_id = t2.id_user and  t1.type = 'B' where t1.active_by = '$id' ";
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
if($totalrows == 0)
{
	echo "There is no information to show!"; 
}
else 
{ ?>
	<table id="ContentPlaceHolder1_grid" class="data_grid" cellspacing=0 border=1 style="width:100%;border-collapse:collapse;" rules=all>
		<tbody>
		<tr>
			<th><B>E-mail</B></th>
			<th><B>Name</B></th>
			<th><B>Phone No</B></th>
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
		
		$sql = "$sql LIMIT $start,$plimit ";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query))
		{
			$child_id = $row['id_user'];
			$real_parent = $row['real_parent'];
			$username = $row['username'];
			$name= $row['f_name']." ".$row['l_name'];
			$date = $row['date'];
			$email = $row['email'];
			$phone_no = $row['phone_no'];
			$request_amount = $row['provience'];
			
			print "
				<tr>
					<td style=\"padding-left:5px; width:180px;\">$email</th>
					<td style=\"padding-left:15px; width:200px;\">$name</th>
					<td style=\"padding-left:15px; width:130px;\">$phone_no</th>
				</tr>";
		}
		
		print "
		<tr><td style=\"text-align:left; padding-left:10px\" colspan=4 height=30><strong>";
		if ($newp>1)
		{ ?> <a href="<?="index.php?page=activate_member&p=".($newp-1);?>">&laquo;</a> <?php  }
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<a href="<?="index.php?page=activate_member&p=$i";?>"><?php print_r("$i");?></a>
				<?php 
			}
			else
			{ print_r("$i"); }
		} 
		if ($newp<$pnums) 
		{ ?> <a href="<?="index.php?page=activate_member&p=".($newp+1);?>">&raquo;</a> <?php  } 
		print"</strong></td></tr></tbody></table>";
}
?>
