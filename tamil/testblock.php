<?php
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> attempts;
	$incorrectAttempts = $collection -> count(array("ip" => $_SERVER['REMOTE_ADDR']));
	var_dump($incorrectAttempts);
?>