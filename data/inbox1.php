<?php
session_start();
//require_once("config.php");
//include("function/functions.php");
$id = $_SESSION['ebank_user_id'];

if(isset($_POST['read']))
{
	$table_id = $_POST['table_id'];
	mysql_query("update message set mode = 1 where id = '$table_id' ");
	$query = mysql_query("SELECT * FROM message WHERE id = '$table_id'");
	while($row = mysql_fetch_array($query))
	{
		$receive_id  = $row['receive_id'];
		$title = $row['title'];
		$message = $row['message'];
		$message_date = $row['message_date'];
		$mode = $row['mode'];
		
	}
		$qqq = mysql_query("SELECT * FROM admin WHERE id_user = '$id_user'");
		while($rrrr = mysql_fetch_array($qqq))
		{
			$name = $rrrr['username'];
		
		}
?> 
		<p>&nbsp;</p>
		<div style="height:30px; text-align:left; padding-left:10px;">From : <?php print $name; ?></div>
		<div style="height:30px; text-align:left; padding-left:10px;">Title : <?php print $title; ?></div>
		<div style="height:30px; text-align:left; padding-left:10px;">Date : <?php print $message_date; ?></div>
		<div style="height:auto; text-align:left; padding-left:10px; margin-top:20px;">Message : <?php print $message; ?></div>
		
<?php
}
else
{
$query = mysql_query("SELECT * FROM message WHERE receive_id = '$id' order by id desc");
$num = mysql_num_rows($query);
if($num > 0)
{ 
?><!-- New widget -->
<div class="powerwidget cold-grey" id="mailinbox" data-widget-editbutton="false">
	<header><h2>Inbox<small>Mail Inbox</small></h2></header>
	<div class="inner-spacer">
		<div class="mailinbox">
			<div class="row">
				<div class="col-md-1">
					<div class="left-content">
						<div class="list-group"> 
							<a href="#" class="list-group-item active">
								<i class="entypo-inbox"></i><b>Inbox</b><span class="badge">32</span>
							</a> 
							<a href="#" class="list-group-item"><i class="entypo-paper-plane"></i><b>Sent</b></a> 
							<a href="#" class="list-group-item"><i class="entypo-doc-text"></i><b>Drafts</b></a> 
							<a href="#" class="list-group-item"><i class="entypo-archive"></i><b>Archive</b></a> 
							<a href="#" class="list-group-item"><i class="entypo-trash"></i><b>Trash</b></a> 
						</div>
					</div>
				</div>
				<div class="col-md-11">
					<div class="right-content clearfix">
						<div class="big-icons-buttons clearfix margin-bottom"> 
							<a class="btn btn-sm btn-default"><i class="fa fa-envelope"></i>New Message</a>
							<div class="btn-group btn-group-sm pull-right"> 
								<a class="btn btn-default mark_read"><i class="fa fa-check-circle-o"></i>Read</a> 
								<a class="btn btn-default mark_unread"><i class="fa fa-circle-o"></i>Unread</a> 
								<a class="btn btn-default delete"><i class="fa fa-times-circle"></i> Delete</a> 
								<a class="btn btn-default refresh"><i class="fa fa-refresh"></i> Refresh</a> 
							</div>
						</div>
						<!--<div class="input-group margin-bottom">
		  					<input type="text" class="form-control" placeholder="Search Inbox">
		  					<span class="input-group-btn">
		  						<button class="btn btn-default" type="button">Search</button>
		  					</span> 
						</div>-->
		<!-- /input-group -->
						<div class="table-relative table-responsive">
							<table class="table table-condensed table-striped margin-0px">
								<thead>
								<tr>
									<th>
										<input id="all" type="checkbox" class="checkall" /><label for="all"></label>
									</th>
									<th colspan="2">Author</th>
									<th>Message Header</th>
									<th>Date</th>
									<th>Name</th>
								</tr>
								</thead>
								<tbody>
						<?php
								while($row = mysql_fetch_array($query))
								{
									$id  = $row['id'];
									$receive_id  = $row['receive_id'];
									//$receive_id = get_receive_id($row['receive_id']);
									$title = $row['title'];
									$message = $row['message'];
									$message_date = $row['message_date'];
									$mode = $row['mode'];
									
									$que = mysql_query("SELECT * FROM admin");
									while($rrr = mysql_fetch_array($que))
									{
										$name = $rrr['username'];
									}
						?>
	
								<tr class="unread">
									<td>
										<input type="hidden" name="table_id" value="<?php print $id; ?>"  />
										<div class="user-image"><img alt="User" src="http://placehold.it/150x150"/>
											<input id="<?php print $id; ?>" type="checkbox" class="checkbox" name="check-row" />
											<label for="1"></label>
										</div>
									</td>
									<td class="star"><a class="fa fa-flag flagged-grey"></a></td>
									<td>
										<input id="<?php print $id; ?>" type="submit" name="read" value="<?php print $title; ?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none; cursor:pointer; text-align:left; vertical-align:top; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
									</td>
									<td>
										<input id="<?php print $id; ?>" type="submit" name="read" value="<?php print $message; ?>" style=" width:150px; height:20px; background:none; border:none; box-shadow:none; cursor:pointer; vertical-align:top; text-align:left; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
									</td>
									<td> 
										<input id="<?php print $id; ?>" type="submit" name="read" value="<?php print $message_date; ?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none; cursor:pointer; text-align:left; vertical-align:top; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" /></small>
									</td>
									<td> 
										<input id="<?php print $id; ?>" type="submit" name="read" value="<?php print $name; ?>" style="width:150px; height:20px; background:none; border:none; box-shadow:none; cursor:pointer; text-align:left; vertical-align:top; <?php if($mode == 0) { ?> font-weight:bold; <?php } ?>" />
									</td>
								</tr>
						<?php
							}
						?>
							</table>
						</div>
						<div class="margin-top">
							<div class="padding-15px pull-left"><small>Showing: <?php print $num; ?></small></div>
							<ul class="pagination pagination-sm pull-right margin-0px">
								<li><a href="#">&laquo;</a></li>
								<li class="active"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">&raquo;</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="inbox-new-message">
			<div class="page-header"><h3>New Message<small>Compose New</small></h3></div>
			<form role="form">
			<div class="row">
				<div class="form-group col-md-4">
					<input type="email" class="form-control" id="exampleInputEmail1" placeholder="dazeincreative@gmail.com" disabled>
				</div>
				<div class="form-group col-md-4">
					<input type="email" class="form-control" id="exampleInputEmail2" placeholder="CC">
				</div>
				<div class="form-group col-md-4">
					<input type="email" class="form-control" id="exampleInputEmail3" placeholder="BCC">
				</div>
				<div class="form-group col-md-12">
					<input type="text" class="form-control" id="exampleInputPassword1" placeholder="Topic of Message">
				</div>
			</div>
			<div id="summernote">This is a Summernote editor</div>
			<button type="submit" class="btn btn-info">Send</button>
			<button type="submit" class="btn btn-default">Save as Draft</button>
			</form>
		</div>
	</div>
</div>
<!-- End Widget --> 
<?php  
}
else { print "<font style=\"color:#ff0000;font-weight:bold;\"><br />There is no information to show</font>";}
} ?>	