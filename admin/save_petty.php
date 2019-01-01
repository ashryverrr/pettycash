<?php
require_once '../config/connection.php';
require_once '../config/validate_user.php';
header('Content-type: application/json');

$last_id = $_SESSION['last_id'];

$number = count($_POST['vehicle']);

if ($number > 0) {
	for ($i=0; $i < $number; $i++) { 
		$vehicle = $_POST['vehicle'][$i];
		$descr = $_POST['desc'][$i];
		$amount = $_POST['amount'][$i];

		$sql = "INSERT INTO transaction_details (trans_id, vehicle, expenses, amount) VALUES (:trans_id, :vehicle, :expenses,:amount) ";

		$stmt = $pdo->prepare($sql);

		$stmt -> bindParam(':trans_id', $last_id);
		$stmt -> bindParam(':vehicle', $_POST['vehicle'][$i]) ;
		$stmt -> bindParam(':expenses', $_POST['desc'][$i]);
		$stmt -> bindParam(':amount', $_POST['amount'][$i]);

		$stmt -> execute();	  	
	}

	  $response_array['status'] = 'success'; 
	  echo json_encode($response_array);	
	 
} else {
	$response_array['status'] = 'error'; 
	echo json_encode($response_array);
}

?>