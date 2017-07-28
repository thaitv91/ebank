<?php
session_start();
include("condition.php");
include("function/functions.php");

?>
<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info"> 
<tbody role="alert" aria-live="polite" aria-relevant="all">		  
<?php
	$user_id = $_SESSION['ebank_user_id'];
	$query = mysql_query("select * from e_pin where user_id = '$user_id' and mode = 0 ");
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		print "<tr>
			<td class=\"messageheadbox\">E-pin</td>
			<td class=\"messageheadbox\">E-pin Type</td>
			<td class=\"messageheadbox\">Date</td>
			<td class=\"messageheadbox\">Used Id</td>
			<td class=\"messageheadbox\">Used Date</td>
		  </tr>";
		while($row = mysql_fetch_array($query))
		{
			$epin = $row['epin'];
			$date = $row['date'];
			$amount = $row['amount'];
			$used_id = get_user_name($row['used_id']);
			$used_date = $row['used_date'];
			$epin_type = $row['epin_type'];
			if($epin_type == 0)
			{
				$epin_type_status = "Refistration E-pin";
				$amount = "Free"; 
			}	
			else
			{
				$amount = $row['amount']; 
				$qu = mysql_query("select * from plan_setting  ");
				while($rrr = mysql_fetch_array($qu))
				{ 
					$epin_type_status = $rrr['plan_name'];
				}
			}		
			
			print "<tr>
					<td class=\"messagemessagebox\" style=\"padding-left:20px\"><small>$epin</small></td>
					<td class=\"messagemessagebox\" style=\"padding-left:20px\"><small>$epin_type_status</small></td>
					<td class=\"messagemessagebox\" style=\"padding-left:20px\"><small>$date</small></td>
					<td class=\"messagemessagebox\" style=\"padding-left:20px\"><small>$used_id</small></td>
					<td class=\"messagemessagebox\" style=\"padding-left:20px\"><small>$used_date</small></td>
				  </tr>";
		}
	}
	else 
	{
		print "<tr>
					<td colspan=3>
						<font color=\"#FF0000\" size=\"+1\"> <strong>There is no E-pin to show !</strong></font>
					</td>
				</tr>";
	}
	print "</tbody></table>";
?>

