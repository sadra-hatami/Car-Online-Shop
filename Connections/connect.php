<?php

$hostname_connect = "localhost";
$database_connect = "car";
$username_connect = "root";
$password_connect = "";
$connect = mysql_pconnect($hostname_connect, $username_connect, $password_connect) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES utf8");

function thumb($nw, $nh, $source, $stype, $dest) {
	$filename = $source;
	$width = $nw;
	$height = $nh;
	list($width_orig, $height_orig) = getimagesize($filename);
	$ratio_orig = $width_orig/$height_orig;
	if ($width/$height > $ratio_orig) {
	  $width = $height*$ratio_orig;
	} else {
	  $height = $width/$ratio_orig;
	}
	$image_p = imagecreatetruecolor($width, $height);
	
    switch($stype) {
        case 'gif':
        $image = imagecreatefromgif($source);
        break;
        case 'jpg':
        $image = imagecreatefromjpeg($source);
        break;
        case 'png':
        $image = imagecreatefrompng($source);
        break;
    }
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	imagejpeg($image_p,$dest,120);
}
?>