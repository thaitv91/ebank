<?php
session_start();
//ini_set("display_errors","on");
include("condition.php");
include("function/functions.php");
include("function/income.php");

if($_SESSION['success'] == 1)
{
	print "<div style=\"color:#000; font-size:12pt; text-align:center;\"><br>Product Successfully Purchase !!</div>";
	unset($_SESSION['success']);
}
if($_SESSION['error'] == 1)
{
	print "<br>Your Wallet Amount is low !!";
	unset($_SESSION['error']);
}
if($_SESSION['product_stock'] == 1)
{
	print "<br>This Product Out of Stock !!<P></p>";
	unset($_SESSION['product_stock']);
}
$q = mysql_query("select * from shopping_product ");
$num = mysql_num_rows($q);

?>

<script type="text/javascript">
	function cart_open(str){
	window.scrollTo(0,0);
	 $("#gro_id").empty();
	 $.post("cart_product.php" , {id:str} , function(result){
	 	 $('#gro_id').append(result);
	 });
	//container.appendChild(input);
	// Append a line break 
	//container.appendChild(document.createElement("br"));
	document.getElementById('light').style.display='block';
	
	document.getElementById('cart_fade').style.display='block';	
}
function cart_close(){
	document.getElementById('light').style.display='none';
	document.getElementById('cart_fade').style.display='none';
}
</script>
<style type="text/css">
.pr_li img{
	height:148px;
	width:120px;
}
.pr_li{
	float:left;
	margin:10px 10px;
	width:160px;
	list-style:none;
	min-height:244px;
	border:#FFFF66 5px solid;padding:5px;
	
}
#cart_fade{
	display: none;
	position: relative;
	left: 19px;
	top:-23px;
	bottom:15px;
	float:right;
	z-index:1001;
	-moz-opacity: 0.7;
	opacity:.70;
	z-index:1019;
	filter: alpha(opacity=70);
}

#light{
	display: none;
	position: absolute;
	
	width: 600px;
	height: auto;
	left: 25%;
	/*margin-left: 0px;*/
	min-height:300px;
						
	padding: 20px;
	border: 4px solid #ccc;
	border-radius:10px;
	background: #fff;
	z-index:1002;
	overflow:visible;
}

#fade{
	display: none;
	position: fixed;
	top: 0%;
	left: 0%;
	width: 100%;
	height: 100%;
	background-color: #000;
	z-index:1001;
	-moz-opacity: 0.7;
	opacity:.70;
	filter: alpha(opacity=70);
}
.product{
	width:150px;
	font-weight:bold;
	color:#000000;
	font-size:15px;
}
.description{
	width:150px;
	color:#000000;
	font-size:16px;
}
.price{
	width:150px;
	color:#000000;
	font-size:16px;
}

</style>

<div id="page_content">
<?php

	$id = $_SESSION['ebank_user_id'];
	if(isset($_POST['Submit']))
	{
		$product_id = $_REQUEST['product_id'];
		$arr_for_chk_stock = array_count_values($_SESSION['item']);
		$prod_order_count = $arr_for_chk_stock[$product_id]+1;
		$sql = "select * from shopping_product where stock >= $prod_order_count and id='$product_id'";
		$qu = mysql_query($sql);
		$num = mysql_num_rows($qu);
		if($num > 0)
		{
			$_SESSION['item'][] = $product_id;
		}
		else
		{
			$_SESSION['product_stock'] = 1;
		}
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=product_shop\"";
		echo "</script>";
			
	}
	else
	{
		$q = mysql_query("select * from product_category where prnt_catg != '0' ");
		$num = mysql_num_rows($q);
		if($num > 0)
		{ ?>
			<form action="" method="post">
				<select name="product" onchange="this.form.submit();">	
				<option value="0">Select Category</option>	
		<?php
					while($r = mysql_fetch_array($q))
					{ ?> <option value="<?=$r['catg_id'];?>"><?=$r['category'];?></option> <?php } ?>
				</select>
			</form>		
		<?php
		}
		if(isset($_REQUEST['product']))
		{ $sql = "select * from shopping_product where catg_id ='".$_REQUEST['product']."' and stock > 0"; }
		else
		{ $sql = "select * from shopping_product where catg_id != '0' and stock > 0"; }
	?>
	<p></p>	

	<div style="width:950px;" class="thumbnails">
	 
	<?php 
	$q = mysql_query($sql);
	$num = mysql_num_rows($q);
	if($num > 0)
	{	$i = 1;
		while($r = mysql_fetch_array($q))
		{
			$product_id = $r['id'];
			$product_name = $r['p_name'];
			$prd_image = $r['pro_image'];
		  ?>
			<div class="input-small pr_li span3">
				
				<form action="" method="post">
				<input type="hidden" name="product_id" value="<?php print $product_id; ?>" id="product_id"  />
				<div align="center"><img src="images/product/<?php print $prd_image;?>"/></div>
				<div class="caption" align="center">
					
					<div class="product"><?=$r['p_name'];?></div>
					<div class="description"><?php //$r['description']; ?></div>
					<div class="price" align="center">$ <?=$r['p_price'];?></div>
					<div align="center">
						<button type="button" name="add_cart" class="btn btn-primary btn-small" value=""; 
			onclick="cart_open(<?php print $product_id; ?>)" style="width:100px;">
							<i class="icon-shopping-cart icon-white"></i>Buy
						</button>
					</div>
				</div>
			
			
			</div>
	<?php 	$i++;
		}
	}
	else
	{
		print "There Have No Product to Shopping !!";
	}
	?>
	</div>
	
	
	
	
	<div id="fade" onClick="lightbox_close();"></div> 	
	<?php } ?>
</div>
<div id="light">
<div id="cart_fade" onClick="cart_close();"><img src="images/close.png" alt="Close" /></div> 	
	<!--<div style="background:#ccc; color:#000;height:20px; text-align:left;width:93%;font-size:14px;border: 1px solid #000;	border-radius:5px;" id="cart">
		<div style="text-align:left;padding:2px;">
		Add Cart !!
		</div>
	</div>-->
	<div style="">
		<div id="gro_id"></div>
	</div>
	<div style="margin-top:20px; " id="submit">
		
	</div>
</div>
