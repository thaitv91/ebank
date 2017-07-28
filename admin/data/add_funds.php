<?php
include("condition.php");
include("../function/functions.php");

if(isset($_SESSION['wallet_success']))
{
	echo $_SESSION['wallet_success'];
	unset($_SESSION['wallet_success']);
}

if(isset($_POST['submit']))
{
	$amount = $_REQUEST['amount'];
	$wall_type = $_REQUEST['wall_type'];
	$action = $_REQUEST['action'];
	$username = $_REQUEST['username'];
	$user_id = get_new_user_id($username);
	
	if($wall_type == 1){ $wall_type = "amount";}
	else{  $wall_type = "com_wallet"; }
	
	if($action == 1){ $add_dedct = '+';}
	else{ $add_dedct = '-'; }
	
	if($user_id != 0)
	{
		/*$query = mysql_query("select * from wallet where id = '$user_id' ");
		while($row = mysql_fetch_array($query))
		{
			$db_amount = $row['amount'];
		} 
		$total_amount = $amount+$db_amount;*/
		$date = date('Y-m-d');
		$sql = "update wallet set $wall_type = $wall_type$add_dedct'$amount' , date = '$date' where id = '$user_id' ";
		mysql_query($sql);
		
		//get wallet_balance from user_id
		$tb_wallet = mysql_query("SELECT * FROM  wallet WHERE id = $user_id"); 
		$row_wallet = mysql_fetch_array($tb_wallet);

		// update into account
		//Main wallet
		if($wall_type == 1){
			if($action == 1){
				$account = mysql_query("INSERT INTO account (user_id, cr, type, date, account, wallet_balance, wall_type)  VALUES ($user_id, $amount, '".$acount_type[12]."', '".$date."', '".$acount_type_desc[24]."', ".$row_wallet['amount'].", '".$wallet_type[1]."')");
			}
			if($action == 2){
				$account = mysql_query("INSERT INTO account (user_id, dr, type, date, account, wallet_balance, wall_type)  VALUES ($user_id, $amount, '".$acount_type[12]."', '".$date."', '".$acount_type_desc[25]."', ".$row_wallet['amount'].", '".$wallet_type[1]."')");
			}
			
		}
		//Comission wallet
		if($wall_type == 2){
			if($action == 1){
				$account = mysql_query("INSERT INTO account (user_id, cr, type, date, account, wallet_balance, wall_type)  VALUES ($user_id, $amount, '".$acount_type[12]."', '".$date."', '".$acount_type_desc[24]."', ".$row_wallet['amount'].", '".$wallet_type[3]."')");
			}
			if($action == 2){
				$account = mysql_query("INSERT INTO account (user_id, dr, type, date, account, wallet_balance, wall_type)  VALUES ($user_id, $amount, '".$acount_type[12]."', '".$date."', '".$acount_type_desc[25]."', ".$row_wallet['amount'].", '".$wallet_type[3]."')");
			}
			
		}
		
		
		data_logs($id,$data_log[11][0],$data_log[11][1],$log_type[5]);
		$edit_amount = $amount;
		$username_log = $username;
		include("../function/logs_messages.php");
		data_logs($user_id,$data_log[12][0],$data_log[12][1],$log_type[4]);
		
		$_SESSION['wallet_success'] = "<B style=\"color:#008000;\">Successfully Done!</B>";
		
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=add_funds\"";
		echo "</script>";
	}
	else { echo "<B style=\"color:#ff0000;\">Please Enter correct username!</B>";	 }
}
else
{ ?>
<form name="add_funds" action="index.php?page=add_funds" method="post">
<table class="table table-bordered">  
	<thead><tr><th colspan="2">Add Amount Pannel</th></tr></thead>
	<tr>
		<th>Enter Username </th>
		<td><input type="text" name="username" required /></td>
	</tr>
	<tr>
		<th>Amount</th>
		<td><input type="text" name="amount" required /> <font color=dark>$ </font></td>
	</tr>
	<tr>
		<th>Wallet Type</th>
		<td>
			<select name="wall_type" style="width:185px;" required>
				<option value="">Select Wallet Type</option>
				<option value="1">Main Wallet</option>
				<option value="2">Commission Wallet</option>
			</select>
		</td>
	</tr>
	<tr>
		<th>Action</th>
		<td>
			<select name="action" style="width:185px;" required>
				<option value="">Select Action Type</option>
				<option value="1">Add Balance</option>
				<option value="2">Deduct Balance</option>
			</select>
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
} ?>

