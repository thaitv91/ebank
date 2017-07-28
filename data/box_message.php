<script type="text/javascript" src="js/provide_donation.js"></script>
<div class="modal fade" id="dialog-msg_chat">
	<div class="modal-dialog">
		<fieldset>
		
			<form id="pdgd_message_form" method="post">
				<input name="chat_uid" type="hidden">
				<input name="chat_mdid" type="hidden">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="hierarchy_title">Message</h3>
					</div>
					<div class="modal-body np">
						<div id="chatting" style="overflow: auto; overflow-x: hidden; height:100px;"></div>
						<div id="message_foot">
							<!--<div id="upload">
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
							</div>-->
							<textarea class="form-control form-control-text-area" placeholder="Reply" name="message" id="message" rows="4" style="width:80%"></textarea>
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