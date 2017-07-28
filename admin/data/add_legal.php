<?php
$allowedfiletypes = array("jpeg","jpg","png","gif");
$uploadfolder = $legal_docs_folder;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;

if(isset($_POST['submit']))
{
	$title=$_POST['title'];
	$desc=$_POST['desc'];
	$photo=$_POST['photo'];
	if($title != "" and $desc != "")
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
		mysql_query("INSERT INTO `legal`(`title`,`description`, `photo` , `date`) 
		VALUES ('$title','$desc', '$unique_name' , '$systems_date')");
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=add_legal&msg=suss\"";
		echo "</script>";
	}
	else
	{ echo $error="Some Field Is blank"; }
}

?><?php
if($error=="" and $_REQUEST['msg']=='suss')
{
  echo "<B style='color:green;'>Document Successfully Added !!</B>";
}
?>
<form name="message" action="index.php?page=add_legal" method="post" enctype="multipart/form-data">
<table class="table table-bordered">
	<tr>
		<th>Title</th>
		<td><input type="text" style="width:370px;" name="title" /></td>
	</tr>
	<tr>
		<th>Description</th>
		<td><textarea name="desc" cols="50" rows="5"></textarea></td>
	</tr>
	<tr>
		<th>Upload Image</th>
		<td><input type="file" name="photo"></td>
	</tr>
	<tr>
		<td colspan="2" class="text-center">
			<input type="submit" name="submit" value="Submit" class="btn btn-info"/>
		</td>
	</tr>
</table>
</form>
		

