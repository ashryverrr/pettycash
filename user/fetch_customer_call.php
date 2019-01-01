<?php
require_once '../config/connection.php';
session_start();
$requestData = $_REQUEST;
$user_id = $_SESSION['user_id'];
$columns = array(
   0 => 'ccr_id',
   1 => 'ccr_client',
   2 => 'ccr_date',
);
$sql = "SELECT ccr_id, ccr_cc_num,
      ccr_date, ccr_client, ccr_status
      FROM cc_report
      WHERE
      ccr_user_id = $user_id
      ORDER BY ccr_id
      ";
$sql = $pdo -> prepare($sql);
$sql -> execute();
$totalData = $sql -> rowCount();
$totalFiltered = $totalData;
if( !empty($requestData['search']['value']) ) {
  $sql ="SELECT ccr_id, ccr_cc_num, ccr_date, ccr_client, ccr_status
      FROM cc_report ";
  $sql.= "WHERE ccr_client LIKE '".$requestData['search']['value']."%' ";
  $sql.= "AND ccr_user_id = $user_id ";
  $sql.= "OR ccr_cc_num LIKE '".$requestData['search']['value']."%' ";
  $stmt = $pdo -> prepare($sql);
  //$STMT -> bindParam(":user_id", $user_id);
  $stmt -> execute();
  $totalFiltered = $stmt -> rowCount();
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
} else {
  $sql = "SELECT ccr_id, ccr_cc_num, ccr_date, ccr_client, ccr_status
         FROM cc_report
         WHERE ccr_user_id = $user_id
      ";
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
  //$totalFiltered = $stmt -> rowCount();
}
$data = array();
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
  $nestedData = array();
  $id = $row['ccr_id'];
  $ccr_status =  $row["ccr_status"];
  $cc = $row['ccr_cc_num'];
  if ($ccr_status == 0) {
           $enabled = '';
           $is_posted = "<span class='label label-danger'> NP </span> ";
           $edit = " <a href='edit-customer-calls.php?id=$id' > <i class='fa fa-pencil-square-o'></i>  </a> ";
           $delete = "<a href='#' id='$id' class='trash'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";
    } else {
            $enabled = 'disabled';
            $is_posted = "<span class='label label-success'> P </span>";
            $edit = " <a href='#' onclick='alertNOT()'> <i class='fa fa-pencil-square-o'></i>  </a>  ";
            $delete = "<a href='#' onclick='alertNOT()'> <i class='fa fa-times' aria-hidden='true'></i> </a> ";
    }
  $link = " <a href='customer-call-details.php?id=$id'> $cc </a> ";
  $nestedData[] = $link ;
  $nestedData[] = $row["ccr_client"];
  $nestedData[] = $row["ccr_date"];
  //$nestedData[] = $is_posted;
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