<?php
	ob_start();
	session_start();
	require_once "class.phpmailer.php";
	require_once "class.smtp.php";

	$liveServer = 1;

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

		$name = (string)$_POST["name"];
		$username = (string)$_POST["username"];
		$pass = (string)$_POST["password"];
		$cpass = (string)$_POST["cpassword"];
		$email = (string)$_POST["email"];
		$const = (string)$_POST["constituency"];
		$dist = (string)$_POST["district"];

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
				$code = (string)crc32($email);
				$user = array('district' => $dist, 'admin' => 0, 'name' => $name, 'username' => $username, 'pass' => $hashpass, 'email' => $email, 'active' => 0, 'verify' => $code, "constituency" => $const);
				$collection -> insert($user);
				$file = fopen("password.txt", "r") or die("Password not found");
				$mail = new PHPMailer();
				$mail -> CharSet = 'UTF-8';
				$message = 'Open this link to verify <br><br><b>map.sivasubramanyam.me/verify.php?id='.$code.'</b>';
				$mail -> IsSMTP();
				$mail -> Host       = 'smtp.zoho.com';

				$mail -> SMTPSecure = 'tls';
				$mail -> Port       = 587;
				$mail -> SMTPDebug  = 1;
				$mail -> SMTPAuth   = true;
				$mail -> IsHTML = true;

				$mail -> Username   = 'contact@sivasubramanyam.me';
				$mail -> Password   = fgets($file);
				fclose($file);

				$mail -> SetFrom('contact@sivasubramanyam.me', 'MapMyProblems');

				$mail -> Subject = 'Verify your account - MapMyProblems';
				$mail -> MsgHTML($message);

				$mail -> AddAddress($email, $name);


				$mail -> send();
				$_SESSION['login-error'] = 3;
				header('Location:login.php');

			}
			else {
				$_SESSION['username-exists'] = 1;
				header('Location:signup.php');
			}

		}

		else {

			$alreadyExists = (($collection -> count(array('username' => $username))) + ($collection -> count(array('email' => $email))));
			if(!$alreadyExists) {
				$user = array('district' => $dist, 'admin' => 0, 'name' => $name, 'username' => $username, 'pass' => $hashpass, 'email' => $email, 'active' => 1, 'verify' => crc32($email), "constituency" => $const);
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