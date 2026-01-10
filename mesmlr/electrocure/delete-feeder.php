<?php session_start();
if( !isset($_SESSION['userid']) or $_SESSION['role'] != "admin" ){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}

	$subdivid = 'mes05c1';
            $dbtype = 'electrocure';
	        require_once("opendb.php"); 
	$id="";
	if (isset($_GET['id'])==TRUE){
	$id= $_GET['id'];
	}
	
	$query="delete from feeder where fdid='". $id ."'";
	$conn->query($query)or die("deleting error");
	echo "<script language = \"javascript\" type = \"text/javascript\"> window.location.href=\"feeder-list.php?filter=0G0\"; </script>";	
           	$conn= NULL;

?>