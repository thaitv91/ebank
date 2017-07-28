<div class="col-md-12">
<form action="index.php?welcome" method="post" enctype="multipart/form-data">
	<div class="callout callout-warning"> 
		<div class="box-header callout-warning" style="width:100%; border:1px #000000 thick ; background:#e99100;">
			<h3 class="box-title">Account Activation</h3>
		</div>
		<?php
			if($_REQUEST['pay_err'] == 2) {
				echo "<B style='color:#FF0000; font-size:18px;'> Please Upload Both ID's in once !!</B>";
			}
		?>
		<p style="font-size:16px; font-weight:bold;">
			<table cellpadding="0" cellspacing="0" width="100%"> 
				<tr>
					<td><h3>Photo Id</h3></td>
					<td><h3>Upload</h3></td>
					<td><h3>Status</h3></td>
				</tr>
				<tr>
					<td>
						<div class="widget-body">
							<p class="help-block">
								<label class="control-label" style="color:#FFf;">
									To Activate Your Account, You need to submit your National photo 
									ID	or Driver license
								</label>
							</p>
						</div>
					</td>
					<td style="padding-left:10px;">
						<label class="control-label" style="color:#FFf;">Photo ID</label>
						<input type="file" name="slip1" />
					</td>
					<td style="">
						<?php
					if($photo_id != NULL){ 
						if($photo_mode ==0)
							print $btn_1;
						else
							print $btn_2;
					?>
						<?php }else{echo "<button class=\"btn btn-block btn-danger btn-flat\">Uncomplete</button>";} ?>
					</td>
				</tr>
				<tr>
					<td>
						<div class="widget-body">
							<h3>Selfie with Photo Id and Ebank.Tv LOGO</h3>
							<p class="help-block">
								<label class="control-label" style="color:#FFf;">
									For some secuirty purpose, we require member to take selfie with 
									Photo ID and our LOGO.Download Ebank.Tv logo here.
								</label>
							</p>
						</div>
					</td>
					<td style="padding-left:10px;">
						<label class="control-label" style="color:#FFf;">Selfie Photo</label>
						<input type="file" name="slip2" />
					</td>
					<td style="">
						<?php
					if($selfie_id != NULL){ 
						if($selfie_mode ==0)
							print $btn_1;
						else
							print $btn_2;
						?>
						
						<?php }else{echo "<button class=\"btn btn-block btn-danger btn-flat\">Uncomplete</button>";} ?>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="text-right">
					<?php
					if($photo_id ==NULL or $selfie_id == NULL){ ?>
					<input type="submit" value="Upload" name="upload" class="btn btn-danger" /><?php }else{echo "&nbsp;";} ?>
					
					</td>
				</tr>
			</table>
		</p>
	</div>
</form>
</div>