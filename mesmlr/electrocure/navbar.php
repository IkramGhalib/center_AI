<?php
require 'Mobile_Detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');

if ($detect->isMobile() or $detect->isTablet()) {
  $contentmargin = 0;
  $sidebarmargin = 0;
  ?>
   <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../../index2.html" class="navbar-brand"><b>Electrocure</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
<?php
}else{
  
      $contentmargin = 40;
      $sidebarmargin = 110;
    ?>

    <header class="main-header">
    <!-- Logo -->
  
    <img src="images/header.jpg" id="header_image" width="100%" height="90px">
    <a href="feeder_dashboard.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Electrocure</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->

     <nav class="navbar navbar-inverse">
        <div class="container-fluid">

       
      <?php    
}
?>
      <ul class="nav navbar-nav">
         <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Dashboard
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="feeder_dashboard.php">Infeeder Dashboard</a></li>
            <li><a href="outfeeder_dashboard.php?id=0G0&status=all">Outfeeder Dashboard</a></li>
            <li><a href="transformer_dashboard.php?id=0G0&status=all">Transformer Dashboard</a></li>
            <li><a href="db_dashboard.php?id=0G0&status=all">Distribution Box Dashboard</a></li>
          </ul>
          </li>

          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"> In Feeders
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="feeder-list.php?filter=0G0">In Feeders List</a></li>
            <li><a href="feeder-current-logs.php?filter=0G0">In Feeders Current Logs</a></li>
            <!-- <li><a href="feeder-kwh-logs.php?filter=0G0">In Feeders Consumption Logs</a></li> -->
          </ul>
          </li>

         <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Out Feeders
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="outfeeder_list.php?filter=0G0">Out Feeders List</a></li>
            <li><a href="outfeeder-current-logs.php?filter=0G0">Out Feeders Current Logs</a></li>
            <!-- <li><a href="outfeeder-kwh-logs.php?filter=0G0">Out Feeders Consumption Logs</a></li> -->
          </ul>
          </li>
          
          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Transformers
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="transformer-list.php?filter=0G0">Transformers List</a></li>
            <li><a href="transformer-current-logs.php?filter=0G0">Transformers Current Logs</a></li>
            <li><a href="transformer-kwh-logs.php?filter=0G0">Transformer Consumption Logs</a></li>
            <!-- <li><a href="old_data_entry.php">Comparison Data Entry (OLD)</a></li>
            <li><a href="pesco_data_entry.php">Comparison Data Entry</a></li>
            <li><a href="comparison.php">KWH Comparison Graph</a></li> -->

          </ul>
          </li>

          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Distribution Boxes
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="db-list.php?filter=0G0">Distribution Boxes List</a></li>
            <li><a href="db-current-logs.php?filter=0G0">Distribution Boxes Current Logs</a></li>
            <li><a href="db-kwh-logs.php?filter=0G0">Distribution Consumption Logs</a></li>
          </ul>
          </li>
           <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Connections
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="connection-list.php?filter=0G0">Connection List</a></li>
            <li><a href="connection-current-logs.php?filter=0G0">Customer Current Logs</a></li>
            <li><a href="assign_customer.php">Assign Connections to Consumers</a></li>
            <li><a href="connection-kwh-logs.php?filter=0G0">Customer Consumption Logs</a></li>
          </ul>
          </li>

         <!-- <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Faults
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="feeder_faults.php">Infeeder Faults</a></li>
            <li><a href="outfeeder_faults.php">Outfeeder Faults</a></li>
            <li><a href="transformer_faults.php">Transformer Faults</a></li>
            <li><a href="db_faults.php">Distribution Box Faults</a></li>
            <li><a href="connection_faults.php">Connection Faults</a></li>
          </ul>
          </li> -->
          
          <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Maps
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="transformers_map.php">Transformers Map</a></li>
            <!-- <li><a href="db_map.php">Distribution Box Map</a></li> -->
          </ul>
          </li>
          <!-- <li><a href="performance_check.php">Performance</a></li> -->
          
          <li><a href="logout.php">Log Out</a></li>
        </ul>

<?php 
        if ($detect->isMobile() or $detect->isTablet()) {
?>
 </div>
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <?php

        }else{
          ?>

           </div>
      </nav>
  </header>
          <?php
        }


?>