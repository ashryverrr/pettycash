<?php
require_once '../config/connection.php';
require_once '../config/validate_user.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Reports</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../css/multi-select.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/select2.js"></script>
  <script src="../js/jquery.bootpag.min.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <?php require '../config/header_admin.php'; ?>
  </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <?php require '../config/sidebar.php'; ?>
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Reports
            <small>Create Reports</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Reports</a></li>
            
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Customer Call Report</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <form class="form-horizontal" method="POST" action="cc-report.php">
                    <div class="box-body">
                    <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Date Start: </label>
                      <div class="col-md-6">
                      <input type="date" name="cc_date_start_rep" placeholder="YY-MM-DD" class="form-control" required>
                     </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="email" class="control-label col-md-4"> Date End: </label>
                      <div class="col-md-6">
                        <input type="date" name="cc_date_end_rep" placeholder="YY-MM-DD" class="form-control" required>
                      </div>
                     </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Client: </label>
                      <div class="col-md-6">
                      <select class="form-control report-client" name="client_report">
                              <option value=""> </option>
                              <?php
                                $sql = "SELECT * FROM clients ORDER BY client_name asc, client_branch asc";
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute();
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                                    $client_id = $row['client_id'];
                                    $client_name = $row['client_name'];
                                    $client_branch = $row['client_branch'];
                                    $client_account = $row['client_account'];
                                    $client_fname = $client_name." ".$client_branch;
                                       echo "
                                        <option value='$client_fname'> $client_fname </option>
                                       ";
                                  }
                              ?>
                             </select>
                     </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="email" class="control-label col-md-4">Employee:</label>
                      <div class="col-md-6">
                          <select class="form-control report-employee" name="employee_report" readonly>
                           <option id="" name="" placeholder="Select Employee"> </option>
                           <?php
                              $sql = "SELECT user_id, emp_name FROM users ORDER BY emp_name asc";
                              $stmt = $pdo -> prepare($sql);
                              $stmt -> execute();
                              $countrow = $stmt -> rowCount();
                              if ($countrow > 0) {
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                                  $emp_id = $row['user_id'];
                                  $emp_name = $row['emp_name'];
                                  echo "<option value='$emp_id'> $emp_name </option>";
                                }
                              } else {
                                echo "<option> There are no users registered. </option>";
                              }
                           ?>
                         </select>
                      </div>
                     </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4">CC Start:</label>
                      <div class="col-md-6">
                      <input type="number" class="form-control" name="cc_start_rep" id="cc_start_rep">
                     </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="email" class="control-label col-md-4">CC End:</label>
                      <div class="col-md-6">
                        <input type="num" class="form-control" name="cc_end_rep" id="cc_end_rep">
                      </div>
                     </div>
                    </div>
                  </div>
                  </div>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                 <button class="btn btn-info pull-right" type="submit" name="submit"> Go </button>
                 </form>
                </div>
              </div>
            </div>
          </div>
          <!-- PETTY CASH REPORT -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Petty Cash Report</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                 <form class="form-horizontal" method="POST" action="petty-cash-report.php">
                    <div class="box-body">
                    <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Date Start: </label>
                      <div class="col-md-6">
                      <input type="date" name="pc_date_start" placeholder="YY-MM-DD" class="form-control" required>
                     </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="email" class="control-label col-md-4"> Date End: </label>
                      <div class="col-md-6">
                        <input type="date" name="pc_date_end" placeholder="YY-MM-DD" class="form-control" required>
                      </div>
                     </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Client: </label>
                      <div class="col-md-6">
                      <select class="form-control report-client" name="pc_client">
                              <option value=""> </option>
                              <?php
                                $sql = "SELECT * FROM clients ORDER BY client_name asc, client_branch asc";
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute();
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                                    $client_id = $row['client_id'];
                                    $client_name = $row['client_name'];
                                    $client_branch = $row['client_branch'];
                                    $client_account = $row['client_account'];
                                    $client_fname = $client_name." ".$client_branch;
                                       echo "
                                        <option value='$client_fname'> $client_fname </option>
                                       ";
                                  }
                              ?>
                             </select>
                     </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="email" class="control-label col-md-4">Employee:</label>
                      <div class="col-md-6">
                          <select class="form-control report-employee" name="pc_employee">
                           <option id="" name="" placeholder="Select Employee"> </option>
                           <?php
                              $sql = "SELECT user_id, emp_name FROM users ORDER BY emp_name asc";
                              $stmt = $pdo -> prepare($sql);
                              $stmt -> execute();
                              $countrow = $stmt -> rowCount();
                              if ($countrow > 0) {
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                                  $emp_id = $row['user_id'];
                                  $emp_name = $row['emp_name'];
                                  echo "<option value='$emp_id'> $emp_name </option>";
                                }
                              } else {
                                echo "<option> There are no users registered. </option>";
                              }
                           ?>
                         </select>
                      </div>
                     </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4">CC Start:</label>
                      <div class="col-md-6">
                      <input type="number" class="form-control" name="pc_cc_start" id="cc_start_rep">
                     </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="email" class="control-label col-md-4">CC End:</label>
                      <div class="col-md-6">
                        <input type="num" class="form-control" name="pc_cc_end" id="cc_end_rep">
                      </div>
                     </div>
                    </div>
                  </div>
                  </div>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                 <button class="btn btn-info pull-right" type="submit" name="submit"> Go </button>
                 </form>
                </div>
              </div>
            </div>
          </div>
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
$(".js-example-basic-multiple").select2();
$(".emp-pcl").select2();
$(".acc-emp").select2();
$(".report-client").select2();
$(".report-employee").select2();
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