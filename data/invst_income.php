<?php
session_start();
include("condition.php");

$id = $_SESSION['ebank_user_id'];

$newp = $_GET['p'];
$plimit = "10";



$tamount = 0;
$opq = mysql_query("select sum(total_amount-paid_amount) from income where user_id = '$id' and mode = 1 ");
while($rrow = mysql_fetch_array($opq))
	$tamount = $tamount+$rrow[0];
$q = mysql_query("select * from income_transfer where user_id = '$id' ");
$totalrows = mysql_num_rows($q);
if($totalrows == 0)
{
	echo "There is no information to show!"; 
}
else
{
	while($row = mysql_fetch_array($q))
	{
		$update_fees = $row['update_fees'];
		$tamount = $tamount+$row['amount'];
		
	}		
	?>
	<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info"> 
	<tbody role="alert" aria-live="polite" aria-relevant="all">
		<tr>
		<td colspan="4" align="center"><strong>Total Investment Income</strong></td>
		 <td colspan="4" align="center"><strong><?php print round($tamount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$tamount; ?> <font color=dark>$ </font></strong></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td align="center"><strong>Date</strong></td>
		 <td align="center"><strong>Income</strong></td>
		 <td align="center"><strong>Payee Id</strong></td>
		 <td align="center"><strong>Payee Name</strong></td>
		 <td align="center"><strong>Payee E-mail</strong></td>
		 <td align="center"><strong>Payee Phone</strong></td>
		 <td align="center"><strong>Receipt No</strong></td>
		 <td align="center"><strong>Status</strong></td>
	  </tr>
	<?php 

	$tr = 0;
	$q = mysql_query("select * from income_transfer where user_id = '$id' ");
	while($r = mysql_fetch_array($q))
	{
		$tr++;
		$date = $r['date'];
		$profit = $r['profit'];
		$investment_id = $r['investment_id'];
		$amount = $r['amount'];
		$amount_usd = round($amount/$usd_value_current,2);
		$paying_id = $r['paying_id']; 	
		$payment_receipt = $r['payment_receipt'];	
		$mode = $r['mode'];
		if($mode == 0)
			$invst_status = "Pending";
		elseif($mode == 1)
			$invst_status = "Payable";
		elseif($mode == 3)
			$invst_status = "Blocked";	
		else
			$invst_status = "Received";	
				
		
		$qyq = mysql_query("select * from users where id_user = '$paying_id' ");
		while($rtrr = mysql_fetch_array($qyq))
		{
			$username = $rtrr['username'];
			$bank_acc = $rtrr['ac_no'];
			$bank_name = $rtrr['bank'];
			$email = $rtrr['email'];
			$phone_no = $rtrr['phone_no'];
			$name = $rtrr['f_name']." ".$rtrr['l_name'];
		}
		 	 	 			
		print "<tr>
			<td  align=\"center\">$date</td>
			<td align=\"right\" style=\"padding-right:20px;\">$$amount_usd <font color=DodgerBlue>USD</font> Or  $amount <font color=dark>$ </font></td>
			<td align=\"center\">$username</td>
			<td align=\"center\">$name</td>
			<td align=\"center\">$email</td>
			<td align=\"center\">$phone_no</td>
			<td align=\"center\">"; ?>
			<a id="trigger-rec<?php print $tr; ?>" style="cursor:pointer;"><?php print $payment_receipt; ?></a><br />Mouse Over 
				<div id="pop-up-rec<?php print $tr; ?>" class="css_popup"> 	 
				<table class="MyTable" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse; margin:6px;" cellpadding="0" cellspacing="0" width="95%" >
					<tr>
						<td align="center" height="25" colspan="2" style="padding-left:0px;" bgcolor="#B8C8DC"><strong>Payment Receipt</strong></td>
					</tr>
					<tr>
						<td width="120">Receipt No. </td>
						<td><?php print $payment_receipt; ?></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">
						<img src="payment_receipt/<?php print $payment_receipt; ?>.jpg" height="370" width="640" />
						</td>
					</tr>
				</table>
				</div>	
<?php		print "</td>		
			<td align=\"center\">$invst_status</td>
		  </tr>";
	}	
}
if($totalrows == 0)
{
	?>
	<table id="table-1" class="table table-striped table-hover dataTable" aria-describedby="table-1_info"> 
	<tbody role="alert" aria-live="polite" aria-relevant="all">
	<tr>
		<td colspan="3" align="center"><strong>Total Help Income</strong></td>
		 <td colspan="5" align="center"><strong><?php print round($tamount/$usd_value_current,2)." <font color=DodgerBlue>USD</font> Or  ".$tamount; ?> <font color=dark>$ </font></strong></td>
	  </tr>
	  <tr><td colspan="8">&nbsp;</td></tr>
	  <tr>
		<td align="center"><strong>Date</strong></td>
		 <td align="center"><strong>Income</strong></td>
		 <td align="center"><strong>Payee Id</strong></td>
		 <td align="center"><strong>Payee Name</strong></td>
		 <td align="center"><strong>Payee E-mail</strong></td>
		 <td align="center"><strong>Payee Phone</strong></td>
		 <td align="center"><strong>Receipt No</strong></td>
		 <td align="center"><strong>Status</strong></td>
	  </tr>
	<?php
}
$q = mysql_query("select * from income where user_id = '$id' and mode = 1 ");
while($r = mysql_fetch_array($q))
{
	$date = $r['date'];
	$total_amount = $r['total_amount'];
	$paid_amount = $r['paid_amount']; 	 	
	$amount = $total_amount-$paid_amount;
	$amount_usd = round($amount/$usd_value_current,2);
	$invst_status = "Waiting";
	
	print "<tr>
		<td  align=\"center\">$date</td>
		<td align=\"right\" style=\"padding-right:20px;\">$$amount_usd <font color=DodgerBlue>USD</font> Or  $amount <font color=dark>$ </font></td>
		<td align=\"center\">-</td>
		<td align=\"center\">-</td>
		<td align=\"center\">-</td>
		<td align=\"center\">-</td>
		<td align=\"center\">-</td>
		<td align=\"center\">$invst_status</td>
	  </tr>";
}	
?>
</tbody>
</table>

<style>
      div#container {
        width: 580px;
        margin: 100px auto 0 auto;
        padding: 20px;
        background: #000;
        border: 1px solid #064879;
      }
      
      /* HOVER STYLES */
	  .css_popup
	  {
        display: none;
        position:absolute;
        width:670px;
        padding:0;
        background-color:#FFFFFF;
        color: #000000;
        border: 1px solid #064879;
        font-size: 90%;
		line-height:15px;
		height:450px;

      }

	  .MyTable td {
	  padding-left:20px; }
	        
    </style>
	
	
	 <script type="text/javascript"> 
      $(function() {
        var moveLeft = -500;
        var moveDown = -470;
		<?php for($rcp = 1; $rcp <= $totalrows; $rcp++)
		{ ?>
		$('a#trigger-rec<?php print $rcp; ?>').hover(function(e) {
          $('div#pop-up-rec<?php print $rcp; ?>').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() { 
          $('div#pop-up-rec<?php print $rcp; ?>').hide();
        });
        
        $('a#trigger-rec<?php print $rcp; ?>').mousemove(function(e) {
          $('div#pop-up-rec<?php print $rcp; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
		
		<?php } ?>
      });
	  
	</script>

<?