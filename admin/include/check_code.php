<?php
include("../config.php");
$title = $_POST['title'];
$url = $_POST['url'];
$content = $_POST['content'];
$images = $_POST['images'];
$sql = "INSERT into advertisement (title , content , img) VALUES ('$title' , '$content' , '$images') ";
mysql_query($sql);
print "Successfully Aded";
?>





