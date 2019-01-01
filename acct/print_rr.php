<?php
	require_once "../config/connection.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css" media="">
		body {
	  	  background: rgb(204,204,204); 
		}
		page {
		  background: white;
		  display: block;
		  margin: 0 auto;
		  margin-bottom: 0.5cm;
		  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
		}
		page[size="A2"][layout="landscape"] {
		  width: 8.5in;
		  height: 5.6in;  
		}
		table {
    		width: 100%;
		}
		td {
		    max-width: 0;
		    overflow: visible;
		    
		    white-space: nowrap;
		}
		@media print {
			body, page {
			    margin: 0;
			    box-shadow: 0;	 
			    font-family: Times New Roman;   
			}	
		    header, footer {
		     display: none;
		    }
		    @page{
		    	size: 8.5in 5.6in landscape;
		    	size: auto;   /* auto is the initial value */
    			margin: 0;  /* this affects the margin in the printer settings */
		    }
		 	#header, #footer {
	     	  display: none;
	    	}
	    	table {
    width: 100%;
}
			td {
			    max-width: 0;
			    overflow: visible;
			    text-overflow: ellipsis;
			    white-space: nowrap;
			}
		    title{
		      display: none;
		    }
		}
	</style>
	 <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>

<page size="A2" layout="landscape">
	<?php

	$id = $_GET['id'];

	if (!empty($id)) {
		$sql = "SELECT * FROM remittance_details WHERE remGrp = :rid";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":rid", $id);
		$stmt -> execute();
		$count = $stmt -> rowCount();		
		
		$sql = "SELECT rem_date, rem_emp, rem_receivedBy FROM remittance_report WHERE rem_id = :rid";
		$stmt1 = $pdo -> prepare($sql);
		$stmt1 -> bindParam(":rid", $id);
		$stmt1 -> execute();
		$roww = $stmt1 -> fetch();
		$rem_date = $roww['rem_date'];
		$rem_emp = $roww['rem_emp'];
		$rem_receivedBy = $roww['rem_receivedBy'];

		echo "
		<div>
			<p style='padding-left: 6.6in; padding-top: 2.3cm; padding-bottom: 0.65cm;'>
			 $rem_date		
			</p>				
		</div>
		";	

                $sql1 = "SELECT remParticulars, remDetails, remCash, remCheck, remAmount FROM remittance_details WHERE remGrp = :rem_gid ";

                $stmt1 = $pdo -> prepare($sql1);
                $stmt1 -> bindParam(':rem_gid', $id);
                $stmt1 -> execute();
                $count1 = $stmt1 ->  rowCount();
                $total = 0;
                if ($count1 == 1) {
                	while ($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)) {
	                $rem_particulars = $row['remParticulars'];
	                $rem_details = $row['remDetails'];
	                $rem_cash = $row['remCash'];
	                $rem_check = $row['remCheck'];
	                $rem_amount = $row['remAmount'];

	                $total += $rem_amount;
				    echo "
				    <table style='font-size: 10px;'>
				    	<tr>
				    		<td class='text-center' width='20%' style='padding-left: 95px;'> <nobr> $rem_particulars </nobr> </td> 
				    		<td class='text-center' width='20%' style='padding-left: 113px;'> <nobr> $rem_details	</nobr> </td>                		
				    		<td class='text-center' width='20%'> <nobr> $rem_cash	</nobr> </td>
				    		<td class='text-center' width='20%' ><nobr> $rem_check </nobr> </td>
				    		<td class='text-center' width='20%' style='padding-right: 15px;'> <nobr> $rem_amount </nobr> </td>
						</tr>	  						          		
					</table>
				    "; 
				     }
                } else if ($count1 == 2) {
                	while ($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)) {
	            	$rem_particulars = $row['remParticulars'];
	                $rem_details = $row['remDetails'];
	                $rem_cash = $row['remCash'];
	                $rem_check = $row['remCheck'];
	                $rem_amount = $row['remAmount'];

	                $total += $rem_amount;
				    echo "
				    <table style='font-size: 10px;'>
				    	<tr>
				    		<td class='text-center' width='20%' style='padding-left: 95px;'> <nobr> $rem_particulars </nobr> </td> 
				    		<td class='text-center' width='20%' style='padding-left: 125px;'> <nobr> $rem_details	</nobr> </td>                		
				    		<td class='text-center' width='20%'> <nobr> $rem_cash	</nobr> </td>
				    		<td class='text-center' width='20%' ><nobr> $rem_check </nobr> </td>
				    		<td class='text-center' width='20%' style='padding-right: 17.5px;'> <nobr> $rem_amount </nobr> </td>
						</tr>	  						          		
					</table>
				    ";  	      
            		}
                } else if ($count1 == 3) {
           			while ($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)) {
	                $rem_particulars = $row['remParticulars'];
	                $rem_details = $row['remDetails'];
	                $rem_cash = $row['remCash'];
	                $rem_check = $row['remCheck'];
	                $rem_amount = $row['remAmount'];         
					
					$total += $rem_amount;
				    echo "
				    <table style='font-size: 10px;'>
				    	<tr>
				    		<td class='text-center' width='22%' style='padding-left: 95px;'> <nobr> $rem_particulars </nobr> </td> 
				    		<td class='text-center' width='18%' style='padding-left: 118px;'> <nobr> $rem_details	</nobr> </td>                		
				    		<td class='text-center' width='20%'> <nobr> $rem_cash	</nobr> </td>
				    		<td class='text-center' width='20%' ><nobr> $rem_check </nobr> </td>
				    		<td class='text-center' width='20%' style='padding-right: 18px;'> <nobr> $rem_amount </nobr> </td>
						</tr>	  						          		
					</table>
				    ";  	      
            		}
                } else if ($count1 == 4) {
                	while ($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)) {
	                $rem_particulars = $row['remParticulars'];
	                $rem_details = $row['remDetails'];
	                $rem_cash = $row['remCash'];
	                $rem_check = $row['remCheck'];
	                $rem_amount = $row['remAmount'];
 
	                
	                $rem_date = $row['rem_date'];
	                $rem_date = date("j-M-Y", strtotime($rem_date));   
					
					$total += $rem_amount;
				    echo "
				    <table style='font-size: 10px;'>
				    	<tr>
				    		<td class='text-center' width='22%' style='padding-left: 95px;'> <nobr> $rem_particulars </nobr> </td> 
				    		<td class='text-center' width='18%' style='padding-left: 119.8px;'> <nobr> $rem_details	</nobr> </td>                		
				    		<td class='text-center' width='20%'> <nobr> $rem_cash	</nobr> </td>
				    		<td class='text-center' width='20%' ><nobr> $rem_check </nobr> </td>
				    		<td class='text-center' width='20%' style='padding-right: 18px;'> <nobr> $rem_amount </nobr> </td>
						</tr>	  						          		
					</table>
				    ";  	      
           		 }
                }
                else if ($count1 == 5) {
                	while ($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)) {
	            $rem_particulars = $row['remParticulars'];
	                $rem_details = $row['remDetails'];
	                $rem_cash = $row['remCash'];
	                $rem_check = $row['remCheck'];
	                $rem_amount = $row['remAmount'];
 
	                
	                $rem_date = $row['rem_date'];
	                $rem_date = date("j-M-Y", strtotime($rem_date));   
					
					$total += $rem_amount;
				    echo "
				    <table style='font-size: 10px;'>
				    	<tr>
				    		<td class='text-center' width='22%' style='padding-left: 100px;'> <nobr> $rem_particulars </nobr> </td> 
				    		<td class='text-center' width='18%' style='padding-left: 119.8px;'> <nobr> $rem_details	</nobr> </td>                		
				    		<td class='text-center' width='20%'> <nobr> $rem_cash	</nobr> </td>
				    		<td class='text-center' width='20%' ><nobr> $rem_check </nobr> </td>
				    		<td class='text-center' width='20%' style='padding-right: 18px;'> <nobr> $rem_amount </nobr> </td>
						</tr>	  						          		
					</table>
				    ";  	      
            }
                }
                

        }
        	$total = sprintf('%0.2f', $total);

 			if ($count1 == 1) {
 				echo "
 			<div class='row'>
 				<div class='pull-right' style='padding-top: 64.3px; padding-right: 75px;'>
 					$total
 				</div>
 			</div>
 			";



 			 echo "
                 <div class='row' style='padding-top: 39px; padding-left: 100px;'>
					<div class='col-md-6 col-xs-6'>						 
						 $rem_emp	
					</div>
					<div class='col-md-6 col-xs-6' style='padding-left: 100px;'>
						 $rem_receivedBy	
					</div>
				</div>


          ";
 			} else if ($count1 == 2) {

 			echo "
 			<div class='row'>
 				<div class='pull-right' style='padding-top: 51px; padding-right: 73px;'>
 					$total
 				</div>
 			</div>
 			";



 			 echo "
                 <div class='row' style='padding-top: 38px; padding-left: 100px;'>
					<div class='col-md-6 col-xs-6'>						 
						 $rem_emp	
					</div>
					<div class='col-md-6 col-xs-6' style='padding-left: 100px;'>
						 $rem_receivedBy	
					</div>
				</div>


          ";
 			} else if ($count1 == 3) {
 				
 			echo "
 			<div class='row'>
 				<div class='pull-right' style='padding-top: 37.8px; padding-right: 75px;'>
 					$total
 				</div>
 			</div>
 			";



 			 echo "
                 <div class='row' style='padding-top: 38px; padding-left: 100px;'>
					<div class='col-md-6 col-xs-6'>						 
						 $rem_emp	
					</div>
					<div class='col-md-6 col-xs-6' style='padding-left: 100px;'>
						 $rem_receivedBy	
					</div>
				</div>";


 			} else if ($count1 == 4) {
 				
 			echo "
 			<div class='row'>
 				<div class='pull-right' style='padding-top: 24px; padding-right: 75px;'>
 					$total
 				</div>
 			</div>
 			";



 			 echo "
                 <div class='row' style='padding-top: 38px; padding-left: 100px;'>
					<div class='col-md-6 col-xs-6'>						 
						 $rem_emp	
					</div>
					<div class='col-md-6 col-xs-6' style='padding-left: 100px;'>
						 $rem_receivedBy	
					</div>
				</div>";

 			} else if ($count1 == 5) {
 				echo "
 			<div class='row'>
 				<div class='pull-right' style='padding-top: 10.2px; padding-right: 75px;'>
 					$total
 				</div>
 			</div>
 			";



 			 echo "
                 <div class='row' style='padding-top: 38px; padding-left: 100px;'>
					<div class='col-md-6 col-xs-6'>						 
						 $rem_emp	
					</div>
					<div class='col-md-6 col-xs-6' style='padding-left: 100px;'>
						 $rem_receivedBy	
					</div>
				</div>";
 			}



    ?>
	
</page>

</body>
</html>