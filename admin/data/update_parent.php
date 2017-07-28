<?PHP
session_start();
include("condition.php");
require_once "../function/formvalidator.php";
include("../function/setting.php");
include("../function/functions.php");

if(isset($_POST['submit']))
{
	if($_POST['submit'] == 'Submit')
	{
		$u_name = $_REQUEST[user_name];
		$query = mysql_query("select * from users where username = '$u_name' ");
		$num = mysql_num_rows($query);
		if($num == 0)
		{
			echo "<B style=\"color:#ff0000;\">Please Enter right User Name !</B>";
		}
		else
		{
			while($row = mysql_fetch_array($query))
			{
				$id_user = $row['id_user'];
				$parent_id = $row['real_parent'];
				$query_parent = mysql_query("select * from users where id_user = '$parent_id' ");
				while($row_apr = mysql_fetch_array($query_parent)) 
				{
					$old_parent = $row_apr['username'];
				}
			}
?>
		<form name="register" action="index.php?page=update_parent" method="post" id="commentform">
		<input type="hidden" name="user_id" value="<?=$id_user;?>"  />	
		<table class="table table-bordered">
			<thead><tr><th colspan="2">User Information</th></tr></thead>
			<tr>
				<td>Old Parent</td>			
				<td><input type="text" name="old_parent" value="<?=$old_parent;?>" readonly /></td>
			</tr>
			<tr>
				<td>New Parent</td>			
				<td><input type="text" name="new_parent" value="" required/></td>
			</tr>
			<tr>
				<td colspan="2" class="text-center">
					<input type="submit" name="submit" value="Update" class="btn btn-info"/>
				</td>
			</tr>
		</table>
		</form>	
<?php					
		}
	}		
	elseif($_POST['submit'] == 'Update')
	{
			$id = $_POST['user_id'];
			$old_parent = $_POST['old_parent'];
			$new_parent = $_POST['new_parent'];

			if ($new_parent) {
				$query_id = mysql_query("select * from users where username = '$new_parent' ");
				
				if($query_id) 
				{
					while($row_id = mysql_fetch_array($query_id)) 
					{
						$new_aprrent_id = $row_id['id_user'];
					}
					if ($new_aprrent_id) {
						$insert_q = mysql_query("UPDATE users SET real_parent = '$new_aprrent_id' WHERE id_user = '$id'");
			
						$date = date('Y-m-d');
						$username = get_user_name($id);
						$updated_by = $username." Your self";
						include("../function/logs_messages.php");
						data_logs($id,$data_log[1][0],$data_log[1][1],$log_type[1]);
						echo "<B style=\"color:#008000; font-size:12pt;\">Successfully Updated: New Parent is ". $new_parent ."</B>";
					} 
					else
					{
						echo "<B style=\"color:red; font-size:12pt;\">Donot found Parent User</B>";
					}
				} 
			}
	}
}	
else
{ ?> 
<form name="my_form" action="index.php?page=update_parent" method="post">
<table class="table table-bordered">
	<thead><tr><th colspan="2">User Information</th></tr></thead>
	<tr>
		<td>Enter Member UserName</td>
		<td><input type="text" name="user_name" /></td>
  </tr>
  <tr>
    <td class="text-center" colspan="2">
		<input type="submit" name="submit" value="Submit" class="btn btn-info" />
	</td>
  </tr>
</table>
</form>
<?php  }  ?>

