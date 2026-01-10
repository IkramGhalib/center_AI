<?php
  include_once('check.php');
  authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>

  <?php $pageName = "PESCO-CISNR KWH Comparison Graph"; ?>

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
	<?php //include_once('sidebar.php') ?>

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
     
            <form class="form-horizontal">
              <div class="form-group">
                  <?php
                    require_once("opendb.php");
                    $query = "select distinct pesco_unit_comparison.trid, transformer.name from pesco_unit_comparison, transformer where pesco_unit_comparison.trid = transformer.trid";
                    $result = $conn -> query($query) or die(error);
                  ?>
                  <div class="col-sm-12">
                    <input type="text" list="trans" id= "transformer"name="transformer" class="form-control" placeholder="Select Transformer" required="">
                    <datalist id="trans">
                      <?php
                        foreach ($result as $row) {
                          echo "<option value='".$row['trid']."'>".$row['name']."</option>";
                        }
                      ?>
                    </datalist>
                  </div>
              </div>
              <!-- /.box-body -->
         
                
                <button class="btn btn-primary pull-right">Submit</button>


            </form>

            <?php
            if (isset($_GET['transformer'])) {
              ?>
              
              <p id="ifr" align="center">
                <iframe name="Right" src="tr_kwh_graph_peak.php?id=<?php echo $_GET['transformer']; ?>" width="810" height="400" frameborder="0" ></iframe>
              </p>

              <p id="ifr" align="center">
                <iframe name="Right" src="tr_kwh_graph_offpeak.php?id=<?php echo $_GET['transformer']; ?>" width="810" height="400" frameborder="0" ></iframe>
              </p>

              <p id="ifr" align="center">
                <iframe name="Right" src="tr_kwh_graph_total.php?id=<?php echo $_GET['transformer']; ?>" width="810" height="400" frameborder="0" ></iframe>
              </p>



              <?php
            }
            ?>
        


        <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
         <script type="text/javascript">

        
    </script>
      
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
</html>
