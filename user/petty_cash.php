<?php
require_once '../config/connection.php';
session_start();
$requestData = $_REQUEST;
$user_id = $_SESSION['user_id'];
$columns = array(
   0 => 'cc_num',
   1 => 'client_name',
   2 => 'trans_id',
   3 => 'status'
);
    $sql = "SELECT trans_id, client_name, cc_num, trans_date, status, others
       FROM transaction WHERE emp_id = $user_id";
$sql = $pdo -> prepare($sql);
$sql -> execute();  
$totalData = $sql -> rowCount();
$totalFiltered = $totalData; 
if( !empty($requestData['search']['value']) ) {
  $sql ="SELECT trans_id, client_name, cc_num, trans_date, status, others
          FROM transaction  ";
  $sql.= "WHERE client_name LIKE '".$requestData['search']['value']."%' ";  
  $sql.= "AND emp_id = $user_id "; 
  $sql.= "OR cc_num LIKE '".$requestData['search']['value']."%' "; 
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();  
  $totalFiltered = $stmt -> rowCount();
  $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();  
} else {  
   $sql = "SELECT trans_id, client_name, cc_num, trans_date, status, others
          FROM transaction WHERE emp_id = $user_id ";
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
}
$data = array();
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $nestedData = array(); 
  $id = $row['trans_id'];
  $ccr_status =  $row["status"];
  if ($ccr_status == 0) {
           $enabled = '';
           $is_posted = "<span class='label label-danger'> NP </span> ";
           $edit = " <a href='edit-petty-cash.php?id=$id' > <i class='fa fa-pencil-square-o'></i>  </a> ";
           $delete = "<a href='#' id='$id' class='trash'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";
    } else {
            $enabled = 'disabled';
            $is_posted = "<span class='label label-success'> P </span>";
            $edit = " <a href='#' onclick='alertNOT()'> <i class='fa fa-pencil-square-o'></i>  </a>  ";
            $delete = "<a href='#' onclick='alertNOT()'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";
    }
  $checkbox = "  <input type='checkbox' name='cc_id[]' class='cc_id' value='$id'> ";
  $client_name = $row['client_name'];

  $cc_num = $row['cc_num']; 
  if ($cc_num == "0000") {
    $cc_num = $row['others'];
  } else {
    $cc_num = $row['cc_num'];
  }

  $cc_num = "<a href='petty-cash-details.php?id=$id'> $cc_num </a> ";
  $nestedData[] = $cc_num;
  $nestedData[] = $client_name;
  $nestedData[] = $row["trans_date"];
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