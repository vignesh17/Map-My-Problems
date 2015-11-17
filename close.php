<?php
	$id = $_GET['id'];
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> reports;
	$idArray = array('_id' => new MongoId($id));
	$cursor = $collection -> update($idArray, array('$set' => array("status" => "closed")));
	header('Location:report.php');
?>
