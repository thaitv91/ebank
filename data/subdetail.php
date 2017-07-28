<?php
error_reporting(0);
session_start();
include("../condition.php");
include("../config.php");
include("../function/functions.php");
$user_id = $_SESSION['ebank_user_id'];
$id = $_REQUEST['id'];

//$sql = "SELECT * FROM investment_request WHERE id = '$id' ";
$sql = "SELECT t1.* , t2.mode as int_mode FROM investment_request t1 left join 
		income_transfer t2 on t1.id = t2.investment_id 
		WHERE t1.user_id = '$user_id' and t1.id = '$id' ";
$query = mysql_query($sql);
while($row = mysql_fetch_array($query))
{
	$ids = $row['id'];
	$user_id = $row['user_id'];
	$amount = $row['amount'];
	$date = $row['date'];
	$mode = $row['mode'];
	$int_mode = $row['int_mode'];
	$date = date('d-m-Y', strtotime($date));
	$name = ucfirst(get_full_name($user_id));
	
	if($mode == 1){ $msgs = "Request processed."; }
	elseif($mode == 0 and $int_mode == 0){ $msgs = "Request in Processing."; }
	elseif($mode == 0 and $int_mode == 1){ $msgs = "Request Pending."; }
	elseif($mode == 0 and $int_mode == 2){ $msgs = "Request Confirmed."; }
}

?>
<div class="window subdetail" style="width: 888px; text-align:left;">
	<div class="panel-header panel-header-noborder window-header">
		<div class="panel-title">Detailed information about order</div>
		<div class="panel-tool">
			<a class="panel-tool-close" href="javascript:void(0)" onclick="javascript:close_popup()"></a>
		</div>
	</div>
	<div id="order_info" style="overflow: hidden; height: 465px;" title="" class="panel-body panel-body-noborder window-body">
		<div class="panel">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 10px;overflow: auto; height: 408px;" title="">
				<div id="orderid">
					<div class="ordout true" id="help_detail" style="cursor: pointer; width:270px;">
					<table width="100%" border="0" cellpadding="0" cellspacing="6">
						<tbody>
						<tr>
							<td class="ord_title">
								<span class="translate">Request to Provide Help</span><br>
								<span class="order_out_id">CH292575<?=$ids;?></span>
							</td>
							<td width="32"><img src="images/strelka_32.png" height="32" width="32"></td>
						</tr>
						<tr>
							<td colspan="2" class="ord_body">
								<span class="translate">Participant</span>: 
								<span class="order_out_fio"><?=$name;?></span><br>
								<span class="translate">Amount</span>: 
								<span class="order_out_amount"><?=$amount;?></span>
								<span class="order_out_currency"> $ </span><br>
								<span class="translate">Remaining Amount</span>: 
								<span class="order_out_amount"> <?=$amount;?></span>
								<span class="order_out_currency"> $ </span><br>
								<span class="translate">Date</span>: 
								<span class="order_out_date"><?=$date;?></span><br>
								<span class="translate">Status</span>: 
								<span class="order_out_status"><?=$msgs;?></span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<a onclick="javascript:getsub_detail(this)" data="13203" cs="W" class="cursor neoui-greybutton translate" style="float: right;">Details&gt;&gt;</a>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
				</div>
				<div id="elaunchid"></div>
				<h3>Orders list</h3><h3></h3>
			</div>
		</div>
	</div>
	<div id="order_info_buttons" iconcls="icon-info" class="dialog-button">
		<a href="#" class="easyui-linkbutton l-btn" onclick="javascript:close_popup()">
			<span class="l-btn-left">
				<span class="l-btn-text">
					<span class="l-btn-text icon-cancel" style="padding-left: 20px;">Close</span>
				</span>
			</span>
		</a>
	</div>
</div>
