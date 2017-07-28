<?php 
	ini_set('display_errors','off');
	session_start();
	include "../config.php";
	include('../function/setting.php');
	include('../function/functions.php');
	include('../function/sendmail.php');

	$activate_date = date("Y-m-d H:i:s", time());

	$txt_username = $_POST['txt_username'];
	$txt_sponsor_id =$_POST['txt_sponsor_id'];
	$txt_password=$_POST['txt_password'];
	$txt_security_code=$_POST['txt_security_code'];
	$txt_first_name=$_POST['txt_first_name'];
	$txt_last_name =$_POST['txt_last_name'];
	$txt_sex=$_POST['txt_sex'];
	$txt_email=$_POST['txt_email'];
	$txt_mobile=$_POST['txt_mobile'];
	$txt_country=$_POST['txt_country'];
	$txt_bank_name=$_POST['txt_bank_name'];
	$txt_bank_branch_name=$_POST['txt_bank_branch_name'];
	$txt_bank_account_holder=$_POST['txt_bank_account_holder'];
	$txt_bank_account_member=$_POST['txt_bank_account_member'];


	$mysql = mysql_query("SELECT * FROM users WHERE username = '$txt_username'");
	$mysql1 = mysql_query("SELECT * FROM users WHERE ac_no = '$txt_bank_account_member'");
	$mysql2 = mysql_query("SELECT * FROM users WHERE phone_no = '$txt_mobile'");
	$mysql3 = mysql_query("SELECT * FROM users WHERE email = '$txt_email'");
	$mysql4 = mysql_query("SELECT * FROM users WHERE username = '$txt_sponsor_id'");

	if(mysql_num_rows($mysql) > 0){
		echo 'Username already exist!';
	}else if( $txt_sponsor_id && mysql_num_rows($mysql4) == 0){
		echo 'Incorrect sponsor id!';	
	}else if(mysql_num_rows($mysql1) > 0){
		echo 'Bank account number already exist!';	
	}else if(mysql_num_rows($mysql2) > 0){
		echo 'Phone number already exist!';	
	}else if(mysql_num_rows($mysql3) > 0){
		echo 'Email already exist!';	
	}else{
		if(!empty($txt_sponsor_id)){
			$real_parent = get_new_user_id($txt_sponsor_id);

		    $q_tree = mysql_query("SELECT * FROM users WHERE real_parent = $real_parent");
		    $count = mysql_num_rows($q_tree);
		    $max_send = -1;
		    if ($count == 0) {
		        $max_send = 6;
		    }

		    if ($count == 1) {
		        $max_send = 8;
		    }

		    if ($count == 2) {
		        $max_send = 10;
		    }
		    $max_query = mysql_query("UPDATE users SET max_send_value = $max_send WHERE id_user = $real_parent");

		}
		$insert = mysql_query("INSERT INTO users (username, real_parent, password, user_pin, f_name, l_name, gender, email, phone_no, country, bank, branch, beneficiery_name, ac_no, activate_date, level, max_send_value) VALUES ('$txt_username', '$real_parent', '$txt_password', '$txt_security_code', '$txt_first_name', '$txt_last_name', '$txt_sex', '$txt_email', '$txt_mobile', '$txt_country', '$txt_bank_name', '$txt_bank_branch_name', '$txt_bank_account_holder', '$txt_bank_account_member', '$activate_date', '1', '4')");

    $max_query = mysql_query("UPDATE users SET max_send_value = $max_send WHERE id_user = $ebank_user_id");

		$user_id = mysql_insert_id();
		mysql_query("insert into ac_activation (user_id,photo_id,selfie_id,photo_mode,selfie_mode,mode) values('$user_id','p.jpg','p.jpg','1','1','1')");

		//insert_wallet
		$date = date('Y-m-d');
		$reg_amt = 0;
		mysql_query("insert into wallet (date, amount) values ('$date' , '$reg_amt') ");

		$query = mysql_query("SELECT id_user FROM users WHERE username = '$txt_username' ");
        $row = mysql_fetch_array($query);
        $user_id = $row[0];

        $code1 = rand(1000, 9999);
        $code2 = rand(1000, 9999);
        $code3 = rand(1000, 9999);
        $code4 = rand(1000, 9999);
        $code5 = rand(1000, 9999);
        $code6 = rand(1000, 9999);
        $code7 = rand(1000, 9999);
        $code8 = rand(1000, 9999);
        $code9 = rand(1000, 9999);
        $code10 = rand(1000, 9999);

        mysql_query("INSERT INTO user_code (user_id , code1 , code2 , code3 , code4 , code5 , code6 , code7 , code8 , code9 , code10 , date) VALUES ('$user_id' , '$code1' , '$code2' , '$code3' , '$code4' , '$code5' , '$code6' , '$code7' , '$code8' , '$code9' , '$code10' , '$date') ");

		
		//send mail
		$email = $txt_email;
	    	$name  = $txt_username;
	    	$title = 'Your account has been successfully created';
	  //   	$content = "<p>And thanks for joining our community!</p>
			// <p style='font-size: 15px'>Here are your account details:</p>
			// <p style='font-size: 15px'>Username: ".$txt_username."</p> 
			// <p style='font-size: 15px'>Password: ".$txt_password."</p>
			// <p style='font-size: 15px'>Let's make a better world with us.</p>";
			$content = 'A member has just added you to the system. Please log in now, buy Ticket and make a Sending to help the community.';
	   	sendMail($email,$name,$title,$content);
		if($insert){
			echo 'ok';
		}
	}

?>