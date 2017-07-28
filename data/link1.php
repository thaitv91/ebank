<?php
session_start();
require_once("config.php");
include("condition.php");
require_once("function/functions.php");
include("function/setting.php");
$id = $_SESSION['ebank_user_id'];

$newp = $_GET['p'];
$plimit = "15";
?>
<form name="add_bank" action="" method="post">
<table class="grid-form-table" width="20%" align="right">
	<tbody>
	<tr>
		<td align="right">Select Type
			<select name="link_type" style="width:150px;">
				<option value="">Select Option</option>
				<option value="0">Link In Process</option>
				<option value="1">Pending Link</option>
				<option value="2">Confirm Link</option>
			</select>
			<input type="submit" name="select_link" value="Submit" />
		</td>
	</tr>                                
	</tbody>
</table>
</form>
<?php
if(isset($_REQUEST['select_link']))
{
	$link_type = $_REQUEST['link_type'];
	if($link_type == 0)
	{
		$sql = "SELECT * FROM income_transfer where mode = 0";
	}
	elseif($link_type == 1)
	{
		$sql = "SELECT * FROM income_transfer where mode = 1";
	}
	elseif($link_type == 2)
	{
		$sql = "SELECT * FROM income_transfer where mode = 2";
	}
	
}
else{ $sql = "SELECT * FROM income_transfer"; }
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
			<th><B>Name</B></th>
			<th><B>Payer Name</B></th>
			<th><B>Amount</B></th>
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
			$name = $row['name'];
			$paying_id = $row['paying_id'];
			$amount = $row['amount'];
			
			print "
				<tr>
					<td style=\"padding-left:5px; width:180px;\">$name</th>
					<td style=\"padding-left:15px; width:200px;\">$paying_id</th>
					<td style=\"padding-left:15px; width:130px;\">$amount</th>
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
