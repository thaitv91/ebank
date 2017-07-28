<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
/*include("../function/pair_point_calculation.php");*/
$i = 1;
	$qqq = mysql_query("select * from investment_request where mode = 1 order by id ");
	$num = mysql_num_rows($qqq);
	while($rrr = mysql_fetch_array($qqq))
	{
		$tbl_id = $rrr['id'];
		$amount = $rrr['amount'];
		$user_id = get_user_name($rrr['user_id']);
		$priority = $rrr['priority'];

		mysql_query("UPDATE investment_request set priority = '$i' where id = '$tbl_id' ");
		$i++;
	}	
	
	mysql_query("UPDATE investment_request set priority = 0 where mode != 1 ");