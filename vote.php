<?php
	ob_start();
	session_start();
	if(isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$fromuser = $_GET['user'];
		$operation = $_GET['vote'];
		$id = $_GET['id'];
		if(strcmp($username, $fromuser) == 0) {
			$m = new MongoClient();
			$db = $m -> map;
			$collection = $db -> reports;
			$idArray = array('_id' => new MongoId($id));
			$cursor = $collection -> find($idArray);
			if(strcmp($operation, "up") == 0) {
				foreach ($cursor as $doc) {
					if(!in_array($fromuser, $doc["voters"])){
						$collection -> update($idArray, 
							array('$push' => array("voters" => $fromuser),
								'$inc' => array("votes" => 1)
							)
						);
					}
					else {
						break;
					}
				}
			}
			else {
				foreach ($cursor as $doc) {
					if(in_array($fromuser, $doc["voters"])){
						$collection -> update($idArray, 
							array('$pull' => array("voters" => $fromuser),
								'$inc' => array("votes" => -1)
							)
						);
					}
					else {
						break;
					}
				}
			}
		}
		header('Location:report.php');
	}
	else {
		header('Location:login.php');
	}
?>
