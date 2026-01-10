<?php
  include_once('check.php');
  authenticate("view");
?>
<!doctype html>
<html><!-- InstanceBegin template="/Templates/Master.dwt" codeOutsideHTMLIsLocked="false" -->
	<?php $page_type = NULL;?>
  <meta http-equiv="refresh" content="300">

<head>

	<meta charset="utf-8"> 
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Feeder Dashboard</title>
	
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


        <?php $fdid = explode('F',$_GET['id']);?>
		<section class="content-header">
		<h1><b>
		Feeder Detailed Analytics
		<button id="add-new-button" class="btn btn-primary" onClick="window.location.href='feeder_dashboard.php?id=<?php echo $fdid; ?>'"><b>Return to Dashboard</b></button>

		</b></h1>

		</section>
		<hr>


     <?php 



    date_default_timezone_set("Asia/Karachi");
    $subdivid = 'mes05c1';
    $dbtype = 'electrocure';
	require_once("opendb.php");
    $feeder = $_GET['id'];
    
      
		
         // the word in the braket is that we used in ajax i.e data: {transformerid: 1G1PU01}
        
        $q = "select fd_current_logs.*, feeder.mfactorvoltage, feeder.mfactorcurrent,feeder.name from fd_current_logs,feeder WHERE fd_current_logs.trid=feeder.fdid and fd_current_logs.trid='".$feeder."' and  fd_current_logs.datetime > now()-interval 1 day ORDER BY datetime DESC limit 50";
       // echo $q;
        
        $voltage = array();
        $current = array();        
        
        $kva = array();
	   
        $kvar = array();
           $resultFeeder = $conn -> query($q) or die("Query error");
    
           foreach($resultFeeder as $row){
           $mfv = $row['mfactorvoltage']*1.732;
           $mfc = $row['mfactorcurrent'];
           array_push($voltage ,array('y' => $row['datetime'],'a'  => $row['v1']*$mfv/1000, 'b' =>$row['v2']*$mfv/1000, 'c' => $row['v3']*$mfv/1000));
           array_push($current ,array('y' => $row['datetime'],'a'  => $row['B1U']*$mfc, 'b' => $row['B1M']*$mfc, 'c' => $row['B1L']*$mfc));
           $kva1 = round($row['B1U'] * $row['v1'] *$mfv*$mfc/1000,2);
           $kva2 = round($row['B1M'] * $row['v2'] *$mfv*$mfc/1000 ,2);
           $kva3 = round($row['B1L'] * $row['v2'] *$mfv*$mfc/1000 ,2);
           $kvar1 = round($kva1 * sin(acos($row['pf1'])),2);
           $kvar2 = round($kva2 * sin(acos($row['pf2'])),2);
           $kvar3 = round($kva3 * sin(acos($row['pf3'])),2);
           array_push($kva ,array('y' => $row['datetime'],'a'  => $kva1, 'b' => $kva2, 'c' => $kva3 , 'd' => round(($kva1 + $kva2 + $kva3) , 2)));
           array_push($kvar ,array('y' => $row['datetime'],'a'  => $kvar1, 'b' => $kvar2, 'c' => $kvar3, 'd'=>round($kvar1+ $kvar2+ $kvar3,2)));
           
       }
        $name = $row['name'];

       $lastIndex = sizeof($current) - 1;
       $maxCurrent = max($current[0]['a'], $current[0]['b'], $current[0]['c']);

       $lastIndex = sizeof($voltage) - 1; 
       $avgVoltage =  ($voltage[0]['a'] + $voltage[0]['b'] + $voltage[0]['c'])/3;

       $totalKVA = ($kva[0]['a'] + $kva[0]['b'] + $kva[0]['c']);
       // var_dump($voltage);
         $voltage = json_encode($voltage);
            $current =  json_encode($current);
            $kva =  json_encode($kva);
        $kvar =json_encode($kvar);
        $trid = json_encode($feeder);
        $conn =null;

    ?>

    <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo round($avgVoltage,2);?> KV</h3>

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
             <h3><?php echo round($maxCurrent,2);?> AMP</h3>

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
          <iframe src="load_device_graph_feeder.php?id=<?php echo $feeder; ?>&type=3&name=<?php echo $name; ?>&fd=infeeder" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph_feeder.php?id=<?php echo $feeder; ?>&type=4&name=<?php echo $name; ?>1&fd=infeeder" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph_feeder.php?id=<?php echo $feeder; ?>&type=0&name=<?php echo $name; ?>&fd=infeeder" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph_feeder.php?id=<?php echo $feeder; ?>&type=2&name=<?php echo $name; ?>&fd=infeeder" width="600" height="400" frameborder="0"></iframe>                                      
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