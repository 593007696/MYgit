<?php

$to = "593007696@qq.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "h-cho@jtec-at.co.jp";
$headers = "From: $from";
mail($to,$subject,$message,$headers);


?>