<?php

$imgPath = $_GET['imgpath'];
$type = $_GET['type'] ?? '';

// The file concerned
$filename = '../../assets/images/' . $imgPath;
switch ($type) {
    case 'session_visitor':
        $filename = '../../assets/uploads/session_visitors/pic/' . $imgPath;
        break;
    
    default:
        
        break;
}

// Getting the extension
$ext = pathinfo(parse_url($filename)['path'], PATHINFO_EXTENSION);

// Maximum width and height
$height = $_GET['height'] ?? 100;
$width = $_GET['width'] ?? 100;

// File type
header('Content-Type: image/jpg');

// Get new dimensions
list($width_orig, $height_orig) = getimagesize($filename);

$ratio_orig = $width_orig / $height_orig;

if ($width / $height > $ratio_orig) {
    $width = $height * $ratio_orig;
} else {
    $height = $width / $ratio_orig;
}

// Resampling the image 
$image_p = imagecreatetruecolor($width, $height);
$image = "";

switch ($ext) {
    case 'jpg':
    case 'jpeg':
        $image = imagecreatefromjpeg($filename);
        break;
    case 'png':
        $image = imagecreatefrompng($filename);
        break;
}

imagecopyresampled(
    $image_p,
    $image,
    0,
    0,
    0,
    0,
    $width,
    $height,
    $width_orig,
    $height_orig
);

// Display of output image
imagejpeg($image_p, null, 100);
