<?php
	session_start();
	$user_role = $_SESSION['user_type'];

	if ($user_role == "ACCOUNTING") {
		
	} else {
		session_destroy();
		header("Location: ../index.php");
	}


?>