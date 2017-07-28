<?php



include("condition.php");

include("../function/functions.php");



$newp = $_GET['p'];

$plimit = "15";

$search = '';

if(isset($_REQUEST['search']))

{

	$date1 = date("Y-m-d",strtotime($_REQUEST['date1']));

	$date2 = date("Y-m-d",strtotime($_REQUEST['date2']));

	$search = " where date between '$date1' and '$date2'";

	if(isset($_REQUEST['status'])){

		$status1 = "AND mode = ".$_REQUEST['status']."";

	}



}

$sql = "SELECT  user_id, paying_id,mode,payment_receipt,

			 CASE 

				 WHEN mode = 0 THEN '<span style=color:#FF0000;>Request processed</span>'

				 WHEN mode = 1 THEN '<span style=color:#F09D47;>Request Pending</span>'

				 WHEN mode = 2 THEN '<span style=color:#008000;>Request Approve</span>'

				 WHEN mode = 10 THEN '<span style=color:#008000;>Request Approve By Admin</span>'

			 END as status

			,amount, date

			FROM income_transfer

			$search $status1 ";





$query = mysql_query($sql); 

$totalrows = mysql_num_rows($query);

?>

	<div style="width:100%;margin:0px 0 15px">

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

				<span class="input-group-addon">Status</span>

				<select class="form-control" name="status">

					<option value="0" <?php if($_REQUEST['status'] == '0'){echo 'selected= "selected"';}?>>Request processed</option>

					<option value="1" <?php if($_REQUEST['status'] == '1'){echo 'selected= "selected"';}?>>Request Pending</option>

					<option value="2" <?php if($_REQUEST['status'] == '2'){echo 'selected= "selected"';}?>>Request Approve</option>

					<option value="10" <?php if($_REQUEST['status'] == '10'){echo 'selected= "selected"';}?>>Request Approve By Admin</option>

				</select>

			</div>

		</div>

		<input type="hidden" name="page" value="gd_reports"/>

		<div style="float:left;"><input type="submit" name="search" class="btn btn-info" value="Search" /></div>

		<div class="clear-fix" style="clear:both"></div>

		</form>

	</div>

	<div style="clear:both"></div>
<div>
    <?php
    $status_1 = mysql_num_rows(mysql_query("SELECT * FROM income_transfer where mode=0"));
    $status_2 = mysql_num_rows(mysql_query("SELECT * FROM income_transfer where mode=1"));
    $status_3 = mysql_num_rows(mysql_query("SELECT * FROM income_transfer where mode=2"));
    $status_4 = mysql_num_rows(mysql_query("SELECT * FROM income_transfer where mode=10"));
    ?>
    <p>Request processed: <?= $status_1 ?></p>
    <p>Request Pending: <?= $status_2 ?></p>
    <p>Request Approve: <?=$status_3?></p>
    <p>Request Approve By Admin: <?=$status_4?></p>
</div>
	<table class="table table-bordered">  

		<thead>

		<tr>

			<th>Sr No</th>

			<th>Receiver</th>

			<th>Giver</th>

			<th>Status</th>

			<th>Amount</th>

			<th>Receipt</th>

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

		

		

	

	if ($totalrows - $end_count > $plimit) { $var2 = $plimit; } 

	elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; } 

	

	$sql = $sql." LIMIT $start,$plimit ";

	$query = mysql_query($sql); 

	$srno = $plimit*($newp-1);

	while($row = mysql_fetch_array($query))

	{  

		$srno++;

		$paying_id = $row['paying_id'];

		$user_id = $row['user_id'];

		$mode = $row['mode'];

		$status = $row['status'];

		$amount = $row['amount'];

		$Receipt = $row['payment_receipt'];

		$date = $row['date'];

		$date = date('d/m/Y' , strtotime($date));

		

		$rp = '';

		if($mode != 0 and $mode != 10)

		{

			$rp = "<a href=\"payment_receipt.php?rp=$Receipt&m=1\" target=\"_blank\">Click View</a>";

		}

		else{

			$rp = "&nbsp;";

		}

		?>

		<tr> 

			<td><?=$srno;?></td>

			<td><?=$user_name = get_user_name($user_id);?></td>

			<td><?=$giver_name = get_user_name($paying_id);?></td>

			<td><?=$status;?> </td>

			<td><?=$amount;?> <font color=dark>$ </font></td>

			<td><?=$rp;?></td>

			<td><?=$date;?></td>

	 	</tr>

	<?php	

	$amount1 = $amount1+$row['amount'];

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

