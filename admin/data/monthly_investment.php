<?php
include("condition.php");
?>
<h1>User Monthly Investment</h1>
<?php
		$query = mysql_query("select MIN(date) from reg_fees_structure ");
		$num = mysql_num_rows($query);
		if($num != 0)
		{
			?>
				<table align="center" hspace = 0 cellspacing=0 cellpadding=0 border=0 width=500>
				<tr>
						<td>&nbsp;</td>
				</tr>		
				<tr>
						<td class="message tip" colspan="2" align="center"><strong>Investment Month</strong></td>
						 <td class="message tip" colspan="2" align="center"><strong>Total Investment</strong></td>
					  </tr>
				<?php	
			while($row = mysql_fetch_array($query))
			{
				$min_date = $row[0];
			}
			$current_month = date('Y-m-01');
			$start_date = $min_date;
			while($current_month >= $start_date)
			{ 	  
				$end_date = date('Y-m-01', strtotime($start_date . ' +1 month'));
				$quer = mysql_query("select * from reg_fees_structure where date >= '$start_date' and date < '$end_date' ");
				$num = mysql_num_rows($quer);
				if($num > 0)
				{
					$tamount = 0;
					while($row = mysql_fetch_array($quer))
					{
						$update_fees = $row['update_fees'];
						$reg_fees = $row['reg_fees'];
						if($update_fees == 0)
							$tamount = $tamount+$reg_fees;
						else
							$tamount = $tamount+$update_fees;
					}
					$full_start_date = date('M Y', strtotime($end_date . ' -1 month'));	
				 ?>
					
					<tr>
						<td class="message tip" colspan="2" align="center"><strong><?php print $full_start_date; ?></strong></td>
						 <td class="message tip" colspan="2" align="center"><strong>$ <?php print $tamount; ?></strong></td>
					  </tr>
				 <?php 
				}
				$all_date = date('Y-m-01', strtotime($start_date . ' +1 month'));
				$start_date = $all_date;
			}
			print "</table>";
		}
		