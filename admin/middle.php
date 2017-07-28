<?php
session_start();
ini_set("display_errors",'off');
$val = $_REQUEST['page'];
$query = mysql_query("SELECT * FROM admin");
while($row = mysql_fetch_array($query))
{
	$id_user = $row['id_user'];
	$username = $row['username'];
}

$sql = "Select * from admin_menu where menu_file = (Select parent_menu from admin_menu where menu_file = '$val') limit 1";
$query = mysql_query($sql);
while($row = mysql_fetch_array($query))
{
	$menu = $row['menu'];
}
if($val == '')
{$menu = 'Dashboard';}
?>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?=get_submenu_tit($val);?></h2>
		<ol class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li><a><?=$menu;?></a></li>
			<li class="active"><strong><?=get_submenu_tit($val);?></strong></li>
		</ol>
	</div>
	<div class="col-lg-2">

	</div>
</div>
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox-content">	
				<?php
					$file = $val.".php";
					if ($val == '')
					include("data/projects_summary.php");
					else
					include("data/".$file);
				?>
			</div>
			<div class="footer">
				<div class="pull-right">Design By <strong>Ebank.Tv</strong> 2016.</div>
				<div>
					<strong>Copyright</strong> &copy; 2016 
					<a href="httP://www.ebank.tv" target="_blank">Ebank.Tv</a>
				</div>
			</div>
		</div>
	</div>
</div>
<?php

function direct_member($id)
{
	$query = mysql_query("SELECT * FROM users WHERE real_parent = '$id' ");
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		return $num;
	}
	else{return 0;}
}

function inbox_message($id)
{
	$query = mysql_query("SELECT * FROM message WHERE receive_id = '$id'");
	$num = mysql_num_rows($query);
	if($num > 0)
	{
		return $num;
	}
	else{return 0;}
}

function wallet_balance($id)
{
	$q = mysql_query("select * from wallet where id = '$id' ");
	while($row = mysql_fetch_array($q))
		$amount = $row['amount'];
	if($amount > 0)
	{
		return $amount;
	}
	else
	{
		return 0;
	}
}

function total_investment($id)
{
	$sql = "select sum(update_fees) as fees from reg_fees_structure where user_id = '$id'";
	$q = mysql_query($sql);
	while($row = mysql_fetch_array($q))
		$amount = $row['fees'];
	if($amount > 0)
	{
		return $amount;
	}
	else
	{
		return 0;
	}
}



function get_submenu_tit($val)
{
	$sql = "Select * from admin_menu where menu_file = '$val'";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		$menu_title = $row['menu'];
		$menu_file = $row['menu_file'];
	}
	if($menu_title == '')
	return "Profile";
	else
	return $menu_title;
}
?>
