<?php
include('condition.php');
include('function/setting.php');
include("function/functions.php");
include("function/send_mail.php");
include("function/income.php");

$login_user_id = $_SESSION['ebank_user_id'];
$wallet_query = "SELECT * FROM wallet AS t1 INNER JOIN users AS t2 ON t1.id = t2.id_user AND t1.id ='$login_user_id' ";

$wallet_qur_1 = mysql_query($wallet_query);
while($rowaa = mysql_fetch_array($wallet_qur_1))
{
	$walt_amnt_1 = $rowaa['amount'];
	$pay_username = $rowaa['username'];
	$pay_ac_no = $rowaa['ac_no'];
	$pay_bank = $rowaa['bank'];
	$pay_full_name = $rowaa['f_name']." ".$rowaa['l_name'];
}

?>

<script type="text/javascript" src="js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" >$(document).ready(function() {	
	$("#username").keyup(function (e) {
		//removes spaces from username
		$(this).val($(this).val().replace(/\s/g, ''));
		var username = $(this).val();
		if(username.length < 4){$("#user-result").html('');return;}
		
		if(username.length >= 4){
			$("#user-result").html('<img src="img/ajax-loader.gif" />');
			$.post('check_username.php', {'username':username},function(data)
			{
			  $("#user-result").html(data);
			});
		}
	});	
});	

</script>
<?php

if(isset($_POST['confirm_commitment']))
{
	$amount_id = $_POST['amount'];
	$username_id = $_POST['username'];
	$sql = "SELECT * FROM investment_request AS t1
							INNER JOIN users AS t2 ON t2.username = '$username_id'
							AND t1.user_id = t2.id_user
							AND MODE =1
							AND rec_mode =1";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		while($rows = mysql_fetch_array($query))
		{	
			$investment_id = $rows['id'];
			$paid_id = $rows['user_id'];
			$total_amount = $rows['amount'];
			$real_parent = $rows['real_parent'];
			$id_user  = $rows['id_user '];
			$paid_username = $rows['username'];

			if($walt_amnt_1 >= $total_amount)
			{
				mysql_query("update investment_request set mode = 0 ,priority = 0 where id = '$investment_id' " );
				$totl_dedc_amnt = $walt_amnt_1-$total_amount;
				mysql_query("update wallet set amount = '$totl_dedc_amnt' where id = '$login_user_id' ");
				
				$new_amount = $total_amount/2;	
				$income_time = date('H:i:s');
				mysql_query("insert into investment_request (user_id , amount , date , time , mode , rec_mode , priority ) values ('$login_user_id' , '$new_amount' , '$systems_date' , '$income_time' , 1 , 0 , 1) ");
				
				mysql_query("insert into income_transfer (investment_id , paid_limit , income_id , user_id , username , name , bank_name , bank_acc , paying_id , amount , date, mode ,payment_receipt)         values ('$investment_id' , '$total_amount' , '$login_user_id' , '$login_user_id' , '$pay_username' , '$pay_full_name' , '$pay_bank' , '$pay_ac_no' ,'$paid_id' ,'$total_amount' ,'$systems_date', '2', 'Cash') ");	
					
				$real_par_iid = $real_parent;
				
				$tot_que = mysql_query("select * from daily_interest where member_id  = '$real_par_iid' ");
				while($rrrrr = mysql_fetch_array($tot_que))
				{
					$chk_date = $rrrrr['date'];	
					$chk_end_date = $rrrrr['end_date'];	
				}
				$chk_end_d = get_date_without_sun_sat($chk_end_date,20);
				mysql_query("update daily_interest set date = '$chk_end_date' , end_date = '$chk_end_d' where member_id  = '$real_par_iid' and date <= '$systems_date' and end_date > '$systems_date' ");
						
				$start_date = get_date_without_sun_sat($systems_date,0);
				$end_date = get_date_without_sun_sat($systems_date,20);
				mysql_query("insert into daily_interest (member_id , amount , date , start_date , end_date) value ('$paid_id' , '$total_amount' , '$start_date' , '$start_date' , '$end_date') ");
						
				calculate_level_income($paid_id,$total_amount,$systems_date);
				calculate_ten_level_income($paid_id,$total_amount,$systems_date);
			
			print "<p style=\"color:#228b22;font-size:22px;margin-top:50px;line-height:36px\">$paid_username is activated successfully with the commitment amount of $total_amount <font color=dark>$ </font>.<br /> Because you have received $total_amount <font color=dark>$ </font>, Send help link of $new_amount <font color=dark>$ </font> you are getting shortly.</p>";
			}
			else
			{	
				print "<p style=\"color:#DC143C;font-size:22px;margin-top:50px;\">Insufficient Balance</p>";
			}
		}
	}
	else
	{
	print "<p style=\"color:#DC143C;font-size:22px;margin-top:50px;\">User Not Found</p>";
	}						
}
else{

?>
	<h2 align="left">Cash Paid</h2>
	
	<div style=" height:250px; border:1px solid">
		<?php 	print "<p align=left style=\"color:#FF4500;font-size:22px;margin:20px 10px;\">Your Wallet Balance ";
				print $walt_amnt_1;
				print "</p>";
		?>
		<form method="post" action="">
			<div style="line-height:50px;margin-top:60px;">
				<div style="float:left;">
					<label style="padding:0px 20px 0px 20px;"> <strong>Username</strong> </label> 
					<input type="text" name="username" id="username" size="30" required/> 
					<span id="user-result"></span>&nbsp;
				</div>
				<div style="float:left;"> 
					<label style="padding:0px 20px 0px 20px;"> <strong>Amount</strong> </label> 
					<input type="text" name="amount" size="30" required/>
				</div>
				<div>
					<input type="submit" name="confirm_commitment" value="Confirm Commitment" class="btn btn-info" />
				</div>
			</div>
		</form>
	</div>
<?php 
}
?>	