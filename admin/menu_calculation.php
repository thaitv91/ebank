<?php
$menu = submenu(0);
$menu_count = count($menu);
for($i = 0; $i < $menu_count; $i++)
{
	$sub_file = $menu[$i][1];
	$sub_menu[$i] = submenu($sub_file);
	for($j=0; $j < count($sub_menu[$i]); $j++)
	{
		$second_sub_menu[$i][$j] = submenu($sub_menu[$i][$j][1]);
	}
	
}

function submenu($parent_menu)
{
	 $sql = "select * from admin_menu where parent_menu = '$parent_menu'";
	$q = mysql_query($sql);
	$i=0;
	while($row = mysql_fetch_array($q))
	{
		$j=0;
		$fun_sub_menu[$i][$j] = $row['menu'];
		$j++;
		$fun_sub_menu[$i][$j] = $row['menu_file'];
		$i++;
		
		/*$fun_sub_menu[$i][0] = $row['menu'];
		$fun_sub_menu[$i][1] = $row['menu_file'];
		$i++;*/
	} 
	return $fun_sub_menu;	
}

function get_mainmenu($page)
{
	$q = mysql_query("select * from admin_menu where menu_file = '$page'");
	while($row = mysql_fetch_array($q))
	{
		$file = $row['menu'];
	}
	return $file;
}

function get_submenu($page)
{
	$sql = "Select * from admin_menu where menu_file = (Select parent_menu from admin_menu where menu_file = '$page')";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		$menu_title = $row['menu'];
	}
	return $menu_title;
}
function get_sec_submenu($page)
{
	$sql = "Select * from admin_menu where menu_file = (Select parent_menu from admin_menu where menu_file = (Select parent_menu from admin_menu where menu_file='$page'))";
	$query = mysql_query($sql);
	while($row = mysql_fetch_array($query))
	{
		$menu_title = $row['menu'];
	}
	return $menu_title;
}
?>