<?php 
include_once('check.php');
  authenticate("can_view");
  // echo '<pre>';
  // print_r($_SESSION['employee']);
  // exit;


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