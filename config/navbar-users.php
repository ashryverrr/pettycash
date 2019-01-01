<section class="sidebar" id="doNOTprint">
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
          <ul class="sidebar-menu">
            <li class="header"> MAIN NAVIGATION </li>
            <li>
              <a href="home.php">
                <i class="fa fa-home"></i> <span>Home</span>
              </a>
            </li>
              <li>
              <a href="reports.php">
              <i class="fa fa-history"></i> <span>Reports</span>
              </a>
            </li>
            <li>
              <a href="petty-form.php">
                <i class="fa fa-list-alt"></i> <span>Create Liquidation</span>
              </a>
            </li>
            <li>
              <a href="create-activity-report.php">
                <i class="fa fa-list-alt"></i> <span>Create Activity Report</span>
              </a>
            </li>
            <li>
              <a href="create-remittance-report.php">
                <i class="fa fa-list-alt"></i> <span>Create Remittance Report</span>
              </a>
            </li>
            <li>
              <a href="activity-reports.php">
                <i class="fa fa-list"></i> <span>List of Activity Reports</span>
              </a>
            </li>
            <li>
              <a href="customer-call.php">
                <i class="fa fa-list"></i> <span>List of Customer Calls</span>
              </a>
            </li>
            <li>
              <a href="petty-cash.php">
                <i class="fa fa-list"></i> <span>List of Liquidation</span>
              </a>
            </li>
            <li>
              <a href="remittance-report.php">
                <i class="fa fa-list"></i> <span>List of Remittances</span>
              </a>
            </li>           
                
     
                    
          </ul>
</section>
        