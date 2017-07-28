<?php 
function tree_member($level,$id)
{	
	$photo = get_user_photo($id);
	$field = $qu = $group_by = "";
	for($i = 1; $i < $level+1; $i++)
	{
		$j = $i+1;
		if($i==1){
			$field .= "t$j.email AS lev$i,t$j.id_user AS lev$i"."_id,t$j.f_name AS lev$i"."_fname,t$j.l_name AS lev$i"."_lname";
			$group_by .= "t$i.id_user";
		}
		else{
			$field .= ",t$j.email AS lev$i,t$j.id_user AS lev$i"."_id,t$j.f_name AS lev$i"."_fname,t$j.l_name AS lev$i"."_lname";
			$group_by .= ",t$i.id_user";
		}
			
		$qu .= "LEFT JOIN users AS t$j"." ON t$j."."real_parent = t$i.id_user ";
		 
	}
	$pp = $level+1;
	 $sql = "select ".$field." from users as t1 ".$qu." where t1.id_user='$id' group by ".$group_by.",t$pp.id_user";
	/*$sql = "select t2.username as lev1,t3.username as lev2,t4.username as lev3,t5.username as lev4
				from users as t1
				LEFT JOIN users AS t2 ON t2.real_parent = t1.id_user
				LEFT JOIN users AS t3 ON t3.real_parent = t2.id_user  
				LEFT JOIN users AS t4 ON t4.real_parent = t3.id_user
				LEFT JOIN users AS t5 ON t5.real_parent = t4.id_user
				where t1.id_user='$id'
				group by t1.id_user, t2.id_user, t3.id_user, t4.id_user, t5.id_user
				";*/
	$query = mysql_query($sql);
	if(mysql_num_rows($query) > 0)
	{	
		for($mm = 1; $mm < $level+1; $mm++)
		{
			$fld_lev = "level".$mm."_array";
			$$fld_lev = array();
		}
		echo "<table width=\"750\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"left\">";
		?>	<tr>
				<td rowspan="2"><img src="images/profile_image/<?=$photo;?>" width="100px" /></td>
				<td colspan="<?=$level+1?>" align="center" style="font-weight:bold; color:#000070;font-size: 11pt;">
				<img src="images/Title9.gif" />&nbsp;<?= get_parent_username($id);?>&nbsp;<img src="images/genealogy.gif" align="middle" /> &nbsp; Downline</td>
			</tr>
			<tr>
				<td align="left" colspan="<?=$level+1?>"><span style="padding-left:16px; float:left;">Your Downline is listed below for up to <?= $level;?> levels. Click any member's name to view up to <?= $level;?> more levels below them. The purple dates below are when the member joined and last visited.</span>
				</td>
			</tr>
			<tr>
				<td colspan="<?=$level+1?>" align="center">
					<div>
						<form action=""  method="post" lang="en" runat="server">
						<select name="level" onchange="this.form.submit();">
						<?php 
						for($i = 1; $i < 6; $i++)
						{
						?>
							<option value="<?= $i;?>" <?php  if($level == $i){print 'selected="selected"';} ?> ><?= $i;?> Level</option>
						
						<?php 
						}
						?>
						</select>
						<noscript><input type="submit" value="View" name="view" id="view" onClick="viewmember()" />
						<input type="text" value="" name="username" placeholder="Username" />
						<input type="submit" value="Search" name="search" /></noscript>
						</form>
					</div>
				</td>
			</tr>	
		<?php 
		
		$kk = 1;
		while($row = mysql_fetch_array($query))
		{
			$colspan = $level+1;
			$kk = $kk +1;
			for($mm = 1; $mm < ($level+1); $mm++)
			{
				$fld_lev = "lev$mm";
				$$fld_lev = '';
				$$fld_lev = $row[$fld_lev];
			}
			if($lev1 == NULL)
			{
				echo "<tr><td colspan=\"$level+1\" style=\"text-align:center;\">You Have No Down-Line</td></tr>";
			}
			else{	
					$td = "<td width=3%>&nbsp;</td>";
					for($i = 1; $i <= $kk+1; $i++)
					{
						//print $kk."<br>";
						$lev = 'level'.$i.'_array';
						$levv = "lev".$i;
				//		echo $$levv,",",$lev,"<br>";
						
						if(!in_array($$levv,$$lev))
						{
							if($$levv != NULL){
							$level_id = $row['lev'.$i.'_id'];
						
							$info = "(".$row['lev'.$i.'_fname']."&nbsp;".$row['lev'.$i.'_lname'].")";
							echo "<tr><td width=6%><div class=level_start>$i</div></td>";
								for($j = 1; $j < $i; $j++)
								{
									echo $td;
								}
							echo "<td colspan=".($colspan)." style='text-align:left;'>
									".$$levv."
									&nbsp;<img src=\"images/genealogy.gif\" align=\"middle\" /> &nbsp;$info
								</td></tr>";
/*							echo "<td colspan=".($colspan)." style='text-align:left;'>
								<a href=# onclick=module(".$level_id.",$i,$level) >".$$levv."</a>
								&nbsp;<img src=\"images/genealogy.gif\" align=\"middle\" /> &nbsp;$info
							</td></tr>";       this is show up-level
*/							$arr = 'level'.$i.'_array';
							$h= $i-1;
							$$arr = array($h => $row['lev'.$i]);
							
							}
						}$colspan=$colspan-1;
						
					}
					
			}
		}
		echo "</table>";
		
	}
	else
	{
		echo "You Have No Down-Line";
	}
}

function ajax_tree_member($level,$step_lev_inc,$id)
{	
	
	$field = $qu = $group_by = "";
	for($i = 1; $i < $level+1; $i++)
	{
		$j = $i+1;
		if($i==1){
			$field .= "t$j.email AS lev$i,t$j.id_user AS lev$i"."_id,t$j.f_name AS lev$i"."_fname,t$j.l_name AS lev$i"."_lname";
			$group_by .= "t$i.id_user";
		}
		else{
			$field .= ",t$j.email AS lev$i,t$j.id_user AS lev$i"."_id,t$j.f_name AS lev$i"."_fname,t$j.l_name AS lev$i"."_lname";
			$group_by .= ",t$i.id_user";
		}
			
		$qu .= "LEFT JOIN users AS t$j"." ON t$j."."real_parent = t$i.id_user ";
		 
	}
	$pp = $level+1;
	 $sql = "select ".$field." from users as t1 ".$qu." where t1.id_user='$id' group by ".$group_by.",t$pp.id_user";
	/*$sql = "select t2.username as lev1,t3.username as lev2,t4.username as lev3,t5.username as lev4
				from users as t1
				LEFT JOIN users AS t2 ON t2.real_parent = t1.id_user
				LEFT JOIN users AS t3 ON t3.real_parent = t2.id_user  
				LEFT JOIN users AS t4 ON t4.real_parent = t3.id_user
				LEFT JOIN users AS t5 ON t5.real_parent = t4.id_user
				where t1.id_user='$id'
				group by t1.id_user, t2.id_user, t3.id_user, t4.id_user, t5.id_user
				";*/
	$query = mysql_query($sql);
	if(mysql_num_rows($query) > 0)
	{	
		for($mm = 1; $mm < $level+1; $mm++)
		{
			$fld_lev = "level".$mm."_array";
			$$fld_lev = array();
		}
		echo "<table width=\"750\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"left\">";
		?>	<tr>
				<td rowspan="2"><img src="images/Icon_o.gif" /></td>
				<td colspan="<?=$level+1;?>" align="center" style="font-weight:bold; color:#000070;font-size: 11pt;"><?= get_parent_username($id);?>&nbsp;<img src="images/genealogy.gif" align="bottom" /> &nbsp; Downline</td>
			</tr>
			<tr>
				<td align="left" colspan="<?=$level+1;?>"><span style="padding-left:16px; float:left;">Your Downline is listed below for up to <?= $level;?> levels. Click any member's name to view up to <?= $level;?> more levels below them. The purple dates below are when the member joined and last visited.</span>
				</td>
			</tr>
			<tr>
				<td colspan="<?=$level+1;?>" align="center">
					<div>
						<form action=""  method="post" lang="en" runat="server">
						<select name="level">
						<?php 
						for($i = 1; $i < 6; $i++)
						{
						?>
							<option value="<?= $i;?>" <?php  if($level == $i){print 'selected="selected"';} ?> ><?= $i;?> Level</option>
						
						<?php 
						}
						?>
						</select>
						<input type="submit" value="View" name="view" id="view" onClick="viewmember()" />
						<input type="text" value="" name="username" placeholder="Username" />
						<input type="submit" value="Search" name="search" />
						</form>
					</div>
				</td>
			</tr>	
		<?php 
		$kk = 1;
		while($row = mysql_fetch_array($query))
		{
			$colspan = $level+1;
			$step_lev = '';
			$kk = $kk +1;
			for($mm = 1; $mm < $level+1; $mm++)
			{
				$fld_lev = "lev$mm";
				$$fld_lev = $row[$fld_lev];
			}
			if($lev1 == NULL)
			{
				echo "<tr><td colspan=\"$level+1\" style=\"text-align:center;\">You Have No Down-Line</td></tr>";
			}
			else{	
					$td = "<td width=3%>&nbsp;</td>";
					for($i = 1; $i <= $kk+1; $i++)
					{
						
						$lev = 'level'.$i.'_array';
						$levv = "lev".$i;
						//echo $$levv,",",$lev,"<br>";
						if(!in_array($$levv,$$lev))
						{
							if($$levv != NULL){
							$level_id = $row['lev'.$i.'_id'];
							$step_lev = $step_lev_inc + $i;
							$info = "(".$row['lev'.$i.'_fname']."&nbsp;".$row['lev'.$i.'_lname'].")";
							echo "<tr><td width=6%><div class=level_start>$step_lev</div></td>";
								for($j = 1; $j < $i; $j++)
								{
									echo $td;
								}
							echo "<td colspan=".($colspan).">
									<a href=# onclick=module(".$level_id.",$i,$level) >".$$levv."</a>
									&nbsp;<img src=\"images/genealogy.gif\" align=\"middle\" /> &nbsp;$info
								</td></tr>";
							$arr = 'level'.$i.'_array';
							$h= $i-1;
							$$arr = array($h => $row['lev'.$i]);
							
							}
						}$colspan=$colspan-1;
						
					}
					
			}
		}
	
		echo "</table>";
	}
	
	
}

function get_parent_username($id){
	$sql = mysql_query("select * from users where id_user='$id'");
	while($row = mysql_fetch_array($sql)){
		$user_info = $row['username']."&nbsp;(".$row['f_name']."&nbsp;".$row['l_name'].")";
	}
	return $user_info;
}

function get_user_photo($id)
{
	$query = mysql_query("SELECT photo FROM users WHERE id_user = '$id' ");
	while($row = mysql_fetch_array($query))
	{
		$photo = $row['photo'];
		if($photo != ''){ $img = $photo; }
		else{ $img = 'Icon_o.gif'; }
	}
	return $img;		
}
?>