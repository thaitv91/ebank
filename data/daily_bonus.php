<?php
session_start();
include("condition.php");
include("function/setting.php");
include("function/functions.php");

$newp = $_GET['p'];
$plimit = "12";
$id = $_SESSION['ebank_user_id'];
$add = 1;

$que ="select * from user_income where user_id = '$id' and type = '$income_type[6]' ";
$inc_query = mysql_query($que);
$num = mysql_num_rows($inc_query);

if($num > 0)
{
?>
<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info"> 
<tbody role="alert" aria-live="polite" aria-relevant="all">
	<tr class="odd">
		<td>Sr No</td>	
		<td>User Id</td>
		<td>Amount</td>
		<td>Date</td>
	</tr>
<?php
	while($row = mysql_fetch_array($inc_query))
	{
		$user_name = get_user_name($row['user_id']);
		$amount = $row['income'];
		$amount_usd = round($amount/$usd_value_current,2);
		$date = $row['date'];
		
		echo "<tr class=\"even\">
				<td>$add</td>
				<td>$user_name</td>
				<td>$amount_usd <font color=DodgerBlue>USD</font> Or $amount <font color=dark>$ </font></td>
				<td>$date</td>
			</tr>";
		$add++;
	}
}
else{ print "<strong>There are no information to show !!</strong>";}
?>
</tbody>
</table>