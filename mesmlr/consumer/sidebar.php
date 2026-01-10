 <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
 <aside class="main-sidebar" style="margin-top: <?php echo $sidebarmargin;?>px;">
        <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="overflow-x: scroll;">
          <!-- sidebar menu: : style can be found in sidebar.less -->

          <div class="user-panel">
        <div class="pull-left image">
          <img src="images/user.jpeg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['name'];?></p>
          <a href="#"><?php echo ucfirst($_SESSION['billing_method']);?> User</a>
        </div>
      </div>

          <ul class="sidebar-menu">
            
        <li class="header">Navigation Links</li>

        <li class= 'treeview'>
                <a href="dashboard.php">
                  <span>Dashboard</span> 
                </a>
        </li>

        <li class= 'treeview'>
                <a href="profile.php">
                  <span>My Profile</span> 
                </a>
        </li>
      
        <?php
        if ($_SESSION['billing_method'] != "postpaid") {
          ?>
            <li class= 'treeview'>
                    <a href="recharge.php">
                      <span>Recharge Account</span> 
                    </a>
            </li>
            <li class= 'treeview'>
                    <a href="recharge_history.php">
                      <span>Recharge History</span> 
                    </a>
            </li>
          <?php
        }
        ?>
        
        <li class= 'treeview'>
                <a href="logout.php">
                  <span>Logout</span> 
                </a>
        </li>
        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>