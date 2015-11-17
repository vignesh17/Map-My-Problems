<?php
	ob_start();
	session_start();

	$liveServer = 0;

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
	
		if(!isset($_POST["name"]) or !isset($_POST["username"]) or !isset($_POST["password"]) or !isset($_POST["cpass"]) or !isset($_POST["email"])) {
			header('Location:signup.php');
		}

		$name = $_POST["name"];
		$username = $_POST["username"];
		$pass = $_POST["password"];
		$cpass = $_POST["cpassword"];
		$email = $_POST["email"];
		$const = $_POST["constituency"];

		if(strcmp($pass, $cpass) == 0) {
			$hashpass = md5($pass);
		}

		else {
			$_SESSION['password-mismatch'] = 1;
			header('Location:signup.php');
		}

		$m = new MongoClient();
		$db = $m -> map;
		$collection = $db -> users;

		

		if($liveServer) {

			$alreadyExists = (($collection -> count(array('username' => $username))) + ($collection -> count(array('email' => $email))));
			if(!$alreadyExists) {
				$user = array('name' => $name, 'username' => $username, 'pass' => $hashpass, 'email' => $email, 'active' => 0, 'verify' => crc32($email));
				$collection -> insert($user);
			    $subject = 'Confirmation';
				$message = 'Open this link to verify' . '<a href="map.com/verify.php?id='.crc32($email).'">map.com/verify.php?id='.crc32($email).'</a>';
				$to = '$email';
				$type = 'HTML'; 
				$charset = 'utf-8';

				$mail     = 'no-reply@'.str_replace('www.', '', $_SERVER['SERVER_NAME']);
				$uniqid   = md5(uniqid(time()));
				$headers  = 'From: '.$mail."\n";
				$headers .= 'Reply-to: '.$mail."\n";
				$headers .= 'Return-Path: '.$mail."\n";
				$headers .= 'Message-ID: <'.$uniqid.'@'.$_SERVER['SERVER_NAME'].">\n";
				$headers .= 'MIME-Version: 1.0'."\n";
				$headers .= 'Date: '.gmdate('D, d M Y H:i:s', time())."\n";
				$headers .= 'X-Priority: 3'."\n";
				$headers .= 'X-MSMail-Priority: Normal'."\n";
				$headers .= 'Content-Type: multipart/mixed;boundary="----------'.$uniqid.'"'."\n\n";
				$headers .= '------------'.$uniqid."\n";
				$headers .= 'Content-type: text/'.$type.';charset='.$charset.''."\n";
				$headers .= 'Content-transfer-encoding: 7bit';

				$ma = mail($to, $subject, $message, $headers);
			}
			else {
				$_SESSION['username-exists'] = 1;
				header('Location:signup.php');
			}

		}

		else {

			$alreadyExists = (($collection -> count(array('username' => $username))) + ($collection -> count(array('email' => $email))));
			if(!$alreadyExists) {
				$user = array('admin' => 0, 'name' => $name, 'username' => $username, 'pass' => $hashpass, 'email' => $email, 'active' => 1, 'verify' => crc32($email), "constituency" => $const);
				$collection -> insert($user);
				header('Location:login.php');
			}
			else {
				$_SESSION['username-exists'] = 1;
				header('Location:signup.php');
			}

		}
	}

	else {
		$_SESSION['captcha'] = 1;
		header('Location:signup.php');
	}
     
?>