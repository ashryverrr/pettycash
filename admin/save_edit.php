<?php
require_once '../config/include.php';
require_once '../config/validate_user.php';
header('Content-Type: application/json');
	if (isset($_POST['save_edit'])) {
	 $number = count($_POST['vehicle']);
	 if ($number > 0) {
	 	for ($i=0; $i < $number; $i++) { 
			$detail_id = $_POST['detail_id'][$i];
			$vehicle = $_POST['vehicle'][$i];
			$expenses = $_POST['desc'][$i];
			$amount = $_POST['amount'][$i];
			$sql = "UPDATE transaction_details SET vehicle = :vehicle, expenses = :expenses, amount = :amount WHERE detail_id = :detail_id ";
			$sql = $pdo -> prepare($sql);
			$sql -> bindParam(':detail_id', $_POST['detail_id'][$i]);
			$sql -> bindParam(':vehicle', $_POST['vehicle'][$i]);
			$sql -> bindParam(':expenses', $_POST['desc'][$i]);
			$sql -> bindParam(':amount', $_POST['amount'][$i]);
			$sql -> execute();	
		}
		header('Location: view.php') ;
	}	else {
	}
}
?>