<?php
include("condition.php");
include("../function/functions.php");
include("../function/daily_income.php");

if(isset($_POST['submit']))
{
	$turn_process = $_REQUEST['turn_process'];
	mysql_query("update income_process set mode = '$turn_process' ");
}

	$qu = mysql_query("select * from income_process where id = 1 ");
	while($r = mysql_fetch_array($qu))
	{
		$process_mode = $r['mode'];
	}
	if($process_mode == 1) 
	{
		$system_turn = "On";
		$system_process ="Off";
		$turn_process = 0;
	}
	else
	{
		$system_process ="On";
		$system_turn = "Off";
		$turn_process = 1;
	}
?>
<form name="pay_form" action="index.php?page=system_on_off" method="post">
<table class="table table-bordered"> 
	<input type="hidden" name="turn_process" value="<?=$turn_process; ?>" >
	<thead><tr><th colspan="2">System On/Off Panel</th></tr></thead>
	<tr>
		<td colspan="2">
			<B style="color:#FF0000; font-size:20px;">System Is Currently <?=$system_process;?></B>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="submit" name="submit" class="btn btn-info" value="Turn <?=$system_turn; ?>" />
		</td>
	</tr>
</table>
</form>

