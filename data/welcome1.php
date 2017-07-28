<?php
session_start();
include('condition.php');
include('function/setting.php');
include("function/functions.php");
//include("function/pair_point_calculation.php");
include("function/pair_point_income.php");
include("function/send_mail.php");
include("function/income.php");

	
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/popup.js"></script>
<script type="text/javascript" src="js/future.js"></script>

<?php
$allowedfiletypes = array("jpg");
$uploadfolder = $payment_receipt_img_path;
$thumbnailheight = 100; //in pixels
$thumbnailfolder = $uploadfolder."thumbs/" ;

$user_id = $_SESSION['ebank_user_id'];
$bank_you = get_user_bank_name($user_id);
$tot_msg_chat = get_tot_chat_message($user_id);
$qwww = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
while($rowss = mysql_fetch_array($qwww))
{
	$level_vtype = $rowss['level'];
}
$max_time = $max_time[$level_vtype];

$_SESSION['show_message'];
$_SESSION['show_message'] = "";


$query = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
while($row = mysql_fetch_array($query))
{
	$f_name = $row['f_name'];
	$l_name = $row['l_name'];
	$user_name = $row['username'];
	$name = $f_name." ".$l_name;
	$phone_no = $row['phone_no'];
	$date = $row['date'];
	$real_parent = get_user_name($row['real_parent']);
	$email = $row['email'];
	$phone_no = $row['phone_no'];
	$city = $row['city'];
	$country = $row['country'];
	$address = $row['address'];
}

?>
<table id="example2" class="table table-bordered table-hover">
<?php
if($_SESSION['user_manager_type'] == 'M')
{ ?>
	<tr>
		<td>
			<table id="example2" class="table table-bordered table-hover">
				<tr>
					<td style="padding-top:10px;">
						<a class="easyui-linkbutton" href="index.php?page=manager">Manager</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
<?php
}
?>
	<tr>
		<td>
		<div style="color:#990000; padding:10px 0px 10px 50px;text-decoration: blink">
			<?php
				$inv_count = first_invest_count($user_id);
				if($inv_count == 0){ print "<blink>Note : Your Cmmitment is Not Yet Confirmed.</blink>";
				// Accept Button will be appeared once your commitment confirmed.
				}
				else{}
			?>
		</div>
		<!--<table width="1000" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr><td><img style="width: 100%; padding-bottom: 20px;" src="images/banner1.jpg"></td></tr>
			<tr><td><img style="width: 100%; padding-bottom: 20px;" src="images/banner.gif"></td></tr>
		</table>-->
		<table id="example2" class="table table-bordered table-hover">
			<tbody>
			<tr>
				<td width="50%">
					<div id="put_help" class="ordin_button" onclick="Provide_help_Term()">
						<div>
							<span class="translate">Provide Help</span><br>
							<i class="translate">Make a deposit</i>
						</div>
					</div>
				</td>
				<td width="50%">
					<div id="get_help" class="ordout_button" onclick="Get_Help()">
						<div>
							<span class="translate">Get Help</span><br>
							<i class="translate">Withdraw Deposit</i>
						</div>
					</div>
				</td>
		
			</tr>
			<tr><td colspan="2"></td></tr>
			<tr>
				<td style="text-align: center; font-size: 20px; font-weight: bold; padding:20px 0 20px 0; color:#000;" colspan="2">
				   Your Reffral Link is: <a href="<?=$refferal_link."/index.php?ref=".$email; ?>" class="cssLabel" target="_blank" style="color:#011153;"><?=$refferal_link."/index.php?ref=".$email; ?></a>
				</td>
			</tr>
		</table>
		<!--<table class="table">
			<thead><tr><th><?=$welcome_message;?></th></tr></thead>
		</table>
		<table width="1000" align="center" border="0" cellpadding="0" cellspacing="0"> 
			<tr>
				<td colspan="2" align="center">
					<input id="hdn" value="0" type="hidden">
					<input id="hdniw" value="0" type="hidden">
					<input id="hdnmid" value="1408" type="hidden">
					<input id="hdconfID" value="" type="hidden">
					<select id="ddlselect" class="ddl" style="display: none;"><option selected="selected" value="1408">speakasiaoldfund@gmail.com-Suresh </option></select>
					<br>
				</td>
			</tr>
		</table>-->					
 
		<!--<div style="margin-bottom:10px; text-align:center">
			<a href="#"><img src="img/img2.png" /></a>
			<a href="index.php?page=request-fund-transfer"><img src="img/img1.png" /></a>
		</div>
		<div style="margin-bottom:10px;">
			<a href="index.php?page=edit-profile" class="btn btn-large btn-danger">
				For International Update Your Nettler & Perfect Money Account 
				<!--<img src="images/logo.png" />
			</a>
			<span style="float:right;">
			<a href="index.php?page=request-fund-transfer" class="btn btn-large btn-primary">
				Request For Gift
			</a>
			</span>-->

	<?php
	/*print "<h4>Your Manager</h4>";
	$sql = "SELECT t2.* FROM user_manager as t1 inner join users as t2 on t1.active_by = t2.id_user and  t1.type != 'A' where t1.manager_id = '$user_id' ";
	$query = mysql_query($sql);
	$totalrows = mysql_num_rows($query);
	if($totalrows == 0)
	{
		echo "<B style=\"color:#FF0000;\">There is no information to show!</B>"; 
	}
	else 
	{ */?>
		<!--<table id="ContentPlaceHolder1_gridref" class="data_grid" cellspacing="0" border="1" style="width:100%;border-collapse:collapse;" rules="all">
			<tbody>
			<tr>
				<th>Username</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
			</tr>-->
	<?php
		/*while($row = mysql_fetch_array($query))
		{			
			echo "<tr>
					<th>".$row['username']."</th>
					<th>".$row['f_name'].'&nbsp;'.$row['l_name']."</th>
					<th>".$row['email']."</th>
					<th>".$row['phone_no']."</th>
				  </tr>";		
		}
		echo "</tbody></table>";	
	}*/
?>



<!--<div style="width:100%; height:100px; text-align:center; color:#FFFFFF; font-size:25px; font-family:Courier; font-weight:bold;">
	<a style="color:#FFFFFF;" href="index.php?page=user-investment"><div style="width:49%; height:60px; float:left; background-color: #18d3da; border: thin solid #B5B9BC; box-shadow: 0 0 4em #030905 inset; padding-top:35px;">
		Send Gift
	</div></a>
	<a style="color:#FFFFFF;" href="index.php?page=request-fund-transfer"><div style="width:49%; height:60px; float:right; background-color: #da18ca; border: thin solid #B5B9BC; box-shadow: 0 0 4em #030905 inset; padding-top:35px;">
		Request For Gift
	</div></a> 
</div>-->	

<table style="width:100%;" class="table">
	<tr>
		<td style="vertical-align:top; width:70%;">
			
			
			<div  id="tab_deatil" style="cursor: pointer;">
			
			<!--Help Bonus Start Here-->
			<?php /*?><?php
			$que = mysql_query("select * from income_transfer where user_id = '$user_id' and mode = 2 ");
			$total_pay_row = mysql_num_rows($que);
			if($total_pay_row > 0)
			{ 
				$jc = 0;
				$lvl_cc = 1;	
				while($row = mysql_fetch_array($que))
				{ 
					$jc++;
					$invest_id = $row['investment_id'];
					$total_amount = $row['amount'];
					$paid_amount = $row['amount'];
					$total_left = $total_amount-$paid_amount;
					$date = $row['time_confirm'];
					$date = date('d/m/Y' , strtotime($date));
					?>
				<div class="arrg arrg_transferin" style="cursor: pointer; display: block;">				
				<table class="arrg_tbarrg" width="100%" border="0" cellpadding="2" cellspacing="2">
				<tbody>
					<tr>   
					<td>
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tbody>
						<tr>
							<td rowspan="2" class="arrg_num" colspan="2">
							<img src="images/confirm.png" class="arrg_status_img" height="36" width="36">
								<br> 
								<span class="arrg_sm10"><span class="translate">Number</span>:<br></span>
								<span class="arrg_id">CH127420<?=$invest_id;?> </span>
							</td>
							<td colspan="3" class="arrg_status_name">
								<B style="color:#000;">Recepient fund confirmed</B>
							</td>
						</tr>
						<tr>
							<td class="arrg_num">
								<span class="arrg_sm10">
									<span class="translate">Total Income</span>:<br>
								</span>
								<span class="arrg_date">
									<?=round($total_amount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$total_amount; ?> <font color=dark>$ </font>
								</span>
							</td>
							<td class="arrg_name1">
								<span class="arrg_sm10">
									<span class="translate">Date</span>:<br>
								</span>
								<span class="arrg_user_in"><?=$date;?></span>
							</td>
							<td class="arrg_summ" align="center">
								<span class="arrg_sm10">
									<span class="translate">Paid Income</span>:<br>
								</span>
								<span class="arrg_user_in">
									<?=round($paid_amount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$paid_amount; ?> <font color=dark>$ </font>
								</span>
							</td>
							<td class="arrg_name2" align="center">
								<span class="arrg_sm10">
									<span class="translate">Left Amount</span>:<br>
								</span>
								<span class="arrg_user_in">
									<?=round($total_left/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$total_left; ?> <font color=dark>$ </font>
								</span>
							</td>
							<td width="30"></td>
						</tr>
						
						</tbody>
					</table>
					</td>
					</tr>
				</tbody>
				</table>
				</div>
			<?php
				}
					
			}  ?>
<?php */?>
			<!--Help Bonus End Here-->
			
			
			<!--First Box Start Here-->	
			
			<script>
				$(document).ready(function(){
					$(".first_box").click(function () {
						var site = $(this).attr("site");
						var num = $(this).attr("data");
						//alert("fghg");
						$.ajax({
								type: "POST",
								url: "data/window_details.php",
								data: {pay_id:num},
								success: function(msg) {
								//alert(msg);	
								
								//$("#msg_submit").html(msg);
								$('.detail_user').html(msg);
								$('.detail_user').fadeIn('fast');
								}
						});
							return false;
					});
				});
				
			</script>
			<?php
			$que = mysql_query("select * from income_transfer where mode = 0 and user_id = '$user_id'");
			$num = mysql_num_rows($que);
			if($num > 0)
			{ ?>
				<!--<h3>Income Information</h3>-->
			<?php
				$tr = 0;
				while($row = mysql_fetch_array($que))
				{ 
					$tr++;
					$paying_id = $row['paying_id'];
					$table_id = $row['id'];
					$amount = $row['amount'];
					$mode = $row['mode'];
					$payment_receipt = $row['payment_receipt'];	
					$pay_code = $row['pay_code'];
					$inv_date = $row['date'];
					$inv_date = date('d/m/Y' , strtotime($inv_date));
					
					$receive_id = $row['user_id'];
					$tot_msg = get_tot_chat_message($receive_id);
					
					$time = $row['time_link'];
					
					$curr_time = date('Y-m-d H:i:s');
					$block_time = date('Y-m-d H:i:s' , strtotime($time . " +".$max_time." hours"));
					
					$start_date = new DateTime($curr_time);
					$since_start = $start_date->diff(new DateTime($block_time));
					$day = $since_start->d;
					$hour = $since_start->h+$day*24;
					$minute = $since_start->i;
					$second = $since_start->s;
					
					$remain_time = $hour." Hours ".$minute." Minutes ";
					
					if($curr_time > $block_time)
					{ 
						$msgs = "Your time is over!!"; 
						$img = "delete.png";
					}
					else{ $msgs = "Time Left ".$remain_time; $img = "confirm_blue.png"; }
					
					$query = mysql_query("SELECT * FROM users WHERE id_user = '$paying_id' ");
					while($rrr = mysql_fetch_array($query))
					{
						$id_user = $rrr['id_user'];
						$f_name = $rrr['f_name'];
						$l_name = $rrr['l_name'];
						$payee_username = $rrr['username'];
						$name = $f_name." ".$l_name;
						$bank_paying = get_user_bank_name($id_user);
					} ?>
					<div class="arrg arrg_first_block" style="cursor: pointer; display: block;">
					<table class="arrg_tbarrg" width="100%" border="0" cellpadding="2" cellspacing="2">
						<tbody>
						<tr>
							<td rowspan="2" class="arrg_num" width="36">
							<img src="images/<?=$img;?>" class="arrg_status_img" height="36" width="36">
							<br> 
								<span class="arrg_sm10"><span class="translate">Number</span>:<br></span>
								<span class="arrg_id">CH127420<?=$table_id;?> </span>
							</td>
							<td class="arrg_status_name">Recepient confirmed fund reception (Request to Give Help)</td>
							<td class="arrg_wait"><span style="color:#000066;"><?=$msgs;?></span></td>
							<td class="arrg_msg" style="width: 120px;">   
								<a href="#chat_box" onClick="OpenChatWindow(<?=$paying_id;?>,<?="'chat'";?>,<?=$user_id;?>)" role="button" class="cursor neoui-greybutton translate" data-toggle="chat_box">Message: <?=$tot_msg;?></a>
								<!--<span onclick="javascript:get_messge(this)" class="cursor">
								Messages: 0</span>-->
							</td>
						</tr>
						<tr>   
							<td colspan="3">
							<form method="post" action="index.php?page=welcome_action">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tbody>
								<tr>
									<td class="arrg_num">
										<span class="arrg_sm10">
											<span class="translate">Date of creating</span>:<br>
										</span>
										<span class="arrg_date"><?=$inv_date;?></span>
									</td>
									<td class="arrg_name1">
										<span class="arrg_user_in"><?=$name;?></span><br />
										<span style="font-size:10px;"><?=$bank_paying;?></span>
									</td>
									<td class="arrg_summ" align="center">
										<span class="arrg_summ_in"><img src="images/arrow.png" /></span>
										 &nbsp; 
										<span class="arrg_amt">
										<?=$amount." $ /".round($amount/$usd_value_current,2);?> USD
										</span>&nbsp; 
										<span class="arrg_summ_out"><img src="images/arrow.png" /></span>
										<!--<div class="arrg_out_files" style="">
											<span class="translate">Confirmation</span>: 
											<span class="time_duration upload_img">
												<img src="images/jpg.png">
											</span>
										</div>-->
									</td>
									<td class="arrg_name2">
										<span class="arrg_user_out">YOU</span><br>
										<div class="arrg_bank_out"><?=$bank_you;?></div>
									</td>
									<td width="30"></td>
								</tr>
								<tr>
									<td colspan="2"></td>
									<td align="right">
									<input type="hidden" name="table_ids" value="<?=$table_id;?>" />
									<input type="hidden" name="block_user_id" value="<?=$paying_id; ?>" />	
									<?php
									$user_type = get_user_types($paying_id);
									if($curr_time > $block_time)
									{
										if($user_type != 'X')
										{
									 ?>
										<input type="submit" name="Inv_Blok_Usr" value="Block" class="cursor neoui-greybutton translate" />
									<?php
										}
										else{ echo "<span style=\"padding-right:10px;\">Pending</span>";}
									}
									?>
									</td>
									<td>
										<input type="submit" name="extend_time" value="Time Extend" class="cursor neoui-greybutton translate" />
									</td>
									<td align="right" style="text-align: right; padding-top: 5px;">
									<!--<a onclick="javascript:get_detail(this)" data="2093" class="cursor neoui-greybutton translate">Details&gt;&gt;</a>-->
									<a id="first_box" site="<?=$paying_id;?>" num="<?=$paying_id;?>" data="<?=$paying_id;?>" class="cursor neoui-greybutton translate first_box">Details&gt;&gt;</a>
										
									</td>
								</tr>
								</tbody>
							</table>
							</form>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
			<?php	


				}  
			} 
			 ?>
			<!--First Box End Here-->
			
			<!--Second Box Start Here-->
			<script>
				$(document).ready(function(){
					$("#second_box").click(function () {
						var site = $(this).attr("site");
						var num = $(this).attr("data");
						//alert(num);
						$.ajax({
								type: "POST",
								url: "data/window_details.php",
								data: {id:num},
								success: function(msg) {
								//alert(num);	
								//$("#msg_submit").html(msg);
								$('.detail').html(msg);
								$('.detail').fadeIn('fast');
								}
							});
							return false;
						});
					});
			</script>
			<?php
			$que = mysql_query("select * from income_transfer where mode = 0 and 
			paying_id = '$user_id' " );
			$total_pay_row = mysql_num_rows($que);
			if($total_pay_row > 0)
			{ ?><!--<h4>Payment Information</h4>--><?php
				$pay_err = $_REQUEST['pay_err'];
				if($pay_err == 1)
					print "<B style=\"color:#FF0000;\">Error: Invalid file extension!</B>";
				elseif($pay_err == 2)
					print "<B style=\"color:#FF0000;\">Error: Payment Slip not saved !</B>";
				elseif($pay_err == 3)
					print "<B style=\"color:#FF0000;\">Error: Payment Slip Not Found !</B>" ; 
				elseif($pay_err == 4)
					print "<B style=\"color:#FF0000;\">Error: Invalid Pay Code !</B>" ; 		
				$jc = 0;
				$lvl_cc = 1;	
				while($row = mysql_fetch_array($que))
				{ 
					$jc++;
					$pay_id = $row['user_id'];
					$table_id = $row['id'];
					$amount = $row['amount'];
					$mode = $row['mode'];
					$date_creat = $row['date'];
					$date_creat = date('d/m/Y' , strtotime($date_creat));
					$amount_usd = round($amount/$usd_value_current,2);
					
					$receive_id = $row['paying_id'];
					$tot_msg = get_tot_chat_message($receive_id);
					
					$time = $row['time_link'];
					
					$curr_time = date('Y-m-d H:i:s');
					$block_time = date('Y-m-d H:i:s' , strtotime($time . " +".$max_time." hours"));
					
					$start_date = new DateTime($curr_time);
					$since_start = $start_date->diff(new DateTime($block_time));
					$day = $since_start->d;
					$hour = $since_start->h+$day*24;
					$minute = $since_start->i;
					$second = $since_start->s;
					
					$remain_time = $hour." Hours ".$minute." Minutes ";
					
					if($curr_time > $block_time)
					{ 
						$msgs = "Your time is over!!"; 
						$img = "delete.png";
					}
					else{ $msgs = "Time Left ".$remain_time; $img = "confirm_blue.png"; }
					
					$query = mysql_query("SELECT * FROM users WHERE id_user = '$pay_id' ");
					while($rrr = mysql_fetch_array($query))
					{
						$id_user = $rrr['id_user'];
						$f_name = $rrr['f_name'];
						$l_name = $rrr['l_name'];
						$name = ucfirst($f_name)." ".$l_name;
						$bank_pay = get_user_bank_name($id_user);
					} ?>
			<form action="index.php?page=welcome_action" method="post" enctype="multipart/form-data">
				<input type="hidden" name="table_id" value="<?=$table_id; ?>" />
				<div class="arrg arrg_out" style="cursor: pointer; display: block;">				
				<table class="arrg_tbarrg" width="100%" border="0" cellpadding="2" cellspacing="2">
					<tbody>
					<tr>
						<td rowspan="2" class="arrg_num" width="36">
							<img src="images/<?=$img;?>" class="arrg_status_img" height="36" width="36">
							<br>
							<span class="arrg_sm10"><span class="translate">Number</span>:<br></span>
							<span class="arrg_id">CH127420<?=$table_id;?> </span>
						</td>
						<td class="arrg_status_name">
							You Confirmed Funds Reception (Request to Get Help)
						</td>
						<td class="arrg_wait"><span style="color:#000066;"><?=$msgs;?></span></td>
						<td class="arrg_msg" style="width: 120px;">   
							<a href="javascript:void(0);" onClick="OpenChatWindow(<?=$pay_id;?>,<?="'chat'";?>,<?=$user_id;?>)" style="color:#4a326e; text-decoration:none;" role="button" class="cursor neoui-greybutton translate" data-toggle="modal">Message: <?=$tot_msg_chat;?></a>
							<!--<span onclick="javascript:get_messge()" data="19217" class="cursor">
								Messages: 0
							</span>-->
						</td>
					</tr>
					<tr>   
						<td colspan="4">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tbody>
							<tr>
								<td class="arrg_num">
									<span class="arrg_sm10">
										<span class="translate">Date of creating</span>:<br>
									</span>
									<span class="arrg_date"><?=$date_creat;?></span>
								</td>
								<td class="arrg_name1">
									<span class="arrg_user_in">YOU</span><br />
									<span style="font-size:10px;"><?=$bank_you;?></span>
								</td>
								<td class="arrg_summ" align="center">
									<span class="arrg_summ_in"><img src="images/arrow.png" /></span> 
									&nbsp; 
									<span class="arrg_amt">
										<?=$amount;?> $ /<?=$amount_usd;?> USD
									</span>&nbsp; 
									<span class="arrg_summ_out"><img src="images/arrow.png" /></span>
									<!--<div class="arrg_out_files" style="">
										<span class="translate">Confirmation</span>: 
										<span class="time_duration upload_img">
											<img src="images/jpg.png"></span>
									</div>-->
								</td>
								<td class="arrg_name2">
									<span class="arrg_user_out"><?=$name;?></span><br>
									<div class="arrg_bank_out"><?=$bank_pay;?></div>
								</td>
								<td width="30"></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								
								<td colspan="4" style="text-align: right; padding-top: 5px;">
									<input type="file" name="payment_receipt" style="width:180px;"/>
									<input type="submit" name="Submit" value="Confirm" class="cursor neoui-greybutton translate" /><a id="second_box" site="<?=$pay_id;?>" num="<?=$pay_id;?>" data="<?=$pay_id;?>" class="cursor neoui-greybutton translate">Details&gt;&gt;</a>
								</td>
							</tr>
							</tbody>
						</table>
						</td>
					</tr>
					</tbody>
				</table>
				</div>
			</form>
			 <?php 	
			 	}  
			} ?>
			
			<!--Second Box End Here-->


			<!--Third Box Start-->
			<script>
				$(document).ready(function(){
					$("#third_box").click(function () {
						var site = $(this).attr("site");
						var num = $(this).attr("data");
						//alert(num);
						$.ajax({
								type: "POST",
								url: "data/window_details.php",
								data: {id:num},
								success: function(msg) {
								//alert(num);	
								//$("#msg_submit").html(msg);
								$('.detail').html(msg);
								$('.detail').fadeIn('fast');
								}
							});
							return false;
						});
					});
			</script>
			<?php
			$que = mysql_query("select * from income_transfer where mode = 1 and paying_id = '$user_id'");
			$num = mysql_num_rows($que);
			if($num > 0)
			{ 
				while($row = mysql_fetch_array($que))
				{ 	
					$pay_id = $row['user_id'];
					$table_id = $row['id'];
					$amount = $row['amount'];
					$mode = $row['mode'];
					$creat_date = $row['date'];
					$creat_date = date('d/m/Y' , strtotime($creat_date));
					$payment_receipt = $row['payment_receipt'];	
					
					$query = mysql_query("SELECT * FROM users WHERE id_user = '$pay_id' ");
					while($rrr = mysql_fetch_array($query))
					{
						$id_user = $rrr['id_user'];
						$f_name = $rrr['f_name'];
						$l_name = $rrr['l_name'];
						$payee_username = $rrr['username'];
						$name = $f_name." ".$l_name;
						$bank_pay = get_user_bank_name($id_user);
					} ?>
					<div class="arrg arrg_transferout" style="cursor: pointer; display: block;">				
					<table class="arrg_tbarrg" width="100%" border="0" cellpadding="2" cellspacing="2">
						<tbody>
						<tr>
							<td rowspan="2" class="arrg_num" width="36">
								<img src="images/green1.png" class="arrg_status_img" height="36" width="36"><br> 
								<span class="arrg_sm10"><span class="translate">Number</span>:<br></span>
								<span class="arrg_id">CH127420<?=$table_id;?> </span>
							</td>
							<td class="arrg_status_name">
								You Confirmed Funds Reception (Request to Get Help)
							</td>
							<td class="arrg_wait"></td>
							<td class="arrg_msg" style="width: 120px;">   
								<a href="javascript:void(0);" onClick="OpenChatWindow(<?=$pay_id;?>,<?="'chat'";?>,<?=$user_id;?>)" style="text-decoration:none;" role="button" class="cursor neoui-greybutton translate" data-toggle="modal">Message: <?=$tot_msg_chat;?></a>
								<!--<span onclick="javascript:get_messge()" data="19217" class="cursor">
									Messages: 0
								</span>-->
							</td>
						</tr>
						<tr>   
							<td colspan="4">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tbody>
								<tr>
									<td class="arrg_num">
										<span class="arrg_sm10">
											<span class="translate">Date of creating</span>:<br>
										</span>
										<span class="arrg_date"><?=$creat_date;?></span>
									</td>
									<td class="arrg_name1">
										<span class="arrg_user_in">YOU</span><br />
										<span style="font-size:10px;"><?=$bank_pay;?></span>
									</td>
									<td class="arrg_summ" align="center">
										<span class="arrg_summ_in"><img src="images/arrow.png" /></span> 
										&nbsp; 
										<span class="arrg_amt">
											<?=$amount." $ /".round($amount/$usd_value_current,2);?> USD
										</span>&nbsp; 
										<span class="arrg_summ_out"><img src="images/arrow.png" /></span>
										<!--<div class="arrg_out_files" style="">
											<span class="translate"></span>: 
											<span class="time_duration upload_img">
											
											</span>
										</div>-->
									</td>
									<td class="arrg_name2">
										<span class="arrg_user_out"><?=$name;?></span><br>
										<div class="arrg_bank_out"><?=$bank_you;?></div>
									</td>
									<td width="30"><B style="color:#FF0000;">Pending</B></td>
								</tr>
								<tr>
									<td colspan="3" align="right">
										Receipt Click here
										<a style="color:#fff;" href="payment_rec.php?payment_receipt=<?= $payment_receipt;?>" target="_blank"><img src="images/jpg.png"></a>
									</td>
									<td colspan="2" style="text-align: right; padding-top: 5px;">
										<a id="third_box" site="<?=$pay_id;?>" num="<?=$pay_id;?>" data="<?=$pay_id;?>" class="cursor neoui-greybutton translate">Details&gt;&gt;</a>
									</td>
								</tr>
								</tbody>
							</table>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
			<?php 	
				} 
			}  ?>
			
			<!--Third Box End Here-->
				
			<!--Fourth Box Start Here-->
			<script>
				$(document).ready(function(){
					$("#fourth_box").click(function () {
						var site = $(this).attr("site");
						var num = $(this).attr("data");
						
						$.ajax({
								type: "POST",
								url: "data/window_details.php",
								data: {pay_id:num},
								success: function(msg) {
								//alert(msg);	
								
								//$("#msg_submit").html(msg);
								$('.detail_user').html(msg);
								$('.detail_user').fadeIn('fast');
								}
							});
							return false;
						});
					});
			</script>
			<?php
			$que = mysql_query("select * from income_transfer where mode = 1 and user_id = '$user_id'");
			$numm = mysql_num_rows($que);
			if($numm > 0)
			{  
				$_SESSION['send_income_fo_user'] = 1;
				$jcd = $jc+1;
				$total_pay_row = $total_pay_row+$numm;
				$tr = 0;
				while($row = mysql_fetch_array($que))
				{ 
					$tr++;
					$paying_id = $row['paying_id'];
					$investment_id = $row['investment_id'];
					$table_id = $row['id'];
					$amount = $row['amount'];
					$mode = $row['mode'];
					$payment_receipt = $row['payment_receipt'];	
					$cre_date = $row['date'];
					$cre_date = date('d/m/Y' , strtotime($cre_date));
					
					$receive_id = $row['user_id'];
					$tot_msg = get_tot_chat_message($receive_id);
					
					$query = mysql_query("SELECT * FROM users WHERE id_user = '$paying_id' ");
					while($rrr = mysql_fetch_array($query))
					{
						$id_user = $rrr['id_user'];
						$f_name_acc = $rrr['f_name'];
						$l_name_acc = $rrr['l_name'];
						$phn_acc = $rrr['phone_no'];
						$mail_acc = $rrr['email'];
						$real_phn_acc = get_user_phone($rrr['real_parent']);
						$name_user = $f_name_acc." ".$l_name_acc;
						$bank_paying = get_user_bank_name($id_user);
					} ?>
					<form action="index.php?page=welcome_action" method="post">
					  <input type="hidden" name="table_id" value="<?=$table_id; ?>" />
					  <input type="hidden" name="table_inv_id" value="<?=$investment_id; ?>" />
					<div class="arrg arrg_transferin" style="cursor: pointer; display: block;">
					<table class="arrg_tbarrg" width="100%" border="0" cellpadding="2" cellspacing="2">
						<tbody>
						<tr>
							<td rowspan="2" class="arrg_num" width="36">
							<img src="images/green.png" class="arrg_status_img" height="36" width="36">
							<br> 
								<span class="arrg_sm10"><span class="translate">Number</span>:<br></span>
								<span class="arrg_id">CH127420<?=$table_id;?> </span>
							</td>
							<td class="arrg_status_name">Recepient confirmed fund reception (Request to Give Help)</td>
							<td class="arrg_wait"></td>
							<td class="arrg_msg" style="width: 120px;">   
								<a href="#chat_box" onClick="OpenChatWindow(<?=$paying_id;?>,<?="'chat'";?>,<?=$user_id;?>)" role="button" class="cursor neoui-greybutton translate" data-toggle="chat_box">Message: <?=$tot_msg;?></a>
							<!--<span onclick="javascript:get_messge(this)" data="2093" class="cursor">
								Messages: 0</span>-->
							</td>
						</tr>
						<tr>   
							<td colspan="3">
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tbody>
									<tr>
										<td class="arrg_num">
											<span class="arrg_sm10">
												<span class="translate">Date of creating</span>:<br>
											</span>
											<span class="arrg_date"><?=$cre_date;?></span>
										</td>
										<td class="arrg_name1">
											<span class="arrg_user_in"><?=$name_user;?></span><br />
											<span style="font-size:10px;"><?=$bank_paying;?></span>
										</td>
										<td class="arrg_summ" align="center">
											<span class="arrg_summ_in">
												<img src="images/arrow.png" />
											</span> &nbsp; 
											<span class="arrg_amt">
											<?=$amount." $ /".round($amount/$usd_value_current,2);?> USD
											</span>&nbsp; 
											<span class="arrg_summ_out">
												<img src="images/arrow.png" />
											</span>
											<!--<div class="arrg_out_files" style="">
												<span class="translate">Receipt Click here</span>: 
												<span class="time_duration upload_img">
													
												</span>
											</div>-->
										</td>
										<td class="arrg_name2">
											<span class="arrg_user_out">YOU</span><br>
											<div class="arrg_bank_out"><?=$bank_you;?></div>
										</td>
										<td width="30">
										<input type="submit" name="Accept" value="Accept" class="cursor neoui-greybutton translate" />
										</td>
									</tr>
									<tr>
										<td colspan="3" align="right">Receipt Click here 
											<a style="color:#fff;" href="payment_rec.php?payment_receipt=<?=$payment_receipt;?>" target="_blank"><img src="images/jpg.png"></a>
										</td>
										<td colspan="2" style="text-align: right; padding-top: 5px;">
											<a id="fourth_box" site="<?=$paying_id;?>" num="<?=$paying_id;?>" data="<?=$paying_id;?>" class="cursor neoui-greybutton translate">Details&gt;&gt;</a>
										</td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
					</form>
			<?php 	$jcd++;
				} 
			}  ?>
			 <!--Fourth Box End Here-->
			 
			 <!--Five Box Start Here-->
			<?php
			$que = mysql_query("select * from income_transfer where mode = 2 and user_id = '$user_id'");
			$numm = mysql_num_rows($que);
			if($numm > 0)
			{  
				$_SESSION['send_income_fo_user'] = 1;
				$jcd = $jc+1;
				$total_pay_row = $total_pay_row+$numm;
				$tr = 0;
				while($row = mysql_fetch_array($que))
				{ 
					$table_id = $row['id'];
					$amount = $row['amount'];
					$paying_id = $row['paying_id'];
					$cre_date = $row['time_confirm'];
					$cre_date = date('d/m/Y' , strtotime($cre_date));
										
					$query = mysql_query("SELECT * FROM users WHERE id_user = '$paying_id' ");
					while($rrr = mysql_fetch_array($query))
					{
						$id_user = $rrr['id_user'];
						$f_name_acc = $rrr['f_name'];
						$l_name_acc = $rrr['l_name'];

						$name_user = $f_name_acc." ".$l_name_acc;
						$bank_paying = get_user_bank_name($id_user);
					} ?>
					<div class="arrg ordout_button" style="cursor: pointer; display: block;">
					<table class="arrg_tbarrg" width="100%" border="0" cellpadding="2" cellspacing="2">
						<tbody>
						<tr>
							<td rowspan="2" class="arrg_num" width="36">
							<img src="images/green.png" class="arrg_status_img" height="36" width="36">
							<br> 
								<span class="arrg_sm10"><span class="translate">Number</span>:<br></span>
								<span class="arrg_id">CH127420<?=$table_id;?> </span>
							</td>
							<td class="arrg_status_name">Confirmed Fund</td>
							<td class="arrg_wait">&nbsp;</td>
							<td class="arrg_msg" style="width: 120px;">&nbsp;</td>
						</tr>
						<tr>   
							<td colspan="4">
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
									<tbody>
									<tr>
										<td class="arrg_num">
											<span class="arrg_sm10">
												<span class="translate">Date of creating</span>:<br>
											</span>
											<span class="arrg_date"><?=$cre_date;?></span>
										</td>
										<td class="arrg_name1">
											<span class="arrg_user_in"><?=$name_user;?></span><br />
											<span style="font-size:10px;"><?=$bank_paying;?></span>
										</td>
										<td class="arrg_summ" align="center">
											<span class="arrg_summ_in">
												<img src="images/arrow.png" />
											</span> &nbsp; 
											<span class="arrg_amt">
											<?=$amount." $ /".round($amount/$usd_value_current,2);?> USD
											</span>&nbsp; 
											<span class="arrg_summ_out">
												<img src="images/arrow.png" />
											</span>
										</td>
										<td class="arrg_name2">
											<span class="arrg_user_out">YOU</span><br>
											<div class="arrg_bank_out"><?=$bank_you;?></div>
										</td>
										<td width="30">
										</td>
									</tr>
									<tr>
										<td colspan="3" align="right">&nbsp;</td>
										<td colspan="2" style="text-align: right; padding-top: 5px;">
										</td>
									</tr>
									</tbody>
								</table>
							</td>
						</tr>
						</tbody>
					</table>
					</div>
			<?php 	
				} 
			}  ?>
			 <!--Five Box End Here-->
			 
			</div>
		</td>
		<td style="vertical-align:top;" width="28%">
			<div class="displayDiv" style="margin-bottom: 10px;">
				<a class="l-btn" id="btnhelp" style="padding-left: 18px;">
					Hide/Show accomplished/cancelled orders
				</a>
			</div>
			<!--<a onclick="javascript:getsub_detail()" data="13203" cs="W">						
				<div class="ordout  hidden true" id="help_detail" style="cursor: pointer;">
					<table width="100%" border="0" cellpadding="0" cellspacing="6">
						<tbody>
						<tr>
							<td class="ord_title">
								<span class="translate">Request to Get Help</span><br>
								<span class="order_out_id">G29257568</span>
							</td>
							<td width="32"><img src="images/strelka_32.png" height="32" width="32"></td>
						</tr>
						<tr>
							<td colspan="2" class="ord_body">
								<span class="translate">Participant</span>: 
								<span class="order_out_fio">Suresh  K</span><br>
								<span class="translate">Amount</span>: 
								<span class="order_out_amount">1500</span>
								<span class="order_out_currency"> $ </span><br>
								<span class="translate">Remaining Amount</span>: 
								<span class="order_out_amount"> 0</span>
								<span class="order_out_currency"> $ </span><br>
								<span class="translate">Date</span>: 
								<span class="order_out_date">18/11/2015</span><br>
								<span class="translate">Status</span>: 
								<span class="order_out_status">Request processed.</span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<a onclick="javascript:getsub_detail(this)" data="13203" cs="W" class="cursor neoui-greybutton translate" style="float: right;">Details&gt;&gt;</a>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</a>-->
			
			<!--Request to Provide Help Block Start Here-->
			<div id="help_detail">
			<?php
			$sqssl = "SELECT t1.* , t2.mode as int_mode FROM investment_request t1 left join 
					income_transfer t2 on t1.id = t2.investment_id WHERE t1.user_id = '$user_id' ";
			$query = mysql_query($sqssl);
			while($row = mysql_fetch_array($query))
			{
				$id = $row['id'];
				$user_id = $row['user_id'];
				$amount = $row['amount'];
				$mode = $row['mode'];
				$int_mode = $row['int_mode'];
				$date = $row['date'];
				$date = date('d-m-Y', strtotime($date));
				$name = ucfirst(get_full_name($user_id));
				
				if($mode == 1){ $msgs = "Request processed."; }
				elseif($mode == 0 and $int_mode == 0){ $msgs = "Request in Processing."; }
				elseif($mode == 0 and $int_mode == 1){ $msgs = "Request Pending."; }
				elseif($mode == 0 and $int_mode == 2){ $msgs = "Request Confirmed."; }
			?>
			<script>
				$(document).ready(function(){
					$("#la<?=$id;?>").click(function () {
						var site = $(this).attr("site");
						var num = $(this).attr("data");
						//alert(num);
						$.ajax({
									type: "POST",
									url: "data/subdetail.php",
									data: {id:num},
									success: function(msg) {
									//alert(num);	
									//$("#msg_submit").html(msg);
									$('.subdetail').html(msg);
									$('.subdetail').fadeIn();
									}
								});
								return false;
							});
						});
				
			</script>
			<a id="la<?=$id;?>" site="<?=$id;?>" num="<?=$id;?>" data="<?=$id;?>" cs="W">						
				<div class="ordin false" style="cursor: pointer;">
					<table width="100%" border="0" cellpadding="0" cellspacing="6">
						<tbody>
						<tr>
							<td width="32"><img src="images/strelka_32.png" height="32" width="32"></td>
							<td class="ord_title">
								<span class="translate">Request to Provide Help</span><br>
								<span class="order_out_id">CR292575<?=$id;?></span>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="ord_body">
								<span class="translate">Participant</span>: 
								<span class="order_out_fio"><?=$name;?></span><br>
								<span class="translate">Amount</span>: 
								<span class="order_out_amount"><?=$amount;?></span>
								<span class="order_out_currency"> $ </span><br>
								<span class="translate">Remaining Amount</span>: 
								<span class="order_out_amount"> <?=$amount;?></span>
								<span class="order_out_currency"> $ </span><br>
								<span class="translate">Date</span>: 
								<span class="order_out_date"><?=$date;?></span><br>
								<span class="translate">Status</span>: 
								<span class="order_out_status"><?=$msgs;?></span>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<a id="la<?=$id;?>" site="<?=$id;?>" num="<?=$id;?>" data="<?=$id;?>" cs="W" class="cursor neoui-greybutton translate" style="float: right;">	
								<!--<a onclick="javascript:getsub_detail(this)" data="13203" cs="W" class="cursor neoui-greybutton translate" style="float: right;">-->Details&gt;&gt;</a>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
			</a>
			<?php
			}
			?>
			</div>
			<!--Request to Provide Help Block End Here-->
		</td>
	</tr>
</table>


 </td>
 </tr>
 </table>
<?php
include('provide_help.php');
include('get_help.php');
include('subdetail.php');
include('window_message.php');
?>

</center>	 
<div class="load_success"><?=$success;?></div>
<div style="clear:both"></div>
<!--Four Box End-->
<div id="loading_div"></div>
<div class="detail_user"></div>
<div class="detail"></div>
<div id="chat_box" class="chat_box" style="position: fixed; padding: 10px; top: 24%; top: -500px; left:500px; z-index: 999; opacity: 0.9;">
<style>
.chat_log
{ 
	width:500px;
	min-height:248px;
	border:solid 1px #C7D5E0;
	background: bottom left #FEFEFF repeat-x;
} 
</style>
<div class="chat_log" >
	
	<div id="chat"></div>
	<div id="chatlogContentArea" > </div>
</div>
 
 </div>
	<style>
      div#container {
        width: 580px;
        margin: 100px auto 0 auto;
        padding: 20px;
        background: #000;
        border: 1px solid #064879;
      }
      
      /* HOVER STYLES */
	  .css_popup
	  {
        display: none;
        position:absolute;
        width:310px;
        padding:0;
        background-color:#FFFFFF;
        color: #000000;
        border: 1px solid #064879;
        font-size: 90%;
		line-height:15px;

      }
	  
	  .css_popup_rec
	  {
        display: none;
        position:absolute;
        width:670px;
        padding:0;
        background-color:#FFFFFF;
        color: #000000;
        border: 1px solid #064879;
        font-size: 90%;
		line-height:15px;
		height:450px;padding-left: 20px;
      }

	  .MyTable td {
	  padding-left:20px; }
	        
    </style>
	
    <script type="text/javascript"> 
      $(function() {
	  	
        var moveLeft = 20;
        var moveDown = -150;
		<?php for($tr = 1; $tr <= $total_pay_row; $tr++)
		{ ?>
		$('a#trigger<?=$tr; ?>').hover(function(e) {
          $('div#pop-up<?=$tr; ?>').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() { 
          $('div#pop-up<?=$tr; ?>').hide();
        });
        
        $('a#trigger<?=$tr; ?>').mousemove(function(e) {
          $('div#pop-up<?=$tr; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
		
		<?php } ?>
      });
	  
	</script>
	
	 <script type="text/javascript"> 
      $(function() {
	  
         var moveLeft = -600;
         var moveDown = -100;
		<?php for($rcp = 1; $rcp <= $numm; $rcp++)
		{ ?>
		$('a#trigger-rec<?=$rcp; ?>').hover(function(e) {
          $('div#pop-up-rec<?=$rcp; ?>').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() { 
          $('div#pop-up-rec<?=$rcp; ?>').hide();
        });
        
        $('a#trigger-rec<?=$rcp; ?>').mousemove(function(e) {
          $('div#pop-up-rec<?=$rcp; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
		
		<?php } ?>
      });
	  
	</script>

<?php



function get_bank_info_for_log($user_id)
{
	$qu = mysql_query("select * from users where id_user = '$user_id' ");
	while($row = mysql_fetch_array($qu))
	{
		$results[0] = $row['ac_no'];
		$results[1] = $row['bank']; 	
	}
	return $results;
}

function get_user_commitments($user_id)
{
	$res = 0;
	$qu = mysql_query("select sum(amount) from investment_request where user_id = '$user_id' and mode = 1 ");
	while($row = mysql_fetch_array($qu))
	{
		$res = $row[0];
	}
	if($res == '')
		$res =0;
	return $res;
}

?>

	
