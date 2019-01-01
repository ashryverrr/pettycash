<?php
  require_once '../config/connection.php';
  require_once '../config/validate_tech.php';
  $user_id = $_SESSION['user_id'];  
  $id = $_GET['id'];
  $sql = "SELECT cc_report.*, cc_report_info.* 
  FROM cc_report LEFT JOIN cc_report_info ON cc_report.ccr_id = cc_report_info.ccr_report_id WHERE cc_report.ccr_id = :id ";
  $stmt = $pdo ->prepare($sql);
  $stmt -> bindParam(":id", $id);
  $stmt -> execute();
  $count = $stmt -> rowCount();
  if ($count > 0) {
    while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
      $ccr_id = $row['ccr_id'];
      $customer = $row['ccr_client'];
      $ccr_cc_num = $row['ccr_cc_num'];
      $ccr_date = $row['ccr_date'];
      $ccr_date_fin = $row['ccr_date_finished'];
      $ccr_time_start = $row['ccr_time_start'];
      $ccr_time_end = $row['ccr_time_end'];
      $ccr_model = $row['ccr_model'];
      $ccr_serialnos = $row['ccr_serial_nos'];
      $ccr_complaint = $row['ccr_complaint'];
      $ccr_remark = $row['ccr_remarks'];
      $rr_number = $row['rr_number'];
      $rr_date = $row['rr_date'];
    }
  } else {
    header("Location: dashboard.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Customer Calls </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
  <script src="../js/jquery.bootpag.min.js"></script>
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">
<header class="main-header">
<?php require '../config/header_admin.php'; ?>
</header>
<aside class="main-sidebar">
  <?php require '../config/navbar-users.php'; ?>
</aside>
<div class="content-wrapper">
<section class="content-header">
  <h1>
    Edit Customer Call
  </h1>
  <ol class="breadcrumb">
  </ol>
</section>
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
            <div class="box">
               <div class="box-header with-border">
                    <h3 class="box-title">Customer Call Report </h3>
                </div>
                  <form class="form-horizontal" id="cc_rep" name="cc_rep">
                    <div class="box-body">
                     <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Customer: </label>
                      <div class="col-md-8">
                      <select class="form-control client-select-list" name="ccr_client" id='ccr_client' required>
                        <option value="<?php echo $customer; ?>"> <?php echo $customer; ?> </option>
                              <?php
                                $sql = "SELECT client_id, client_account, client_name, client_branch, client_account FROM clients ORDER BY client_name asc, client_branch asc";
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
                      <label for="email" class="control-label col-md-4">CC#:</label>
                      <div class="col-md-6">
                        <input type="text" class="form-control" name="ccr_cc" id="ccr_cc" value="<?php echo $ccr_cc_num; ?>" readonly>
                      </div>
                      </div>
                      </div>
                      </div>
                      <input type="hidden" name="ccr_id" value="<?php echo $ccr_id; ?>">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="email" class="control-label col-md-4">CC Date:</label>
                             <div class="col-md-6">
                             <input type="date" class="form-control" name="ccr_date" id="ccr_date" value="<?php echo $ccr_date; ?>" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email" class="control-label col-md-4">Date Finished:</label>
                            <div class="col-md-6">
                             <input type="date" class="form-control" name="ccr_date_fin" id="ccr_date_fin" value="<?php echo $ccr_date_fin; ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-md-6">
                         <div class="form-group">
                          <label for="time-start" class="control-label col-md-4">Time Started:</label>
                         <div class="col-md-6">
                           <input type="time" class="form-control" name="ccr_time_start" id="ccr_time_start" value="<?php echo $ccr_time_start; ?>">
                         </div>
                         </div>
                        </div>
                       <div class="col-md-6">
                       <div class="form-group">
                          <label for="time-end" class="control-label col-md-4">Time Finished:</label>
                          <div class="col-md-6">
                          <input type="time" class="form-control" name="ccr_time_end" id="ccr_time_end" value="<?php echo $ccr_time_end; ?>">
                          </div>
                       </div>
                       </div>
                       </div>
                      <div>
                        <table class="table table-condensed">
                          <thead>
                            <tr>
                              <th class="text-center">Model </th>
                              <th class="text-center">Serial Nos.</th>
                              <th class="text-center">Complaints</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td><textarea rows="7" cols="25" name="ccr_model" id="ccr_model" class="form-control"><?php echo trim($ccr_model); ?></textarea></td>
                              <td><textarea class="form-control" rows="7" cols="25"  name="ccr_serialnos" id="ccr_serialnos"><?php echo trim($ccr_serialnos); ?> </textarea></td>
                              <td> <textarea class="form-control" rows="7" cols="65"  name="ccr_complaint" id="ccr_complaint" ><?php echo trim($ccr_complaint); ?></textarea></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-12">
                      <div class="form-group">
                        <label for="comment">Remarks:</label>
                        <textarea class="form-control" rows="5" id="ccr_remark" name="ccr_remark"><?php echo trim($ccr_remark); ?></textarea>
                      </div>
                      </div>
                      <div>
                        <table class="table table-condensed" id="dynamic_field">
                          <thead>
                            <tr>
                              <th class='hidden'> </th>
                              <th class="text-center">Qty.</th>
                              <th class="text-center">Particulars</th>
                              <th class="text-center">Serial Nos.</th>
                              <th class="text-center">Amount</th>
                              <th class="text-center">Delete</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                              $sql = "SELECT * FROM cc_report_info WHERE ccr_report_id = :id ";
                              $stmt = $pdo -> prepare($sql);
                              $stmt -> bindParam(":id", $id);
                              $stmt -> execute();
                              $count = $stmt -> rowCount();
                              if ($count > 0) {
                                $i = 0;
                               while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                                $i++;
                                $ccr_info_id = $row['ccr_info_id'];
                                $ccr_qty = trim($row['ccr_qty']);
                                $ccr_particulars = trim($row['ccr_particulars']);
                                $ccr_amt = trim($row['ccr_amt']);
                                $ccr_serial = trim($row['ccr_serial']);
                                  echo "
                                  <tr id='roww".$i."'>
                                  <td class='hidden'> <input class='form-control' type='hidden' name='ccr_info_id[]' id='ccr_info_id' value='$ccr_info_id'></td>
                                  <td> <input type='number' name='ccr_qty[]' id='ccr_qty' class='form-control' value='$ccr_qty'> </td>
                                  <td> <textarea class='form-control no-resize' rows='1' cols='65' name='ccr_particulars[]' id='ccr_particulars' > $ccr_particulars </textarea></td>
                                  <td> <input class='form-control' type='text' name='ccr_serial[]' id='ccr_serial' value='$ccr_serial' >  </td>
                                  <td> <input class='form-control input' type='number' name='ccr_amt[]' id='ccr_amt' min='0' value='$ccr_amt' onchange='updateTotal();'>  </td>
                                  
                                  <div class='btn-group' data-toggle='buttons'>
                                  <td class='text-center'> <input type='checkbox' name='deletee[]' id='$i' class='try' value='$ccr_info_id'> </td>
                                  </div>
                                  </tr>
                                  ";
                                }
                              }
                              ?>
                          </tbody>
                        </table>
                        <div for="TOTAL AMOUNT" class="pull-right" style="padding-right: 50px;">
                        <h3 style="display: inline;"> Total Amount:  </h3> <h3 id="total" style="display: inline;" class="text-danger"></h3>
                        </div>
                        <br><br>
                        <div class="row">
                         <div class="col-md-4">
                          <div class="form-group">
                            &nbsp &nbsp &nbsp&nbsp&nbsp<label class="checkbox-inline"> <input type="checkbox" value="collection" id="forcollection"> <b> For Collection </b> </label>
                          </div>
                          </div>
                           <div class="col-md-2">
                            <div class="form-group">
                            <label for="email" class="control-label col-md-2">RR#:</label>
                            <div class="col-md-9">                            
                              <select class="form-control" name="ccr_rr" id="ccr_rr" onchange="updateTotal();">
                              <option value="$rr_number"> <?php echo $rr_number; ?>  </option>
                              <?php
                                $sql = "SELECT rr_number FROM rr_number WHERE rr_user_id = :user_id AND rr_count > 0";
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> bindParam(":user_id", $user_id);
                                $stmt -> execute();
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                                      $rr = $row['rr_number'];           
                                       echo "
                                        <option value='$rr'> $rr </option>
                                       ";
                                  }
                              ?>                          
                              </select>
                            </div>
                           </div>
                           </div>
                           <div class="col-md-6">
                           <div class="form-group">
                            <label for="email" class="control-label col-md-6">RR Date#:</label>
                            <div class="col-md-6">
                            <input type="date" class="form-control" name="ccr_rr_date" id="ccr_rr_date" value="<?php echo $rr_date;?>">
                            </div>
                           </div>
                           </div>
                      </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                     <input type="button" id="add" class="btn btn-success" value="Add Field">
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
   $(document).on('click', '.try', function(){
           var button_id = $(this).attr("id");
           $('#roww'+button_id+'').hide();
           updateTotal();  
   });
   $(document).ready(function(){
      var i = 1;
      $('#add').click(function(){
           i++;
           $('#dynamic_field').append('<tr id="row'+i+'">  <td class="hidden"> <input type="checkbox" name="deletee[]" id="deletee" value=""> </td><td class="hidden"> <input class="form-control" type="hidden" name="ccr_info_id[]" id="ccr_info_id"> </td> <td> <input type="text" name="ccr_qty[]" id="ccr_qty" class="form-control"></td> <td> <textarea rows=1 cols=73 class="no-resize form-control" name="ccr_particulars[]" id="ccr_particulars"></textarea></td> <td> <input class="form-control" type="text" name="ccr_serial[]" id="ccr_serial"> </td> <td> <input type="number" name="ccr_amt[]" id="ccr_amt" value="0" class="form-control input" onchange="updateTotal();"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"> <i class="fa fa-times" aria-hidden="true"></i> </button></td></tr></tr>');
      });
      $(document).on('click', '.btn_remove', function(){
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();
      });
      $('#submit').click(function(){
        var client = document.getElementById("ccr_client").value;
        var ccr_cc = document.getElementById("ccr_cc").value;
        var date_start = document.getElementById("ccr_date").value;
        var date_finish = document.getElementById("ccr_date_fin").value;
        var ccr_time_start = document.getElementById("ccr_time_start").value;
        var ccr_time_end = document.getElementById("ccr_time_end").value;
        var ccr_model = document.getElementById("ccr_model").value;
        var ccr_complaint = document.getElementById("ccr_complaint").value;
        var ccr_serialnos = document.getElementById("ccr_serialnos").value;
        var ccr_rr = document.getElementById("ccr_rr").value;
        var ccr_rr_date = document.getElementById("ccr_rr_date").value;
        var ccr_remark = document.getElementById("ccr_remark").value;
        if (client == "" || date_start == "" || date_finish == "" || ccr_time_start == "" || ccr_time_end == "" || ccr_remark == "") {
          alert("Please fill all fields!");
        } else  {
         $.ajax({
                url:"save_cc_edit.php",
                method:"POST",
                data:$('#cc_rep').serialize(),
                success:function(data){
                     if (data.status == 'success'){
                         alert("Customer call with CC# "+ccr_cc+" was edited successfully!"); 
                         location.replace("customer-call.php");
                     } else if(data.status == 'not_allowed'){
                          alert("You are not allowed to edit that!");
                     } else if(data.status == 'cannot_edit'){
                          alert("Cannot edit already posted!");
                     } else if(data.status == 'error'){
                          alert("Something went wrong!");
                     } else {
                        alert("Unknown");
                     }
                }
            });
           }
      });
 });
</script>
<script type="text/javascript">
$(document).ready(function(){
  var total = 0;//
  var btn = document.getElementById('submit');
  var list = document.getElementsByClassName("input");
  var values = [];
  for(var i = 0; i < list.length; ++i) {
      values.push(parseFloat(list[i].value));
  }
  total = values.reduce(function(previousValue, currentValue, index, array){
      return previousValue + currentValue;
  });
  document.getElementById("total").textContent = total.toFixed(2);
});

function updateTotal() {
    var total = 0;//
    var btn = document.getElementById('submit');
    var list = document.getElementsByClassName("input");
    var values = [];
    var rr = document.getElementById('ccr_rr').value;
    var forvisit = document.getElementById('forvisit');
    for(var i = 0; i < list.length; ++i) {
        values.push(parseFloat(list[i].value));
    }
    total = values.reduce(function(previousValue, currentValue, index, array){
        return previousValue + currentValue;
    });
    document.getElementById("total").textContent = total.toFixed(2);
    if (total > 0 && rr == "") {
      btn.disabled = true;      
    } else {
      btn.disabled = false;      
    }
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
