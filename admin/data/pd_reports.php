<?php

include("condition.php");

include("../function/functions.php");



$newp = $_GET['p'];

$plimit = "15";

 /*$sql = "SELECT  t1.user_id, t1.mode, t2.paying_id,t2.payment_receipt,t2.mode,

			 CASE 

				 WHEN t1.mode = 1 and t2.mode = 0 THEN 'Request Pending'

				 WHEN t1.mode = 0 and t2.mode = 1 THEN 'Request in Process'

				 WHEN t1.mode = 0 and t2.mode = 2 THEN 'Request Approve'

			 END as status ,t1.amount, t1.date FROM investment_request t1 

			LEFT JOIN income_transfer t2 on t1.id = t2.investment_id";*/

$search = '';

if(isset($_REQUEST['search']))

{

	$date1 = date("Y-m-d",strtotime($_REQUEST['date1']));

	$date2 = date("Y-m-d",strtotime($_REQUEST['date2']));

	$search = " where t1.date between '$date1' and '$date2'";

	$sel_status = explode(",",$_REQUEST['status']);

	if(isset($sel_status[0])){

		$status1 = "AND t1.mode = ".$sel_status[0]."";

	}

	if(isset($sel_status[1])){

		$status2 = "AND t2.mode = ".$sel_status[1]."";

	} 

}

$sql = "SELECT t1.* ,t1.mode as inv_mode, t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id $search $status1 $status2";		

$query = mysql_query($sql); 

$totalrows = mysql_num_rows($query);

?>

	<div style="width:100%; margin:0px 0 15px">

		<form action="" method="get">

		<div class="form-group" id="data_1" style="margin:0px 15px 0 0; float:left;">

			<div class="input-group date">

				

				<span class="input-group-addon">From Date <i class="fa fa-calendar"></i></span>

				<input class="form-control" type="text" name="date1" value="<?=$_REQUEST['date1'];?>" required/>



			</div>

		</div>

		<div class="form-group" id="data_2" style="margin:0px 15px 0 0; float:left;">

			<div class="input-group date">

				<span class="input-group-addon">To Date <i class="fa fa-calendar"></i></span>

				<input class="form-control" type="text" name="date2" value="<?=$_REQUEST['date2'];?>" required/>

			</div>

		</div>

		<div class="form-group" id="status" style="margin:0px 15px 0 0; float:left;">

			<div class="input-group date">

				<span class="input-group-addon">Status </span>

				<select class="form-control" name="status">

					<option value="1" <?php if($_REQUEST['status'] == '1'){echo 'selected= "selected"';}?>>Request processed</option>

					<option value="0,0" <?php if($_REQUEST['status'] == '0,0'){echo 'selected= "selected"';}?>>Request in Processing</option>

					<option value="0,1" <?php if($_REQUEST['status'] == '0,1'){echo 'selected= "selected"';}?>>Request Pending</option>

					<option value="0,2" <?php if($_REQUEST['status'] == '0,2'){echo 'selected= "selected"';}?>>Request Confirmed</option>

				</select>

			</div>

		</div>

		<input type="hidden" name="page" value="pd_reports"/>

		<div style="float:left;"><input type="submit" name="search" class="btn btn-info" value="Search" /></div>

		<div class="clear-fix" style="clear:both"></div>

		</form>

	</div>

	<div style="clear:both"></div>
<div>
    <?php
    $status_1 = mysql_num_rows(mysql_query("SELECT t1.* ,t1.mode as inv_mode, t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id  where t1.mode=1"));
    $status_2 = mysql_num_rows(mysql_query("SELECT t1.* ,t1.mode as inv_mode, t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id  where t1.mode=0 and t2.mode=0"));
    $status_3 = mysql_num_rows(mysql_query("SELECT t1.* ,t1.mode as inv_mode, t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id  where t1.mode=0 and t2.mode=1"));
    $status_4 = mysql_num_rows(mysql_query("SELECT t1.* ,t1.mode as inv_mode, t2.mode as int_mode FROM investment_request t1 left join income_transfer t2 on t1.id = t2.investment_id  where t1.mode=0 and t2.mode=2"));
    ?>
    <p>Request processed: <?= $status_1 ?></p>
    <p>Request in Processing: <?= $status_2 ?></p>
    <p>Request Pending: <?= $status_3 ?></p>
    <p>Request Confirmed: <?= $status_4 ?></p>
</div>
	<table class="table table-bordered">  

		<thead>

		<tr>

			<th>Sr No</th>

			<th>User ID</th>

			<th>Amount</th>

			<th>Status</th>

			<th>Date</th>

		</tr>

		</thead>

	<?php

	if($totalrows != 0)

	{ 

	$pnums = ceil ($totalrows/$plimit);

	if ($newp==''){ $newp='1'; }

		

	$start = ($newp-1) * $plimit;

	$starting_no = $start + 1;

	

	if ($totalrows - $start < $plimit) { $end_count = $totalrows;

	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }

		

		

	

	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;

	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; } 

	$sql = $sql." LIMIT $start,$plimit ";

	$query = mysql_query($sql); 

	$srno = $plimit*($newp-1);

	while($row = mysql_fetch_array($query))

	{  

		$srno++;

		$user_id = $row['user_id'];

		$inv_mode = $row['inv_mode'];

		$int_mode = $row['int_mode'];

		$amount = $row['amount'];

		$date = $row['date'];

		$date = date('d/m/Y' , strtotime($date));

		$user_name = get_user_name($user_id);

		

		if($inv_mode == 1)

		{ 

			$status = "<span style=color:#FF0000>Request processed</span>"; 

		}

		if($inv_mode == 0 and $int_mode == 0)

		{ 

			$status = "<span style=color:#0028F1>Request in Processing</span>"; 

		}

		elseif($inv_mode == 0 and $int_mode == 1)

		{ 

			$status = "<span style=color:#F39C12>Request Pending</span>"; 

		}

		elseif($inv_mode == 0 and $int_mode == 2)

		{ 

			$status = "<span style=color:#008000>Request Confirmed</span>"; 

		}

		?>

		<tr> 

			<td><?=$srno;?></td>

			<td><?=$user_name;?></td>

			<td><?=$amount;?> <font color=dark>$ </font></td>

			<td><?=$status;?> </td>

			<td><?=$date;?></td>

	 	</tr>

	<?php	

	} 

}

else { echo "<tr><td col-span='5'><B style=\"color:#ff0000;\">No Information Found !</B></td></tr>"; }

  ?>

	</table>

	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">

	<ul class="pagination">

	<?php

	if ($newp>1)

	{ ?>

		<li id="DataTables_Table_0_previous" class="paginate_button previous">

			<a href="<?=$_SERVER['REQUEST_URI']."&p=".($newp-1);?>">Previous</a>

		</li>

	<?php 

	}

	for ($i=1; $i<=$pnums; $i++) 

	{ 

		if ($i!=$newp)

		{ ?>

			<li class="paginate_button ">

				<a href="<?=$_SERVER['REQUEST_URI']."&p=$i";?>"><?php print_r("$i");?></a>

			</li>

			<?php 

		}

		else

		{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }

	} 

	if ($newp<$pnums) 

	{ ?>

	   <li id="DataTables_Table_0_next" class="paginate_button next">

			<a href="<?=$_SERVER['REQUEST_URI']."&p=".($newp+1);?>">Next</a>

	   </li>

	<?php 

	} 

	?>

	</ul></div>

	<script src="js/date.js"></script>

