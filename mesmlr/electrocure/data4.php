<?php 
	require_once 'opendb.php';

	if(isset($_POST['dbid'])) {
		$dbid = $_POST['dbid'];
		$q = "SELECT cid, name, description FROM connections WHERE  SUBSTRING_INDEX(cid, 'C', 1) = '".$dbid."'";
		$result = $conn -> query($q) or die("Query error");
		$connection = array();
		foreach ($result as $row) {
			array_push($connection, array('id' => $row['cid'], 'name' => $row['name'], 'desc' => $row['description']));
		}
		echo json_encode($connection);
	}
	$conn = NULL;

 ?>