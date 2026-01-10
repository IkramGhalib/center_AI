<?php
	require_once("opendb.php");
	if (isset($_GET['dbid'])) {

		$dbid = $_GET['dbid'];
		$singlephase = $_GET['singleph'];
		$threephase = $_GET['threeph'];
		$query = "INSERT INTO connections (cid, name, slot1, slot2, slot3, description, connectiondate) VALUES";
		
		for ($i=1; $i <= $singlephase; $i++) { 
            if ($i < 10)
			$id = $dbid."CN0".$i;
            else
                $id = $dbid."CN".$i;
			$connection = "Connection ".$i;

			$querySubPart = "('$id', '$connection', 1,-1,-1, '$connection', now())";
			$query = $query.$querySubPart;
			$query = $query.",";
		}

		for (; $i <= $threephase+$singlephase; $i++) { 
            if ($i < 10)
			$id = $dbid."CN0".$i;
            else
                $id = $dbid."CN".$i;

			$connection = "Connection ".$i;

			$querySubPart = "('$id', '$connection', 1,2,3, '$connection', now())";
			$query = $query.$querySubPart;

			if ($i != $singlephase+$threephase) {
				$query = $query.",";
			}	
		}
		 $query;
		$conn->exec($query);
		//echo "Success";

         $q = "update db set linesassigned = '".$count."' ,noOFCT = '".$count."' where dbid = '".$dbid."'";
             $conn->exec($q); 
         $conn= NULL;
        echo "<script language = \"javascript\" type = \"text/javascript\"> window.location.href=\"db-list.php?filter=0G0\"; </script>";
    
     }
    else
	echo "Distribution ID not found!";
	
?>