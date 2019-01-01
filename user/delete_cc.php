<?php
	require_once '../config/connection.php';
	header('Content-Type: application/json');
	session_start();
		$user_id = $_SESSION['user_id'];
		$id = $_POST['del_id'];
		$sql = "SELECT * FROM cc_report WHERE ccr_id = :id";
		$sql = $pdo -> prepare($sql);
		$sql -> bindParam(':id', $id);
		$sql -> execute();
		$row_count = $sql -> rowCount();
		if ($row_count > 0) {
			$row = $sql -> fetch();
			$ccr_status = $row['ccr_status'];
			$ccr_cc_num = $row['ccr_cc_num'];
			if ($ccr_status == 0) {				
		  	  $sql = "UPDATE cc_number SET cc_num_status = 0 WHERE cc_number = :id1";
	  		  $stmt = $pdo -> prepare($sql);
	  		  $stmt -> bindParam(":id1", $ccr_cc_num);
	  		  $stmt -> execute();

			  $sql = "DELETE FROM cc_report WHERE ccr_id = :id1";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam(":id1", $id);
			  $stmt -> execute();

			  $sql = "DELETE FROM cc_report_info WHERE ccr_report_id = :id";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam(":id", $id);
			  $stmt -> execute();

			  $log_desc = "Delete customer call with CC# $ccr_cc_num.";
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
?>