<?php
	require_once '../config/connection.php';
	header('Content-Type: application/json');
	session_start();
		$id = $_POST['del_id'];
		$sql = "SELECT * FROM clients WHERE client_id = :id";
		$sql = $pdo -> prepare($sql);
		$sql -> bindParam(':id', $id);
		$sql -> execute();
		$row_count = $sql -> rowCount();
		if ($row_count > 0) {
			$sql = "DELETE FROM clients WHERE client_id = :id";
			$stmt = $pdo -> prepare($sql);
			$stmt -> bindParam(":id", $id);
			$stmt -> execute();
			$response_array['status'] = 'success';
		    echo json_encode($response_array);
		} else {			
			$response_array['status'] = 'error';
		    echo json_encode($response_array);
		}
?>