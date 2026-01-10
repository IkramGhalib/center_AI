<?php
  include_once('check.php');
  authenticate("view");
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/Master.dwt" codeOutsideHTMLIsLocked="false" -->
  
<head>

	<meta charset="utf-8"> 
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Transformer Detailed Analytics</title>
	<!-- InstanceEndEditable -->
	<!-- InstanceBeginEditable name="head" -->
	<!-- InstanceEndEditable --> 
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- 		/*All STYLES*/  --> 
<style>			
		#overflow{
		width: 100%;
		height: 100%;
		}

		#add-new-button{
		position: absolute;
		right:  120px;
		}

		.skin-blue{
		background-color:#ECF0F5;
		}

		thead{
		background-color:#0073B7;
		color:white;
		}
</style>
 
			<!--ALL LINKS-->
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    
</head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<body class="skin-blue">
	<?php require_once('navbar.php');?>

<!--ASIDES
	 
 Left side column. contains the logo and sidebar -->


     <?php 



      date_default_timezone_set("Asia/Karachi");
      require_once("opendb.php");
      $transformer = $_GET['id'];

      $q = "select * from transformer where trid = '".$transformer."'";

      $result= $conn -> query($q) or die("Query error");                          
      foreach($result as $row)
      {
       $name = $row['trid']." - ".$row['name'];
       	$kva1 = round($row['c1'] * $row['v1']/1000,2);
       	$kva2 = round($row['c2'] * $row['v2']/1000 ,2);
       	$kva3 = round($row['c3'] * $row['v2']/1000 ,2);
       	$avgVoltage = round(($row['v1']+$row['v2']+$row['v3'])/3,2);
       	$totalCurrent = round(($row['c1']+$row['c2']+$row['c3']),2);
       $totalKVA = $kva1+$kva2+$kva3;          
      }

      $conn =null;

      ?>

    <div class="content-header" background-color:#000000>

    <section class="content-header">
    <br><br>
    <br>
    <h1><b>
    Transformer Detailed Analytics (<?php echo $name; ?>)
    

    </b></h1>

    </section>
    <hr>

    <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $avgVoltage;?> Volt</h3>

              <p><b>Average Voltage</b></p>
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
             <h3><?php echo $totalCurrent;?> AMP</h3>

              <p><b>Total Current</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
				<h3><?php echo $totalKVA;?></h3>

              <p><b>Total KVA</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>




    
    </div>
    <div >
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph.php?id=<?php echo $transformer; ?>&type=3&name=Transformer 1" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph.php?id=<?php echo $transformer; ?>&type=4&name=Transformer 1" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph.php?id=<?php echo $transformer; ?>&type=2&name=Transformer 1" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="tr_daily_kwh_graph.php?id=<?php echo $transformer; ?>" width="700" height="450" frameborder="0"></iframe>                                  
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="tr_monthly_kwh_graph.php?id=<?php echo $transformer; ?>" width="700" height="450" frameborder="0"></iframe>                                  
        </div>

        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="tr_yearly_kwh_graph.php?id=<?php echo $transformer; ?>" width="700" height="450" frameborder="0"></iframe>                                  
        </div>

      


    </div>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
		
	<!-- SlimScroll -->
	<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>

   
    
              
</body>
</html>