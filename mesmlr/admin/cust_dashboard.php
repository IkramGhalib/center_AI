<?php
  // include_once('check.php');
  // authenticate("can_view");
?>
<!DOCTYPE html>
<html>
<head>

  <?php $pageName = "Connection Dashboard";?>

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
            
        <li class="header">Active Connections</li>
      
        <li class=" treeview">
                <a href="#">
                  <i class="fa fa-dashboard"></i> <span>Active Connections</span> 
                </a>
        </li>
         <?php
   date_default_timezone_set("Asia/Karachi");
    
   require_once("opendb.php"); 
 //     $con = new DBCon();
      $values = array();
      $splitval = array();
      $status = "";
      $totalPeak = 0;
      $totalOffPk= 0;
      if ($_GET['id']) {
        $cid = $_GET['id'];  
      }else{
        $cid = "0G0";
      }
      
      $id  = $cid;
      $type  = 0; 
      $q_db = "select status from db_status where dbid = '$cid'";
      echo $q_db;
      $result = $conn -> query($q_db) or die("Query Error");

      foreach ($result as $row) {
        $db_status = $row['status'];
      }

      $split_status =  str_split($db_status, 1);

      $q = "SELECT * from connections where substring_index(cid,'C',1)='".$cid."'";
          
      $totalPeak = 0;
      $totalOffPk= 0;
         

        $resultactive = $conn -> query($q) or die("Query error");
//echo $q;                              
        $index=0;
        
          foreach($resultactive as $row){
               $currenttime = date('Y-m-d H:i:s');
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


               $timediff = abs(ceil(($currenttime-$lasttime)/60));
               $avgVoltage  = round(($row['v1']+$row['v2']+$row['v3'])/3 ,2);
               $sumCurrent = round(($row['c1']+ $row['c2'] + $row['c3']),2);
// $NC = round($row['NC'],2);
              $kva1 = round($row['c1'] * $row['v1']/1000,2);
              $kva2 = round($row['c2'] * $row['v2']/1000 ,2);
              $kva3 = round($row['c3'] * $row['v2']/1000 ,2);
              $totalKVA  = round(($kva1 + $kva2 + $kva3),2);
              $avgPf = round(($row['pf1']+$row['pf2']+$row['pf3'])/3,2);
               // $id = explode('D',$row['cid']);
              $totalPeak = $totalPeak + $row['peak'];
              $totalOffPk = $totalOffPk + $row['offpeak'];
              $maxCurrent = max($row['c1'],$row['c2'],$row['c3']);
             array_push($values,array($row['cid'],$row['name'],$timediff,$avgVoltage,$sumCurrent,$maxCurrent,$totalKVA,$avgPf,$row['offpeak'],$row['peak'], $row['datetime'], $row['switch']));

			array_push($splitval, array($row['cid'],$row['slot1'],$row['slot2'],$row['slot3'],round($row['c1'],2),round($row['c2'],2),round($row['c3'],2),round($row['pf1'],2),round($row['pf2'],2),round($row['pf3'],2),round($row['v1'],2),round($row['v2'],2),round($row['v3'],2),round($row['kwhpeak1'],2),round($row['kwhpeak2'],2),round($row['kwhpeak3'],2),round($row['kwhoffpeak1'],2),round($row['kwhoffpeak2'],2),round($row['kwhoffpeak3'],2)));

          //   $q = "select * from tr_kwh_logs where cid = '".$row['cid']."' and  Datetime >= now() - INTERVAL 1 DAY order by id desc limit 100";
        //     $result = $con->db->query($q);
              
                
              
          }
          
         // $conn = null;
     
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

    <!-- Right side column. Contains the navbar and content of the page -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
  
	<br>
	<br>

  <div class="row">
    <div class="col col-md-4 col-md-offset-4">
        <div class="box box-widget widget-user-2" style="text-align: center;">
          <div class="widget-user-header bg-green" >
            <h3><b>
              <?php
                if ($id == "0G0") {
                   echo "All Connections";   
                }else
                {
                	$name_query = "select name from db where dbid = '".$id."'";
                	$name = "";
                	$result = $conn -> query($name_query) or die(error);
                	foreach ($result as $row) {
                		$name = $row['name'];
                	}
                  echo $name." Connections"; 
                  $conn = NULL;  
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

                            if (($splitval[$i][10] < 100 and $splitval[$i][10]>0 )or($splitval[$i][11] < 100 and $splitval[$i][11]>0 ) or($splitval[$i][12] < 100 and $splitval[$i][12]>0 )) {
                              $color = "bg-gray"; 
                              $state = "Link Down";
                            }elseif (($splitval[$i][10] < 150 and $splitval[$i][10]>0 )or($splitval[$i][11] < 150 and $splitval[$i][11]>0 ) or($splitval[$i][12] < 150 and $splitval[$i][12]>0 )) {
                              $color = "bg-orange";
                              $state = "Under Voltage";
                            }elseif (($splitval[$i][10] > 250 ) or ($splitval[$i][11] > 250 ) or ($splitval[$i][12] > 250 )) {
                              $color = "bg-yellow";
                              $state = "Over Voltage";
                            }else{
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


                        <div class="col-md-3">
                          <div class="box box-widget widget-user-2" style="text-align: center;">
                            
                            <div class="widget-user-header <?php echo $color; ?>" >
                              
                              <h3><b><?php echo ($state == "Offline") ? "0" : $values[$i][6]; ?> KVA</b></h3>
                              <h5><?php echo $values[$i][1]; ?></h5>
                              
                            </div>
                       
                            <div class="box-footer no-padding" >
                                Device ID = <?php echo $values[$i][0];?> <br>
                                Status = <?php echo $state; ?> <br>
                                Last Pulse: <?php echo $values[$i][10]; ?><br>
                                Average Voltage = <?php echo ($state == "Offline") ? "0" : $values[$i][3]; ?> Volts<br>
                                Total Current = <?php echo ($state == "Offline") ? "0" : $values[$i][4]; ?> Amps<br>
                                Average Power Factor = <?php echo ($values[$i][7] > 0.7) ? $values[$i][7] : " .72 (NC)";  ?> <br>
                                Consumed Units = <?php echo $values[$i][8]+$values[$i][9]; ?><br>
                                <br>

                              <?php 
                              
                              $c_no = explode('N',$values[$i][0]);
                              
                              $index = (int)$c_no[1];
                              
                              //echo $split_status[$index-1];
                              $id_split = explode("DB", $values[$i][0]);
                              ?>
                               <button class='btn btn-primary' onclick='window.location.href="connection_device_dashboard.php?id=<?php echo $values[$i][0]; ?>&type=<?php echo ($splitval[$i][2] > 0 ? 3 : 1); ?>"'>Details</button>
                               
                              <?php
                              // print_r($values);
                              // die;

                              if ($values[$i][11] == 1) {
                               
                              if($split_status[$index-1] == 1){
                                
                                 
                              
                                ?>
                                <button class='btn btn-danger' onclick='window.location.href="switch_conn.php?id=<?php echo $values[$i][0]; ?>"'>Switch off</button>
                                <?php
                              }else{
                                  ?>
                              <button class='btn btn-success' onclick='window.location.href="switch_conn.php?id=<?php echo $values[$i][0]; ?>"'>Switch On</button>
                              <?php
                              }
                            ?>
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
                else
                {
                  echo "<b>No Distribtion Box Added Yet!</b>";
                }
              ?>
              

    </div>


          
<table width="100%" border="0"></table>
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
