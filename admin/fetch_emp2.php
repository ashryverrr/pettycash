<?php  
require_once '..\config\connection.php'; 
require_once '../config/validate_user.php';
$no_output = '';
$search_field = $_POST['search'];
$start_from = 1;  
$item_per_page = 10;  
$page = '';  
$output = '';  

if(isset($_POST["page"])){
  $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
  if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
}else{
  $page_number = 1;
}

$position = ( ($page_number - 1) * $item_per_page );

if (empty($search_field)) {
   $sql = "SELECT * FROM users ORDER BY emp_name ASC LIMIT $position, $item_per_page";
   $sql = $pdo -> prepare($sql);
   $sql -> bindParam(':client', $search_field);
   
   $sql -> execute();  
   $count_row = $sql -> rowCount();

   while ($row = $sql -> fetch(PDO::FETCH_ASSOC) ) {
      $id = $row['user_id'];
      $empname = $row['emp_name'];
      $user_role = $row['user_role'];
          $output .= "
            <tr>
              <td> <a href='details.php?id=$id'> $id </a> </td>
              <td> $empname </td>
              <td> $user_role </td>
              <td> <a href='edit.php?id=$id' > <i class='fa fa-ravelry'> </i> </a> </td>
              <td>  <a href='delete.php?id=$id'> del </a> </td> 
            </tr>
          ";   
      }  
      echo $output;  

} else {
 $sql = "SELECT * FROM users WHERE emp_name LIKE concat('%', :emp_name, '%') ORDER BY emp_name ASC LIMIT $position, $item_per_page ";
 $sql = $pdo -> prepare($sql);
 $sql -> bindParam(':emp_name', $search_field);
 $sql -> execute();  
 $row_count = $sql -> rowCount();
 if ($row_count > 0 ) {
      while ($row = $sql -> fetch(PDO::FETCH_ASSOC) ) {
      $id = $row['user_id'];
      $empname = $row['emp_name'];
      $user_role = $row['user_role'];
          $output .= "
            <tr>
              <td> <a href='details.php?id=$id'> $id </a> </td>
              <td> $empname </td>
              <td> $user_role </td>
              <td> <a href='edit.php?id=$id' > <i class='fa fa-ravelry'> </i> </a> </td>
              <td>  <a href='delete.php?id=$id'> del </a> </td> 
            </tr>
          ";          
      }  

      echo $output;  
 }  
 else {    
 $no_output = "
      <tr>
        <td class='text-center' colspan=5> THERE ARE NO EMPLOYEES. </td>
      </tr>
    ";
    echo $no_output;  
 }  
}

?>  