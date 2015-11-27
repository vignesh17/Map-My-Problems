<?php
	ob_start();
	session_start();

	$liveServer = 0;
	
	if(!isset($_POST["title"]) or !isset($_POST["name"]) or !isset($_POST["password"]) or !isset($_POST["cpass"])) {
		header('Location:signup.php');
	}

	$name = $_POST["name"];
	$title = $_POST["title"];
	$pass = $_POST["password"];
	$cpass = $_POST["cpassword"];
	$const = $_POST["constituency"];

	if(strcmp($pass, $cpass) == 0) {
		$hashpass = md5($pass);
	}

	else {
		$_SESSION['password-mismatch'] = 1;
		header('Location:signup.php');
	}

	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> users;

	

	if($liveServer) {

		$alreadyExists = (($collection -> count(array('title' => $title))) + ($collection -> count(array('constituency' => $const))));
		if($alreadyExists != 2) {
			$user = array('name' => $name, 'title' => $title, 'constituency' => $const, 'pass' => $hashpass, 'admin' => 1);
			$collection -> insert($user);
		    $subject = 'Confirmation';
			$message = 'Open this link to verify' . '<a href="map.com/verify.php?id='.crc32($email).'">map.com/verify.php?id='.crc32($email).'</a>';
			$to = '$email';
			$type = 'HTML'; 
			$charset = 'utf-8';

			$mail     = 'no-reply@'.str_replace('www.', '', $_SERVER['SERVER_NAME']);
			$uniqid   = md5(uniqid(time()));
			$headers  = 'From: '.$mail."\n";
			$headers .= 'Reply-to: '.$mail."\n";
			$headers .= 'Return-Path: '.$mail."\n";
			$headers .= 'Message-ID: <'.$uniqid.'@'.$_SERVER['SERVER_NAME'].">\n";
			$headers .= 'MIME-Version: 1.0'."\n";
			$headers .= 'Date: '.gmdate('D, d M Y H:i:s', time())."\n";
			$headers .= 'X-Priority: 3'."\n";
			$headers .= 'X-MSMail-Priority: Normal'."\n";
			$headers .= 'Content-Type: multipart/mixed;boundary="----------'.$uniqid.'"'."\n\n";
			$headers .= '------------'.$uniqid."\n";
			$headers .= 'Content-type: text/'.$type.';charset='.$charset.''."\n";
			$headers .= 'Content-transfer-encoding: 7bit';

			$ma = mail($to, $subject, $message, $headers);
		}
		else {
			$_SESSION['username-exists'] = 1;
			header('Location:signup.php');
		}

	}

	else {

		$alreadyExists = (($collection -> count(array('title' => $title, 'constituency' => $const))));
		if(!$alreadyExists) {
			$user = array('name' => "$name", 'title' => $title, 'constituency' => $const, 'pass' => $hashpass, 'admin' => 1);
			$collection -> insert($user);
			header('Location:login.php');
		}
		else {
			$_SESSION['username-exists'] = 1;
			header('Location:signup.php');
		}

	}
		
     
?>