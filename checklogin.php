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
    	$username = (string)$_POST['username'];
		$password = md5((string)$_POST['password']);
		$m = new MongoClient();
		$db = $m -> map;
		$collection = $db -> users;
		$constituency = "";
		$fullname = "";
		$cursor = $collection -> find(array('username' => $username));
	    foreach ($cursor as $doc) {
	        $constituency = $doc["constituency"];
	        $fullname = $doc["name"];
	        $dist = $doc["district"];
	    }
		$creds = array('username' => $username, 'pass' => $password, 'active' => 1);
		$count = $collection -> count($creds);
		if ($count) {
			$_SESSION['username'] = $username;
			$_SESSION['fullname'] = $fullname;
			$_SESSION['constituency'] = $constituency;

			$collection = $db -> attempts;
			$incorrectAttempts = $collection -> count(array("ip" => $_SERVER['REMOTE_ADDR']));
			if (!$incorrectAttempts) {
				header('Location:report.php');
			}
			else {
				$attempts = $collection -> find(array("ip" => $_SERVER['REMOTE_ADDR']));
				foreach ($attempts as $attempt) {
					$isBlocked = $attempt["blocked"];
					if ($isBlocked) {
						$_SESSION["locked"] = 1;
						header('Location:login.php');
					}
					else {
						$collection -> update(array('ip' => $_SERVER['REMOTE_ADDR']), array('$set' => array('count' => 0)));
						header('Location:report.php');
					}
				}
			}

		}
		else {

			$collection = $db -> attempts;
			$incorrectAttempts = $collection -> count(array("ip" => $_SERVER['REMOTE_ADDR']));
			if ($incorrectAttempts) {
				$attempts = $collection -> find(array("ip" => $_SERVER['REMOTE_ADDR']));
				foreach ($attempts as $attempt) {
					$wrongAttempts = $attempt["count"];
					if ($wrongAttempts < 3) {
						$collection -> update(array("ip" => $_SERVER['REMOTE_ADDR']), array('$inc' => array("count" => 1)));
					}
					else {
						$collection -> update(array("ip" => $_SERVER['REMOTE_ADDR']), array('$set' => array("blockedAt" => new MongoDate(), "blocked" => 1)));
						$collection->ensureIndex(array('blockedAt' => 1), array('expireAfterSeconds' => 900));
						$_SESSION["locked"] = 1;
					}
				}
			}
			else {
				$collection -> insert(array("ip" => $_SERVER['REMOTE_ADDR'], "count" => 1));
			}

			$_SESSION['login-error'] = 1;
			header('Location:login.php');
		}
  	} 

  	else {
  		$_SESSION['login-error'] = 2;
		header('Location:login.php');
  	}

	
?>