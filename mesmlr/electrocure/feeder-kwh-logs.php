<?php
  include_once('check.php');
  authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Feeder Consumption Logs"?>



  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $pageName;?></title>
  
 <?php include_once('head.php') ?> 
 
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue sidebar-mini" >
<!-- Site wrapper -->
<div class="wrapper" style="overflow: hidden;">
	
	
	<!-- Navbar -->
	<?php include_once('navbar.php') ?>
	<!-- Sidebar -->
	
  <aside class="main-sidebar" style="margin-top: <?php echo $sidebarmargin;?>px;">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            
        
      <?php

      require_once("opendb.php"); 
      $filter = $_GET['filter'];
      
      
      //if($page_type == "Feeder"){
        
      //}
      
      if ($filter ='0G0')
            {
                $query= "select fdid,name from feeder where datetime > now()-interval 24 hour";
        $result = $conn -> query($query) or die("Query error");
        foreach($result as $row){
       ?>
      <li>
                <a href="feeder-kwh-logs.php?filter=<?php echo $row['fdid'] ?>">
                  <i class="fa fa-dashboard"></i> <span><?php echo($row['name'])?></span> 
                </a>
        </li>



    <?php
      }
            }
              else
              {
                   $query= "select fdid, name from feeder where datetime > now()-interval 24 hour where fdid = '".$filter."'";
            $result = $conn -> query($query) or die("Query error");
                  foreach($result as $row){
       ?>
      <li>
                <a href="feeder-kwh-logs.php?filter=0G0">
                  <i class="fa fa-dashboard"></i> <span><?php echo($row['name'])?> <u>clear</u></span> 
                </a>
        </li>

              <?php
                  
              }
              }
        
    ?>      
      </ul>
       
      </section>
        <!-- /.sidebar -->
      </aside>



  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  
  <div class="content-wrapper" style="margin-top: <?php echo $contentmargin?>px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <b><?php echo $pageName;?></b>
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageName;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
       <?php
          
        //  require_once("db/opendb.php"); 
          if ($filter == '0G0')
                    {
          $query= "select fd_kwh_logs.*, feeder.name from fd_kwh_logs,feeder WHERE fd_kwh_logs.trid = feeder.fdid and fd_kwh_logs.Datetime > DATE_SUB(CURDATE(), INTERVAL 1 DAY) ORDER BY Datetime DESC limit 1000";
                    }
                    else
                    {
                     $query= "select fd_kwh_logs.*, feeder.name from fd_kwh_logs,feeder WHERE fd_kwh_logs.trid = feeder.fdid and fd_kwh_logs.Datetime > DATE_SUB(CURDATE(), INTERVAL 1 DAY) and fdid = '".$filter."' ORDER BY Datetime DESC";
   
                    }
          $result = $conn -> query($query) or die("Query error");
              
            ?>
      
      <div id="overflow">
       <table id="example1" class="table table-responsive table-bordered table-striped">
      <thead class="bg-blue">
        <tr>
              <th scope="col">Feeder ID</th>
              <th scope="col">Feeder Name</th>
              <th scope="col">Off Peak</th>
              <th scope="col">Peak</th>
              <th scope="col">pkunits</th>
              <th scope="col">Date & Time</th>
              
        </tr>
      </thead>
      <tbody>
                      
           <?php
            foreach($result as $row){
            ?>
            
            <tr>
              <td><?php echo $row ['trid'];  ?></td>
              <td><?php echo $row ['name'];  ?></td>
              <td><?php echo $row ['offpeak'];  ?></td>
              <td><?php echo $row ['peak'];  ?></td>
              <td><?php echo $row ['pkunits'];  ?></td>
              <td><?php echo $row ['Datetime'];  ?></td>
             
        </tr>
            
                      <?php } ?>
            
                    </tbody>
          <tfoot class="bg-blue">
            <tr>
              <th scope="col">Feeder ID</th>
              <th scope="col">Feeder Name</th>
              <th scope="col">Off Peak</th>
              <th scope="col">Peak</th>
              <th scope="col">pkunits</th>
              <th scope="col">Date & Time</th>
              
        </tr>

          </tfoot>
                  </table>
      </div>

  <?php $conn= NULL; ?>
    
  

      
    </section>

    <!-- /.content -->


   
  </div>
  <!-- /.content-wrapper -->
  
	<?php include_once('footer.php') ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<script>
    $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
    })
    })
</script>
<!-- ./wrapper -->
<?php include_once('script.php') ?>
</body>
</html>
