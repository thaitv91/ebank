<?php 
include("condition.php");
$q = mysql_query("select * from wallet where id = '".$_SESSION['real_parent_id']."' ");
while($row = mysql_fetch_array($q))
{
	$amount = $row['amount'];
}
 ?>
	
	<table align="center" width="300" border="0">
	<form name="generate_epin" action="index.php?val=add_member&open=3" method="post">
	  
	  <tr>
		<td align="center" colspan="2">Wallet Amount $<?php echo $amount; ?> <font color=dark>$ </font></td>
	  </tr>
	  <tr>
		<td align="center" colspan="2">Registration Fees $<?php echo $fees; ?> <font color=dark>$ </font></td>
	  </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
		<td>Generate E-Pin</td>
		<td><input type="submit" name="submit" value="Generate" class="btn btn-info" /></td>
	  </tr>
	  </form>
	</table>
	
