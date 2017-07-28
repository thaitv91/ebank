<?php
session_start();

include("condition.php");

require_once("validation/validation.php");

include("function/setting.php");

include("function/functions.php");

include("function/send_mail.php");

require_once("function/country_list.php");



$id = $_SESSION['ebank_user_id'];



$allowedfiletypes = array("jpeg", "jpg", "png", "gif");

$uploadfolder = $user_profile_folder;

$thumbnailheight = 100; //in pixels

$thumbnailfolder = $uploadfolder . "thumbs/";





if (isset($_POST['submit']))
{

    $full_name = $_POST['full_name'];

    $gender = $_POST['gender'];

    $branch = $_POST['branch'];

    $bank = $_POST['bank'];
	
	$email = $_POST['email'];

    $ac_no = $_POST['ac_no'];

    $ifsc = $_POST['ifsc'];

    $benf_name = $_POST['benf_name'];

    $dob = $_POST['dob'];

    $sec_code = $_POST['sec_code'];



    $full_name = explode(" ", $full_name);



    $f_name = $full_name[0];

    $l_name = $full_name[1] . " " . $full_name[2];



    $chk_email = email_exist($email);

    $chk_phone = phone_exist($phone);





    $query = mysql_query("select * from users where id_user = '$id' and user_pin = '$sec_code' ");

    $num = mysql_num_rows($query);

    if ($num == 0)
    {

        echo "<B style=\"color:#FF0000;\">Please Enter Correct Security Code !!</B>";
    }
    else
    {
		

        /* $sql_update = "UPDATE users SET f_name = '$f_name',l_name='$l_name',gender='$gender', 

          beneficiery_name = '$benf_name', branch = '$branch' , bank = '$bank' , ac_no = '$ac_no' ,

          bank_code = '$ifsc'"; */

        if($chk_email > 0){
            $sql_update = "UPDATE users SET f_name = '$f_name' , l_name = '$l_name' , gender = '$gender'";
        } else{
            $sql_update = "UPDATE users SET f_name = '$f_name' , l_name = '$l_name' , gender = '$gender' , email='$email'";
        } 
        
        // user image profile
        if (!empty($_FILES['photo']['name']))
        {
            $uploadfilename = $_FILES['photo']['name'];
            
            $fileext = strtolower(substr($uploadfilename, strrpos($uploadfilename, ".") + 1));



            if (!in_array($fileext, $allowedfiletypes))
            {

                print "Invalid Extension";
            }
            else
            {

                $unique_time = time();

                $unique_name = "EBT" . $unique_time;

                $unique_name = $unique_name . "." . $fileext;

                $fulluploadfilename = $uploadfolder . $unique_name;

                copy($_FILES['photo']['tmp_name'], $fulluploadfilename);
                $sql_update .=" , photo = '$unique_name'";
            }
        }
        $sql_update.=" WHERE id_user = $id";

        mysql_query($sql_update);
		

        $date = date('Y-m-d');

        $username = get_user_name($id);

        $updated_by = $username . " Your self";

        include("function/logs_messages.php");

        data_logs($id, $data_log[1][0], $data_log[1][1], $log_type[1]);

        echo "<B style=\"color:#008000;\">Successfully Updated</B><br />";
    }
}

$query = mysql_query("select * from users where id_user = '$id' ");

while ($row = mysql_fetch_array($query))
{
    $username = $row['username'];

    $gender = $row['gender'];

    $dob = $row['dob'];

    $city = $row['city'];

    $email = $row['email'];

    $phone = $row['phone_no'];

    $dob = $row['dob'];

    $photo = $row['photo'];
    
    $idcard = $row['idcard'];

    $photo_idcard = $row['photo_idcard'];
    
    $b_city = $row['city'];

    $level = $row['level'];

    $bank = $row['bank'];

    $branch = $row['branch'];

    $acc_no = $row['ac_no'];

    $benf_name = $row['beneficiery_name'];

    $acc_type = $row['acc_type'];

    $ifsc_code = $row['bank_code'];

    $full_name = ucfirst($row['f_name']) . " " . ucfirst($row['l_name']);

    $viber = $row['viber'];

    $zalo = $row['zalo'];

    $bit_coin_ac = $row['bit_coin_ac'];

    $q_country = mysql_query("SELECT * FROM location WHERE location_id =".$row['country']);
    $r_country = mysql_fetch_array($q_country);
    $country = $r_country['name'];

    $dd = date('d', strtotime($dob));

    $mm = date('m', strtotime($dob));

    $yy = date('Y', strtotime($dob));
}
?>
<div class="box box-primary" style="padding: 15px"> 
    <form name="money" class="form-horizontal" action="index.php?page=edit-profile" method="post" enctype="multipart/form-data">
    
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label"><h4>Personal Details</h4></label>
						<div class="col-sm-8"></div>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label">Full Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control col-sm-11 col-xs-12" name="full_name" value="<?= $full_name; ?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Gender</label>
						<div class="col-sm-8">
							<div class="radio-inline">
								<label>
									<input type="radio" name="gender" value="male" <?php if($gender == 'male'){echo 'checked';}?>>
									Male
								</label>
							</div>
							<div class="radio-inline">
								<label>
									<input type="radio" name="gender" value="female" <?php if($gender == 'female'){echo 'checked';}?>>
									Female
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Upload Photo</label>
						<div class="col-sm-1 hidden-xs"><img class=" img-circle" src="images/profile_image/<?=!empty($photo)?$photo:"user.png"; ?>" height="50" width="50" /></div>
						<div class="col-sm-5">
							<label for="file-upload" class="custom-file-upload">
								<i class="fa fa-cloud-upload"></i> Custom Upload
							</label>
							<input id="file-upload" type="file"  name="photo" value="<?= $photo; ?>"/>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label">Username</label>
						<div class="col-sm-8">
							<input type="text" class="form-control col-sm-11 col-xs-12" name="user_name" value="<?= $username; ?>" readonly >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Level</label>
						<div class="col-sm-8">
							<?php
							$lev = mysql_query("select * from tb_level_plan");
							while ($rowl = mysql_fetch_array($lev))
							{
				
								?>
								<span class="btn btn-<?= ($rowl['level_name'] == $level) ? "primary" : "default" ?>">V<?= $rowl['level_name'] ?></span>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-md-4 col-sm-4 control-label">Referral Link</label>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="row">
								<div class="col-md-12 col-sm-11 col-xs-12">
									<div id="linkRegister" class="form-control col-lg-11 copytext">https://vwallet.uk/register.php?ref=<?= $username ?></div>
								</div>
								<div class="col-md-12 col-sm-11 col-xs-12" style="padding-top:10px;">
									<a href="javascript:;" class="btn btn-success copybtn btn-copy" data-clipboard-action="copy" data-clipboard-target="#linkRegister">Copy</a>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
            
            <div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label"><h4>Contact Details</h4></label>
						<div class="col-sm-8"></div>
					</div>
				</div>
			</div>
            <div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label">Email</label>
						<div class="col-sm-8">
							<input type="text" class="form-control col-lg-11 col-sm-11 col-xs-12" name="email" value="<?= $email; ?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Phone</label>
						<div class="col-sm-8">
							<input type="text" class="form-control col-lg-11 col-sm-11 col-xs-12" name="phone" value="<?= $phone; ?>" readonly>
						</div>
					</div>
				</div>
				
				<div class="col-md-6 col-sm-12">
    				<div class="form-group">
    					<label class="col-sm-4 control-label">ID code</label>
    					<div class="col-sm-8">
    						<input type="text" class="form-control col-sm-11 col-xs-12" name="idcard" value="<?= $idcard; ?>" readonly>
    					</div>
    				</div>
    			</div>
				
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label">ID Card</label>
						<div class="col-sm-1 hidden-xs"><img class=" img-circle" src="images/idcard_image/<?=!empty($photo_idcard)?$photo_idcard:"idcard.png"; ?>" height="200" width="200" /></div>
					</div>
					
					<div class="form-group" style="text-align: center;">
                        <a class="btn btn-primary" href="/index.php?page=edit-idcard">Update ID Card</a>
                    </div>
				</div>
				
			</div>	
			
			<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label"><h4>Bank Details</h4></label>
						<div class="col-sm-8"></div>
					</div>
				</div>
			</div>
            <div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label">Account Holder Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control col-lg-11 col-sm-11 col-xs-12" name="bank_holder_name" value="<?= $benf_name; ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Bank Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control col-lg-11 col-sm-11 col-xs-12" name="bank_name" value="<?= $bank; ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Security Code</label>
						<div class="col-sm-8">
							<input type="password" class="form-control col-lg-11 col-sm-11 col-xs-12" name="sec_code" value="" >
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label">Branch Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control col-lg-11 col-sm-11 col-xs-12" name="branch_name" value="<?= $branch; ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Bank Account Number</label>
						<div class="col-sm-8">
							<input type="text" class="form-control col-lg-11 col-sm-11 col-xs-12" name="account_no" value="<?= $acc_no; ?>" readonly>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12">
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" name="submit" class="btn btn-primary btn_update">Update</button>
						</div>
					</div>
				</div>	
			</div>	



    </form>	
</div>

<?php
/* $qwww = mysql_query("SELECT * FROM ac_activation WHERE user_id = '$user_id' ");

  while($rowss = mysql_fetch_array($qwww))

  {

  $photo_id = $rowss['photo_id'];

  $selfie_id = $rowss['selfie_id'];

  $act_mode = $rowss['mode'];

  }

  if($photo_id == NULL or $act_mode == 0)

  {

  include "account_activation.php";

  } */
?>		

<script>

    $(function () {

        //Datemask dd/mm/yyyy

        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "yyyy-mm-dd"});

        //Datemask2 mm/dd/yyyy

        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});

        //Money Euro

        $("[data-mask]").inputmask();

		/*
		var copyTextareaBtn = document.querySelector('.copybtn');

        copyTextareaBtn.addEventListener('click', function (event) {
            var copyTextarea = document.querySelector('.copytext');
            copyTextarea.select();

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Copying text command was ' + msg);
            } catch (err) {
                console.log('Oops, unable to copy');
            }
        });*/

    });

</script>

<script src="js/clipboard.min.js"></script>
<script>
    var clipboard = new Clipboard('.btn-copy');

    clipboard.on('success', function(e) {
        console.log(e);
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });
</script>

<style>
	#linkRegister{overflow:hidden;}
	input[type="file"] {
       display: none;
    }
    .custom-file-upload {
    	border: 1px solid #0EC31C;
		background-color: #0EC31C;
		color:#fff;
		display: inline-block;
		padding: 6px 12px;
		cursor: pointer;
	}
	.btn_update, .copybtn{width:50%;}
	@media screen and (max-width: 768px) {
		.btn_update, .copybtn{width:100%;}
	}
</style>
