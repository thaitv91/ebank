<div class="modal fade" id="dialog-report-confirm">
	<div class="modal-dialog">
		<form id="report_pdgd_form" enctype="multipart/form-data" method="post">
		<input name="__req" value="8" type="hidden">
		<input name="__nonce" value="cefcec9360f913f57c5691af38a1e49f1e16785d3e3541c2503dfe5263f60aa0" type="hidden">
		<input name="report_uid" type="hidden">
		<input name="report_mdid" type="hidden">
		<fieldset>
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="hierarchy_title">Report Confirmation</h3>
				</div>
				<div class="modal-body">
					<p>Please Provide the reason on why you wish to report the match pdgd.</p>
					<label>Option :</label>
					<select class="form-control" name="report_reason">
													<option selected="selected" value="">Please Select</option>
													<option value="1">Paid, but GD user no approved</option>
													<option value="2">Invalid Bank Info</option>
													<option value="3">Invalid Contact Number</option>
													<option value="6">Others</option>
											</select>
					<span id="report_reason_err_text" class="error"></span><br>
					<label>Message :</label>
					<textarea class="form-control form-control-text-area" placeholder="Reply here..." name="report_message" rows="4"></textarea>
					<div id="confirm_upload_images_div">
						<div id="confirm_message_div" class="messageWrap"></div>
						<div id="confirm_message_foot">
							<div id="report_upload">
								<div class="btn-group btn-group-sm" id="confirm_upload_clone">
									<div class="fileupload fileupload-new" data-provides="fileupload">
										<div class="input-group">
											<div class="form-control col-md-3">
												<i class="fa fa-file fileupload-exists"></i> <span class="fileupload-preview"></span>
											</div>
											<span class="input-group-btn">
												<span class="btn btn-default btn-sm btn-file">
													<span class="fileupload-new">Select File</span>
													<span class="fileupload-exists">Change File</span>
													<input class="btn btn-inverse" name="report_upload" type="file">
												</span>
												<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer" id="approve_cancel_btn">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
					<input id="btn_cancel_donation" class="btn btn-primary btn-sm" value="Confirm" type="submit">
				</div>
			</div>
		</fieldset>
		</form>
	</div>
</div>