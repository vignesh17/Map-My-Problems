<?php
	ob_start();
	session_start();
	//https://github.com/IQAndreas/php-spam-filter
	require_once 'spamfilter.php';

	if(isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$fromuser = $_GET['user'];
		$id = $_GET['id'];
		$comment = $_POST['comment'];		
		$filter = new SpamFilter();
		$result = $filter->check_text($comment);
		if ($result) {
			$_SESSION['spam'] = 1;
			header('Location:login.php');
		}
		else {
			if(strcmp($username, $fromuser) == 0) {
				$m = new MongoClient();
				$db = $m -> map;
				$collection = $db -> reports;
				$idArray = array('_id' => new MongoId($id));
				$cursor = $collection -> find($idArray);
				foreach ($cursor as $doc) {
					$collection -> update($idArray, 
						array('$push' => array("comments" => $comment, 
							"commenters" => $username)
						)
					);
				}
			}
			header('Location:report.php');
		}
	}
	else {
		header('Location:login.php');
	}
?>
