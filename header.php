<?php
ini_set('display_errors','off');
$id = $_SESSION['ebank_user_id'];
?>
<header class="main-header">
	<a href="index.php" class="logo"> 	
		<img src="images/newlayout/ebank.png" style="vertical-align:top;"> 
	</a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown messages-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-shopping-cart"></i>
						<span class="label label-success">
							<?php  if(isset($_SESSION['item']))print count($_SESSION['item']); 
							else print "0";?>
						</span>                
					</a>
					<ul class="dropdown-menu">
						<li class="header">
							You Order To <?php if(isset($_SESSION['item']))print count($_SESSION['item']);
							else print "0";?> Product
						</li>
						<li>
						<!-- inner menu: contains the actual data -->
						<ul class="menu">
							<?php
							$item_arr = $_SESSION['item'];
							$cnt = count($item_arr);
							$new_item_arr = array();
							$cnt_item = 1;
							$count_item_arr = array_count_values($item_arr);
							 for($i = 0; $i < count($item_arr); $i++)
							 {
								$item = $item_arr[$i];
								if(!in_array($item,$new_item_arr))
								{
									$new_item_arr[] = $item;
								}
							 }
							 for($i = 0; $i < 5; $i++)
							 {	
								$item = $new_item_arr[$i];
								$q = mysql_query("select * from shopping_product where id='$item'");
								while($rr = mysql_fetch_array($q))
								{
								?> <li>
								<a href="#">
									<div class="pull-left">
									<img class="img-thumbnail" src="images/product/<?=$rr['pro_image'];?>" />
									</div>
									<h4><?=$rr['p_name'];?> <small><i class="fa fa-shopping-cart"></i> <?=$count_item_arr[$item];?> Product</small></h4>
									</a>
									</li>
								<?php	
								}
							 }
							 ?>
					</ul>
				</li>
				<li class="footer">
				<a href="#">
					<form action="index.php?page=view_cart" method="post">
						<input type="Submit" name="view_cart" 
						value="View Cart (<?=count($item_arr);?> items)" 
						class="btn btn-primary btn-sm" />
					</form>
				</a>
				</li>
			</ul>
		</li>
			<!-- Messages: style can be found in dropdown.less-->
		<li class="dropdown messages-menu">
			<?php
			$query = mysql_query("SELECT * FROM message WHERE receive_id = '$id' order by id desc");
			$num = mysql_num_rows($query);
			include('language/en.php');
			?>
			<a href="index.php?page=inbox" class="dropdown-toggle" data-toggle="dropdown">
				<i class="fa fa-envelope-o"></i>
				<span class="label label-success"><?=$num;?></span>                
				</a>
				<ul class="dropdown-menu">
				<li class="header"><?=$you_hav;?></li>
				<li>
				<!-- inner menu: contains the actual data -->
				<ul class="menu">
			<?php
			if($num > 0)
			{ 
				while($row = mysql_fetch_array($query))
				{
					$id  = $row['id'];
					$receive_id  = $row['receive_id'];
					$title = $row['title'];
					$message = $row['message'];
					$message_date = $row['message_date'];
					$time = $row['time'];
					
					$datetime1 = new DateTime();
					$datetime2 = new DateTime($time);
					$interval = $datetime1->diff($datetime2);
					$interval->format('%Y-%m-%d %H:%i:%s');
					$days = $interval->format('%d');
					$hour = $interval->format('%H');
					$minute = $interval->format('%i');
					$clock_days = '';
					$clock_hour = '';
					$clock_minute = '';
					
					if($days != 0)
					$clock_days = $days." Days";
					if($hour != 0)
					$clock_hour = $hour." Hour";
					if($minute != 0)
					$clock_minute = $minute." Min";
					
					$que = mysql_query("SELECT * FROM admin");
					while($rrr = mysql_fetch_array($que))
					{
						$name = $rrr['username'];
					}
					?>
				<li><!-- start message -->
				<a href="index.php?page=inbox">
				<div class="pull-left">
					<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="<?=$name; ?>"/>
				</div>
				<h4>
					<?=$title; ?> 
					<small><i class="fa fa-clock-o"></i> <?=$clock_days." ".$clock_hour." ".$clock_minute;?></small>
				</h4>
				<p><?php print $message; ?></p>
				</a>
				</li><!-- end message -->
			<?php
				}
			} 
			else 
			{
	?>			<li style="font-size:12px; padding-left:10px; font-weight:bold;">
					There are no information to show !!
				</li>
	<?php 	}?>
			</ul>
				</li>
				<li class="footer"><a href="index.php?page=inbox">See All Messages</a></li>
			</ul>
		</li>
	  <?php
	    $user_id = $_SESSION['ebank_user_id'];
	 	$query = mysql_query("SELECT * FROM users WHERE id_user = '$user_id' ");
		while($row = mysql_fetch_array($query))
		{ 
			$image = $row['photo']; 
		}
		if($image == ''){ $image = "user.png"; }
		?>
		<li class="dropdown user user-menu">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<img src="images/profile_image/<?=$image;?>" class="user-image" />
				<span class="hidden-xs"><?=ucfirst($_SESSION['ebank_user_full_name']);?></span>
			</a>
			<ul class="dropdown-menu">
				<!-- User image -->
				<li class="user-header">
					<img src="images/profile_image/<?=$image;?>" class="img-circle"  />
					<p><?=ucfirst($_SESSION['ebank_user_full_name']);?></p>
				</li>
				<!-- Menu Footer-->
		  		<li class="user-footer">
					<div class="pull-left">
						<a href="index.php?page=edit-profile" class="btn btn-default btn-flat">
							<?=$Profile;?>
						</a>
					</div>
					<div class="pull-right">
					  <a href="logout.php" class="btn btn-default btn-flat"><?=$Sign_out;?></a>
					</div>
		  		</li>
			</ul>
		</li>
	</ul>
	</div>
</nav>
</header>
<div>
<?php 
$alert_report[3] = "being blocked";
$date = date('Y-m-d H:i:s');
$sql_time_block = mysql_query("SELECT * FROM tb_time_block");
$row_time_report = mysql_fetch_array($sql_time_block);

$time_block = $row_time_report['time_block'];
$time_frozen = $row_time_report['time_frozen'];
$frozen_downline = $row_time_report['frozen_downline'];
$time_report = $row_time_report['time_report'];
//update report
$q_user_report = mysql_query("SELECT * FROM report WHERE reported = ".$user_id."");
$r_user_report = mysql_fetch_array($q_user_report);
if(!empty($r_user_report)){
	if($r_user_report['mode'] == 1){
		$rel_time = date('Y-m-d H:i:s',(strtotime($r_user_report['date']) + $time_block*3600));
	}
	if($r_user_report['mode'] == 2){
		$rel_time = date('Y-m-d H:i:s',(strtotime($r_user_report['frozen_date']) + $time_frozen*3600));
	}else{
		$rel_time = date('Y-m-d H:i:s', time());
	}
	
	if(!empty($rel_time)){
		if( strtotime($rel_time) < time()){
			
			$se_report = mysql_query("SELECT * fROM report WHERE reported = ".$id_user." AND mode = ".$r_user_report['mode']."");
			$re_report = mysql_fetch_array($se_report);

			$update_block = mysql_query("UPDATE report SET mode = 3 , block_date = '".$rel_time."' WHERE id = ".$re_report['id']." ");
			$delete_block = mysql_query("DELETE FROM report WHERE reported = ".$id_user." AND id <> ".$re_report['id']."");
			
			//update block time
			mysql_query("UPDATE users SET block_time = block_time+1 , time_block = '".$date."' WHERE id_user = ".$id_user."");

			//insert into tb_report_history
			if($update_block){ mysql_query("INSERT INTO tb_report_history (user_id , mode , date)  VALUES ('$user_id' , '3' , '$date')"); }
			
			//find real_parent 
			$mysql_user = mysql_query("SELECT * FROM users WHERE id_user = ".$user_id."");
			$row_mysql_user = mysql_fetch_array($mysql_user);
			if(!empty($row_mysql_user['real_parent'])){
				//kiểm tra user đã bị đóng băng chưa
			    $check_fro = mysql_query("SELECT *  FROM report WHERE reported = ".$$row_mysql_user['real_parent']." AND mode = ".$mode_report[2]."");
			    $count_fro = mysql_num_rows($check_fro);
			    if(empty($count_fro)){
			        //frozen this user_id
			        mysql_query("INSERT INTO report (reported , report , mode , date, frozen_date) values ('".$row_mysql_user['real_parent']."' , '$alert_report[2]' , '$mode_report[2]' , '$date', '$date') ");
			        // insert into report history
			        mysql_query("INSERT INTO tb_report_history (reported , report , mode , date)  VALUES ('".$row_mysql_user['real_parent']."' , '".$row_mysql_user['username']." ".$alert_report[3]."' , $mode_report[2]' , '$date')");
					//update frozen time
        			mysql_query("UPDATE users SET frozen_time = frozen_time+1 WHERE id_user = ".$row_mysql_user['real_parent']."");
				}
			}

			//delete investment_request by id_user 
			$q_investment_request = mysql_query("SELECT * fROM investment_request WHERE mode = 1 AND user_id = ".$user_id."");
			while($r_investment_request = mysql_fetch_array($q_investment_request)){
				mysql_query("DELETE FROM investment_request WHERE id = ".$r_investment_request['id']."");
			}

			// // chuyển income_transfer của các user giao dịch với id_user vào cột phải
			$q_income_transfer = mysql_query("SELECT * fROM income_transfer WHERE mode = 1 OR mode = 0 AND paying_id = ".$user_id."");
			while($r_income_transfer = mysql_fetch_array($q_income_transfer)){
				$move_income = mysql_query("INSERT INTO income (user_id , total_amount , paid_limit , date , mode , priority , rec_mode , time)  VALUES ('".$r_income_transfer['user_id']."' , '".$r_income_transfer['amount']."' , '".$r_income_transfer['paid_limit']."' , '".$r_income_transfer['date']."' , '1' , '1' , '1' , '".$r_income_transfer['time_link']."')");

				// xóa income_transfer của id_user
				$remove_incom_transfer = mysql_query("DELETE FROM income_transfer WHERE id = ".$r_income_transfer['id']."");
			}
		}
	}
}


?>
</div>