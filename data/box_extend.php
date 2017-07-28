<div class="modal fade" id="dialog-msg">
	<div class="modal-dialog">
	<fieldset>
	<form id="pdgd_message_form" method="post" action="index.php?page=welcome_action">
		<input name="extend_mdid" type="hidden">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="hierarchy_title">Extend Time</h3>
			</div>
			<div class="modal-body np">
				<div id="message_div" class="messageWrap"></div>
				<div id="message_foot">
					<input type="radio" name="hours" value="12" checked="checked" />12 Hours<br />
					<input type="radio" name="hours" value="24" />24 Hours
					<p class="error" id="message_text"></p>
				</div>
			</div>
			<footer class="modal-footer clearfix">
				<input class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel" type="button">
				<input class="btn btn-inverse btn-sm" name="extend_time" value="Extend" type="submit">
			</footer>
		</div>
	</form>
	</fieldset>
	</div>
</div>