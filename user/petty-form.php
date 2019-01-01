<?php
  require_once '../config/connection.php';
  require_once '../config/validate_tech.php';
  $username = $_SESSION['user_name'];
  $emp_id = $_SESSION['user_id'];
  $sql = "SELECT cc_auth_password FROM miscellaneous WHERE id = 1 ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> execute();
  $row = $stmt -> fetch();
  $password = $row['cc_auth_password'];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Dashboard</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/select2.min.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.js"></script> 
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
          Petty Cash Liquidation Form
          </h1>
          <ol class="breadcrumb">
          </ol>
        </section>
<section class="content"> 
  <div class="row">
    <div class="col-md-12">
      <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Fill-Up Form</h3>
              </div><!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal">
              <div class="box-body">
                  <div class="form-group">
                    <label for="emp_name" class="col-sm-2 control-label">Employee</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="" value="<?php  echo $username; ?>" readonly>
                       <input type="hidden" class="form-control" id="empname" name="emp_name" value="<?php  echo $emp_id; ?>">
                    </div>
                  </div>
                  <!-- PASSWORD-->
                  <input type="hidden" id="password_orig" value="<?php echo $password; ?>"><!-- PASSWORD-->
                  <div class="form-group">
                    <label for="passowrd" class="col-sm-2 control-label">CC#/ DR#</label>
                    <div class="col-sm-10">
                      <select class="form-control ccnum-select-list" name="ccnum[]" id="ccnum" multiple="multiple" onchange="checkForCC();">
                        <?php
                           $sql = "SELECT * FROM cc_number WHERE cc_num_status = 1 AND cc_user_id = :uid ORDER BY cc_number asc"; 
                            $stmt = $pdo -> prepare($sql);
                            $stmt -> bindParam(":uid", $_SESSION['user_id']);
                            $stmt -> execute();
                            $count = $stmt -> rowCount();
                            if ($count > 0) {
                              while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                                $cc_id = $row['cc_id'];                                
                                $cc_number = $row['cc_number'];
                                   echo "
                                    <option value='$cc_number'> $cc_number </option>
                                   
                                   ";
                              }  
                             echo "<option value='0000'> Others </option>";
                            } else {
                              echo "
                                <option disabled> No CC number available. </option>
                                <option value='0000'> Others </option>
                              ";  
                            }                         
                        ?>
                      </select>
                    </div>
                  </div>   
                  <div class="form-group" id="hide_me">
                        <label for="amount" class="col-sm-2 control-label">Others</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="others" placeholder="DR# / AR #" name="others">
                        </div>
                  </div>

                  <div class="form-group" id="hide_me_2">
                        <label for="amount" class="col-sm-2 control-label">Client</label>
                        <div class="col-sm-10">
                        <select class="form-control client-select-list" name="client" id="client""> <!--  onChange="setAccount(); -->
                              <option value=""> </option>
                              <?php
                                $sql = "SELECT * FROM clients ORDER BY client_name asc, client_branch asc";
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute();
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                                    $client_id = $row['client_id'];
                                    $client_name = stripslashes($row['client_name']);
                                    $client_branch = stripslashes($row['client_branch']);
                                    $client_account = $row['client_account'];
                                    $client_fname = $client_name." ".$client_branch;
                                    $client_fname1 = $client_name." ".$client_branch;
                                       echo "
                                        <option value='$client_fname'> $client_fname </option>
                                       ";
                                  }
                              ?>
                             </select>
                  </div>
                    </div>
                    
                  <div class="form-group">
                    <label for="amount" class="col-sm-2 control-label">Amount</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="amt" placeholder="Amount if given" name="amt" value="0">
                    </div>
                  </div> 
                  <div class="form-group">
                    <label for="date" class="col-sm-2 control-label">Date</label>
                    <div class="col-sm-10">
                      <input type="date" name="trans_date" class="form-control" id="trans_date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                  </div>
                   
                </div><!-- /.box-body -->
                <div class="box-footer">
                   <input id="submit" onclick="myFunction()" name="submit" type="button" value="Submit" class="btn btn-info pull-right">
                </div><!-- /.box-footer -->
              </form>
      </div><!-- /.box -->
    </div>  
    <!-- MODAL START  -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancel</span></button>
        <h4 class="modal-title" id="myModalLabel">Admin Authentication</h4>
      </div>
      <div class="modal-body">
        <input class="form-control" type="password" id="admin_authen" name="admin_authen" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="checkCC2();">Authenticate</button>
      </div>
    </div>
  </div>
</div>
<!-- MODAL END->
  </section><!-- right col -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
      <?php include '../config/footer.html'; ?>
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
  </body>
</html>
<script type="text/javascript">
$(".clientSelect").select2();
$(".ccnum-select-list").select2();
//HIDE THE MODAL ON LOAD OF THE PAGE
$(document).ready(function(){      
      $("#hide_me").hide();
      $("#hide_me_2").hide();
});
//CHECK IF Others
function checkForCC(){
  var cc_input = document.getElementById("ccnum").value;
  //var admin_authen = document.getElementById("admin_authen").value;
  if (cc_input == '0000') {
     $('#myModal1').modal('show');      
  }else {
     $("#hide_me").hide();
  }
}
function checkCC2(){
  var admin_authen = document.getElementById("admin_authen").value;
  var password_orig = document.getElementById("password_orig").value;
  //var admin_authen1 = md5(admin_authen);
   if (admin_authen === password_orig) {      
      $("#hide_me").show();  
      $("#hide_me_2").show();  
      $('#myModal1').modal('hide');
  } else {       
       alert("Wrong password");
     }
}
function myFunction() {
  var empname = document.getElementById("empname").value;
  var ccnum = $('#ccnum').val(); 
  var amount = document.getElementById("amt").value;
  var trans_date = document.getElementById("trans_date").value; 
  var client = $('#client').val(); 
  var others = document.getElementById("others").value;
  var dataString = 'empname=' + empname + '&ccnum=' + ccnum + '&trans_date=' + trans_date + '&amount=' + amt + '&others=' + others + '&client=' + client;  
  if (empname == '' || ccnum == '' || amount =='' || trans_date == '') {
    alert("Please fill all fields.");  
  } else if (ccnum == '0000' && others == '') {
    alert("Please fill all fields.");  
  } else {
   $.ajax({
      type: "POST",
      url: "save_petty_form.php",
      data: dataString,
      cache: false,
      success: function(data) {  
         if (data.status == 'success'){
              alert("Added! Please fill in the details of the transaction.");
              window.location.replace("add-details.php");
         } else if(data.status == 'exist'){
              alert("CC# already exists in the database. Please check and try again!");
         } else if(data.status == 'error'){
              alert("Something went wrong!");
         } else{
              alert("Unknown");
         }
      }
  });  
  }  
  return false;
}

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

</script>
