<?php
require_once 'config/connection.php';
session_start();

if (isset($_SESSION['user_type'])) {
  if($_SESSION['user_type'] == "SUPERVISOR"){
    header('Location: admin/dashboard.php');
  } else if ($_SESSION['user_type'] == "TECHNICIAN") {
    header('Location: user/home.php');
  } else {

  }
}

if (isset($_POST['submit'])) {
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = :username AND password = :password ";
$stmt = $pdo -> prepare($sql);
$stmt -> bindParam(':username', $username);
$stmt -> bindParam(':password', $password);   
$stmt -> execute();
$count_row = $stmt -> rowCount();

if ($count_row > 0) {
  
  $row = $stmt -> fetch(PDO::FETCH_ASSOC);  

  for ($i=0; $i < $count_row; $i++) { 
    $user_role = $row['user_role'];
    $user_id = $row['user_id'];
    $emp_name = $row['emp_name'];
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $emp_name;
    
    $log_desc = "Logged in.";

    if ($user_role == 'SUPERVISOR') {
      $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
      $stmt = $pdo -> prepare($sql);
      $stmt -> bindParam(':uid', $user_id);
      $stmt -> bindParam(':log_desc', $log_desc);
      $stmt -> execute();
      $_SESSION['user_type'] = $user_role;
      header('Location: admin/dashboard.php');
      
    } else if ($user_role == 'TECHNICIAN') {    
      $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
      $stmt = $pdo -> prepare($sql);
      $stmt -> bindParam(':uid', $user_id);
      $stmt -> bindParam(':log_desc', $log_desc);
      $stmt -> execute();      
      $_SESSION['user_type'] = $user_role;
      header('Location: user/home.php');

    } else if ($user_role == 'ACCOUNTING') {
      $sql = "INSERT INTO petty_log (user, log_desc) VALUES (:uid, :log_desc) ";
      $stmt = $pdo -> prepare($sql);
      $stmt -> bindParam(':uid', $user_id);
      $stmt -> bindParam(':log_desc', $log_desc);
      $stmt -> execute();      
      $_SESSION['user_type'] = $user_role;
      header('Location: acct/home.php');

    } else {
      echo "<script> alert('ERROR! ACCOUNT IS NOT VALID.') </script>";
    }
  }
  
} else {
  $error = "ERROR";
}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CYBER FRONTIER | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">   
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.css">
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="index.php"><b>CYBER</b>Frontier</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in to Petty Cash System</p>
        <form class="login-form" method="POST" action="">
          <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>
        <div class="social-auth-links text-center">
        <?php 
        if (isset($error)) {
          echo "
            <p class='text-danger message'> Username or password is incorrect. </p>
          ";
          }
        ?>    
        </div><!-- /.social-auth-links -->

        <!-- START 
        <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a>
        <!-- ENDING -->
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="js/bootstrap.min.js"> </script>

  </body>
</html>
