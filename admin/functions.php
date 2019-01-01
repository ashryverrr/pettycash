<?php
require_once '../config/validate_user.php';

function databaseConn(){
	$hostname='localhost';
	$username='bryan';
	$password='cyberits07';	

	$pdo = new PDO("mysql:host=$hostname; dbname=pettysystem", $username, $password);
	
	if ($pdo) {
		#echo "CONNECTED.";
	} else {
		echo "ERROR";
		print_r($pdo->errorInfo());
	}

	return $pdo;
}

function Login($username, $password){
	
	$pdo -> prepare("SELECT * FROM users WHERE username = :uname, password = :pass ");
	$pdo -> bindParam(':uname', $username );
	$pdo -> bindParam(':pass', $password);
	$pdo -> execute();


	if ($pdo) {
		// check for the user role
		if ($user_role == 'supervisor') {
			# if supervisor
			#header('Location: dashboard.php');
		} else if ($user_role == 'technician') {
			# if tech redirect again
			#header('Location: dashboard.php');
		} else {
			# invalid user role
			return false;
		}

	} else {
		//something went wrong with the code
	}
}

function saveTransaction(){
		$hostname='localhost';
		$username='bryan';
		$password='cyberits07';	

		$pdo = new PDO("mysql:host=$hostname; dbname=pettysystem", $username, $password);

		$pdo ->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$empname = $_POST['user_id'];
		$ccnum = $_POST['ccnum'];
		$amount = $_POST['amt'];
		$client = $_POST['client'];
		$date = $_POST['trans_date'];

		$does_match = "SELECT * FROM transaction WHERE cc_num = :ccnum ";
		$does_match = $pdo -> prepare($does_match);
		$does_match -> bindParam(':ccnum', $ccnum);
		$does_match -> execute();
		$row_match = $does_match -> rowCount();

		if ($row_match > 0) {
			$return = "have_match";
			return FALSE;		
		} else {
				$sql = "INSERT INTO transaction (emp_name, cc_num, amount, client_name, trans_date) VALUES (:empname, :ccnum, :amount, :client, :trans_date) ";
				$stmt = $pdo->prepare($sql)  or die(print_r($stmt->errorInfo(), true));
				$stmt -> bindParam('empname', $empname);
				$stmt -> bindParam(':ccnum', $ccnum);
				$stmt -> bindParam(':amount', $amount);
				$stmt -> bindParam(':client', $client);
				$stmt -> bindParam(':trans_date', $date);
				if ($stmt -> execute()) {
					return TRUE;
				} else {
					print_r($pdo->errorInfo());
				}

		}

		
 

}


function deleteTrans($table_name, $id_field, $id){
	databaseConn(); #call the database

	$sql = "SELECT * FROM $table_name WHERE $id_field = $id "; #field the query
	$sql = $pdo -> execute(); #exec the query
	$row_count = $sql -> rowCount();

	if ($row_count > 0) { #check if there is an item with that id value
		$del_sql = "DELETE FROM $table_name WHERE $id_field = $id";
		$del_sql = $pdo -> execute();

		if ($del_sql) {
			return true;
		} else {
			return false;
		}

	} else {
		return false;
	}
}


function editTransaction(){

}


?>