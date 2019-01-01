<?php
  require_once '../config/connection.php';
  require_once '../config/validate_tech.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Customer Calls </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
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
    Petty Cash
    <small>List of Liquidation</small>
  </h1>
  <ol class="breadcrumb">
  </ol>
</section>
        <!-- Main content -->
        <section class="content">
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of Petty Cash </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped" id="petty-grid">
                    <thead>
                      <tr>
                          <th> CC#  </th>
                          <th> CLIENT </th>
                          <th> DATE </th>
                          <th class="info"> MODIFY </th>
                          <th class="danger"> DELETE  </th>
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
<script src="../js/jquery.dataTables.min.js"></script>
<script src="../js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        var dataTable = $('#petty-grid').DataTable( {
          "processing": true,
          "serverSide": true,
          "paging": true,
          "ordering": true,
          "order": [[ 2, "desc" ]],
          "scrollX": true,
          "sScrollX": "100%",
          "sScrollXInner": "100%",
          "ajax":{
            url :"petty_cash.php", // json datasource
            type: "GET",  // method  , by default get
            error: function(){  // error handling
              $(".petty-grid-error").html("");
              $("#sample-grid").append('<tbody class="petty-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#petty-grid_processing").css("display","none");
            }            
          }
        } );
} );
function alertNOT(){
  alert("Already posted!");
}
</script>
<script type="text/javascript">
//DELETE
$(function(){
    $(document).on('click','.trash',function(){
      var del_id = $(this).attr('id');
      if(confirm("Are you sure you want to delete this?")){
           $.ajax({
            type:'post',
            url:'delete_petty_cash.php',
            data:{'del_id': del_id},
            success: function(data){
               if (data.status == 'success'){
                 alert("Petty Cash was successfully deleted!");
                 window.location.reload(true);
               } else if(data.status == 'posted'){
                 alert("Petty Cash cannot be deleted, it's already posted!");
               } else if(data.status == 'error'){
                 alert("Petty Cash status is invalid.");
                 window.location.reload(true);
               } else {
                 alert("Something went wrong!");
               }
             }
          });
      }
   });
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

</script>
