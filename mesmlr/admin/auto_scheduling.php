<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Switchings"?>



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
	<?php include_once('sidebar.php') ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  
  <div class="content-wrapper" style="margin-top: <?php echo $contentmargin?>px">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
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
     
                   <button id="add-new-button" class="btn btn-primary" onClick="window.location.href='add_auto_schedule.php'"><b>+ Add Auto Switching Job</b></button>
                  <br>
                  <br>

    
    <div id="overflow" style="overflow-x:auto;">
    <table id="example1"  class="table table-responsive table-bordered table-striped">
    <thead class="bg-blue">
    <tr>
      <th>Device ID</th>
      <th>Location</th>
      <th>Start Time</th>
      <th>Off Time</th> 
      <th>Repeat</th> 
      <!--<th>Enable/Disable</th> -->

      <!-- <th>Auto Status</th>
      <th>Auto Time Adjustment</th> -->
      <!-- <th>Signal Strength</th> -->
      <th> Job Creation Date & Time</th>
       
       <th width="120">Actions</th>
    </tr>
    </thead>
    <tbody>

    <?php
    require_once("opendb.php");
    // $query1 = "SELECT trid, count(case when `offline_entry` > 5 then 1 end) as greater5, count(case when `offline_entry` <= 5 and `offline_entry`>2 then 1 end) as greater2, count(case when `offline_entry` <= 2 then 1 end) as less2, count(offline_entry) as total FROM `transformer_delay_logs` where date_time > DATE_SUB(NOW(),INTERVAL 1 HOUR) group by trid";
    // // where date_time > (now() - INTERVAL 1 DAY) ";
    // $result1 = $conn -> query($query1) or die(error);
    // $strength = array();

    // foreach ($result1 as $key1) {
    // 	$signalStrength = 0;
    //   $total = $key1['total'];
    //   $less2 = $key1['less2']/$key1['total']*100;
    //   $greater2 = $key1['greater2']/$key1['total']*100;
    //   $greater5 = $key1['greater5']/$key1['total']*100;

    // 	if ($less2>$greater2 and $less2 > $greater5) {
    // 		$signalStrength = 1; //Strong
    // 	}elseif ($less2<$greater2 and $greater2 > $greater5) {
    // 		$signalStrength = 2; // MODERATE
    // 	}else{
    // 		$signalStrength = 3; //WEAK
    // 	}
    //   array_push($strength, array($key1['trid'],$signalStrength,$total));    
    // }

    $query = "SELECT transformer.name , auto_switching.starttime , auto_switching.offtime , auto_switching.repeat,auto_switching.id,auto_switching.en_status,auto_switching.Datetime, auto_switching.actual_ontime , auto_switching.actual_offtime, transformer.datetime as lastpulse, auto_time_adjustment, transformer.trid FROM transformer , auto_switching WHERE transformer.trid = auto_switching.trid order by transformer.name";

    $result = $conn -> query($query) or die("Query error");
    foreach($result as $row){


                                       
                                       // $time_diff = date('Y-m-d H:i:s')." ".$row2['datetime'];
                                        echo "<tr>";
                                          echo "<td>" . $row['trid'] . "</td>";
                                            echo "<td>" . $row[0] . "</td>";
                                  
                        if ($row[1] == $row['actual_ontime'])
                            {
                              echo "<td>" . date('h:i:s a ', strtotime($row[1])). "</td>";
                              echo "<td>" . date('h:i:s a ', strtotime($row[2])). "</td>";
                            }
                              else
                              {
                               echo "<td>" . date('h:i:s a ', strtotime($row[1])).' (load.shd)' ."<br>" .date('h:i:s a ', strtotime($row['actual_ontime'])).' (act)' . "</td>";
                                echo "<td>" . date('h:i:s a ', strtotime($row[2])).' (load.shd)'. "<br>". date('h:i:s a ', strtotime($row['actual_offtime'])).' (act)'. "</td>";
                              }

                          
                          
                              if($row[3]==-1)
                              echo "<td> Never </td>";
                              elseif($row[3]==0)
                              echo "<td> Daily </td>";
                              elseif($row[3]==1)
                              echo "<td> Monday </td>";
                              elseif($row[3]==2)
                              echo "<td> Tuesday </td>";
                              elseif($row[3]==3)
                              echo "<td> Wednesday </td>";
                              elseif($row[3]==4)
                              echo "<td> Thursday </td>";
                              elseif($row[3]==5)
                              echo "<td> Friday </td>";
                              elseif($row[3]==6)
                              echo "<td> Saturday </td>";
                              elseif($row[3]==7)
                              echo "<td> Sunday </td>";
                              $signal = 1;
                              // if (ceil(abs(strtotime(date('Y-m-d H:i:s'))-strtotime(date('Y-m-d H:i:s',strtotime(substr($row['lastpulse'],2)))))/60)>15) {
                              //                      		// $signal = 0;
                              //                       echo "<td>
                              //                               <button class='btn btn-secondary'><span class='fa fa-power-off'></span> Offline</button>
                              //                                   </a>   
                              //                           </td>";
                                                         
                              //                            echo "<td>Offline</td>";
                              //                     }else{

                              //                       if ($row[5]==0)
                              //                       {
                              //                           echo "<td><a href='change_auto_enable_status.php?pumpid=".$row[4]."&en_status=1'>
                              //                               <button class='btn btn-primary'><span class='fa fa-power-off'></span> On</button>
                              //                                   </a>   
                              //                           </td>";
                              //                            echo "<td>Off</td>";
                              //                       }
                              //                       else
                              //                       {
                              //                          echo "<td><a href='change_auto_enable_status.php?pumpid=".$row[4]."&en_status=0'>
                              //                               <button class='btn btn-danger'><span class='fa fa-power-off'></span> Off</button>
                              //                                   </a>   
                              //                           </td>"; 
                              //                            echo "<td>On</td>";
                              //                       }
                              //                     }

                              //                     if ($row['auto_time_adjustment']==1)
                              //                       {
                              //                           echo "<td><a href='auto_time_adjustment.php?pumpid=".$row[4]."&status=1'>
                              //                               <button class='btn btn-danger'><span class='fa fa-power-off'></span>Disable</button>
                              //                                   </a>   
                              //                           </td>";
                              //                       }
                              //                       else
                              //                       {
                              //                          echo "<td><a href='auto_time_adjustment.php?pumpid=".$row[4]."&status=0'>
                              //                               <button class='btn btn-success'><span class='fa fa-power-off'></span> Enable</button>
                              //                                   </a>   
                              //                           </td>"; 
                              //                       }
                                                    // $count = 0;
                                                    // if ($signal == 0) {
                                                    // 	echo "<td style='color: red;'>No Signal</td>";
                                                    // }
  	                                                // else{

                                                    //   for($i=0; $i<sizeof($strength); $i++){
                                                    //   	if ($strength[$i][0] == $row['trid']) {
                                                    //   		if ($strength[$i][1] == 1) {
  		                                            //             echo "<td style='color: Green;'>Strong (".$strength[$i][2].")</td>";
  		                                            //             $count++;
  		                                            //           }elseif ($strength[$i][1] == 2) {
  		                                            //             echo "<td style='color: black;'>Moderate (".$strength[$i][2].")</td>";
  		                                            //             $count++;
  		                                            //           }elseif ($strength[$i][1] == 3) {
  		                                            //             echo "<td style='color: red;'>Weak (".$strength[$i][2].")</td>";
  		                                            //             $count++;
  		                                            //           }
                                                    //   	}
                                                    //   }
                                                     
  	                                                // }
                                               // echo "<td>".date('d-m-y H:i:s a',strtotime($row[5]))."</td>";
                                                   echo "<td>".$row["Datetime"]."</td>";              //echo "<td>" . $row[3] . "</td>";
                            echo "<td>" . $row[4] . "</td>";  
                            echo "<td><a href = 'edit_auto_switching.php?id=$row[4]&name=$row[0]&repeat=$row[3]'><button class = 'btn btn-primary'>Edit</button></a>";
                            echo " <button class = 'btn btn-danger' value='".$row[4]."' onclick = deleteVal(this.value)>Delete</button></a></td>";
                                    
                            echo "</tr>";
                                                                     
                                    
          
            ?>
                    

    <?php } ?>

    </tbody>
    </table>
  </div>
  <br>
  <button onclick="exportTableToCSV('auto_switching.csv')" class="btn btn-primary"><span class="fa fa-download"></span>&nbsp;Download</button>

 

    </section>
    <script>
      function deleteVal(val)
      {
        var conf= confirm("Do you really want to delete the job?");
        if (conf== true){
           window.open('delete_switching.php?pumpid='+val , '_self');
        }else{
          return;
        }
      };
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
