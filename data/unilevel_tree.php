<?php 
error_reporting(0);
session_start();
//include("condition.php");
include "function/tree_function.php";

$user_id = $_SESSION['ebank_user_id'];;
$level = $_REQUEST['level'];
if($level == '')
{
	$level = 1;
}

function exist_username($username){
	$sql = mysql_query("select * from users where username='$username'");
	$num = mysql_num_rows($sql);
	if($num > 0){
		while($row = mysql_fetch_array($sql)){
		return $row['id_user'];
		}
	}
	else
		return false;
	/*while($row = mysql_fetch_array($sql)){
		$user_info = $row['username']."&nbsp;(".$row['f_name']."&nbsp;".$row['l_name'].")";
	}*/
	
}
?>
<style>
td{
color:#000000;
font-size:12px;
}
a{
color:#000000;
font-size:9pt;
text-decoration:none;
}
a:hover{
color:#0033FF;
}
td img{
vertical-align:middle;
}
.clear{
clear:both;
}

.level_start
{
	border-radius:18px;
	background:#99C;
	width:16px;
	text-align:center;
	color:#FFFFFF;
}
</style>
<!--<script>
function module(id,step,lev)
{
	document.getElementById("tree").innerHTML="";
	if (id == "" && lev == "")
	  {
	  document.getElementById("tree").innerHTML="";
	  return;
	  }
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("tree").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","data/ajax_tree.php?level_id="+id+"&step="+step+"&level="+lev,true);
	xmlhttp.send();
}
</script>-->

<div id="wrapper750">

<div id="tree">

<?php 

if(isset($_REQUEST['search']) and isset($_REQUEST['username']) and $_REQUEST['username'] != '')
{
	$result = exist_username($_REQUEST['username']);
	if($result)
	{
		$user_id = $result;
	}
	else
	{
		echo "<p>Username Incorrect</p>";
	}
}
	tree_member($level,$user_id);

?>
</div>
</div>
<div class="clear" style="height:10px;"></div>