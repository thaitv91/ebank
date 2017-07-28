<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
if(isset($_POST['submit']))
{
	$time = date('Y-m-d H:i:s');
	$username = $_REQUEST['username'];
	$user_id = get_new_user_id($username);
	if($user_id != 0)
	{
		$amount = $_REQUEST['amount'];
		$date = date('Y-m-d');
		mysql_query("update wallet set amount = '$amount' , date = '$date' where id = '$user_id' ");
		
		/*$cash_wal = get_wallet_amount($user_id);
		insert_wallet_account_adm($user_id , $amount , $time , $acount_type[18],$acount_type_desc[18], 1 , $cash_wal ,$wallet_type[1]);*/
		
		print "Amount Added Successfully!";
	}
	else { print "Please Enter correct username!";	 }
}
else
{ ?>
	<table width="600" border="0">
	<form name="add_funds" action="index.php?page=transfer_to_member" method="post">
  <tr>
    <td colspan="2"><b> Add Amount Pannel</b></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Enter Username :</td>
    <td><p><input type="text" name="username" size="15" class="input-medium" /></p></td>
  </tr>
  <tr>
    <td><p>Amount :</p></td>
    <td><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$<input type="text" name="amount" size="10" class="input-small" /> <font color=dark>$ </font></p></td>
  </tr>
  <tr>
    <td colspan="2"><p align="center"><input type="submit" name="submit" value="Submit" class="btn btn-info" /></p></td>
  </tr>
  </form>
</table>

<?php } ?>

