
<?php

    include("opendb.php");

    //$con = new DBCon();

            $fid = $_GET['pumpid'];
            $status = $_GET['status'];
            $status_out= 1;
            //$totalconsumption = 0.0;
            //date_default_timezone_set("Asia/Karachi");
            $dt = date("Y-m-d H:i:s");
            //$datetime = date('Y-m-d H:i:s');

            if ($status == 'Off')
            {
                $status_out=0;
                // $q = "select * from transformer WHERE trid = '".$fid."' ";
                // //echo $q;
                // $result = $con->db->query($q);
                // $row6 = mysqli_fetch_array($result);
                // $ontime = $row6['switch_time'];
                // $name = $row6['name'];            

                // if (strlen($row6['switch_time'])== 19 )
                //     $switchdatetime  = substr($row6['switch_time'],2);
                // else
                //     $switchdatetime = $row6['switch_time']; 
                // $ontime = $switchdatetime;
           
                // $lasttime=strtotime($switchdatetime); 
                // $currenttime = date('Y-m-d H:i:s');
                // if (strlen($currenttime)==19)
                //     $currenttime = strtotime(substr($currenttime,2));
                // else
                //     $currenttime = strtotime($currenttime);
            
                // $timediff = abs(ceil(($currenttime-$lasttime)/60));
                // $switchdatetime = strtotime($switchdatetime);
                // $pumping_capacity = $row6['pumping_capacity'];
                // $year 	  = date('Y');
                // $month	  = date('F');
                // $day      = explode('-',date('d-m-y'));
                // $gallonhr = round($timediff * $pumping_capacity/60,2);
                // $insert = "INSERT INTO `tr_kwh_daily`( `trid`, `offpeak`, `peak`, `year`, `month`, `day`, `timeswitchedOn`, `timeswitchedoff`, `total`,`yield`) VALUES ('".$fid."','".$row6['yieldoffpk']."','".$row6['yieldpk']."','".$year."','".$month."','".$day[0]."','".$ontime."','".$datetime."','".($row6['yieldoffpk']+$row6['yieldpk'])."','".$gallonhr."')";
                // echo $insert;
                // $result8 = $con->db->query($insert);                 
                    
            }
            $q = "update transformer set status = '".$status."' , cause = 'Online',status_out = '".$status_out."' WHERE trid = '".$fid."' "; 
            echo $q;
            $result = $conn -> query($q) or die(error);
           
                echo "<script> window.location.href = 'transformer_dashboard.php?id=0G0&status=all'; </script>";

            
        

?>