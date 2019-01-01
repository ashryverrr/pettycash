<?php
  require_once '../config/connection.php';
  require_once '../config/validate_acct.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Remittance Report </title>
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
  <?php require '../config/navbar-acct.php'; ?>
</aside>
<div class="content-wrapper">
<section class="content-header">
  <h1>
    Remittance Report
    <small>List of Remittance Report</small>
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
                  <h3 class="box-title">List of Remittance Report </h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped" id="petty-grid">
                    <thead>
                      <tr>
                          <th> RR#  </th>             
                          <th> EMPLOYEE  </th>                          
                          <th> DATE </th>
                          <th> STATUS </th>
                          <th> POST </th>
                          <th class="info"> MODIFY </th>
                          <th class="danger"> DELETE  </th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <button type="button" name="btn_post" id="btn_post" class="btn btn-success"
                  > POST</button>
                    <button type="button" name="btn_unpost" id="btn_unpost" class="btn btn-danger"> UNPOST</button>
                    <label><input type="checkbox" id="checkAll"/>  SELECT ALL</label>
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

$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

$(document).ready(function() {
        var dataTable = $('#petty-grid').DataTable( {
          "processing": true,
          "serverSide": true,
          "paging": true,
          "ordering": true,
          "order": [[ 0, "desc"]],
          "scrollX": true,
          "sScrollX": "100%",
          "sScrollXInner": "100%",
          "ajax":{
            url :"remittance_report.php", // json datasource
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
  alert("Remittance report is already posted!");
}

//POST
$(document).ready(function(){
 $('#btn_post').click(function(){
  if(confirm("Are you sure you want to post this item(s)?"))  {
   var id = [];
   $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
   });
   if(id.length === 0)    {
    alert("Please Select atleast one checkbox");
   }
   else {
    $.ajax({
     url:'post_rr.php',
     method:'POST',
     data:{id:id},
     success:function(data){
       if (data.status == 'success'){
                 alert("Remittance report was successfully posted!");
                 window.location.reload(true);
               } else {
                  alert("Error remittance_report.");
                  window.location.reload(true);
               }
     }
    });
   }
  }
  else
  {
   return false;
  }
 });
});

//UNPOST
$(document).ready(function(){
 $('#btn_unpost').click(function(){
  if(confirm("Are you sure you want to unpost this item(s)?"))  {
   var id = [];
   $(':checkbox:checked').each(function(i){
    id[i] = $(this).val();
   });
   if(id.length === 0)    {
    alert("Please Select atleast one checkbox");
   }
   else {
    $.ajax({
     url:'unpost_rr.php',
     method:'POST',
     data:{id:id},
     success:function(data){
       if (data.status == 'success'){
                 alert("Remittance report was successfully unposted!");
                 window.location.reload(true);
               } else {
                  alert("Error posting remittance report.");
                  window.location.reload(true);
               }
     }
    });
   }
  }
  else
  {
   return false;
  }
 });
});

//DELETE
$(function(){
    $(document).on('click','.trash',function(){
      var del_id = $(this).attr('id');
      if(confirm("Are you sure you want to delete this?")){
           $.ajax({
            type:'post',
            url:'delete_rr.php',
            data:{'del_id': del_id},
            success: function(data){
               if (data.status == 'success'){
                 alert("Remittance report was successfully deleted!");
                 window.location.reload(true);
               } else if(data.status == 'posted'){
                 alert("Remittance report cannot be deleted, it's already posted!");
               } else if(data.status == 'error'){
                 alert("Remittance report status is invalid.");
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
              alert("Wronw password. Please try again.");
         } else {
              alert("Something went wrong!");
         }
  }
  });
  }  
  return false;
}

</script>
