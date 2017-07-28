<?php
include("../../../config.php");
include("../../../function/block_user.php");
$sql="SELECT income_transfer.paying_id FROM income_transfer where case when mode=0 then DATE_ADD(income_transfer.time_link,INTERVAL 2 DAY) <= NOW() when mode=1 then DATE_ADD(income_transfer.time_reciept,INTERVAL 2 DAY) <= NOW() end and mode IN (0,1) and income_transfer.id in (SELECT MAX(id) FROM income_transfer GROUP BY user_id)";
$querysd=mysql_query($sql);
while($table_row= mysql_fetch_array($querysd))
block_user_calculation($table_row['paying_id']);
