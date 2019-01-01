<?php
require_once 'config/connection.php';
header('Content-type: application/json');
session_start();
	$ccnum = trim($_POST['ccnum']);
	$trans_date = $_POST['trans_date'];
	$amount = $_POST['amount'];

	//$client_name = $_POST['client'];
	$ccNum = explode(", ", $ccnum);

	$clientName[] = "";
	foreach($ccNum as $key){
		$sql = "SELECT ccr_client FROM cc_report WHERE ccr_cc_num = :ccnum";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":ccnum", $key);
		$stmt -> execute();
		$row = $stmt -> fetch();
		$clientName[] .= $row['ccr_client'] ?: "";
	}
	
	$client_name = implode(",", $clientName);
		
	$client_account11 = "";
	$client_name1 =  explode(',', $client_name);
	foreach ($client_name1 as $key) {
		$sql = "SELECT client_account FROM clients 
			WHERE concat(client_name,' ',client_branch) LIKE :cclient_name";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":cclient_name", $key);
		$stmt -> execute();
		$row = $stmt -> fetch();
		$client_account11[] .= $row['client_account']; // if 2 or more clients value 
	}	

	$client_account = implode("/", $client_account11);	

	$ar = $_POST['others']; // IF ITS A MEETING ETC.
	if ($ccnum == "0000") {
		$sql = "INSERT INTO transaction (emp_id, cc_num, others, client_name, client_account, amount, trans_date) VALUES (:emp_name, :ccnum, :others, :client_name, :client_account, :amount, :trans_date)";
			$stmt = $pdo -> prepare($sql);
			$stmt -> bindParam(':emp_name', $emp_name);
			$stmt -> bindParam(':ccnum', $ccnum);
			$stmt -> bindParam(':others', $ar);
			$stmt -> bindParam(':client_name', $client_name);
			$stmt -> bindParam(':client_account', $client_account);
			$stmt -> bindParam(':amount', $amount);
			$stmt -> bindParam(':trans_date', $trans_date);
			if ($stmt -> execute()) {
				$response_array['status'] = 'success';
				$last_id = $pdo -> lastInsertId();
				$_SESSION['last_id'] = $pdo -> lastInsertId();
				echo json_encode($response_array);
			} else {
				$response_array['status'] = 'error';
				echo json_encode($response_array);
			}
	} else {
		$has_match = "SELECT cc_num FROM transaction WHERE cc_num = :cnum  ";
		$has_match = $pdo -> prepare($has_match);
		$has_match -> bindParam(':cnum', $ccnum);
		$has_match -> execute();
		$has_match_count = $has_match -> rowCount();
		if ( $has_match_count > 0){
			$response_array['status'] = 'exist';
			echo json_encode($response_array);
		} else {
			$sql = "INSERT INTO transaction (emp_id, cc_num, client_name, client_account, amount, trans_date) VALUES (:emp_name, :ccnum, :client_name, :client_account, :amount, :trans_date)";
			$stmt = $pdo -> prepare($sql);
			$stmt -> bindParam(':emp_name', $emp_name);
			$stmt -> bindParam(':ccnum', $ccnum);
			$stmt -> bindParam(':client_name', $client_name);
			$stmt -> bindParam(':client_account', $client_account);
			$stmt -> bindParam(':amount', $amount);
			$stmt -> bindParam(':trans_date', $trans_date);
			if ($stmt -> execute()) {
				$response_array['status'] = 'success';
				$last_id = $pdo -> lastInsertId();
				$_SESSION['last_id'] = $pdo -> lastInsertId();	

				$sql = "UPDATE cc_number SET cc_num_status = 2 WHERE cc_number = :ccnum ";
				$stmt = $pdo -> prepare($sql);
				$stmt -> bindParam(":ccnum", $ccnum);
				$stmt -> execute();

				echo json_encode($response_array);
			} else {
				$response_array['status'] = 'error';
				echo json_encode($response_array);
			}
		}
	}
	$pdo = null;
?>