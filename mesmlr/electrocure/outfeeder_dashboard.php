<?php
  // include_once('check.php');
  // authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>

  <?php $pageName = "Out Feeder Dashboard"?>

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
            
        <li class="header">Active Feeders</li>
      
        <li class=" treeview">
                <a href="#">
                  <i class="fa fa-dashboard"></i> <span>Active Feeders</span> 
                </a>
        </li>
         <?php
              date_default_timezone_set("Asia/Karachi");
                                     
                                   require_once("opendb.php"); 
                                      $values = array();
                                      $splitval = array();
                                      $totalPeak = 0;
                                      $totalOffPk= 0;
                                      $fdid = $_GET['id'];
                                        if ($fdid =="0G0") {
                                              $q = "SELECT * from outfeeder";
                                            $resultactive = $conn -> query($q) or die("Query error");
                                             $q = "select * from feeder where fdid = '".$fdid."'";
                                        } else{
                                            $q = "SELECT * from outfeeder where substring_index(fdid,'F',1)= '".$fdid."'";
                                            $resultactive = $conn -> query($q) or die("Query error");
                                            $q = "select * from feeder where fdid = '".$fdid."'";
                                        }
                                        $totalPeak = 0;
                                          $totalOffPk= 0;
                                          $name = 'All Out Feeders';
                    
                                          $resultFeeder = $conn -> query($q) or die("Query error");
                                          foreach($resultFeeder as $row){
                                          $totalPeak = $row['peak'];
                                          $totalOffPk= $row['offpeak'];
                                          $name = $row['name'];
                                          }
                                         // $feederValue = array();
                                         $allc = 0;
                                      $offlc  = 0;
                                      $onc = 0; 
                                      $offc =0; 
                                      foreach($resultactive as $row){
                                              
                                                if($row['fdid']==$fdid.'F1')
                                                {
                                                  $mfv1 = $row['mfactorvoltage']*1.732;
                                                  $mfc1 = $row['mfactorcurrent'];
                                                }
                                              $mfv = $row['mfactorvoltage']*1.732;
                                              $mfc = $row['mfactorcurrent'];
                                               $currenttime = date('Y-m-d H:i:s');
                                               $lasttime =$row['datetime'];
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
        
                         
                                                $timediff = abs(ceil(abs($currenttime-$lasttime)/60));
                                                $avgVoltage  = round(($row['v1']+$row['v2']+$row['v3'])/3*0.1732,2);
                                                $sumCurrent = round(($row['c1']+ $row['c2'] + $row['c3']),2);
                                                $maxCurrent = max($row['c1'],$row['c2'],$row['c3']);
                                                //$NC = round($row['NC']* $row['mfactorcurrent'],2);
                                                $kva1 = round($row['c1'] * $row['v1']*0.1732,2);
                                                $kva2 = round($row['c2'] * $row['v2']*0.1732 ,2);
                                                $kva3 = round($row['c3'] * $row['v2']*0.1732 ,2);
                                                $totalKVA  = round(($kva1 + $kva2 + $kva3),2);
                                                $avgPf = round(($row['pf1']+$row['pf2']+$row['pf3'])/3,2);
                                               // $id = explode('D',$row['fdid']);
                                                $totalPeak = $totalPeak + $row['peak'];
                                                $totalOffPk = $totalOffPk + $row['offpeak'];


                                              array_push($values,array($row['fdid'],$row['name'],$timediff,$avgVoltage,$sumCurrent,$maxCurrent,$totalKVA,$avgPf,$row['offpeak'],$row['peak'],$mfv,$mfc,$row['datetime']));
                                                array_push($splitval, array($row['fdid'],$row['c1']* $row['mfactorcurrent'],$row['c2']* $row['mfactorcurrent'],$row['c3']* $row['mfactorcurrent'],$row['v1']* $row['mfactorvoltage']*1.7432/1000,$row['v2']* $row['mfactorvoltage']*1.7432/1000,$row['v3']* $row['mfactorvoltage']*1.7432/1000,$row['pf1'],$row['pf2'],$row['pf3']));
                                                if ($timediff <=360)
                                                {
                                                    if (max($row['c1'],$row['c2'],$row['c3'])>0.04)
                                                    {
                                                        $onc = $onc + 1;
                                                      ?>
                                                        <li class= 'treeview'>
                                                          <a href="outfeeder_device_dashboard.php?id=<?php echo $row['fdid']; ?>">
                                                            <span><?php echo $row['name']; ?></span> 
                                                          </a>
                                                        </li>
                                                        <?php
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
              
                                          
                                      $conn= NULL; 
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

     
    <?php echo "<div class = 'row'>";
       echo "<div class='col-md-6'>";
        $status = $_GET['status'];  
        if ($status==='ON')
            {
            echo "<a href='transformer_dashboard.php?id=".$fdid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {
              echo "<a href='transformer_dashboard.php?id=".$fdid."&status=ON'>
                <button class='btn btn-success'><i class='icofont icofont-check-circled'></i> On $onc</button>
            </a>";  
            }
            if ($status==='OFL')
            {
            echo "<a href='transformer_dashboard.php?id=".$fdid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {echo "<a href='transformer_dashboard.php?id=".$fdid."&status=OFL'>
                <button class='btn  btn-warning' style='background:blue;border-color:blue;><i class='icofont icofont-warning-alt'></i> Offline $offlc</button>
            </a>";
            }
            if ($status==='OFF')
            {
            echo "<a href='transformer_dashboard.php?id=".$fdid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {
            echo "<a href='transformer_dashboard.php?id=".$fdid."&status=OFF'>
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
                if ($fdid == "0G0") {
                  echo "All Out Feeders";    
                  }else{
                    echo $fdid." Out Feeders";
                  }

                
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

                        if($values[$i][2] <= 360){
                          
                          if ($values[$i][5] > 0.1) {

                           
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

                     
                        if ($status === "ON" and ($state ==="Offline" or $state === "Off")) {
                            goto skip;
                        }elseif($status === "OFL" and ($state ==="Off" or $state === "On" or $state === "Under Voltage" or $state === "Over Voltage" or $state === "Link Down")) {
                            goto skip;
                        }elseif ($status === "OFF" and ($state ==="Offline" or $state === "On" or $state === "Under Voltage" or $state === "Over Voltage" or $state === "Link Down")) {
                            goto skip;   
                        }
                        
                        ?>


                        <div class="col col-md-3">
                          <div class="box box-widget widget-user-2" style="text-align: center;">
                            <a href='transformer_dashboard.php?id=<?php echo ($values[$i][0] == 'I1F01') ? 'I1F1' : $values[$i][0]; ?>&status=all'>
                            <div class="widget-user-header <?php echo $color; ?>" >
                              
                              <h3><b><?php echo $values[$i][6]; ?> KVA</b></h3>
                              Status = <?php echo $state; ?> <br>
                              <h5><?php echo $values[$i][1]; ?></h5>
                              
                            </div>
                          </a>
                            <div class="box-footer no-padding" >
                                Device ID: <?php echo $values[$i][0];?> <br>
                                Last Pulse: <?php echo $values[$i][12]; ?><br>
                                Average Voltage = <?php echo $values[$i][3]; ?> KVolts <br>
                                Total Current = <?php echo $values[$i][4]; ?> Amps <br>
                                Average Power Factor = <?php echo $values[$i][7]; ?> <br>
                                <br>

                              <?php 

                        if($state == "On" or $state == "Link Down" or $state == "Under Voltage" or $state == "Over Voltage"){
                          ?>
                          <button class='btn btn-primary' onclick='window.location.href="outfeeder_device_dashboard.php?id=<?php echo $values[$i][0]; ?>"'>Details</button>
                        

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
                      skip:
                   }
                }
                else{
                  echo "<b>No Feeders Added Yet!</b>";
                }
              ?>
    </div>
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
