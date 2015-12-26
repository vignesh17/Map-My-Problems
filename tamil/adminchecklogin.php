<?php
	ob_start();
	session_start();
	$பயனர் பெயர் = $_POST['username'];
	$கடவுச்சொல் = md5($_POST['password']);
	$கான்ஸ்ட் = $_POST["constituency"];
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> users;
	$creds = array('title' => $பயனர் பெயர், 'pass' => $password, 'admin' => 1, 'constituency' => $const);
	$count = $collection -> count($creds);
	if ($count) {
		$_SESSION['username'] = $username;
		$_SESSION['admin'] = 1;
		$_SESSION['constituency'] = $const;
		header('Location:report.php');
	}
	else {
		$_SESSION['login-error'] = 1;
		header('Location:login.php');
	}
?>
