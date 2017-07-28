<?PHP
session_start();
include("../function/setting.php");
include("condition.php");
require_once "../function/formvalidator.php";

if(isset($_POST['Submit']))
{ 
	$old_password = $_REQUEST['old_password'];
	$new_password = $_REQUEST['new_password'];
	$con_new_password = $_REQUEST['con_new_password'];
	
	$q = mysql_query("select * from admin where password = '$old_password' ");
	$num = mysql_fetch_array($q);
	if($num > 0)
	{
		if($new_password == $con_new_password and $new_password != '')
		{
			$insert_q = mysql_query("UPDATE admin SET password = '$new_password' ");
			echo "<B style=\"color:#008000;\">Password UpdatedS uccessfully </B>";
		}
		else 
		{ 
			echo "<B style=\"color:#ff0000;\">Please Enter same Password in both  New and Confirm password Field !!</B>"; 
		}
	}
	else { echo "<B style=\"color:#ff0000;\">Please Enter Correct Old Password !!</B>"; }
}	

else
{ 
$quew = mysql_query("select * from admin");
$row = mysql_fetch_array($quew);
$password = $row['password'];
?>
<form name="change_pass1" action="index.php?page=change_password" method="post" id="commentform">
<table class="table table-bordered"> 
	<tr>
		<th width="40%">Old Password</th>
		<td><input type="text" size=25 name="old_password" value="<?=$password;?>" readonly="" /></td>
	</tr>
	<tr>
		<th>New Password</th>
		<td><input type="text" size=25 name="new_password" /></td>
	</tr>
	<tr>
		<th>Confirm New Password</th>
		<td><input type="text" size=25 name="con_new_password" /></td>
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" name="Submit" class="btn btn-info" value="Update" />
		</td>
	</tr>
</table>
</form>
<?php } ?>

