<?php 
	$id = $_SESSION['ebank_user_id'];
	$mode=$_GET['mode'];

	//get max time block/frozen in db
	$sql_max_time = mysql_query("SELECT max(time) as maxtime FROM tb_block_fee");
	$row_max_time = mysql_fetch_array($sql_max_time);
	$maxtime = $row_max_time['maxtime'];

	if($mode == 3 ){ //blocked
		$title_box = 'Unblock Account';
		//get time blocked
		$q_user = mysql_query("SELECT * FROM users WHERE id_user = ".$id."");
		$r_user = mysql_fetch_array($q_user);
		$user_code = $r_user['user_pin'];
		$time_block = $r_user['block_time'];
		$time = $time_block;

		if($time_block < $maxtime){
			//get tb_time_report
			$sql_block_fee = mysql_query("SELECT * FROM tb_block_fee WHERE time = ".$time_block."");
			$row_block_fee = mysql_fetch_array($sql_block_fee);

			$amount = $row_block_fee['block'];
		}else{
			//get tb_time_report
			$sql_block_fee = mysql_query("SELECT * FROM tb_block_fee WHERE time = ".$maxtime."");
			$row_block_fee = mysql_fetch_array($sql_block_fee);

			$amount = $row_block_fee['block'];
		}
		
	}
	if($mode == 2 ){ //blocked
		$title_box = 'Unfreeze Account';
		//get time blocked
		$q_user = mysql_query("SELECT * FROM users WHERE id_user = ".$id."");
		$r_user = mysql_fetch_array($q_user);
		$user_code = $r_user['user_pin'];
		$time_frozen = $r_user['frozen_time'];
		$time = $time_frozen;

		if($time_frozen < $maxtime){
			//get tb_time_report
			$sql_block_fee = mysql_query("SELECT * FROM tb_block_fee WHERE time = ".$time_frozen."");
			$row_block_fee = mysql_fetch_array($sql_block_fee);

			$amount = $row_block_fee['frozen'];
		}else{
			//get tb_time_report
			$sql_block_fee = mysql_query("SELECT * FROM tb_block_fee WHERE time = ".$maxtime."");
			$row_block_fee = mysql_fetch_array($sql_block_fee);

			$amount = $row_block_fee['frozen'];
		}
		
	}
	
?>
<div class="box box-primary">
<div id="wrap">
<div class="col-md-12">
<p></p>
				<?php 
				if($mode == 2 )
				{ 
					echo '<p>Your account has been frozen '.$time.' time(s). You have to pay '.number_format($amount).' VND to unfreeze it.</p>';
				}
				if($mode == 3 )
				{
					echo '<p>Your account has been blocked '.$time.' time. You have to pay '.number_format($amount).' VND to unblock it.</p>';
				}
				?>	
</div>
	<div id="wrap">

	    <div class="payment-method" id="payment_method">

		  	<!-- Nav tabs -->
		  	<ul class="nav nav-tabs" role="tablist">
		  		<li role="presentation" class="active-home"><a><b>Payment Method</b></a></li>
		    	<li role="presentation" class="active"><a href="#wallet" aria-controls="home" role="tab" data-toggle="tab">Pay using your wallet</a></li>
		    	<li role="presentation"><a href="#epin" aria-controls="profile" role="tab" data-toggle="tab">Pay using Bitcoin</a></li>
		  	</ul>

		  	<!-- Tab panes -->
		  	<div class="tab-content">

		  		<!-- WALLET -->
		    	<div role="tabpanel" class="tab-pane fade in active" id="wallet">
		    		<?php 
		    		$q_wallet = mysql_query("SELECT * FROM wallet WHERE id = ".$id."");
		    		$r_wallet = mysql_fetch_array($q_wallet);
		    		$main_wallet = $r_wallet['amount'];
		    		$comm_wallet = $r_wallet['com_wallet'];
		    		$sum_amount = $main_wallet + $comm_wallet;

		    		if($sum_amount < $amount){
						echo '<p></p><p>&nbspYour wallet balance is not enough!</p><p></p>';
		    		}else{
		    			// main_wallet đủ tiền
		    			if($main_wallet >= $amount ){
		    		?>
		    		<div class="col-md-6 col-sm-8 col-xs-12">
		    			<table class="table">
							<tr><th scope="row">Main Wallet</th> <td align="right"><?=number_format($main_wallet)?></td></tr>
							<tr><th scope="row">Deduct</th> <td align="right"><?=number_format($amount)?></td></tr>
							<tr><th scope="row">Main Wallet (after deduction)</th> <td align="right"><?=number_format($main_wallet-$amount)?></td></tr>
						</table>

							<div class="col-md-5 col-sm-6 col-xs-12">
								<label class="form-label">Security Code:</label>
							</div>
							<div class="col-md-5 col-sm-6 col-xs-12">
								<input id="mw_code" name="txt_code" class="form-control" style="width:100%;">
								<p class="alert-mw-code text-red"></p>
							</div>
							<div class="col-md-2 col-sm-6 col-xs-12">
								<a href="javascript:;" id="btn_mw_payment" mode="<?=$mode?>" class="btn btn-info">Submit</a>
							</div>

					</div>	
		    		<?php 
		    			}else{
		    			//main_wallet không đủ tiền, trừ thêm comm_wallet
		    		?>
	    			<div class="col-md-6 col-sm-8 col-xs-12">
		    			<table class="table">
							<tr><th scope="row">Main Wallet</th> <td align="right"><?=number_format($main_wallet)?></td></tr>
							<tr><th scope="row">Commission Wallet</th> <td align="right"><?=number_format($main_wallet)?></td></tr>
							<tr><th scope="row">Deduct</th> <td align="right"><?=number_format($amount)?></td></tr>
							<tr><th scope="row">Main Wallet (after deduction)</th> <td align="right"><?=number_format($comm_wallet+$main_wallet-$amount)?></td></tr>
						</table>
						
							<div class="col-md-4 col-sm-6 col-xs-12">
								<label>Security Code:</label>
							</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
								<input id="mw_code" name="txt_code" class="form-control" style="width:100%;">
								<p class="alert-mw-code text-red"></p>
							</div>
							<div class="col-md-2 col-sm-6 col-xs-12">
								<a href="javascript:;" id="btn_mw_payment" mode="<?=$mode?>" class="btn btn-info">Submit</a>
							</div>
						
					</div>	
		    		<?php
		    			}
		    		}
		    		?>
					<div style="clear:both"></div>
		    	</div>
		    	<!-- END / WALLET -->

		    	<!-- BITCOIN -->
		    	<div role="tabpanel" class="tab-pane fade" id="epin">
		    		<div id="mining_profit_crypt_conv" style="display:none;">
			            <span class="crypt-side dis-inl">
			                <input class="val_btc val-crypt" type="text" value="-">
			                <span class="cr-label dis-inl">BTC</span></span>
			            <span class="equal-course">=</span><span class="course-side dis-inl">
			                <input class="val_course val-crypt" type="text" id="btcusd" value="---">
			            </span>
			        </div>
			        <p></p>
			        <form class="form-inline" style="margin:15px 0;">
					<div class="col-md-12">
			        	<div class="form-group">
					    	<label for="exampleInputName2">You have to pay: </label>
					    </div>
					    <div class="form-group">
							<input type="text" class="form-control" id="payment_usd" value="<?=number_format($amount/22400,2)?>" disabled>
					    	<label for="exampleInputName2">USD = </label>
					    </div>
					    <div class="form-group">
					    	<input type="text" class="form-control" id="payment_bit" disabled>
					    	<label for="exampleInputEmail2">BITCOIN</label>
					    </div>
						
					</div>
					<div style="clear:both"></div>					
					</form>
					<p></p>
					<form class="form-inline">
					<div class="col-md-12">
					    <div class="form-group" style="margin-right:15px;">
							<label for="exampleInputName2">Security Code: </label>
					    	<input type="text" class="form-control" id="security_code">
					    </div>
					    <div class="form-group">
					    	<a href="javascript:;" class="btn btn-info" id="btn_bit_payment">Submit</a>
					    </div>
						
					</div>	
					<div style="clear:both"></div>
					</form>
					<div class="col-md-12" style="margin-bottom:15px;"><p class="alert_security_code text-red"></p></div>
					<p></p>
					<div style="clear:both"></div>
		    	</div>
		    	<!-- END / BITCOIN -->
				<div style="clear:both"></div>
		  	</div>

		</div>

	</div> 
</div>
</div>
<script type="text/javascript">
	$('#payment_method').tab('show')
</script>
<script type="text/javascript">
	$('#btn_mw_payment').click(function(){
		var amount = <?=$amount?>;
		var id     = <?=$id?>;
		var mode     = <?=$mode?>;
		var user_code = <?=$user_code?>;
		var input_code= $('#mw_code').val();
		if(!input_code){
			$('.alert-mw-code').html('Please enter Security Code!');
			$('#mw_code').focus();
			return false;
		}
		else if(input_code != user_code){
			$('.alert-mw-code').html('Security Code wrong!');
			$('#mw_code').focus();
			return false;
		}else{
			$.ajax({
	            url : "/ajax_call/pay_wallet_unblock.php",
	            type : "post",
	            dateType:"html",
	            data : 'id='+id+'&amount='+amount+'&mode='+mode,
	            success : function (result){
	            	if(result){
	            		window.location.href = 'https://<?=$_SERVER["HTTP_HOST"]?>';
	            		//location.reload(); 
	            	}
	            }
	        });
		}
		
	})
</script>

<script type="text/javascript">
$('#payment_method .nav li a').click(function(){
	
	var con_bit = $('input.val_course.val-crypt').val();
	var usd     = $('#payment_usd').val();
	var bit     = parseInt(usd) / parseInt(con_bit);
	$('#payment_bit').val(bit.toFixed(4));
})
</script>

<script type="text/javascript">
	$('#btn_bit_payment').click(function(){
		var amount = <?=number_format($amount/22400,2)?>;
		var id     = <?=$id?>;
		var mode     = <?=$mode?>;
		var bitcoin   = $('#payment_bit').val();
		var user_code = <?=$user_code?>;
		var input_code= $('#security_code').val(); 
		if(!input_code){
			$('.alert_security_code').html('Please enter Security Code!');
			$('#security_code').focus();
			return false;
		}
		else if(input_code != user_code){
			$('.alert_security_code').html('Security Code wrong!');
			$('#security_code').focus();
			return false;
		}else{
			$.ajax({
	            url : "/ajax_call/pay_bitcoin_unblock.php",
	            type : "post",
	            dateType:"html",
	            data : 'id='+id+'&amount='+amount+'&bitcoin='+bitcoin+'&mode='+mode,
	            success : function (result){
	            	if(result){
	            		//location.reload(); 
	            		window.location.replace("/index.php?page=confirm_block&id="+result);
	            	}
	            }
	        });
		}
		
	})
</script>

<style>
.table>tbody>tr>td, .table>tbody>tr>th{padding:10px;}
</style>
