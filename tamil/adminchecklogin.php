<?php
	ob_start();
	session_start();
	$username = $_POST['பயனர் பெயர்'];
	$password = md5($_POST['கடவுச்சொல்']);
	$const = $_POST["தொகுதியில்"];
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> users;
	$creds = array('title' => $username, 'pass' => $password, 'admin' => 1, 'constituency' => $const);
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
