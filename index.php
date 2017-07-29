<?php
session_start();
ini_set('display_errors','off');
include("config.php");
// $lang = $_REQUEST['lang'];

// if($lang == 'Spanish') {
// 	unset($_SESSION['language']);
// 	$_SESSION['language']  = 'language/sp.php'; 
// } elseif($lang == 'French') {
// 	unset($_SESSION['language']);
// 	$_SESSION['language']  = 'language/fr.php'; 
// } elseif($lang == 'English') {
// 	unset($_SESSION['language']);
// 	$_SESSION['language']  = 'language/en.php'; 
// }

// if(!isset($_SESSION['language'])) {
// 	$_SESSION['language'] = "language/en.php";
// }
// include $_SESSION['language'];

if($_SESSION['ebank_user_login'] != 1) {
	include("login.php");
	die;
}

if($_SESSION['biz_ective_client_ip_blocked'] == 1){
	 ?>
<font size="+2" style="color:#FF0000; padding-top:500px;"><center><strong>You Can't Logged in because, You are Not Authorised !!!<</strong></center></font>

<?php 
	die; 
}

$qu = mysql_query("select * from income_process where id = 1 ");
while($r = mysql_fetch_array($qu)){
	$process_mode = $r['mode'];
}

if($process_mode == 1) { ?>
<strong style="color:#FF0000">Sorry Site is In Under Process !!!<br />Please Try Again Leter !</strong>
<?php 
} else {
$query = mysql_query("SELECT * FROM users WHERE id_user = '".$_SESSION['ebank_user_id']."' ");
global $user_global_type;
while($row = mysql_fetch_array($query)) {
	$user_global_type = $row['type'];
}
include("function/setting.php");	
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>System - vWallet Community</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- Bootstrap 3.3.2 -->
<link href="<?=$url_local;?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />    
<!-- FontAwesome 4.3.0 -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons 2.0.0 -->
<link href="https://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />    
<!-- Theme style -->
<link href="<?=$url_local;?>/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<!-- AdminLTE Skins. Choose a skin from the css/skins 
 folder instead of downloading all of them to reduce the load. -->
<link href="<?=$url_local;?>/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<!-- iCheck -->
<link href="<?=$url_local;?>/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
<!-- Morris chart -->
<link href="<?=$url_local;?>/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<!-- jvectormap -->
<link href="<?=$url_local;?>/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<!-- Date Picker -->
<link href="<?=$url_local;?>/plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<!-- Daterange picker -->
<link href="<?=$url_local;?>/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<!-- bootstrap wysihtml5 - text editor -->
<link href="<?=$url_local;?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
<link href="<?=$url_local;?>/css/provide.css" rel="stylesheet" type="text/css" />
<link href="<?=$url_local;?>/dist/css/skins/newlayout_design.css" rel="stylesheet" type="text/css" />
<style>
.table-responsive{-webkit-overflow-scrolling: touch;}
.table-responsive .table {
    max-width: none;
}
</style>
<!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
<script type="text/javascript" src="<?=$url_local;?>/js/print.js"></script>
<script type="text/javascript" src="<?=$url_local;?>/js/jquery_002.js"></script>
<script type="text/javascript" src="<?=$url_local;?>/js/bootstrap.js"></script>
<script type="text/javascript" src="<?=$url_local;?>/js/remaining.js"></script>
<script type="text/javascript" src="<?=$url_local;?>/js/fn_number_format.js"></script>
<script type="text/javascript" src="<?=$url_local;?>/js/2701431551e89e890baf8fae579f4d11.js"></script>
<script src="<?=$url_local;?>/js/pagenavigation.js"></script>
<script src="<?=$url_local;?>/js/simple-converter.js"></script>
<script type="text/javascript">
	var _gNow = new Date();
</script>


<script type="text/javascript">
jQuery(document).ready(function($){
	var gdBtn = $('#gdBtn');
	var pdBtn = $('#pdBtn');
	
	pdBtn.click(function(){
		$(this).toggleClass('active');
		gdBtn.removeClass('active');
		$('#pdWrap').stop(true, false).slideToggle('fast');
		$('#gdWrap').stop(true, false).slideUp('fast').removeClass('open');
		return false;
	});
	// if user status is freeze or just unblock and not yet do the maintain
	gdBtn.click(function(){
		$(this).toggleClass('active');
		pdBtn.removeClass('active');
		$('#gdWrap').stop(true, false).slideToggle('fast');
		$('#pdWrap').stop(true, false).slideUp('fast').removeClass('open');
		return false;
	});
});
</script>
<script>
function digclock()
{
	var d = new Date();
	var t = d.toLocaleTimeString();
	document.getElementById("clock").innerHTML = t;
	//document.getElementById("clock1").innerHTML = t;
}
setInterval(function(){digclock()},1000);
</script>

<script type="text/javascript">
jQuery(document).ready(function($){
	var pin_message = "You need {quantity} e-PIN for";
		$('#maintain_back_btn, #pd_back_btn, #gd_back_btn').click(function(){
		$('input[name=__req]').val('start'); //back to starting step
	});
	var req_pin = parseInt($('#pd_amount').val()* <?=$plan_diff?>);
	$("#pd_pin_group").hide();
	$("#pd_pin").text(pin_message.replace("{quantity}", 1)+" "+format_monetary_value(req_pin));
	$("input[name=from_wallet]").change(function() {
		if($(this).val() == 'cwallet') {
			$("#minimum_amount").text("3,300,000");
		} else {
			$("#minimum_amount").text("6,600,000");
		}
	});
	
	$("#show_pd_amount").html('2,900,000');
	$("#show_gd_amount").html('0');
	
	$("#pd_amount").change(function(){
		$("#show_pd_amount").html(format_monetary_value($(this).val()) + " = " + format_monetary_value($(this).val() * <?=$plan_diff?>));
		var req_pin = parseInt($(this).val()* <?=$plan_diff?>);
		if($(this).val() > <?=$epin_value?> && ($(this).val())%<?=$epin_value?> == 0){
		 $("#pd_pin").text(pin_message.replace("{quantity}", ($(this).val() )/<?=$epin_value?>)+" "+format_monetary_value(req_pin));
			$("#pd_epin").html("");
		}else if($(this).val() >= <?=$epin_value?>){
			$("#pd_pin").text(pin_message.replace("{quantity}", 1)+" "+format_monetary_value(req_pin));
		}
		else if($(this).val() < <?=$epin_value?>){
			$("#pd_epin").html("");
			$("#pd_pin_group").hide();
			$("#pd_pin").text(pin_message.replace("{quantity}", 0)+" "+format_monetary_value(0));
		}
		$.post( "chk_pin.php", { pin: req_pin/<?=$epin_value?>})
		  .done(function( data ) { 
			if(data){alert(data);}
		  });
	});
	$("#gd_amount").keyup(function(){
		$("#show_gd_amount").html(format_monetary_value($(this).val()).substring(0) + " = " + format_monetary_value($(this).val() * <?=$plan_diff?>));
	});
	
});
</script>
<style>
.pd_epin{
margin-top:5px; margin-left:10px;
}</style>
<link rel="stylesheet" href="<?=$url_local;?>/css/tabs.css" type="text/css" media="screen, projection"/>
<link rel="stylesheet" href="<?=$url_local;?>/css/jquery.ui.css" type="text/css"/>
<script src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?=$url_local;?>/js/countrylist.js" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
	var $tabs = $('#tabs').tabs();
	$(".ui-tabs-panel").each(function(i){
		var totalSize = $(".ui-tabs-panel").size() - 1;
		if (i != totalSize) {
			next = i + 2;
		}
		if (i != 0) {
			prev = i;
		}
	});

	$('.next-tab, .prev-tab').click(function() { 
		$tabs.tabs('select', $(this).attr("rel"));
		return false;
	});
	
	$(function() {
		startRefresh();
	});

	function startRefresh() {
    	setTimeout(startRefresh,1000);
		var s_id = $("#s_id").val();
		var r_id = $("#r_id").val();
	    $.get("data/ajaxsubmit.php?s_id="+s_id+"&r_id="+r_id, function(data) {
	        $('#chat_res').html(data);    
	    });
	}

</script>

<script src="<?=$url_local;?>/js/jquery.treeview.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.downline_tree').treeView();
})
</script>

</head>
<body class="skin-blue">
<div class="wrapper">
	<?php 
	include 'header.php';
	include 'sidebar.php'; 
	include 'middle.php'; 
	include 'footer.php';
	?>
	<div id="chat_box" class="chat_box" style="position: fixed; padding: 10px; top: 24%; top: -300px; left:25%; z-index: 999; opacity: 0.9;">
<style>
.chat_log
{ 
	width:500px;
	min-height:248px;
	border:solid 1px #C7D5E0;
	background: bottom left #FEFEFF repeat-x;
} 
.chat_log{
	background-color: #fff;
	border: 1px solid #E9E9E9;
	border-radius: 4px;
	padding: 10px;
	overflow: hidden;
}	
#chat_res{
	border: 1px solid #D5D5D5;
	padding: 5px;
}
#msg_text{
	margin-top:15px;
	
}
#msg_text textarea{
	margin:0px;
	padding: 5px;
	border: 1px solid #D5D5D5;
}
input#chat_submit{
	background-color: #43B515 !important;
	border-radius: 0;
	border: 1px solid #43B515;
}
input.closer-chat{
	margin-left: 10px;
	border-radius: 0;
	border: 1px solid #CCCACB;
	background-color: #fff !important;
}
span.btn-file{
	margin-left: 10px;
	border-radius: 0;
	background-color: #4BADFF !important;
	border: 1px solid #4BADFF;
}
</style>
<div class="chat_log" >
	
	<div id="chat"></div>
	<div id="chatlogContentArea" > </div>
</div>
 
 </div>
</div>

<!-- jQuery 2.1.3 -->
<!--Removed below Jquery reason for logout Matter
<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>-->
<!-- jQuery UI 1.11.2 -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!--<link rel="stylesheet" type="text/css" href="css/style.css" />-->
<link rel="stylesheet" type="text/css" href="<?=$url_local;?>/js/jquery/plugins/simpleTree/style.css" />
<script type="text/javascript" src="<?=$url_local;?>/js/jquery/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=$url_local;?>/js/jquery/plugins/simpleTree/jquery.simple.tree.js"></script>
<script type="text/javascript" src="<?=$url_local;?>/js/langManager.js" ></script>
<script type="text/javascript" src="<?=$url_local;?>/js/treeOperations.js"></script>
<script type="text/javascript" src="<?=$url_local;?>/js/init.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?=$url_local;?>/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>    
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?=$url_local;?>/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?=$url_local;?>/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?=$url_local;?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="<?=$url_local;?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?=$url_local;?>/plugins/knob/jquery.knob.js" type="text/javascript"></script>
<!-- InputMask -->
<script src="<?=$url_local;?>/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?=$url_local;?>/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?=$url_local;?>/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="<?=$url_local;?>/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- datepicker -->
<script src="<?=$url_local;?>/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=$url_local;?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?=$url_local;?>/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="<?=$url_local;?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='<?=$url_local;?>/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="<?=$url_local;?>/dist/js/app.min.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=$url_local;?>/dist/js/pages/dashboard.js" type="text/javascript"></script>

    <!-- AdminLTE for demo purposes -->
<script src="<?=$url_local;?>/dist/js/demo.js" type="text/javascript"></script>

<br>
<script>
$('#menu1').click(function (e){
	$( "#result" ).load( "index.php?page=edit-password" );	
});
</script>

<script type="text/javascript" src="<?=$url_local;?>/js/future.js"></script>
</body>
</html>
<?php } ?>