<?php
include("condition.php");
?>
<h1>Update Investment</h1>
<?php

if(isset($_POST['submit']))
{
	$username = $_REQUEST['username'];
	$query = mysql_query("select * from users where username = '$username' ");
	$num = mysql_num_rows($query);
	if($num != 0)
	{
		while($row = mysql_fetch_array($query))
		{
			$id_user = $row['id_user'];
			
			$w_q = mysql_query("select * from wallet where id = '$id_user' ");
			while($rr = mysql_fetch_array($w_q))
			{
				$wallet_amount = $rr['amount'];
			}
			$investment = '';
			$w_q = mysql_query("select * from reg_fees_structure where user_id = '$id_user' ");
			while($rr = mysql_fetch_array($w_q))
			{
				$investment .= $rr['update_fees']." <font color=dark>$ </font> on ".$rr['date']."<br>";
				
			}
				
			mysql_query("update wallet set amount = 0 where id = '$id_user' ");
			mysql_query("update reg_fees_structure set reg_fees = 0 , update_fees = 0 , total_days = 0 where user_id = '$id_user' ");
			
			$date = date('Y-m-d');
			$title_block = "Update Investment";
			$blocked = "update";
			include("../function/logs_messages.php");
			data_logs($id_user,$data_log[17][0],$data_log[17][1],$log_type[10]);
			
			print "<B style=\"color:#008000;\">Wallet Amount : $wallet_amount <br>
					Investment : $investment All Amount has been changed to 0 !!</B>";	
		}
	}
	else
	{ echo "<B style=\"color:#ff0000;\">Please Enter Correct Username !!</B>"; }	
}
else
{ ?> 
<form name="parent" action="index.php?page=update_investment" method="post">
<table class="table table-bordered">  		
	<tr>
		<th style="width:40%;">User Name</th>
		<td><input type="text" name="username" /></td>
	</tr>
	<tr>
		<td class="text-center" colspan="2">
			<input type="submit" name="submit" value="Update" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>
<?php 
}	
?>