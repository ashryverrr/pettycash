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
		@media print {
			body, page {
			    margin: 0;
			    box-shadow: 0;	    
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
		$sql = "SELECT * FROM remittance_report WHERE rem_id = :rid";
		$stmt = $pdo -> prepare($sql);
		$stmt -> bindParam(":rid", $id);
		$stmt -> execute();
		$count = $stmt -> rowCount();		
		$roww = $stmt -> fetch();
		$rem_date = $roww['rem_date'];
		$rem_grp = $roww['rem_grp'];
		echo "
		<div>
			<p style='padding-left: 6.6in; padding-top: 2.3cm; padding-bottom: 0.5cm;'>	 
			 $rem_date		
			</p>				
		</div>
		";	

                $sql1 = "SELECT rem_id, rem_emp, rem_particulars, rem_details, rem_cash, rem_check, rem_amount, rem_date, rem_receivedBy FROM remittance_report WHERE rem_grp = :rem_gid ";
                $stmt1 = $pdo -> prepare($sql1);
                $stmt1 -> bindParam(':rem_gid', $rem_grp);
                $stmt1 -> execute();
                $count1 = $stmt1 ->  rowCount();
                $total = 0;

                if ($count1 == 1) {
                	# code...
                } else if ($count1 == 2) {
                	while ($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)) {
	                $rem_emp = $row['rem_emp'];
	                $rem_particulars = $row['rem_particulars'];
	                $rem_details = $row['rem_details'];
	                $rem_cash = $row['rem_cash'];
	                $rem_check = $row['rem_check'];
	                $rem_amount = $row['rem_amount'];
	                $rem_receivedBy = $row['rem_receivedBy'];
	                $rem_date = $row['rem_date'];
	                $rem_date = date("j-M-Y", strtotime($rem_date));   


	                $total += $rem_amount;
	                echo "
	                	<div class='container text-center' style='font-size: 10px; padding-top: 6.8px;'>
							<div class='col-xs-2' style='padding-left: 30px;'>			
								<nobr> $rem_particulars	</nobr>
							</div>
							<div class='col-xs-2' style='padding-left: 150px;'>
								<nobr> $rem_details	 </nobr>
							</div>
							<div class='col-xs-2' style='padding-left: 75px;'>
								<nobr> $rem_cash	</nobr>
							</div>
							<div class='col-xs-2' style='padding-left: 50px;'>			
								<nobr> $rem_check </nobr>
							</div>
							<div class='col-xs-2' style='padding-left: 80px;'>
								<nobr> $rem_amount </nobr>	
							</div>
						</div>
	                ";  
	      
	                }
                } else if ($count1 == 3) {
                	# code...
                } else if ($count1 == 4) {
                	# code...
                }
                

        }
        	$total = sprintf('%0.2f', $total);

 			if ($count1 == 1) {
 				# code...
 			} else if ($count1 == 2) {

 			echo "
 			<div class='row'>
 				<div class='pull-right' style='padding-top: 43px; padding-right: 75px;'>
 					$total
 				</div>
 			</div>
 			";



 			 echo "
                 <div class='row' style='padding-top: 48px; padding-left: 100px;'>
					<div class='col-md-6 col-xs-6'>						 
						 $rem_emp	
					</div>
					<div class='col-md-6 col-xs-6' style='padding-left: 100px;'>
						 $rem_receivedBy	
					</div>
				</div>


          ";
 			}


    ?>
	
</page>

</body>
</html>