<?php
if(isset($_POST['faq_delete']))
{
$faq_id=$_POST['faq_id'];
mysql_query("DELETE FROM `faqs` WHERE id='$faq_id'");
print "<center><b style='color:red; font-size: 15px;'>Successfully</b></center>";
}
if(isset($_POST['save_edit']))
{
	$faq_id=$_POST['faq_id'];
	$title=$_POST['title'];
	$message=$_POST['message'];
	if($title!="" and $message!="")
	{
		mysql_query("UPDATE `faqs` SET `question`='$title',`answer`='$message' WHERE id='$faq_id'");
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=view_faqs&msg=suss\"";
		echo "</script>";
	}
	else
	{
		echo $error="Some Field Is blank";
	}
}
else if(isset($_POST['edit_faq']))
{
	$faq_id=$_POST['faq_id'];
	$array = mysql_fetch_array(mysql_query("select * from faqs where id='$faq_id'"));
	?>
	<table class="table table-bordered">
	<form name="message" action="index.php?page=view_faqs" method="post">
		<tr>
			<th>Question</th>
			<td><input type="text" style="width:370px;" value="<?=$array['question']?>" name="title" /></td>
		</tr>
		<tr>
			<th>Answer</th>
			<td><textarea name="message" cols="80" rows="5"><?=$array['answer']?></textarea></td>
		</tr>
		<tr>
			<td colspan="2" class="text-center">
			    <input type="hidden"  value="<?=$array['id']?>" name="faq_id" />
				<input type="submit" name="save_edit" value="Submit" class="btn btn-info"/>
			</td>
		</tr>
	</form>
	</table>
<?php
}
else
{
	$sqli = "select * from faqs";
	$query = mysql_query($sqli);
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		if($_REQUEST['msg']=='suss')
		{
		  echo "<center><b style='color:green; font-size: 15px;'>Successfully</b></center>";
		}
		?>
		<table id="sorting-advanced" class="table-responsive table">
			<thead>
			<tr class="align-center">
				<th colspan="2">Sr no.</th>
				<th>Question</th>
			</tr>
			</thead>
		<?php
		$x=0;
		while($row = mysql_fetch_array($query))
		{   $x++;
			$id = $row['id'];
			$question = $row['question'];
			$answer = $row['answer'];
			
		?>
			<tr class="align-center">
				<td style="width:50px;"><?=$x?></td>
				<td><?=$question?></td>
				<td style="width:10%;">
					<a style="float:left;" href="javascript:void(0)" onClick="show_hide('img<?php print $id; ?>');">
						<img src="images/plus.png" id="img<?php print $id; ?>"></a>
						<form action="" method="POST">
							<input type="hidden" value="<?=$id?>" name="faq_id" />
							<input type="Submit"  style="width:18px; height:18px; margin-left:5px;    float:left; border:0;background-color:transparent; background-image:url(images/edit.png)" value="" name="edit_faq" title="Edit" />
							<input type="Submit" value="" style="width:18px; height:18px; margin-left:5px;   float:left; border:0;background-color:transparent; background-image:url(images/delete.png)"  name="faq_delete" title="Delete" />
						</form>
				</td>
			</tr>
			<tr style="display: none;" id="<?php print $id; ?>">
				<td colspan="1">Ans.</td>
				<td colspan="3"><?=$answer?></td>
			</tr>
		<?php
		$le++;
		}
		echo "</table>";
	}	
	else{ print "<B style=\"color:#FF0000; font-size:12pt;\">There are no information to show !!</b>";}
	?>
	

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
<?php }?>