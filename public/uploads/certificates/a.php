<?php
  header('Content-type: image/jpeg');

  // Create Image From Existing File
  $jpg_image = imagecreatefromjpeg('img.jpg');
//$jpg_image=imagecreatetruecolor(100,100);

  // Allocate A Color For The Text
 $white = imagecolorallocate($jpg_image, 255, 255, 255);


  // Set Path to Font File
  $font_path = 'CREMISSS.ttf';

  // Set Text to Be Printed On Image
  $text = "This is a sunset!";

  // Print Text On Image
  $x=20;
  for($i=0;$i<=strlen($text);$i++){
   $print_text=substr($text,$i,1);
   $x+=20;
    imagettftext($jpg_image, 30, 0, $x, 200, $white, $font_path, $print_text);
  }


  // Send Image to Browser
  imagejpeg($jpg_image,'name.jpg');

  // Clear Memory
  imagedestroy($jpg_image);
?> 