<?php
	ob_start();
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> floods;
	$type = $_POST["type"];
	$details = $_POST["details"];
	$person = $_POST["person"];
	$contact = $_POST["contact"];
	$location = $_POST["location"];
	$coords = $_POST["coords"];
	$report = array('comments' => array(),
		'type' => $type, 
		'details' => $details, 'location' => $location, 
		'coords' => $coords, 'person' => $person, 
		'time' => new MongoDate(),
		'contact' => $contact
	);
	$collection -> insert($report);
?>