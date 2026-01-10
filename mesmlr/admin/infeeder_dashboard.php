<?php
  //  include_once('check.php');
  //  authenticate("can_view");
?>

<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Feeder Dashboard";?>



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

         <?php
               date_default_timezone_set("Asia/Karachi");

                                   require_once("opendb.php"); 
                                      // $values = array();
                                      // $splitVal = array();
                                      // $totalPeak = 0;
                                      // $totalOffPk= 0;
                                      // if (isset($_GET['status'])) {
                                      //   $status = $_GET['status'];
                                      // }else{
                                      //   $status = "all";
                                      // }
                                      // $offlc = 0;
                                      // $offc = 0;
                                      // $onc = 0;
                                    //  $totalConsumtion = 0;
                                     

                                          $q = "SELECT * from tbl_feeders_avgs";
                                          $resultactive = $conn -> query($q) or die("Query error");
                                      foreach($resultactive as $row){
                                               $currenttime = date('y-m-d H:i:s');
                                               $lasttime =$row['datetime'];
                                             
                                              
                                              //  if($row['fdid']=='I1')
                                              //   {
                                              //     $mfv1 = $row['mfactorvoltage']*1.732;
                                              //     $mfc1 = $row['mfactorcurrent'];
                                              //   }
                                              // $mfv = $row['mfactorvoltage']*1.732;
                                              // $mfc = $row['mfactorcurrent'];

        // echo $currenttime.' '.$lasttime;
                                               if (strlen($currenttime)== 19)
                                                {
                                                    $currenttime = strtotime($currenttime);
                                                }
                                                else
                                                {
                                                    $currenttime = strtotime('20'.$currenttime);
                                                }
        
                                                $lasttime =$row['datetime'];
        
                                                if (strlen($lasttime)== 19)
                                                {
                                                    $lasttime = strtotime($lasttime);
                                                }
                                                else
                                                {
                                                    $lasttime = strtotime('20'.$lasttime);
                                                }
        
                         
                                                $timediff = abs(ceil(($currenttime-$lasttime)/60));
                                                $avgVoltage  = round(($row['v1_avg']+$row['v2_avg']+$row['v3_avg'])/3,2);
                                                $sumCurrent = round(($row['c1_avg']+ $row['c2_avg'] + $row['c3_avg']),2);
                                                $maxCurrent = max($row['c1_avg'],$row['c2_avg'],$row['c3_avg']);
                                                //$NC = round($row['NC']* $row['mfactorcurrent'],2);
                                                array_push($splitVal, array($row['feeders_ids'],$row['c1_avg'],$row['c2_avg'],$row['c3_avg'],$row['v1_avg'],$row['v2_avg'],$row['v3_avg'],$row['pf1_avg'],$row['pf2_avg'],$row['pf3_avg']));


                                                $kva1 = round($row['c1'] * $row['v1'],2);
                                                $kva2 = round($row['c2'] * $row['v2'],2);
                                                $kva3 = round($row['c3'] * $row['v2'],2);
                                              
                                                $totalKVA  = round(($kva1 + $kva2 + $kva3),2);
                                                $avgPf = round(($row['pf1_avg']+$row['pf2_avg']+$row['pf3_avg'])/3,2);
                                               // $id = explode('D',$row['fdid']);
                                                // $totalPeak = $totalPeak + $row['peak'];
                                                // $totalOffPk = $totalOffPk + $row['offpeak'];


                                              array_push($values,array($row['feeders_ids'],$timediff,$avgVoltage,$sumCurrent,$maxCurrent,$totalKVA,$avgPf));

                                               if ($timediff <=360)
                                                {
                                                    if (max($row['c1_avg'],$row['c2_avg'],$row['c3_avg'])>0.1)
                                                    {
                                                        $onc = $onc + 1;
                                                    }
                                                    else
                                                    {
                                                        $offc = $offc +1;
                                                    }
                                                    
                                                }
                                              else
                                              {
                                                  $offlc = $offlc + 1;
                                              }
                                              
                                          

                                          }
               $allc= $onc + $offc+ $offlc ;
                                          $conn= NULL;
              ?>
 
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

      
      <?php echo "<div class = 'row'>";
       echo "<div class='col-md-6'>";
        $fdid = "0G0";
            if ($status==='ON')
            {
            echo "<a href='feeder_dashboard.php?filter=".$fdid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {
              echo "<a href='feeder_dashboard.php?filter=".$fdid."&status=ON'>
                <button class='btn btn-success'><i class='icofont icofont-check-circled'></i> On $onc</button>
            </a>";  
            }
            if ($status==='OFL')
            {
            echo "<a href='feeder_dashboard.php?filter=".$fdid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {echo "<a href='feeder_dashboard.php?filter=".$fdid."&status=OFL'>
                <button class='btn  btn-warning' style='background:blue;border-color:blue;><i class='icofont icofont-warning-alt'></i> Offline $offlc</button>
            </a>";
            }
            if ($status==='OFF')
            {
            echo "<a href='feeder_dashboard.php?filter=".$fdid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {
            echo "<a href='feeder_dashboard.php?filter=".$fdid."&status=OFF'>
                <button class='btn btn-danger'><i class='icofont icofont-eye-alt'></i> Off $offc</button>
            </a>";

            }
        echo    "</div>";
           
       echo "</div>";?>
    
      
  <br>
      <div class="row">
    <div class="col col-md-4 col-md-offset-4">
        <div class="box box-widget widget-user-2" style="text-align: center;">
          <div class="widget-user-header bg-green" >
            <h3><b>
              <?php
                echo "All Feeders";
                
                ?>
                </b></h3>
          </div>
        </div>
      </div>
      </div> 

      <div class="row">

      
              <?php
                
                $count = sizeof($values);
                //echo $count;
                if(sizeof($values) > 0)
                {
                  for ($i=0; $i < $count ; $i++) {

                        if($values[$i][1] <= 360){
                          
                          if ($values[$i][3] > 0.1) {

                            
                              $color = "bg-green";
                              $state = "On";
                            
                          }
                          else
                          {
                            $color = "bg-green";
                            $state = "On";
                          }
                        
                        }
                        else{
                          $color = "bg-blue";
                          $state = "Offline"; 
                        }

                     
                        // if ($status === "ON" and ($state ==="Offline" or $state === "Off")) {
                        //     goto skip;
                        // }elseif($status === "OFL" and ($state ==="Off" or $state === "On" or $state === "Under Voltage" or $state === "Over Voltage" or $state === "Link Down")) {
                        //     goto skip;
                        // }elseif ($status === "OFF" and ($state ==="Offline" or $state === "On" or $state === "Under Voltage" or $state === "Over Voltage" or $state === "Link Down")) {
                        //     goto skip;   
                        // }
                        
                        ?>


                        <div class="col col-md-3" data-toggle="popover" title="voltages = (<?php echo $splitVal[$i][4].', '.$splitVal[$i][5].', '.$splitVal[$i][6].') currents=('.$splitVal[$i][1].', '.$splitVal[$i][2].', '.$splitVal[$i][3].') PFs=('.$splitVal[$i][7].', '.$splitVal[$i][8].', '.$splitVal[$i][9].')';?>">
                          <div class="box box-widget widget-user-2" style="text-align: center;">
                            <a href='outfeeder_dashboard.php?id=<?php echo $values[$i][0]?>&status=all'>
                            <div class="widget-user-header <?php echo $color; ?>" >
                              
                              <h3><b><?php echo $values[$i][5]; ?> KVA</b></h3>
                              <!-- Status = <?php //echo $state; ?> <br> -->
                              <h5><?php echo $values[$i][1]; ?></h5>
                              
                            </div>
                          </a>
                            <div class="box-footer no-padding" >
                                Device ID = <?php echo $values[$i][0];?> <br>
                                
                                 
                                 Average Voltage = <?php echo $values[$i][2]; ?> KVolts <br>
                                 Total Current = <?php echo $values[$i][3]; ?> Amps <br>
                                 Average Power Factor = <?php echo $values[$i][5]; ?> <br>
                                 Total KVA = <?php echo $values[$i][6]; ?><br>
                                <br>

                              <?php 

                        if($state == "On" or $state == "Link Down" or $state == "Under Voltage" or $state == "Over Voltage"){
                          ?>
                        
                        <button class='btn btn-primary' onclick='window.location.href="feeder_device_dashboard.php?id=<?php echo $values[$i][0]; ?>&mfv=<?php echo $values[$i][10]; ?>&mfc=<?php echo $values[$i][11]; ?>"'>Details</button>
                        

                          <?php
                        }elseif ($state == "offline") {
                        ?>                         
                        <!-- <button class='btn btn-primary' disabled="disabled">Graphs</button> -->
                        <button class='btn btn-primary'disabled="disabled">Details</button>
                        
                        <?php 
                        }else
                        {
                          ?>
                        <!-- <button class='btn btn-primary' disabled="disabled">Graphs</button> -->
                        <button class='btn btn-primary'disabled="disabled">Details</button>
                          <?php
                        }
                        ?>
                              <br><br>
                            </div>
                          </div>
                        </div>
<?php
                      // skip:
                  }
                }
                  
                
                // else{
                //   echo "<b>No Feeders Added Yet!</b>";
                // }
              ?>
    </div>



      
    <!-- Right side column. Contains the navbar and content of the page -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
        

    <table border="0" width="100%"></table>          

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
