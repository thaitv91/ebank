<?php
session_start();
include("condition.php");
include("../function/functions.php");
?>
<h2 align="left">Average Price</h2><p></p>

<?php	
$qqq =  mysql_query("select * from user_trade group by trade_id ");	
$num = mysql_num_rows($qqq);
if($num > 0)
{
	?>
	<table width="800" border="0" cellpadding="1" cellspacing="1">	
	<tr>
		<th colspan="6" height="35">&nbsp;</th>
	</tr>	
	<tr>
		<th height="35" class="message tip"><strong>Trade Name</strong></th>
		<th height="35" class="message tip"><strong>Trade Quantity</strong></th>
		<th class="message tip"><strong>Trade Amount</strong></th>
		<th class="message tip"><strong>Average Price</strong></th>
	</tr>
	<?php	
	while($row = mysql_fetch_array($qqq))
	{ 
		$trade_id = $row['trade_id'];

		$tque = mysql_query("select sum(quantity) , sum(trade_amount) from user_trade where trade_id = '$trade_id' and buy_id = 0 ");
		while($row = mysql_fetch_array($tque))
		{
			$total_buy_trade = $row[0];
			$total_buy_amount = $row[1];
		}	
		
		$tque1 = mysql_query("select sum(quantity) , sum(trade_amount) from user_trade where trade_id = '$trade_id' and buy_id = 1 ");
		while($row2 = mysql_fetch_array($tque1))
		{
			$total_sale_trade = $row2[0];
			$total_sale_amount = $row2[1];
		}	
		
		$query = mysql_query("select * from trade_setting where trade_id = '$trade_id' ");
		while($row = mysql_fetch_array($query))
		{ 
			$trade_name = $row['trade_name'];
			$min_buy = $row['min_buy'];
			$min_tarde_days = $row['min_tarde_days'];
		}
		
		$total_quantity_trade = $total_buy_trade-$total_sale_trade;
		$total_amount_trade = $total_buy_amount-$total_sale_amount;
		$average_price = $total_amount_trade/$total_quantity_trade;
			
	   ?>
	   <tr>
		<td style="background-color:#DADAE4; border:solid 1px #999999; height:18px; width:150px; padding-left:20px;">
		<?php echo $trade_name; ?></td>
		<td style="background-color:#DADAE4; border:solid 1px #999999; height:18px; width:90px; padding-left:20px;">
		<?php echo $total_quantity_trade; ?></td>
		<td style="background-color:#DADAE4; border:solid 1px #999999; height:18px; width:120px; padding-left:20px;">
		$ <?php echo $total_amount_trade; ?>  <font color=dark>$ </font></td>
		<td style="background-color:#DADAE4; border:solid 1px #999999; height:18px; width:120px; padding-left:20px;">
		<?php echo $average_price; ?></td>
	   <tr>
<?php	} ?>		   
	 </table>
<?php	
}				
