<?php
$menu = submenu(0);
$menu_count = count($menu);
for($i = 0; $i < $menu_count; $i++){
	$sub_file = $menu[$i][1];
	$sub_menu[$i] = submenu($sub_file);
}


function submenu($parent_menu)
{
	$fun_sub_menu = '';
	mysql_query ("set character_set_results='utf8'"); 
	$q = mysql_query("select * from menu where parent_menu = '$parent_menu'");
	$i=0;
	if(mysql_num_rows($q) > 0){
		while($row = mysql_fetch_array($q)){
			$fun_sub_menu[$i][0] = $row['menu'];
			$fun_sub_menu[$i][1] = $row['menu_file'];
			$i++;
		} 
	}
	return $fun_sub_menu;	
}

function get_mainmenu($page)
{
	$file = '';
	mysql_query ("set character_set_results='utf8'"); 
	$q = mysql_query("select * from menu where menu_file = '$page'");
	while($row = mysql_fetch_array($q)){
		$file = $row['menu'];
	}
	return $file;
}

function get_submenu($page)
{
	$menu_title = '';
	mysql_query ("set character_set_results='utf8'"); 
	$sql = "Select * from menu where menu_file=(Select parent_menu from menu where menu_file ='$page')";
	$query = mysql_query($sql);
	if(mysql_num_rows($query) > 0){
		while($row = mysql_fetch_array($query)){
			$menu_title = $row['menu'];
		}
	}
	return $menu_title;
}
?>