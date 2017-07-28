<?php
ini_set("display_errors" , "off");
session_start();
require_once("config.php");
require_once("function/functions.php");
$Start='2015-12-23';
$end=date('Y-m-d');
$email_id='';
$mode='';
$allData=get_parent_details($_SESSION['ebank_user_id'], $Start, $end, $mode, $email_id);
 ?>
<table id="ContentPlaceHolder1_gridref" class="data_grid" cellspacing="0" border="1" style="width:100%;border-collapse:collapse;" rules="all">
	<tbody>		
		<tr>
			<th>Sr No.</th>
			<th>Payer  Name</th>
			<th>Reciver Name</th>
			<th>Amount</th>
			<th>Date</th>
			<th>Mode</th>
		</tr> 
<?php	
	for ($x = 0; $x <= count($allData)-1; $x++) {
		?>
		 <tr>
		 	<td align="center"><?=$x+1;?></td>
			
			<td><?=$allData[$x]['PayerName'];?></td>
			<td><?=$allData[$x]['ReciverName'];?></td>
			<td><?=$allData[$x]['amount'];?></td>
			<td><?=$allData[$x]['date'];?></td>
			<td><?=$allData[$x]['mode'];?></td>
        </tr>
<?php
		
	} 



?>

