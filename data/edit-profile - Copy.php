<?php
session_start();
include("condition.php");
require_once("validation/validation.php"); 
include("function/setting.php");
include("function/functions.php");
include("function/send_mail.php");
require_once("function/country_list.php");

$id = $_SESSION['ebank_user_id'];

$allowedfiletypes = array("jpeg","jpg","png","gif");
$uploadfolder = $user_profile_folder;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;


if(isset($_POST['submit']))
{
	$security_pin = $_REQUEST['security_pin'];
	$query = mysql_query("select * from users where id_user = '$id' and password = '$security_pin' ");
	$num = mysql_num_rows($query);
	if($num == 0)
	{ echo "<B style=\"color:#ff0000;\">Enter Correct Transaction Password !!</B>"; }
	else 
	{
		$country =$_POST['country'];
		$username = $_POST['username'];
		$password =$_POST['password'];
		$re_password =$_POST['re_password'];

		$district =$_POST['district'];
		$state = $_POST['state'];
		$address =$_POST['address'];
		$gender =$_POST['gender'];
		$dob =$_POST['dob'];
		$relation = $_POST['relation'];
		$image = $_REQUEST['photo'];
		
		$unique_time = time();
		$unique_name =	"EBT".$unique_time;
		$uploadfilename = $_FILES['photo']['name'];
			
		if(!empty($_FILES['photo']['name']))
		{
			$fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
			
			if (!in_array($fileext,$allowedfiletypes)) 
			{
				print "Invalid Extension";
			}
			else 
			{
				$fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
				if (copy($_FILES['photo']['tmp_name'], $fulluploadfilename))
				{ 
					$unique_name = $unique_name.".".$fileext;
		
					$sql_update = "UPDATE users SET dob = '$dob' , gender = '$gender' , 
					address = '$address' , district = '$district' , state = '$state' , 
					country ='$country' , password = '$password' , photo = '$unique_name' 
					WHERE id_user = '$id' ";
					mysql_query($sql_update);
		
					$date = date('Y-m-d');
					$username = get_user_name($id);
					$updated_by = $username." Your self";
					include("function/logs_messages.php");
					data_logs($id,$data_log[1][0],$data_log[1][1],$log_type[1]);
					echo "<B>Successfully Updated</B>";
				}
			}
		}
	}	
}


$query = mysql_query("select * from users where id_user = '$id' ");
while($row = mysql_fetch_array($query))
{
	$gender = $row['gender'];
	$dob = $row['dob'];
	$city = $row['city'];
	$mg = $_REQUEST['mg'];
	$country = $row['country'];
	$provience = $row['provience'];
	$address = $row['address'];
	$password =$row['password'];
	$district =$row['district'];
	$state = $row['state'];
	$photo = $row['photo'];
	
	$dd = date('d',strtotime($dob));
	$mm = date('m',strtotime($dob));
	$yy = date('Y',strtotime($dob));
}
	
 ?>
<form name="money" action="index.php?page=edit-profile" method="post" enctype="multipart/form-data">
<table id="example2" class="table table-bordered table-hover">
	<tr>
		<td colspan="2" style="color:#00274F; font-size:18px; font-weight:bold;">Security Details :</td>
	</tr>
	<tr>
		<td>Password :</td>
		<td><input type="text" name="security_pin" /></td>
	</tr>
	<tr>
		<td colspan="3" style="color:#00274F; font-size:18px; font-weight:bold;">Personal Details :</td>
	</tr>
	<tr>
		<td>Date of Birth</td>
		<td>
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					<input name="dob" type="text" data-inputmask="'alias': 'yyyy-mm-dd'" data-mask value="<?=$dob;?>"/>
				</div>
			</div>
		</td>
	</tr>
	<tr>
		<td>Gender <font color="#FF0000">*</font></td>
		<td>
			<input type="radio"  name="gender" value="male" checked="checked" />&nbsp;Male
			<input type="radio" style="width:50px;" name="gender" value="female" />&nbsp;Female
		</td>
	</tr>
	<tr>
		<td colspan="3" style="color:#00274F; font-size:18px; font-weight:bold;">Contact Details :</td>
	</tr>
	<tr>
		<td>Address <font color="#FF0000">*</font></td>
		<td><textarea name="address" style="width:164px;" required ><?=$address;?></textarea></td>
	</tr>
	<tr>
		<td>District <font color="#FF0000">*</font></td>
		<td><input type="text" name="district" value="<?=$district;?>" required /></td>
	</tr>
	<tr>
		<td>State <font color="#FF0000">*</font></td>
		<td> <input type="text" name="state" value="<?=$state;?>" required /></td>
	</tr>
	<tr>
		<td>Country <font color="#FF0000">*</font></td>
		<td >
			<select name="country" required>
				<option value="">Select One</option>
		<?php
				$list = count($country_list);
				for($cl = 0; $cl < $list; $cl++)
				{ ?>
					<option value="<?=$country_list[$cl];?>" 
					<?php if($country_list[$cl] == $country) { ?> selected="selected" <?php } ?>>
						<?=$country_list[$cl]; ?>
					</option>
		<?php 	} ?>
			</select>
		</td>
	</tr>
	
	<tr><td colspan="3" style="color:#00274F; font-size:18px; font-weight:bold;">Login Details :</td></tr>	
	<tr>
		<td>Password <font color="#FF0000">*</font></td>
		<td><input type="password" name="password" value="<?=$password;?>" required /></td>
	</tr>
	<tr>
		<td>Confirm Password <font color="#FF0000">*</font></td>
		<td> <input type="password" name="re_password" value="<?=$re_password;?>" required /></td>
	</tr>
	<tr>
		<td>Upload Photo</td>
		<td>
			<input  type="file" name="photo" value="<?=$photo;?>" required />
			<img src="images/profile_image/<?=$photo;?>" height="100" width="100" />
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input id="send" type="submit" name="submit" value="Update" class="btn btn-success" /> 
		</td>
	</tr>
</table>
</form>			
<script>
  $(function () {
	//Datemask dd/mm/yyyy
	$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "yyyy-mm-dd"});
	//Datemask2 mm/dd/yyyy
	$("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
	//Money Euro
	$("[data-mask]").inputmask();
   
  });
</script>