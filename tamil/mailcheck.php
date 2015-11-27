<?php
	require_once "class.phpmailer.php";
	require_once "class.smtp.php";

	$file = fopen("password.txt", "r") or die("Password not found");

	$mail=new PHPMailer();
	$mail->CharSet = 'UTF-8';

	$body = 'This is the message';

	$mail->IsSMTP();
	$mail->Host       = 'smtp.zoho.com';

	$mail->SMTPSecure = 'tls';
	$mail->Port       = 587;
	$mail->SMTPDebug  = 1;
	$mail->SMTPAuth   = true;
	$mail->IsHTML = true;
	$mail->Username   = 'contact@sivasubramanyam.me';
	$mail->Password   = fgets($file);
	fclose($file);

	$mail->SetFrom('contact@sivasubramanyam.me', 'sivasubramanyam');

	$mail->Subject    = 'reset enabled';
	$mail->MsgHTML($body);

	$mail->AddAddress('sivasubramanyama@gmail.com', 'title1');

	$mail->send();

?>