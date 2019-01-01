<?php
require_once '../config/connection.php';
require_once '../config/validate_user.php';
$emp_name = $_POST['emp_name'];
$password = $_POST['password'];
$account_type = $_POST['account_type'];
$sql = "INSERT INTO users (emp_name, password, user_role) VALUES (:emp_name, :password, :account_type)";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(':emp_name', $emp_name);
$stmt -> bindParam(':password', $password);
$stmt -> bindParam(':account_type', $account_type);
$stmt -> execute();
?>