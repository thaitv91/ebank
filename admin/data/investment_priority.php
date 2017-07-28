<?php
include("condition.php");
include("../function/setting.php");
include("../function/functions.php");
include("../function/send_mail.php");
include("../function/wallet_message.php");
include("../function/direct_income.php");
include("../function/check_income_condition.php");
include("../function/pair_point_calculation.php");

$newp = $_GET['p'];
$plimit = "30";

$income_hold_days = 7;
$curr_date = $systems_date;
$link_date = $systems_date;//date('Y-m-d', strtotime("$systems_date  +$income_hold_days day "));

if(isset($_POST['set_priority']))
{ 
	$upd_qur = "";
	$tatl_priority_cnt = $_POST['tatl_priority_cnt'];
	for($pcs = 1; $pcs <= $tatl_priority_cnt; $pcs++)
	{
		$priority_set = $_POST['priority_set_'.$pcs];
		$tabl_id = $_POST['tabl_priority_set_'.$pcs];
		$upd_qur .= "WHEN $tabl_id THEN '$priority_set' ";
		if($pcs < $tatl_priority_cnt)
			$upd_id .= " $tabl_id , ";
		else
			$upd_id .= " $tabl_id ";		
	}

	mysql_query("UPDATE income
					SET priority = CASE id
						$upd_qur
					END
				WHERE id IN ($upd_id) ");
	
	//mysql_query("update income set priority = '$priority_set' where id = '$tabl_id' ");*/
		
	$priority_username_log = $_POST['username_priority_set_'.$pcs];
	include("../function/logs_messages.php");
	data_logs($income_payee_id,$data_log[19][0],$data_log[19][1],$log_type[5]);	

}


$qqq1 = mysql_query("select * from income where mode = 1 and date <= '$link_date' and (total_amount-paid_amount) > 0  order by priority , date , id ");
$totalrows = mysql_num_rows($qqq1);
if($totalrows > 0)			
{ ?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th class="text-center">User id</th>
			<th class="text-center">Name</th>
			<th class="text-center">Total Income</th>
			<th class="text-center">Paid Income</th>
			<th class="text-center">Paid Limit</th>
			<th class="text-center">Left Paid</th>
			<th class="text-center">Income Date</th>
			<th class="text-center">Income Priority</th>
		</tr>
	</thead>
			
<?php

	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; } 
	
	$qqq = mysql_query("select * from income where mode = 1 and date <= '$link_date' and (total_amount-paid_amount) > 0 order by priority , date , id LIMIT $start,$plimit ");
	$num = mysql_num_rows($qqq);
	
	$psc = 1;	
?>	
	<form action="" method="post">
	<input type="hidden" name="tatl_priority_cnt"  value="<?=$num;?>" /> 			
<?php			
	while($rrr = mysql_fetch_array($qqq))
	{
		$total_inv_amount = $rrr['total_amount'];
		$total_inv_amount_usd = round($total_inv_amount/$usd_value_current,2);
		$prev_paid_amount = $rrr['paid_amount']; 
		$prev_paid_amount_usd = round($prev_paid_amount/$usd_value_current,2);	 
		$total_timit = $rrr['paid_limit'];
		$total_limit_usd = round($total_timit/$usd_value_current,2);
		
		$total_limit_paid = $rrr['per_day_paid'];
		$total_limit_paid_usd = round($total_limit_paid/$usd_value_current,2);
		$income_id = $rrr['id'];
		$date = $rrr['date'];
		$pay_user_id = get_user_name($rrr['user_id']);
		$pay_user_name = get_full_name($rrr['user_id']);
		$priority = $rrr['priority'];
	?>
		<tr>
			<td class="text-center"><?=$pay_user_id;?></td>
			<td class="text-center"><?=$pay_user_name;?></td>
			<td class="text-center"><?=$total_inv_amount;?> <font color=dark>$ </font></td>
			<td class="text-center"><?=$prev_paid_amount;?> <font color=dark>$ </font></td>
			<td class="text-center"><?=$total_timit;?> <font color=dark>$ </font></td>
			<td class="text-center"><?=$total_limit_paid;?> <font color=dark>$ </font></td>
			<td class="text-center"><?=$date;?></td>
			<td class="text-center">
				<input type="text" name="priority_set_<?=$psc;?>" value="<?=$priority;?>" style="width:50px;" /> 
				<input type="hidden" name="tabl_priority_set_<?=$psc;?>" value="<?=$income_id;?>" />
				<input type="hidden" name="username_priority_set_<?=$psc;?>" value="<?=$pay_user_id;?>" /> 
			</td>
		</tr>
<?php	
		$psc++;	
	} ?>
	
	<tr class="text-right">
		<td colspan=8>
			<input type="submit" name="set_priority" value="Set Priority" class="btn btn-info" />
		</td>
	</tr>
	</form>	
	</table>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=investment_priority&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=investment_priority&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=investment_priority&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
		</ul></div>
<?php			
}
?>	