<?php
  require_once '../config/connection.php';
  require_once '../config/validate_tech.php';
  $rem_emp_id = $_SESSION['user_id']; 
  $sql = "SELECT * FROM cc_number WHERE cc_user_id = :uid AND cc_num_status = 0 LIMIT 1";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(":uid", $_SESSION['user_id']);
  $stmt -> execute();
  $row = $stmt -> fetch(PDO::FETCH_ASSOC);
  $count = $stmt -> rowCount();
  if ($count > 0) {
    $cc_number = $row['cc_number'];
  } else {
    $cc_number = "No CC available.";
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Home</title>
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
            Home <small>Create Customer Call</small>
          </h1>
          <ol class="breadcrumb">
          </ol>
        </section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Customer Call Form </h3>
                  </div>
                  <form class="form-horizontal" id="cc_rep" name="cc_rep">
                    <div class="box-body">
                     <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Client: </label>
                      <div class="col-md-8">
                      <select class="form-control client-select-list clientId" name="ccr_client" id="ccr_client""> <!--  onChange="setAccount(); -->
                              <option value=""> </option>
                              <?php
                                $sql = "SELECT client_id, client_name, client_branch, client_account FROM clients ORDER BY client_name asc, client_branch asc";
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute();
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                                    $client_id = $row['client_id'];
                                    $client_name = stripslashes($row['client_name']);
                                    $client_branch = stripslashes($row['client_branch']);
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
                        <input type="text" class="form-control" name="ccr_cc" id="ccr_cc" value="<?php echo $cc_number; ?>" readonly>
                      </div>
                     </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="email" class="control-label col-md-4">CC Date:</label>
                             <div class="col-md-6">
                             <input type="date" class="form-control" name="ccr_date" id="ccr_date" value="<?php echo date('Y-m-d'); ?>" onchange="setDate();" required>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email" class="control-label col-md-4">Date Finished:</label>
                            <div class="col-md-6">
                             <input type="date" class="form-control" name="ccr_date_fin" id="ccr_date_fin" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-md-6">
                         <div class="form-group">
                          <label for="time-start" class="control-label col-md-4">Time Started:</label>
                         <div class="col-md-6">
                           <input type="time" class="form-control" name="ccr_time_start" id="ccr_time_start">
                         </div>
                         </div>
                        </div>
                       <div class="col-md-6">
                      <div class="form-group">
                        <label for="time-end" class="control-label col-md-4">Time Finished:</label>
                        <div class="col-md-6">
                        <input type="time" class="form-control" name="ccr_time_end" id="ccr_time_end">
                        </div>
                      </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                         <div class="form-group">
                          <label for="time-start" class="control-label col-md-4">Status:</label>
                          <div class="col-md-6 accountClient">
                                                   
                         </div>
                         </div>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                          <label for="time-start" class="control-label col-md-4">Signed By:</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="ccr_signedBy" id="ccr_signedBy">      
                         </div>
                         </div>
                        </div>
                       <div class="col-md-6">
                      <div class="form-group">                       
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
                              <td> <textarea type="text" rows="7" cols="25" name="ccr_model" id="ccr_model" class="form-control"> </textarea> </td>
                              <td> <textarea class="form-control" rows="7" cols="25"  name="ccr_serialnos" id="ccr_serialnos" ></textarea> </td>
                              <td> <textarea class="form-control" rows="7" cols="65"  name="ccr_complaint" id="ccr_complaint" ></textarea>  </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="col-md-12">
                      <div class="form-group">
                        <label for="comment">Work done:</label>
                        <textarea class="form-control" rows="5" id="ccr_remark" name="ccr_remark"></textarea>
                      </div>
                      </div>
                      <div>
                        <table class="table table-condensed" id="dynamic_field">
                          <thead>
                            <tr>
                              <th class="text-center">Qty.</th>
                              <th class="text-center">Particulars</th>
                              <th class="text-center">Serial Nos.</th>
                              <th class="text-center">Amount</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td> <input type="number" name="ccr_qty[]" id="ccr_qty" class="form-control"> </td>
                              <td> <textarea class="form-control" rows=1 cols=65 class="
                              no-resize" name="ccr_particulars[]" id="ccr_particulars" ></textarea> </td>
                              <td> <input type="text" name="ccr_serial[]" id="ccr_serial" class="form-control"> </td>
                              <td> <input class="form-control input" type="number" name="ccr_amt[]" value="0" min="0" step="any" id="ccr_amt" onchange="updateTotal();"> </td>
                            </tr>
                          </tbody>
                        </table>
                        <div class="">
                        <h3 id="" style="display: inline;"> Total Amount:  </h3> <h3 id="total" style="display: inline;" class="text-danger"></h3>
                        </div>
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
                            <!--
                              <input type="text" class="form-control" name="ccr_rr" id="ccr_rr" onkeyup="updateTotal();">
                              !-->
                              <select class="form-control" name="ccr_rr" id="ccr_rr" onchange="updateTotal();">
                              <option value=""> </option>
                              <?php
                                $sql = "SELECT rr_number FROM rr_number WHERE rr_user_id = :user_id AND rr_count > 0";
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> bindParam(":user_id", $rem_emp_id);
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
                            <input type="date" class="form-control" name="ccr_rr_date" id="ccr_rr_date">
                            </div>
                           </div>
                           </div>
                      </div>
                      </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
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

<script type="text/javascript">

function setAccount(){
  document.getElementById("ccr_client_client").value = document.getElementById("ccr_client").value;
  document.getElementById("other_account").value = document.getElementById("ccr_client_client").value;
  
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

$(document).ready(function(){
      var i = 1;
      $('#add').click(function(){
           i++;
           $('#dynamic_field').append('<tr id="row'+i+'"> <td> <input type="text" name="ccr_qty[]" id="ccr_qty" class="form-control"></td> <td> <textarea rows=1 cols=73 class="no-resize form-control" name="ccr_particulars[]" id="ccr_particulars"></textarea></td> <td> <input type="text" name="ccr_serial[]" id="ccr_serial" class="form-control"> </td>  <td> <input type="number" name="ccr_amt[]" id="ccr_amt" value="0" class="form-control input" onchange="updateTotal();"></td>  <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"> <i class="fa fa-times" aria-hidden="true"></i> </button></td></tr></tr>');
      });
      $(document).on('click', '.btn_remove', function(){
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();
      });
      $('#submit').click(function(){
        var client = document.getElementById("ccr_client").value;
        var ccr_signedBy = document.getElementById("ccr_signedBy").value;
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
        if (client == "" || date_start == "" || date_finish == "" || ccr_time_start == "" || ccr_time_end == "" || ccr_remark == "" || ccr_signedBy == "") {
          alert("Please fill all fields!");
        } else  {
         $.ajax({
                url:"save.php",
                method:"POST",
                data:$('#cc_rep').serialize(),
                success:function(data){
                     if (data.status == 'success'){
                          alert("Customer call report was saved!");
                          $('#cc_rep')[0].reset();
                          window.location.reload(true);
                     } else if(data.status == 'exist'){
                          alert("CC# already exists in the database. Please check and try again!");
                     } else if(data.status == 'error'){
                          alert("Something went wrong!");
                     }
                }
            });
           }
      });
 });

function setDate(){
  var date_start = document.getElementById("ccr_date").value;
  document.getElementById("ccr_date_fin").value = date_start;
}

function updateTotal() {
    var total = 0;//
    var btn = document.getElementById('submit');
    var list = document.getElementsByClassName("input");
    var values = [];
    var rr = document.getElementById('ccr_rr').value;
    for(var i = 0; i < list.length; ++i) {
        values.push(parseFloat(list[i].value));
    }
    total = values.reduce(function(previousValue, currentValue, index, array){
        return previousValue + currentValue;
    });

    if (isNaN(total)) total = 0;

    document.getElementById("total").textContent = total.toFixed(2);

    if (total > 0 && rr == "") {
      btn.disabled = true;      
    } else {
      btn.disabled = false;
    }
}

$(document).ready(function()
{
 $(".clientId").change(function()
 {
  var id = $(this).val();
  var dataString = 'id='+ id; 
  $.ajax
  ({
   type: "POST",
   url: "get_account.php",
   data: dataString,
   cache: false,
   success: function(html)
   {
      $(".accountClient").html(html);
   } 
   });
  });
});



var forcollection = document.getElementById('forcollection');
var ccr_rr = document.getElementById('ccr_rr');
var ccr_rr_date = document.getElementById('ccr_rr_date');
var btn = document.getElementById('submit');
var cc_num = document.getElementById('ccr_cc').value;
if (cc_num == "No CC available.") {
  btn.disabled = true;
}
forcollection.onchange = function() {  
  btn.disabled = false;
  ccr_rr.readOnly = !!this.checked;
  ccr_rr_date.readOnly = !!this.checked;
};
$(".client-select-list").select2();

</script>