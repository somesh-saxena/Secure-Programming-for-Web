<?php
session_start();
$text = rand(10000,99999);
$_SESSION["vercode"] = $text;
$height = 35;
$width = 75;
$image_p = imagecreate($width, $height);
$black = imagecolorallocate($image_p, 128, 128, 128);
$white = imagecolorallocate($image_p, 255, 255, 255);
$font_size = 14;
imagestring($image_p, $font_size, 5, 5, $text, $white);
imagejpeg($image_p, null, 80);
?>
