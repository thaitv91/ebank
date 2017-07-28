<?php
function display($pos,$page,$img,$user_name,$name,$parent_u_name,$parent_full_name,$mode,$position,$date,$left_child,$right_child,$gender)
{
?>
<link rel="stylesheet" type="text/css" href="../web_css/css_style1.css" />
<script type="text/javascript" src="../js/jquery.min.js"></script>
<?php
for($i = 0; $i < 15; $i++)
{
if($pos[$i] == '' && $pos[$i] == 0) { $img[$i] = "c"; }

} 
if($pos[0] != '')
{
	include("../function/all_child.php");
	include("../function/total_info_display.php");
	$childrens = give_all_children($pos[0]);
	//$total_left = count($childrens[0]);
	//$total_right = count($childrens[1]);
	$left_info = get_total_paid_unpaid_members($childrens[0]);
	$right_info = get_total_paid_unpaid_members($childrens[1]);
}
?>
<style>
  div#container {
	width: 580px;
	margin: 100px auto 0 auto;
	padding: 20px;
	background: #000;
	border: 1px solid #1a1a1a;
  }
  
  /* HOVER STYLES */
  div#pop-up0, #pop-up1, #pop-up2, #pop-up3, #pop-up4, #pop-up5, #pop-up6, #pop-up7, #pop-up8, #pop-up9, #pop-up10, #pop-up11, #pop-up12, #pop-up13, #pop-up14 {
	display: none;
	position:absolute;
	width:360px;
	padding:0;
	background: #eeeeee;
	color: #000000;
	border: 1px solid #ffffff;
	font-size: 90%;
  }
  
</style>
<script type="text/javascript">
  $(function() {
	var moveLeft = -400;
	var moveDown = -450;
	<?php for($tr = 0; $tr < 15; $tr++)
	{ ?>
	$('a#trigger<?=$tr; ?>').hover(function(e) {
	  $('div#pop-up<?=$tr; ?>').show();
	  //.css('top', e.pageY + moveDown)
	  //.css('left', e.pageX + moveLeft)
	  //.appendTo('body');
	}, function() {
	  $('div#pop-up<?=$tr; ?>').hide();
	});
	
	$('a#trigger<?=$tr; ?>').mousemove(function(e) {
	  $('div#pop-up<?=$tr; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
	});
	
	<?php } ?>
  });
  
</script>
<table class="table table-bordered">
	<tr>
		<td colspan="2">
			<table class="table table-bordered">
				<thead>
				<tr><th colspan="10">Legend</th></tr>
				<tr>
					<th class="text-center">Deactivate Member</th>
					<th class="text-center">Free Member</th>
					<th class="text-center">Paid Member</th>
					<th class="text-center">Blank Position </th>
					<th class="text-center">Block Member </th>
				</tr>
				</thead>
				<tr>
					<th class="text-center"><img src="images/d.png" /></th>
					<th class="text-center"><img src="images/f.png" /></th>
					<th class="text-center"><img src="images/p.png" /></th>
					<th class="text-center"><img src="images/c.png" /></th>
					<th class="text-center"><img src="images/b.png" /></th>
				</tr>
			</table>				
		</td>
	</tr>
	<tr>
		<td>
			<table class="table table-bordered">
				<thead>
				<tr>
					<th>Tree Count</th>
					<th class="text-center">Left</th>
					<th class="text-center">Right</th>
					<th class="text-center">Total</th>
				</tr>
				</thead>
				<tr>
					<th>Total Paid Members </th>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblLeftR"><?=$left_info[0]; ?></span>
					</td>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblRightR"><?=$right_info[0]; ?></span>
					</td>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblRightR">
							<?=$tp =$left_info[0]+$right_info[0]; ?>
						</span> 
					</td>
				</tr>
				<tr>
					<th>Total Unpaid Members </th>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblLeftB"><?=$left_info[1]; ?></span>
					</td>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblRightB"><?=$right_info[1]; ?></span>
					</td>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblRightR">
							<?=$tp =$left_info[1]+$right_info[1]; ?>
						</span> 
					</td>
				</tr>
				<tr>
					<th>Total Investment </th>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblLeftP"><?=$left_info[2]; ?></span>
					</td>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblRightP"><?=$right_info[2]; ?></span>
					</td>
					<td class="text-center">
						<span id="ctl00_ContentPlaceHolder1_lblRightR">
							<?=$tp =$left_info[2]+$right_info[2]; ?>
						</span> 
					</td>
				</tr>
				 <!--<tr>
				  <td> &nbsp;&nbsp;&nbsp;Block Members </td>
				  <td><span id="ctl00_ContentPlaceHolder1_lblLeftP">&nbsp;&nbsp;&nbsp;4</span> </td>
				  <td><span id="ctl00_ContentPlaceHolder1_lblRightP">&nbsp;&nbsp;&nbsp;0</span> </td>
				</tr>
			   <tr class="MyFooter">
				  <td> <strong>&nbsp;&nbsp;&nbsp;Total </strong></td>
				  <td><strong> &nbsp;&nbsp;&nbsp;6 </strong></td>
				  <td><strong> &nbsp;&nbsp;&nbsp;0 </strong></td>
				</tr>-->
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" valign="top">
			<table class="table table-borderless">
				<tr>
					<td>
					<?php
					for($tcd = 0; $tcd < 15; $tcd++)
					{
						if($pos[$tcd] != 0) 
						{ ?>									
						<div id="pop-up<?=$tcd; ?>">	
							<table class="table table-bordered">
								<thead>
								<tr>
									<th colspan="4">Date Of Joining : <?=$date[$tcd]; ?></th>
								</tr>
								</thead>
								<tr>
									<th>Distributor ID </th>
									<td colspan="3"><?=$user_name[$tcd]; ?></td>
								</tr>
								<tr>
									<th>Distributor Name</th>
									<td colspan="3"><?=$name[$tcd]; ?></td>
								</tr>
								<tr>
									<th>Sponsor ID </th>
									<td colspan="3"><?=$parent_u_name[$tcd]; ?></td>
								</tr>
								<tr>
									<th>Sponsor Name</th>
									<td colspan="3"><?=$parent_full_name[$tcd]; ?></td>
								</tr>
								
								<tr>
									<th>Total Left ID</th>
									<td><?=$left_child[$tcd]; ?></td>
									<th>Total Right ID</th>
									<td><?=$right_child[$tcd]; ?></td>
								</tr>
							</table>
						</div>
	
				<?php 	} 
					} ?>		
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<div align="center"> 
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[0]; ?>"  />
							<a id="trigger0">
								<input type="submit" name="tree" style="background:url(images/<?=$img[0]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[0]; ?></B>
							</a>
						</form>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="8">
						<div align="center"><img src="images/band1.gif" width="550" height="35" /></div>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[1]; ?>"  />
							<a id="trigger1">
								<input type="submit" name="tree" style="background:url(images/<?=$img[1]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[1]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td colspan="4">
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[2]; ?>"  />
							<a id="trigger2">	
								<input type="submit" name="tree" style="background:url(images/<?=$img[2]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[2]; ?></B>
							</a>
						</form>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="4">
						<div align="center"><img src="images/band2.gif" width="325" height="35" /></div>
					</td>
					<td colspan="4">
						<div align="center"><img src="images/band2.gif" width="325" height="35" /></div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[3]; ?>"  />
							<a id="trigger3">
								<input type="submit" name="tree" style="background:url(images/<?=$img[3]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[3]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td colspan="2">
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[4]; ?>"  />
							<a id="trigger4">
								<input type="submit" name="tree" style="background:url(images/<?=$img[4]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[4]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td colspan="2">
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[5]; ?>"  />
							<a id="trigger5">	
								<input type="submit" name="tree" style="background:url(images/<?=$img[5]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[5]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td colspan="2">
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[6]; ?>"  />
							<a id="trigger6">
								<input type="submit" name="tree" style="background:url(images/<?=$img[6]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[6]; ?></B>
							</a>
						</form>
						</div>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div align="center"><img src="images/band4.gif" width="125" height="35" /></div>
					</td>
					<td colspan="2">
						<div align="center"><img src="images/band4.gif" width="125" height="35" /></div>
					</td>
					<td colspan="2">
						<div align="center"><img src="images/band4.gif" width="125" height="35" /></div>
					</td>
					<td colspan="2">
						<div align="center"><img src="images/band4.gif" width="125" height="35" /></div>
					</td>
				</tr>
				<tr>
					<td>
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
						<input type="hidden" name="id" value="<?=$pos[7]; ?>"  />
							<a id="trigger7">
								<input type="submit" name="tree" style="background:url(images/<?=$img[7]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[7]; ?></B>
							</a>
						</form>
						</div>
								
					</td>
					<td>
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
						<input type="hidden" name="id" value="<?=$pos[8]; ?>"  />
							<a id="trigger8">
								<input type="submit" name="tree" style="background:url(images/<?=$img[8]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[8]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td>
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[9]; ?>"  />
							<a id="trigger9">
								<input type="submit" name="tree" style="background:url(images/<?=$img[9]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[9]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td>
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[10]; ?>"  />
							<a id="trigger10">
								<input type="submit" name="tree" style="background:url(images/<?=$img[10]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[10]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td>
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[11]; ?>"  />
							<a id="trigger11">
								<input type="submit" name="tree" style="background:url(images/<?=$img[11]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[11]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td>
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[12]; ?>"  />
							<a id="trigger12">
								<input type="submit" name="tree" style="background:url(images/<?=$img[12]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[12]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td>
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[13]; ?>"  />
							<a id="trigger13">
								<input type="submit" name="tree" style="background:url(images/<?=$img[13]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[13]; ?></B>
							</a>
						</form>
						</div>
					</td>
					<td>
						<div align="center">
						<form name="tree_v" action="index.php?page=tree_view" method="post">
							<input type="hidden" name="id" value="<?=$pos[14]; ?>"  />
							<a id="trigger14">
								<input type="submit" name="tree" style="background:url(images/<?=$img[14]; ?>.png) no-repeat; height:52px; width:60px; border:none" value=""/><br />
								<B><?=$user_name[14]; ?></B>
							</a>
						</form>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>		
<?php } 

function display_member($pos,$page,$img,$user_name,$parent_u_name,$name,$mode,$position,$date,$left_child,$right_child,$gender)
{
	for($i = 0; $i < 3; $i++)
	{
	if($pos[$i] == '' && $pos[$i] == 0) { $img[$i] = "c"; }
	} 
?>
</center>

<link rel="stylesheet" type="text/css" href="web_css/css_style1.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<?php
for($i = 0; $i < 3; $i++)
{
	if($pos[$i] == '' && $pos[$i] == 0) { $img[$i] = "c"; }
} 
?>
<style>
  div#container {
	width: 580px;
	margin: 100px auto 0 auto;
	padding: 20px;
	background: #000;
	border: 1px solid #1a1a1a;
  }
  
  /* HOVER STYLES */
  div#pop-up0, #pop-up1, #pop-up2, #pop-up3, #pop-up4, #pop-up5, #pop-up6, #pop-up7, #pop-up8, #pop-up9, #pop-up10, #pop-up11, #pop-up12, #pop-up13, #pop-up14 {
	display: none;
	position:absolute;
	width:360px;
	padding:0;
	background: #eeeeee;
	color: #000000;
	border: 1px solid #ffffff;
	font-size: 90%;
  }
  
</style>
<script type="text/javascript">
  $(function() {
	var moveLeft = 20;
	var moveDown = 10;
	<?php for($tr = 0; $tr < 3; $tr++)
	{ ?>
	$('a#trigger<?=$tr; ?>').hover(function(e) {
	  $('div#pop-up<?=$tr; ?>').show();
	  //.css('top', e.pageY + moveDown)
	  //.css('left', e.pageX + moveLeft)
	  //.appendTo('body');
	}, function() {
	  $('div#pop-up<?=$tr; ?>').hide();
	});
	
	$('a#trigger<?=$tr; ?>').mousemove(function(e) {
	  $('div#pop-up<?=$tr; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
	});
	
	<?php } ?>
  });
  
</script>

<table class="table table-bordered">
	<tr>
		<td>
		<?php
		for($tcd = 0; $tcd < 3; $tcd++)
		{
			if($pos[$tcd] != 0) 
			{ ?>																		
			<div id="pop-up<?=$tcd; ?>">	
			<table class="table table-bordered">
				<tr><th colspan="4">Date Of Joining : <?=$date[$tcd]; ?></th></tr>
				<tr>
					<td width="113">Distributor ID </td>
					<td colspan="3"><?=$user_name[$tcd]; ?></td>
				</tr>
				<tr>
					<td>Distributor Name</td>
					<td colspan="3"><?=$name[$tcd]; ?></td>
				</tr>
				<tr>
					<td>Sponsor ID </td>
					<td colspan="3"><?=$parent_u_name[$tcd]; ?></td>
				</tr>
				<tr>
					<td>Sponsor Name</td>
					<td colspan="3"><?=$parent_full_name[$tcd]; ?></td>
				</tr>
				<tr>
					<td>Total Left ID</td>
					<td width="50"><?=$left_child[$tcd]; ?></td>
					<td width="125">Total Right ID </td>
					<td width="50"><?=$right_child[$tcd]; ?></td>
				</tr>
			</table>
			</div>
	<?php 	} 
		} ?>		
		</td>
	</tr>
	<tr>
		<td colspan="8">
			<div align="center">
				<a href="index.php?page=search-member&id=<?=$pos[0]; ?>" id="trigger0">
					<img src="images/<?=$img[0]; ?>.png" width="76" height="76" />
				</a><br />
				<a href="index.php?page=search-member&id=<?=$pos[0]; ?>" id="trigger0">
					<B><?=$user_name[0]; ?></B>
				</a>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="8">
			<div align="center"><img src="images/band1.gif" width="470" height="35" /></div>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<div align="center">
				<a href="index.php?page=search-member&id=<?=$pos[1]; ?>" id="trigger1">
					<img src="images/<?=$img[1]; ?>.png" width="76" height="76" />
				</a><br />
				<a href="index.php?page=search-member&id=<?=$pos[1]; ?>" id="trigger1">
					<B><?=$user_name[1]; ?></B>
				</a>
			</div>
		</td>
		<td colspan="4">
			<div align="center">
				<a href="index.php?page=search-member&id=<?=$pos[2]; ?>" id="trigger2">
					<img src="images/<?=$img[2]; ?>.png" width="76" height="76" />
				</a><br />
				<a href="index.php?page=search-member&id=<?=$pos[2]; ?>" id="trigger2">
					<B><?=$user_name[2]; ?></B>
				</a>
			</div>
		</td>
	</tr>
</table>
<?php } ?>