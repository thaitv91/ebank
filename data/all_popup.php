<div class="modal fade" id="dialog-msg">
	<div class="modal-dialog">
		<fieldset>
			<form id="pdgd_message_form" method="post">
				<input name="uid" value="76186897" type="hidden">
				<input name="mdid" type="hidden">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="hierarchy_title">Message</h3>
					</div>
					<div class="modal-body np">
						<div id="message_div" class="messageWrap"></div>
						<div id="message_foot">
							<div id="upload">
								<div class="btn-group btn-group-sm" id="upload_clone">
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
													<input class="btn btn-inverse" name="upload" type="file">
												</span>
												<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
											</span>
										</div>
									</div>
								</div>
							</div>
							<textarea class="form-control form-control-text-area" placeholder="Reply" name="message" id="message" rows="4"></textarea>
							<p class="error" id="message_text"></p>
						</div>
					</div>
					<footer class="modal-footer clearfix">
						<input class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" type="button">
						<input class="btn btn-inverse btn-sm" id="btn_add_message" value="Send Reply" type="submit">
					</footer>
				</div>
			</form>
		</fieldset>
	</div>
</div>


<div class="modal fade" id="dialog-confirm-confirm">
	<div class="modal-dialog">
		<form id="approve_pdgd_form" enctype="multipart/form-data" method="post">
		<input name="__req" value="12" type="hidden">
		<input name="__nonce" value="f3d8f390ec4949de5cc73754cdb6505e0a221869d94725c8539725b79770d857" type="hidden">
		<input name="confirm_mdid" type="hidden">
		<fieldset>
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="hierarchy_title">Confirm Confirmation</h3>
				</div>
				<div class="modal-body">
					Are you sure you want to confirm the match PDGD?<br><br>
					For the security of fund transfer, system add upload feature to 
upload the payment proof, user can direct click the confirm or upload 
files and click confirm also can.<br><br>At GD user side, when they click approve, they can see the payment proof that PD user upload!<br><br>
					<div id="confirm_upload_images_div">
						<div id="confirm_message_div" class="messageWrap"></div>
						<div id="confirm_message_foot">
							<div id="confirm_upload">
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
													<input class="btn btn-inverse" name="confirm_upload[]" type="file">
												</span>
												<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="confirm_message_div" class="messageWrap"></div>
						<div id="confirm_message_foot">
							<div id="confirm_upload">
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
													<input class="btn btn-inverse" name="confirm_upload[]" type="file">
												</span>
												<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="confirm_message_div" class="messageWrap"></div>
						<div id="confirm_message_foot">
							<div id="confirm_upload">
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
													<input class="btn btn-inverse" name="confirm_upload[]" type="file">
												</span>
												<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="confirm_message_div" class="messageWrap"></div>
						<div id="confirm_message_foot">
							<div id="confirm_upload">
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
													<input class="btn btn-inverse" name="confirm_upload[]" type="file">
												</span>
												<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="confirm_message_div" class="messageWrap"></div>
						<div id="confirm_message_foot">
							<div id="confirm_upload">
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
													<input class="btn btn-inverse" name="confirm_upload[]" type="file">
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
				<div class="modal-footer" id="confirm_cancel_btn">
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
					<input id="btn_approve_donation" class="btn btn-primary btn-sm" value="Confirm" type="submit">
				</div>
			</div>
		</fieldset>
		</form>
	</div>
</div>
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


<div class="modal fade" id="dialog-photo">
	<div class="modal-dialog">
		<form name="cancel_order_form" method="post" action="">
			<input name="" value="" type="hidden">
			<input name="" value="" type="hidden">
			<input name="pboid" value="" type="hidden">
			<div class="modal-content">
				<div class="modal-body np" id="image_div">
				</div>
			</div>
		</form>
	</div>
</div>