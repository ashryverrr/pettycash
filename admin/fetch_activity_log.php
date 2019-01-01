<?php
require_once '../config/connection.php';
require_once '../config/validate_user.php';
   $output = '';
   $page = ' ';
   $item_per_page = 3;
    if(isset($_POST["page"])){
    $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
    if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
     $page_number = 1;
    }
       $position = (($page_number - 1) * $item_per_page);
   $sql = "SELECT petty_log.log_id, petty_log.log_date, petty_log.log_desc, users.emp_name AS emp_id FROM petty_log INNER JOIN users ON users.user_id = petty_log.user ORDER BY log_date  DESC LIMIT $position, $item_per_page";
   $sql = $pdo -> prepare($sql);
   $sql -> execute();
   $row_count = $sql -> rowCount();
   if ($row_count > 0) {
     while ($row = $sql -> fetch(PDO::FETCH_ASSOC) ) {
        $id = $row['log_id'];
        $empname = $row['emp_id'];
        $log_date = $row['log_date'];
        $log_desc = $row['log_desc'];
        $output .= "
          <tr>
            <td> $id </td>
            <td> $empname </td>
            <td> $log_date </td>
            <td> $log_desc </td>
          </tr>
        ";
      }
      echo $output;
   } else {
      $no_output = "
            <tr>
              <td colspan='4' class='text-center'> <b> No activity logs. </b> </td>
            </tr>
    ";
       echo $no_output;
   }
?>