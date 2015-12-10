<?php
	ob_start();
	session_start();

	$liveServer = 0;
	
	if(!isset($_POST["title"]) or !isset($_POST["name"]) or !isset($_POST["password"]) or !isset($_POST["cpass"])) {
		header('Location:signup.php');
	}

	$name = $_POST["name"];
	$title = $_POST["title"];
	$pass = $_POST["password"];
	$cpass = $_POST["cpassword"];
	$const = $_POST["constituency"];
	$dist = $_POST["district"];
	$access = $_POST["access"];

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


	$alreadyExists = (($collection -> count(array('title' => $title, 'constituency' => $const))));
	if(!$alreadyExists) {
		$user = array('district' => $dist, 'access' => $access, 'name' => "$name", 'title' => $title, 'constituency' => $const, 'pass' => $hashpass, 'admin' => 1);
		$collection -> insert($user);
		header('Location:login.php');
	}
	else {
		$_SESSION['username-exists'] = 1;
		header('Location:signup.php');
	}


     
?>