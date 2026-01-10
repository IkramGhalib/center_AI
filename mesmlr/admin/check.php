<?php 
	session_start();
	
	function authenticate($page){
		if (!isset($_SESSION['employee'])) {
			echo "<script>window.location.href = 'login.php';</script>";
		}

		if ($page != "ignore") {
			if($_SESSION['employee'][$page] == 0){
			echo "<script>window.location.href = 'unauthorized.php';</script>";
			}
		}
	}
?>