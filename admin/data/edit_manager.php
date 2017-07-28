<?php
if(isset($_POST['remove']))
{
	$user_id = $_POST['user_id'];
	mysql_query("update user_manager set type = 'B' where manager_id = '$user_id' ");
	echo "<B style=\"color:#008000;\">Remove Successfully</B>";
}
	
$sql = "select * from user_manager as t1 inner join users as t2 on t1.manager_id = t2.id_user where t1.type = 'M' ";
$query = mysql_query($sql);
?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th class="text-center">Id</th>
			<th class="text-center">Username</th>
			<th class="text-center">Name</th>
			<th class="text-center">Email</th>
			<th class="text-center">Phone</th>
			<th class="text-center">Action</th>
		</tr>
		</thead>
	<?php
	$sr = 1;
	while($row = mysql_fetch_array($query))
	{	
		$id_user = $row['id_user'];
		$username = $row['username'];		
		$name = $row['f_name'].' '.$row['l_name'];
		$email = $row['email'];
		$phone = $row['phone_no'];
	?>
		<tr>
			<td class="text-center"><?=$sr;?></td>
			<td class="text-center"><?=$username;?></td>
			<td class="text-center"><?=$name;?></td>
			<td class="text-center"><?=$email;?></td>
			<td class="text-center"><?=$phone;?></td>
			<td class="text-center">
				<form method="post" action="">
					<input type="hidden" name="user_id" value="<?=$id_user;?>">
					<input type="submit" name="remove" value="Remove" class="btn btn-info">
				</form>
				</td>
		</tr>
	<?php		
		$sr++;
	}
	print "</table>";
?>