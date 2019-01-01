<?php
  require_once '../config/connection.php';
  require_once '../config/validate_tech.php';
  $username = $_SESSION['user_name'];
  $emp_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Create Remittance Report</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/custom.css">
  <link rel="stylesheet" href="../css/select2.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../css/multi-select.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/jquery.multi-select.js"></script>
  <script src="../js/jquery.bootpag.min.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
  <script src="../js/select2.js"></script>
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
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Create Remittance Report
          </h1>
          <ol class="breadcrumb">
          </ol>
        </section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Remittance Report Form</h3>
                  </div>
                  <form class="form-horizontal" id="rr_rep" name="rr_rep">
                    <div class="box-body">
                     <div class="row">
                       <div class="col-md-6">
                         <div class="form-group">
                          <label for="prepared-by" class="control-label col-md-4">Prepared By:</label>     
                          <div class="col-sm-8">                
                          <input type="text" class="form-control" value="<?php  echo $username; ?>" name="rem_emp" id="rem_emp" readonly>
                         <input type="hidden" class="form-control" id="empname" name="emp_name" value="<?php  echo $emp_id; ?>">
                         </div>
                         </div>
                       </div>
                       <div class="col-md-6">
                         <div class="form-group">
                          <label for="date" class="control-label col-md-4">Date:</label>
                         <div class="col-md-6">
                           <input type="date" class="form-control" name="rem_date" id="rem_date">
                         </div>
                         </div>
                       </div>
                     </div>
                     <div class="row">
                       <div class="col-md-6">
                        <div class="form-group">
                          <label for="Control Number" class="control-label col-md-4"> Control #:</label>     
                          <div class="col-sm-8">                
                          <input type="text" class="form-control" name="rem_ctr_no" id="rem_ctr_no">                     
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
                        <tr>
                          <td> <input type="text" class="form-control" name="rem_particulars[]" id="rem_particulars"> </td>
                          <td> <input type="text" class="form-control" name="rem_details[]" id="rem_details"> </td>
                          <td> <input type="text" class="form-control" name="rem_cash[]" id="rem_cash"> </td>
                          <td> <input type="text" class="form-control" name="rem_check[]" id="rem_check"> </td>
                          <td> <input type="text" class="form-control" name="rem_amount[]" id="rem_amount"> </td>
                        </tr>
                      </table>    
                      </div>
                     </div>                 
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                    <div class="row">
                     <div class="col-md-6">
                      Note: <b>Particulars </b> - Name of Customer
                             <b> Details: A/R </b> - Accounts Receivable <b> S </b> - Sales <b> CC </b> - Customer Call <b> M </b> - Maintenance
                     </div>
                     <div class="col-md-6">                     
                     </div>
                     </div>
                     <br>
                     <input type="button" id="add" class="btn btn-success" value="Add Field">
                     <input id="submit" type="button" value="Submit" class="btn btn-success pull-right">                     
                    </div><!-- /.box-footer -->
                  </form>
                </div><!-- /.box -->
    </div>
  </div>
</section><!-- right col -->
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->
  <?php include '../config/footer.html'; ?>
  <div class="control-sidebar-bg"></div>
</div>
<script src="../dist/js/app.min.js"></script>
</body>
</html>
<script>


$(document).ready(function(){
      var i = 1;
      $('#add').click(function(){
           i++;
           $('#dynamic_field').append('<tr id="row'+i+'">  <td> <input type="text" class="form-control" name="rem_particulars[]" id="rem_particulars"> </td>  <td> <input type="text" class="form-control" name="rem_details[]" id="rem_details"> </td>             <td> <input type="text" class="form-control" name="rem_cash[]" id="rem_cash"> </td> <td> <input type="text" class="form-control" name="rem_check[]" id="rem_check"> </td> <td> <input type="text" class="form-control" name="rem_amount[]" id="rem_amount"> </td> <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"> <i class="fa fa-times" aria-hidden="true"></i> </button></td></tr></tr>');
      });
      $(document).on('click', '.btn_remove', function(){
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();
  });
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

$('#submit').click(function(){
  var rem_particulars = document.getElementById("rem_particulars").value;
  var rem_details = document.getElementById("rem_details").value;
  var rem_cash = document.getElementById("rem_cash").value;
  var rem_check = document.getElementById("rem_check").value;
  var rem_amount = document.getElementById("rem_amount").value;
  var rem_ctr_no = document.getElementById("rem_ctr_no").value;
  var rem_date = document.getElementById("rem_date").value;

  if (rem_particulars == "" || rem_details == "" || rem_amount == "" || rem_ctr_no == "" || rem_date == "") {
    alert("Please fill all fields!");
  } else  {
   $.ajax({
          url:"save_rr.php",
          method:"POST",
          data:$('#rr_rep').serialize(),
          success:function(data){
               if (data.status == 'success'){
                    alert("Remittance report was saved!");
                    $('#rr_rep')[0].reset();
                    window.location.reload(true);
               } else if(data.status == 'error'){
                    alert("Something went wrong!");
               } else {
                    alert("Something went wrong!");
               }
          }
      });
     }
});

</script>

<script type="text/javascript">
  $(".client-select-list").select2();
</script>