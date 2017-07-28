<?php

function display($pos,$page,$img,$user_name,$name,$parent_u_name,$parent_full_name,$mode,$position,$date,$act_date,$left_child,$right_child,$gender,$approved_investment,$full_investment)
{
?>
<link rel="stylesheet" type="text/css" href="web_css/css_cstyle1.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<?php
	for($i = 0; $i < 15; $i++)
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
	<?php	if($tr == 2 or $tr == 5 or $tr == 6 or $tr > 10)
		{ ?>	
        	$('div#pop-up<?=$tr; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + (-410));
	<?php	}
		else
		{ ?>
			$('div#pop-up<?=$tr; ?>').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
	<?php	} ?>	  
        });
		
		<?php } ?>
      });
	  
	</script>
	<center>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
 		<tr>
            <td height="55" colspan="2" class="in_inner_title1"><h2 align="left">Tree Structure</h2> </td>
        </tr>
<!--		<tr>
			<td height="1" colspan="2" valign="top" bgcolor="#E9EDF0"></td>
		</tr>
-->		<tr><td height="1" colspan="2" valign="top" bgcolor="#ffffff"></td>
							  </tr>
		<tr>
            <td height="40" colspan="2" valign="top" class="in_inner_txt1">
				<table class="MyTable" border="0" bordercolor="#FFFFFF" style="border-collapse:collapse; margin:6px;" cellpadding="0" cellspacing="0" width="99%" >
                                  <tbody>
                                    <tr class="MyTitle">
                                      <td height="30" colspan="10" bgcolor="#E3E8EC" style="color:#0189B0;"> &nbsp;&nbsp;&nbsp;<strong>Legend </strong></td>
                                    </tr>
                                    <tr>
									<!--  <td width="13%"> &nbsp;&nbsp;Deactivate Member </td>
                                      <td width="9%"><img src="images/d.png" /></td>-->
                                      <td width="13%" height="60"> &nbsp;&nbsp;Free Member</td>
                                      <td width="9%"><img src="images/f.png" /></td>
                                     <!-- <td width="13%"> &nbsp;&nbsp;Paid Member</td>
                                      <td width="9%"><img src="images/p.png" /></td>-->
                                      <td width="13%"> &nbsp;&nbsp;Blank Position </td>
                                      <td width="10%"><img src="images/c.png" /></td>
									  <td width="13%"> &nbsp;&nbsp;Block Member </td>
                                      <td width="10%"><img src="images/b.png" /></td>
                                    </tr>
                                  </tbody>
                                </table>				
			</td>
        </tr>
		<tr>
            <td width="51%" height="40" valign="middle" class="in_inner_txt1">
				<!--<table class="MyTable" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse; margin:6px;" cellpadding="0" cellspacing="0" width="99%">
                                  <tbody>
                                    <tr class="MyTitle">
                                      <td width="40%" height="30" bgcolor="#E3E8EC" style="color:#0189B0;"><strong> &nbsp;&nbsp;&nbsp;Tree Count</strong></td>
                                      <td width="20%" bgcolor="#E3E8EC" style="color:#0189B0;"><strong> &nbsp;&nbsp;&nbsp;Left </strong></td>
                                      <td width="20%" bgcolor="#E3E8EC" style="color:#0189B0;"><strong> &nbsp;&nbsp;&nbsp;Right </strong></td>
									  <td width="20%" bgcolor="#E3E8EC" style="color:#0189B0;"><strong> &nbsp;&nbsp;&nbsp;Total </strong></td>
                                    </tr>
                                    <tr>
                                      <td> &nbsp;&nbsp;&nbsp;Total Paid Members </td>
                                      <td><span id="ctl00_ContentPlaceHolder1_lblLeftR">&nbsp;&nbsp;&nbsp;<?=$left_info[0]; ?></span> </td>
                                      <td><span id="ctl00_ContentPlaceHolder1_lblRightR">&nbsp;&nbsp;&nbsp;<?=$right_info[0]; ?></span> </td>
									  <td><span id="ctl00_ContentPlaceHolder1_lblRightR">&nbsp;&nbsp;&nbsp;<?=$tp =$left_info[0]+$right_info[0]; ?></span> </td>
                                    </tr>
                                    <tr>
                                      <td> &nbsp;&nbsp;&nbsp;Total Unpaid Members </td>
                                      <td><span id="ctl00_ContentPlaceHolder1_lblLeftB">&nbsp;&nbsp;&nbsp;<?=$left_info[1]; ?></span> </td>
                                      <td><span id="ctl00_ContentPlaceHolder1_lblRightB">&nbsp;&nbsp;&nbsp;<?=$right_info[1]; ?></span> </td>
									  <td><span id="ctl00_ContentPlaceHolder1_lblRightR">&nbsp;&nbsp;&nbsp;<?=$tp =$left_info[1]+$right_info[1]; ?></span> </td>
                                    </tr>
									<tr>
                                      <td> &nbsp;&nbsp;&nbsp;Total Investment </td>
                                      <td><span id="ctl00_ContentPlaceHolder1_lblLeftP">&nbsp;&nbsp;&nbsp;<?=$left_info[2]; ?></span> </td>
                                      <td><span id="ctl00_ContentPlaceHolder1_lblRightP">&nbsp;&nbsp;&nbsp;<?=$right_info[2]; ?></span> </td>
									  <td><span id="ctl00_ContentPlaceHolder1_lblRightR">&nbsp;&nbsp;&nbsp;<?=$tp =$left_info[2]+$right_info[2]; ?></span> </td>
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
                                    </tr>
                                  </tbody>
                                </table>-->
			</td>
                            
        </tr>
		<tr>
            <td height="40" colspan="2" valign="top" class="binary_tree_txt">
				<table  style="width:960px;" height="550" border="0" cellspacing="0" cellpadding="0" align="center">
                                   <br /><br />
								   <tr>
								   	<td>
<?php
for($tcd = 0; $tcd < 15; $tcd++)
{
	if($pos[$tcd] != 0) { ?>									
									
<div id="pop-up<?=$tcd; ?>" style="width:400px;">	
<table class="MyTable" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse; margin:6px;" cellpadding="0" cellspacing="0" width="388" >
		<tr>
            <td height="25" align="center" bgcolor="#E3E8EC"><p><strong>Date Of Joining : </strong><strong><?=$date[$tcd]; ?></strong></p></td>
			<td height="25" align="center" width="150"  colspan="2" bgcolor="#E3E8EC"><p><strong>Paid Commitment : <?=$approved_investment[$tcd]; ?> <font color=dark>$ </font></strong></p></td>
          </tr>
		  <tr>
            <td style="padding-left:10px;">Activation Date</td>
            <td colspan="2" style="padding-left:10px;"><?=$act_date[$tcd]; ?></td>
          </tr>	
          <tr>
            <td width="113" style="padding-left:10px;">Distributor ID </td>
            <td colspan="2" style="padding-left:10px;"><?=$user_name[$tcd]; ?></td>
            </tr>
          <tr>
            <td style="padding-left:10px;">Distributor Name</td>
            <td colspan="2" style="padding-left:10px;"><?=$name[$tcd]; ?></td>
          </tr>
          <tr>
            <td style="padding-left:10px;">Sponsor ID </td>
            <td colspan="2" style="padding-left:10px;"><?=$parent_u_name[$tcd]; ?></td>
            </tr>
          <tr>
            <td style="padding-left:10px;">Sponsor Name</td>
            <td colspan="2" style="padding-left:10px;"><?=$parent_full_name[$tcd]; ?></td>
            </tr>
           <tr>
            <td style="padding-left:10px;"> Commitment</td>
            <td colspan="2" style="padding-left:10px;"><?=$full_investment[$tcd]; ?> <font color=dark>$ </font></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="50" align="center">Left</td>
			<td width="50" align="center">Right</td>
          </tr>
		  <tr>
            <td style="padding-left:10px;">Members</td>
            <td width="50" align="center"><?=$left_child[$tcd][0]; ?> Members</td>
			<td width="50" align="center"><?=$right_child[$tcd][0]; ?> Members</td>
          </tr>
		  <tr>
            <td style="padding-left:10px;">Approved Commitment</td>
            <td width="50" style="text-align:right; padding-right:10px;"><?=$left_child[$tcd][1]; ?> <font color=dark>$ </font></td>
			<td width="50" style="text-align:right; padding-right:10px;"><?=$right_child[$tcd][1]; ?> <font color=dark>$ </font></td>
          </tr>
		  <tr>
            <td style="padding-left:10px;">Total Commitment</td>
            <td width="50" style="text-align:right; padding-right:10px;"><?=$left_child[$tcd][4]; ?> <font color=dark>$ </font></td>
			<td width="50" style="text-align:right; padding-right:10px;"><?=$right_child[$tcd][4]; ?> <font color=dark>$ </font></td>
          </tr>
		  
		  <!-- <tr>
            <td style="padding-left:10px;">Link Sent</td>
            <td width="50" style="text-align:right; padding-right:10px;"><?=$left_child[$tcd][2]; ?> <font color=dark>$ </font></td>
			<td width="50" style="text-align:right; padding-right:10px;"><?=$right_child[$tcd][2]; ?> <font color=dark>$ </font></td>
          </tr>
		  <tr>
            <td style="padding-left:10px;">Pending Help</td>
            <td width="50" style="text-align:right; padding-right:10px;"><?=$left_child[$tcd][3]; ?> <font color=dark>$ </font></td>
			<td width="50" style="text-align:right; padding-right:10px;"><?=$right_child[$tcd][3]; ?> <font color=dark>$ </font></td>
          </tr>
        <tr>
            <td height="25" colspan="4" bgcolor="#E3E8EC"><p><strong>SelfTopUp&nbsp; :</strong><strong> 10000 </strong></p></td>
            </tr>
          <tr>
            <td>Total Left TopUpAmount </td>
            <td>20000</td>
            <td>Total Right TopUpAmount</td>
            <td>20000</td>
          </tr>
          <tr>
            <td>Total Left Alpha TopUpAmount </td>
            <td>10000.00</td>
            <td>Total Right Alpha TopUpAmount</td>
            <td>10000.00</td>
          </tr>
          <tr>
            <td>Total Left Beta TopUpAmount </td>
            <td>10000.00</td>
            <td>Total Right Beta TopUpAmount</td>
            <td>10000.00</td>
          </tr>-->
        </table>
</div>

<?php } } ?>		
   									</td>
								   </tr>
								  <tr>
                                    <td colspan="8" style="padding-top:5px;text-align:center;">
									<a id="trigger0">  	
									<form name="tree_v" action="index.php?page=tree_view" method="post">
										<input type="hidden" name="id" value="<?=$pos[0]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[0]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									
									</a> <br />
                                        <strong><a id="trigger0"><?=$user_name[0]; ?></a></strong></div> 
										</form>
 									</td>
                                  </tr>
                                  <tr>
                                    <td colspan="8"><div align="center"><img src="images/band1.gif" width="550" height="35" /></div></td>
                                  </tr>
                                  <tr>
                                    <td colspan="4" style="width:480px; height:100px; padding-top:10px; vertical-align:top;text-align:center;">
									<?php
									if($pos[1] > 0)
									{ ?>
 									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger1">	
										<input type="hidden" name="id" value="<?=$pos[1]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[1]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;; cursor:pointer;" value=""/></a>
																			
									<br />
                                        <strong><a id="trigger1"><?=$user_name[1]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[0] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[0]; ?>"  />
										<input type="hidden" name="reg_position" value="0"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[1]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                       <strong><a>New Joining</a></strong>
									</form>
									<?php
									} 
									else
									{ ?>
										<img src="images/<?=$img[1]; ?>.png"  />
									
									<?php } ?>
									
									  </td>
                                    <td colspan="4" style="width:480px; height:100px; padding-top:10px; vertical-align:top;text-align:center;">
									<?php
									if($pos[2] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger2">	
										<input type="hidden" name="id" value="<?=$pos[2]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[2]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[2]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[0] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[0]; ?>"  />
										<input type="hidden" name="reg_position" value="1"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[2]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong>
									</form>
									<?php
									} 
									else
									{ ?>
										<img src="images/<?=$img[2]; ?>.png"  />
									
									<?php } ?>
										
									</td>
                                  </tr>
                                  <tr>
                                    <td colspan="4"><div align="center"><img src="images/band2.gif" width="325" height="35" /></div></td>
                                    <td colspan="4"><div align="center"><img src="images/band2.gif" width="325" height="35" /></div></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" style="width:240px; height:100px; padding-top:10px; vertical-align:top;text-align:center;">
									<?php
									if($pos[3] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger3">	
										<input type="hidden" name="id" value="<?=$pos[3]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[3]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[3]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[1] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[1]; ?>"  />
										<input type="hidden" name="reg_position" value="0"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[3]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[4]; ?>.png"  />
									
									<?php } ?>
									
										</td>
                                    <td colspan="2" style="width:240px; height:100px; padding-top:10px; vertical-align:top;text-align:center;">
									<?php
									if($pos[4] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger4">	
										<input type="hidden" name="id" value="<?=$pos[4]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[4]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[4]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[1] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[1]; ?>"  />
										<input type="hidden" name="reg_position" value="1"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[4]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[4]; ?>.png"  />
									
									<?php } ?>
									
									</td>
                                    <td colspan="2" style="width:240px; height:100px; padding-top:10px; vertical-align:top;text-align:center;">
									<?php
									if($pos[5] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger5">	
										<input type="hidden" name="id" value="<?=$pos[5]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[5]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[5]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[2] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[2]; ?>"  />
										<input type="hidden" name="reg_position" value="0"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[5]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[5]; ?>.png"  />
									
									<?php } ?>
									
									</td>
                                    <td colspan="2" style="width:240px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">
									<?php
									if($pos[6] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger6">	
										<input type="hidden" name="id" value="<?=$pos[6]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[6]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[6]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[2] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[2]; ?>"  />
										<input type="hidden" name="reg_position" value="1"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[6]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[6]; ?>.png"  />
									
									<?php } ?>
									</td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><div align="center"><a href="#"><img src="images/band4.gif" width="125" height="35" /></a></div></td>
                                    <td colspan="2"><div align="center"><a href="#"><img src="images/band4.gif" width="125" height="35" /></a></div></td>
                                    <td colspan="2"><div align="center"><a href="#"><img src="images/band4.gif" width="125" height="35" /></a></div></td>
                                    <td colspan="2"><div align="center"><a href="#"><img src="images/band4.gif" width="125" height="35" /></a></div></td>
                                  </tr>
                                  <tr>
                                    <td style="width:120px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">

									<?php
									if($pos[7] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger7">	
										<input type="hidden" name="id" value="<?=$pos[7]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[7]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[7]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[3] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[3]; ?>"  />
										<input type="hidden" name="reg_position" value="0"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[7]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[7]; ?>.png"  />
									
									<?php } ?>
								
									</td>
                                    <td style="width:120px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">
									<?php
									if($pos[8] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger8">	
										<input type="hidden" name="id" value="<?=$pos[8]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[8]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[8]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[3] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[3]; ?>"  />
										<input type="hidden" name="reg_position" value="1"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[8]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[8]; ?>.png"  />
									
									<?php } ?>
									</td>
                                    <td style="width:120px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">
									<?php
									if($pos[9] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger9">	
										<input type="hidden" name="id" value="<?=$pos[9]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[9]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[9]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[4] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[4]; ?>"  />
										<input type="hidden" name="reg_position" value="0"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[9]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[9]; ?>.png"  />
									
									<?php } ?>
									</td>
                                    <td style="width:120px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">
									
									<?php
									if($pos[10] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger10">	
										<input type="hidden" name="id" value="<?=$pos[10]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[10]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[10]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[4] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[4]; ?>"  />
										<input type="hidden" name="reg_position" value="1"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[10]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[10]; ?>.png"  />
									
									<?php } ?>
									
									
									</td>
                                    <td style="width:120px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">
									<?php
									if($pos[11] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger11">	
										<input type="hidden" name="id" value="<?=$pos[11]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[11]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[11]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[5] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[5]; ?>"  />
										<input type="hidden" name="reg_position" value="0"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[11]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[11]; ?>.png"  />
									
									<?php } ?>
									
									</td>
                                    <td style="width:120px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">
									
									<?php
									if($pos[12] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger12">	
										<input type="hidden" name="id" value="<?=$pos[12]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[12]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[12]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[5] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[5]; ?>"  />
										<input type="hidden" name="reg_position" value="1"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[12]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[12]; ?>.png"  />
									
									<?php } ?>
									
									</td>
                                    <td style="width:120px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">
									<?php
									if($pos[13] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger13">	
										<input type="hidden" name="id" value="<?=$pos[13]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[13]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[13]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[6] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[6]; ?>"  />
										<input type="hidden" name="reg_position" value="0"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[13]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[13]; ?>.png"  />
									
									<?php } ?>
									
									</td>
                                    <td style="width:120px; height:100px; padding-top:10px; vertical-align:top; text-align:center;">
									<?php
									if($pos[14] > 0)
									{ ?>
									<form name="tree_v" action="index.php?page=tree_view" method="post">
									<a id="trigger14">	
										<input type="hidden" name="id" value="<?=$pos[14]; ?>"  />
										<input type="submit" name="tree" style="background:url(images/<?=$img[14]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/></a>
									<br />
                                        <strong><a id="trigger2"><?=$user_name[14]; ?></a></strong>
									</form>
									<?php
									}
									elseif($pos[6] > 0)
									{  ?>
									<form name="tree_v" action="register.php" target="_new" method="post">
										<input type="hidden" name="reg_placement_id" value="<?=$pos[6]; ?>"  />
										<input type="hidden" name="reg_position" value="1"  />
										<input type="hidden" name="reg_realparent_id" value="<?=$_SESSION['ebank_user_id']; ?>"  />
										<input type="submit" name="tree_reg" style="background:url(images/<?=$img[14]; ?>.png) no-repeat; height:80px; width:60px; border:none; cursor:pointer;" value=""/>
									</a><br />
                                        <strong><a>New Joining</a></strong></div>
									</form>
									<?php
									}
									else
									{ ?>
										<img src="images/<?=$img[14]; ?>.png"  />
									
									<?php } ?>
									
									</td>
                                  </tr>
                                  
								  
                                </table>
			</td>
			</tr>
			<tr>
			<td height="100">&nbsp;</td>
			</tr>
	</table>		
								</center>
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
        width: 590px;
        margin: 100px auto 0 auto;
        padding: 20px;
        background: #000;
        border: 1px solid #1a1a1a;
      }
      
      /* HOVER STYLES */
      div#pop-up0, #pop-up1, #pop-up2, #pop-up3, #pop-up4, #pop-up5, #pop-up6, #pop-up7, #pop-up8, #pop-up9, #pop-up10, #pop-up11, #pop-up12, #pop-up13, #pop-up14 {
        display: none;
        position:absolute;
        width:400px;
        padding:0;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #ffffff;
        font-size: 90%;
      }
      
    </style>
    <script type="text/javascript">
      $(function() {
        var moveLeft = -200;
        var moveDown = -200;
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
						<th>Distributor ID </th>
						<td><?=$user_name[$tcd]; ?></td>
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
						<td><?=$left_child[$tcd];?></td>
						<td>Total Right ID </td>
						<td><?=$right_child[$tcd];?></td>
					</tr>
					 <!--<tr><td colspan="4">SelfTopUp&nbsp; :10000</td></tr>
					  <tr>
						<td>Total Left TopUpAmount </td>
						<td>20000</td>
						<td>Total Right TopUpAmount</td>
						<td>20000</td>
					  </tr>
					  <tr>
						<td>Total Left Alpha TopUpAmount </td>
						<td>10000.00</td>
						<td>Total Right Alpha TopUpAmount</td>
						<td>10000.00</td>
					  </tr>
					  <tr>
						<td>Total Left Beta TopUpAmount </td>
						<td>10000.00</td>
						<td>Total Right Beta TopUpAmount</td>
						<td>10000.00</td>
					  </tr>-->
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
					<img src="images/<?=$img[0]; ?>.png" width="76" height="76" /><br />
					<B><?=$user_name[0]; ?></B>
				</a>
			</div>
		</td>
	</tr>
	<tr><td colspan="8"><div align="center"><img src="images/band1.gif" width="530" /></div></td></tr>
	<tr>
		<td colspan="4">
			<div align="center">
				<a href="index.php?page=search-member&id=<?=$pos[1]; ?>" id="trigger1">
					<img src="images/<?=$img[1]; ?>.png" width="76" height="76" /><br />
					<B><?=$user_name[1]; ?></B>
				</a>
			</div>
		</td>
		<td colspan="4">
			<div align="center">
				<a href="index.php?page=search-member&id=<?=$pos[2]; ?>" id="trigger2">
					<img src="images/<?=$img[2]; ?>.png" width="76" height="76" /><br />
					<B><?=$user_name[2]; ?></B>
				</a>
			</div>
		</td>
	</tr>
</table>
<?php } ?>