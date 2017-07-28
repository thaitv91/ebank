
<?php
/********************************************
*
*	Filename:	index.php
*	Author:		Ahmet Oguz Mermerkaya
*	E-mail:		ahmetmermerkaya@hotmail.com
*	Begin:		Tuesday, Feb 23, 2009  10:21
*
*********************************************/

ini_set("display_errors","off");

?>	
<link rel="stylesheet" type="text/css" href="css1/style.css" />
	<link rel="stylesheet" type="text/css" href="js/jquery/plugins/simpleTree/style.css" />
	<script type="text/javascript" src="js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery/plugins/jquery.cookie.js"></script>
	<script type="text/javascript" src="js/jquery/plugins/simpleTree/jquery.simple.tree.js"></script>
	<script type="text/javascript" src="js/langManager.js" ></script>
	<script type="text/javascript" src="js/treeOperations.js"></script>
	<script type="text/javascript" src="js/init.js"></script>
<div class="contextMenu" id="myMenu2">
	<li class="edit"><img src="js/jquery/plugins/simpleTree/images/page_edit.png" /> </li>
	<li class="delete"><img src="js/jquery/plugins/simpleTree/images/page_delete.png" /> </li>
</div>
<div align="right">
	<form action="" method="post">
	<input type="text" value="" name="search_by_name" />
	<input type="submit" name="tree_member" value="Search" />
	</form>
</div> 
	<?php 
	if(isset($_POST['tree_member']))
	{
		$name = $_POST['search_by_name'];
		$sql = "select * from users where username = '$name'";
		$query = mysql_query($sql);
		$num = mysql_num_rows($query);
		if($num > 0)
		{
			while($row = mysql_fetch_array($query))
			{
				$id = $row['id_user'];
				$username = $row['username'];
			}
			$_SESSION['tree_session_id'] = $id;
		}
		else
		{
			print "<div style=\"color:red; font-size:14px;\" align=\"center\">Please Use Correct Name For Search</div>";
		}
	}
	else
	{
		$_SESSION['tree_session_id'] = 1;
	}
	
	
define("IN_PHP", true);

require_once("common.php");
$spindng_user_id = $_SESSION['ipayindia_user_id'];
$sql = "select * from users where id_user = '".$_SESSION['tree_session_id']."' ";
$query = mysql_query($sql);
while($row = mysql_fetch_array($query))
{
	$welcome_name = $row['f_name']." ".$row['l_name'];
} 
$rootName = "Tree of ".$welcome_name."&nbsp;";
$treeElements = $treeManager->getElementList( $_SESSION['tree_session_id'], "manageStructure.php");	
//include "function/tot_child.php";
//$obj = new total_child();
?>
<div id="wrap">
	<div id="annualWizard">	
		<ul class="simpleTree" id='pdfTree'>		
			<li class="root" id='<?=$treeManager->getRootId(); ?>'><span><?=$rootName;?></span>
				<ul><?=$treeElements;?></ul>				
			</li>
		</ul>						
	</div>	
</div> 
<div id='processing'></div>
