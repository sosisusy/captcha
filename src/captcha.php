<?php
header('Content-Type: image/png');

# variable
$width = 200;
$height = 80;
$weight = floor($width / $cnt);
$lineCnt = rand(6, 9);
$lineWidth = 2.2;
$fontSize = rand(23, 30);
$font = "./font/NotoSansKR-Medium.otf";
$rotate = rand(-20, 20);
$captcha = "";
$captchaLength = 6;

# text
$patten = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$len = strlen($patten) - 1;
for ($i = 0, $len = strlen($patten) - 1; $i < $captchaLength; $i++) {
    $captcha .= $patten[rand(0, $len)];
}


# 이미지 생성
$img = imagecreatetruecolor($width, $height);

# 색상
$bg = imagecolorallocate($img, 255, 255, 255);
$fontColor = imagecolorallocate($img, 0, 0, 0);
$lineColor = imagecolorallocate($img, 245, 91, 69);

# 배경
imagefill($img, 0, 0, $bg);

# text
$textBox = imagettfbbox($fontSize, $rotate, $font, $captcha);
$x = $textBox[0] + (imagesx($img) / 2) - ($textBox[4] / 2);
$y = $textBox[1] + (imagesy($img) / 2) - ($textBox[5] / 2);
imagettftext($img, $fontSize, $rotate, $x, $y, $fontColor, $font, $captcha);

# 픽셀
for ($i = 0; $i < 3000; $i++) {
    $x = rand(0, $width);
    $y = rand(0, $height);
    imagesetpixel($img, $x, $y, 0x000);
}

# 라인
imagesetthickness($img, $lineWidth);
for ($i = 0; $i < $lineCnt; $i++) {
    $x = rand(0, $width);
    $y = rand(0, $height);
    $toX = rand(0, $width);
    $toY = rand(0, $height);
    imageline($img, $x, $y, $toX, $toY, $lineColor);
}

# 필터
imagefilter($img, IMG_FILTER_EMBOSS);

imagepng($img);
imagedestroy($img);
