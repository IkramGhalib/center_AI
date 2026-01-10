<?php

require_once("opendb.php");
$q = "select dbid from db where substr(dbid,1,4)='I1F1'";
$result = $conn->query($q);
foreach($result as $row)
{ 
    $dbid = $row['dbid'];
     $id = $dbid."CN01";
            $connection = "Connection 1";
            $count =3;

			$querySubPart = "('$id', '$connection', 1,2,3, '$connection', now())";
		$query = "INSERT INTO connections (cid, name, slot1, slot2, slot3, description, connectiondate) VALUES";
            $query = $query.$querySubPart;
            $conn->exec($query);
            $q = "update db set linesassigned = '".$count."' ,noOFCT = '".$count."' where dbid = '".$dbid."'";
            $conn->exec($q); 
}
        $conn= NULL;

?>