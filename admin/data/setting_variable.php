<?php
include("condition.php");

$p=0;
$q = mysql_query("select * from setting_variable");
$num = mysql_num_rows($q);
while($row = mysql_fetch_array($q))
{
	$tbl_id[$p] = $row['id'];
	$field[$p] = $row['field'];
	$variable[$p] = $row['variable'];
	$p++;
}
if(isset($_POST['submit']))
{
	if($_POST['submit'] == 'Update')
	{
		$sql = '';
		for($j = 0; $j < $num; $j++)
		{
			$tbl_id = $_REQUEST['tbl_id_'.$j];
			$field = $_REQUEST['field_'.$j];
			$variable = $_REQUEST['variable_'.$j];
			$date = date('Y-m-d H:i:s');
			$sql = "update setting_variable set `field` = '$field' , `variable` = '$variable' , 
			`date` = '$date' where id = '$tbl_id'; ";
			mysql_query($sql);
		}
	}
	if($_POST['submit'] == 'Add Variable')
	{
		mysql_query("insert into setting_variable (field,variable) values('Enter Info','Enter Info')");
	} 
	if($_POST['submit'] == 'Delete Variable')
	{	
		$tbl_id = $_REQUEST['tbl_id'];
		if($tbl_id == '')
		{
			print "Please Select Any One Variable For Delete !";
		}
		else
		{
			mysql_query("delete from setting_variable where id = '$tbl_id'");
			mysql_query("ALTER TABLE `setting_variable` DROP `id`");
			mysql_query("ALTER TABLE `setting_variable` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST ,
			ADD PRIMARY KEY ( id )");
		}
	} 
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=setting_variable\"";
	echo "</script>";
}

	
?>
<form name="setting" method="post" action="">
<table class="table table-bordered">
	<?php 
	for($pi = 0; $pi < $num; $pi++)
	{ 
	$read_only = '';
	if($variable[$pi] != 'Enter Info')
	$read_only = "readonly='readonly'";
	?>
	<tr>
		<input type="hidden" name="tbl_id_<?=$pi; ?>" value="<?=$tbl_id[$pi];?>"/>
		<input type="hidden" name="tbl_id" value="<?=$tbl_id[$pi];?>"/>
		<td><input type="radio" name="tbl_id" value="<?=$tbl_id[$pi];?>"/></td>
		<td><input type="text" class="" name="variable_<?=$pi;?>" value="<?=$variable[$pi];?>" <?=$read_only?>/></td>
		<td><input type="text" name="field_<?=$pi;?>" value="<?=$field[$pi];?>" /></td>
	</tr>
<?php 
	} ?>
	<tr>
		<td colspan="2">&nbsp;</td>
		<td><input type="submit" name="submit" value="Add Variable" class="btn btn-info"  />
		<input type="submit" name="submit" value="Delete Variable" class="btn btn-info"  /></td>
	</tr>
	<tr>
		<td colspan="3" class="text-center">
			<input type="submit" name="submit" value="Update" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>