<?php
require_once '../config/connection.php';
$requestData = $_REQUEST;
$columns = array(
   0 => 'emp_name',
   1 => 'ar_client',
   2 => 'ar_date_started',   
);
$sql = "SELECT activity_report.ar_id, users.emp_name AS emp_name, 
      activity_report.ar_date_started, activity_report.ar_client
      FROM activity_report
      LEFT JOIN users ON users.user_id = activity_report.ar_user_id
      ";
$sql = $pdo -> prepare($sql);
$sql -> execute();
$totalData = $sql -> rowCount();
$totalFiltered = $totalData;
if( !empty($requestData['search']['value']) ) {
  $sql = "SELECT activity_report.ar_id, users.emp_name AS emp_name, 
      activity_report.ar_date_started, activity_report.ar_client
      FROM activity_report
      LEFT JOIN users ON users.user_id = activity_report.ar_user_id ";
  $sql.= "WHERE ar_client LIKE '".$requestData['search']['value']."%' ";
  $sql.= "OR emp_name LIKE '".$requestData['search']['value']."%' ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
  $totalFiltered = $stmt -> rowCount();
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
} else {
  $sql = "SELECT activity_report.ar_id, users.emp_name AS emp_name, 
      activity_report.ar_date_started, activity_report.ar_client
      FROM activity_report
      LEFT JOIN users ON users.user_id = activity_report.ar_user_id
      ";
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
  //$totalFiltered = $stmt -> rowCount();
}
$data = array();
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $nestedData = array();
  $id = $row['ar_id'];
  $emp_name = $row['emp_name'];
  $client = $row["ar_client"];
  $link = " <a href='activity-report-details.php?id=$id'> $client </a> ";
  $edit = " <a href='edit-activity-report.php?id=$id' > <i class='fa fa-pencil-square-o'></i>  </a> ";
  $delete = "<a href='#' id='$id' class='trash'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";

  $nestedData[] = $link;
  $nestedData[] = $emp_name;  
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