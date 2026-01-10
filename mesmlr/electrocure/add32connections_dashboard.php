<?php
	require_once("opendb.php");
	if (isset($_GET['dbid'])) {
       if($_GET['dbtype'] == 0)
       {
		$dbid = $_GET['dbid'];
		$query = "INSERT INTO connections (cid, name, slot1, slot2, slot3, description, connectiondate) VALUES";
		
		for ($i=1; $i <= 32; $i++) { 
            if ($i < 10)
			$id = $dbid."CN0".$i;
            else
                $id = $dbid."CN".$i;
			$connection = "Connection ".$i;

			$querySubPart = "('$id', '$connection', 1,-1,-1, '$connection', now())";
			$query = $query.$querySubPart;
			if ($i != 32) {
				$query = $query.",";
			}	
		}
		//echo $query;
		$conn->exec($query);
		//echo "Success";
		$count = 32;

		
	}
        elseif($_GET['dbtype'] == 1)
        {
            $dbid = $_GET['dbid'];
            $id = $dbid."CN01";
            $connection = "Connection ".$i;
            $count =3;

			$querySubPart = "('$id', '$connection', 1,2,3, '$connection', now())";
		$query = "INSERT INTO connections (cid, name, slot1, slot2, slot3, description, connectiondate) VALUES";
            $query = $query.$querySubPart;
            $conn->exec($query);
         //   $q = "update db set linesassigned = '".$count."' ,noOFCT = '".$count."' where dbid = '".$dbid."'";
           // $conn->exec($q); 
        }//
        $q = "update db set linesassigned = '".$count."' ,noOFCT = '".$count."' where dbid = '".$dbid."'";
             $conn->exec($q); 
        $conn= NULL;
        $id = explode('D',$dbid);
        echo "<script language = \"javascript\" type = \"text/javascript\"> window.location.href=\"db_dashboard.php?filter=".$id[0]."\"; </script>";
    }
    else
	echo "Distribution ID not found!";
	
?>