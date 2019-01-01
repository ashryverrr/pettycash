<?php
require_once '../config/connection.php';
session_start();
$user_id = $_SESSION['user_id'];
$requestData = $_REQUEST;
$columns = array(
   0 => 'ar_client',
   1 => 'ar_date_started',   
);
$sql = "SELECT ar_id,  ar_date_started, ar_client
      FROM activity_report
      WHERE ar_user_id = :uid      
      ";
$sql = $pdo -> prepare($sql);
$sql -> bindParam(":uid", $user_id);
$sql -> execute();
$totalData = $sql -> rowCount();
$totalFiltered = $totalData;
if( !empty($requestData['search']['value']) ) {
  $sql = "SELECT ar_id,  ar_date_started, ar_client
      FROM activity_report
      WHERE ar_user_id = :uid ";
  $sql.= "OR ar_client LIKE '".$requestData['search']['value']."%' ";
  $sql.= "OR emp_name LIKE '".$requestData['search']['value']."%' ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(":uid", $user_id);
  $stmt -> execute();
  $totalFiltered = $stmt -> rowCount();
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
} else {
  $sql = "SELECT ar_id,  ar_date_started, ar_client
      FROM activity_report
      WHERE ar_user_id = :uid ";
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(":uid", $user_id);
  $stmt -> execute();
  //$totalFiltered = $stmt -> rowCount();
}
$data = array();
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $nestedData = array();
  $id = $row['ar_id'];
  
  $client = $row["ar_client"];
  $link = " <a href='activity-report-details.php?id=$id'> $client </a> ";
  $edit = " <a href='edit-activity-report.php?id=$id' > <i class='fa fa-pencil-square-o'></i>  </a> ";
  $delete = "<a href='#' id='$id' class='trash'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";

  $nestedData[] = $link;
  
  $nestedData[] = $row["ar_date_started"];
  $nestedData[] = $edit;
  $nestedData[] = $delete;

  $data[] = $nestedData;
}
$json_data = array(
      "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );
echo json_encode($json_data);  // send data as json format
?>