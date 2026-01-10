<!DOCTYPE html>
<html>
<head>
	<title>Web Calculated Units</title>
</head>
<body>

	<?php
		if (isset($_GET['id'])) {
			$cid = $_GET['id'];
			require_once("opendb.php");
			$values = array();
			$query = "select * from cust_current_logs where cid = '".$cid."' order by datetime asc";
			$result = $conn -> query($query) or die(error);
			foreach ($result as $row) {
				array_push($values, array($row['v1'],$row['v2'],$row['v3'],$row['c1'],$row['c2'],$row['c3'],$row['pf1'],$row['pf2'],$row['pf3'],$row['datetime']));
			}
			?>

			<table border="1">
				<thead>
					<tr>
						<td>CID</td>
						<td>KWH 1</td>
						<td>KWH 2</td>
						<td>KWH 3</td>
						<td>TOTAL</td>
						<td>DateTime</td>
					</tr>
				</thead>
			
				<tbody>
					<?php
						$kwh1 = 0;
						$kwh2 = 0;
						$kwh3 = 0;

						for ($i=1; $i < sizeof($values); $i++) { 
							$diff = strtotime($values[$i][9]) - strtotime($values[$i-1][9]);
							if ($diff > 900) {
								goto skip;
							}
							$kwh1 += ($values[$i][0] * $values[$i][3] * $values[$i][6] * ($diff/3600))/1000;
							$kwh2 += ($values[$i][1] * $values[$i][4] * $values[$i][7] * ($diff/3600))/1000;
							$kwh3 += ($values[$i][2] * $values[$i][5] * $values[$i][8] * ($diff/3600))/1000;

							?>
							<tr>
								<td><?php echo $cid; ?></td>
								<td><?php echo round($kwh1,2); ?></td>
								<td><?php echo round($kwh2,2); ?></td>
								<td><?php echo round($kwh3,2); ?></td>
								<td><?php echo round($kwh1 + $kwh2 + $kwh3,2); ?></td>
								<td><?php echo $values[$i][9]; ?></td>
							</tr>						
							<?php
							skip:
						}
					?>
					
				</tbody>

			</table>


			<?php
			$conn = NULL;
		}else{
			echo "Error: id not set!";
		}
		
		

	?>

</body>
</html>

