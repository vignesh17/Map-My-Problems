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
    	$username = $_POST['username'];
		$password = md5($_POST['password']);
		$m = new MongoClient();
		$db = $m -> map;
		$collection = $db -> users;
		$constituency = "";
		$cursor = $collection -> find(array('username' => $username));
	    foreach ($cursor as $doc) {
	        $constituency = $doc["constituency"];
	    }
		$creds = array('username' => $username, 'pass' => $password, 'active' => 1);
		$count = $collection -> count($creds);
		if ($count) {
			$_SESSION['username'] = $username;
			$_SESSION['constituency'] = $constituency;
			header('Location:report.php');
		}
		else {
			$_SESSION['login-error'] = 1;
			header('Location:login.php');
		}
  	} 

  	else {
  		$_SESSION['login-error'] = 2;
		header('Location:login.php');
  	}

	
?>