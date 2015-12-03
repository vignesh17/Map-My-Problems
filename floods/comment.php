<?php
	ob_start();

	$id = $_GET['id'];
	$comment = (string)$_POST['comment'];	
	if (strlen($_POST['comment']) < 2) {
		header('Location:admin.php');
	}	
	else {
		$m = new MongoClient();
		$db = $m -> map;
		$collection = $db -> floods;
		$idArray = array('_id' => new MongoId($id));
		$cursor = $collection -> find($idArray);
		foreach ($cursor as $doc) {
			$collection -> update($idArray, 
				array(
					'$push' => array(
									"comments" => $comment
								)
				)
			);
		}
		header('Location:admin.php');
	}	
?>
