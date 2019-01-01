<!-- Logo -->
        <a href="#" class="logo">
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
                  <img src="../img/user.png" class="user-image" alt="User Image">
                  <span class="hidden-xs">
                    <?php
                      $username = $_SESSION['user_name'];
                      echo $username;

                    ?>
                  </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../img/user.png" class="img-circle" alt="User Image">
                    <p>
                      <?php
                      $username = $_SESSION['user_name'];
                      echo $username;

                    ?>
                    </p>
                  </li> 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#myModal">Change Password</a>
                    </div>
                    <div class="pull-right">
                      <a href="../logout.php" class="btn btn-primary btn-flat">Sign out</a>
                    </div>         
                  </li>
                </ul>
              </li>          
            </ul>
          </div>
        </nav>

     <!-- MODAL START  -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
          <div class="modal-dialog  modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancel</span></button>
                <h4 class="modal-title" id="myModalLabel">Change Password</h4>
              </div>
              <div class="modal-body">
               <input class="form-control" type="password" id="change_user_password_old" name="change_user_password_old" placeholder="Old Password" required>
               <br>
              <input class="form-control" type="password" id="change_user_password_new" name="change_user_password_new" placeholder="New Password" required>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="changeUserPassword();">Save</button>
              </div>
            </div>
          </div>
        </div>
        <!-- MODAL END-->

