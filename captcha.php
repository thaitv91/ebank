<?php
session_start();
$code=rand(10000,99999);
$_SESSION["code"] = $code;
$font = 'font/arial.ttf';
$im = imagecreatetruecolor(75, 30);
$bg = imagecolorallocate($im, 22, 86, 165); //background color blue
$fg = imagecolorallocate($im, 255, 255, 255);//text color white
imagefill($im, 0, 0, $bg);
imagettftext($im, 15, 3, 10, 22, $fg, $font, $code);
header("Cache-Control: no-cache, must-revalidate");
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
?>