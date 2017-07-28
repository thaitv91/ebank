<?php
session_start();
require_once("config.php");
include("condition.php");
$id = $_SESSION['ebank_user_id'];

$title = 'Display';
$message = 'Display Wallet Information';
data_logs($id,$title,$message,0);

	
$query = mysql_query("SELECT * FROM wallet WHERE id = '$id' ");
$num = mysql_num_rows($query);
if($num == 0)
{
	echo "<strong>There is no information  to show!!</strong>"; 
}
else 
{

print "<table id=\"table-1\" class=\"table table-striped table-hover dataTable\" aria-describedby=\"table-1_info\"> 
<tbody role=\"alert\" aria-live=\"polite\" aria-relevant=\"all\">
<tr><th class=\"messageheadbox\" width=200 colspan=2><strong>Account Balance</strong></th></tr>
<tr>
	<td align=\"center\"><strong>Main Wallet</strong></td>
	<td align=\"center\"><strong>Magic Wallet</strong></td>
</tr>
";
	while($row = mysql_fetch_array($query))
	{
		$income = $row['amount'];
		$roi_wall = $row['roi'];
		$income_usd = round($income/$usd_value_current,2);
		$roi_wall_usd = round($roi_wall/$usd_value_current,2);
		$date = date('Y-m-d');
		print "
		<tr>
			<td align=\"center\" class=\"messagemessagebox\" width=200 style=\"padding-left:40px\">			
				$$income_usd <font color=DodgerBlue>USD
				</font> Or  $income <font color=dark>$ </font> 
			</td>
			<td align=\"center\" class=\"messagemessagebox\" width=200 style=\"padding-left:40px\">			
				$$roi_wall_usd <font color=DodgerBlue>USD
				</font> Or  $roi_wall <font color=dark>$ </font> 
			</td>
		</tr>";
	}
	print "</tbody></table>";
}	
?>
