<div class="modal fade" id="dialog-confirm-confirm">
	<div class="modal-dialog">
	<form id="approve_pdgd_form" action="index.php?page=welcome_action" method="post" enctype="multipart/form-data">
	<fieldset>
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-green" id="hierarchy_title">Confirm Confirmation</h3>
			</div>
			<div class="modal-body">
				After you sending the payment to the receiver, please upload a payment receipt then click confirm. The receiver will use the receipt to verify your payment.<br><br>You can 
also use the Chat function to let the receiver know about your payment.<br><br>
				<div id="confirm_upload_images_div">
					<div id="confirm_message_div" class="messageWrap"></div>
					<div id="confirm_message_foot">
						<div id="confirm_upload">
							<div class="btn-group btn-group-sm" id="confirm_upload_clone">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="input-group">
										<div class="form-control col-md-3" style="height:40px;">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview"></span>
										</div>
										<span class="input-group-btn">
											<input class="btn btn-inverse" name="payment_receipt" type="file">
											<!--<span class="btn btn-default btn-sm btn-file">
												<span class="fileupload-new">Select File</span>
												<span class="fileupload-exists">Change File</span>
												<input class="btn btn-inverse" name="payment_receipt" type="file">
											</span>-->
											<!--<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>-->
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer text-left" id="confirm_cancel_btn" style="text-align:left;">
				<input name="confirm_mdid" type="hidden">
				<input id="btn_approve_donation" class="btn btn-success btn-sm" value="Confirm" type="submit" name="Submit">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
				
			</div>
		</div>
	</fieldset>
	</form>
	</div>
</div>