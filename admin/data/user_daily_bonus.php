<?php
include("../function/functions.php");
	
$query = "select * FROM `income_transfer`
			WHERE `paying_id` NOT IN
			(
				SELECT * FROM
				(
					SELECT t1. paying_id 
					FROM income_transfer AS t1
					LEFT OUTER JOIN daily_interest AS t2 ON t1.paying_id = t2.member_id
					AND t1.mode =2
					where t2.member_id !='NULL'
					GROUP BY t1.paying_id
				) AS idtbl
			)
		and mode = 2
		group by paying_id";

$sql_query = mysql_query($query);
$num = mysql_num_rows($sql_query);
if($num > 0)
{ ?>
	<table class="table table-bordered">
			<thead>
			<tr>
				<th>Sr.</th>
				<th>Username</th>
				<th>Date</th>
				<th>ID</th>
			</tr>
			</thead>
	<?php				
	$sr = 1;		
	while($row = mysql_fetch_array($sql_query))
	{
	  print "<tr>  
			<td>$sr</td>
			<td>".$id = get_user_name($paying_id = $row['paying_id'])."</td>
			<td>".$date = $row['date']."</td>
			<td>".$paying_id = $row['paying_id']."</td>
			</tr>"; 
	$sr++;
	}
	print "</table>";
}
else { echo "<B style=\"color:#ff0000;\">There are no information to show !</B>"; }
?>