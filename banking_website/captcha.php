<?php
session_start();
//font used for captcha text
$fontfile = 'LaBelleAurore.ttf';
header('Content-Type: image/png');

//captcha image box specs
$img    = imagecreatetruecolor(250, 250);
//colors
$blue  = imagecolorallocate($img, 0,0,255);
$red  = imagecolorallocate($img, 255,0,0);
$yellow  = imagecolorallocate($img, 255, 255, 224);

// field for captcha text to appear in 
imagefilledrectangle($img, 5, 5, 245, 245, $yellow);

//captcha text randomizer 
$len1 = 6;
$len2 = 7;
$txt1 = substr(str_shuffle(md5(time())),0,$len1);
$txt2 = substr(str_shuffle(md5(time())),0,$len2);
//concatinate both texts into one
$txt = $txt1.$txt2;

//remembers the captcha here
$_SESSION["captcha"]=$txt;

//places captcha texts in a certain spot in the image box
imagettftext($img, 25, -25, 30,  65, $blue, $fontfile, $txt1);
imagettftext($img, 35,  25, 70, 200,  $red, $fontfile, $txt2);

//creates the image as a png then destroys it
imagepng($img);
imagedestroy($img);
?>