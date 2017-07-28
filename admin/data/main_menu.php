<?php
$sql = "select * from menu";
$query = mysql_query($sql);
$num = mysql_num_rows($query);
if($num > 0)
{ ?>
	<table id="sorting-advanced" class="table-responsive table">
		<thead>
		<tr>
			<th>Sr no.</th>
			<th>Title</th>
			<th>Parent Menu</th>
			<th>Action</th>
		</tr>
		</thead>
		<?php
		$sr = 0;
		while($row = mysql_fetch_array($query))
		{   
			$sr++;
			$id = $row['id'];
			$menu = $row['menu'];
			$parent_menu = $row['parent_menu'];
			$menu_file = $row['menu_file'];
			
			if($parent_menu == '0'){ $par_menu = "Main Menu";}
			else{ $par_menu = $parent_menu; }
		?>
		<tr>
			<td><?=$sr;?></td>
			<td><?=$menu;?></td>
			<td><?=$par_menu;?></td>
			<td></td>
		</tr>
		<?php
		}
		?>
	</table>
<?php
}
else{ print "<B style=\"color:#FF0000;\">There are no information to show !!</b>";}
		