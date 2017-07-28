<?php
session_start();
include("condition.php");

if(isset($_POST['submit']))
{
	$system_date = $_REQUEST['system_date'];
	$system_date = date('Y-m-d', strtotime($system_date));
	if($system_date == '')
	{
		echo "<B style=\"color:#FF0000;\">Please Enter System Date !!</B>";
	}
	else
	{
		mysql_query("update system_date set sys_date = '$system_date' where id = 1 ");
		echo "<B style=\"color:#008000;\">System Date Changed Successfully !!</B>";
	}	
}
else
{ 
	$q = mysql_query("select * from system_date where id = 1 ");
	while($row = mysql_fetch_array($q))
	{
		$current_d = $row['sys_date'];
	}
?>
<form name="my_form" action="index.php?page=system_date" method="post" >
<table class="table table-bordered"> 
	<thead>
	<tr>
		<th>System Date</th>
		<th><?=$current_d;?></th>
	</tr>
	</thead>
	<tr>
		<th>Enter System Date</th>
		<td>
			<div class="form-group" id="data_1" style="margin:0px">
				<div class="input-group date">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" name="system_date" />
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" name="submit" value="Submit" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>
<?php  
}  ?>
<script src="js/date.js"></script>