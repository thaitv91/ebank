<?php
ini_set("display_erros","on");
session_start();
include('condition.php');
include("function/functions.php");
$user_id = $_SESSION['ebank_user_id'];
$network = $_SESSION['ebank_user_network'];
$network = $_REQUEST['network'];
$bank_you = get_user_bank_name($network);
$username_you = get_user_name($network);

$you_name = ucfirst(get_full_name($network));
$you_phone = get_user_phone($network);

$mang_id = active_by_real_p($network);
$mang_name = ucfirst(get_full_name($mang_id));
$mang_phone = get_user_phone($mang_id);

$rand = "PD".rand(11111,99999);
?>
<script type="text/javascript" src="js/provide_donation.js"></script>

<div class="col-md-12">
	<div class="widget">
		<div class="widget-head clearfix">
			<h4 class="heading"><i class="fa fa-download"></i> GD Downline</h4>
		</div>
		<div class="widget-body innerAll">
			<?php
			$sqlk = "select t1.*,sum(t1.amount) as amt,t2.total_amount from income_transfer t1
			left join income t2 on t1.income_id = t2.id where t1.user_id in($network) 
			group by income_id";
			$querss = mysql_query($sqlk);
			$num = mysql_num_rows($querss);
			if($num > 0)
			{
				while($rrss = mysql_fetch_array($querss))
				{
					$id_don[] = $rrss['id'];
					$tot_amt[] = $rrss['amt'];
					$invest_id[] = $rrss['income_id'];
					$date_don[] = $rrss['date'];
					$mode_don[] = $rrss['mode'];
					$user_d[] = $rrss['user_id'];
					//$total_amt[] = $rrss['total_amount'];
					$remain_amt[] = $rrss['total_amount']-$rrss['amt'];
				}
				for($i = 0; $i < count($invest_id); $i++)
				{
					$date_dont = date('d - M - Y', strtotime($date_don[$i]));
					if($mode_don[$i] != 2){ 
						$status_don="<span class=\"pending\">Pending Payment</span>";
						$trst_fund = '0';
					}
					else{ 
						$status_don = "<span class=\"confirm\">Confirm Payment</span>";
						$trst_fund = '100';
					}
				
					$inv_id = $invest_id[$i];
					$user_id = $user_d[$i]; 
			?>
				<div class="overthrow" id="<?=$id_don[$i];?>">
				<table class="table table-bordered table-donate table-gd ">
				<tbody>
					<tr bgcolor="#1bb5ce">
					<td>
					<div class="donate-header clearfix">
						<i data-original-title="Click&nbsp;to&nbsp;hide" class="fa fa-ellipsis-h hireTable" rel="<?=$id_don[$i];?>" value="pd" data-toggle="tooltip" data-placement="top" title=""></i>
						<h4>Request For help: <span>GD06980<?=$invest_id[$i];?></span></h4>
						<b>Participant</b>: <?=$username_you;?><br>
						<b>Amount</b>: $  <?=number_format($tot_amt[$i]);?><br>
						<b>Remain Amount</b>: $  <?=number_format($remain_amt[$i]);?><br>
						<b>Date</b>: <?=$date_dont;?><br>
						<b>Status</b>: <?=$status_don;?><br>
						<b>Trust Fund</b>: <?=$trst_fund;?>%<br>
						<a class="btn btn-print btn-sm glyphicon-right" href="#" >
							<i class="fa fa-print"></i> Print
						</a>
					</div>
					<?php
					$que = mysql_query("select * from income_transfer where user_id = '$user_id' and 
				income_id = '$inv_id'");
				$num = mysql_num_rows($que);
				if($num > 0)
				{
					$_SESSION['send_income_fo_user'] = 1;
					$jc = 0;
					$lvl_cc = 1;	
					while($row = mysql_fetch_array($que))
					{ 
						$tr = 0;
						$tr++;
						$paying_id = $row['paying_id'];
						$investment_id = $row['investment_id'];
						$pay_id = $row['user_id'];
						$table_id = $row['id'];
						$amount = $row['amount'];
						$mode = $row['mode'];
						$payment_receipt = $row['payment_receipt'];	
						$pay_code = $row['pay_code'];
						$inv_date = $row['date'];
						$time = $row['time_link'];
						$extend_time = $row['extend_time'];
						$inv_date = date('d/M/Y' , strtotime($inv_date));
						
						$manager = active_by_real_p($paying_id);
						$manager_name = ucfirst(get_full_name($manager));
						$manager_phone = ucfirst(get_user_phone($manager));
						
						if($mode != 2)
						{ 
							$imgs = "ellipsis-h"; $class = "pending";
							$rect_msg = "Funds Receiption is awaiting payment from PD user";
							$cnfirm_class = "orange";
						}
						else 
						{ 
							$imgs = "check"; $class = "confirm"; 
							$rect_msg = "You Approved funds reception : MD006521".$table_id; 
							$cnfirm_class = "green";
						}
							
						$query = mysql_query("SELECT * FROM users WHERE id_user = '$paying_id' ");
						while($rrr = mysql_fetch_array($query))
						{
							$id_user = $rrr['id_user'];
							$name = ucfirst($rrr['f_name'])." ".ucfirst($rrr['l_name']);
							$bank_pay = $rrr['bank'];
							$bank_ac = $rrr['ac_no'];
							$bank_branch = $rrr['branch'];
							$bank_city = $rrr['district'];
							$bank_state = $rrr['state'];
							$phone_rec = $rrr['phone_no'];
						} ?>
							<div style="display: none;" class="pd donate-body-<?=$id_don[$i];?>">
								<table class="table table-donations">
									<tbody>
									<tr>
										<td class="donate-status pending" width="100px">
											ID: <span class="number">MD006521<?=$table_id;?></span>
										</td>
										<td>Create Date:<br><span class="date"><?=$inv_date;?></span></td>
										<td><span class="user"><?=get_full_name($user_id);?></span> <?=$bank_you;?></td>
										<td width="20" align="center">
											<i class="fa fa-chevron-left"></i>
										</td>
										<td width="120px">
											<span class="value money">$  <?=number_format($amount);?></span>
										</td>
										<td width="20" align="center">
											<i class="fa fa-chevron-left"></i>
										</td>
										<td width="120px">
											<span class="user"><?=$name;?></span> <?=$bank_pay;?>
										</td>
									</tr>
									<tr>
										<td class="<?=$class;?>"><i class="fa fa-<?=$imgs;?>"></i></td>
										<td colspan="3" width="48%">
											<span class="<?=$cnfirm_class;?>"><?=$rect_msg;?></span>
										</td>
										
										<!--<td class="confirm"><i class="fa fa-check"></i></td>
										<td colspan="3" width="48%">
											<span class="green">
												You Approved funds reception : MD006521 <?=$table_id;?>
											</span>
										</td>-->
										<td colspan="3" class="nowrap action-btn" align="right">																											
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
												TRANSFER BY : <!--<br>
												Alipay Account (Taobao Account/Mobile/Email) : <br>
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
											<td><?=$bank_pay;?></td>
										</tr>
										<tr>
											<td><b>Bank Branch Name</b></td>
											<td><?=$bank_branch;?></td>
										</tr>
										<tr>
											<td><b>Bank Account Number</b></td>
											<td><?=$bank_ac;?></td>
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
											<td colspan="2">
												<ul class="contactList">
													<li>
														Contact Recipient: <?=$name;?> :
														<?=$phone_rec;?>
													</li>
													<li>
														Contact Manager of Recipient: 
														<?=$manager_name;?> : <?=$manager_phone;?>
													</li>
													<li>
														Contact Sender: <?=$you_name;?> : 
														<?=$you_phone;?>
													</li>
													<li>
														Contact Manager of Sender: 
														<?=$mang_name;?> : 
														<?=$mang_phone;?>
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
