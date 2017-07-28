<?php

$sqli = "select * from legal";
$query = mysql_query($sqli);
$num = mysql_num_rows($query);
if($num > 0)
{?>
	<table id="sorting-advanced" class="table-responsive table">
		<!--<thead>
		<tr>
			<th width="10%">Title</th>
			<th>Image</th>
		</tr>
		</thead>-->
	<?php
	while($row = mysql_fetch_array($query))
	{   
		$id = $row['id'];
		$title = $row['title'];
		$desc = $row['description'];
		$photo = $row['photo'];
	?>
		<tr>
			<th width="20%"><?=$title?></th>
			<td><img src="images/legal/<?=$photo;?>" /></td>
		</tr>
		
	<?php	
	}
	echo "</table>";
}
else{ print "<B style=\"color:#FF0000;\">There are no information to show !!</b>";}