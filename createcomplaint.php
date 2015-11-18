<?php
	ob_start();
	session_start();
	//https://github.com/IQAndreas/php-spam-filter
	require_once 'spamfilter.php';

	if(isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$m = new MongoClient();
		$db = $m -> map;
		$collection = $db -> reports;
		$constituency = $_SESSION["constituency"];
		$title = htmlspecialchars(($_POST["title"]));
		$description = str_replace("\n", "<br/>", nl2br($_POST["description"]));
		$filter = new SpamFilter();
		$result = $filter->check_text($_POST["title"]);
		if ($result) {
			header("HTTP/1.0 403 Forbidden");
		}
		else {
			$result = $filter->check_text($_POST["description"]);
			if ($result) {
				header("HTTP/1.0 403 Forbidden");
			}
			else {
				$location = $_POST["location"];
				$coords = $_POST["coords"];
				$taggedAt = $_POST["taggedAt"];
				$dt = new DateTime(date('Y-m-d'), new DateTimeZone('UTC'));
				$ts = $dt->getTimestamp();
				$today = new MongoDate($ts);
				$report = array('comments' => array(), 'commenters' => array(), 
					'votes' => 0, 'voters' => array(), 'title' => $title, 
					'description' => $description, 'location' => $location, 
					'coords' => $coords, 'username' => $username, 
					'time' => new MongoDate(),
					'taggedAt' => $taggedAt,
					'constituency' => $constituency,
					'status' => "open",
				);
				$collection -> insert($report);
				header('Location:report.php');
			}
		}
	}
	else {
		header('Location:login.php');
	}
?>