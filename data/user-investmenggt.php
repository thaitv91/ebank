<?php
include("condition.php");
include("function/setting.php");
include("function/functions.php");
include("function/send_mail.php");
include("function/direct_income.php");
include("function/check_income_condition.php");
include("function/pair_point_calculation.php");
$id = $_SESSION['ebank_user_id'];


if(isset($_POST['submit']))
{
	if($_SESSION['user_investment_request'] == 1)
	{
		$user_pin = $_POST['user_pin'];
		$request_amount = $_POST['request'];
		
		$inv_prfit = $setting_inv_profit;
		$inv_days = $setting_inv_days;
		
		$query = mysql_query("select * from users where id_user = '$id' and user_pin = '$user_pin' ");
		$num = mysql_num_rows($query);
		if($num > 0)
		{
	
			$income_time = date('H:i:s');
			mysql_query("insert into investment_request (user_id , amount , inv_profit , date , time , inc_days , mode , rec_mode , priority ) values ('$id' , '$request_amount' , '$inv_prfit' , '$systems_date' , '$income_time' , '$inv_days' , 1 , 1 , 1) ");
							
			$acc_username_log = get_user_name($id);
			$income_log = $request_amount;
			$date = $systems_date;
			$wallet_amount_log = $curr_amnt;
			$total_wallet_amount = $left_wallet_amount;
			include("function/logs_messages.php");
			data_logs($id,$data_log[16][0],$data_log[16][1],$log_type[4]);
			
			print "You request for Withdrawal amount ".$request_amount."  <font color=dark>$ </font> has been completed successfully!";
		}
		else
		{  
			print "<font style=\"color:#FF0000\"><strong>Please enter correct user pin !</strong></font>";
		}	
		$_SESSION['user_investment_request'] = 0;
	}			
}	
else
{
	$_SESSION['user_investment_request'] = 1;
	$invest_amount = $_POST['invest_amount'];
	$result = mysql_query("select * from investment_request where user_id = '$user_login_id' ");
	$result_chk = mysql_num_rows($result);
	?>
		<table width="650" border="0" style="color:#CCCCCC; font-size:15px;">
		<form name="invest" method="post" action="">
		
	  <tr>
		<td colspan="5">&nbsp;</td>
	  </tr>
	  <tr>
		<td height=30px width="200px" class="messageheadbox" align="center"><strong>Plan Name</strong></td>
		<td height=30px class="messageheadbox" align="center"><strong>Profit(%)</strong></td>
		<td height=30px width="180px" class="messageheadbox" align="center"><strong>Help Amount</strong></td>
		<td height=30px width="120px" class="messageheadbox" align="center"><strong>Income Times</strong></td>
	  </tr>
	   <tr>
		<td height="20px" class="messagemessagebox" align="left" style="padding-left:20px;"><?php print $setting_inv_name; ?></td>
		<td height="20px" class="messagemessagebox" align="center"><?php print $setting_inv_profit; ?></td>
		<td height="20px" width="200" class="messagemessagebox"align="left" style="padding-left:20px;"><?php print $setting_inv_amount." <font color=dark>$ </font> - ".$setting_inv_end_amount; ?> <font color=dark>$ </font> </td>
		<td height="20px" class="messagemessagebox" align="center"><?php print $setting_inv_days ?></td>
		</tr>
		<tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
		<tr>
		<tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
	<?php
		$query = mysql_query("select * from income where user_id = '$id' and date = '$systems_date' and type = 2 ");		  
		$num = mysql_num_rows($query);
		if($num == 0)
		{	  ?>
			<tr>
				<td colspan="2" style="padding-left:100px; color:#000000; font-size:15px;"><strong>New Help</strong></td>
				<td colspan="3" style="color:#000000;">
				<select name="request" class="textInput" style="width:144px; font-size:13px; color:#000000;">
	<?php			for($i = $setting_inv_amount; $i <= $setting_inv_end_amount; $i = $i+$setting_inv_amount)
				{ ?>
					<option value="<?php print $i; ?>"><?php print $i; ?> <font color=dark>$ </font></option>
		<?php		} ?>				
				</select>
				</td>
			 </tr>
			  <tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2" style="padding-left:100px; color:#000000;"><strong>Transaction Password</strong></td>
				<td colspan="3" style="color:#000000;">
				<input type="text" name="user_pin" style="width:144px; font-size:13px; "  />
				<?php
					$t_pass = mysql_query("select user_pin from users where id_user = '$id'");
					while($row = mysql_fetch_array($t_pass))
					{
						print "&nbsp;&nbsp;&nbsp;".$trans_pass = $row['user_pin'];
					}
				?>
				</td>
			  </tr>
			  <tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="5" align="center"><input type="submit" name="submit" value="Invest" class="btn btn-info" /></td>
			  </tr>
			  </form>
<?php	}
else
	print "<tr>
				<td colspan=5 height=80 align=center><font color=red><strong>System can not have Multiple Commitments !</strong></font></td>
			  </tr>	";  ?>			  
	  </table>
<?php	
	
}
?>
