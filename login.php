<?php ini_set("display_errors", 'off'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>vWallet - Log In</title>

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 3.3.2 -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
        <style>
            .login-box-body{
                border-radius: 5px !important;
            }
            .has-feedback .form-control{
                padding-right: 0;
            }
            .form-control-feedback{
                left: 0;
                top: 3px
            }
            .form-group input[type="text"],.form-group input[type="password"]{
                padding-left: 30px;
                height: 40px;
                border-radius: 5px !important;
            }
        </style>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// --><!--[if lt IE 9]>	
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script><![endif]--></head>
    <body class="login-page">	
        <div class="login-box">	
            <div class="login-box-body">
                <?php
                $err = $_REQUEST['err'];
                if ($err == 1) {
                    ?><font color="#FF0000" size="+2"><H4>Please Enter Correct Username !!</H4></font><?php
                }
                elseif ($err == 2) {
                    ?> <h4>Please Check Your Email,<br> we have sent your password</h4> 
                <?php } ?>
                <form action="login_check.php" method="POST">
                    <div class="form-group text-center" style="margin:15px">
                        <img src="images/logo-login.png">
                    </div>
                    <div class="form-group  has-feedback">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <input type="text" class="form-control" name="username" style="width:100%" placeholder="Username">
                    </div>
                    <div class="form-group  has-feedback">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>	
                        <input type="password" class="form-control" name="password" style="width:100%" placeholder="Password">
                    </div>
                    <div class="row">			
                        <div class="col-xs-6">    				
                            <div class="checkbox">
                                <label><input type="checkbox"> Check me out</label>
                            </div>
                        </div><!-- /.col -->					
                        <div class="col-xs-6">			
                            <div class="checkbox icheck"><a href="forget_password.php">I forgot my password</a></div>	

                        </div><!-- /.col -->				
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success" style="width:100%; height: 40px">Login</button>
                    </div>
                    <div class="form-group">
                        <a href="register.php" class="btn btn-default" style="width:100%; padding: 10px">Not a member? Sign Up Now!</a>
                    </div>
                    <div class="form-group text-center">
                        <p class="blue text-center" style="color:#1C323F">Supported countries</p>
                        <img style="margin:0 auto" class="img-responsive" src="../images/newlayout/icons/flag_login.png">
                    </div>
                </form>		
                <div class="social-auth-links text-center"></div>
                <!-- /.social-auth-links -->
                <!--<label><input type="checkbox"> Remember Me</label><br>-->			
                <!--<a href="register.php" class="text-center">Register a new membership</a>-->		
            </div><!-- /.login-box-body -->	
        </div><!-- /.login-box --><!-- jQuery 2.1.3 -->
        <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>

        <!-- Bootstrap 3.3.2 JS -->
        <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <script>  
            $(function () {	
                $('input').iCheck({	  
                    checkboxClass: 'icheckbox_square-blue', 
                    radioClass: 'iradio_square-blue', 
                    increaseArea: '20%' // optional	
                    });  
                });
        </script>
    </body>
</html>