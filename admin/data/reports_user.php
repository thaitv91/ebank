<?php
include("condition.php");
include("../function/functions.php");

$url_local = 'https://' . $_SERVER['HTTP_HOST'];

$newp = $_GET['p'];
$plimit = "20";
$sql = "SELECT * FROM report";
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);

//get tb_time_report
$sql_time_block = mysql_query("SELECT * FROM tb_time_block");
$row_time_report = mysql_fetch_array($sql_time_block);

$time_block = $row_time_report['time_block'];
$time_frozen = $row_time_report['time_frozen'];
$frozen_downline = $row_time_report['frozen_downline'];
$time_report = $row_time_report['time_report'];

$todate = date('Y-m-d H:i:s');
?>



<script type="text/javascript" src="js/provide_donation.js"></script>
<script type="text/javascript" src="js/remaining.js"></script>

	<table class="table table-bordered">
		<thead>
		<tr>
			<th class="text-center">SR NO.</th>
			<th class="text-center">User Name</th>
			<th class="text-center">Date</th>
			<th class="text-center">Amount</th>
			<th class="text-center">Btc Address</th>
			<th class="text-center">File</th>
			<th></th>
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
	
	$sr_no = $plimit*($newp-1);
	
	$query = mysql_query("$sql LIMIT $start,$plimit ");
	while($row = mysql_fetch_array($query))
	{
		$sr_no++;
		$id = $row['user_id'];
		$giver_id = $row['income_transfr_id'];
		$date = $row['date'];
		$date_fr = $row['frozen_date'];
		$date_bl = $row['block_date'];
		$report = $row['report'];
		$mode = $row['mode'];
		$amount_usd = $row['usd'];
		$amount_bit = $row['bitcoin'];
		$file = $row['file'];
		$btc_address = $row['btc_address'];
		$username = get_user_name($id);
		$reported = get_user_name($row['reported']);
		//$rel_time = (strtotime($date) + $time_block*3600) - time();
		
		if(!empty($file)){
			$img_confirm = '<a href="javascript:void(0)" class="modal-img" data-img="'.$file.'"><img width="30" src="/images/block_pay_receipt/'.$file.'"></a>';
		}else{
			$img_confirm = '';
		}

		if($mode == 1){
			$date_rp = $date;
			$rel_time = (strtotime($date) + $time_block*3600) - time();
		}
		if($mode == 2){
			$date_rp = $date_fr;
			$rel_time = (strtotime($date_fr) + $time_frozen*3600) - time();
		}
		if($mode == 3){
			$date_rp = $date_bl;
		}


		if($mode == 3){
			$group_button_action = '<span class="approve_remaining_time text-red">Account being blocked</span>
				<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample'.$row['reported'].'" aria-expanded="false" aria-controls="collapseExample">Detail</button>
				<button data-id="'.$row['reported'].'" type="button" class="unblock_user btn btn-danger">Unblock</button>';
		}
		if($mode == 2){
			$group_button_action = '<span id="_remain_sec_MD006521'.$row['id'].'" mode="2" rel="'.$rel_time.'" data_id="'.$row['reported'].'" data_time="'.$row['date'].'" class="approve_remaining_time text-blue"></span>
				<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample'.$row['reported'].'" aria-expanded="false" aria-controls="collapseExample">Detail</button>
				<a type="button" data-id="'.$row['reported'].'" class="remove_frozen btn btn-primary">Remove Frozen </a>
				<button type="button" data-id="'.$row['reported'].'" data_time="'.$todate.'" mode="2" class="block_user btn btn-danger">Block</button>';
		}
		if($mode == 1){
			$group_button_action = '<span id="_remain_sec_MD006521'.$row['id'].'" mode="1" rel="'.$rel_time.'" data_id="'.$row['reported'].'" data_time="'.$row['date'].'" class="approve_remaining_time text-green"></span>
				<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#collapseExample'.$row['reported'].'" aria-expanded="false" aria-controls="collapseExample">Detail</button>
				<a type="button" data-id="'.$row['reported'].'" class="remove_report btn btn-info">Remove Report </a>
				<button type="button" data-id="'.$row['reported'].'" data_time="'.$todate.'" mode="1" class="block_user btn btn-danger">Block</button>';
		}
		
		echo '<tr>
			<td rowspan="2" class="text-center">'.$sr_no.'</td>
			<td class="text-center">'.$reported.'</td>
			<td class="text-center">'.$date_rp.'</td>
			<td class="text-center">'.$amount_usd.' USD / '.$amount_bit.' BIT</td>
			<td class="text-center">'.$btc_address.'</td>
			<td class="text-center">'.$img_confirm.'</td>
			<td align="right" id="button_action'.$row['reported'].'">'.$group_button_action.'</td>
		</tr>
		<tr><td colspan="6" style="padding:0;border:none;">
		<div class="collapse" id="collapseExample'.$row['reported'].'">
		  	<div style="padding:10px;">
		  		<table class="table table-bordered" style="margin:0;">
		  		<tbody> 
		  			<tr><th scope="row">Being Reported by</th><td>'.$username.'</td></tr>
		  			<tr><th scope="row">Income transfer id</th><td>MD006521'.$giver_id.'</td></tr>
		  			<tr><th scope="row">Resion</th><td>'.$report.'</td></tr>
		  		</tbody> 
		  		</table>
		  	</div>
		</div></td></tr>';
			
	}
	echo "</table>";
	?>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=reports_user&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=reports_user&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=reports_user&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
		</ul></div>

<script type="text/javascript">
	$('.remove_report').click(function(){
		var id = $(this).attr('data-id');
		$.ajax({
            url : "/ajax_call/remove_report.php",
            type : "post",
            dateType:"html",
            data : 'id='+id+'&mode=1',
            success : function (result){
            	if(result){
            		location.reload(); 
            	}
                //$('#button_action'+id_user).html(result);
            }
        });
	})
</script>

<script type="text/javascript">
	$('.remove_frozen').click(function(){
		var id = $(this).attr('data-id');
		$.ajax({
            url : "/ajax_call/remove_frozen.php",
            type : "post",
            dateType:"html",
            data : 'id='+id+'&mode=2',
            success : function (result){
            	if(result){
            		location.reload(); 
            	}
                //$('#button_action'+id_user).html(result);
            }
        });
	})
</script>



<script type="text/javascript">
	$('.block_user').click(function(){
		var result = confirm("Want to block?");
		if (result) {
			var id = $(this).attr('data-id');
			var time = $(this).attr('data_time');
			var mode = $(this).attr('mode');
			$.ajax({
	            url : "/ajax_call/block.php",
	            type : "post",
	            dateType:"html",
	            data : 'id='+id+'&mode='+mode+'&time='+time,
	            success : function (result){
	            	$('#button_action'+id).html(result);
	            }
	        });
	    }    
	})
</script>

<script type="text/javascript">
	$('.unblock_user').click(function(){
		var result = confirm("Want to unblock?");
		if (result) {
			var id = $(this).attr('data-id');
			$.ajax({
	            url : "/ajax_call/unblock.php",
	            type : "post",
	            dateType:"html",
	            data : 'id='+id,
	            success : function (result){
	            	if(result){
	            		location.reload(); 
	            	}
	            }
	        });
	    }    
	})
</script>

<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-epin">
                    <p><img id="viewImg" style="width:100%" src=""></p>
                    <p>  <a class="btn btn-info" href="javascript:void(0)" data-dismiss="modal" aria-label="Close">Close</a></p>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    $(document).on('click', '.modal-img', function (event) {
        event.preventDefault();
        var img = $(this).attr('data-img');
        var link = "/images/block_pay_receipt/" + img;
        $('#viewImg').attr('src', link);
        $('#myModal').modal('show');

    });
</script>

