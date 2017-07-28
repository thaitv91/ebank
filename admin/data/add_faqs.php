<?php
if(isset($_POST['submit']))
{
	$title=$_POST['title'];
	$message=$_POST['message'];
	if($title != "" and $message != "")
	{
		mysql_query("INSERT INTO `faqs`(`question`,`answer`, `date`) 
		VALUES ('$title','$message','$systems_date')");
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=add_faqs&msg=suss\"";
		echo "</script>";
	}
	else
	{ echo $error="Some Field Is blank"; }
}

?><?php
if($error=="" and $_REQUEST['msg']=='suss')
{
  echo "<center><b style='color:green; font-size: 15px;'>Successfully</b></center>";
}
?>
<table class="table table-bordered">
	<form name="message" action="index.php?page=add_faqs" method="post">
		<input type="hidden" name="id" value=""  />
		<input type="hidden" name="id_user" value=""  />
		<!--<tr>
			<td align="right" width="40%"><span>Send To</span></td>
			<td><input type="text" name="username" value="Admin" readonly=""></td>
		</tr>-->
		<tr>
			<th>Question</th>
			<td><input type="text" style="width:370px;" name="title" /></td>
		</tr>
		<tr>
			<th>Answer</th>
			<td><textarea name="message" cols="50" rows="5"></textarea></td>
		</tr>
		<tr>
			<td colspan="2" class="text-center">
				<input type="submit" name="submit" value="Submit" class="btn btn-info"/>
			</td>
		</tr>
	</form>
</table>
		

