<?php
session_start();
require_once("../config.php");
$id = $_SESSION['ebank_user_admin_login'];

print "<br>".$_SESSION['error'].$_SESSION['success']."<br>";
$_SESSION['error'] = $_SESSION['success'] = '';

?>
<script src="/js/chosen.jquery.js"></script>
<script>
     $(function() {
        $('.chosen-select').chosen();
     });
</script>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-chosen.css">

<script>
	tinymce.init({
		selector: 'textarea',
		height: 500,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table contextmenu paste code'
		],
	toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
	content_css: [
		'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
		'//www.tinymce.com/css/codepen.min.css'
  ]
});
</script>
<form name="message" action="index.php?page=compose1" method="post">
<input type="hidden" name="id" value=""  />
<input type="hidden" name="id_user" value=""  />
<table class="table table-bordered">  
	
	<tr>
		<th width="40%">Username</th>
		<td>
			<select id="selectUsers" name="username[]" data-placeholder="Choose a Country" class="chosen-select" multiple tabindex="4">
			<option value="all">All Username</option>
			<?php
				$qqq = mysql_query("SELECT * FROM users");
				while($row = mysql_fetch_array($qqq))
				{ $username = $row['username']; ?>
					<option value="<?=$row['id_user'];?>"><?=$username;?></option>
		<?php 	} ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>Query Title</th>
		<th><input type="text" name="title" /> Ticket No.</th>
	</tr>
	<tr>
		<th>Message</th>
		<td><textarea name="message"  style="height:100px; width:200px" class="text-editor"></textarea></td>
	</tr>
	<tr>
		<td class="text-center" colspan="2">
			<input type="submit" value="Send" name="submit" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>

