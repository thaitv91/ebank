<?php
session_start();
include("condition.php");
require_once("../config.php");
include("../function/child_info.php");
include("../function/functions.php");

if(isset($_POST['Submit']))
{
	if($_POST['Submit'] == 'Submit')
	{
		$mode = $_REQUEST['mode'];
		?>
		<form name="my_form" action="index.php?page=all_finance" method="post">
		<table class="table table-bordered"> 
			<thead><tr><th colspan="2"> Daily Binary List</th></tr></thead>
			<?php
			if($mode == 'date') 
			{
			?>
			<tr>
				<input type="hidden" name="search_mode" value="date_wise"  />
				<th>Enter Start Date</th>
				<td><input type="text" name="s_date" /></td>
			</tr>
			<tr><td>Enter End Date</td><td><input type="text" name="end_d" /></td></tr>
			<?php 
			} 
			else
			{ ?>
			<tr>
				<input type="hidden" name="search_mode" value="user_wise"  />
				<th>Enter User Id</th>
				<td><input type="text" name="user_info" /></td>
			</tr>
			<?php 
			}?>
			<tr>
				<td class="center" colspan="2">		
					<input type="submit" name="Submit" value="Enter" class="btn btn-info" />
				</td>
			</tr>
		</table>
		</form>
		<?php
	}
	elseif($_POST['Submit'] == 'Enter')
	{
		$search_mode = $_REQUEST['search_mode'];
		if($search_mode == 'date_wise')
		{	
		
			$s_date = $_REQUEST['s_date'];
			$e_date = $_REQUEST['end_d'];
			$q_all = mysql_query("select * from add_funds where date >= '$s_date' and 
			date <= '$e_date' and mode = 1");
			$num_all = mysql_num_rows($q_all);
			if($num_all != 0)
			{ ?>
				<table class="table table-bordered"> 
					<thead>
					<tr>
						<th>Date</th>
						<th>User Id</th>
						<th>Amount</th>
						<th>Payment Mode</th>
						<th>Received Date</th>
					</tr>
					</thead>
				<?php
				while($row = mysql_fetch_array($q_all))
				{
					$amount = $row['amount'];
					$date = $row['date'];
					$user_id = $row['user_id'];
					$username = get_user_name($user_id);
					$payment_mode = $row['payment_mode'];
					$request_amount = $row['amount'];
					$app_date = $row['app_date'];
				?>
					<tr>
						<td><?=$date;?></th>
						<td><?=$username;?></th>
						<td><?=$amount;?></th>
						<td><?=$payment_mode;?></th>
						<td><?=$app_date;?></th>
					</tr>
				<?php
				}
				print "</table>";
			}
			else { echo "<B style=\"color:#ff0000;\">There is no information to show !!</B>"; }
		}
		elseif($search_mode == 'user_wise')
		{
			$u_name = $_REQUEST['user_info'];
			$q = mysql_query("select * from users where username = '$u_name' ");
			$num = mysql_num_rows($q);
			if($num == 0)
			{ echo "<B style=\"color:#ff0000;\">Please Enter right User Name !!</B>";  }
			else
			{
				while($id_row = mysql_fetch_array($q))
				{
					$id_user = $id_row['id_user'];
				}
				
				$q_all = mysql_query("select * from add_funds where user_id = '$id_user' and mode = 1 ");
				$num_all = mysql_num_rows($q_all);
				if($num_all != 0)
				{ ?>
					<table class="table table-bordered"> 
						<thead>
						<tr>
							<th>Date</th>
							<th>Amount</th>
							<th>Payment Mode</th>
							<th>Received Date</th>
						</tr>
						</thead>
					<?php
					while($row = mysql_fetch_array($q_all))
					{
						$amount = $row['amount'];
						$date = $row['date'];
						$payment_mode = $row['payment_mode'];
						$request_amount = $row['amount'];
						$app_date = $row['app_date'];
						?>
						<tr>
							<td><?=$date;?></th>
							<td><?=$amount;?></th>
							<td><?=$payment_mode;?></th>
							<td><?=$app_date;?></th>
						</tr>
					<?php		
					}
					print "</table>";
				}
			}	
		}
	}		
}	
else
{ ?>
<form name="my_form" action="index.php?page=all_finance" method="post">
<table class="table table-bordered"> 
	<thead><tr><th colspan="2">Daily Binary List Panel</th></tr></thead>
	<tr>
	<th>Select Search Mode</th>
	<td>
		<input type="radio" name="mode" value="date" /> By Date
		<input type="radio" name="mode" value="user" /> By User
	</td>
	</tr>
	<tr>
		<td class="text-center" colspan="2">
			<input type="submit" name="Submit" value="Submit" class="btn btn-info" />
		</td>
	</tr>
</table>
</form>
<?php  
}  
?> 

