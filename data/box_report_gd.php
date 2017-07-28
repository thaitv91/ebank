<div class="modal fade" id="dialog-report-confirm">
	<div class="modal-dialog">
		<form id="report_pdgd_form" method="post" action="index.php?page=welcome_action">
		<input name="report_uid" type="hidden">
		<input name="report_uir" type="hidden">
		<input name="report_invest" type="hidden">
		<input name="report_mdid" type="hidden">
		<input name="gd_pd" type="hidden" value="gd">
			<fieldset>
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title text-red" id="hierarchy_title">Report Confirmation</h3>
					</div>
					<div class="modal-body">
						<p style="font-size:16px;">
							Please provide a specific reason why you want to report this transaction.
						</p>
						<textarea class="form-control" style="width:100%;" name="comment" type="text"  placeholder="Type your reason here"></textarea>
						<!--<input name="comment" type="text" style="width:70%;" placeholder="Type your reason here">-->
						<!--<input type="radio" name="comment" value="Paid, but PD user no approved" checked="checked" /> Paid, but PD user no approved-->
						
					</div>
					<div class="modal-footer" id="approve_cancel_btn" style="text-align:left">
						<input id="btn_cancel_donation" class="btn btn-danger btn-sm" value="Confirm" type="submit" name="report">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>