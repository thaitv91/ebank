<?php
ini_set("display_errors" , "off");
session_start();
require_once("config.php");
require_once("function/functions.php");
$user_id = $_SESSION['ebank_user_id'];
?>
<form name="add_bank" action="" method="post">
<table class="grid-form-table" width="80%" align="right">
	<tbody>
	<tr>
		<td align="right">
			Start Date <input type="text" name="st_date" class="flexy_datepicker_input" />
		</td>
		<td align="right">
			End Date <input type="text" name="end_date" class="flexy_datepicker_input" />
		</td>
		<td align="right"><input type="text" name="email" placeholder="Search by email"/></td>
		<td align="right">Select Type
			<select name="link_type" style="width:150px;">
				<option value="">Select Option</option>
				<option value="0">Link In Process</option>
				<option value="1">Pending Link</option>
				<option value="2">Confirm Link</option>
			</select>
			<input type="submit" name="select_link" value="Submit" class="success" />
		</td>
	</tr>                                
	</tbody>
</table>
</form>

<?php
$Start = $_REQUEST['st_date'];
$end = $_REQUEST['end_date'];
$email_id = $_REQUEST['email'];
$mode = $_REQUEST['link_type'];
$allData = get_parent_details($user_id, $Start, $end, $mode, $email_id);
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
	for ($x = 0; $x <= count($allData)-1; $x++) 
	{ 
		if($allData[$x]['mode'] == 0){ $link_status = "Link in Progress";}
		if($allData[$x]['mode'] == 1){ $link_status = "Link Pending";}
		if($allData[$x]['mode'] == 2){ $link_status = "Link Confirmed";}
	?>
	 <tr>
		<td align="center"><?=$x+1;?></td>
		<td><?=$allData[$x]['PayerName'];?></td>
		<td><?=$allData[$x]['ReciverName'];?></td>
		<td><?=$allData[$x]['amount'];?></td>
		<td><?=$allData[$x]['date'];?></td>
		<td><?=$link_status;?></td>
	</tr>
<?php
	} 
?>
	</tbody>
</table>

