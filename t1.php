<?php
require_once "../config/connection.php";
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

$objPHPExcel->getActiveSheet()->getStyle('A1:M4')->getFont()->setBold(true);

$colorArray = array(
      'fill' => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => '41bbf4')
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A4:M4')->applyFromArray($colorArray); //color
$objPHPExcel->getActiveSheet()->getStyle("A1:M1")->getFont()->setSize(20); //font size
$objPHPExcel->getActiveSheet()->getStyle("A4:M4")->getFont()->setSize(12); //font size
$objPHPExcel->getActiveSheet()->mergeCells('A1:M1'); //merge cells
$objPHPExcel->getActiveSheet()->mergeCells('G2:H2'); //merge 
$objPHPExcel->getActiveSheet()->mergeCells('G3:H3'); //merge 
$objPHPExcel->getActiveSheet()->getStyle("M")->getNumberFormat()->setFormatCode('0.00'); 

$objPHPExcel->getActiveSheet()
    ->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getDefaultStyle()
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$employee_name = "";
      if (isset($_POST['cc_date_start_rep']) && isset($_POST['cc_date_end_rep'])) {
                   $date_start = $_POST['cc_date_start_rep'];
                   $date_end = $_POST['cc_date_end_rep'];
                   $date_start = date("M j, Y", strtotime($date_start));
                   $date_end = date("M j, Y", strtotime($date_end));
                                      }
                   if (!empty($_POST['client_report'])) {
                   $client = $_POST['client_report'];
            
                   }
                   if (!empty($_POST['employee_report'])) {
                   $employee = $_POST['employee_report'];
                   $sql = "SELECT emp_name FROM users WHERE user_id = :id ";
                   $stmt = $pdo -> prepare($sql);
                   $stmt -> bindParam(":id", $employee);
                   $stmt -> execute();
                   $row = $stmt -> fetch();
                   $employee_name = $row['emp_name'];                   
                   }
                   if (!empty($_POST['cc_start_rep']) && !empty($_POST['cc_end_rep'])) {
                   $cc_start_rep = $_POST['cc_start_rep'];
                   $cc_end_rep = $_POST['cc_end_rep'];                  
      }
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'CUSTOMER CALL REPORT');
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G2', $date_start.' to '.$date_end);
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('G3', $employee_name);            
$colorYellow = array(
            'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'f4f442')
          )
      );
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Date')
            ->setCellValue('B4', 'CC No./DR#')
            ->setCellValue('C4', 'Client')
            ->setCellValue('D4', 'Status')      
            ->setCellValue('E4', 'Address')
            ->setCellValue('G4', 'Model/Ctr No/ SN')
            ->setCellValue('F4', 'Task/Activity')            
            ->setCellValue('H4', 'Parts Replaced')
            ->setCellValue('I4', 'S/N')
            ->setCellValue('J4', 'Outcome/Remarks')
            ->setCellValue('K4', 'Time Started')
            ->setCellValue('L4', 'Time Finished')
            ->setCellValue('M4', 'Charges/Paid Amount');

if (isset($_POST['submit'])) {
      $date_start = $_POST['cc_date_start_rep'];
      $date_end = $_POST['cc_date_end_rep'];
      $client = $_POST['client_report'];
      $employee = $_POST['employee_report'];
      $cc_start = $_POST['cc_start_rep'];
      $cc_end = $_POST['cc_end_rep'];

      if (empty($client) && empty($cc_start) && empty($cc_end) && empty($employee) && !empty($date_start) && !empty($date_end)) {
            $sql = "SELECT * FROM cc_report WHERE ccr_date BETWEEN :date_start AND :date_end AND ccr_status = 1 ORDER BY ccr_user_id asc, ccr_date asc";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":date_start", $date_start);
            $stmt -> bindParam(":date_end", $date_end);
            $stmt -> execute();
      } else if (empty($cc_start) && empty($cc_end) && empty($employee) && !empty($client) && !empty($date_start) && !empty($date_end) ) {
            $sql = "SELECT * FROM cc_report WHERE  ccr_client = :client_name AND ccr_date BETWEEN :date_start AND :date_end AND ccr_status = 1 ORDER BY ccr_user_id asc, ccr_date asc";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":date_start", $date_start);
            $stmt -> bindParam(":date_end", $date_end);
            $stmt -> bindParam(":client_name", $client);
            $stmt -> execute();
      } else if (empty($cc_start) && empty($cc_end) && !empty($date_start) && !empty($date_end) && !empty($client) && !empty($employee)) {
            $sql = "SELECT * FROM cc_report WHERE  ccr_client = :client_name AND ccr_user_id = :employee AND ccr_date BETWEEN :date_start AND :date_end AND ccr_status = 1 ORDER BY ccr_user_id asc, ccr_date asc";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":date_start", $date_start);
            $stmt -> bindParam(":date_end", $date_end);
            $stmt -> bindParam(":client_name", $client);
            $stmt -> bindParam(":employee", $employee);
            $stmt -> execute();
      } else if (empty($cc_start) && empty($cc_end) && empty($client) && !empty($date_start) && !empty($date_end) && !empty($employee)) {
            $sql = "SELECT * FROM cc_report WHERE ccr_user_id = :ccr_user_id AND ccr_date BETWEEN :date_start AND :date_end AND ccr_status = 1 ORDER BY ccr_user_id asc, ccr_date asc";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":date_start", $date_start);
            $stmt -> bindParam(":date_end", $date_end);
            $stmt -> bindParam(":ccr_user_id", $employee);
            $stmt -> execute();
      } else if (empty($employee) && !empty($date_start) && !empty($date_end) && !empty($cc_start) && !empty($cc_end) && !empty($client)) {
            $sql = "SELECT * FROM cc_report WHERE ccr_client = :client AND ccr_date BETWEEN :date_start AND :date_end AND ccr_cc_num BETWEEN :cc_start AND :cc_end AND ccr_status = 1 ORDER BY ccr_user_id asc, ccr_date asc";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":client", $client);
            $stmt -> bindParam(":date_start", $date_start);
            $stmt -> bindParam(":date_end", $date_end);
            $stmt -> bindParam(":cc_start", $cc_start);
            $stmt -> bindParam(":cc_end", $cc_end);
            $stmt -> execute();
      } else if (empty($client) && !empty($date_start) && !empty($date_end) && !empty($cc_start) && !empty($cc_end) && !empty($employee)) {
            $sql = "SELECT * FROM cc_report WHERE ccr_user_id = :employee AND ccr_date BETWEEN :date_start AND :date_end AND ccr_cc_num BETWEEN :cc_start AND :cc_end AND ccr_status = 1 ORDER BY ccr_user_id asc, ccr_date asc";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":employee", $employee);
            $stmt -> bindParam(":date_start", $date_start);
            $stmt -> bindParam(":date_end", $date_end);
            $stmt -> bindParam(":cc_start", $cc_start);
            $stmt -> bindParam(":cc_end", $cc_end);
            $stmt -> execute();
      }  else if (empty($client) && empty($employee) && !empty($date_start) && !empty($date_end) && !empty($cc_start) && !empty($cc_end) ) {
            $sql = "SELECT * FROM cc_report WHERE ccr_date BETWEEN :date_start AND :date_end AND ccr_cc_num BETWEEN :cc_start AND :cc_end AND ccr_status = 1 ORDER BY ccr_user_id asc, ccr_date asc";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":date_start", $date_start);
            $stmt -> bindParam(":date_end", $date_end);
            $stmt -> bindParam(":cc_start", $cc_start);
            $stmt -> bindParam(":cc_end", $cc_end);
            $stmt -> execute();
      } else if(!empty($date_start) && !empty($date_end) && !empty($employee) && !empty($client) && !empty($cc_start) && !empty($cc_end) && !empty($employee)) {
            $sql = "SELECT * FROM cc_report WHERE  ccr_client = :client_name AND ccr_user_id = :employee AND ccr_date BETWEEN :date_start AND :date_end
                  AND ccr_cc_num BETWEEN :cc_start AND :cc_end AND ccr_status = 1 ORDER BY ccr_user_id asc, ccr_date asc";
            $stmt = $pdo -> prepare($sql);
            $stmt -> bindParam(":date_start", $date_start);
            $stmt -> bindParam(":date_end", $date_end);
            $stmt -> bindParam(":client_name", $client);
            $stmt -> bindParam(":employee", $employee);
            $stmt -> bindParam(":cc_start", $cc_start);
            $stmt -> bindParam(":cc_end", $cc_end);
            $stmt -> execute();
      }

      


      $countres = $stmt -> rowCount();
      if ($countres > 0) {
            $row_data = 5; // 1-based index
            $emp_id = 0;
            while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {

            $id = $row['ccr_id'];
            $date_start = $row['ccr_date'];
            $date_start = date("j-M-Y", strtotime($date_start));
            $cc_number = $row['ccr_cc_num'];
            $client = $row['ccr_client'];
            $ccr_time_start = $row['ccr_time_start'];
            $ccr_time_end = $row['ccr_time_end'];
            $ccr_time_start = date("g:i a", strtotime($ccr_time_start));
            $ccr_time_end = date("g:i a", strtotime($ccr_time_end));
            $ccr_model = $row['ccr_model'];
            $ccr_serial_nos = "/ ".$row['ccr_serial_nos'] ?: "";
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

            $query = "SELECT emp_name FROM users WHERE user_id = :eid";
            $query = $pdo -> prepare($query);
            $query -> bindParam(":eid", $ccr_user_id);
            $query -> execute();
            $query_row = $query -> fetch();
            $emp_name = $query_row['emp_name'];

            if ($ccr_user_id != $emp_id) {
              $objPHPExcel->getActiveSheet()->getStyle('A'.($row_data).':B'.($row_data))->applyFromArray($colorYellow);
              $objPHPExcel->getActiveSheet()->getStyle('A'.($row_data).':B'.($row_data))->getFont()->setSize(13); //font size
              $objPHPExcel->getActiveSheet()->mergeCells('A'.($row_data).':B'.($row_data)); 
              $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), $emp_name);
              $row_data++;              
            }

            $emp_id = $ccr_user_id;   

            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), $date_start);//DATE
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row_data), $cc_number); //CCNUMBER
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row_data), $client);//CLIENT NAME
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row_data), $account);//ACCOUNT
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row_data), $address);//ADDRESS
            //TASK/ACTIVITY
            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row_data), $ccr_model.$ccr_serial_nos);// model/serialnos
            $objPHPExcel->getActiveSheet()->setCellValue('G'.($row_data), $ccr_complaint);//
            $objPHPExcel->getActiveSheet()->setCellValue('H'.($row_data), "none");//parts replaced
            $objPHPExcel->getActiveSheet()->setCellValue('I'.($row_data), "none");//SN
            $objPHPExcel->getActiveSheet()->setCellValue('J'.($row_data), $ccr_remarks);//outcome remakrs
            $objPHPExcel->getActiveSheet()->setCellValue('K'.($row_data), $ccr_time_start);//TIME ST
            $objPHPExcel->getActiveSheet()->setCellValue('L'.($row_data), $ccr_time_end);//TIME FIN
            $objPHPExcel->getActiveSheet()->setCellValue('M'.($row_data), "none");//CHARGES
            


            $sql2 = "SELECT * FROM cc_report_info WHERE ccr_report_id = :id";
                  $stmt2 = $pdo -> prepare($sql2);
                  $stmt2 -> bindParam(":id" ,$id);
                  $stmt2 -> execute();
                  $countRow = $stmt2 -> rowCount();
                  if ($countRow > 0) {
                        while ($row = $stmt2 -> fetch(PDO::FETCH_ASSOC)){
                              $row_data++;   

                              $ccr_particulars = $row['ccr_particulars'];
                              $ccr_serial = $row['ccr_serial'];
                              $ccr_amt = $row['ccr_amt'];
                              if ($ccr_particulars == "" && $ccr_serial == "") {
                              
                              } else if ($rr_number == "") {
                                    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), "");//DATE
                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row_data), ""); //CCNUMBER
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row_data), "");//CLIENT NAME
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row_data), "");//ACCOUNT
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row_data), "");//ADDRESS
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row_data), "");// model/serialnos
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row_data), "");//parts
                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row_data), $ccr_particulars);//s/n
                                    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row_data), $ccr_serial);//outcome remarks
                                    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row_data), "");//TIME ST
                                    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row_data), "");//TIME FIN
                                    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row_data), "");//CHARGES
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.($row_data), "For Collection /".$ccr_amt);//CHARGES
                              } else {
                                    $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), "");//DATE
                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.($row_data), ""); //CCNUMBER
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.($row_data), "");//CLIENT NAME
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.($row_data), "");//ACCOUNT
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.($row_data), "");//ADDRESS
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.($row_data), "");// model/serialnos
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.($row_data), "");//parts
                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.($row_data), $ccr_particulars);//s/n
                                    $objPHPExcel->getActiveSheet()->setCellValue('I'.($row_data), $ccr_serial);//outcome remarks
                                    $objPHPExcel->getActiveSheet()->setCellValue('J'.($row_data), "");//TIME ST
                                    $objPHPExcel->getActiveSheet()->setCellValue('K'.($row_data), "");//TIME FIN
                                    $objPHPExcel->getActiveSheet()->setCellValue('L'.($row_data), "");//CHARGES
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.($row_data), $ccr_amt);//CHARGES
                              }
                        }
                  }

            $row_data++;   

            }
      } else {
            $row_data = 0;
            echo "
                  <tr>
                  <td colspan='13' class='text-center'> <h4> NO RESULT FOUND. </h4> </td>
                  </tr>
            ";
      }
}

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$tt = $row_data - 1;
$total_border = $tt;
$objPHPExcel->getActiveSheet()->getStyle('A4:M'.$total_border)->applyFromArray($styleArray);

// Set document properties
$objPHPExcel->getProperties()->setCreator("Cyber Frontier")
							 ->setLastModifiedBy("Cyber")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Customer call  report.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

for ($col = ord('A'); $col <= ord('Q'); $col++)
{
    $objPHPExcel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(-1);
}

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Customer Call');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//SET BORDER
$date = date("m-d-Y");
$fileName = "Customer Call - $date.xlsx";
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

