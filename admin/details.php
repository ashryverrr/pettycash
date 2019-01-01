<?php
  require_once '../config/connection.php';
  require_once '../config/validate_user.php';
  $k_id = $_GET['id'];
  $sql = "SELECT * FROM transaction WHERE trans_id = :transid ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(':transid', $k_id);
  $stmt -> execute();
  $row = $stmt -> fetch();
    $emp_id = $row['emp_id'];
    $sql1 = "SELECT emp_name FROM users WHERE user_id = :uid ";
    $stmt1 = $pdo -> prepare($sql1);
    $stmt1 -> bindParam(':uid', $emp_id);
    $stmt1 -> execute();
    $name_row = $stmt1 -> fetch();
    $empname = $name_row['emp_name'];
    $date = $row['trans_date'];
    $client_name = $row['client_name'];
    $amount_given = $row['amount'];
    $ccnum = $row['cc_num'];
  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title id="doNOTprint">Cyber Frontier | Petty Cash Details</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" type="text/css" href="../css/custom.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
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
            Petty Cash
            <small>Details</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="transactions.php"><i class="fa fa-dashboard"></i> Petty Cash</a></li>
            <li class="active">Detail</li>
          </ol>
        </section>
  <section class="content">
    <div class="row">
      <div class="container">
        <div class="panel panel-default">
          <div class="panel-body">
          <b> Date    : </b> <?php echo $date; ?></br>
          <b> Name    : </b><?php echo $empname; ?><br>
          <b> CC#/DR# : </b> <?php echo $ccnum; ?>  <br>
          <b> Amount  : </b> <?php echo $amount_given; ?> <br>
          <b> Client  : </b> <?php echo $client_name; ?><br>
          <table class="table table-bordered table-condensed no-spacing" cellspacing="0">
            <thead>
              <th> VEHICLE </th>
              <th> EXPENSES </th>
              <th> AMOUNT</th>
            </thead>
            <tbody>
            <tr>
            <?php
            $k_id = $_GET['id'];
            $counter = "SELECT * FROM transaction_details WHERE trans_id = :k_id ";
            $countergo = $pdo-> prepare($counter);
            $countergo -> bindParam(':k_id', $k_id);
            $countergo -> execute();
            $count_details = $countergo -> rowCount();
            if ($count_details > 0) { #check for the number of details available
            $sql = "SELECT transaction.trans_date as tdate, transaction.amount as given_amount, transaction_details.expenses as texpenses, transaction_details.amount as tamount, transaction_details.vehicle as vehicle FROM transaction INNER JOIN transaction_details on transaction.trans_id = transaction_details.trans_id WHERE transaction.trans_id = :k_id ";
            $stmt = $pdo->prepare($sql);
            $stmt -> bindParam(':k_id', $k_id);
            $stmt -> execute();
            $row_count = $stmt ->rowCount();
            if ($row_count > 0) {
              $total = 0;
              $excess = 0;
              while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                          $vehicle = $row['vehicle'];
                          $tdate = $row['tdate'];
                          $texpenses = $row['texpenses'];
                          $amount = $row['tamount'];
                          $total += $amount;
                          $total1 = sprintf('%0.2f',$total);
                          $date = $row['tdate'];
                          $given_amount = $row['given_amount'];
                            echo "
                              <td> $vehicle </td>
                              <td> $texpenses </td>
                              <td> $amount </td>
                              <tr>
                            ";
                }
                if ($given_amount > 0) {
                $excess1 = $given_amount - $total ;
                $excess = sprintf('%0.2f', $excess1);
                $refund = $given_amount - $total;
                if ($refund < 0) {
                  $refund = $given_amount - $total ;
                  $refund = abs($refund);
                  $excess = 0.00;
                } else {
                  $refund = 0.00;
                }
                  echo "
                    <tr>
                      <td> </td>
                      <td class='text-right'> <b> Approved by: </b> </td>
                      <td>  </td>
                    <tr>
                    <tr>
                      <td> </td>
                      <td class='text-right'> <b> Total expenses: </b> </td>
                      <td> $total1 </td>
                    <tr>
                    <tr>
                      <td> </td>
                      <td class='text-right'> <b> Refund: </b> </td>
                      <td> $refund </td>
                    <tr>
                    <tr>
                      <td> </td>
                      <td class='text-right'> <b> Excess: </b> </td>
                      <td> $excess </td>
                    <tr>
                    ";
                } else {
                   echo "
                    <tr>
                      <td> </td>
                      <td class='text-right'> <b> Approved by: </b> </td>
                      <td>  </td>
                    <tr>
                    <tr>
                      <td> </td>
                      <td class='text-right'> <b> Total expenses: </b> </td>
                      <td> $total1 </td>
                    <tr>
                    <tr>
                      <td> </td>
                      <td class='text-right'> <b> Refund: </b> </td>
                      <td> </td>
                    <tr>
                    <tr>
                      <td> </td>
                      <td class='text-right'> <b> Excess: </b> </td>
                      <td> $excess </td>
                    <tr>
                    ";
              }
            }
            #IF WALANG DETAILS
            } else {
              echo "
              <tr>
                <td colspan=3 class='text-center'> <h3> No details available. To add click <a href=''>here</a>. </h3> </td>
              </tr>
               ";
            echo "
              <tr>
                <td> </td>
                <td class='text-right'> <b> Total expenses: </b> </td>
                <td> <b> PHP </b> 0.00 </td>
              <tr>
            ";
            }
          ?>
          </tbody>
        </table>
      </div>
      <div class="panel-footer" id="doNOTprint">
       <form method="POST" action="print.php">
        <div class="row">
         <div class="col-md-6 pull-left">
           </div>
           <div class="col-md-6 pull-right">
             <input type='hidden' name="detail_id" id='detail_id' value="<?php echo $k_id ?>">
          <p class="text-right"> <button id="doNOTprint" class="btn btn-info"> <i class="fa fa-print fa-2x" aria-hidden="true"></i> </button> </p>
           </div>
          </div>
        </form>
      </div>
  </div>
</div>
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
      <?php include '../config/footer.html'; ?>
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <script src="../dist/js/app.min.js"></script>
  </body>
</html>
<script>


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