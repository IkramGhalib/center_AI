
<?php
	// "PAGE LOADED!";
	date_default_timezone_set("Asia/Karachi");
	$dbtype = "electrocure";
	$feeders = array(array("mes10c1","I1F1"));

	for ($x = 0 ; $x <sizeof($feeders); $x++)
	{
		$subdivid = $feeders[$x][0];

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = $dbtype."_".$subdivid;
		$servername = "10.13.144.6";
		$username = "user_".$subdivid;
		$password = "Adm1n@".$subdivid;

		try {
		    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//echo "Connection Successfull";
		}
		catch(PDOException $e){
			echo  $e->getMessage();
		}


		for($i=1; $i<sizeof($feeders[$x]);$i++){
			
			$feeder = $feeders[$x][$i];
			echo "feeder: ".$feeder."<br>";

			$check = "SELECT TIMESTAMPDIFF(minute,(outfeeder.datetime), max(transformer.datetime)) as diff from transformer, outfeeder where substring_index(transformer.trid, 'TR', 1) = outfeeder.fdid and fdid = '$feeder'";

			$result = $conn -> query($check) or die(error);
			$minutes = 0; 
			foreach ($result as $row) {
				$minutes = $row['diff'];
			}
			if ($minutes > 0) {
				$v1 = 0;
				$v2 = 0;
				$v3 = 0;
				$c1 = 0;
				$c2 = 0;
				$c3 = 0;
				$pf1 = 0;
				$pf2 = 0;
				$pf3 = 0;
				$peak = 0;
				$offpeak = 0;
				$dt = "";
								
				$timeDiff = 0;
			
				//echo "Getting Data<br>";
				
				$trQuery = "select AVG(v1) as v1,AVG(v2) as v2,AVG(v3) as v3,SUM(c1) as c1,SUM(c2) as c2,SUM(c3) as c3,MAX(pf1) as pf1,MAX(pf2) as pf2,MAX(pf3) as pf3, MAX(datetime) as dt from transformer WHERE substring_index(trid, 'TR', 1) = '$feeder' and TIMESTAMPDIFF(minute,now(),datetime) < 15";

				//echo $trQuery;

				$result = $conn -> query($trQuery) or die(error);
				//echo $dbQuery."<br>";
				//echo "Selection: Success<br>";
				$count = 0;
				foreach ($result as $row) {
					$count++;
					$v1 += $row['v1'];
					$v2 += $row['v2'];
					$v3 += $row['v3'];
					$c1 = $row['c1'];
					$c2 = $row['c2'];
					$c3 = $row['c3'];
					$pf1 = $row['pf1'];
					$pf2 = $row['pf2'];
					$pf3 = $row['pf3'];
				

					$dt = max($row['dt'],$dt);

				}


				$v1 = $v1;
				$v2 = $v2;
				$v3 = $v3;
				echo "V: ".$v1.", ".$v2.", ".$v3."<br>";
				$kva1 = $v1*$c1/1000;
				$kva2 = $v2*$c3/1000;
				$kva3 = $v3*$c3/1000;

				echo "KVA: 0".$kva1.", ".$kva2.", ".$kva3."<br>";
				echo "C: ".$c1.", ".$c2.", ".$c3."<br>";

				$v1 = round((($v1)/2)/1.732,2);
				$v2 = round((($v2)/2)/1.732,2);
				$v3 = round((($v3)/2)/1.732,2);
				echo "V: ".$v1.", ".$v2.", ".$v3."<br>";
				
				$c1 = round($kva1/($v1*0.1732),2);
				$c2 = round($kva2/($v2*0.1732),2);
				$c3 = round($kva3/($v3*0.1732),2);
				echo "C: ".$c1.", ".$c2.", ".$c3."<br>";

				$kva1 = $v1*0.1732*$c1;
				$kva2 = $v2*0.1732*$c3;
				$kva3 = $v3*0.1732*$c3;
				echo "KVA: ".$kva1.", ".$kva2.", ".$kva3."<br>";

				$pf1 = round($pf1,2);
				$pf2 = round($pf2,2);
				$pf3 = round($pf3,2);

				//echo $c1+$c2+$c3;
				//echo "Attempting Insertion<br>";
				$feeder = 'I1F01';
				$sql  = "update  outfeeder set `datetime` = '".$dt."',`c1` = '". $c1."',`c2` = '". $c2."',`c3` = '". $c3."',`v1` = '". $v1."',`v2` = '". $v2."',`v3` = '". $v3."',`pf1` = '". $pf1."',`pf2` = '". $pf2."',`pf3` = '". $pf3."' where fdid = '$feeder'";
				//echo $sql."<br>";
				$result = $conn -> query($sql) or die(error);

				$insertCL = "insert into ofd_current_logs (trid,v1,v2,v3,B1U,B1M,B1L,pf1,pf2,pf3,datetime) values('$feeder',$v1,$v2,$v3,$c1,$c2,$c3,$pf1,$pf2,$pf3,'".$dt."')";

				echo $insertCL;
				//echo $insertCL."<br>";
				$result = $conn -> query($insertCL) or die(error);
				//echo "Insertion: Success<br>";


			}else{
				echo "Already Updated!";
			}
			}

    	$conn = NULL;
	}

?>
