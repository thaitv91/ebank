<?php
ini_set("display_errors" , "off");
session_start();
require_once("config.php");
//include("condition.php");
require_once("function/functions.php");

$newp = $_GET['p'];
$plimit = "15";
$id = $_SESSION['ebank_user_id'];

$spons_email = get_user_email($id);



$query = mysql_query("SELECT * FROM users WHERE real_parent = '$id' ");
$totalrows = mysql_num_rows($query);
if($totalrows == 0)
{
	echo "<B style=\"color:#FF0000; font-size:14px;\">$there_are</B>"; 
}
else 
{ ?>
<table id="example2" class="table table-bordered table-hover">
	<tr>
		<th colspan=3><?=$Referrals;?></th>
		<th colspan=5><?=$totalrows;?> <?=$Members;?></th>
	</tr>
	<tr>
		<th><?=$sr_no;?></th>				<th><?=$Joining_Date;?></th>
		<th><?=$Participate_ID;?></th>		<th><?=$Participate_Name;?></th>
		<th><?=$Reffer_ID;?></th>			<th><?=$Commitment;?></th>
		<th><?=$Status;?></th>				<th><?=$Role;?></th>
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
	$query = mysql_query("SELECT * FROM users WHERE real_parent = '$id' LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		$child_id = $row['id_user'];
		$username = $row['username'];
		$name= $row['f_name']." ".$row['l_name'];
		$date = $row['date'];
		$email = $row['email'];
		$phone_no = $row['phone_no'];
		$id_user = $row['id_user'];
		
		$role = get_user_role($child_id);
		
		$date = date('d/m/Y' , strtotime($date));
		
		$manager = active_by_real_p($child_id);
		$manager_name = ucfirst(get_full_name($manager));
		
		$status = get_user_type($id_user);
		$position = get_user_pos($id_user);
		
		$tot_invstmnt = get_user_approved_investment($child_id);
		$tot_invstmnt_usd = round($tot_invstmnt/$usd_value_current,2);
		
		$tot_invstmnt_inc = get_user_investment_income($child_id);
		$tot_invstmnt_inc_usd = round($tot_invstmnt_inc/$usd_value_current,2);

		$tot_comming_invstmnt = get_user_comming_investment($child_id);
		$tot_comming_invstmnt_usd = round($tot_comming_invstmnt/$usd_value_current,2);

		$tot_pending_invstmnt = get_user_pending_investment($child_id);
		$tot_pending_invstmnt_usd = round($tot_pending_invstmnt/$usd_value_current,2);

		$full_investment = get_user_full_investment($child_id);
		$full_investment_usd = round($full_investment/$usd_value_current,2);
		
		 ?>
		 <tr>
		 	<td align="center"><?=$sr_no;?></td>
			<!--<td style="padding:10px;">
				<form action="index.php?page=member_information" method="post">
				<input type="hidden" name="showing_user_id" value="<?=$child_id; ?>"  />
				<input type="submit" name="Submit" style="width:120px; background:none; border:none; text-align:left; text-decoration:underline;" value="<?=$username; ?>" />
				</form>
 			</td>
			<td><?=$level;?></td>-->
			<td><?=$date;?></td>
			<td><?=$email;?></td>
			<td><?=$name;?></td>
			<td><?=$spons_email;?></td>
			<td>
				<!--$<?=$full_investment_usd;?> <font color=DodgerBlue>USD</font> Or-->  
				<?=$full_investment;?>.00 <font color=dark>$ </font>
			</td>
			<td><?=$status;?></td>
			<td><?=$role;?></td>
			<!--<td>
				$<?=$tot_invstmnt_usd;?> <font color=DodgerBlue>USD</font> Or  
				<?=$tot_invstmnt;?> <font color=dark>$ </font>
			</td>
			<td>
				$<?=$tot_invstmnt_inc_usd;?> <font color=DodgerBlue>USD</font> Or  
				<?=$tot_invstmnt_inc;?> <font color=dark>$ </font>
			</td>
			<td>
				$<?=$tot_comming_invstmnt_usd;?> <font color=DodgerBlue>USD</font> Or  
				<?=$tot_comming_invstmnt;?> <font color=dark>$ </font>
			</td>
			<td>
				$<?=$tot_pending_invstmnt_usd;?> <font color=DodgerBlue>USD</font> Or  
				<?=$tot_pending_invstmnt;?> <font color=dark>$ </font>
			</td>-->
		</tr>
<?php
		$sr_no++;
	}?>
	</table>
	<div class="col-xs-6">
		<div class="dataTables_paginate paging_bootstrap">
			<ul class="pagination">
				<?php
				if ($newp>1)
				{ ?> 
					<li class="prev">
						<a href="<?="index.php?page=participants&p=".($newp-1);?>">&larr; <?=Previous?></a>
					</li> <?php  
				}
				for ($i=1; $i<=$pnums; $i++) 
				{ 
					if ($i!=$newp)
					{ ?>
						<li>
						<a href="<?="index.php?page=participants&p=$i";?>"><?php print_r("$i");?></a>
						</li>
						<?php 
					}
					else
					{ ?><li class="active"><a href="#"><?php print_r("$i"); ?></a></li> <?php }
				} 
				if ($newp<$pnums) 
				{ ?> 
					<li class="next">
					<a href="<?php echo "index.php?page=participants&p=".($newp+1);?>"><?=Next;?> &rarr;</a>
					</li> <?php  
				} ?>
			</ul>
		</div>
	</div>
	<?php
}

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