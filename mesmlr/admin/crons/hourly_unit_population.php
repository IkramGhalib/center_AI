<?php
date_default_timezone_set("Asia/Karachi");
$dbtype = "netmeter";
$subdivid_array= array("26217");
for ($sub_index=0; $sub_index< sizeof($subdivid_array); $sub_index++)
{
$subdivid = $subdivid_array[$sub_index];

$dbhost = "10.13.144.6";
$dbuser = "user_".$subdivid;
$dbpass =  "Adm1n@".$subdivid;
$dbname =  $dbtype."_".$subdivid;
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    $sql  =" INSERT INTO `netmeter_26217`.`cust_kwh_hourly_logs` SELECT null,cid,hour(datetime) as hour, day(datetime) as day,month(datetime) as month,year(datetime) as year,sum(round(offpkunits,2)) as offpeak, sum(round(pkunits,2)) as peak FROM `netmeter_26217`.`cust_kwh_logs` where datetime > now()-interval 1 hour GROUP BY cid, hour,day,month,year ORDER BY year,month,day,hour";
    $result = mysqli_query($db,$sql);
 	$db->close();
}
?>
