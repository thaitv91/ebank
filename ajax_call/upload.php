<?php 
session_start(); 
// array(5) {
//   ["name"]=>
//   string(25) "dangduongphat-favicon.png"
//   ["type"]=>
//   string(9) "image/png"
//   ["tmp_name"]=>
//   string(24) "E:\xampp\tmp\phpBC4D.tmp"
//   ["error"]=>
//   int(0)
//   ["size"]=>
//   int(6892)
// }
//var_dump($_POST['id']); 

include('../config.php');								
$payment_receipt_img_full_path = "../images/message/"; 
$id = $_GET['id'];

if ( !$_FILES["file"]["name"] ) {
        echo "Can't upload!";
    }
else {
	$allowedfiletypes = array("jpg" , "png" , "jpeg" , "gif" , "doc" , "docx" , "pdf" , "xls" , "xlsx");
	$allowedfile_img = array("jpg" , "png" , "jpeg" , "gif");
	$allowedfile_file = array("doc" , "docx" , "pdf" , "xls" , "xlsx");
	$uploadfolder = $payment_receipt_img_full_path;




	$thumbnailheight = 100; //in pixels
	$thumbnailfolder = $uploadfolder."thumbs/" ;
	$user_id = $_SESSION['ebank_user_id'];

	$unique_time = time();
	$unique_name =	"CD".$unique_time.$user_id;
	$uploadfilename = $_FILES["file"]["name"];

	$fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
			
	if (!in_array($fileext,$allowedfiletypes)) 
	{
		echo  1; 
	}	
	else 
	{
		$fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
		$unique_name = $unique_name.".".$fileext;
		$time = date('Y-m-d H:i:s');

		if (in_array($fileext,$allowedfile_img)) {
			$patch_file = "<a data-img='".$fulluploadfilename."' class='modal-img' href='javascript:void(0)'><img width='100' src='".$fulluploadfilename."'/></a>";
		}else{
			$patch_file = "<i class='fa fa-file-text-o fa-2x' aria-hidden='true'></i>".$unique_name;
		}

		if (move_uploaded_file($_FILES["file"]["tmp_name"], $fulluploadfilename)) {
			$img = "<a target='_blank' href='".$fulluploadfilename."' download='".$unique_name."'>".$patch_file."</a>";
			$date = date("Y-m-d");
        	$inser_img = mysql_query("INSERT INTO message (id_user,receive_id, title, message, message_date,mode) VALUES ('$user_id', '$id' , 'chat_msg' ,'".mysql_escape_string($img)."' , '$date' , '0') ");
        	var_dump($inser_img);
	    } else {
	        echo  1;
	    }

	}	
}
?>