<?php
// select from setting table
include 'account_maintain.php';

$url_local = 'http://' . $_SERVER['HTTP_HOST'];
$limit_ph = 4200000;

$query = mysql_query("select * from setting ");
while($row = mysql_fetch_array($query))
{
	//messages
	$welcome_message = $row['welcome_message'];
	$forget_password_message = $row['forget_password_message'];
	$payout_generate_message = $row['payout_generate_message'];
	$email_welcome_message = $row['email_welcome_message'];
	$direct_member_message = $row['direct_member_message'];
	$payment_request_message = $row['payment_request_message'];
	$payment_transfer_message = $row['payment_transfer_message'];
	$user_pin_generate_message = $row['user_pin_generate_message'];
	$epin_generate_message = $row['epin_generate_message'];
	$member_to_member_message = $row['member_to_member_message']; 
	$transfer_to_member_message = $row['transfer_to_member_message']; 
	$direct_income_percent = $row['direct_income_percent'];
	$epin_value = $row['epin_value']; 
	$other_withdrwal_per = $row['binary_income_percent']; 
	$make_shopping_email = $row['make_shopping_email'];
	$minimun_invests_amount = $row['minimun_invest'];
	$max_transfer_count = $row['transfer_count'];
	$setting_registration_amount = $row['registration_fees'];
	$level = $row['parent_limit'];
	$minimum_withdrawal = $row['minimum_withdrawal'];
	$ten_level_sponsor_percent = $row['ten_level_sponsor_percent'];
	$per_day_multiple_binary_pair = $row['per_day_multiple_pair'];
	$per_day_max_binary_inc_db = $row['per_day_max_binary_inc'];
	$setting_epin_price = $row['epin_price'];
	$setting_epin_amount = $row['epin_value'];
	
	//sms sett.
	
	$setting_sms_registration_user = $row['user_register_sms'];
	$setting_sms_user_payment_receiver = $row['user_payment_receiver_sms'];
	$setting_sms_user_payment_sender = $row['user_payment_sender_sms'];
	$setting_sms_make_invsetment = $row['make_invsetment_sms'];
	$setting_real_parent_bonus_inc = $row['real_parent_bonus_inc'];
	
	$setting_investment_paying_income[1] = $row['first_inv_income'];
	$setting_investment_paying_income[2] = $row['second_inv_income'];
	$setting_investment_paying_income[3] = $row['third_inv_income'];
	$setting_investment_paying_income[4] = $row['fourth_inv_income'];
	
	$setting_thou_nnager_income = $row['thou_nnager_income'];
	$setting_cdbv_join_amt =10;
}
$setting_cdbv_admin_ac = "303604";
$setting_cdbv_admin_bank = "SBI";
$setting_cdbv_admin_branch = "Jaipur";
$setting_cdbv_admin_name = "Admin";
$maximum_withdrawal = 5000;


$amt_multiple = 100;
/*$q = mysql_query("select * from plan_setting ");
while($row = mysql_fetch_array($q))
{$setting_inv_profit  = $row['profit'];	$setting_inv_name = $row['plan_name'];$setting_inv_days = $row['days'];*/
	
$quee = mysql_query("select * from setting_variable ");
while($rrs = mysql_fetch_array($quee))
{
	$$rrs['variable'] = $rrs['field'];
}
$gd_status_time[0] = '48';
$gd_status_time[1] = 'hours';
/*$setting_sms_invsetment_link_receiver = "Dear #receiver_username , #sender_username has been assigned to you as donor get help within 48 hrs. Paycode  - #investment_pay_code . www.cryptohelps.net";
$setting_sms_invsetment_link_sender = "Dear #sender_username , #receiver_username has been assigned as receiver to you. Please pay your help within 48 hours. www.cryptohelps.net";

$email_bblock_user_message = " #block_username ";
$email_payment_transfer_link_message = " #sender_username  #current_pay_amount  #receiver_username ";
$email_payment_accept_message = " #inv_username_log #receiver_username #total_amount ";
$email_payment_receive_message = " #inv_username_log #receiver_username #total_amount ";
$email_payment_transfer_message = "#inv_username_log #income_transfer_amount #acc_username_log";


//sms

$setting_sms_user_payment_sender = '#inv_username_log #total_investments';
$setting_sms_user_payment_receiver = '#acc_username_log #total_investments';

$setting_sms_user_pay_uploader_receiver = '#acc_username_log #income_transfer_amount';
$setting_sms_user_investment_request = '#acc_username_log  #request_amount';
$setting_sms_user_block_by_user = '#acc_username_log ';
$setting_sms_user_block_by_admin = ' #block_username';*/

$setting_inv_amount = $epin_value;
$setting_inv_end_amount = 50000000000; 


$pos = 0;
$virtual_parent_condition = 1;


$quw = mysql_query("select * from plan_setting ");
while($rrr = mysql_fetch_array($quw))
{
	$min_inv_amount[] = $rrr['amount'];
	$max_inv_amount[] = $rrr['end_amount'];  	 	
}
$plan_diff = $min_inv_amount[0]/$epin_value;
$quw = mysql_query("select * from epin_setting ");
$es = 1;
while($rrr = mysql_fetch_array($quw))
{
	$epin_setting[$es][0] = $rrr['day'];
	$epin_setting[$es][1] = $rrr['week'];
	$epin_setting[$es][2] = $rrr['month'];
	$es++;	 	
}
$tot_inv_plan = count($max_inv_amount);

// starting year and month
$start_year = 2010;
$start_month = 01;


//Link send max time
$quw = mysql_query("select * from link_time_limit ");
$ps = 1;
while($rrr = mysql_fetch_array($quw))
{
	$max_time[$ps] = $rrr['hour'];
	$ps++;	 	
}

$quw = mysql_query("select * from gd_link_time_limit ");
while($rrr = mysql_fetch_array($quw))
{
	$gd_time = $rrr['hour'];
}

$py = 1;
$quwyy = mysql_query("select * from re_pd_time ");
while($rry = mysql_fetch_array($quwyy))
{
	$re_pd_time[$py] = $rry['hour'];
	$py++;	 	
}
// registration types
$type[0] = "A";
$type[1] = "B";

//product id for registration

$product_id[1] = "reg";

//income

/*$income[1] = 20;  //survey income
$income[2] = 30;  //direct member income
*/

// registration fees

$minimum_registration_fees = 0;
$registration_fees = 500;

// deduction reference
$ref[12] = 5; //12 extend time ref
$ref[24] = 10; //24 extend time ref
$ref[3] = 3; //5 block ref

//income type direct
$income_type[1] = 1;  // direct income 
$income_type[2] = 2;  // binary income
$income_type[3] = 3;  // level income
$income_type[4] = 4;  // 10 Manager income
$income_type[5] = 5;  // Sponsor income ok
$income_type[6] = 6;  // investment daily income  ok
$income_type[7] = 7;  // 5 Manager income 
$income_type[8] = 8;  // speed bonus on receipt upload in 24 hours  ok
$income_type[9] = 9;  // confirmation bonus on receipt accept in 24 hours  
$income_type[10] = 10; // Reffral Activate income 

$speed_bonus_percent = 5;
$speed_bonus_maximum_time = 24*60*60;
$direct_percent = 10;
// daily invest details

$q = mysql_query("select * from plan_setting order by id asc ");
$plan_count = mysql_num_rows($q);
$p=0;
while($row = mysql_fetch_array($q))
{
	$setting_investment_plan[$p][0] = $row['id'];
	$setting_investment_plan[$p][1] = $row['plan_name'];
	$setting_investment_plan[$p][2] = $row['amount'];
	$setting_investment_plan[$p][3] = $row['end_amount'];
	$setting_investment_plan[$p][4] = $row['profit'];
	$setting_investment_plan[$p][5] = $income_hold_days = $row['days'];
	$p++; 	 	
}

$setting_min_investment_amount = $setting_investment_plan[0][2];
$setting_min_investment_profit = $setting_investment_plan[0][4];
$setting_min_payment_amount = 500;

// registration mode

$fund_transfer_mode[0] = "wallet";
$fund_transfer_mode[1] = "ge_currency";
$fund_transfer_mode[2] = "liberty";
$fund_transfer_mode[3] = "Perfect_money";
$fund_transfer_mode[4] = "alert_pay";
$fund_transfer_mode[5] = "uae_exchange";
$fund_transfer_mode[6] = "western_union";
$fund_transfer_mode[7] = "credit_card";
$fund_transfer_mode[8] = "bank_wire";

// maximum pd for M1,M2,M3,M4,M5,M6
$quw = mysql_query("select * from pd_setting ");
$ps = 1;
while($rrr = mysql_fetch_array($quw))
{
	$min_pd_settings[$ps] = $rrr['min_pd'];
	$max_pd_settings[$ps] = $rrr['max_pd'];
	$ps++;	 	
}
$quw = mysql_query("select * from pd_gd_amt_setting ");
$ps = 1;
while($rrr = mysql_fetch_array($quw))
{
	$min_pd_amt_settings[$ps] = $rrr['min_pd'];
	$max_pd_amt_settings[$ps] = $rrr['max_pd'];
	$min_mw_gd_amt_settings[$ps] = $rrr['min_mw_gd'];
	$max_mw_gd_amt_settings[$ps] = $rrr['max_mw_gd'];
	$min_cw_gd_amt_settings[$ps] = $rrr['min_cw_gd'];
	$max_cw_gd_amt_settings[$ps] = $rrr['max_cw_gd'];
	$ps++;	 	
}//Vinh$quw1 = mysql_query("select * from gd_dwm_setting ");$ps = 1;while($rrr = mysql_fetch_array($quw1)){	$min_mw_gd_amt_settings[$ps] = $rrr['day_amt_limit'];	$max_mw_gd_amt_settings[$ps] = $rrr['week_amt_limit'];	$min_cw_gd_amt_settings[$ps] = $rrr['month_amt_limit'];	$ps++;	 	}//end$quw =
$quw = mysql_query("select * from pd_dwm_setting ");
$ps = 1;
while($rrr = mysql_fetch_array($quw))
{
	$pd_dwm_settings[$ps][0] = $rrr['day'];
	$pd_dwm_settings[$ps][1] = $rrr['week'];
	$pd_dwm_settings[$ps][2] = $rrr['month'];
	$ps++;	 	
}

$quw = mysql_query("select * from gd_dwm_setting ");
$ps = 1;
while($rrr = mysql_fetch_array($quw))
{
	$gd_dwm_amt[$ps][0] = $rrr['day_amt_limit'];
	$gd_dwm_amt[$ps][1] = $rrr['week_amt_limit'];
	$gd_dwm_amt[$ps][2] = $rrr['month_amt_limit'];
	$ps++;	 	
}

$quw = mysql_query("select * from gd_setting ");
$ps = 1;
while($rrr = mysql_fetch_array($quw))
{
	$min_gd_settings[$ps] = $rrr['min_gd'];
	$max_gd_settings[$ps] = $rrr['max_gd'];
	$ps++;	 	
}
/*$level_up_setting[1][0] = 5;
$level_up_setting[1][1] = 3; */
$level_up_setting = array(
    array(6, 3),
    array(3, 3),
	array(3, 3),
	array(3, 3),
	array(3, 3),
	array(3, 3)
); // key 0 member required // key 1 member investment required
// registration mode value
$fund_transfer_mode_value[0] = "E-Wallet";
$fund_transfer_mode_value[1] = "Ge Currency";
$fund_transfer_mode_value[2] = "Liberty Reserve";
$fund_transfer_mode_value[3] = "Perfect Money"; 
$fund_transfer_mode_value[4] = "Alert Pay";
$fund_transfer_mode_value[5] = "UAE Exchange";
$fund_transfer_mode_value[6] = "Western Union";
$fund_transfer_mode_value[7] = "Credit Card";
$fund_transfer_mode_value[8] = "Bank Wire";

$per_day_multiple_binary_pair = $per_day_multiple_pair = 1000; // per_day_multiple_binary_pair
$pair_point_percent = 10; //pair_point_percent
$per_day_max_binary_inc_db = 1000000;
$reffral_bonus_for_registration = 1000000;
//mail setting

$from = "alert@ebank.tv";
$SmtpServer="mail.ebank.tv";
$SmtpPort="25"; //default
$SmtpUser="alert@ebank.tv";
$SmtpPass="9829061228";

// penalty roi deduction
$penalty_protection = 10;
$user_protection = 5;
//

// alert report
$alert_report[1] = "This transaction being hold";
$alert_report[2] = "being reported many time consecutive";
$alert_report[3] = "being blocked";
$alert_report[4] = "After sending Bitcoin to 13c3heZzgctorHDHaHvXt9QVt9A4dg7N8a, please upload a payment receipt or enter your Bitcoin address in the box above to confirm your payment. Your payment will be processed within 12 hours.";
//mode block
$mode_report[1] = 1; // reported
$mode_report[2] = 2; // frozen
$mode_report[3] = 3; // blocked
$mode_report[4] = 4; // remove report
$mode_report[5] = 5; // remove frozen
$mode_report[6] = 6; // unblock
?>