<?php

date_default_timezone_set('Etc/UTC');

require '/phpmailer/class.phpmailer.php';
require '/phpmailer/class.smtp.php';

function sendmail($to, $subject, $message)
{

    $mail = new PHPMailer;

//Tell PHPMailer to use SMTP
    $mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

//Set the hostname of the mail server
    // $mail->Host = 'mail.smtp2go.com';
    $mail->Host = 'vps29289.inmotionhosting.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    // $mail->Port = 2525;
    $mail->Port = 465;

//Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'ssl';

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
    // $mail->Username = "support@ebank.live";
    $mail->Username = "admin@vwallet.uk";

//Password to use for SMTP authentication
    // $mail->Password = "ebank@123456";
    $mail->Password = "admin@vwallet";

//Set who the message is to be sent from
    // $mail->setFrom('support@ebank.live', 'eBank Community');
    $mail->setFrom('admin@vwallet.uk', 'vWallet Community');

//Set an alternative reply-to address
    $mail->addReplyTo($to, $to);

//Set who the message is to be sent to
    $mail->addAddress($to, $to);

//Set the subject line
    $mail->Subject = $subject;

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
    $mail->msgHTML($message);

//Replace the plain text body with one created manually
    $mail->AltBody = $message;


//send the message, check for errors
    if (!$mail->send())
    {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else
    {
        echo "Message sent!";
    }
}

function contentEmail($name, $content){
    $template = '<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="user-scalable=yes, width=device-width, initial-scale=1.0, minimum-scale=1" name="viewport">
	<title>Email Marketing</title>
	<link rel="stylesheet" type="text/css" href="http://ebank.live/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://ebank.live/css/style_email.css">
</head>
<body>
<div class="img-logo" style="padding: 50px 0; text-align:center;">
	<img src="http://ebank.live/images/newlayout/logo.png" class="img-responsive" style="display: block;height: auto;max-width: 100%;">
</div>
<div class="content" style="background-color: #fff;margin: 0 auto;width: 616px !important;">
	<div class="bg">
		<img src="http://ebank.live/images/newlayout/banner.jpg" class="img-responsive" style=" display: block;height: auto;max-width: 100%;">
	</div>
	<div class="mail-content" style="color: #1b1b1b;padding: 20px 30px;">
		<h4 style="color: #31c7ff;font-weight: bold;padding-bottom: 15px;font-size: 18px;margin-bottom: 10px;margin-top: 10px;">Dear '.$name.',</h4>
		<p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px;">'.$content.'</p>
		<p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px;">
		Regards,<br>
		<strong>The eBank team</strong>
		</p>
	</div><!--/mail-content-->
</div><!--/content-->
<footer>
	<ul class="icon list-inline" style="padding: 30px 0 10px;text-align: center;list-style: outside none none;margin-left: -5px;margin-bottom: 10px;margin-top: 0;">
		<li style="display: inline-block;padding-left: 5px;padding-right: 5px;"><a href="#" style="text-decoration: none;"><img style="border: medium none;vertical-align: middle;" src="http://ebank.live/images/newlayout/icons/icon-facebook.png"></a></li>
		<li style="display: inline-block;padding-left: 5px;padding-right: 5px;"><a href="#" style="text-decoration: none;"><img style="border: medium none;vertical-align: middle;" src="http://ebank.live/images/newlayout/icons/icon-youtube.png"></a></li>
		<li style="display: inline-block;padding-left: 5px;padding-right: 5px;"><a href="#" style="text-decoration: none;"><img style="border: medium none;vertical-align: middle;" src="http://ebank.live/images/newlayout/icons/icon-flickr.png"></a></li>
	</ul>
	<p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px; text-align:center;">745 5th Ave #31, New York, NY 10151</p>
	<p style="font-size: 15px;font-weight: 300;line-height: 25px;margin: 0 0 10px; text-align:center;">&copy;2016 eBank Community</p>
</footer>
</body>
</html>';
	return $template;
}
