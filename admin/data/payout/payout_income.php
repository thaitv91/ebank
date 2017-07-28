<?php
include("../.././config.php");
include("../../../function/functions.php");
include("../../../function/daily_income.php");
include("../../../function/pair_point_income.php");
	$chkdate = date('D', strtotime(" $systems_date "));
	//$chkdate != 'Sat' and $chkdate != 'Sun'
	
	mysql_query("update income_process set mode = 1 ");
	
	get_daily_income($systems_date);
	
	mysql_query("update income_process set mode = 0 ");
	print "Success : Income Calculated Successfully !";
	mysql_query("update income_process set mode = 0 ");

	//pair_point_income($systems_date);
