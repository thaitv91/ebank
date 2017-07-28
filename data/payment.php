<?php
session_start();
ini_set("display_errors","off");
include("condition.php");
include("function/functions.php");
include("function/setting.php");
include("function/income.php");
//include("function/pair_point_calc_new.php");
if($_SESSION['success'] == 1)
{
	print "<br>Product Successfully Purchase !!";
	unset($_SESSION['success']);
}
	?>

<h1>Shopping Cart</h1>
<div id="page_content">
<?php
 $id = $_SESSION['ebank_user_id'];


if(isset($_REQUEST['continue']) and $_REQUEST['p_mode'] == 0)
{
	
	$date = $systems_date;
	$time = date("H:i:s");
	$item_arr = $_SESSION['item'];
	$new_item_arr = array();
	$cnt_item = 1;
	$count_item_arr = array_count_values($item_arr);
	$pay_mode = $_REQUEST['p_mode'];
	//print_r($count_item_arr);
	 for($i = 0; $i < count($item_arr); $i++)
	 {
		$item = $item_arr[$i];
		if(!in_array($item,$new_item_arr))
		{
			$new_item_arr[] = $item;
		}
	 }
							
	$toal_item_price = 0;
	$toal_item_bv =0;
	$purchase_quantity = '';
	$purchase_item = '';
	
	 for($i = 0; $i < count(array_unique($_SESSION['item'])); $i++)
	 {	
		$seprator = "-";
		$item = $new_item_arr[$i];
		$q = mysql_query("select * from shopping_product where id='$item'");
		
		while($rr = mysql_fetch_array($q))
		{
			if($i == 0)
			{
				$seprator = "";
			}
			$toal_item_price = $toal_item_price + ($count_item_arr[$item]*$rr['p_price']);
			
			$purchase_quantity .= $seprator.$count_item_arr[$item];
			$purchase_item .= $seprator.$item;
			$toal_item_bv = $toal_item_bv + ($count_item_arr[$item]*$rr['bv']);
		}
	 }
	// print "&nbsp;I= ".$purchase_item."&nbsp;Q= ".$purchase_quantity;
	if(get_wallet_amount($id) >= $toal_item_price)
	{
		do {
				$random_number = substr(md5(rand(0, 1000000)), 0, 8);
				$query_object = mysql_query( "SELECT 1 FROM prd_order WHERE order_id = $random_number");
				$query_record = mysql_fetch_array($query_object);
				if(! $query_record) {
					break;
				}
			} while(1);
		$p_order_id = $random_number;
		$sql = "update wallet set amount=amount-$toal_item_price where id='$id'";
		mysql_query($sql);
		$sql_order = "insert into prd_order (order_id,product_id, user_id,quantity,amount, date, time) 
						  values('$p_order_id','$purchase_item', '$id', '$purchase_quantity','$toal_item_price', '$date', '$time')";
			mysql_query($sql_order);
			
			$sql_order_retrive = "select id from prd_order where user_id = '$id' 
			order by id desc limit 1";
			$query_order_retrive = mysql_query($sql_order_retrive);
			while($rr = mysql_fetch_array($query_order_retrive))
			$order_id = $rr['id'];
			
			$sql_invoice = "insert into prd_invoice (order_id, mode,pay_mode) 
						  values('$order_id', '0','$pay_mode ')";
			mysql_query($sql_invoice);
			
			$request_ship = $_REQUEST;
			do 
			{
				$random_number = substr(md5(rand(0, 1000000)), 0, 9);
				$query_object = mysql_query( "SELECT 1 FROM shipping WHERE track_id = $random_number");
				$query_record = mysql_fetch_array($query_object);
				if(! $query_record) {
					break;
				}
			} while(1);
			$track_id = $random_number;
			
			$sql_ship = "insert into shipping (order_id, track_id, ship_address, name, zip, l_mark, country, 	state, city, phone1, phone2) 
						  values('$p_order_id', '$track_id' , '".$request_ship['s_add']."','".$request_ship['name']."',
						   '".$request_ship['zip']."','".$request_ship['l_mark']."', 
						   '".$request_ship['country']."','".$request_ship['state']."',
						   '".$request_ship['city']."','".$request_ship['mobile']."',
						   '".$request_ship['l_line']."')";
			mysql_query($sql_ship);
			
			$w_bal = get_wallet_amount($id);
			insert_wallet_account($id , $id , $toal_item_price , $date , $acount_type[5] , $acount_type_desc[5], 2 , $w_bal);
			
			/*distribute_upline_network_income($id,$toal_item_bv);
			set_upline_pair_point_income($id , $toal_item_bv,$date);*/
			//calculate_three_level_income($id,get_user_rank($id),$date);
			$_SESSION['item'] = '';
			$_SESSION['cart'] = '';
			unset($_SESSION['item']);
			unset($_SESSION['cart']);
			$_SESSION['success'] = 1;
			echo "<script type=\"text/javascript\">";
			echo "window.location = \"index.php?page=product_shop\"";
			echo "</script>";
	}
	else
	{
		$_SESSION['item'] = '';
		$_SESSION['cart'] = '';
		unset($_SESSION['item']);
		unset($_SESSION['cart']);
		$_SESSION['error'] = 1;
		echo "<script type=\"text/javascript\">";
		echo "window.location = \"index.php?page=product_shop\"";
		echo "</script>";
	}
		
}
if(isset($_REQUEST['continue']) and $_REQUEST['p_mode'] == 1)
{
	print "Pay Processr";
}
?>
</div>
