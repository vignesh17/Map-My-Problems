<?php
	ob_start();

	$id = $_GET["id"];

	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> users;

	$user = array('name' => $name, 'username' => $username, 'pass' => $pass, 'email' => $email, 'active' => 0, 'verify' => crc32($email));
	$collection -> update(array('verify' => $id), array('active' => 1));
	header('Location:login.php');

?>