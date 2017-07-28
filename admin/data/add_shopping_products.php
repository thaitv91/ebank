<?php
session_start();
include("condition.php");
?>
<h2 align="left">Add Shopping Product</h2>
<?php
if($_SESSION['success'] == 1)
{
	print "<br>Product Successfully Added !!";
	unset($_SESSION['success']);
}


$allowedfiletypes = array("jpeg","jpg","png","gif");
 $uploadfolder = $path."/images/product/";
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $path."/images/thumbs/" ;
	

if(isset($_POST['submit']))
{
	$product_name = $_REQUEST['product_name'];
	$product_cost = $_REQUEST['product_cost'];
	$product_cost1 = $_REQUEST['product_cost1'];
	$product_cost2 = $_REQUEST['product_cost2'];
	$product_title = $_REQUEST['product_title'];
	$product_discription = $_REQUEST['product_discription'];
	$product1 = $_REQUEST['product1'];
	$catg_id = $_REQUEST['par_id'];
	
	$ship_c = $_REQUEST['ship_c'];
	$discount = $_REQUEST['discount'];
	$tax = $_REQUEST['tax'];
	$stock = $_REQUEST['stock'];
	$bv = $_REQUEST['bv'];
	
	
	$img = $_FILES['product1']['name'];
    if(empty($_FILES['product1']['name']))
	{
        echo "<strong>Error: File not uploaded!</strong></p>\n\n" ;
    } 
	else 
	{
		$uploadfilename = $_FILES['product1']['name'];
        $fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
        if (!in_array($fileext,$allowedfiletypes)) { echo "<strong>Error: Invalid file extension!</strong></p>\n\n" ; }
        else 
		{
		
            $fulluploadfilename = $uploadfolder.$_FILES['product1']['name'] ;
			/*if (file_exists($fulluploadfilename)) {
				echo "The file ".$_FILES['product1']['name']." exists";
			}
			else
			{*/
				if (copy($_FILES['product1']['tmp_name'], $fulluploadfilename)) 
				{
					 
					mysql_query("insert into shopping_product ( catg_id,p_name , p_price , p_price1,p_price2,description,pro_image,shipping,tax,discount,stock,bv) values ( '$catg_id', '$product_name' , '$product_cost', '$product_cost1', '$product_cost2' , '$product_discription', '$img','$ship_c','$tax','$discount','$stock','$bv') ");
					
					$_SESSION['success'] = 1;
					echo "<script type=\"text/javascript\">";
					echo "window.location = \"index.php?page=add_shopping_products\"";
					echo "</script>";
				} 
				else { echo "<strong>Error: Couldn't save Image ($fulluploadfilename)!</strong></p>\n\n"; }
			/*}*/
        }
		
	}	
	
}
else
{?>
	<table width="400" border="0">
	<form method="post" enctype="multipart/form-data"  name="pay_form" action="index.php?page=add_shopping_products">
 
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Product Name</td>
	 <td><input type="text" name="product_name" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Product Cost</td>
	 <td><input type="text" name="product_cost" />USD</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Web Product Cost </td>
	 <td><input type="text" name="product_cost1" />USD</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Refferal Product Cost</td>
	 <td><input type="text" name="product_cost2" />USD</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
 <!-- <tr>
    <td>Product Title</td>
	<td><input type="text" name="product_title" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>-->
  <tr>
    <td>Product Discription</td>
	 <td><textarea name="product_discription" style="height:40px;"></textarea></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Product Category</td>
	<td><select name="par_id" required class="" style="height:auto;width:auto;">
	  		<option value="0">Select Category</option>
	  		<?php $opt = mysql_query("select * from product_category where catg_id not in(select catg_id from product_category where prnt_catg ='0')");
				while($ro = mysql_fetch_array($opt))
				{
					 $title = $ro['category'];
			?>
				<option value="<?=$ro['catg_id']?>"><?php print $title;  ?></option><?php }?>
			</select>
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Shipping Charge</td>
	 <td><input type="text" name="ship_c" value="" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Tax</td>
	 <td><input type="text" name="tax" value="" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Discount</td>
	 <td><input type="text" name="discount" value="" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Stock</td>
	 <td><input type="text" name="stock" value="" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Business Volume</td>
	 <td><input type="text" name="bv" value="" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Product Image</td>
	 <td><input type="file" name="product1" value="" /></td>
  </tr>
  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" colspan="2"><input type="submit" name="submit" value="Add Product" class="normal-button" /></td>
  </tr>
  </form>
</table>
<?php }?>
