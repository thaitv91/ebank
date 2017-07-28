<?php
include("condition.php");
include("../function/functions.php");
include("../function/setting.php");

if(isset($_POST['submit']) and $_SESSION['unblock_user'] == 1)
{
	$time = date('Y-m-d H:i:s');
	$id = $_REQUEST['id'];
	$user_name = $_REQUEST['user_name'];	
	$type = get_type_user($id);
	$_SESSION['unblock_user'] = 0;
	if($type == 'D')
	{
		mysql_query("UPDATE users SET type = 'B' WHERE id_user = '$id' ");
		mysql_query("update wallet set amount = amount-'$unblock_deduct' where id='$id'");
		
		$cash_wal = get_wallet_amount($id);
		insert_wallet_account_adm($id , $unblock_deduct , $time , $acount_type[16],$acount_type_desc[16], 2 , $cash_wal ,$wallet_type[1]);
		
		print "User ".$user_name." Activated Successfully !!<br>";
	}
}
$_SESSION['unblock_user'] = 1;
$d =mysql_query("SELECT * FROM users WHERE type = 'D' ");
$num = mysql_num_rows($d);
if($num != 0)
{ ?>
	<table class="table table-bordered">
		<thead>
		<tr>
			<th class="text-center">User Name</th>
			<th class="text-center">Name</th>
			<th class="text-center">Date</th>
			<th class="text-center">Action</th>
		</tr>
		</thead>
	<?php
	while($row = mysql_fetch_array($d))
	{
		$id = $row['id_user'];
		$username = get_user_name($id);
		$name = $row['f_name']." ".$row['l_name'];
		$date = $row['date'];
		
		echo "<tr>
			<td class=\"text-center\">$username</td>
			<td class=\"text-center\">$name</td>
			<td class=\"text-center\">$date</td>
			<td class=\"text-center\">
				<form name=\"inact\" action=\"index.php?page=block_member_list\" method=\"post\">
					<input type=\"hidden\" name=\"id\" value=\"$id\" />
					<input type=\"hidden\" name=\"user_name\" value=\"$username\" />
					<input type=\"submit\" name=\"submit\" value=\"Activate\" class=\"btn btn-info\" />
				</form>
			</td>
			</tr>";
	}
	echo "</table>";
}
else { echo "<B style=\"color:#FF0000;\">There are no Information to show !!</B>"; } 	
?>
