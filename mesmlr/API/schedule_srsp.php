<?php
	// require_once("subdivid.php");
	// $subdivid = "basic";
	// $subdivid = "basic";
	$subdivid = $_GET['subdivid']; // Retrieve subdivid from URL
  	$dbtype = "electrocure";

	$servername = "10.13.144.6";
	$username = "user_".$subdivid;
	$password = "Adm1n@".$subdivid;
	$dbname = $dbtype."_".$subdivid;

	// $servername = "localhost";
	// $username = "root";
	// $password = "";
	// $dbname = "waterscada";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//echo "Connection Successfull";
}
catch(PDOException $e)
    {
    echo  $e->getMessage();
    echo "Unsuccesfull! Try again...!";
    }

	$deviceId = $_GET['id'];
	$query = "select * from auto_switching where trid = '".$deviceId."' order by auto_switching.repeat asc";
	// BASIC
	
	$result = $conn -> query($query) or die(error);
	//echo $query;
	$time = "schedule=";
	$monday = array();
	$tuesday = array();
	$wednesday = array();
	$thursday = array();
	$friday = array();
	$saturday = array();
	$sunday = array();

	foreach ($result as $row) {

		if ($row['repeat'] == 0) {
			array_push($monday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
			array_push($tuesday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));		
			array_push($wednesday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
			array_push($thursday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
			array_push($friday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
			array_push($saturday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
			array_push($sunday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
		}elseif ($row['repeat'] == 1) {
			array_push($monday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
		}elseif ($row['repeat'] == 2) {
			array_push($tuesday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
		}elseif ($row['repeat'] == 3) {
			array_push($wednesday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
		}elseif ($row['repeat'] == 4) {
			array_push($thursday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
		}elseif ($row['repeat'] == 5) {
			array_push($friday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
		}elseif ($row['repeat'] == 6) {
			array_push($saturday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
		}elseif ($row['repeat'] == 7) {
			array_push($sunday, array(substr($row['actual_ontime'],0,-3), substr($row['actual_offtime'],0,-3)));
		}
	}

	if (sizeof($monday) != 0) {
		for ($i=0; $i < sizeof($monday); $i++) { 
			$time .= $monday[$i][0].",";
			$time .= $monday[$i][1].",";	
				
		}
		//echo $time;
		$time = substr($time, 0, -1);
		$time .= ";";
	}else{
		$time .= "xxxx;";
	}

	if (sizeof($tuesday) != 0) {
		for ($i=0; $i < sizeof($tuesday); $i++) { 
			$time .= $tuesday[$i][0].",";	
			$time .= $tuesday[$i][1].",";	
		}
		//echo $time;
		$time = substr($time, 0, -1);
		$time .= ";";
	}else{
		$time .= "xxxx;";
	}

	if (sizeof($wednesday) != 0) {
		for ($i=0; $i < sizeof($wednesday); $i++) { 
			$time .= $wednesday[$i][0].",";	 
			$time .= $wednesday[$i][1].",";	
		}
		//echo $time;
		$time = substr($time, 0, -1);
		$time .= ";";
	}else{
		$time .= "xxxx;";
	}

	if (sizeof($thursday) != 0) {
		for ($i=0; $i < sizeof($thursday); $i++) { 
			$time .= $thursday[$i][0].",";	 
			$time .= $thursday[$i][1].",";	
		}
		//echo $time;
		$time = substr($time, 0, -1);
		$time .= ";";
	}else{
		$time .= "xxxx;";
	}

	if (sizeof($friday) != 0) {
		for ($i=0; $i < sizeof($friday); $i++) { 
			$time .= $friday[$i][0].",";	
			$time .= $friday[$i][1].",";	
		}
		//echo $time;
		$time = substr($time, 0, -1);
		$time .= ";";
	}else{
		$time .= "xxxx;";
	}

	if (sizeof($saturday) != 0) {
		for ($i=0; $i < sizeof($saturday); $i++) { 
			$time .= $saturday[$i][0].",";
			$time .= $saturday[$i][1].",";	
		}

		//echo $time;
		$time = substr($time, 0, -1);
		$time .= ";";
	}else{
		$time .= "xxxx;";
	}

	if (sizeof($sunday) != 0) {
		for ($i=0; $i < sizeof($sunday); $i++) { 
			$time .= $sunday[$i][0].",";	
			$time .= $sunday[$i][1].",";	
		}
		//echo $time;
		$time = substr($time, 0, -1);
		$time .= ";";
	}else{
		$time .= "xxxx;";
	}

	$time .= "END";

	$time = str_replace(":","",$time);
	echo $time;

	$conn = NULL;
?>