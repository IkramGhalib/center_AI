<?php session_start();
if( !isset($_SESSION['cid'])){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
?>
<?php
	session_start();
	require_once("opendb.php");
	$id = $_SESSION['cid'];
	$billing_method = "";
	$query = "select * from connections where cid = '".$id."'";
	$result = $conn -> query($query) or die("Query error");
	foreach ($result as $row) {
		$billing_method = $row['billing_method'];
	}
	
	if($billing_method == "prepaid"){
		$query = "update connections set billing_method = 'postpaid' where cid = '".$id."'";
		echo ("Changed to postpaid");
	}elseif($billing_method == "postpaid"){ 
		$query = "update connections set billing_method = 'prepaid' where cid = '".$id."'";
		echo ("Changed to prepaid");
	}
	$stmt = $conn->prepare($query);
    $stmt -> execute();

	$conn = NULL;

	echo "<script language='javascript'>window.location.href='profile.php';</script>";
?>