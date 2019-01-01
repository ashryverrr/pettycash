<?php
	require_once "../config/connection.php";
	header('Content-type: application/json');
	session_start();
	$user_id = $_SESSION['user_id'];
	$ccr_client = $_POST['ar_client'];
	$ccr_client = implode(",", $ccr_client);
	$client_account11 = "";
	$client_name1 =  explode(',', $ccr_client);
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
	$ccr_date = $_POST['ar_date'];
	$ccr_time_start = $_POST['ar_time_start'];
	$ccr_time_end = $_POST['ar_time_end'];
	$ccr_remark = $_POST['ar_remark'];	
	$sql = "INSERT INTO activity_report (ar_user_id, ar_client, ar_client_account, ar_date_started, ar_time_start, ar_time_end, ar_activity) VALUES (:ccr_uid, :ccr_client, :ccr_client_account, :ccr_date, :ccr_time_start, :ccr_time_end, :ccr_remark) ";
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(":ccr_uid", $user_id);
	$stmt -> bindParam(":ccr_client", $ccr_client);
	$stmt -> bindParam(":ccr_client_account", $client_account);
	$stmt -> bindParam(":ccr_date", $ccr_date);
	$stmt -> bindParam(":ccr_time_start", $ccr_time_start);
	$stmt -> bindParam(":ccr_time_end", $ccr_time_end);	
	$stmt -> bindParam(":ccr_remark", $ccr_remark);
	if ($stmt -> execute()) {		
		$log_desc = "Created Activity report.";
	    $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':uid', $user_id);
        $stmt -> bindParam(':log_desc', $log_desc);
        $stmt -> execute();    
		$response_array['status'] = 'success'; 
		echo json_encode($response_array);
	}  else {
		// FIRST QUERY FAILED
		$response_array['status'] = 'error'; 
		echo json_encode($response_array);	
	}	
?>
