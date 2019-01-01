<?php
require_once '../config/connection.php';
require_once '../config/validate_user.php';
$sql = "SELECT petty_log.log_id, petty_log.log_date, petty_log.log_desc, users.emp_name AS emp_id FROM petty_log LEFT JOIN users ON users.user_id = petty_log.user ORDER BY petty_log.log_date desc ";
$stmt = $pdo ->prepare($sql);
$stmt -> execute();
$item_per_page = 3;
$get_total_rows = $stmt -> rowCount();
$pages = ceil($get_total_rows / $item_per_page);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cyber Frontier | Dashboard</title>
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
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">   
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Activity Log</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tr>
                      <th style="width: 20px">#</th>
                      <th style="width: 250px">User</th>
                      <th style="width: 150px">Date</th>
                      <th>Activity</th>
                    </tr>      
                    <tbody id="results">
                    </tbody>              
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <ul class="pagination pagination-sm no-margin pull-right">
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- 1ST row -->
          <div class="row">
          <div class="col-md-6">
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Add Client</h3>
                  </div>
                  <!-- form start -->
                  <form class="form-horizontal">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="emp_name" class="col-sm-4 control-label">Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="client_name" id="client_name" onchange="checkString();" placeholder="Name of the Client">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="branch" class="col-sm-4 control-label">Branch</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Branch Name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Account</label>
                        <div class="col-sm-8">
                        <select class="form-control" id="client_type" name="client_type">
                          <option>WARRANTY</option>
                          <option>PMA</option>
                          <option>CHARGE</option>                          
                          <option>RENTAL</option>
                          <option>DEMO</option>                          
                          <option>NONE</option> 
                        </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Contact Person</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="client_person" name="client_person" placeholder="Contact Person">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label">Contact Number</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="client_contact_num" name="client_contact_num" placeholder="Contact Number">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="client_address" class="col-sm-4 control-label">Address</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="client_address" placeholder="Address of the Client">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="contract_start" class="col-sm-4 control-label">Contract Start</label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control" placeholder="YY-MM-DD" id="contract_start">
                        </div>
                      </div>  
                      <div class="form-group">
                        <label for="contract_end" class="col-sm-4 control-label">Contract End</label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control" placeholder="YY-MM-DD" id="contract_end">
                        </div>
                      </div>                    
                    </div><!-- /.box-body -->
                    <div class="box-footer">              
                       <input id="submit" onclick="saveClient()" type="button" value="Submit" class="btn btn-info pull-right">
                    </div><!-- /.box-footer -->
                  </form>
                </div><!-- /.box -->
          </div> <!-- END DIV -->
            <!-- Left col -->                       
             <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Add Employee</h3>
                  </div><!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="emp_name" class="col-sm-4 control-label">Name</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="emp_name_user" placeholder="Employee Name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="emp_name" class="col-sm-4 control-label">Username</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="emp_name_username" placeholder="Username" name="emp_name_username">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="passowrd" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="password_user" placeholder="Password" name="password_user">
                        </div>
                      </div>                   
                      <div class="form-group">
                        <label for="passowrd" class="col-sm-4 control-label">Position</label>
                        <div class="col-sm-8">
                        <select class="form-control" name="account_type" id="account_type">
                          <option>TECHNICIAN</option>
                          <option>ACCOUNTING</option>
                          <option>SUPERVISOR</option>
                        </select>
                        </div>
                      </div>        
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                    <button id="submit" onclick="saveUser()" type="button" class="btn btn-info pull-right"> Save User </button>
                    </div><!-- /.box-footer -->
                  </form>
                </div><!-- /.box -->
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">Set Password for Authentication</h3>
                  </div><!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="emp_name" class="col-sm-4 control-label">Old Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="old_pass_auth" placeholder="Old Password">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="emp_name" class="col-sm-4 control-label">New Password</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="new_pass_auth" placeholder="New Password" name="new_pass_auth">
                        </div>
                      </div>                                  
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                    <button id="submit" onclick="changeAuth();" type="button" class="btn btn-info pull-right"> Change Password </button>
                    </div><!-- /.box-footer -->
                  </form>
                </div><!-- /.box -->
          </div> <!-- END DIV -->     
        </div> <!-- END FIRST ROW -->
        <div class="row">
          <div class="col-md-6">
            <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Liquidation Form</h3>
                  </div><!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal" class="searchable">
                    <div class="box-body">                      
                      <div class="form-group">
                        <label for="emp_name" class="col-sm-4 control-label">Employee</label>
                        <div class="col-sm-8">
                         <select class="form-control emp-pcl" id="empname" name="empname" required>
                           <option id="" name=" " placeholder="Select Employee"> </option>
                           <?php
                              $sql = "SELECT user_id, emp_name FROM users ORDER BY emp_name asc";
                              $stmt = $pdo -> prepare($sql);
                              $stmt -> execute();
                              $countrow = $stmt -> rowCount();
                              if ($countrow > 0) {
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                                  $emp_id = $row['user_id'];
                                  $emp_name = $row['emp_name'];
                                  echo "<option value='$emp_id'> $emp_name </option>"; 
                                }
                              } else {
                                echo "<option> There are no users registered. </option>";
                              }
                           ?>
                         </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="passowrd" class="col-sm-4 control-label">CC#/ DR#</label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" name="ccnum" id="ccnum" placeholder="CC# / DR#" onchange="checkForCC();" required>
                        </div>
                      </div>  
                      <div class="form-group" id="hide_me">
                        <label for="amount" class="col-sm-4 control-label">Others</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="others" placeholder="DR# / AR #" name="others">
                        </div>
                      </div>                
                      <div class="form-group">
                        <label for="amount" class="col-sm-4 control-label">Amount</label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" id="amt" placeholder="Amount if given" name="amt" value="0">
                        </div>
                      </div>  
                      <div class="form-group">
                        <label for="date" class="col-sm-4 control-label">Date</label>
                        <div class="col-sm-8">
                          <input type="date" name="trans_date" class="form-control" id="trans_date" value="<?php echo date('Y-m-d'); ?>" placeholder="YY-MM-DD" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-4"> Client </label>
                        <div class="col-sm-8">         
                        <select class="form-control js-example-basic-multiple" name="clientSelect[]" id='clientSelect' multiple="multiple">
                          <?php
                            $sql = "SELECT client_id, client_name, client_branch, client_account FROM clients ORDER BY client_name asc, client_branch asc";
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
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                     <input id="submit" onclick="myFunction()" name="submit" type="button" value="Submit" class="btn btn-info pull-right">
                    </div><!-- /.box-footer -->
                  </form>
            </div><!-- /.box -->
          </div>
          <div class="col-md-6">
            <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title">Assign CC</h3>
                  </div><!-- /.box-header -->
                  <!-- form start -->
                  <form class="form-horizontal">
                    <div class="box-body">                      
                      <div class="form-group">
                        <label for="emp_name" class="col-sm-4 control-label">Employee</label>
                        <div class="col-sm-8">
                         <select class="form-control acc-emp" id="cc_emp_id" name="cc_emp_id" required>
                           <option placeholder="Select Employee"> </option>
                           <?php
                              $sql = "SELECT user_id, emp_name FROM users ORDER BY emp_name asc";
                              $stmt = $pdo -> prepare($sql);
                              $stmt -> execute();
                              $countrow = $stmt -> rowCount();
                              if ($countrow > 0) {
                                while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                                  $emp_id = $row['user_id'];
                                  $emp_name = $row['emp_name'];
                                  echo "<option value='$emp_id'> $emp_name </option>"; 
                                }
                              } else {
                                echo "<option> There are no users registered. </option>";
                              }
                           ?>
                         </select>
                        </div>
                      </div>                   
                      <div class="form-group">
                        <label for="" class="col-sm-4 control-label">From</label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" name="cc_num_start" id="cc_num_start" placeholder="Start of CC" required>
                        </div>
                      </div>                  
                      <div class="form-group">
                        <label for="" class="col-sm-4 control-label">To</label>
                        <div class="col-sm-8">
                          <input type="number" class="form-control" name="cc_num_end" id="cc_num_end" placeholder="End of CC" required>
                        </div>
                      </div>                       
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                      <button id="submit" onclick="assignCC()" type="button" class="btn btn-info pull-right"> Assign CC </button>
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
    </div><!-- ./wrapper -->
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
  </body>
</html>
<script type="text/javascript">
$(document).ready(function(){      
      $("#hide_me").hide();
});

function changeAuth(){
  var old_pass_auth = document.getElementById("old_pass_auth").value;
  var new_pass_auth = document.getElementById("new_pass_auth").value;
  var dataString = 'old_pass_auth=' + old_pass_auth + '&new_pass_auth=' + new_pass_auth;
    if (old_pass_auth == '' || new_pass_auth == '') {
      alert("Please fill all fields!");
    } else {
        $.ajax({
      type: "POST",
      url: "change_password_auth.php",
      data: dataString,
      cache: false,
      success: function(data) {  
         if (data.status == 'success'){
              alert("Password was changed.");
              window.location.reload(true);
         } else if(data.status == 'wrong'){
              alert("Password does not match!");
         } else {
              alert("Code error.");
         }
      }
    });  
  }
}
function checkForCC(){
  var cc_input = document.getElementById("ccnum").value;
  if (cc_input == '0000') {
     $("#hide_me").show();
  }else {
     $("#hide_me").hide();
  }
}
function myFunction() {
  var empname = document.getElementById("empname").value;
  var ccnum = document.getElementById("ccnum").value;
  var amount = document.getElementById("amt").value;
  var trans_date = document.getElementById("trans_date").value; 
  var others = document.getElementById("others").value;
  var client = $('#clientSelect').val(); 
  var dataString = 'empname=' + empname + '&ccnum=' + ccnum + '&trans_date=' + trans_date + '&amount=' + amt + '&client=' + client + '&others=' + others;  
  if (empname == '' || ccnum == '' || amount =='' || trans_date == '' || client == '') {
    alert("Please fill all fields.");  
  } else {
   $.ajax({
      type: "POST",
      url: "save__petty.php",
      data: dataString,
      cache: false,
      success: function(data) {  
         if (data.status == 'success'){
              alert("Added! Please fill in the details of the transaction.");
              window.location.replace("submit_petty_form.php");
         } else if(data.status == 'exist'){
              alert("CC# already exists in the database. Please check and try again!");
         } else if(data.status == 'error'){
              alert("Something went wrong!");
         }
      }
  });  
  }  
  return false;
}
function saveUser() {
  var empname = document.getElementById("emp_name_user").value;
  var password_user = document.getElementById("password_user").value;
  var emp_name_username = document.getElementById("emp_name_username").value;
  var account_type = document.getElementById("account_type").value;
  var dataString = 'empname=' + empname + '&password_user=' + password_user + '&emp_name_username=' + emp_name_username + '&account_type=' + account_type ;  
  if (empname == '' || password_user == '' || account_type == '' || emp_name_username == '') {
    alert('Please fill all fields.');
  } else {
  $.ajax({
  type: "POST",
  url: "save_user.php",
  data: dataString,
  cache: false,
  success: function(data) {  
         if (data.status == 'success'){
              alert("New user was added successfully.");
              window.location.reload(true);
         } else if(data.status == 'error'){
              alert("Query was not executed successfully.");
         } else if(data.status == 'exist'){
              alert("Username or Employee already exists in the database.");
         } else {
              alert("Something went wrong!");
         }
  }
  });
  }  
  return false;
}

function checkString(){
  var client_name = document.getElementById("client_name").value;
  var specialChar = new RegExp(/(['"])/g);
  var btn = document.getElementById("submit");
  //var regex = /^[a-zA-Z0-9!@#$%\^&*)(+=._-]*$/;
  
  if (specialChar.test(client_name)) {
      alert("Please remove the ' or \"!");
      btn.disabled = true;
  } else {
      btn.disabled = false;
  }
}


function saveClient() {
  var client_name = document.getElementById("client_name").value;
  var branch_name = document.getElementById("branch_name").value;
  var client_person = document.getElementById("client_person").value;
  var client_type = document.getElementById("client_type").value;
  var client_contact_num = document.getElementById("client_contact_num").value;
  var client_address = document.getElementById("client_address").value;
  var contract_start = document.getElementById("contract_start").value;
  var contract_end = document.getElementById("contract_end").value;

  var dataString = 'client_name=' + client_name + '&branch_name=' + branch_name + '&client_type=' + client_type + '&client_contact_num=' + client_contact_num + '&client_address=' + client_address + '&contract_start=' + contract_start + '&contract_end=' + contract_end + '&client_person=' + client_person;
  if (client_name == '' || branch_name == '' || client_type == '' || client_address == '') {
    alert('Please fill all fields.');
  } else {
  $.ajax({
  type: "POST",
  url: "save_client.php",
  data: dataString,
  cache: false,
  success: function(data) {
     if (data.status == 'success'){
          alert("Client was added successfully.");
          window.location.reload(true);
     } else if(data.status == 'error'){
          alert("Query was not executed successfully.");
     } else if(data.status == 'exist'){
          alert("Client already exist in the database.");
     } else {
       alert("Something went wrong, you might have entered an invalid character! Please check and try again.");
     }
  },
  });
  }  
  return false;
}
function assignCC() {
  var cc_emp_id = document.getElementById("cc_emp_id").value;
  var cc_num_start = document.getElementById("cc_num_start").value;
  var cc_num_end = document.getElementById("cc_num_end").value;
  var dataString = 'cc_emp_id=' + cc_emp_id + '&cc_num_start=' + cc_num_start + '&cc_num_end=' + cc_num_end ;  
  if (cc_emp_id == '' || cc_num_start =='' || cc_num_end == '') {
    alert("Please fill all fields.");  
  } else {
   $.ajax({
      type: "POST",
      url: "save_cc.php",
      data: dataString,
      cache: false,
      success: function(data) {  
         if (data.status == 'success'){
              alert("CC Numbers was successfully assigned!");
              window.location.reload(true);
         } else if(data.status == 'exist'){
              alert("There is a conflict in the CC# that you entered. Please check and try again!");
         } else if(data.status == 'error'){
              alert("Something went wrong!");
         }
      }
  });  
  }  
  return false;
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

$(document).ready(function() {
  $("#results").load("fetch_activity_log.php");  //initial page number to load
  $(".pagination").bootpag({
     total: <?php echo $pages; ?>,
     page: 1,
     maxVisible: 3
  }).on("page", function(e, num){
    e.preventDefault(); 
    $("#results").load("fetch_activity_log.php", {'page':num});
  });
});

$(".js-example-basic-multiple").select2();
$(".emp-pcl").select2();
$(".acc-emp").select2();
$(".report-client").select2();
$(".report-employee").select2();
</script>
