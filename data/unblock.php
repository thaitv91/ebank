<?php
ini_set("display_erros","off");
session_start();
include('condition.php');
include("function/setting.php");
include("function/functions.php");
$user_id = $_SESSION['ebank_user_id'];
if($_SESSION['ebank_user_block_mode'] == 1)
{
	?>
	<div class="col-md-12">
	
	<div class="widget donate-sidebar pdContainer" style="padding:10px;">
		<h3 class="box-title" style="padding-left:10px;"><?="Un-Block Panel"?></h3>
		<div class="widget-body">
			<div class="donateHead clearfix">
				<b style="color:#FF0000; font-size:14px;">Your Account is Block Because You did'nt Re-PD !!<br />
				Click Here To Un-Block and You Will Be Deducted $  <?=$unblock_deduct;?> Amount in Main-wallet.</b><br /><br />
				<form action="" method="post">
					<input type="submit" value="UnFreeze" name="submit" class="btn btn-primary btn-sm" />
				</form>
			</div>
		</div>
	</div>
	
</div>



	<?php
}
if(isset($_REQUEST['submit']))
{
	mysql_query("update users set block=0 where id_user='$user_id'");
	mysql_query("update wallet set amount = amount-'$unblock_deduct' where id='$user_id'");
	
	$time = date('Y-m-d H:i:s');
	$cash_wal = get_wallet_amount($user_id);
	insert_wallet_account($user_id,$user_id,$unblock_deduct,$time,$acount_type[23],$acount_type_desc[23], 2, $cash_wal , $wallet_type[1]); 
	
	$_SESSION['ebank_user_freeze_mode'] = 0;
	echo "<script type=\"text/javascript\">";
	echo "window.location = \"index.php\"";
	echo "</script>";
}

?>


