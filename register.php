<?php
ini_set("display_errors", 'off');
session_start();
$referral_u = $_REQUEST['ref'];
$unused_reg_pin = $_REQUEST['unused_reg_pin'];
$user_real_parent = $_GET['ref'];

require_once("config.php");
include("function/setting.php");
include("function/functions.php");
include("function/chk_constraint.php");
include("function/sendmail_register.php");
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>vWallet - Account Registration</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,300italic,400italic,700&subset=latin,greek,vietnamese' rel='stylesheet' type='text/css'>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
			.widget{background-color:#fff; border-radius:5px;  }
			.register-page{
				background-color: rgba(0, 0, 0, 0.5);
				font-size:13px;
                background:url('https://vwallet.uk/images/back.jpg') no-repeat center center;
			}
			.register-page .btn{
				width: 100%;
				background: #45d633;
				color: #fff;
				text-transform: uppercase;
			}
			.register-page h4{font-size:15px;}
			.register-page h1{font-size:30px;}
			*{
				font-family: 'Open Sans', sans-serif;
			}
			@media screen and (min-width: 1200px  ){
				.container{width:80%;}
			}
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
            .boxj{ display: none; }

            .e_pin{ background: none; }

            .payu{ background: none; }
            .widget {border: 0; padding:5px 20px; margin-top: 30px}
            .form-control {width: 100%; border-radius: 5px !important}
            .form-group label{font-weight: normal}

            /**
             * Create the box for the checkbox
             */
            .checkbox input[type="checkbox"]{
                display: none
            }
            .form-group input[type="submit"]{
                background-color: #45d633 !important;
            }
            .checkbox span{
                margin-left: 35px
            }
            .checkbox label {
                cursor: pointer;
                position: absolute;
                width: 25px;
                height: 25px;
                top: 0;
                left: 0;
                background: #006df0;
                border:1px solid #006df0;
                border-radius: 3px;
            }

            /**
             * Display the tick inside the checkbox
             */
            .checkbox label:after {
                opacity: 0.2;
                content: '';
                position: absolute;
                width: 9px;
                height: 5px;
                background: transparent;
                top: 6px;
                left: 7px;
                border: 3px solid #fff;
                border-top: none;
                border-right: none;
                -webkit-transform: rotate(-45deg);
                -moz-transform: rotate(-45deg);
                -o-transform: rotate(-45deg);
                -ms-transform: rotate(-45deg);
                transform: rotate(-45deg);
            }

            /**
             * Create the hover event of the tick
             */
            .checkbox label:hover::after {
                opacity: 0.5;
            }

            /**
             * Create the checkbox state for the tick
             */
            .checkbox input[type=checkbox]:checked + label:after {
                opacity: 1;
            }
			.text-red{color:#ff0000;}	
        </style>

    </head>

    <body class="register-page">
        <div class="container">
            <div class="widget">
				<h1>NEW REGISTRATION</h1>
				<p>Your email address will not be published. Required fields are marked *</p>
                <form id="frmRegister">
                    <h5>ACCOUNT INFORMATION</h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Username:</label>
                                <input type="text" required="" class="form-control txt_username">
                            </div>
                            <p class="text-red alert_txt_username"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Sponsor ID:</label>
                                <input type="text" required="" class="form-control txt_sponsor_id" value="<?php if(!empty($user_real_parent)){echo $user_real_parent;}?>" <?php if(!empty($user_real_parent)){echo 'disabled';}?>>
                            </div>
                            <p class="text-red alert_txt_sponsor_id"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Password:</label>
                                <input type="password" required="" class="form-control txt_password">
                            </div>
                            <p class="text-red alert_txt_password"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Confirm Password:</label>
                                <input type="password" required="" class="form-control txt_confirm_password">
                            </div>
                            <p class="text-red alert_txt_confirm_password"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Security Code:</label>
                                <input type="password" required="" class="form-control txt_security_code">
                            </div>
                            <p class="text-red alert_txt_security_code"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Confirm Security Code:</label>
                                <input type="password" required="" class="form-control txt_confirm_security_code">
                            </div>
                            <p class="text-red alert_txt_confirm_security_code"></p>
                        </div>
                    </div>

                    <h5>PERSONAL INFORMATION</h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* First Name:</label>
                                <input type="text" required="" class="form-control txt_first_name">
                            </div>
                            <p class="text-red alert_txt_first_name"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Last Name:</label>
                                <input type="text" required="" class="form-control txt_last_name">
                            </div>
                            <p class="text-red alert_txt_last_name"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Gender:</label>
                                <div style="height:35px;">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="male" checked=""> Male
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="female"> Female
                                    </label>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Email:</label>
                                <input type="text" required="" class="form-control txt_email">
                            </div>
                            <p class="text-red alert_txt_email"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Mobile:</label>
                                <input type="text" required="" class="form-control txt_mobile">
                            </div>
                            <p class="text-red alert_txt_mobile"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Country:</label>
                                <select class="form-control txt_country">
                                    <?php 
                                    $q_country = mysql_query("SELECT * FROM location ORDER BY location_id ASC");
                                    while($r_country = mysql_fetch_array($q_country)){
                                        echo "<option value='".$r_country['location_id']."'>".$r_country['name']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <p class="text-red alert_txt_mobile"></p>
                        </div>
                    </div>

                    <h5>PAYMENT INFORMATION</h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Bank Name:</label>
                                <input type="text" required="" class="form-control txt_bank_name">
                            </div>
                            <p class="text-red alert_txt_bank_name"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Bank Branch Name:</label>
                                <input type="text" required="" class="form-control txt_bank_branch_name">
                            </div>   
                            <p class="text-red alert_txt_bank_branch_name"></p>             
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Bank Account Holder Name:</label>
                                <input type="text" required="" class="form-control txt_bank_account_holder">
                            </div>     
                            <p class="text-red alert_txt_bank_account_holder"></p>                  
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Bank Account Number:</label>
                                <input type="text" required="" class="form-control txt_bank_account_member">
                            </div>
                            <p class="text-red alert_txt_bank_account_member"></p>
                        </div>
                        
                        
                    </div>
                    <h5>SECURITY VERIFICATION</h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>* Security Verification:</label>
                                <input type="text" required="" class="form-control txt_security_verification">
                            </div>
                            <p class="text-red alert_txt_security_verification"></p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label></label>
                                <input type="text" disabled="" class="form-control txt_security_capcha" style="width:50%;margin-top:17px">
                            </div>
                            <p class="text-red alert_txt_bank_account_member"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <p class="secure"><a href="/login.php"><i class="fa fa-sign-in" aria-hidden="true"></i> I HAVE ACCOUNT</a></p>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <button class="btn btn-creataccount" type="button">CREATE ACCOUNT</button>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <p class="secure"><span></span> 100% SECURE &amp; FCA AUTHORISED</p>
                        </div>
                    </div>            
                </form>

            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-epin text-center">
                            <p><img src="images/payment_active.png"></p>
                            <h3 class="test">Thank you for joining vWallet.</h3>
                            <P style="font-size:16px;">Please check your email for your account details and log-in to vWallet using your registered username and password</P>
                            <h3><a style="border:1px solid #3AD700;text-transform:none;width:auto;" class="btn btn-success" href="https://vwallet.uk/login.php">Login to vWallet</a></h3>
                            <a id="download"></a>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- jQuery 2.1.3 -->
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>

<script>
	var security = Math.floor(Math.random()*90000) + 10000;
	jQuery('.txt_security_capcha').val(security);
</script>

<script>
    jQuery('.btn-creataccount').click(function(){
        var txt_username         = jQuery('.txt_username').val();
        var txt_sponsor_id       = jQuery('.txt_sponsor_id').val();
        var txt_password         = jQuery('.txt_password').val();
        var txt_confirm_password = jQuery('.txt_confirm_password').val();
        var txt_security_code    = jQuery('.txt_security_code').val();
        var txt_confirm_security_code = jQuery('.txt_confirm_security_code').val();
        var txt_first_name       = jQuery('.txt_first_name').val();
        var txt_last_name        = jQuery('.txt_last_name').val();
        var txt_sex              = jQuery('input[name="gender"]:checked').val();
        var txt_email            = jQuery('.txt_email').val();
        var txt_mobile           = jQuery('.txt_mobile').val();
        var txt_country          = jQuery('.txt_country').val();
        var txt_bank_name        = jQuery('.txt_bank_name').val();
        var txt_bank_branch_name = jQuery('.txt_bank_branch_name').val();
        var txt_bank_account_holder = jQuery('.txt_bank_account_holder').val();
        var txt_bank_account_member = jQuery('.txt_bank_account_member').val();
        var txt_security_verification = jQuery('.txt_security_verification').val();
        var txt_security_capcha    = jQuery('.txt_security_capcha').val();

        if(!txt_username){
            jQuery('.alert_txt_username').html('Please enter username!');
            jQuery('.txt_username').focus();
            return false;
        }else{
            jQuery('.alert_txt_username').html('');
        }
        if(!txt_password){
            jQuery('.alert_txt_password').html('Please enter password!');
            jQuery('.txt_password').focus();
            return false;
        }else{
            jQuery('.alert_txt_password').html('');
        }
        if(txt_password != txt_confirm_password){
            jQuery('.alert_txt_confirm_password').html('Confirm password wrong!');
            jQuery('.txt_confirm_password').focus();
            return false;
        }else{
            jQuery('.alert_txt_confirm_password').html('');
        }
        if(!txt_security_code){
            jQuery('.alert_txt_security_code').html('Please enter security code!');
            jQuery('.txt_security_code').focus();
            return false;
        }else{
            jQuery('.alert_txt_security_code').html('');
        }
        if(txt_security_code != txt_confirm_security_code){
            jQuery('.alert_txt_confirm_security_code').html('Confirm security code wrong!');
            jQuery('.txt_confirm_security_code').focus();
            return false;
        }else{
            jQuery('.alert_txt_confirm_security_code').html('');
        }
        if(!txt_first_name){
            jQuery('.alert_txt_first_name').html('Please enter first name!');
            jQuery('.txt_first_name').focus();
            return false;
        }else{
            jQuery('.alert_txt_first_name').html('');
        }
        if(!txt_last_name){
            jQuery('.alert_txt_last_name').html('Please enter last name!');
            jQuery('.txt_last_name').focus();
            return false;
        }else{
            jQuery('.alert_txt_last_name').html('');
        }
        if(!txt_email){
            jQuery('.alert_txt_email').html('Please enter email!');
            jQuery('.txt_email').focus();
            return false;
        }else{
            jQuery('.alert_txt_email').html('');
        }
        if(!txt_mobile){
            jQuery('.alert_txt_mobile').html('Please enter mobile!');
            jQuery('.txt_mobile').focus();
            return false;
        }else{
            jQuery('.alert_txt_mobile').html('');
        }
        if(!txt_bank_name){
            jQuery('.alert_txt_bank_name').html('Please enter bank name!');
            jQuery('.txt_bank_name').focus();
            return false;
        }else{
            jQuery('.alert_txt_bank_name').html('');
        }
        if(!txt_bank_branch_name){
            jQuery('.alert_txt_bank_branch_name').html('Please enter bank branch name!');
            jQuery('.txt_bank_branch_name').focus();
            return false;
        }else{
            jQuery('.alert_txt_bank_branch_name').html('');
        }
        if(!txt_bank_account_holder){
            jQuery('.alert_txt_bank_account_holder').html('Please enter bank account holder!');
            jQuery('.txt_bank_account_holder').focus();
            return false;
        }else{
            jQuery('.alert_txt_bank_account_holder').html('');
        }
        if(!txt_bank_account_member){
            jQuery('.alert_txt_bank_account_member').html('Please enter bank account name!');
            jQuery('.txt_bank_account_member').focus();
            return false;
        }else{
            jQuery('.alert_txt_bank_account_member').html('');
        }
        if(!txt_security_verification){
            jQuery('.alert_txt_security_verification').html('Please enter security verification!');
            jQuery('.txt_security_verification').focus();
            return false;
        }else{
            jQuery('.alert_txt_security_verification').html('');
        }
        if(txt_security_verification != txt_security_capcha){
            jQuery('.alert_txt_security_verification').html('security verification is wrong!');
            jQuery('.txt_security_verification').focus();
            return false;
        }
            
        jQuery.ajax({
            url : "/ajax_call/register_account.php",
            type : "post",
            dateType:"html",
            data : 'txt_username='+txt_username+'&txt_sponsor_id='+txt_sponsor_id+'&txt_password='+txt_password+'&txt_security_code='+txt_security_code+'&txt_first_name='+txt_first_name+'&txt_last_name='+txt_last_name+'&txt_sex='+txt_sex+'&txt_email='+txt_email+'&txt_mobile='+txt_mobile+'&txt_country='+txt_country+'&txt_bank_name='+txt_bank_name+'&txt_bank_branch_name='+txt_bank_branch_name+'&txt_bank_account_holder='+txt_bank_account_holder+'&txt_bank_account_member='+txt_bank_account_member,
            success : function (result){
                if(result){
                    if(result == 'ok'){
                        $("#myModal").modal();
                        var downloadButton = document.getElementById("download");
                        var counter = 10;
                        var newElement = document.createElement("p");
                        newElement.innerHTML = "Redirect to log-in eBank in 10 seconds.";
                        var id;

                        downloadButton.parentNode.replaceChild(newElement, downloadButton);

                        id = setInterval(function() {
                            counter--;
                            if(counter < 0) {
                                window.location.href = 'https://vwallet.uk/login.php';
                            } else {
                                newElement.innerHTML = "Redirect to log-in vWallet in " + counter.toString() + " seconds.";
                            }
                        }, 1000);
                    }else{
                        alert(result);
                    }
                }
            }
        }); 
    })
</script>