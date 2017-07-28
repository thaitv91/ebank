<?php
session_start();
include("condition.php");
require_once("function/functions.php");
$user_id = $_SESSION['ebank_user_id'];

$table_id = $_REQUEST['table_id'];


if(isset($_REQUEST['update']))
{
	extract($_REQUEST);
	mysql_query("update user_bank set bank = '$bank' , branch = '$branch' , acc_no = '$acc_no', perfect_money_acc = '$perfect_money' , acc_type = '$acc_type' , ifsc_code = '$ifsc' , bit_coin_acc = '$bitcoin' , state = '$state' , city = '$city' , date =  '$systems_date' where user_id = '$user_id' and id = '$id' ");
	
	$_SESSION['success_edit'] = "<B style=\"color:#008000;font-size:14px;\"><center>Edit Bank Successfully !</center></B>";
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=add_bank\"";
		echo "</script>";
	
}
elseif(isset($_REQUEST['update_main']))
{
	extract($_REQUEST);
	
	mysql_query("update users set bank = '$bank' , branch = '$branch' , ac_no = '$acc_no' , account_type = '$acc_type' , bank_code = '$ifsc' , state = '$state' , city = '$city' where id_user = '$user_id'");
	
	$_SESSION['success_edit_main'] = "<B style=\"color:#008000;\">Edit Bank Successfully !</B>";
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=add_bank\"";
	echo "</script>";
	
}



if(isset($_REQUEST['edit']))
{
	$query = mysql_query("select * from user_bank where user_id = '$user_id' and id = '$table_id'");
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
		$name = ucfirst(get_full_name($users_id));
	}
	?>
	<table id="example2" class="table table-bordered table-hover">
	<tr>
		<td>
			<form name="edit_bank" action="" method="post">
			<input type="hidden" name="id" value="<?=$id; ?>" />
			<table id="example2" class="table table-bordered table-hover">
				<tr>
					<td>Name :</td>
					<td><input readonly="readonly" class="form-control" type="text" value="<?=$name;?>"></td>
					<td>City :</td>
					<td><input name="city" class="form-control" type="text" value="<?=$city;?>"></td>
				</tr>
				<tr>
					<td>State :</td>
					<td><input name="state" class="form-control" type="text" value="<?=$state;?>"></td>
					<td>Branch Name :</td>
					<td><input name="branch" class="form-control" type="text" value="<?=$branch;?>"></td>
				</tr>                                
				<tr>
					<td>Bank Name:</td>
					<td><input name="bank" class="form-control" type="text" value="<?=$bank;?>"></td>
					<td>Account No.:</td>
					<td><input name="acc_no" class="form-control" type="text" value="<?=$acc_no;?>"></td>
				</tr>
				<tr>
					<td>Account Type :</td>
					<td>
						<select name="acc_type" class="form-control">
							<option selected="selected" value="saving">Saving</option>
							<option value="current">Current</option>
						</select>
					</td>
					<td>PerfectMoney Account No.:</td>
					<td>
						<input name="perfect_money" class="form-control" type="text" value="<?=$perfect_money_acc;?>">
					</td>
				</tr>                                
				<tr>
					<td>Ifsc code :</td>
					<td><input name="ifsc" class="form-control" type="text" value="<?=$ifsc_code;?>"></td>
					<td>Bit Coin Address:</td>
					<td><input name="bitcoin" class="form-control" type="text" value="<?=$bit_coin_acc;?>"></td>
				</tr>  
				<tr>
					<td colspan="4" class="text-center">
					<input name="update" value="Update" class="btn btn-success" style="" type="submit">
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	</table>
<?php
}

elseif(isset($_REQUEST['edit_main']))
{
	$query = mysql_query("select * from users where id_user = '$user_id'");
	while($row = mysql_fetch_array($query))
	{
		$user_id = $row['id_user'];
		$bank = $row['bank'];
		$branch = $row['branch'];
		$acc_no = $row['ac_no'];
		$beneficiery_name = $row['beneficiery_name'];
		$acc_type = $row['account_type'];
		$ifsc_code = $row['bank_code'];
		$state = $row['state'];
		$city = $row['city'];
		$name = ucfirst(get_full_name($user_id));
	}
	?>
	<table id="example2" class="table table-bordered table-hover">
	<tr>
		<td>
			<form name="edit_main_bank" action="" method="post">
			<input type="hidden" name="user_id" value="<?=$user_id; ?>" />
			<table id="example2" class="table table-bordered table-hover">
				<tr>
					<td>Name :</td>
					<td>
						<input readonly="readonly" class="form-control" type="text" value="<?=$name;?>">
					</td>
					<td>City :</td>
					<td><input name="city" class="form-control" type="text" value="<?=$city;?>"></td>
				</tr>
				<tr>
					<td>State :</td>
					<td><input name="state" class="form-control" type="text" value="<?=$state;?>"></td>
					<td>Branch Name :</td>
					<td><input name="branch" class="form-control" type="text" value="<?=$branch;?>"></td>
				</tr>                                
				<tr>
					<td>Bank Name:</td>
					<td><input name="bank" class="form-control" type="text" value="<?=$bank;?>"></td>
					<td>Account No.:</td>
					<td><input name="acc_no" class="form-control" type="text" value="<?=$acc_no;?>"></td>
				</tr>
				<tr>
					<td>Account Type :</td>
					<td>
						<select name="acc_type" class="form-control">
							<option selected="selected" value="saving">Saving</option>
							<option value="current">Current</option>
						</select>
					</td>
					<td>Ifsc code :</td>
					<td><input name="ifsc" class="form-control" type="text" value="<?=$ifsc_code;?>"></td>
				</tr>                                
				<tr>
					<td colspan="4" class="text-center">
						<input name="update_main" value="Update" class="btn btn-success" style="" type="submit">
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	</table>
<?php
}
?>