<?php
	require_once "../config/connection.php";
	require_once '../config/validate_tech.php';
	header('Content-type: application/json');
  	$user_id = $_SESSION['user_id'];

  	$id = $_POST['ar_id'];        
    $ar_client = $_POST['ar_client'];
    $ar_client = implode(",", $ar_client);
    $ar_date_started = $_POST['ar_date_started'];
    $ar_time_start = $_POST['ar_time_start'];
    $ar_time_end = $_POST['ar_time_end'];
    $ar_activity = $_POST['ar_activity'];

    $sql = "SELECT ar_id FROM activity_report WHERE ar_user_id = :ar_uid AND ar_id = :id";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":ar_uid", $user_id);
    $stmt -> bindParam(":id", $id);
    $stmt -> execute();
    $rowCount = $stmt -> rowCount();

    if ($rowCount > 0) {
    	$sql = "UPDATE activity_report
			SET ar_client = :ar_client,
			ar_date_started = :ar_date_started,			
			ar_time_start = :ar_time_start,
			ar_time_end = :ar_time_end,	
			ar_activity = :ar_activity
			WHERE ar_id = :ar_id ";

		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":ar_client", $ar_client);
		$stmt -> bindParam(":ar_date_started", $ar_date_started);
		$stmt -> bindParam(":ar_time_start", $ar_time_start);
		$stmt -> bindParam(":ar_time_end", $ar_time_end);
		$stmt -> bindParam(":ar_activity", $ar_activity);
		$stmt -> bindParam(":ar_id", $id);
		if ($stmt -> execute() ) {		
			 $log_desc = "Edited activity report.";
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
    } else {
    	$response_array['status'] = 'not_allowed';
		echo json_encode($response_array);
    }

	
?>
