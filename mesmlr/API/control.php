<?php
include 'db.php';
if (!empty($_GET)) 
{
    try
    {
        $subdivid = $_GET['subdivid'];
        $pump_id = $_GET['moduleid'];
        $dbtype = 'electrocure';
        require_once("opendb.php"); 
        $api_flag = $_GET['api_flag'];
        $moduleid = $_GET['moduleid']; 
		if($api_flag == 'apitransv20')
			$sql = "select status_out from transformer where trid = '".$moduleid."'";
		elseif($api_flag == 'apidblcv20')
			$sql = "select status_out from db_status where dbid = '".$moduleid."'";
		
        $result = $conn -> query($sql) or die("Query error");
		
		$index = 1;
	
		foreach($result as $row)
        { 
			if ($api_flag == 'apitransv20')
			{
				echo "switch=".$row['status_out'];
			}
			elseif($api_flag == 'apidblcv20')
			{
				
				$status_out = $row['status_out'];
				$split_status_out = str_split($status_out, 1);
				echo "switch=".$split_status_out[0].",".$split_status_out[1].",".$split_status_out[2].",".$split_status_out[3].",".$split_status_out[4].",".$split_status_out[5].",".$split_status_out[6].",".$split_status_out[7].",".$split_status_out[8].",".$split_status_out[9].",".$split_status_out[10].",".$split_status_out[11].",".$split_status_out[12].",".$split_status_out[13].",".$split_status_out[14].",".$split_status_out[15].",".$split_status_out[16].",".$split_status_out[17].",".$split_status_out[18].",".$split_status_out[19].",".$split_status_out[20].",".$split_status_out[21].",".$split_status_out[22].",".$split_status_out[23].",".$split_status_out[24].",".$split_status_out[25].",".$split_status_out[26].",".$split_status_out[27].",".$split_status_out[28].",".$split_status_out[29].",".$split_status_out[30].",".$split_status_out[31].",";
				
			}
			
            
        }
        $conn= null;

    }
    catch (Exception $e)
    {
        $conn= null;
        echo "error";
    }
}
else
{
        echo "empty post";
}

?>

