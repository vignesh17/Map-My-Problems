<?php
	session_start();
	$username = $_SESSION['username'];
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> reports;
	$title = $_POST["title"];
	$description = $_POST["description"];
	$location = $_POST["location"];
	$coords = $_POST["coords"];
	$dt = new DateTime(date('Y-m-d'), new DateTimeZone('UTC'));
	$ts = $dt->getTimestamp();
	$today = new MongoDate($ts);
	$report = array('title' => $title, 'description' => $description, 'location' => $location, 'coords' => $coords, 'username' => $username, 'time' => new MongoDate());
	$collection -> insert($report);
	header('Location:report.php');
?>