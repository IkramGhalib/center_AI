<?php
  // include_once('check.php');
  // authenticate("view");
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
                                        $q = "SELECT connections_db.*,db.name from connections_db,db where connections_db.dbid=db.dbid";
                                         $name = 'All Connections';
                                          
                                      }else{
                                        $q = "SELECT connections_db.*,db.name from connections_db,db where connections_db.dbid='".$cid."' and db.dbid= '".$cid."'";
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
                                //           array_push($values,array($row['cid'],$row['name'],$timediff);
                                          //   $q = "select * from tr_kwh_logs where cid = '".$row['cid']."' and  Datetime >= now() - INTERVAL 1 DAY order by id desc limit 100";
                                        //     $result = $con->db->query($q);
                                              
                                                if ($timediff <=1440)
                                                {
                                                    if (max($row['c1'],$row['c2'],$row['c3'])>0.1)
                                                    {
                                                        if($index==0)
                                                        {
                                                        $activeid = $row['dbid'];
                                                        $activename = $row['dbid'].'--'.$row['name'];
                                                         $index = 1;
                                                        }
                                                      ?>
                                                        <li class= 'treeview'>
                                                          <a href="cust_dashboard.php?id=<?php echo $row['dbid']; ?>">
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
                                        $resultactive = $conn -> query($q) or die("Query error");
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
                                //           array_push($values,array($row['cid'],$row['name'],$timediff);
                                          //   $q = "select * from tr_kwh_logs where cid = '".$row['cid']."' and  Datetime >= now() - INTERVAL 1 DAY order by id desc limit 100";
                                        //     $result = $con->db->query($q);
                                              
                                               
                    if ($timediff <=1440 )
                    {
                        //echo $values[$i][1];
                        echo " <li>
                       <a href='cust_dashboard.php?id=".$row['dbid']."' style='background-color: #2FFFFF'>
                        <b>".$row['dbid'].'--'.$row['name']."</b>
                       <br>
                       Status = Online <br>";
                    }
                    else
                    {
                      echo " <li>
                       <a href='cust_dashboard.php?id=".$row['dbid']."' style='background-color: #2b80db'>
                        <b>".$row['dbid'].'--'.$row['name']."</b> <br>
                        ";
                      echo " 
                        Status = Offline <br>";
                    }
                       echo "
               Last Value Received at ".date('d-m-y h:i:s a',strtotime($row['datetime']))."
               V1 = ".$row['v1']." Volts , V2 = ".$row['v2']." Volts , V3 = ".$row['v3']." Volts <br>
               I1 = ".$row['c1']." Amps , I2 = ".$row['c2']." Amps <br> I3 = ".$row['c3']." Amps 
               I4 = ".$row['c4']." Amps <br> I5 = ".$row['c5']." Amps , I6 = ".$row['c6']." Amps <br>
               I7 = ".$row['c7']." Amps , I8 = ".$row['c8']." Amps <br> I9= ".$row['c9']." Amps <br>
               I10 = ".$row['c10']." Amps <br> I11 = ".$row['c11']." Amps , I12 = ".$row['c12']." Amps <br>
               I13 = ".$row['c13']." Amps , I14 = ".$row['c14']." Amps <br> I15 = ".$row['c15']." Amps 
               I16 = ".$row['c16']." Amps <br> I17 = ".$row['c17']." Amps , I18 = ".$row['c18']." Amps <br>
               I19 = ".$row['c19']." Amps , I20 = ".$row['c20']." Amps <br> I21 = ".$row['c21']." Amps 
               I22 = ".$row['c22']." Amps <br> I23 = ".$row['c23']." Amps , I24 = ".$row['c24']." Amps <br>
               I25 = ".$row['c25']." Amps , I26 = ".$row['c26']." Amps <br> I27 = ".$row['c27']." Amps 
               I28 = ".$row['c28']." Amps <br> I29 = ".$row['c29']." Amps , I30 = ".$row['c30']." Amps <br>
               I31 = ".$row['c31']." Amps , I32 = ".$row['c32']." Amps <br>
               PF1 = ".$row['pf1']." , PF2 = ".$row['pf2']." <br> PF3 = ".$row['pf3']." 
               PF4 = ".$row['pf4']." <br> PF5 = ".$row['pf5']." , PF6 = ".$row['pf6']." <br>
               PF7 = ".$row['pf7']." , PF8 = ".$row['pf8']." <br> PF9= ".$row['pf9']." <br>
               PF10 = ".$row['pf10']." <br> PF11 = ".$row['pf11']." , PF12 = ".$row['pf12']." <br>
               PF13 = ".$row['pf13']." , PF14 = ".$row['pf14']." <br> PF15 = ".$row['pf15']." 
               PF16 = ".$row['pf16']." <br> PF17 = ".$row['pf17']." , PF18 = ".$row['pf18']." <br>
               PF19 = ".$row['pf19']." , PF20 = ".$row['pf20']." <br> PF21 = ".$row['pf21']." 
               PF22 = ".$row['pf22']." <br> PF23 = ".$row['pf23']." , PF24 = ".$row['pf24']." <br>
               PF25 = ".$row['pf25']." , PF26 = ".$row['pf26']." <br> PF27 = ".$row['pf27']." 
               PF28 = ".$row['pf28']." <br> PF29 = ".$row['pf29']." , PF30 = ".$row['pf30']." <br>
               PF31 = ".$row['pf31']." , PF32 = ".$row['pf32']." <br>
               
               </a><br>";
                    
                     echo "</li>";
                     //call newData(peak,offpeak,cat) function of the javascript on each onclick function of the button and pass new data to the method.
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
