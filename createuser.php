<?php
	ob_start();

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

    $to      = 'sivasubramanyama@gmail.com';
	$subject = 'the subject';
	$message = 'hello';
	$headers = 'From: contact@sivasubramanyam.me' . "\r\n" .
	    'Reply-To: contact@sivasubramanyam.me' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);

	header('Location:login.php');
     
}
?>