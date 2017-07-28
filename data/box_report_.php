<div class="modal fade" id="dialog-report-confirm">
	<div class="modal-dialog">
		<form id="report_pdgd_form" method="post" action="index.php?page=welcome_action">
		<input name="report_uid" type="hidden">
		<input name="report_uir" type="hidden">
		<input name="report_invest" type="hidden">
		<input name="report_mdid" type="hidden">
		<input name="gd_pd" type="hidden" value="pd">
			<fieldset>
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="hierarchy_title">Report Confirmation</h3>
					</div>
					<div class="modal-body">
						<p style="font-size:16px;">
							Please Provide the reason on why you wish to report the match pdgd.
						</p>
						<!--<input type="radio" name="comment" value="Paid, but GD user no approved" checked="checked" /> Paid, but GD user no approved-->
						<input name="comment" type="text" style="width:70%;" placeholder="Type your reason here">
						
					</div>
					<div class="modal-footer" id="approve_cancel_btn">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
						<input id="btn_cancel_donation" class="btn btn-primary btn-sm" value="Confirm" type="submit" name="report">
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>