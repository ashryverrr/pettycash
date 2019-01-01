<?php
  require_once '../config/connection.php';
  require_once '../config/validate_tech.php';

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Create Activity Report</title>
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
            Create Activity Report
          </h1>
          <ol class="breadcrumb">
          </ol>
        </section>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Activity Report form</h3>
                  </div>
                  <form class="form-horizontal" id="cc_rep" name="cc_rep">
                    <div class="box-body">
                     <div class="row">
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Client: </label>
                      <div class="col-md-8">
                      <select class="form-control client-select-list" name="ar_client[]" id='ar_client' multiple="multiple">
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
                              <label for="email" class="control-label col-md-4">Date:</label>
                             <div class="col-md-6">
                             <input type="date" class="form-control" name="ar_date" id="ar_date" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                       <div class="row">
                        <div class="col-md-6">
                         <div class="form-group">
                          <label for="time-start" class="control-label col-md-4">Time Started:</label>
                         <div class="col-md-6">
                           <input type="time" class="form-control" name="ar_time_start" id="ar_time_start">
                         </div>
                         </div>
                        </div>
                       <div class="col-md-6">
                      <div class="form-group">
                        <label for="time-end" class="control-label col-md-4">Time Finished:</label>
                        <div class="col-md-6">
                        <input type="time" class="form-control" name="ar_time_end" id="ar_time_end">
                        </div>
                      </div>
                        </div>
                      </div>
                      <div>
                      </div>
                      <div class="col-md-12">
                      <div class="form-group">
                        <label for="comment">Work done:</label>
                        <textarea class="form-control" rows="5" id="ar_remark" name="ar_remark"></textarea>
                      </div>
                      </div>                 
                    </div><!-- /.box-body -->
                    <div class="box-footer">
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
  var client = document.getElementById("ar_client").value;
  var date_start = document.getElementById("ar_date").value;
  var ccr_time_start = document.getElementById("ar_time_start").value;
  var ccr_time_end = document.getElementById("ar_time_end").value;
  var ccr_remark = document.getElementById("ar_remark").value;

  if (client == "" || date_start == "" || ccr_time_start == "" || ccr_time_end == "" || ccr_remark == "") {
    alert("Please fill all fields!");
  } else  {
   $.ajax({
          url:"save_ar.php",
          method:"POST",
          data:$('#cc_rep').serialize(),
          success:function(data){
               if (data.status == 'success'){
                    alert("Activity report was saved!");
                    $('#cc_rep')[0].reset();
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