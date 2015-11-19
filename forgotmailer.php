<?php
	ob_start();
	session_start();
	require_once "class.phpmailer.php";
	require_once "class.smtp.php";
	require_once "recaptchalib.php";

	$secret = "6LcbKhETAAAAAEhXBtoLAZtNQIT9Mcz8GXLyysnB";
	$response = null;
	$reCaptcha = new ReCaptcha($secret);

	if ($_POST["g-recaptcha-response"]) {
    	$response = $reCaptcha->verifyResponse(
        	$_SERVER["REMOTE_ADDR"],
        	$_POST["g-recaptcha-response"]
    	);
	}

	if ($response != null && $response->success) {

		$file = fopen("password.txt", "r") or die("Password not found");

		$key = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);

		$m = new MongoClient();
		$db = $m -> map;
		$collection = $db -> forgot;
		$collection -> insert(array('email' => $_POST["email"], 'key' => $key));


		$mail=new PHPMailer();
		$mail->CharSet = 'UTF-8';

		$body = 'Open this link to reset your password. <br><br><b>map.sivasubramanyam.me/profileupdate.php?id='.$key.'</b>';


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

		$mail->SetFrom('contact@sivasubramanyam.me', 'MapMyProblems');

		$mail->Subject    = 'Password reset link - MapMyProblems';
		$mail->MsgHTML($body);

		$mail->AddAddress($_POST["email"], $_POST["email"]);

		$mail->send();
		$_SESSION['login-error'] = 3;
		header('Location:forgot.php');
	}

	else {
		$_SESSION['login-error'] = 2;
		header('Location:forgot.php');
	}


?>