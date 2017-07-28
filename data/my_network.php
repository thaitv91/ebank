<?php
/********************************************
*
*	Filename:	unilevel_tree.php
*	Author:		Rajveer Singh 
*	E-mail:		ahmetmermerkaya@hotmail.com
*	Begin:		Tuesday, Feb 23, 2009  10:21
*
*********************************************/
$id = $_SESSION['ebank_user_id'];

?>	


	<?php 
	if(isset($_POST['tree_member']))
	{
		$email = $_POST['search_by_email'];
		$prestashop_user_id = $_SESSION['ebank_user_id'];
		$query = mysql_query("select * from users where username = '$email' && id_user >$prestashop_user_id ");
		$num = mysql_num_rows($query);
		if($num > 0)
		{
			while($row = mysql_fetch_array($query))
			{
				$id = $row['id_user'];
				$querrrrry = mysql_query("select * from users where id_user = $id ");
				while($rrrr = mysql_fetch_array($querrrrry))
				{
					$id_customer = $rrrr['id_user'];
				}
			}
			$_SESSION['tree_session_id'] = $id_customer;
		}
		else
		{
			print "<div style=\"color:red; font-size:14px;\" align=\"center\">Please Use Correct Name For Search</div>";
		}
	}
	else
	{
		$_SESSION['tree_session_id'] = $_SESSION['ebank_user_id'];
	}
	
	
define("IN_PHP", true);

require_once("common.php");
$prestashop_user_id = $_SESSION['tree_session_id'];
$query = mysql_query("select * from users where id_user = '$prestashop_user_id' ");
while($row = mysql_fetch_array($query))
{
	$welcome_name = "<strong>".$row['username']." (".$row['f_name']." ".$row['l_name'].")</strong>";
} 
$rootName = $welcome_name."&nbsp;Tree";
$treeElements = $treeManager->getElementList( $_SESSION['tree_session_id'], "manageStructure.php");	
	
	
?>
<!--<div class="contextMenu" id="myMenu2">
		<li class="edit"><img src="js/jquery/plugins/simpleTree/images/page_edit.png" /> </li>
		<li class="delete"><img src="js/jquery/plugins/simpleTree/images/page_delete.png" /> </li>
</div>-->
<div align="right">
	<form action="" method="post">
	<input type="text" value="" name="search_by_email" />
	<input type="submit" name="tree_member" value="Search" />
	</form>
	</div>

<div id="wrap">
	<div id="annualWizard">	
			<ul class="simpleTree" id='pdfTree'>		
					<li class="root" id='<?php echo $treeManager->getRootId();  ?>'><span><?php echo $rootName; ?></span>
						<ul><?php echo $treeElements; ?></ul>				
					</li>
			</ul>						
	</div>	
</div> 
<div id='processing'>&nbsp;</div>
