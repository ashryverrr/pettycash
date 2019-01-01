<?php
	require_once '../config/connection.php';
	header('Content-Type: application/json');
	session_start();
	$user_id = $_SESSION['user_id'];
	$id = $_POST['del_id'];
		$sql = "SELECT ar_id FROM activity_report WHERE ar_id = :id";
		$sql = $pdo -> prepare($sql);
		$sql -> bindParam(':id', $id);
		$sql -> execute();
		$row_count = $sql -> rowCount();
		if ($row_count > 0) {
			  $sql = "DELETE FROM activity_report WHERE ar_id = :id";
			  $stmt = $pdo -> prepare($sql);
			  $stmt -> bindParam("id", $id);
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
		
	$pdo = null;
?>