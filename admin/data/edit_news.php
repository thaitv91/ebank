<?php
session_start();
?>
<h2 align="left">Our News  </h2>
<?php
if(isset($_SESSION['success']))
{
	print $_SESSION['success'];
	unset($_SESSION['success']);
}
if(isset($_POST['submit']))
{
	$date = date('Y-m-d');
	$news =$_POST['news'];
	
	$sqls = "Update news set news = '$news' , date = '$date'";
	$query = mysql_query($sqls);
	
	$_SESSION['success'] =  "<B style=\"color:#298b13; font-size:12pt;\">Successfully Added !!</B>";	
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=edit_news\"";
	echo "</script>";
}	
else{
$sql ="select * FROM news";
$query = mysql_query($sql);
while($row=mysql_fetch_array($query))
{
	$news = $row['news'];
}
							

?>

<form action="index.php?page=edit_news" method="post">
	<table>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td>Edit News :</td>
			<td><textarea style="width:300px; height:150px;" name="news" ><?=$news;?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>
</form>

<?php
}
?>