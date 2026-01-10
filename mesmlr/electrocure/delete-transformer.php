<?php session_start();
if( !isset($_SESSION['userid']) or $_SESSION['role'] != "admin" ){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
?>
<?php
    $subdivid = 'mes05c1';
    $dbtype = 'electrocure';
	require_once("opendb.php"); 
    $id="";
	if (isset($_GET['id'])==TRUE){
	$id= $_GET['id'];
	}
	
	$query="delete from transformer where trid='". $id ."'";
	$conn->query($query)or die("deleting error");
	echo "<script language = \"javascript\" type = \"text/javascript\"> window.location.href=\"transformer-list.php?filter=0G0\"; </script>";	
?>