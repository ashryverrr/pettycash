<?php
	require_once '../config/connection.php';
	require_once '../config/validate_user.php';
	header('Content-type: application/json');
	$old_password = $_POST['old_pass_auth'];
	$new_password = $_POST['new_pass_auth'];
	$sql = "SELECT cc_auth_password FROM miscellaneous WHERE id = 1 ";
	$stmt = $pdo -> prepare($sql);
	$stmt -> execute();
	$row = $stmt -> fetch();
	$password = $row['cc_auth_password'];
	if ($password === $old_password) {
	//	$new_password = md5($new_password);
		$sql = "UPDATE miscellaneous SET cc_auth_password = :new_password WHERE id = 1 ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":new_password", $new_password);
		$stmt -> execute();
		$response_array['status'] = 'success';
		echo json_encode($response_array);
	} else {
		$response_array['status'] = 'wrong';
		echo json_encode($response_array);
	}
?>