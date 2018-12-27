<?php
   $imagePath = $_POST["imagem"];

   $imagick = new \Imagick($imagePath);
   $d = $imagick->getImageGeometry();
   $width = $d['width'];
   $height = $d['height'];
   $startX = $d['width'] / 2;
   $startY = $d['height'] / 2;

   $imagick->cropImage($width, $height, $startX, $startY);
   header("Content-Type: image/jpg");
   echo $imagick->getImageBlob();
?>
