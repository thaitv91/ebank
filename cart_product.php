<?php
ini_set("display_errors","off");
session_start();
include "config.php";
include "condition.php";

$prd_id = $_REQUEST['id'];
$sql = "select * from shopping_product where id='$prd_id'";
$query = mysql_query($sql);
while($row = mysql_fetch_array($query)) {
	$img = $row['pro_image'];
	$name = $row['p_name'];
	$detail = $row['description'];
	$price = $row['p_price'];
}
?>
<form action="index.php?page=add_quantity" method="post">
<table border="0" width="600">
	<tr>
		<td rowspan="2" height="300" width="180"><img src="images/product/<?=$img?>" style="height:150px; width:150px;" /></td>
		<td height="20">
			<div style="font-weight:bold; font-size:20px; padding-right:20px;">$<?=$price?></div>
		</td>
	</tr>
	<tr>
		<td valign="top"> 
		<div style="font-weight:bold; font-size:20px;"><?=$name;?></div>
		<div style=" font-size:20px;"><?=$detail;?></div>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td style="font-size:20px;">
		Add Quantity : <input type="text" name="qunt_item" value="" />
		<input type="submit" class="btn btn-info" value="Add to Cart" name="addtocart" /></td>
	</tr>
</table>
<input type="hidden" value="<?=$prd_id?>" name="id"  />
</form>