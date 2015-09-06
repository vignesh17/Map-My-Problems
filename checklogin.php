<?php
	ob_start();
	session_start();
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> users;
	$creds = array('username' => $username, 'password' => $password, 'active' => 1);
	$count = $collection -> count($creds);
	if ($count) {
		$_SESSION['username'] = $username;
		header('Location:report.php');
	}
	else {
		$_SESSION['login-error'] = 1;
		header('Location:login.php');
	}
?>