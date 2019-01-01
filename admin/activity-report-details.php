<?php
  require_once '../config/connection.php';
  require_once '../config/validate_user.php';
  $k_id = $_GET['id'];
  $sql = "SELECT ar_user_id, ar_client, ar_client_account,  ar_date_started,
    ar_time_start, ar_time_end,
    ar_activity FROM activity_report WHERE ar_id = :ar_id ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(':ar_id', $k_id);
  $stmt -> execute();
  $row = $stmt -> fetch();
    $emp_id = $row['ar_user_id'];
    $sql1 = "SELECT emp_name FROM users WHERE user_id = :uid ";
    $stmt1 = $pdo -> prepare($sql1);
    $stmt1 -> bindParam(':uid', $emp_id);
    $stmt1 -> execute();
    $name_row = $stmt1 -> fetch();
    $empname = $name_row['emp_name'];
    $ar_client_account = $row['ar_client_account'];
    $ar_client = $row['ar_client'];
    $ar_date_started = $row['ar_date_started'];
    $ar_time_start = $row['ar_time_start'];
    $ar_time_end = $row['ar_time_end'];
    $ar_time_start = date("g:i a", strtotime($ar_time_start));
    $ar_time_end = date("g:i a", strtotime($ar_time_end));
    $ar_activity = $row['ar_activity'];
  
    $sqll = "SELECT client_address, client_account, client_person FROM clients
    WHERE concat(clients.client_name,' ',clients.client_branch) LIKE(:client_name)";
    $stmtt = $pdo -> prepare($sqll);
    $stmtt -> bindParam(":client_name", $ar_client);
    $stmtt -> execute();
    $address_row = $stmtt -> fetch();
    $address = $address_row['client_address'];
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title id="doNOTprint">Cyber Frontier | Customer Call Details</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" type="text/css" href="../css/custom.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
  <style type="text/css">
   .container, .container-fluid {
    width: auto;
    display: block!important;
    }
    @media print{
    body {
      size: auto;   /* auto is the initial value */
      color: #000;
      background: #fff;
      width: 100%;
      height: 100%;
      display: block;
      font-family: "Arial";
      margin: 0 0 0 0;
    }
    @page {
      size: auto;
      margin: 0;
    }
    aside{
      display: none;
      margin: 0;
    }
    header, footer {
     display: none;
    }
    #button {
     display: none;
    }
    table tr td {
     border: none !important;
     zoom: 1;
     margin: 0;
     border-spacing: 0;
     border-collapse: collapse;
     page-break-inside: avoid;
    }
    #doNOTprint{
     display: none;
    }
    title{
      display: none;
    }
    }
  </style>
</head>
<body class="skin-black sidebar-mini">
<div class="wrapper">
<header class="main-header">
  <?php require '../config/header_admin.php'; ?>
</header>
<aside class="main-sidebar">
  <?php require '../config/sidebar.php'; ?>
</aside>
<div class="content-wrapper">
<section class="content-header">
          <h1>
            Activity Report
            <small>Details</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="customer-calls.php"><i class="fa fa-dashboard"></i> Activity Report</a></li>
            <li class="active">Details</li>
          </ol>
        </section>
  <section class="content">
    <div class="row">
      <div class="container">
        <div class="panel panel-default">
        <div class="panel-body">
          <?php
            echo "
              <div class='row'>
                <div class='col-md-6'>
                  <b> Employee: </b>  $empname
                </div>
                <div class='col-md-6'>
                  <b> Client: </b> $ar_client
                </div>
           
              </div>
              <div class='row'>                
                <div class='col-md-6'>
                  <b> CC Date: </b> $ar_date_started
                </div>
                <div class='col-md-6'>
                  <b> Client Account: </b> $ar_client_account
                </div>
              </div>
              <div class='row'>                
                <div class='col-md-6'>
                  <b> Time Started: </b> $ar_time_start
                </div>
                <div class='col-md-6'>
                  <b> Time Finished: </b> $ar_time_end
                </div>
              </div>
            ";
            echo "
              <div>
                <h3> Activity </h3>
                  <div class='container'>
                  $ar_activity
                  </div>
              </div>
            ";
          ?>
              
          </tbody>
        </table>
      </div>
  </div> <!-- PANEL BODY -->
</div>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
      <?php include '../config/footer.html'; ?>
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
<script src="../dist/js/app.min.js"></script>
<script type="text/javascript">
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
  </body>
</html>
