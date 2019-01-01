<?php
  require_once '../config/connection.php';
  require_once '../config/validate_tech.php';  
  $user_id = $_SESSION['user_id'];  
  $id = $_GET['id'];

  $sql = "SELECT rem_emp, rem_date, rem_ctr_no FROM remittance_report WHERE rem_id = :rem_id ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(':rem_id', $id);
  $stmt -> execute();
  $row = $stmt -> fetch(); 
  $countRow = $stmt -> rowCount();

  if ($countRow > 0) {   
  $rem_emp = $row['rem_emp'];  
  $rem_date = $row['rem_date'];
  $rem_ctr_no = $row['rem_ctr_no'];

  } else {
    header("Location: activity-reports.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Edit Remittance Report </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/select2.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
  <script src="../js/jquery.bootpag.min.js"></script>
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">
<header class="main-header">
<?php require '../config/header_admin.php'; ?>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <?php require '../config/navbar-users.php'; ?>
</aside>
<div class="content-wrapper">
<section class="content-header">
  <h1>
  Edit Remittance Report
  </h1>
  <ol class="breadcrumb">    
  </ol>
</section>
        <section class="content">         
          <div class="row">         
            <div class="col-xs-12">
            <div class="box">
               <div class="box-header with-border">
                    <h3 class="box-title">Remittance Report Form</h3>
                  </div>
                  <form class="form-horizontal" id="rr_rep" name="rr_rep">
                    <div class="box-body">
                     <div class="row">

                      <input type="hidden" class="form-control" id="rem_id" name="rem_id"  value="<?php echo $id; ?>">

                       <div class="col-md-6">
                         <div class="form-group">
                          <label for="prepared-by" class="control-label col-md-4">Prepared By:</label>     
                          <div class="col-sm-8">                
                          <input type="text" class="form-control" value="<?php  echo $rem_emp; ?>" name="rem_emp" id="rem_emp" readonly>
                         <input type="hidden" class="form-control" id="empname" name="emp_name" value="<?php  echo $emp_id; ?>">                     
                         </div>
                         </div>
                       </div>
                       <div class="col-md-6">
                         <div class="form-group">
                          <label for="date" class="control-label col-md-4">Date:</label>
                         <div class="col-md-6">
                           <input type="date" value="<?php echo $rem_date;?>" class="form-control" name="rem_date" id="rem_date" >
                         </div>
                         </div>
                       </div>
                     </div>
                     <div class="row">
                       <div class="col-md-6">
                        <div class="form-group">
                          <label for="Control Number" class="control-label col-md-4"> Control #:</label>     
                          <div class="col-sm-8">                
                          <input type="text" class="form-control" name="rem_ctr_no" id="rem_ctr_no" value="<?php echo $rem_ctr_no;?>" readonly>                     
                         </div>
                         </div>                         
                       </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12">
                        <table class="table table-bordered table-condensed" id="dynamic_field">
                        <thead>
                          <th class="text-center"> Particulars </th>
                          <th class="text-center"> Details </th>
                          <th class="text-center"> Cash </th>
                          <th class="text-center"> Check </th>
                          <th class="text-center"> Amount </th>
                        </thead>
                        <?php

                          $sql = "SELECT remId, remParticulars, remDetails, remCash, remCheck, remAmount FROM remittance_details WHERE remGrp = :id ";
                          $stmt = $pdo -> prepare($sql);
                          $stmt -> bindParam(":id", $id);
                          $stmt -> execute();

                          while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                            $remId = $row['remId'];
                            $remParticulars = $row['remParticulars'];
                            $remDetails = $row['remDetails'];
                            $remCash = $row['remCash'];
                            $remCheck = $row['remCheck'];
                            $remAmount = $row['remAmount'];

                            echo "
                            <tr>
                              <td class='hidden'> <input type='text' class='form-control' name='rem_det_id[]' id='rem_det_id' value='$remId'>  </td>

                              <td> <input type='text' class='form-control' name='rem_particulars[]' id='rem_particulars' value='$remParticulars'> </td>
                              <td> <input type='text' class='form-control' name='rem_details[]' id='rem_details' value='$remDetails'> </td>
                              <td> <input type='text' class='form-control' name='rem_cash[]' id='rem_cash' value='$remCash'> </td>
                              <td> <input type='text' class='form-control' name='rem_check[]' id='rem_check' value='$remCheck'> </td>
                              <td> <input type='text' class='form-control' name='rem_amount[]' id='rem_amount' value='$remAmount'> </td>
                            </tr>
                            ";
                          }



                        ?>
                      </table>    
                      </div>
                     </div>                      
                    </div><!-- /.box-body -->  
                    <div class="box-footer">         
                     <input class="btn btn-success pull-right" id="submit" type="button" value="Submit" >
                    </div><!-- /.box-footer -->               
              </div><!-- /.box -->
            </div>
            </div>
</div><!-- /.row (main row) -->
        </section><!-- /.content -->
</div><!-- /.content-wrapper -->
       <?php include '../config/footer.html'; ?>
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
  </body>
</html>
<script src="../dist/js/app.min.js"></script>
<script type="text/javascript">

$('#submit').click(function(){           
        var rem_date = document.getElementById("rem_date").value;
        var rem_particulars = document.getElementById("rem_particulars").value;
        var rem_details = document.getElementById("rem_details").value;
        var rem_cash = document.getElementById("rem_cash").value;
        var rem_check = document.getElementById("rem_check").value;
        var rem_amount = document.getElementById("rem_amount").value;
        var rem_id = document.getElementById("rem_id").value;

        if (rem_date == "" || rem_particulars == ""  || rem_amount == "" || rem_id == "") {
          alert("Please fill all fields!");
        } else  {
         $.ajax({  
                url:"save_rr_edit.php",  
                method:"POST", 
                data:$('#rr_rep').serialize(),  
                success:function(data){
                     if (data.status == 'success'){
                         alert("Remittance report was edited successfully!");
                         $('#rr_rep')[0].reset();  
                         location.replace("remittance-report.php");
                     } else if(data.status == 'not_allowed'){
                          alert("You are not allowed to edit that!");
                     }  else if(data.status == 'error'){
                          alert("Something went wrong!");
                     } else {
                        alert("Unknown");
                     }
                }  
            });  
           }       
});  
 
function changeUserPassword() {
  var change_user_password_old = document.getElementById("change_user_password_old").value;
  var change_user_password_new = document.getElementById("change_user_password_new").value;
  var dataString = 'change_user_password_old=' + change_user_password_old + '&change_user_password_new=' + change_user_password_new;
  if (change_user_password_old == '' || change_user_password_new == '') {
    alert('Please fill all fields.');
  } else {
  $.ajax({
  type: "POST",
  url: "../config/change_user_password.php",
  data: dataString,
  cache: false,
  success: function(data) {  
         if (data.status == 'success'){
              alert("Password was changed successfully!");
              window.location.reload(true);
         } else if(data.status == 'error'){
              alert("Wrong password. Please try again.");
         } else {
              alert("Something went wrong!");
         }
  }
  });
  }  
  return false;
}

$(".ar-client-select").select2();
</script>
