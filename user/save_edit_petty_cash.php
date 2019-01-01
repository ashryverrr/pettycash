<?php
	require_once "../config/connection.php";
	require_once '../config/validate_tech.php';
	header('Content-type: application/json');
	$emp_id = $_POST['employee'];
	$trans_id = $_POST['trans_id'];	
	$cc_num = $_POST['cc_num'];
	$trans_date = $_POST['trans_date'];
	$amount = $_POST['trans_amount'];
	$client1 = $_POST['client'];
	$client = implode(",", $client1);
	$sql = "SELECT * FROM transaction WHERE trans_id = :trans_id AND status = 1";
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(":trans_id", $trans_id);
	$stmt -> execute();
	$checkStatus = $stmt -> rowCount();
	if ($checkStatus > 0) {
		$response_array['status'] = 'cannot_edit'; 
		echo json_encode($response_array);
	} else {
			$sql = "UPDATE transaction 
					SET client_name = :client_name,
					amount = :amount,
					trans_date = :trans_date
					WHERE trans_id = :trans_id ";
			$stmt = $pdo -> prepare($sql);
			$stmt -> bindParam(":trans_id", $trans_id);
			$stmt -> bindParam(":client_name", $client);
			$stmt -> bindParam(":amount", $amount);
			$stmt -> bindParam(":trans_date", $trans_date);		
			$stmt -> execute();
			$count = count($_POST['vehicle']);
			if ($count > 0) {
				for ($i = 0; $i < $count; $i++) { 	
				$vehicle = $_POST['vehicle'][$i];
				$description = $_POST['desc'][$i];
				$amount = $_POST['amount'][$i];					
				$detail_id = $_POST['detail_id'][$i] ?: "";				
				$sql = "SELECT detail_id FROM transaction_details WHERE detail_id = :detail_id";	
					$stmt = $pdo -> prepare($sql);
					$stmt -> bindParam(":detail_id", $detail_id);
					$stmt -> execute();
					$count_if = $stmt -> rowCount();
					if($count_if > 0){							
						$sql = "UPDATE transaction_details SET vehicle = :vehicle, expenses = :description, amount = :amount WHERE detail_id = :detail_id ";
							$stmt = $pdo -> prepare($sql);
							$stmt -> bindParam(":detail_id", $detail_id);
							$stmt -> bindParam(":vehicle", $vehicle);
							$stmt -> bindParam(":description", $description);
							$stmt -> bindParam(":amount", $amount);
							$stmt -> execute();									
					} else {
							$sql = "INSERT INTO transaction_details (trans_id, vehicle, expenses, amount) VALUES (:trans_id, :vehicle, :descr, :amount) ";
								$stmt = $pdo -> prepare($sql);								
								$stmt -> bindParam(":trans_id", $trans_id);
								$stmt -> bindParam(":vehicle", $vehicle);
								$stmt -> bindParam(":descr", $description);
								$stmt -> bindParam(":amount", $amount);
								$stmt -> execute();
					}
				}
			if (!empty($_POST['deletee'])) {
				$del11 = count($_POST['deletee']);
				if ($del11 > 0) {
					for($i = 0; $i < $del11; $i++){
					$checkbox = $_POST['deletee'][$i];
					$sql = "DELETE FROM transaction_details WHERE detail_id = :detail_id";
										$stmt = $pdo -> prepare($sql);
										$stmt -> bindParam(":detail_id", $checkbox);
										$stmt -> execute();	
					}
				}
			}	
					
			}
			$response_array['status'] = 'success'; 
			echo json_encode($response_array);
}
?>