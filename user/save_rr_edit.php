<?php
	require_once "../config/connection.php";
	require_once '../config/validate_tech.php';
	header('Content-type: application/json');
  	$user_id = $_SESSION['user_id'];

  	$id = $_POST['rem_id'];        
  	$rem_date = $_POST['rem_date'];


    $sql = "SELECT rem_id FROM remittance_report WHERE rem_id = :id AND rem_emp_id = :userid ";
    $stmt = $pdo -> prepare($sql);    
    $stmt -> bindParam(":id", $id);
    $stmt -> bindParam(":userid", $user_id);
    $stmt -> execute();
    $rowCount = $stmt -> rowCount();

    $sql = "UPDATE remittance_report SET rem_date = :rdate WHERE rem_id = :id ";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":id", $id);
    $stmt -> bindParam(":rdate", $rem_date);
    $stmt -> execute();

    if ($rowCount > 0) {
    $count = count($_POST['rem_amount']);

		  	for ($i = 0; $i < $count; $i++) {
		  	 $rem_particulars = $_POST['rem_particulars'][$i];     
		     $rem_details = $_POST['rem_details'][$i];
		     $rem_cash = $_POST['rem_cash'][$i];
		     $rem_check = $_POST['rem_check'][$i];
		     $rem_amount = $_POST['rem_amount'][$i];
		     $rem_det_id = $_POST['rem_det_id'][$i];

		  		$sql = "UPDATE remittance_details
					SET remParticulars = :remParticulars,
					remDetails = :remDetails,			
					remCash = :remCash,
					remCheck = :remCheck,	
					remAmount = :remAmount
					WHERE remId = :remId ";

				$stmt = $pdo -> prepare($sql);
				$stmt -> bindParam(":remParticulars", $rem_particulars);
				$stmt -> bindParam(":remDetails", $rem_details);
				$stmt -> bindParam(":remCash", $rem_cash);
				$stmt -> bindParam(":remCheck", $rem_check);
				$stmt -> bindParam(":remAmount", $rem_amount);
				$stmt -> bindParam(":remId", $rem_det_id);	
				$stmt -> execute();
		  	}
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

	
?>
