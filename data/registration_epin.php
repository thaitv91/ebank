<?php
include("condition.php");
include("function/setting.php");
include("function/send_mail.php");
include("function/functions.php");
include("function/wallet_message.php");

$id = $_SESSION['ebank_user_id'];
$position = $_SESSION['position'];

if(isset($_POST['submit']))
{
	$user_pin = $_REQUEST['user_pin'];
	$pin_no = $_REQUEST['pin_no'];
	$request_pin = $_REQUEST['request_pin'];
	$requested_user = $_REQUEST['requested_user'];
	$comment = mysql_real_escape_string($_POST['comment'],$con);
	$requested_user_id = get_new_user_id($requested_user);
	$request_date = $systems_date;
	if($requested_user_id == 0)
	{
		echo "<B style=\"color:#FF0000;\">Please Enter correct Username !</B>";
	}
	else
	{	
		$query = mysql_query("select * from users where id_user = '$id' and user_pin = '$user_pin' ");
		$num = mysql_num_rows($query);
		if($num > 0)
		{
		
			if($id == $requested_user_id)
			{ echo "<B style=\"color:#FF0000;\">Please Transfer To Another Member</B>"; }
			else
			{
				$left_amount = $current_amount-$request_amount;
				$query = mysql_query("select * from e_pin where user_id = '$id' and mode = 1 limit  $pin_no");
				$pin_num = mysql_num_rows($query);
				if($pin_num > 0)
				{
					if($pin_num >= $pin_no)
					{
						while($row = mysql_fetch_array($query))
						{
							$epin_id = $row['id'];
							$epin_type = $row['epin_type'];
							$epin_ids = $row['epin_id'];
							
							$sql_updt = "update e_pin set user_id = '$requested_user_id' , 
							date = '$request_date' where id = '$epin_id' ";
							mysql_query($sql_updt);
						
							$qus = "select * from e_pin as t1 inner join epin_history as t2 on 
							t1.id = t2.epin_id and t1.user_id = '$id' and t1.mode = 1 limit $pin_no ";
							$query_epin = mysql_query($qus);
							while($rok = mysql_fetch_array($query_epin))
							{
								$epin_new_id = $rok['id'];
								$generate_id = $rok['generate_id'];
								$transfer_to = $rok['transfer_to'];
							}
							$insert_sql = "insert into epin_history (epin_id, generate_id , 
							user_id ,transfer_to, date) values ('$epin_id' , '$generate_id' , 
							'$id' ,'$requested_user_id', '$request_date')";
							mysql_query($insert_sql);
						
							/*$message = "Registration E-Pin is successfully transfered to you. www.poorvanchalservices.net";
							$phone = get_user_phone($requested_user_id);
							send_sms($phone,$message);*/
						}
						$sqlkk = "update epin_request set num_of_pin='$pin_no' where epin_id='$epin_ids'";
						mysql_query($sqlkk);
						
						/*$time = date('Y-m-d H:i:s');
						$sqlss = "insert into epin_request (generate_by, epin_for , num_of_pin , mode , date , time , epin_type , comment , epin_id , process_datetime) values ('$id' , '$requested_user_id' ,'$pin_no' , 1 , '$request_date' , '$time' , '$epin_type' , '$comment' , '0' , '$time')";
						mysql_query($sqlss);*/
						
						$_SESSION['epin_success'] = "<B style=\"color:#008000;\">You request of transfer E-pin ".$request_pin." has completed successfully !!</B>";
						echo "<script type=\"text/javascript\">";
						echo "window.location = \"index.php?page=pin-transfer-to-member\"";
						echo "</script>";
					}
					else
					{ echo "<B style=\"color:#FF0000;\">You Can Transfer Only $pin_num E-pin !!</B>"; }	
				}	
				else 
				{ echo "<B style=\"color:#FF0000;\">Please Enter Correct Number to Transfer !!</B>"; }
			}
		}
		else { echo "<B style=\"color:#FF0000;\">Please enter correct Transaction Password !</B>"; }		
	}		
}
else
{
	$query = mysql_query("select * from e_pin where user_id = '$id' and mode = 1 ");
	$num = mysql_num_rows($query);
	if($num != 0)
	{
	$msg = $_REQUEST[mg]; echo $msg; ?> 
	
	<table id="example2" class="table table-bordered table-hover">
	<form name="money" action="" method="post">
		<tr>
			<td style="color:#003366; font-size:18px" colspan="2">
				<B>Your Total E-pin is : &nbsp;&nbsp;&nbsp;&nbsp;<?=$num;?></B>
			</td>
		</tr>
		<tr>
			<th width="40%">No of E-pin :</th>
			<td ><input type="text" name="pin_no" class="form-control" /></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<th>Requested Username :</th>
			<td><input type="text" name="requested_user" class="form-control" /></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<th>Transaction Password :</th>
			<td><input type="text" name="user_pin" class="form-control" /></td>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td colspan="2" class="text-center">
				<input type="submit" class="btn btn-info" name="submit" value="Request" />
			</td>   
		</tr>
	</form>
	</table>
<?php 
}
else { echo "<B style=\"color:#FF0000;\">You Have No Unused Epin to transfer !</B>"; }
}  ?>
