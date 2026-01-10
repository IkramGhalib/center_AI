<?php
date_default_timezone_set("Asia/Karachi");
$dbtype = "electrocure";
$subdivid_array= array("mes");
for ($sub_index=0; $sub_index< sizeof($subdivid_array); $sub_index++)
{
$subdivid = $subdivid_array[$sub_index];
echo $subdivid;
$dbhost = "10.13.144.6";
$dbuser = "user_".$subdivid;
$dbpass =  "Adm1n@".$subdivid;
$dbname =  $dbtype."_".$subdivid;
 // date_default_timezone_set("Asia/Karachi");
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$sql = "select * from connections order by cid ";

$arrayData = array();
$arrayData_index = array();
$db_update_index = array();
	//	$yeild_update_index = array();
		$db_index = 0;
		$last_index = '0';
		$result1 = mysqli_query($db,$sql);
		
		while($row = mysqli_fetch_array($result1))
		{  
			$new_index = explode('CN',$row['cid']);
			
			  $last_index = $new_index[0];
			    $arrayData_index[]=$last_index;
            
            array_push($arrayData,array($row['cid'],$row['offpeak'],$row['peak'],$row['datetime'],$row['v1'],$row['v2'],$row['v3'],$row['c1'],$row['c2'],$row['c3'],$row['pf1'],$row['pf2'],$row['pf3'],$row['kwhpeak1'],$row['kwhpeak2'],$row['kwhpeak3'],$row['kwhoffpeak1'],$row['kwhoffpeak2'],$row['kwhoffpeak3'],$row['slot1'],$row['slot2'],$row['slot3'],$last_index));
		}

//var_dump($arrayData_index);

    $sql = "SELECT a.* from raw_user_current_log a
            inner join(SELECT moduleid, MAX(server_date_time) pdt
            from raw_user_current_log where server_date_time > now() - interval 4 minute  GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and a.server_date_time >now() - interval 4 minute";

		$result = mysqli_query($db,$sql);
       // $result_save = $result;
		$insert = "INSERT INTO cust_current_logs (cid, v1,v2,v3,c1,c2,c3,pf1,pf2,pf3,datetime) VALUES";
     //   $insertkwh = "INSERT INTO cust_kwh_logs (cid,kwh1,kwh2,kwh3,offpeak,peak,offpkunits,pkunits,pkflg,datetime) VALUES";
		//$insertkwh = "INSERT INTO  `db_kwh_logs`  (`dbid`, `offpeak`, `peak`,`offpkunits`,`pkunits`line1_kwh1,line1_kwh2,line1_kwh3,line2_kwh1,line2_kwh2,line2_kwh3,line3_kwh1,line3_kwh2,line3_kwh3,line4_kwh1,line4_kwh2,line4_kwh3,datetime,`pkflg`) VALUES";
	$index_row= 0 ;
    $count = mysqli_num_rows($result);
    $index= 0;
    $cn_update_index = array();
    while($rowdata = mysqli_fetch_array($result))
	{
       
       
      
                $db_index = array_search($rowdata['moduleid'],$arrayData_index);
        
//echo $arrayData[$db_index][0];
        
		while ($rowdata['moduleid']==$arrayData[$db_index][22])
		{
			$rowdata['server_date_time'] = date('Y-m-d H:i:00',strtotime($rowdata['server_date_time']));
            if($index == 0)
            {
                $index = 1;
            }
            else
               $insert = $insert . ","; 
            
            if ($arrayData[$db_index][20]== -1)
            {
                $insert = $insert . "('".$arrayData[$db_index][0]."','".($rowdata['v_red']/100)."','".($rowdata['v_blue']/100)."','".($rowdata['v_yellow']/100)."','".($rowdata['i'.$arrayData[$db_index][19]]/100)."',0,0,'".($rowdata['pf'.$arrayData[$db_index][19]]/100)."',0,0,'".$rowdata['server_date_time']."')";
     //           echo $insert;
                $arrayData[$db_index][3]=$rowdata['server_date_time'];
                $arrayData[$db_index][4]=$rowdata['v_red']/100;
                $arrayData[$db_index][5]=$rowdata['v_blue']/100;
                $arrayData[$db_index][6]=$rowdata['v_yellow']/100;
                $arrayData[$db_index][7]=($rowdata['i'.$arrayData[$db_index][19]]/100);
                $arrayData[$db_index][10]=$rowdata['pf'.$arrayData[$db_index][19]]/100;
               // $arrayData[$db_index][9]=$rowdata['server_date_time'];
                
            }
            elseif ($arrayData[$db_index][21]== -1)
            {
                $insert = $insert . "('".$arrayData[$db_index][0]."','".($rowdata['v_red']/100)."','".($rowdata['v_blue']/100)."','".($rowdata['v_yellow']/100)."','".($rowdata['i'.$arrayData[$db_index][19]]/100)."','".($rowdata['i'.$arrayData[$db_index][20]]/100)."',0,'".($rowdata['pf'.$arrayData[$db_index][19]]/100)."','".($rowdata['pf'.$arrayData[$db_index][20]]/100)."',0,'".$rowdata['server_date_time']."')";
           //     echo $insert;
                $arrayData[$db_index][3]=$rowdata['server_date_time'];
                $arrayData[$db_index][4]=$rowdata['v_red']/100;
                $arrayData[$db_index][5]=$rowdata['v_blue']/100;
                $arrayData[$db_index][6]=$rowdata['v_yellow']/100;
                $arrayData[$db_index][7]=($rowdata['i'.$arrayData[$db_index][19]]/100);
                $arrayData[$db_index][8]=($rowdata['i'.$arrayData[$db_index][20]]/100);
                $arrayData[$db_index][10]=$rowdata['pf'.$arrayData[$db_index][19]]/100;
                $arrayData[$db_index][11]=$rowdata['pf'.$arrayData[$db_index][20]]/100;
            }
            else
            {
             //   $rowdata['v_yellow'] = $rowdata['v_red'] + $rowdata['v_blue'];
               $insert = $insert . "('".$arrayData[$db_index][0]."','".($rowdata['v_red']/100)."','".($rowdata['v_blue']/100)."','".($rowdata['v_yellow']/100)."','".($rowdata['i'.$arrayData[$db_index][19]]/100)."','".($rowdata['i'.$arrayData[$db_index][20]]/100)."','".($rowdata['i'.$arrayData[$db_index][21]]/100)."','".($rowdata['pf'.$arrayData[$db_index][19]]/100)."','".($rowdata['pf'.$arrayData[$db_index][20]]/100)."','".($rowdata['pf'.$arrayData[$db_index][21]]/100)."','".$rowdata['server_date_time']."')"; 
				//echo 
         //      echo $insert;
                $arrayData[$db_index][3]=$rowdata['server_date_time'];
                $arrayData[$db_index][4]=$rowdata['v_red']/100;
                $arrayData[$db_index][5]=$rowdata['v_blue']/100;
                $arrayData[$db_index][6]=$rowdata['v_yellow']/100;
                $arrayData[$db_index][7]=($rowdata['i'.$arrayData[$db_index][19]]/100);
                $arrayData[$db_index][8]=($rowdata['i'.$arrayData[$db_index][20]]/100);
                $arrayData[$db_index][9]=($rowdata['i'.$arrayData[$db_index][21]]/100);
                $arrayData[$db_index][10]=$rowdata['pf'.$arrayData[$db_index][19]]/100;
                $arrayData[$db_index][11]=$rowdata['pf'.$arrayData[$db_index][20]]/100;
                $arrayData[$db_index][12]=$rowdata['pf'.$arrayData[$db_index][21]]/100;
            }
            
			$cn_update_index[] = $db_index;
			$db_index = $db_index + 1;
           // echo sizeof($arrayData);
            if($db_index == sizeof($arrayData))
            {break;}
           
		}
        
       
	}
//echo $insert;
$result = $db->query($insert);
/*$sql = "SELECT a.* from raw_user_kwh_log a
            inner join(SELECT moduleid, MAX(server_date_time) pdt
            FROM raw_user_kwh_log where server_date_time > now() - interval 15 day  GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and a.server_date_time >now() - interval 15 day";*/
    $sql = "SELECT a.* from raw_user_kwh_log a
            inner join(SELECT moduleid, MAX(server_date_time) pdt
            FROM raw_user_kwh_log where server_date_time > now() - interval 4 minute  GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and a.server_date_time >now() - interval 4 minute";
    
		$result = mysqli_query($db,$sql);
		$insert = "INSERT INTO `cust_kwh_logs`( `cid`, `kwh1`, `kwh2`, `kwh3`, `offpeak`, `peak`, `offpkunits`, `pkunits`, `pkflg`, `datetime`) VALUES";
		//$insertkwh = "INSERT INTO  `db_kwh_logs`  (`dbid`, `offpeak`, `peak`,`offpkunits`,`pkunits`line1_kwh1,line1_kwh2,line1_kwh3,line2_kwh1,line2_kwh2,line2_kwh3,line3_kwh1,line3_kwh2,line3_kwh3,line4_kwh1,line4_kwh2,line4_kwh3,datetime,`pkflg`) VALUES";
	$index_row= 0 ;
    $count = mysqli_num_rows($result);
    $index_l= 0;
    while($rowdata = mysqli_fetch_array($result))
	{
       
       
      
                $db_index = array_search($rowdata['moduleid'],$arrayData_index);
        
//echo $arrayData[$db_index][0];
        
		while($rowdata['moduleid']==$arrayData[$db_index][22])
		{
						$rowdata['server_date_time'] = date('Y-m-d H:i:00',strtotime($rowdata['server_date_time']));

            $datetime 	= $rowdata['server_date_time'];
				$time = date('H',strtotime($datetime));
				$month = date('m',strtotime($datetime));
				$frommontharray = array(12,3,6,9);
				$tomontharray = array(2,5,8,11);
				$fromtimearray = array('2000-01-01 17:00:00','2000-01-01 18:00:00','2000-01-01 19:00:00','2000-01-01 18:00:00');
				$totimearray = array('2000-01-01 21:00:00', '2000-01-01 22:00:00','2000-01-01 23:00:00','2000-01-01 22:00:00');
				$index = 0;
			/*	while($index<4)
				{
					$frommonth = $frommontharray[$index] ;
					$tomonth = $tomontharray[$index] ;
					$fromtime = date('H', strtotime($fromtimearray[$index])) ;
					$totime = date('H', strtotime($totimearray[$index])) ;       
					if ($frommonth>$tomonth)
					$frommonth = 0;

					if(($month==$frommonth or $month>$frommonth) and ($month==$tomonth or $month<$tomonth))
					{
						if(($time==$fromtime or $time>$fromtime) and ($time==$totime or $time<$totime))
						{
							$ispeak = 1;
						}
						else
						{
						$ispeak = 0;
						}
					}
					$index = $index+1;
				}*/
			$ispeak = $rowdata['peak'];
            if($index_l == 0)
            {
                $index_l = 1;
            }
            else
               $insert = $insert . ","; 
            $pkunits = 0;
            $offpkunits = 0;
            if ($arrayData[$db_index][20]== -1)
            {
                
                if($ispeak == 1)
                {
                    $peak = $rowdata['kwh'.$arrayData[$db_index][19]]/100;
                    $pkunits = $peak - $arrayData[$db_index][2] ;
                    $offpeak = $arrayData[$db_index][1];
                    $arrayData[$db_index][2] = $peak;
                    $arrayData[$db_index][13] = $peak;
                }
                else
                {
                    $offpeak = $rowdata['kwh'.$arrayData[$db_index][19]]/100;
                    $offpkunits = $offpeak - $arrayData[$db_index][1] ;
                    $peak = $arrayData[$db_index][2];
                    $arrayData[$db_index][1] = $offpeak;
                    $arrayData[$db_index][16] = $offpeak;
                }
                $insert = $insert . "('".$arrayData[$db_index][0]."','".($rowdata['kwh'.$arrayData[$db_index][19]]/100)."',0,0,'".$offpeak."','".$peak."','".$pkunits."','".$offpkunits."','".$ispeak."','".$rowdata['server_date_time']."')";
            //    echo $insert;
            }
             elseif ($arrayData[$db_index][21]== -1)
             {
                 if($ispeak == 1)
                {
                    $peak = $rowdata['kwh'.$arrayData[$db_index][19]]/100 + $rowdata['kwh'.$arrayData[$db_index][20]]/100;
                    $pkunits = $peak - $arrayData[$db_index][2] ;
                    $offpeak = $arrayData[$db_index][1];
                    $arrayData[$db_index][2] = $peak;
                   $arrayData[$db_index][14] = $rowdata['kwh'.$arrayData[$db_index][19]]/100;
                    $arrayData[$db_index][15] = $rowdata['kwh'.$arrayData[$db_index][20]]/100;
                }
                else
                {
                    $offpeak = $rowdata['kwh'.$arrayData[$db_index][19]]/100 + $rowdata['kwh'.$arrayData[$db_index][20]]/100;
                    $offpkunits = $offpeak - $arrayData[$db_index][1] ;
                    $peak = $arrayData[$db_index][2];
                    $arrayData[$db_index][1] = $offpeak;
                    $arrayData[$db_index][16] = $rowdata['kwh'.$arrayData[$db_index][19]]/100;
                    $arrayData[$db_index][17] = $rowdata['kwh'.$arrayData[$db_index][20]]/100;
                }
                $insert = $insert . "('".$arrayData[$db_index][0]."','".($rowdata['kwh'.$arrayData[$db_index][19]]/100)."','".($rowdata['kwh'.$arrayData[$db_index][20]]/100)."',0,'".$offpeak."','".$peak."','".$pkunits."','".$offpkunits."','".$ispeak."','".$rowdata['server_date_time']."')";
             }
            else
            {
                if($ispeak == 1)
                {
                    $peak = $rowdata['kwh'.$arrayData[$db_index][19]]/100+ $rowdata['kwh'.$arrayData[$db_index][20]]/100 + $rowdata['kwh'.$arrayData[$db_index][21]/100];
                    $pkunits = round($peak - $arrayData[$db_index][2],2) ;
                    $offpeak = $arrayData[$db_index][1];
                    $arrayData[$db_index][2] = $peak;
                    $arrayData[$db_index][13] =  $rowdata['kwh'.$arrayData[$db_index][19]]/100;
                    $arrayData[$db_index][14] =  $rowdata['kwh'.$arrayData[$db_index][20]]/100;
                    $arrayData[$db_index][15] =  $rowdata['kwh'.$arrayData[$db_index][21]]/100;
                }
                else
                {
                    $offpeak = $rowdata['kwh'.$arrayData[$db_index][19]]/100 + $rowdata['kwh'.$arrayData[$db_index][20]]/100+$rowdata['kwh'.$arrayData[$db_index][21]]/100;
                    $offpkunits =round($offpeak - $arrayData[$db_index][1],2) ;
                    $peak = $arrayData[$db_index][2];
                    $arrayData[$db_index][1] = $offpeak;
                    $arrayData[$db_index][16] =  $rowdata['kwh'.$arrayData[$db_index][19]]/100;
                    $arrayData[$db_index][17] =  $rowdata['kwh'.$arrayData[$db_index][20]]/100;
                    $arrayData[$db_index][18] =  $rowdata['kwh'.$arrayData[$db_index][21]]/100;
                }
                $insert = $insert . "('".$arrayData[$db_index][0]."','".($rowdata['kwh'.$arrayData[$db_index][19]]/100)."','".($rowdata['kwh'.$arrayData[$db_index][20]]/100)."','".($rowdata['kwh'.$arrayData[$db_index][21]]/100)."','".$offpeak."','".$peak."','".$offpkunits."','".$pkunits."','".$ispeak."','".$rowdata['server_date_time']."')";
                
            }
            
            $db_index = $db_index + 1;
           // echo sizeof($arrayData);
            if($db_index == sizeof($arrayData))
            {break;}
        }
}
echo $insert;
$result = $db->query($insert);

for ($i = 0; $i<count($cn_update_index);$i++)
        {
       //    echo $arrayData[$db_update_index[$i]][0];
      //      var_dump($arrayData[$db_update_index[$i]]);
            $sql = "update  connections set `offpeak` = '". $arrayData[$cn_update_index[$i]][1]."',
                `peak` = '". $arrayData[$cn_update_index[$i]][2]."',
                `datetime` = '". $arrayData[$cn_update_index[$i]][3]."',
                `v1` = '". $arrayData[$cn_update_index[$i]][4]."',
                `v2` = '". $arrayData[$cn_update_index[$i]][5]."',
                `v3` = '". $arrayData[$cn_update_index[$i]][6]."',
                `c1` = '". $arrayData[$cn_update_index[$i]][7]."',
                `c2` = '". $arrayData[$cn_update_index[$i]][8]."',
                `c3` = '". $arrayData[$cn_update_index[$i]][9]."',
                `pf1` = '". $arrayData[$cn_update_index[$i]][10]."',
                `pf2` = '". $arrayData[$cn_update_index[$i]][11]."',
                `pf3` = '". $arrayData[$cn_update_index[$i]][12]."',
				`kwhpeak1` = '". $arrayData[$cn_update_index[$i]][13]."',
                `kwhpeak2` = '". $arrayData[$cn_update_index[$i]][14]."',
                `kwhpeak3` = '". $arrayData[$cn_update_index[$i]][15]."',
				`kwhoffpeak1` = '". $arrayData[$cn_update_index[$i]][16]."',
                `kwhoffpeak2` = '". $arrayData[$cn_update_index[$i]][17]."',
                `kwhoffpeak3` = '". $arrayData[$cn_update_index[$i]][18]."'
				where cid = '". $arrayData[$cn_update_index[$i]][0]."'";
         //   echo $sql;
            $result = $db->query($sql);
                
                
        }
 $sql = "select * from connections_db order by dbid ";

$arrayData = array();
$arrayData_index = array();
$db_update_index = array();
	//	$yeild_update_index = array();
		$db_index = 0;
		$result = mysqli_query($db,$sql);
		
		while($row = mysqli_fetch_array($result))
		{  
			$arrayData_index[]=$row['dbid'];
                array_push($arrayData,array($row['dbid'],
                                            $row['datetime'],
                                            $row['v1'],$row['v2'],$row['v3'],
                                            $row['c1'],$row['c2'],$row['c3'],
                                            $row['c4'],$row['c5'],$row['c6'],
                                            $row['c7'],$row['c8'],$row['c9'],                                           $row['c10'],$row['c11'],$row['c12'],                                           $row['c13'],$row['c14'],$row['c15'],                                           $row['c16'],$row['c17'],$row['c18'],                                            $row['c19'],$row['c20'],$row['c21'],                                            $row['c22'],$row['c23'],$row['c24'],                                            $row['c25'],$row['c26'],$row['c27'],                                            $row['c28'],$row['c29'],$row['c30'],                                            $row['c31'],$row['c32'],$row['pf1'],                                           $row['pf2'],$row['pf3'],$row['pf4'],                                            $row['pf5'],$row['pf6'],$row['pf7'],                                            $row['pf8'],$row['pf9'],$row['pf10'],                                            $row['pf11'],$row['pf12'],$row['pf13'],                                            $row['pf14'],$row['pf15'],$row['pf16'],                                            $row['pf17'],$row['pf18'],$row['pf19'],                                            $row['pf20'],$row['pf21'],$row['pf22'],                                            $row['pf23'],$row['pf24'],$row['pf25'],                                            $row['pf26'],$row['pf27'],$row['pf28'],                                            $row['pf29'],$row['pf30'],$row['pf31'],                                           $row['pf32'],$row['kwhpeak1'],$row['kwhpeak2'],                                          $row['kwhpeak3'],$row['kwhpeak4'],$row['kwhpeak5'],                                      $row['kwhpeak6'],$row['kwhpeak7'],$row['kwhpeak8'],                                      $row['kwhpeak9'],$row['kwhpeak10'],$row['kwhpeak11'],                                    $row['kwhpeak12'],$row['kwhpeak13'],$row['kwhpeak14'],                                  $row['kwhpeak15'],$row['kwhpeak16'],$row['kwhpeak17'],                              $row['kwhpeak18'],$row['kwhpeak19'],$row['kwhpeak20'],                                $row['kwhpeak21'],$row['kwhpeak22'],$row['kwhpeak23'],                                  $row['kwhpeak24'],$row['kwhpeak25'],$row['kwhpeak26'],
                                            $row['kwhpeak27'],$row['kwhpeak28'],$row['kwhpeak29'],$row['kwhpeak30'],$row['kwhpeak31'],$row['kwhpeak32'],$row['kwhoffpeak1'],$row['kwhoffpeak2'],$row['kwhoffpeak3'],$row['kwhoffpeak4'],$row['kwhoffpeak5'],$row['kwhoffpeak6'],$row['kwhoffpeak7'],$row['kwhoffpeak8'],$row['kwhoffpeak9'],$row['kwhoffpeak10'],$row['kwhoffpeak11'],$row['kwhoffpeak12'],$row['kwhoffpeak13'],$row['kwhoffpeak14'],$row['kwhoffpeak15'],$row['kwhoffpeak16'],$row['kwhoffpeak17'],$row['kwhoffpeak18'],$row['kwhoffpeak19'],$row['kwhoffpeak20'],$row['kwhoffpeak21'],$row['kwhoffpeak22'],$row['kwhoffpeak23'],$row['kwhoffpeak24'],$row['kwhoffpeak25'],$row['kwhoffpeak26'],$row['kwhoffpeak27'],$row['kwhoffpeak28'],$row['kwhoffpeak29'],$row['kwhoffpeak30'],$row['kwhoffpeak31'],$row['kwhoffpeak32']));	
		} 

 $sql = "SELECT a.* from raw_user_current_log a
            inner join(SELECT moduleid, MAX(server_date_time) pdt
            from raw_user_current_log where server_date_time > now() - interval 4 minute  GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and a.server_date_time >now() - interval 4 minute";

		$result = mysqli_query($db,$sql);
//var_dump($result);

 while($rowdata = mysqli_fetch_array($result))
	{
       
       
      
                $db_index = array_search($rowdata['moduleid'],$arrayData_index);
     echo $arrayData[$db_index][0].' ';
     echo $rowdata['moduleid'].' ';
     
     
     if ($rowdata['moduleid']==$arrayData[$db_index][0])
     {
       // echo $rowdata['server_date_time'];
		 			$rowdata['server_date_time'] = date('Y-m-d H:i:00',strtotime($rowdata['server_date_time']));

        $arrayData[$db_index][1] = $rowdata['server_date_time'];
        echo  $arrayData[$db_index][1].' ';
         $arrayData[$db_index][2] = $rowdata['v_red']/100;
         $arrayData[$db_index][3] = $rowdata['v_blue']/100;
         $arrayData[$db_index][4] = $rowdata['v_yellow']/100;
         for ($i = 5; $i<37 ; $i=$i+1)
         $arrayData[$db_index][$i] = $rowdata['i'.($i-4)]/100;
        
          for ($i = 37; $i<69 ; $i=$i+1)
         $arrayData[$db_index][$i] = $rowdata['pf'.($i-36)]/100;
         
         $db_update_index[]=$db_index;
         
     }
 }
 

 $sql = "SELECT a.* from raw_user_kwh_log a
            inner join(SELECT moduleid, MAX(server_date_time) pdt
            from raw_user_kwh_log where server_date_time > now() - interval 4 minute  GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and a.server_date_time >now() - interval 4 minute";
 	$result = mysqli_query($db,$sql);    
   while($rowdata = mysqli_fetch_array($result))
	{
       
       
      
                $db_index = array_search($rowdata['moduleid'],$arrayData_index);
  //   echo $rowdata['moduleid'];
    //   echo $db_index;
     if ($rowdata['moduleid']==$arrayData[$db_index][0])
     {
         $datetime 	= $rowdata['server_date_time'];
				$time = date('H',strtotime($datetime));
				$month = date('m',strtotime($datetime));
				$frommontharray = array(12,3,6,9);
				$tomontharray = array(2,5,8,11);
				$fromtimearray = array('2000-01-01 17:00:00','2000-01-01 18:00:00','2000-01-01 19:00:00','2000-01-01 18:00:00');
				$totimearray = array('2000-01-01 21:00:00', '2000-01-01 22:00:00','2000-01-01 23:00:00','2000-01-01 22:00:00');
				$index = 0;
			/*	while($index<4)
				{
					$frommonth = $frommontharray[$index] ;
					$tomonth = $tomontharray[$index] ;
					$fromtime = date('H', strtotime($fromtimearray[$index])) ;
					$totime = date('H', strtotime($totimearray[$index])) ;       
					if ($frommonth>$tomonth)
					$frommonth = 0;

					if(($month==$frommonth or $month>$frommonth) and ($month==$tomonth or $month<$tomonth))
					{
						if(($time==$fromtime or $time>$fromtime) and ($time==$totime or $time<$totime))
						{
							$ispeak = 1;
						}
						else
						{
						$ispeak = 0;
						}
					}
					$index = $index+1;
				}*/
		 $ispeak = $rowdata['peak'];
         if($ispeak)
         {
            for ($i = 69; $i<101 ; $i=$i+1)
            $arrayData[$db_index][$i] = $rowdata['kwh'.($i-68)]/100;
         }
         else
         {
            for ($i = 101; $i<132 ; $i=$i+1)
            $arrayData[$db_index][$i] = $rowdata['kwh'.($i-100)]/100;
             //var_dump($arrayData);
         }
     }
 }
var_dump($db_update_index);

for ($i = 0; $i<count($db_update_index);$i++)
{
    $q = "UPDATE `connections_db` SET 
     `datetime` = '". $arrayData[$db_update_index[$i]][1]."',
     `v1` = '". $arrayData[$db_update_index[$i]][2]."',`v2` = '". $arrayData[$db_update_index[$i]][3]."', `v3` = '".$arrayData[$db_update_index[$i]][4]."',
    `c1`='".$arrayData[$db_update_index[$i]][5]."',`c2`='".$arrayData[$db_update_index[$i]][6]."',
    `c3`='".$arrayData[$db_update_index[$i]][7]."',`c4`='".$arrayData[$db_update_index[$i]][8]."',
    `c5`='".$arrayData[$db_update_index[$i]][9]."',`c6`='".$arrayData[$db_update_index[$i]][10]."',
    `c7`='".$arrayData[$db_update_index[$i]][11]."',`c8`='".$arrayData[$db_update_index[$i]][12]."',
    `c9`='".$arrayData[$db_update_index[$i]][13]."',`c10`='".$arrayData[$db_update_index[$i]][14]."',
    `c11`='".$arrayData[$db_update_index[$i]][15]."',`c12`='".$arrayData[$db_update_index[$i]][16]."',
    `c13`='".$arrayData[$db_update_index[$i]][17]."',`c14`='".$arrayData[$db_update_index[$i]][18]."',
    `c15`='".$arrayData[$db_update_index[$i]][19]."',`c16`='".$arrayData[$db_update_index[$i]][20]."',
    `c17`='".$arrayData[$db_update_index[$i]][21]."',`c18`='".$arrayData[$db_update_index[$i]][22]."',
    `c19`='".$arrayData[$db_update_index[$i]][23]."',`c20`='".$arrayData[$db_update_index[$i]][24]."',
    `c21`='".$arrayData[$db_update_index[$i]][25]."',`c22`='".$arrayData[$db_update_index[$i]][26]."',
    `c23`='".$arrayData[$db_update_index[$i]][27]."',`c24`='".$arrayData[$db_update_index[$i]][28]."',
    `c25`='".$arrayData[$db_update_index[$i]][29]."',`c26`='".$arrayData[$db_update_index[$i]][30]."',
    `c27`='".$arrayData[$db_update_index[$i]][31]."',`c28`='".$arrayData[$db_update_index[$i]][32]."',
    `c29`='".$arrayData[$db_update_index[$i]][33]."',`c30`='".$arrayData[$db_update_index[$i]][34]."',
    `c31`='".$arrayData[$db_update_index[$i]][35]."',`c32`='".$arrayData[$db_update_index[$i]][36]."',
    `pf1`='".$arrayData[$db_update_index[$i]][37]."',`pf2`='".$arrayData[$db_update_index[$i]][38]."',
    `pf3`='".$arrayData[$db_update_index[$i]][39]."',`pf4`='".$arrayData[$db_update_index[$i]][40]."',
    `pf5`='".$arrayData[$db_update_index[$i]][41]."',`pf6`='".$arrayData[$db_update_index[$i]][42]."',
    `pf7`='".$arrayData[$db_update_index[$i]][43]."',`pf8`='".$arrayData[$db_update_index[$i]][44]."',
    `pf9`='".$arrayData[$db_update_index[$i]][45]."',`pf10`='".$arrayData[$db_update_index[$i]][46]."',
    `pf11`='".$arrayData[$db_update_index[$i]][47]."',`pf12`='".$arrayData[$db_update_index[$i]][48]."',
    `pf13`='".$arrayData[$db_update_index[$i]][49]."',`pf14`='".$arrayData[$db_update_index[$i]][50]."',
    `pf15`='".$arrayData[$db_update_index[$i]][51]."',`pf16`='".$arrayData[$db_update_index[$i]][52]."',
    `pf17`='".$arrayData[$db_update_index[$i]][53]."',`pf18`='".$arrayData[$db_update_index[$i]][54]."',
    `pf19`='".$arrayData[$db_update_index[$i]][55]."',`pf20`='".$arrayData[$db_update_index[$i]][56]."',
    `pf21`='".$arrayData[$db_update_index[$i]][57]."',`pf22`='".$arrayData[$db_update_index[$i]][58]."',
    `pf23`='".$arrayData[$db_update_index[$i]][59]."',`pf24`='".$arrayData[$db_update_index[$i]][60]."',
    `pf25`='".$arrayData[$db_update_index[$i]][61]."',`pf26`='".$arrayData[$db_update_index[$i]][62]."',
    `pf27`='".$arrayData[$db_update_index[$i]][63]."',`pf28`='".$arrayData[$db_update_index[$i]][64]."',
    `pf29`='".$arrayData[$db_update_index[$i]][65]."',`pf30`='".$arrayData[$db_update_index[$i]][66]."',
    `pf31`='".$arrayData[$db_update_index[$i]][67]."',`pf32`='".$arrayData[$db_update_index[$i]][68]."',
    `kwhpeak1`='".$arrayData[$db_update_index[$i]][69]."',`kwhpeak2`='".$arrayData[$db_update_index[$i]][70]."',
    `kwhpeak3`='".$arrayData[$db_update_index[$i]][71]."',`kwhpeak4`='".$arrayData[$db_update_index[$i]][72]."',
    `kwhpeak5`='".$arrayData[$db_update_index[$i]][73]."',`kwhpeak6`='".$arrayData[$db_update_index[$i]][74]."',
    `kwhpeak7`='".$arrayData[$db_update_index[$i]][75]."',`kwhpeak8`='".$arrayData[$db_update_index[$i]][76]."',
    `kwhpeak9`='".$arrayData[$db_update_index[$i]][77]."',`kwhpeak10`='".$arrayData[$db_update_index[$i]][78]."',
    `kwhpeak11`='".$arrayData[$db_update_index[$i]][79]."',`kwhpeak12`='".$arrayData[$db_update_index[$i]][80]."',
    `kwhpeak13`='".$arrayData[$db_update_index[$i]][81]."',`kwhpeak14`='".$arrayData[$db_update_index[$i]][82]."',
    `kwhpeak15`='".$arrayData[$db_update_index[$i]][83]."',`kwhpeak16`='".$arrayData[$db_update_index[$i]][84]."',
    `kwhpeak17`='".$arrayData[$db_update_index[$i]][85]."',`kwhpeak18`='".$arrayData[$db_update_index[$i]][86]."',
    `kwhpeak19`='".$arrayData[$db_update_index[$i]][87]."',`kwhpeak20`='".$arrayData[$db_update_index[$i]][88]."',
    `kwhpeak21`='".$arrayData[$db_update_index[$i]][89]."',`kwhpeak22`='".$arrayData[$db_update_index[$i]][90]."',
    `kwhpeak23`='".$arrayData[$db_update_index[$i]][91]."',`kwhpeak24`='".$arrayData[$db_update_index[$i]][92]."',
    `kwhpeak25`='".$arrayData[$db_update_index[$i]][93]."',`kwhpeak26`='".$arrayData[$db_update_index[$i]][94]."',
    `kwhpeak27`='".$arrayData[$db_update_index[$i]][95]."',`kwhpeak28`='".$arrayData[$db_update_index[$i]][96]."',
    `kwhpeak29`='".$arrayData[$db_update_index[$i]][97]."',`kwhpeak30`='".$arrayData[$db_update_index[$i]][98]."',
    `kwhpeak31`='".$arrayData[$db_update_index[$i]][99]."',`kwhpeak32`='".$arrayData[$db_update_index[$i]][100]."',
    `kwhoffpeak1`='".$arrayData[$db_update_index[$i]][101]."',`kwhoffpeak2`='".$arrayData[$db_update_index[$i]][102]."',
    `kwhoffpeak3`='".$arrayData[$db_update_index[$i]][103]."',`kwhoffpeak4`='".$arrayData[$db_update_index[$i]][104]."',
    `kwhoffpeak5`='".$arrayData[$db_update_index[$i]][105]."',`kwhoffpeak6`='".$arrayData[$db_update_index[$i]][106]."',
    `kwhoffpeak7`='".$arrayData[$db_update_index[$i]][107]."',`kwhoffpeak8`='".$arrayData[$db_update_index[$i]][108]."',
    `kwhoffpeak9`='".$arrayData[$db_update_index[$i]][109]."',`kwhoffpeak10`='".$arrayData[$db_update_index[$i]][110]."',
    `kwhoffpeak11`='".$arrayData[$db_update_index[$i]][111]."',`kwhoffpeak12`='".$arrayData[$db_update_index[$i]][112]."',
    `kwhoffpeak13`='".$arrayData[$db_update_index[$i]][113]."',`kwhoffpeak14`='".$arrayData[$db_update_index[$i]][114]."',
    `kwhoffpeak15`='".$arrayData[$db_update_index[$i]][115]."',`kwhoffpeak16`='".$arrayData[$db_update_index[$i]][116]."',
    `kwhoffpeak17`='".$arrayData[$db_update_index[$i]][117]."',`kwhoffpeak18`='".$arrayData[$db_update_index[$i]][118]."',
    `kwhoffpeak19`='".$arrayData[$db_update_index[$i]][119]."',`kwhoffpeak20`='".$arrayData[$db_update_index[$i]][120]."',
    `kwhoffpeak21`='".$arrayData[$db_update_index[$i]][121]."',`kwhoffpeak22`='".$arrayData[$db_update_index[$i]][122]."',
    `kwhoffpeak23`='".$arrayData[$db_update_index[$i]][123]."',`kwhoffpeak24`='".$arrayData[$db_update_index[$i]][124]."',
    `kwhoffpeak25`='".$arrayData[$db_update_index[$i]][125]."',`kwhoffpeak26`='".$arrayData[$db_update_index[$i]][126]."',
    `kwhoffpeak27`='".$arrayData[$db_update_index[$i]][127]."',`kwhoffpeak28`='".$arrayData[$db_update_index[$i]][128]."',
    `kwhoffpeak29`='".$arrayData[$db_update_index[$i]][129]."',`kwhoffpeak30`='".$arrayData[$db_update_index[$i]][130]."',
    `kwhoffpeak31`='".$arrayData[$db_update_index[$i]][131]."',`kwhoffpeak32`='".$arrayData[$db_update_index[$i]][132]."'
     WHERE dbid = '".$arrayData[$db_update_index[$i]][0]."'";
    echo $q;
    	$result = mysqli_query($db,$q);
}
     
}
		$db->close();

?>


