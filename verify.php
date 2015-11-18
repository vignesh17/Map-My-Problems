<?php
	ob_start();

	$id = $_GET["id"];

	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> users;

	$collection -> update(array('verify' => $id), 
		array('$set' => array('active' => 1)));
	
	header('Location:login.php');

?>