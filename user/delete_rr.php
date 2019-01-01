<?php
	require_once '../config/connection.php';
	header('Content-Type: application/json');
	session_start();
	$user_id = $_SESSION['user_id'];
	$user_role = $_SESSION['user_type'];
	$id = $_POST['del_id'];
	if ($user_role == 'ACCOUNTING') {
		$sql = "SELECT rem_id, rem_ctr_no FROM remittance_report WHERE rem_status = 0";
		$sql = $pdo -> prepare($sql);
		$sql -> bindParam(':id', $id);
		$sql -> execute();
		$row1 = $sql -> fetch();
		$rem_ctr_no = $row1['rem_ctr_no'];
		$row_count = $sql -> rowCount();
		if ($row_count > 0) {
			  $sql = "DELETE FROM remittance_report WHERE rem_id = :id";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam(":id", $id);
			  $stmt -> execute();

			  $sql = "DELETE FROM rr_number WHERE rr_number = :rr_number ";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam(":rr_number", $rem_ctr_no);
			  $stmt -> execute();
			  
			  /**
			  $row = $stmt -> fetch();
			  $rr_count1 = $row['rr_count'];
			  $rr_count = $rr_count1 + 1;
			  $sql = "UPDATE rr_number SET rr_count = :rr_count WHERE rr_number = :rrnumber
			  ";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam(":rr_count", $rr_count);
			  $stmt -> bindParam(":rrnumber", $rem_ctr_no);
			  $stmt -> execute();
			  **/

			  $response_array['status'] = 'success';
		      echo json_encode($response_array);
		} else if($row_count == 0) {
			  $response_array['status'] = 'doesnot';
		      echo json_encode($response_array);
		} else {
			  $response_array['status'] = 'error';
		      echo json_encode($response_array);
		}
	} else {
		$sql = "SELECT rem_id, rem_ctr_no FROM remittance_report WHERE rem_id = :id AND rem_emp_id = :uid ";
		$sql = $pdo -> prepare($sql);
		$sql -> bindParam(':id', $id);
		$sql -> bindParam(':uid', $user_id);
		$sql -> execute();
		$row1 = $sql -> fetch();
		$rem_ctr_no = $row1['rem_ctr_no'];
		$row_count = $sql -> rowCount();

		$sql = "DELETE FROM rr_number WHERE rr_number = :rr_number ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":rr_number", $rem_ctr_no);
		$stmt -> execute();
			  		
		if ($row_count > 0) {
			  $sql = "DELETE FROM remittance_report WHERE rem_id = :id";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam(":id", $id);			  
			  $stmt -> execute();
			  $response_array['status'] = 'success';
		      echo json_encode($response_array);
		} else if($row_count == 0) {
			  $response_array['status'] = 'doesnot';
		      echo json_encode($response_array);
		} else {
			  $response_array['status'] = 'error';
		      echo json_encode($response_array);
		}
	}	
		
	$pdo = null;
?>