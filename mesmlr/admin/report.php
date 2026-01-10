<?php
	include_once("opendb.php");
	$q1 = "select trid from transformer";
	$result1 = $conn -> query($q1) or die(error);

	echo "Step 1 --- Successful <br>";
	

	echo "Step 2 --- Successful <br>";

	foreach ($result1 as $transformer) {
		$data = array();
		$nul = array();


		$trid = $transformer['trid'];
		echo "<br>Transformer ID: ".$trid;
		$query = "SELECT transformer.trid, tr_current_logs.NC* tr_current_logs.NC * transformer.ltlength * transformer.cresistance AS nloss, tr_current_logs.datetime FROM tr_current_logs,transformer WHERE tr_current_logs.trid = transformer.trid and tr_current_logs.trid = '$trid' ORDER by datetime";

		$result = $conn -> query($query) or die(error);
		
		foreach ($result as $row) {
			array_push($data, array($row['trid'],$row['nloss'], $row['datetime']));
		}

		//print_r($data);
		for ($week=1; $week <= 52; $week++) { 
			array_push($nul, array($week, 0));
		}

		for ($i=1; $i < sizeof($data); $i++) {
			$val = $data[$i][1] * (abs(strtotime($data[$i][2]) - strtotime($data[$i-1][2]))/3600);
			$nul[date('W', strtotime($data[$i][2]))][1] += $val;
		}

		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Transformer NUL/week</title>
		</head>
		<body>
			<table border="1">
				<thead>
					<tr>
						<td>Week</td>
						<td>NUL</td>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($line=0; $line < sizeof($nul); $line++) { 

							if ($nul[$line][1] != 0) {
							?>
							<tr>
								<td><?php echo $nul[$line][0]; ?></td>
								<td><?php echo $nul[$line][1]; ?></td>
							</tr>
							<?php
							}
						}
					?>
				</tbody>
			</table>
		</body>
		</html>

		<?php

	}
	echo "Last Step --- Successful <br>";

	$conn = NULL;	


?>

