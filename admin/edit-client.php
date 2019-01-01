<?php
  require_once '../config/connection.php';
  require_once '../config/validate_user.php';  
  $user_id = $_SESSION['user_id'];  
  $id = $_GET['id'];
  $sql = "SELECT client_id, client_person, client_name, client_branch, client_account, client_contact_num, client_address, client_contract_start, client_contract_end FROM clients WHERE client_id = :id";
  $stmt = $pdo ->prepare($sql);
  $stmt -> bindParam(":id", $id);
  $stmt -> execute();
  $count = $stmt -> rowCount();
  if ($count > 0) {
    $row = $stmt -> fetch();
    $client_id = $row['client_id'];
    $client_person = $row['client_person'];
    $client_name = $row['client_name'];
    $client_branch = $row['client_branch'];
    $client_address = $row['client_address'];
    $client_account = $row['client_account'];
    $client_contact_num = $row['client_contact_num'];
    $client_contract_start = $row['client_contract_start'];
    $client_contract_end = $row['client_contract_end'];   
  } else {
    header("Location: dashboard.php");
  }
?>
<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Edit Client Information</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="../css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="../css/multi-select.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.css">  
  <script src="../js/jquery.min.js"></script>
  <script src="../js/select2.js"></script>
  <script src="../js/jquery.bootpag.min.js"></script>
  <script src="../js/bootstrap.min.js"> </script>
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
    Edit Client
  </h1>
  <ol class="breadcrumb">    
  </ol>
</section>
        <section class="content">         
          <div class="row">         
            <div class="col-xs-12">
            <div class="box">
               <div class="box-header with-border">
                    <h3 class="box-title"> Edit Client Information </h3>
                </div>
                  <form class="form-horizontal" method="POST" id="cc_rep" name="cc_rep">
                    <div class="box-body">
                     <div class="row">                      
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Client: </label>
                      <div class="col-md-6">                      
                      <input type="text" class="form-control" name="client_name" id="client_name" value="<?php echo $client_name; ?>" >
                      </div>                
                      </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email" class="control-label col-md-4">Branch:</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="client_branch" id="client_branch" value="<?php echo $client_branch; ?>" > 
                          </div>                
                        </div>
                      </div>
                      </div>
                      <input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
                      <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="amt" class="control-label col-md-4">Account:</label>
                             <div class="col-md-6">
                             <select class="form-control" name="client_account" id="client_account">
                               <option value="<?php echo "$client_account"; ?>"><?php echo "$client_account"; ?></option>
                               <option>WARRANTY</option>
                               <option>PMA</option>
                               <option>SERVICE</option>
                               <option>RENTAL</option>
                             </select>
                            </div>                
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="email" class="control-label col-md-4">Contact Person:</label>
                            <div class="col-md-6">
                             <input type="text" class="form-control" name="client_person" id="client_person" value="<?php echo $client_person; ?>" required>
                            </div>
                          </div>
                        </div>
                      </div>                     
                     <div class="row">                      
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Address: </label>
                      <div class="col-md-6">                     
                      <input type="text" class="form-control" name="client_address" id="client_address" value="<?php echo $client_address; ?>">
                      </div>                
                      </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email" class="control-label col-md-4">Contact Number:</label>
                          <div class="col-md-6">
                            <input type="text" class="form-control" name="client_contact_num" id="client_contact_num" value="<?php echo $client_contact_num; ?>"> 
                          </div>                
                        </div>
                      </div>
                      </div>
                      <div class="row">                      
                      <div class="col-md-6">
                      <div class="form-group">
                      <label for="customer" class="control-label col-md-4"> Contract Start: </label>
                      <div class="col-md-6">                  
                      <input type="date" class="form-control" name="client_contract_start" id="client_contract_start" value="<?php echo $client_contract_start; ?>" >
                      </div>                
                      </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="email" class="control-label col-md-4">Contract End:</label>
                          <div class="col-md-6">
                            <input type="date" class="form-control" name="client_contract_end" id="client_contract_end" value="<?php echo $client_contract_end; ?>"> 
                          </div>                
                        </div>
                      </div>
                      </div>
                    </div><!-- /.box-body -->  
                    <div class="box-footer">          
                     <input class="btn btn-success pull-right" id="submit" type="button" value="Save">
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
    $('#submit').click(function(){   
      
      var client_id = document.getElementById("client_id").value;
      var client_name = document.getElementById("client_name").value;        
      var client_branch = document.getElementById("client_branch").value;
      var client_address =  document.getElementById("client_address").value;
      var client_person = document.getElementById("client_person").value;
      var client_account = document.getElementById("client_account").value;
      var client_contact_num = document.getElementById("client_contact_num").value;
      var client_contract_start = document.getElementById("client_contract_start").value;
      var client_contract_end = document.getElementById("client_contract_end").value;
      var dataString = 'client_id=' + client_id + '&client_name=' + client_name + '&client_branch=' + client_branch + '&client_address=' + client_address + '&client_person=' + client_person +  '&client_account=' + client_account + '&client_contact_num=' + client_contact_num + '&client_contract_start=' + client_contract_start + '&client_contract_end=' + client_contract_end; 
      if (client_name == "" || client_branch == "" || client_address == "" ||  client_account == "") {
        alert("Please fill all fields!");
      } else  {
       $.ajax({  
              url:"save_edit_client.php",  
              method:"POST", 
              data: dataString,  
              success:function(data){
                   if (data.status == 'success'){
                       alert("Client Information was edited successfully!");
                       location.replace("clients.php");
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

</script>