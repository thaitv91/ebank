<?php
ini_set("display_erros","on");
session_start();
include('condition.php');
include("function/functions.php");
$user_id = $_SESSION['ebank_user_id'];
$network = $_SESSION['ebank_user_network'];
$network = implode(",",$network);

$sql = "select * from users where id_user in($network)";
$query = mysql_query($sql);
?>
<div class="col-md-12">
	<div class="widget">
		<div class="widget-head clearfix">
			<h4 class="heading"><i class="fa fa-upload"></i>  GD Downline</h4>
		</div>
		<div class="widget-body innerAll">
				<div class="overthrow" >
				<table class="table table-bordered ">
				<thead>
					<tr><th>Sr.No.</th><th>Username</th><th>Action</th></tr>
				</thead>
				<tbody>
				<?php
				$i = 1;
				while($row = mysql_fetch_array($query)){
				?>
					<tr><td><?=$i?></td><td><?=$row['username'];?></td>
						<td>
							<form action="index.php?page=downline_gd" method="post">
								<input type="hidden" name="network" value="<?=$row['id_user']?>" />
								<input type="submit" name="gd" value="GD" class="btn btn-info" />
							</form>
						</td>
					</tr>
				<?php 
					$i++;
				} ?>					
				</tbody>
				</table>
				</div>
				<p></p>
		</div>
	</div>
</div>
