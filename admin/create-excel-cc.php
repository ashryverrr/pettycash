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

$objPHPExcel->getActiveSheet()->getStyle('A1:N4')->getFont()->setBold(true);

$colorArray = array(
      'fill' => array(
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => '41bbf4')
    )
);

$objPHPExcel->getActiveSheet()->getStyle('A4:N4')->applyFromArray($colorArray); //color
$objPHPExcel->getActiveSheet()->getStyle("A1:N1")->getFont()->setSize(20); //font size
$objPHPExcel->getActiveSheet()->getStyle("A4:N4")->getFont()->setSize(12); //font size
$objPHPExcel->getActiveSheet()->mergeCells('A1:N1'); //merge cells
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
            ->setCellValue('M4', 'Signed')
            ->setCellValue('N4', 'Charges/Paid Amount');

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
        $sql = "SELECT ccr_id, ccr_user_id, ccr_client, ccr_date FROM cc_report WHERE ccr_status = 1 AND ccr_client = :ccr_client AND ccr_date BETWEEN :date_start AND :date_end UNION ALL SELECT ar_id, ar_user_id, ar_client, ar_date_started FROM activity_report WHERE ar_client = :ar_client AND ar_date_started BETWEEN :1date_start AND :1date_end ORDER BY ccr_user_id asc, ccr_date asc";
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
      $row_data = 4;
      while ($row1 = $stmt_1 -> fetch(PDO::FETCH_ASSOC) ) {
          $row_data++;
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
              $objPHPExcel->getActiveSheet()->getStyle('A'.($row_data).':B'.($row_data))->applyFromArray($colorYellow);
              $objPHPExcel->getActiveSheet()->getStyle('A'.($row_data).':B'.($row_data))->getFont()->setSize(13); //font size
              $objPHPExcel->getActiveSheet()->mergeCells('A'.($row_data).':B'.($row_data)); 
              $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), $emp_name);
              $row_data++;    
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

  
          $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), $date_start);//DATE
          $objPHPExcel->getActiveSheet()->setCellValue('B'.($row_data), $cc_number); //CCNUMBER
          $objPHPExcel->getActiveSheet()->setCellValue('C'.($row_data), $client);//CLIENT NAME
          $objPHPExcel->getActiveSheet()->setCellValue('D'.($row_data), $account);//ACCOUNT
          $objPHPExcel->getActiveSheet()->setCellValue('E'.($row_data), $address);//ADDRESS
          //TASK/ACTIVITY         
          $objPHPExcel->getActiveSheet()->setCellValue('F'.($row_data), $ccr_complaint);//
           $objPHPExcel->getActiveSheet()->setCellValue('G'.($row_data), $ccr_model.$ccr_serial_nos);// model/serialnos
          $objPHPExcel->getActiveSheet()->setCellValue('H'.($row_data), "NONE");//parts replaced
          $objPHPExcel->getActiveSheet()->setCellValue('I'.($row_data), "NONE");//SN
          $objPHPExcel->getActiveSheet()->setCellValue('J'.($row_data), $ccr_remarks);//outcome remakrs
          $objPHPExcel->getActiveSheet()->setCellValue('K'.($row_data), $ccr_time_start);//TIME ST
          $objPHPExcel->getActiveSheet()->setCellValue('L'.($row_data), $ccr_time_end);//TIME FIN
          $objPHPExcel->getActiveSheet()->setCellValue('M'.($row_data), $ccr_signedBy);//CHARGES
          $objPHPExcel->getActiveSheet()->setCellValue('N'.($row_data), "NONE");//CHARGES
          
          

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
                                     $objPHPExcel->getActiveSheet()->setCellValue('M'.($row_data), "");//
                                    $objPHPExcel->getActiveSheet()->setCellValue('N'.($row_data), "For Collection /".$ccr_amt);//CHARGES
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
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.($row_data), "");//
                                    $objPHPExcel->getActiveSheet()->setCellValue('N'.($row_data), $ccr_amt);//CHARGES
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
          $objPHPExcel->getActiveSheet()->getStyle('A'.($row_data).':B'.($row_data))->applyFromArray($colorYellow);
          $objPHPExcel->getActiveSheet()->getStyle('A'.($row_data).':B'.($row_data))->getFont()->setSize(13); //font size
          $objPHPExcel->getActiveSheet()->mergeCells('A'.($row_data).':B'.($row_data)); 
          $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), $emp_name);
          $row_data++;    
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

          $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), $ccr_date);//DATE
          $objPHPExcel->getActiveSheet()->setCellValue('B'.($row_data), "OFFICE"); //CCNUMBER
          $objPHPExcel->getActiveSheet()->setCellValue('C'.($row_data), $ar_client);//CLIENT NAME
          $objPHPExcel->getActiveSheet()->setCellValue('D'.($row_data), $ar_client_account);//ACCOUNT
          $objPHPExcel->getActiveSheet()->setCellValue('E'.($row_data), "NONE");//ADDRESS
          //TASK/ACTIVITY
          $objPHPExcel->getActiveSheet()->setCellValue('F'.($row_data), "NONE");// model/serialnos
          $objPHPExcel->getActiveSheet()->setCellValue('G'.($row_data), "NONE");//
          $objPHPExcel->getActiveSheet()->setCellValue('H'.($row_data), "NONE");//parts replaced
          $objPHPExcel->getActiveSheet()->setCellValue('I'.($row_data), "NONE");//SN
          $objPHPExcel->getActiveSheet()->setCellValue('J'.($row_data), $ar_activity);//outcome remakrs
          $objPHPExcel->getActiveSheet()->setCellValue('K'.($row_data), $ar_time_start);//TIME ST
          $objPHPExcel->getActiveSheet()->setCellValue('L'.($row_data), $ar_time_end);//TIME FIN
          $objPHPExcel->getActiveSheet()->setCellValue('M'.($row_data), "NONE");//CHARGES
          $objPHPExcel->getActiveSheet()->setCellValue('N'.($row_data), "NONE");//CHARGES
            
    }
  }
}       


$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$tt = $row_data;
$total_border = $tt;
$objPHPExcel->getActiveSheet()->getStyle('A4:N'.$total_border)->applyFromArray($styleArray);

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

