<?php
ini_set("display_errors","off");
$allowedfiletypes = array("jpeg","jpg","png","gif");
$uploadfolder = $legal_docs_folder;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;

if(isset($_POST['delete_legal']))
{
	$legal_id = $_POST['legal_id'];
	mysql_query("DELETE FROM `legal` WHERE id='$legal_id'");
	mysql_query("ALTER TABLE `legal` DROP `id`");
	mysql_query("ALTER TABLE `legal` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST ,ADD PRIMARY KEY (id)");
	print "<B style='color:red;'>Delete Successfully</B>";
}
if(isset($_POST['save_edit']))
{
	$legal_id=$_POST['legal_id'];
	$title=$_POST['title'];
	$desc=$_POST['desc'];
	$photo=$_POST['photo'];
	if($title!="" and $desc!="")
	{
		if(!empty($_FILES['photo']['name']))
		{   $uploadfilename = $_FILES['photo']['name'];
			$fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
			
			if (!in_array($fileext,$allowedfiletypes)) 
			{
				print "Invalid Extension";
			}
			else 
			{ 
			   $unique_time = time();
			   $unique_name =	"EBT".$unique_time;
			   $unique_name = $unique_name.".".$fileext;
			   $fulluploadfilename = $uploadfolder.$unique_name;
			   copy($_FILES['photo']['tmp_name'], $fulluploadfilename);
			}
		}
		mysql_query("UPDATE `legal` SET `title`='$title',`description`='$desc' , `photo`='$unique_name' 
		WHERE id='$legal_id'");
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=view_legal&msg=suss\"";
		echo "</script>";
	}
	else
	{
		echo $error="Some Field Is blank";
	}
}
elseif(isset($_POST['edit_legal']))
{
	$legal_id=$_POST['legal_id'];
	$sql = "select * from legal where id = '$legal_id'";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		$id = $row['id'];
		$title = $row['title'];
		$desc = $row['description'];
		$photo = $row['photo'];
	}
	?>
	<table class="table table-bordered">
	<form name="message" action="index.php?page=view_legal" method="post" enctype="multipart/form-data">
		<tr>
			<th>Title</th>
			<td><input type="text" style="width:370px;" value="<?=$title;?>" name="title" /></td>
		</tr>
		<tr>
			<th>Description</th>
			<td><textarea name="desc" cols="80" rows="5"><?=$desc;?></textarea></td>
		</tr>
		<tr>
			<th>Image</th>
			<td>
				<input type="file" name="photo" value="">
				<img src="../images/legal/<?=$photo;?>">
			</td>
		</tr>
		<tr>
			<td colspan="2" class="text-center">
			    <input type="hidden"  value="<?=$id;?>" name="legal_id" />
				<input type="submit" name="save_edit" value="Submit" class="btn btn-info"/>
			</td>
		</tr>
	</form>
	</table>
<?php
}
else
{
	$sqli = "select * from legal";
	$query = mysql_query($sqli);
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		if($_REQUEST['msg']=='suss')
		{
		  echo "<B style='color:green;'>Updated Successfully</B>";
		}
		?>
		<table id="sorting-advanced" class="table-responsive table">
			<thead>
			<tr>
				<th>Sr no.</th>
				<th>Title</th>
				<th class="text-right">Action</th>
			</tr>
			</thead>
		<?php
		$x=0;
		while($row = mysql_fetch_array($query))
		{   
			$x++;
			$id = $row['id'];
			$title = $row['title'];
			$desc = $row['description'];
			$photo = $row['photo'];
			
		?>
			<tr>
				<td style="width:10%;"><?=$x;?></td>
				<td style="width:60%;"><?=$title;?></td>
				<td class="text-right">
					<form action="" method="POST">
						<a href="javascript:void(0)" onClick="show_hide('img<?=$id;?>');" title="View">
							<img src="images/plus.png" id="img<?=$id;?>">
						</a>
						<input type="hidden" value="<?=$id;?>" name="legal_id" />
						<input type="Submit"  style="width:18px; height:18px; margin-left:5px;border:0;background-color:transparent; background-image:url(images/edit.png)" value="" name="edit_legal" title="Edit" />
						<input type="Submit" value="" style="width:18px; height:18px; margin-left:5px;border:0;background-color:transparent; background-image:url(images/delete.png)"  name="delete_legal" title="Delete" />
					</form>
				</td>
			</tr>
			<tr style="display: none;" id="<?=$id;?>">
				<td><B>Title</B><br /><?=$title?></td>
				<td><B>Description</B><br /><?=$desc?></td>
				<td class="text-right"><B>Image</B><br /><img src="../images/legal/<?=$photo;?>" /></td>
			</tr>
		<?php
		}
		echo "</table>";
	}	
	else{ print "<B style=\"color:#FF0000;\">There are no information to show !!</b>";}
}	?>
	

<script type="text/javascript">
function show_hide(id)
{
	
	var CurrentRowClick = 	id.replace("img", "");
	
	if(document.getElementById(CurrentRowClick).style.display == "none")
	{
		document.getElementById(CurrentRowClick).style.display="";		
		document.getElementById("img"+CurrentRowClick).src="images/minus.png";
	}
	else
	{
		document.getElementById(CurrentRowClick).style.display="none";
		document.getElementById("img"+CurrentRowClick).src="images/plus.png";
	}
	
	if(document.getElementById("prv_open").value!=CurrentRowClick) 
	{
		hide_prv_row(document.getElementById("prv_open").value);
	}
	document.getElementById("prv_open").value = CurrentRowClick;
	
}
</script>
