<?php
require_once '../config/connection.php';
$requestData = $_REQUEST;
$emp_id = $_POST['emp_id'];
$columns = array(
  0 => 'cc_history_id',
  1 => 'cc_history_issued',
);

$sql = "SELECT cc_history_id, cc_history_emp, cc_history_start, cc_history_end, cc_history_issued
       FROM cc_history WHERE cc_history_emp = :uid";
$sql = $pdo -> prepare($sql);
$sql -> bindParam(":uid", $emp_id);
$sql -> execute();
$totalData = $sql -> rowCount();
$totalFiltered = $totalData;
if( !empty($requestData['search']['value']) ) {
  $sql = "SELECT cc_history_id, cc_history_emp, cc_history_start, cc_history_end, cc_history_issued
       FROM cc_history WHERE cc_history_emp = :uid";
  $sql.=" AND cc_history_id LIKE '".$requestData['search']['value']."%' ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(":uid", $emp_id);
  $stmt -> execute();
  $totalFiltered = $stmt -> rowCount();
  $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
} else {
  $sql = "SELECT cc_history_id, cc_history_emp, cc_history_start, cc_history_end, cc_history_issued FROM cc_history WHERE cc_history_emp = :uid ";
  $sql.="ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(":uid", $emp_id);
  $stmt -> execute();
}
$data = array();
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $nestedData = array();
  $id = $row['cc_history_id'];
  $cc_history_issued =  $row["cc_history_issued"];
  $cc_start = $row['cc_history_start'];
  $cc_end = $row['cc_history_end'];
  $description = "Issued CC# beginning $cc_start to $cc_end.";
  
  $nestedData[] = $description;
  $nestedData[] = $cc_history_issued;

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