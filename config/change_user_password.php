<?php
	require_once '../config/connection.php';
	header('Content-Type: application/json');
	session_start();
	$user_id = $_SESSION['user_id'];
	$old_password = $_POST['change_user_password_old'];
	$new_password = $_POST['change_user_password_new'];
	$sql = "SELECT user_id FROM users WHERE user_id = :uid AND password = :password";
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(":uid", $user_id);
	$stmt -> bindParam(":password", $old_password);
	$stmt -> execute();
	$count_row = $stmt -> rowCount();
	if ($count_row > 0) {
		$sql = "UPDATE users SET password = :password WHERE user_id = :uid";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":uid", $user_id);
		$stmt -> bindParam(":password", $new_password);
		$stmt -> execute();
		$response_array['status'] = 'success';
		echo json_encode($response_array);
	} else  {
		 $response_array['status'] = 'error';
		 echo json_encode($response_array);
	}

?>