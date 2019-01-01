<?php
  require_once '../config/connection.php';
  require_once '../config/validate_user.php';
  $k_id = $_GET['id'];
  $sql = "SELECT ccr_user_id, ccr_client_account, ccr_cc_num, ccr_client, ccr_date,
    ccr_date_finished, ccr_time_start, ccr_time_end,
    ccr_model, ccr_serial_nos, ccr_complaint, ccr_remarks,
    rr_number, rr_date FROM cc_report WHERE ccr_id = :k_id ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(':k_id', $k_id);
  $stmt -> execute();
  $row = $stmt -> fetch();
  
    $emp_id = $row['ccr_user_id'];
    $sql1 = "SELECT emp_name FROM users WHERE user_id = :uid ";
    $stmt1 = $pdo -> prepare($sql1);
    $stmt1 -> bindParam(':uid', $emp_id);
    $stmt1 -> execute();
    $name_row = $stmt1 -> fetch();
    $empname = $name_row['emp_name'];
    $ccr_cc_num = $row['ccr_cc_num'];
    $ccr_client = $row['ccr_client'];
    $ccr_date = $row['ccr_date'];
    $ccr_date_finished = $row['ccr_date_finished'];
    $ccr_time_start = $row['ccr_time_start'];
    $ccr_time_end = $row['ccr_time_end'];
    $ccr_time_start = date("g:i a", strtotime($ccr_time_start));
    $ccr_time_end = date("g:i a", strtotime($ccr_time_end));
    $ccr_model = $row['ccr_model'] ?: "NOT AVAILABLE";
    $ccr_serial_nos = $row['ccr_serial_nos'] ?: "NOT AVAILABLE";
    $ccr_complaint = $row['ccr_complaint'] ?: "NOT AVAILABLE";
    $ccr_remarks = $row['ccr_remarks'];
    $rr_info = $row['rr_number'] ?: "NONE";
    $rr_date = $row['rr_date'] ?: " NONE ";
    $account = $row['ccr_client_account'] ?: " NONE ";
  
    $sqll = "SELECT client_address, client_account, client_person FROM clients
    WHERE concat(clients.client_name,' ',clients.client_branch) LIKE(:client_name)";
    $stmtt = $pdo -> prepare($sqll);
    $stmtt -> bindParam(":client_name", $ccr_client);
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
            Customer Call
            <small>Details</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="customer-calls.php"><i class="fa fa-dashboard"></i> Customer Calls</a></li>
            <li class="active">Detail</li>
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
                <div class='col-md-3'>
                  <b> Employee: </b>  $empname
                </div>
                <div class='col-md-4'>
                  <b> Client: </b> $ccr_client
                </div>
                <div class='col-md-5'>
                  <b> Address: </b> $address
                </div>
              </div>
              <div class='row'>
                <div class='col-md-3'>
                  <b> CC Number: </b> $ccr_cc_num
                </div>
                <div class='col-md-4'>
                  <b> CC Date: </b> $ccr_date
                </div>
                <div class='col-md-5'>
                  <b> Date Finished: </b> $ccr_date_finished
                </div>
              </div>
              <div class='row'>
                <div class='col-md-3'>
                  <b> Client Account: </b> $account
                </div>
                <div class='col-md-4'>
                  <b> Time Started: </b> $ccr_time_start
                </div>
                <div class='col-md-5'>
                  <b> Time Finished: </b> $ccr_time_end
                </div>
              </div>
              <div class='row'>
                <div class='col-md-3'>
                  <b> RR Number: </b> $rr_info
                </div>
                <div class='col-md-4'>
                  <b> RR Date: </b> $rr_date
                </div>
              </div>
            ";
          ?>
          <table class="table table-bordered table-condensed no-spacing" cellspacing="0">
            <thead>
              <th class="" width ="30%"> MODEL</th>
              <th class="" width ="40%"> SERIAL NUMBER </th>
              <th class=""> COMPLAINTS</th>
            </thead>
            <tbody>
              <?php
                echo "
                  <tr>
                    <td class=''> $ccr_model </td>
                    <td class=''> $ccr_serial_nos </td>
                    <td class=''> $ccr_complaint </td>
                  </tr>
                ";
              ?>
            </tbody>
          </table>
            <h4> <b> REMARKS</b> </h4>
              <div class="container">
                <p><?php echo $ccr_remarks; ?></p>
              </div>
          <table class="table table-bordered table-condensed no-spacing" cellspacing="0">
            <thead>
              <th class="" width ="15%"> QUANTITY </th>
              <th class="" width ="40%"> PARTICULARS </th>
              <th class="" width ="30%"> SERIAL NUMBER </th>
              <th class=""> AMOUNT</th>
            </thead>
            <tbody>
            <?php
              $total = sprintf('%0.2f', 0);
              $k_id = $_GET['id'];
              $counter = "SELECT ccr_report_id FROM cc_report_info WHERE ccr_report_id = :k_id ";
              $countergo = $pdo-> prepare($counter);
              $countergo -> bindParam(':k_id', $k_id);
              $countergo -> execute();
              $count_details = $countergo -> rowCount();
              if ($count_details > 0) { #check for the number of details available
              $sql = "SELECT ccr_qty, ccr_particulars, ccr_amt, ccr_serial FROM cc_report_info WHERE ccr_report_id = :k_id ";
              $stmt = $pdo -> prepare($sql);
              $stmt -> bindParam(':k_id', $k_id);
              $stmt -> execute();
              $row_count = $stmt ->rowCount();
              if ($row_count > 0) {
                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                            $ccr_qty = $row['ccr_qty'];
                            $ccr_particulars = $row['ccr_particulars'];
                            $ccr_amt = $row['ccr_amt'];
                            $ccr_serial = $row['ccr_serial'];
                              echo "
                                <tr>
                                <td class=''> $ccr_qty </td>
                                <td class=''> $ccr_particulars </td>
                                <td class=''> $ccr_serial </td>
                                <td class=''> $ccr_amt </td>
                                </tr>
                              ";
                            $total += $ccr_amt;
                  }
                  $total = sprintf('%0.2f', $total);
                    echo "
                      <tr>
                        <td> </td>
                        <td> </td>                        
                        <td class='text-right'> <b> TOTAL: </b> </td>
                        <td> <h3 class=' text-danger'> $total </h3> </td>
                      </tr>
                      ";
              }
              #IF WALANG DETAILS
              } else {
                echo "
                <tr>
                  <td colspan='4' class='text-center'> <h3> No details. </h3> </td>
                </tr>
                 ";
              echo "
                      <tr>
                        <td> </td>
                        <td> </td>
                        <td class='text-right'> <b> TOTAL: </b> </td>
                        <td> <h3 class=' text-danger'> $total </h3> </td>
                      </tr>
              ";
              }
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
