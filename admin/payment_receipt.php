<?php
include("config.php");
include("condition.php");
extract($_REQUEST);
if($m == 1)
{
	?>
	<img src="../images/payment_receipt/<?=$rp?>" />
	<?php
}
?>