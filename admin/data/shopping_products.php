<?php
include("condition.php");


$allowedfiletypes = array("jpeg","jpg","png");
$uploadfolder = $path."/images/product/";
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $path."/images/thumbs/" ;

?>
<h2 align="left">Shoping Product</h2>
<?php
if(isset($_POST['Submit']))
{
	
	$p_id = $_REQUEST['p_id'];
	if($_POST['Submit'] == 'Edit')
	{
		
			$q = mysql_query("select * from shopping_product where id = '$p_id' ");
			while($r = mysql_fetch_array($q))
			{
				$product_name = $r['p_name'];
				$product_cost = $r['p_price'];
				$product_cost1 = $r['p_price1'];
				$product_cost2 = $r['p_price2'];
				
				$discription = $r['description'];
				$product_id = $r['id'];
				$shipping = $r['shipping'];
				$tax = $r['tax'];
				
				$discount = $r['discount'];
				$stock = $r['stock'];
				$bv = $r['bv'];
			}
		
		?>
			<table width="400" border="0">
				<form enctype="multipart/form-data" name="pay_form2" action="index.php?page=shopping_products" method="post" >
				<input type="hidden" name="p_id" value="<?=$p_id; ?>"  />
				<input type="hidden" name="o_pro_id" value="<?=$product_id; ?>"  />
			  <tr>
				<td colspan="2" style="font-size:16px; color:#666666;"><b>Edit Shopping Products</b></td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td>Product Name</td>
				 <td><input type="text" name="product_name" value="<?=$product_name; ?>" /></td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td>Product Cost</td>
				 <td><input type="text" name="product_cost" value="<?=$product_cost; ?>" /> USD</td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td>Web Product Cost</td>
				 <td><input type="text" name="product_cost1" value="<?=$product_cost1; ?>" /> USD</td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td>Refferal Product Cost</td>
				 <td><input type="text" name="product_cost2" value="<?=$product_cost2; ?>" /> USD</td>
			  </tr>
			  
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td>Product Discription</td>
				 <td><textarea name="product_discription" style="height:40px;"><?=$discription; ?></textarea></td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
				<tr>
					<td>Shipping Charge</td>
					<td><input type="text" name="ship_c" value="<?=$shipping ;?>" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					 <td>Tax</td>
					 <td><input type="text" name="tax" value="<?=$tax ;?>" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>Discount</td>
					<td><input type="text" name="discount" value="<?=$discount ;?>" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>Stock</td>
					<td><input type="text" name="stock" value="<?=$stock ;?>" /></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>Business Volume</td>
					<td><input type="text" name="bv" value="<?=$bv ;?>" /></td>
				</tr>
			  <tr>
				<td>Product Image</td>
				 <td><input type="file" name="product_images" /></td>
			  </tr>
			  <tr>
				<td colspan="2">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="center" colspan="2"><input type="submit" name="Submit" value="Edit Product" class="normal-button" /></td>
			  </tr>
			  </form>
			</table>	
		
		<?php
	}
	elseif($_POST['Submit'] == 'Delete')
	{
		$p_id = $_REQUEST['p_id'];
		$q = mysql_query("select * from shopping_product where id = '$p_id' ");
		while($r = mysql_fetch_array($q))
		{
			$img = $r['pro_image'];
		}
		mysql_query("delete from shopping_product where id = '$p_id'");
		mysql_query("ALTER TABLE shopping_product DROP `id`;");
		mysql_query("ALTER TABLE shopping_product ADD `id` INT NOT NULL AUTO_INCREMENT FIRST ,
ADD PRIMARY KEY ( id ) ;");
		unlink($path."/images/product/".$img);
		
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=shopping_products\"";
		echo "</script>";
	}
	elseif($_POST['Submit'] == 'Edit Product')
	{
		$p_id = $_REQUEST['p_id'];
		$product_name = $_REQUEST['product_name'];
		$product_cost = $_REQUEST['product_cost'];
		$product_cost1 = $_REQUEST['product_cost1'];
		$product_cost2 = $_REQUEST['product_cost2'];
		$product_title = $_REQUEST['product_title'];
		$product_discription = $_REQUEST['product_discription'];
		$product_images = $_REQUEST['product_images'];
		
		$ship_c = $_REQUEST['ship_c'];
		$discount = $_REQUEST['discount'];
		$tax = $_REQUEST['tax'];
		$stock = $_REQUEST['stock'];
		$bv = $_REQUEST['bv'];
		
		if(empty($_FILES['product_images']['name']))
		{
			mysql_query("update shopping_product set p_name = '$product_name' , p_price = '$product_cost', p_price1 = '$product_cost1', p_price2 = '$product_cost2' , description = '$product_discription', shipping='$ship_c', tax='$tax', discount='$discount', stock='$stock',bv='$bv' where id = '$p_id' ");
			print "<br>Edit Shopping Product Completed Successfully !";
		}
		else 
		{
			$o_pro_id = $_REQUEST['o_pro_id'];
			$r = date('Ymd');
			$unique_pin = $r.$unique_time = time();
			
			
			
			$img = $uploadfilename = $_FILES['product_images']['name'];
			$fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
			if (!in_array($fileext,$allowedfiletypes)) { echo "<strong>Error: Invalid file extension!</strong></p>\n\n" ; }
			else 
			{
				$fulluploadfilename = $uploadfolder.$_FILES['product_images']['name'] ;
				
				if (file_exists($fulluploadfilename)) {
					echo "This Image ".$_FILES['product_images']['name']." exists";
				}
				else
				{
					if (copy($_FILES['product_images']['tmp_name'], $fulluploadfilename)) 
					{
					
						mysql_query("update shopping_product set p_name = '$product_name' , p_price = '$product_cost' , description = '$product_discription', pro_image='$img', shipping='$ship_c', tax='$tax', discount='$discount', stock='$stock' where id = '$p_id' ");
						print "<br>Edit Shopping Product Completed Successfully !";
					} 
					else { echo "<strong>Error: Couldn't save Image ($fulluploadfilename)!</strong></p>\n\n"; }
				}
			}
			
		}
		
	}
}
else
{
	
	
?>	<table width="700" border="0">
  <?php 
  	$q = mysql_query("select * from product_category where prnt_catg != '0' ");
	$num = mysql_num_rows($q);
	if($num > 0)
	{
		?>
	
	  <tr>
		<td width="650px" height=30px class="message tip"><strong>Product Name</strong></td>
		<td height=30px width="650px" class="message tip" align="center"><strong>Product Cost</strong></td>
		<td height=30px width="650px" class="message tip" align="center"><strong>Product Discription</strong></td>
		<td height=30px width="650px" class="message tip" align="center"><strong>Stock</strong></td>
		<td colspan="2" height=30px width="650px" class="message tip" align="center"><strong>Product Operation</strong></td>
	  </tr>
		<form action="" method="post">
			<select name="product" onchange="this.form.submit();">	
			<option value="0">Select Category</option>	
		<?php
		while($r = mysql_fetch_array($q))
		{
			?>
				<option value="<?=$r['catg_id'];?>"><?=$r['category'];?></option>
			<?php
		}
		?>
		</select>
			</form>		
		<?php
	}
	
	if(isset($_REQUEST['product']))
	{ 
		$sql = "select * from shopping_product where catg_id ='".$_REQUEST['product']."'";
	}
	else
	{
		$sql = "select * from shopping_product where catg_id != '0'";
	}
		$qu = mysql_query($sql);
		$num = mysql_num_rows($qu);
		if($num > 0)
		{
			while($r = mysql_fetch_array($qu))
			{
				$product_name = $r['p_name'];
				$product_cost = $r['p_price'];
				$stock = $r['stock'];
				$discription = $r['description'];
				$pro_image = $r['pro_image'];
				$p_id = $r['id'];
				
				
			  ?>
			  
			   <tr>
			   
				<form name="invest" method="post" action="index.php?page=shopping_products">
				<td height="20px" class="input-small" align="center">
					<img src="../images/product/<?=$pro_image; ?>" width="100px" /><br />
					<?=$product_name; ?>
				</td>
				<td height="20px" class="input-small" align="center">$<?=$product_cost; ?></td>
				<td height="20px" class="input-small" align="center"><?=$discription; ?></td>
				<td height="20px" class="input-small" align="center"><?=$stock; ?></td>
				<td height="20px" class="input-small" align="center">
				<input type="hidden" name="p_id" value="<?=$p_id; ?>"  />
				<input type="submit" name="Submit" value="Edit" class="normal-button"  />
				<input type="submit" name="Submit" value="Delete" class="normal-button"  /></form></td>
				</tr>
		<?php }
		}
		else
		{print "There Have No Product For Shopping!!";}
	?>
	
  </table>
	
	
	
	
<?php } ?>

