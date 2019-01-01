<?php	
	require_once 'config/connection.php';
	session_start();
	$user_id = $_SESSION['user_id'];
	$user_role =  $_SESSION['user_type'];

	if ($user_role == 'SUPERVISOR') {
		$log_desc = "Logout.";
		$insert_log = "INSERT INTO petty_log (user, log_desc) VALUES (?, ?) ";
		$stmt = $pdo ->prepare($insert_log);
		$stmt -> bindParam(1, $user_id);
		$stmt -> bindParam(2, $log_desc);
		$stmt -> execute();
		session_destroy();
		header("Location: index.php");
			
	} else if ($user_role == 'TECHNICIAN') {	
		$log_desc = "User logout.";
		$insert_log = "INSERT INTO petty_log (user, log_desc) VALUES (?, ?) ";
		$stmt = $pdo ->prepare($insert_log);
		$stmt -> bindParam(1, $user_id);
		$stmt -> bindParam(2, $log_desc);
		$stmt -> execute();		
		session_destroy();
		header("Location: index.php");
	} else {
		session_destroy();
		header("Location: index.php");
	}


	


?>