<?php
session_start();
include("condition.php");
require_once("function/functions.php");
include("function/setting.php");
$user_id = $_SESSION['ebank_user_id'];
$curr_amnt = get_wallet_amount($user_id);
?>
<div class="window gethelp" style="width: 488px; left: 433px;">
	<div class="panel-header panel-header-noborder window-header" style="width: 888px; text-align:left;">
		<div class="panel-title">Withdraw</div>
	</div>
	<div class="panel-body panel-body-noborder window-body" style="overflow: hidden;">
		<div class="panel">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 30px; overflow: auto; text-align:left;" title="">
				Withdraw Currency : - 
					<select name="currency">
						<option value="1">$ </option>
					</select><br>
				Minimum Withdraw : <?=$minimum_withdrawal;?><br>
				Maximum Withdraw : <?=$maximum_withdrawal;?><br>
				Multiply By : <?=$minimum_withdrawal;?><br>
				<table>
					<tbody>
					<tr>
						<td>Wallet Balance :</td>
						<td><?=$curr_amnt;?></td>
					</tr>
					<tr>
						<td>Total Withdraw Amount :</td>
						<td><input id="txtgwallet" type="text"></td>
					</tr>
					<tr>
						<td>Enter Code No. - <span style="color:Red;">1</span></td>
						<td><input id="txtcodenow" type="password"></td>
					</tr>
					</tbody>
				</table><br>
				<span id="spnerror" style="color: Red"></span><br><br><br>
				<div class="wizard_actions">&nbsp;
					<a class="easyui-linkbutton l-btn panel-tool-close" onclick="javascript:close_popup()"><span class="l-btn-left"><span class="l-btn-text"><span class="l-btn-text icon-cancel" style="padding-left: 20px;">Cancel</span></span></span></a>&nbsp;
					
					<input type="submit" name="submit" value="Withdraw" class="success" />
					<!--<a class="easyui-linkbutton l-btn" onclick="javascript:Withdraw_Get_Help()"><span class="l-btn-left"><span class="l-btn-text"><span class="l-btn-text icon-ok" style="padding-left: 20px;">Withdraw </span></span></span></a>-->&nbsp;&nbsp; &nbsp; 
					<a class="easyui-linkbutton l-btn" onclick="javascript:getcodelist()"><span class="l-btn-left"><span class="l-btn-text"><span class="l-btn-text icon-ok" style="padding-left: 20px;">Get Code List </span></span></span></a>
				</div>
			</div>
		</div>
	</div>
</div>