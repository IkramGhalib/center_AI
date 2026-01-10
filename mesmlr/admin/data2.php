<?php 
	require_once 'opendb.php';

	if(isset($_POST['ofdid'])) {
		$ofdid = $_POST['ofdid'];
		$q = "SELECT trid, name, description FROM transformer WHERE  SUBSTRING_INDEX(trid, 'T', 1) = '".$ofdid."'";
		$result = $conn -> query($q) or die("Query error");
		$outfeeder = array();
		foreach ($result as $row) {
			array_push($outfeeder, array('id' => $row['trid'], 'name' => $row['name'], 'desc' => $row['description']));
		}
		echo json_encode($outfeeder);
	}
	$conn = NULL;

 ?> 