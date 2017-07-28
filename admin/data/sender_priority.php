<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
include("../function/pair_point_calculation.php");

if(isset($_POST['move_top']))
{
	$priority_set = $_POST['priority_set'];
	$tatl_priority_cnt = $_POST['tatl_priority_cnt'];
	$priority_id = $_POST['priority_id'];
	for($i = ($priority_set-1); $i >= 1; $i--)
	{	
		$new_priority = $i+1;
		mysql_query("UPDATE investment_request set priority = '$new_priority' where priority = '$i' ");
	}	
	mysql_query("UPDATE investment_request set priority = 1 where id = '$priority_id' ");
	
}	
elseif(isset($_POST['move_down']))
{
	$priority_set = $_POST['priority_set'];
	$tatl_priority_cnt = $_POST['tatl_priority_cnt'];
	$priority_id = $_POST['priority_id'];
	for($i = ($priority_set+1); $i <= $tatl_priority_cnt; $i++)
	{	
		$new_priority = $i-1;
		mysql_query("UPDATE investment_request set priority = '$new_priority' where priority = '$i' ");
	}	
	mysql_query("UPDATE investment_request set priority = '$tatl_priority_cnt' where id = '$priority_id' ");
}
elseif(isset($_POST['swap_top']))
{
	$priority_set = $_POST['priority_set'];
	$priority_id = $_POST['priority_id'];
	$new_priority = $priority_set-1;
	
	mysql_query("UPDATE investment_request set priority = '$priority_set' where priority = '$new_priority' ");
	mysql_query("UPDATE investment_request set priority = '$new_priority' where id = '$priority_id' ");
}
elseif(isset($_POST['swap_down']))
{
	$priority_set = $_POST['priority_set'];
	$priority_id = $_POST['priority_id'];
	$new_priority = $priority_set+1;
	
	mysql_query("UPDATE investment_request set priority = '$priority_set' where priority = '$new_priority' ");
	mysql_query("UPDATE investment_request set priority = '$new_priority' where id = '$priority_id' ");
	
}		



$qqqq = mysql_query("select sum(amount) from investment_request where mode = 1 and date <= '$systems_date' ");
while($rrrq = mysql_fetch_array($qqqq))
$total_investment_amount = $rrrq[0];
if($total_investment_amount == '')
$total_investment_amount = 0;  

$sqls = "select * from investment_request where mode = 1 and date <= '$systems_date' 
and priority > 0 order by priority ";
$qqq = mysql_query($sqls);
$num = mysql_num_rows($qqq);
if($num != 0)
{ ?> 
	<table class="table table-bordered">  
	<thead>
	<tr>
		<th colspan="2">Total Investment Amount</th>
		<th colspan="3"><?=$total_investment_amount;?> <font color=dark>$ </font></th>
	</tr>
	<tr>
		<th class="text-center">&nbsp;</th>
		<th class="text-center">Username</th>
		<th class="text-center">Name</th>
		<th class="text-center">Help Amount</th>
		<th class="text-center">&nbsp;</th>
	</tr>
	</thead>
<?php
	while($rrr = mysql_fetch_array($qqq))
	{
		$tbl_id = $rrr['id'];
		$amount = $rrr['amount'];
		$user_id = get_user_name($rrr['user_id']);
		$name = get_full_name($rrr['user_id']);
		$priority = $rrr['priority'];
	?>			
		<tr>
			<form action="" method="post">
			<input type="hidden" name="tatl_priority_cnt"  value="<?=$num;?>" /> 
			<input type="hidden" name="priority_set"  value="<?=$priority;?>" /> 
			<input type="hidden" name="priority_id"  value="<?=$tbl_id;?>" /> 
			<input type="hidden" name="current_table_id" value="<?=$tbl_id;?>"  />
			<td>
				<input type="submit" name="move_top" value="Move Top" class="btn btn-info" />
				<input type="submit" name="swap_top" value="Swap Top" class="btn btn-info" />
			</td>
			<td><?=$user_id;?></td>
			<td><?=$name;?></td>
			<td><?=$amount;?> <font color=dark>$ </font></td>
			<td>			
				<input type="submit" name="swap_down" value="Swap Down" class="btn btn-info" />
				<input type="submit" name="move_down" value="Move Down" class="btn btn-info" />
			</td>
		</form>	
		</tr>
<?php 	
	} ?>
		
</table>
<?php 
}
else 
{ 
	echo "<B style=\"color:#ff0000;\">There are no information to show !!</B>"; 
}
?> 

