<?php
	$hostname='localhost';
	$username='root';
	$password='';	

	$pdo = new PDO("mysql:host=$hostname; dbname=pettysystem", $username, $password);

	$pdo ->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if ($pdo) {
		#echo "CONNECTED.";
	} else {
		echo "ERROR";
		print_r($pdo->errorInfo());
	}

?>