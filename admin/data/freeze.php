<?php
error_reporting(0)
session_start();
include "condition.php";
$sql = "select * from users where freeze=1";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
if($num > 0){
?>
	<table class="">
		<tr>
			<th>S.no.</th>
			<th>Username</th>
			<th>Name</th>
			<th>Phone</th>
			<th>Email</th>
			<th>Freeze</th>
			<th>Date</th>
		</tr>
	<?php
	$i = 1;
	while($row = mysql_fetch_array($query)){
		$username = $row['username'];
		$name = $row['f_name']."&nbsp;".$row['l_name'];
		$phone = $row['phone_no'];
		$email = $row['email'];
		$cnt = $row['freeze_cnt'];
		$date = $row['freeze_date'];
	?>
		<tr>
			<td><?=$i;?></td>
			<td><?=$username;?></td>
			<td><?=$name;?></td>
			<td><?=$phone;?></td>
			<td><?=$email;?></td>
			<td><?=$cnt;?></td>
			<th><?=$date;?></th>
		</tr>
	<?php 
	$i++;
	}
	?>
	</table>
<?php
}
else{
	echo "There have no freeze member !!";
}
?>