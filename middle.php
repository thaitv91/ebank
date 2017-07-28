<?php
ini_set("display_errors",'off');
$val = $_REQUEST['page'];
$main_menu = get_submenu($val);
$name = $_SESSION['ebank_user_full_name'];
$user_id = $_SESSION['ebank_user_id'];
$sql = "Select * from menu where menu_file = '$val'";
$query = mysql_query($sql);
while($row = mysql_fetch_array($query))
{
    $menu_title = $row['menu'];
    $menu_file = $row['menu_file'];
}

if($val == ''){ 
    $menu_title = "<div class='row'>Dashboard <small>Vesion 2.0</small></div>"; $main_menu = 'Desktop'; $class = "box-primary"; 
} elseif($val == 'welcome') { 
    $menu_title = "<div class='row'>Dashboard <small>Vesion 2.0</small></div>"; $main_menu = 'Desktop'; $class = "box-primary"; 
} else { 
    $class = "box box-primary"; 
}

if($val == 'edit_bank') {
    $menu_title = "Edit Bank"; $main_menu = 'Accounts';
}

switch($menu_file)
{
    case '' : 						$icon = '';			            break;
    case 'welcome' : 				$icon = '';			            break;
    case 'registration' : 			$icon = 'fa-eye';				break;
    case 'inactive_members' : 		$icon = 'fa-user';				break;
    case 'tree' : 			        $icon = 'fa-users';				break;
    case 'direct-members' : 		$icon = 'fa-group';				break;
    case 'participants' : 			$icon = 'fa-group';				break;
    case 'downline_pd' : 			$icon = 'fa-trophy';			break;
    case 'downline_gd' : 			$icon = 'fa-trophy';			break;
    case 'add_bank' : 				$icon = 'fa-edit';				break;
    case 'edit-password' : 			$icon = 'fa-lock';				break;
    case 'edit_sec_code' : 			$icon = 'fa-lock';				break;
    case 'provide_donation' : 		$icon = 'fa-money';				break;
    case 'get_donation' : 			$icon = 'fa-money';				break;
    case 'penalty_protection' : 	$icon = 'fa-money';				break;
    case 'user_protection' : 		$icon = 'fa-money';				break;
    case 'epin_request' : 			$icon = 'fa-key';				break;
    case 'unused_pin' : 			$icon = 'fa-key';				break;
    case 'pin-transfer-to-member' : $icon = 'fa-key';				break;
    case 'inbox' : 					$icon = 'fa-inbox';				break;
    case 'sent_message' : 			$icon = 'fa-envelope';			break;
    case 'compose' : 				$icon = 'fa-edit';				break;
    case 'compose_all' : 			$icon = 'fa-wechat';			break;
    case 'product_shop' : 			$icon = 'fa-shopping-cart';		break;
    case 'faq' : 					$icon = 'fa-question-circle';	break;
    case 'legal_docs' : 			$icon = 'fa-legal';				break;
    case 'pd_history' : 			$icon = 'fa-th';				break;
    case 'gd_history' : 			$icon = 'fa-th';				break;
    case 'main_wallet' : 			$icon = 'fa-money';				break;
    case 'comm_wallet' : 			$icon = 'fa-money';				break;
    case 'roi_wallet' : 			$icon = 'fa-money';				break;
    case 'epin_wallet' : 			$icon = 'fa-key';				break;
    case 'pin_transfer_history' : 	$icon = 'fa-key';				break;
    case 'remove_block' : 	        $icon = 'fa-unlock-alt';		break;
    case 'confirm_block' : 	        $icon = 'fa-unlock-alt';		break;
}

if($val == 'registration1') {
    $icon = 'fa-eye';$menu_title = 'Registration';
}

if($val == 'registration_epin') {
    $icon = 'fa-key';$menu_title = 'E-pin Transfer To Member';
}

$q = mysql_query("select * from wallet where id = '$user_id' ");
while($row = mysql_fetch_array($q)) {
    $cash_wall = $row['amount'];
    $roi_wall = $row['roi'];
    $epin_wall = $row['epin_wallet'];
}
?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="hidden-xs" style="text-align:right; height:30px; position:absolute; right: 15px; top: 0;">
                    <div style="padding-top:10px;">
                        <strong class="mr5">Server Time</strong>
                        <span id="clock"></span> <?=date('d/m/Y');?>
                    </div>
                </div>

                <script type="text/javascript" src="<?=$url_local?>/js/remaining.js"></script>
                <?php
                    $sql_time_block = mysql_query("SELECT * FROM tb_time_block");
                    $row_time_report = mysql_fetch_array($sql_time_block);
                    $time_block = $row_time_report['time_block'];
                    $time_frozen = $row_time_report['time_frozen'];
                    $frozen_downline = $row_time_report['frozen_downline'];
                    $time_report = $row_time_report['time_report'];
                    $query = mysql_query("SELECT * FROM report WHERE reported = ".$user_id."");

                    if (mysql_num_rows($query) > 0) {
                        while($r_report_alert = mysql_fetch_array($query)){
                            $rel_time_report = (strtotime($r_report_alert['date']) + $time_block*3600) - time();
                            $rel_time_frozen = (strtotime($r_report_alert['frozen_date']) + $time_frozen*3600) - time();
                            if($r_report_alert['mode'] == 1) {
                                echo '<div class="row"><div class="col-md-12"><div class="alert alert-warning alert-report">
                                          <i class="fa fa-exclamation-triangle fa-3x pull-left" aria-hidden="true"></i> <strong>This account is being reported!</strong>
                                          <p>You only have <b><span id="_remain_sec_MD006521'.$r_report_alert['id'].'" rel="'.$rel_time_report.'" data_id="'.$user_id.'" data_time="'.$r_report_alert['date'].'" mode = "3"  class="approve_remaining_time"></span></b> to remove report of this account. Please contact Admin for more information.</p>
                                        </div></div></div>';
                                echo '<script type="text/javascript" src="'.$url_local.'/js/countdown_report.js"></script>';
                            }
                            if( ($r_report_alert['mode'] == 2 && !empty($r_report_alert['file'])) || ($r_report_alert['mode'] == 2 && !empty($r_report_alert['btc_address'])) ){
                                echo '<div class="row"><div class="col-md-12"><div class="alert alert-info" role="alert">
                                        <i class="fa fa-info-circle fa-2x pull-left" aria-hidden="true"></i>
                                        <p>Your request to unfreeze your account is being processed by Admin!</p>
                                    </div></div></div>';
                            }
                            if( $r_report_alert['mode'] == 2 && empty($r_report_alert['file']) && empty($r_report_alert['btc_address']) ){
                                echo '<div class="row"><div class="col-md-12"><div class="alert alert-info alert-report">
                                          <i class="fa fa-exclamation-triangle fa-5x pull-left" aria-hidden="true"></i> <strong>This account is being frozen!</strong>
                                          <p>You only have <span id="_remain_sec_MD006521'.$r_report_alert['id'].'" rel="'.$rel_time_frozen.'" data_id="'.$user_id.'" data_time="'.$r_report_alert['frozen_time'].'" mode = "2"  class="approve_remaining_time"></span> to remove freeze of this account.</p>
                                          <p>Unfreeze Your Account Now</p>
                                          <a  href="index.php?page=remove_block&mode=2"> Unfreeze <i class="fa fa-unlock" aria-hidden="true"></i> </a>
                                        </div></div></div>';
                                echo '<script type="text/javascript" src="'.$url_local.'/js/countdown_report.js"></script>';
                            }
                            if( ($r_report_alert['mode'] == 3 && !empty($r_report_alert['file'])) || ($r_report_alert['mode'] == 3 && !empty($r_report_alert['btc_address'])) ){
                                echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger" role="alert">
                                        <i class="fa fa-info-circle fa-2x pull-left" aria-hidden="true"></i>
                                        <p>Your request to unblock your account is being processed by Admin!</p>
                                    </div></div></div>';
                            }
                            if( $r_report_alert['mode'] == 3 && empty($r_report_alert['file']) && empty($r_report_alert['btc_address']) ){
                                echo '<div class="row"><div class="col-md-12"><div class="alert alert-danger alert-report">
                                          <i class="fa fa-exclamation-triangle fa-5x pull-left" aria-hidden="true"></i> <strong>This account being blocked!</strong>
                                          <p>Unblock Your Account Now!</p>
                                          <a class="btn btn-info" href="index.php?page=remove_block&mode=3">Unblock <i class="fa fa-unlock" aria-hidden="true"></i></a>
                                        </div></div></div>';
                            }
                        }
                    }

                    //nếu không bị report hay block
                    $query_report = mysql_query("SELECT * FROM report WHERE reported = $user_id AND (mode = 1 OR mode = 3) ");
                    if (mysql_num_rows($query_report) > 0){
                    }else{
                            $que_repd = mysql_query("SELECT * FROM tb_repd WHERE user_id = $user_id AND gd_id <> 0 AND pd_id = 0");
                            if (mysql_num_rows($que_repd) > 0){
                                while($row_repd = mysql_fetch_array($que_repd)){
                                    $query_usr = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
                                    $row_usr = mysql_fetch_array($query_usr);
                                    if($row_usr['level'] > 1){
                                        $query_gd_limit = mysql_query("SELECT * FROM re_pd_time WHERE level = ".$row_usr['level']." ");
                                        $row_gd_limit   = mysql_fetch_array($query_gd_limit);
                                        $rel_time_repd = (strtotime($row_repd['gd_time']) + $row_gd_limit['hour']*3600) - time();
                                ?>
                                <?php
                                }}
                                echo '<script type="text/javascript" src="'.$url_local.'/js/countdown_repd.js"></script>';
                            }

                    }
                ?>
                <div>

                    <?php
                    if($_SESSION['ebank_user_freeze_mode'] != 1){ ?>
                    <div class="box-header">
                        <i class="fa <?=$icon;?>"></i>
                        <h3 class="box-title"><?=$menu_title?></h3>
                    </div>
                    <?php } ?>

                    <!-- alert country for user -->
                    <?php 
                    $q_user_pre = mysql_query("SELECT * FROM users WHERE id_user = $user_id ");
                    $r_user_pre = mysql_fetch_array($q_user_pre);
                    $country    = $r_user_pre['country'];
                    if(!empty($country)){
                        $q_country  = mysql_query("SELECT * FROM location WHERE location_id = $country");
                        $r_country  = mysql_fetch_array($q_country);
                    ?>
                    <div class="alert alert-success" style="background-color:#2394F2 !important;border-color:#2394F2">    
                        <img width="30" class="img-circle" src="<?=$url_local;?>/images/locations/<?=$r_country['flag']?>">
                        Hi <?=$r_user_pre['username']?>, you are on vWallet site.. We are delighted to have you on board.
                    </div>
                    <?php }?>
                    <!-- End /alert country for user -->

                    <div class="box-body pad" id="middle_data">
                        <?php
                        if($_SESSION['ebank_user_freeze_mode'] != 1 and $_SESSION['ebank_user_block_mode'] != 1)
                        {
                            $file = $val.".php";
                            if ($val == '')
                            { include("data/welcome.php"); }
                            else
                            { include("data/".$file); }
                        }
                        elseif($_SESSION['ebank_user_freeze_mode'] == 1){ include 'data/unfreeze.php'; }
                        elseif($_SESSION['ebank_user_block_mode'] == 1){ include 'data/unblock.php'; }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>