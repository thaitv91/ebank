<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/wallet_message.php");

$newp = $_GET['p'];
$plimit = "5";

if(isset($_POST['submit']) and ($_SESSION['ebank_user_admin_login'] == 1))
{
	if($_POST['submit'] == 'Accept')
	{
		$time = date('Y-m-d H:i:s');
		$req_id = $_REQUEST['id'];
		$u_id = $_REQUEST['u_id'];
		$information = $_REQUEST['information'];
		$req_amount = $_REQUEST['req_amount'];
		$query = mysql_query("select * from wallet where id = '$u_id' ");
		while($row = mysql_fetch_array($query))
		{
			$total_amount = $row['amount'];
		}
	
		$accept_date= date('Y-m-d');
		mysql_query("update add_funds set app_date = '$accept_date' , information = '$information' , 
		mode = 1 where id = '$req_id' ");
		
		$bal_amount = $total_amount+$req_amount;		
		mysql_query("update wallet set amount = '$bal_amount' , date = '$accept_date' 
		where id = '$u_id' ");
		
		$cash_wal = get_wallet_amount($u_id);
		insert_wallet_account_adm($u_id , $req_amount , $time , $acount_type[18],$acount_type_desc[18], 1 , $cash_wal ,$wallet_type[1]);
		
		$username_log = get_user_name($u_id);
		$amount = $req_amount;
		$date = $accept_date;
		include("../function/logs_messages.php");
		data_logs($u_id,$data_log[14][0],$data_log[14][1],$log_type[6]);
		
		$from_user = $u_id;
		$to_user = $u_id;
		$phone_to = get_user_phone($u_id);
		include("../function/sms_message.php");
		send_sms($url_sms,$request_yourself,$phone_to);  //send sms

		
		$log_username = get_user_name($u_id);
		$income_log = $req_amount;
		$date = $accept_date;
		$income_type_log = "Requested Fund from ADMIN";
		include("../function/logs_messages.php");
		data_logs($u_id,$data_log[4][0],$data_log[4][1],$log_type[4]);
		
		$pay_request_username = get_user_name($u_id);
		$request_amount = $req_amount;
		$to = get_user_email($u_id);
		$title = "Payment Transfer Message";
		$db_msg = $payment_transfer_message;
		include("../function/full_message.php");
		$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);
		$SMTPChat = $SMTPMail->SendMail();
		
		print "Request Accepted Successfully!";
	}
	elseif($_POST['submit'] == 'Cancel')
	{
		$req_id = $_REQUEST['id'];
		$accept_date= date('Y-m-d');
		$information = $_REQUEST['information'];
		mysql_query("update add_funds set app_date = '$accept_date' , information = '$information' , 
		mode = 2 where id = '$req_id' ");
		print "Request Cancelled Successfully !";
	}
	else { }	
}
else
{
	$mg = $_REQUEST['mg']; 
	echo $mg;
	$sql = "select * from add_funds where mode = 0 and amount > 0 ";
	$query = mysql_query($sql);
	$totalrows = mysql_num_rows($query);
	if($totalrows != 0)
	{ ?>
		<table class="table table-bordered"> 
			<thead>
			<tr>
				<th>User Name</th>
				<th>Request Amount</th>
				<th>Payment Mode</th>
				<th>Date</th>
				<th>Information</th>
				<th>Action</th>
			</tr>
			</thead>
		<?php	
		$pnums = ceil ($totalrows/$plimit);
		if ($newp==''){ $newp='1'; }
			
		$start = ($newp-1) * $plimit;
		$starting_no = $start + 1;
		
		if ($totalrows - $start < $plimit) { $end_count = $totalrows;
		} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
			
			
		
		if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
		} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
		
		
		$query = mysql_query("$sql LIMIT $start,$plimit ");
		while($row = mysql_fetch_array($query))
		{
			$id = $row['id'];
			$u_id = $row['user_id'];
			$username = get_user_name($u_id);
			$request_amount = $row['amount'];
			$request_date = $row['date'];
			$payment_mode = $row['payment_mode'];
			?>	
			<form name="inact" action="index.php?page=requested_add_funds" method="post">
			<input type="hidden" name="id" value="<?=$id;?>" />
			<input type="hidden" name="u_id" value="<?=$u_id;?>" />
			<input type="hidden" name="req_amount" value="<?=$request_amount;?>" />
			<tr>
				<td>
					<a href="index.php?page=requested_add_funds_info&inf=<?=$id;?>"><?=$username;?></a>
				</td>
				<td><?=$request_amount;?> <font color=dark>$ </font></td>
				<td><?=$payment_mode;?></td>
				<td><?=$request_date;?></td>
				<td><textarea name="information" style="height:30px; width:150px" > </textarea></td>
				<td>
					<input type="submit" name="submit" value="Cancel" />	
					<input type="submit" name="submit" value="Accept" />						
				</td>
			</tr>
			</form>
			<?php
		}
		?>
		</table>
		<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
		<ul class="pagination">
		<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=requested_add_funds&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=requested_add_funds&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=requested_add_funds&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
		</ul></div>
	<?php
	}
	else{ echo "<B style=\"color:#ff0000;\">There is no request !!</B>"; }	
}  ?>
 
 