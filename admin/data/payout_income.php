<?php
include("condition.php");
include("../function/functions.php");
include("../function/daily_income.php");
//include("../function/pair_point_income.php");
if(isset($_SESSION['msg_roi_sucs']))
{
	echo $_SESSION['msg_roi_sucs'];
	unset($_SESSION['msg_roi_sucs']);
}

if(isset($_POST['submit']))
{
	$chkdate = date('D', strtotime($systems_date));
	if(1)//$chkdate != 'Sat' and $chkdate != 'Sun'
	{
		mysql_query("update income_process set mode = 1 ");
		
		get_daily_income($systems_date);
		
		mysql_query("update income_process set mode = 0 ");
		
		$_SESSION['msg_roi_sucs'] =  "Income Calculated Successfully !";
		
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=payout_income\"";
		echo "</script>";
	}
	else
	{
		print  "<font color='#ff0000'>Roi Income Not Calculated Today !</font>";
	}
	//pair_point_income($systems_date);	
}
else
{ ?>
<form name="pay_form" action="index.php?page=payout_income" method="post">
<table class="table table-bordered"> 
	<thead><tr><th>Generate Income</th></tr></thead>
	<tr>
		<td class="text-center"><input type="submit" name="submit" value="Pay" class="btn btn-info"  /></td>
	</tr>
</table>
</form>
<?php 
}?>
