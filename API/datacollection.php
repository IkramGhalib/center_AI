<?php

include 'db.php';

if (!empty($_GET)) 
{
        try
        {

                //Extra
                // t Data from GET
        $SubDiv=$_GET['subdivid'];
        $moduleid = $_GET['moduleid'];
        $labels = array();
        $data = array();
        $flg=true;
        $sql = "";
        $server_date_time = date('Y-m-d H:i:s');
		$application="electrocure";
        if(isset($_GET['api_flag']))
        {
            $api_flg = $_GET['api_flag'];
		echo $api_flg;
	if ($api_flg=='apiucv20' )
            {
				$strlabels= "moduleid,packet_date_time,v_red,v_blue,v_yellow,i1,i2,i3,i4,i5,i6,i7,i8,i9,i10,i11,i12,i13,i14,i15,i16,i17,i18,i19,i20,i21,i22,i23,i24,i25,i26,i27,i28,i29,i30,i31,i32,pf1,pf2,pf3,pf4,pf5,pf6,pf7,pf8,pf9,pf10,pf11,pf12,pf13,pf14,pf15,pf16,pf17,pf18,pf19,pf20,pf21,pf22,pf23,pf24,pf25,pf26,pf27,pf28,pf29,pf30,pf31,pf32,server_date_time";
				$strData="'".$moduleid."','".$_GET['packet_date_time']."',".$_GET['voltage'].",".$_GET['current_users'].",".$_GET['pf_users'].",'".$server_date_time."'";
                $sql="INSERT INTO raw_user_current_log (id, $strlabels) VALUES (NULL, $strData)";
echo $sql;
			}
            elseif($api_flg=='apiukwh10')
			{
               $strlabels= "moduleid,packet_date_time,kwh1,kwh2,kwh3,kwh4,kwh5,kwh6,kwh7,kwh8,kwh9,kwh10,kwh11,kwh12,kwh13,kwh14,kwh15,kwh16,kwh17,kwh18,kwh19,kwh20,kwh21,kwh22,kwh23,kwh24,kwh25,kwh26,kwh27,kwh28,kwh29,kwh30,kwh31,kwh32,peak,server_date_time";
               $strData="'".$moduleid."','".$_GET['packet_date_time']."',".$_GET['kwh_users'].",'".$_GET['peak']."','".$server_date_time."'";                    
               $sql="INSERT INTO raw_user_kwh_log (id, $strlabels) VALUES (NULL, $strData)";
               
            }
             if ($api_flg=='apinetcv10' )
            {
				$strlabels= "moduleid,packet_date_time,v_red,v_blue,v_yellow,i1,i2,i3,i4,i5,i6,i7,i8,i9,pf1,pf2,pf3,pf4,pf5,pf6,server_date_time";
				$strData="'".$moduleid."','".$_GET['packet_date_time']."',".$_GET['voltage'].",".$_GET['current_users'].",".$_GET['pf_users'].",'".$server_date_time."'";
                $sql="INSERT INTO raw_user_current_log (id, $strlabels) VALUES (NULL, $strData)";
               echo $sql;
		$application="netmeter";
			}
            elseif($api_flg=='apinetkwhv10')
			{
               $strlabels= "moduleid,packet_date_time,kwh1,kwh2,kwh3,kwh4,kwh5,kwh6,kwh7,kwh8,kwh9,peak,server_date_time";
               $strData="'".$moduleid."','".$_GET['packet_date_time']."',".$_GET['kwh_users'].",'".$_GET['peak']."','".$server_date_time."'";                    
               $sql="INSERT INTO raw_user_kwh_log (id, $strlabels) VALUES (NULL, $strData)";
		echo $sql;
                $application="netmeter";
            }
			elseif($api_flg=='apidblcv20')
            {
				$strLabels="moduleid,packet_date_time,v_red,v_blue,v_yellow,i1_red,i1_blue,i1_yellow,pf1_red,pf1_blue,pf1_yellow,i2_red,i2_blue,i2_yellow,pf2_red,pf2_blue,pf2_yellow,i3_red,i3_blue,i3_yellow,pf3_red,pf3_blue,pf3_yellow,i4_red,i4_blue,i4_yellow,pf4_red,pf4_blue,pf4_yellow,server_date_time";
				$strData="'".$moduleid."','".$_GET['packet_date_time']."',".$_GET['voltage'].",".$_GET['c_line1'].",".$_GET['c_line2'].",".$_GET['c_line3'].",".$_GET['c_line4'].",".$_GET['pf_line1'].",".$_GET['pf_line2'].",".$_GET['pf_line3'].",".$_GET['pf_line4'].",'".$server_date_time."'";
				$sql="INSERT INTO raw_db_log (id, $strLabels) VALUES (NULL, $strData)";
				echo $sql;
            }
			elseif($api_flg=='apignrv20')
			{
				if ($SubDiv == 'uetpswr')
				{
					$strlabels= "moduleid,packet_date_time,v_red,v_blue,v_yellow,i_red,i_blue,i_yellow,pf_red,pf_blue,pf_yellow";
					$strData="'".$moduleid."','".$server_date_time."',".$_GET['voltage'].",".$_GET['c1'].",".$_GET['pf'];	$sql="INSERT INTO raw_generator_log (id, $strlabels) VALUES (NULL, $strData)";
				}
				else
				{
					foreach (array_keys($_GET) as $field)
                	{
						if ($field != 'api_flag')
                    	{
							if($flg) 
                        	{
                           		$flg=false;
                           		continue;
                        	}
							array_push($labels,$field);
                        	array_push($data,"'".$_GET[$field]."'");
                    	}
                 	}
                 	$strLabels = implode(',',$labels);
                 	$strLabels = $strLabels.',server_date_time';
                 	$strData = implode(',',$data);
				 	$strData = $strData.",'".$server_date_time."'";
					$sql = "INSERT INTO raw_generator_log (id, $strLabels) VALUES (NULL, $strData)";
					
				}
				$application = "generatocure";
			}
			elseif($api_flg=='apiglvv20')
			{
				if ($SubDiv == 'uetpswr')
				{
					$strlabels= "moduleid,server_date_time,temperature,level";
					$strData="'".$moduleid."','".$server_date_time."',".$_GET['temperature'].",".$_GET['level'];	$sql="INSERT INTO raw_generator_sensor_log (id, $strlabels) VALUES (NULL, $strData)";
				}
				else
				{
					foreach (array_keys($_GET) as $field)
                	{
						if ($field != 'api_flag')
                    	{
							if($flg) 
                        	{
                           		$flg=false;
                           		continue;
                        	}
							array_push($labels,$field);
                        	array_push($data,"'".$_GET[$field]."'");
                    	}
                 	}
                 	$strLabels = implode(',',$labels);
                 	$strLabels = $strLabels.',server_date_time';
                 	$strData = implode(',',$data);
				 	$strData = $strData.",'".$server_date_time."'";
					$sql = "INSERT INTO raw_generator_sensor_log (id, $strLabels) VALUES (NULL, $strData)";
				}
				
				$application = "generatocure";
			}
			elseif($api_flg== 'apitransv20' or $api_flg=='apifeedv20')
            {
				
				foreach (array_keys($_GET) as $field)
                {
					if ($field != 'api_flag')
                    {
						if($flg) 
                        {
                           $flg=false;
                           continue;
                        }
						array_push($labels,$field);
                        array_push($data,"'".$_GET[$field]."'");
                    }
                 }
                 $strLabels = implode(',',$labels);
                 $strLabels = $strLabels.',server_date_time';
                 $strData = implode(',',$data);
				 $strData = $strData.",'".$server_date_time."'";
                if($api_flg== 'apitransv20')
                {
                   $sql = "INSERT INTO raw_transfocure_log (id, $strLabels) VALUES (NULL, $strData)";
				}

				elseif($api_flg=='apifeedv20')
                {
//				if($moduleid=='I1F4' && $SubDiv=='mes10c1'){
//					$strData[6] = $strData[6]*20;
//					$strData[7] = $strData[7]*20;
//					$strData[8] = $strData[8]*20;
//				}	
//					print_r($strData[6]);
					$sql=  "INSERT INTO raw_feeder_log (id, $strLabels) VALUES (NULL, $strData)";
                }
			}
			elseif($api_flg == 'apitransv21')
			{
				
				if ($_GET['peak']== 0)
				{
					
						$strData="'".$moduleid."','".$server_date_time."',".$_GET['voltage'].",".$_GET['c1'].",".$_GET['pf'].",".$_GET['kwh'].",0,0,0,'".$server_date_time."'";
					
					
				}
				else
				{
						$strData="'".$moduleid."','".$server_date_time."',".$_GET['voltage'].",".$_GET['c1'].",".$_GET['pf'].",0,0,0,".$_GET['kwh'].",'".$server_date_time."'";
					
					
				}
				$strlabels= "moduleid,packet_date_time,v_red,v_blue,v_yellow,i_red,i_blue,i_yellow,pf_red,pf_blue,pf_yellow, `kwh_offpeak_red`, `kwh_offpeak_blue`, `kwh_offpeak_yellow`, `kwh_peak_red`, `kwh_peak_blue`, `kwh_peak_yellow`,server_date_time";
	
				$sql="INSERT INTO raw_transfocure_log (id, $strlabels) VALUES (NULL, $strData)";
				
				
			}elseif($api_flg=='apismtrv20')
		{
				foreach (array_keys($_GET) as $field)
                {
					if ($field != 'api_flag')
                    {
						if($flg) 
                        {
                           $flg=false;
                           continue;
                        }
						array_push($labels,$field);
                        array_push($data,"'".$_GET[$field]."'");
                    }
                 }
                 $strLabels = implode(',',$labels);
                 $strLabels = $strLabels.',server_date_time';
                 $strData = implode(',',$data);
				 $strData = $strData.",'".$server_date_time."'";
                
                 $sql = "INSERT INTO raw_transfocure_log (id, $strLabels) VALUES (NULL, $strData)";
				
			
		}

        }
		
        else
        {
            foreach (array_keys($_GET) as $field)
			{
				if($flg) 
				{
					$flg=false;
					continue;
				}
				if ($field == 'packet_date_time')
					array_push($data,"'".date('Y-m-d H:i:s')."'");
                else
                   array_push($data,"'".$_GET[$field]."'");
				array_push($labels,$field);
			}
			$strLabels = implode(',',$labels);
			$strLabels = $strLabels.',server_date_time';
			$strData = implode(',',$data);
			$strData = $strData.",'".$server_date_time."'";
            $sql = "INSERT INTO raw_transfocure_log (id, $strLabels) VALUES (NULL, $strData)";
		}

		if ($sql == "") {
			echo "Variable sql has not query to execute";
		}else{
			$dbhost = "10.13.144.6";
            $dbuser = "user_".$SubDiv;
            $dbpass =  "Adm1n@".$SubDiv;
            $dbname =  $application."_".$SubDiv;

            $db = new db($dbhost, $dbuser, $dbpass, $dbname);
			$result = $db->query($sql);
			echo $sql;
$db->close();		
}

		}
        catch (Exception $e)
        {
                $db->close();
                echo "error";
        }
}
else
{
        echo "empty post";
}


 
?>





