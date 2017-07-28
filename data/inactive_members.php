<?php
session_start();
require_once("config.php");
include("condition.php");
require_once("function/functions.php");
include("function/setting.php");

$newp = $_GET['p'];
$plimit = "15";

$id = $_SESSION['ebank_user_id'];

if(isset($_POST['Submit']))
{
	$member_id = $_POST['showing_user_id'];
	$request_amount = $_POST['request'];
	$query = mysql_query("SELECT * FROM users WHERE id_user = '$member_id' ");
	while($row = mysql_fetch_array($query))
	{
		$type = $row['type'];
		if($type == 'A')
		{
			mysql_query("update users set type = 'B' where id_user = '$member_id' ");
			mysql_query("update user_manager set type = 'B' where manager_id = '$member_id' ");
			
			//$income_time = date('H:i:s');
			//mysql_query("insert into investment_request (user_id , amount , date , time , mode , rec_mode , priority ) values ('$member_id' , '$request_amount' , '$systems_date' , '$income_time' , 1 , 1 , 1) ");
							
			$acc_username_log = get_user_name($member_id);
			$income_log = $request_amount;
			$date = $systems_date;
			$wallet_amount_log = $curr_amnt;
			$total_wallet_amount = $left_wallet_amount;
			include("function/logs_messages.php");
			data_logs($member_id,$data_log[16][0],$data_log[16][1],$log_type[4]);
			
			echo "<B style=\"color:#008000;\"><center>$successfully</center></B>";
		}	
	}		 
}

/*$type_user = mysql_query("select type from user_manager where manager_id = '$id' ");
$rowsa = mysql_fetch_array($type_user);
$member_type = $rowsa['type'];

if($member_type == 'M')
{*/
	$sql = "SELECT t2.* FROM user_manager as t1 inner join users as t2 on t1.manager_id = t2.id_user and  t1.type = 'A' where t1.active_by = '$id' ";
	$query = mysql_query($sql);
	$totalrows = mysql_num_rows($query);
	if($totalrows == 0)
	{
		echo "<B style=\"color:#FF0000;\">$there_are</B>"; 
	}
	else 
	{
	/*print "
		<div style=\"color:#990000; padding:10px 0px 10px 10px;text-decoration: blink\" align=\"left\">";
			$inv_count = first_invest_count($id);
			if($inv_count == 0){  "<blink>Note : Accept Button will be appeared once your commitment confirmed..</blink>";
			
			}
			else{}*/
	?>	
	<table id="example2" class="table table-bordered table-hover">
		<tr>
			<th><?=$sr_no;?></th>
			<th><?=$User_Name;?></th>
			<th><?=$Name;?></th>
			<th><?=$e_mail;?></th>
			<th><?=$mob_no;?></th>
			<th class="text-center"><?=$Action;?></th>
		</tr> 
	<?php	
		$pnums = ceil ($totalrows/$plimit);
		if ($newp==''){ $newp='1'; }
			
		$start = ($newp-1) * $plimit;
		$starting_no = $start + 1;
		
		if ($totalrows - $start < $plimit) { $end_count = $totalrows;
		} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
			
			
		
		if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
		} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }
		
		$sr_no = $start+1;
		$sql = "$sql LIMIT $start,$plimit ";
		$query = mysql_query($sql);
		while($row = mysql_fetch_array($query))
		{
			$child_id = $row['id_user'];
			$real_parent = $row['real_parent'];
			$username = $row['username'];
			$name= $row['f_name']." ".$row['l_name'];
			$date = $row['date'];
			$email = $row['email'];
			$phone_no = $row['phone_no'];
			$request_amount = $row['provience'];
			?>
			<tr>
			<form action="index.php?page=inactive_members" method="post">
				<input type="hidden" name="showing_user_id" value="<?=$child_id; ?>"  />
				<td><?=$sr_no;?></td>
				<td><?=$username;?></td>
				<td><?=$name;?></td>				
				<!--<td>
				<select name="request" >
				<?php
				for($i = $setting_inv_amount; $i <= $setting_inv_end_amount; $i = $i+$setting_inv_amount)
				{ ?>
					<option <?php if($request_amount == $i) { ?> selected="selected" <?php } ?> value="<?=$i; ?>">
						<?=round($i/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or ".$i;?> 
						<font color=dark>$ </font>
					</option>
		<?php	} ?>				
				</select>
				</td>-->
				<td><?=$email;?></th>
				<td><?=$phone_no;?></th>
				<td class="text-center">
					<input type="submit" name="Submit" value="Active" class="btn btn-info" />
				</td>
			</form>
			</tr>
	<?php	$sr_no++;	
		}?>
	</table>
	<div class="col-xs-6">
		<div class="dataTables_paginate paging_bootstrap">
			<ul class="pagination">
				<?php
				if ($newp>1)
				{ ?> 
					<li class="prev">
						<a href="<?="index.php?page=inactive_members&p=".($newp-1);?>">&larr; <?=$Previous;?></a>
					</li> <?php  
				}
				for ($i=1; $i<=$pnums; $i++) 
				{ 
					if ($i!=$newp)
					{ ?>
						<li>
						<a href="<?="index.php?page=inactive_members&p=$i";?>"><?php print_r("$i");?></a>
						</li>
						<?php 
					}
					else
					{ ?><li class="active"><a href="#"><?php print_r("$i"); ?></a></li> <?php }
				} 
				if ($newp<$pnums) 
				{ ?> 
					<li class="next">
					<a href="<?php echo "index.php?page=inactive_members&p=".($newp+1);?>"><?=$Next;?> &rarr;</a>
					</li> <?php  
				} ?>
			</ul>
		</div>
	</div>
	<?php
	}
/*}
else
{
	print "You Are Not A Manger. So You Can't Active Any Child !!";
}*/
function get_user_full_investment($id)
{
	$q = mysql_query("select sum(amount) from investment_request where user_id = '$id' ");
	while($row = mysql_fetch_array($q))
	{
		$total_invst = $row[0];
	}
	if($total_invst == '')
		$total_invst = 0;
	return $total_invst;		
}

?>
