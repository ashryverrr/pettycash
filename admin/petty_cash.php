<?php
require_once '../config/connection.php';
$requestData = $_REQUEST;
$columns = array(
   0 => 'trans_id',
   1 => 'client_name',
   2 => 'emp_name',
   3 => 'trans_date',
   4 => 'status'
);
$sql = "SELECT transaction.trans_id, transaction.others, users.emp_name AS emp_id,
       transaction.client_name, transaction.cc_num,
       transaction.trans_date, transaction.status
       FROM transaction
       LEFT JOIN users ON users.user_id = transaction.emp_id ";
$sql = $pdo -> prepare($sql);
$sql -> execute();  
$totalData = $sql -> rowCount();
$totalFiltered = $totalData; 
if( !empty($requestData['search']['value']) ) {
  $sql = "SELECT transaction.trans_id, transaction.others, users.emp_name AS emp_name, transaction.client_name,     
        transaction.cc_num, transaction.trans_date, transaction.status
       FROM transaction
       LEFT JOIN users ON users.user_id = transaction.emp_id ";
  $sql.=" WHERE client_name LIKE '".$requestData['search']['value']."%' ";  
  $sql.= "OR cc_num LIKE '".$requestData['search']['value']."%' ";
  $sql.= "OR emp_name LIKE '".$requestData['search']['value']."%' ";   
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();  
  $totalFiltered = $stmt -> rowCount();
  $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";  
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();  
} else {  
  $sql = "SELECT transaction.trans_id, transaction.others, users.emp_name AS emp_name, transaction.client_name,    
          transaction.cc_num, transaction.trans_date, transaction.status
          FROM transaction LEFT JOIN users ON users.user_id = transaction.emp_id          ";
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
  $client_len = strlen($client_name);
  if ($client_len > 15) {
    $client_name = substr($client_name, 0, 15);
    $client_name = $client_name."...";
  } else {
  }
  $cc_num = $row['cc_num']; 
  if ($cc_num == "0000") {
    $cc_num = $row['others'];
  } else {
    $cc_num = $row['cc_num'];
  }

  $cc_num = "<a href='details.php?id=$id'> $cc_num </a> ";
  $nestedData[] = $cc_num;
  $nestedData[] = $client_name;
  $nestedData[] = $row["emp_name"];
  $nestedData[] = $row["trans_date"];
  $nestedData[] = $is_posted ; 
  $nestedData[] = $edit;
  $nestedData[] =  $checkbox ;   
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