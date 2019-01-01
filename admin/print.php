<!DOCTYPE>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
    <style type="text/css" media="print">
    @media print{
    @page {
      size: auto;
      margin: 0 0 0 0;
    }   
    header, footer {
     display: none;
    }
    title{
      display: none;
    }
    }
    </style>
</head>
<body>
<?php
//"Courier New", monospace, serif;
require_once '../config/connection.php';
$k_id = $_POST['detail_id'];
$sql = "SELECT * FROM transaction WHERE trans_id = :transid ";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(':transid', $k_id);
$stmt -> execute();
$row = $stmt -> fetch();
$transid = $row['trans_id'];
$emp_id = $row['emp_id'];
$sql1 = "SELECT emp_name FROM users WHERE user_id = :uid ";
$stmt1 = $pdo -> prepare($sql1);
$stmt1 -> bindParam(':uid', $emp_id);
$stmt1 -> execute();
$name_row = $stmt1 -> fetch();
$empname = $name_row['emp_name'];
$trans_date = $row['trans_date'];
$client_name = $row['client_name'];
$amount = $row['amount'];
$amount_given = $row['amount'];
$ccnum = $row['cc_num'];
$others = $row['others'];
if ($ccnum == "0000") {
	$ccnum = $others;
}
//try {
	$border = str_repeat("-", 61);
	echo "<center> <b> PETTY CASH LIQUIDATION </center>";
	echo "Name: $empname </b> <br>";
	echo "Date: $trans_date <br>";
	echo "CC#/DR#: $ccnum<br>";
	echo "Amount: $amount<br>";
	echo "Client: $client_name<br>";
	echo "$border<br>";
	echo "<div class='row'>
			<b>
			<div class='col-xs-3'>
			 VEHICLE
			</div>
			<div class='col-xs-5'>
			 EXPENSES
			</div>
			<div class='col-xs-3'>
			 AMOUNT 
		 	</div>
		    </b>
	 	</div>";
	echo "$border<br>";
	//LOOP FOR THE DETAILS
	$counter = "SELECT * FROM transaction_details WHERE trans_id = :k_id ";
	$countergo = $pdo-> prepare($counter);
	$k_id = $_POST['detail_id'];
	//$k_id = 12;
	$countergo -> bindParam(':k_id', $k_id);
	$countergo -> execute();
	$count_details = $countergo -> rowCount();
	#check for the number of details available
	if ($count_details > 0) {
	$sql = "SELECT transaction.trans_date as tdate, transaction_details.expenses as texpenses, transaction_details.amount as tamount, transaction_details.vehicle as vehicle FROM transaction LEFT JOIN transaction_details on transaction.trans_id = transaction_details.trans_id WHERE transaction.trans_id = :k_id ";
	$stmt = $pdo->prepare($sql);
	$transid = $_POST['detail_id'];
	$stmt -> bindParam(':k_id', $transid);
	$stmt -> execute();
	$row_count = $stmt ->rowCount();
	if ($row_count > 0) {
		$total = 0;
		for($i = 0; $i < $row_count;  $i++){
			$row = $stmt -> fetch(PDO::FETCH_ASSOC);
			$vehicle = strtoupper($row['vehicle']);
			$tdate = $row['tdate'];
			$texpenses = strtoupper($row['texpenses']);
		    $amount = $row['tamount'];
		    $total += $amount;
		    $total1 = sprintf('%0.2f',$total);
		    $date = $row['tdate'];
			echo "<div class='row'>
					<div class='col-xs-3'>
						$vehicle
					</div>
					<div class='col-xs-6'>
						 $texpenses
					</div>
					<div class='col-xs-3 text-right' style='padding-right: 20px'>
						$amount
				 	</div>
			 	</div>";
		}
	  }
	}
	$excess = $amount_given - $total1;
	$excess = sprintf('%0.2f',$excess);
	if ($excess > 0) {
		$excess1 = $excess;
		$refund1 = "0.00";
	} else {
		$excess1 = "0.00";
	}
	if ($amount_given > 0) {
		$refund = $amount_given - $total1;
		if ($refund < 0) {
			$refund = $amount_given - $total1;
			$refund1 = abs($refund);
			$refund1 = sprintf('%0.2f',$refund1);
	        $excess = 0.00;
		}
	} else {
		$refund1 = "0.00";
	}
	echo "$border<br>";
	$underline = str_repeat("_", 26);
	echo "Approved By: $underline<br>";
	echo "Date: <br>";
	echo "
		<div class='row'>
			<div class='col-xs-9'>
				Total Expenses:
			</div>
			<div class='col-xs-3 text-right' style='padding-right: 20px'>
			 	$total1
			</div>
	 	</div>
    ";
    echo "
		<div class='row'>
			<div class='col-xs-9'>
				Refund:
			</div>
			<div class='col-xs-3 text-right' style='padding-right: 20px'>
			 	$refund1
			</div>
	 	</div>
    ";
    echo "
		<div class='row'>
			<div class='col-xs-9'>
				Excess:
			</div>
			<div class='col-xs-3 text-right' style='padding-right: 20px'>
			 	$excess1
			</div>
	 	</div>
    ";

	$today = date("Y-m-d h:i a", time());
	echo "<p class='text-center'> $today </p>";

	$cc_num_r =  explode(',', $ccnum);
	$count = count($cc_num_r);

if ($count > 0) {
	foreach ($cc_num_r as $key) {
	$sql = "SELECT SUM(ccr_amt) as total_sum, rr_number FROM cc_report
			RIGHT JOIN cc_report_info ON cc_report.ccr_id = cc_report_info.ccr_report_id
			WHERE ccr_cc_num = :ccnum";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":ccnum", $key);
		$stmt -> execute();
		$count = $stmt -> rowCount();
		if ($count > 0) {
			$row = $stmt -> fetch();
			$rr_number = $row['rr_number'] ?: "<b> For collection </b>";
			$amount = $row['total_sum'];	
			if(!empty($amount)){
				echo "
				<div class='row'>
					<div class='col-xs-4'>
						RR#: $rr_number
					</div>
					<div class='col-xs-4'>
						CC#: $key
					</div>
					<div class='col-xs-4'>
						$amount
					</div>
				</div>
				";
			}
				
		}			
	}
}
?>
</body>
</html>

<script type="text/javascript">
window.onload = function() { window.print(); }
</script>