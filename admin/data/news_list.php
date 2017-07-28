<?php
session_start();
include("condition.php");
if(isset($_POST['news_delete']))
{
$news_id=$_POST['news_id'];
mysql_query("DELETE FROM `news` WHERE id='$news_id'");
print "Successfully";
}
$newp = $_GET['p'];
if(isset($_REQUEST['news_no']))
{
	$qa = mysql_query("select * from news where id='".$_REQUEST['news_no']."'");
	echo "<a href='index.php?page=news_list&p=$newp' class='btn btn-danger'><i class=\"fa fa-reply\"></i>Back</a><p>&nbsp;</p>";
	if(mysql_num_rows($qa)!=0){$rowa=mysql_fetch_array($qa);
	?>
		<div style="height:30px; text-align:left; padding-left:10px;"><b>Title : <?=$rowa['title']; ?></b></div>
		<div style="height:30px; text-align:left; padding-left:10px;">Date : <?=$rowa['date']; ?></div>
		<div style="height:auto; text-align:left; padding-left:10px;">Message : <?=$rowa['news']; ?></div>
<?php
}else{echo "Not Found";}
}
else
{
$plimit = "25";
$q = mysql_query("select * from news ");
$totalrows = mysql_num_rows($q);
?>
	<table class="table table-bordered">  
		<thead>
		<tr>
			<th style="width:100px;" class="text-center">Date</th>
			<th class="text-center">Title</th>
		    <th style="width:100px;"  class="text-center">Action</th>
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
		?>
		<tr>
			<th class="text-center"><?=$id_row['date']?></th>	
			<td class="text-center">
				<a href="index.php?page=news_list&p=<?=$newp?>&news_no=<?=$id_row['id']?>">
					<?=$id_row['title']?>
				</a>
			</td>
			<td class="text-center">
			<a href="index.php?page=news_update&id=<?= $id_row['id'] ?>">Update</a>
			<form action="index.php?page=news_list&p=<?=$newp?>" method="post">
			    <input type="hidden" name="news_id" value="<?=$id_row['id']?>"  /> 
				<input style="background-color:transparent; color:red; text-decoration:underline; border:0;" type="submit" name="news_delete" value="Delete" />
 			</form>
		   </td>
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
				<a href="<?="index.php?page=news_list&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=news_list&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=news_list&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
	</ul>
	</div>

<?php }?>
