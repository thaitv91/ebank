<?php
session_start();
include("condition.php");
include("function/functions.php");
$user_id = $_SESSION['ebank_user_id'];
$name = ucfirst(get_full_name($user_id));

$account_no = get_user_bank_acc_exist($user_id);

if(isset($_SESSION['success']))
{
	echo $_SESSION['success'];
	unset($_SESSION['success']);
}

elseif(isset($_SESSION['success_edit']))
{
	echo $_SESSION['success_edit'];
	unset($_SESSION['success_edit']);
}

elseif(isset($_SESSION['success_edit_main']))
{
	echo $_SESSION['success_edit_main'];
	unset($_SESSION['success_edit_main']);
}


if(isset($_REQUEST['submit']))
{
	extract($_REQUEST);

	if($acc_no == $account_no)
	{
		echo "<B style=\"color:#FF0000;\">$acc_already_exit</B>";
	}
	else
	{
		$sql = "insert into user_bank (user_id , bank , branch , acc_no , perfect_money_acc , acc_type , 
		ifsc_code , bit_coin_acc , state , city , date) values ('$user_id' , '$bank' , '$branch' , 
		'$acc_no' , '$perfect_money' , '$acc_type' , '$ifsc' , '$bitcoin' , '$state' , '$city' , 
		'$systems_date')";
		mysql_query($sql);
		
		$_SESSION['success'] = "<B style=\"color:#008000;\">$Bank_Add_Successfully</B>";
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=add_bank\"";
		echo "</script>";
	}
}

?>
<table id="example2" class="table table-bordered table-hover">
<tr>
	<td>
		<form name="add_bank" action="" method="post">
		<table id="example2" class="table table-bordered table-hover">
			<tbody>
			<tr>
				<td><?=$Name;?></td>
				<td><input readonly="readonly" class="form-control" type="text" value="<?=$name;?>"></td>
				<td><?=$City;?></td>
				<td><input name="city" class="form-control" type="text"></td>
			</tr>
			<tr>
				<td><?=$State;?></td>
				<td><input name="state" class="form-control" type="text"></td>
				<td><?=$Branch_Name;?></td>
				<td><input name="branch" class="form-control" type="text"></td>
			</tr>                                
			<tr>
				<td><?=$Bank_Name;?></td>
				<td><input name="bank" class="form-control" type="text"></td>
				<td><?=$Account_No;?></td>
				<td><input name="acc_no" class="form-control" type="text"></td>
			</tr>
			<tr>
				<td><?=$Account_Type;?></td>
				<td>
					<select name="acc_type" class="form-control">
						<option selected="selected" value="saving"><?=$Saving;?></option>
						<option value="current"><?=$Current;?></option>
					</select>
				</td>
				<td><?=$PerfectMoney_Account_No;?></td>
				<td><input name="perfect_money" class="form-control" type="text"></td>
			</tr>                                
			<tr>
				<td><?=$Ifsc_code;?></td>
				<td><input name="ifsc" class="form-control" type="text"></td>
				<td><?=$Bit_Coin_Address;?></td>
				<td><input name="bitcoin" class="form-control" type="text"></td>
				
			</tr>  
			<tr>
				<td colspan="4" style="text-align:center">
					<input name="submit" value="Submit" class="btn btn-info" type="submit">
				</td>
			</tr>
			</tbody>
		</table>
		</form>
	</td>
</tr>
</table>

<h3 class="box-title"><?=$Main_Account_Details;?></h3>
<table id="example2" class="table table-bordered table-hover">
	<tr>
		<th><?=$Name;?></th>				<th><?=$Bank;?></th>
		<th><?=$Branch;?></th>				<th><?=$Account_No;?></th>
		<th><?=$PerfectMoney_Account_No;?></th>	<th><?=$Account_Type;?></th>
		<th><?=$Ifsc_code;?></th>			<th><?=$State;?></th>
		<th><?=$City;?></th>				<th><?=$Action;?></th>
	</tr>
	<?php
	$query = mysql_query("select * from users where id_user = '$user_id'");
	while($row = mysql_fetch_array($query))
	{
		$users_id = $row['id_user'];
		$bank = $row['bank'];
		$branch = $row['branch'];
		$acc_no = $row['ac_no'];
		$beneficiery_name = $row['beneficiery_name'];
		$acc_type = $row['acc_type'];
		$ifsc_code = $row['bank_code'];
		$state = $row['state'];
		$city = $row['city'];
		$full_name = ucfirst(get_full_name($users_id));
	?>
		<tr>
			<td><?=$full_name;?></td>			<td><?=$bank;?></td>
			<td><?=$branch;?></td>				<td><?=$acc_no;?></td>
			<td><?=$perfect_money_acc;?></td>	<td><?=$acc_type;?></td>
			<td><?=$ifsc_code;?></td>			<td><?=$state;?></td>
			<td><?=$city;?></td>
			<td>
				<form method="post" action="index.php?page=edit_bank">
					<input type="hidden" name="users_id" value="<?=$users_id; ?>" />
					<input type="submit" name="edit_main" value="Edit" class="btn btn-success">
				</form>
			</td>
		</tr>
	<?php
	}
	?>
</table>
<br />
<h3 class="box-title"><?=$Other_Bank_Account_Details;?></h3>
<?php
$query = mysql_query("select * from user_bank where user_id = '$user_id'");
$num = mysql_num_rows($query);
if($num > 0)
{ ?>
	<table id="example2" class="table table-bordered table-hover">
	<tr>
		<th><?=$Name;?></th>				<th><?=$Bank;?></th>
		<th><?=$Branch;?></th>				<th><?=$Account_No;?></th>
		<th><?=$PerfectMoney_Account_No;?></th>	<th><?=$Account_Type;?></th>
		<th><?=$Ifsc_code;?></th>			<th><?=$State;?></th>
		<th><?=$City;?></th>				<th><?=$Action;?></th>
	</tr>
	<?php
	while($row = mysql_fetch_array($query))
	{
		$id = $row['id'];
		$users_id = $row['user_id'];
		$bank = $row['bank'];
		$branch = $row['branch'];
		$acc_no = $row['acc_no'];
		$perfect_money_acc = $row['perfect_money_acc'];
		$acc_type = $row['acc_type'];
		$ifsc_code = $row['ifsc_code'];
		$bit_coin_acc = $row['bit_coin_acc'];
		$state = $row['state'];
		$city = $row['city'];
		$full_name = ucfirst(get_full_name($users_id));
	?>
		<tr>
			<td><?=$full_name;?></td>			<td><?=$bank;?></td>
			<td><?=$branch;?></td>				<td><?=$acc_no;?></td>
			<td><?=$perfect_money_acc;?></td>	<td><?=$acc_type;?></td>
			<td><?=$ifsc_code;?></td>			<td><?=$state;?></td>
			<td><?=$city;?></td>
			<!--<td><?=$bit_coin_acc;?></td>-->
			<td>
				<form method="post" action="index.php?page=edit_bank">
					<input type="hidden" name="table_id" value="<?=$id; ?>" />
					<input type="submit" name="edit" value="Edit" class="btn btn-success">
				</form>
			</td>
		</tr>
	<?php
	}
	?>
</table>
<?php
}
else{ echo "<B style=\"color:#FF0000;\">$there_are</B>"; }


function get_user_bank_acc_exist($user_id)
{
	$query = mysql_query("select acc_no from user_bank where user_id = '$user_id' limit 1");
	$row = mysql_fetch_array($query);
	$acc_no = $row['acc_no'];
	return $acc_no;
}
?>
