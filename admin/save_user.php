<?php
require_once '../config/validate_user.php';
require_once '../config/connection.php';
header('Content-Type: application/json');
$emp_name = $_POST['empname'];
$username = $_POST['emp_name_username'];
$password_user = $_POST['password_user'];
$account_type = $_POST['account_type'];
$sql = "SELECT user_id FROM users WHERE emp_name = :empname OR username = :username ";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(':empname', $emp_name);
$stmt -> bindParam(':username', $username);
$stmt -> execute();
$countrows = $stmt -> rowCount();
if ($countrows > 0 ) {
	$response_array['status'] = 'exist';
	echo json_encode($response_array);
} else {
	$sql = "INSERT INTO users (username, emp_name, password, user_role) VALUES (:username, :emp_name, :password, :account_type)";
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':username', $username);
	$stmt -> bindParam(':emp_name', $emp_name);
	$stmt -> bindParam(':password', $password_user);
	$stmt -> bindParam(':account_type', $account_type);
	$stmt -> execute();		
		$user_id = $_SESSION['user_id'];
		$log_desc = "Added a new user.";
		$sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(':uid', $user_id);
		$stmt -> bindParam(':log_desc', $log_desc);
		$stmt -> execute();
		$response_array['status'] = 'success';
		echo json_encode($response_array);
}
?>