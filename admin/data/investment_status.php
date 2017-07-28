<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/sendmail.php");

include("../function/direct_income.php");
include("../function/check_income_condition.php");
/*include("../function/pair_point_calculation.php");*/

// date_default_timezone_set('Etc/UTC');
// require '../phpmailer/class.phpmailer.php';
// require '../phpmailer/class.smtp.php';
// $mail = new PHPMailer;
// $mail->isSMTP();
// $mail->SMTPDebug = 0;
// $mail->Debugoutput = 'html';
// $mail->Host = 'mail.smtp2go.com';
// $mail->Port = 2525;
// $mail->SMTPSecure = 'tsl';
// $mail->SMTPAuth = true;
// $mail->Username = "support@ebank.live";
// $mail->Password = "ebank@123456";
// $mail->setFrom('support@ebank.live', 'Vwallet community');
$count_mail = 0;
if(isset($_SESSION['success']))
{
	echo $_SESSION['success'];
	unset($_SESSION['success']);
}
else if(isset($_SESSION['msg_sucs']))
{
	echo $_SESSION['msg_sucs'];
	unset($_SESSION['msg_sucs']);
}

$link_date = $systems_date; //date('Y-m-d', strtotime("$systems_date  +$income_hold_days day "));
echo $systems_date;
if(isset($_POST['calculate']))
{

	if($_SESSION['accept_user_investment_Request'] == 1)
	{

		$total_approval_payment = $tttttt = $_POST['send_total_amount'];
		$check_list = $_POST['check_list'];
		$tttttt_usd = round($tttttt/$usd_value_current,2); 
		$qqq = mysql_query("select sum(paid_limit-per_day_paid) , sum(total_amount-paid_amount) from income where id IN (".$check_list.") and  mode = 1 and date <= '$link_date'  order by priority , date , id ");
		while($rrr = mysql_fetch_array($qqq))
		{
			$paid_lmt = $rrr[0];
			$total_pad_inc = $rrr[1];
			if($paid_lmt > $total_pad_inc)
			{ $paid_limit = $total_pad_inc; }
			else
			{ $paid_limit = $paid_lmt; }
		}	
		if($total_approval_payment <= $paid_limit and $total_approval_payment > 0)
		{
			$inc_qqq = mysql_query("select * from investment_request where mode = 1 and 
			date <= '$systems_date' and priority > 0 order by priority DESC, id ASC  ");

			while($inc_row = mysql_fetch_array($inc_qqq))
			{
				$datepd = $inc_row['date']; 
				$daysplan = $inc_row['inc_days'];
				
				$show_date = date("Y-m-d",strtotime($datepd." + $daysplan days"));
			

				if($show_date <= $systems_date){
							
					$curr_investments = $investment = $inc_row['amount'];
					$investment_user_id = $inc_row['user_id'];
					$investment_req_tbl_id = $inc_row['id'];
				
					if(true)
					{
						$total_approval_payment = $total_approval_payment-$investment;
						do
						{
							$time = date('h:i:s');
							$qqq = mysql_query("select * from income where id IN (".$check_list.") and mode = 1 and date <= '$link_date' 
							 and user_id != '$investment_user_id' order by priority , date , id limit 1 ");
							$num = mysql_num_rows($qqq);
							$condition_run = 0;
							if($num == 0)
							{
								$qqq = mysql_query("select * from income where id IN (".$check_list.") and mode = 1 and 
								date <= '$link_date' order by priority , date , id limit 1 ");
								$num = mysql_num_rows($qqq);
							}
							if($num > 0)			
							{
								while($rrr = mysql_fetch_array($qqq))
								{
									$total_inv_amount = $rrr['total_amount'];
									$prev_paid_amount = $rrr['paid_amount'];
									$income_id = $rrr['id'];
									$pay_user_id = $rrr['user_id'];
									$paid_limit = $rrr['paid_limit'];
									$previous_paid_date = $rrr['date'];
									$per_day_paid = $rrr['per_day_paid'];
									
									//một user không được PD-GD cho nhau
									if($investment_user_id != $pay_user_id){
										
										if(real_parent($investment_user_id) == $pay_user_id || real_parent($pay_user_id)  == $investment_user_id)
										{
											// không được PD/GD 1 cấp
											echo "<B style=\"color:#ff0000;\">Cannot send PH - GH to F1 and related!</B>";	
										}else{
									
											$one_day_recived_amount = $paid_limit-$per_day_paid;
						
											$prev_left_amount = $total_inv_amount-$prev_paid_amount;
											
											if(($curr_investments >= $one_day_recived_amount) or ($prev_left_amount < $curr_investments))
											{
												if($prev_left_amount > $one_day_recived_amount)
												{
													$income_mode = 1;
													$nxtd = date('Y-m-d', strtotime("$systems_date  +1 day "));	
													$current_pay_amount = $one_day_recived_amount;
													$total_receive_amount = $prev_paid_amount+$one_day_recived_amount;
													$user_investment_left_amount = $curr_investments-$one_day_recived_amount;
													$total_per_day_paid = 0;
												}	
												else
												{
													$income_mode = 0;
													$nxtd = $previous_paid_date; 
													$current_pay_amount = $prev_left_amount;
													$total_receive_amount = $total_inv_amount;
													$user_investment_left_amount = $curr_investments-$prev_left_amount;
													$total_per_day_paid = $per_day_paid+$prev_left_amount;
												}	
											}
											else
											{
												$income_mode = 1;
												$nxtd = $previous_paid_date; 
												$current_pay_amount = $curr_investments;
												$total_receive_amount = $prev_paid_amount+$curr_investments;
												$user_investment_left_amount = 0;
												$total_per_day_paid = $per_day_paid+$curr_investments;
											}	
													
											
											$qyq = mysql_query("select * from users where id_user = '$pay_user_id' ");
											while($rtrr = mysql_fetch_array($qyq))
											{
												$pay_username = $rtrr['username'];
												$pay_ac_no = $rtrr['ac_no'];
												$pay_bank = $rtrr['bank'];
												$pay_full_name = $rtrr['f_name']." ".$rtrr['l_name'];
											}
											
											$pay_code = mt_rand(1000, 9999);	
											$curr_time = $systems_date_time;
											mysql_query("insert into income_transfer (investment_id , paid_limit , income_id , user_id , username , name , bank_name , bank_acc , paying_id , amount , pay_code , date , time_link) values ('$investment_req_tbl_id' , '$current_pay_amount' , '$income_id' , '$pay_user_id' , '$pay_username' , '$pay_full_name' , '$pay_bank' , '$pay_ac_no' , '$investment_user_id' , '$current_pay_amount' , '$pay_code' , '$systems_date' , '$curr_time') ");	
						
											mysql_query("update income set paid_amount = '$total_receive_amount' , mode = '$income_mode' , per_day_paid = '$total_per_day_paid' , date = '$nxtd' where id = '$income_id' ");
											if ($investment > $current_pay_amount) {
												$current_investment = $investment - $current_pay_amount;
												mysql_query("update investment_request set amount = $current_investment, app_date = '$systems_date' , app_time  = '$time' where mode = 1 and id = '$investment_req_tbl_id' ");
											} else {
												mysql_query("update investment_request set mode = 0 , priority = 0 , app_date = '$systems_date' , app_time  = '$time' where mode = 1 and id = '$investment_req_tbl_id' ");
											}
											

											$email = get_user_email($investment_user_id);
								           			$name  = get_user_name($investment_user_id);
								            			$title = 'You have a new matched Send - Get';
								            			$content = 'Your Sending request has been successfully processed. Please log-in to <a href="https://vwallet.uk/">www.Vwallet.uk</a> now to complete the Sending.';
								            			sendMail($email,$name,$title,$content);									
											$condition_run = 1;
										}	
									}else{echo "<B style=\"color:#ff0000;\">Cannot send PH - GH to same ID !</B>";	}
									
								}
							}
							$curr_investments = $user_investment_left_amount;
							echo $user_investment_left_amount;
						}while($user_investment_left_amount > 0 && $condition_run == 1);
					}
				}
			}

			$_SESSION['accept_user_investment_Request'] = 0;
			mysql_query("insert into chk_pay (date) values ('$systems_date') ");
			mysql_query("delete from income_transfer where amount = 0 ");
			$_SESSION['msg_sucs'] =  "<B style=\"color:#008000;\">Investment Request of amount $tttttt  accepted Successfully !!</B>";
			
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=investment_status\"";
			echo "</script>";
		}
		else
		{ echo "<B style=\"color:#ff0000;\">Error : Invaild Amount !</B>"; }		
	}	
}


if(isset($_POST['Cancel_withdrawal']))
{
	$time = date('Y-m-d H:i:s');
	$withdral_id = $_POST['cancel_withdrawal_id'];
	$qqq = mysql_query("select * from income where mode = 1 and id = '$withdral_id' ");
	while($rrr = mysql_fetch_array($qqq))
	{
		$total_amount = $rrr['total_amount']; 	 	
		$paid_amount = $rrr['paid_amount'];
		$user_id = $rrr['user_id']; 
	}
	mysql_query("update income set total_amount = '$paid_amount' , mode = 0 where mode = 1 and id = '$withdral_id' ");
	
	$left_amount = $total_amount-$paid_amount;	

	$tot_que = mysql_query("select * from wallet where id = '$user_id' ");
	while($rrrrr = mysql_fetch_array($tot_que))
	{
		$wallet_amount = $rrrrr['amount'];	
	}
	$total_wallet_bal = $wallet_amount+$left_amount;
	mysql_query("update wallet set amount = '$total_wallet_bal' where id = '$user_id' ");
	
	$cash_wal = get_wallet_amount($user_id);
	insert_wallet_account_adm($user_id , $left_amount , $time , $acount_type[17],$acount_type_desc[17], 1 , $cash_wal ,$wallet_type[1]);
}

if(isset($_POST['Cancel_commitment']))
{
	$commit_id = $_POST['cancel_commitment_id'];
	$member_id = $_POST['cancel_member_id'];
	$table_id = $_POST['member_table_id'];
	mysql_query("update investment_request set mode = 3 where id = '$commit_id'");
	
	$sql = "update daily_interest set count = 0 , max_count = 0 where member_id = '$member_id' and investment_id = '$table_id' ";
	mysql_query($sql);
		
	$_SESSION['success']="<B style=\"color:#008000;\">Success : User Commitment Cancel Successfully!</B>";
	
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=investment_status\"";
	echo "</script>";
	// Old Query
	//mysql_query("update investment_request set amount = 0 , mode = 0 where id = '$commit_id' ");
}		
else
{
	$_SESSION['accept_user_investment_Request'] = 1;
	$q = mysql_query("select * from chk_pay where date = '$systems_date' ");
	$chk_nm = mysql_num_rows($q);
	if($chk_nm == 0)
		mysql_query("update income set per_day_paid  = 0 where date <= '$systems_date' and mode = 1 ");
	
	$total_inv_amount_in_queue = 0;
	$qqq = mysql_query("select (paid_limit-per_day_paid) , (total_amount-paid_amount) from income where mode = 1 and date < '$link_date' order by priority , date , id ");
	while($rrr = mysql_fetch_array($qqq))
	{
		$total_inv_amnt_in_queue = $rrr[0];
		$total_pnd_amount_in_queue = $rrr[1];
		if($total_inv_amnt_in_queue > $total_pnd_amount_in_queue)
		{
			$total_inv_amount_in_queue = $total_inv_amount_in_queue+$total_pnd_amount_in_queue;
		}
		else
		{
			$total_inv_amount_in_queue = $total_inv_amount_in_queue+$total_inv_amnt_in_queue;
		}
	}
	
	$qqqq = mysql_query("select amount,date,inv_profit from investment_request where mode = 1 and date <= '$systems_date' ");
	$total_investment_amount = 0;
	while($rrrq = mysql_fetch_array($qqqq))
	{
		$i_date = $rrrq[1];
		$paln_day = $rrrq[2];
		$show_date = date("Y-m-d",strtotime($i_date." + $paln_day days"));
		if($show_date <= $systems_date){
		$total_investment_amount += $rrrq[0];
		$total_investment_amount_usd = round($total_investment_amount/$usd_value_current,2);
		}
	}
	$total_investment_amount_usd = round($total_investment_amount/$usd_value_current,2);	
	if($total_investment_amount == '')
		$total_investment_amount = 0;
	?> 
	<table class="table table-bordered">
	<form action="index.php?page=investment_status" method="post">
		<tr>
			<th>
				Commitment Amount: 
				<input id="total_amount" type="text" name="send_total_amount" value="0" />
				<font color=dark>VND </font> <?//=$total_investment_amount_snd; ?>
				<input id="check_list" type="hidden" name="check_list" value="" />
			</th>
			<td>
				<input type="submit" name="calculate" value="Calculate" class="btn btn-info" />
			</td>
		</tr>
		</form>
	<?php 
	if($total_investment_amount > 0)
	{ 
		if($total_inv_amount_in_queue >= $total_investment_amount){
			$total_investment_amount_snd = $total_investment_amount;
			$total_investment_amount_snd_usd = round($total_investment_amount_snd/$usd_value_current,2); 
		}	
		else{
			$total_investment_amount_snd = $total_inv_amount_in_queue;	
			$total_investment_amount_snd_usd = round($total_investment_amount_snd/$usd_value_current,2); 
		}	
		?>	
		
	<?php	
	} 
	?>	
	<tr>
		<td>	
			<table class="table table-bordered table-scroll">
				<thead>
				<tr>
					<th colspan="3">Total Commitment Amount</th>
					<th colspan="2"><?=$total_investment_amount;?></th>
				</tr>
				<tr>
					<th class="text-center">User Id</th>
					<th class="text-center">Name</th>
					<!--<th class="text-center">Phone No.</th>-->
					<th class="text-center">Amount</th>
					<th class="text-center">Date</th>
					<th class="text-center">Action</th>
				</tr>
				</thead>
			<?php

				$qqq = mysql_query("select * from investment_request where mode = 1 and 
				date <= '$systems_date' and priority > 0 order by priority DESC, id ASC ");
				while($rrr = mysql_fetch_array($qqq))
				{
					$amount = $rrr['amount'];
					$amount_usd = round($amount/$usd_value_current,2);
					$date = $rrr['date'];
					$user_id = get_user_name($rrr['user_id']);
					$name = get_full_name($rrr['user_id']);
					$phone = get_user_phone($rrr['user_id']);
					$invtbl_id = $rrr['id'];
					$id_user = $rrr['user_id'];
					$tbl_id = $rrr['id'];
					$plan = $rrr['inc_days'];
					//$show_date = date("Y-m-d",strtotime($date." + $plan days"));
					//if($show_date <= $systems_date){
					?>			
				<tr>
					<td><?=$user_id;?></td>
					<td><?=$name;?></td>
					<!--<td><? //=$phone;?></td>-->
					<td><?=$amount;?></td>
					<td><?=$date;?></td>
					<td>
					<form action="index.php?page=investment_status" method="post">
					<input type="hidden" name="cancel_commitment_id" value="<?=$invtbl_id;?>" />
					<input type="hidden" name="cancel_member_id" value="<?=$id_user;?>" />
					<input type="hidden" name="member_table_id" value="<?=$tbl_id;?>" />
					<input type="submit" name="Cancel_commitment" value="Cancel" class="btn btn-info" />
					</form>
					</td>
				</tr>
		<?php 		//} 
				}
		?>			
			</table>
		</td>
		<td>	
			<table class="table table-bordered table-scroll">
				<thead>
				<tr>
					<th colspan="3">Total Unpaid Amount</th>
					<th colspan="3"><?=round($total_inv_amount_in_queue,2); ?></th>
				</tr>
				<tr>
					<th><input type="checkbox" id="checkAll"/></th>
					<th class="text-center">User Id</th>
					<th class="text-center">Name</th>
					<!--<th class="text-center">Phone No.</th>-->
					<th class="text-center">Amount</th>
					<th class="text-center">Date</th>
					<th class="text-center">Action</th>
				</tr>
				</thead>

			<?php
				$qqq = mysql_query("select (paid_limit-per_day_paid) , (total_amount-paid_amount) , 
				user_id , date , id from income where mode = 1 and date <= '$link_date' and 
				(total_amount-paid_amount) > 0  order by priority , date , id ");
				while($rrr = mysql_fetch_array($qqq))
				{
					$paid_lmt = $rrr[0];
					$total_pad_inc = $rrr[1];
					$date = $rrr[3];
					$tbl_id = $rrr[4];
					
					if($paid_lmt > $total_pad_inc) { $paid_limit = $total_pad_inc; }
					else { $paid_limit = $paid_lmt; }
					
					$user_id = get_user_name($rrr['user_id']);
					$name = get_full_name($rrr['user_id']);
					$phone = get_user_phone($rrr['user_id']);
					$show_date = date("Y-m-d",strtotime($date." + $gd_time hours"));
					if($show_date <= $systems_date){
				?>			
				<tr>
					<td><input class="checkitem" type="checkbox" name="check_list[]" id="<?=$rrr['id']?>" value="<?=$paid_limit;?>"/></td>
					<td><?=$user_id;?></td>
					<td><?=$name;?></td>
					<!--<td><?//=$phone;?></td>-->
					<td><?=$paid_limit;?></td>
					<td><?=$date;?></td>
					<td>
					<form action="index.php?page=investment_status" method="post">
					<input type="hidden" name="cancel_withdrawal_id" value="<?=$tbl_id; ?>" />
					<input type="submit" name="Cancel_withdrawal" value="Cancel" class="btn btn-info" />
					</form>
					</td>
				</tr>
		<?php  		}
				} ?>			
			</table>
		</td>
	</tr>
</table>		
<?php 
}	
?> 

<script type="text/javascript">
	
	$("#checkAll").change(function () {
		var selected = 0;
		var string_id = '';
		var yourArray = new Array();
        if(this.checked) { // check select status
            $('.checkitem').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"    
                selected += parseInt($(this).val());   
                yourArray.push($(this).attr('id')); 

            });
            string_id = yourArray.toString()
        }else{
            $('.checkitem').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });     
            selected = 0;   
            string_id = ''  
        }
        $('#total_amount').val(selected);
        $('#check_list').val(string_id);
	});

	$(".checkitem").change(function () {
		var selected = parseInt($('#total_amount').val());
		var string_id = $('#check_list').val();
		if(string_id){
			var yourArray = string_id.split(",");
		}else{
			var yourArray = [];
		}
		
		if(this.checked) {    
            selected += parseInt($(this).val()); 
            yourArray.push($(this).attr('id')); 
        }else{     
            selected -= parseInt($(this).val());  
            var a = yourArray.indexOf($(this).attr('id')); 
            yourArray.splice(0,1);
        }
        $('#check_list').val(yourArray.toString());
        $('#total_amount').val(selected);
	});

	
</script>

<script type="text/javascript">
	$('.table-scroll tbody').css('max-height',screen.height-300);
</script>
<style type="text/css">
table.table-scroll {
    display: flex;
    flex-flow: column;
    overflow-y: auto;    
	overflow-x: hidden;  
    height: 100%;
    width: 100%;
}
table.table-scroll thead {
    flex: 0 0 auto;
    width: calc(100% - 0.9em);
}
table.table-scroll tbody {

    flex: 1 1 auto;
    display: block;
    overflow-y: scroll;
}
table.table-scroll tbody tr {
    width: 100%;
}
table.table-scroll thead, table.table-scroll tbody tr {
    display: table;
    table-layout: fixed;
}
</style>

