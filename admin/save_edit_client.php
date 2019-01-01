<?php
	require_once "../config/connection.php";
	require_once '../config/validate_user.php';
	header('Content-type: application/json');

	$client_id = $_POST['client_id'];
    $client_person = $_POST['client_person'];
    $client_name = $_POST['client_name'];
    $client_branch = $_POST['client_branch'];
    $client_address = $_POST['client_address'];
    $client_account = $_POST['client_account'];
    $client_contact_num = $_POST['client_contact_num'];
    $client_contract_start = $_POST['client_contract_start'];
    $client_contract_end = $_POST['client_contract_end'];  
     
    $sql = "UPDATE clients SET client_person = :client_person, client_name = :client_name, client_branch = :client_branch, client_address = :client_address, client_account = :client_account, client_contact_num =:client_contact_num, client_contract_start = :client_contract_start, client_contract_end = :client_contract_end WHERE client_id = :client_id ";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":client_person", $client_person);
    $stmt -> bindParam(":client_name", $client_name);
    $stmt -> bindParam(":client_branch", $client_branch);
    $stmt -> bindParam(":client_address", $client_address);
    $stmt -> bindParam(":client_account", $client_account);
    $stmt -> bindParam(":client_contact_num", $client_contact_num);
    $stmt -> bindParam(":client_contract_start", $client_contract_start);
    $stmt -> bindParam(":client_contract_end", $client_contract_end);
    $stmt -> bindParam(":client_id", $client_id);
    $stmt -> execute();
  	$response_array['status'] = 'success'; 
	echo json_encode($response_array);
?>