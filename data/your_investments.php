<?php
session_start();
include("condition.php");
include("function/functions.php");

$id = $_SESSION['ebank_user_id'];

$newp = $_GET['p'];
$plimit = "10";

if($newp == '')
{
	$title = 'Display';
	$message = 'Display User Investments';
	data_logs($id,$title,$message,0);
}

$tamount = 0;
$q = mysql_query("select * from income_transfer where paying_id = '$id' ");
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
	<table align=\"center\"  border=0 width=800>
	<tr>
		<td class="messageheadbox" colspan="4" align="center"><strong>Total Investment</strong></td>
		 <td class="messageheadbox" colspan="8" align="center"><strong><?php print $tamount; ?> <font color=dark>$ </font></strong></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td class="messageheadbox" align="center"><strong>Date</strong></td>
		 <td class="messageheadbox" align="center"><strong>Investment</strong></td>
		 <td class="messageheadbox" align="center"><strong>Receiver Id</strong></td>
		 <td class="messageheadbox" align="center"><strong>Receiver E-mail</strong></td>
		 <td class="messageheadbox" align="center"><strong>Receiver Phone No.</strong></td>
		 <td class="messageheadbox" align="center"><strong>Receipt No</strong></td>
		 <td class="messageheadbox" align="center"><strong>Status</strong></td>
	  </tr>
	  

	<?php 
	
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }
	$tr = 0;
	$q = mysql_query("select * from income_transfer where paying_id = '$id' LIMIT $start,$plimit ");
	while($r = mysql_fetch_array($q))
	{
		$tr++;
		$date = $r['date'];
		$profit = $r['profit'];
		$investment_id = $r['investment_id'];
		$payment_receipt = $r['payment_receipt']; 	
		$amount = $r['amount'];
		$user_id = $r['user_id'];
		$mode = $r['mode'];
		if($mode == 0)
			$invst_status = "Pending";
		elseif($mode == 1)
			$invst_status = "Payable";
		else
			$invst_status = "Confirm";	
				
		
		$que = mysql_query("select * from users where id_user = '$user_id' ");
		while($rrr = mysql_fetch_array($que))
		{
			$username = $rrr['username'];
			$email = $rrr['email'];
			$phone_no = $rrr['phone_no'];
		}	
		
		print "<tr>
			<td  align=\"center\" class=\"messagemessagebox\">$date</td>
			<td align=\"center\" class=\"messagemessagebox\">$amount <font color=dark>$ </font></td>
			<td align=\"center\" class=\"messagemessagebox\">$username</td>
			<td align=\"center\" class=\"messagemessagebox\">$email</td>
			<td align=\"center\" class=\"messagemessagebox\">$phone_no</td>
			<td align=\"center\" class=\"messagemessagebox\">"; ?>
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
			<td align=\"center\" class=\"messagemessagebox\">$invst_status</td>
		  </tr>";
	}
	print "<tr><td colspan=6>&nbsp;</td></tr><td style=\"text-align:left; padding-left:20px;\" colspan=8 height=30px width=400 class=\"messageheadbox\"><strong>";
		if ($newp>1)
		{ ?>
			<a href="<?php echo "index.php?page=your_investments&open=4&p=".($newp-1);?>">&laquo;</a>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<a href="<?php echo "index.php?page=your_investments&open=4&p=$i";?>"><?php print_r("$i");?></a>
				<?php 
			}
			else
			{
				 print_r("$i");
			}
		} 
		if ($newp<$pnums) 
		{ ?>
		   <a href="<?php echo "index.php?page=your_investments&open=4&p=".($newp+1);?>">&raquo;</a>
		<?php 
		} 
		print"</strong></td></tr></table>";
	
}	
?>


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
        var moveLeft = 20;
        var moveDown = -280;
		<?php for($rcp = 1; $rcp <= $tttotal_roqs; $rcp++)
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

<?php

