<?php
  require_once '../config/connection.php';
  require_once '../config/validate_user.php';  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Petty Cash </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="../css/font-awesome.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css"> 
  <link rel="stylesheet" href="../css/font-awesome.min.css">

  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
</head>
<body class="hold-transition skin-black  sidebar-mini" >
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
    Liquidation List
    <small>List of Petty Cash Records</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Liquidation List</li>
  </ol>
</section>
        <!-- Main content -->
        <section class="content">         
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->                      
            <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of Transactions </h3>    
                </div><!-- /.box-header -->
                <div class="box-body">   

                  <table class="table table-striped table-bordered" style="text-align: center; white-space: nowrap;" id="sample-grid">
                  <!--  style="text-align: center; white-space: nowrap;" -->
                    <thead>
                      <tr>                         
                          <th> CC#</th>                          
                          <th> CLIENT </th>
                          <th> EMPLOYEE  </th>                          
                          <th class="text-nowrap"> DATE</th>
                          <th class="warning"> STATUS</th>          
                          <th class="info"> EDIT </th>
                          <th class="info"> POST </th>
                          <th class="danger"> DELETE  </th>     
                      </tr>
                    </thead>                                                             
                  </table>                
                  </div><!-- /.box-body -->  

                  <div class="box-footer clearfix">                  
                    <button type="button" name="btn_post" id="btn_post" class="btn btn-success">POST</button>
                     <button type="button" name="btn_unpost" id="btn_unpost" class="btn btn-danger">UNPOST</button>  
                     <label><input type="checkbox" id="checkAll"/>  SELECT ALL</label>               
                  </div>              
             </div><!-- /.box -->            
             </div> <!-- /COL MD 12 -->   
           </div>  <!-- /ROW -->   

          
        </section><!-- /.content -->
</div><!-- /.content-wrapper -->
       <?php include '../config/footer.html'; ?>
      
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
        var dataTable = $('#sample-grid').DataTable( {
          "processing": true,
          "serverSide": true,
          "paging": true,
          "ordering": true,     
          "scrollX": true,
          "order": [[ 0, "desc" ]],
          "ajax":{
            url :"petty_cash.php", // json datasource
            type: "GET",  // method  , by default get
            error: function(){  // error handling
              $(".sample-grid-error").html("");
              //$("#sample-grid").append('<tbody class="sample-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              //$("#employee-grid_processing").css("display","none");        
            }

          }
        } );
} );

function alertNOT(){
  alert("Already posted!");
}

//DELETE
$(function(){
    $(document).on('click','.trash',function(){
      var del_id = $(this).attr('id');     
      if(confirm("Are you sure you want to delete this?")){
           $.ajax({
            type:'POST',
            url:'delete.php',
            data:{'del_id': del_id},
            success: function(data){
               if (data.status == 'success'){
                 alert("Petty Cash was successfully deleted!");
                 window.location.reload(true);
               } else if(data.status == 'posted'){
                 alert("Petty Cash cannot be deleted, it's already posted!");
                 window.location.reload(true);
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
     url:'post_petty.php',
     method:'POST',
     data:{id:id},
     success:function(data){
       if (data.status == 'success'){
                 alert("Petty Cash was successfully posted!");
                 window.location.reload(true);
               } else {
                  alert("ERROR");
                  window.location.reload(true);
               }
      }     
    });
   }
   
  }
  else{
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
     url:'unpost_petty.php',
     method:'POST',
     data:{id:id},
     success:function(data){
       if (data.status == 'success'){
                 alert("Petty Cash was successfully unposted!");
                 window.location.reload(true);
               } else {
                  alert("ERROR");
                  window.location.reload(true);
               }
      }     
    });
   }
   
  }
  else{
   return false;
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

