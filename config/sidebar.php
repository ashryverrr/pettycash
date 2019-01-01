<section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../img/user.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>
                <?php
                      $username = $_SESSION['user_name'];
                      echo $username;
                ?>              
              </p>              
            </div>
          </div>
          <!-- search form -->
      
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"> MAIN NAVIGATION </li>
            <li>
              <a href="dashboard.php">
                <i class="fa fa-home"></i> <span>Dashboard</span>
              </a>
            </li>
            <li>
              <a href="reports.php">
                <i class="fa fa-history"></i> <span>Reports</span> 
              </a>
            </li>     
             <li>
              <a href="activity-reports.php">
                <i class="fa fa-list"></i> <span>List of Activity Reports</span> 
              </a>
            </li>
            <li>
              <a href="customer-calls.php">
                <i class="fa fa-list"></i> <span>List of Customer Calls</span> 
              </a>
            </li>
            <li>
              <a href="transactions.php">
                <i class="fa fa-list"></i> <span>List of Liquidation</span> 
              </a>
            </li>
      
             <li>
              <a href="clients.php">
                <i class="fa fa-user"></i> <span>Clients</span> 
              </a>
            </li>
             <li>
              <a href="employees.php">
                <i class="fa fa-users"></i> <span>Employees</span> 
              </a>
            </li>               
          </ul>
</section>
        <!-- /.sidebar -->