<?php
include("condition.php");
/*include("../function/pair_point_calculation.php");*/

if(isset($_POST['submit']))
{
	$time = date('Y-m-d H:i:s');
	$username = $_REQUEST['username'];
	$query = mysql_query("select * from users where username = '$username' ");
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$id_user = $row['id_user'];
			$user_type = $row['type'];
		}
		if($user_type != 'D')
		{
			$w_q = mysql_query("select * from wallet where id = '$id_user' ");
			while($rr = mysql_fetch_array($w_q))
			{
				$wallet_amount = $rr['amount'];
			}
			$investment = '';
			$w_q = mysql_query("select * from reg_fees_structure where user_id = '$id_user' ");
			while($rr = mysql_fetch_array($w_q))
			{
				$investment .= $rr['update_fees']." <font color=dark>$ </font> on ".$rr['date']."<br>";
				
			}

			mysql_query("update users set type = 'D' where id_user = '$id_user' ");
			mysql_query("update wallet set amount = 0 where id = '$id_user' ");
			mysql_query("update reg_fees_structure set reg_fees = 0 , update_fees = 0 , total_days = 0 where user_id = '$id_user' ");
			
			$cash_wal = get_wallet_amount($id_user);
			insert_wallet_account_adm($id_user , 0 , $time , $acount_type[15],$acount_type_desc[15], 2 , $cash_wal ,$wallet_type[1]);
			
			$date = date('Y-m-d');
			$title_block = "block member";
			$blocked = "blocked";
			$log_username = $username;
			include("../function/logs_messages.php");
			data_logs($id_user,$data_log[17][0],$data_log[17][1],$log_type[10]);
			echo "<B style=\"color:#008000;\">User ".$username." Blocked Successfully !</B>";
		}
		else
		{ echo "<B style=\"color:#FF0000;\">User ".$username." already Block !</B>"; }
	}
	else
	{ echo "<B style=\"color:#FF0000;\">Please enter correct usernsme !</B>"; }
}
else
{?>
<form name="franchisee" action="" method="post">
<table class="table table-bordered">
	<thead><tr><th colspan="2">Block User</th></tr></thead>
	<tr>
		<th>Username :</th>
		<td><input type="text" name="username" /></td>
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" name="submit" value="Convert" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>
<?php } ?>


