<?php
ini_set("display_errors",'off');
include("../config.php");

	
	$i = 1;
	$sql = "select user_id,sum(`income`) inc from user_income where type=2 group by user_id";
	$query1 = mysql_query($sql);
	while($rr = mysql_fetch_array($query1))
	{
		$user_id = $rr['user_id'];
		$inc = $rr['inc'];
		$sql = "select * from wallet where id='$user_id'";
		$query = mysql_query($sql);
		
		while($rr1 = mysql_fetch_array($query))
		{
			$amt = $rr1['amount'];
		}
		$inc = $amt - $inc;$i++;
		if($inc > 0)
		{
			
			$qu = "update wallet set amount= '$inc' where id='$user_id'";
		}
		else
		{
			$qu = "update wallet set amount='0' where id='$user_id'";
		}
		print "<br>$i****".$qu;
		mysql_query($qu);
	}
?>