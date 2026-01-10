<?php
  include_once('check.php');
  authenticate("view");
?>

<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Transformer Consumption Logs"?>



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
    <section class="sidebar" style="overflow-x: scroll;">
          <!-- sidebar menu: : style can be found in sidebar.less -->
         
      <ul class="sidebar-menu">
            <form id="sidebarform" method="post">
        <li class="header">Select Specific Transformer</li>
        <br>
          <?php if (!$detect->isMobile() and !$detect->isTablet()) {

          require_once("opendb.php");
          $query = "select trid, name from transformer";
          $result = $conn -> query($query) or die("Query error");
          ?>

          <input type="text" list="transformers" name="transformer" placeholder="Select Transformer" class="form-control">
          <datalist id="transformers">
            <?php
            foreach ($result as $row) {
              echo "<option value=".$row['trid'].">".$row['name']."</option>";
            }
            ?>
            
          </datalist>

          

          <br>
          <div style="color: #FFFFFF"><b>Date and Time From:</b></div>
            
          <input type="date" id="fromdate" name="fromdate" class="form-control" placeholder="Logs From">
          <input type="time" id="fromtime" name="fromtime" class="form-control" placeholder="Logs From">
          <br>
          <div style="color: #FFFFFF"><b>Date and Time To:</b></div>
          <input type="date" id="todate" name="todate" class="form-control" placeholder="Logs to">
          <input type="time" id="totime" name="totime" class="form-control" placeholder="Logs to">

          <br>
          <button style="float: right; margin-right:5px; " class="btn-primary btn" name="submit"> Submit </button>

        </form>
<?php }
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
      <br>


      
      <?php if ($detect->isMobile() or $detect->isTablet()) {
           require_once("opendb.php");
          $query = "select trid, name from transformer";
          $result = $conn -> query($query) or die("Query error");
          ?>

          <input type="text" list="transformers" name="transformer" placeholder="Select Transformer" class="form-control">
          <datalist id="transformers">
            <?php
            foreach ($result as $row) {
              echo "<option value=".$row['trid'].">".$row['name']."</option>";
            }
            ?>
            
          </datalist>

          <br>
          <div><b>Date and Time From:</b></div>
          <input type="date" id="fromdate" name="fromdate" class="form-control" placeholder="Logs From">
          <input type="time" id="fromtime" name="fromtime" class="form-control" placeholder="Logs From">
          <br>
          <div><b>Date and Time To:</b></div>
          <input type="date" id="todate" name="todate" class="form-control" placeholder="Logs to">
          <input type="time" id="totime" name="totime" class="form-control" placeholder="Logs to">

          <br>
          <button style="float: right; margin-right:5px; " class="btn-primary btn" name="submit"> Submit </button>


            </div>
            <!-- /.box-body -->
          </div>
          
          
        </form>
          <?php } ?>

       
       <?php
        require_once("opendb.php"); 
        $filter = $_GET['filter'];
        if ($filter == '0G0')
        // $query= "select tr_kwh_logs.*, transformer.name from tr_kwh_logs, transformer WHERE tr_kwh_logs.Datetime > DATE_SUB(CURDATE(), INTERVAL 1 DAY) and tr_kwh_logs.trid = transformer.trid ORDER BY tr_kwh_logs.Datetime DESC limit 3000";
        //         else
        //         $query= "select tr_kwh_logs.*, transformer.name from transformer, tr_kwh_logs WHERE tr_kwh_logs.trid = '".$filter."'tr_kwh_logs.Datetime > DATE_SUB(CURDATE(), INTERVAL 1 DAY) and tr_kwh_logs.trid = transformer.trid ORDER BY tr_kwh_logs.Datetime DESC limit 3000";
        
      ?>





       <?php
          //include("db/opendb.php");
          if(isset($_POST['transformer'])){
            $id = $_POST['transformer'];

            if(empty($_POST['todate']) or empty($_POST['fromdate'])){
              $query = "select tr_kwh_logs.*, transformer.name from tr_kwh_logs, transformer WHERE tr_kwh_logs.trid = transformer.trid and tr_kwh_logs.trid = '".$id."' order by tr_kwh_logs.datetime desc limit 1500";
              ?>

              
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo "Showing Data for Transformer <b>'".$id."'</b>"; ?>
              </div>
            
              <?php
            }
            else
            {
              $fromdate = $_POST['fromdate'];
              $todate = $_POST['todate'];

              if(!(empty($_POST['fromtime']) or empty($_POST['totime']))){
                $fromdate = $fromdate ." ". $_POST['fromtime'];
                $todate = $todate ." ". $_POST['totime'];
              }
              $query = "select tr_kwh_logs.*, transformer.name from tr_kwh_logs, transformer WHERE tr_kwh_logs.trid = transformer.trid and tr_kwh_logs.trid = '".$id."' AND tr_kwh_logs.datetime BETWEEN '".$fromdate."' AND '".$todate."' order by tr_kwh_logs.datetime desc";
              ?>

              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo "Showing Data for Transformer <b>'".$id."'</b> from date '".$fromdate."' to date '".$todate."' desc limit 1000"; ?>
              </div>
            
              <?php
              
            }
          }
          elseif($filter == '0G0'){
          $query= "select tr_kwh_logs.*, transformer.name from tr_kwh_logs, transformer WHERE tr_kwh_logs.trid = transformer.trid and tr_kwh_logs.datetime >NOW()-INTERVAL 1 DAY order by tr_kwh_logs.datetime desc limit 1000";}
          else{
          $query= "select tr_kwh_logs.*, transformer.name from tr_kwh_logs, transformer WHERE tr_kwh_logs.trid = transformer.trid and tr_kwh_logs.trid = '".$filter."' order by tr_kwh_logs.datetime order by tr_kwh_logs.datetime desc limit 1000";
          }

          $result = $conn -> query($query) or die("Query error");
         ?>
      
    <div  id="overflow" style="overflow-x:auto;" >
        <table  id="example1" class="table table-responsive table-bordered table-striped" >
        <thead class="bg-blue">
        <tr>
          <th scope="col">Transformer ID</th>
          <th scope="col">Transformer Name</th>
          <th scope="col">Peak Units</th>
          <th scope="col">Off Peak Units</th>
			<th scope="col">Total Units</th>
          <th scope="col">Date & Time</th>
          
        </tr>
        </thead>
          
          
        <tbody bgcolor="#FFFFFF">
          
          <?php
          foreach($result as $row){
          ?>
          
          
        <tr>
          <td><?php echo $row ['trid'];  ?></td>
          <td><?php echo $row ['name'];  ?></td>
          <td><?php  echo round(($row['peak_dev']),2);?></td>
          <td><?php echo round($row ['offpeak_dev'],2);  ?></td>
          <td><?php echo round($row ['offpeak_dev']+$row ['peak_dev'],2); ?></td>
          <td><?php echo $row ['Datetime'];  ?></td>
        </tr>
          
          <?php
          }
        ?>
        
          
        </tbody>
        <tfoot class="bg-blue">
        <tr>
          <th scope="col">Transformer ID</th>
          <th scope="col">Transformer Name</th>
          <th scope="col">Peak Units</th>
          <th scope="col">Off Peak Units</th>
          <th scope="col">Total Units</th>
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
    $('#example1').DataTable( {"order": [[ 5, "desc" ]]})
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
