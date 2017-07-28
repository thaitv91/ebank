<?php
include("../function/functions.php");
	
if(isset($_POST['edit']))
{
	$id_table = $_POST['id_table'];
	$de_query = mysql_query("select * from daily_interest where id = '$id_table' ");
	?>
	<form method="post" action="index.php?page=dailly_amount_diff">
		<table class="table table-bordered">
			<thead>
			<tr>
				<th>Amount</th>
				<th>Date</th>
				<th>Start Date</th>
				<th>End Date</th>
			</tr>
			</thead>
			<?php		
			while($rows = mysql_fetch_array($de_query))
			{
				$id = $rows['id'];
				$amount = $rows['amount'];
				$date = $rows['date'];
				$start_date = $rows['start_date'];
				$end_date = $rows['end_date'];
			?>	
				<tr>
					<td><input type="text" name="amount" value="<?=$amount;?>" /></td>
					<td>
						<div class="form-group" id="data_1" style="margin:0px">
							<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="date" value="<?=$date;?>">
							</div>
						</div>
					</td>
					<td>
						<div class="form-group" id="data_1" style="margin:0px">
							<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="str_dte" value="<?=$start_date;?>">
							</div>
						</div>
					</td>
					<td>
						<div class="form-group" id="data_1" style="margin:0px">
							<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="end_dte" value="<?=$end_date;?>">
							</div>
						</div>
						<input type="hidden" name="id" value="<?=$id;?>">
					</td>
				</tr>
			<?php
			} ?>
			<tr>
			 <td colspan="4" class="text-right">
				<input class="btn btn-info" type="submit" name="update" value="Updat"></th>
			</tr>
		</table>
	</form>
<?php
}
elseif(isset($_POST['update']))
{
	$ch_id = $_POST['id'];
 	$amount = $_POST['amount'];
	$date = $_POST['date'];
	$str_dte = $_POST['str_dte'];
	$end_dte = $_POST['end_dte'];
	
	$date = date('Y-m-d', strtotime($date));
	$str_dte = date('Y-m-d', strtotime($str_dte));
	$end_dte = date('Y-m-d', strtotime($end_dte));
	
	mysql_query("UPDATE daily_interest SET amount = '$amount', date = '$date', start_date = '$str_dte', end_date = '$end_dte' where id = '$ch_id'");
	
	print "Update Successfully !";
}
else
{	
	$query = "select tbl1.*, tbl2.* from 
				(	select * from
					(
					select t1.user_id,t1.amount as amount_inv
					,t1.mode,t1.rec_mode
					FROM investment_request AS t1
					where t1.mode = 0 and t1.rec_mode = 1
					GROUP BY t1.user_id
					) as tb1
				) tbl1 
			inner join 
				(	select * from
					(
					select t2.id,t2.date,t2.member_id,t2.amount as amount_daily
					FROM daily_interest AS t2
					GROUP BY t2.member_id
					) as tb2	
				) tbl2
				on tbl1.amount_inv != tbl2.amount_daily and tbl1.user_id = tbl2.member_id 
				and tbl1.mode = 0 and tbl1.rec_mode = 1 ";
			
	$sql_query = mysql_query($query);
	$num = mysql_num_rows($sql_query);
	if($num > 0)
	{ ?>
	<table class="table table-bordered">
		<thead>
		<tr>
			<th>Sr.</th>
			<th>Username</th>
			<th>Date</th>
			<th>Commit Amount</th>
			<th>Bonus Amount</th>
			<th>Status</th>
		</tr>
		</thead>
	<?php	
	$sr = 1;		
	while($row = mysql_fetch_array($sql_query))
	{
	  print "<form method=\"post\" action=\"index.php?page=dailly_amount_diff\">
	  		<tr>  
			<td>$sr</td>
			<td>".$id = get_user_name($user_id = $row['user_id'])."</td>
			<td>".$date = $row['date']."</td>
			<td>".$amount_inv = $row['amount_inv']."</td>
			<td>".$amount_daily = $row['amount_daily']."</td>
			<td><input type=\"hidden\" name=\"id_table\" value=\"".$id = $row['id']."\">
				<input type=\"submit\" name=\"edit\" value=\"Edit\" class=\"normal-button\"></td>
			</tr>
			</form>"; 
	$sr++;
	} ?>
	</table>
<?php
	}
	else { echo "<B style=\"color:#ff0000;\">There are no information to show !</B>"; }
}	
?>
<script> 
$('#data_1 .input-group.date').datepicker({
	todayBtn: "linked",
	keyboardNavigation: false,
	forceParse: false,
	calendarWeeks: true,
	autoclose: true
});

$('#data_2 .input-group.date').datepicker({
	startView: 1,
	todayBtn: "linked",
	keyboardNavigation: false,
	forceParse: false,
	autoclose: true
});
</script>