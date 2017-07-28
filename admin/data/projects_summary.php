<title></title><?php
include("condition.php");
include("../function/setting.php");
?>
<table class="table table-bordered">
	<thead>
	<tr>
		<th>Total Joinings</th>
		<th><?=get_all_users();?> Members</th>
	</tr>
	</thead>
	<tr>
		<th>Total Wallet Amount</th>
		<th>
			<?php $totl_wal = get_total_wallet_amnt(); print round($totl_wal,2); ?> 
			<font color=dark>$ </font>
		</th>
	</tr>
	<tr>
		<th>Total Investment</th>
		<th>
			<?php $com_totl_inv = get_company_total_investment(); print round($com_totl_inv,2); ?> 
			<font color=dark>$ </font>
		</th>
	</tr>
	<tr>
		<th>Total Investment Approved</th>
		<th>
			<?php $totl_approv = get_total_approved_investment(); print round($totl_approv,2) ?> 
			<font color=dark>$ </font>
		</th>
	</tr>
	<tr>
		<th>Total Investment Pending</th>
		<th>
			<?php $totl_pend = get_total_pending_investment();  print round($totl_pend,2);?> 
			<font color=dark>$ </font>
		</th>
	</tr>
	<tr>
		<th>Total Investment Comming</th>
		<th>
			<?php $totl_comin_inv =  get_total_comming_investment();  print round($totl_comin_inv,2);?> 
			<font color=dark>$ </font>
		</th>
	</tr>
</table>

<table class="table table-bordered">
	<thead><tr><th colspan="2">Current Information</th></tr></thead>
	<tr>
		<th>Members registered today</th>
		<th><?=get_current_joining($systems_date); ?> Members</th>
	</tr>
	<tr>
		<th>Total Pending PH</th>
		<th>
			<?php
    $status_1 = mysql_num_rows(mysql_query("SELECT t1.* ,t1.mode as inv_mode, t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id  where t1.mode=1"));
 
    ?> <?= $status_1 ?>
		</th>
	</tr>
</table>

<?php
function get_all_users()
{
	$query = mysql_query("select * from users ");
	$all_user = mysql_num_rows($query);
	return $all_user;
}

function get_current_joining($date)
{
	$query = mysql_query("select * from users where date = '$date'");
	$all_user = mysql_num_rows($query);
	return $all_user;
}



function get_total_wallet_amnt()
{
	$amount = mysql_query("select sum(amount) from wallet ");
	while($row = mysql_fetch_array($amount))
	{
		$total_wallet_amnt = $row[0];
	}
	return $total_wallet_amnt;
}



function get_total_pending_investment()
{
	$que = mysql_query("select sum(amount) from income_transfer where mode = 1 " );
	while($row = mysql_fetch_array($que))
	{
		$total_mnt = $row[0];
	}
	if($total_mnt == '')
		$total_mnt = 0;
	return $total_mnt;
}

function get_total_comming_investment()
{
	$que = mysql_query("select sum(amount) from income_transfer where mode = 0  " );
	while($row = mysql_fetch_array($que))
	{
		$total_mnt = $row[0];
	}
	if($total_mnt == '')
		$total_mnt = 0;
	return $total_mnt;
}

function get_total_approved_investment()
{
	$que = mysql_query("select sum(amount) from income_transfer where mode = 2  " );
	while($row = mysql_fetch_array($que))
	{
		$total_mnt = $row[0];
	}
	if($total_mnt == '')
		$total_mnt = 0;
	return $total_mnt;
}



function get_company_total_investment()
{
	$q = mysql_query("select sum(amount) from income_transfer ");
	while($row = mysql_fetch_array($q))
		$tatalamount = $row[0];
	if($tatalamount > 0)
	{
		return $tatalamount;
	}
	else
	{
		return 0;	
	}	
}


function get_current_company_total_investment($date)
{
	$q = mysql_query("select sum(amount) from income_transfer where date = '$date' ");
	while($row = mysql_fetch_array($q))
		$tatalamount = $row[0];
	if($tatalamount > 0)
	{
		return $tatalamount;
	}
	else
	{
		return 0;	
	}	
}


?>
