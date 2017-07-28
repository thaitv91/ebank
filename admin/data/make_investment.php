<?php
session_start();
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");

if(isset($_SESSION['success']))
{
	echo "<B style=\"color:#008000;\">".$_SESSION['success']."</B>";
	unset($_SESSION['success']);
}

elseif(isset($_POST['submit']))
{
	$user_name = $_REQUEST['user_name'];
	$investment_amount = $_REQUEST['investment_amount'];
	$investment_date = $_REQUEST['investment_date'];
	$investment_priority = $_REQUEST['investment_priority'];
	$invst_id = get_new_user_id($user_name);
	
	$investment_date = date('Y-m-d', strtotime($investment_date));
	
	$user_id = get_user_id($user_name);
	$user_type = get_user_types($user_id);
	if($user_type == 'D')
	{ echo "<B style=\"color:#FF0000;\">This User is Blocked !!</B>"; }
	else
	{
		if($invst_id == 0)
		{ echo "<B style=\"color:#FF0000;\">Error : Incorrect User Name !</B>"; }
		else
		{
			if($investment_date == "")
			{ echo "<B style=\"color:#FF0000;\">Error : Incorrect Investment Date !</B>"; }
			else
			{
				if($setting_min_investment_amount <= $investment_amount)
				{
					$paid_limit = $investment_amount;
					mysql_query("insert into income (user_id , total_amount , paid_limit , date , type , mode , priority) values ('$invst_id' , '$investment_amount' , '$paid_limit' , '$investment_date' , 1 , 1 , '$investment_priority') ");
					
					include("../function/logs_messages.php");
					data_logs($invst_id,$data_log[22][0],$data_log[22][1],$log_type[5]);
				
					$_SESSION['success'] = "Success : User Investment Completed Successfully !";
					
					echo "<script type=\"text/javascript\">";
					echo "window.location = \"index.php?page=make_investment\"";
					echo "</script>";
				}
				else
				{
					echo "<B style=\"color:#FF0000;\">Error : Investment not Completed !!<br />Miminum Investment amount is : ".$setting_min_investment_amount."</B>";
				}	
			}
		}
	}	
}
else
{ ?>	
<form name="my_form" action="" method="post">
<table class="table table-bordered">
	<tr>
		<th>User Id</th>
		<td><input type="text" name="user_name" /></td>
	</tr>
	<tr>
		<th>Investment Amount</th>
		<td><input type="text" name="investment_amount" /></td></td>
	</tr>
	<tr>
		<th>Investment Date</p></th>
		<td>
			<div class="form-group" id="data_1" style="margin:0px">
				<div class="input-group date">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" name="investment_date" />
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<th>Investment Priority</th>
		<td>
			<select name="investment_priority">
				<option value="1"> Priority 1</option>
				<option value="2"> Priority 2</option>
			</select>
		</td>
	</tr>  
	<tr>
		<td class="text-center" colspan="2">
			<input type="submit" name="submit" value="Submit" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>
	
<?php } ?>
<script src="js/date.js"></script>