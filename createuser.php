<?php
	ob_start();
	error_reporting(-1);
	ini_set('display_errors', 'On');
	set_error_handler("var_dump");

	if(!isset($_POST["name"]) or !isset($_POST["username"]) or !isset($_POST["password"]) or !isset($_POST["cpass"]) or !isset($_POST["email"])) {
		header('Location:signup.php');
	}

	$name = $_POST["name"];
	$username = $_POST["username"];
	$pass = $_POST["password"];
	$cpass = $_POST["cpass"];
	$email = $_POST["email"];

	if(strcmp($pass, $cpass) == 0) {
		$pass = md5($pass);
	}
	else {
		header('Location:signup.php');
	}

	$m = new MongoClient();
	$db = $m -> map;
	$collection = $db -> users;

	$user = array('name' => $name, 'username' => $username, 'pass' => $pass, 'email' => $email, 'active' => 0);
	$collection -> insert($user);

    $subject = 'subject';
	$message = 'message';
	$to = 'contact@sivasubramanyam.me';
	$type = 'plain'; // or HTML
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

	echo $ma;
	if($ma) {
		header('Location:login.php');
	}
     
?>