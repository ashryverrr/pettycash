<?php
require_once "../config/connection.php";
header('Content-type: application/json');
session_start();
$details_count = count(isset($_POST['rem_details']));	
$number = count($_POST['rem_particulars']);

if ($number > 0) {	
		$rem_emp = $_POST['rem_emp'];
		$rem_date = $_POST['rem_date'];
		$rem_ctr_no = $_POST['rem_ctr_no'];
		$rem_emp_id = $_SESSION['user_id'];	

		$sql = "INSERT INTO rr_number (rr_number, rr_user_id, rr_count) VALUES (:rr_number, :rr_user_id, :rr_count) ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(':rr_number', $rem_ctr_no);
		$stmt -> bindParam(':rr_user_id', $rem_emp_id);	
		$stmt -> bindParam(':rr_count', $details_count);	
		$stmt -> execute();

		$sql = "INSERT INTO remittance_report (rem_emp, rem_emp_id, rem_date, rem_ctr_no) VALUES (:rem_emp, :rem_emp_id, :rem_date, :rem_ctr_no) ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(':rem_emp', $rem_emp);
		$stmt -> bindParam(':rem_emp_id', $rem_emp_id);
		$stmt -> bindParam(':rem_date', $rem_date);		
		$stmt -> bindParam(':rem_ctr_no', $rem_ctr_no);		
		$stmt -> execute();

		$id = $pdo -> lastInsertId();

	for ($i=0; $i < $number; $i++) { 
		$rem_particulars = $_POST['rem_particulars'][$i];
		$rem_details = $_POST['rem_details'][$i];
		$rem_cash = $_POST['rem_cash'][$i];
		$rem_check = $_POST['rem_check'][$i];
		$rem_amount = $_POST['rem_amount'][$i];
		$sql = "INSERT INTO remittance_details (remGrp, remParticulars, remDetails, remCash, remCheck, remAmount) VALUES (:remGrp, :remParticulars, :remDetails, :remCash, :remCheck, :remAmount) ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(':remGrp', $id);
		$stmt -> bindParam(':remParticulars', $rem_particulars);
		$stmt -> bindParam(':remDetails', $rem_details);
		$stmt -> bindParam(':remCash', $rem_cash);		
		$stmt -> bindParam(':remCheck', $rem_check);
		$stmt -> bindParam(':remAmount', $rem_amount);		
		$stmt -> execute();

     }

	 $response_array['status'] = 'success'; 
	 echo json_encode($response_array);		
} else {
	$response_array['status'] = 'error'; 
	echo json_encode($response_array);		 
}


?>
