<?php
require_once "../config/connection.php";
//require_once '../config/validate_user.php';
header('Content-Type: application/json');
session_start();
$username = $_SESSION['user_name'];
if(isset($_POST["id"])) {
 foreach($_POST["id"] as $id) {
  $sql = "UPDATE remittance_report SET rem_status = '1', rem_receivedBy = :userName WHERE rem_id = :id ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(":id", $id);
  $stmt -> bindParam(":userName", $username);
  $stmt -> execute();
 }
	    $user_id = $_SESSION['user_id'];
  	  $log_desc = "Posted remittance report.";
      $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
      $stmt = $pdo -> prepare($sql);
      $stmt -> bindParam(':uid', $user_id);
      $stmt -> bindParam(':log_desc', $log_desc);
      $stmt -> execute();      

  $response_array['status'] = 'success'; 
  echo json_encode($response_array);
}
?>