<?php
session_start();
?>
<div class="row border-bottom">
	<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
			<!--<form role="search" class="navbar-form-custom" method="post" action="search_results.html">
				<div class="form-group">
					<input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
				</div>
			</form>-->
			<!--Language Flags for language change Start here-->
			<!--<div style="margin:11px 0 0 20px; float:left">
			<form role="search" class="navbar-form-custom" method="post" action="" style="height:25px;">
				<input type="submit" id="en" value="English" name="lang" style="font-size:0; background:url(img/lang/en.png); height:25px; width:32px; cursor:pointer;" title="English">
				<input type="submit" id="fr" value="French" name="lang" style="font-size:0; background:url(img/lang/fr.png); height:25px; width:32px; cursor:pointer;" title="French">
				<input type="submit" id="sp" value="Spanish" name="lang" style="font-size:0; background:url(img/lang/sp.png); height:25px; width:32px; cursor:pointer;" title="Spanish">
			</form>
			</div>-->
			<!--Language Flags for language change End here-->
		</div>
		<ul class="nav navbar-top-links navbar-right">
			<li>
				<span class="m-r-sm text-muted welcome-message">
					Welcome to <B>Admin</B>
				</span>
			</li>
			<?php
				$query = mysql_query("SELECT * FROM message WHERE receive_id = '$id' order by id desc");
				$num = mysql_num_rows($query);
			?>
			<li class="dropdown">
				<a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
					<i class="fa fa-envelope"></i>  
					<span class="label label-warning"><?=$num;?></span>
				</a>
				<ul class="dropdown-menu dropdown-messages">
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
					?>	
						<li>
							<div class="dropdown-messages-box">
								<a href="profile.html" class="pull-left">
									<img alt="image" class="img-circle" src="img/a7.jpg">
								</a>
								<div class="media-body">
									<small class="pull-right">
										<?=$clock_hour; ?>
									</small>
									<strong>Mike Loreipsum</strong> started following 
									<strong>Monica Smith</strong>. <br>
									<small class="text-muted">
										<?=$clock_days." ".$clock_hour." ".$clock_minute; ?>
									</small>
								</div>
							</div>
						</li>
					<li class="divider"></li>
				<?php 	}  ?>
					<li>
						<div class="text-center link-block">
							<a href="mailbox.html">
								<i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
							</a>
						</div>
					</li>
					<?php
							}
							else 
							{
					?>			<li>
									<div class="media-body">There are no information to show !!</div>
								</li>
					<?php 	}	?>
				</ul>
			</li>
			<li><a href="logout.php"><i class="fa fa-sign-out"></i> <?=$logout;?></a></li>
		</ul>
	</nav>
</div>