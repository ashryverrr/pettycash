<?php
require_once '../config/connection.php';
session_start();
$requestData = $_REQUEST;
$user_id = $_SESSION['user_id'];
$columns = array(
   0 => 'rem_id',
   1 => 'rem_ctr_no',
   2 => 'rem_emp',
   3 => 'rem_date',
   4 => 'rem_status',
);

$sql = "SELECT rem_id, rem_emp, rem_date, rem_ctr_no, rem_status FROM remittance_report";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();  
$totalData = $stmt -> rowCount();
$totalFiltered = $totalData; 

if( !empty($requestData['search']['value']) ) {
  $sql = "SELECT * FROM remittance_report ";
  $sql.= "WHERE rem_emp LIKE '".$requestData['search']['value']."%' ";  
  $sql.= "OR rem_ctr_no LIKE '".$requestData['search']['value']."%' ";  
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();  
  $totalFiltered = $stmt -> rowCount();
  $sql.= " ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();  
} else {      
  $sql = "SELECT rem_id, rem_emp, rem_date, rem_ctr_no, rem_status
          FROM remittance_report";
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   "; 
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
}
$data = array();
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $nestedData = array(); 
  $id = $row['rem_id'];
  $status =  $row['rem_status'];
  $rem_emp = $row['rem_emp'];
  if ($status == 0) {
           $enabled = '';
           $is_posted = "<span class='label label-danger'> NP </span> ";
           $edit = " <a href='edit-remittance-report.php?id=$id' > <i class='fa fa-pencil-square-o'></i>  </a> ";
           $delete = "<a href='#' id='$id' class='trash'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";
    } else {
            $enabled = 'disabled';
            $is_posted = "<span class='label label-success'> P </span>";
            $edit = " <a href='#' onclick='alertNOT()'> <i class='fa fa-pencil-square-o'></i>  </a>  ";
            $delete = "<a href='#' onclick='alertNOT()'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";
    }
  $checkbox = "  <input type='checkbox' name='cc_id[]' class='cc_id' value='$id'> ";
  //$rem_emp = "<a href='remittance-report-details.php?id=$id'> $rem_emp </a> ";
  $rem_emp = "<a href='print_rr.php?id=$id'> $rem_emp </a> ";
  $nestedData[] = $row['rem_ctr_no'];   
  $nestedData[] = $rem_emp;   
  $nestedData[] = $row["rem_date"];
  $nestedData[] = $is_posted; 
  $nestedData[] = $checkbox;   
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
