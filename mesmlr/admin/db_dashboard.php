<?php
  include_once('check.php');
  authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>

  <?php $pageName = "Distribution Boxes Dashboard"?>
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
            
        <li class="header">Active DBs</li>
      
        <li class=" treeview">
                <a href="#">
                  <i class="fa fa-dashboard"></i> <span>Active DBs</span> 
                </a>
        </li>
        <?php
    date_default_timezone_set("Asia/Karachi");
    require_once("opendb.php"); 
    $values = array();
    $splitval = array();
    $totalPeak = 0;
    $totalOffPk= 0;
    $trid = $_GET['id'];

    $length = strlen($trid);
    // echo $trid;
    $status = $_GET['status'];
    $chartdata=array(array('y'=>'1 Jan', 'a'=>20,'b'=>30,'c'=>40),array('y'=>'2 Jan', 'a'=>30,'b'=>30,'c'=>40));
    $id  = $trid;
    $type  = 0;
    $onc = 0;
    $offlc=0;
    $offc =0;
    $allc=0;

    if ($trid == "0G0") {
      $q = "SELECT db.* from db";
    }else{
      $q = "SELECT db.* from db where TRIM(SUBSTRING(TRIM(dbid),1,$length))='".$trid."'";
      echo $q;
      }
      $q1 = "select * from transformer where trid = '".$trid."'";

      $totalPeak = 0;
      $totalOffPk= 0;
      $name = 'All Distribution Boxess';
      $resultFeeder = $conn -> query($q1) or die("Query error");
      
      foreach($resultFeeder as $row){
        $totalPeak = $row['peak'];
        $totalOffPk= $row['offpeak'];
        $name = $row['name'];
      }

      $resultactive = $conn -> query($q) or die("Query error");
      foreach($resultactive as $row){
        $currenttime = date('y-m-d H:i:s');
        $lasttime =$row['datetime'];

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
        $connectiontimedifference = abs(ceil((strtotime($row['connectiondate']) - $lasttime)/60));
        if ($connectiontimedifference > 0)
        $timediff = abs(ceil(($currenttime-$lasttime)/60));
        else
        {
            $timediff = 20000;
            $row['datetime'] = 'Never';
        }
        $avgVoltage  = round(($row['v1']+$row['v2']+$row['v3'])/3 ,2);
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
// $NC = round($row['NC'],2);
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
        
        $avgPf_line1 = round(($row['line1_pf1']+$row['line1_pf2']+$row['line1_pf3'])/3,2);
        $avgPf_line2 = round(($row['line2_pf1']+$row['line2_pf2']+$row['line2_pf3'])/3,2);
        $avgPf_line3 = round(($row['line3_pf1']+$row['line3_pf2']+$row['line3_pf3'])/3,2);
        $avgPf_line4 = round(($row['line4_pf1']+$row['line4_pf2']+$row['line4_pf3'])/3,2);
                                                      
         // $id = explode('D',$row['trid']);
        $totalPeak = $totalPeak + $row['peak'];
        $totalOffPk = $totalOffPk + $row['offpeak'];
        $maxCurrent_line1 = max($row['line1_c1'],$row['line1_c2'],$row['line1_c3']);
        $maxCurrent_line2 = max($row['line2_c1'],$row['line2_c2'],$row['line2_c3']);
        $maxCurrent_line3 = max($row['line3_c1'],$row['line3_c2'],$row['line3_c3']);
        $maxCurrent_line4 = max($row['line4_c1'],$row['line4_c2'],$row['line4_c3']);
        $maxCurrent =max($maxCurrent_line1,$maxCurrent_line2,$maxCurrent_line3,$maxCurrent_line4);

        
        array_push($splitval, array($row['dbid'],$row['line1_c1'],$row['line1_c2'],$row['line1_c3'],$row['line2_c1'],$row['line2_c2'],$row['line2_c3'],$row['line3_c1'],$row['line3_c2'],$row['line3_c3'],$row['line4_c1'],$row['line4_c2'],$row['line4_c3'],$row['v1'],$row['v2'],$row['v3'],$row['line1_pf1'],$row['line1_pf2'],$row['line1_pf3'],$row['line2_pf1'],$row['line2_pf2'],$row['line2_pf3'],$row['line3_pf1'],$row['line3_pf2'],$row['line3_pf3'],$row['line4_pf1'],$row['line4_pf2'],$row['line4_pf3']));

        array_push($values,array($row['dbid'],$row['name'],$timediff,$avgVoltage,$sumCurrent_line1,$sumCurrent_line2,$sumCurrent_line3,$sumCurrent_line4,$maxCurrent,$totalline1_kva,$totalline2_kva,$totalline3_kva,$totalline4_kva,$avgPf_line1,$avgPf_line2,$avgPf_line3,$avgPf_line4,$row['offpeak'],$row['peak'],$row['datetime'], $row['noOFCT'], $row['dbtype'], $total_kva, $totalcurrent));

          if ($timediff <=360)
          {
            if ($maxCurrent>0.1)
            {
                $onc = $onc +1;
            }
            else
            {
                $offc = $offc + 1;
            }
          }
         else
         {
             $offlc = $offlc + 1;
         }
    }
  
        $chartdata = json_encode($chartdata);
        
        $allc = $onc+$offc+$offlc;
       
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
      <div class="row">
       
          <!-- <p id="ifr" align="center" style="overflow-x:auto;">
            <iframe name="Right" src="loadgraph_db.php?id=I1F1TR01DB01&type=1&name=Distribution Box 1" width="900" height="400" frameborder="0" ></iframe>
      </p>    -->

      </div>

<?php echo "<div class = 'row'>";
       echo "<div class='col-md-6'>";
            if ($status==='ON')
            {
            echo "<a href='db_dashboard.php?id=".$trid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {
              echo "<a href='db_dashboard.php?id=".$trid."&status=ON'>
                <button class='btn btn-success'><i class='icofont icofont-check-circled'></i> On $onc</button>
            </a>";  
            }
            if ($status==='OFL')
            {
            echo "<a href='db_dashboard.php?id=".$trid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {echo "<a href='db_dashboard.php?id=".$trid."&status=OFL'>
                <button class='btn  btn-warning' style='background:blue;border-color:blue;><i class='icofont icofont-warning-alt'></i> Offline $offlc</button>
            </a>";
            }
            if ($status==='OFF')
            {
            echo "<a href='db_dashboard.php?id=".$trid."&status=all'>
                <button class='btn btn-warning'><i class='icofont icofont-check-circled'></i> ALL $allc</button>
            </a>";
            }
            else
            {
            echo "<a href='db_dashboard.php?id=".$trid."&status=OFF'>
                <button class='btn btn-danger'><i class='icofont icofont-eye-alt'></i> Off $offc</button>
            </a>";

            }
        echo    "</div>";
           
       echo "</div>";


        $count3 = 0;
        $count1 = 0;
        for($i = 0 ; $i < sizeof($values); $i++) {
          if ($values[$i][21] == 1 or $values[$i][2] == 3) {
            $count3 += 1;
          }

          if ($values[$i][21] == 0 or $values[$i][21] == 2) {
            $count1 += 1;
          }

        }
        if ($count3 > 0) {
          $tree3 = "";
        }else{
          $tree3 = "hidden";
        }

        if ($count1 > 0) {
          $tree1 = "";
        }else        {
          $tree1 = "hidden";
        }

        if ($tree3 == "hidden" and $tree1 == "hidden") {
          echo "<b>---No Devices Added Yet!</b>";
        }

       ?>
        
        <br>
      <div class="row">
    <div class="col col-md-4 col-md-offset-4">
        <div class="box box-widget widget-user-2" style="text-align: center;">
          <div class="widget-user-header bg-green" >
            <h3><b>
              <?php
                if ($trid == "0G0") {
                   echo "All Distribution Boxes (Single Phase)";   
                }else
                {
                  echo $trid." Distribution Boxes (Single Phase)";   
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
                    if ($values[$i][21] == 0 or $values[$i][21] == 2) {
                      
                        if($values[$i][2] <= 360){
                          
                          if (max($splitval[$i][1],$splitval[$i][2],$splitval[$i][3]) > 0.1) {

                            if ($splitval[$i][13] < 180 and $splitval[$i][13]>0 ) {
                              $color = "bg-gray"; 
                              $state = "Link Down";
                            }elseif ($splitval[$i][13] < 200 and $splitval[$i][13]>0 ) {
                              $color = "bg-orange";
                              $state = "Under Voltage";
                            }elseif (($splitval[$i][13] > 250 ) or ($splitval[$i][13] > 250 ) or ($splitval[$i][13] > 250 )) {
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


                        <div class="col col-md-3" data-toggle="popover" title="voltages = (<?php echo $splitval[$i][13].','.$splitval[$i][14].','.$splitval[$i][15].') currents_line1=('.$splitval[$i][1].','.$splitval[$i][2].','.$splitval[$i][3].') currents_line2=('.$splitval[$i][4].','.$splitval[$i][5].','.$splitval[$i][6].') currents_line3=('.$splitval[$i][7].','.$splitval[$i][8].','.$splitval[$i][9].') currents_line4=('.$splitval[$i][10].','.$splitval[$i][11].','.$splitval[$i][12].') PF_line1=('.$splitval[$i][16].','.$splitval[$i][17].','.$splitval[$i][18].') PF_line2=('.$splitval[$i][19].','.$splitval[$i][20].','.$splitval[$i][21].') PF_line3=('.$splitval[$i][22].','.$splitval[$i][23].','.$splitval[$i][24].') PF_line4=('.$splitval[$i][25].','.$splitval[$i][26].','.$splitval[$i][27].')';?>">
                          <div class="box box-widget widget-user-2" style="text-align: center;">
                            <a href='cust_dashboard.php?id=<?php echo $values[$i][0]; ?>&status=all'>
                            <div class="widget-user-header <?php echo $color; ?>" >
                              
                              <h3><b><?php echo $values[$i][22]; ?> KVA</b></h3>
                              Status = <?php echo $state; ?> <br>
                              <h5><?php echo $values[$i][1]; ?></h5>
                              
                            </div>
                          </a>
                            <div class="box-footer no-padding" >
                                Device ID = <?php echo $values[$i][0];?> <br>                       
                                Last Pulse: <?php echo $values[$i][19]; ?><br>
                                Voltage = (<?php echo $splitval[$i][13]; ?>,<?php echo $splitval[$i][14]; ?>,<?php echo $splitval[$i][15]; ?>) Volts<br>
                                Total Current = <?php echo $values[$i][23];?> Amps<br>
                                Average Power Factor = <?php echo ($values[$i][13] > 0.7) ? $values[$i][13] : " .72 (NC)";  ?> <br>
                                Total Consumers Connected = <?php echo $values[$i][20]; ?><br>
                                </a><br>

                                <?php if($state == "On"){
                                  ?>
                               <!--  <button class='btn btn-primary' onclick="refreshIframe('loadgraph_db.php?id=<?php echo $values[$i][0]; ?>&type=1&name=<?php echo $values[$i][1]; ?>');">Graphs</button> -->
                                <button class='btn btn-primary' onclick='window.location.href="db_device_dashboard.php?id=<?php echo $values[$i][0]; ?>&type=1"'>Details</button>
                                <button class='btn btn-primary'>Switch Off</button>
                                  <?php
                                }else{
                                ?>                         
                                <!-- <button class="btn btn-primary" disabled>Graphs</button> -->
                                <button class='btn btn-primary'>Details</button>
                                <button class='btn btn-primary'>Switch On</button>
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
                    
                }
                else
                {
                  echo "<b>No Single Phase Distribtion Box Added Yet!</b>";
                }
              ?>
              

    </div>

    <div class="row">
    <div class="col col-md-4 col-md-offset-4">
        <div class="box box-widget widget-user-2" style="text-align: center;">
          <div class="widget-user-header bg-green" >
            <h3><b>
              <?php
                if ($trid == "0G0") {
                   echo "All Distribution Boxes (Three Phase)";   
                }else
                {
                  echo $trid." Distribution Boxes (Three Phase)";   
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
                    if ($values[$i][21] == 1 or $values[$i][21] == 3) {
                      
                        if($values[$i][2] <= 360){
                          
                          if (max($splitval[$i][1],$splitval[$i][2],$splitval[$i][3]) > 0.1) {

                            if (($splitval[$i][13] < 180 and $splitval[$i][13]>0 )or($splitval[$i][14] < 180 and $splitval[$i][14]>0 ) or($splitval[$i][15] < 180 and $splitval[$i][15]>0 )) {
                              $color = "bg-gray"; 
                              $state = "Link Down";
                            }elseif (($splitval[$i][13] < 200 and $splitval[$i][13]>0 )or($splitval[$i][14] < 200 and $splitval[$i][14]>0 ) or($splitval[$i][15] < 200 and $splitval[$i][15]>0 )) {
                              $color = "bg-orange";
                              $state = "Under Voltage";
                            }elseif (($splitval[$i][13] > 250 ) or ($splitval[$i][14] > 250 ) or ($splitval[$i][15] > 250 )) {
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
                            goto skip1;
                        }elseif($status === "OFL" and ($state ==="Off" or $state === "On" or $state === "Under Voltage" or $state === "Over Voltage" or $state === "Link Down")) {
                            goto skip1;
                        }elseif ($status === "OFF" and ($state ==="Offline" or $state === "On" or $state === "Under Voltage" or $state === "Over Voltage" or $state === "Link Down")) {
                            goto skip1;   
                        }
                        
                        ?>


                        <div class="col col-md-3" data-toggle="popover" title="voltages = (<?php echo $splitval[$i][13].','.$splitval[$i][14].','.$splitval[$i][15].') currents_line1=('.$splitval[$i][1].','.$splitval[$i][2].','.$splitval[$i][3].') currents_line2=('.$splitval[$i][4].','.$splitval[$i][5].','.$splitval[$i][6].') currents_line3=('.$splitval[$i][7].','.$splitval[$i][8].','.$splitval[$i][9].') currents_line4=('.$splitval[$i][10].','.$splitval[$i][11].','.$splitval[$i][12].') PF_line1=('.$splitval[$i][16].','.$splitval[$i][17].','.$splitval[$i][18].') PF_line2=('.$splitval[$i][19].','.$splitval[$i][20].','.$splitval[$i][21].') PF_line3=('.$splitval[$i][22].','.$splitval[$i][23].','.$splitval[$i][24].') PF_line4=('.$splitval[$i][25].','.$splitval[$i][26].','.$splitval[$i][27].')';?>">
                          <div class="box box-widget widget-user-2" style="text-align: center;">
                            <a href='cust_dashboard.php?id=<?php echo $values[$i][0]; ?>&status=all'>
                            <div class="widget-user-header <?php echo $color; ?>" >
                              
                              <h3><b><?php echo $values[$i][22]; ?> KVA</b></h3>
                              Status = <?php echo $state; ?> <br>
                              <h5><?php echo $values[$i][1]; ?></h5>
                              
                            </div>
                          </a>
                            <div class="box-footer no-padding" >
                                Device ID = <?php echo $values[$i][0];?> <br>
                                Last Value received at <?php echo $values[$i][19]; ?> <br>
                                Average Voltage = <?php echo $values[$i][3]; ?> Volts <br>
                                Total Current Line 1 = <?php echo $values[$i][4] ;?> Amps <br>
                                Total Current Line 2 = <?php echo $values[$i][5] ;?> Amps <br>
                                Total Current Line 3 = <?php echo $values[$i][6] ;?>Amps <br>
                                Average Power Factor Line 1 = <?php echo $values[$i][13]>0.6 ? $values[$i][13] : $values[$i][13]."(NC)"; ?> <br>
                                Average Power Factor Line 2 = <?php echo $values[$i][14]>0.6 ? $values[$i][14] : $values[$i][14]."(NC)"; ?> <br>
                                Average Power Factor Line 3 = <?php echo $values[$i][15]>0.6 ? $values[$i][15] : $values[$i][15]."(NC)"; ?> <br>
                                Total KVA Line 1= <?php echo $values[$i][9] ; ?><br>
                                Total KVA Line 2= <?php echo $values[$i][10]; ?><br>
                                Total KVA Line 3= <?php echo $values[$i][11]; ?><br>
                                <br>


                              <?php 

                        if($state == "On" or $state == "Link Down" or $state == "Under Voltage" or $state == "Over Voltage"){
                          ?>
                       <!-- <button class='btn btn-primary' onclick="refreshIframe('loadgraph_db.php?id=<?php echo $values[$i][0]; ?>&type=1&name=<?php echo $values[$i][1]; ?>');">Graphs</button> -->
                      <button class='btn btn-primary' onclick='window.location.href="db_device_dashboard.php?id=<?php echo $values[$i][0]; ?>&type=3"'>Details</button>

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
                      skip1:
                   }

                   } 
                    
                }
                else
                {
                  echo "<b>No Three Phase Distribtion Box Added Yet!</b>";
                }
              ?>
              

    </div>

            <script type="text/javascript">

        function refreshIframe(path) {
          var ifr = document.getElementsByName('Right')[0];
          ifr.src = path;
        }
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
