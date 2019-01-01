<?php
  require_once '../config/connection.php';
  require_once '../config/validate_user.php';
  
  $user_id = $_SESSION['user_id'];

  $sql = "SELECT * FROM cc_report ORDER BY ccr_id";
  $stmt = $pdo ->prepare($sql);
  $stmt -> execute();
  $item_per_page = 10;
  $get_total_rows = $stmt -> rowCount();
  $pages = ceil($get_total_rows / $item_per_page);

?>

<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Transactions </title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">  
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
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <?php require '../config/sidebar.php'; ?>
</aside>

<div class="content-wrapper">
<section class="content-header">
  <h1>
    Customer Call
    <small>List of Customer Call Reports</small>
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
                  <h3 class="box-title">List of Customer Calls </h3>    
                  <br><br>
                  <div class="form-group">
                       <div class="input-group">  
                            <span class="input-group-addon">Search</span>  
                            <input type="text" name="search_text" id="search_text" placeholder="Search by Client Name, Employee or CC#" class="form-control" />  
                       </div>  
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>                          
                          <th> CC#  </th>
                          <th> CLIENT </th>
                          <th> EMPLOYEE </th>
                          <th> DATE </th>
                          <th class="warning"> STATUS</th>          
                          <th class="info"> MODIFY </th>
                          <th class="info"> POST </th>
                          <th class="danger"> DELETE  </th>     
                      </tr>
                    </thead>
                    <tbody id="results">    
                    </tbody>                                                
                  </table>                   
                </div><!-- /.box-body -->  
                <div class="box-footer clearfix">
                  <button type="button" name="btn_post" id="btn_post" class="btn btn-info"> POST selected</button>
                  <ul class="pagination pagination-sm no-margin pull-right">
                  </ul>
                </div>               
              </div><!-- /.box -->
            </div>
            </div>

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
$(document).ready(function() {

  $("#results").load("customer_calls.php");  //initial page number to load
  $(".pagination").bootpag({
     total: <?php echo $pages; ?>,
     page: 1,
     maxVisible: 10 
  }).on("page", function(e, num){
    e.preventDefault(); 
    $("#results").load("customer_calls.php", {'page':num});
  });
});

 $(document).ready(function(){  
      $('#search_text').keyup(function(){  
           var txt = $(this).val();  
           if(txt != '') {  
                $.ajax({  
                     url:"customer_calls.php",  
                     method:"post",  
                     data:{search:txt},  
                     dataType:"text",  
                     success:function(data) {  
                          $('#results').html(data);  
                     }  
                });  
           }  
           else  {  
           $.ajax({  
                url:"customer_calls.php",  
                method:"post",  
                data:{search:txt},  
                dataType:"text", 
                success:function(data)  {  
                    $('#results').html(data);  
                }  
            });             
           }  
      });  
 }); 


</script>   

<script type="text/javascript">

function alertNOT(){
  alert("Already posted!");
}

$(function(){
    $(document).on('click','.trash',function(){
      var del_id = $(this).attr('id');     
      if(confirm("Are you sure you want to delete this?")){
           $.ajax({
            type:'post',
            url:'../user/delete_cc.php',
            data:{'del_id': del_id},
            success: function(data){
               if (data.status == 'success'){
                 alert("Customer call was successfully deleted!");
                 window.location.reload(true);
               } else if(data.status == 'posted'){
                 alert("Customer call cannot be deleted, it's already posted!");
               } else if(data.status == 'error'){
                 alert("Customer call status is invalid.");
                 window.location.reload(true);
               } else {
                 alert("Something went wrong!");
               }
             }
          });     
      }
   });
});
</script>

<script>
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
     url:'post_cc.php',
     method:'POST',
     data:{id:id},
     success:function(data){
       if (data.status == 'success'){
                 alert("Customer call was successfully posted!");
                 window.location.reload(true);
               } else {
                  alert("ERROR");
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
</script>