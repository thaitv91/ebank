<?php
if(isset($_POST['add']))
{
	$username = $_POST['username'];
	$sql = "select id_user,username from users where username = '$username' ";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		$row = mysql_fetch_array($query);
		$id = $row['id_user'];
		mysql_query("update user_manager set type = 'M' where manager_id = '$id' ");
		
		echo "<B style=\"color:#008000;\">Manager Create Successfully</B>";
	}
	else
	{ echo "<B style=\"color:#ff0000;\">Please Enter Correct Username</B>"; }
}
?>


<form method="post">
<table class="table table-bordered">  
	<tr>
		<td width="30%"><input type="text" name="username" placeholder="Username"  required /></td>	
		<td><input type="submit" name="add" value="Add" class="btn btn-info"/></td>
	</tr>	
</table>
</form>