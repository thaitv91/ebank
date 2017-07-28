<?php
ini_set("display_errors", "off");
session_start();
require_once("config.php");
include('function/setting.php');
include("function/sendmail.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>vWallet | Forget Password</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />

        <!-- iCheck -->
        <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
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

    </head>

    <body class="login-page">

        <?php
        if (isset($_POST['submit'])) {
            $username = $_REQUEST['username'];
            $query = mysql_query("select * from users where username = '$username' ");
            $num = mysql_num_rows($query);
            if ($num != 0) {
                while ($row = mysql_fetch_array($query)) {
                    $password = $row['password'];
                    $to = $row['email'];
                }
                include("function/full_message.php");
                $db_msg = $forget_password_message;
                $email = $to;
                $name  = $username;
                $title = 'Forget password';
                $content = 'This is your password: ' . $password;
                sendMail($email,$name,$title,$content);

                echo '<script type="text/javascript">';
                echo 'window.location="forget_password.php?err=2";';
                echo '</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'window.location="forget_password.php?err=1";';
                echo '</script>';
            }
        }
        ?>
        <div class="login-box">
            <div class="login-box-body">
                <?php
                $err = $_REQUEST['err'];
                if ($err == 1) {
                    ?>
                    <div style=" margin-left:10px;">
                        <B style="color:#FF0000;">Please Enter Correct Username !!</B>
                    </div>
                    <?php
                } elseif ($err == 2) {
                    ?>
                    <div style=" margin-left:10px;">
                        <B style="color:#008000;">
                            Please Check Your Email !!<br> we have sent your password on your E-mail !!
                        </B>
                    </div>
                <?php } ?>
                <form method="post" action="forget_password.php">
                    <div class="form-group text-center" style="margin:15px">
                        <img src="images/logo-login.png"><br>
                    </div>
                    <p class="login-box-msg">Recover your password for Sign in</p>
                    <div class="form-group has-feedback">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <input type="text" class="form-control" style="width:100%" placeholder="Username" name="username"/>
                    </div>
                    <div class="form-group text-right">
                    <input name="submit" value="Send" class="btn btn-primary" type="submit">
                    </div>
                </form>
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
        <!-- jQuery 2.1.3 -->
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