<?php
//date_default_timezone_set("Asia/Karachi");
$dbtype = "electrocure";
$subdivid = "26217";

$dbhost = "10.13.144.6";
$dbuser = "user_".$subdivid;
$dbpass =  "Adm1n@".$subdivid;
$dbname =  $dbtype."_".$subdivid;

$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

$sql = "select * from db where dbtype=1 or dbtype =3 order by dbid ";

$arrayData = array();
$arrayData_index = array();
$db_update_index = array();
	//	$yeild_update_index = array();
		$db_index = 0;
		$result = mysqli_query($db,$sql);
		
		while($row = mysqli_fetch_array($result))
		{  
			$arrayData_index[]=$row['dbid'];
                array_push($arrayData,array($row['dbid'],$row['offpeak'],$row['peak'],$row['datetime'],$row['v1'],$row['v2'],$row['v3'],$row['line1_c1'],$row['line1_c2'],$row['line1_c3'],$row['line2_c1'],$row['line2_c2'],$row['line2_c3'],$row['line3_c1'],$row['line3_c2'],$row['line3_c3'],$row['line4_c1'],$row['line4_c2'],$row['line4_c3'],$row['line1_pf1'],$row['line1_pf2'],$row['line1_pf3'],$row['line2_pf1'],$row['line2_pf2'],$row['line2_pf3'],$row['line3_pf1'],$row['line3_pf2'],$row['line3_pf3'],$row['line4_pf1'],$row['line4_pf2'],$row['line4_pf3'],$row['line1_kwhpeak1'],$row['line1_kwhpeak2'],$row['line1_kwhpeak3'],$row['line2_kwhpeak1'],$row['line2_kwhpeak2'],$row['line2_kwhpeak3'],$row['line3_kwhpeak1'],$row['line3_kwhpeak2'],$row['line3_kwhpeak3'],$row['line4_kwhpeak1'],$row['line4_kwhpeak2'],$row['line4_kwhpeak3'],$row['line1_kwhoffpeak1'],$row['line1_kwhoffpeak2'],$row['line1_kwhoffpeak3'],$row['line2_kwhoffpeak1'],$row['line2_kwhoffpeak2'],$row['line2_kwhoffpeak3'],$row['line3_kwhoffpeak1'],$row['line3_kwhoffpeak2'],$row['line3_kwhoffpeak3'],$row['line4_kwhoffpeak1'],$row['line4_kwhoffpeak2'],$row['line4_kwhoffpeak3']));	
		}

//var_dump($arrayData);

    $sql = "SELECT a.* from raw_db_log a
            inner join(SELECT moduleid, MAX(server_date_time) pdt
            FROM raw_db_log where server_date_time > now() - interval 3 minute  GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and a.server_date_time >now() - interval 3 minute";
		$result = mysqli_query($db,$sql);
		$insert = "INSERT INTO db_current_logs (dbid, v1,v2,v3,line1_c1,line1_c2,line1_c3,line2_c1,line2_c2,line2_c3,line3_c1,line3_c2,line3_c3,line4_c1,line4_c2,line4_c3,line1_pf1,line1_pf2,line1_pf3,line2_pf1,line2_pf2,line2_pf3,line3_pf1,line3_pf2,line3_pf3,line4_pf1,line4_pf2,line4_pf3,datetime) VALUES";
		$insertkwh = "INSERT INTO  `db_kwh_logs`  (`dbid`, `offpeak`, `peak`,`offpkunits`,`pkunits`line1_kwh1,line1_kwh2,line1_kwh3,line2_kwh1,line2_kwh2,line2_kwh3,line3_kwh1,line3_kwh2,line3_kwh3,line4_kwh1,line4_kwh2,line4_kwh3,datetime,`pkflg`) VALUES";
	$index_row= 0 ;
    $count = mysqli_num_rows($result);
    
    while($rowdata = mysqli_fetch_array($result))
	{
       
       
      //var_dump($arrayData_index);
		//echo $rowdata['moduleid']; 
                $db_index = array_search($rowdata['moduleid'],$arrayData_index);
        
		 echo $arrayData[$db_index][0];
		if ($rowdata['moduleid']==$arrayData[$db_index][0])
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
				$arrvoltage = array($rowdata['v_red']/100,$rowdata['v_blue']/100,$rowdata['v_yellow']/100);
				$arrpf1 = array($rowdata['pf1_red']/100,$rowdata['pf1_blue']/100,$rowdata['pf1_yellow']/100);
			    $arrpf2 = array($rowdata['pf2_red']/100,$rowdata['pf2_blue']/100,$rowdata['pf2_yellow']/100);
			    $arrpf3 = array($rowdata['pf3_red']/100,$rowdata['pf3_blue']/100,$rowdata['pf3_yellow']/100);
			    $arrpf4 = array($rowdata['pf4_red']/100,$rowdata['pf4_blue']/100,$rowdata['pf4_yellow']/100);
            //    var_dump($arrpf);
				$arrc1 = array($rowdata['i1_red']/100,$rowdata['i1_blue']/100,$rowdata['i1_yellow']/100);
			    $arrc2 = array($rowdata['i2_red']/100,$rowdata['i2_blue']/100,$rowdata['i2_yellow']/100);
			    $arrc3 = array($rowdata['i3_red']/100,$rowdata['i3_blue']/100,$rowdata['i3_yellow']/100);
			    $arrc4 = array($rowdata['i4_red']/100,$rowdata['i4_blue']/100,$rowdata['i4_yellow']/100);
			
			
			
				$peakflg    = $ispeak;
				
		//-------------------------------------------------------------------------

		//Power Factor Correction (Avoid 1 on dbs)------------------------
				if($arrpf1[0]>0.99)
					$arrpf1[0] = 0.98;

				if($arrpf1[1]>0.99)
					$arrpf1[1] = 0.98;

				if($arrpf1[2]>0.99)
					$arrpf1[2] = 0.98;
			
				if($arrpf2[0]>0.99)
					$arrpf2[0] = 0.98;

				if($arrpf2[1]>0.99)
					$arrpf2[1] = 0.98;

				if($arrpf2[2]>0.99)
					$arrpf2[2] = 0.98;
				
				if($arrpf3[0]>0.99)
					$arrpf3[0] = 0.98;

				if($arrpf3[1]>0.99)
					$arrpf3[1] = 0.98;

				if($arrpf3[2]>0.99)
					$arrpf3[2] = 0.98;
			
			
				$currenttime = strtotime($datetime);				
				$prevdatetime = $arrayData[$db_index][3];
				$prevdatetime = strtotime($prevdatetime);
				$lasttime=$prevdatetime; 
				$timediff = ceil(($currenttime-$lasttime));
				$totalOffpk = $arrayData[$db_index][1];
				$totalpeak = $arrayData[$db_index][2];
               	$insert = $insert."('".$moduleid."','".$arrvoltage[0]."','".$arrvoltage[1]."','".$arrvoltage[2]."',
				'".$arrc1[0]."','".$arrc1[1]."','".$arrc1[2]."','".$arrc2[0]."','".$arrc2[1]."','".$arrc2[2]."',
				'".$arrc3[0]."','".$arrc3[1]."','".$arrc3[2]."','".$arrc4[0]."','".$arrc4[1]."','".$arrc4[2]."',
				'".$arrpf1[0]."','".$arrpf1[1]."','".$arrpf1[2]."','".$arrpf2[0]."','".$arrpf2[1]."','".$arrpf2[2]."',		'".$arrpf3[0]."','".$arrpf3[1]."','".$arrpf3[2]."','".$arrpf4[0]."','".$arrpf4[1]."','".$arrpf4[2]."','".$datetime."')";
               
                $arrayData[$db_index][4]=$arrvoltage[0];
                $arrayData[$db_index][5]=$arrvoltage[1];
                $arrayData[$db_index][6]=$arrvoltage[2];
                $arrayData[$db_index][7]=$arrc1[0];
                $arrayData[$db_index][8]=$arrc1[1];
                $arrayData[$db_index][9]=$arrc1[2];
			    $arrayData[$db_index][10]=$arrc2[0];
                $arrayData[$db_index][11]=$arrc2[1];
                $arrayData[$db_index][12]=$arrc2[2];
			    $arrayData[$db_index][13]=$arrc3[0];
                $arrayData[$db_index][14]=$arrc3[1];
                $arrayData[$db_index][15]=$arrc3[2];
			    $arrayData[$db_index][16]=$arrc4[0];
                $arrayData[$db_index][17]=$arrc4[1];
                $arrayData[$db_index][18]=$arrc4[2]; 
                $arrayData[$db_index][19]=$arrpf1[0];
                $arrayData[$db_index][20]=$arrpf1[1];
                $arrayData[$db_index][21]=$arrpf1[2];
			    $arrayData[$db_index][22]=$arrpf2[0];
                $arrayData[$db_index][23]=$arrpf2[1];
                $arrayData[$db_index][24]=$arrpf2[2];
			    $arrayData[$db_index][25]=$arrpf3[0];
                $arrayData[$db_index][26]=$arrpf3[1];
                $arrayData[$db_index][27]=$arrpf3[2];
			    $arrayData[$db_index][28]=$arrpf4[0];
                $arrayData[$db_index][29]=$arrpf4[1];
                $arrayData[$db_index][30]=$arrpf4[2]; 
               
            
            
            
                //    echo $pf1;
                //    echo $pf2;
                //    echo $pf3;
                 $mankwh = (($arrvoltage[0] * $arrc1[0] *$arrpf1[0])  +  ($arrvoltage[1] * $arrc1[1] * $arrpf1[1]) +  ($arrvoltage[2] * $arrc1[2] * $arrpf1[2]) + ($arrvoltage[0] * $arrc2[0] *$arrpf2[0])  +  ($arrvoltage[1] * $arrc2[1] * $arrpf2[1]) +  ($arrvoltage[2] * $arrc2[2] * $arrpf2[2]) + ($arrvoltage[0] * $arrc3[0] *$arrpf3[0])  +  ($arrvoltage[1] * $arrc3[1] * $arrpf3[1]) +  ($arrvoltage[2] * $arrc3[2] * $arrpf3[2]) + ($arrvoltage[0] * $arrc4[0] *$arrpf4[0])  +  ($arrvoltage[1] * $arrc4[1] * $arrpf4[1]) +  ($arrvoltage[2] * $arrc4[2] * $arrpf4[2]) );
                 //echo $mankwh;
				$mankwh = $mankwh*$timediff;
				$mankwh = $mankwh / (3600000);
				$arrkwh1 = array(($arrvoltage[0] * $arrc1[0] *$arrpf1[0]*$timediff)/3600000,($arrvoltage[1] * $arrc1[1] * $arrpf1[1]*$timediff)/3600000,($arrvoltage[2] * $arrc1[2] * $arrpf1[2]*$timediff)/3600000);
			    $arrkwh2 = array(($arrvoltage[0] * $arrc2[0] *$arrpf2[0]*$timediff)/3600000,($arrvoltage[1] * $arrc2[1] * $arrpf2[1]*$timediff)/3600000,($arrvoltage[2] * $arrc2[2] * $arrpf2[2]*$timediff)/3600000);
			    $arrkwh3 = array(($arrvoltage[0] * $arrc3[0] *$arrpf3[0]*$timediff)/3600000,($arrvoltage[1] * $arrc3[1] * $arrpf3[1]*$timediff)/3600000,($arrvoltage[2] * $arrc3[2] * $arrpf3[2]*$timediff)/3600000);
			    $arrkwh4 = array(($arrvoltage[0] * $arrc4[0] *$arrpf4[0]*$timediff)/3600000,($arrvoltage[1] * $arrc4[1] * $arrpf4[1]*$timediff)/3600000,($arrvoltage[2] * $arrc4[2] * $arrpf4[2]*$timediff)/3600000);
				$offpeak = 0;
				$pk		 = 0;
				if($ispeak== 1)  
				{
					$offpeak = $totalOffpk;
					$pk		 = $totalpeak + $mankwh;
				//	$arrayData[$db_index][10] = $arrayData[$db_index][10] + $mankwh;
				//	$realval = $mankwh;
                    $arrayData[$db_index][31]=$arrayData[$db_index][31] +$arrkwh1[0];
                    $arrayData[$db_index][32]=$arrayData[$db_index][32] +$arrkwh1[1];
                    $arrayData[$db_index][33]=$arrayData[$db_index][33] +$arrkwh1[2];
					
					$arrayData[$db_index][34]=$arrayData[$db_index][34] +$arrkwh2[0];
                    $arrayData[$db_index][35]=$arrayData[$db_index][35] +$arrkwh2[1];
                    $arrayData[$db_index][36]=$arrayData[$db_index][36] +$arrkwh2[2];
					
					$arrayData[$db_index][37]=$arrayData[$db_index][37] +$arrkwh3[0];
                    $arrayData[$db_index][38]=$arrayData[$db_index][38] +$arrkwh3[1];
                    $arrayData[$db_index][39]=$arrayData[$db_index][39] +$arrkwh3[2];
					
					$arrayData[$db_index][40]=$arrayData[$db_index][40] +$arrkwh4[0];
                    $arrayData[$db_index][41]=$arrayData[$db_index][41] +$arrkwh4[1];
                    $arrayData[$db_index][42]=$arrayData[$db_index][42] +$arrkwh4[2];
				}
				else  
				{		
					$pk = $totalpeak;
					$offpeak		 = $totalOffpk + $mankwh;
				//	$arrayData[$db_index][11] = $arrayData[$db_index][11] + $mankwh;
				//	$realval = $mankwh;
                    $arrayData[$db_index][43]=$arrayData[$db_index][43] +$arrkwh1[0];
                    $arrayData[$db_index][44]=$arrayData[$db_index][44] +$arrkwh1[1];
                    $arrayData[$db_index][45]=$arrayData[$db_index][45] +$arrkwh1[2];
					
					$arrayData[$db_index][46]=$arrayData[$db_index][46] +$arrkwh2[0];
                    $arrayData[$db_index][47]=$arrayData[$db_index][47] +$arrkwh2[1];
                    $arrayData[$db_index][48]=$arrayData[$db_index][48] +$arrkwh2[2];
					
					$arrayData[$db_index][49]=$arrayData[$db_index][49] +$arrkwh3[0];
                    $arrayData[$db_index][50]=$arrayData[$db_index][50] +$arrkwh3[1];
                    $arrayData[$db_index][51]=$arrayData[$db_index][51] +$arrkwh3[2];
					
					$arrayData[$db_index][52]=$arrayData[$db_index][52] +$arrkwh4[0];
                    $arrayData[$db_index][53]=$arrayData[$db_index][53] +$arrkwh4[1];
                    $arrayData[$db_index][54]=$arrayData[$db_index][54] +$arrkwh4[2];
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
				$arrayData[$db_index][1]= $offpeak;
				$arrayData[$db_index][2]= $pk;
				$insertkwh = $insertkwh."('".$moduleid."','".$offpeak."','".$pk."','".$offpkunits."','".$pkunits."','".$arrkwh1[0]."','".$arrkwh1[1]."','".$arrkwh1[2]."','".$arrkwh2[0]."','".$arrkwh2[1]."','".$arrkwh2[2]."','".$arrkwh3[0]."','".$arrkwh3[1]."','".$arrkwh3[2]."','".$arrkwh4[0]."','".$arrkwh4[1]."','".$arrkwh4[2]."','".$datetime."','".$peakflg ."')";
			    $arrayData[$db_index][3] = $rowdata['server_date_time'];
              //  var_dump($arrayData[$db_index]);
				$db_update_index[]=$db_index;
			
		}
        $db_index = 0;
       
	}
echo $insert;
$result = $db->query($insert);
echo $insertkwh;
$result = $db->query($insertkwh);
//var_dump($db_update_index);

for ($i = 0; $i<count($db_update_index);$i++)
        {
       //    echo $arrayData[$db_update_index[$i]][0];
      //      var_dump($arrayData[$db_update_index[$i]]);
            $sql = "update  db set `offpeak` = '". $arrayData[$db_update_index[$i]][1]."',
                `peak` = '". $arrayData[$db_update_index[$i]][2]."',
                `datetime` = '". $arrayData[$db_update_index[$i]][3]."',
                `v1` = '". $arrayData[$db_update_index[$i]][4]."',
                `v2` = '". $arrayData[$db_update_index[$i]][5]."',
                `v3` = '". $arrayData[$db_update_index[$i]][6]."',
                `line1_c1` = '". $arrayData[$db_update_index[$i]][7]."',
                `line1_c2` = '". $arrayData[$db_update_index[$i]][8]."',
                `line1_c3` = '". $arrayData[$db_update_index[$i]][9]."',
				`line2_c1` = '". $arrayData[$db_update_index[$i]][10]."',
                `line2_c2` = '". $arrayData[$db_update_index[$i]][11]."',
                `line2_c3` = '". $arrayData[$db_update_index[$i]][12]."',
				`line3_c1` = '". $arrayData[$db_update_index[$i]][13]."',
                `line3_c2` = '". $arrayData[$db_update_index[$i]][14]."',
                `line3_c3` = '". $arrayData[$db_update_index[$i]][15]."',
				`line4_c1` = '". $arrayData[$db_update_index[$i]][16]."',
                `line4_c2` = '". $arrayData[$db_update_index[$i]][17]."',
                `line4_c3` = '". $arrayData[$db_update_index[$i]][18]."',
                `line1_pf1` = '". $arrayData[$db_update_index[$i]][19]."',
                `line1_pf2` = '". $arrayData[$db_update_index[$i]][20]."',
                `line1_pf3` = '". $arrayData[$db_update_index[$i]][21]."',
				`line2_pf1` = '". $arrayData[$db_update_index[$i]][22]."',
                `line2_pf2` = '". $arrayData[$db_update_index[$i]][23]."',
                `line2_pf3` = '". $arrayData[$db_update_index[$i]][24]."',
				`line3_pf1` = '". $arrayData[$db_update_index[$i]][25]."',
                `line3_pf2` = '". $arrayData[$db_update_index[$i]][26]."',
                `line3_pf3` = '". $arrayData[$db_update_index[$i]][27]."',
				`line4_pf1` = '". $arrayData[$db_update_index[$i]][28]."',
                `line4_pf2` = '". $arrayData[$db_update_index[$i]][29]."',
                `line4_pf3` = '". $arrayData[$db_update_index[$i]][30]."',
                `line1_kwhpeak1` = '". $arrayData[$db_update_index[$i]][31]."',
                `line1_kwhpeak2` = '". $arrayData[$db_update_index[$i]][32]."',
                `line1_kwhpeak3` = '". $arrayData[$db_update_index[$i]][33]."',
				`line2_kwhpeak1` = '". $arrayData[$db_update_index[$i]][34]."',
                `line2_kwhpeak2` = '". $arrayData[$db_update_index[$i]][35]."',
                `line2_kwhpeak3` = '". $arrayData[$db_update_index[$i]][36]."',
				`line3_kwhpeak1` = '". $arrayData[$db_update_index[$i]][37]."',
                `line3_kwhpeak2` = '". $arrayData[$db_update_index[$i]][38]."',
                `line3_kwhpeak3` = '". $arrayData[$db_update_index[$i]][39]."',
				`line4_kwhpeak1` = '". $arrayData[$db_update_index[$i]][40]."',
                `line4_kwhpeak2` = '". $arrayData[$db_update_index[$i]][41]."',
                `line4_kwhpeak3` = '". $arrayData[$db_update_index[$i]][42]."',
                `line1_kwhoffpeak1` = '". $arrayData[$db_update_index[$i]][43]."',
                `line1_kwhoffpeak2` = '". $arrayData[$db_update_index[$i]][44]."',
                `line1_kwhoffpeak3` = '". $arrayData[$db_update_index[$i]][45]."',
				`line2_kwhoffpeak1` = '". $arrayData[$db_update_index[$i]][46]."',
                `line2_kwhoffpeak2` = '". $arrayData[$db_update_index[$i]][47]."',
                `line2_kwhoffpeak3` = '". $arrayData[$db_update_index[$i]][48]."',
				`line3_kwhoffpeak1` = '". $arrayData[$db_update_index[$i]][49]."',
                `line3_kwhoffpeak2` = '". $arrayData[$db_update_index[$i]][50]."',
                `line3_kwhoffpeak3` = '". $arrayData[$db_update_index[$i]][51]."',
				`line4_kwhoffpeak1` = '". $arrayData[$db_update_index[$i]][52]."',
                `line4_kwhoffpeak2` = '". $arrayData[$db_update_index[$i]][53]."',
                `line4_kwhoffpeak3` = '". $arrayData[$db_update_index[$i]][54]."'
                where dbid = '". $arrayData[$db_update_index[$i]][0]."'";
            echo $sql;
            $result = $db->query($sql);
                
                
        }
        $sql = "select * from db where dbtype=0 or dbtype =2 order by dbid ";

		$arrayData = array();
		$arrayData_index = array();
		$db_update_index = array();
		$db_index = 0;
		$result = mysqli_query($db,$sql);
		
		while($row = mysqli_fetch_array($result))
		{  
			$arrayData_index[]=$row['dbid'];
                array_push($arrayData,array($row['dbid'],$row['datetime'],$row['v1'],$row['v2'],$row['v3'],$row['line1_c1'],$row['line1_c2'],$row['line1_c3'],$row['line2_c1'],$row['line2_c2'],$row['line2_c3'],$row['line3_c1'],$row['line3_c2'],$row['line3_c3'],$row['line4_c1'],$row['line4_c2'],$row['line4_c3'],$row['line5_c1'],$row['line5_c2'],$row['line5_c3'],$row['line6_c1'],$row['line6_c2'],$row['line6_c3'],$row['line7_c1'],$row['line7_c2'],$row['line7_c3'],$row['line8_c1'],$row['line8_c2'],$row['line8_c3'],$row['line9_c1'],$row['line9_c2'],$row['line9_c3'],$row['line10_c1'],$row['line10_c2'],$row['line10_c3'],$row['line11_c1'],$row['line11_c2'],$row['line11_c3'],$row['line6_c1'],$row['line6_c2'],$row['line6_c3'],$row['line1_pf1'],$row['line1_pf2'],$row['line1_pf3'],$row['line2_pf1'],$row['line2_pf2'],$row['line2_pf3'],$row['line3_pf1'],$row['line3_pf2'],$row['line3_pf3'],$row['line4_pf1'],$row['line4_pf2'],$row['line4_pf3'],$row['line5_pf1'],$row['line5_pf2'],$row['line5_pf3'],$row['line6_pf1'],$row['line6_pf2'],$row['line6_pf3'],$row['line7_pf1'],$row['line7_pf2'],$row['line7_pf3'],$row['line8_pf1'],$row['line8_pf2'],$row['line8_pf3'],$row['line9_pf1'],$row['line9_pf2'],$row['line9_pf3'],$row['line10_pf1'],$row['line10_pf2'],$row['line10_pf3'],$row['line11_pf1'],$row['line11_pf2'],$row['line11_pf3'],$row['line6_pf1'],$row['line6_pf2'],$row['line6_pf3']));	
		}

//var_dump($arrayData);

    $sql = "SELECT a.* from raw_user_current_log a
            inner join(SELECT moduleid, MAX(server_date_time) pdt
            from raw_user_current_log where server_date_time > now() - interval 4 minute  GROUP BY moduleid)b on a.moduleid = b.moduleid and a.server_date_time = b.pdt and a.server_date_time >now() - interval 4 minute";
			$result = mysqli_query($db,$sql);

	$index_row= 0 ;
    $count = mysqli_num_rows($result);
    $insert = "INSERT INTO `db_current_logs`( `dbid`, `v1`, `v2`, `v3`, `line1_c1`, `line1_c2`, `line1_c3`, `line2_c1`, `line2_c2`, `line2_c3`, `line3_c1`, `line3_c2`, `line3_c3`, `line4_c1`, `line4_c2`, `line4_c3`, `line5_c1`, `line5_c2`, `line5_c3`, `line6_c1`, `line6_c2`, `line6_c3`, `line7_c1`, `line7_c2`, `line7_c3`, `line8_c1`, `line8_c2`, `line8_c3`, `line9_c1`, `line9_c2`, `line9_c3`, `line10_c1`, `line10_c2`, `line10_c3`, `line11_c1`, `line11_c2`, `line1_pf1`, `line1_pf2`, `line1_pf3`, `line2_pf1`, `line2_pf2`, `line2_pf3`, `line3_pf1`, `line3_pf2`, `line3_pf3`, `line4_pf1`, `line4_pf2`, `line4_pf3` , `line5_pf1`, `line5_pf2`, `line5_pf3`, `line6_pf1`, `line6_pf2`, `line6_pf3`, `line7_pf1`, `line7_pf2`, `line7_pf3`, `line8_pf1`, `line8_pf2`, `line8_pf3`, `line9_pf1`, `line9_pf2`, `line9_pf3`, `line10_pf1`, `line10_pf2`, `line10_pf3`, `line11_pf1`, `line11_pf2`, `datetime`) VALUES ";
	$index_insert = 0;
    while($rowdata = mysqli_fetch_array($result))
	{
		$moduleid = explode('C',$rowdata['moduleid']);
		$mid = $moduleid[0];
		 $db_index = array_search($mid,$arrayData_index);
        
		//echo $arrayData[$db_index][0];
		if ($mid==$arrayData[$db_index][0])
		{
			if($index_insert == 0)
			{
				$index_insert = 1;
			}
			else
			{
				$insert = $insert . ",";
			}
			$sql = "update db set datetime = '".$rowdata['server_date_time']."',
			v1 = '".($rowdata['v_red']/100)."',
			v2 = '".($rowdata['v_yellow']/100)."',
			v3 = '".($rowdata['v_blue']/100)."',
			`line1_c1`='".($rowdata['i1']/100)."',
			`line1_c2`='".($rowdata['i2']/100)."',
			`line1_c3`='".($rowdata['i3']/100)."',
			`line2_c1`='".($rowdata['i4']/100)."',
			`line2_c2`='".($rowdata['i5']/100)."',
			`line2_c3`='".($rowdata['i6']/100)."',
			`line3_c1`='".($rowdata['i7']/100)."',
			`line3_c2`='".($rowdata['i8']/100)."',
			`line3_c3`='".($rowdata['i9']/100)."',
			`line4_c1`='".($rowdata['i10']/100)."',
			`line4_c2`='".($rowdata['i11']/100)."',
			`line4_c3`='".($rowdata['i12']/100)."',
			`line5_c1`='".($rowdata['i13']/100)."',
			`line5_c2`='".($rowdata['i14']/100)."',
			`line5_c3`='".($rowdata['i15']/100)."',
			`line6_c1`='".($rowdata['i16']/100)."',
			`line6_c2`='".($rowdata['i17']/100)."',
			`line6_c3`='".($rowdata['i18']/100)."',
			`line7_c1`='".($rowdata['i19']/100)."',
			`line7_c2`='".($rowdata['i20']/100)."',
			`line7_c3`='".($rowdata['i21']/100)."',
			`line8_c1`='".($rowdata['i22']/100)."',
			`line8_c2`='".($rowdata['i23']/100)."',
			`line8_c3`='".($rowdata['i24']/100)."',
			`line9_c1`='".($rowdata['i25']/100)."',
			`line9_c2`='".($rowdata['i26']/100)."',
			`line9_c3`='".($rowdata['i27']/100)."',
			`line10_c1`='".($rowdata['i28']/100)."',
			`line10_c2`='".($rowdata['i29']/100)."',
			`line10_c3`='".($rowdata['i30']/100)."',
			`line11_c1`='".($rowdata['i31']/100)."',
			`line11_c2`='".($rowdata['i32']/100)."',
			`line1_pf1`='".($rowdata['pf1']/100)."',
			`line1_pf2`='".($rowdata['pf2']/100)."',
			`line1_pf3`='".($rowdata['pf3']/100)."',
			`line2_pf1`='".($rowdata['pf4']/100)."',
			`line2_pf2`='".($rowdata['pf5']/100)."',
			`line2_pf3`='".($rowdata['pf6']/100)."',
			`line3_pf1`='".($rowdata['pf7']/100)."',
			`line3_pf2`='".($rowdata['pf8']/100)."',
			`line3_pf3`='".($rowdata['pf9']/100)."',
			`line4_pf1`='".($rowdata['pf10']/100)."',
			`line4_pf2`='".($rowdata['pf11']/100)."',
			`line4_pf3`='".($rowdata['pf12']/100)."',
			`line5_pf1`='".($rowdata['pf13']/100)."',
			`line5_pf2`='".($rowdata['pf14']/100)."',
			`line5_pf3`='".($rowdata['pf15']/100)."',
			`line6_pf1`='".($rowdata['pf16']/100)."',
			`line6_pf2`='".($rowdata['pf17']/100)."',
			`line6_pf3`='".($rowdata['pf18']/100)."',
			`line7_pf1`='".($rowdata['pf19']/100)."',
			`line7_pf2`='".($rowdata['pf20']/100)."',
			`line7_pf3`='".($rowdata['pf21']/100)."',
			`line8_pf1`='".($rowdata['pf22']/100)."',
			`line8_pf2`='".($rowdata['pf23']/100)."',
			`line8_pf3`='".($rowdata['pf24']/100)."',
			`line9_pf1`='".($rowdata['pf25']/100)."',
			`line9_pf2`='".($rowdata['pf26']/100)."',
			`line9_pf3`='".($rowdata['pf27']/100)."',
			`line10_pf1`='".($rowdata['pf28']/100)."',
			`line10_pf2`='".($rowdata['pf29']/100)."',
			`line10_pf3`='".($rowdata['pf30']/100)."',
			`line11_pf1`='".($rowdata['pf31']/100)."',
			`line11_pf2`='".($rowdata['pf32']/100)."'
			where dbid = '".$mid."'";
			echo $sql;
			 $result_SQL = $db->query($sql);

			$insert = $insert . "('".$mid."','".($rowdata['v_red']/100)."','".($rowdata['v_blue']/100)."','".($rowdata['v_yellow']/100)."','".($rowdata['i1']/100)."','".($rowdata['i2']/100)."','".($rowdata['i3']/100)."','".($rowdata['i4']/100)."','".($rowdata['i5']/100)."','".($rowdata['i6']/100)."','".($rowdata['i7']/100)."','".($rowdata['i8']/100)."','".($rowdata['i9']/100)."','".($rowdata['i10']/100)."','".($rowdata['i11']/100)."','".($rowdata['i12']/100)."','".($rowdata['i13']/100)."','".($rowdata['i14']/100)."','".($rowdata['i15']/100)."','".($rowdata['i16']/100)."','".($rowdata['i17']/100)."','".($rowdata['i18']/100)."','".($rowdata['i19']/100)."','".($rowdata['i20']/100)."','".($rowdata['i21']/100)."','".($rowdata['i22']/100)."','".($rowdata['i23']/100)."','".($rowdata['i24']/100)."','".($rowdata['i25']/100)."','".($rowdata['i26']/100)."','".($rowdata['i27']/100)."','".($rowdata['i28']/100)."','".($rowdata['i29']/100)."','".($rowdata['i30']/100)."','".($rowdata['i31']/100)."','".($rowdata['i32']/100)."','".($rowdata['pf1']/100)."','".($rowdata['pf2']/100)."','".($rowdata['pf3']/100)."','".($rowdata['pf4']/100)."','".($rowdata['pf5']/100)."','".($rowdata['pf6']/100)."','".($rowdata['pf7']/100)."','".($rowdata['pf8']/100)."','".($rowdata['pf9']/100)."','".($rowdata['pf10']/100)."','".($rowdata['pf11']/100)."','".($rowdata['pf12']/100)."','".($rowdata['pf13']/100)."','".($rowdata['pf14']/100)."','".($rowdata['pf15']/100)."','".($rowdata['pf16']/100)."','".($rowdata['pf17']/100)."','".($rowdata['pf18']/100)."','".($rowdata['pf19']/100)."','".($rowdata['pf20']/100)."','".($rowdata['pf21']/100)."','".($rowdata['pf22']/100)."','".($rowdata['pf23']/100)."','".($rowdata['pf24']/100)."','".($rowdata['pf25']/100)."','".($rowdata['pf26']/100)."','".($rowdata['pf27']/100)."','".($rowdata['pf28']/100)."','".($rowdata['pf29']/100)."','".($rowdata['pf30']/100)."','".($rowdata['pf31']/100)."','".($rowdata['pf32']/100)."','".$rowdata['server_date_time']."')";
		}
		

	}
echo $insert;
 $result = $db->query($insert);

		$db->close();
?>