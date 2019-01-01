<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cyber Frontier | Dashboard</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">  
    <script src="..\js\jquery.min.js"></script>
    <script src="..\js\bootstrap.min.js"> </script>
  </head>
  <body class="hold-transition skin-black sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>C</b>YB</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Cyber</b>Frontier</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                  <span class="hidden-xs">Bryan Chua</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    <p>
                      Bryan Chua - Web Developer
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li> 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>          
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Bryan Chua</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li>
              <a href="pages/widgets.html">
                <i class="fa fa-home"></i> <span>Dashboard</span>
              </a>
            </li>
            <li>
              <a href="pages/widgets.html">
                <i class="fa fa-list-alt"></i> <span>Transactions</span> 
              </a>
            </li>
             <li>
              <a href="pages/widgets.html">
                <i class="fa fa-user"></i> <span>Customers</span> 
              </a>
            </li>
             <li>
              <a href="pages/widgets.html">
                <i class="fa fa-users"></i> <span>Employees</span> 
              </a>
            </li>         
          </ul>
        </section>
        <!-- /.sidebar -->
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
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->                       
           <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                  <h3 class="box-title">List of Petty Cash </h3>    
                  <br><br>
                  <div class="form-group">
                       <div class="input-group">  
                            <span class="input-group-addon">Search</span>  
                            <input type="text" name="search_text" id="search_text" placeholder="Search by Customer Name, CC# or DR#" class="form-control" />  
                       </div>  
                  </div> 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered table-striped" id="result">
                    <thead>
                      <tr>
                          <th> # </th>
                          <th> EMPLOYEE  </th>
                          <th> CUSTOMER </th>
                          <th> CC# / DR# </th>
                          <th> DATE</th>
                          <th class="success"> STATUS</th>          
                          <th class="info"> MODIFY </th>
                          <th class="danger"> DELETE  </th>     
                      </tr>
                    </thead>
                    <tbody>     
                         <?php require 'fetch_transactions.php' ?>                           
                    </tbody>
                    <tfoot>
                      <tr>
                          <th> # </th>
                          <th> EMPLOYEE  </th>
                          <th> CUSTOMER </th>
                          <th> CC# / DR# </th>
                          <th> DATE</th>
                          <th class="success"> STATUS</th>          
                          <th class="info"> MODIFY </th>
                          <th class="danger"> DELETE  </th>    
                      </tr>
                    </tfoot>                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

            </div>
           
              </div>
            </section><!-- right col -->

          </div><!-- /.row (main row) -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
      </footer>
      
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->


    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
  </body>
</html>

<script>  
 $(document).ready(function(){  
      $('#search_text').keyup(function(){  
           var txt = $(this).val();  
           if(txt != '') {  
                $.ajax({  
                     url:"fetch2.php",  
                     method:"post",  
                     data:{search:txt},  
                     dataType:"text",  
                     success:function(data)  
                     {  
                          $('#result').html(data);  
                     }  
                });  
           }  
           else  {  
           $.ajax({  
                url:"fetch2.php",  
                method:"post",  
                data:{search:txt},  
                dataType:"text", 
                success:function(data)  {  
                    $('#result').html(data);  
                }  
            });             
           }  
      });  
 }); 
</script>  


