<?php
	ob_start();
	session_start();


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

		$email = $_POST["email"];
		$key = $_SESSION["id"];
		$pass = $_POST["password"];
		$cpass = $_POST["cpassword"];
		$const = $_POST["constituency"];

		$m = new MongoClient();
		$db = $m -> map;
		$collection = $db -> forgot;

		$check = $collection -> count(array('email' => $email, 'key' => $key));
		if($check) {
			if(strcmp($pass, $cpass) == 0) {
				$hashpass = md5($pass);
			}

			else {
				$_SESSION['password-mismatch'] = 1;
				header('Location:profileupdate.php');
			}

			$collection = $db -> users;
			$collection -> update(array('email' => $email), array('$set' => array('pass' => $hashpass, 'constituency' => $const)));
			$collection = $db -> forgot;
			$collection -> remove(array('email' => $email));
			$_SESSION['reset'] = 1;
			header('Location:login.php');
		}

		else {
			$_SESSION['invalid'] = 1;
			header('Location:profileupdate.php');
		}

	}


	else {
		$_SESSION['captcha'] = 1;
		header('Location:profileupdate.php');
	}
     
?>