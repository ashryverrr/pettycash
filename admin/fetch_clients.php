<?php
require_once '../config/connection.php';
$requestData = $_REQUEST;
$columns = array(
   0 => 'client_name',
   1 => 'client_branch',
   2 => 'client_account',
   3 => 'client_contact_num',
);
$sql = "SELECT client_id, client_name, client_branch, client_account, client_contact_num
       FROM clients";
$sql = $pdo -> prepare($sql);
$sql -> execute();
$totalData = $sql -> rowCount();
$totalFiltered = $totalData;
if( !empty($requestData['search']['value']) ) {
  $sql = "SELECT client_id, client_name, client_branch, client_account, client_contact_num
       FROM clients";
  $sql.=" WHERE client_name LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR client_branch LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR client_account LIKE '".$requestData['search']['value']."%' ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
  $totalFiltered = $stmt -> rowCount();
  $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
} else {
  $sql = "SELECT client_id, client_name, client_branch, client_account, client_contact_num
       FROM clients";
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
}
$data = array();
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $nestedData = array();
  $id = $row['client_id'];
  $client_name = stripslashes($row['client_name']);
  $client_branch =  $row["client_branch"];
  $client_account =  $row["client_account"];
  $client_contact_num = $row['client_contact_num'];
  $edit = "<a href='edit-client.php?id=$id'> <i class='fa fa-pencil-square-o'></i>   </a> ";
  $delete = "<a href='#' id='$id' class='trash'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";
  $nestedData[] = $client_name;
  $nestedData[] = $client_branch;
  $nestedData[] = $client_account;
  $nestedData[] = $client_contact_num;
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