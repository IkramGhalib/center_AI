<?php 
	require_once 'opendb.php';

	if(isset($_POST['ifdid'])) {
		$ifdid = $_POST['ifdid'];
		$q = "SELECT fdid, name, description FROM outfeeder WHERE  SUBSTRING_INDEX(fdid, 'F', 1) = '".$ifdid."'";
		$result = $conn -> query($q) or die("Query error");
		$outfeeder = array();
		foreach ($result as $row) {
			array_push($outfeeder, array('id' => $row['fdid'], 'name' => $row['name'], 'desc' => $row['description']));
		}
		echo json_encode($outfeeder);
	}
 ?>