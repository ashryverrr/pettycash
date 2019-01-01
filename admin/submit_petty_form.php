<?php
require_once '../config/validate_user.php';
require_once '../config/connection.php';
$last_id = $_SESSION['last_id'];
$sql = "SELECT * FROM transaction WHERE trans_id = :last_id ";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(":last_id", $last_id);
$stmt-> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
    $empname = $row['emp_id'];
    $client = $row['client_name'];
    $ccnum = $row['cc_num'];
    $trans_date = $row['trans_date'];
    $amount = $row['amount']; 
}
$sql = "SELECT emp_name FROM users WHERE user_id = :empname"   ;
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(":empname", $empname);
$stmt -> execute();
while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
    $emp_name = $row['emp_name'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cyber Frontier | Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../css/custom.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.css"> 
    <script src="..\js\jquery.min.js"></script>
    <script src="..\js\bootstrap.min.js"> </script>
    <script src="..\js\jquery.hotkeys.js"></script>
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
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Petty Form
            <small>Add Details</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Submit Petty Form</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">   
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Submit Petty Form</h3>
                  <br>
                  <div class="row">               
                      <div class="col-md-3">
                       <b> Employee: </b> <?php echo $emp_name; ?>
                      </div>
                      <div class="col-md-2">
                        <b> CC#: </b> <?php echo  $ccnum; ?>
                      </div>
                      <div class="col-md-2">
                       <b> Amount: </b> <?php echo $amount; ?>
                      </div>
                     <div class="col-md-2">
                         <b> Date: </b> <?php echo $trans_date; ?>
                      </div>
                    <div class="col-md-3">
                        <b> Customer: </b> <?php echo $client; ?>
                      </div>
                  </div>
                </div><!-- /.box-header -->
                <form name="add_petty" id="add_petty">  
                <div class="box-body">                
                  <table class="table table-bordered" id="dynamic_field">
                    <tr>
                      <th>Vehicle</th>
                      <th>Expenses</th>
                      <th>Amount</th>
                      <th></th>
                    </tr>      
                     <tr>
                      <td> <input type="text" name="vehicle[]" id="vehicle" class="form-control"></td>  
              <td> <textarea class="form-control" rows=1 cols=65 class="no-resize" name="desc[]" id="desc"></textarea></td>
              <td> <input class="form-control" type="number" name="amount[]" id="amt" onchange="automaticAdd();"></td>
                     </tr>
                  </table>
                  <div class="box-footer"> 
                    <button type="button" onclick="myFunction();" id="submit" name="save_petty_info" class="btn btn-success pull-right">Save</button>
                  
                    </div><!-- /.box-footer -->
                </div><!-- /.box-body -->
                </form>
              </div><!-- /.box -->
            </div>
          </div>     
        </section><!-- right col -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include '../config/footer.html'; ?>
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
  </body>
</html>
<script>
var i = 1; 
function automaticAdd(){     
     i++;
     $('#dynamic_field').append('<tr id="row'+i+'"> <td> <input type="text" name="vehicle[]" id="vehicle" class="form-control"></td>  <td> <textarea rows=1 cols=73 class="no-resize form-control" name="desc[]" id="desc"></textarea></td> <td> <input type="number" name="amount[]" id="amt" class="form-control" onchange="automaticAdd();"></td>  <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"> <i class="fa fa-times" aria-hidden="true"></i> </button></td></tr></tr>');
}

$(document).on('click', '.btn_remove', function(){
       var button_id = $(this).attr("id");
       $('#row'+button_id+'').remove();
  });
</script>
<script type="text/javascript">
  function myFunction() {
  var vehicle = document.getElementById("vehicle").value;
  var amt = document.getElementById("amt").value;
  var desc = document.getElementById("desc").value;
  if (vehicle == '' || amt == '' || desc == '') {
    alert("Please fill all fields.");  
  } else {
   $.ajax({
      url:"save_petty.php",  
      method:"POST", 
      data:$('#add_petty').serialize(),  
      success:function(data) {  
         if (data.status == 'success'){
              alert("Information was added succesfully!");
              window.location.replace("transactions.php");
         } else if(data.status == 'error'){
              alert("Something went wrong in saving the information!");
         } else {
              alert("Something is wrong.");
         }
      }  
  });  
  }  
  return false;
}
</script>