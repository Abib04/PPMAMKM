<?php
/**
 * Created by PhpStorm.
 * User: artisan
 * Date: 30/07/16
 * Time: 20:12
 */
session_start();
header("Content-type: image/jpeg");
$digit1 = mt_rand(1,20);
$digit2 = mt_rand(1,20);
$font = "resource/assets/fonts/UbuntuMono-R.ttf";

if(mt_rand(0,1) === 1){
    $math = "$digit1 + $digit2";
    $_SESSION['captcha_ans'] = $digit1 + $digit2;
}else{
    $math = "$digit1 - $digit2";
    $_SESSION['captcha_ans'] = $digit1 - $digit2;
}

//    return $math;
$im = imagecreatefromjpeg("resource/assets/images/bg5.jpg");
$black = imagecolorallocate($im, 0, 0, 0);
imagettftext($im, 30, 10, 60, 60, $black, $font, $math);
imagejpeg($im);
imagedestroy($im);
