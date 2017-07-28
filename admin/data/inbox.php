<?php
session_start();
require_once("../config.php");
include("../function/functions.php");

$newp = $_GET['p'];
$plimit = "15";
if(isset($_REQUEST['rply_submit']) and $_SESSION['rply_sess'] == 1)
{
	$_SESSION['rply_sess'] = 0;
	$u_id = $_REQUEST['ms_id'];
	$message = $_REQUEST['rply'];
	$title = "Send Reply By Adminitrator";
	$message_date = $systems_date;
	$time = date("Y-m-d H:i:s",strtotime($message_date));
	mysql_query("INSERT INTO message (id_user,receive_id, title, message, message_date,time)
				 VALUES ('0','$u_id' , '$title' , '$message', '$message_date','$time') ");
	echo "<font color=green size=2><strong>Message send successfully!</strong></font>";	
}
if(isset($_POST['read']))
{
	$table_id = $_POST['table_id'];
	$_SESSION['rply_sess'] = 1;
	mysql_query("update message set mode = 1 where id = '$table_id' ");
	$query = mysql_query("SELECT * FROM message WHERE id = '$table_id'");
	while($row = mysql_fetch_array($query))
	{
		$id  = $row['id'];
		$title = $row['title'];
		$message = $row['message'];
		$message_date = $row['message_date'];
		$mode = $row['mode'];
		$receive_id = $row['id_user'];
	}
	if($receive_id == 0)
	{ 
		$name = "Admin";
	}
	else
	{	
		$qqq = mysql_query("SELECT * FROM users WHERE id_user = '$receive_id'");
		while($rrrr = mysql_fetch_array($qqq))
		{
			$name = $rrrr['f_name']." ".$rrrr['l_name'];
		}
	}	
?> 
		<div style="height:30px; text-align:left; padding-left:10px;">From : <?=$name;?></div>
		<div style="height:30px; text-align:left; padding-left:10px;">Title : <?=$title;?></div>
		<div style="height:30px; text-align:left; padding-left:10px;">Date : <?=$message_date;?></div>
		<div style="height:auto; text-align:left; padding-left:10px; margin-top:20px;">
			Message : <?=$message;?>
		</div>
		
		<div style="height:auto; text-align:left; width:100% padding:10px; margin-top:20px;">
			<form action="" method="post">
				<textarea name="rply" style="width:100%; padding:10px; min-height:100px; overflow:hidden;" placeholder="Reply"></textarea>
				<input type="hidden" name="ms_id" value="<?=$receive_id?>"  />
				<p></p>
				<input type="submit" class="btn btn-success" name="rply_submit" value="Send Reply" />
			</form>	
		</div>
		
<?php
}
else
{ 	
	
	$query = mysql_query("SELECT * FROM message where receive_id = 0 group by id_user");
	$totalrows = mysql_num_rows($query);
	$pnums = ceil ($totalrows/$plimit);
	if ($newp==''){ $newp='1'; }
		
	$start = ($newp-1) * $plimit;
	$starting_no = $start + 1;
	
	if ($totalrows - $start < $plimit) { $end_count = $totalrows;
	} elseif ($totalrows - $start >= $plimit) { $end_count = $start + $plimit; }
		
		
	
	if ($totalrows - $end_count > $plimit) { $var2 = $plimit;
	} elseif ($totalrows - $end_count <= $plimit) { $var2 = $totalrows - $end_count; }  
	
 	$id = $_SESSION['dennisn_admin_login'];
	$sql ="SELECT * FROM message WHERE receive_id = 0 order by id 
	desc LIMIT $start,$plimit" ;
	$query = mysql_query($sql);
	$num = mysql_num_rows($query);
	if($num > 0)
	{  ?>
		<table class="table table-bordered">  
			<thead>
			
			<tr>
				<th><input type="checkbox" id="checkAll"/></th>
				<th class="text-center">Ticket ID</th>
				<th class="text-center">Query Title</th>
				<th class="text-center">UserName</th>
				<th class="text-center">Name</th>
				<th class="text-center">Date</th>
				<th class="text-center">&nbsp;</th>
			</tr>
			</thead>
			<?php					
			while($row = mysql_fetch_array($query))
			{
				$id  = $row['id'];
				$title = $row['title'];
				$message = $row['message'];
				$ticket_no = $row['ticket_no'];
				$message_date = $row['message_date'];
				$mode = $row['mode'];
				$receive_id = $row['id_user'];
				$username = get_user_name($receive_id);
				
				$que = mysql_query("SELECT * FROM users WHERE id_user = '$receive_id'");
				while($rrr = mysql_fetch_array($que))
				{
					$name = $rrr['f_name']." ".$rrr['l_name'];
				}
		?>
			<tr>
				<td><input class="checkitem" type="checkbox" name="check_list[]" id="<?=$id?>"/></td>
				<form action="" method="post">
				<input type="hidden" name="table_id" value="<?=$id;?>"  />
				<td>
					<input type="submit" name="read" value="<?=$ticket_no;?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none;  text-align:left; vertical-align:top; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
				</td>
				<td>
					<input type="submit" name="read" value="<?=$title;?>" style="width:120px; height:20px; background:none; border:none; box-shadow:none;  text-align:left; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
				</td>
				<!--	
				<td>
					<input type="submit" name="read" value="<?=$message;?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none; cursor:pointer; text-align:left; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
				</td>-->
				<td>
					<input type="submit" name="read" value="<?=$username;?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none;  text-align:left; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
				</td> 
				<td>
					<input type="submit" name="read" value="<?=$name;?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none;  text-align:left; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
				</td>
				<td>
					<input type="submit" name="read" value="<?=$message_date;?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none;  text-align:left; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
				</td>
				<td>
					<input type="submit" name="read" value="Read More" style="width:150px; height:20px; background:none; border:none; box-shadow:none; cursor:pointer; text-align:left; vertical-align:top; color:#0000FF; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
				</td>
				</form>
				
			</tr>
	<?php 	}
	?>
	<input id="check_list" type="hidden" name="check_list" value="" />
		</table>
		<a href="javascript:;" id="del_mesages" class="btn btn-danger">Delete</a>
	<div id="DataTables_Table_0_paginate" class="dataTables_paginate paging_simple_numbers">
	<ul class="pagination">
	<?php
		if ($newp>1)
		{ ?>
			<li id="DataTables_Table_0_previous" class="paginate_button previous">
				<a href="<?="index.php?page=inbox&p=".($newp-1);?>">Previous</a>
			</li>
		<?php 
		}
		for ($i=1; $i<=$pnums; $i++) 
		{ 
			if ($i!=$newp)
			{ ?>
				<li class="paginate_button ">
					<a href="<?="index.php?page=inbox&p=$i";?>"><?php print_r("$i");?></a>
				</li>
				<?php 
			}
			else
			{ ?><li class="paginate_button active"><a href="#"><?php print_r("$i"); ?></a></li><?php }
		} 
		if ($newp<$pnums) 
		{ ?>
		   <li id="DataTables_Table_0_next" class="paginate_button next">
				<a href="<?="index.php?page=inbox&p=".($newp+1);?>">Next</a>
		   </li>
		<?php 
		} 
		?>
	</ul>
	</div>
<?php
	}
	else { echo "<B style=\"color:#ff0000;\">There is no information to show !!</B>"; }
} ?>	


<script type="text/javascript">
	$("#checkAll").change(function () {
		var selected = 0;
		var string_id = '';
		var yourArray = new Array();
        if(this.checked) { // check select status
            $('.checkitem').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"     
                yourArray.push($(this).attr('id')); 

            });
            string_id = yourArray.toString()
        }else{
            $('.checkitem').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"
            });     
            string_id = ''  
        }
        $('#check_list').val(string_id);
	});


	$(".checkitem").change(function () {
		var string_id = $('#check_list').val();
		if(string_id){
			var yourArray = string_id.split(",");
		}else{
			var yourArray = [];
		}
		
		if(this.checked) {    
            yourArray.push($(this).attr('id')); 
        }else{      
            var a = yourArray.indexOf($(this).attr('id')); 
            yourArray.splice(0,1);
        }
        $('#check_list').val(yourArray.toString());
	});
</script>		

<script type="text/javascript">
	$('#del_mesages').click(function(){
		var str_id = $('#check_list').val();
		if(!str_id){
			return false;
		}else{
			if(!confirm('Are you sure?')){ return false;}
			else{
				$.ajax({
	                url : "/ajax_call/del_messages.php",
	                type : "post",
	                dateType:"html",
	                data : 'string_id='+str_id,
	                success : function (result){
	                	if(result){
	                		location.reload(); 
	                	}
	                    //$('#button_action'+id_user).html(result);
	                    //location.reload(); 
	                }
	            });
			}
		}
	})
</script>
		