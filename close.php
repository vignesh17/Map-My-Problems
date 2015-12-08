<?php
	ob_start();
	session_start();
	if (!isset($_SESSION['username'])) {
		header('Location:login.php');
	}
	$id = $_GET['id'];
	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> reports;
	$idArray = array('_id' => new MongoId($id));
	$cursor = $collection -> find($idArray);
	foreach ($cursor as $doc) {
		echo $doc["username"]."   ".$_SESSION["username"]; 
		if ($doc["username"] == $_SESSION["username"]) {
			$cursor = $collection -> update($idArray, array('$set' => array("status" => "closed")));
			header('Location:report.php');
		}
	}


	
?>
