<?php
session_start();
include("condition.php");
require_once("function/functions.php");
include("function/setting.php");
$id = $user_id = $_SESSION['ebank_user_id'];

$curr_amnt = get_wallet_amount($user_id);
$min_wid = $minimum_withdrawal;
$max_wid = $maximum_withdrawal;
?>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">                                 
// we will add our javascript code here
jQuery(document).ready(function($) {

	$("#wallet_withdraw").submit(function() {
		var str = $(this).serialize();
		var url = $(this).attr("action");
		//alert(url);

		$.ajax({
			type: "POST",
			url: url,
			data: str,
			success: function(msg) {
    			
			$("#msg_withdraw_success").html(msg);
			$('.gethelp').fadeOut();
			$('.withdraw_success').fadeIn('slow');
				
			}
		});
		return false;
	});
});
</script>
<div class="window gethelp" style="width: 488px; left: 433px;">
	<div class="panel-header panel-header-noborder window-header" style="width: 485px; text-align:left;">
		<div class="panel-title">Withdraw</div>
		<div class="panel-tool">
<a class="panel-tool-close" onclick="javascript:close_popup()"></a>
</div>
	</div>
	<div class="panel-body panel-body-noborder window-body" style="overflow: hidden;">
		<div class="panel">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 30px; overflow: auto; text-align:left;" title="">
			<?php
			$query_mode = mysql_query("select * from income where user_id = '$id' and total_amount > 0");
			while($rows = mysql_fetch_array($query_mode))
			{
				$inv_mode = $rows['mode'];
			}
			
			$query_mode1 = mysql_query("select * from income_transfer where user_id = '$id' and mode != 2");
			
			$var_te = mysql_num_rows($query_mode1);
			$sql = "select * from income_transfer where paying_id = '$id' and mode != 2";
			$query_mode2 = mysql_query($sql);
			
			$var_te1 = mysql_num_rows($query_mode2);
			
			$sql_2 = "SELECT * FROM `investment_request` WHERE `user_id`='$id' and mode = 1";
			$query_2 = mysql_query($sql_2);
			$query_cnt_2 = mysql_num_rows($query_2);
						
			if($inv_mode == 1 or $var_te > 0 or $var_te1 > 0 or $query_cnt_2 > 0)	
			{
				print "<p style=\"color:#BC0007\">Last Withdrawal is Not Yet Completed or There should not any pending get help and send help. or you are getting link for send payment shortly .<br /><br /></p>";
			}
			else
			{ ?>
			<form action="data/get_help1.php" id="wallet_withdraw" method="post">
				<input type="hidden" name="curr_amnt" value="<?=$curr_amnt; ?>"  />
				Withdraw Currency : 
					<select name="currency">
						<option value="1">$ </option>
					</select><br>
				Minimum Withdraw : <?=$min_wid;?><br>
				Maximum Withdraw : <?=$max_wid;?><br>
				Multiply Amount By &nbsp; : <?=$min_wid;?><br>
				Your Wallet Balance : <?=$curr_amnt;?><br />
				<table>
					<tbody>
					<tr>
						<td>Total Withdraw Amount :</td>
						<td>
							<select name="request" style="width:100px;">
							<?php
								for($i = $min_wid;$i <= $max_wid; $i = $i+($min_wid))
								{ ?><option><?=$i;?></option><?php }?>	
							</select>
						</td>
					</tr>
					<tr>
						<td>Enter Code No. - <span style="color:Red;">1</span></td>
						<td><input type="password" name="sec_code" required /></td>
					</tr>
					</tbody>
				</table><br>
				<span id="spnerror" style="color: Red"></span><br><br><br>
				<div class="wizard_actions">&nbsp;
					<a class="easyui-linkbutton l-btn panel-tool-close" onclick="javascript:close_popup()"><span class="l-btn-left"><span class="l-btn-text"><span class="l-btn-text icon-cancel" style="padding-left: 20px;">Cancel</span></span></span></a>&nbsp;
					
					<input type="submit" name="submit" value="Withdraw" class="success" />
					&nbsp;&nbsp; &nbsp; 
					<a class="easyui-linkbutton l-btn" id="get_code_list" href="data/get_code_list.php">
						<span class="l-btn-left">
							<span class="l-btn-text">
								<span class="l-btn-text icon-ok" style="padding-left: 20px;">
									Get Code List 
								</span>
							</span>
						</span>
					</a>
				</div>
				</form>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>

<div class="window withdraw_success" style="width: 488px; left: 452px; top: 200px;">
	<div class="panel-header panel-header-noborder window-header" style="width: 888px; text-align:left;">
		<div class="panel-title">Withdraw Info </div>
	</div>
	<div class="panel-body panel-body-noborder window-body" style="overflow: hidden;">
		<div class="panel">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 30px;overflow: auto; text-align:left;" title="">
				
				<br>
				<span id="msg_withdraw_success"></span><br><br><br>
				
				<div class="wizard_actions">
					<a class="easyui-linkbutton l-btn panel-tool-close" onclick="javascript:close_popup()"><span class="l-btn-left"><span class="l-btn-text"><span class="l-btn-text icon-cancel" style="padding-left: 20px;">Close</span></span></span></a>
				</div>
			</div>
		</div>
	</div>
</div>