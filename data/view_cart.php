<link rel="stylesheet" type="text/css" href="sign_up/css/style.css" media="all" />
	
	
<?php
session_start();
//ini_set("display_errors","on");
include("condition.php");
include("function/functions.php");
include("function/income.php");

if($_SESSION['success'] == 1)
{
	print "<br>Product Successfully Purchase !!";
	unset($_SESSION['success']);
}
if($_SESSION['product_stock'] == 1)
{
	print "<br>This Product Out of Stock !!";
	unset($_SESSION['product_stock']);
}
	$q = mysql_query("select * from shopping_product ");
	$num = mysql_num_rows($q);
	?>

<h1>Shopping Cart</h1>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js"></script>
    
<script type="text/javascript">
jQuery(document).ready(function($) {
	var form = $('form[name="money"]'),
		selectd = $('select[name="p_mode"]'),
		choice = '';
	selectd.change(function(e) {
		choice = this.value;
		if (choice === '0') {
			form.attr('action', 'index.php?page=payment');
		} else {
			form.attr('action', 'pay_method/pgRedirect.php');
		}
	});
});
</script>
<style>
#tabs td{
padding-left:10px;
}

#tabs th{
text-align:right;
}

.ui-tabs .ship_title{
text-align:justify;
font-size:14px;
color:#000000;
}
.box-body {
    overflow: hidden;
}

</style>
<div id="page_content">
<?php
 $id = $_SESSION['ebank_user_id'];
$email = get_user_email($id);

if(isset($_REQUEST['procced']))
{
	$item_arr = $_SESSION['item'];
	$class = " ui-tabs-hide";
	if($_REQUEST['procced'] == 'Next'){
	$class ='';
	}
	$new_item_arr = array();
	$cnt_item = 1;
	$count_item_arr = array_count_values($item_arr);
	 for($i = 0; $i < count($item_arr); $i++)
	 {
		$item = $item_arr[$i];
		if(!in_array($item,$new_item_arr))
		{
			$new_item_arr[] = $item;
		}
	 }
							
	$toal_item_price = 0;
	 for($i = 0; $i < count(array_unique($_SESSION['item'])); $i++)
	 {	
		
		$item = $new_item_arr[$i];
		$q = mysql_query("select * from shopping_product where id='$item'");
		
		while($rr = mysql_fetch_array($q))
		{
			$toal_item_price = $toal_item_price + ($count_item_arr[$item]*$rr['p_price']);
			$pur_prod .= $item."-";
			$pur_quantity .= $count_item_arr[$item]."-";
		}
	 }
	 $pur_prod = rtrim($pur_prod,"-");
	 $pur_quantity = rtrim($pur_quantity,"-");
	 if($_REQUEST['phase']== '')
	 {
	 	$phase = 1;
		$frg_s = 1;
		$frg_p = 2;
		$aaa = '<a id="pay"></a>';
	 }
	 else
	 {
	 	$phase = 2;
		$frg_s = 2;
		$frg_p = 1;
		$aaa = "<a href=\"#fragment-$frg_p\" id=\"pay\"></a>";
	 }
	 $request = $_REQUEST;
	
	 
        
        // Lets select all countries from our table...
        $sqlAllCountries = "SELECT * FROM `location` WHERE `location_type` =0";
        $sqlAllCountriesResult = mysql_query($sqlAllCountries);
        if ($sqlAllCountriesResult) {
            while ($row = mysql_fetch_object($sqlAllCountriesResult)) {
                $objAllCountries[] = $row;
            }
        }
        ?>
<style>
select{
	color: #000;
	font-family: Georgia;
	height: 25px;
	padding: 1px 3px;
	width: 200px;
}
input[type="text"]{
	color: #000;
	height: 20px;
	padding: 1px 3px;
	width: 150px;
}
</style>

<script type="text/javascript">
  function calculateCheckSum(){  
    document.forms[0].action = 'CheckSum';
  	document.forms[0].submit();
  }
 
	function assignChecksum() {
		var order = document.getElementById("orderid");
		var orderId = order.value + parseInt(Math.random() * 1000000);
		order.value = orderId;
	}
	function payInIframe(){
        document.getElementsByTagName("form")[0].target = "myiframe";
        document.getElementsByName('myiframe')[0].style.display = "block";
        
        Paytm = {
        	payment_response : null
        };
        
        checkForPaymentResponse(function(res){
        	document.getElementById('payment-response-msg').innerHTML = "Payment response : " + res;
        });
        
        function checkForPaymentResponse(callback){
        	var cb = callback;
        	var sid = setInterval(function(){
        		if(Paytm.payment_response){
        			cb(Paytm.payment_response);
        			clearInterval(sid);
        		}
        	}, 200)
        };

	}
</script>
<!--</head>
<body onLoad="javascript:assignChecksum();">-->
	<div id="page-wrap" style="float:left;">
	<div id="tabs">
		<ul>
			<li><a href="#fragment-<?=$frg_s?>" id="ship"></a></li>
			<li><?=$aaa;?></li>
			
		</ul>
		<div id="fragment-1" class="ui-tabs-panel" style="height:100%">
			<div class="container">
				<form action="" method="post">
					<table  height="100%" style=" width:52%; ">
					  <tr><th scope="col" colspan="2" style="text-align:left;" class="ship_title"><b>Enter a shipping address</b></th></tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
					  <tr>
						<th >Pin Code: *</th>
						<td><input type="text" name="zip" value="<?=$request['zip']?>" class="input" required="" /></td>
					  </tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
					  <tr>
						<th >Full Name: *</th>
						<td><input type="text" name="name" value="<?=$request['name']?>" required=""/></td>
					  </tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
					  <tr>
						<th >Shipping Address: *</th>
						<td>
							<textarea name="s_add" style="width:150px ;height:30px;" required=""><?=$request['s_add']?></textarea>
						</td>
					  </tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
					  <tr>
						<th >Nearest Landmark:</th>
						<td><input type="text" name="l_mark" value="<?=$request['l_mark']?>" /></td>
					  </tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
						<tr>
						<th scope="row">Country: *</th>
						<td>
							<select name="country" id="select-country" 
								onChange="ajax_call('ajaxCall',{location_id:this.value,location_type:1}
								, 'state')" required="">
								<option value="">Select Country</option>
								<?php
								foreach ($objAllCountries AS $CountryDetails) {
									if($_REQUEST['country'] == $CountryDetails->location_id)
									{
										echo '<option value="' . $CountryDetails->location_id . '">'
										 . $CountryDetails->name . '</option>';
									}
									else
									{
										echo '<option value="' . $CountryDetails->location_id . '">'
									 . $CountryDetails->name . '</option>';
									}
								}
								?>
							</select>
						</td>
					  </tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
					  <tr>
						<th scope="row">State: *</th>
						<td>
							<select name="state" id="state" onChange="
							ajax_call('ajaxCall',{location_id:this.value,location_type:2},
							 'city')" required="">
							</select>
						</td>
					  </tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
					   <tr>
						<th scope="row">City: *</th>
						<td><select name="city" id="city" style="width: 200px;" required=""></select></td>
					  </tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
					  <tr>
						<th scope="row">Mobile: *</th>
						<td><input type="text" name="mobile" value="<?=$request['mobile']?>" required=""/></td>
					  </tr>
					   <tr><th scope="col" colspan="2">&nbsp;</th></tr>
					  <tr>
						<th scope="row">Land Line:</th>
						<td><input type="text" name="l_line" value="<?=$request['l_line']?>" /></td>
					  </tr>
					  <tr><th scope="col" colspan="2">&nbsp;<input type="hidden" name="phase" value="<?=$phase?>" /></th></tr>
					  <tr><th scope="col" colspan="2" style="text-align:center;"><input type="submit" name="procced" class="btn" value="Next" /></th></tr>
					</table>
        
				</form>
				
			</div>
			<div id="loading"></div>
		</div>
		<div id="fragment-2" class="ui-tabs-panel <?=$class;?>">
		
			<form name="money" action="" method="post" id="FORM_ID">
		<table style="we" align="center" >
			<tr><td colspan="2" class="td_title"><B>Your Transaction Information</B></td></tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td class="td_title" align="left"><h3>Your Current Wallet Amount</h3></td>
				<td class="gfsdskjldfhidsfh" align="left"> $   <?php echo get_wallet_amount($id);  ?></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td class="td_title" align="left"><h3>Total Purchase</h3></td>
				<td align="left"> $  <?php echo $toal_item_price;  ?></td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
			<?php
					if(1)//get_wallet_amount($id)>=$toal_item_price
					{
					?>
					
						<td class="td_title"><h3>Payment Mode :</h3></td>
						<td align="left">
							<select name="p_mode" required id="select13">
								<option value="">Select Mode</option>
								
								<!--<option value="2">ebs</option><option value="1">paytm</option>-->
								<option value="0">Wallet</option>
							
							</select><br><br><input type="submit" name="continue" value="Continue" class="button"  />
						</td>
					
					
					<?php
					}
					else
					{
						print "<td colspan=2 align=\"left\"><font color='#ff0000'>Low Balance !!</font></td>";
					}
					?>
			</tr>
		  	<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td colspan="2" align="center">
					<input type="hidden" name="email" value="<?= $email;?>" />
					<input type="hidden" name="name" value="<?= $request['name']?>" />
					<input type="hidden" name="zip" value="<?= $request['zip']?>" />
					<input type="hidden" name="s_add" value="<?= $request['s_add']?>" />
					<input type="hidden" name="l_mark" value="<?= $request['l_mark']?>" />
					<input type="hidden" name="country" value="<?= $request['country']?>" />
					<input type="hidden" name="state" value="<?= $request['state']?>" />
					<input type="hidden" name="city" value="<?= $request['city']?>" />
					<input type="hidden" name="mobile" value="<?= $request['mobile']?>" />
					<input type="hidden" name="l_line" value="<?= $request['l_line']?>" />
					<input type="hidden" name="price" value="<?= $toal_item_price?>" />
					<input type="hidden" name="ebs_prd" value="<?= $pur_prod?>" />
					<input type="hidden" name="ebs_pur_quantity" value="<?= $pur_quantity?>" />
					<input type="hidden" name="redirect_url" value="index.php?page=product_shop">
				</td>   
			</tr>
		 </table>
		
	</form>
		</div>
	</div>
</div>	
		
	<?php 
}
else
{	
	$item_arr = $_SESSION['item'];
	$new_item_arr = array();
	$cnt_item = 1;
	$count_item_arr = array_count_values($item_arr);
	 for($i = 0; $i < count($item_arr); $i++)
	 {
		$item = $item_arr[$i];
		if(!in_array($item,$new_item_arr))
		{
			$new_item_arr[] = $item;
		}
	 }
	if(count($item_arr) > 0)
	{
	?> 
		<table width="100%">
		<tr><th>&nbsp;</th><th>Unit Price</th><th>Quantity </th><th>Sub Total</th></tr>
		<tr>
			<td colspan="4">
				<div style="background:#b80000; height:3px; color:#b80000; margin:5px 0 5px 0;"></div>
			</td>
		</tr>
		<?php
		$toal_item_price = 0;
		 for($i = 0; $i < count(array_unique($_SESSION['item'])); $i++)
		 {	
			$item = $new_item_arr[$i];
			$q = mysql_query("select * from shopping_product where id='$item'");
			
			while($rr = mysql_fetch_array($q))
			{
				print "
					<tr>
					<td valign=\"top\">
						<div style=\"float:left; \">
							<img src=\"images/product/".$rr['pro_image']."\" height=120 width=150 />
						</div>
						<div  style=\"float:left;padding-left:10px;\" class=\"pull-left\" id=\"item_id\">".$rr['p_name']."</div>
					</td>
					<td style=\"padding:5px; width:100px;color:#000;\">".$rr['p_price']."</td>";
			?>		<td style="padding:5px; width:100px;color:#000;">
					<form action="index.php?page=add_quantity" method="post" name="cart_quantity">
						<input type="hidden" name="id" value="<?=$item;?>" />
						<div style="width:100px;">
							<div style=" float:left;">
							<input  id="qunt_item" onKeyUp="quantity_in_numeric(this)" type="text" value="<?=$count_item_arr[$item]?>" style="width:20px;" name="qunt_item" />
							</div>
							<div style="float:left; margin-left:5px;">
								<div style="height:7px;">
									<a href="index.php?page=add_quantity&qunt_item=<?=$count_item_arr[$item]+1?>&id=<?=$item;?>">
										<i class="icon-sort-up"></i>
									</a>
								</div>
								<div style="height:7px;">
									<a href="index.php?page=add_quantity&qunt_item=<?=$count_item_arr[$item]-1?>&id=<?=$item;?>">
										<i class="icon-sort-down"></i>
									</a>
								</div>
							</div>
						</div>	
					</form>	
					</td>
					<td style="font-size:14px;"><B><?=$count_item_arr[$item]*$rr['p_price'];?></B></td>
						<?php
				print"</tr>
				<tr><td colspan=\"4\">&nbsp;</td></tr>
				<tr><td colspan=\"4\"><hr /></td></tr>";
				$toal_item_price = $toal_item_price + ($count_item_arr[$item]*$rr['p_price']);
			}
		 }
		 ?>
			 <tr>
			 	<td colspan="4" style="text-align:right;font-size:14px;">
					<B>Payable Amount (<?=count($item_arr);?> items): <?=$toal_item_price;?></B>  
				</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align:center;">
				<div style="float:left; width:250px;">
				<form action="index.php?page=product_shop" method="post">
					<input type="Submit" name="continue" value="Continue To Purchase" class="btn" />
				</form>
				</div>
			<?php 
				if(count($item_arr) > 0)
				{
			?>
				<div style="float:left; width:250px;">
					<form action="index.php?page=view_cart" method="post">
					<input type="Submit" name="procced" value="Proceed To Checkout" class="btn btn-info" />
					</form>
				</div>
			<?php 
				} 
			?>
				</td>
			</tr>
		</table>
<?php	}
		else
		{ ?>
			<p style="color:#FF0000; font-size:12px; font-weight:bold;">Cart is Empty !!</p>
			<div style="float:left; width:250px;">
				<form action="index.php?page=product_shop" method="post">
					<input type="Submit" name="continue" value="Continue To Purchase" class="button" />
				</form>
			</div>	
<?php 	}
} 
?>
</div>
