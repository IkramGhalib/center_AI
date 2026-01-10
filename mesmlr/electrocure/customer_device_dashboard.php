<?php
  include_once('check.php');
  authenticate("view");
?><!doctype html>
<html><!-- InstanceBegin template="/Templates/Master.dwt" codeOutsideHTMLIsLocked="false" -->
  <meta http-equiv="refresh" content="300">
<head>

	<meta charset="utf-8"> 
	<!-- InstanceBeginEditable name="doctitle" -->
	<title>Connection Detailed Analytics</title>
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

<!--ASIDES
	 
<!-- Left side column. contains the logo and sidebar -->
     

 
<div class="content-header" background-color:#000000>


     <?php //$fdid = explode('TR',$_GET['id']);?>
		<section class="content-header">
		<h1><b>
		<?php echo $_GET['id'];?> Detailed Analytics
		<button id="add-new-button" class="btn btn-primary" onClick="window.location.href='connection_dashboard.php'"><b>Return to Dashboard</b></button>

		</b></h1>

		</section>
		<hr>


     <?php 



    date_default_timezone_set("Asia/Karachi");
	   require_once("opendb.php");
   // include("DBConnection.php");
    $id = $_GET['id'];
   // $con = new DBCon();
   
      
		
         // the word in the braket is that we used in ajax i.e data: {transformerid: 1G1PU01}
        
        $q = "select * from cust_current_logs where cid = '".$id."' and  datetime >= now() - INTERVAL 1 DAY order by id desc limit 360";
       // echo $q;
       // $result = $con->db->query($q);
        $voltage = array();
        $current = array();        
        
        $kva = array();
	   
        $kvar = array();
       $result= $conn -> query($q) or die("Query error");                          
foreach($result as $row)
{
           array_push($voltage ,array('y' => $row['datetime'],'a'  => $row['v1'], 'b' =>$row['v2'], 'c' => $row['v3']));
           array_push($current ,array('y' => $row['datetime'],'a'  => $row['c1'], 'b' => $row['c2'], 'c' => $row['c3']));
           $kva1 = round($row['c1'] * $row['v1']/1000,2);
           $kva2 = round($row['c2'] * $row['v2']/1000 ,2);
           $kva3 = round($row['c3'] * $row['v3']/1000 ,2);
           $kvar1 = round($kva1 * sin(acos($row['pf1'])),2);
           $kvar2 = round($kva2 * sin(acos($row['pf2'])),2);
           $kvar3 = round($kva3 * sin(acos($row['pf3'])),2);
           array_push($kva ,array('y' => $row['datetime'],'a'  => $kva1, 'b' => $kva2, 'c' => $kva3 , 'd' => round(($kva1 + $kva2 + $kva3) , 2)));
           array_push($kvar ,array('y' => $row['datetime'],'a'  => $kvar1, 'b' => $kvar2, 'c' => $kvar3, 'd'=>round($kvar1+ $kvar2+ $kvar3,2)));
           
       }


       $lastIndex = sizeof($current) - 1;
       $maxCurrent = max($current[$lastIndex]['a'], $current[$lastIndex]['b'], $current[$lastIndex]['c']);

       $lastIndex = sizeof($voltage) - 1; 

       $query = "select slot1, slot2, slot3,name from connections where cid = '".$id."'";
       $result= $conn -> query($query) or die("Query error");
       foreach ($result as $row) {
        if($row['slot2']>0 && $row['slot3']>0 ){
          $avgVoltage =  ($voltage[$lastIndex]['a'] + $voltage[$lastIndex]['b'] + $voltage[$lastIndex]['c'])/3;
        }else if($row['slot2']>0 && $row['slot3']<0 ){
           $avgVoltage =  ($voltage[$lastIndex]['a'] + $voltage[$lastIndex]['b'])/2;
        }else if($row['slot2']<0 && $row['slot3']<0 ){
           $avgVoltage =  ($voltage[$lastIndex]['a']);
        }
       }



//       $avgVoltage =  ($voltage[$lastIndex]['a'] + $voltage[$lastIndex]['b'] + $voltage[$lastIndex]['c'])/3;

       $totalKVA = $kvar1+$kvar2+$kvar3;
       // var_dump($voltage);
         $voltage = json_encode($voltage);
            $current =  json_encode($current);
            $kva =  json_encode($kva);
        $kvar =json_encode($kvar);
       // $trid = json_encode($transformer);
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
          <iframe src="load_device_graph_connection.php?id=<?php echo $id; ?>&type=3&name=Transformer 1" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph_connection.php?id=<?php echo $id; ?>&type=4&name=Transformer 1" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph_connection.php?id=<?php echo $id; ?>&type=0&name=Transformer 1" width="600" height="400" frameborder="0"></iframe>                                      
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="load_device_graph_connection.php?id=<?php echo $id; ?>&type=2&name=Transformer 1" width="600" height="400" frameborder="0"></iframe>                                      
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