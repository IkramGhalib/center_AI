<?php
  session_start();
// require_once 'check.php';

// authenticate('can_view');

?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Transformer Dashboard"?>



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
        
        
         <?php
               date_default_timezone_set("Asia/Karachi");
                
               require_once("opendb.php"); 
             //     $con = new DBCon();
                  $values = array();
                  $splitval = array();
                  $totalPeak = 0;
                  $totalOffPk= 0;
                  if($_GET['id'])
                  {
                    $fdid = $_GET['id'];
                  }
                  $status = $_GET['status']; 
                  //echo $fdid;
                  $chartdata=array(array('y'=>'1 Jan', 'a'=>20,'b'=>30,'c'=>40),array('y'=>'2 Jan', 'a'=>30,'b'=>30,'c'=>40));
                  $id  = $fdid;
                  $type  = 0; //0 kvar, 1kwh, 2 kva
                //  $totalConsumtion = 0;
                  $allc = 0;
                  $offlc  = 0;
                  $onc = 0; 
                  $offc =0;
                  $fdid = $_GET['id'];
                    if ($fdid != "0G0") {
                      
                      $q = "select * from transformer where SUBSTRING_INDEX(trid, 'TR', 1) = '".$fdid."'";
                    }else{
                      $q = "SELECT transformer.* from transformer";  
                    }
                    
                    

                     $totalPeak = 0;
                      $totalOffPk= 0;

                    $resultactive = $conn -> query($q) or die("Query error");
                      foreach($resultactive as $row){
                          //$allc = $allc +1;
                           $currenttime = date('y-m-d H:i:s');
                           $lasttime =$row['datetime'];
//  echo $currenttime.' '.$lasttime;    
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


                            if ($row['trid'] == 'I1F1TR06'){
                              $vUpperBound = 232;
                              $vLowerBound = 228;
                              $vDiff = ($vUpperBound - $vLowerBound);

                              $v1Factor = (int)(($vUpperBound - $row['v1'])/$vDiff);
                              $v2Factor = (int)(($vUpperBound - $row['v2'])/$vDiff);
                              $v3Factor = (int)(($vUpperBound - $row['v3'])/$vDiff);
                              $v1 = round($row['v1'] + $v1Factor * $vDiff);
                              $v2 = round($row['v2'] + $v2Factor * $vDiff);
                              $v3 = round($row['v3'] + $v3Factor * $vDiff);
                            }elseif($row['trid'] == 'I1F1TR04'){
                              $v1 = round($row['v1'] );
                              $v2 = round(($row['v1'] + $row['v3'])/2);
                              $v3 = round($row['v3'] );
                            }else{
                              $v1 = round($row['v1']);
                              $v2 = round(($row['v2']));
                              $v3 = round($row['v3']);
                            }
                            

                            // $v1 = ($row['v1'] < 200) ? 230 :  $row['v1'];
                            // $v2 = ($row['v2'] < 200) ? 230 :  $row['v2'];
                            // $v3 = ($row['v3'] < 200) ? 230 :  $row['v3'];

     
                           $timediff = abs(ceil(($currenttime-$lasttime)/60));
                           $avgVoltage  = round(($v1+$v2+$v3)/3 ,2);
                           $sumCurrent = round(($row['c1']+ $row['c2'] + $row['c3']),2);
   // $NC = round($row['NC'],2);
                          $kva1 = round($row['c1'] * $v1/1000,2);
                          $kva2 = round($row['c2'] * $v2/1000 ,2);
                          $kva3 = round($row['c3'] * $v2/1000 ,2);
                          $totalKVA  = round(($kva1 + $kva2 + $kva3),2);
                          $avgPf = round(($row['pf1']+$row['pf2']+$row['pf3'])/3,2);

                        
                          
                          $kwh_peak = round($row['kwh_peak1'] + $row['kwh_peak2'] + $row['kwh_peak3']  ,2);
                          $kwh_offpeak = round($row['kwh_offpeak1'] + $row['kwh_offpeak2'] + $row['kwh_offpeak3']  ,2);

                          $kwh_dev_peak = round($row['kwh_dev_peak1'] + $row['kwh_dev_peak2'] + $row['kwh_dev_peak3']  ,2);
                          $kwh_dev_offpeak = round($row['kwh_dev_offpeak1'] + $row['kwh_dev_offpeak2'] + $row['kwh_dev_offpeak3']  ,2);
                          array_push($splitval, array($row['trid'],$row['c1'],$row['c2'],$row['c3'],$v1,$v2,$v3,$row['pf1'],$row['pf2'],$row['pf3']));

                          $totalPeak = $totalPeak + $row['peak'];
                          $totalOffPk = $totalOffPk + $row['offpeak'];
                          $maxCurrent = max($row['c1'],$row['c2'],$row['c3']);
                         array_push($values,array($row['trid'],$row['name'],$timediff,$avgVoltage,$sumCurrent,$maxCurrent,$totalKVA,$avgPf,$row['offpeak'],$row['peak'],$row['datetime'],$row['NC'],$row['NL'],$row['NUL'], $kwh_peak, $kwh_offpeak, $kwh_dev_peak, $kwh_dev_offpeak,$row['status_out'],$row['switching'],$row['status']));
                      //   $q = "select * from tr_kwh_logs where trid = '".$row['trid']."' and  Datetime >= now() - INTERVAL 1 DAY order by id desc limit 100";
                    //     $result = $con->db->query($q);
                          
                            if ($timediff <=15)
                            {
                                if((max($row['c1'],$row['c2'],$row['c3'])>0.1 and $row['switching'] == 0) or ($row['status'] == "On" and $row['switching'] == 1)){
                                    $onc = $onc + 1;
                                  
                                }else{
                                  $offc = $offc + 1;
                                }
                
                            }
                          else
                          {
                              $offlc = $offlc + 1;
                          }
                          
                      }
                      
                   /*    $q = "SELECT fd_current_logs.* , feeder.name, feeder.mfactorcurrent,feeder.mfactorvoltage FROM `fd_current_logs`,feeder WHERE `fd_current_logs`.`trid`=feeder.trid and `fd_current_logs`.`id` in ( SELECT MAX(id) FROM fd_current_logs GROUP BY trid) order by trid";
                      $resultactive = $con->db->query($q);
                      $q = "select * from feeder";
                        $result2 = $con->db->query($q);*/
                      $chartdata = json_encode($chartdata);
                      $conn = null;
                $allc= $onc + $offc+ $offlc ;

                 
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
            {echo "<a href='transformer_dashboard.php?id=".$fdid."&status=OFF'>
                <button class='btn  btn-danger' style='background:red;border-color:red;><i class='icofont icofont-warning-alt'></i> Off $offc</button>
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
              if ($fdid != "0G0") {
                echo $fdid." Transformers";
              }else{
                echo "All Transformers";
              }
                ?>
                </b></h3>
          </div>
        </div>
      </div>
      </div>
    <div class="row">

      
              <?php
                $ona = 0;
                $offa = 0;
                $offla = 0;
                $count = sizeof($values);
                //echo $count;
                if(sizeof($values) > 0)
                {
                  for ($i=0; $i < $count ; $i++) {

                        if($values[$i][2] <= 15){
                          
                          if ((max($splitval[$i][1],$splitval[$i][2],$splitval[$i][3])>0.1 and $values[$i][19] == 0) or ($values[$i][20] == "On" and $values[$i][19] == 1)) {

                            if (($splitval[$i][4] < 180 and $splitval[$i][4]>0 )or($splitval[$i][5] < 180 and $splitval[$i][5]>0 ) or($splitval[$i][6] < 180 and $splitval[$i][6]>0 )) {
                              $color = "bg-gray"; 
                              $state = "Link Down";
                            }elseif (($splitval[$i][4] < 150 and $splitval[$i][4]>0 )or($splitval[$i][5] < 150 and $splitval[$i][5]>0 ) or($splitval[$i][6] < 150 and $splitval[$i][6]>0 )) {
                              $color = "bg-orange";
                              $state = "Under Voltage";
                            }elseif (($splitval[$i][4] > 250 ) or ($splitval[$i][5] > 250 ) or ($splitval[$i][6] > 250 )) {
                              $color = "bg-yellow";
                              $state = "Over Voltage";
                            }else{
                              $color = "bg-green";
                              $state = "On";
                            }
                          }
                          else
                          {
                            $color = "bg-red";
                            $state = "Off";
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


                        <div class="col col-md-3" data-toggle="popover" title="voltages = (<?php echo $splitval[$i][4].','.$splitval[$i][5].','.$splitval[$i][6].') currents=('.$splitval[$i][1].','.$splitval[$i][2].','.$splitval[$i][3].') PFs=('.$splitval[$i][7].','.$splitval[$i][8].','.$splitval[$i][9].')';?>">
                          <div class="box box-widget widget-user-2" style="text-align: center;">
                            <a>
                            <div class="widget-user-header <?php echo $color; ?>" >
                              
                              <h3><b><?php echo ($state == "Offline") ? "0": $values[$i][6]; ?> KVA</b></h3>
                              Status = <?php echo $state; ?> <br>
                              <h6><?php echo $values[$i][1]; ?></h6>
                              
                            </div>
                          </a>
                            <div class="box-footer no-padding" >
                                Device ID = <?php echo $values[$i][0];?> <br>
                                
                                Last Pulse: <?php echo date('d-m-y H:i',strtotime($values[$i][10])); ?><br>
                                Average Voltage = <?php echo ($state == "Offline") ? "0": $values[$i][3]; ?> Volts<br>
                                Total Current = <?php echo ($state == "Offline") ? "0": $values[$i][4]; ?> Amps<br>
                                Average Power Factor = <?php echo ($values[$i][7] > 0.7) ? $values[$i][7] : " .72 (NC)";  ?> <br>
                                
                                Neutral Current = <?php echo $values[$i][11]; ?> <br>
                                <br>

                              <?php 

                        if($state == "On" or $state == "Link Down" or $state == "Under Voltage" or $state == "Over Voltage"){
                          ?>

                        <button class='btn btn-primary' onclick='window.location.href="transformer_device_dashboard.php?id=<?php echo $values[$i][0]; ?>"'>Details</button>
                        <!-- <button class='btn btn-primary' onclick='window.location.href="transformer_dd_nl_bnl.php?id=<?php //echo $values[$i][0]; ?>"'>NL-BNL</button> -->

                        <?php
                          if ($values[$i][19] == 1) {
                        

                          echo "<a href='change_pump_status.php?pumpid=".$values[$i][0]."&status=Off'><button class='btn btn-danger fa fa-edit'> OFF</button>
                                                    </a>"; 
                                            
                    

                                                   
                          }
                        ?>

                          <?php
                        }elseif ($state == "offline") {
                        ?>                         
                        
                        <button class='btn btn-primary'disabled="disabled">Details</button>
                        <!-- <button class='btn btn-primary' onclick='window.location.href="transformer_dd_nl_bnl.php?id=<?php //echo $values[$i][0]; ?>"'>NL-BNL</button> -->
                        <?php
                          if ($values[$i][19] == 1) {
                          ?>
                        <button class='btn btn-primary' onclick="#">Switch Disabled</button>

                        <?php                            
                          }
                        
                        }else
                        {
                          ?>
                        
                        <button class='btn btn-primary'disabled="disabled">Details</button>
                        <!-- <button class='btn btn-primary' onclick='window.location.href="transformer_dd_nl_bnl.php?id=<?php //echo $values[$i][0]; ?>"'>NL-BNL</button> -->
                        <?php
                          if ($values[$i][19] == 1) {
                          
                        echo "  <a href='change_pump_status.php?pumpid=".$values[$i][0]."&status=On'><button class='btn btn-success fa fa-edit'> ON</button>
                                                    s</a>"; 
                                                                           
                          }
                        
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
                else
                {
                  echo "<b>No Transformers Added Yet!</b>";
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
