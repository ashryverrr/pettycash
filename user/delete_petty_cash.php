<?php
	require_once '../config/connection.php';
	header('Content-Type: application/json');
	session_start();
	$user_id = $_SESSION['user_id'];
		$id = $_POST['del_id'];		
		$sql = "SELECT * FROM transaction WHERE trans_id = :id AND emp_id = :uid";
		$sql = $pdo -> prepare($sql);
		$sql -> bindParam(':id', $id);
		$sql -> bindParam(':uid', $user_id);
		$sql -> execute();
		$row_count = $sql -> rowCount();
		if ($row_count > 0) {				
			$row = $sql -> fetch();
			$ccr_status = $row['status'];				
			$ccr_cc_num = $row['cc_num'];			
			if ($ccr_status == 0) {
		  	$ccNum = explode(",", $ccr_cc_num);
		  	foreach ($ccNum as $key) {
		  		$sql = "UPDATE cc_number SET cc_num_status = 1 WHERE cc_number = :id1";
		  		$stmt = $pdo -> prepare($sql);
		  		$stmt -> bindParam(":id1", $key);
		  		$stmt -> execute();
		  	}	
			  $sql = "DELETE FROM transaction WHERE trans_id = :id1";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam(":id1", $id);
			  $stmt -> execute();
			  $sql = "DELETE FROM transaction_details WHERE trans_id = :id";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam(":id", $id);
			  $stmt -> execute();

  	  	  	  $log_desc = "Delete liquidation with CC# $ccr_cc_num.";
			  $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
		      $stmt = $pdo -> prepare($sql);
		      $stmt -> bindParam(':uid', $user_id);
		      $stmt -> bindParam(':log_desc', $log_desc);
		      $stmt -> execute();    


			  $response_array['status'] = 'success';
		      echo json_encode($response_array);
			} else if ($ccr_status == 1) {
			  $response_array['status'] = 'posted';
		      echo json_encode($response_array);
			} else {
			  $response_array['status'] = 'error';
		      echo json_encode($response_array);
			}
		} else {
			// INVALID CCR_ID
			$response_array['status'] = 'error';
		    echo json_encode($response_array);
		}
	$pdo = null;
?>