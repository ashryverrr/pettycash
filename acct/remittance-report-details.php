<?php
  require_once '../config/connection.php';
  //require_once '../config/validate_user.php';
  session_start();
  $k_id = $_GET['id'];


    
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
          <table class="table table-bordered table-condensed no-spacing" cellspacing="0">
            <thead>
              <th class="" width ="40%"> Particulars</th>
              <th class="" width ="20%"> Details </th>
              <th class=""> Cash </th>
              <th class=""> Check </th>
              <th class=""> Amount </th>
            </thead>
            <tbody>
              <?php
              $sql = "SELECT rem_grp FROM remittance_report WHERE rem_id = :k_id ";
              $stmt = $pdo -> prepare($sql);
              $stmt -> bindParam(':k_id', $k_id);
              $stmt -> execute();
              $row = $stmt -> fetch();
              $count = $stmt -> rowCount();

              if ($count > 1) {
                $sql1 = "SELECT rem_id, rem_emp, rem_particulars, rem_details, rem_cash, rem_check, rem_amount, rem_date, rem_receivedBy FROM remittance_report WHERE rem_grp = :rem_gid ";
                $stmt1 = $pdo -> prepare($sql1);
                $stmt1 -> bindParam(':rem_gid', $rem_grp);
                $stmt1 -> execute();
            
            

                while ($row = $stmt1 -> fetch(PDO::FETCH_ASSOC)) {
                            $rem_emp = $row['rem_emp'];
                $rem_particulars = $row['rem_particulars'];
                $rem_details = $row['rem_details'];
                $rem_cash = $row['rem_cash'] ?: "-";
                $rem_check = !empty($row['rem_check']) ?: "-";
                $rem_amount = $row['rem_amount'];
                $rem_receivedBy = $row['rem_receivedBy'];
                $rem_date = $row['rem_date'];
                $rem_date = date("g:i a", strtotime($rem_date));     
                  echo "
                  <tr>  
                    <td> $rem_particulars </td>
                    <td> $rem_details </td>
                    <td> $rem_cash </td>
                    <td> $rem_check </td>
                    <td> $rem_amount </td>
                  </tr>    
                  <tr>  
                    <td> &nbsp </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                  </tr>             
                  <tr>  
                    <td> &nbsp </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                  </tr> 
                  <tr>  
                    <td> &nbsp </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                  </tr> 
                ";
                }

              } else {    
                $sql1 = "SELECT rem_id, rem_emp, rem_particulars, rem_details, rem_cash, rem_check, rem_amount, rem_date, rem_receivedBy FROM remittance_report WHERE rem_id = :k_id ";
                $stmt1 = $pdo -> prepare($sql1);
                $stmt1 -> bindParam(':k_id', $k_id);
                $stmt1 -> execute();
                $row = $stmt1 -> fetch();
                $rem_emp = $row['rem_emp'];
                $rem_particulars = $row['rem_particulars'];
                $rem_details = $row['rem_details'];
                $rem_cash = $row['rem_cash'] ?: "-";
                $rem_check = !empty($row['rem_check']) ?: "-";
                $rem_amount = $row['rem_amount'];
                $rem_receivedBy = $row['rem_receivedBy'];
                $rem_date = $row['rem_date'];
                $rem_date = date("g:i a", strtotime($rem_date));

                echo "
                  <tr>  
                    <td> $rem_particulars </td>
                    <td> $rem_details </td>
                    <td> $rem_cash </td>
                    <td> $rem_check </td>
                    <td> $rem_amount </td>
                  </tr>    
                  <tr>  
                    <td> &nbsp </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                  </tr>             
                  <tr>  
                    <td> &nbsp </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                  </tr> 
                  <tr>  
                    <td> &nbsp </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
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
