<?php
  require_once '../config/connection.php';
  require_once '../config/validate_user.php';  
  $user_id = $_SESSION['user_id'];  
  $id = $_GET['id'];
  $sql = "SELECT trans_id, emp_id, client_name, cc_num, trans_date, amount as tamount FROM transaction WHERE trans_id = :id ";
  $stmt = $pdo ->prepare($sql);
  $stmt -> bindParam(":id", $id);
  $stmt -> execute();
  $count = $stmt -> rowCount();
  if ($count > 0) {
    $row = $stmt -> fetch();
    $id = $row['trans_id'];
    $emp_id = $row['emp_id'];
    $customers = $row['client_name'];
    $ccnum = $row['cc_num'];
    $trans_date = $row['trans_date'];      
    $amountt = $row['tamount'];      
  
    $customers1 =  explode(',', $customers);
    $sql = "SELECT emp_name FROM users WHERE user_id = :emp_id ";
    $stmt = $pdo -> prepare($sql);
    $stmt -> bindParam(":emp_id", $emp_id);
    $stmt -> execute();
    $row11 = $stmt -> fetch();
    $emp_name = $row11['emp_name'];
  } else {
    header("Location: dashboard.php");
  }
?>
<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Edit Petty Cash</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../css/multi-select.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">
  <script src="..\js\jquery.min.js"></script>
  <script src="..\js\select2.js"></script>
  <script src="..\js\jquery.bootpag.min.js"></script>
  <script src="..\js\bootstrap.min.js"> </script>
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
    Edit Petty Cash
  </h1>
  <ol class="breadcrumb">    
  </ol>
</section>
        <section class="content">         
          <div class="row">         
            <div class="col-xs-12">
            <div class="box">
               <div class="box-header with-border">
                    <h3 class="box-title">Petty Cash Liquidation Form </h3>
                </div>
                  <form class="form-horizontal" method="POST" id="cc_rep" name="cc_rep">
                    <div class="box-body">
                     <div class="row">                      
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Employee: </label>
                      <div class="col-md-6">
                      <input type="hidden" name="employee" id="employee" value="<?php echo $emp_id; ?>" >
                      <input type="text" class="form-control" name="" id="" value="<?php echo $emp_name; ?>" readonly>
                      </div>                
                      </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email" class="control-label col-md-4">CC#:</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="cc_num" id="cc_num" value="<?php echo $ccnum; ?>" readonly> 
                          </div>                
                        </div>
                      </div>
                      </div>
                      <input type="hidden" id="trans_id" name="trans_id" value="<?php echo $id; ?>">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="amt" class="control-label col-md-4">Amount:</label>
                             <div class="col-md-6">
                             <input type="number" class="form-control" name="trans_amount" id="trans_amount" value="<?php echo $amountt; ?>"> 
                            </div>                
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email" class="control-label col-md-4">Date:</label>
                            <div class="col-md-6">
                             <input type="date" class="form-control" name="trans_date" id="trans_date" value="<?php echo $trans_date; ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>                     
                     <div class="form-group">
                      <label for="time-start" class="control-label col-md-2">Client:</label>
                     <div class="col-md-4">
                       <select class="form-control js-example-basic-multiple" name="client[]" id='client' multiple="multiple">
                          <?php
                            foreach ($customers1 as $key) {
                              echo "<option value='$key' selected='selected'>  $key </option>";
                            }
                            //SELECT * FROM clients WHERE concat(clients.client_name,' ', clients.client_branch) NOT IN ('SM PAMPANGA', 'SM BALIUAG')
                            $sql = "SELECT client_id, client_name, client_branch FROM clients WHERE concat(clients.client_name,' ', clients.client_branch) NOT IN (:customers) ORDER BY client_name asc, client_branch asc"; 
                            $stmt = $pdo -> prepare($sql);   
                            $stmt -> bindParam(":customers", $customers);                         
                            $stmt -> execute();           
                            while ($row = $stmt -> fetch(PDO::FETCH_ASSOC) ) {
                                $client_id = $row['client_id'];
                                $client_name = $row['client_name'];
                                $client_branch = $row['client_branch'];           
                                $client_fname = $client_name." ".$client_branch;
                                   echo "
                                    <option value='$client_fname'> $client_fname </option>
                                   ";
                              }  
                          ?>
                        </select>
                     </div>               
                     </div>        
                      <div>
                        <table class="table table-condensed" id="dynamic_field">
                          <thead>
                            <tr>
                              <th class='hidden'> </th>
                              <th class="text-center">Vehicle</th>
                              <th class="text-center">Expenses</th>
                              <th class="text-center">Amount</th>
                              <th> Delete </th>
                            </tr>
                          </thead>
                          <tbody>                                          
                            <?php
                              $sql = "SELECT * FROM transaction_details WHERE trans_id = :id ";
                              $stmt = $pdo -> prepare($sql);
                              $stmt -> bindParam(":id", $id);
                              $stmt -> execute();
                              $count = $stmt -> rowCount();
                              if ($count > 0) {     
                                $i = 0;                          
                               while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){
                                $i++;
                                $vehicle = trim($row['vehicle']);
                                $expenses = trim($row['expenses']);
                                $amt = trim($row['amount']);
                                $detail_id = trim($row['detail_id']);
                                  echo " 
                                  <tr id='roww".$i."' >
                                  <td class='hidden'> <input class='form-control' type='hidden' name='detail_id[]' id='detail_id' value='$detail_id'> </td>
                                  <td> <input type='text' name='vehicle[]' id='vehicle' class='form-control' value='$vehicle'> </td>
                                  <td> <textarea class='form-control no-resize' rows='1' cols='65' name='desc[]' id='desc' >$expenses</textarea></td>
                                  <td> <input class='form-control input' type='number' name='amount[]' id='amount' min='0' value='$amt' onchange='updateTotal();'>  </td>       
                                  <div class='btn-group' data-toggle='buttons'>                             
                                  <td class='text-center'> <input type='checkbox' name='deletee[]' onclick='Checkbox(this);' id='$i' class='try' value='$detail_id'> </td>                                 
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
                        </div>
                    </div><!-- /.box-body -->  
                    <div class="box-footer">           
                     <input type="button" id="add" class="btn btn-success" value="Add Field">
                     <input class="btn btn-success pull-right" id="submit" type="button" value="Save" >
                    </div><!-- /.box-footer -->               
              </div><!-- /.box -->
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

// HIDE ELEMENT WHEN DELETE IS CHECKED
$(document).on('click', '.try', function(){  
         var button_id = $(this).attr("id");   
         $('#roww'+button_id+'').hide();
         updateTotal();  
}); 

$(document).ready(function(){  
    var i = 1;  
    $('#add').click(function(){  
         i++;  
          $('#dynamic_field').append('<tr id="row'+i+'"> <td class="hidden"><td class="hidden"> <input type="hidden" name="detail_id[]" id="detail_id"> </td> <td> <input type="text" name="vehicle[]" id="vehicle" class="form-control"></td> <td> <textarea rows=1 cols=73 class="no-resize form-control" name="desc[]" id="desc"></textarea></td> <td> <input type="number" name="amount[]" id="amount" class="form-control input" onchange="updateTotal();"></td>  <td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove"> <i class="fa fa-times" aria-hidden="true"></i> </button></td></tr></tr>');
    });        
    $(document).on('click', '.btn_remove', function(){  
         var button_id = $(this).attr("id");   
         $('#row'+button_id+'').remove();             
    });  
    $('#submit').click(function(){   
      var employee = document.getElementById("employee").value;
      var cc_num = document.getElementById("cc_num").value;        
      var trans_date = document.getElementById("trans_date").value;
      var client = $('#client').val();
      var trans_amount = document.getElementById("trans_amount").value;
      var trans_id = document.getElementById("trans_id").value;
      var detail_id = document.getElementById("detail_id").value;
      var vehicle = document.getElementById("vehicle").value;
      var amount = document.getElementById("amount").value;
      var description = document.getElementById("desc").value;
      var dataString = 'employee=' + employee + '&cc_num=' + cc_num + '&trans_date=' + trans_date + '&trans_amount=' + trans_amount + '&client=' + client +  '&vehicle=' + vehicle + '&description=' + description + '&amount=' + amount + '&trans_id=' + trans_id + '&detail_id=' + detail_id; 
      if (employee == "" || cc_num == "" || trans_amount == "" || trans_date == "" || client == "") {
        alert("Please fill all fields!");
      } else  {
       $.ajax({  
              url:"save_edit_petty_cash.php",  
              method:"POST", 
              data:$('#cc_rep').serialize(),  
              success:function(data){
                   if (data.status == 'success'){
                       alert("Petty cash with CC#"+cc_num+" was edited successfully!");
                       location.replace("transactions.php");
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
  if (isNaN(total)) total = 0;
  document.getElementById("total").textContent = total.toFixed(2); 
});

function updateTotal() {
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
  if (isNaN(total)) total = 0;
  document.getElementById("total").textContent = total.toFixed(2); 
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

$(".js-example-basic-multiple").select2();
</script>