<?php
date_default_timezone_set("Asia/Karachi");
$subdivs = array("mes");
$dbtype = "electrocure";
//$subdivid = "mes30c1";

for($x=0; $x<sizeof($subdivs);$x++){
$subdivid = $subdivs[$x];
echo $subdivid;
$dbhost = "10.13.144.6";
$dbuser = "user_".$subdivid;
$dbpass =  "Adm1n@".$subdivid;
$dbname =  $dbtype."_".$subdivid;

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$sql = "select * from outfeeder order by fdid ";

$arrayData = array();
$arrayData_index = array();
$feeder_update_index = array();
	//	$yeild_update_index = array();
		$feeder_index = 0;
		$result = mysqli_query($db,$sql);
		
		while($row = mysqli_fetch_array($result))
		{  
			$arrayData_index[]=$row['fdid'];
                array_push($arrayData,array($row['fdid'],$row['offpeak'],$row['peak'],$row['datetime'],$row['c1'],$row['c2'],$row['c3'],$row['v1'],$row['v2'],$row['v3'],$row['pf1'],$row['pf2'],$row['pf3'],$row['kwh_offpeak1'],$row['kwh_offpeak2'],$row['kwh_offpeak3'],$row['kwh_peak1'],$row['kwh_peak2'],$row['kwh_peak3']));	
		}

//var_dump($arrayData);

    $sql = "SELECT a.* from raw_feeder_log a
            inner join(SELECT moduleid, MAX(server_date_time) pdt
            FROM raw_feeder_log where server_date_time > now() - interval 2 minute  GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and a.server_date_time >now() - interval 2 minute";
	echo $sql;
		$result = mysqli_query($db,$sql);
		$insert = "INSERT INTO ofd_current_logs (trid, v1,v2,v3,pf1,pf2,pf3,B1U, B1M, B1L, datetime) VALUES";
		$insertkwh = "INSERT INTO  `ofd_kwh_logs`  (`trid`, `offpeak`, `peak`,`Datetime`,`offpkunits`,`pkunits`,`val1`,`val2`,`val3`,`cval1`,`cval2`,`cval3`,`pf1`,`pf2`,`pf3`,`kwh1`,`kwh2`,`kwh3`,`pkflg`) VALUES";
	$index_row= 0 ;
    $count = mysqli_num_rows($result);
    
    while($rowdata = mysqli_fetch_array($result))
	{
       
        if(strlen($rowdata['moduleid'])>3)
        {
            
      
                $feeder_index = array_search($rowdata['moduleid'],$arrayData_index);
        
		echo $arrayData[$feeder_index][0];
		if ($rowdata['moduleid']==$arrayData[$feeder_index][0])
		{
			
			 if ($index_row==0)
				 {
					 $index_row = $index_row+1;
				 }
				 else
				 {
					 $insert = $insert.",";
					 $insertkwh = $insertkwh.",";
//					 $insertyeild = $insertyeild. ",";
				 }
				$datetime 	= $rowdata['server_date_time'];
				$time = date('H',strtotime($datetime));
				$month = date('m',strtotime($datetime));
				$frommontharray = array(12,3,6,9);
				$tomontharray = array(2,5,8,11);
				$fromtimearray = array('2000-01-01 17:00:00','2000-01-01 18:00:00','2000-01-01 19:00:00','2000-01-01 18:00:00');
				$totimearray = array('2000-01-01 21:00:00', '2000-01-01 22:00:00','2000-01-01 23:00:00','2000-01-01 22:00:00');
				$index = 0;
				while($index<4)
				{
					$frommonth = $frommontharray[$index] ;
					$tomonth = $tomontharray[$index] ;
					$fromtime = date('H', strtotime($fromtimearray[$index])) ;
					$totime = date('H', strtotime($totimearray[$index])) ;       
					if ($frommonth>$tomonth)
                { 
                    if($month == $frommonth)
                        $month = 0;
                        $frommonth = 0;
                        
                }

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
				}

				$moduleid=$rowdata['moduleid'];
				$arrvoltage = array($rowdata['v_red'],$rowdata['v_blue'],$rowdata['v_yellow']);
				$arrpf = array($rowdata['pf_red'],$rowdata['pf_blue'],$rowdata['pf_yellow']);
            //    var_dump($arrpf);
				$arrc1 = array($rowdata['i_red'],$rowdata['i_blue'],$rowdata['i_yellow']);
				$peakflg    = $ispeak;
				$i1 = $arrc1[0];
				$i2 = $arrc1[1];
				$i3 = $arrc1[2];

				$pf1 = $arrpf[0];
				$pf2 = $arrpf[1];
				$pf3 = $arrpf[2];

				$angle1 = acos($pf1);
				$angle2 = acos($pf2);
				$angle3 = acos($pf3);

				$angle12 = deg2rad(120) + $angle2 - $angle1;
				$angle13 = deg2rad(240) + $angle3 - $angle1;

				$A = $i1 + ($i2 * cos($angle12)) + ($i3 * cos($angle13));	//Real Components
				$B = ($i2 * sin($angle12)) + ($i3 * sin($angle13));			//Imaginary Components
				$C = sqrt( $A*$A + $B*$B );									//Magnitude
				$neutral = round($C, 2);
		//-------------------------------------------------------------------------

		//Power Factor Correction (Avoid 1 on Transformers)------------------------
				if($arrpf[0]>0.99)
					$arrpf[0] = 0.98;

				if($arrpf[1]>0.99)
					$arrpf[1] = 0.98;

				if($arrpf[2]>0.99)
					$arrpf[2] = 0.98;

		
				$currenttime = strtotime($datetime);				
				$prevdatetime = $arrayData[$feeder_index][3];
				$prevdatetime = strtotime($prevdatetime);
				$lasttime=$prevdatetime; 
				$timediff = ceil(($currenttime-$lasttime));
				$totalOffpk = $arrayData[$feeder_index][1];
				$totalpeak = $arrayData[$feeder_index][2];
                 
				$insert = $insert."('".$moduleid."','".$arrvoltage[0]."','".$arrvoltage[1]."','".$arrvoltage[2]."','".$arrpf[0]."','".$arrpf[1]."','".$arrpf[2]."','".$arrc1[0]."','".$arrc1[1]."','".$arrc1[2]."','".$datetime."')";
                $arrayData[$feeder_index][4]=$arrc1[0];
                $arrayData[$feeder_index][5]=$arrc1[1];
                $arrayData[$feeder_index][6]=$arrc1[2];
                $arrayData[$feeder_index][7]=$arrvoltage[0];
                $arrayData[$feeder_index][8]=$arrvoltage[1];
                $arrayData[$feeder_index][9]=$arrvoltage[2];
               
                $arrayData[$feeder_index][10]=$arrpf[0];
                $arrayData[$feeder_index][11]=$arrpf[1];
                $arrayData[$feeder_index][12]=$arrpf[2];
               
            
                if($arrpf[0]<0.5)
                {
                    $pf1 = 0.7;
                   //  $arrayData[$feeder_index][10]=0.7;
                }
                else
                    $pf1 = $arrpf[0];
                if($arrpf[1]<0.5)
                {
                    $pf2 = 0.7;
                }
                else
                    $pf2 = $arrpf[1];
                
                if($arrpf[2]<0.5)
                 {
                    $pf3 = 0.7;
//$arrayData[$feeder_index][12]=0.7;
                }
                else
                    $pf3 = $arrpf[2];
            
            
                //    echo $pf1;
                //    echo $pf2;
                //    echo $pf3;
                 $mankwh = (($arrvoltage[0] * $arrc1[0] *$pf1)  +  ($arrvoltage[1] * $arrc1[1] * $pf2) +  ($arrvoltage[2] * $arrc1[2] * $pf3) );
                 //echo $mankwh;
				$mankwh = $mankwh*$timediff;
				$mankwh = $mankwh / (3600000);
				$arrkwh = array(($arrvoltage[0] * $arrc1[0] *$pf1*$timediff)/3600000,($arrvoltage[1] * $arrc1[1] * $pf2*$timediff)/3600000,($arrvoltage[2] * $arrc1[2] * $pf3*$timediff)/3600000);
				$offpeak = 0;
				$pk		 = 0;
				if($ispeak== 1)  
				{
					$offpeak = $totalOffpk;
					$pk		 = $totalpeak + $mankwh;
				//	$arrayData[$feeder_index][10] = $arrayData[$feeder_index][10] + $mankwh;
					$realval = $mankwh;
                    $arrayData[$feeder_index][13]=$arrayData[$feeder_index][13] +$arrkwh[0];
                    $arrayData[$feeder_index][14]=$arrayData[$feeder_index][14] +$arrkwh[1];
                    $arrayData[$feeder_index][15]=$arrayData[$feeder_index][15] +$arrkwh[2];
				}
				else  
				{		
					$pk = $totalpeak;
					$offpeak		 = $totalOffpk + $mankwh;
				//	$arrayData[$feeder_index][11] = $arrayData[$feeder_index][11] + $mankwh;
					$realval = $mankwh;
                    $arrayData[$feeder_index][16]=$arrayData[$feeder_index][16] +$arrkwh[0];
                    $arrayData[$feeder_index][17]=$arrayData[$feeder_index][17] +$arrkwh[1];
                    $arrayData[$feeder_index][18]=$arrayData[$feeder_index][18] +$arrkwh[2];
				}
				if($ispeak ==1)
				{
					$pkunits 	= $mankwh;
					$offpkunits = 0;
				}
				else
				{
					$offpkunits = $mankwh;
					$pkunits 	= 0;
				}
				$arrayData[$feeder_index][1]= $offpeak;
				$arrayData[$feeder_index][2]= $pk;
				$insertkwh = $insertkwh."('".$moduleid."','".$offpeak."','".$pk."','".$datetime."','".$offpkunits."','".$pkunits."','".$arrvoltage[0]."','".$arrvoltage[1]."',	'".$arrvoltage[2]."','".$arrc1[0]."','".$arrc1[1]."','".$arrc1[2]."','".$arrpf[0]."','".$arrpf[1]."','".$arrpf[2]."','".$arrkwh[0]."','".$arrkwh[1]."','".$arrkwh[2]."','" . $peakflg ."')";
			    $arrayData[$feeder_index][3] = $rowdata['server_date_time'];
              //  var_dump($arrayData[$feeder_index]);
				$feeder_update_index[]=$feeder_index;
			
		}
        $feeder_index = 0;
        }
	}
echo $insert;
$result = $db->query($insert);
        echo $insertkwh;
		$result = $db->query($insertkwh);
//var_dump($feeder_update_index);

for ($i = 0; $i<count($feeder_update_index);$i++)
        {
       //    echo $arrayData[$feeder_update_index[$i]][0];
           // var_dump($arrayData[$feeder_update_index[$i]]);
            $sql = "update outfeeder set `offpeak` = '". $arrayData[$feeder_update_index[$i]][1]."',
                `peak` = '". $arrayData[$feeder_update_index[$i]][2]."',
                `datetime` = '". $arrayData[$feeder_update_index[$i]][3]."',
                `c1` = '". $arrayData[$feeder_update_index[$i]][4]."',
                `c2` = '". $arrayData[$feeder_update_index[$i]][5]."',
                `c3` = '". $arrayData[$feeder_update_index[$i]][6]."',
                `v1` = '". $arrayData[$feeder_update_index[$i]][7]."',
                `v2` = '". $arrayData[$feeder_update_index[$i]][8]."',
                `v3` = '". $arrayData[$feeder_update_index[$i]][9]."',
                `pf1` = '". $arrayData[$feeder_update_index[$i]][10]."',
                `pf2` = '". $arrayData[$feeder_update_index[$i]][11]."',
                `pf3` = '". $arrayData[$feeder_update_index[$i]][12]."',
                `kwh_peak1` = '". $arrayData[$feeder_update_index[$i]][13]."',
                `kwh_peak2` = '". $arrayData[$feeder_update_index[$i]][14]."',
                `kwh_peak3` = '". $arrayData[$feeder_update_index[$i]][15]."',
                `kwh_offpeak1` = '". $arrayData[$feeder_update_index[$i]][16]."',
                `kwh_offpeak2` = '". $arrayData[$feeder_update_index[$i]][17]."',
                `kwh_offpeak3` = '". $arrayData[$feeder_update_index[$i]][18]."'
                where fdid = '". $arrayData[$feeder_update_index[$i]][0]."'";
            echo $sql;
            $result = $db->query($sql);
                
                
        }
        
		
		$db->close();
}
?>
