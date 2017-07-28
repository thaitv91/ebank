<div class="modal fade" id="dialog-confirm-confirm">
	<div class="modal-dialog">
	<form id="approve_pdgd_form" action="index.php?page=welcome_action" method="post" enctype="multipart/form-data">
	<fieldset>
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="hierarchy_title">Confirm Confirmation</h3>
			</div>
			<div class="modal-body">
				Are you sure you want to confirm the match PDGD?<br><br>
				For the security of fund transfer, system add upload feature to 
				upload the payment proof, user can direct click the confirm or upload 
				files and click confirm also can.<br><br>At GD user side, when they click approve, 
				they can see the payment proof that PD user upload!<br><br>
				<div id="confirm_upload_images_div">
					<div id="confirm_message_div" class="messageWrap"></div>
					<div id="confirm_message_foot">
						<div id="confirm_upload">
							<div class="btn-group btn-group-sm" id="confirm_upload_clone">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<div class="input-group">
										<div class="form-control col-md-3">
											<i class="fa fa-file fileupload-exists"></i> 
											<span class="fileupload-preview"></span>
										</div>
										<span class="input-group-btn">
											<span class="btn btn-default btn-sm btn-file">
												<span class="fileupload-new">Select File</span>
												<span class="fileupload-exists">Change File</span>
												<input class="btn btn-inverse" name="payment_receipt" type="file">
											</span>
											<!--<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>-->
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer" id="confirm_cancel_btn">
				<input name="confirm_mdid" type="hidden">
				<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
				<input id="btn_approve_donation" class="btn btn-primary btn-sm" value="Confirm" type="submit" name="Submit">
			</div>
		</div>
	</fieldset>
	</form>
	</div>
</div>