<?php
ini_set("display_erros","on");
session_start();
include('condition.php');
include("function/functions.php");
require_once("pagination.php");
$user_id = $_SESSION['ebank_user_id'];

$bank_you = get_user_bank_name($user_id);
$username_you = get_user_name($user_id);

$you_name = ucfirst(get_full_name($user_id));
$you_phone = get_user_phone($user_id);

$mang_id = active_by_real_p($user_id);
$manager_name = ucfirst(get_full_name($mang_id));
$manager_phone = get_user_phone($mang_id);
?>
<script type="text/javascript" src="js/provide_donation.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="widget">
            <div class="widget-head clearfix"><h4 class="heading">PH History</h4></div>
            <div class="widget-body innerAll">
                <?php
                $limit = 10;
                $limit_count = isset($_GET['p']) ? ($_GET['p']-1)*$limit-1 : 0;
                $paging = new Pagination();
                $count_used_epin = mysql_num_rows(mysql_query("select *,sum(t1.amount) as amt,t2.amount as inv_amt from income_transfer t1
                left join investment_request t2 on t1.investment_id = t2.id
                 where t1.paying_id = '$user_id' group by investment_id"));


                $sqlk = "select *,sum(t1.amount) as amt,t2.amount as inv_amt from income_transfer t1
                left join investment_request t2 on t1.investment_id = t2.id
                 where t1.paying_id = '$user_id' group by investment_id LIMIT $limit_count,$limit";

                $querss = mysql_query($sqlk);
                $num = mysql_num_rows($querss);
                if($num > 0)
                {
                    while($rrss = mysql_fetch_array($querss))
                    {
                        $id_don[] = $rrss['id'];
                        $tot_amt[] = $rrss['amt'];
                        $invest_id[] = $rrss['investment_id'];
                        $date_don[] = $rrss['date'];
                        $mode_don[] = $rrss['mode'];
                        $remain_amt[] = $rrss['inv_amt']-$rrss['amt'];

                    }
                    for($i = 0; $i < count($invest_id); $i++)
                    {
                        $date_dont = date('d - M - Y', strtotime($date_don[$i]));
                        if($mode_don[$i] != 2)
                        {
                            $status_don="<span class=\"pending\">Pending Payment</span>";
                            $trst_fund = '0';
                        }
                        else
                        {
                            $status_don = "<span class=\"confirm\">Confirm Payment</span>";
                            $trst_fund = '100';
                        }

                        $inv_id = $invest_id[$i];
                        $status_tra = getStatusPD($inv_id);

                        if($status_tra == 0){
                            $status_don="<span class=\"pending\">Being Processed</span>";
                        }
                        if($status_tra == 1){
                            $status_don="<span class=\"pending\">Pending Approval</span>";
                        }
                        if($status_tra == 2){
                            $status_don = "<span class=\"confirm\">Completed</span>";
                        }


                        if($status_tra == 2){
                    ?>
                    <div class="overthrow" id="<?=$id_don[$i];?>">
                        <table class="table table-bordered table-donate table-pd ">
                        <tbody>
                        <tr>
                        <td>
                        <div class="donate-header clearfix">
                            <i data-original-title="Click&nbsp;to&nbsp;hide" class="fa fa-chevron-up hireTable" rel="<?=$id_don[$i];?>" value="pd" data-toggle="tooltip" data-placement="top" title=""></i>
                            <h4>Provide Help: <span>PH069<?=$id_don[$i];?></span></h4>
                            <b>Participant</b>: <?=$username_you;?><br>
                            <b>Amount</b>:   <?=number_format($tot_amt[$i]);?><br>
                            <!--<b>Remain Amount</b>: $  <?//=number_format($remain_amt[$i]);?><br>-->
                            <b>Date</b>: <?=$date_dont;?><br>
                            <b>Status</b>: <?=$status_don;?><br>
                            <a class="btn btn-info btn-print btn-sm glyphicon-right" href="#" onclick="printContent('<?=$id_don[$i];?>')" >
                                <i class="fa fa-print"></i> Print
                            </a>
                        </div>
                        <?php
                        $que = mysql_query("select * from income_transfer where paying_id = '$user_id'
                        and investment_id = '$inv_id'");
                        $num = mysql_num_rows($que);
                        if($num > 0)
                        {
                            $jc = 0;
                            $lvl_cc = 1;
                            while($row = mysql_fetch_array($que))
                            {
                                $jc++;
                                $pay_id = $row['user_id'];
                                $table_id = $row['id'];
                                $amount = $row['amount'];
                                $payment_receipt = $row['payment_receipt'];
                                $mode = $row['mode'];
                                $date_creat = $row['date'];
                                $date_creat = date('d/m/Y' , strtotime($date_creat));
                                $amount_usd = round($amount/$usd_value_current,2);

                                $receive_id = $row['paying_id'];
                                $tot_msg = get_tot_chat_message($receive_id);

                                $manager = active_by_real_p($pay_id);
                                $rec_mang_name = ucfirst(get_full_name($manager));
                                $rec_mang_phone = ucfirst(get_user_phone($manager));

                                if($mode != 2)
                                {
                                    $imgs = "ellipsis-h"; $class = "pending";
                                    $rect_msg = "Awaiting payment";
                                    $cnfirm_class = "orange";
                                }
                                else
                                {
                                    $imgs = "check"; $class = "confirm";
                                    $rect_msg = "Payment approved";
                                    $cnfirm_class = "green";
                                }

                                $query = mysql_query("SELECT * FROM users WHERE id_user = '$pay_id' ");
                                while($rrr = mysql_fetch_array($query))
                                {
                                    $id_user = $rrr['id_user'];
                                    $payee_username = $rrr['username'];
                                    $name = ucfirst($rrr['f_name'])." ".ucfirst($rrr['l_name']);
                                    $bank_paying = $rrr['bank'];
                                    $bank_ac = $rrr['ac_no'];
                                    $bank_branch = $rrr['branch'];
                                    $bank_city = $rrr['district'];
                                    $bank_state = $rrr['state'];
                                    $phone_payee = $rrr['phone_no'];
                                } ?>
                                <div style="display: none;" class="pd donate-body-<?=$id_don[$i];?>">
                                    <table class="table table-donations">
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
                                            <td class="pending" align="right">
                                                <span class="<?=$cnfirm_class;?>"><i class="fa fa-<?=$imgs;?>"></i> <?= $rect_msg; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="donate-status pending" width="100px">
                                                <span class="number">E06<?=$table_id;?>
                                            </td>
                                            <td>
                                                <span class="date"><?=$date_creat;?></span>
                                            </td>
                                            <td><span class="value money">You</span></td>
                                            <td width="20" align="center">
                                                <i class="fa fa-chevron-right"></i>
                                            </td>
                                            <td width="120px">
                                                <span class="value money">
                                                      <?=number_format($amount);?>
                                                </span>
                                            </td>
                                            <td width="20" align="center">
                                                <i class="fa fa-chevron-right"></i>
                                            </td>
                                            <td width="120px">
                                                <span class="user"><?=$payee_username;?></span>
                                            </td>
                                            <td class="nowrap action-btn" align="right">
                                                <a class="btn btn-warning btn-xs btn-details">Details</a>
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
                                                        TRANSFER TO : <!--<br>
                                                        Alipay Account (Taobao Account/Mobile/Email) :<br>
                                                        Bank Account Number : <?=$bank_ac;?>-->
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td><b>Bank Account Holder Name</b></td>
                                                    <td><?=$name;?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Bank Name</b></td>
                                                    <td><?=$bank_paying;?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Bank Branch Name</b></td>
                                                    <td><?=$bank_branch;?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Bank Account Number</b></td>
                                                    <td><?=$bank_ac;?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <ul class="contactList">
                                                            <li>
                                                                Contact Receiver: <?=$name;?> -
                                                                <?=$phone_payee;?>
                                                            </li>
                                                            <li>
                                                                Contact Receiver's Manager:
                                                                <?=$rec_mang_name;?> - <?=$rec_mang_phone;?>
                                                            </li>
                                                            <li>
                                                                Contact Sender: <?=$you_name;?> -
                                                                <?=$you_phone;?>
                                                            </li>
                                                            <?php
                                                            $q_find_user_Receiver = mysql_query("SELECT * FROM users WHERE id_user = $user_id ");
                                                            $user_name_Receiver = mysql_fetch_array($q_find_user_Receiver);
                                                            ?>
                                                            <li>
                                                                Contact Sender's Manager: <?=ucfirst(get_full_name($user_name_Receiver['real_parent']))?>- <?=ucfirst(get_user_phone($user_name_Receiver['real_parent']))?>
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
                    <p></p>
                        <?php }?>
                    <?php
                    }
                        $config = array(
                            'current_page' => isset($_GET['p']) ? $_GET['p'] : 1, // Trang hiện tại
                            'total_record' => $count_used_epin, // Tổng số record
                            'limit' => $limit, // limit
                            'link_full' => 'index.php?page=pd_history&p={page}', // Link full có dạng như sau: domain/com/page/{page}
                            'link_first' => 'index.php?page=pd_history', // Link trang đầu tiên
                            'range' => 9 // Số button trang bạn muốn hiển thị
                        );
                        $paging->init($config);
                        echo $paging->html();

                }
                else{ echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>"; }
                ?>
            </div>
        </div>
    </div>
</div>

<style>
.table-donations tr td.confirm i, .table-donations tr td.pending i, .table-donations tr td.reject i{
    background-color:#5cb85c;
    border:1px solid #259b67;
}
</style>
