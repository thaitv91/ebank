<?php 

$url_sms = "http://www.smsappgw.com/WS/CMP/wservicecmp.pc.php";
$refferal_link = "http://www.smsappgw.com";
$path = getcwd();									
$payment_receipt_img_full_path = $path."/images/payment_receipt/"; 
$profile_img_full_path = $path."/images/"; 
$save_excel_file_path = $path."/admin/userinfo/";
$user_profile_folder = $path."/images/profile_image/";
$idcard_folder = $path."/images/idcard_image/";
$legal_docs_folder = $path."/images/legal/";

// investment Warning Meggage

$admin_email_title = "";
$admin_email_msg = "";
$admin_email = "";

//payumoney end
// Ge Currency

$ge_sending_url = "E:/server1/ebank.tv/ctm_transfer_check.php";
$ge_notify_url = "E:/server1/ebank.tv/business/ctm_notify.php";
$ge_return_url = "E:/server1/ebank.tv/business/index.php?page=your_investments";
$ge_cencel_url = "E:/server1/ebank.tv/business/cencel.php";
$gecurrency_payee_user_id = "rbkmoney";
$ipn_security_key = "1377477201";

// liberty
$liberty_account = 'U3114652';
$lr_currency = "$ ";
$liberty_success_url = "";
$liberty_failed_url = "";

$db_host = "localhost";
$db_username = "root";
$db_password = "thaitran";
//$db = "vwalle5_vwallet_admin";
$db = "vwallet5_vwallet_admin";
$con=mysql_connect($db_host,$db_username,$db_password);
mysql_select_db($db,$con);
mysql_query("SET NAMES 'UTF8'");

$ip_Add = $_SERVER['REMOTE_ADDR']."(".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].")";
	$datess = date('Y-m-d');
	$u_id_f_ip = $_SESSION['ebank_user_id'];
	mysql_query("insert into ips_address (user_id , ip_add , date) values ('$u_id_f_ip' , '$ip_Add' , '$datess') ");
	
$q_c_dd = mysql_query("select * from system_date where id = 1 ");
while($row_q_c_d = mysql_fetch_array($q_c_dd)) {
	$current_d = $row_q_c_d['sys_date'];
}

$systems_date =  date('Y-m-d', strtotime(" + 7 hours 44 minutes"));	
$systems_date_time = date("Y-m-d H:i:s");//,strtotime($current_d." ".date("12:10:10")));	

function data_logs($from,$title,$message,$type_data) {
	$date = date('Y-m-d');
	$time = time();
	$ip_Add = $_SERVER['REMOTE_ADDR']."(".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].")";
	mysql_query("insert into logs (title , message , user_id , date , time , type , ip_add) values ('$title' , '$message' , '$from' , '$date' , '$time' , '$type_data' , '$ip_Add') ");
}

function send_sms($mobile,$message)
{

//Change your configurations here.
//---------------------------------
$username="test";
$api_password="a6777tvyub8jrgghk";
$sender="test";
$domain="speed.bulksmspark.in";
$priority="1";// 1-Normal,2-Priority,3-Marketing
$method="POST";
//---------------------------------

$username=urlencode($username);
$password=urlencode($api_password);
$sender=urlencode($sender);
$message=urlencode($message);

$parameters="username=$username&api_password=$api_password&sender=$sender&to=$mobile&message=$message&priority=$priority";
	if($method=="POST") {
		$opts = array(
		  'http'=>array(
			'method'=>"$method",
			'content' => "$parameters",
			'header'=>"Accept-language: en\r\n" .
					  "Cookie: foo=bar\r\n"
		  )
		);
		$context = stream_context_create($opts);
		$fp = fopen("http://$domain/pushsms.php", "r", false, $context);
	} else {
		$fp = fopen("http://$domain/pushsms.php?$parameters", "r");
	}

	$response = stream_get_contents($fp);
	fpassthru($fp);
	fclose($fp);
}

$recipient_acc = 'aliencare@gmail.com';
$item_name = 'Registration';
$currency = '$ ';
$item = 'I get this information back';
$return_url = 'E:/server1/cdbv/business/index.php?page=alert_pay';
$cancel_url = 'http://alienweb.in';
$ap_test = 1;

?>