<?php
include("condition.php");
include("../function/functions.php");
?>
<h2 align="left">User Information</h2>
<?php

$newp = $_GET['p'];
$plimit = "15";
?>
<div style="width:90%; text-align:right;height:70px;">
<div style="width:25%; text-align:right; float:left;  height:70px;">
<form action="index.php?page=user_email" method="post">
<input type="submit" name="Excel" value="Download Excel" class="btn btn-info" />
</form>
</div>
<div style="width:65%; text-align:right; float:right; height:70px;">
<form action="index.php?page=user_email" method="post">
<input type="text" name="search_username" placeholder="Username"  />
<input type="text" name="search_mobile" placeholder="Mobile No."  />
<input type="submit" name="Search" value="Search" class="btn btn-info" />
</form>
</div>
</div>


<?php
$qur_set_search = '';

if(isset($_POST['Excel']))
{

	$save_excel_file_path = "/var/www/vwalletdev/admin/UserInfo/";
	
	$unique_name = "UserInformation".time();
	$sep = "\t"; 
	$fp = fopen($save_excel_file_path.$unique_name.".xls", "w"); 
	$insert = ""; 
	$insert_rows = ""; 
	$result = mysql_query("select * from users ");              
	
	$insert_rows.="Sr. No. \t User Name\t Password \t Security Key \t Name \t E-mail \t Phone No. \t Total Investment \t Total Received \t Total Comming \t Total Pending \t Bank Details \t";
	
	$srno = 1;
	$insert_rows.="\n";
	fwrite($fp, $insert_rows);
	while($row = mysql_fetch_array($result))
	{
		$insert = "";
		$id = $row['id_user'];
		 $username = $row['username'];
		$password = $row['password'];
		$email = $row['email'];
		$beneficiery_name = $row['beneficiery_name'];
		$ac_no = $row['ac_no'];
		$bank = $row['bank'];
		$bank_code = $row['bank_code'];
		$user_pin = $row['user_pin'];
		$phone_no = $row['phone_no'];
		$type = $row['type'];
		$name = $row['f_name']." ".$row['l_name'];
		if($type == 'D')
			$col = "#FF0000";
		else
			$col = "#000000";
		$bank_details= "Beneficiery Name : $beneficiery_name Account No. : $ac_no Bank Name : $bank IFSC Code : $bank_code";	
				
		
		$tot_invstmnt = get_user_approved_investment($id);
		$tot_invstmnt_inc = get_user_investment_income($id);
		$tot_comming_invstmnt = get_user_comming_investment($id);
		$tot_pending_invstmnt = get_user_pending_investment($id);
		
		$insert .= $srno.$sep;
		$insert .= $username.$sep;
		$insert .= $password.$sep;
		$insert .= $user_pin.$sep;
		$insert .= $name.$sep;
		$insert .= $email.$sep;
		$insert .= $phone_no.$sep;
		$insert .= $tot_invstmnt."$ ".$sep;
		$insert .= $tot_invstmnt_inc."$ ".$sep;
		$insert .= $tot_comming_invstmnt."$ ".$sep;
		$insert .= $tot_pending_invstmnt."$ ".$sep;
		$insert .= $bank_details.$sep;
			
		$srno++;

		$insert = str_replace($sep."$", "", $insert);
		
		$insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $insert);
		$insert .= "\n";
		fwrite($fp, $insert);
	}
	fclose($fp);
	$full_path = "UserInfo/".$unique_name.".xls";
	
	print "Excel File Download Successfully !!";
	
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"$full_path\"";
	echo "</script>";
}


if((isset($_POST['Search'])) or ((isset($newp)) and (isset($_POST['search_username'])) and (isset($_POST['search_mobile']))))
{
	if(!isset($newp))
	{
		$search_username = $_POST['search_username'];
		$search_mobile = $_POST['search_mobile'];
		if($search_username !='' and $search_mobile == '')
		{
			$search_id = get_new_user_id($search_username);
			if($search_id == 0)
				print "<div style=\"width:80%; text-align:right; color:#FF0000; font-style:normal; font-size:14px; height:50px; padding-right:100px;\">Enter Correct User Id !</div>";
			else
			{
				$_SESSION['session_search_username'] = $search_id;
				$qur_set_search = " where id_user = '$search_id' ";
			}	
		}
		else if($search_mobile !='' and $search_username =='')
		{
			$search_mob = phone_exist($search_mobile);
			if($search_mob == 0)
			{
				print "<div style=\"width:80%; text-align:right; color:#FF0000; font-style:normal; font-size:14px; height:50px; padding-right:100px;\">Enter Correct Mobile Number !</div>";
			}
			else
			{
				$qur_set_search = " where phone_no='$search_mobile'";
			}
		}
		else if($search_mobile !='' and $search_username !='')
		{
			$search_id = get_new_user_id($search_username);
			$search_mob = phone_exist($search_mobile);
			if($search_id == 0 or $search_mob == 0)
				print "<div style=\"width:80%; text-align:right; color:#FF0000; font-style:normal; font-size:14px; height:50px; padding-right:100px;\">Enter Correct User Id Or Mobile No.!</div>";
			else
			{
				$_SESSION['session_search_username'] = $search_id;
				$qur_set_search = " where id_user = '$search_id' and phone_no='$search_mobile'";
			}	
		}
	}
	else
	{	
		$search_id = $_SESSION['session_search_username'];
		$qur_set_search = " where id_user = '$search_id' ";
	}		
}
elseif(isset($_POST['block_member']))
{
	$block_user_id = $_POST['block_user_id'];
	
	$quer = mysql_query("select * from income_transfer where paying_id = '$block_user_id' and mode < 2 ");
	while($row = mysql_fetch_array($quer))
	{
		$income_id = $row['income_id'];
		$amount = $row['amount'];		
		$que = mysql_query("select * from income where id = '$income_id' ");
		while($rrr = mysql_fetch_array($que))
		{
			$paid_amount = $rrr['paid_amount'];
			$left_paid_amount = $paid_amount-$amount;
			mysql_query("update income set paid_amount = '$left_paid_amount' , per_day_paid = 0 , mode = 1 where id = '$income_id' ");
		}
	}
	mysql_query("update investment_request set mode = 3 , amount = 0  where user_id = '$block_user_id' " );
	
	mysql_query("update income set total_amount = 0 , paid_amount = 0 , mode = 0 where user_id = '$block_user_id' " );

	mysql_query("update income_transfer set mode = 3 , amount = 0 , paid_limit = 0 where paying_id = '$block_user_id'  " );
		
	mysql_query("update users set type = 'D' where id_user = '$block_user_id' " );
	mysql_query("update user_income set income = 0 where user_id = '$block_user_id' " );
	mysql_query("update wallet set amount = 0 where id = '$block_user_id' " );
	
	$block_username = get_user_name($block_user_id);
	$title = "Member Block E-mail";
	$to = get_user_email($block_user_id);
	$db_msg = $email_bblock_user_message;
	include("function/full_message.php");
	$SMTPMail = new SMTPClient($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $title, $full_message);	
	$SMTPChat = $SMTPMail->SendMail();
	
	$phone = get_user_phone($block_user_id);
	$db_msg = $setting_sms_user_block_by_admin;
	include("function/full_message.php");
	send_sms($phone,$full_message);	
	

}
elseif(isset($_POST['block_investment']))
{
	$block_user_id = $_POST['block_user_id'];
	
	$quer = mysql_query("select * from income_transfer where paying_id = '$block_user_id' and mode < 2 ");
	while($row = mysql_fetch_array($quer))
	{
		$income_id = $row['income_id'];
		$amount = $row['amount'];		
		$que = mysql_query("select * from income where id = '$income_id' ");
		while($rrr = mysql_fetch_array($que))
		{
			$paid_amount = $rrr['paid_amount'];
			$left_paid_amount = $paid_amount-$amount;
			mysql_query("update income set paid_amount = '$left_paid_amount' , per_day_paid = 0 , mode = 1 where id = '$income_id' ");
		}
	}	
	mysql_query("update investment_request set mode = 3 , amount = 0  where user_id = '$block_user_id' " );
	
	mysql_query("update income set total_amount = 0 , paid_limit = 0 , mode = 0 where user_id = '$block_user_id' " );
		
	mysql_query("update income_transfer set mode = 3 , amount = 0 , paid_limit = 0 where paying_id = '$block_user_id'  " );

	$data_log[21][0] = "Investment Blocked";  // network title
	$data_log[21][1] = "User ".$acc_username_log." has blocked investment of user ".$investment_id." of amount ".$pay_income_log." on ".$date;  //  Wallet data
	

}
else
{
	unset($_SESSION['session_search_username']);
}


$query = mysql_query("SELECT * FROM users $qur_set_search ");
$totalrows = mysql_num_rows($query);
?>
<table class="table table-bordered">
	<thead>
	<tr>
		<th class="text-center">Sr. No.</th>
		<th class="text-center">User Name</th>
		<th class="text-center">Password</th>
		<th class="text-center">Security Code</th>
		<th class="text-center">Sponsor</th>
		<th class="text-center">Name</th>
		<th class="text-center">E-mail</th>
		<th class="text-center">Phone No.</th>
		<th class="text-center">Total Investment</th>
		<th class="text-center">Total Received</th>
		<!--<th class="text-center">Total Comming</th>
		<th class="text-center">Total Pending</th>
		<th class="text-center">Bank Details</th>-->
		<th class="text-center">Block</th>
	</tr>
	</thead>
	<tbody>
<?php
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
	
	$cnt = $plimit*($newp-1);

	$query = mysql_query("SELECT * FROM users $qur_set_search LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{

		$cnt++;
		$id = $row['id_user'];
		$username = $row['username'];
		$password = $row['password'];
		$user_pin = $row['user_pin'];
		$email = $row['email'];
		$beneficiery_name = $row['beneficiery_name'];
		$ac_no = $row['ac_no'];
		$bank = $row['bank'];
		$bank_code = $row['bank_code'];
		$user_pin = $row['user_pin'];
		$phone_no = $row['phone_no'];
		$type = $row['type'];
		$name = $row['f_name']." ".$row['l_name'];
		$parent_id = $row['real_parent'];
		
		
		/*$query_1 = mysql_query("SELECT code1 FROM user_code where user_id = '$id' ");
		$row_1 = mysql_fetch_array($query_1);
		$user_code = $row_1['code1'];*/
	
		
		if($type == 'E')
			$col = "#FF0000";
		else
			$col = "#000000";	
		
		$tot_invstmnt = get_user_approved_investment($id);
		$tot_invstmnt_inc = get_user_investment_income($id);
		$tot_comming_invstmnt = get_user_comming_investment($id);
		$tot_pending_invstmnt = get_user_pending_investment($id);
		
		print "<tr>
		<td style=\"color:$col;\">$cnt</td>
		<td style=\"color:$col;\">"; ?>
		<form action="../login_check.php" target="_new" method="post">
		<input type="hidden" name="username" value="<?=$username; ?>"   />
		<input type="hidden" name="password" value="<?=$password; ?>"   />
		<input type="submit" name="submit" value="<?=$username; ?>" style="background:#FF0000; border:none; cursor:pointer; font-size:12px; min-width:70px; color:#FFF; padding:5px;" />
		</form>
<?php	print "</td>
		<td style=\"color:$col;\">$password</td>
		<td style=\"color:$col;\">$user_pin</td>
		<td style=\"color:$col;\">". $real_parent = get_user_name($parent_id)."</td>
		<td style=\"color:$col;\">$name</td>
		<td style=\"color:$col;\">$email</td>
		<td style=\"color:$col;\">$phone_no</td>
		<td style=\"color:$col;\">$tot_invstmnt <font color=dark>$ </font></td>
		<td style=\"color:$col;\">$tot_invstmnt_inc <font color=dark>$ </font></th>";
		/*?><td style=\"color:$col;\">$tot_comming_invstmnt <font color=dark>$ </font></th>
		<td style=\"color:$col;\">$tot_pending_invstmnt <font color=dark>$ </font></th>
		<td style=\"color:$col;\">
			Beneficiery Name : $beneficiery_name<br>
			Account No. : $ac_no<br>
			Bank Name : $bank<br>
			IFSC Code : $bank_code</small>
		</td>";<?php */
		print "<td style=\"color:$col;\">"; 
		if($type == 'E')
		{
			print "<B>Block Member</B>";
		}
		else
		{?>
			<form action="index.php?page=user_email" method="post">
				<input type="hidden" name="block_user_id" value="<?=$id; ?>"   />
				<input type="submit" name="block_member" value="Member" class="btn btn-info"  />
			</form>
<?php		}
		print "</td>
		
		</tr>";
	}
	echo "</table>";
	?>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=user_email&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=user_email&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=user_email&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
		</ul></div>
