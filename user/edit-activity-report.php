<?php
  require_once '../config/connection.php';
  require_once '../config/validate_tech.php';  
  $user_id = $_SESSION['user_id'];  
  $id = $_GET['id'];
  $sql = "SELECT ar_user_id, ar_client, ar_client_account,  ar_date_started,
  ar_time_start, ar_time_end,
  ar_activity FROM activity_report WHERE ar_id = :ar_id ";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindParam(':ar_id', $id);
  $stmt -> execute();
  $row = $stmt -> fetch(); 
  $countRow = $stmt -> rowCount();
  if ($countRow > 0) {   
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
  $ar_activity = $row['ar_activity'];
  $ar_client =  explode(',', $ar_client);
  } else {
    header("Location: activity-reports.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Edit Activity Report </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <link rel="stylesheet" href="../css/font-awesome.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/select2.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
  <script src="../js/jquery.bootpag.min.js"></script>
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
<div class="content-wrapper">
<section class="content-header">
  <h1>
  Edit Activity Report
  </h1>
  <ol class="breadcrumb">    
  </ol>
</section>
        <section class="content">         
          <div class="row">         
            <div class="col-xs-12">
            <div class="box">
               <div class="box-header with-border">
                    <h3 class="box-title">Activity Report </h3>
                </div>
                  <form class="form-horizontal" id="ar_rep" name="ar_rep">
                    <div class="box-body">
                     <div class="row">                      
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Customer: </label>
                      <div class="col-md-8">
                      <select class="form-control ar-client-select" name="ar_client[]" id='ar_client' multiple="multiple">                        
                              <?php
                                $sql = "SELECT * FROM clients ORDER BY client_name asc, client_branch asc"; 
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute();
                                 foreach ($ar_client as $key) {
                                 echo "<option value='$key' selected='selected'>  $key </option>";
                                  }                       
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
                      <input type="hidden" name="ar_id" id="ar_id" value="<?php echo $id; ?>">
                       
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="Employee" class="control-label col-md-4">Employee:</label>
                             <div class="col-md-6">
                             <input type="text" class="form-control" name="emp_name" id="emp_name" value="<?php echo $empname; ?>" readonly> 
                            </div>                
                          </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                              <label for="email" class="control-label col-md-4">Date:</label>
                             <div class="col-md-6">
                             <input type="date" class="form-control" name="ar_date_started" id="ar_date_started" value="<?php echo $ar_date_started; ?>" required> 
                            </div>                
                          </div>
                        </div>
                      </div>                      
                       <div class="row">
                        <div class="col-md-6">
                         <div class="form-group">
                          <label for="time-start" class="control-label col-md-4">Time Started:</label>
                         <div class="col-md-6">
                           <input type="time" class="form-control" name="ar_time_start" id="ar_time_start" value="<?php echo $ar_time_start; ?>"> 
                         </div>               
                         </div>
                        </div>
                       <div class="col-md-6">
                       <div class="form-group">
                          <label for="time-end" class="control-label col-md-4">Time Finished:</label>
                          <div class="col-md-6">
                          <input type="time" class="form-control" name="ar_time_end" id="ar_time_end" value="<?php echo $ar_time_end; ?>">
                          </div>
                       </div>
                       </div>
                       </div>                     
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="comment">Activity:</label>
                          <textarea class="form-control" rows="5" id="ar_activity" name="ar_activity"><?php echo trim($ar_activity); ?></textarea>
                        </div>
                      </div>                      
                    </div><!-- /.box-body -->  
                    <div class="box-footer">         
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

$('#submit').click(function(){   
        var ar_client = $('#ar_client').val();   
        var ar_date_started = document.getElementById("ar_date_started").value;
        var ar_time_start = document.getElementById("ar_time_start").value;
        var ar_time_end = document.getElementById("ar_time_end").value;
        var ar_activity = document.getElementById("ar_activity").value;
        if (ar_client == "" || ar_date_started == ""  || ar_time_start == "" || ar_time_end == "" || ar_activity == "") {
          alert("Please fill all fields!");
        } else  {
         $.ajax({  
                url:"save_ar_edit.php",  
                method:"POST", 
                data:$('#ar_rep').serialize(),  
                success:function(data){
                     if (data.status == 'success'){
                         alert("Activity report was edited successfully!");
                         $('#ar_rep')[0].reset();  
                         location.replace("activity-reports.php");
                     } else if(data.status == 'not_allowed'){
                          alert("You are not allowed to edit that!");
                     }  else if(data.status == 'error'){
                          alert("Something went wrong!");
                     } else {
                        alert("Unknown");
                     }
                }  
            });  
           }       
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

$(".ar-client-select").select2();
</script>
