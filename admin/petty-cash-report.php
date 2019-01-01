<?php

require_once "../config/connection.php";

?>

<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Cyber Frontier | Petty Cash Report</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">

  <link rel="stylesheet" href="../css/bootstrap.min.css">

  <link rel="stylesheet" href="../css/select2.min.css">

  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">

  <link rel="stylesheet" type="text/css" href="../css/multi-select.css">

  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">

  <style type="text/css">

  	body{

  		 overflow:auto;

  	}

  </style>

  <style type="text/css" media="print">

  	@media print{

  		@page {

  			size: landscape;

  			margin-left: 0cm;

  			margin-right: 0cm;

  			margin-bottom: 0cm;

  			margin-top: 0cm;

  		}

  		#header, #footer {

	     display: none;

	    }

	    title{

	     display: none;

	    }

	     .no-print, .no-print *

		{

		    display: none !important;

		}

  	}

  </style>

  <script src="../js/jquery.min.js"></script>

  <script src="../js/select2.js"></script>

  <script src="../js/jquery.bootpag.min.js"></script>

  <script src="../js/bootstrap.min.js"> </script>

</head>

<body>

	<div class="container-fluid">

		<h4 class="text-center">PETTY CASH REPORT</h4>

			<h5 class="text-center">

			<?php

			 $output = " ";

			 if (isset($_POST['pc_date_start']) && isset($_POST['pc_date_end'])) {

			 $date_start = $_POST['pc_date_start'];
			
			 $date_end = $_POST['pc_date_end'];
			 

			 $date_start = date("M j, Y", strtotime($date_start));

			 $date_end = date("M j, Y", strtotime($date_end));

			 $output .= " <b> $date_start </b> to <b> $date_end </b> ";

			 }

			 if (!empty($_POST['pc_client'])) {

				 $client = $_POST['pc_client'];
				 

			 	$output .= "

			 		<br><br>

			 		<b> Client: </b> $client

			 	";

			 }

			 if (!empty($_POST['pc_employee'])) {

				$employee = $_POST['pc_employee'];
				$employee1 = $_POST['pc_employee'];

			 	$sql = "SELECT emp_name FROM users WHERE user_id = :id ";

			 	$stmt = $pdo -> prepare($sql);

			 	$stmt -> bindParam(":id", $employee);

			 	$stmt -> execute();

			 	$row = $stmt -> fetch();

			 	$employee_name = $row['emp_name'];

			 	$output .= "

			 		<br><br>

			 		<b> Employee: </b> $employee_name

			 	";

			 }

			 if (!empty($_POST['pc_cc_start']) && !empty($_POST['pc_cc_end'])) {

				 $cc_start_rep = $_POST['pc_cc_start'];
				 

				 $cc_end_rep = $_POST['pc_cc_end'];
				 

			 	$output .= "

			 		<br><br>

			 		<b> CC Number: </b> $cc_start_rep to $cc_end_rep

			 	";

			 }

			 echo $output;

			 ?></h5>

			 <?php

			
			$date_start1 = $_POST['pc_date_start'];

			$date_end1 = $_POST['pc_date_end'];
   
			$client1 = $_POST['pc_client'];
   
			$employee1 = $_POST['pc_employee'];
   
			$cc_start1 = $_POST['pc_cc_start'];
   
			$cc_end1 = $_POST['pc_cc_end'];
   
			


			 ?>

			 <form method="POST" action="create-excel-pc.php">

			 	<input type="hidden" name="pc_date_start" value="<?php echo $date_start1; ?>">

			 	<input type="hidden" name="pc_date_end" value="<?php echo $date_end1; ?>">

			 	<input type="hidden" name="pc_client" value="<?php echo $client1; ?>">

			 	<input type="hidden" name="pc_employee" value="<?php echo $employee1; ?>">

			 	<input type="hidden" name="pc_cc_start" value="<?php echo $cc_start1; ?>">

			 	<input type="hidden" name="pc_cc_end" value="<?php echo $cc_end1; ?>">

			 

			 	<h5 class="text-center no-print"> 
				<button class="btn btn-default btn-sm" name="submit" type="submit"> Export Excel File </button> </h5>

			 </form>

	</div>

	<div class="">

	<table class="table table-condensed table-bordered">

		<thead>

			<th colspan="16" class="text-center"> Petty Cash Report </th>

		</thead>

		<tr>

			<th class="text-center">Date</th>

			<th class="text-center text-nowrap">CC No./DR#</th>

			<th class="text-center">Client</th>

			<th class="text-center">Status</th>			

			<th class="text-center">Total Amount</th>

		</tr>

		<?php

		if (isset($_POST['submit'])) {

			$date_start = $_POST['pc_date_start'];

			$date_end = $_POST['pc_date_end'];

			$client = $_POST['pc_client'];

			$employee = $_POST['pc_employee'];

			$cc_start = $_POST['pc_cc_start'];

			$cc_end = $_POST['pc_cc_end'];

			if (empty($client) && empty($cc_start) && empty($cc_end) && empty($employee) && !empty($date_start) && !empty($date_end)) {

				$sql = "SELECT * FROM transaction WHERE trans_date BETWEEN :date_start AND :date_end AND status = 1 ";

				$stmt = $pdo -> prepare($sql);

				$stmt -> bindParam(":date_start", $date_start);

				$stmt -> bindParam(":date_end", $date_end);

				$stmt -> execute();

			} else if (empty($client) && empty($cc_start) && empty($cc_end) && !empty($employee) && !empty($date_start) && !empty($date_end)) {

				$sql = "SELECT * FROM transaction WHERE emp_id = :emp_id AND trans_date BETWEEN :date_start AND :date_end AND status = 1 ";

				$stmt = $pdo -> prepare($sql);

				$stmt -> bindParam(":emp_id", $employee);

				$stmt -> bindParam(":date_start", $date_start);

				$stmt -> bindParam(":date_end", $date_end);

				$stmt -> execute();

			} else if (empty($client) && empty($employee) && !empty($cc_start) && !empty($cc_end) && !empty($date_start) && !empty($date_end)) {

				$sql = "SELECT * FROM transaction WHERE trans_date BETWEEN :date_start AND :date_end AND cc_num BETWEEN :cc_start AND :cc_end AND status = 1 ";

				$stmt = $pdo -> prepare($sql);

				$stmt -> bindParam(":cc_start", $cc_start);

				$stmt -> bindParam(":cc_end", $cc_end);

				$stmt -> bindParam(":date_start", $date_start);

				$stmt -> bindParam(":date_end", $date_end);

				$stmt -> execute();

			} else if (!empty($client) && empty($cc_start) && empty($cc_end) && !empty($employee) && !empty($date_start) && !empty($date_end)) {

				$sql = "SELECT * FROM transaction WHERE emp_id = :emp_id AND client_name LIKE concat('%',:client_name,'%') AND trans_date BETWEEN :date_start AND :date_end AND status = 1  ";

				$stmt = $pdo -> prepare($sql);

				$stmt -> bindParam(":emp_id", $employee);

				$stmt -> bindParam(":client_name", $client);

				$stmt -> bindParam(":date_start", $date_start);

				$stmt -> bindParam(":date_end", $date_end);

				$stmt -> execute();

			} else if (!empty($client) && empty($cc_start) && empty($cc_end) && empty($employee) && !empty($date_start) && !empty($date_end)) {

				$sql = "SELECT * FROM transaction WHERE client_name LIKE concat('%',:client_name,'%') AND trans_date BETWEEN :date_start AND :date_end AND status = 1  ";

				$stmt = $pdo -> prepare($sql);

				$stmt -> bindParam(":client_name", $client);

				$stmt -> bindParam(":date_start", $date_start);

				$stmt -> bindParam(":date_end", $date_end);

				//client_name LIKE concat('%',:client_name,'%')

				$stmt -> execute();

			}

			$countres = $stmt -> rowCount();

			if ($countres > 0) {

				$empID = 0;

				while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {

				$id = $row['trans_id'];

				$date_start = $row['trans_date'];

				$date_start = date("j-M-Y", strtotime($date_start));

				$cc_number = $row['cc_num'];

				$client = $row['client_name'];

				$emp_id = $row['emp_id'];

				$account = $row['client_account'];
			

				// QUERY FOR THE ACCOUNT

				//QUERY FOR THE SUM

				$sql = "SELECT SUM(amount) as tamount FROM transaction_details WHERE trans_id = :trans_id";

				$stmt2 = $pdo -> prepare($sql);

				$stmt2 -> bindParam(":trans_id", $id);

				$stmt2 -> execute();

				$countRow = $stmt2 -> rowCount();

					if ($countRow > 0) {

					while ($row = $stmt2 -> fetch(PDO::FETCH_ASSOC)){

							$amount = $row['tamount'];

						}

					} else {

						$amount = 0;

					}

				$sql = "SELECT emp_name FROM users WHERE user_id = :user_id";

				$stmt2 = $pdo -> prepare($sql);

				$stmt2 -> bindParam(":user_id", $emp_id);

				$stmt2 -> execute();

				$row = $stmt2 -> fetch();	

				$employee_name = $row['emp_name'];

				

				if ($emp_id != $empID) {

					echo "

						<tr>

							<td colspan='5'> <h5> $employee_name </h5> </td>

						</tr>

					";	

				}



				$empID = $emp_id;

				echo "

					<tr>

						<td class='text-center text-nowrap' rowspan=''> $date_start </td>

						<td class='text-center'> $cc_number </td>

						<td class='text-center'> $client </td>

						<td class='text-center'> $account </td>					

						<td class='text-center'> $amount </td>

					</tr>

					";

				}

			} else {

				echo "

					<tr>

					<td colspan='13' class='text-center'> <h4> NO RESULT FOUND. </h4> </td>

					</tr>

				";

			}

		} else {

			echo "

				<tr>

					<th class='text-center' colspan='5'> Please go back and select a date again. </th>

				</tr>

			";

		}

		?>

	</table>

	</div>

</body>

</html>

