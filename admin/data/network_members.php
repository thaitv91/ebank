<h2 align="left">Tree View </h2>
<?php
	$KoolControlsFolder = "../KoolControls";//Relative path to "KoolPHPSuite/KoolControls" folder
	
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolTreeView/kooltreeview.php";
	include("../function/functions.php");

	$user_id = 1;
	$id_query = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
	$total_lvl_child[1] = mysql_num_rows($id_query);
	while($id_row = mysql_fetch_array($id_query))
	{
		$user_name = $id_row['username'];
		$treearr[0] = array("root",$user_name,$user_name,false,"woman2S.gif");
	}
	
	$pos[1] = $user_id;
	$total_lvl_child[1] = 1;
	$j = 1;
	$lc = 1;
	$chld_num = $cnt_chk = 0;
	$cnt = count($pos);
	for($i=1 ; $i <= $cnt; $i++)
	{
		$cnt_chk++;
		$bbid = $pos[$i];
		$real_paernt_username = get_user_name($bbid);
		$id_query = mysql_query("SELECT * FROM users WHERE parent_id = '$bbid' ");
		$chld_num = ($chld_num)+mysql_num_rows($id_query);
		while($id_row = mysql_fetch_array($id_query))
		{
			$j++;
			$pos[$j] = $id_row['id_user'];

			$user_name = $id_row['username'];
			$treearr[$j-1] = array($real_paernt_username,$user_name,$user_name,false,"woman2S.gif");
		}
		if($total_lvl_child[$lc] == $cnt_chk)
		{
			$lc++;
			$total_lvl_child[$lc] = $chld_num;
			$chld_num = $cnt_chk = 0;
		}
		$cnt = count($pos);
	}
		
	$total_m = count($pos)-1;
	$_node_template = "<label for='cb_{id}'>{text}</label>";
	
	$treeview = new KoolTreeView("treeview");
	$treeview->scriptFolder = $KoolControlsFolder."/KoolTreeView";
	$treeview->imageFolder=$KoolControlsFolder."/KoolTreeView/icons";
	$treeview->styleFolder = "default";
	$root = $treeview->getRootNode();
	
	$root->text = str_replace("{id}","treeview.root",$_node_template);
	$root->text = str_replace("{name}","treeview_root",$root->text);
	$root->text = str_replace("{text}","<font style=\"color:#004080; font-size:14px; font-weight:bold;\">Tree View of User ".$treearr[0][2]." ( Total Members : ".$total_m." )</font>",$root->text);
	$root->expand=true;
	$root->image="woman2S.gif";	
	for ( $i = 0 ; $i < sizeof($treearr) ; $i++)
	{
		$_text = str_replace("{id}",$treearr[$i][1],$_node_template);
		$_text = str_replace("{name}",$treearr[$i][1],$_text);
		$_text = str_replace("{text}",$treearr[$i][2],$_text);
		$treeview->Add($treearr[$i][0],$treearr[$i][1],$_text,$treearr[$i][3],$treearr[$i][4]);
	}
	$treeview->showLines = true;
	$treeview->selectEnable = false;
	$treeview->keepState = "onpage";	
?>

	<div style="padding:10px; width:150px;">
		<?php echo $treeview->Render();?>
	</div>	
<div style="margin-top:50px;"><center>
<table width="400" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" style="background-color:#002346; color:#CCCCCC; font-weight:bolder; text-align:center; height:30px; vertical-align:middle">Level</td>
    <td style="background-color:#002346; color:#CCCCCC; font-weight:bolder; text-align:center; height:30px; vertical-align:middle">Member(s)</td>
  </tr>
 <?php 
 $c = count($total_lvl_child);
 for($i = 2; $i <= $c; $i++)
 { ?> 
   <tr>
    <td style="background-color:#C2BDFD; color:#002346; font-weight:bolder; text-align:center; height:30px; vertical-align:middle; border-right:#002346 solid 1px; border-bottom:#002346 solid 1px;"><?php print "Level ".($i-1); ?></td>
    <td style="background-color:#C2BDFD; color:#002346; font-weight:bolder; text-align:center; height:30px; vertical-align:middle; border-bottom:#002346 solid 1px;"><?php print $total_lvl_child[$i]; ?></td>
  </tr>
 <?php } ?>  
  
</table>
</div>
