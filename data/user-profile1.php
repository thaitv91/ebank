<?php
ini_set("display_errors","off");
session_start();
include('condition.php');
include("function/setting.php");
//include("function/send_mail.php");
include("function/functions.php");
$id = $_SESSION['ebank_user_id'];

$query = mysql_query("SELECT * FROM users WHERE id_user = '$id'");
$num = mysql_num_rows($query);
if($num == 0)
{
	echo "<font color=\"#FF0000\" size=\"+2\">There are no information to show!!</font>";
}
else 
{
	while($row = mysql_fetch_array($query))
	{
		$id_user = $row['id_user'];
		$f_name = $row['f_name'];
		$l_name = $row['l_name'];
		$email = $row['email'];
		$username = $row['username'];
		$phone = $row['phone_no'];
		$city = $row['city'];
		$country = $row['country'];
		$state = $row['state'];
		
		$parent_id = get_user_name($row['parent_id']);
		$spons_id = get_user_email($row['real_parent']);
		$spons_name = ucfirst(get_full_name($row['real_parent']));
		$spons_phone = get_user_phone($row['real_parent']);
		
		$manager = active_by_real_p($id);
		$mang_id = get_user_email($manager);
		$mang_name = ucfirst(get_full_name($manager));
		$mang_phone = get_user_phone($manager);
	} 
?>
		<table id="example2" class="table table-bordered table-hover">
		<tr>
			<td>Invite (Nickname in the system)</td>
			<td><?=$email;?></td>
		</tr>
		<tr>
			<td>First Name</td>
			<td><?=$f_name;?></td>
		</tr>
		<tr>
			<td>Last Name</td>
			<td><?=$l_name;?></td>
		</tr>
		<tr>
			<td>E-mail</td>
			<td><strong><?=$email;?></strong></td>
		</tr>
		<tr style="color: green; height: 19px; background-color: rgb(239, 239, 239);">
			<td>Cell Number</td>
			<td><B><?=$phone;?></B></td> 
		</tr> 
		<tr style="color: green; height: 19px; background-color: rgb(239, 239, 239);">
			<td>Country</td>
			<td><?=$country;?></td>
		</tr>
		<tr>
			<td>Region</td>
			<td><?=$state;?></td>
		</tr>
		<tr>
			<td style="border: 0;">
				<span style="color: #666; font-weight: bold; padding-left:10px;">
					<span style="color: #666">Sponsor Details</span>
				</span>
			</td>
		</tr>
		<tr>
			<td>Sponsor ID</td>
			<td><?=$spons_id;?></td>
		</tr>
		<tr>
			<td>Sponsor Name </td>
			<td><?=$spons_name;?></td>
		</tr>
		<tr>
			<td>Sponsor Mobile No </td>
			<td><?=$spons_phone;?></td>
		</tr>
		<tr>
			<td style="border: 0;">
				<span style="color: #666; font-weight: bold; padding-left:10px;">
					<span style="color: #666">Manager Details</span>
				</span>
			</td>
		</tr>
		<tr>
			<td>Manager ID</td>
			<td><?=$mang_id;?></td>
		</tr>
		<tr>
			<td>Manager Name </td>
			<td><?=$mang_name;?></td>
		</tr>
		<tr>
			<td>Manager Mobile No </td>
			<td><?=$mang_phone;?></td>
		</tr>
	</table>
<?php		
}
?>

