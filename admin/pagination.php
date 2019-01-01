<?php  
 require_once '..\config\connection.php';
 $record_per_page = 10;  
 $page = '';  
 $output = '';  
 if(isset($_POST["page"]))  {  
      $page = $_POST["page"];  
 } else  {  
      $page = 1;  
 } 

 $start_from = ($page - 1) * $record_per_page;  

 $stmt = $pdo -> prepare("SELECT * FROM transaction LIMIT $start_from, $record_per_page");
 $stmt -> execute();

$row_count = $stmt ->rowCount();
  if ($row_count > 0) { #if there are items in the query    
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
      $id = $row['trans_id'];
      $emp_id = $row['emp_id'];
      $client_name = $row['client_name'];
      $ccnum = $row['cc_num'];
      $date = $row['trans_date'];
      $status = $row['status'];
      $sql1 = "SELECT emp_name FROM users WHERE user_id = :uid ";
      $stmt1 = $pdo -> prepare($sql1);
      $stmt1 -> bindParam(':uid', $emp_id);
      $stmt1 -> execute();      
      $name_row = $stmt1 -> fetch();     
      $empname = $name_row['emp_name'];   

          if ($status == 0) {
            $enabled = 'disabled';
            $is_posted = "<td class=''><span class='label label-success'> POSTED </span> </td>";
          } else {
            $enabled = '';
            $is_posted = "<td class=''><span class='label label-danger'> NOT POSTED </span> </td>";
          }
          $output .= "
            <tr>
              <td> <a href='details.php?id=$id'> $id </a> </td>
              <td> $empname </td>
              <td> $client_name </td>
              <td> $ccnum </td>
              <td> $date </td>
              $is_posted
                <td> <a href='edit.php?id=$id' > <i class='fa fa-ravelry'> </i> </a> </td>
                <td>  <a href='delete.php?id=$id'> del </a> </td> 
            <tr>
          ";            
    }     
       $page_query = "SELECT * FROM transaction ORDER BY trans_date DESC";
       $page_result = $pdo -> prepare($page_query);
       $page_result -> execute();
       $total_records = $page_result->fetchColumn();

       $total_pages = ceil($total_records/$record_per_page);  
       for($i = 1; $i<=$total_pages; $i++)   {  
            $output .= "<span class='pagination_link' style='cursor:pointer; padding:6px; border:1px solid #ccc;' id='".$i."'>".$i."</span>";  
       }  

       echo $output;  
  } else {
    echo "
      <tr>
        <td class='text-center'> THERE ARE NO TRANSACTIONS </td>
      </tr>
    ";
  }


 
 ?>  