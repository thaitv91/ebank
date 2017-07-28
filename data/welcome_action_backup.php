<?php

session_start();


include('condition.php');

include('function/setting.php');

include('function/functions.php');

include('function/send_mail.php');

include('function/income.php');

include("function/sendmail.php");



// Vinh
function find($result)
{
    $rows = array();
    while ($row = mysql_fetch_array($result))
    {
        $rows[] = $row;
    }
    return $rows;
}

function getFindOne($tbl, $id)
{
    $query = mysql_query("SELECT * FROM $tbl WHERE id_user = $id");

    $data = [];
    while ($row = mysql_fetch_array($query))
    {

        $data[] = $row;
    }

    return $data[0];
}



$allowedfiletypes = array("jpg" , "png" , "jpeg" , "gif");
$uploadfolder = $payment_receipt_img_full_path;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;
$user_id = $_SESSION['ebank_user_id'];
$level_vtype = get_user_level($user_id);
$invst_chk = $_REQUEST['inv'];
if($invst_chk == 1)
{
	print "<p>Success : Your Request of Investment has completed ! <br>
 		Please pay amount to showing Information !</p>";
 }





if (isset($_POST['Submit']))
{



    $table_id = $_POST['confirm_mdid'];

    $pay_code = $_POST['pay_code'];



    $unique_time = time();

    $unique_name = "CD" . $unique_time . $user_id;

    $uploadfilename = $_FILES['payment_receipt']['name'];



    $q123 = mysql_query("select * from income_transfer where id = '$table_id' ");



    $chk_pay_code = mysql_num_rows($q123);

    if ($chk_pay_code > 0)
    {

        if (!empty($_FILES['payment_receipt']['name']))
        {

            $fileext = strtolower(substr($uploadfilename, strrpos($uploadfilename, ".") + 1));



            if (!in_array($fileext, $allowedfiletypes))
            {

                echo "<script type=\"text/javascript\">";

                echo "window.location = \"index.php?page=provide_donation&pay_err=1\"";

                echo "</script>";
            }
            else
            {

                $fulluploadfilename = $uploadfolder . $unique_name . "." . $fileext;

                $unique_name = $unique_name . "." . $fileext;

                $time = date('Y-m-d H:i:s');



                if (copy($_FILES['payment_receipt']['tmp_name'], $fulluploadfilename))
                {

                    mysql_query("update income_transfer set mode = 1 , payment_receipt = 

					'$unique_name' , time_reciept = '$time' where id = '$table_id' ");



                    $que = mysql_query("select * from income_transfer where id = '$table_id' ");

                    while ($row = mysql_fetch_array($que))
                    {

                        $investment_id = $row['investment_id'];

                        $income_tbl_id = $row['income_id'];

                        $income_transfer_amount = $row['amount'];

                        $income_payee_id = $row['user_id'];

                        $investment_user_ids = $row['paying_id'];



                        $sms_bank_name = $row['bank_name'];

                        $sms_bank_acc = $row['bank_acc'];
                    }



                    //levelupmember($investment_user_id);



                    //update wallet
                    //get_speed_bonus($investment_user_ids,$income_transfer_amount,$table_id,$systems_date);

                    $inv_username_log = get_user_name($investment_user_ids);

                    $acc_username_log = get_user_name($income_payee_id);

                    $title = "Payment Transfer E-mail";

                    $to = get_user_email($investment_user_ids);

                    $db_msg = $email_payment_transfer_message;

                    //include("function/full_message.php");

                    //$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);

                    //$SMTPChat = $SMTPMail->SendMail();



                    $date = $systems_date; //date('Y-m-d');





                    $log_bank_info = get_bank_info_for_log($income_payee_id);

                    $bank_account = $log_bank_info[0];

                    $bank_name = $log_bank_info[1];

                    $pay_income_log = $income_transfer_amount;

                    //include("function/logs_messages.php");

                    //data_logs($income_payee_id, $data_log[17][0], $data_log[17][1], $log_type[5]);



                    $phone = get_user_phone($income_payee_id);

                    $db_msg = $setting_sms_user_pay_uploader_receiver;

                    //include("function/full_message.php");

                    //send_sms($phone, $full_message);



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
elseif (isset($_POST['Accept']))
{

        $_SESSION['send_income_fo_user'] = 0;

        $time = date('Y-m-d H:i:s');

        $table_id = $_POST['approve_mdid'];

        $table_inv_id = $_POST['invst_id'];

        $sql = "select * from income_transfer where id = '$table_id' and mode = 1 ";

        $que = mysql_query($sql);

        mysql_query("update income_transfer set mode = 2 , time_confirm = '$time' where id = '$table_id' ");

        while ($row = mysql_fetch_array($que))
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

            while ($trrr = mysql_fetch_array($trtr))
            {

                $chk_rec_mode = $trrr[0];
            }

            if ($chk_rec_mode == 1)
            {

                $new_amount = $income_transfer_amount / 2;

                $income_time = date('H:i:s');
            }







            $ch_quer = mysql_query("select * from income_transfer where investment_id = '$investment_id' and mode < 2 ");

            $chk_all_inv = mysql_num_rows($ch_quer);

            /*if ($chk_all_inv == 0)
            {

				
                $tot_quer = mysql_query("select sum(amount) from income_transfer where investment_id = '$investment_id' ");
                while ($rrrrr = mysql_fetch_array($tot_quer))
                    $total_investments = $rrrrr[0];

                $qq = mysql_query("select * from investment_request where id = '$table_inv_id' and rec_mode = 1");

                while ($rowa = mysql_fetch_array($qq))
                {
                    
                    $rec_mode_inv = $rowa['rec_mode'];

                    $inv_days = $rowa['inc_days'];

                    $plan_profit = $rowa['inv_profit'];

                    $plan_setting_id = $rowa['plan_setting_id'];

                    $pqq = mysql_query("select * from plan_setting where id = '$plan_setting_id'");

                    while ($rp = mysql_fetch_array($pqq))
                    {

                        $direct_percent = $rp['direct_inc'];
                    }

                    if ($rec_mode_inv == 1)
                    {


                        $start_date = date('Y-m-d', strtotime("$systems_date + 1 days"));

                        $end_date = date('Y-m-d', strtotime("$start_date + $inv_days days"));



                        $deduc_qu = mysql_query("select max(ref) as ref from deduction_history where user_id = '$user_id' and invest_id='$investment_id'");

                        $dec_num = mysql_num_rows($deduc_qu);

                        $ref1 = 0;

                        if ($dec_num > 0)
                        {

                            while ($rp = mysql_fetch_array($deduc_qu))
                            {

                                $ref1 = $rp['ref'];

                                $ref1 = $ref[$ref1];
                            }
                        }

                        $principel_with_roi = $total_investments + $total_investments * $plan_profit / 100;
                        mysql_query("update wallet set amount= amount+'$principel_with_roi' where id=" . $_SESSION['ebank_user_id'] . "");
                        $cash_wal = get_wallet_amount($user_id);
                    }
                }



                $acc_username_log = $receiver_username = get_user_name($investment_receiver_id);

                $inv_username_log = get_user_name($investment_user_ids);



                //new registration message

                $title = "Payment Accept";

                $to = get_user_email($investment_user_ids);

                $db_msg = $email_payment_accept_message;

                //include("function/full_message.php");

                //$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);

                //$SMTPChat = $SMTPMail->SendMail();



                $title = "Payment Receive";

                $to = get_user_email($investment_receiver_id);

                $db_msg = $email_payment_receive_message;

                //include("function/full_message.php");

                //$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);

                //$SMTPChat = $SMTPMail->SendMail();

                $phonesms1 = get_user_phone($investment_user_ids);

                $phonesms2 = get_user_phone($investment_receiver_id);

                $phone = get_user_phone($investment_user_ids);

                $db_msg = $setting_sms_user_payment_sender;

                //include("function/full_message.php");

                //send_sms($phone, $full_message);



                $phone = get_user_phone($investment_receiver_id);

                $db_msg = $setting_sms_user_payment_receiver;

                //include("function/full_message.php");

                //send_sms($phone, $full_message);
            }*/
        }

		


        get_speed_bonus($investment_user_ids,$income_transfer_amount,$table_id,$systems_date);

	
        //get plansetting

        $investment = mysql_query("select * from investment_request where id = " . $table_inv_id . " ");

        $r_investment = mysql_fetch_array($investment);

        $plansetting = mysql_query("select * from plan_setting where id = " . $r_investment['plan_setting_id'] . " ");

        $r_plansetting = mysql_fetch_array($plansetting);

        //% Direct Income of Plansetting

        $direct_inc = $r_plansetting['direct_inc'];



        //find parent 

        $user = mysql_query("select * from users where id_user = " . $investment_user_ids . " ");

        $trrr = mysql_fetch_array($user);

        $parent_sponsor = $trrr['real_parent'];

		$time = date('Y-m-d H:i:s', time());
		$cash_wal = get_wallet_amount($investment_user_ids);

        //find manager parent;

        $idloop = $parent_sponsor;

        if (!empty($idloop))
        {
            
            $manager_parent = (tree_manager($idloop));

            foreach ($manager_parent as $key => $value)
            {
                $level_income = find_level_income($value['level']);
                $manager_bonus = $income_transfer_amount * $level_income / 100;
                $update_manager = mysql_query("update wallet set manager_wallet = manager_wallet+" . $manager_bonus . ", com_wallet = com_wallet+" . $manager_bonus . " where id = " . $value['id_user'] . " ");
				//insert to account
				$comwallet = get_wallet_commission($value['id_user']);
				insert_wallet_account($value['id_user'], $investment_user_ids, $manager_bonus, $time, $acount_type[11],$acount_type_desc[11], 1, $comwallet , $wallet_type[3]); 
				
				//insert user_income for manager bonus
				$insert_user_income = mysql_query("insert into user_income (user_id , income, income_id, investment_id , date , type ) 
				values ('".$value['id_user']."' , '".$manager_bonus."', '".$table_id."', '".$r_investment['id']."' , '".$time."' , '".$income_type[5]."') ");
            }
        }

        //update sponsor bonus
        $sponsor_bonus = $income_transfer_amount * $direct_inc / 100;
        $update_sponsor = mysql_query("update wallet set sponsor_wallet = sponsor_wallet+" . $sponsor_bonus . ", com_wallet = com_wallet+" . $sponsor_bonus . " where id = " . $parent_sponsor . " ");
		
        //insert to account
		$comwallet = get_wallet_commission($parent_sponsor);
		insert_wallet_account($parent_sponsor, $investment_user_ids, $sponsor_bonus, $time, $acount_type[10],$acount_type_desc[10], 1, $comwallet , $wallet_type[3]); 
       // var_dump($investment_user_ids); exit;
		//insert user income
        $insert_userincome = mysql_query("insert into user_income (user_id , income , income_id, investment_id , date , type, level ) values ('$parent_sponsor' , '$sponsor_bonus' , '$id' , '$table_inv_id' ,'$time' , '$income_type[7]','0') ");
		// update level
		update_level($investment_user_ids);
        //update wallet
		


    echo "<script type=\"text/javascript\">";

    echo "window.location = \"index.php?page=get_donation\"";

    echo "</script>";
}
elseif (isset($_POST['Block_inv']))
{

    $block_user_id = $_POST['block_user_id'];





    mysql_query("update users set type = 'D' where id_user = '$block_user_id' ");



    $acc_username_log = get_user_name($user_ids);

    $investment_id = get_user_name($paying_id);

    $pay_income_log = $income_transfer_amount;

    include("function/logs_messages.php");

    data_logs($user_ids, $data_log[21][0], $data_log[21][1], $log_type[5]);



    $phone = get_user_phone($block_user_id);

    $db_msg = $setting_sms_user_block_by_user;

    include("function/full_message.php");

    send_sms($phone, $full_message);



    echo "<script type=\"text/javascript\">";

    echo "window.location = \"index.php?page=welcome\"";

    echo "</script>";
}
elseif (isset($_POST['Inv_Blok_Usr']))
{

    $block_user_id = $_POST['block_user_id'];

    mysql_query("update users set type = 'X' where id_user = '$block_user_id' ");



    echo "<script type=\"text/javascript\">";

    echo "window.location = \"index.php?page=welcome\"";

    echo "</script>";
}
elseif (isset($_POST['extend_time']))
{

    $table_id = $_POST['extend_mdid'];

    $hours = $_POST['hours'];

    $curr_time = $systems_date_time;



    $sql = "select * from income_transfer where id = '$table_id'";

    $qu = mysql_query($sql);

    while ($rp = mysql_fetch_array($qu))
    {

        $paying_id = $rp['paying_id'];

        $time_link = $rp['time_link'];

        $invest_id = $rp['investment_id'];
    }

    $max_time = $max_time[$level_vtype] - 24;

    $ext_time = date('Y-m-d H:i:s', strtotime($curr_time . "+" . $hours . " hours"));

    $time_link = date('Y-m-d H:i:s', strtotime($time_link . "+$max_time hours"));

    $start_date = new DateTime($curr_time);

    $since_start = $start_date->diff(new DateTime($time_link));

    $ext_diff = ($since_start->d * 24 + $since_start->h) . " hours " . $since_start->i . " minute " . $since_start->s . " second ";

    $ext_time = date('Y-m-d H:i:s', strtotime($ext_time . "+" . $ext_diff));

    mysql_query("insert into deduction_history(user_id,by_user_id,ref,income_id,invest_id) values('$user_id','$paying_id','$hours','$table_id','$invest_id')");

    mysql_query("update income_transfer set extend_time = '$ext_time' where id = '$table_id' ");



    echo "<script type=\"text/javascript\">";

    echo "window.location = \"index.php?page=get_donation\"";

    echo "</script>";
}
elseif (isset($_POST['report']))
{

    $user_id = $_POST['report_uid']; //user bấm report

    $reported= $_POST['report_uir']; //user bị report

    $investment_id= $_POST['report_invest']; //id investment

    $table_id = $_POST['report_mdid']; // id income_transfer

    $comment = $_POST['comment']; // 

    $gd_pd = $_POST['gd_pd']; // PD hay GD

    $date = date('Y-m-d H:i:s');


    $sql = "select * from report where reported = ".$reported." and mode=1";

    $qu = mysql_query($sql);

    $num = mysql_num_rows($qu);

    if ($num == 0)
    {
		//get tb_time_report
        $sql_time_block = mysql_query("SELECT * FROM tb_time_block");
        $row_time_report = mysql_fetch_array($sql_time_block);
        $time_report = $row_time_report['time_report'];


        //select user id
        $mysql_user = mysql_query("SELECT * FROM users WHERE id_user = ".$reported."");
        $row_my_user = mysql_fetch_array($mysql_user);
        if($row_my_user['report_time'] < $time_report){
            //update report time
            mysql_query("UPDATE users SET report_time = report_time+1 WHERE id_user = ".$reported."");
        }else{
            //update report time
            mysql_query("UPDATE users SET report_time = 0 WHERE id_user = ".$reported."");
            //kiểm tra user đã bị đóng băng chưa
            $check_fro = mysql_query("SELECT *  FROM report WHERE reported = ".$reported." AND mode = ".$mode_report[2]."");
            $count_fro = mysql_num_rows($check_fro);
            if(empty($count_fro)){
                //frozen this user_id
                mysql_query("INSERT INTO report (reported , report , mode , date, frozen_date) values ($reported' , '$alert_report[2]' , '$mode_report[2]' , '$date', '$date') ");
                // insert into report history
                mysql_query("INSERT INTO tb_report_history (reported , report , mode , date)  VALUES ($reported' , '$alert_report[2]' , $mode_report[2]' , '$date')");
				//update frozen time
                mysql_query("UPDATE users SET frozen_time = frozen_time+1 WHERE id_user = ".$reported."");
				
				
            }
        }

        $sqli = mysql_query("insert into report (user_id, reported , income_transfr_id , investment_id , report , type , mode , date) 

		values ('$user_id' , '$reported' , $investment_id , '$table_id' , '$comment' , '$gd_pd' , '$mode_report[1]' , '$date') ");

        // insert into report history
        mysql_query("INSERT INTO tb_report_history (user_id, reported , income_transfr_id , investment_id , report , type , mode , date)  VALUES ('$user_id' , '$reported' , $investment_id , '$table_id' , '$comment' , '$gd_pd' , '$mode_report[1]' , '$date')");

        // hidden investment_request by user_id
        $hidden_invest = mysql_query("SELECT * FROM investment_request WHERE user_id = ".$reported." AND mode = 1");
        while($r_hidden_invest = mysql_fetch_array($hidden_invest)){
            mysql_query("UPDATE investment_request SET mode = 5 WHERE id = ".$r_hidden_invest['id']."");
        }

        // hidden incom by user_id
        $hidden_income = mysql_query("SELECT * FROM income WHERE user_id = ".$reported." AND mode = 1");
        while($r_hidden_income = mysql_fetch_array($hidden_income)){
            mysql_query("UPDATE income SET mode = 5 WHERE id = ".$r_hidden_income['id']."");
        }
		
		//send mail
		$report_username = get_user_name($user_id);
        		$email = get_user_email($reported);
        		$name  = get_user_name($reported);
        		$title = 'Your account has been reported';
        		$content = "You have been reported by ".$report_username." member.<br>You have 48 hours from now to solve your account's problems.";
        		sendMail($email,$name,$title,$content); 
		



        if ($gd_pd == "pd") //Nếu PD chuyển tới provide_donation
        {

            echo "<script type=\"text/javascript\">";

            echo "window.location = \"index.php?page=provide_donation&succ=1\""; // báo Report Successfully Added !!

            echo "</script>";
        }
        else // nếu GD chuyển tới  get_donation
        {

            echo "<script type=\"text/javascript\">";

            echo "window.location = \"index.php?page=get_donation&succ=1\""; // báo Report Successfully Added !!

            echo "</script>";
        }
    }
    else
    {

        if ($gd_pd == "pd")
        {

            echo "<script type=\"text/javascript\">";
  
            echo "window.location = \"index.php?page=provide_donation&succ=2\""; //báo Report Already have Submitted By You !!

            echo "</script>";
        }
        else
        {

            echo "<script type=\"text/javascript\">";

            echo "window.location = \"index.php?page=get_donation&succ=2\""; //báo Report Already have Submitted By You !!

            echo "</script>";
        }
    }
}

function get_bank_info_for_log($user_id)
{

    $qu = mysql_query("select * from users where id_user = '$user_id' ");

    while ($row = mysql_fetch_array($qu))
    {

        $results[0] = $row['ac_no'];

        $results[1] = $row['bank'];
    }

    return $results;
}



function find_level_income($id)
{

    $query = mysql_query("select * from tb_level_plan where id = $id");

    $row = mysql_fetch_array($query);

    return $row['level_income'];
}






?>