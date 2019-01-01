<?php
require_once '../config/connection.php';
require_once '../config/validate_user.php';

$employee_id = $_GET['id'];

$sql = "SELECT * FROM users WHERE user_id = :uid";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(":uid", $employee_id);
$stmt -> execute();
$row = $stmt -> fetch();

$emp_name = $row['emp_name'];


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | CC History</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
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
    <?php require '../config/sidebar.php'; ?>
</aside>
<div class="content-wrapper">
<section class="content-header">
  <h1>
    <?php echo $emp_name; ?>
    <small>CC History</small>
  </h1>
  <ol class="breadcrumb">
     <li><a href="employees.php"><i class="fa fa-dashboard"></i> Employees</a></li>
    <li class="active">CC History</li>
  </ol>
</section>
<section class="content">      
		  <input type="hidden" id="employee_id" value="<?php echo $employee_id; ?>">   
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->                       
           <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of CC </h3>    
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped" id="history-grid">
                    <thead>
                      <tr>                          
                          <th class=""> ASSIGNED CC  </th>                          
                          <th class="info"> DATE ISSUED </th>                           
                      </tr>
                    </thead>
                    <tbody>    
                    </tbody>                                                
                  </table>
                </div><!-- /.box-body -->    
                <div class="box-footer clearfix">
                  <ul class="pagination pagination-sm no-margin pull-right">
                  </ul>
                </div>            
              </div><!-- /.box -->
            </div>    
            </div>
            </section><!-- right col -->
      </div><!-- /.content-wrapper -->
       <?php include '../config/footer.html'; ?>      
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->    
  </body>
</html>
<script src="../dist/js/app.min.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript">
$(document).ready(function() {
		var emp_id = document.getElementById("employee_id").value;
        var dataTable = $('#history-grid').DataTable( {
          "processing": true,
          "serverSide": true,
          "paging": true,
          "ordering": true,    
          "scrollX": true, 
          "order": [[ 0, "desc" ]],
          "ajax":{
            url :"fetch_cc_history.php", // json datasource
            type: "POST",  // method  , by default get
            data: {
            emp_id: emp_id,             
        	},
            error: function(){  // error handling
              $(".history-grid-error").html("");
              //$("#sample-grid").append('<tbody class="sample-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              //$("#employee-grid_processing").css("display","none");        
            }
          }
        } );
} );

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
