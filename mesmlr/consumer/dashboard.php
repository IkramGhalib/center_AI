<?php session_start();
if( !isset($_SESSION['cid'])){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  
  <?php $pageName = "User Dashboard"?>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $pageName;?></title>
  
 <?php include_once('head.php') ?> 
 
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Graph JS -->
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
<!-- Graph JS ENDS -->
<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->

<body class="hold-transition skin-blue sidebar-mini" >

<!-- Site wrapper -->
<div class="wrapper" style="overflow: hidden;">
  
	
	
	<!-- Navbar -->
	<?php include_once('navbar.php') ?>
	<!-- Sidebar -->
	<?php include_once('sidebar.php') ?>

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
      require_once('opendb.php');
      
      if ($_SESSION['billing_method'] == "postpaid") {
        $query = "select connections.*, billing_postpaid.current_reading, paid_on from connections, billing_postpaid where bill_id in (select max(bill_id) from billing_postpaid group by cid) and billing_postpaid.cid = connections.cid and connections.cid = '".$_SESSION['cid']."'";
        $result = $conn -> query($query) or die("Query error");
        $status = "";
        
        $current_reading = 0;
        $remaining_units = 0;
        $bill_paid_on = "";
        
        foreach ($result as $row) {
        	$status = $row['status'];
          $consumed_units = $row['peak'] + $row['offpeak'] - $row['current_reading'];
          $current_reading = $row['peak'] + $row['offpeak'];
          $bill_paid_units = $row['current_reading'];
          $last_recharge = $row['paid_on'];
         
        }
 
   

      ?>

  <div class=row>
      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo round(($consumed_units > 0 ? $consumed_units : 0),2); ?></h3>

              <p><b>Units to be Paid</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo round($bill_paid_units,2); ?></h3>

              <p><b>Bill Paid Upto</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $current_reading; ?></h3>

              <p><b>Current Reading</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>
       
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h4><?php echo $last_recharge; ?></h4>

              <p><b>Last Bill Paid</b></p>
            </div>
            <div class="icon">
              <i class=""></i>
            </div>
            
          </div>
        </div>

        
      </div>
      

        <?php
      }
      elseif ($_SESSION['billing_method'] == 'prepaid') {
        require_once("opendb.php");
        $query = "select * from connections where cid = '".$_SESSION['cid']."'";
        
        $result = $conn -> query($query) or die("Query error");
        $status = "";
        $current_reading = 0;
        $remaining_units = 0;
        $bill_paid_on = "";
        foreach ($result as $row) {
        	$status = $row['status'];
          $current_reading = $row['peak'] + $row['offpeak'];
          $remaining_units = $row['unit_limit'] - $current_reading;
          $last_recharge = $row['bill_paid_on'];
          $unit_limit = $row['unit_limit'];
        }

         if($status == "off"){
      	?>
     	<div class="alert alert-danger alert-dismissible">
       		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
       		<h4><i class="icon fa fa-ban"></i> Alert!</h4>
       		Kindly recharge your account to continue usage of electricity without any convenienance.
        </div>
     <?php

      }

      ?>

        <div class=row>

      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $remaining_units?></h3>

              <p><b>Remaining Units</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>


<!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $current_reading; ?></h3>

              <p><b>Current Reading</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $unit_limit; ?></h3>

              <p><b>Unit Limit</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $last_recharge; ?></h3>

              <p><b>Last Recharge</b></p>
            </div>
            <div class="icon">
              <i class=""></i>
            </div>
            
          </div>
        </div>
        
      </div>
      
        <?php
      }
        ?>

        <div id="row">
          <div class="col-md-6">
          <iframe src="load_graph.php?id=<?php echo $_SESSION['cid']?>&type=1"  width="100%" height="450" frameborder="0"></iframe>  
          </div>
          <div class="col-md-6">
            <iframe src="load_graph.php?id=<?php echo $_SESSION['cid']?>&type=2"  width="100%" height="450" frameborder="0"></iframe>
          </div>
          <div class="col-md-6">
          <iframe src="http://brtpswr.cisnr.com/electrocure_user/load_graph_kwh.php?id=<?php echo $_SESSION['cid']?>&type=3&pay=<?php echo $_SESSION['pay']?>"  width="100%" height="450" frameborder="0"></iframe>  
          </div>
          <div class="col-md-6">
          <iframe src="http://brtpswr.cisnr.com/electrocure_user/load_graph_kwh.php?id=<?php echo $_SESSION['cid']?>&type=4&pay=<?php echo $_SESSION['pay']?>"  width="100%" height="450" frameborder="0"></iframe>  
          </div>

        </div>
       <div class="row">
        <img src="images/project.PNG" width="100%">
      </div>





    </section>
<?php $conn = NULL; ?> 
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
</html>
<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Consumed Units',     53],
          ['Remaining Units', 247]
        ]);

        var options = {
          colors:['#DD4C39','#01A65A'],
          backgroundColor: '#ECEFF4',
          is3D: true,
          chartArea:{left:20,top:0,width:'80%',height:'75%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>