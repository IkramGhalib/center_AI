<?php //date_default_timezone_set("Asia/Karachi"); 
$subdiv_array = array("mes");//"mes11c","mes10c")
 $dbtype = "electrocure"; for ($x = 0 ; $x <sizeof($subdiv_array); 
$x++)
 {
 $subdivid = $subdiv_array[$x];
echo $subdivid; 
$dbhost = "10.13.144.6";
 $dbuser = "user_".$subdivid;
 $dbpass = "Adm1n@".$subdivid; 
$dbname = $dbtype."_".$subdivid;
 $db = new mysqli($dbhost, 
$dbuser, $dbpass, $dbname);
 $sql = "select * from transformer order by trid "; $arrayData = array(); $arrayData_index = array(); $transformer_update_index = array();
	//	$yeild_update_index = array();
		$transformer_index = 0;
		$result = mysqli_query($db,$sql);
		
		while($row = mysqli_fetch_array($result))
		{
			$arrayData_index[]=$row['trid'];
             array_push($arrayData,array($row['trid'],$row['offpeak'],$row['peak'],$row['datetime'],$row['c1'],$row['c2'],$row['c3'],$row['v1'],$row['v2'],$row['v3'],$row['pf1'],$row['pf2'],$row['pf3'],$row['kwh_offpeak1'],$row['kwh_offpeak2'],$row['kwh_offpeak3'],$row['kwh_peak1'],$row['kwh_peak2'],$row['kwh_peak3'],$row['ltlength'],$row['cresistance'],$row['NC'],$row['NL'],$row['NUL'],$row['status'],$row['status_out'], 
$row['switch_time'],$row['cause'], $row['kwh_dev_offpeak1'], $row['kwh_dev_offpeak2'], $row['kwh_dev_offpeak3'], $row['kwh_dev_peak1'], $row['kwh_dev_peak2'], $row['kwh_dev_peak3'], 
$row['offpeak_dev'],$row['peak_dev'] ));
		}
		
//var_dump($arrayData);
	$sql = "SELECT a.* from raw_transfocure_log a
       inner join(SELECT moduleid, MAX(server_date_time) pdt
      FROM raw_transfocure_log where server_date_time > now() - interval 1 minute GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and 
a.server_date_time >now() - interval 1 minute";
	echo $sql;
	$result = mysqli_query($db,$sql);
	$insert = "INSERT INTO tr_current_logs (trid, v1,v2,v3,pf1,pf2,pf3,B1U, B1M, B1L, datetime,NC,NL,NUL) VALUES";
	$insertkwh = "INSERT INTO `tr_kwh_logs` (`trid`, `offpeak`, 
`peak`,`offpeak_dev`,`peak_dev`,`Datetime`,`offpkunits`,`pkunits`,`offpkunits_dev`,`pkunits_dev`,`val1`,`val2`,`val3`,`cval1`,`cval2`,`cval3`,`pf1`,`pf2`,`pf3`,`kwh_peak1`,`kwh_peak2`,`kwh_peak3`,`kwh_offpeak1`,`kwh_offpeak2`,`kwh_offpeak3`,`pkflg`) 
VALUES";
	$index_row= 0 ;
     
    
    while($rowdata = mysqli_fetch_array($result))
	{
       $transformer_index = array_search($rowdata['moduleid'],$arrayData_index);
       $arrayData[$transformer_index][0];
		if ($rowdata['moduleid']==$arrayData[$transformer_index][0])
		{
			$rowdata['server_date_time'] = date('Y-m-d H:i:00',strtotime($rowdata['server_date_time']));
			
			 if ($index_row==0)
			 {
				 $index_row = $index_row+1;
			 }
			 else
			 {
				 $insert = $insert.",";
				 $insertkwh = $insertkwh.",";
			 }
			$datetime = $rowdata['server_date_time'];
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
 // if ($frommonth>$tomonth) // $frommonth = 0;
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
            // var_dump($arrpf);
			$arrc1 = array($rowdata['i_red'],$rowdata['i_blue'],$rowdata['i_yellow']);
            $arrkwhoffpeak = array($rowdata['kwh_offpeak_red'],$rowdata['kwh_offpeak_blue'],$rowdata['kwh_offpeak_yellow']);
			$arrkwhpeak = array($rowdata['kwh_peak_red'],$rowdata['kwh_peak_blue'],$rowdata['kwh_peak_yellow']);
			if ($arrayData[$transformer_index][28] < $rowdata['kwh_offpeak_red'])
                $arrayData[$transformer_index][28] = $rowdata['kwh_offpeak_red'];
			else
				$arrkwhoffpeak[0] = $arrayData[$transformer_index][28];
			
			if ($arrayData[$transformer_index][29] < $rowdata['kwh_offpeak_blue'])
                $arrayData[$transformer_index][29] = $rowdata['kwh_offpeak_blue'];
			else
				$arrkwhoffpeak[1] = $arrayData[$transformer_index][29];
			
            if ($arrayData[$transformer_index][30] < $rowdata['kwh_offpeak_yellow'])
				$arrayData[$transformer_index][30] = $rowdata['kwh_offpeak_yellow'];
			else
				$arrkwhoffpeak[2] = $arrayData[$transformer_index][30];
			
            if ($arrayData[$transformer_index][31] < $rowdata['kwh_peak_red'])
				$arrayData[$transformer_index][31] = $rowdata['kwh_peak_red'];
			else
				$arrkwhpeak[0] = $arrayData[$transformer_index][31];
                
			if ($arrayData[$transformer_index][32] < $rowdata['kwh_peak_blue'])
				$arrayData[$transformer_index][32] = $rowdata['kwh_peak_blue'];
			else
				$arrkwhpeak[1] = $arrayData[$transformer_index][32];
            if ($arrayData[$transformer_index][33] < $rowdata['kwh_peak_yellow'])
				$arrayData[$transformer_index][33] = $rowdata['kwh_peak_yellow'];
			else
				$arrkwhpeak[2] = $arrayData[$transformer_index][33];
			$offpeak_dev = $arrkwhoffpeak[0] + $arrkwhoffpeak[1] + $arrkwhoffpeak[2];
			$peak_dev = $arrkwhpeak[0] + $arrkwhpeak[1] + $arrkwhpeak[2];
			$peakflg = $ispeak;
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
			$B = ($i2 * sin($angle12)) + ($i3 * sin($angle13)); //Imaginary Components
			$C = sqrt( $A*$A + $B*$B ); //Magnitude
			$neutral = round($C, 2);
		//-------------------------------------------------------------------------
		//Power Factor Correction (Avoid 1 on Transformers)------------------------
			if($arrpf[0]>0.99)
				$arrpf[0] = 0.98;
			if($arrpf[1]>0.99)
				$arrpf[1] = 0.98;
			if($arrpf[2]>0.99)
				$arrpf[2] = 0.98;
				
			$kva1= round($arrc1[0]*$arrvoltage[0]/1000,2);
		    $kva2= round($arrc1[1]*$arrvoltage[1]/1000,2);
	        $kva3= round($arrc1[2]*$arrvoltage[2]/1000,2);
		
			$currenttime = strtotime($datetime);
			$prevdatetime = $arrayData[$transformer_index][3];
			$prevdatetime = strtotime($prevdatetime);
			$lasttime=$prevdatetime;
			$timediff = ceil(($currenttime-$lasttime));
			$totalOffpk = $arrayData[$transformer_index][1];
			$totalpeak = $arrayData[$transformer_index][2];
            $NL = round($arrayData[$transformer_index][19] * $arrayData[$transformer_index][20] * $neutral *$neutral,2);
            $arrayData[$transformer_index][21] = $neutral;
            $arrayData[$transformer_index][22] = $NL;
			$NUL = $NL * $timediff;
            $NUL = round($NUL/(60*60),2);
			$arrayData[$transformer_index][23] = $NUL;
			$insert = 
$insert."('".$moduleid."','".$arrvoltage[0]."','".$arrvoltage[1]."','".$arrvoltage[2]."','".$arrpf[0]."','".$arrpf[1]."','".$arrpf[2]."','".$arrc1[0]."','".$arrc1[1]."','".$arrc1[2]."','".$datetime."','".$neutral."','".$NL."','".$NUL."')";
            $arrayData[$transformer_index][4]=$arrc1[0];
            $arrayData[$transformer_index][5]=$arrc1[1];
            $arrayData[$transformer_index][6]=$arrc1[2];
            $arrayData[$transformer_index][7]=$arrvoltage[0];
            $arrayData[$transformer_index][8]=$arrvoltage[1];
            $arrayData[$transformer_index][9]=$arrvoltage[2];
              
            $arrayData[$transformer_index][10]=$arrpf[0];
            $arrayData[$transformer_index][11]=$arrpf[1];
            $arrayData[$transformer_index][12]=$arrpf[2];
               
            
            if($arrpf[0]<0.5)
				$pf1 = 0.7;
                
			else
               $pf1 = $arrpf[0];
             
			if($arrpf[1]<0.5)
				$pf2 = 0.7;
               
            else
                $pf2 = $arrpf[1];
                
            if($arrpf[2]<0.5)
				$pf3 = 0.7;
            else
                $pf3 = $arrpf[2];
            
            
        
            $mankwh = (($arrvoltage[0] * $arrc1[0] *$pf1) + ($arrvoltage[1] * $arrc1[1] * $pf2) + ($arrvoltage[2] * $arrc1[2] * $pf3) );
			$mankwh = $mankwh*$timediff;
			$mankwh = $mankwh / (3600000);
			$arrkwh = array(($arrvoltage[0] * $arrc1[0] *$pf1*$timediff)/3600000,($arrvoltage[1] * $arrc1[1] * $pf2*$timediff)/3600000,($arrvoltage[2] * $arrc1[2] * 
$pf3*$timediff)/3600000);
			$offpeak = 0;
			$pk = 0;
			
			
			if($ispeak== 1)
			{
				$offpeak = $totalOffpk;
				$pk = $totalpeak + $mankwh;
				$realval = $mankwh;
                $arrayData[$transformer_index][16]=$arrayData[$transformer_index][16] +$arrkwh[0];
                $arrayData[$transformer_index][17]=$arrayData[$transformer_index][17] +$arrkwh[1];
                $arrayData[$transformer_index][18]=$arrayData[$transformer_index][18] +$arrkwh[2];
			}
			else
			{
				$pk = $totalpeak;
				$offpeak = $totalOffpk + $mankwh;
				$realval = $mankwh;
                $arrayData[$transformer_index][13]=$arrayData[$transformer_index][13] +$arrkwh[0];
                $arrayData[$transformer_index][14]=$arrayData[$transformer_index][14] +$arrkwh[1];
                $arrayData[$transformer_index][15]=$arrayData[$transformer_index][15] +$arrkwh[2];
			}
			
			if($ispeak ==1)
			{
				$pkunits_dev = $peak_dev - $arrayData[$transformer_index][35];
				$pkunits = $arrkwh[0] + $arrkwh[1] + $arrkwh[2];
			
				$offpkunits_dev = 0;
				$offpkunits = 0;
			}
			else
			{
				$offpkunits_dev = $offpeak_dev - $arrayData[$transformer_index][34];
				$offpkunits = $arrkwh[0] + $arrkwh[1] + $arrkwh[2];
				$pkunits_dev = 0;
				$pkunits = 0;
			}
			$arrayData[$transformer_index][35] = $peak_dev;
			$arrayData[$transformer_index][34] = $offpeak_dev;
			$arrayData[$transformer_index][1]= $offpeak;
			$arrayData[$transformer_index][2]= $pk;
			
			           
  
			$insertkwh = 
$insertkwh."('".$moduleid."','".$offpeak."','".$pk."','".$offpeak_dev."','".$peak_dev."','".$datetime."','".$offpkunits."','".$pkunits."','".$offpkunits_dev."','".$pkunits_dev."','".$arrvoltage[0]."','".$arrvoltage[1]."',	
'".$arrvoltage[2]."','".$arrc1[0]."','".$arrc1[1]."','".$arrc1[2]."','".$arrpf[0]."','".$arrpf[1]."','".$arrpf[2]."','".$arrkwhpeak[0]."','".$arrkwhpeak[1]."','".$arrkwhpeak[2]."','".$arrkwhoffpeak[0]."','".$arrkwhoffpeak[1]."','".$arrkwhoffpeak[2]."','" 
. $peakflg ."')";
			$arrayData[$transformer_index][3] = $rowdata['server_date_time'];
			$lasttime=strtotime($arrayData[$transformer_index][26]);
			$timediff = ceil(($currenttime-$lasttime)/60);
			
			$transformer_update_index[]=$transformer_index;
			
			
		}
        $transformer_index = 0;
       
	}
	$result = $db->query($insert);
	echo $insert;
	$result = $db->query($insertkwh); 
	echo $insertkwh; 
	//echo $insert;
	//print_r($transformer_update_index);
	for ($i = 0; $i<count($transformer_update_index);$i++) {
   
       $sql = "update transformer set `offpeak` = '". $arrayData[$transformer_update_index[$i]][1]."',
                `peak` = '". $arrayData[$transformer_update_index[$i]][2]."',
                `datetime` = '". $arrayData[$transformer_update_index[$i]][3]."',
                `c1` = '". $arrayData[$transformer_update_index[$i]][4]."',
                `c2` = '". $arrayData[$transformer_update_index[$i]][5]."',
                `c3` = '". $arrayData[$transformer_update_index[$i]][6]."',
                `v1` = '". $arrayData[$transformer_update_index[$i]][7]."',
                `v2` = '". $arrayData[$transformer_update_index[$i]][8]."',
                `v3` = '". $arrayData[$transformer_update_index[$i]][9]."',
                `pf1` = '". $arrayData[$transformer_update_index[$i]][10]."',
                `pf2` = '". $arrayData[$transformer_update_index[$i]][11]."',
                `pf3` = '". $arrayData[$transformer_update_index[$i]][12]."',
                `kwh_peak1` = '". $arrayData[$transformer_update_index[$i]][16]."',
                `kwh_peak2` = '". $arrayData[$transformer_update_index[$i]][17]."',
                `kwh_peak3` = '". $arrayData[$transformer_update_index[$i]][18]."',
                `kwh_offpeak1` = '". $arrayData[$transformer_update_index[$i]][13]."',
                `kwh_offpeak2` = '". $arrayData[$transformer_update_index[$i]][14]."',
                `kwh_offpeak3` = '". $arrayData[$transformer_update_index[$i]][15]."',
				`kwh_dev_offpeak1` = '".$arrayData[$transformer_update_index[$i]][28]."',
                `kwh_dev_offpeak2` = '".$arrayData[$transformer_update_index[$i]][29]."',
                `kwh_dev_offpeak3` = '".$arrayData[$transformer_update_index[$i]][30]."',
                `kwh_dev_peak1` = '".$arrayData[$transformer_update_index[$i]][31]."',
                `kwh_dev_peak2` = '".$arrayData[$transformer_update_index[$i]][32]."',
                `kwh_dev_peak3` = '".$arrayData[$transformer_update_index[$i]][33]."',
				`offpeak_dev` = '".$arrayData[$transformer_update_index[$i]][34]."',
				`peak_dev` = '".$arrayData[$transformer_update_index[$i]][35]."',
                `NC` = '".$arrayData[$transformer_update_index[$i]][21]."',
                `NL` = '".$arrayData[$transformer_update_index[$i]][22]."',
                `NUL`= '".$arrayData[$transformer_update_index[$i]][23]."',
				`cause`= '".$arrayData[$transformer_update_index[$i]][27]."'
                where trid = '". $arrayData[$transformer_update_index[$i]][0]."'";
            echo $sql;
            $result = $db->query($sql);


 }
$db->close();

		 if($subdivid == 'mespesh'){
	$servername = "10.13.144.6";
	$username = "user_mespesh";
	$password = "Adm1n@mespesh";
	  $dbname = "electrocure_mespesh";



	try {
	    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connection Successfull";
	}
	catch(PDOException $e)
	    {
	    echo  $e->getMessage();
	    }		
$query = "select trid, v1, v2, v3 from transformer where trid = 'I1F1TR01' or trid = 'I1F1TR02'";
	$result = $conn -> query($query) or die(error);
	$data = array();
	foreach ($result as $row) {
		array_push($data, array($row['trid'], $row['v1'], $row['v2'], $row['v3']));
	}
	$volt1 = $data[0][1] + $data[0][2] + $data[0][3];
	$volt2 = $data[1][1] + $data[1][2] + $data[1][3];

	if ($volt1 > $volt2) {
		$v1 = $data[0][1] - $data[0][1]/100*1.15;
		$v2 = $data[0][2] - $data[0][1]/100*1.45;
		$v3 = $data[0][3] - $data[0][1]/100*1.65;
		$update = "update transformer set v1 = '$v1', v2 = '$v2', v3 = '$v3' where trid = '".$data[1][0]."'";
		$tr_logs = "update tr_current_logs set v1 = '$v1', v2 = '$v2', v3 = '$v3' where trid = '".$data[1][0]."' and datetime > now() - interval 2 minute";
	}else{
		$v1 = $data[1][1] - $data[1][1]/100*1.15;
		$v2 = $data[1][2] - $data[1][1]/100*1.45;
		$v3 = $data[1][3] - $data[1][1]/100*1.65;
		$update = "update transformer set v1 = '$v1', v2 = '$v2', v3 = '$v3' where trid = '".$data[0][0]."'";
		$tr_logs = "update tr_current_logs set v1 = '$v1', v2 = '$v2', v3 = '$v3' where trid = '".$data[0][0]."' and datetime > now() - interval 2 minute";
		echo $update;
	}

		$result = $conn -> query($update) or die(error);
		$result = $conn -> query($tr_logs) or die(error);
		}
		
		$db->close();
}
?>
