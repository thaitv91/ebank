<?php
include("condition.php");
include("../function/functions.php");
include("../function/setting.php");

$newp = $_GET['p'];
$plimit = "20";
$uid = $_REQUEST['uid']; 

if(isset($_REQUEST['not_accept']))
{
	mysql_query("update ac_activation set mode=0,photo_mode=0,selfie_mode=0,photo_id=NULL,selfie_id=NULL where user_id='$uid'");
}
if(isset($_REQUEST['photo_accept']))
{
	mysql_query("update ac_activation set photo_mode=1 where user_id='$uid'");
}
if(isset($_REQUEST['selfie_accept']))
{
	mysql_query("update ac_activation set selfie_mode=1 where user_id='$uid'");
}
if( isset($_REQUEST['photo_accept']) or isset($_REQUEST['selfie_accept']) )
{
	$sqwe = "Select * from ac_activation where user_id = '$uid' and photo_mode = 1 and selfie_mode = 1";
	$querr = mysql_query($sqwe);
	$num = mysql_num_rows($querr);
	if($num > 0)
	{
		$sql = "update ac_activation set mode=1 where user_id='$uid' and photo_mode=1 and selfie_mode=1";
		mysql_query($sql);
		$real_p = real_parent($uid);
		mysql_query("update users set activate_date='$systems_date' where id_user='$uid'");
		mysql_query("insert into user_income (user_id , income , income_id , type , date ) 
		values ('$real_p','$reffral_bonus_for_registration','$uid','$income_type[5]','$systems_date')");
		
		$sqd = "update wallet set  roi = roi + '$reffral_bonus_for_registration' where id = '$real_p'";			
		mysql_query($sqd);
	}
}

$sql = "SELECT t1.*,t2.* FROM users t1
		left join ac_activation t2 on t1.id_user = t2.user_id
		where t2.mode=0 and t2.photo_id is not NULL and t2.selfie_id is not NULL";
$query = mysql_query($sql);
$totalrows = mysql_num_rows($query);
if($totalrows == 0){
echo "There is no information !!";
}else{
?>
	<table class="table table-bordered">
		<thead>
		
		<tr>
			<th class="text-center">SR NO.</th>
			<th class="text-center">User Name</th>
			<th class="text-center">Name</th>
			<th class="text-center">Date</th>
			<th class="text-center">Status</th>
			<th class="text-center">Photo Id</th>
			<th class="text-center">Selfie Id</th>
			<th class="text-center">Accept</th>
			<th class="text-center">Cancel</th>
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
		$id = $row['id_user'];
		$username = get_user_name($id);
		$name = $row['f_name']." ".$row['l_name'];
		$type = $row['mode'];
		$photo_id = "<img width='60' height='60'  src=../images/profile_image/".$row['photo_id'].">";
		$selfie_id = "<img width='60' height='60' src=../images/profile_image/".$row['selfie_id'].">";
		if($type == 1) { $status = "Active"; }
		else { $status = "Deactive"; }
		$date = $row['date'];
		$photo_mode = $row['photo_mode'];
		$selfie_mode = $row['selfie_mode'];
		print "<tr>
			<td class=\"text-center\">$sr_no</td>
			<td class=\"text-center\">$username</td>
			<td class=\"text-center\">$name</td>
			<td class=\"text-center\">$date</td>
			<td class=\"text-center\">$status</th>
			<td class=\"text-center\">$photo_id</td>
			<td class=\"text-center\">$selfie_id</td><td>"; 
			if($photo_mode == 0){
			?>
			<form action="" method="post" >
				<input type="hidden" name="uid" value="<?=$id;?>" />
				<input type="submit" class="btn btn-info" name="photo_accept" value="Photo Accept" />
			</form>
			<?php
			}
			else{
				echo "Photo Accept";
			}
			if($selfie_mode == 0){
			?><br />
			<form action="" method="post" >
				<input type="hidden" name="uid" value="<?=$id;?>" />
				<input type="submit" class="btn btn-info" name="selfie_accept" value="Selfie Accept" />
			</form>
		<?php
			}
			else{
				echo "Selfie Accept";
			}
			?>
			<?php
		print "</td>
			<td>
				<form method=\"post\" >
					<input type=\"hidden\" name=\"uid\" value=\"$id\" />
					<input type=\"submit\" class=\"btn btn-info\" name=\"not_accept\" value=\"Decline\" />
				</form>
			</td>
			</tr>";
			
	}
	echo "</table>";
	?>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=member_activate&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=member_activate&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=member_activate&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
		</ul></div>
<?php } ?>
