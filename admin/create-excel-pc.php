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



$objPHPExcel->getActiveSheet()->getStyle('A1:G4')->getFont()->setBold(true);



$colorArray = array(

      'fill' => array(

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('rgb' => '41bbf4')

    )

);

$colorYellow = array(

      'fill' => array(

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('rgb' => 'f4f442')

    )

);



$objPHPExcel->getActiveSheet()->getStyle('A4:F4')->applyFromArray($colorArray); //color

$objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setSize(20); //font size

$objPHPExcel->getActiveSheet()->getStyle("A4:F4")->getFont()->setSize(12); //font size

$objPHPExcel->getActiveSheet()->mergeCells('A1:F1'); //merge cells

$objPHPExcel->getActiveSheet()->mergeCells('C2:D2'); //merge 

$objPHPExcel->getActiveSheet()->mergeCells('C3:D3'); //merge 

$objPHPExcel->getActiveSheet()->getStyle("F")->getNumberFormat()->setFormatCode('0.00'); 



$objPHPExcel->getActiveSheet()

    ->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())

    ->getAlignment()

    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 



$objPHPExcel->getDefaultStyle()

    ->getAlignment()

    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);







$employee_name = "";

      if (isset($_POST['pc_date_start']) && isset($_POST['pc_date_end'])) {

                   $date_start = $_POST['pc_date_start'];

                   $date_end = $_POST['pc_date_end'];

                   $date_start = date("M j, Y", strtotime($date_start));

                   $date_end = date("M j, Y", strtotime($date_end));

                                      }

                   if (!empty($_POST['pc_client'])) {

                   $client = $_POST['pc_client'];

            

                   }

                   if (!empty($_POST['pc_employee'])) {

                   $employee = $_POST['pc_employee'];

                   $sql = "SELECT emp_name FROM users WHERE user_id = :id ";

                   $stmt = $pdo -> prepare($sql);

                   $stmt -> bindParam(":id", $employee);

                   $stmt -> execute();

                   $row = $stmt -> fetch();

                   $employee_name = $row['emp_name'];                   

                   }

                   if (!empty($_POST['pc_cc_start']) && !empty($_POST['pc_cc_end'])) {

                   $cc_start_rep = $_POST['pc_cc_start'];

                   $cc_end_rep = $_POST['pc_cc_end'];                  

      }





$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A1', 'PETTY CASH REPORT');

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('C2', $date_start.' to '.$date_end);

$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('C3', $employee_name);            







$objPHPExcel->setActiveSheetIndex(0)

            ->setCellValue('A4', 'Date')

            ->setCellValue('B4', 'CC No./DR#')

            ->setCellValue('C4', 'Client')

            ->setCellValue('D4', 'Status')      

            ->setCellValue('E4', 'Employee')

            ->setCellValue('F4', 'Total Amount');



if (isset($_POST['submit'])) {

      $date_start = $_POST['pc_date_start'];

      $date_end = $_POST['pc_date_end'];

      $client = $_POST['pc_client'];

      $employee = $_POST['pc_employee'];

      $cc_start = $_POST['pc_cc_start'];

      $cc_end = $_POST['pc_cc_end'];

      if (empty($client) && empty($cc_start) && empty($cc_end) && empty($employee) && !empty($date_start) && !empty($date_end)) {

        $sql = "SELECT * FROM transaction WHERE trans_date BETWEEN :date_start AND :date_end AND status = 1 ORDER BY emp_id asc, trans_date asc";

        $stmt = $pdo -> prepare($sql);

        $stmt -> bindParam(":date_start", $date_start);

        $stmt -> bindParam(":date_end", $date_end);

        $stmt -> execute();

      } else if (empty($client) && empty($cc_start) && empty($cc_end) && !empty($employee) && !empty($date_start) && !empty($date_end)) {

        $sql = "SELECT * FROM transaction WHERE emp_id = :emp_id AND trans_date BETWEEN :date_start AND :date_end AND status = 1 ORDER BY emp_id asc, trans_date asc";

        $stmt = $pdo -> prepare($sql);

        $stmt -> bindParam(":emp_id", $employee);

        $stmt -> bindParam(":date_start", $date_start);

        $stmt -> bindParam(":date_end", $date_end);

        $stmt -> execute();

      } else if (empty($client) && empty($employee) && !empty($cc_start) && !empty($cc_end) && !empty($date_start) && !empty($date_end)) {

        $sql = "SELECT * FROM transaction WHERE trans_date BETWEEN :date_start AND :date_end AND cc_num BETWEEN :cc_start AND :cc_end AND status = 1 ORDER BY emp_id asc, trans_date asc";

        $stmt = $pdo -> prepare($sql);

        $stmt -> bindParam(":cc_start", $cc_start);

        $stmt -> bindParam(":cc_end", $cc_end);

        $stmt -> bindParam(":date_start", $date_start);

        $stmt -> bindParam(":date_end", $date_end);

        $stmt -> execute();

      } else if (!empty($client) && empty($cc_start) && empty($cc_end) && !empty($employee) && !empty($date_start) && !empty($date_end)) {

        $sql = "SELECT * FROM transaction WHERE emp_id = :emp_id AND client_name LIKE concat('%',:client_name,'%') AND trans_date BETWEEN :date_start AND :date_end AND status = 1 ORDER BY emp_id asc, trans_date asc ";

        $stmt = $pdo -> prepare($sql);

        $stmt -> bindParam(":emp_id", $employee);

        $stmt -> bindParam(":client_name", $client);

        $stmt -> bindParam(":date_start", $date_start);

        $stmt -> bindParam(":date_end", $date_end);

        $stmt -> execute();

      } else if (!empty($client) && empty($cc_start) && empty($cc_end) && empty($employee) && !empty($date_start) && !empty($date_end)) {

        $sql = "SELECT * FROM transaction WHERE client_name LIKE concat('%',:client_name,'%') AND trans_date BETWEEN :date_start AND :date_end AND status = 1 ORDER BY emp_id asc, trans_date asc ";

        $stmt = $pdo -> prepare($sql);

        $stmt -> bindParam(":client_name", $client);

        $stmt -> bindParam(":date_start", $date_start);

        $stmt -> bindParam(":date_end", $date_end);

        //client_name LIKE concat('%',:client_name,'%')

        $stmt -> execute();

      }



     $countres = $stmt -> rowCount();

      if ($countres > 0) {

        $row_data = 5; // 1-based index

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

              $objPHPExcel->getActiveSheet()->getStyle('A'.($row_data).':B'.($row_data))->applyFromArray($colorYellow);

              $objPHPExcel->getActiveSheet()->getStyle('A'.($row_data).':B'.($row_data))->getFont()->setSize(13); //font size

              $objPHPExcel->getActiveSheet()->mergeCells('A'.($row_data).':B'.($row_data)); 

               $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), $employee_name);//NAME HEADER               

              $row_data++;    

            }



            $empID = $emp_id;



            $objPHPExcel->getActiveSheet()->setCellValue('A'.($row_data), $date_start);//DATE

            $objPHPExcel->getActiveSheet()->setCellValue('B'.($row_data), $cc_number); //CCNUMBER

            $objPHPExcel->getActiveSheet()->setCellValue('C'.($row_data), $client);//CLIENT NAME

            $objPHPExcel->getActiveSheet()->setCellValue('D'.($row_data), $account);//status

            $objPHPExcel->getActiveSheet()->setCellValue('E'.($row_data), $employee_name);//employee            

            $objPHPExcel->getActiveSheet()->setCellValue('F'.($row_data), $amount); //total amount

           

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

$objPHPExcel->getActiveSheet()->getStyle('A4:F'.$total_border)->applyFromArray($styleArray);



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

$objPHPExcel->getActiveSheet()->setTitle('Liquidation Report');





// Set active sheet index to the first sheet, so Excel opens this as the first sheet

$objPHPExcel->setActiveSheetIndex(0);



//SET BORDER

$date = date("m-d-Y");

$fileName = "Liquidation Report - $date.xlsx";

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



