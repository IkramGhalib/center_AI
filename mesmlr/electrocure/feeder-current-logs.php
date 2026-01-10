<?php
  include_once('check.php');
  authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Feeder Current Logs"?>



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
      
      if ($filter ='0G0')
            {
                $query= "select fdid, name from feeder where datetime > now()-interval 24 hour";
        $result = $conn -> query($query) or die("Query error");
        foreach($result as $row){
       ?>
      <li>
                <a href="feeder-current-logs.php?filter=<?php echo $row['fdid'] ?>">
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
                <a href="feeder-current-logs.php?filter=0G0">
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
          
          //require_once("db/opendb.php");
                    if ($filter == '0G0')
                    {
          $query= "select fd_current_logs.*, feeder.mfactorvoltage, feeder.mfactorcurrent,feeder.name from fd_current_logs,feeder WHERE fd_current_logs.trid=feeder.fdid and fd_current_logs.datetime > DATE_SUB(CURDATE(), INTERVAL 1 DAY)  and (fdid = '1G1FD24' or fdid = '1G1FD30' or fdid = '1G1FD31') ORDER BY datetime DESC limit 1000";
                    }
                    else
                    {
                     $query= "select fd_current_logs.*, feeder.mfactorvoltage, feeder.mfactorcurrent,feeder.name from fd_current_logs,feeder WHERE fd_current_logs.trid=feeder.fdid and fd_current_logs.datetime > DATE_SUB(CURDATE(), INTERVAL 1 DAY) and fdid = '".$filter."' ORDER BY datetime DESC limit 1000";
   
                    }
          $result = $conn -> query($query) or die("Query error");
              
            ?>
      
      <div id="overflow">
       <table id="example1" class="table table-responsive table-bordered table-striped">
    <thead class="bg-blue">
          <tr>
              <th scope="col">Feeder ID</th>
              <th scope="col">Feeder Name</th>
              <th scope="col">v1 (KV)</th>
              <th scope="col">v2 (KV)</th>
              <th scope="col">v3 (KV)</th>
              <th scope="col">pf1</th>
              <th scope="col">pf2</th>
              <th scope="col">pf3</th>
              <th scope="col">kva1</th>
              <th scope="col">kva2</th>
              <th scope="col">kva3</th>
              <th scope="col">Total Kva</th>              
              <th scope="col">c1</th>
              <th scope="col">c2</th>
              <th scope="col">c3</th>
              <th scope="col">Date & Time</th>
              
        </tr>
                    </thead>
         
         
                    <tbody>
                      
           <?php
            foreach($result as $row){
                            
                            if($row['pf1']<0.5)
                               $pf1 = 'NC';
                            else
                                $pf1 = $row['pf1'];
                            if($row['pf2']<0.5)
                               $pf2 = 'NC';
                            else
                                $pf2 = $row['pf2'];
                            if($row['pf3']<0.5)
                               $pf3 = 'NC';
                            else
                               $pf3 = $row['pf3'];
            ?>
            
            <tr>
              <td><?php echo $row ['trid'];  ?></td>
                          <td><?php echo $row ['name'];  ?></td>
              <td><?php echo round($row ['v1'] *$row ['mfactorvoltage']*1.732/1000,2);  ?></td>
              <td><?php echo round($row ['v2'] *$row ['mfactorvoltage']*1.732/1000,2);  ?></td>
              <td><?php echo round($row ['v3'] *$row ['mfactorvoltage']*1.732/1000,2);  ?></td>
              <td><?php echo $row ['pf1'];  ?></td>
              <td><?php echo $row ['pf2'];  ?></td>
              <td><?php echo $row ['pf3'];  ?></td>
              <td><?php echo round($row ['v1'] *$row ['mfactorvoltage']*1.732 * $row ['B1U'] *$row ['mfactorcurrent']/1000,2);  ?></td>
              <td><?php echo round($row ['v2'] *$row ['mfactorvoltage']*1.732 * $row ['B1M'] *$row ['mfactorcurrent']/1000,2);  ?></td>
              <td><?php echo round($row ['v3'] *$row ['mfactorvoltage']*1.732 * $row ['B1L'] *$row ['mfactorcurrent']/1000,2);  ?></td>
              <td><?php echo round(($row ['v1'] *$row ['mfactorvoltage']*1.732 * $row ['B1U'] *$row ['mfactorcurrent']/1000) + ($row ['v2'] *$row ['mfactorvoltage']*1.732 * $row ['B1M'] *$row ['mfactorcurrent']/1000)+ ($row ['v3'] *$row ['mfactorvoltage']*1.732 * $row ['B1L'] *$row ['mfactorcurrent']/1000),2);  ?></td>
              <td><?php echo $row ['B1U'] *$row ['mfactorcurrent'];  ?></td>
              <td><?php echo $row ['B1M'] *$row ['mfactorcurrent'];  ?></td>
              <td><?php echo $row ['B1L'] *$row ['mfactorcurrent']; ?></td>
              
              <td><?php echo $row ['datetime'];  ?></td>
              
        </tr>
            
                      <?php } ?>
            
                    </tbody>
                    <tfoot class="bg-blue">
                      <tr>
              <th scope="col">Feeder ID</th>
                          <th scope="col">Feeder Name</th>
              <th scope="col">v1 (KV)</th>
              <th scope="col">v2 (KV)</th>
              <th scope="col">v3 (KV)</th>
              <th scope="col">pf1</th>
              <th scope="col">pf2</th>
              <th scope="col">pf3</th>
              <th scope="col">kva1</th>
              <th scope="col">kva2</th>
              <th scope="col">kva3</th>
              <th scope="col">Total Kva</th>              
              <th scope="col">c1</th>
              <th scope="col">c2</th>
              <th scope="col">c3</th>
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
<!-- ./wrapper -->
<?php include_once('script.php') ?>
</body>

    <script>
   
    $(function () {
    $('#example1').DataTable(
        {
            'order': [[ 15, "desc" ]],
           'pageLength': 17
        })
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
</html>
