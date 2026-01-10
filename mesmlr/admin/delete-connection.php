<?php session_start();
if( !isset($_SESSION['userid']) or $_SESSION['role'] != "admin" ){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
  
	require_once("opendb.php"); 
    $id="";
	if (isset($_GET['id'])==TRUE){
	$id= $_GET['id'];
	}
	
	$query="delete from connections where cid='". $id ."'";
	$conn->query($query)or die("deleting error");
	echo "<script language = \"javascript\" type = \"text/javascript\"> window.location.href=\"connection-list.php?filter=0G0\"; </script>";	
?>