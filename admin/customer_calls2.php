<?php
/* Database connection start */
require_once '../config/connection.php';
$requestData = $_REQUEST;
$columns = array(
   0 => 'ccr_id',
   1 => 'ccr_client',
   2 => 'emp_name',
   3 => 'ccr_date',
   4 => 'ccr_status'
);
$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_date BETWEEN :date_start AND :date_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc ";
$sql = $pdo -> prepare($sql);
$sql -> execute();
$totalData = $sql -> rowCount();
$totalFiltered = $totalData;
if( !empty($requestData['search']['value']) ) {
  $sql = "SELECT cc_report.ccr_id, users.emp_name AS emp_name, cc_report.ccr_cc_num,
      cc_report.ccr_date, cc_report.ccr_client, cc_report.ccr_status
      FROM cc_report
      LEFT JOIN users ON users.user_id = cc_report.ccr_user_id ";
  $sql.= "WHERE ccr_client LIKE '".$requestData['search']['value']."%' ";
  $sql.= "OR ccr_cc_num LIKE '".$requestData['search']['value']."%' ";
  $sql.= "OR emp_name LIKE '".$requestData['search']['value']."%' ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
  $totalFiltered = $stmt -> rowCount();
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
} else {
  $sql = "SELECT cc_report.ccr_id, users.emp_name AS emp_name, cc_report.ccr_cc_num,
      cc_report.ccr_date, cc_report.ccr_client, cc_report.ccr_status
      FROM cc_report
      LEFT JOIN users ON users.user_id = cc_report.ccr_user_id
      ";
  $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."   LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
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
  $checkbox = " <td class='text-center'> <input type='checkbox' name='cc_id[]' class='cc_id' value='$id'>  </td> ";
  $link = " <a href='customer-calls-details.php?id=$id'> $cc </a> ";
  $nestedData[] = $link ;
  $nestedData[] = $row["ccr_client"];
  $nestedData[] = $row["emp_name"];
  $nestedData[] = $row["ccr_date"];
  $nestedData[] = $is_posted;
  $nestedData[] = $edit;
  $nestedData[] = $checkbox;
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