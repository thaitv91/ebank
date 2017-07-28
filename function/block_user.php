<?php

function block_user_calculation($user_id)
{
	$updt_sql = "update users as t1 inner join wallet as t2 on t1.id_user = t2.id set t1.type='D' where t1.id_user = '$user_id' ";
	mysql_query($updt_sql);
	mysql_query("update investment_request set mode = 5 where user_id = '$user_id'");
	mysql_query("update daily_interest set count = 0 , max_count = 0 where member_id = '$user_id'");
	
	$sql = "select t1.*, t3.type
			  from income_transfer as t1
			  inner join income_transfer as t2 on t2.paying_id = t1.user_id
			  and t2.mode != 2 
			  inner join users as t3 on t3.id_user = t2.paying_id
			  and t3.type = 'D'
			  where t2.paying_id = '$user_id'";
	$ques = mysql_query($sql);		
	$num = mysql_num_rows($ques); 
	if($num > 0)
	{
		while($rowss = mysql_fetch_array($ques))
		{
			$invst_id = $rowss['investment_id'];
			$invst_user_id = $rowss['paying_id'];
			$date = $systems_date;
			$time = date('Y-m-d H:i:s');
			$sqlss = "INSERT INTO investment_request
			( `user_id`,`amount`,`inv_profit`,`date`, `mode`,`time`,`priority` )
			SELECT `user_id`,`amount`,`inv_profit`,'$date', 1 , '$time' , 1
			FROM investment_request
		   where id = '$invst_id'";
		   mysql_query($sqlss);
		   
		   mysql_query("update investment_request set mode = 5 where id = '$invst_id'");
		   $sqqq = "UPDATE income_transfer SET mode = 10 WHERE paying_id = '$invst_user_id' ";
		   mysql_query($sqqq);
		}
	} 
	
	$sqls = "select t1.user_id, t1.amount AS inc_amnt, t2.amount AS walt_amnt
			  from income_transfer as t1
			  inner join wallet as t2 on t1.paying_id = '$user_id'
			  and t1.mode != 2
			  and t2.id = t1.user_id";
	$trns_qury = mysql_query($sqls);
	while($row = mysql_fetch_array($trns_qury))
	{
		$id = $row['user_id'];
		$amount = $row['inc_amnt'];
		$walt_amnt = $row['walt_amnt'];
		
		$totl_amnt = $walt_amnt+$amount;
		
		mysql_query("UPDATE wallet SET amount = '$totl_amnt' WHERE id = '$id' ");
	}
	mysql_query("UPDATE income_transfer SET mode = 10 WHERE paying_id = '$user_id' ");
}
?>