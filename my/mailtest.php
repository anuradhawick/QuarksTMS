<?php

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host       = "smtp.gmail.com";      // SMTP server example, use smtp.live.com for Hotmail
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 465;                   // SMTP port for the GMAIL server 465 or 587
$mail->Username   = "username@gmail.com";  // SMTP account username example
$mail->Password   = "password";   