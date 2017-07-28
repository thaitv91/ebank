<?php
session_start();
include("condition.php");
include("function/e_pin.php");
include("function/setting.php");
include("function/functions.php");
include("function/send_mail.php");
$user_id = $_SESSION['ebank_user_id'];

$allowedfiletypes = array("jpg","png");
$uploadfolder = $path;
$uploadfolder = $uploadfolder."/images/epin_pay_receipt/" ;
if(isset($_POST['submit']))
{
	$epin_number = $_POST['epin_number'];
	$user_pin = $_POST['user_pin'];
	$Amount = $_POST['amount'];
	?>
	<div class="col-md-12">
	<div class="callout callout-info">
		<p style="font-size:16px; font-weight:bold;">
			<div class="widget-body">
				<p class="help-block">
					<label class="control-label" style="color:#FFf;">Admin  Account Details</label>
				</p>
				<form action="" method="post" enctype="multipart/form-data">
				<?php
				$query1 = mysql_query("select * from admin_bank ");
				while($rowa = mysql_fetch_array($query1))
				{
					print "<span style=\"color:#000\">Bit Coin A/C -</span><span style=\"color:#fff\">  ".$rowa['bitac_no']."</span>";		
					print "<br>";
					print "<span style=\"color:#000\">Perfect Money A/C -</span><span style=\"color:#fff\">  ".$rowa['perfectac_no']."</span>";	
					print "<br>";
					print "<span style=\"color:#000\">Payza A/C - </span><span style=\"color:#fff\">  ".$rowa['payzaac_no']."</span>";
					print "<br>
					<input type=\"file\" name=\"slip\" />
					";

				}
				print "<span style=\"color:#ff0000\">Please Pay Epin Amount on above Admin Account!! </span>";
				?>
				<p class="help-block">
					<label class="control-label" style="color:#FFf;">
					 
						<input type="hidden" name="epin_number" value="<?=$epin_number;?>" />
						<input type="hidden" name="user_pin" value="<?=$user_pin;?>" />
						<input type="hidden" name="amount" value="<?=$Amount;?>" />
						<p class="help-block" align="center">
							<input type="submit" name="next_submit" value="Confirm" class="btn btn-success" />
						</p>
					</label>
				</p>
				</form>
			</div>
		</p>
		</div>
	</div>
	<?php
}
elseif(isset($_POST['next_submit']))
{
	if($_SESSION['generate_pin_for_user'] == 1)
	{
		//$epin_number = $_POST['epin_number'];
//		$epin_amount = $_POST['epin_number']*$epin_value;
		$user_pin = $_POST['user_pin'];
		$_SESSION['generate_pin_for_user'] = 0;
		$epin_number = $_POST['amount']/$epin_value;
		$amount = $_POST['amount'];
		$epin_number = $_POST['epin_number'];	
		$sql = "select * from users where id_user = '$user_id' and user_pin ='$user_pin' ";
		$q = mysql_query($sql);
		$num = mysql_num_rows($q);
		if($_POST['amount']%$epin_value == 0){
			if($num != 0)
			{
				while($rt = mysql_fetch_array($q)){
					$user_level = $rt['level'];
				}
				$epin_c1 = max_epin_complete($user_id,$user_level,$systems_date,'month',$epin_number);
				$epin_c2 = max_epin_complete($user_id,$user_level,$systems_date,'week',$epin_number);
				$epin_c3 = max_epin_complete($user_id,$user_level,$systems_date,'day',$epin_number);
				
				if($epin_c1 or $epin_c2 or $epin_c3){
					echo "<script type=\"text/javascript\">";
					echo "window.location = \"index.php?page=epin_request&pay_err=3\"";
					echo "</script>";
				}
				$date = $systems_date_time;
				if(!empty($_FILES['slip']['name'])){
					$uploadfilename = $_FILES['slip']['name'];
					$fileext = strtolower(substr($uploadfilename,strrpos($uploadfilename,".")+1));
					if(!in_array($fileext,$allowedfiletypes)) 
					{
						echo "<script type=\"text/javascript\">";
						echo "window.location = \"index.php?page=epin_request&pay_err=1\"";
						echo "</script>"; 
					}
					else{
						$unique_time = rand(10000000,99999999);
						$unique_name =	"Ebank.Tv_EP".$unique_time.$user_id;
						$fulluploadfilename = $uploadfolder.$unique_name.".".$fileext;
						$unique_name = $unique_name.".".$fileext;
						if(copy($_FILES['slip']['tmp_name'], $fulluploadfilename))
						{
							mysql_query("insert into epin_request (user_id, plan_id , no_pin , date,photo) 
								values ('$user_id' ,'$epin_amount','$epin_number','$date','$unique_name')");
							/*$epin_generate_username = "rapidforx2";
							$epin_amount = $fees;
							$payee_epin_username = $mew_user;
							$title = "E-pin mail";
							$to = get_user_email($new_user_id);
							$from = 0;
							
							$db_msg = $epin_generate_message;
							include("../function/full_message.php");
								
							$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);
							$SMTPChat = $SMTPMail->SendMail();*/
							print "E pin Request Send Successfully To Admin !";	
						}
					}
				}
				else{
					echo "<script type=\"text/javascript\">";
					echo "window.location = \"index.php?page=epin_request&pay_err=2\"";
					echo "</script>";
				}
			}
			else { echo "<B style=\"color:#ff0000;\">Enter Correct Password !!</B>"; }	
		}
		else { echo "<B style=\"color:#ff0000;\">Enter Valid Amount Multiple of $epin_value !!</B>"; }	
	}
	else{ echo "<B style=\"color:#ff0000;\">There are some conflicts !!</B>"; }
}
else
{  $_SESSION['generate_pin_for_user'] = 1;
	if(isset($_REQUEST['pay_err']) and $_REQUEST['pay_err'] == 3){
		echo "Pin request limit is over for one day !!";
	}
	?>
	<form action="" method="post">
	<?php 
	for($i = 1; $i < 6; $i++)
	{
		$chk = "";
		if($i == 1){ $chk = "checked=\"checked\""; }
		?>
		<div class="input-small pr_li span3" id="checkboxGroup">
			<div align="center" class="pack">
				<div class="inner"><?=$t = 4*$i?> Epin<br />Package</div>
			</div>
			<div id="caption" align="center">
				<div class="description"><?php //$r['description']; ?></div>
				<div class="price" align="center">$<?=$tt=$t*$epin_value;?></div>+10% VAT
				<div align="center">
					<input type="checkbox" <?=$chk?> name="epin_number" value="<?=$t;?>" />
				</div>
			</div>
		</div>
		<?php
	} ?>

	<div class="widget-body">
		<p class="help-block" align="center" style="padding-right:38px;">
			<label class="control-label" style="color:#000;">
			Amount 
			</label>
			<input type="text" name="amount" required="required"  />
		</p>
		<p class="help-block" align="center" style="padding-right:80px;">
			<label class="control-label" style="color:#000;">
			Security Code 
			</label>
			<input type="text" name="user_pin" required="required"  />
		</p>
		<p class="help-block" align="center">
			<input type="submit" name="submit" value="Buy Epin Package" class="btn btn-success" />
		</p>
		<p class="help-block">
		<font color="#FF0000" size="+1">NOTE : Price Per Epin $<?=$epin_value;?></font>
	</p>
	</div>
	</form>
<?php 
} ?>

<script type="text/javascript" src="js/jquery_002.js"></script>

<script>
$(function(){
	$('#checkboxGroup input[type=checkbox]').change(function() {
	if (this.checked) {
		$('#checkboxGroup input[type=checkbox]').not(
			$(this)).prop('checked', false);
		}
	});
});
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
	min-height:200px;
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

.pack{
	display: block;
	position: relative;
	padding:10px;
	width: 80%;
	height: 100px;
	background-color: #a0a39f;
	z-index:1001;
	-moz-opacity: 0.7;
	opacity:.70;
	text-align:center;
	margin:0 auto;
	filter: alpha(opacity=70);
}
.inner{
	display: block;
	position: relative;
	padding:10px;
	border:#FFFFFF dashed 1px;
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
