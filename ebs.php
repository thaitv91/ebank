<?php
ini_set("display_errors","off");
session_start();
?>

<form method="post" action="https://secure.ebs.in/pg/ma/payment/request" name="frmTransaction" id="frmTransaction">
<?php
$ebs_email=$_REQUEST['email'];
$ebs_user_name=$_REQUEST['name'];
$ebs_user_address=$_REQUEST['s_add'];
$ebs_user_zipcode=$_REQUEST['zip'];
$ebs_user_city=$_REQUEST['city'];
$ebs_user_state=$_REQUEST['state'];
$ebs_user_country=$_REQUEST['country'];
$ebs_user_phone=$_REQUEST['mobile'];
$ebs_price=$_REQUEST['price'];
$ebs_prd =$_REQUEST['ebs_prd'];
$ebs_pur_quantity =$_REQUEST['ebs_pur_quantity'];
$ebs_month =$_REQUEST['ebs_month'];
$ebs_user_id=$_SESSION['royalforexgroup_user_id'];
$modelno="M1";
$ebs_finalamount=$_REQUEST['price'];
$ebs_redirect_url=$_REQUEST['redirect_url'];
if($_REQUEST['new_user'] == 'in' and isset($_REQUEST['new_user'])) {
	$prod_id = $_REQUEST['reg_p_name'];
	$retrive_sql = "select * from product_bonus where id < 5 and  id='$prod_id'";
	$retrivequery = mysql_query($retrive_sql);
	while($p_row = mysql_fetch_array($retrivequery)) {
		$ebs_price=$p_row['amount'];
		$ebs_prd =$p_row['id'];
		$ebs_pur_quantity =1;
	}
	$ebs_return_url = $ebs_return_url[1];
} else {
	$ebs_return_url = $ebs_return_url[0];
}

do {
	$random_number = substr(md5(rand(0, 1000000)), 0, 8);
	$query_object = mysql_query( "SELECT 1 FROM prd_order WHERE order_id = $random_number");
	$query_record = mysql_fetch_array($query_object);
	if(! $query_record) {
		break;
	}
} while(1);

$ebs_order_no = $random_number;
$date = date("Y-m-d");
$time = date("H:i:s");
$sql_order = "insert into temp_order (orderId,productId, user_id,quantity,amount, date, time,purchaseMode,mode) values('$ebs_order_no','$ebs_prd', '$ebs_user_id', '$ebs_pur_quantity','$ebs_finalamount', '$date', '$time','1','0')"; 
// unpaid entry
mysql_query($sql_order);			
$sql_order_retrive = "select id from temp_order where user_id = '$ebs_user_id' order by id desc limit 1";
$query_order_retrive = mysql_query($sql_order_retrive);
while($rr = mysql_fetch_array($query_order_retrive)) 
	$order_id = $rr['id'];
			
$request_ship = $_REQUEST;
do {
	$random_number = substr(md5(rand(0, 1000000)), 0, 9);
	$query_object = mysql_query( "SELECT 1 FROM shipping WHERE track_id = $random_number");
	$query_record = mysql_fetch_array($query_object);
	if(! $query_record) {
		break;
	}
} while(1);
$track_id = $random_number;			
$sql_ship = "insert into shipping (order_id, track_id, ship_address, name, zip, l_mark, country, 	state, city, phone1, phone2) values('$p_order_id', '$track_id' , '".$request_ship['s_add']."','".$request_ship['name']."','".$request_ship['zip']."','".$request_ship['l_mark']."', '".$request_ship['country']."','".$request_ship['state']."','".$request_ship['city']."','".$request_ship['mobile']."','".$request_ship['l_line']."')";
mysql_query($sql_ship);
$ebs_hash = $ebs_key."|".$ebs_account_id."|".$ebs_price."|".$ebs_order_no."|".$ebs_return_url."|".$ebs_mode;
$ebs_secure_hash = md5($ebs_hash);
?>

<input type="hidden" name="account_id" value="<?php echo $ebs_account_id;?>"> 
<input type="hidden" name="channel" value="<?php echo $channel;?>"> 
<input type="hidden" name="currency"  value="<?='INR';?>">
<input type="hidden" name="return_url"  value="<?php echo  $ebs_return_url; ?>">
<input type="hidden" name="mode"  value="<?=$mode;?>">
<input type="hidden" name="reference_no" value="<?php echo $ebs_order_no; ?>">
<input type="hidden" name="description" value="<?php echo $modelno; ?>">
<input type="hidden" name="amount" value="<?php echo $ebs_price; ?>">
<input type="hidden" name="email" value="<?php echo $ebs_email; ?>">
<input type="hidden" name="name"  value="<?php echo $ebs_user_name; ?>">
<input type="hidden" name="address"  value="<?php echo $ebs_user_address; ?>">
<input type="hidden" name="city"  value="<?php echo $ebs_user_city; ?>">
<input type="hidden" name="state" value="<?php echo $ebs_user_state; ?>">
<input type="hidden" name="country" value="<?php echo $ebs_user_country; ?>">
<input type="hidden" name="postal_code" value="<?php echo $ebs_user_zipcode; ?>">
<input type="hidden" name="phone" value="<?php echo $ebs_user_phone; ?>">
<input type="hidden" name="user_id" value="<?php echo $ebs_user_id; ?>">
<input type="hidden" name="s_add" value="<?= $_REQUEST['s_add']?>" />
<input type="hidden" name="l_mark" value="<?= $_REQUEST['l_mark']?>" />
<input type="hidden" name="l_line" value="<?= $_REQUEST['l_line']?>" />
<input type="hidden" name="ebs_prd" value="<?php echo $ebs_prd; ?>">
<input type="hidden" name="ebs_pur_quantity"  value="<?php echo $ebs_pur_quantity; ?>">
<input type="hidden" name="ebs_price" value="<?php echo $ebs_price; ?>">
<input type="hidden" name="secure_hash" value="<?php echo $ebs_secure_hash; ?>">
<input type="hidden" name="ebs_redirect_url" value="<?php echo $ebs_redirect_url; ?>">
<input type="hidden" name="ebs_month" value="<?php echo $ebs_month; ?>">
</form>
<script type="text/javascript">
			document.frmTransaction.submit();
</script>