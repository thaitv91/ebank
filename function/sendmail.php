<?php

date_default_timezone_set('Etc/UTC');

require_once('../phpmailer/class.phpmailer.php');
require_once('../phpmailer/class.smtp.php');

//require 'https://' . $_SERVER['HTTP_HOST'] . '/phpmailer/class.phpmailer.php';
//require 'https://' . $_SERVER['HTTP_HOST'] . '/phpmailer/class.smtp.php';


include 'Mailin.php';
function sendMail($email,$name,$title,$content){
    $contentEmail = contentEmail($name,$content);
    $mailin = new Mailin('support@ebank.tv', 'QpRfvH4FGSN5tYKb');
    $mailin->
    addTo($email, $name)->
    setFrom('support@blsinvestments.com', 'Vwallet Community')->
    setReplyTo('support@ebank.tv','vwallet Community')->
    setSubject($title)->
    setText($title)->
    setHtml($contentEmail);
    $res = $mailin->send();
}



function contentEmail($name, $content){
    $template = '<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="user-scalable=yes, width=device-width, initial-scale=1.0, minimum-scale=1" name="viewport">
    <title>Email Marketing</title>
    <link rel="stylesheet" type="text/css" href="http://vwallet.uk/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://vwallet.uk/css/style_email.css">
</head>
<body>
<div class="img-logo" style="padding: 50px 0; text-align:center;">
    <img src="http://vwallet.uk/images/newlayout/ebank.png" class="img-responsive" style="display: block;height: auto;max-width: 100%; margin:0 auto;">
</div>
<div class="content" style="background-color: #fff;margin: 0 auto;width: 616px !important;">
    <div class="bg">
        <img src="http://vwallet.uk/images/newlayout/banner2.png" class="img-responsive" style=" display: block;height: auto;max-width: 100%;">
    </div>
    <div class="mail-content" style="color: #1b1b1b;padding: 20px 30px;">
        <h4 style="color: #31c7ff;font-weight: bold;padding-bottom: 15px;font-size: 18px;margin-bottom: 10px;margin-top: 10px;">Dear '.$name.',</h4>
        <p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px;">'.$content.'</p>
        <p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px;">
        Regards,<br>
        <strong>The vwallet team</strong>
        </p>
    </div><!--/mail-content-->
</div><!--/content-->
<footer>
    <p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px; text-align:center;">5 Matthew, Liverpool, M1 6BB, Vương Quốc Anh.</p>
    <p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px; text-align:center;">&copy;2017 vwallet Community</p>
</footer>
</body>
</html>';
    return $template;
}
