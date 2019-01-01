<?php
	require_once "../config/connection.php";
	header('Content-type: application/json');
	session_start();
	$user_id = $_SESSION['user_id'];
	$ccr_client = addslashes($_POST['ccr_client']);		
	$client_account = $_POST['other_account'];
	$ccr_signedBy = $_POST['ccr_signedBy'];
	$ccr_cc = $_POST['ccr_cc'];
	$ccr_date = $_POST['ccr_date'];
	$ccr_date_finished = $_POST['ccr_date_fin'];
	$ccr_time_start = $_POST['ccr_time_start'];
	$ccr_time_end = $_POST['ccr_time_end'];
	$ccr_model = $_POST['ccr_model'];
	$ccr_serialnos = $_POST['ccr_serialnos'];
	$ccr_remark = $_POST['ccr_remark'];
	$ccr_complaint = $_POST['ccr_complaint'];
	$ccr_rr = $_POST['ccr_rr'];
	$ccr_rr_date = $_POST['ccr_rr_date'];

	$sql = "SELECT rr_count FROM rr_number WHERE rr_number = :rr_number ";
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(":rr_number", $ccr_rr);
	$stmt -> execute();
	$row = $stmt -> fetch();
	$rr_count1 = $row['rr_count'];	

	if ($rr_count1 != 0) {
		
		$rr_count = $rr_count1 - 1;	

		$sql = "UPDATE rr_number SET rr_count = :rr_count WHERE rr_number = :rr_number " ;
			$stmt = $pdo -> prepare($sql);
			$stmt -> bindParam(":rr_number", $ccr_rr);
			$stmt -> bindParam(":rr_count", $rr_count);
			$stmt -> execute();
	} else if ($rr_count1 === 1) {
		$rr_count = $rr_count1 - 1;	
		
		$sql = "UPDATE rr_number SET rr_count = :rr_count WHERE rr_number = :rr_number " ;
			$stmt = $pdo -> prepare($sql);
			$stmt -> bindParam(":rr_number", $ccr_rr);
			$stmt -> bindParam(":rr_count", $rr_count);
			$stmt -> execute();
	}



	$sql = "INSERT INTO cc_report (ccr_user_id, ccr_client, ccr_signedBy, ccr_client_account, ccr_cc_num, ccr_date, ccr_date_finished, ccr_time_start, ccr_time_end, ccr_model, ccr_serial_nos, ccr_complaint, rr_number, rr_date, ccr_remarks) VALUES (:ccr_uid, :ccr_client, :ccr_signedBy, :ccr_client_account,:ccr_cc, :ccr_date, :ccr_date_finished, :ccr_time_start, :ccr_time_end, :ccr_model, :ccr_serialnos, :ccr_complaint, :rr_number, :rr_date, :ccr_remark) ";
	
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(":ccr_uid", $user_id);
	$stmt -> bindParam(":ccr_client", $ccr_client);
	$stmt -> bindParam(":ccr_signedBy", $ccr_signedBy);
	$stmt -> bindParam(":ccr_client_account", $client_account);
	$stmt -> bindParam(":ccr_cc", $ccr_cc);
	$stmt -> bindParam(":ccr_date", $ccr_date);
	$stmt -> bindParam(":ccr_date_finished", $ccr_date_finished);
	$stmt -> bindParam(":ccr_time_start", $ccr_time_start);
	$stmt -> bindParam(":ccr_time_end", $ccr_time_end);
	$stmt -> bindParam(":ccr_model", $ccr_model);
	$stmt -> bindParam(":ccr_serialnos", $ccr_serialnos);
	$stmt -> bindParam(":ccr_remark", $ccr_remark);
	$stmt -> bindParam(":ccr_complaint", $ccr_complaint);
	$stmt -> bindParam(":rr_number", $ccr_rr);
	$stmt -> bindParam(":rr_date", $ccr_rr_date);
	if ($stmt -> execute()) {		
	$_SESSION['last_id'] = $pdo -> lastInsertId();
	$ccr_report_id = $_SESSION['last_id'];
	$sql = "UPDATE cc_number SET cc_num_status = '1' WHERE cc_number = :cc_num";
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(":cc_num", $ccr_cc);
	$stmt -> execute();	
	if (!empty($_POST['ccr_particulars'])) {
		$count = count($_POST['ccr_qty']);
		if ($count > 0) {
				for ($i=0; $i < $count; $i++) { 
				$ccr_qty = $_POST['ccr_qty'][$i];
				$ccr_particulars = $_POST['ccr_particulars'][$i];
				$ccr_amt = $_POST['ccr_amt'][$i];
				$ccr_serial = $_POST['ccr_serial'][$i];
					if (!empty($ccr_qty) && !empty($ccr_particulars) && !empty($ccr_serial) && !empty($ccr_amt)) {
						$sql = "INSERT INTO cc_report_info (ccr_report_id, ccr_qty, ccr_particulars, ccr_serial, ccr_amt) VALUES (:ccr_report_id, :ccr_qty, :ccr_particulars, :ccr_serial, :ccr_amt) ";
					$stmt = $pdo -> prepare($sql);
					$stmt -> bindParam(":ccr_report_id", $ccr_report_id);
					$stmt -> bindParam(":ccr_qty", $ccr_qty);
					$stmt -> bindParam(":ccr_particulars", $ccr_particulars);
					$stmt -> bindParam(":ccr_serial", $ccr_serial);
					$stmt -> bindParam(":ccr_amt", $ccr_amt);
						if ($stmt -> execute() ) {
						}
					}				
				} 

		$log_desc = "Created customer call with CC# $ccr_cc.";
	    $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':uid', $user_id);
        $stmt -> bindParam(':log_desc', $log_desc);
        $stmt -> execute();    

			  $response_array['status'] = 'success'; 
		      echo json_encode($response_array);

		} 
	} else {		

		$log_desc = "Created a customer call with CC# $ccr_cc.";
	    $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
        $stmt = $pdo -> prepare($sql);
        $stmt -> bindParam(':uid', $user_id);
        $stmt -> bindParam(':log_desc', $log_desc);
        $stmt -> execute();    

		$response_array['status'] = 'success'; 
		echo json_encode($response_array);     
		}
	}  else {
		// FIRST QUERY FAILED
		  $response_array['status'] = 'error'; 
		  echo json_encode($response_array);	
	}	
?>
