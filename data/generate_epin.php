<?php
include("condition.php");
include("function/setting.php");
include("function/e_pin.php");
include("function/functions.php");
include("function/send_mail.php");

$id = $new_user_id = $_SESSION['ebank_user_id'];

if(isset($_POST['submit']))
{
	$amount = $setting_registration_amount;
	$number = $_POST['number'];
	$user_pin = $_POST['user_pin'];
	$total_amount = $_POST['total_amount'];
	
	$pin_number = $total_amount/$setting_registration_amount;
	
	$q = mysql_query("select * from users where id_user = '$new_user_id' and user_pin = '$user_pin' ");
	$chknum = mysql_num_rows($q);
	if($chknum == 0)
	{
		print "Enter Correct Transaction Password!!"; 
	}
	else
	{
		$total_epin_amount = $total_amount;
		$query = mysql_query("SELECT * FROM wallet WHERE id = '$id' ");
		while($row = mysql_fetch_array($query))
			$wallet_amount = $row['amount'];
			
		if($wallet_amount >= $total_epin_amount)
		{
			for($ii = 0; $ii < $number; $ii++)
			{	
				do
				{
					$unique_epin = mt_rand(1000000000, 9999999999);
					$query = mysql_query("select * from e_pin where epin = '$unique_epin' ");
					$num = mysql_num_rows($query);
				}while($num > 0);
				
				$mode = 1;
				$date = date('Y-m-d');
				$t = date('h:i:s');
				
				mysql_query("insert into e_pin (epin, user_id ,amount , mode , time , date) values ('$unique_epin' , '$new_user_id' , '$setting_registration_amount', '$mode' , '$t' , '$date')");
			}	
			$left_wallet_bal = $wallet_amount-$total_epin_amount;
			mysql_query("update wallet set amount ='$left_wallet_bal' where id = '$new_user_id' ");
			
			$time = date('Y-m-d H:i:s');
			$cash_wal = get_wallet_amount($new_user_id);
			insert_wallet_account($new_user_id, $new_user_id, $total_epin_amount, $time, $acount_type[8],$acount_type_desc[8], 2, $cash_wal , $wallet_type[1]); 
			
			print "<strong>Success : E-Pin generated Successfully !</strong>";		
		}
		else 
		{ 
			print "<font color=\"FF0000\"><strong>Error : You have no Sufficient Balance in your Wallet !</strong></font>"; 
		}	
	}	
}
else
{ 
	echo "General Epin";
	$query = mysql_query("SELECT * FROM wallet WHERE id = '$id' ");
	while($row = mysql_fetch_array($query))
		$wallet_amount = $row['amount'];
		
	//$request_query = mysql_query("select * from investment_request where user_id = '$id' and mode = 1 ");
	//$request_num = mysql_num_rows($request_query);	
	
	//$link_query = mysql_query("select * from income_transfer where paying_id = '$id' and mode < 2 ");
	//$request_link = mysql_num_rows($link_query);	

?>
<h4> <font color=dark>Note -: You Can Generate E-pin Only Multiple Of 500</font></h4>
<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info"> 
<tbody role="alert" aria-live="polite" aria-relevant="all">	
<form method="post" action="">
	<tr>
		<td>Wallet Balance </td>
		<td><?php print $wallet_amount; ?> <font color=dark>$ </font></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<?php			  
	if(1)
	{ ?>			  
	<tr>
		<td>Number Of E-pin </td>
		<td>
			<label class="input"><input type="text" name="number" onKeyUp="this.form.total_amount.value = <?php print $setting_registration_amount;?> * (this.form.number.value - 0)" placeholder="Number"></label>
			<label class="input"><input type="text" name="total_amount" readonly="" placeholder="Total"></label>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>Transaction Password </td>
		<td><label class="input"><input type="text" name="user_pin"  /></label></td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" name="submit" value="Generate" class="btn btn-info" />
		</td>
	</tr>
</form>
<?php	
	}
	else
	{
		print " <tr>
		<td colspan=2 height=100>&nbsp;</td>   
	  </tr>
		<tr>
			<td align=center colspan=2><font color=red size=4><strong>Error : Please Approve all Donation !!</strong></font></td>
		  </tr>";
	}  ?>
</tbody> 
</table>

<?php } ?>
