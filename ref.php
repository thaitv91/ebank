<script type='text/javascript' src='plugins/jQuery/jquery.js'></script>
<script type="text/javascript">
    $(document).ready(function(){
		$(".box_rec").hide();
		$(".epin_rec").show();
        $('input[type="radio"]').click(function(){
	        if($(this).attr("value")=="admin"){
		        $(".box_rec").hide();
	            $(".cash_rec").show();
	        }

	        if($(this).attr("value")=="epin"){
		        $(".box_rec").hide();
	            $(".epin_rec").show();
	        }
        });
    });
</script>

<style type="text/css">
    .box_rec{ display: none; }
    .cash_rec{ background: none; }
    .epin_rec{ background: none; }
</style>

<?php
session_start();
ini_set("display_errors",'off');
include 'config.php';

$date = $systems_date;
$t = date('h:i:s');

if(isset($_POST['submit']))
{
	$mno = $_REQUEST['mno'];
	$amo = $_SESSION['amo'] = $_REQUEST['amo'];
	$pin = $_REQUEST['pin'];
	$opr = $_REQUEST['opr'];
	$rech_type = $_REQUEST['rech_type'];
	$id = $_SESSION['user_id'];
	
	if($rech_type == 'mobile')
		$rec_t = 1;
	else
		$rec_t = 2;
	
	if($id > 0)
	{
		$recharge_sql = "insert into recharge_history (user_id, mobile_no, operator, amount, date, time , recharge_type, mode , referral) values ('$id', '$mno', '$opr', '$amo', '$date', '$t', '$rec_t', '1' , '1' ) ";
		mysql_query($recharge_sql);
		print "Successfully Recharge !!";				
		unset($_SESSION['user_id']);
	}	
}

else {
	$get_uname = $_REQUEST['ref'];
	$sql = "select id_user from users where username = '$get_uname' ";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	$result = mysql_fetch_array($query);
	
	if($num > 0) {
		$_SESSION['user_id'] = $result[0];
	?>
		<table id="table-1" class="table table-striped table-hover dataTable">
		<tr>
			<td colspan="2">
				<input type="radio" name="investmentmode"  value="epin" checked="checked"  /> Mobile  
				<input type="radio" name="investmentmode"  value="admin" /> DTH
			</td> 
		</tr>
		<tr>
			<td class="epin_rec box_rec" colspan="2">
				<form name="invest" method="post" action="">
					<table class="table table-striped table-hover dataTable">
						<tr>
							<td><strong>Mobile Number:   </strong></td>
							<td><input type="text" value="" name="mno" maxlength="10" id="mno"onKeyUp="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" required></td>
						</tr>
						<tr>
							<td><strong>Amount:  </strong></td>
							<td><input id="amo" type="text" name="amo" required></td>
						</tr>
						<tr>
							<td><strong>Operator:  </strong></td>
							<td>  
								<select name="opr" required>
									<option value="">--Operator--</option>
									<option value="AIRCEL">AIRCEL</option>
									<option value="AIRTEL">AIRTEL</option>
									<option value="BSNL">BSNL</option>
									<option value="IDEA">IDEA</option>
									<option value="MTNL">MTNL</option>
									<option value="MTS">MTS</option>
									<option value="RELIANCE CDMA">RELIANCE CDMA</option>
									<option value="RELIANCE GSM">RELIANCE GSM</option>
									<option value="T24">T24</option>
									<option value="TATA DOCOMO">TATA DOCOMO</option>
									<option value="TATA INDICOM">TATA INDICOM</option>
									<option value="Uninor">Uninor</option>
									<option value="Videocon">Videocon</option>
									<option value="VIRGIN CDMA">VIRGIN CDMA</option>
									<option value="VIRGIN GSM">VIRGIN GSM</option>
									<option value="VODAFONE">VODAFONE</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center">
								<input type="hidden" name="rech_type" value="mobile" />
								<input type="submit" name="submit" value="TOPUP" class="btn btn-success" />
							</td>
						</tr>
					</table>
				</form>	
			</td>
			<td class="cash_rec box_rec" colspan="2">
				<form name="invest" method="post" action="">
					<table class="table table-striped table-hover dataTable">
						<tr>
							<td><strong>Select DTH Provider:</strong>  </td>
							<td align="left">
								<select id="opr"  name="opr" required>
									<option value="">--Select--</option>
									<option value="AIRTEL DIGITAL TV">AIRTEL DIGITAL TV</option>
									<option value="BIG TV">BIG TV</option>
									<option value="DISH TV">DISH TV</option>
									<option value="SUN DIRECT">SUN DIRECT</option>
									<option value="TATA SKY">TATA SKY</option>
									<option value="VIDEOCON D2H">VIDEOCON D2H</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><strong>Subscriber Number:</strong>  </td>
							<td align="left"><input id="mno" type="text" value="" name="mno" required></td>
						</tr>
						<tr>
							<td><strong>Amount:  </strong></td>
							<td><input id="amo" type="text" name="amo" required></td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center">
								<input type="hidden" name="rech_type" value="dth" />
								<input type="submit" name="submit" value="TOPUP" class="btn btn-success" />
							</td>
						</tr>
					</table>
				</form>
			</td>
		</tr>
	</table>
	<?php
	} else {
		print "Invalid Referral !!";
	}
}
?>	