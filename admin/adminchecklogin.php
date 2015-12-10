<?php
	ob_start();
	session_start();
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$const = $_POST["constituency"];
	$dist = $_POST["district"];
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> users;
	$creds = array('title' => $username, 'pass' => $password, 'admin' => 1, 'constituency' => $const);
	$cursor = $collection -> find($creds);
	$count = $cursor -> count();
	if ($count) {
		foreach ($cursor as $doc) {
			if ($doc["access"] == "constituency") {
				$_SESSION['access'] = 'constituency';
			}
			else if ($doc["access"] == "district") {
				$_SESSION['access'] = 'district';
			}
			else {
				$_SESSION['access'] = 'state';
			}
		}
		$_SESSION['username'] = $username;
		$_SESSION['admin'] = 1;
		$_SESSION['constituency'] = $const;
		$_SESSION['district'] = $dist;
		header('Location:reportadmin.php');
	}
	else {
		$_SESSION['login-error'] = 1;
		header('Location:login.php');
	}
?>