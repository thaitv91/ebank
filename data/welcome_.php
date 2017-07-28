<?php
ini_set("display_erros","off");
session_start();
include('condition.php');
include('function/setting.php');
include("function/functions.php");
//include("function/pair_point_calculation.php");
include("function/pair_point_income.php");
include("function/send_mail.php");
include("function/income.php");
$user_id = $_SESSION['ebank_user_id'];
$invest_cnt = get_max_investment($user_id);
$wall_bal = get_wallet_amount($user_id);
$roi_bal = get_wallet_roi_amt($user_id);
$com_wal = get_wallet_com_amt($user_id);
$epin_wal = get_wallet_epin_amt($user_id);

$bank_you = get_user_bank_name($user_id);
$min_wid = $minimum_withdrawal;
$max_wid = $maximum_withdrawal;

$qwww = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
while($rowss = mysql_fetch_array($qwww))
{
    $bank = $rowss['bank'];
    $branch = $rowss['branch'];
    $level_vtype = $rowss['level'];
    $ac_no = $rowss['ac_no'];
    $phone_no = $rowss['phone_no'];
    $name = ucfirst($rowss['f_name'])." ".ucfirst($rowss['l_name']);
}
$qwww = mysql_query("SELECT * FROM ac_activation WHERE user_id = '$user_id' ");
while($rowss = mysql_fetch_array($qwww))
{
    $photo_id = $rowss['photo_id'];
    $selfie_id = $rowss['selfie_id'];
    $photo_mode = $rowss['photo_mode'];
    $selfie_mode = $rowss['selfie_mode'];
    $act_mode = $rowss['mode'];
    $btn_1 = "<button class=\"btn btn-block btn-success\">Checking</button>";
    $btn_2 = "<button class=\"btn btn-block btn-success\">Complete</button>";
}
?>
<script type="text/javascript" src="js/future.js"></script>
<!--<div class="row">-->
<div class="row" style="z-index:-1;">
    <div class="col-lg-4 col-xs-12">
        <div class="small-box bg-aqua">
            <div class="inner"><h3><?=number_format($wall_bal);?></h3><p>Main Wallet</p></div>
            <div class="icon"><i class="fa fa-money-icon"><img src="/images/newlayout/icons/main_wallet.png"></i></div>
            <a href="index.php?page=main_wallet" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-xs-12">
        <div class="small-box bg-yellow">
            <div class="inner"><h3><?=number_format($com_wal);?></h3><p>Commission Wallet</p></div>
            <div class="icon"><i class="fa fa-trophy-icon"><img src="/images/newlayout/icons/com_wallet.png"></i></div>
            <a href="index.php?page=comm_wallet" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!--<div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?=number_format($roi_bal);?><sup style="font-size: 20px"></sup></h3>
                <p>Refferal Wallet</p>
            </div>
            <div class="icon"><i class="ion ion-person-add"></i></div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>-->
    <div class="col-lg-4 col-xs-12">
        <div class="small-box bg-red">
            <div class="inner"><h3><?=$epin_wal;?></h3><p>e-PIN Wallet</p></div>
            <div class="icon"><i class="fa fa-key-icon"><img src="/images/newlayout/icons/epin.png"></i></div>
            <a href="index.php?page=epin_request" class="small-box-footer">
                More info <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
<?php
$allowedfiletypes = array("jpg","png");
$uploadfolder = $payment_receipt_img_full_path;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;


if(isset($_SESSION['wid_sucs']))
{
    print $_SESSION['wid_sucs'];
    unset($_SESSION['wid_sucs']);
}

/*if($_REQUEST['activate'] == 'Activate'){
    $epin = $_REQUEST['epin'];
    $sql = "select * from e_pin where epin='$epin' and mode=1";
    $query = mysql_query($sql);
    $num = mysql_num_rows($query);
    if($num > 0){
        $sql = "update users set type='B' where id_user ='$user_id'";
        $query = mysql_query($sql);
        $time = date("H:i:s");
        $sql = "update e_pin set mode='0',used_id='$user_id',used_date='$systems_date',used_time='$time' where epin ='$epin' and mode=1";
        $query = mysql_query($sql);
        $_SESSION['ebank_user_type'] = 'B';
        echo "<script type=\"text/javascript\">";
        echo "window.location = \"index.php?page=welcome\"";
        echo "</script>";
    }
    else{
        $error_epin = "<font color='red'>Enter Correct E-pin !!</font>";
    }
}*/
$_SESSION['show_message'];
$_SESSION['show_message'] = "";
$sql = "select * from income_transfer where paying_id = '$user_id' and type='1'";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
$ebank_user_type = $_SESSION['ebank_user_type'];
if($photo_id == NULL or $act_mode == 0)
{
    //include "account_activation.php";
}


$query = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
while($row = mysql_fetch_array($query))
{
    $f_name = $row['f_name'];
    $l_name = $row['l_name'];
    $user_name = $row['username'];
    $name = $f_name." ".$l_name;
    $phone_no = $row['phone_no'];
    $date = $row['date'];
    $real_parent = get_user_name($row['real_parent']);
    $email = $row['email'];
    $phone_no = $row['phone_no'];
    $city = $row['city'];
    $country = $row['country'];
    $address = $row['address'];
}

$sqlw = "SELECT * FROM daily_interest WHERE member_id=$user_id order by id DESC limit 1";
$queeww = mysql_query($sqlw);
$num_tot = mysql_num_rows($queeww);
if($num_tot > 0)
{
    while($ree = mysql_fetch_array($queeww))
    {
        $id = $ree['id'];
        $str_date = $ree['start_date'];
        $end_date = $ree['end_date'];
        $re_pd_time = $re_pd_time[$level_vtype];
        $end_date = date('Y-m-d',strtotime($end_date."+ $re_pd_time hours"));
        $curr_time = date("Y-m-d H:i:s");

        $start_date = new DateTime($curr_time);
        $since_start = $start_date->diff(new DateTime($end_date));
        $day = $since_start->d;
        $hour = $since_start->h;
        $minute = $since_start->i;
        $second = $since_start->s;
    } ?>
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
                <p style="font-size:16px; font-weight:bold;">
                    Please re-PH for GD within : <?=$day;?> Day, <?=$hour;?> Hours, <?=$minute;?> Minutes, <?=$second;?>
                    Seconds. <br />Otherwise, your account will be frozen.
                </p>
            </div>
        </div>
    <?php
}

/*$sql = "SELECT *,count(investment_id) c FROM `daily_interest`
WHERE `member_id`='$user_id' and count = max_count
group by investment_id
having c < 6
order by id desc
limit 1";    re pd sql change*/
$link_time_limit = $min_pd_settings[$level_vtype];
$sql = "SELECT count(*) c FROM `investment_request` WHERE user_id = '$user_id' order by id desc having c < '$link_time_limit'";

$quer = mysql_query($sql);
$num = mysql_num_rows($quer);
$sql = "SELECT * FROM `income_transfer` WHERE mode = 2 and user_id = '$user_id' order by id desc";
$quer = mysql_query($sql);
$num1 = mysql_num_rows($quer);
if($num > 0 and $num1 > 0)
{ ?>
    <table id="example2" class="table table-bordered table-hover">
    <tr>
    <td style="text-align: center; font-size:20px; font-weight:bold; padding:20px 0 20px 0;color:#000;">
       Your Re-PD is necessary in 48 Hours, other than Your Account will be Automatically Freezed !!
    </td>
    </tr>
    </table>
<?php
}
?>
<div style="color:#990000; padding:10px 0px 10px 50px;text-decoration: blink">
    <?php
        $inv_count = first_invest_count($user_id);
        if($inv_count == 0)
        {
            //print "<blink>Note : Your Cmmitment is Not Yet Confirmed.</blink>";
            // Accept Button will be appeared once your commitment confirmed.
        }
        else{}
    ?>
</div>
<!--<table id="example2" class="table table-bordered table-hover">
    <tr>
        <td style="text-align: center; font-size: 20px; font-weight: bold; padding:20px 0 20px 0; color:#000;">
           Your Reffral Link is: <a href="<?=$refferal_link."/index.php?ref=".$email; ?>" class="cssLabel" target="_blank" style="color:#011153;"><?=$refferal_link."/index.php?ref=".$email; ?></a>
        </td>
    </tr>
</table>-->
<div style="margin-bottom:20px;">
<div id="donationWrap">
    <div class="row">
        <?php
            //check acount reported
            $user_rep = check_user_report($user_id);
            if($user_rep > 0){
        ?>
            <div class="col-lg-6 col-xs-12">
                <a class="btn btn-block btn-default" style="padding:20px;font-size:20px;background-color:#ACABAB;">
                    <i class="fa fa-fw icon-pd"></i>
                    <span>PROVIDE HELP</span>
                </a>
            </div>
            <div class="col-lg-6 col-xs-12">
                <a class="btn btn-block btn-default" style="padding:20px;font-size:20px;background-color:#ACABAB;">
                    <i class="fa fa-fw icon-gd"></i>
                    <span>GET HELP</span>
                </a>
            </div>
        <?php
            }else{
        ?>
            <div class="col-lg-6 col-xs-12">
                <a class="btn btn-block" id="pdBtn">
                    <i class="fa fa-fw icon-pd"></i>
                    <span>PROVIDE HELP</span>
                </a>
            </div>
            <div class="col-lg-6 col-xs-12">
                <a class="btn btn-block" id="gdBtn">
                    <i class="fa fa-fw icon-gd"></i>
                    <span>GET HELP</span>
                </a>
            </div>
        <?php
            }
        ?>

    </div>
    </div>
    <!--<div class="row">-->
<?php
if($invest_cnt >= 5){ $max_invest = $max_inv_amount[$tot_inv_plan-1]; }
else{ $max_invest = $max_inv_amount[1];}

if(isset($_REQUEST['buy_unit']))
{
    if($max_pd_amt_settings[$level_vtype] >= $_POST['request_amount'])
    {
        $request_amount = $_POST['request_amount'];
        $epin_cnt = $request_amount / $epin_value;
        $sec_code = $_POST['sec_code'];
        $plans_id = $_POST['plan'];
        $date_inv = $_POST['date_inv'];
        $protected = $_POST['protected'];
        $request_amount = $request_amount*$plan_diff;
        if($date_inv == ''){ $date_inv = $systems_date;}
        $pin_cnt = $epin_cnt;


        $epin_sql = "select *  from e_pin where mode=1 and user_id='$user_id' LIMIT $pin_cnt";
        $epin_ques = mysql_query($epin_sql);
        $num = mysql_num_rows($epin_ques);
        if($num < $pin_cnt)
        {
            print "<B style=\"color:#FF0000; padding-left:20px;\">Please enter correct PH amount. Type 600 for a PH amount of 6,000,000.</B>";
        }
        else
        {
            while($ro = mysql_fetch_array($epin_ques)){
            $epin_tot_amt = $epin_tot_amt + $ro['amount'];
            $epin_id[] =  $ro['id'];
        }
        $epin_tot_chk = $pin_cnt * $epin_value*$plan_diff;
        $sqlt = "select * from plan_setting where id = '$plans_id' order by id desc limit 1";
        $ques = mysql_query($sqlt);
        $num = mysql_num_rows($ques);
        if(1)//$epin_tot_chk == $epin_tot_amt
        {
            if(1)
            {
                while($ros = mysql_fetch_array($ques))
                {
                    $plan_id = $ros['id'];
                    $plan_profit  = $ros['profit'];
                    $inv_days = $ros['days'];
                }
                $sdl = "SELECT * FROM users WHERE user_pin = '$sec_code' and id_user = '$user_id' ";
                $query = mysql_query($sdl);
                $num = mysql_num_rows($query);
                if($num > 0)
                {
                    /*$sqls = "SELECT t1.mode as ir_mode , t2.mode as it_mode FROM investment_request t1
                    left join income_transfer t2 on t1.id = t2.investment_id and t1.user_id = t2.paying_id
                    WHERE t1.user_id = '$user_id'";
                    $query = mysql_query($sqls);
                    while($row = mysql_fetch_array($query))
                    {
                        $ir_mode = $row['ir_mode'];
                        $it_mode = $row['it_mode'];
                    }*/
                    $sqls = "SELECT t1.* FROM investment_request t1
                             WHERE t1.user_id = '$user_id' and t1.date='$date_inv'";
                    $query = mysql_query($sqls);
                    $num_i = mysql_num_rows($query);
                    if($epin_tot_chk >= $max_pd_amt_settings[$level_vtype])
                    {
                        $max_pd_complete_m = max_pd_complete($user_id,$level_vtype,$systems_date,'month');
                        $max_pd_complete_w = max_pd_complete($user_id,$level_vtype,$systems_date,'week');
                        $max_pd_complete_d = max_pd_complete($user_id,$level_vtype,$systems_date,'day');
                        if($max_pd_complete_m and $max_pd_complete_w and $max_pd_complete_d)
                        //$ir_mode != '1' or $ir_mode == NULL) and ($it_mode == '2' or $it_mode == NULL)
                        {
                            $income_time = date('H:i:s');
                            $sql = "insert into investment_request (user_id , amount , plan_setting_id ,
                            inv_profit , date , time , mode , inc_days , rec_mode , priority)
                            values ('$user_id' , '$request_amount', '$plan_id' , '$plan_profit' ,
                            '$date_inv' , '$income_time' , 1 ,'$inv_days' , 1 , 1)";
                            $epin = implode(",",$epin_id);
                            mysql_query("update e_pin set mode='0' where user_id='$user_id' and id in($epin) and mode=1");

                            foreach ($epin_id as $key => $value) {
                                $date = date('Y-m-d');
                                $insert_sql = mysql_query("insert into epin_history (epin_id , user_id , mode , date) values ('$value' , '$user_id' ,'2', '$date')");
                            }


                            //remove re-PD
                            $time_now = date('Y-m-d H:i:s', time());
                            $q_repd = mysql_query("SELECT * FROM tb_repd WHERE user_id = $user_id AND pd_id = 0 ORDER BY gd_time ASC LIMIT 1");
                            $r_repd = mysql_fetch_array($q_repd);
                            $id_repd = $r_repd['id'];
                            mysql_query("UPDATE tb_repd SET pd_id = $id_repd , pd_time = '$time_now' WHERE id = $id_repd");

                            mysql_query($sql);
                            if($protected == 'on'){
                                mysql_query("update users set protected='1' where id_user='$user_id'");
                            }
                            echo "<B style=\"color:#008000;\">Your PH request has been received. You will receive an email when it is processed. </B>";
                        }
                        else
                        { echo "<B style=\"color:#FF0000;\">You have reached your maximum PH amount allowed for today. Please wait until tomorrow.</B>"; }
                    }
                    else
                    { echo "<B style=\"color:#FF0000;\">Please Enter Valid Amount !!</B>"; }
                }
                else
                { echo "<B style=\"color:#FF0000;\">Please enter correct security password</B>"; }
            }
            else
            { echo "<B style=\"color:#FF0000;\">Please Enter Correct Amount According to Plan !!</B>";  }
        }
        else{echo "<B style=\"color:#FF0000;\">Please Enter Correct Epin According to Amount !!</B>";}
    }
    }
    else
    { echo "<B style=\"color:#FF0000;\">You have exceeded your allowed PH amount.</B>"; }
}

if(isset($_REQUEST['withdraw']))
{
    $curr_amnt = get_wallet_amount($user_id);
    $request_amount = $_POST['request']*$plan_diff;//$epin_value
    $sec_code = $_POST['sec_code'];
    $wallet_from = $_POST['wallet_type'];

    if($request_amount % 100000  == 0){

    $sdl = "SELECT * FROM users WHERE user_pin = '$sec_code' and id_user = '$user_id' ";
    $query = mysql_query($sdl);
    $num = mysql_num_rows($query);
    if($num > 0)
    {
        switch($wallet_from)
        {
            case 'cwallet' :	$min_gd_amt_settings = $min_mw_gd_amt_settings[$level_vtype];
                                $max_gd_amt_settings = $max_mw_gd_amt_settings[$level_vtype];
                                break;
            case 'rwallet' :	$min_gd_amt_settings = $min_cw_gd_amt_settings[$level_vtype];
                                $max_gd_amt_settings = $max_cw_gd_amt_settings[$level_vtype];
                                break;
        }
        if($request_amount <= $curr_amnt or $request_amount <= $roi_bal)
        {
            $request_amount." ".$min_gd_amt_settings*$plan_diff." ".$max_gd_amt_settings*$plan_diff;
            if($request_amount <= $max_gd_amt_settings*$plan_diff)
            {
                //$sql = "select count(user_id) c from income where user_id='$user_id' group by user_id having c <= '".$max_gd_settings[$level_vtype]."'";
                //$quess = mysql_query($sql);
                //if(mysql_num_rows($quess) > 0)
                //{
                    $max_gd_complete_m = max_gd_complete($user_id,$request_amount,$level_vtype,$systems_date,'month');
                    $max_gd_complete_w = max_gd_complete($user_id,$request_amount,$level_vtype,$systems_date,'week');
                    $max_gd_complete_d = max_gd_complete($user_id,$request_amount,$level_vtype,$systems_date,'day');
                    if($request_amount % $amt_multiple == 0)
                    {
                        if($max_gd_complete_m && $max_gd_complete_w && $max_gd_complete_d){
                            $time = date('Y-m-d H:i:s');
                            $sql = "insert into income (user_id , total_amount , paid_limit , date , mode ,
                            priority ,  rec_mode , time) values ('$user_id' , '$request_amount' , '$request_amount' ,
                             '$systems_date' , 1 , 1 , 1 , '$time')";
                            mysql_query($sql);

                            //get wallet_balance from user_id
                            $tb_wallet = mysql_query("SELECT * FROM  wallet WHERE id = $user_id");
                            $row_wallet = mysql_fetch_array($tb_wallet);

                            if($wallet_from == 'cwallet')
                            {
                                $sfl = "update wallet set amount = amount-'$request_amount' where id = '$user_id' ";
                                mysql_query($sfl);
                                $wallet = get_wallet_amount($user_id);
                                $wall_type = $wallet_type[1];

                                // update into account when user GD of Commission Wallet
                                //$account = mysql_query("INSERT INTO account (user_id, dr, type, date, account, wallet_balance, wall_type)  VALUES ($user_id, $request_amount, '".$acount_type[24]."', '".$date."', 'Made a GD of ".$request_amount." from Commission-Wallet', ".$row_wallet['amount'].", '".$wallet_type[1]."')");
                            }
                            else
                            {
                                $sfl = "update wallet set roi = roi-'$request_amount' where id = '$user_id' ";
                                mysql_query($sfl);
                                $wallet = get_wallet_roi_amt($user_id);
                                $wall_type = $wallet_type[2];

                                // update into account when user GD of Commission Wallet
                                //$account = mysql_query("INSERT INTO account (user_id, dr, type, date, account, wallet_balance, wall_type)  VALUES ($user_id, $request_amount, '".$acount_type[24]."', '".$date."', 'Made a GD of ".$request_amount." from Commission-Wallet', ".$row_wallet['amount'].", '".$wallet_type[3]."')");
                            }

                            insert_wallet_account($user_id, $user_id, $request_amount, $time, $acount_type[6],$acount_type_desc[6], 2, $wallet , $wall_type);


                            $acc_username_log = get_user_name($id);
                            $income_log = $request_amount;
                            $date = $systems_date;
                            $wallet_amount_log = $curr_amnt;
                            $total_wallet_amount = $left_wallet_amount;
                            include("function/logs_messages.php");
                            data_logs($id,$data_log[16][0],$data_log[16][1],$log_type[4]);

                            $phone = get_user_phone($id);
                            $db_msg = $setting_sms_user_investment_request;
                            include("function/full_message.php");
                            send_sms($phone,$full_message);

                            $_SESSION['wid_sucs'] = "<B style=\"color:#008000;\">You GH request for an amount of ".$request_amount." has been received. You will receive an email when it is processed.</B>";

                            echo "<script type=\"text/javascript\">";
                            echo "window.location = \"index.php?page=welcome\"";
                            echo "</script>";
                        }
                        else{
                            echo "<B style=\"color:#FF0000;\">Your Have Exceeded Your GH Amount Limit According Level !!</B>";
                        }
                    }
                    else
                    {
                    echo "<B style=\"color:#FF0000;\">Please Enter Amount Multiple of $amt_multiple</B>";
                    }
                //}
                //else
                //{ echo "<B style=\"color:#FF0000;\">Your Wallet Withdrawal Limit Over According To Level !!</B>"; }
            }
            else{ echo "<B style=\"color:#FF0000;\">Please Enter Correct Amount!!</B>"; }

        }
        else{ echo "<B style=\"color:#FF0000;\">Error : insufficient balance !!</B>"; }
    }
    else
    { echo "<B style=\"color:#FF0000;\">Please enter correct code !!</B>"; }
    }else{
        echo "<B style=\"color:#FF0000;\">Your GH amount must be a multiple of 100,000!</B>";
    }
}
?>
    <div>
        <div id="pdWrap" style="display: none;">
            <div class="widget widget-body-white">
                <div class="widget-head widget-head-blue">
                    <h4 class="heading">PROVIDE HELP</h4>
                </div>
                <?php

                $pd_complete_m = max_pd_complete($user_id,$level_vtype,$systems_date,'month');
                $pd_complete_w = max_pd_complete($user_id,$level_vtype,$systems_date,'week');
                $pd_complete_d = max_pd_complete($user_id,$level_vtype,$systems_date,'day');
                if($pd_complete_m and $pd_complete_w and $pd_complete_d){
                ?>
                <form class="form-horizontal margin-none" name="buy_share_form" action="" method="post">
                <div class="widget-body" style="padding-top:15px;">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label class="col-md-8 col-xs-12 control-label">Amount</label>
                            <div class="col-md-4 col-xs-12 div-select">
                                <?php  
                                    $level_user = get_user_level($user_id);
                                    $quotient = (int)($max_pd_amt_settings[$level_user]/600);
                                ?>
                                <select class="form-control" id="pd_amount" name="request_amount">
                                    <?php 
                                    for ($i=1; $i <= $quotient; $i++) { 
                                        $value = $i*600;
                                        echo  '<option value='.$value.'>'.number_format($value*10000).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="pd_pin_group">
                            <div class="col-md-9" id="pd_epin"></div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label class="col-md-8 col-xs-12 control-label">Time of Investment</label>
                            <div class="col-md-4 xol-xs-12">
                                <select name="plan">
                            <?php
                                $quss = mysql_query("select * from plan_setting where end_amount <= '$max_invest'");
                                while($roqw = mysql_fetch_array($quss))
                                {
                                    $plan_id = $roqw['id'];
                                    $plan_name = $roqw['plan_name'];
                                    $min_amt = $roqw['amount'];
                                    $max_amt = $roqw['end_amount'];
                                    $days_invst = $roqw['days'];

                                ?>
                                    <option value="<?=$plan_id;?>">
                                    <?=$plan_name;?><?php /*?> for  <?=$min_amt;?> to <?=$max_amt;?><?php */?>
                                    </option>
                            <?php
                                }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-8 xol-xs-12 control-label">Security Code</label>
                            <div class="col-md-4 col-xs-12">
                                <input class="form-control" name="sec_code" placeholder="" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-8 xol-xs-12 control-label"></label>
                            <div class="col-md-4 col-xs-12">
                                <input type="submit" name="buy_unit" value="I agree to PH" class="btn btn-info btn-sm" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <p class="help-block" style="margin-top:0;line-height:15px;">
                            The amount you select : <span id="show_pd_amount"></span></br>
                            <span class="help-block" id="pd_pin" style="color:red"></span>
                        </p>
                    </div>
					<div style="clear:both;"></div>
                </div>
                </form>
                <?php }
                else{
                    if(!$pd_complete){
                        ?>
                        <div class="widget-body">
                            <p class="help-block">
                                <label class="control-label" style="color:#FF0000;">
                                    You have exceeded your PH allowance. Please try again later.
                        </label><br />
                            </p>
                        </div>
                        <?php
                    }
                } ?>
            </div>
        </div>

        <div id="gdWrap" style="display: none;">
            <div class="widget widget-body-white">
                <fieldset>
                <div class="widget-head widget-head-blue">
                    <h4 class="heading">GET HELP</h4>
                </div>

                <form class="form-horizontal margin-none" name="wallet_transfer" method="post" action="">
                    <input type="hidden" name="curr_amnt" value="<?=$curr_amnt; ?>"  />
                    <div class="widget-body" style="padding-top:15px;">
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label class="col-md-8 col-xs-12 control-label">
                                    Receivable Amount:<span class="ast">*</span>
                                </label>
                                <div class="col-md-4 col-xs-12">
                                    <input class="form-control" name="request" id="gd_amount" type="text">
                                    <p class="help-block">
                                        GH amount : <span id="show_gd_amount">0 = 0</span>
                                    </p>
                                    <p class="help-block red">
                                        <i>Note: GH amount must be a multiple of 100,000</i>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-8 col-xs-12 control-label">Your Bank Details:</label>
                                <div class="col-md-4 col-xs-12 value-user-info">
                                    <a class="" role="button" data-toggle="collapse" href="#bank_detail" aria-expanded="false" aria-controls="bank_detail">
                                        View now
                                    </a>
                                </div>
                            </div>
                            <div class="collapse" id="bank_detail">
                                <div class="form-group">
                                    <label class="col-md-8 col-xs-12 control-label">Bank Name:</label>
                                    <div class="col-md-4 col-xs-12 value-user-info"><span><?=$bank;?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 col-xs-12 control-label">Bank Branch Name:</label>
                                    <div class="col-md-4 col-xs-12 value-user-info"><span><?=$branch;?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 col-xs-12 control-label">Bank Account Number:</label>
                                    <div class="col-md-4 col-xs-12 value-user-info"><span><?=$ac_no;?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 col-xs-12 control-label">Bank Account Holder Name:</label>
                                    <div class="col-md-4 col-xs-12 value-user-info"><span><?=ucfirst($name);?></span></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-8 col-xs-12 control-label">Your Phone Number:</label>
                                    <div class="col-md-4 col-xs-12 value-user-info"><span><?=$phone_no;?></span></div>
                                </div>
                            </div>
                            
                            <div class="clear-fix"></div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 control-label text-left">
                                    From Wallet:<span class="ast">*</span>
                                </label>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-5 col-sm-6 col-xs-12 text-center">
                                            <div class="icon text-center"><i class="fa fa-money-icon"><img src="/images/newlayout/icons/main_wallet.png"></i></div>
                                            <div class="text-center"><b>M-Wallet: <span class="red"><?=number_format($wall_bal);?></span></b></div>
                                            <label class="radio">
                                                <input name="wallet_type" value="cwallet" class="mt8" type="radio" checked="checked" style="width:auto;margin:0"> 
                                            </label>
                                        </div>
                                        <div class="col-md-5 col-sm-6 col-xs-12 text-center">
                                            <div class="icon text-center"><i class="fa fa-trophy-icon"><img src="/images/newlayout/icons/com_wallet.png"></i></div>
                                            <div class="text-center"><b>C-Wallet: <span class="red"><?=number_format($roi_bal);?></span></b></div>
                                            <label class="radio">
                                                <input name="wallet_type" value="rwallet" class="mt8" type="radio" style="width:auto;margin:0"> 
                                            </label>
                                        </div>
                                        
                                        <div class="col-md-10 col-sm-12 col-xs-12 text-center">
                                            <p class="help-block mwallet_p">
                                                Minimum M-Wallet GH amount :
                                                <span id="minimum_amount" class="red">
                                                     <?=number_format($min_mw_gd_amt_settings[$level_vtype] * 10000);?>
                                                </span>
                                            </p>
                                            <p class="help-block cwallet_p">
                                                Minimum C-Wallet GH amount :
                                                <span id="minimum_amount" class="red">
                                                     <?=number_format($min_cw_gd_amt_settings[$level_vtype] * 10000);?>
                                                </span>
                                            </p>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="clear-fix"></div>
                            </div>
                            <div class="clear-fix"></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="col-md-8 col-xs-12 control-label">
                                            Security Code:<span class="ast">*</span>
                                        </label>
                                        <div class="col-md-4 col-xs-12">
                                            <input class="form-control" name="sec_code" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-8 col-xs-12 control-label"></label>
                                        <div class="col-md-4 col-xs-12">
                                            <input type="submit" name="withdraw" value="I agree to GH" class="btn btn-info btn-sm" />
                                        </div>
                                    </div>
                                </div>
                                <div class="clear-fix"></div>
                            </div>
                            <div class="clear-fix"></div>
                        </div>
                    </div>
                </form>
                </fieldset>

            </div>
        </div>
    </div>
</div>

<div class="differance-top">

    <div class="row">


        <!-- news list -->
        <div class='col-md-8 col-xs-12'>
            <div class="box-warning">
                <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">News List</h3>
                    <div class="box-tools pull-right">
                    <?php
                        $sql = "Select * from news order by id desc limit 4";
                        $query = mysql_query($sql);
                        $num = mysql_num_rows($query);
                    ?>
                        <span class="label label-danger"><?=$num;?> New</span>
                        <button class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="col-md-12">
                        <ul class="list-unstyled news-list">
                            <?php
                                $dem = 1;
                                while($id_row = mysql_fetch_array($query))
                                {
                                ?>
                                <li>
                                    <div class="row">
                                        <div class="col-lg-1 col-md-2 icon-admin">
                                            <span class="fa-stack" aria-hidden="true">
                                              	<i class="fa fa-circle fa-stack-2x text-blue"></i>
                                              	<i class="fa fa-user fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </div>
                                        <div class="news-item col-lg-11 col-md-10 col-sm-12 col-xs-12">
                                            <p><a href="index.php?page=news_list&p=1&news_no=<?=$id_row['id']?>"><?=$id_row['title']?></a></p>
                                            <div class="row">
                                                <div class="col-md-10 col-sm-12 col-xs-12">
                                                    <p><?=cropString($id_row['news'], 20)?></p>
                                                </div>
                                                <div class="col-md-2 col-sm-12 col-xs-12 news-date">
                                                    <p>Admin <br><?=$id_row['date']?></p>
                                                </div>
                                            </div>
                                            <div class="clear-fix:both"></div>
                                        </div>
                                    <div class="clear-fix:both"></div>
                                    </div>
                                </li>
                            <?php }?>
                            <div class="clear-fix:both"></div>
                        </ul>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                    <a href="index.php?page=news_list" class="uppercase">View All News</a>
                </div><!-- /.box-footer -->
            </div><!--/.box -->
            </div><!-- /.box -->
        </div>
        <!-- End / news list -->

        <div class="col-md-4 col-sm-6 col-xs-12 banner-home">
            <img src="images/newlayout/banner1.png">
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12 banner-home">
            <img src="images/newlayout/banner2.png">
        </div>

        <div class="col-md-8 col-sm-12 col-xs-12 link-register">
            <form class="form-inline">
                <div class="form-group">
                    Please use this link to refer other members to eBank
                </div>
                <?php
                $q_linkreg = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
                $r_linkreg = mysql_fetch_array($q_linkreg);
                ?>
                <div class="form-group">
                    <div class="form-control" id="linkRegister">https://system.ebank.tv/register.php?ref=<?=$r_linkreg['username'] ?></div>
                </div>
                <a href="javascript:;" class="btn btn-copy btn-success" data-clipboard-action="copy" data-clipboard-target="#linkRegister">Copy</a>
            </form>
        </div>


    </div>

</div>


<div class="load_success"><?=$success;?></div>
<div style="clear:both"></div>
<!--Four Box End-->
<div id="loading_div"></div>
<div class="detail_user"></div>
<div class="detail"></div>
<div id="chat_box" class="chat_box" style="position: fixed; padding: 10px; top: 24%; top: -500px; left:500px; z-index: 999; opacity: 0.9;">
<style>
.chat_log
{
    width:500px;
    min-height:248px;
    border:solid 1px #C7D5E0;
    background: bottom left #FEFEFF repeat-x;
}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
    border-top: 1px solid #ddd;
        line-height: 1.42857;
        padding: 8px;
        vertical-align: top;
}
.cwallet_p{display: none;}
.value-user-info {padding-top:7px;}
</style>
<div class="chat_log" >
    <div id="chat"></div>
    <div id="chatlogContentArea" > </div>
</div>

 </div>
<?php



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

function get_user_commitments($user_id)
{
    $res = 0;
    $qu = mysql_query("select sum(amount) from investment_request where user_id = '$user_id' and mode = 1 ");
    while($row = mysql_fetch_array($qu))
    {
        $res = $row[0];
    }
    if($res == '')
        $res =0;
    return $res;
}

?>

<script>
    $(function () {
    //Datemask dd/mm/yyyy
    $("#datemask").inputmask("yyyy-mm-dd", {"placeholder": "yyyy-mm-dd"});
    //Datemask2 mm/dd/yyyy
    $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    $("[data-mask]").inputmask();

    });
</script>

<script src="js/clipboard.min.js"></script>
<script>
        var clipboard = new Clipboard('.btn-copy');

        clipboard.on('success', function(e) {
                console.log(e);
        });

        clipboard.on('error', function(e) {
                console.log(e);
        });
</script>

<script type="text/javascript">
	$('input[name$="wallet_type"]').change(function(){
		var class_name = $(this).val();
		if(class_name == 'cwallet'){
			$('.cwallet_p').css("display", "none");
			$('.mwallet_p').css("display", "block");
		}else{
			$('.cwallet_p').css("display", "block");
			$('.mwallet_p').css("display", "none");
		}
	})
</script>
