<?php
require_once "../config/connection.php";
require_once '../config/validate_user.php';
header('Content-Type: application/json');
$user_id = $_SESSION['user_id'];
$cc_emp_id = $_POST['cc_emp_id'];
$cc_num_start = $_POST['cc_num_start'];
$cc_num_end = $_POST['cc_num_end'];
$sql = "SELECT cc_id FROM cc_number WHERE cc_number BETWEEN :cc_number AND :cc_number_end ";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(":cc_number", $cc_num_start);
$stmt -> bindParam(":cc_number_end", $cc_num_end);
$stmt -> execute();
$count = $stmt -> rowCount();
if ($count > 0) {
	$response_array['status'] = 'exist';
	echo json_encode($response_array);
} else {
	for ($i = $cc_num_start ; $i <= $cc_num_end ; $i++) { 	
		$sql = "INSERT INTO cc_number (cc_number, cc_user_id ) VALUES (:cc_number, :cc_user_id) ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":cc_number", $i);
		$stmt -> bindParam(":cc_user_id", $cc_emp_id);		
		$stmt -> execute();		
	}


	$sql = "INSERT INTO cc_history (cc_history_emp, cc_history_start, cc_history_end ) VALUES (:cc_emp, :cc_start, :cc_end) ";
	$stmt = $pdo -> prepare($sql);		
	$stmt -> bindParam(":cc_emp", $cc_emp_id);		
	$stmt -> bindParam(":cc_start", $cc_num_start);
	$stmt -> bindParam(":cc_end", $cc_num_end);
	$stmt -> execute();	

	$log_desc = "Assigned CC Number from $cc_num_start to $cc_num_end.";		
	$sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
	$stmt = $pdo -> prepare($sql);				
	$stmt -> bindParam(':uid', $user_id);
  	$stmt -> bindParam(':log_desc', $log_desc);
	$stmt -> execute();	

	$response_array['status'] = 'success';
	echo json_encode($response_array);	
}
?>