<?php
ini_set("display_errors","off");
session_start();

$_REQUEST['verify_code'];
print $_SESSION['mobile_code'];
if(isset($_REQUEST['submit']))
{
	if($_REQUEST['verify_code'] == $_SESSION['mobile_code'])
	{
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=registration&verify=success\"";
		echo "</script>";
	}
	else
	{
		print "Please enter correct code!";
	}
}
?>
<form name="form" id="registrarionForm" action="index.php?page=registration1" method="post"  >
<table id="table-1" class="table table-striped table-hover dataTable">
	<tr><th style="padding-top: 20px;" colspan="2"><h4>Mobile Verification</h4></th></tr>
	<tr>
		<td align="right">Enter verification code here : &nbsp;</td>
		<td><input type="text" name="verify_code" value="" /></td> 
	</tr> 
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" name="submit" value="Submit"  class="btn btn-primary"/>
		</td>
	</tr>
</table>
</form>

