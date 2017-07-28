<?php
ini_set("display_erros", "on");

session_start();

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


include('condition.php');

include("function/functions.php");

include("function/setting.php");


$user_id = $_SESSION['ebank_user_id'];

/*$query_level = mysql_query("select * from tb_level_plan");
$rows_list = find($query_level);
$user = getFindOne('users', $id);
$int_mode = mysql_num_rows(mysql_query("SELECT * FROM income_transfer where user_id='$user_id' and mode=2"));
foreach ($rows_list as $value)
{
    $level_name = $value['level_name'];
    if (($user['count_user'] >= $value['level_member']) and ( $int_mode >= $value['level_pd']))
    {
        //$user_update = mysql_query("update users set level = '$level_name' where id_user = '$user_id'");
    }
}*/
$level_vtype = get_user_level($user_id);

$max_time = $max_time[$level_vtype];

$bank_you = get_user_bank_name($user_id);

$username_you = get_user_name($user_id);



$you_name = ucfirst(get_full_name($user_id));

$you_phone = get_user_phone($user_id);



$mang_id = active_by_real_p($user_id);

$mang_name = ucfirst(get_full_name($mang_id));

$mang_phone = get_user_phone($mang_id);



//$rand = "GD".rand(11111,99999);
?>

<script type="text/javascript" src="js/provide_donation.js"></script>





<div class="col-md-9">

    <div class="widget">

        <div class="widget-head">

            <h4 class="heading"><i class="fa fa-download"></i> GET Donation</h4>

        </div>

        <div class="widget-body ">

            <?php
            $succ = $_REQUEST['succ'];

            if ($succ == 1)
            {
                print "<B style=\"color:#008000;\">Report Successfully Added !!</B>";
            }
            elseif ($succ == 2)
            {
                print "<B style=\"color:#FF0000;\">Report Already have Submitted By You !!</B>";
            }



            $sqlk = "select t1.*,t2.mode as inc_mode ,sum(t1.amount) as amt,t2.total_amount from income_transfer t1

		left join income t2 on t1.income_id = t2.id where t1.user_id = '$user_id' 

		group by income_id";

            $querss = mysql_query($sqlk);

            $num = mysql_num_rows($querss);
            if ($num > 0)
            {
                while ($rrss = mysql_fetch_array($querss))
                {
                    $date_dont = date('d - M - Y', strtotime($rrss['date']));
					
					//get status_do
					$status_stra = getStatus($rrss['income_id']);
					
                    if($status_stra == 0)
                    {
                        $status_don = "<span class=\"pending\">Request Processed</span>";
                    }
					if($status_stra == 1)
                    {
                        $status_don = "<span class=\"pending\">Payment Pending</span>";
                    }
                    if($status_stra == 2)
                    {
                        $status_don = "<span class=\"confirm\">Confirm Payment</span>";
                    }
				if($status_stra != 2){	
            ?>        
            <!-- overthow item -->
            <div class="overthrow">
                <table class="table table-bordered table-donate table-gd">
                    <tbody>
                        <tr bgcolor="#1bb5ce">
                            <td>
                               <div class="donate-header clearfix">
                                    <i title="" data-placement="top" data-toggle="tooltip" value="gd" rel="181" class="fa fa-ellipsis-h hireTable" data-original-title="Click&nbsp;to&nbsp;hide"></i>
                                    <h4>Request For Help: <span>GD06980<?=$rrss['income_id'];?></span></h4>
                                    <b>Participant</b>: <?=get_user_name($rrss['user_id']);?><br>
                                    <b>Amount</b>: $  <?=number_format($rrss['total_amount']); ?><br>
                                    <b>Remain Amount</b>: $  <?= number_format($rrss['total_amount'] - $rrss['amt']); ?><br>
                                    <b>Date</b>: <?=$date_dont;?><br>
                                    <b>Status</b>: <span class="pending"><?=$status_don?></span><br>
                                    <b>Trust Fund</b>: 0%<br>
                                    <a onclick="window.print();" class="btn btn-print btn-sm glyphicon-right">
                                        <i class="fa fa-print"></i> Print
                                    </a>
                                </div>
                                <?php 
                                $que = mysql_query("select * from income_transfer where user_id = ".$user_id." and income_id = ".$rrss['income_id']."");
                                $num = mysql_num_rows($que);
                                if ($num > 0)
                                {
                                    while ($row = mysql_fetch_array($que)){

                                        $curr_time = date('Y-m-d H:i:s');
                                        $block_time = date('Y-m-d H:i:s', strtotime($row['time_link'] . " +" . $max_time . " hours"));
                                        // hình và button approved
                                        if ($row['mode'] == 1)
                                        {
                                            //hình hóa đơn khi user confirm PD
                                            $img_pmt = "Confirmation : <a href=\"#dialog-photo\" id=\"show_image_".$row['id']."\" data=\"images/payment_receipt/".$row['payment_receipt']."\" data-toggle=\"modal\"><i class=\"fa fa-picture-o\"></i> </a>";
                                            //button approved
                                            $app_btn = "<a href=\"#dialog-approve-confirm\" data-toggle=\"modal\" src=\"data/box_approve.php?mdid=".$row['id']."\" class=\"btn btn-primary btn-sm\" id=\"show_approve_box\" data='{\"mdid\":".$row['id'].",\"inv_id\":".$row['investment_id']."}'>Approve</a>";
                                        }
                                        elseif ($row['mode'] == 2)
                                        {
                                            $img_pmt = "Confirmation: <a href=\"#dialog-photo\" id=\"show_image_".$row['id']."\" data=\"images/payment_receipt/".$row['payment_receipt']."\" data-toggle=\"modal\"><i class=\"fa fa-picture-o\"></i></a>";
                                        }
                                        else
                                        {
                                            $img_pmt = $app_btn = '';
                                        }  

                                        //tính thời gian đếm ngược
                                        $tot_second = '';
                                        if ($row['extend_time'] != NULL and $row['extend_time'] != '0000-00-00 00:00:00')
                                        {
                                            $swr = "SELECT TIMESTAMPDIFF(SECOND,'".$curr_time."','".$row['extend_time']."') as seconds";
                                            $result = mysql_fetch_array(mysql_query($swr));
                                            $tot_second = $result[0];
                                        }
                                        else
                                        {
                                            $ete = strtotime(date("Y-m-d", strtotime($row['time_link'] . "+ ".$max_time." hours")));
                                            $cume = strtotime(date("Y-m-d", strtotime($curr_time)));
                                            if ($ete > $cume)
                                                $ext_btn = "<a href=\"#dialog-msg\" src=\"?mdid=".$row['id']."\" data-toggle=\"modal\" class=\"btn btn-inverse btn-xs\" id=\"show_extend_box\" data=\"".$row['id']."\">Extend</a>";
                                            $swr = "SELECT TIMESTAMPDIFF(SECOND,'$curr_time','$block_time') as seconds";
                                            $result = mysql_fetch_array(mysql_query($swr));
                                            $tot_second = $result[0];
                                        }

                                        // tìm tên của user income
                                        $q_find_user_income = mysql_query("SELECT * FROM users WHERE id_user = ".$row['paying_id']." ");
                                        $user_name_id= mysql_fetch_array($q_find_user_income);
                                        $name_income = ucfirst($user_name_id['f_name']) . " " . ucfirst($user_name_id['l_name']);   

                                        if ($row['mode'] != 2)
                                        {
                                            $imgs = "ellipsis-h";
                                            $class = "pending";
                                            $rect_msg = "Funds Receiption is awaiting payment from PD user";
                                            $cnfirm_class = "orange";
                                            if ($curr_time > $block_time)
                                            {
                                                $report_btn = "<a href=\"#dialog-report-confirm\" data-toggle=\"modal\" class=\"btn btn-danger btn-sm\" id=\"show_report_box_gd\" data=\"{&quot;mdid&quot;:&quot;".$row['id']."&quot;,&quot;uid&quot;:&quot;".$row['user_id']."&quot;,&quot;uir&quot;:&quot;".$row['paying_id']."&quot;,&quot;invest&quot;:&quot;".$row['investment_id']."&quot;}\">Report</a>";
                                            }else{
                                                 $report_btn = '';
                                            }
                                           
                                            $tr = "<tr style=\"background-color: #ffe5e5;\">
                                                <td colspan=\"7\" style=\"color:#a52121\">
                                                    ROI Distribute Remain Time : <span class=\"approve_remaining_time\" rel=\"".$tot_second."\" id=\"_remain_sec_MD006521".$row['id']."\"></span>                                        
                                                </td>
                                            </tr>";
                                            $chat_but = "<a href='#chat_box' onClick='OpenChatWindow(".$row['paying_id'].",chat,".$row['user_id'].")' role='button' class='btn btn-inverse btn-xs' data-toggle='chat_box'>Chat</a>";     
                                        }
                                        else
                                        {
                                            $tr = '';
                                            $ext_btn = '';
                                            $imgs = "check";
                                            $class = "confirm";
                                            $rect_msg = "You Approved funds reception : MD006521" . $table_id;
                                            $cnfirm_class = "green";
                                            $report_btn = '';
                                        }   


                                        
                                ?>
                                <!-- income transfer item -->
                                <div class="gd donate-body-181" style="display: block;">
                                    <table class="table table-donations <?php if(check_user_report($row['paying_id']) >0){ echo 'table-donations-report';}?>">
                                        <tbody>
                                            <tr style="background-color: #ffe5e5;">
                                                <td style="color:#a52121" colspan="7">
                                                    ROI Distribute Remain Time : <span id="_remain_sec_MD006521<?=$row['id']?>" rel="<?=$tot_second?>" class="approve_remaining_time"></span>                                        
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="100px" class="donate-status pending">
                                                    ID: <span class="number">MD006521<?=$row['id'];?></span>
                                                </td>
                                                <td>Create Date:<br><span class="date"><?=date('d/M/Y', strtotime($row['date']))?></span></td>
                                                <td><span class="user">You</span><?=get_user_bank_name($row['user_id']);?></td>
                                                <td width="20" align="center">
                                                    <i class="fa fa-chevron-left"></i>
                                                </td>
                                                <td width="120px">
                                                    <span class="value money">$  <?=number_format($row['amount']); ?></span>  
                                                    <?=$img_pmt?>
                                                </td>
                                                <td width="20" align="center">
                                                    <i class="fa fa-chevron-left"></i>
                                                </td>
                                                <td width="120px">
                                                    <span class="user"><?=$name_income;?></span> <?=get_bank_name($row['paying_id']);?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="pending"><i class="fa fa-ellipsis-h"></i></td>
                                                <td width="48%" colspan="3">
                                                    <span class="<?= $cnfirm_class; ?>"><?= $rect_msg; ?></span>
                                                </td>
                                                <td align="right" class="nowrap action-btn" colspan="3">  
                                                <?php  
                                                //kiểm tra user bị report
                                                $user_rep = check_user_report($row['paying_id']);
                                                if($user_rep > 0){ echo '<p class="red text-left" style="font-size:15px;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>'.$alert_report[1].' <a class="btn btn-warning btn-xs btn-details pull-right">Details</a></p>';}
                                                else{ 
                                                ?>    
                                                    <?=$app_btn?>  
                                                    <?= $report_btn; ?>    
                                                    <?= $ext_btn; ?>
                                                    <a class="btn btn-warning btn-xs btn-details">Details</a>
                                                    <?= $chat_but; ?>    
                                                <?php }?>                                                                                                                                
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="transactionWrap" style="display: none;">
                                        <div class="transaction-details">
                                            <table class="table table-bordered table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2">
                                                            TRANSFER BY :
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $q_user_income = mysql_query("SELECT * FROM users WHERE id_user = ".$row['paying_id']." ");
                                                    $r_user_income = mysql_fetch_array($q_user_income);
                                                    ?>
                                                    <tr>
                                                        <td><b>Bank Account Holder Name</b></td>
                                                        <td><?=$name_income;?></td>
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
                                                        <td><?=$r_user_income['beneficiery_name'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Bit Coin A/C</b></td>
                                                        <td>
                                                            <strong style="color:red;">
                                                                <?php if ($bit_coin_ac != ""){?>
                                                                    <?= $bit_coin_ac ?><br />
                                                                    <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?= $bit_coin_ac ?>" />
                                                                <?php
                                                                    }else{
                                                                    print "<strong style='color:red;'>No A/C found</strong>";
                                                                }?>

                                                            </strong>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <ul class="contactList">
                                                                <li>
                                                                    Contact Recipient: <?=$name_income;?> : <?=$r_user_income['phone_no'];?>
                                                                </li>
                                                                <li>
                                                                    Contact Manager of Recipient: <?=ucfirst(get_full_name($r_user_income['real_parent']))?> : <?=ucfirst(get_user_phone($r_user_income['real_parent']))?>
                                                                </li>
                                                                <li>
                                                                    Contact Sender: Ebank ebank : 345734857394
                                                                </li>
                                                                <li>
                                                                    <?php $user_parent2 = active_by_real_p($user_id);?>
                                                                    Contact Manager of Sender: <?=ucfirst(get_full_name($user_parent2))?> : <?=ucfirst(get_user_phone($user_parent2))?>

                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--  END / income transfer item -->
                                <?php } }?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p></p>
            <!-- End overthow item -->
				<?php }?>
				<?php }}else{  echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>";}?>
        </div>
    </div>
</div>



<div class="col-md-3" style="padding:0px;">

    <?php
    $sqssl = "SELECT * from income where user_id = $user_id";
    //$sqssl = "SELECT *,sum(amount) as amt from income_transfer WHERE paying_id = '$user_id' group by income_id ";
	//$sqssl = "select t1.*,t2.mode as inc_mode ,sum(t1.amount) as amt,t2.total_amount from income_transfer t1 left join income t2 on t1.income_id = t2.id where t1.user_id = '$user_id' group by income_id";
    $query = mysql_query($sqssl);
    while ($row = mysql_fetch_array($query))
    {
		

        $id = $row['id'];

        $user_id = $row['user_id'];

        $amount = $row['total_amount'];

        $paid_amt = $row['paid_amount'];

        $mode = $row['mode'];

        $int_mode = $row['int_mode'];

        $date = $row['date'];

        $date = date('d-M-Y', strtotime($date));
		
		$time_gd = $row['time_confirm'];

        $name = ucfirst(get_full_name($user_id));



		
		//get status_do
		$status_stra = getStatus($id);
		
		if($status_stra == 0){
			$mesgs="<span style=\"color:#F09D47;\">Request Processed</span>";
			$div_class = 'pending';
		}
		if($status_stra == 1){
			$mesgs="<span style=\"color:#008000;\">Pending Payment</span>";
			$div_class = 'pending';
			
		}
		if($status_stra == 2){
			$mesgs = "<span style=\"color:#F09D47;\">Confirm Payment</span>";
			$div_class = 'confirm';
			
			//check isset id_GD in tb_repd
            if($time_gd > 0){
                $time =  $time_gd;
            }else{
                $time = date('Y-m-d H:i:s', time());
            }
            $q_repd = mysql_query("SELECT * FROM tb_repd WHERE gd_id = $id AND user_id = $user_id");
            $r_repd = mysql_num_rows($q_repd);
            if($r_repd > 0){}
            else{
                $inser_repd = mysql_query("INSERT INTO tb_repd (user_id , gd_id , gd_time) values ('$user_id' , '$id' , '$time')");
            }
		}
			
			
		if($status_stra != 2){
			$q_sumincom = mysql_query("SELECT SUM(income_transfer) FROM income_transfer WHERE income_id = $id");
            $r_sumincom = mysql_fetch_array($q_sumincom);
            if($r_sumincom > 0){
                $remain_amt = $amount - $r_sumincom;
            } else {
                $remain_amt = $amount;
            }

        ?>

        <div class="widget donate-sidebar gdContainer-<?= $div_class; ?>">

            <div class="widget-body">

                <div class="donateHead clearfix">

                    <span class="fa fa-arrow-right glyphicon-circle glyphicon-right"></span>

                    <div class="title">Get Donation: <span>GD06980<?= $id; ?></span></div>

                </div>

                <b>Participant</b>:  <?= $name; ?><br>

                <b>Amount</b>: $  <?= number_format($amount); ?><br>

                <b>Remain Amount</b>: $  <?= number_format($remain_amt); ?><br>

                <b>Date</b>: <?= $date; ?><br>

                                <b>Status</b>: <?= $mesgs; ?><!--<span class="pending">Pending</span>-->

            </div>

        </div>

    <?php
	}}
?>

</div>



<?php
include 'box_approve.php';

include 'box_report_gd.php';

include 'box_extend.php';

include 'box_payment_recipt.php';

include 'box_message.php';
?>

