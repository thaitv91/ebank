<?php
include("../function/functions.php");	
ini_set("display_errors","on");

if(isset($_POST['Release']))
{
	$user_id = $_POST['usr_id'];
	mysql_query("UPDATE users SET TYPE = 'B' WHERE id_user = '$user_id'");
	print "User Release Successfully";
}

elseif(isset($_POST['per_blok']))
{
	$user_id = $_POST['usr_id'];
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
	
	//sponser_deduct($user_id);
	//print "User Permanently Block";
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php?page=semi_block\"";
	echo "</script>";
}

else
{	
	$semi_query = mysql_query("select * from users where type = 'X'");
	$semi_cnt = mysql_num_rows($semi_query);
	
	if($semi_cnt > 0)
	{	?>
		<table class="table table-bordered">
			<thead>
			<tr>
				<th class="text-center">Sr No.</th>
				<th class="text-center">Username</th>
				<th class="text-center">Phone</th>
				<th class="text-center">Email</th>
				<th class="text-center">Sponsor</th>
				<th class="text-center" colspan="2">Action</th>
			</tr>
			</thead>
		<?php
		$no = 1;
		while($row = mysql_fetch_array($semi_query))
		{ ?>
			<form method=post>
			<input type="hidden" name="usr_id" value="<?=$id_user = $row['id_user']?>" />
			<tr>
				<td class="text-center"><?=$no;?></td>
				<td class="text-center"><?=$username = $row['username'];?></td>
				<td class="text-center"><?=$phone = $row['phone_no'];?></td>
				<td class="text-center"><?=$email = $row['email'];?></td>
				<td class="text-center"><?=$sponsor = get_user_name($row['real_parent']);?></td>
				<td class="text-center">
					<input type="submit" name="Release" value="Release" class="btn btn-info" />
				</td>
				<td class="text-center">
				   <input type="submit" name="per_blok" value="Permanent Block" class="btn btn-info"/>
				</td>
			</tr>
			</form>
		<?php
			$no++;	  
		}
		echo "</table>";
	}
	
	else
	{
		print "<B style=\"color:#FF0000;\">There Are No Users</B>";
	}	
}



?>