<?php
require_once '../config/connection.php';
$requestData = $_REQUEST;
$columns = array(
  0 => 'emp_name',
  1 => 'user_role',
  2 => 'user_id', 
);
$sql = "SELECT user_id, emp_name, user_role
       FROM users";
$sql = $pdo -> prepare($sql);
$sql -> execute();
$totalData = $sql -> rowCount();
$totalFiltered = $totalData;
if( !empty($requestData['search']['value']) ) {
  $sql = "SELECT user_id, emp_name, user_role
          FROM users";
  $sql.=" WHERE emp_name LIKE '".$requestData['search']['value']."%' ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
  $totalFiltered = $stmt -> rowCount();
  $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
} else {
  $sql = "SELECT user_id, emp_name, user_role
          FROM users";
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
}
$data = array();
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $nestedData = array();
  $id = $row['user_id'];
  $emp_name = $row['emp_name'];
  $user_role =  $row["user_role"];
  $empName = "<a href='cc-history.php?id=$id'> $emp_name </a>";

  $nestedData[] = $empName;
  $nestedData[] = $user_role;
  $nestedData[] = "edit";
  $nestedData[] = "delete";
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