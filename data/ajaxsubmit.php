<?php

ini_set('display_errors','off');
include "../config.php";
include "../function/function.php";
$s_id = $_REQUEST['s_id'];
$r_id = $_REQUEST['r_id'];
$msg = $_REQUEST['msg'];
$date = date("Y-m-d");
if($msg != '')
{
	mysql_query("INSERT INTO message (id_user,receive_id, title, message, message_date,mode) VALUES ('$s_id','$r_id' , 'chat_msg' ,'$msg' , '$date' , '0') ");
}
 $sql = "select * from message where id_user = '$s_id'  
		and receive_id = '$r_id' or id_user = '$r_id' 
		and receive_id = '$s_id' and message_date = '$date'
		order by id desc";
$query = mysql_query($sql);
$num = mysql_num_rows($query);

if($num > 0){
	while($row = mysql_fetch_array($query))
	{
	 $id =	$row['id_user'];
	 $sq = "select username from users where id_user='$id'";
	 $quer = mysql_query($sq);
	 $row1 = mysql_fetch_array($quer);
	 $name = $row1[0];
	 print "<div style='color:#484848;text-align:left;'>&nbsp;";
	 print $name."&nbsp;>>";
	 print "&nbsp;&nbsp;".$row['message'];
	 print "</div>";
	
	}
}
?>