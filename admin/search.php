<?php
require_once '..\config\include.php';
require_once '../config/validate_user.php';

if (isset($_POST['search'])) {
	$search_field = $_POST['search_field'];


	$sql = "SELECT * FROM transaction 
			WHERE client_name LIKE concat('%', :client, '%') ";
	$sql = $pdo -> prepare($sql);
	$sql -> bindParam(':client', $search_field);
	$sql -> execute();	

	$row_count = $sql -> rowCount();
	echo "
		<div class='container'>
		<div class='panel panel-default'>
  		<div class='panel-heading'> Showing search results for customers with <i> $search_field </i> </div>	
  		
			<table class='table table-bordered table-condensed table-hover'>
				<thead>
					<th> # </th>
					<th> EMPLOYEE  </th>
					<th> CUSTOMER </th>
					<th> CC# / DR# </th>
					<th> DATE</th>
					<th class='success'> STATUS</th>					
					<th class='info'> MODIFY </th>
					<th class='danger'> DELETE  </th>			
				</thead>
				<tbody>
					<tr>
						
			
		";

	if ($row_count > 0 ) {
		# SO MERON TAYONG NAHANAP BES
	

		while ($row = $sql -> fetch(PDO::FETCH_ASSOC) ) {
			$id = $row['trans_id'];
			$empname = $row['emp_name'];
			$client_name = $row['client_name'];
		    $ccnum = $row['cc_num'];
		    $date = $row['trans_date'];
		    $status = $row['status'];
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
		    	<td> <a href='details.php?id=$id'> $id </a> </td>
		    	<td> $empname </td>
		    	<td> $client_name </td>
		    	<td> $ccnum </td>
		    	<td> $date </td>
		    	$is_posted
		    	<td> <a href='' > <i class='fa fa-ravelry'> </i> </a> </td>
		    	<td> <a href='delete.php?id=$id'> del </a> </td>
		    	<tr>
	    		
		    ";			
		}		

		echo "
				</tbody>
				</table>
				<div class='panel-footer'> Panel Footer </div>
				</div> 

			</div>
			";

	} else {
		# NO RESULT WAS FOUND
		echo "

			<td colspan = 8	 class='text-center'>0 results returned. </td>
			</tr>
			</tbody>
					</table>
					<div class='panel-footer'> Panel Footer </div>
					</div> 

			</div>
		";
	}


}

?>