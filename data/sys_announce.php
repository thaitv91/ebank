<?php
session_start();
$newp = $_GET['p'];
$plimit = "15";
$my_id=$_SESSION['ebank_user_id'];

if(isset($_REQUEST['id']))
{ ?>
	<a href="index.php?page=sys_announce&p=<?=$newp;?>" class="btn btn-danger">
		Back <i class="fa fa-reply"></i>
	</a><p>&nbsp;</p>
	<?php
	$table_id = $_REQUEST['id'];
	$qa = mysql_query("select * from news where id = '$table_id'");
	$num = mysql_num_rows($qa);
	if($num != 0 )
	{
		while($rowa=mysql_fetch_array($qa))
		{
			$title = $rowa['title'];
			$date = $rowa['date'];
			$news = $rowa['news'];
			$date = date('d/m/Y',strtotime($date));
		} ?>
		<div style="height:30px; text-align:left; padding-left:10px;"><b>Title : <?=$title; ?></b></div>
		<div style="height:30px; text-align:left; padding-left:10px;">Date : <?=$date; ?></div>
		<div style="height:auto; text-align:left; padding-left:10px;">Message : <?=$news; ?></div>
		<?php
	}
	else{echo "Not Found";}
}
else
{
	$ques = "select * from news";
	$q = mysql_query($ques);
	$totalrows = mysql_num_rows($q);
	?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th style="width:10%;" class="text-center">Date</th>
			<th>Title</th>
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
	
	$q1 = mysql_query("select * from news LIMIT $start,$plimit ");		
	
	while($id_row = mysql_fetch_array($q1))
	{
		$id = $id_row['id'];
		$date = $id_row['date'];
		$title = $id_row['title'];
		$news = $id_row['news'];
		$date = date('d/m/Y',strtotime($date));
		?>
		<tr>
			<td class="text-center"><?=$date?></td>	
			<td><a href="index.php?page=sys_announce&p=<?=$newp?>&id=<?=$id;?>"><?=$title;?></a></td>
		</tr>	
		<?php		
	}
	?>
	</table>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=sys_announce&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=sys_announce&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=sys_announce&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
	</ul>
	</div>

<?php }?>
