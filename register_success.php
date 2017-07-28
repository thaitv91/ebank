<?php
ini_set("display_errors", 'off');
session_start();
require_once("config.php");

$sql = "Select * from users order by id_user DESC limit 1";
$query = mysql_query($sql);
while ($row = mysql_fetch_array($query))
{

    $username = $row['username'];
    $password = $row['password'];
    $spo_id = $row['real_parent'];
    $full_name = $row['f_name'] . " " . $row['l_name'];
    $spon_name = sponsor_name($spo_id);
}

function sponsor_name($id)
{
    $quer = mysql_query("SELECT username FROM users WHERE id_user = '$id' ");
    while ($ro = mysql_fetch_array($quer))
    {
        $sponsor = $ro['username'];
        return $sponsor;
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>vWallet</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 3.3.2 -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        
        <!-- Theme style -->
        <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>    
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>    
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="lockscreen">
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper">
            <div class="lockscreen-item" style="width:400px; padding-bottom: 20px">
                <div id="payouts" class="dashWidget" style="background:#FFF; padding:20px;">
                    <center>
                        <p><img src="images/logo-login.png"></p>
                        <p>Congratulation Your Registration Is Successfully Completed !!</p>
                        <div style="text-align:left; float:left">
                            <p style="font-weight:bold;" id="login_username">Your Username :  &nbsp;<?= $username; ?></p>
                            <p style="font-weight:bold;" id="login_password">Your Password &nbsp;:  &nbsp;<?= $password; ?></p>
                            <?php if (!empty($spon_name)) { ?>
                                <p style="font-weight:bold;">Your Sponsor   &nbsp; &nbsp;:  &nbsp;<?= $spon_name; ?></p>
                            <?php } ?>
                        </div>

                        <div style="clear:both;">
                            <a href="login.php" class="btn btn-primary" style="padding: 5px 40px;  background-color: #45d633; font-size: 18px; border: 1px solid #45d633">Login Now</a>
                        </div>
                    </center>
                </div><!-- /.lockscreen-item -->

                <div class='lockscreen-footer text-center'>
                    Copyright &copy; 2017 <b><a href="https://vwallet.uk" class='text-black'>vWallet.Uk</a></b><br>
                    All rights reserved
                </div>
            </div><!-- /.center -->
        </div>
    </body>
</html>