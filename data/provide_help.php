<?php
session_start();
include("condition.php");
require_once("function/functions.php");
include("function/setting.php");
$member_id = $_SESSION['ebank_user_id'];
?>

<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">                                 
// we will add our javascript code here
jQuery(document).ready(function($) {

	$("#wallet_submit").submit(function() {
		var str = $(this).serialize();
		var url = $(this).attr("action");
		//alert(url);

		$.ajax({
			type: "POST",
			url: url,
			data: str,
			success: function(msg) {
    			
			$("#msg_submit").html(msg);
			$('.deposite_amount').fadeOut();
			$('.deposit_success').fadeIn('slow');
				
			}
		});
		return false;
	});
});
</script>

<script type="text/javascript">                                 
jQuery(document).ready(function($) {

	$("#get_code_list").click(function() {
		var str = $(this).serialize();
		var url = $(this).attr("href");
		//alert(url);

		$.ajax({
			type: "POST",
			url: url,
			data: "",
			success: function(msg) {
    			
			$("#msg_submit").html(msg);
			$('.deposite_amount').fadeOut();
			$('.deposit_success').fadeIn('slow');
				
			}
		});
		return false;
	});
});
</script>

<div class="window provide_term" id="provide_term_id" style="width: 488px; left: 452px; top: 200px;">
	<div class="panel-header panel-header-noborder window-header" style="width:888px; text-align:left;">
		<div class="panel-title">Add Request</div>
	</div>
	<div class="panel-body panel-body-noborder window-body" style="overflow: hidden;">
		<div class="panel">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 30px;overflow: auto; text-align:left;" title="">
				I read the THE WARNING, and I fully understand all the risks. I make decision to
				participate in Cdbv being of sound mind and memory.
				<br><br>
				<input id="chkterm" type="checkbox"> Accept<br>
				<br>
				<span id="spnterms" style="color: Red"></span>
				<br>
				<div class="wizard_actions">
					<a class="easyui-linkbutton l-btn panel-tool-close" onclick="javascript:close_popup()"><span class="l-btn-left"><span class="l-btn-text"><span class="l-btn-text icon-cancel" style="padding-left: 20px;">Cancel</span></span></span></a>&nbsp; <a class="easyui-linkbutton l-btn" onclick="javascript:Provide_help_Term_Next()"><span class="l-btn-left"><span class="l-btn-text"><span class="l-btn-text icon-ok" style="padding-left: 20px;">Next</span></span></span></a>
				</div>
			</div>
		</div>
	</div>
</div>
	
<div class="window deposite_amount" style="width: 588px; left: 420px; top: 190px;">
	<div class="panel-header panel-header-noborder window-header" style="width: 588px;">
		<div class="panel-title">
			Commitment</div>
	</div>
	<div class="panel-body panel-body-noborder window-body" style="overflow: hidden;">
		<div class="panel">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 30px;overflow: auto;" title="">
				<form action="data/provide_help1.php" id="wallet_submit" method="post">
				<table>
					<tbody>
					<tr>
						<td>Enter Deposit Amount :</td>
						<td>
							<select name="request">
							<?php
							for($i = $setting_inv_amount; $i <= $setting_inv_end_amount; $i = $i+$setting_inv_amount)
							{ ?>
								<option <?php if($request_amount == $i) { ?> selected="selected" <?php } ?> value="<?=$i; ?>"><?=round($i/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$i; ?> 	
									<font color=dark>$ </font>
								</option>
					<?php	} ?>				
							</select>
							
							<!--<input value="" name="ctl00$ContentPlaceHolder1$txtamount" id="ContentPlaceHolder1_txtamount" type="text">
							&nbsp;-->
						</td>
						<td>
							<!--<span id="ContentPlaceHolder1_lblctype">$ </span>-<span id="ContentPlaceHolder1_lblm">Indian Rupees</span>-->
						</td>
					</tr>
					<tr>
						<td colspan="3">
							<span>
								Enter Minimum $  Amount 1000 ,Maximum 50000 and Multiply With 1000 $ 
							</span>
						</td>
					</tr>
					<tr>
						<td>Select Growth :</td>
						<td>
							<select name="growth">
								<option value="60">60% Growth </option>
							</select>
						</td>
					</tr>
					<tr>
						<td>Enter Code No. -<span style="color:Red;">1</span></td>
						<td><input type="password" name="sec_code" required /></td>
					</tr>
					</tbody>
				</table><br>
				<br><br><br>
				<div class="wizard_actions">
				<a class="easyui-linkbutton l-btn panel-tool-close" onclick="javascript:close_popup()">
						<span class="l-btn-left">
							<span class="l-btn-text">
								<span class="l-btn-text icon-cancel" style="padding-left: 20px;">
									Cancel
								</span>
							</span>
						</span>
					</a>&nbsp;
					
					<!--<span class="l-btn-left">
						<span class="l-btn-text">
							<span class="l-btn-text icon-ok" style="padding-left: 20px;">
								Submit
							</span>
						</span>
					</span>-->
					<input type="submit" name="Submit" value="Submit" class="success" />
					&nbsp; &nbsp; &nbsp; 
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
			</div>
		</div>
	</div>
</div>

<div class="window deposit_success" style="width: 488px; left: 452px; top: 200px;">
	<div class="panel-header panel-header-noborder window-header" style="width: 888px;">
		<div class="panel-title">Help Info </div>
	</div>
	<div class="panel-body panel-body-noborder window-body" style="overflow: hidden;">
		<div class="panel">
			<div class="dialog-content panel-body panel-body-noheader panel-body-noborder" style="padding: 30px;overflow: auto; text-align:left;" title="">
				
				<br>
				<span id="msg_submit"></span><br><br><br>
				
				<div class="wizard_actions">
					<a class="easyui-linkbutton l-btn panel-tool-close" onclick="javascript:close_popup()"><span class="l-btn-left"><span class="l-btn-text"><span class="l-btn-text icon-cancel" style="padding-left: 20px;">Close</span></span></span></a>
				</div>
			</div>
		</div>
	</div>
</div>