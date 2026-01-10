<?php
  include_once('check.php');
  authenticate("view");
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/Master.dwt" codeOutsideHTMLIsLocked="false" -->
<head>

	<meta charset="utf-8"> 
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Distribution Box Detailed Analytics</title>
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
	 
<!-- Left side column. contains the logo and sidebar -->
     

 
<div class="content-header" background-color:#000000>


     <?php //$fdid = explode('TR',$_GET['id']);?>
		<section class="content-header">
		<br>
    <br>
    <br>
    <h1><b>

		Distribution Box Detailed Analytics
		<button id="add-new-button" class="btn btn-primary" onClick="window.location.href='db_dashboard.php'"><b>Return to Dashboard</b></button>

		</b></h1>

		</section>
		<br>
     <?php 



    date_default_timezone_set("Asia/Karachi");
	   require_once("opendb.php");
   // include("DBConnection.php");
    $db = $_GET['id'];
   // $con = new DBCon();
   
      
		
         // the word in the braket is that we used in ajax i.e data: {transformerid: 1G1PU01}
        
        $q = "select * from db where dbid = '".$db."'";
       // echo $q;
       // $result = $con->db->query($q);
        $voltage = array();
        $current = array();        
        
   
	   
        
       $result= $conn -> query($q) or die("Query error");  
       $totalKVA = 0;
       $totalCurrent = 0;
       $avgvoltage = 0;                        
      foreach($result as $row)
      {
           $avgvoltage = $row['v1'] + $row['v2'] + $row['v3'];
           
           $totalKVA = $totalKVA + round($row['line1_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line1_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line1_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line2_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line2_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line2_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line3_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line3_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line3_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line4_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line4_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line4_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line5_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line5_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line5_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line6_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line6_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line6_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line7_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line7_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line7_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line8_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line8_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line8_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line9_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line9_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line9_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line10_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line10_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line10_c3'] * $row['v3']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line11_c1'] * $row['v1']/1000,2);
           $totalKVA = $totalKVA + round($row['line11_c2'] * $row['v2']/1000 ,2);
           $totalKVA = $totalKVA + round($row['line11_c3'] * $row['v3']/1000 ,2);

           $totalCurrent = round(
            $row['line1_c1'] + 
            $row['line1_c2'] + 
            $row['line1_c3'] + 
            $row['line2_c1'] + 
            $row['line2_c2'] + 
            $row['line2_c3'] + 
            $row['line3_c1'] + 
            $row['line3_c2'] + 
            $row['line3_c3'] + 
            $row['line4_c1'] +
            $row['line4_c2'] + 
            $row['line4_c3'] + 
            $row['line5_c1'] + 
            $row['line5_c2'] + 
            $row['line5_c3'] + 
            $row['line6_c1'] + 
            $row['line6_c2'] + 
            $row['line6_c3'] + 
            $row['line7_c1'] + 
            $row['line7_c2'] + 
            $row['line7_c3'] + 
            $row['line8_c1'] + 
            $row['line8_c2'] + 
            $row['line8_c3'] +
            $row['line9_c1'] + 
            $row['line9_c2'] + 
            $row['line9_c3'] + 
            $row['line10_c1'] + 
            $row['line10_c2'] + 
            $row['line10_c3'] + 
            $row['line11_c1'] + 
            $row['line11_c2'] +
            $row['line11_c3'] ,2);

       }

       $conn =null;
    ?>

    <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo round($avgVoltage,2);?> Volt</h3>

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
             <h3><?php echo round($totalCurrent,2);?> AMP</h3>

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
				<h3><?php echo round($totalKVA,2);?></h3>

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
          <iframe src="load_db_device_graph.php?id=<?php echo $db; ?>&type=3" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_db_device_graph.php?id=<?php echo $db; ?>&type=4" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_db_device_graph.php?id=<?php echo $db; ?>&type=2" width="600" height="400" frameborder="0"></iframe>                                      
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