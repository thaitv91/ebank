<?php
ini_set("display_erros","on");
session_start();
include('condition.php');
include("function/functions.php");
include("function/setting.php");
$user_id = $_SESSION['ebank_user_id'];
$level_vtype = get_user_level($user_id);
$max_time = $max_time[$level_vtype];
$bank_you = get_user_bank_name($user_id);
$username_you = get_user_name($user_id);

$you_name = ucfirst(get_full_name($user_id));
$you_phone = get_user_phone($user_id);

$mang_id = active_by_real_p($user_id);
$manager_name = ucfirst(get_full_name($mang_id));
$manager_phone = get_user_phone($mang_id);

$rand = "PH".rand(11111,99999);
?>
<script type="text/javascript" src="js/provide_donation.js"></script>

<div class="col-md-9">
    <div class="box box-primary" style="padding: 15px">
        <div class="">
            <h4 class="heading">Provide Help</h4>
        </div>
        <div class="widget-body innerAll">
            <?php
            $succ = $_REQUEST['succ'];
            $pay_err = $_REQUEST['pay_err'];
            if($succ == 1)
                print "<B style=\"color:#008000;\">Your report request has been sent to Admin.</B>" ;
            elseif($succ == 2)
                print "<B style=\"color:#FF0000;\">You have already reported this member.</B>" ;

            if($pay_err == 1)
                print "<B style=\"color:#FF0000;\">Error: Invalid file extension !!</B>";
            elseif($pay_err == 2)
                print "<B style=\"color:#FF0000;\">Error: Payment receipt not saved !!</B>";
            elseif($pay_err == 3)
                print "<B style=\"color:#FF0000;\">Error: Payment receipt not found !!</B>" ;
            elseif($pay_err == 4)
                print "<B style=\"color:#FF0000;\">Error: Invalid Pay Code !!</B>" ;
            elseif($pay_err == 5)
                print "<B style=\"color:#1D46BB;\">Receipt successfully uploaded !!</B>" ;



            $sqlk = "select t1.*,sum(t1.amount) as amt,t2.amount as inv_amt from income_transfer t1 left join investment_request t2 on t1.investment_id = t2.id where t1.paying_id = '$user_id' group by investment_id";
            $querss = mysql_query($sqlk);
            $num = mysql_num_rows($querss);

            if($num > 0)
            {
                while($rrss = mysql_fetch_array($querss))
                {   
                    $id_don = $rrss['id'];
                    $tot_amt = $rrss['amt'];
                    $invest_id = $rrss['investment_id'];
                    $date_don = $rrss['date'];
                    $mode_don = $rrss['mode'];
                    $remain_amt = $rrss['inv_amt']-$rrss['amt'];

                    $date_dont = date('d - M - Y', strtotime($date_don));

                    $inv_id = $invest_id;
                    $curr_time = date('Y-m-d H:i:s');//$systems_date_time;

                    $status_tra = getStatusPD($invest_id);


                    $q_incomtransfer = mysql_query("select * from income_transfer where paying_id = ".$user_id." and investment_id = ".$rrss['investment_id']."");
                    $row_incomtransfer = mysql_fetch_array($q_incomtransfer);
                    $curr_time = date('Y-m-d H:i:s');
                    $str_max_time = $max_time * 3600;

                    $block_time = date('Y-m-d H:i:s', strtotime($row_incomtransfer['time_link'])+$str_max_time);

                    $tot_second = '';
                    if ($row_incomtransfer['extend_time'] != NULL and $row_incomtransfer['extend_time'] != '0000-00-00 00:00:00')
                    {
                        $swr = "SELECT TIMESTAMPDIFF(SECOND,'".$curr_time."','".$row_incomtransfer['extend_time']."') as seconds";
                        $result = mysql_fetch_array(mysql_query($swr));
                        $tot_second = $result[0];
                    }
                    else
                    {
                        $ete = date('Y-m-d H:i:s', strtotime($row_incomtransfer['time_link'])+$str_max_time);
                        $cume = strtotime(date("Y-m-d H:i:s", strtotime($curr_time)));
                        if ($ete > $cume)
                            $ext_btn = "<a href=\"#dialog-msg\" src=\"?mdid=".$row_incomtransfer['id']."\" data-toggle=\"modal\" class=\"btn btn-inverse btn-xs\" id=\"show_extend_box\" data=\"".$row_incomtransfer['id']."\">Extend</a>";
                        $swr = "SELECT TIMESTAMPDIFF(SECOND,'$curr_time','$block_time') as seconds";
                        $result = mysql_fetch_array(mysql_query($swr));
                        $tot_second = $result[0];
                    }

                    if($status_tra == 0){
                        $status_don="<span class=\"pending\">Being Processed</span>";
                        $roi_time = "<b class='text-remaining_time remaining_time$id_don '>Time Left To Complete Transaction: </b>
                        <span class=\"approve_remaining_time ph-remaining\" rel=\"$tot_second\" data_class=\"remaining_time$id_don\" id=\"_remain_sec_p$rand.$id_don\"></span>";
                    }
                    if($status_tra == 1){
                        $status_don="<span class=\"pending\">Pending Completion</span>";
                        $roi_time = "<b class='text-remaining_time remaining_time$id_don'>Time Left To Complete Transaction:&nbsp;</b>
                        <span class=\"approve_remaining_time ph-remaining\" rel=\"$tot_second\" data_class=\"remaining_time$id_don\" id=\"_remain_sec_p$rand.$id_don\"></span>";
                    }
                    if($status_tra == 2){
                        $status_don = "<span class=\"confirm\">Completed</span>";
                        $roi_time = "";
                    }

                    if($status_tra !=  2){
                ?>
                        <div class="overthrow">
                            <div class="table-responsive">
                                <table class="table table-bordered table-donate table-pd ">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="donate-header clearfix">
                                                    <i data-original-title="Click&nbsp;to&nbsp;hide" class="fa fa-chevron-up hireTable" rel="<?=$id_don;?>" value="pd" data-toggle="tooltip" data-placement="top" title=""></i>
                                                    <h4>Your PH ID: <span>PH069<?=$invest_id;?></span></h4>
                                                    <b>Participant</b>: <?=$username_you;?><br>
                                                    <b>Amount</b>: <?=number_format($tot_amt);?><br>
                                                    <!--<b>Remain Amount</b>: $  <?//=number_format($remain_amt);?><br>-->
                                                    <b>Date</b>: <?=$date_dont;?><br>
                                                    <b>Status</b>: <?=$status_don;?><br>
                                                    <?=$roi_time;?>
                                                    <a class="btn btn-info btn-print btn-sm glyphicon-right" href="#" >
                                                        <i class="fa fa-print"></i> Print
                                                    </a>
                                                </div>
                                            <?php
                                            $que = mysql_query("select * from income_transfer where paying_id = '$user_id' and investment_id = '$inv_id'");
                                            $num_in = mysql_num_rows($que);
                                            if($num_in > 0){
                                                while($row = mysql_fetch_array($que)){
                                                    $jc++;
                                                    $pay_id = $row['user_id'];
                                                    $table_id = $row['id'];
                                                    $amount = $row['amount'];
                                                    $payment_receipt = $row['payment_receipt'];
                                                    $mode = $row['mode'];
                                                    $date_creat = $row['date'];
                                                    $time_link = $row['time_link'];
                                                    $date_creat = date('d/m/Y' , strtotime($date_creat));
                                                    $amount_usd = round($amount/$usd_value_current,2);

                                                    $receive_id = $row['paying_id'];
                                                    $tot_msg = get_tot_chat_message($receive_id);

                                                    $manager = real_parent($pay_id);
                                                    $rec_mang_name = ucfirst(get_full_name($manager));
                                                    $rec_mang_phone = ucfirst(get_user_phone($manager));

                                                    if($mode == 0)
                                                    {
                                                        $report_btn = '';
                                                        $conf_btn = "<a href=\"#dialog-confirm-confirm\" data-toggle=\"modal\" src=\"?mdid=$table_id\" class=\"btn btn-default btn-sm\" id=\"show_confirm_box_$table_id\" data='{\"mdid\":$table_id}' style=\"background-color: #1dbb1d;\">Confirm</a>";

                                                        $imgs = "ellipsis-h"; $class = "pending";
                                                        $rect_msg = "Awaiting your payment";
                                                        $cnfirm_class = "orange";
                                                        $chat_but = "<a href='#chat_box' onClick='OpenChatWindow($pay_id,chat,$receive_id)' role='button' class='btn btn-inverse btn-xs' data-toggle='chat_box'>Chat</a>";

                                                    }
                                                    elseif($mode == 2)
                                                    {
                                                        $report_btn = '';
                                                        $imgs = "check"; $class = "confirm";
                                                        $rect_msg = "Payment approved";
                                                        $cnfirm_class = "green";
                                                    }
                                                    else
                                                    {
                                                        $conf_btn = '';
                                                        $imgs = "ellipsis-h"; $class = "pending";
                                                        $rect_msg = "Awaiting confirmation";
                                                        $cnfirm_class = "red";
                                                        $chat_but = "<a href='#chat_box' onClick='OpenChatWindow($pay_id,chat,$receive_id)' role='button' class='btn btn-inverse btn-xs' data-toggle='chat_box'>Chat</a>";
                                                        $report_btn = "<a href=\"#dialog-report-confirm\" data-toggle=\"modal\" class=\"btn btn-danger btn-sm\" id=\"show_report_box_gd\" data=\"{&quot;mdid&quot;:&quot;".$row['id']."&quot;,&quot;uid&quot;:&quot;".$row['user_id']."&quot;,&quot;uir&quot;:&quot;".$row['paying_id']."&quot;,&quot;invest&quot;:&quot;".$row['investment_id']."&quot;}\">Report</a>";
                                                    }
                                            ?>
                                                <div style="display: block;" class="pd donate-body-<?=$id_don;?>">
                                                    <table class="table table-donations <?php if(check_user_report($pay_id) >0){ echo 'table-donations-report';}?>">
                                                        <tbody>
                                                        <tr class="title-pd">
                                                            <td width="100px" class="donate-status pending">
                                                                ID
                                                            </td>
                                                            <td>Create Date</td>
                                                            <td>Sender</td>
                                                            <td width="20" align="center"></td>
                                                            <td>Amount</td>
                                                            <td width="20" align="center"></td>
                                                            <td>Receiver</td>
                                                            <td class="<?php if($mode == 2){echo 'confirm';}else{echo 'pending';}?>" align="right">
                                                                <span class="<?= $cnfirm_class; ?>"><i style="padding:1px 0; width:20px;" class="fa <?php if($mode == 2){echo 'fa-check';}else{echo 'fa-info';}?>"></i> <?= $rect_msg; ?></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="donate-status pending" width="100px">
                                                                <span class="number">E06<?=$table_id;?></span>
                                                            </td>
                                                            <td>
                                                                <span class="date"><?=$date_creat;?></span>
                                                            </td>
                                                            <td><span class="user">You</span></td>
                                                            <td width="20" align="center">
                                                                <i class="fa fa-chevron-right"></i>
                                                            </td>
                                                            <td width="120px">
                                                                <span class="value money">  <?=number_format($amount);?></span>
                                                            </td>
                                                            <td width="20" align="center">
                                                                <i class="fa fa-chevron-right"></i>
                                                            </td>
                                                            <td width="120px">
                                                                <span class="user"><?=get_user_name($pay_id);?></span>
                                                            </td>
                                                            <td class="nowrap action-btn" align="right">
                                                            <?php
                                                            //kiểm tra user bị report
                                                            $user_rep = check_user_report($pay_id);
                                                            $user_rep_incom = check_user_report($receive_id);
                                                            if( ($user_rep > 0) || ($user_rep_incom > 0) ){ echo '<p class="red text-left" style="font-size:15px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>'.$alert_report[1].'  <a class="btn btn-warning btn-xs btn-details pull-right">Details</a></p>';}
                                                            else{
                                                            ?>
                                                                <?=$conf_btn;?>
                                                                <?=$report_btn;?>
                                                                <a class="btn btn-warning btn-xs btn-details">Details</a>
                                                                <?=$chat_but;?>
                                                            <?php }?>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style="display: none;" class="transactionWrap">
                                                        <div class="transaction-details">
                                                            <table class="table table-condensed">
                                                                <thead>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        TRANSFER TO:
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                <?php
                                                                $q_user_income = mysql_query("SELECT * FROM users WHERE id_user = ".$row['user_id']." ");
                                                                $r_user_income = mysql_fetch_array($q_user_income);
                                                                $name_income = ucfirst($r_user_income['f_name']) . " " . ucfirst($r_user_income['l_name']);
                                                                ?>
                                                                    <td><b>Bank Account Holder Name</b></td>
                                                                    <td><?=$r_user_income['beneficiery_name'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Bank Name</b></td>
                                                                    <td><?=$r_user_income['bank'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Bank Branch Name</b></td>
                                                                    <td><?=$r_user_income['branch'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>Bank Account Number</b></td>
                                                                    <td><?=$r_user_income['ac_no'];?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2">
                                                                        <ul class="contactList">
                                                                            
                                                                            <li>
                                                                                Contact Receiver: <?=$name_income;?> - <?=$r_user_income['phone_no'];?>
                                                                            </li>
                                                                            <li>
                                                                                Contact Receiver's Manager: <?=ucfirst(get_full_name($r_user_income['real_parent']))?> - <?=ucfirst(get_user_phone($r_user_income['real_parent']))?>
                                                                            </li>
                                                                            <li>
                                                                                Contact Sender: <?=$you_name;?> -
                                                                                <?=$you_phone;?>
                                                                            </li>
                                                                            <?php
                                                                            $q_find_user_Sender = mysql_query("SELECT * FROM users WHERE id_user = ".$user_id." ");
                                                                            $user_name_Sender = mysql_fetch_array($q_find_user_Sender);
                                                                            ?>
                                                                            <li>
                                                                                Contact Sender's Manager: <?=ucfirst(get_full_name($user_name_Sender['real_parent']))?> - <?=ucfirst(get_user_phone($user_name_Sender['real_parent']))?>
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                             </div>
                        </div>
                        <p></p>
                <?php 
                    }
                }
            }
            else{ echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>"; }
        ?>
    </div>
    </div>
</div>
<div class="col-md-3" style="padding:0px;">
    <?php
    /*
        $sqssl = "SELECT t1.* , t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id WHERE t1.user_id = '$user_id' group by investment_id";*/
        $sqssl = "SELECT * from investment_request where user_id = $user_id ORDER BY id DESC";
        //$sqssl = "SELECT t1.*,sum(t2.amount) as amt FROM income_transfer t2 right join investment_request t1 on t2.investment_id = t1.id  WHERE t1.user_id = '$user_id' group by t2.investment_id";

        $query = mysql_query($sqssl);

        while($row = mysql_fetch_array($query))
        {   
            $id = $row['id'];
            $paying_id = $row['paying_id'];
            $amount = $row['amount'];
            $mode = $row['mode'];
            $inv_profit = $row['inv_profit'];
            /*$int_mode = $row['int_mode'];*/
            $date = $row['date'];
            $date = date('d-M-Y', strtotime($date));
            $name = ucfirst(get_full_name($user_id));
            $amt = $row['amt'];
            $remain_amt = $amount-$amt;


            //$int_mode=mysql_num_rows(mysql_query("SELECT * FROM income_transfer where investment_id='$id' and mode!='2'"));

            switch($inv_profit)
            {
                case 10 : $bg_class = "bg_green"; break;
                case 20 : $bg_class = "bg_blue"; break;
                case 30 : $bg_class = "bg_yellow"; break;
                case 40 : $bg_class = "bg_pink"; break;
                case 30 : $bg_class = "bg_sky_blue"; break;
            }

            if($mode == 1)
            {
                //$mesgs = "<span style=\"color:#F09D47;\">Request processed</span>";
                $div_class = 'pending';
            }

            elseif($mode == 0)
            {

                //$mesgs = "<span style=\"color:#008000;\">Request Confirmed</span>";
                $div_class = 'confirm';
            }
            else
            {
                //$mesgs = "<span style=\"color:#F09D47;\">Request in Processing</span>";
                $div_class = 'pending';

            }
            /*elseif($mode == 0 and $int_mode == 1)
            { $mesgs = "<span style=\"color:#F09D47;\">Request Pending</span>"; $div_class = 'pending'; }
            */

            $status_tra = getStatusPD($id);

            if($status_tra == 0){
                $mesgs="<span style=\"color:#FD0000;\">Being Processed</span>";
            }
            if($status_tra == 1){
                $mesgs="<span style=\"color:#47FE03;\">Pending Completion</span>";
            }
            if($status_tra == 2){
                $mesgs = "<span style=\"color:#F09D47;\">Completed</span>";
            }

            if($status_tra !=  2){

                $date1=date_create($row['date']);
                if($row['app_date'] == '0000-00-00'){
                    $date2=date_create(date('Y-m-d', time()));
                }else{
                    $date2=date_create($row['app_date']);
                }
                $diff = date_diff($date1,$date2);
                $cv_array = get_object_vars($diff);
                $day_inc = $cv_array['days'];


                $plansetting = mysql_query("select * from plan_setting where id = " . $row['plan_setting_id'] . " ");
                $r_plansetting = mysql_fetch_array($plansetting);
                $profit_inc = $r_plansetting['profit'];

                $sponsor_amount = $amount * $profit_inc * $day_inc / 100;

        ?>
        <div class="widget donate-sidebar pdContainer-<?=$div_class;?>">
            <div class="donateHead clearfix">
                <div class="title">Your PH ID: PH069<?=$id;?></div>
            </div>
            <div class="widget-body">
                <ul class="list-unstyled list-ph">
                    <li>
                        <span class="icon date"></span>
                        <b>Start date : <?=$date;?></b>
                    </li>
                    <li>
                        <span class="icon amount"></span>
                        <b>PH Amount : <?=number_format($amount);?></b><br>
                    </li>
                    <li>
                        <span class="icon profit"></span>
                        <b>Profit to date : <?=number_format($sponsor_amount);?></b>
                    </li>
                    <li>
                        <span class="icon received"></span>
                        <b>Amount Received : 
                        <?php 
                        $amount_profit = $sponsor_amount + $amount;
                        $limit_ph;
                        $amount_received = 0;

                        if( $amount == 5000000){ 
                            $amount_profit = 6400000;
                        }else { 
                             $amount_profit = 3200000;
                        }
                        echo number_format($amount_profit);
                        ?>
                        </b>
                    </li>
                    <li>
                        <span class="icon status"></span>
                        <b>Status</b>: <?=$mesgs;?>
                    </li>
                </ul>
            </div>
        </div>
    <?php
        }}
    ?>
</div>
<?php
include 'box_confirm.php';
include 'box_report.php';
?>

