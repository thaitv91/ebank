<?php
session_start();
include('condition.php');
include('function/setting.php');
include("function/functions.php");
include("function/send_mail.php");
include("function/income.php");

$allowedfiletypes = array("jpg");
$uploadfolder = $payment_receipt_img_full_path;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;
$user_id = $_SESSION['ebank_user_id'];

$invst_chk = $_REQUEST['inv'];
if($invst_chk == 1)
{
	print "<p>Success : Your Request of Investment has completed ! <br>
		Please pay amount to showing Information !</p>";
}


if(isset($_POST['Submit']))
{
	$table_id = $_POST['confirm_mdid'];
	$pay_code = $_POST['pay_code'];
	
	$unique_time = time();
	$unique_name =	"CD".$unique_time.$user_id;
	$uploadfilename = $_FILES['payment_receipt']['name'];
	
	$q123 = mysql_query("select * from income_transfer where id = '$table_id' " );
	$chk_pay_code = mysql_num_rows($q123);
	if($chk_pay_code > 0)
	{
		if(!empty($_FILES['payment_receipt']['name']))
		{
			$fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
			
			if (!in_array($fileext,$allowedfiletypes)) 
			{
				echo "<script type=\"text/javascript\">";
				echo "window.location = \"index.php?page=provide_donation&pay_err=1\"";
				echo "</script>"; 
			}	
			else 
			{
				$fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
				$unique_name = $unique_name.".".$fileext;
				$time = date('Y-m-d H:i:s');
				
				if(copy($_FILES['payment_receipt']['tmp_name'], $fulluploadfilename))
				{ 
					mysql_query("update income_transfer set mode = 1 , payment_receipt = 
					'$unique_name' , time_reciept = '$time' where id = '$table_id' " );
					
					$que = mysql_query("select * from income_transfer where id = '$table_id' " );
					while($row = mysql_fetch_array($que))
					{ 
						$investment_id = $row['investment_id'];
						$income_tbl_id = $row['income_id'];
						$income_transfer_amount = $row['amount'];
						$income_payee_id = $row['user_id'];
						$investment_user_ids = $row['paying_id'];
						
						$sms_bank_name = $row['bank_name'];
						$sms_bank_acc = $row['bank_acc']; 	
					}
					levelupmember($investment_user_id);	
					get_speed_bonus($investment_user_ids,$income_transfer_amount,$table_id,$systems_date);
					$inv_username_log = get_user_name($investment_user_ids);
					$acc_username_log = get_user_name($income_payee_id);
					$title = "Payment Transfer E-mail";
					$to = get_user_email($investment_user_ids);
					$db_msg = $email_payment_transfer_message;
					include("function/full_message.php");
					$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);	
					$SMTPChat = $SMTPMail->SendMail();
					
					$date = $systems_date; //date('Y-m-d');
					
					
					$log_bank_info = get_bank_info_for_log($income_payee_id);
					$bank_account = $log_bank_info[0];
					$bank_name = $log_bank_info[1];
					$pay_income_log = $income_transfer_amount;
					include("function/logs_messages.php");
					data_logs($income_payee_id,$data_log[17][0],$data_log[17][1],$log_type[5]);	
					
					$phone = get_user_phone($income_payee_id);
					$db_msg = $setting_sms_user_pay_uploader_receiver;
					include("function/full_message.php");
					send_sms($phone,$full_message);	
					
					echo "<script type=\"text/javascript\">";
					echo "window.location = \"index.php?page=provide_donation&pay_err=5\"";
					echo "</script>";
				}	
				else
				{
					echo "<script type=\"text/javascript\">";
					echo "window.location = \"index.php?page=provide_donation&pay_err=2\"";
					echo "</script>"; 
				}	
			}
		}
		else
		{
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=provide_donation&pay_err=3\"";
			echo "</script>"; 	
		}	
	}
	else
	{
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=provide_donation&pay_err=4\"";
		echo "</script>"; 	
	}				
}
elseif(isset($_POST['Accept']))
{
	if($_SESSION['send_income_fo_user'] == 1)
	{
		$_SESSION['send_income_fo_user'] = 0;
		
		$time = date('Y-m-d H:i:s');
		$table_id = $_POST['approve_mdid'];
		$table_inv_id = $_POST['invst_id'];
		$sql = "select * from income_transfer where id = '$table_id' and mode = 1 ";
		$que = mysql_query($sql);
		mysql_query("update income_transfer set mode = 2 , time_confirm = '$time' where 
		id = '$table_id' " );
		while($row = mysql_fetch_array($que))
		{ 
			$investment_id = $row['investment_id'];
			$income_tbl_id = $row['income_id'];
			$income_transfer_amount = $row['amount'];
			$invst_paid_type = $row['paid_type'];
			$sms_bank_name = $row['bank_name'];
			$sms_bank_acc = $row['bank_acc']; 
			$investment_user_ids = $row['paying_id'];	
			$investment_receiver_id = $row['user_id'];	
			$profit = $setting_investment_plan[4];
			
			$trtr = mysql_query("select rec_mode from income where id = '$income_tbl_id' ");
			while($trrr = mysql_fetch_array($trtr))
			{
				$chk_rec_mode = $trrr[0];
			}
			if($chk_rec_mode == 1)
			{
				$new_amount = $income_transfer_amount/2;	
				$income_time = date('H:i:s');
				//mysql_query("insert into investment_request (user_id , amount , date , time , mode , rec_mode , priority ) values ('$investment_receiver_id' , '$new_amount' , '$systems_date' , '$income_time' , 1 , 0 , 1) ");
			}			

			
			$ch_quer = mysql_query("select * from income_transfer where investment_id = '$investment_id' and mode < 2 ");
			$chk_all_inv = mysql_num_rows($ch_quer);	
			if($chk_all_inv == 0)
			{			
				$tot_quer = mysql_query("select sum(amount) from income_transfer where investment_id = '$investment_id' ");
				while($rrrrr = mysql_fetch_array($tot_quer))
					$total_investments = $rrrrr[0];
					
				/*$real_par_iid = real_parent($investment_user_ids);
				$que = mysql_query("select max(amount) from income_transfer where paying_id  = '$real_par_iid' and mode = 2 ");
				while($roow = mysql_fetch_array($que))
				{
					$max_amnt = $roow[0];
				}
				if($max_amnt <= $total_investments)
				{
					$tot_que = mysql_query("select * from daily_interest where member_id  = '$real_par_iid' ");
					while($rrrrr = mysql_fetch_array($tot_que))
					{
						$chk_date = $rrrrr['date'];	
						$chk_end_date = $rrrrr['end_date'];	
					}
					$chk_end_d = get_date_without_sun_sat($chk_end_date,20);
					mysql_query("update daily_interest set date = '$chk_end_date' , end_date = '$chk_end_d' where member_id  = '$real_par_iid' and date <= '$systems_date' and end_date > '$systems_date' ");
				}
						
				$start_date = get_date_without_sun_sat($systems_date,0);
				$end_date = get_date_without_sun_sat($systems_date,20);
				/*mysql_query("insert into daily_interest (member_id , amount , date , start_date , end_date) value ('$investment_user_ids' , '$total_investments' , '$systems_date' , '$start_date' , '$end_date') ");*/
				
				
				$qq = mysql_query("select * from investment_request where id = '$table_inv_id' and rec_mode = 1");
				while($rowa = mysql_fetch_array($qq))
				{
					$rec_mode_inv = $rowa['rec_mode'];
					$inv_days = $rowa['inc_days'];
					$plan_profit = $rowa['inv_profit'];
					$plan_setting_id = $rowa['plan_setting_id'];
					$pqq = mysql_query("select * from plan_setting where id = '$plan_setting_id'");
					while($rp = mysql_fetch_array($pqq))
					{
						$direct_percent = $rp['direct_inc'];
					}
					if($rec_mode_inv == 1)
					{
						
						$start_date = date('Y-m-d',strtotime("$systems_date + 1 days"));
						$end_date = date('Y-m-d',strtotime("$start_date + $inv_days days"));
						
						$deduc_qu = mysql_query("select max(ref) as ref from deduction_history where user_id = '$user_id' and invest_id='$investment_id'");
						$dec_num = mysql_num_rows($deduc_qu);
						$ref1=0;
						if($dec_num > 0){
							while($rp = mysql_fetch_array($deduc_qu)){
								$ref1 = $rp['ref'];
								$ref1 = $ref[$ref1];
							}
						}
						$sqli = "insert into daily_interest (investment_id , member_id , amount , 
						percent , date , start_date , end_date , count , max_count,deduction) 
						values ('$table_inv_id' ,'$investment_user_ids' , '$total_investments' , 
						'$plan_profit' , '$systems_date' ,'$start_date','$end_date' , 0 , '$inv_days','$ref1') ";
						mysql_query($sqli);
						mysql_query("update wallet set amount= amount+'$total_investments' where id=".$_SESSION['ebank_user_id']."");
						get_ten_level_sponsor_income($investment_user_ids,$total_investments,$direct_percent,$systems_date);
						
						$cash_wal = get_wallet_amount($user_id);
						insert_wallet_account($user_id, $investment_user_ids, $total_investments, $time, $acount_type[7],$acount_type_desc[7], 1, $cash_wal , $wallet_type[1]); 
						
					}
				} 
				
				$acc_username_log = $receiver_username = get_user_name($investment_receiver_id);
				$inv_username_log = get_user_name($investment_user_ids);
				
				//new registration message
				$title = "Payment Accept";
				$to = get_user_email($investment_user_ids);
				$db_msg = $email_payment_accept_message;
				include("function/full_message.php");
				$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);	
				$SMTPChat = $SMTPMail->SendMail();
				
				$title = "Payment Receive";
				$to = get_user_email($investment_receiver_id);
				$db_msg = $email_payment_receive_message;
				include("function/full_message.php");
				$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);	
				$SMTPChat = $SMTPMail->SendMail();
				$phonesms1 = get_user_phone($investment_user_ids);
				$phonesms2 = get_user_phone($investment_receiver_id);
				$phone = get_user_phone($investment_user_ids);
				$db_msg = $setting_sms_user_payment_sender;
				include("function/full_message.php");
				send_sms($phone,$full_message);	
				
				$phone = get_user_phone($investment_receiver_id);
				$db_msg = $setting_sms_user_payment_receiver;
				include("function/full_message.php");
				send_sms($phone,$full_message);	
			}
		}
	}	
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=get_donation\"";
	echo "</script>";	
}
elseif(isset($_POST['Block_inv']))
{
	$block_user_id = $_POST['block_user_id'];
	

	mysql_query("update users set type = 'D' where id_user = '$block_user_id' " );

	$acc_username_log = get_user_name($user_ids);
	$investment_id = get_user_name($paying_id);
	$pay_income_log = $income_transfer_amount;
	include("function/logs_messages.php");
	data_logs($user_ids,$data_log[21][0],$data_log[21][1],$log_type[5]);	
	
	$phone = get_user_phone($block_user_id);
	$db_msg = $setting_sms_user_block_by_user;
	include("function/full_message.php");
	send_sms($phone,$full_message);	
	
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=welcome\"";
	echo "</script>";
		
}
elseif(isset($_POST['Inv_Blok_Usr']))
{
	$block_user_id = $_POST['block_user_id'];
	mysql_query("update users set type = 'X' where id_user = '$block_user_id' " );
	
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=welcome\"";
	echo "</script>";
}
elseif(isset($_POST['extend_time']))
{
	$table_id = $_POST['extend_mdid'];
	$hours = $_POST['hours'];
	$curr_time = $systems_date_time;
	
	$sql = "select * from income_transfer where id = '$table_id'";
	$qu = mysql_query($sql);
	while($rp = mysql_fetch_array($qu))
	{
		$paying_id = $rp['paying_id'];
		$time_link = $rp['time_link'];
		$invest_id = $rp['investment_id'];
	}
	$ext_time = date('Y-m-d H:i:s' , strtotime($curr_time. "+".$hours." hours"));
	$time_link = date('Y-m-d H:i:s' , strtotime($time_link. "+48 hours"));
	$start_date = new DateTime($curr_time);
	$since_start = $start_date->diff(new DateTime($time_link));
	$ext_diff = ($since_start->d*24+$since_start->h)." hours ".$since_start->i." minute ".$since_start->s." second ";
 $ext_time = date('Y-m-d H:i:s' , strtotime($ext_time. "+".$ext_diff));
	mysql_query("insert into deduction_history(user_id,by_user_id,ref,income_id,invest_id) values('$user_id','$paying_id','$hours','$table_id','$invest_id')");
	mysql_query("update income_transfer set extend_time = '$ext_time' where id = '$table_id' " );
	
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=get_donation\"";
	echo "</script>";
}
elseif(isset($_POST['report']))
{
	$user_id = $_POST['report_uid'];
	$table_id = $_POST['report_mdid'];
	$comment = $_POST['comment'];
	$gd_pd = $_POST['gd_pd'];
	$date = date('Y-m-d H:i:s');
	
	$sql = "select * from report where income_transfr_id = '$table_id' and user_id = '$user_id'";
	$qu = mysql_query($sql);
	$num  = mysql_num_rows($qu);
	if($num == 0)
	{
		$sqli = "insert into report (user_id , income_transfr_id , report , date) 
		values ('$user_id' ,'$table_id' , '$comment' , '$date') ";
		mysql_query($sqli);
		
		if($gd_pd == "pd")
		{
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=provide_donation&succ=1\"";
			echo "</script>";
		}
		else
		{
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=get_donation&succ=1\"";
			echo "</script>";
		}
	}
	else
	{ 
		if($gd_pd == "pd")
		{
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=provide_donation&succ=2\"";
			echo "</script>";
		}
		else
		{
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=get_donation&succ=2\"";
			echo "</script>";
		}
	}
}

function get_bank_info_for_log($user_id)
{
	$qu = mysql_query("select * from users where id_user = '$user_id' ");
	while($row = mysql_fetch_array($qu))
	{
		$results[0] = $row['ac_no'];
		$results[1] = $row['bank']; 	
	}
	return $results;
}
?>