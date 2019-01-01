<?php
require_once '../config/validate_user.php';
require_once '..\config\connection.php';

$stmt = $pdo -> prepare("SELECT * FROM transaction ORDER BY trans_date DESC LIMIT 10");
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
			    	$posted = "POSTED";
			    	$enabled = 'disabled';
			    	$is_posted = "<td class='danger'> $posted </td>";
			    } else {
			    	$posted = "NOT POSTED";
			    	$enabled = '';
			    	$is_posted = "<td class=''> $posted </td>";
			    }
			    echo "
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
	} else {
		echo "
			<tr>
			<td class='text-center'> THERE ARE NO TRANSACTIONS </td>
			</tr>
		";
	}	 
?>


