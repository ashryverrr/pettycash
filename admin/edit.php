<?php 
	require '..\config\include.php';
	require_once '../config/validate_user.php';
	 
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<div class='container'>
			<h4 class='text-center'>
			 CYBER FRONTIER ELECTRONIC TRADING FORM <br>
			 PETTY CASH LIQUIDATION FORM 
			</h4>
			<form method='POST' action='save_edit.php' class='form-horizontal' id='add_petty'>	
			 <input type='hidden' name='userID'>
			 <div class='panel panel-default'>
  			 <div class='panel-heading'>
  					<b> Name: </b>
  					<b style='margin-left: 100px'>	CC: </b>
  					<b style='margin-left: 100px'> Amount: 
  					<b style='margin-left: 100px'> Client: 
  			</div>	

		  	<table class='table table-bordered' id='dynamic_field'>
		  		<thead>
		  			<th class='col-md-2'> Vehicle </th>
		  			<th class='col-md-8'>Expenses</th>
		  			<th class='col-md-2'>Amount</th>
		  		</thead>
		  		<tbody>
		  		<tr>
				<?php
					if (isset($_GET['id']) && is_numeric($_GET['id'])) {
					$t_id = $_GET['id'];
					$sql = "SELECT * FROM transaction_details WHERE trans_id = :t_id ";

					$sql = $pdo ->prepare($sql);
					$sql -> bindParam(':t_id', $t_id);
					$sql -> execute();

					$trans_count = $sql -> rowCount();

					if ($trans_count > 0) {
							  	for ($i=0; $i < $trans_count; $i++) {
							  	$row = $sql -> fetch(PDO::FETCH_ASSOC);
							  	$detail_id = $row['detail_id'];
							  	$trans_id = $row['trans_id'];
							  	$vehicle = trim($row['vehicle']);
							  	$expenses = $row['expenses'];
							  	$amount = $row['amount'];

								echo "
										<input type='hidden' name='detail_id[$i]' value='$detail_id'>
										<td> <input type='text' name='vehicle[$i]' id='vehicle' value='$vehicle'></td>
						  				<td> <textarea rows=1 cols=73 class='no-resize' name='desc[$i]' id='desc'> $expenses </textarea></td>
						  				<td> <input type='number' name='amount[$i]' id='amt' value='$amount'> </td>
						  			</tr>
						  			";
							}		  				
					} 
				} 

				?>

			</tbody>
		  	</table>
		  	<div class='panel-footer'> 
		  		 <button type='submit' name='add' id='add' class='btn btn-success'>Add More</button> 
		  		  <button type='submit' name='save_edit' id='submit1' class='btn btn-success pull-right'>Update</button>
		  	</div>

		  </div>
		  </div>			  
		  <div class='form-group'> 
		    <div class='col-sm-offset-2 col-sm-8'>
		      <button type='button' name='save_edit' id='submit1' class='btn btn-success'>Submit</button>
		    </div>
		</div>	
	</form>
		</div>

</body>
</html>


