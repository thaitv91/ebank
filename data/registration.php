<?php
ini_set("display_errors", "off");
session_start();
$ebank_user_type = $_SESSION['ebank_user_type'];

//check acount reported
date_default_timezone_set('Etc/UTC');

require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

//require 'https://' . $_SERVER['HTTP_HOST'] . '/phpmailer/class.phpmailer.php';
//require 'https://' . $_SERVER['HTTP_HOST'] . '/phpmailer/class.smtp.php';


include 'function/Mailin.php';
function sendMail($email,$name,$title,$content){
    
    $contentEmail = contentEmail($name,$content);
    $mailin = new Mailin('support@ebank.tv', 'QpRfvH4FGSN5tYKb');
    $mailin->
    addTo($email, $name)->
    setFrom('support@blsinvestments.com', 'Vwallet Community')->
    setReplyTo('support@ebank.tv','vwallet Community')->
    setSubject($title)->
    setText($title)->
    setHtml($contentEmail);
    
    $res = $mailin->send();
}



function contentEmail($name, $content){
    $template = '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="user-scalable=yes, width=device-width, initial-scale=1.0, minimum-scale=1" name="viewport">
    <title>Email Marketing</title>
    <link rel="stylesheet" type="text/css" href="http://vwallet.uk/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://vwallet.uk/css/style_email.css">
</head>
<body>
<div class="img-logo" style="padding: 50px 0; text-align:center;">
    <img src="http://vwallet.uk/images/newlayout/ebank.png" class="img-responsive" style="display: block;height: auto;max-width: 100%; margin:0 auto;">
</div>
<div class="content" style="background-color: #fff;margin: 0 auto;width: 616px !important;">
    <div class="bg">
        <img src="http://vwallet.uk/images/newlayout/banner2.png" class="img-responsive" style=" display: block;height: auto;max-width: 100%;">
    </div>
    <div class="mail-content" style="color: #1b1b1b;padding: 20px 30px;">
        <h4 style="color: #31c7ff;font-weight: bold;padding-bottom: 15px;font-size: 18px;margin-bottom: 10px;margin-top: 10px;">Dear '.$name.',</h4>
        <p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px;">'.$content.'</p>
        <p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px;">
        Regards,<br>
        <strong>The vwallet team</strong>
        </p>
    </div><!--/mail-content-->
</div><!--/content-->
<footer>
    <p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px; text-align:center;">5 Matthew, Liverpool, M1 6BB, Vương Quốc Anh.</p>
    <p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px; text-align:center;">&copy;2017 vwallet Community</p>
</footer>
</body>
</html>';
    return $template;
}
// 


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

function find($result)
{
    $rows = array();
    while ($row = mysql_fetch_array($result))
    {
        $rows[] = $row;
    }
    return $rows;
}

function resultlevel($user_id)
{
    $count_income_cha = 0;
    $count_income_con = 0;

    $investment_cha = find(mysql_query("select * from investment_request where user_id=$user_id"));
    foreach ($investment_cha as $investment)
    {
        $investment_id = $investment['id'];
        $count_pd = mysql_num_rows(mysql_query("select * from income_transfer where investment_id=$investment_id and mode=2"));
        if ($count_pd > 0)
            $count_income_cha += 1;
    }
    $int_mode_cha = mysql_num_rows(mysql_query("select * from income_transfer where paying_id=$user_id and mode=2"));

    $user = getFindOne('users', $user_id);

    $level = $user['level'];
    $real_p = $user['real_p'];
    $user_con = find(mysql_query("select * from users where real_parent =$user_id"));
    foreach ($user_con as $user)
    {

        $investment_con = find(mysql_query("select * from investment_request where user_id=" . $user['id_user']));
        foreach ($investment_con as $inv)
        {
            $inv_id = $inv['id'];
            $count_con_pd = mysql_num_rows(mysql_query("select * from income_transfer where investment_id=$inv_id and mode=2"));
            if ($count_con_pd > 0)
                $count_income_con += 1;
        }
    }

    $num_user_level = mysql_num_rows(mysql_query("select * from users where real_parent = $user_id and level=$level"));
    $query_level = mysql_query("select * from tb_level_plan where level_name > $level");
    $rows_list = find($query_level);
    if (count($rows_list) > 0)
    {
        $level_name = $rows_list[0]['level_name'];
        if ($level_name > 2)
        {
            if (($num_user_level >= $rows_list[0]['level_member']))
                $user_update = mysql_query("update users set level = '$level_name' where id_user = $user_id");
        } else
        {
            if (($num_user_level >= $rows_list[0]['level_member']) and ( $count_income_cha > 0) and ( $count_income_con >= $rows_list[0]['level_pd']))
            {
                $user_update = mysql_query("update users set level = '$level_name' where id_user = $user_id");
            }
        }
    }
}

$login_username = $_SESSION['ebank_user_name'];



$referral_site = $_REQUEST['referral'];

$referral_u = $_REQUEST['tree_real_parent'];

$referral_u = $_REQUEST['tree_placement_parent'];



$reg_placement_id = $_POST['reg_placement_id'];

$tree_reg_position = $_POST['reg_position'];

$reg_realparent_id = $_POST['reg_realparent_id'];



//require_once("config.php");

include("function/setting.php");

include("function/country_list.php");

include("function/best_position.php");

include("function/functions.php");

require_once "function/formvalidator.php";

include("function/virtual_parent.php");

//include("https://vwallet.uk/function/sendmail.php");
//include('../function/sendmail.php');

include("function/e_pin.php");

include("function/insert_into_wallet.php");

require_once("validation/validation.php");


//kiểm tra user bị report
$user_rep = check_user_report($user_id);
if ($user_rep > 0)
{
    
}
else
{



    $qu = mysql_query("select * from income_process where id = 1 ");

    while ($r = mysql_fetch_array($qu))
    {

        $process_mode = $r['mode'];
    }



    if ($process_mode == 1)
    {
        ?><B style="color:#FF0000"><?= $sorry_site; ?></B><?php
    }
    else
    {

        if (isset($_REQUEST['ref']))
        {

            $ref = $_REQUEST['ref'];

            $chk_ref_user = mysql_query("select * from users where username = '$ref'");

            $ref_cnt = mysql_num_rows($chk_ref_user);

            if ($ref_cnt > 0)
            {

                $ref_user = $ref;
            }
            else
            {

                $ref_user_wrng = "<font color=\"#FF0000\" size=\"2\">$Incorrect</font>";
            }
        }



        if (isset($_REQUEST['submit']))
        {

            $real_parent = $_REQUEST['real_perent_id'];

            $username = $_POST['username'];

            $email = $_POST['email'];

            $phone = $_POST['phone'];



            $id_query = mysql_query("SELECT * FROM users WHERE username = '$real_parent' ");

            $num = mysql_num_rows($id_query);



            if ($num == 0)
            {
                $error_sponsor = "<B style=\"color:#FF0000;\">$correct_Sponsor_Id</B>";
            }
            else
            {

                while ($row = mysql_fetch_array($id_query))
                {

                    $real_p = $real_parent_id = $_SESSION['rbhgrocery_real_parent_id'] = $row['id_user'];
                }



                if (!validateName($_POST['f_name']) || !validateLname($_POST['l_name']) || !validatePhone($_POST['phone']) || !validateEmail($_POST['email']))
                {
                    ?>  

                    <div id="error">  

                        <ul>  						

                            <?php
                            if (!validatePhone($_POST['phone'])):

                                $error_phone = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Phone No:</center></font>";

                            endif
                            ?> 

                            <?php
                            if (!validateEmail($_POST['email'])):

                                $error_email = "<font color=\"#FF0000\" size=\"2\"><center>Invalid E-mail:</center></font>";

                            endif
                            ?>  

                            <?php
                            if (!validateName($_POST['f_name'])):

                                $error_f_name = "<font color=\"#FF0000\" size=\"2\"><center>Invalid First Name:</center></font>";

                            endif
                            ?> 

                            <?php
                            if (!validateLname($_POST['l_name'])):

                                $error_l_name = "<font color=\"#FF0000\" size=\"2\"><center>Invalid Last Name:</center></font>";

                            endif
                            ?> 

                        </ul>  

                    </div> <?php
                }

                else
                {

                    /* if(isset($_POST["captcha"]) && $_POST["captcha"] != "" && $_SESSION["code"] == $_POST["captcha"])

                      { */

                    if ($_POST['password'] == $_POST['re_password'])
                    {

                        if ($_POST['sec_code'] == $_POST['re_sec_code'])
                        {



                            /* $id_query = mysql_query("SELECT * FROM user_code WHERE user_id = '$real_p' and code1='".$_POST['sec_code']."' ");

                              $num = mysql_num_rows($id_query);

                              if($num == 0)

                              { $error_re_sec_code = "<B style=\"color:#FF0000;\">Enter Correct Security Code</B>"; }

                              else

                              { */

                            $chk = user_exist($username);

                            if ($chk > 0)
                            {

                                $error_username = "<font color=\"#FF0000\" size=\"2\"><center>Username Already Used</center></font>";
                            }
                            else
                            {

                                if ($_POST['username'] != $_POST['real_perent_id'])
                                {

                                    $chk_ac_no = bank_ac_exist($_REQUEST['ac_no']);

                                    if ($chk_ac_no > 0)
                                    {

                                        $error_ac_no = "<B style=\"color:#FF0000;\">Account Number Already Used</B>";
                                    }
									
									$chk_ac_no1 = strpos($ac_no, ' ');

                                            if ($chk_ac_no1 > 0)
                                            {

                                                $error_ac_no = "<p><B style=\"color:#FF0000;\">No white space allowed</B></p>";
                                            }
									else							
                                    {

                                        $chk_email = email_exist($email);

                                        if ($chk_email > 0)
                                        {

                                            $error_email = "<B style=\"color:#FF0000;\">E-mail Already Used!</B>";
                                        }
                                        else
                                        {

                                            $chk_phone = phone_exist($phone);

                                            if ($chk_phone > 0)
                                            {

                                                $error_phone = "<B style=\"color:#FF0000;\">Phone Already Used</B>";
                                            }
											$chk_phone1 = strpos($phone, ' ');

                                            if ($chk_phone1 > 0)
                                            {

                                                $error_phone = "<p><B style=\"color:#FF0000;\">No white space allowed</B></p>";
                                            }
											if (strlen($phone) < 10)
											{
												$error_phone = "<p><B style=\"color:#FF0000;\">Phone number must be 10-11 characters</B></p>";
											}
											else if(strlen($phone) > 11)
											{
											   $error_phone = "<p><B style=\"color:#FF0000;\">Phone number must be 10-11 characters</B></p>";
											}										
                                            else
                                            {

                                                $_SESSION['position'] = $_POST['position'];

                                                $_SESSION['real_perent_id'] = get_new_user_id($_POST['real_perent_id']);

                                                $_SESSION['cdbv_verify_user'] = 1;

                                                $_SESSION['username'] = $_POST['username'];

                                                $_SESSION['password'] = $_POST['password'];

                                                $_SESSION['re_password'] = $_POST['re_password'];

                                                $_SESSION['sec_code'] = $_POST['sec_code'];

                                                $_SESSION['re_sec_code'] = $_POST['re_sec_code'];



                                                $_SESSION['f_name'] = $_POST['f_name'];

                                                $_SESSION['l_name'] = $_POST['l_name'];

                                                $_SESSION['gender'] = $_POST['gender'];

                                                $_SESSION['country'] = $_POST['country'];

                                                $_SESSION['email'] = $_POST['email'];

                                                $_SESSION['phone'] = $_POST['phone'];

                                                $_SESSION['address'] = $_POST['address'];

                                                $_SESSION['dob'] = $_POST['dob'];



                                                $_SESSION['bank'] = $_POST['bank'];

                                                $_SESSION['branch'] = $_POST['branch'];

                                                $_SESSION['benf_name'] = $_POST['beneficiery_name'];

                                                $_SESSION['ac_no'] = $_POST['ac_no'];

                                                $_SESSION['bank_phone'] = $_POST['bank_phone'];

                                                $_SESSION['placement_username'] = $_POST['placement_username'];





                                                /* if($_POST['phone'] != '')

                                                  {

                                                  $_SESSION['mobile_code'] = $rand_no = rand(100000 , 999999);

                                                  $full_message = $Your_verification_code_is." ".$rand_no." ". $website ;

                                                  send_sms($phone,$full_message);

                                                  }



                                                  echo "<script type=\"text/javascript\">";

                                                  echo "window.location = \"index.php?page=registration1\"";

                                                  echo "</script>"; */
                                            }
                                        }
                                    }
                                }
                                else
                                {

                                    echo "<B style=\"color:#FF0000;\">Please Enter Diffrent Username and Sponsor Name !!</B>";
                                }
                            }

                            //}
                        }
                        else
                        {

                            $error_re_sec_code = "<font style=\"color:#FF0000;\">Please Enter Same Security Code !!</font>";
                        }
                    }
                    else
                    {
                        $error_re_password = "<font style=\"color:#FF0000;\">Please Enter Same Password !!</font>";
                    }

                    /* }

                      else

                      { echo "<B style=\"color:#FF0000;\">Enter correct Code !!</B>"; } */
                }
            }
        }

//isset($_REQUEST['verify']) and $_REQUEST['verify'] == 'success' and

        if ($_SESSION['cdbv_verify_user'] == 1)
        {

            $_SESSION['cdbv_verify_user'] = 2;

            $position = $_SESSION['position'] = 0;

            $real_p = $real_parent = $request_name = $_SESSION['real_perent_id'];

            $username = $_SESSION['username'];

            $password = $_SESSION['password'];

            $re_password = $_SESSION['re_password'];

            $user_pin = $_SESSION['sec_code'];

            $re_sec_code = $_SESSION['re_sec_code'];

            $f_name = $_SESSION['f_name'];

            $l_name = $_SESSION['l_name'];

            $gender = $_SESSION['gender'];

            $country = $_SESSION['country'];

            $email = $_SESSION['email'];

            $phone = $_SESSION['phone'];

            $address = $_SESSION['address'];

            $dob = $_SESSION['dob'];

            $bank = $_SESSION['bank'];

            $branch = $_SESSION['branch'];

            $benf_name = $_SESSION['benf_name'];

            $ac_no = $_SESSION['ac_no'];

            $bank_phone = $_SESSION['bank_phone'];



            $date = $systems_date;



            //$user_pin = mt_rand(100000, 999999);
            //$password = substr(md5(rand(0, 1000000)), 0, 7);
            //$username = "Ebank.Tv".substr(md5(rand(0, 1000000)), 0, 7);
            //$unique_time = date("Y-m-d H:i:s",strtotime($date));



            $type = "B";

            $virtual_par = get_virtual_parent_position($real_p, $position);



            mysql_query("INSERT INTO users (username,real_parent,level, max_send_value) VALUES ('$username' , '$real_p' , '1', '4') ");

            $real_parent_username_log = get_user_name($real_p);

            // update max_send_value
            // $ebank_user_id_query = mysql_query("SELECT id_user FROM users WHERE username = '$username' ");
            // while ($row = mysql_fetch_array($ebank_user_id_query))
            // {

            //     $ebank_user_id = $row[0];
            // }

            // $q_tree = mysql_query("SELECT * FROM users WHERE real_parent = $ebank_user_id");
            // $count = mysql_num_rows($q_tree);
            // $max_send = -1;
            // if ($count == 0) {
            //     $max_send = 4;
            // }

            // if ($count == 1) {
            //     $max_send = 6;
            // }

            // if ($count == 2) {
            //     $max_send = 8;
            // }

            // if ($count == 3) {
            //     $max_send = 10;
            // }
            // mysql_query("UPDATE users SET max_send_value = $max_send WHERE id_user = $ebank_user_id");
            // end

            $query = mysql_query("SELECT id_user FROM users WHERE username = '$username' ");

            while ($row = mysql_fetch_array($query))
            {

                $user_id = $row[0];
            }

            insert_wallet();  // inserting in wallet

            $activate_date = date("Y-m-d H:i:s", strtotime($systems_date . date("H:i:s")));


            $sql = "UPDATE users SET parent_id = '$virtual_par' , real_parent = '$real_p' , 

	position =  '$position' , f_name = '$f_name' , l_name = '$l_name' , activate_date = 

	'$activate_date' , email = '$email' , phone_no = '$phone' , password = '$password' , 

	user_pin = '$user_pin' , date = '$date' , type = '$type' , beneficiery_name = '$benf_name' , 

	ac_no = '$ac_no' , bank = '$bank' , branch = '$branch' , bank_code = '$bank_code' ,gender = '$gender' , country = '$country'

	WHERE id_user = '$user_id' ";

            mysql_query($sql);



            mysql_query("INSERT INTO user_manager (manager_id , real_parent,parent_id,position,type) VALUES ('$user_id' , '$real_p' ,'$users_parent_id' , '$user_pos', '$type') ");



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



            mysql_query("INSERT INTO user_code (user_id , code1 , code2 , code3 , code4 , code5 , code6 ,

	 code7 , code8 , code9 , code10 , date) 

	VALUES ('$user_id' , '$code1' , '$code2' , '$code3' , '$code4' , '$code5' , '$code6' , '$code7' , 

	'$code8' , '$code9' , '$code10' , '$date') ");

            $user_level = mysql_query("select * from users where real_parent = '$real_p'");
            $user_num = mysql_num_rows($user_level);
            resultlevel($real_p);
            $code_message = "Your verification code is " . $code1 . " - " . $code2 . " - " . $code3 . " - " . $code4 . " - " . $code5 . " - " . $code6 . " - " . $code7 . " - " . $code8 . " - " . $code9 . " - " . $code10 . " www.ebank.tv";

            //send_sms($phone, $code_message);



            //mysql_query("update wallet set roi = '$rech_amount' where id = '$user_id' ");
            //mysql_query("insert into reg_fees_structure (user_id , update_fees , bv, date  )values ('$user_id' , '$pin_amount' , '$bus_vol' , '$date') ");
            //pair_point_calculation($user_id , $date);
            //reward_pair_point_calculation($user_id,$date);



            $wal_bal = get_wallet_amount($user_id);

            //insert_wallet_account($user_id, $user_id, $rech_amount, $date, $ac_type[4],$ac_type_desc[4], 1, $wal_bal);



            $time = date('h:i:s');

            //$epin ="update e_pin set mode = 0 ,used_id = '$user_id', used_time = '$time', used_date = '$date' where epin = '$epin' and mode = 1 ";
            //mysql_query($epin);



            $virtual_parent_username = get_user_name($virtual_par);

            $real_parent_username = get_user_name($real_parent_id);

            if ($position == 0)
                $user_position = "Left Leg";
            else
                $user_position = "Right Leg";

            //new registration message



            //sendmail($to, $title, $full_message);
            //$user_id = get_new_user_id($username); //newlly entered user id
			
            $email = $email;
            $name  = $username;
            $title = "You have just been added to vWallet";
            $content = 'A member has just added you to the system. Please log in now, buy Ticket and make a Sending to help the community.';
            sendMail($email,$name,$title,$content);
			
            //insert_child_in_left_right($user_id);

            $par_id = real_par($user_id);



            $user_id = get_new_user_id($username); //newlly entered user id

            $real_parent_username_log = $real_parent_username;

            include("function/logs_messages.php");

            data_logs($real_parent_id, $data_log[3][0], $data_log[3][1], $log_type[2]);



            $log_msg = "Successfully Registration Of " . $username . " on " . $date;

            include("function/logs_messages.php");

            data_logs($real_parent_id, $data_log[8][0], $log_msg, $log_type[4]);



            $postvars = array(
                "user" => $auto_post_user,
                "password" => $auto_post_password,
                "sender" => $auto_post_sender,
                "mobiles" => $phone,
                "duration" => $auto_post_duration,
                "draft_file_name" => $auto_post_draft_file_name,
                "droute" => $auto_post_droute
            );



            $message = "HELLO $f_name. Username : $username , Password : $password , Keep information 

	secured. www.ebank.tv";

            //send_sms($phone, $message);



            //post_to_url($auto_post_your_post_url, $postvars);

            $_SESSION['register_success'] = "<B style=\"color:#008000;\">User Registration Successfully Completed  !!</B>";



            //$_SESSION['register_success']="<B style=color:#008000;><center>$register_successfully</center></B>";

            echo "<script type=\"text/javascript\">";

            echo "window.location = \"index.php?page=maxsend\"";

            echo "</script>";
        }

        elseif (isset($_SESSION['register_success']))//($_SESSION['mmm_verify_user'] == 2)
        {

            print $_SESSION['register_success'];

            unset($_SESSION['register_success']);

            //session_destroy();
        }
        ?>
        <div class="box box-primary" style="padding: 20px"> 
            <div class="row">
                <form name="form" class="form-horizontal" action="index.php?page=registration" method="post"  >

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-md-8 col-sm-12 col-md-offset-2 col-sm-offset-0 col-xs-offset-0 text-left" style="font-size: 18px">ACCOUNT INFORMATION</label>
                        </DIV>
                        <?php
                        if (isset($_REQUEST['referral']))
                        {

                            if ($referral_username == '0')
                            {
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Sponsor ID</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control col-lg-11" name="real_perent_id" value="<?php
                                        if ($real_parent != "")
                                        {
                                            print $real_parent;
                                        }
                                        else
                                        {
                                            print get_user_name(1);
                                        }
                                        ?>" >
                                        <p><?= $error_sponsor; ?></p>
                                    </div>
                                </div>


                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Sponsor ID</label>
                                    <div class="col-sm-8">
                                        <input type="hidden" class="form-control col-lg-11" name="real_perent_id" value="<?= $request_name ?>" >
                                        <span><strong><?= get_full_name_by_username($referral_site); ?></strong></span>
                                    </div>
                                </div>


                                <?php
                            }
                        }
                        else
                        {
                            ?>
                            <div class="form-group">
                                <label class="col-sm-4 control-label"><?= $Sponsor_ID; ?></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control col-lg-11" name="real_perent_id" value="<?= $login_username ?>" readonly>
                                    <p><?= $ref_user_wrng . " " . $error_sponsor; ?></P>
                                </div>
                            </div>
                        <?php }
                        ?>
						<div class="form-group">
                            <label class="col-sm-4 control-label">Username</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="username" value="<?= $_POST['username'] ?>" required>
                                <p></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control col-lg-11" name="password" value="<?= $_POST['password'] ?>" required>
                                <p><?= $error_password ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Confirm Password</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control col-lg-11" name="re_password" value="<?= $_POST['re_password'] ?>" required>
                                <p><?= $error_username; ?></p>
                            </div>
                        </div><div class="form-group">
                            <label class="col-sm-4 control-label">Security Code</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control col-lg-11" name="sec_code" value="<?= $_POST['sec_code'] ?>" required>
								<!--<input type="text" class="form-control col-lg-11" name="sec_code" value="<?= $_POST['sec_code'] ?>" required onKeyUp="if (/[^\.\_\-\'0-9]/g.test(this.value))
                                            this.value = this.value.replace(/[^\.\_\-\'0-9]/g, '')">-->
                                <p><?= $error_sec_code; ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Confirm Security Code</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control col-lg-11" name="re_sec_code" value="<?= $re_sec_code ?>" required >
								<!--<input type="text" class="form-control col-lg-11" name="re_sec_code" value="<?= $re_sec_code ?>" required onKeyUp="if (/[^\.\_\-\'0-9]/g.test(this.value))
                                            this.value = this.value.replace(/[^\.\_\-\'0-9]/g, '')" >-->
                                <p><?= $error_re_sec_code; ?></p>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-8 col-sm-12 col-md-offset-2 col-sm-offset-0 col-xs-offset-0 text-left" style="font-size: 18px">PAYMENT INFORMATION</label>
                        </DIV>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Bank Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="bank" value="<?= $_POST['bank'] ?>" required>
                                <p><?= $error_bank; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Bank Account</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="ac_no" value="<?= $_POST['ac_no'] ?>" required>
                                <p><?= $error_ac_no; ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Bank Branch</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="branch" value="<?= $_POST['branch'] ?>" required>
                                <p><?= $error_bank; ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Bank Account Holder Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="beneficiery_name" value="<?= $_POST['beneficiery_name'] ?>" required>
                                <p><?= $error_beneficiery_name; ?></p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-md-8 col-sm-12 col-md-offset-2 col-sm-offset-0 col-xs-offset-0 text-left" style="font-size: 18px">PERSONAL INFORMATION</label>
                        </DIV>
						<div class="form-group">
                            <label class="col-sm-4 control-label"><?= $first_name ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="f_name" value="<?= $_POST['f_name'] ?>" >
                                <p><?= $error_f_name ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?= $last_name ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="l_name" value="<?= $_POST['l_name'] ?>" >
                                <p><?= $error_l_name ?></p>
                            </div>
                        </div>
                        
						<div class="form-group">
                            <label class="col-sm-4 control-label"><?= $mob_no ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="phone" value="<?= $_POST['phone'] ?>" >
                                <p><?= $error_phone ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?= $E_mail_ID ?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control col-lg-11" name="email" value="<?= $_POST['email'] ?>" >
                                <p><?= $error_email ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Country</label>
                            <div class="col-sm-8">
                                <select class="form-control col-lg-11" name="country">
                                <?php
                                $q_country = mysql_query("SELECT * FROM location ORDER BY location_id ASC");
                                while($r_country = mysql_fetch_array($q_country)){
                                    echo "<option value='".$r_country['location_id']."'>".$r_country['name']."</option>";
                                } 
                                ?>                                    
                                </select>
                            </div>
                        </div>
						<div class="form-group">
                            <label class="col-sm-4 control-label">Gender</label>
                            <div class="col-sm-8">
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="gender" value="male" checked>
                                        Male
                                    </label>
                                </div>
                                <div class="radio-inline">
                                    <label>
                                        <input type="radio" name="gender" value="famale">
                                        Famale
                                    </label>
                                </div>
                                <p><?= $error_gender ?></p>
                            </div>
                        </div>
                        
                        <!--<div class="form-group">
                            <label class="col-sm-4 control-label" style="font-size: 18px">Security</label>
                        </DIV>-->

                        

                    <?php } ?>              


                </DIV>
	<div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-xs-12 col-xs-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-primary">Update</button>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>
        </DIV>
    </DIV>

    <?php
}
?>