<?php
require_once '..\config\connection.php';


$k_id = $_POST['detail_id'];
$contents = " ";
$sql = "SELECT * FROM transaction WHERE trans_id = :transid ";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(':transid', $k_id);
$stmt -> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
	$emp_id = $row['emp_id'];
	$sql1 = "SELECT emp_name FROM users WHERE user_id = :uid ";
    $stmt1 = $pdo -> prepare($sql1);
    $stmt1 -> bindParam(':uid', $emp_id);
    $stmt1 -> execute(); 			
    $name_row = $stmt1 -> fetch();
   	$empname = $name_row['emp_name'];   
	$date = date("Y-m-d");
	$client_name = $row['client_name'];
	$amount = $row['amount'];
	$ccnum = $row['cc_num'];
}

$counter = "SELECT * FROM transaction_details WHERE trans_id = :k_id ";
$countergo = $pdo-> prepare($counter);
$k_id = $_POST['detail_id'];;
$countergo -> bindParam(':k_id', $k_id);
$countergo -> execute();
$count_details = $countergo -> rowCount();
if ($count_details > 0) { #check for the number of details available
$sql = "SELECT transaction.trans_date as tdate, transaction_details.expenses as texpenses, transaction_details.amount as tamount, transaction_details.vehicle as vehicle FROM transaction INNER JOIN transaction_details on transaction.trans_id = transaction_details.trans_id WHERE transaction.trans_id = :k_id ";
$stmt = $pdo->prepare($sql);
$stmt -> bindParam(':k_id', $k_id);
$stmt -> execute();	
$row_count = $stmt ->rowCount();



$myfile = fopen("printme.txt", "w") or die("Unable to open file!");


$center = 40 /2;
$perline = strlen() / 2;
$middle = $center - $perline;



$contents .= "			
     	PETTY CASH 
      LIQUIDATION FORM 
DATE PRINTED: $date 
NAME: $empname 
CC#/DR#: $ccnum \r
AMOUNT: $amount \r
CLIENT: $client_name \r
VEHICLE         EXPENSES       AMOUNT \r
";



$petty = "PETTY CASH";
testing($petty);
$numberOfSpaces = testing($petty);

function CountMe($a){
  $middle = 0;
  $center = 40 / 2;
  $perline = strlen($a) / 2;
  $middle = $center - $perline;
  return $middle;
}

if ($row_count > 0) {
	$total = 0;
	$daya = 8 + $row_count;	
	for($i = 8; $i < $daya;  $i++){
		$row = $stmt -> fetch(PDO::FETCH_ASSOC);
			
	$vehicle = strtoupper($row['vehicle']);
	$tdate = $row['tdate'];
	$texpenses = strtoupper($row['texpenses']);
    $amount = $row['tamount'];
    $total += $amount;
    $total1 = sprintf('%0.2f',$total);	
    $date = $row['tdate'];	

    $contents .= "
$vehicle       $texpenses		$amount \r
	";

		}
	  }
	

$contents .= "
				APPROVED BY: \r
				TOTAL EXPENSES: $total1\r
				REFUND:\r
				EXCESS:\r
";


fwrite($myfile, $contents);
fclose($myfile);




$handle = printer_open("BIXOLON");
printer_set_option($handle, PRINTER_PAPER_FORMAT, PRINTER_FORMAT_CUSTOM);
printer_set_option($handle, PRINTER_PAPER_WIDTH, 76);
printer_logical_fontheight($handle, 5);
printer_start_doc($handle, "My Document");
printer_start_page($handle);
$filename = "printme.txt";
$file = $filename;
$contents = file($file); 
printer_draw_text($handle, $contents);
printer_end_page($handle);
printer_end_doc($handle);
printer_close($handle);
	

$filecontents = file_get_contents("printme.txt");
print "<script>window.print()</script>";

} else {
	echo "Printer is not connected.";
}

?>