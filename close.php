<?php
	ob_start();
	session_start();
	if(isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$id = $_GET['id'];
		$m = new MongoClient();
		$db = $m -> map;
		$collection = $db -> reports;
		$idArray = array('_id' => new MongoId($id));
		$cursor = $collection -> find($idArray);
		$postedBy = "";
		foreach ($cursor as $doc) {
			$postedBy = $doc["username"];
		}
		if(strcmp($username, $postedBy) == 0) {
			$cursor = $collection -> remove($idArray);
			header('Location:report.php');
		}
		else {
			header('Location:login.php');
		}
	}
	else {
			header('Location:login.php');
	}
?>
