<?php
session_start();
include 'config.php';
//include 'function/add_remove_function.php';
?>
<h2 align="left">Add Category</h2>

<?php

	if(isset($_REQUEST['Save']))
	{
		
		if($_SESSION['tmp'] == 1)
		{
		$par_id = $_REQUEST['par_id'];
		$catg_name = $_REQUEST['catg_name'];
		$alias = $_REQUEST['alias'];
		$r = date('Ymd');
		$unique_time = date("His");
		$catg_id = substr(md5(rand(0, 1000000)), 0, 12);
		
		mysql_query("insert into product_category(catg_id,category, prnt_catg, description) values('$catg_id','$catg_name', '$par_id', '".$alias."')");
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=add_category\"";
		echo "</script>";
		$tmp = $_SESSION['tmp'] = 0;
		}
		else
		{
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=add_category\"";
			echo "</script>"; 
		}
	}
	else
	{
	 $_SESSION['tmp'] = 1;
?>	
<div align="center">
 <form method="post" action="index.php?page=add_category">
	<table style="line-height:42px;">
	 
	 <tr>
	  <td width="40%" style="font-size:12pt;">Category Name</td>
	  <td><input type="text" name="catg_name" required class="input" /></td>
	 </tr>
	 
	 <tr>
	  <td style="font-size:12pt;">Description</td>
	  <td><input type="text" name="alias" required  class="input"/></td>
	 </tr>
	 
	 <tr>
	  <td style="font-size:12pt;">Parent</td>
	  <td><select name="par_id" required class="input" style="width:212px;height:auto;">
	  		<option value="0">New</option>
	  		<?php $opt = mysql_query("select * from product_category where prnt_catg =0");
				while($ro = mysql_fetch_array($opt))
				{
					 $title = $ro['category'];
			?>
				<option value="<?=$ro['catg_id']?>"><?php print $title;  ?></option><?php }?>
			</select>	
	  </td>
	 </tr> 
	 
	 <tr>
	 	<td></td>
	  <td><input type="submit" name="Save" value="Save"  class="button"/></td>
	 </tr>
	</table>
	 		</form>	
</div>
<?php } ?>		