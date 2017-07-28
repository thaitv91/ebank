<?PHP
session_start();
include("../function/setting.php");
include("condition.php");
require_once "../function/formvalidator.php";

$payment_receipt_img_full_path = "../images/locations/"; 

if(isset($_POST['Submit']))
{ 
	$country = $_REQUEST['country'];
	$currency_unit = $_REQUEST['currency_unit'];

	if(!empty($country)){
		$q = mysql_query("select * from location where name = '$country' ");
		$num = mysql_num_rows($q);
		if($num > 0)
		{
			echo "<B style=\"color:#FD0000;\">This country already exists !!</B>";
		}
		else {  
			if ($_FILES["flag"]["name"] ) {
				$allowedfiletypes = array("jpg" , "png" , "jpeg" , "gif" );
				$uploadfolder = $payment_receipt_img_full_path;

				$thumbnailheight = 100; //in pixels
				$thumbnailfolder = $uploadfolder."thumbs/" ;
				$user_id = $_SESSION['ebank_user_id'];

				$unique_time = time();
				$unique_name =	"CD".$unique_time.$user_id;
				$uploadfilename = $_FILES["flag"]["name"];

				$fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
						
				if (!in_array($fileext,$allowedfiletypes)) 
				{
					echo  1; 
				}	
				else 
				{
					$fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
					$unique_name = $unique_name.".".$fileext;

					if (move_uploaded_file($_FILES["flag"]["tmp_name"], $fulluploadfilename)) {
			        	$inser_img = mysql_query("INSERT INTO location (name, currency_unit, flag) VALUES ('$country', '$currency_unit', '$unique_name')");
			        	if($inser_img){
							echo "<B style=\"color:#008000;\">Country inserted uccessfully </B>";
						}
				    } else {
				        echo  1;
				    }

				}	
			}else{
				$inser_img = mysql_query("INSERT INTO location (name, currency_unit) VALUES ('$country', '$currency_unit')");
	        	if($inser_img){
					echo "<B style=\"color:#008000;\">Country inserted uccessfully </B>";
				}
			}	
		}
	}else{
		echo "<B style=\"color:#FD0000;\">Enter country </B>";
	}
	

}
if(isset($_POST['update']))
{ 
	$id = $_REQUEST['location_id'];
	$name = $_REQUEST['country'];
	$currency_unit = $_REQUEST['currency_unit'];
 
	if(!empty($name)){
		$q = mysql_query("select * from location where name = '$name' ");
		$num = mysql_num_rows($q);

		if ( $_FILES["flag"]["name"] ) {
			$allowedfiletypes = array("jpg" , "png" , "jpeg" , "gif" );
			$uploadfolder = $payment_receipt_img_full_path;

			$thumbnailheight = 100; //in pixels
			$thumbnailfolder = $uploadfolder."thumbs/" ;
			$user_id = $_SESSION['ebank_user_id'];

			$unique_time = time();
			$unique_name =	"CD".$unique_time.$user_id;
			$uploadfilename = $_FILES["flag"]["name"];

			$fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
					
			if (!in_array($fileext,$allowedfiletypes)) 
			{
				echo  1; 
			}	
			else 
			{
				$fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
				$unique_name = $unique_name.".".$fileext;

				if (move_uploaded_file($_FILES["flag"]["tmp_name"], $fulluploadfilename)) {
					if($num > 0){
						$inser_img = mysql_query("UPDATE location SET flag = '$unique_name' WHERE location_id = $id");
					}else{
						$inser_img = mysql_query("UPDATE location SET name = '$name', currency_unit = '$currency_unit', flag = '$unique_name' WHERE location_id = $id");
					}
		        	if($inser_img){
						echo "<B style=\"color:#008000;\">Country updated uccessfully </B>";
					}
			    } else {
			        echo  "can't upload file";
			    }

			}
		}else{
			$inser_img = mysql_query("UPDATE location SET name = '$name', currency_unit = '$currency_unit' WHERE location_id = $id");
        	if($inser_img){
				echo "<B style=\"color:#008000;\">Country updated uccessfully </B>";
			}
		}
	}else{
		echo "<B style=\"color:#FD0000;\">Enter country </B>";
	}		
}




if(isset($_REQUEST['act'])){
	$act = $_REQUEST['act'];
	$id  = $_REQUEST['id'];
	if($act == 'edit'){
		$q_count = mysql_query("select * from location where location_id = $id ");
		$r_count = mysql_fetch_array($q_count);
		?>
		<form name="change_pass1" action="index.php?page=location_setting" method="post" id="commentform" enctype="multipart/form-data">
			<table class="table table-bordered"> 
				<thead>
		            <tr><th colspan="5">Update Country</th></tr> 
		        </thead>
		        <tbody>
		        	<tr>
						<th width="40%">Name country</th>
						<td>
							<input type="text" class="form-control" name="country" value="<?=$r_count['name'];?>" placeholder="Name country"/>
							<input type="hidden" name="location_id" value="<?=$r_count['location_id'];?>"/>
						</td>
						<td><input class="form-control" type="text" name="currency_unit" value="<?=$r_count['currency_unit'];?>" placeholder="Currency unit"/></td>
						<td>
							<?php if(!empty($r_count['flag'])){echo '<img style="float:left;margin-right:10px" width="50" src="../images/locations/'.$r_count['flag'].'">';}?>
							<input type="file" name="flag" value="" placeholder="Flag"/>
						</td>
						<td class="text-center">
							<input type="submit" name="update" class="btn btn-info" value="Update" />
						</td>
					</tr>
		        </tbody>
			</table>
		</form>
<?php
	}
	if($act == 'delete'){
		$q_r = mysql_query("SELECT * FROM location WHERE location_id = $id");
		$r_r = mysql_fetch_array($q_r);
		unlink($payment_receipt_img_full_path.$r_r['flag']);
		$del_country = mysql_query("DELETE FROM location WHERE location_id = $id ");
		if($del_country){
			echo "<B style=\"color:#008000;\">Country deleted uccessfully </B>";
		}
	}
}
?>

<?php 
if($_REQUEST['act'] != 'edit'){
?>
<form name="change_pass1" action="index.php?page=location_setting" method="post" id="commentform" enctype="multipart/form-data"> 
	<table class="table table-bordered"> 
		<thead>
            <tr><th colspan="5">Insert Country</th></tr> 
        </thead>
        <tbody>
        	<tr>
				<th width="40%">Name country</th>
				<td><input class="form-control" type="text" name="country" value="" placeholder="Name country"/></td>
				<td><input class="form-control" type="text" name="currency_unit" value="" placeholder="Currency unit"/></td>
				<td>
					<input type="file" name="flag" value="" placeholder="Flag"/>
				</td>
				<td class="text-center">
					<input type="submit" name="Submit" class="btn btn-info" value="Insert" />
				</td>
			</tr>
        </tbody>
	</table>
</form>
<?php }?>




<?php
$q_country = mysql_query("SELECT * FROM location ORDER BY location_id ASC");
?>
<table class="table table-bordered"> 
		<thead>
            <tr>
            	<th colspan="5">Contries</th>
            </tr> 
            <tr>
            	<th>No</th>
            	<th>Flag</th>
            	<th>Country</th>
            	<th>Currency unit</th>
            	<th></th>
            </tr> 
        </thead>
        <tbody>
        	<?php 
        	$dem = 1;
        	while($r_country = mysql_fetch_array($q_country)){
        	?>
        	<tr>
        		<td><?=$dem++?></td>
        		<td><img width="50" src="../images/locations/<?=$r_country['flag']?>" alt=""></td>
				<td><?=$r_country['name']?></td>
				<td><?=$r_country['currency_unit']?></td>
				<td class="text-center">
					<a href="index.php?page=location_setting&act=edit&id=<?=$r_country['location_id']?>" class="btn btn-info">Edit</a>
					<a href="index.php?page=location_setting&act=delete&id=<?=$r_country['location_id']?>" class="btn btn-warning">Delete</a>
				</td>
			</tr>
			<?php }?>
        </tbody>
	</table>


<style type="text/css">
 input[type=file] {
 	height:35px;
 }
</style>
