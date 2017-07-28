<?php
ini_set("display_erros","on");
session_start();
include('condition.php');
include("function/functions.php");
$user_id = $_SESSION['ebank_user_id'];

$bank_you = get_user_bank_name($user_id);
$username_you = get_user_name($user_id);

$you_name = ucfirst(get_full_name($user_id));
$you_phone = get_user_phone($user_id);

$mang_id = active_by_real_p($user_id);
$manager_name = ucfirst(get_full_name($mang_id));
$manager_phone = get_user_phone($mang_id);

$rand = "PD".rand(11111,99999);
?>
<script type="text/javascript" src="js/provide_donation.js"></script>

<div class="col-md-9">
	<div class="widget">
		<div class="widget-head">
			<h4 class="heading"><i class="fa fa-upload"></i> Provide Donation</h4>
		</div>
		<div class="widget-body innerAll">
			<?php
			$succ = $_REQUEST['succ'];
			$pay_err = $_REQUEST['pay_err'];
			if($succ == 1)
				print "<B style=\"color:#008000;\">Report Successfully Added !!</B>" ;
			elseif($succ == 2)
				print "<B style=\"color:#FF0000;\">Report Already have Submitted By You !!</B>" ;
				
			if($pay_err == 1)
				print "<B style=\"color:#FF0000;\">Error: Invalid file extension !!</B>";
			elseif($pay_err == 2)
				print "<B style=\"color:#FF0000;\">Error: Payment Slip not saved !!</B>";
			elseif($pay_err == 3)
				print "<B style=\"color:#FF0000;\">Error: Payment Slip Not Found !!</B>" ; 
			elseif($pay_err == 4)
				print "<B style=\"color:#FF0000;\">Error: Invalid Pay Code !!</B>" ; 
			elseif($pay_err == 5)
				print "<B style=\"color:#1D46BB;\">Reciept Successfully Upload !!</B>" ;
			
			$sqlk = "select t1.*,sum(t1.amount) as amt,t2.amount as inv_amt from income_transfer t1
			left join investment_request t2 on t1.investment_id = t2.id
			 where t1.paying_id = '$user_id' group by investment_id";
			$querss = mysql_query($sqlk);
			$num = mysql_num_rows($querss);
			if($num > 0)
			{
				while($rrss = mysql_fetch_array($querss))
				{
					$id_don[] = $rrss['id'];
					$tot_amt[] = $rrss['amt'];
					$invest_id[] = $rrss['investment_id'];
					$date_don[] = $rrss['date'];
					$mode_don[] = $rrss['mode'];
			    	$remain_amt[] = $rrss['inv_amt']-$rrss['amt'];
					
				}
				for($i = 0; $i < count($invest_id); $i++)
				{
					$date_dont = date('d - M - Y', strtotime($date_don[$i]));
					
					$inv_id = $invest_id[$i]; 
					
					$querr = mysql_query("select * from income_transfer where paying_id = '$user_id' 
					and investment_id = '$inv_id'");
					while($rojj = mysql_fetch_array($querr))
					{
						$extnd_time = $rojj['extend_time'];
						$times = $rojj['time_link'];
						
						$day = $hour = $minute = $second =0;
						$curr_time = date('Y-m-d H:i:s');//$systems_date_time;
						
						if($extnd_time != NULL and $extnd_time != '0000-00-00 00:00:00')
						{
							$start_date = new DateTime($curr_time);
							$since_start = $start_date->diff(new DateTime($extnd_time));
							$day = $since_start->d;
							$hour = $since_start->h;
							$minute = $since_start->i;
							$second = $since_start->s;
						}
						else
						{
							$ete = strtotime(date("Y-m-d",strtotime($times."+48 hours")))."<Br>";
							$cume = strtotime(date("Y-m-d",strtotime($curr_time)));
							if($ete > $cume)
							$ext_btn = "<a href=\"#dialog-msg\" src=\"?mdid=$table_id\" data-toggle=\"modal\" class=\"btn btn-inverse btn-xs\" id=\"show_extend_box\" data=\"$table_id\">Extend</a>";
						}
							
						$max_time = $max_time+$hour;
						$block_time=date('Y-m-d H:i:s',strtotime($times." +".$max_time." hours"." +".$day." days"." +".$minute." minute"));
						
						$start_date = new DateTime($curr_time);
						$since_start = $start_date->diff(new DateTime($block_time));
						$day = $since_start->d;
						$hour = $since_start->h;
						$minute = $since_start->i;
						$second = $since_start->s;
						
						$remain_time = $hour." Hours ".$minute." Minutes ";
						$remain_time = $day.' days, '.$hour.' hour, '.$minute.' minutes, '.$second.'seconds';
						$hour += $day*24;
						$minute += $hour*60;
						$tot_second += $minute*60;
						
						if($mode_don[$i] != 2)
						{ 
							$status_don="<span class=\"pending\">Pending Payment</span>";
							$roi_time = "<b>ROI Distribute Remain Time</b>: 
							<span class=\"approve_remaining_time\" rel=\"$tot_second\" id=\"_remain_sec_p$rand.$id_don[$i]\"></span>";
						}
						else{ 
							$status_don = "<span class=\"confirm\">Confirm Payment</span>";
							$roi_time = '';
						}
					}
					?>
				<div class="overthrow">
				<table class="table table-bordered table-donate table-pd ">
				<tbody>
					<tr bgcolor="#21a361">
					<td>
					<div class="donate-header clearfix">
						<i data-original-title="Click&nbsp;to&nbsp;hide" class="fa fa-ellipsis-h hireTable" rel="<?=$id_don[$i];?>" value="pd" data-toggle="tooltip" data-placement="top" title=""></i>
						<h4>Provide help: <span>PD06980<?=$invest_id[$i];?></span></h4>
						<b>Participant</b>: <?=$username_you;?><br>
						<b>Amount</b>: $  <?=number_format($tot_amt[$i]);?><br>
						<b>Remain Amount</b>: $  <?=number_format($remain_amt[$i]);?><br>
						<b>Date</b>: <?=$date_dont;?><br>
						<b>Status</b>: <?=$status_don;?><br>
						<b>Trust Fund</b>: 0%<br>
						<?=$roi_time;?>
						<a class="btn btn-print btn-sm glyphicon-right" href="#" >
							<i class="fa fa-print"></i> Print
						</a>
					</div>
					<?php
					$que = mysql_query("select * from income_transfer where paying_id = '$user_id' 
					and investment_id = '$inv_id'");
					$num = mysql_num_rows($que);
					if($num > 0)
					{
						$jc = 0;
						$lvl_cc = 1;
						while($row = mysql_fetch_array($que))
						{ 
							$jc++;
							$pay_id = $row['user_id'];
							$table_id = $row['id'];
							$amount = $row['amount'];
							$payment_receipt = $row['payment_receipt'];
							$mode = $row['mode'];
							$date_creat = $row['date'];
							$date_creat = date('d/m/Y' , strtotime($date_creat));
							$amount_usd = round($amount/$usd_value_current,2);
							
							$receive_id = $row['paying_id'];
							$tot_msg = get_tot_chat_message($receive_id);
							
							$manager = active_by_real_p($pay_id);
							$rec_mang_name = ucfirst(get_full_name($manager));
							$rec_mang_phone = ucfirst(get_user_phone($manager));
							
							if($mode == 0)
							{ 	
								$report_btn = '';
								$conf_btn = "<a href=\"#dialog-confirm-confirm\" data-toggle=\"modal\" src=\"?mdid=$table_id\" class=\"btn btn-default btn-sm\" id=\"show_confirm_box_$table_id\" data='{\"mdid\":$table_id}' style=\"background-color: #1dbb1d;\">Confirm</a>";
								
								$imgs = "ellipsis-h"; $class = "pending";
								$rect_msg = "Funds Receiption(Provide help : MD006521$table_id) is awaiting your payment";
								$cnfirm_class = "orange";
								
							}
							elseif($mode == 2)
							{
								$report_btn = '';
								$imgs = "check"; $class = "confirm"; 
								$rect_msg = "You Approved funds reception : MD006521".$table_id; 
								$cnfirm_class = "green";
							}
							else
							{ 
								$conf_btn = '';
								$imgs = "ellipsis-h"; $class = "pending"; 
								$rect_msg = "You funds is proceed to confirmatiom"; 
								$cnfirm_class = "orange";
								
								
							}
							
							$report_btn = "<a href=\"#dialog-report-confirm\" data-toggle=\"modal\" class=\"btn btn-danger btn-sm\" id=\"show_report_box_gd_$table_id\" data=\"{&quot;mdid&quot;:&quot;$table_id&quot;,&quot;uid&quot;:&quot;$user_id&quot;}\">Report</a>";
							
							$query = mysql_query("SELECT * FROM users WHERE id_user = '$pay_id' ");
							while($rrr = mysql_fetch_array($query))
							{
								$id_user = $rrr['id_user'];
								$payee_username = $rrr['username'];
								$name = ucfirst($rrr['f_name'])." ".ucfirst($rrr['l_name']);
								$bank_paying = $rrr['bank'];
								$bank_ac = $rrr['ac_no'];
								$bank_branch = $rrr['branch'];
								$bank_city = $rrr['district'];
								$bank_state = $rrr['state'];
								$phone_payee = $rrr['phone_no'];
							} ?>
							<div style="display: block;" class="pd donate-body-<?=$id_don[$i];?>">
								<table class="table table-donations">
									<tbody>
									<tr>
										<td class="donate-status pending" width="100px">
											ID: <span class="number">MD006521<?=$table_id;?></span>
										</td>
										<td>
											Create Date:<br>
											<span class="date"><?=$date_creat;?></span>
										</td>
										<td><span class="user">You</span> <?=$bank_you;?></td>
										<td width="20" align="center">
											<i class="fa fa-chevron-right"></i>
										</td>
										<td width="120px">
											<span class="value money">$  <?=number_format($amount);?></span>
										</td>
										<td width="20" align="center">
											<i class="fa fa-chevron-right"></i>
										</td>
										<td width="120px">
											<span class="user"><?=$name;?></span> <?=$bank_paying;?>
										</td>
									</tr>
									<tr>
										<td class="<?=$class;?>"><i class="fa fa-<?=$imgs;?>"></i></td>
										<td colspan="3" width="48%">
											<span class="<?=$cnfirm_class;?>"><?=$rect_msg;?></span>
										</td>
										<td colspan="3" class="nowrap action-btn" align="right">																											
											<?=$conf_btn;?><?=$report_btn;?>
											<!--<a href="#dialog-report-confirm" data-toggle="modal" class="btn btn-danger btn-sm" id="show_report_box_<?=$table_id;?>" data="{&quot;mdid&quot;:&quot;<?=$table_id."&quot;,&quot;uid&quot;:&quot;".$user_id;?>&quot;}">Report</a>-->
											<!--<a href="#dialog-report-confirm" data-toggle="modal" class="btn btn-danger btn-sm" id="show_report_box_652160" data="{&quot;mdid&quot;:&quot;652160&quot;,&quot;uid&quot;:&quot;67778633&quot;}">Report</a>-->
											<a class="btn btn-warning btn-xs btn-details">Details</a>
										</td>
									</tr>
									</tbody>
								</table>
								<div style="display: none;" class="transactionWrap">
									<div class="transaction-details">
										<table class="table table-bordered table-condensed">
											<thead>
											<tr>
												<th colspan="2">
													TRANSFER TO : <!--<br>
													Alipay Account (Taobao Account/Mobile/Email) :<br>
													Bank Account Number : <?=$bank_ac;?>-->																
												</th>
											</tr>
											</thead>
											<tbody>
											<tr>
												<td><b>Bank Account Holder Name</b></td>
												<td><?=$name;?></td>
											</tr>
											<tr>
												<td><b>Bank Name</b></td>
												<td><?=$bank_paying;?></td>
											</tr>
											<tr>
												<td><b>Bank Branch Name</b></td>
												<td><?=$bank_branch;?></td>
											</tr>
											<!--<tr>
												<td><b>Bank State</b></td>
												<td><?=$bank_state;?></td>
											</tr>
											<tr>
												<td><b>Bank City</b></td>
												<td><?=$bank_city;?></td>
											</tr>-->
											<tr>
												<td><b>Bank Account Number</b></td>
												<td><?=$bank_ac;?></td>
											</tr>
											<tr>
												<td colspan="2">
													<ul class="contactList">
														<li>
															Contact Recipient: <?=$name;?> :
															<?=$phone_payee;?>
														</li>
														<li>
															Contact Manager of Recipient: 
															<?=$rec_mang_name;?> : <?=$rec_mang_phone;?>
														</li>
														<li>
															Contact Sender: <?=$you_name;?> : 
															<?=$you_phone;?>
														</li>
														<li>
															Contact Manager of Sender: 
															<?=$manager_name;?> : 
															<?=$manager_phone;?>
														</li>
													</ul>
												</td>
											</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						
						<?php	
						}  
					} 
					 ?>
					</td>
				</tr>
				</tbody>
				</table>
				</div>
				<p></p>
				<?php
				}
			}
			else{ echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>"; }
		?>	
	</div>
	</div>
</div>
<div class="col-md-3" style="padding:0px;">
	<?php
	/*
		$sqssl = "SELECT t1.* , t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id WHERE t1.user_id = '$user_id' group by investment_id";*/
		
		$sqssl = "SELECT t1.*,sum(t2.amount) as amt FROM income_transfer t2 right join investment_request t1 on t2.investment_id = t1.id  WHERE t1.user_id = '$user_id' group by t2.investment_id";
		
		$query = mysql_query($sqssl);
		while($row = mysql_fetch_array($query))
		{ 
			$id = $row['id'];
			$paying_id = $row['paying_id'];
			$amount = $row['amount'];
			$mode = $row['mode'];
			/*$int_mode = $row['int_mode'];*/
			$date = $row['date'];
			$date = date('d-M-Y', strtotime($date));
			$name = ucfirst(get_full_name($user_id));
			$amt = $row['amt'];
			$remain_amt = $amount-$amt;
			
			
			 $int_mode=mysql_num_rows(mysql_query("SELECT * FROM income_transfer where investment_id='$id' and mode!='2'"));
		
			if($mode == 1)
			{ 
				$mesgs = "<span style=\"color:#F09D47;\">Request processed</span>";
				$div_class = 'pending'; 
			}
			
			elseif($mode == 0)
			{ 
				
				$mesgs = "<span style=\"color:#008000;\">Request Confirmed</span>"; 
				$div_class = 'confirm'; 
			}
			else
			{ 
			    $mesgs = "<span style=\"color:#F09D47;\">Request in Processing</span>"; 
				$div_class = 'pending';
				
			}
			/*elseif($mode == 0 and $int_mode == 1)
			{ $mesgs = "<span style=\"color:#F09D47;\">Request Pending</span>"; $div_class = 'pending'; }
			*/
		?>
		<div class="widget donate-sidebar pdContainer-<?=$div_class;?>">
		<div class="widget-body">
			<div class="donateHead clearfix">
				<span class="fa fa-arrow-right glyphicon-circle glyphicon-right"></span>
				<div class="title">Provide Donation: <span>PD06980<?=$id;;?></span></div>
			</div>
			<b>Participant</b>:  <?=$name;?><br>
			<b>Amount</b>: $  <?=number_format($amount);?><br>
			<b>Remain Amount</b>: $  <?=number_format($remain_amt);?><br>
			<b>Date</b>: <?=$date;?><br>
			<b>Status</b>: <?=$mesgs;?><!--<span class="pending">Pending</span>-->
		</div>
	</div>
	<?php
		}
	?>
</div>


<!--<div class="col-md-3">
	<?php
		//$sqssl = "SELECT t1.* , t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id WHERE t1.user_id = '$user_id' ";
		$sqssl = "SELECT *,sum(amount) as amt from income_transfer WHERE paying_id = '$user_id' 
		group by income_id ";
		$query = mysql_query($sqssl);
		while($row = mysql_fetch_array($query))
		{
			$id = $row['id'];
			$paying_id = $row['user_id'];
			$amount = $row['amt'];
			$mode = $row['mode'];
			$income_id = $row['income_id'];
			$int_mode = $row['int_mode'];
			$date = $row['date'];
			$date = date('d-M-Y', strtotime($date));
			$name = ucfirst(get_full_name($user_id));
			
			/*if($mode == 1){ $mesgs = "<span style=\"color:#F09D47;\">Request processed</span>"; }
			
			elseif($mode == 0 and $int_mode == 0)
			{ 
				$mesgs = "<span style=\"color:#F09D47;\">Request in Processing</span>"; 
				$div_class = 'pending';
			}
			
			elseif($mode == 0 and $int_mode == 1)
			{ $mesgs = "<span style=\"color:#F09D47;\">Request Pending</span>"; $div_class = 'pending'; }
			
			elseif($mode == 0 and $int_mode == 2)
			{ 
				$mesgs = "<span style=\"color:#008000;\">Request Confirmed</span>"; 
				$div_class = 'confirm'; 
			}*/
			if($mode == 0)
			{ 
				$mesgs = "<span style=\"color:#F09D47;\">Request in Processing</span>"; 
				$div_class = 'pending';
			}
			
			elseif($mode == 1)
			{ 
				$mesgs = "<span style=\"color:#F09D47;\">Request Pending</span>"; 
				$div_class = 'pending'; 
			}
			
			elseif($mode == 2)
			{ 
				$mesgs = "<span style=\"color:#008000;\">Request Confirmed</span>"; 
				$div_class = 'confirm'; 
			}
		?>
		<div class="widget donate-sidebar pdContainer-<?=$div_class;?>">
		<div class="widget-body">
			<div class="donateHead clearfix">
				<span class="fa fa-arrow-right glyphicon-circle glyphicon-right"></span>
				<div class="title">Provide Donation: <span><?=$rand.$income_id;?></span></div>
			</div>
			<b>Participant</b>:  <?=$name;?><br>
			<b>Amount</b>: $  <?=number_format($amount);?><br>
			<!--<b>Remain Amount</b>: $ 6,600,000<br>
			<b>Date</b>: <?=$date;?><br>
			<b>Status</b>: <?=$mesgs;?><!--<span class="pending">Pending</span>
		</div>
	</div>
	<?php
		}
	?>
</div>-->
<?php
include 'box_confirm.php';
include 'box_report.php';
?>

