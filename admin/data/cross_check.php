<?php
session_start();
include("condition.php");
include("../function/logs_messages.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";
if(isset($_POST['submit']) or $newp != '')
{
	if($_POST['submit'] == 'Select')
	{
		$search_mode = $_REQUEST['search_mode'];
		if($search_mode == 'username')
		{ ?> 
			<form name="parent" action="index.php?page=cross_check" method="post">
			<input type="hidden" name="mode" value="1" />
			<table class="table table-bordered">
				<tr>
					<td>Enter Username</p> </td>
					<td><input type="text" name="username" /></td>
				</tr>
				<tr>
					<td class="form_label"><p>Start Date</p> </td>
					<td>
						<div class="form-group" id="data_1" style="margin:0px">
							<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="start_date" />
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_label"><p>End Date</p> </td>
					<td>
						<div class="form-group" id="data_1" style="margin:0px">
							<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="end_date" />
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="text-right">
						<input type="submit" name="submit" value="Search" class="btn btn-info"  />
					</td>
				</tr>
			</table>
			</form>
		<?php
		}
		else
		{?> 
			<form name="parent" action="index.php?page=cross_check" method="post">
			<input type="hidden" name="mode" value="2" />
			<table class="table table-bordered">
				<tr>
					<td class="form_label"><p>Start Date</p> </td>
					<td>
						<div class="form-group" id="data_1" style="margin:0px">
							<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="start_date" />
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="form_label"><p>End Date</p> </td>
					<td>
						<div class="form-group" id="data_2" style="margin:0px">
							<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" name="end_date" />
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td class="text-right">
						<input type="submit" name="submit" value="Search" class="btn btn-info"  />
					</td>
				</tr>		  
			</table>
			</form>
				<?php
		}
	}	
	elseif(($_POST['submit'] == 'Search') or $newp != '')
	{
		if($newp != '')
		{
			$mode = $_SESSION['search_mode_save'];
			$start_date = $_SESSION['search_start_date_save'];
			$end_date = $_SESSION['search_end_date_save'];
		}
		else
		{
			$mode = $_REQUEST['mode'];
			$start_date = $_REQUEST['start_date'];
			$end_date = $_REQUEST['end_date'];
			$_SESSION['search_start_date_save'] = $start_date;
			$_SESSION['search_mode_save'] = $mode;
			$_SESSION['search_end_date_save'] = $end_date;
		}
		if($start_date != '' and $end_date != '')
		{
			if($mode == 1)
			{
				if($newp != '')
				{
					$username = $_SESSION['search_username_save'];
				}
				else
				{
					$username = $_REQUEST['username'];
					$_SESSION['search_username_save'] = $username;
				}
				$query = mysql_query("select * from users where username = '$username' ");
				$num = mysql_num_rows($query);
				if($num != 0)
				{
					while($row = mysql_fetch_array($query))
					{
						$user_id = $row['id_user'];
						$start_date = date('Y-m-d', strtotime($start_date));
						$end_date = date('Y-m-d', strtotime($end_date));
						$SQL = "select * from logs where user_id = '$user_id' and 
						date >= '$start_date' and date <= '$end_date' and type = '$log_type[4]' ";
						$query = mysql_query(SQL);
						$totalrows = mysql_num_rows($query);
						if($totalrows != 0)
						{?>
						<table class="table table-bordered">
							<thead>
							<tr>
								<th class="text-center">Date</th>
								<th class="text-center">Title</th>
								<th class="text-center">Massage</th>
							</tr>
							</thead>
						<?php
							$pnums = ceil ($totalrows/$plimit);
							if ($newp==''){ $newp='1'; }
								
							$start = ($newp-1) * $plimit;
							$starting_no = $start + 1;
							
							if ($totalrows - $start < $plimit) { $end_count = $totalrows;
							} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
								
								
							
							if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
							} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
										
							$query = mysql_query("select * from logs where user_id = '$user_id' 
							and date >= '$start_date' and date <= '$end_date' and type = '$log_type[4]' 
							LIMIT $start,$plimit ");			
							while($row = mysql_fetch_array($query))
							{
								$title = $row['title'];
								$message = $row['message'];
								$date = $row['date'];
								print  "<tr>
									<td>$date</td>
									<td>$title</td>
									<td>$message</td>
									</tr>";
							}
							echo "</table>";
					?>
					<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
					<ul class="pagination">
					<?php
						if ($newp>1)
						{ ?>
							<li id="DataTables_Table_0_previous" class="paginate_button previous">
								<a href="<?="index.php?page=cross_check&p=".($newp-1);?>">Previous</a>
							</li>
						<?php 
						}
						for ($i=1; $i<=$pnums; $i++) 
						{ 
							if ($i!=$newp)
							{ ?>
								<li class="paginate_button ">
									<a href="<?="index.php?page=cross_check&p=$i";?>"><?php print_r("$i");?></a>
								</li>
								<?php 
							}
							else
							{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
						} 
						if ($newp<$pnums) 
						{ ?>
						   <li id="DataTables_Table_0_next" class="paginate_button next">
								<a href="<?="index.php?page=cross_check&p=".($newp+1);?>">Next</a>
						   </li>
						<?php 
						} 
						?>
						</ul></div>
					<?php	
						}
						else 
						{ echo "<B style=\"color:#ff0000;\">There is no logs !</B>"; }
					}	
				}
				else
				{ echo "<B style=\"color:#ff0000;\">Please Enter Correct Username !</B>"; }		
			}
			else
			{
				$start_date = date('Y-m-d', strtotime($start_date));
				$end_date = date('Y-m-d', strtotime($end_date));
				$sqli = "select * from logs where  date >= '$start_date' and date <= '$end_date' and 
				type = '$log_type[4]' ";
				$query = mysql_query($sqli);
				$totalrows = mysql_num_rows($query);
				if($totalrows != 0)
				{?>
					<table class="table table-bordered">
						<thead>
						<tr>
							<th class="text-center">Date</th>
							<th class="text-center">Account Id</th>
							<th class="text-center">Massage</th>
						</tr>
						</thead>
					<?php
					$pnums = ceil ($totalrows/$plimit);
					if ($newp==''){ $newp='1'; }
						
					$start = ($newp-1) * $plimit;
					$starting_no = $start + 1;
					
					if ($totalrows - $start < $plimit) { $end_count = $totalrows;
					} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
						
								
							
					if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
					} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
									
					$sqls = "select * from logs where date >= '$start_date' and date <= '$end_date' 
					and type = '$log_type[4]' LIMIT $start,$plimit ";
					$query = mysql_query($sqls);			
					while($row = mysql_fetch_array($query))
					{
						$user_id = $row['user_id'];
						$u_anme = get_user_name($user_id);
						$message = $row['message'];
						$date = $row['date'];
						print  "<tr>
								<td>$date</td>
								<td>$u_anme</td>
								<td>$message</td>
							</tr>";	
					}
					echo "</table>";
					?>
					<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
					<ul class="pagination">
					<?php
					if ($newp>1)
					{ ?>
						<li id="DataTables_Table_0_previous" class="paginate_button previous">
							<a href="<?="index.php?page=cross_check&p=".($newp-1);?>">Previous</a>
						</li>
					<?php 
					}
					for ($i=1; $i<=$pnums; $i++) 
					{ 
						if ($i!=$newp)
						{ ?>
							<li class="paginate_button ">
								<a href="<?="index.php?page=cross_check&p=$i";?>"><?php print_r("$i");?></a>
							</li>
							<?php 
						}
						else
						{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
					} 
					if ($newp<$pnums) 
					{ ?>
					   <li id="DataTables_Table_0_next" class="paginate_button next">
							<a href="<?="index.php?page=cross_check&p=".($newp+1);?>">Next</a>
					   </li>
					<?php 
					} 
					?>
					</ul></div>
					<?php	
				}
				else { echo "<B style=\"color:#ff0000;\">There is no logs !</B>"; }
			}	
		}
		else 
		{ echo "<B style=\"color:#ff0000;\">Please Enter Start Date or End Date !</B>"; }		
	}
	else { echo "<B style=\"color:#ff0000;\">There Is Some Conflicts !</B>"; }
}			
else
{ ?> 
<form name="parent" action="index.php?page=cross_check" method="post">
<table class="table table-bordered">
	<tr>
		<th>Search Mode</th>
		<td>
			<input type="radio" name="search_mode" value="username" /> By Username &nbsp;&nbsp;&nbsp;
			<input type="radio" name="search_mode" value="date" /> By Date
		</td>
	</tr>
	<tr>
		<td colspan="2" class="text-right">
			<input type="submit" name="submit" value="Select" class="btn btn-info"  />
		</td>
  </tr>
</table>
</form>
	<?php
}	
?>
<script src="js/date.js"></script>