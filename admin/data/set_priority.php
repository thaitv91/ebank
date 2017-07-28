<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/wallet_message.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
include("../function/pair_point_calculation.php");

$curr_date = date('Y-m-d', strtotime("$systems_date - 1 day"));	

if(isset($_POST['set_priority']))
{
	$total_inv_amount = $_POST['total_inv_amount'];
	$prev_paid_amount = $_POST['prev_paid_amount'];
	$total_timit = $_POST['total_timit'];
	$total_limit_paid = $_POST['total_limit_paid'];
	$tabl_id = $_POST['tabl_id'];
	$priority_set = $_POST['priority_set'];
	$priority_username_log = $_POST['tabl_username'];
	$date = $_POST['date'];
	
	mysql_query("update income set priority = '$priority_set' , total_amount = '$total_inv_amount' , paid_amount = '$prev_paid_amount' , paid_limit = '$total_timit' , paid_amount = '$total_limit_paid' , date = '$date' , mode = 1 where id = '$tabl_id' ");

	include("../function/logs_messages.php");
	data_logs($income_payee_id,$data_log[19][0],$data_log[19][1],$log_type[5]);	
}
	
if(isset($_POST['Search']))
{
	$username = $_POST['username'];
	$user_id = get_new_user_id($username);
	if($user_id == 0)
		print "<font color=#FF0000 size=5>Enter Correct Username !</font>";
	else
	{
		$qqq = mysql_query("select * from income where user_id = '$user_id' ");
		$num = mysql_num_rows($qqq);
		if($num > 0)			
		{ ?>
			<table class="table table-bordered">  
				<thead>
				<tr>
					<th class="text-center">User id</th>
					<th class="text-center">Name</th>
					<th class="text-center">Total Income</th>
					<th class="text-center">Paid Income</th>
					<th class="text-center">Total Limit</th>
					<th class="text-center">Limit Paid</th>
					<th class="text-center">Date</th>
					<th class="text-center">Income Priority</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
		<?php
			
			$psc = 1;				
			while($rrr = mysql_fetch_array($qqq))
			{
				$total_inv_amount = $rrr['total_amount'];
				$prev_paid_amount = $rrr['paid_amount'];
				$total_timit = $rrr['paid_limit'];
				$total_limit_paid = $rrr['paid_amount'];
				$income_id = $rrr['id'];
				$date = $rrr['date'];
				$pay_user_id = get_user_name($rrr['user_id']);
				$pay_user_name = get_full_name($rrr['user_id']);
				$priority = $rrr['priority'];
		?>
		<form action="" method="post">
		<input type="hidden" name="tabl_id" value="<?=$income_id; ?>" /> 	
		<input type="hidden" name="tabl_username" value="<?=$pay_user_id; ?>"  /> 		
			<tr>
				<td><?=$pay_user_id; ?></td>
				<td><?=$pay_user_name; ?></td>
				<td>
					<input type="text" name="total_inv_amount" value="<?=$total_inv_amount; ?>" style="width:80px;" /> </td>
				<td>
					<input type="text" name="prev_paid_amount" value="<?=$prev_paid_amount; ?>" style="width:80px;" /> </td>
				<td>
					<input type="text" name="total_timit" value="<?=$total_timit; ?>" style="width:80px;" /> 
				</td>
				<td>
					<input type="text" name="total_limit_paid" value="<?=$total_limit_paid; ?>" style="width:80px;" /> </td>
				<td><input type="text" name="date" value="<?=$date; ?>" style="width:100px;" /> </td>
				<td>
					<input type="text" name="priority_set" style="width:100px;" value="<?=$priority;?>" /> 
				</td>
				<td>
					<input type="submit" name="set_priority" value="Set Priority" class="btn btn-info" />
				</td>
			</tr>
		</form>
		<?php	} ?>
		</table>
		<?php		
		}	
	}	
}
else
{  ?>
	<form action="" method="post">
	<table class="table table-bordered">  
		<tr>
			<th width="40%">User Id</th>
			<th><input type="text" name="username" /> </th>
		</tr>
		<tr>
			<td colspan="2" class="text-center">
				<input type="submit" name="Search" value="Search" class="btn btn-info" />
			</td>
		</tr>
	</table>
	</form>	
<?php	 	
} 	
?>