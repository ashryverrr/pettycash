<?php

require_once '..\config\include.php';
require_once '../config/validate_user.php';

if (isset($_POST['submit'])) {


	$empname = $_POST['empname'];
	$ccnum = $_POST['ccnum'];
	$amount = $_POST['amt'];
	$client = $_POST['client'];
	$date = $_POST['trans_date'];

	$sql = "INSERT INTO transaction (emp_name, cc_num, amount, client_name, trans_date) VALUES (:empname, :ccnum, :amount, :client, :trans_date) ";

	$stmt = $pdo->prepare($sql)  or die(print_r($stmt->errorInfo(), true));

	$stmt -> bindParam('empname', $empname);
	$stmt -> bindParam(':ccnum', $ccnum);
	$stmt -> bindParam(':amount', $amount);
	$stmt -> bindParam(':client', $client);
	$stmt -> bindParam(':trans_date', $date);

	#$stmt -> execute();

	if ($stmt -> execute()) {
		echo "<script> alert('Added! Please fill in the details of the transaction.') </script> ";
		$last_id = $pdo -> lastInsertId();

	} else {
		print_r($pdo->errorInfo());
	}


} else {
	#header('Location: view.php');
}

?>