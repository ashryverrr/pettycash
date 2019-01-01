<?php
	require_once "../config/connection.php";
	require_once '../config/validate_user.php';
	header('Content-type: application/json');
  	$user_id = $_SESSION['user_id'];
  	
	$ccr_id = $_POST['ccr_id'];
	$ccr_client = $_POST['ccr_client'];
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
	$sql = "SELECT ccr_status FROM cc_report WHERE ccr_id = :ccr_id AND ccr_status = 1";
	$stmt = $pdo -> prepare($sql);
	$stmt -> bindParam(":ccr_id", $ccr_id);
	$stmt -> execute();
	$checkStatus = $stmt -> rowCount();
	if ($checkStatus > 0) {
		$response_array['status'] = 'cannot_edit';
		echo json_encode($response_array);
	} else {		
			$sql = "UPDATE cc_report
					SET ccr_client = :ccr_client,
					ccr_date = :ccr_date,
					ccr_date_finished = :ccr_date_finished,
					ccr_time_start = :ccr_time_start,
					ccr_time_end = :ccr_time_end,
					ccr_model = :ccr_model,
					ccr_serial_nos = :ccr_serialnos,
					ccr_complaint = :ccr_complaint,
					rr_number = :rr_number,
					rr_date = :rr_date,
					ccr_remarks = :ccr_remark
					WHERE ccr_id = :ccr_id ";

			$stmt = $pdo -> prepare($sql);
			$stmt -> bindParam(":ccr_id", $ccr_id);
			$stmt -> bindParam(":ccr_client", $ccr_client);
			$stmt -> bindParam(":ccr_date", $ccr_date);
			$stmt -> bindParam(":ccr_date_finished", $ccr_date_finished);
			$stmt -> bindParam(":ccr_time_start", $ccr_time_start);
			$stmt -> bindParam(":ccr_time_end", $ccr_time_end);
			$stmt -> bindParam(":ccr_model", $ccr_model);
			$stmt -> bindParam(":ccr_serialnos", $ccr_serialnos);
			$stmt -> bindParam(":ccr_complaint", $ccr_complaint);
			$stmt -> bindParam(":rr_number", $ccr_rr);
			$stmt -> bindParam(":rr_date", $ccr_rr_date);
			$stmt -> bindParam(":ccr_remark", $ccr_remark);
			$stmt -> execute();

			if (isset($_POST['ccr_particulars'])) {
			$count = count($_POST['ccr_qty']);
				if ($count > 0) {
						for ($i = 0; $i < $count; $i++) {
						$ccr_qty = $_POST['ccr_qty'][$i];
						$ccr_particulars = $_POST['ccr_particulars'][$i] ?: "";
						$ccr_amt = $_POST['ccr_amt'][$i] ?: "";
						$ccr_serial = $_POST['ccr_serial'][$i];
						$ccr_info_id = $_POST['ccr_info_id'][$i];
						$sql = "SELECT * FROM cc_report_info WHERE ccr_info_id = :ccr_info_id";
						$stmt = $pdo -> prepare($sql);
						$stmt -> bindParam(":ccr_info_id", $ccr_info_id);
						$stmt -> execute();
						$count_if = $stmt -> rowCount();
							if($count_if > 0){
								$sql = "UPDATE cc_report_info SET  ccr_qty = :ccr_qty, ccr_particulars = :ccr_particulars, ccr_serial = :ccr_serial, ccr_amt = :ccr_amt WHERE ccr_info_id = :ccr_info ";
								$stmt = $pdo -> prepare($sql);
								$stmt -> bindParam(":ccr_info", $ccr_info_id);
								$stmt -> bindParam(":ccr_qty", $ccr_qty);
								$stmt -> bindParam(":ccr_serial", $ccr_serial);
								$stmt -> bindParam(":ccr_particulars", $ccr_particulars);
								$stmt -> bindParam(":ccr_amt", $ccr_amt);
								$stmt -> execute();
							} else  {
								$sql = "INSERT INTO cc_report_info (ccr_report_id, ccr_qty, ccr_particulars, ccr_amt, ccr_serial) VALUES (:ccr_report_id, :ccr_qty, :ccr_particulars, :ccr_amt, :ccr_serial) ";
								$stmt = $pdo -> prepare($sql);
								$stmt -> bindParam(":ccr_report_id", $ccr_id);
								$stmt -> bindParam(":ccr_qty", $ccr_qty);
								$stmt -> bindParam(":ccr_serial", $ccr_serial);
								$stmt -> bindParam(":ccr_particulars", $ccr_particulars);
								$stmt -> bindParam(":ccr_amt", $ccr_amt);
								$stmt -> execute();
							}							
						}		

						if (!empty($_POST['deletee'])) {
							$del11 = count($_POST['deletee']);
							if ($del11 > 0) {
								for($i = 0; $i < $del11; $i++){
								$checkbox = $_POST['deletee'][$i];
								$sql = "DELETE FROM cc_report_info WHERE ccr_info_id = :ccr_info_id";
								$stmt = $pdo -> prepare($sql);
								$stmt -> bindParam(":ccr_info_id", $checkbox);
								$stmt -> execute();
								}
									
							}
						}							
					}			
				}

	  $log_desc = "Edited customer call with CC# $ccr_cc.";
	  $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
      $stmt = $pdo -> prepare($sql);
      $stmt -> bindParam(':uid', $user_id);
      $stmt -> bindParam(':log_desc', $log_desc);
  	  $stmt -> execute();    

	$response_array['status'] = 'success';
	echo json_encode($response_array);
}
?>
