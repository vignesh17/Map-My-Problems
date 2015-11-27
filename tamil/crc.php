<?php
	echo crc32("sivasubramanyama@gmail.com");
	$check = array("verify" => crc32("sivasubramanyama@gmail.com"));
	var_dump($check);
?>