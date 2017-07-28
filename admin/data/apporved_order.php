<?php
session_start();
include("condition.php");

session_start();
?>
<h2 align="left">Approved Shopping Order</h2>
<?php

//*********************process Payment************************//
$serch_year = $_REQUEST['year'];
$serch_month = $_REQUEST['month'];
$tamount = 0;
$serach = '';
if(isset($_REQUEST['year']) and isset($_REQUEST['search']))
{
	$serach = " where YEAR(t1.date)='$serch_year'";
}
if(isset($_REQUEST['month']) and isset($_REQUEST['search']))
{
	$serach = " where MONTH(t1.date)='$serch_month'";
}
if(isset($_REQUEST['year']) and isset($_REQUEST['month']) and isset($_REQUEST['search']))
{
	$serach = " where YEAR(t1.date)='$serch_year' and MONTH(t1.date)='$serch_month'";
}


?>
	<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=500>
		<form action="" method="post">
		<tr>
				<th colspan=5 align="center">Select Month&nbsp;
					<select name="year" style="width:70px;">
						<option value="">YYYY</option>
				<?php
						$yr = date('Y');
						for($i = 2013; $i <= $yr; $i++) 
						{ ?>
							<option <?php if($year == $i) { ?> selected="selected" <?php } ?> 
							value="<?=$i; ?>"><?=$i; ?></option>
				<?php 	} ?> 
					</select>
					<select name="month" style="width:52px;">
						<option value="">MM</option>
						<option value="1">Jan</option>
						<option value="2">Feb</option>
						<option value="3">Mar</option>
						<option value="4">Apr</option>
						<option value="5">May</option>
						<option value="6">Jun</option>
						<option value="7">Jul</option>
						<option value="8">Aug</option>
						<option value="9">Sep</option>
						<option value="10">Oct</option>
						<option value="11">Nov</option>
						<option value="12">Dec</option>
					</select>
					<!--Select Date&nbsp;
					
					<select name="day" style="width:152px;">
						<option value="">Select Date</option>
						<option value="1">1-<?=$mnth_end_day?></option>
					</select>-->
					
					<input type="submit" name="search" value="Search">	
				</th>
			</tr>
		</form>
</table>
	<?php
 $sql = "select t1.*,t1.mode as od_mode,t2.mode,t2.confirm_date,t3.username from prd_order as t1 inner join prd_invoice as t2 on t1.id=t2.order_id and t2.mode=2
 	inner join users as t3 on t3.id_user = t1.user_id
   $serach ";
$q = mysql_query($sql);
$num = mysql_num_rows($q);
if($num > 0)
{
	
	while($row = mysql_fetch_array($q))
	{
		$product_list = $row['product_id'];
		$quantity_list = $row['quantity'];
		
		$product = explode("-",$product_list);
		$quantity = explode("-",$quantity_list);
		for($i = 0; $i < count($product); $i++)
		{
			$prd_id = $product[$i];
			$prd_quan = $quantity[$i];
			if($od_mode == 0){
				$sql_o = "select p_price from shopping_product where id='$prd_id'";
				$field = "p_price";
			}
			else{
				$sql_o = "select amount from product_bonus where id='$prd_id'";
				$field = "amount";
			}
			$sql_prd_price = mysql_query($sql_o);
			while($sp = mysql_fetch_array($sql_prd_price))
			$tamount = $tamount+($sp[$field]*$prd_quan);
		}
	}		
	?>
	
	<table align=\"center\" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=100%>
	
	 <tr>
		<td colspan="5">&nbsp;</td>
	  </tr>
	<tr class="even">
		<td class="message tip" colspan="3" align="center"><strong>Total Order</strong></td>
		 <td class="message tip" colspan="4" align="center"><strong>$ <?php print $tamount; ?></strong></td>
	  </tr>
	  <tr>
		<td colspan="7">&nbsp;</td>
	  </tr>
	  
	  <tr class="even">
		 <td class="message tip" align="center"><strong>S.No.</strong></td>
		 <td class="message tip" align="center"><strong>Order No.</strong></td>
		  <td class="message tip" align="center"><strong>User-name</strong></td>
		 <td class="message tip" align="center"><strong>Total Purchase</strong></td>
		 <td class="message tip" align="center"><strong>Order Status</strong></td>
		 <td class="message tip" align="center"><strong>Show Order</strong></td>
		 <td class="message tip" align="center"><strong>Date</strong></td>
	  </tr>
	
	<?php 
	
	$q = mysql_query($sql);
	$s_no = 1;
	while($row = mysql_fetch_array($q))
	{
		$product_list = $row['product_id'];
		$quantity_list = $row['quantity'];
		$order_confirm = $row['mode'];
		$prod_cost = $row['amount'];
		$order_no = $row['order_id'];
		$order_id = $row['id'];
		$user_name = $row['username'];
		$product = explode("-",$product_list);
		$quantity = explode("-",$quantity_list);
		if($order_confirm == 0)
		{
			$ord_st = "<form action=\"\" method=\"post\">
							<input type=\"hidden\" name=\"order\" value=\"$order_no\" />
							<input type=\"submit\" value=\"Process\" name=\"process\" class=\"button\" />
						</form>	";
			$date = $row['date'];
		}
		else
		{
			$ord_st = "Delivered";
			$date = $row['confirm_date'];
		}
		$tamount = 0;
		for($i = 0; $i < count($product); $i++)
		{
			$prd_id = $product[$i];
			$prd_quan = $quantity[$i];
			if($od_mode == 0){
				$sql_o = "select p_price from shopping_product where id='$prd_id'";
				$field = "p_price";
			}
			else{
				$sql_o = "select amount from product_bonus where id='$prd_id'";
				$field = "amount";
			}
			$sql_prd_price = mysql_query($sql_o);
			while($sp = mysql_fetch_array($sql_prd_price))
			$tamount = $tamount+($sp[$field]*$prd_quan);
		}
		if($s_no%2==0)
			$class = "even";
		else
			$class = "odd";
		print "<tr class=\"$class\">
				<td align=\"center\" class=\"input-small\">$s_no</td>
				<td align=\"center\" class=\"input-small\">$order_no</td>
				<td align=\"center\" class=\"input-small\">$user_name</td>
				<td align=\"center\" class=\"input-small\">$tamount</td>
				<td align=\"center\" class=\"input-small\">$ord_st</td>
				<td align=\"center\" class=\"input-small\">
				<form action=\"index.php?page=show_order\" method=\"post\">
					<input type=\"hidden\" name=\"order\" value=\"$order_id\" />
					<input type=\"submit\" value=\"Show\" name=\"show\" class=\"button\" />
				</form>	
				</td>
				<td  align=\"center\" class=\"input-small\">$date</td>
			  </tr>";
		$s_no++;
		
	}
	print "</table>";

}
else
{
	print "<br><p>There Have No Order !!</p> ";
}
?>