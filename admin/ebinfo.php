<title></title><?php
?>
<table class="table table-bordered">
	<thead>
	<tr>
		<th>Total Members</th>
		<th>1829</th>
	</tr>
	</thead>
	<tr>
		<th>Total Pending GH</th>
		<th>
		5,106,800,000
		</th>
	</tr>
</table>

<table class="table table-bordered">
	<thead><tr><th colspan="2">Current Information</th></tr></thead>	
	<tr>
		<th>Total Pending PH</th>
		<th>1498
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
