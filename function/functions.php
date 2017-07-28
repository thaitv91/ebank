<?php 
/*error_reporting(0);
include "../config.php";*/
function user_exist($username) //check user id is already store or not
{	
	$query = mysql_query("SELECT id_user FROM users WHERE username = '$username' ");
	$num = mysql_num_rows($query);
	return $num;
}	

function email_exist($email) //check user id is already store or not 
{	
	$query = mysql_query("SELECT id_user FROM users WHERE email = '$email' ");
	$num = mysql_num_rows($query);
	return $num;
}	

function phone_exist($phone) //check user id is already store or not
{	
	$query = mysql_query("SELECT id_user FROM users WHERE phone_no = '$phone' ");
	$num = mysql_num_rows($query);
	return $num;
}	
function bank_ac_exist($ac) //check user id is already store or not
{	
	$query = mysql_query("select ac_no from users where ac_no = '$ac'");
	$num = mysql_num_rows($query);
	return $num;
}
function get_new_user_id($username)
{
	$query = mysql_query("SELECT * FROM users WHERE username = '$username' ");
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$id = $row['id_user'];
			return $id;
		}
	}
	else { return 0; }		
}
function get_email($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$name = $row['email'];
	}
	return $name;		
}
function chk_protected($id)
{
	
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$protected = $row['protected'];
	}
	if($protected==0)return false;
	else return true;
}

function get_user_id_by_email($email)
{
	$query = mysql_query("SELECT * FROM users WHERE email = '$email' ");
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$id = $row['id_user'];
			return $id;
		}
	}
	else { return 0; }		
}

function get_full_name($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$name = $row['f_name']." ".$row['l_name'];
	}
	return $name;		
}

function get_full_name_by_username($username)
{
	$query = mysql_query("SELECT * FROM users WHERE username = '$username' ");
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$name = $row['f_name']." ".$row['l_name'];
			return $name;	
		}
	}
	else
		return 0;
}

function get_date($id) 
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	$num = mysql_num_rows($query);
	while($row = mysql_fetch_array($query))
	{
		$date = $row['date'];
	}
	return $date;	
}

function show_details($user_id)  
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
	while($row = mysql_fetch_array($query))
	{
		echo "<center><h1>Step 1</center>";
		echo "<h2>Your ID is ".$row['id_user']."<br>";
		echo "<h2>Your real patent is ".$row['real_parent']."<br>";
		echo "You are added at your virtual parent ".$row['parent_id'];
		echo " at position ".$row['position']."</h2>";
	}	
}

function get_user_name($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$username = $row['username'];
		return $username;
	}	
}

function get_user_key($id)
{

		$query = mysql_query("SELECT * FROM user_key WHERE id = '$id' ");
	  while($row = mysql_fetch_array($query))
	{
		 $key = $row['user_key'];
		
	}
		return $key;
}

function check_user_key($id)
{
    $key = substr(md5(rand(0, 1000000)), 0, 16);
    $query = mysql_query("SELECT * FROM user_key WHERE id = '$id' ");
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		 $sql_update="update user_key set user_key='$key' where id='$id'";
		mysql_query($sql_update);
		
	}
	else
	{
	mysql_query("INSERT INTO user_key (id , user_key) VALUES ('$id' , '$key')");
    }
	
	 return $key;
}
function get_user_password($id)
{
	$query = mysql_query("SELECT password FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$password = $row['password'];
		return $password;
	}	
}

function get_user_phone($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$phone = $row['phone_no'];
		return $phone;
	}	
}

function real_parent($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$real_parent  = $row['real_parent'];
		return $real_parent ;
	}	
}

function get_user_id($username)
{
	$query = mysql_query("SELECT * FROM users WHERE username = '$username' ");
	while($row = mysql_fetch_array($query))
	{
		$id_user  = $row['id_user'];
		return $id_user ;
	}	
}

function get_user_type($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
		if($type == 'A') { $status = "Deactive"; }
		if($type == 'B') { $status = "Light"; }
		if($type == 'B') { $status = "Activate"; }
		if($type == 'D') { $status = "Franchisee"; }
		if($type == 'E') { $status = "Blocked"; }
		return $status;
	}	
}

function get_user_email($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$email = $row['email'];
		return $email;
	}	
}

function update_member_wallet($user_id,$wallet_income,$inc_type,$amount,$row_investment_id)
{
	require_once("functions.php");
	include("setting.php");
	$date = date('Y-m-d');
	$time = date('Y-m-d H:i:s');
	
	if($inc_type == 8) 
	{ 
		$income_type_log = "Speed Bonus Income"; 
		$wall_field = 'amount'; 
		$wall_type = $wallet_type[1];
		$wallet = get_wallet_amount($user_id);
		$money_pd = $amount;
	}
	if($inc_type == 5) 
	{ 
		$income_type_log = "Reffral Commission Income"; 
		$wall_field = 'com_wallet';
		$wall_type = $wallet_type[3];
		$wallet = get_wallet_com_amt($user_id);
		$money_pd = 0;
	}

	//get investment
	$q_inves = mysql_query("select amount_profit from investment_request where id = '$row_investment_id' ");
	$r_inves = mysql_fetch_array($q_inves);
	//số tiền đã được cộng từ investment_request sau các xác nhận của GH
	$amount_profit = $r_inves['amount_profit'];
	
	$query = mysql_query("select * from wallet where id = '$user_id' ");
	while($row = mysql_fetch_array($query))
	{
		$amount = $wallet_amount_log = $row[$wall_field];
	}

	//tổng tiền vốn + lãi được cộng vào
	$total_income = $total_wallet_amount = $money_pd+$wallet_income;
	//echo 'Số tiền vốn + lãi được cộng vào:'.$total_income;
	// số tiền được cộng sau xác nhận cuối cùng
	$last_amount = $total_income + $amount_profit;
	// if($amount_profit < $limit_ph){
	// 	if($last_amount >= $limit_ph){
	// 		$final = $limit_ph - $amount_profit;
	// 	}else{
	// 		$final = $total_income;
	// 	}
		$final = $total_income;

		//echo 'số tiền thực tế được cộng vào:'.$final; exit;
		mysql_query("update wallet set $wall_field = $wall_field + '$final' , date = '$date'  where id = '$user_id' ");	
		mysql_query("update investment_request set amount_profit = amount_profit + '$final' where id = '$row_investment_id' ");
	// } 
	
	
	//insert_wallet_account($user_id,$user_id,$wallet_income,$time,$acount_type[9],$acount_type_desc[9], 1, $wallet , $wall_type); 

	
	$acc_username_log = get_user_name($user_id);
	$income_log = $wallet_income;
	include("logs_messages.php");
	data_logs($user_id,$data_log[15][0],$data_log[15][1],$log_type[4]);
}	
function active_check($id)
{
	$query = mysql_query("select * from users where id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
		if($type == 'B' or $type == 'D') { return 'yes';  }
		else { return 'no';  }
	}	
}


function get_wallet_amount($id)
{
	$q = mysql_query("select * from wallet where id = '$id' ");
	while($row = mysql_fetch_array($q))
	{
		$amount = $row['amount'];
	}
	return $amount;
}	
function get_wallet_commission($id){
	$q = mysql_query("select * from wallet where id = '$id' ");
	while($row = mysql_fetch_array($q))
	{
		$amount = $row['com_wallet'];
	}
	return $amount;
}
function get_wallet_roi_amt($id)
{
	$q = mysql_query("select * from wallet where id = '$id' ");
	while($row = mysql_fetch_array($q))
	{
		$amount = $row['com_wallet'];
	}
	return $amount;
}
function get_wallet_com_amt($id)
{
	$q = mysql_query("select * from wallet where id = '$id' ");
	while($row = mysql_fetch_array($q))
	{
		$amount = $row['com_wallet'];
	}
	return $amount;
}
function get_wallet_epin_amt($id)
{
	$sql = "select * from e_pin where user_id = '$id' and mode='1' ";
	$q = mysql_query($sql);
	$num = mysql_num_rows($q);
	if($num == 0){ $no_of_pin = "0";}
	else{ $no_of_pin = $num; }
	return $no_of_pin;
}	

function insert_wallet()
{
	$date = date('Y-m-d');
	$reg_amt = 0;
	mysql_query("insert into wallet (date, amount) values ('$date' , '$reg_amt') ");
}
function get_type_user($id)
{
	$query = mysql_query("select * from users where id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
		return $type;	}	
}	

function get_user_pos($id)
{
	$query = mysql_query("select * from users where id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$position = $row['position'];
		if($position == 0) { $pos = "Left"; }
		else { $pos = "Right";  }
	}
	return $pos;	
}	

function get_message($field)
{
	$query = mysql_query("select * from setting ");
	while($row = mysql_fetch_array($query))
	{
		$message = $row[$field];
	}
	return $message;
}

function get_user_position($id)
{
	$query = mysql_query("select * from users where id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$position = $row['position'];
	}
	return $position;	
}	





function real_par($id)
{    
	$q = mysql_query("select * from users where id_user = '$id' ");
	while($row = mysql_fetch_array($q))
	{
		$par = $row['real_parent'];
	}
	return $par;
}



function get_paid_free($id)
{
	$date = date('Y-m-d');
	$query = mysql_query("select * from reg_fees_structure where user_id = '$id' and date <= '$date' and end_date >= '$date' ");
	$num = mysql_num_rows($query);
	return $num;	
}	

function validate_request_amount($amount) 
{  
	if(ereg("^[0-9]{1,15}$", $amount) == 1)
	{
		if($amount > 0)
			return 1;
		else
			return 0;
	}			
	else
		return 0;     
}

function get_user_investment($id)
{
	$q = mysql_query("select sum(amount) from income_transfer where paying_id = '$id' ");
	while($row = mysql_fetch_array($q))
		$totalamount = $row[0];
	if($totalamount > 0)
	{
		return $totalamount;
	}
	else
	{
		return 0;	
	}	
}


function get_user_magic_bonus($id)
{
	$q = mysql_query("select sum(income) from user_income where user_id = '$id' and type = 4 ");
	while($row = mysql_fetch_array($q))
		$totalamount = $row[0];
	if($totalamount > 0)
	{
		return $totalamount;
	}
	else
	{
		return 0;	
	}	
}


function get_user_level_investment($id)
{
	$q = mysql_query("select sum(income) from user_income where user_id = '$id' and type = 3 ");
	while($row = mysql_fetch_array($q))
		$totalamount = $row[0];
	if($totalamount > 0)
	{
		return $totalamount;
	}
	else
	{
		return 0;	
	}	
}

function get_user_approved_investment($id)
{
	$q = mysql_query("select sum(amount) from income_transfer where paying_id = '$id' and mode = 2 ");
	while($row = mysql_fetch_array($q))
		$totalamount = $row[0];
	if($totalamount > 0)
	{
		return $totalamount;
	}
	else
	{
		return 0;	
	}	
}

function get_user_not_approved_investment($id)
{
	$q = mysql_query("select sum(amount) from income_transfer where paying_id = '$id' and mode != 2 ");
	while($row = mysql_fetch_array($q))
		$totalamount = $row[0];
	if($totalamount > 0)
	{
		return $totalamount;
	}
	else
	{
		return 0;	
	}	
}

function get_user_investment_income($id)
{
	$q = mysql_query("select sum(amount) from income_transfer where user_id = '$id' and mode = 2 ");
	while($row = mysql_fetch_array($q))
		$totalamount = $row[0];
	if($totalamount > 0)
	{
		return $totalamount;
	}
	else
	{
		return 0;	
	}	
}

function get_user_comming_investment($id)
{
	$q = mysql_query("select sum(amount) from income_transfer where paying_id = '$id' and mode = 0 ");
	while($row = mysql_fetch_array($q))
		$totalamount = $row[0];
	if($totalamount > 0)
	{
		return $totalamount;
	}
	else
	{
		return 0;	
	}	
}

function get_user_pending_investment($id)
{
	$q = mysql_query("select sum(amount) from income_transfer where paying_id = '$id' and mode = 1 ");
	while($row = mysql_fetch_array($q))
		$totalamount = $row[0];
	if($totalamount > 0)
	{
		return $totalamount;
	}
	else
	{
		return 0;	
	}	
}

function first_invest_count($id)
{
	$q_cnt = mysql_query("select * from investment_request where user_id = '$id' and mode = 0 limit 1");
	$cnt = mysql_num_rows($q_cnt);
	if($cnt > 0)
	{return 1;}
	else{return 0;}
	
}
function get_parent_details($input_id, $Start, $end, $mode, $email)
{
	$user_id = array($input_id);
	$filter = ($mode != '')?" and income_transfer.mode = '".$mode."'":"";
	$filter .= ($Start != '')?" and income_transfer.date >= '".$Start."'":"";
	$filter .= ($end != '')?" and income_transfer.date <= '".$end."'":"";
	$filter .= ($email != '')?" and (reciver.email = '".$email."' or payer.email='".$email."')":"";
	$All_data = $SubAll_data = array();
	while(list($key, $value) = each($user_id))
	{
		$sql = "SELECT id_user FROM users where real_parent='$value'";
		$query = mysql_query($sql);
		while($table_row = mysql_fetch_assoc($query))
		{
			array_push($user_id, $table_row['id_user']);
			$id_user=$table_row['id_user'];
			$sql1w = "SELECT income_transfer.* , concat(payer.f_name, ' ', payer.l_name) as PayerName, 
			concat(reciver.f_name, ' ', reciver.l_name) as ReciverName FROM income_transfer LEFT JOIN 
			users as payer ON  payer.id_user=income_transfer.paying_id LEFT JOIN users as reciver ON  
			reciver.id_user=income_transfer.user_id where user_id='$id_user' $filter";
			$query1 = mysql_query($sql1w);
			while($table_row1 = mysql_fetch_assoc($query1))
			array_push($SubAll_data, $table_row1);
		}
	}
	$sdfuh = array_column($SubAll_data, 'date');
	arsort($sdfuh);
	foreach($sdfuh as $key=>$value) 
	$All_data[] = $SubAll_data[$key];
	return $All_data;
}
function sponser_deduct($id)
{
	include("setting.php");
	$sql = "select t1.real_parent as sponser_id,t2.amount as user_invest_amt ,t3.amount as 						            sponser_wall_amt 
			from users as t1
			INNER JOIN investment_request as t2 on t1.id_user= t2.user_id 
			INNER JOIN wallet AS t3 ON t3.id = t1.real_parent and t1.type='D' and t1.id_user='$id'
			limit 1";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		$spons_amt = $row['sponser_wall_amt'];
		$user_amt = $row['user_invest_amt'];
		$spons_id = $row['sponser_id'];
	}
	$tot_dect_amt = (($user_amt*10)/100);
	$spons_amt = $spons_amt-$tot_dect_amt;
	if($spons_amt > 0)
	{
		$spons_amt = $spons_amt;
		$dect_amt = $tot_dect_amt;
		$rem_dect_amt = 0;
	}
	else
	{
		$dect_amt = $tot_dect_amt - (-$spons_amt);
		$rem_dect_amt = (-$spons_amt);
		$spons_amt = $spons_amt-$spons_amt;
	}
	$wallet_sql = "update wallet set amount= '$spons_amt' where id='$spons_id'";
 	mysql_query($wallet_sql);
 	
	$time = date('Y-m-d H:i:s');
	$cash_wal = get_wallet_amount($spons_id);
	insert_wallet_account($spons_id,$spons_id,$spons_amt,$time,$acount_type[10],$acount_type_desc[10], 2, $cash_wal , $wallet_type[1]); 
	
 	$dect_sql = "insert into block_investment (block_user_id, dect_sponser_id, total_dect_amt, dect_amt, rem_dect_amt) values('$id', '$spons_id', '$tot_dect_amt', '$dect_amt', '$rem_dect_amt')";
 	mysql_query($dect_sql);
}

function get_date_without_sun_sat($date,$day)
{
	$outdate = $date;
	$i = 0;
	while($i <= $day)
	{
		$outdate = date('Y-m-d', strtotime(" $outdate , + 1 days"));
		$chkday = date('D', strtotime(" $outdate "));
		if($chkday == 'Sat')
		{
			$outdate = date('Y-m-d', strtotime(" $outdate , + 2 days"));
		}
		if($chkday == 'Sun')
		{
			$outdate = date('Y-m-d', strtotime(" $outdate , + 1 days"));
		}
		$i++;
	}
	return $outdate;
}
/*$sql = "select id_user from users";
$query = mysql_query($sql);
while($row = mysql_fetch_array($query))
{
 echo $row['id_user'],"***",active_by_real_p($row['id_user']),"<br>";
}
function active_by_real_p($id_user) // by hari
{
	$parent = 1; 
	$cnt = 1;
	for($k =0; $k < $cnt; $k++)
	{
		$sql = "select t1.manager_id,t1.type 
				from user_manager as t1 
				inner join user_manager as t2 
				on t1.manager_id = t2.real_parent and t2.manager_id = '$id_user' ";
		$query = mysql_query($sql);
		$num = mysql_num_rows($query);
		$row = mysql_fetch_array($query);
		$real_parent = $row[0];
		$type = $row[1];
		if($real_parent == 0){
		break;}
		//echo $real_parent," -",$type,"<br>";
		if($type == 'M')
		{
			$parent =  $real_parent;
		}
		else
		{
			if($real_parent == 1)
			{
				$parent = $real_parent;
			}
			else
			{
				$id_user = $real_parent;
				$cnt = $cnt + 1;	
			}		
		}
		
	}
	return $parent;
}
*/

/*function active_by_real_p($id_user)
{
	$parent = 1; 
	
	$sql = "select t1.manager_id,t1.type 
			from user_manager as t1 
			inner join user_manager as t2 
			on t1.manager_id = t2.real_parent and t2.manager_id = '$id_user' ";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	$real_parent = $row[0];
	$type = $row[1];
	//echo $real_parent," -",$type,"<br>";
	if($type == 'M')
	{
		$parent =  $real_parent;
		return $parent;
	}
	else
	{
		if($real_parent == 1)
		{
			return $real_parent;
		}
		$parent = active_by_real_p($real_parent);
		return $parent;
	}
}*/

function active_by_real_p($id_user)
{
	$sql = "select t1.manager_id,t1.type,t1.active_by 
			from user_manager as t1 
			inner join user_manager as t2 
			on t1.manager_id = t2.real_parent and t2.manager_id = '$id_user' ";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	$real_parent = $row[0];
	$type = $row[1];
	if($type == 'M')
	{
		$parent =  $real_parent;
		return $parent;
	}
	else
	{
		$parent =  $row[2];
		return $parent;
	}
}

function set_manager_bonus_income($manager_id,$total_investments,$date,$giver)
{
	include "setting.php";
	$time = date('Y-m-d H:i:s');
	$user_income_chk = "select * from user_income where type=7 and user_id='$member_id'";
	$user_income_query = mysql_query($user_income_chk);
	if(1)
	{
		$manager_bonus = $total_investments * $manager_bonus_percent/100;
		mysql_query("insert into user_income (user_id , income , date , type,level) values ('$manager_id' , '$manager_bonus' , '$date' ,  '$income_type[7]' , '$giver') "); //manager bonus
		mysql_query("update wallet set amount = amount + '$manager_bonus' where id = '$manager_id' ");
		
		$cash_wal = get_wallet_amount($spons_id);
		insert_wallet_account($manager_id,$manager_id,$manager_bonus,$time,$acount_type[11],$acount_type_desc[11], 1, $cash_wal , $wallet_type[1]); 
	}
}

function get_user_role($id)
{
	$query = mysql_query("SELECT * FROM user_manager WHERE manager_id = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
		if($type == 'M') { $role = "Manager"; }
		else{ $role = "Member"; }
		return $role;
	}	
}
/*function req_provide_help($user_id)
{
	$query = mysql_query("SELECT user_id , amount , date FROM investment_request WHERE user_id = '$user_id' ");
	while($row = mysql_fetch_array($query))
	{
		$user_id = $row['user_id'];
		$amount = $row['amount'];
		$date = $row['date'];
		$arr[] = array($user_id, $amount , $date);
		return $arr;
	}
}*/

function get_bank_name($id)
{
	$query = mysql_query("select bank from users where id_user = '$id' ");
	$row = mysql_fetch_array($query);
	$bank = $row['bank'];
	return $bank;
}
function get_user_bank_name($id)
{
	$query = mysql_query("select bank from user_bank where user_id = '$id' limit 1");
	$row = mysql_fetch_array($query);
	$bank = $row['bank'];
	return $bank;
}
function get_tot_chat_message($id)
{
	$sql = "select * from message where receive_id = '$id'";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	return $num;
}

function get_user_types($id)
{
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
	}	
	return $type;
}
function insert_wallet_account($id , $recieve_id , $amount , $date , $type , $account, $mode , $wallet_balance,$wall_type)
{
	//include 'setting.php';
	$date = date('Y-m-d H:i:s', time());
	$username = get_user_name($recieve_id);
	if($mode == 1)
	{
		$sql = "insert into account (user_id , cr , date , type , account , wallet_balance , wall_type)
				values('$id' , '$amount' , '$date' , '$type' , '$account ".$username."' , '$wallet_balance' , '$wall_type') ";
					
	}
	elseif($mode == 2)
	{
		$sql = "insert into account (user_id , dr , date , type , account , wallet_balance , wall_type)
				values('$id' , '$amount' , '$date' , '$type' , '$account ".$username."' , '$wallet_balance' , '$wall_type') ";
					
	}
	mysql_query($sql);
}


function insert_wallet_account_adm($id , $amount , $date , $type , $account, $mode , $wallet_balance ,$wall_type)
{
	//include 'setting.php';
	if($mode == 1)
	{
		$sql = "insert into account (user_id , cr , date , type , account , wallet_balance , wall_type)
				values('$id','$amount','$date','$type','$account','$wallet_balance','$wall_type') ";
	}
	elseif($mode == 2)
	{
		$sql = "insert into account (user_id , dr , date , type , account , wallet_balance , wall_type)
				values('$id','$amount','$date','$type','$account','$wallet_balance','$wall_type') ";
	}
	mysql_query($sql);
}

function get_max_investment($id)
{
	$sql = "select * from investment_request where user_id = '$id'";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	return $num;
}
function get_user_level($id)
{
	$sql = "select * from users where id_user = '$id'";
	$query = mysql_query($sql);
	while($ro = mysql_fetch_array($query))
	{
		$level = $ro['level'];
	}
	return $level;
}
/*levelupmember(1);*/
function levelupmember($id)
{
	$sql = "select * from users where id_user = '$id'";
	$query = mysql_query($sql);
	while($ro = mysql_fetch_array($query))
	{
		$level = $ro['level'];
	}
	switch($level < 7 )
	{
		case 1 : 
				
				$sql = "select (t1.id_user) lvm,count(t2.user_id) c from users t1
						left join investment_request t2 on t1.id_user = t2.user_id
						where t1.real_parent = '$id' and t1.level=1 
						group by t2.user_id,t1.id_user
						order by t1.id_user";
				$query = mysql_query($sql);
				$num = mysql_num_rows($query);
				$lvup = 0;
				
				if($num > ($level_up_setting[0][0] - 1))
				{
					while($ro = mysql_fetch_array($query)){
						if($ro['c'] > 0)$lvup++;
					}
					if($lvup > ($level_up_setting[0][1] - 1)){
					mysql_query("update users set level = level +1 where id_user = '$id'");
					}
				}
				break;
		case 2 : 
				
				$sql = "select count(t2.user_id) c from users t1
						left join investment_request t2 on t1.id_user = t2.user_id
						where t1.real_parent = '$id' and t1.level=2
						group by t2.user_id
						having c > 2";
				$query = mysql_query($sql);
				$num = mysql_num_rows($query);
				$lvup = 0;
				
				if($num > ($level_up_setting[1][0] - 1))
				{
					while($ro = mysql_fetch_array($query)){
						if($ro['c'] > 0)$lvup++;
					}
					if($lvup > ($level_up_setting[1][1] - 1))
					mysql_query("update users set level = level +1 where id_user = '$id'");
				}
				break;
		case 3 : 
				
				$sql = "select count(t2.user_id) c from users t1
						left join investment_request t2 on t1.id_user = t2.user_id
						where t1.real_parent = '$id' and t1.level=3
						group by t2.user_id
						having c > 2";
				$query = mysql_query($sql);
				$num = mysql_num_rows($query);
				$lvup = 0;
				
				if($num > ($level_up_setting[2][0] - 1))
				{
					while($ro = mysql_fetch_array($query)){
						if($ro['c'] > 0)$lvup++;
					}
					if($lvup > ($level_up_setting[2][1] - 1))
					mysql_query("update users set level = level +1 where id_user = '$id'");
				}
				break;
		case 4 : 
				
				$sql = "select count(t2.user_id) c from users t1
						left join investment_request t2 on t1.id_user = t2.user_id
						where t1.real_parent = '$id' and t1.level=4
						group by t2.user_id
						having c > 2";
				$query = mysql_query($sql);
				$num = mysql_num_rows($query);
				$lvup = 0;
				
				if($num > ($level_up_setting[3][0] - 1))
				{
					while($ro = mysql_fetch_array($query)){
						if($ro['c'] > 0)$lvup++;
					}
					if($lvup > ($level_up_setting[3][1] - 1))
					mysql_query("update users set level = level +1 where id_user = '$id'");
				}
				break;
		case 5 : 
				
				$sql = "select count(t2.user_id) c from users t1
						left join investment_request t2 on t1.id_user = t2.user_id
						where t1.real_parent = '$id' and t1.level=5
						group by t2.user_id
						having c > 2";
				$query = mysql_query($sql);
				$num = mysql_num_rows($query);
				$lvup = 0;
				
				if($num > ($level_up_setting[4][0] - 1))
				{
					while($ro = mysql_fetch_array($query)){
						if($ro['c'] > 0)$lvup++;
					}
					if($lvup > ($level_up_setting[4][1] - 1))
					mysql_query("update users set level = level +1 where id_user = '$id'");
				}
				break;
	}
}

function max_pd_complete($user_id,$vlevel,$date,$dwm)
{
	include "setting.php";
	switch($dwm){
		case 'month' :  $s_date = date("Y-m-01",strtotime($date));
						$e_date = date("Y-m-t",strtotime($date));
						$sql = "select * from investment_request where user_id = '$user_id' and date >='$s_date' and date <= '$e_date'";
						$p = 2;
						break;
		case 'week' :   $s_date = date('Y-m-d', strtotime('Last Monday '. $date));
						$e_date = date('Y-m-d', strtotime('Next Sunday '. $date));
						$sql = "select * from investment_request where user_id = '$user_id' and date >='$s_date' and date <= '$e_date'";
						$p = 1;
						break;
		case 'day' :  	$sql = "select * from investment_request where user_id = '$user_id' and date = '$date'";
						$p = 0;
						break;
	}
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	
	if($num >= $pd_dwm_settings[$vlevel][$p])
		return false;
	else
		return true;
}
function max_gd_complete($user_id,$amt,$vlevel,$date,$dwm)
{
	include "setting.php";
	switch($dwm){
		case 'month' :  $s_date = date("Y-m-01",strtotime($date));
						$e_date = date("Y-m-t",strtotime($date));
						$sql = "select (sum(total_amount)) amt from income where user_id = '$user_id' and date >='$s_date' and date <= '$e_date'";
						$p = 2;
						break;
		case 'week' :   $s_date = date('Y-m-d', strtotime('Last Monday '. $date));
						$e_date = date('Y-m-d', strtotime('Next Sunday '. $date));
						$sql = "select (sum(total_amount)) amt from income where user_id = '$user_id' and date >='$s_date' and date <= '$e_date'";
						$p = 1;
						break;
		case 'day' :  	$sql = "select (sum(total_amount)) amt from income where user_id = '$user_id' and date = '$date'";
						$p = 0;
						break;
	}
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	while($ro = mysql_fetch_array($query)){
		$amount = $ro['amt'];
	}
	//echo $dwm,"---",$amt ,"****", $gd_dwm_amt[$vlevel][$p]*$plan_diff,"<br>";
	if($amount+$amt > $gd_dwm_amt[$vlevel][$p]*$plan_diff)
		return false;
	else
		return true;
}
function max_epin_complete($user_id,$vlevel,$date,$dwm,$epin_number)
{
	include "setting.php";
	switch($dwm){
		case 'month' :  $s_date = date("Y-m-01",strtotime($date));
						$e_date = date("Y-m-t",strtotime($date));
						$sql = "select (sum(no_pin)+$epin_number) tot from epin_request where user_id = '$user_id' and date >= '$s_date 00:00:00' and date <='$e_date 23:59:59'";
						$p = 2;
						break;
		case 'week' :   $s_date = date('Y-m-d', strtotime('Last Monday '. $date));
						$e_date = date('Y-m-d', strtotime('Next Sunday '. $date));
						$sql = "select (sum(no_pin)+$epin_number) tot from epin_request where user_id = '$user_id' and date >= '$s_date 00:00:00' and date <='$e_date 23:59:59'";
						$p = 1;
						break;
		case 'day' :  	$sql = "select (sum(no_pin)+$epin_number) tot from epin_request where user_id = '$user_id' and date >= '$date 00:00:00' and date <='$date 23:59:59'";
						$p = 0;
						break;
	}
	
	$query = mysql_query($sql);
	while($ro = mysql_fetch_array($query)){
		$num = $ro[0];
	}
	
	if($num > $epin_setting[$vlevel][$p])
		return false;
	else
		return true;
}

function report_exist($user_id , $table_id) //PD exits on report
{	
	$sql = "SELECT * FROM report WHERE user_id = '$user_id' and income_transfr_id = '$table_id'";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	return $num;
}	

//check user exits on reported list
function check_user_report($id){
	$sql = "SELECT * FROM report WHERE reported = '$id'";
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	return $num;
}


/*function get_user_photo($id)
{
	$query = mysql_query("SELECT photo FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$photo = $row['photo'];
		if($photo != ''){ $img = $photo; }
		else{ $img = 'Icon_o.gif'; }
	}
	return $img;		
}*/
function epin_per_day_limit() //Per Day E-pin Limit of whole system 
{	
	$query = mysql_query("SELECT day FROM epin_setting");
	while($ro = mysql_fetch_array($query))
	{
		$day = $ro['day'];
	}
	return $day;
}
function tot_epin_generate_day($date) //Per Day Generate E-pin of whole system 
{	
	$query = mysql_query("SELECT * FROM e_pin where date = '$date'");
	$num = mysql_num_rows($query);
	return $num;
}

function tot_epin_request_day($date) //Per Day Generate E-pin of whole system 
{	
	$sql = "SELECT sum(no_pin) tot_pin FROM epin_request where `date` like '%$date%'";
	$query = mysql_query($sql);
	while($ro = mysql_fetch_array($query))
	{
		$tot_pin = $ro['tot_pin'];
	}
	return $tot_pin;
}

//update level ueeser 
function update_level($id){
	//echo $id.'|';
	//select max level
	$q_maxlevel = mysql_query("SELECT MAX(level_name) as level_max FROM tb_level_plan");
	$r_maxlevel = mysql_fetch_array($q_maxlevel);
	
	//get this id_user level
	$this_user = mysql_query("SELECT * FROM users WHERE id_user = $id");
	$r_this_user = mysql_fetch_array($this_user);
	//check đã PD chưa
	$wallet = mysql_query("SELECT * FROM account WHERE user_id = ".$id." AND wall_type = 'Main Wallet' AND wallet_balance > 0");
	$count_wallet = mysql_num_rows($wallet);
	
	if($count_wallet > 0){
		if($r_this_user['level'] < $r_maxlevel['level_max']){
			$up_level = $r_this_user['level']+1;
			//get tb_level_plan
			$tb_level_plan = mysql_query("SELECT * from tb_level_plan where id = ".$up_level."");
			$r_level_plan = mysql_fetch_array($tb_level_plan);
			//find usser child
			
			$my_sql = "SELECT * FROM users WHERE real_parent = ".$id." AND level >= ".$r_this_user['level']."";
			$q_child = mysql_query("SELECT * FROM users WHERE real_parent = ".$id." AND level >= ".$r_this_user['level']."");
			$count_row_child = mysql_num_rows($q_child);
			
			//echo $my_sql.'|'.$r_this_user['level'].'|'.$count_row_child.'|'.$r_level_plan['level_member'];
			if($count_row_child >= $r_level_plan['level_member']){ //so sánh số child member với tiêu chí của level cấp trên 
				
				//đếm số child member hoàn thành PD
				$dem = 0; //số member pd thành công
				while($r_child = mysql_fetch_array($q_child)){
					$id_user_child = $r_child['id_user'];
					//echo ' id_child='.$id_user_child;
					$count = 0; //số pd thành công của một member
					$sqssl = mysql_query("SELECT * FROM account WHERE user_id = ".$id_user_child." AND wall_type = 'Main Wallet' AND wallet_balance > 0");
					$count_row_pd = mysql_num_rows($sqssl);
					//$sqssl = mysql_query("SELECT t1.*,sum(t2.amount) as amt FROM income_transfer t2 right join investment_request t1 on t2.investment_id = t1.id  WHERE t1.user_id = $id_user_child  group by t2.investment_id");
					//while($row = mysql_fetch_array($sqssl)){
					//	if($row['mode'] == 0){
					//		$dem  += 1;
					//	}
					//}
					//echo ' count = '.$count_row_pd ;
					if($count_row_pd > 0){
						$dem += 1;
					}
				}
				//echo $r_this_user['level'].'|'.$count_row_child.'|'.$r_level_plan['level_member'].'-'.$dem;
				if($dem >= $r_level_plan['level_pd']){ //so sánh số member pd thành công với tiêu chí lên level
					$update = mysql_query("UPDATE users SET level = level+1 WHERE id_user = $id");
					//var_dump($update);
				}else{
					//echo 'level lên'.$r_level_plan['level_pd'].' so PD thành công'.$dem.'số member hoàn thành PD chưa đủ'; 
				}
			}else{
				//echo $id.' ko đủ số member yêu cầu để lên level'; 
			}
		}else{
			//echo $id.' đã ở level cao nhất, ko thể lên level nữa'; 
		}
		
	}else{
		//echo $id.' chưa PD nên chưa có tiền ở Mwallet'; 
	}
	
		
	//update level cho real parent 
	$tree_manager = tree_manager($r_this_user['real_parent']);
	foreach($tree_manager as $value){
		update_level($value['id_user']);
	}		
}

//find real parent user
function tree_manager($id = NULL, &$data = [])
{

    $sql = "select * from users where id_user = $id";

    $query = mysql_query($sql);

    while ($row = mysql_fetch_array($query))
    {

        $data[] = $row;

        tree_manager($row['real_parent'], $data);
    }

    return $data;
}

function cropString($str, $length) {
  $str = explode(" ", $str);
  return implode(" " , array_slice($str, 0, $length));
}

//stattus of GD
function getStatus($id){
	$query = mysql_query("SELECT * FROM income_transfer WHERE income_id = $id");
	while($row   =  mysql_fetch_array($query)){
		$data[] = $row['mode'];
	}
	if(empty($data)){
		return 0;
	}
	if( (!in_array("1", $data)) &&  (!in_array("2", $data)) ){
		return 0;
	}else if( (!in_array("0", $data)) &&  (!in_array("1", $data)) )
	{
		return 2;
	}else{
		return 1;
	}

}

//status of PD
function getStatusPD($id){
	$query = mysql_query("SELECT * FROM income_transfer WHERE investment_id = $id");
	while($row   =  mysql_fetch_array($query)){
		$data[] = $row['mode'];
	}
	if(empty($data)){
		return 0;
	}
	if( (!in_array("1", $data)) &&  (!in_array("2", $data)) ){
		return 0;
	}else if( (!in_array("0", $data)) &&  (!in_array("1", $data)) )
	{
		return 2;
	}else{
		return 1;
	}
}
