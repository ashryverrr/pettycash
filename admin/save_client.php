<?php
require_once '../config/connection.php';
header('Content-Type: application/json');
session_start();
$client_name = $_POST['client_name'];
$client_person = $_POST['client_person'];
$client_branch = $_POST['branch_name'];
$client_account = $_POST['client_type'];
$client_contact_num = $_POST['client_contact_num'];
$client_address = $_POST['client_address'];
$contract_start = $_POST['contract_start'];
$contract_end = $_POST['contract_end'];

$checkExist = "SELECT client_id FROM clients WHERE client_name = :client_name AND client_branch = :client_branch"; 
$checkExist = $pdo -> prepare($checkExist);
$checkExist -> bindParam(':client_name', $client_name);
$checkExist -> bindParam(':client_branch', $client_branch);
$checkExist -> execute();
$check_row = $checkExist -> rowCount();
if ($check_row > 0) {
	$response_array['status'] = 'exist';
	echo json_encode($response_array);
} else {
	$sql = "INSERT INTO clients (client_person, client_name, client_branch, client_account, client_contact_num, client_address, client_contract_start, client_contract_end) VALUES (:client_person, :client_name, :client_branch, :client_account, :client_contact_num, :client_address, :client_contract_start, :client_contract_end)";
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(':client_person', $client_person);
	$stmt -> bindParam(':client_name', $client_name);
	$stmt -> bindParam(':client_branch', $client_branch);
	$stmt -> bindParam(':client_account', $client_account);
	$stmt -> bindParam(':client_contact_num', $client_contact_num);
	$stmt -> bindParam(':client_address', $client_address);
	$stmt -> bindParam(':client_contract_start', $contract_start);
	$stmt -> bindParam(':client_contract_end', $contract_end);
	if ($stmt -> execute()){	
		$user_id = $_SESSION['user_id'];
		$log_desc = "Added a new client.";
		$sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(':uid', $user_id);
		$stmt -> bindParam(':log_desc', $log_desc);
		$stmt -> execute();
		$response_array['status'] = 'success';
		echo json_encode($response_array);
	} else {
		$response_array['status'] = 'error'; 
		echo json_encode($response_array);
	}
}
$pdo = null;
?>