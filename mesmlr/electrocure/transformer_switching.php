<?php
	require_once("opendb.php");
	$id = $_GET['id'];
	$switch = $_GET['switch'];
	if($switch == 0){
		$status_out = 1;
		$sw_desc = "On";
	}else{
		$status_out = 0;
		$sw_desc = "Off";
	}

	$query = "update transformer set status = '$sw_desc', status_out = $status_out, cause = 'Manual' where trid = '$id'";
	
	$result = $conn -> query($query) or die(error);
	echo $query;
	echo "success";
	$conn = NULL;
	echo "<script type='text/javascript'>window.location.href = 'transformer_dashboard.php?id=0G0&status=all'</script>";


?>