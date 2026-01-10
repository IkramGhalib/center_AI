<?php 
	require_once 'opendb.php';

	if(isset($_POST['trid'])) {
		$trid = $_POST['trid'];
		$q = "SELECT dbid, name, description FROM db WHERE  SUBSTRING_INDEX(dbid, 'D', 1) = '".$trid."'";
		$result = $conn -> query($q) or die("Query error");
		$db = array();
		foreach ($result as $row) {
			array_push($db, array('id' => $row['dbid'], 'name' => $row['name'], 'desc' => $row['description']));
		}
		echo json_encode($db);
	}
	$conn = NULL;

 ?>