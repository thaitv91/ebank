
<div class="modal fade" id="dialog-approve-confirm">
	<div class="modal-dialog">
	<form id="approve_pdgd_form" method="post" action="index.php?page=welcome_action">
		<fieldset>
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="hierarchy_title">Transaction Confirmation</h3>
				</div>
				<div class="modal-body">
					Are you sure that you want to approve this transaction?	
					<div id="approve_message_div" class="messageWrap"></div>
					<!--<div class="innerMessage message-toggle">
							<div class="fullMessage clearfix">
								<div class="pull-left"><strong class="blue"><?=$name;?></strong></div>
								<div class="pull-right calendar ml5">
									<i class="fa fa-calendar mr5"></i>
									<span class="title-date"><?=date('d M Y H:i:s A');?></span>
								</div>
								<div class="clearfix"></div>
								<div class="mt5">
									<p class="nm">Siblings please turn PDF into account Hang it this VCB: Vietcombank Nguyen Thi Thuy Trang Phan Thiet CN 062 100 040 6337 Thank you sister much, she wished him to go very much and received so much.</p>
									<a id="show_message_image" class="" data-toggle="modal" data="images/payment_receipt/<?=$payment_receipt;?>" href="#dialog-photo">
										<img width="100px" height="100px" src="images/payment_receipt/<?=$payment_receipt;?>">
									</a>
								</div>
							</div>
						</div>-->
				</div>
				<div class="modal-footer" id="approve_cancel_btn" style="text-align: left;">
					<input name="approve_mdid" type="hidden">
					<input name="invst_id" type="hidden">
					<input id="btn_approve_donation" class="btn btn-success btn-sm" value="Confirm" type="submit" name="Accept">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
					
				</div>
			</div>
		</fieldset>
		</form>
	</div>
</div>


