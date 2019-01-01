<?php
require_once "../config/connection.php";
require_once '../config/validate_user.php';
header('Content-Type: application/json');


$user_id = $_SESSION['user_id'];

if(isset($_POST["id"])) {
 foreach($_POST["id"] as $id) {
  $sql = "UPDATE cc_report SET ccr_status = '0' WHERE ccr_id = :id ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(":id", $id);
  $stmt -> execute();
 }

 	  $log_desc = "Unposted Customer calls.";
      $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
      $stmt = $pdo -> prepare($sql);
      $stmt -> bindParam(':uid', $user_id);
      $stmt -> bindParam(':log_desc', $log_desc);
      $stmt -> execute();      

 $response_array['status'] = 'success'; 
 echo json_encode($response_array);
}
	$pdo = null;
?>