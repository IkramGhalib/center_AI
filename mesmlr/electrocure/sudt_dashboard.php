
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
                                      $totalPeak = 0;
                                      $totalOffPk= 0;
                                      if ($_GET) {
                                        $cid = $_GET['id'];  
                                      }else{
                                        $cid = "0G0";
                                      }
                                      
                                    //  $chartdata=array(array('y'=>'1 Jan', 'a'=>20,'b'=>30,'c'=>40),array('y'=>'2 Jan', 'a'=>30,'b'=>30,'c'=>40));
                                      $id  = $cid;
                                      $type  = 0; //0 kvar, 1kwh, 2 kva
                                    //  $totalConsumtion = 0;
                                      
                                      if ($cid == "0G0") {
                                        $q = "SELECT * from connections";
                                         $name = 'All Connections';
                                          
                                      }else{
                                        $q = "SELECT * from connections where substring_index(cid,'C',1)='".$cid."'";
                                          $q_db = "select dbid,name from db where dbid = '".$cid."'";
                                          echo $q_db;
                                          $result = $conn -> query($q_db) or die("Query error");
                                          foreach($result as $row)
                                          {
                                              $name = $row['dbid'].'--'.$row['name'];
                                          }
                                        }
                             
    
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
                                               $sumCurrent = round(($row['c1']+ $row['c2'] + $row['c3'])/3,2);
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
                                             array_push($values,array($row['cid'],$row['name'],$timediff,$avgVoltage,$sumCurrent,$maxCurrent,$totalKVA,$avgPf,$row['offpeak'],$row['peak']));
                                          //   $q = "select * from tr_kwh_logs where cid = '".$row['cid']."' and  Datetime >= now() - INTERVAL 1 DAY order by id desc limit 100";
                                        //     $result = $con->db->query($q);
                                              
                                                if ($timediff <=1440)
                                                {
                                                    if (max($row['c1'],$row['c2'],$row['c3'])>0.1)
                                                    {
                                                        if($index==0)
                                                        {
                                                        $activeid = $row['cid'];
                                                        $activename = $row['cid'].'--'.$row['name'];
                                                         $index = 1;
                                                        }
                                                      ?>
                                                        <li class= 'treeview'>
                                                          <a href="connection_device_dashboard.php?id=<?php echo $row['cid']; ?>">
                                                            <span><?php echo $row['name']; ?></span> 
                                                          </a>
                                                        </li>
                                                        <?php
                                                    }
                                                    
                                                }
                                              
                                          }
                                          
                                       /*    $q = "SELECT fd_current_logs.* , feeder.name, feeder.mfactorcurrent,feeder.mfactorvoltage FROM `fd_current_logs`,feeder WHERE `fd_current_logs`.`cid`=feeder.cid and `fd_current_logs`.`id` in ( SELECT MAX(id) FROM fd_current_logs GROUP BY cid) order by cid";
                                          $resultactive = $con->db->query($q);
                                          $q = "select * from feeder";
                                            $result2 = $con->db->query($q);*/
                                //          $chartdata = json_encode($chartdata);
                                          $conn = null;
                                     
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


  <p id="ifr" align="center">
            <iframe name="Right" src="loadgraph_connection.php?id=<?php echo $activeid;?> &type=1&name=<?php echo $activename;?>" width="810" height="400" frameborder="0" ></iframe>
      </p>
    <!-- Main content -->
    <section class="content">
      
  <div class="tree" border="2px">
   
  <ul>
    <li>
         <?php

  echo "    <a href='device_dashboard_total.php' style='background-color: #53e002'>
        <h3><b>Distribution Box</b></h3> <br>
               
      </a>";?>
        <br>
          
  <ul>
      <?php  
                $count = sizeof($values);
             if(sizeof($values) > 0)
            {
                 for ($i=0 ; $i<$count; $i++)
                {
                    
                    if ($values[$i][2] < 180  and $values[$i][5]>0.1 )
                    {
                        //echo $values[$i][1];
                        echo " <li>
                       <a href='#' style='background-color: #53e002'>
                        <b>".$values[$i][0]."--".$values[$i][1]."</b>
                       <br>
                       Status = On <br>";
                    }
                    elseif($values[$i][2] > 180)
                    {
                      echo " <li>
                       <a href='#' style='background-color: #2b80db'>
                        <b>".$values[$i][0]."--".$values[$i][1]."</b> <br>
                        ";
                      echo " 
                        Status = Offline <br>";
                    }else
                    {
                      echo " <li>
                       <a href='#' style='background-color: #f73d3d'>
                        <b>".$values[$i][0]."--".$values[$i][1]."</b> <br>
                        ";
                           echo "
                       Status = Off <br>";
          }
                       echo "
               Average Voltage = ".$values[$i][3]." Volts <br>
               Total Current = ".$values[$i][4]." Amps <br>
               Average Power Factor = ".$values[$i][7]." <br>
               Total KVA = ".$values[$i][6]."<br>
               </a><br>";
                     if ($values[$i][2] < 180  and $values[$i][5]>0.04 )
                    {       
               ?>
                    
              <button class="btn btn-primary" onclick="refreshIframe('loadgraph_transformer.php?id=<?php echo $values[$i][0];?>&type=1&name=<?php echo $values[$i][1]; ?>)">Graphs</button>
                        <button class='btn btn-primary' onclick='window.location.href="connection_device_dashboard.php?id=<?php echo $values[$i][0]; ?>&name=<?php echo $values[$i][1]; ?>"'>Details</button>
                     
                     <?php
                     }
                     else
                     {
                         ?>
                         
                         <button class="btn btn-primary" disabled>Graphs</button>
                        <button class='btn btn-primary' disabled>Details</button>
        
        
                         <?php
                     }
                     echo "</li>";
                     //call newData(peak,offpeak,cat) function of the javascript on each onclick function of the button and pass new data to the method.
                }
            }
            else
            {
                echo "No Connections Added ";
            }
        ?>
    
  </ul>
        </li>
        </ul>
  </div>    
      
    <!-- Right side column. Contains the navbar and content of the page -->
         <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
         <script type="text/javascript">

        function refreshIframe(path) {
          var ifr = document.getElementsByName('Right')[0];
          ifr.src = path;
        }
    </script>
                     <br>
        <br>
          <br>
        <div>
      
        <!-- /.content -->
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
<style>
  
    /*Now the CSS*/
* {margin: 0; padding: 0;}

      .tree ul {
        padding-top: 20px;
        position: relative;
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;

      }

      .tree li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
      }

      /*We will use ::before and ::after to draw the connectors*/

      .tree li::before, .tree li::after{
        content: '';
        position: absolute; top: 0; right: 50%;
        border-top: 1px solid black;
        width: 50%; height: 20px;


      }
      .tree li::after{


        right: auto; left: 50%;
        border-left: 1px solid black;
      }

      /*We need to remove left-right connectors from elements without 
      any siblings*/
      .tree li:only-child::after, .tree li:only-child::before {
        display: none;

      }

      /*Remove space from the top of single children*/
      .tree li:only-child{ padding-top: 0;
          }

      /*Remove left connector from first child and 
      right connector from last child*/
      .tree li:first-child::before, .tree li:last-child::after{
        border: 0 none
          ;
      }
      /*Adding back the vertical connector to the last nodes*/
      .tree li:last-child::before{
        border-right: 1px solid black;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;

      }
      .tree li:first-child::after{
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;

      }

      /*Time to add downward connectors from parents*/
      .tree ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 1px solid black;
        width: 0; height: 20px;

      }

      .tree li a{
        border: 1px solid black;
        padding: 5px 10px;
        text-decoration: none;
        color:black;
        font-family: arial, verdana, tahoma;
        font-size: 14px;
        display: inline-block;
        background-color:#FFFFFF;

        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
      }

      /*Time for some hover effects*/
      /*We will apply the hover effect the the lineage of the element also*/
      .tree li a:hover, .tree li a:hover+ul li a {
        background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
      }
      /*Connector styles on hover*/
      .tree li a:hover+ul li::after, 
      .tree li a:hover+ul li::before, 
      .tree li a:hover+ul::before, 
      .tree li a:hover+ul ul::before{
        border-color:#000000;
      }

/*Thats all. I hope you enjoyed it.
Thanks :)*/

</style>
</body>
</html>
