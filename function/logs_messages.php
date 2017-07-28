<?php

//log data


$data_log[1][0] = "edit profile";  // edit title
$data_log[1][1] = "Profile updated of user ".$username." on ".$date." by ".$updated_by;  // edit data
$data_log[2][0] = "Edit Password";  // edit title
$data_log[2][1] = "Password updated of user ".$username." on ".$date." by ".$updated_by;  // edit data
 
$data_log[3][0] = "New user registration";  //  Wallet title
$data_log[3][1] = "New user ".$username." registered with Amount ".$reg_amount." on ".$date." By ".$real_parent_username_log;  // other data
$data_log[5][0] = "New wallet inserted";  //  edit title
$data_log[5][1] = "wallet inserted of new user ".$username;  // registration data
$data_log[4][0] = "Update wallet";  // network title
$data_log[4][1] = "Update wallet of ".$log_username." by receiving amount $".$income_log."  <font color=dark>$ </font> on ".$date." As ".$income_type_log;  //  Wallet data
$data_log[6][0] = "User Activate";  // network title
$data_log[6][1] = "User ".$username_log." Successfully Activate by using E-pin : ".$epin_log." on ".$date; //  Wallet data

$data_log[7][0] = "User Ugradation";  // network title
$data_log[7][1] = "User ".$username_log." Ugrade his status by using E-pin : ".$epin_log." on ".$date; 
$data_log[8][0] = "Update wallet";  // network title
$data_log[8][1] = "Update wallet of ".$username_log." by reducing amount $".$income_log."  <font color=dark>$ </font> by ".$for." on ".$date; //  Wallet data

$data_log[9][0] = "E-pin generate";  // network title
$data_log[9][1] = "User ".$username_log." Generate E-pin : ".$epin_log." on ".$date;  //  Wallet data
$data_log[10][0] = "E-pin Used";  // network title
$data_log[10][1] = "User ".$real_parent_username_log." Used E-pin : ".$reg_pin_used." for New User ".$username." on ".$date;  //  Wallet data


$data_log[11][0] = "New Investment Request";  // network title
$data_log[11][1] = "User ".$inv_username_log." make New Investment of amount $ ".$invest_amount." on ".$date;  //  Wallet data

$data_log[13][0] = "New Investment Accepted";  // network title
$data_log[13][1] = "User ".$acc_username_log." Accepted Investment Request of Amount $ ".$amount." By ".$inv_username_log." on ".$date;  

$data_log[13][0] = "New Investment Cancled";  // network title
$data_log[13][1] = "User ".$acc_username_log." Cancled Investment Request of Amount $ ".$amount." By ".$inv_username_log." on ".$date;  


$data_log[14][0] = "Income Received";  // network title
$data_log[14][1] = "User ".$acc_username_log." Receive ".$income_type." income of Amount $ ".$amount." By ".$inv_username_log." on ".$date;  //  Wallet data

$data_log[15][0] = "Wallet Update";  // network title
$data_log[15][1] = "Wallet of User ".$acc_username_log." has updated by Receiving Amount ".$amount_log." as ".$income_type_log." income on ".$date." , His Wallet Balance ".$wallet_amount_log." has Changed Now his Current Balance ".$total_wallet_amount;  //  Wallet data

$data_log[16][0] = "Wallet Update";  // network title
$data_log[16][1] = "Wallet of User ".$acc_username_log." has updated by Reducing Amount ".$income_log." as Withdrawal Request on ".$date." , His Wallet Balance ".$wallet_amount_log." has Changed Now his Current Balance ".$total_wallet_amount;  //  Wallet data



$data_log[17][0] = "Investment Payment";  // network title
$data_log[17][1] = "User ".$inv_username_log." has paid amount ".$product_cost." in Bank A/C : ".$bank_account." of Bank ".$bank_name." of User ".$acc_username_log." as new Investment on ".$date;  //  Wallet data

$data_log[18][0] = "Payment Receive";  // network title
$data_log[18][1] = "User ".$acc_username_log." has received amount ".$pay_income_log." as ".$income_pay_type." in Bank A/C ".$bank_account." of Bank ".$bank_name." fron User ".$inv_username_log." as new Investment on ".$date;  //  Wallet data

$data_log[19][0] = "Set User Priority";  // network title
$data_log[19][1] = "Priority of user ".$priority_username_log." has set by ADMIN on ".$curr_date;  //  Wallet data

$data_log[20][0] = "Payment Receive";  // network title
$data_log[20][1] = "User ".$acc_username_log." has received amount ".$pay_income_log." as ".$income_pay_type." in Bank A/C ".$bank_account." of Bank ".$bank_name." fron User ".$inv_username_log." as new Investment on ".$date;  //  Wallet data


$data_log[21][0] = "Investment Block";  // network title
$data_log[21][1] = "User ".$acc_username_log." has blocked investment of user ".$investment_id." of amount ".$pay_income_log." on ".$date;  //  Wallet data


$data_log[22][0] = "New Investment By Admin";  // network title
$data_log[22][1] = "User ".$user_name." has made investment of amount ".$investment_amount." <font color=dark>$ </font> on ".$investment_date." By System ADMIN";;  //  Wallet data



//log data

$log_type[1] = 1;  // profile log
$log_type[2] = 2;  // password log
$log_type[3] = 3;  // registration log
$log_type[4] = 4;  //  Update wallet add
$log_type[5] = 5;  //  investment Logs 
$log_type[6] = 6;  //  Update wallet reduce
$log_type[7] = 7;  //  User E-pin Transfer
$log_type[8] = 8;  //  shopping
$log_type[9] = 9;  //  withdrall requst
$log_type[10] = 10;  // block member
$log_type[11] = 11;  //  Board Voucher Generated
$log_type[12] = 12;  //  Transfer Board Voucher
$log_type[13] = 13;  //  receive board voucher
$log_type[14] = 14;  //  update setting
$log_type[15] = 15;  //  Board Break
$log_type[16] = 16;  //  wallet amount edit
$log_type[17] = 17;  //  block member


// sms message 

$message1 = "Hi $username , You have Invested $ $invest_amount  <font color=dark>$ </font> on $date. Thanks From Royal Trader Group";
