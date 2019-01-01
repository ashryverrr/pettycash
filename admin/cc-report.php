<?php
require_once "../config/connection.php";
?>
<!DOCTYPE html>
<html>
<head>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Customer Call Report</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
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
		thead {
	    display: table-row-group;
		}
  	}
  </style>
</head>
</head>
<body>
	<div class="">
		<h4 class="text-center">CUSTOMER CALL REPORT</h4>
			<h5 class="text-center">
			<?php
			 $output = "";
			 if (isset($_POST['cc_date_start_rep']) && isset($_POST['cc_date_end_rep'])) {
			 $date_start = $_POST['cc_date_start_rep'];
			 $date_end = $_POST['cc_date_end_rep'];
			 $date_start = date("M j, Y", strtotime($date_start));
			 $date_end = date("M j, Y", strtotime($date_end));
			 $output .= " <b> $date_start </b> to <b> $date_end </b> ";
			 }
			 if (!empty($_POST['client_report'])) {
			 	$client = $_POST['client_report'];
			 	$output .= "
			 		<br><br>
			 		<b> Client: </b> $client
			 	";
			 }
			 if (!empty($_POST['employee_report'])) {
			 	$employee = $_POST['employee_report'];
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
			 if (!empty($_POST['cc_start_rep']) && !empty($_POST['cc_end_rep'])) {
			 	$cc_start_rep = $_POST['cc_start_rep'];
			 	$cc_end_rep = $_POST['cc_end_rep'];
			 	$output .= "
			 		<br><br>
			 		<b> CC Number: </b> $cc_start_rep to $cc_end_rep
			 	";
			 }
			 echo $output;
			 ?></h5>
			 <?php

			 if (isset($_POST['submit'])) {
			 	$date_start = $_POST['cc_date_start_rep'];
				$date_end = $_POST['cc_date_end_rep'];
				$client = $_POST['client_report'];
				$employee = $_POST['employee_report'];
				$cc_start = $_POST['cc_start_rep'];
				$cc_end = $_POST['cc_end_rep'];

			 }
			
			 ?>
			 <form method="POST" action="create-excel-cc.php">
			 	<input type="hidden" name="cc_date_start_rep" value="<?php echo $date_start; ?>">
			 	<input type="hidden" name="cc_date_end_rep" value="<?php echo $date_end; ?>">
			 	<input type="hidden" name="client_report" value="<?php echo $client; ?>">
			 	<input type="hidden" name="employee_report" value="<?php echo $employee; ?>">
			 	<input type="hidden" name="cc_start_rep" value="<?php echo $cc_start; ?>">
			 	<input type="hidden" name="cc_end_rep" value="<?php echo $cc_end; ?>">
			 
			 	<h5 class="text-center no-print"> <button class="btn btn-default btn-sm" name="submit" type="submit"> Export Excel File </button> </h5>
			 </form>
	</div>
	<div class="">	
	<table class="table table-condensed table-bordered table-striped">	
			
						<thead>
							<th class="text-center">Date</th>
							<th class="text-center text-nowrap">CC#./DR#</th>
							<th class="text-center">Status</th>
							<th class="text-center">Client</th>
							<th class="text-center">Address</th>
							<th class="text-center">Model/Ctr No./SN</th>
							<th class="text-center">Task/Activity</th>			
							<th class="text-center">Parts Replaced</th>
							<th class="text-center">S/N</th>
							<th class="text-center">Outcome/Remarks</th>
							<th class="text-center">Time Started</th>
							<th class="text-center">Time Finished</th>
							<th class="text-center">Signed</th>
							<th class="text-center">Charges/Paid Amount</th>
						</thead>
				
<?php
if (isset($_POST['submit'])) {	
	$date_start = $_POST['cc_date_start_rep'];
	$date_end = $_POST['cc_date_end_rep'];
	$client = $_POST['client_report'];
	$employee = $_POST['employee_report'];
	$cc_start = $_POST['cc_start_rep'];
	$cc_end = $_POST['cc_end_rep'];

	if (empty($client) && empty($employee) && empty($cc_start) && empty($cc_end) && !empty($date_start) && !empty($date_end) ) {
		$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_status = 1 AND ccr_date BETWEEN :date_start AND :date_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";
		$stmt_1 = $pdo -> prepare($sql);
		$stmt_1 -> bindParam(":date_start", $date_start);
    	$stmt_1 -> bindParam(":date_end", $date_end);
    	$stmt_1 -> bindParam(":1date_start", $date_start);
    	$stmt_1 -> bindParam(":1date_end", $date_end);
		$stmt_1 -> execute();	
		
	} else if (empty($employee) && empty($cc_start) && empty($cc_end) && !empty($client) && !empty($date_start) && !empty($date_end) ) {
		$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE 	 ccr_status = 1 AND ccr_client = :ccr_client AND ccr_date BETWEEN :date_start AND :date_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_client = :ar_client AND ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";
		$stmt_1 = $pdo -> prepare($sql);
		$stmt_1 -> bindParam(":ccr_client", $client);		
		$stmt_1 -> bindParam(":date_start", $date_start);
    	$stmt_1 -> bindParam(":date_end", $date_end);
    	$stmt_1 -> bindParam(":ar_client", $client);
    	$stmt_1 -> bindParam(":1date_start", $date_start);
    	$stmt_1 -> bindParam(":1date_end", $date_end);
		$stmt_1 -> execute();	
	} else if(empty($cc_start) && empty($cc_end) && !empty($client) && !empty($date_start) && !empty($date_end) && !empty($employee) ){
		$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_status = 1 AND ccr_client = :ccr_client AND ccr_user_id = :ccr_user AND ccr_date BETWEEN :date_start AND :date_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_client = :ar_client AND ar_user_id = :ar_id AND ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";
		$stmt_1 = $pdo -> prepare($sql);
		$stmt_1 -> bindParam(":ar_id", $employee);		
		$stmt_1 -> bindParam(":ccr_user", $employee);		
		$stmt_1 -> bindParam(":ccr_client", $client);		
		$stmt_1 -> bindParam(":date_start", $date_start);
    	$stmt_1 -> bindParam(":date_end", $date_end);
    	$stmt_1 -> bindParam(":ar_client", $client);
    	$stmt_1 -> bindParam(":1date_start", $date_start);
    	$stmt_1 -> bindParam(":1date_end", $date_end);
		$stmt_1 -> execute();	
	} else if (!empty($cc_start) && !empty($cc_end) && !empty($client) && !empty($date_start) && !empty($date_end) && !empty($employee) ) {
		$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_status = 1 AND ccr_client = :ccr_client AND ccr_user_id = :ccr_user AND ccr_date BETWEEN :date_start AND :date_end AND ccr_cc_num BETWEEN :cc_start AND :cc_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_client = :ar_client AND ar_user_id = :ar_id AND ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";		
		$stmt_1 = $pdo -> prepare($sql);
		$stmt_1 -> bindParam(":cc_start", $cc_start);
        $stmt_1 -> bindParam(":cc_end", $cc_end);
		$stmt_1 -> bindParam(":ar_id", $employee);		
		$stmt_1 -> bindParam(":ccr_user", $employee);		
		$stmt_1 -> bindParam(":ccr_client", $client);		
		$stmt_1 -> bindParam(":date_start", $date_start);
    	$stmt_1 -> bindParam(":date_end", $date_end);
    	$stmt_1 -> bindParam(":ar_client", $client);
    	$stmt_1 -> bindParam(":1date_start", $date_start);
    	$stmt_1 -> bindParam(":1date_end", $date_end);
		$stmt_1 -> execute();	
	} else if (!empty($cc_start) && !empty($cc_end) && empty($client) && !empty($date_start) && !empty($date_end) && empty($employee) ) {
		$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_status = 1 AND ccr_date BETWEEN :date_start AND :date_end AND ccr_cc_num BETWEEN :cc_start AND :cc_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE  ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";		
		$stmt_1 = $pdo -> prepare($sql);
		$stmt_1 -> bindParam(":cc_start", $cc_start);
        $stmt_1 -> bindParam(":cc_end", $cc_end);			
		$stmt_1 -> bindParam(":date_start", $date_start);
    	$stmt_1 -> bindParam(":date_end", $date_end);    	
    	$stmt_1 -> bindParam(":1date_start", $date_start);
    	$stmt_1 -> bindParam(":1date_end", $date_end);
		$stmt_1 -> execute();	
	} else if (!empty($cc_start) && !empty($cc_end) && empty($client) && !empty($date_start) && !empty($date_end) && !empty($employee) ) {
			$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_status = 1 AND ccr_user_id = :id AND ccr_date BETWEEN :date_start AND :date_end AND ccr_cc_num BETWEEN :cc_start AND :cc_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_user_id = :rid AND ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";		
		$stmt_1 = $pdo -> prepare($sql);
		$stmt_1 -> bindParam(":id", $employee);
		$stmt_1 -> bindParam(":rid", $employee);
		$stmt_1 -> bindParam(":cc_start", $cc_start);
        $stmt_1 -> bindParam(":cc_end", $cc_end);			
		$stmt_1 -> bindParam(":date_start", $date_start);
    	$stmt_1 -> bindParam(":date_end", $date_end);    	
    	$stmt_1 -> bindParam(":1date_start", $date_start);
    	$stmt_1 -> bindParam(":1date_end", $date_end);
		$stmt_1 -> execute();	
	} else if (!empty($cc_start) && !empty($cc_end) && !empty($client) && !empty($date_start) && !empty($date_end) && empty($employee) ) {
			$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_status = 1 AND ccr_client = :client AND ccr_date BETWEEN :date_start AND :date_end AND ccr_cc_num BETWEEN :cc_start AND :cc_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_client = :client1 AND ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";		
		$stmt_1 = $pdo -> prepare($sql);
		$stmt_1 -> bindParam(":client", $client);
		$stmt_1 -> bindParam(":client1", $client);
		$stmt_1 -> bindParam(":cc_start", $cc_start);
        $stmt_1 -> bindParam(":cc_end", $cc_end);			
		$stmt_1 -> bindParam(":date_start", $date_start);
    	$stmt_1 -> bindParam(":date_end", $date_end);    	
    	$stmt_1 -> bindParam(":1date_start", $date_start);
    	$stmt_1 -> bindParam(":1date_end", $date_end);
		$stmt_1 -> execute();	
	} else if (empty($client) && !empty($employee) && empty($cc_start) && empty($cc_end) && !empty($date_start) && !empty($date_end) ) {
		$sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_status = 1 AND ccr_user_id = :id AND ccr_date BETWEEN :date_start AND :date_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_user_id = :rid AND ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";
		$stmt_1 = $pdo -> prepare($sql);
		$stmt_1 -> bindParam(":id", $employee);
		$stmt_1 -> bindParam(":rid", $employee);
		$stmt_1 -> bindParam(":date_start", $date_start);
    	$stmt_1 -> bindParam(":date_end", $date_end);
    	$stmt_1 -> bindParam(":1date_start", $date_start);
    	$stmt_1 -> bindParam(":1date_end", $date_end);
		$stmt_1 -> execute();	
		
	} 
	$emp_id = 0;

	while ($row1 = $stmt_1 -> fetch(PDO::FETCH_ASSOC) ) {
		$ccr_id = $row1['ccr_id'];
		$ccr_client = $row1['ccr_client'];
		$ccr_date = $row1['ccr_date'];
		$uid = $row1['ccr_user_id'];

		$sql = "SELECT * FROM cc_report WHERE ccr_id = :id AND ccr_client = :client AND ccr_date = :cDate ";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":id", $ccr_id);
		$stmt -> bindParam(":client", $ccr_client);
		$stmt -> bindParam(":cDate", $ccr_date);
		$stmt -> execute();
		$row = $stmt -> fetch();
		$countRow = $stmt -> rowCount();
		$ccr_user_id = $row['ccr_user_id'];	
				
		if ($countRow > 0) {	

			$query = "SELECT emp_name FROM users WHERE user_id = :eid";
			$query = $pdo -> prepare($query);
			$query -> bindParam(":eid", $ccr_user_id);
			$query -> execute();
			$query_row = $query -> fetch();
			$emp_name = $query_row['emp_name'];
			if ($ccr_user_id != $emp_id) {
						echo "						
							<tr class=''>
								<td colspan='13'>
							 		<h4> $emp_name </h4>
							 	</td>
							 </tr>						
							";	
						$emp_id = $ccr_user_id;				
			} 

			$id = $row['ccr_id'];
			$date_start = $row['ccr_date'];
			$date_start = date("j-M-Y", strtotime($date_start));
			$cc_number = $row['ccr_cc_num'];
			$ccr_signedBy = $row['ccr_signedBy'];
			$client = $row['ccr_client'];
			$ccr_time_start = $row['ccr_time_start'];
			$ccr_time_end = $row['ccr_time_end'];
			$ccr_time_start = date("g:i a", strtotime($ccr_time_start));
			$ccr_time_end = date("g:i a", strtotime($ccr_time_end));
			$ccr_model = $row['ccr_model'];
			$ccr_serial_nos = "/ ".$row['ccr_serial_nos'];
			$ccr_complaint = $row['ccr_complaint'];
			$ccr_remarks = $row['ccr_remarks'];
			$account = $row['ccr_client_account'];
			$rr_number = $row['rr_number'];				
			$ccr_user_id = $row['ccr_user_id'];
			$sqll = "SELECT client_address FROM clients
				WHERE concat(clients.client_name,' ',clients.client_branch) LIKE(:client_name)";
			$stmtt = $pdo -> prepare($sqll);
			$stmtt -> bindParam(":client_name", $client);
			$stmtt -> execute();
			$address_row = $stmtt -> fetch();
			$address = $address_row['client_address'];			
			$sql = "SELECT sum(ccr_amt) as tamount FROM cc_report_info WHERE ccr_report_id = :id ";
			$stmtt = $pdo -> prepare($sql);
			$stmtt -> bindParam(":id", $id);
			$stmtt -> execute();
			$amountRow = $stmtt -> fetch();	

			$emp_id = $ccr_user_id;				
				echo "
					<tr>
						<td class='text-center text-nowrap' rowspan=''> $date_start </td>
						<td class='text-center'> $cc_number </td>
						<td class='text-center'> $account </td>
						<td class='text-center'> $client </td>
						<td class='text-center'> $address </td>
						<td class='text-center text-nowrap'> $ccr_model $ccr_serial_nos </td>
						<td class='text-center'> $ccr_complaint </td>
						<td class='text-center'> none </td>						
						<td class='text-center'> none </td>
						<td class='text-center'> $ccr_remarks </td>
						<td class='text-center text-nowrap'> $ccr_time_start </td>
						<td class='text-center text-nowrap'> $ccr_time_end </td>
						<td class='text-center text-nowrap'> $ccr_signedBy </td>
						<td class='text-center'> none </td>
					</tr>
				";


            	 $sql2 = "SELECT * FROM cc_report_info WHERE ccr_report_id = :id";
                  $stmt2 = $pdo -> prepare($sql2);
                  $stmt2 -> bindParam(":id" ,$id);
                  $stmt2 -> execute();
                  $countRow = $stmt2 -> rowCount();
                  if ($countRow > 0) {
                        while ($row = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
       
                              $ccr_particulars = $row['ccr_particulars'];
                              $ccr_serial = $row['ccr_serial'];
                              $ccr_amt = $row['ccr_amt'];
                              if ($ccr_particulars == "" && $ccr_serial == "") {
                              
                              } else if ($rr_number == "") {                                    
                                    echo "
									<tr>
										<td class='text-center text-nowrap' rowspan=''>  </td>
										<td class='text-center'>  </td>
										<td class='text-center'>  </td>
										<td class='text-center'>  </td>
										<td class='text-center'>  </td>
										<td class='text-center text-nowrap'> </td>
										<td class='text-center'> </td>
										<td class='text-center'> $ccr_particulars </td>						
										<td class='text-center'> $ccr_serial </td>
										<td class='text-center'> </td>
										<td class='text-center text-nowrap'> </td>
										<td class='text-center text-nowrap'> </td>
										<td class='text-center text-nowrap'> </td>
										<td class='text-center'> For Collection / $ccr_amt </td>
									</tr>
								";
                              } else {
                                    echo "
									<tr>
										<td class='text-center text-nowrap' rowspan=''>  </td>
										<td class='text-center'>  </td>
										<td class='text-center'>  </td>
										<td class='text-center'>  </td>
										<td class='text-center'>  </td>
										<td class='text-center text-nowrap'> </td>
										<td class='text-center'> </td>
										<td class='text-center'> $ccr_particulars </td>						
										<td class='text-center'> $ccr_serial </td>
										<td class='text-center'> </td>
										<td class='text-center text-nowrap'> </td>
										<td class='text-center text-nowrap'> </td>
										<td class='text-center text-nowrap'> </td>
										<td class='text-center'> $ccr_amt </td>
									</tr> 
									";
                              }
                        }
                  }
				
		} else {

		$sql = "SELECT ar_user_id FROM activity_report WHERE ar_user_id = :id";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":id", $uid);
		$stmt -> execute();
		$row = $stmt -> fetch();
		$ccr_user_id = $row['ar_user_id'];	

		$query = "SELECT emp_name FROM users WHERE user_id = :eid";
		$query = $pdo -> prepare($query);
		$query -> bindParam(":eid", $ccr_user_id);
		$query -> execute();
		$query_row = $query -> fetch();
		$emp_name = $query_row['emp_name'];
		if ($ccr_user_id != $emp_id) {
					echo "						
						<tr>
							<td colspan='13'>
						 		<h4> $emp_name </h4>
						 	</td>
						 </tr>						
						";	
					$emp_id = $ccr_user_id;				
		} 


		$sql_2 = "SELECT ar_id, ar_user_id, ar_client, ar_client_account, ar_date_started, ar_time_start, ar_time_end, ar_activity FROM activity_report WHERE ar_id = :id AND ar_client = :client AND ar_date_started = :cDate ";
		$stmt_2 = $pdo -> prepare($sql_2);
		$stmt_2 -> bindParam(":id", $ccr_id);
		$stmt_2 -> bindParam(":client", $ccr_client);
		$stmt_2 -> bindParam(":cDate", $ccr_date);
		$stmt_2 -> execute();
		$row = $stmt_2 -> fetch();
		
		$ar_client = $row['ar_client'];
		$ar_client_account = $row['ar_client_account'];
		$ar_date_started = $row['ar_date_started'];
		$ccr_date = date("j-M-Y", strtotime($ccr_date));
		$ar_time_start = $row['ar_time_start'];
		$ar_time_start = date("g:i a", strtotime($ar_time_start));
		$ar_time_end = $row['ar_time_end'];
		$ar_time_end = date("g:i a", strtotime($ar_time_end));
		$ar_activity = $row['ar_activity'];
			 echo "
			 	<tr>
			 		<td> $ccr_date </td>
		 			<td class='text-center'> OFFICE </td>
					<td class='text-center'> $ar_client_account </td>
					<td class='text-center'> $ar_client </td>
					<td class='text-center'> NONE </td>
					<td class='text-center text-nowrap'> NONE </td>
					<td class='text-center'> NONE </td>
					<td class='text-center'> NONE </td>						
					<td class='text-center'> NONE </td>
					<td class='text-center'> $ar_activity </td>
					<td class='text-center text-nowrap'> $ar_time_start </td>
					<td class='text-center text-nowrap'> $ar_time_end </td>
					<td class='text-center'> none </td>
			 	</tr>";
						
		}
	}
} else {
				 echo "
			 	<tr>
			 		<td class='text-center' colspan='12'> <h4> Empty parameters. </h4> </td>
			 	</tr>";
}
?>
</table>
</div>
</body>
</html>
