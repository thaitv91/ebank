<?php
session_start();
include("condition.php");
require_once("config.php");
include("function/child_info.php");
include("function/setting.php");
include("function/pair_point_income.php");

?>
<div class="forgotbox1">
<h4 style="padding-left:20px;">Current Matching Status</h4>	
<center>

<?php
$id = $_SESSION['ebank_user_id'];

$chk_binary_condition = check_transfer_condition($id);

	$q = mysql_query("select * from pair_point where user_id = '$id' ");
	$num = mysql_num_rows($q);
	if($num != 0)
	{
		$j = 0;
		while($row = mysql_fetch_array($q))
		{
			$detail[$j][0] = $row['left_point'];
			$detail[$j][1] = $row['right_point'];
			$detail[$j][2] = $row['date'];
			
			$pc = 1;
			$max_pair = min($detail[$j][0],$detail[$j][1]);
			do
			{
				$pair_calc = $per_day_multiple_binary_pair*$pc;
				$pc++;
			}
			while($pair_calc <= $max_pair);
			$total_pair = $pair_calc-$per_day_multiple_binary_pair;
			
			$detail[-1][3] = "-";
			$detail[-1][4] = "-";
			$detail[$j][3] = $detail[$j][0]-$total_pair;
			$detail[$j][4] = $detail[$j][1]-$total_pair;
			$detail[$j][5] = $total_pair;
			
			$j++;
			
		}
		
		print "
			<table id=\"table-1\" class=\"table table-striped table-hover dataTable\" aria-describedby=\"table-1_info\"> 
			<tbody role=\"alert\" aria-live=\"polite\" aria-relevant=\"all\">
			<tr>
				<td rowspan=2 height=20 align=\"center\"><strong>Date</strong></td>
				<td width=500 colspan=2 align=\"center\"><strong>Investment</strong></td>
				<td width=500 colspan=2 align=\"center\"><strong>Carry Forward</strong></td>
				<td rowspan=2 width=250 align=\"center\"><strong>Pair</strong></td>
			</tr>
			<tr>
				<td height=20 align=\"center\"><strong>Left</strong></td>
				<td align=\"center\"><strong>Right</strong></td>
				<td align=\"center\"><strong>Left </strong></td>
				<td align=\"center\"><strong>Right</strong></td>
			</tr>"; 

	
			$c = count($detail);
			for($i = 0; $i < $c-1; $i++)
			{
				print "<tr>
					<td align=\"center\"><small>";echo $detail[$i][2]; print"</small></td>
					<td align=\"center\"><small>"; echo $detail[$i][0]; print"</small></td>
					<td align=\"center\"><small>"; echo $detail[$i][1]; print"</small></td>
					<td align=\"center\"><small>"; echo $detail[$i-1][3]; print"</small></td>
					<td align=\"center\"><small>"; echo $detail[$i-1][4]; print"</small></td>
					<td align=\"center\"><small>";echo $detail[$i][5]; print"</small></td>
					</tr>";
			}	
			print "</tbody></table>";
	}
else { print "You Have No child !"; }

?>
</center>
</div>
<?php

function get_max($c)
{
	if($c[0] < $c[1])
	{
 		$max[0] = $c[1]-$c[0];
		$max[1] = 1;
	}
	else
	{
		$max[0] = $c[0]-$c[1];
		$max[1] = 0;
	}
	return $max;
}		

function capping($pair)
{	
	if($pair == 1 or $pair == 2 or $pair == 3 or $pair ==4 or $pair ==5 or $pair == 0)	
		$res = 0;
	else
		$res = $pair-5;
	return $res;
}

		
?>

