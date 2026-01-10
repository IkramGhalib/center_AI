<!DOCTYPE html>
<html lang="en">
  
<head>
  <meta http-equiv="refresh" content="300">
<?php

  date_default_timezone_set("Asia/Karachi");
  $id= $_GET['id'];
  //$id = "I1F1TR02";
  $type=$_GET['type'];
  //$type = 2;
  $data1=array();
  $data2=array();
  $data3=array();
  $data4=array();
  $data=array();
  $graphName = "";


?>
  
  <style>
    body{
      background-color: #ECF0F5;
    }

    #chart {
      max-width: 650px;
      margin: 35px auto;
    }
  </style>
</head>

<body bgcolor="#dddddd">
 
 <div id="chart">

  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

  <script>
       var data1 = [];
        //var data2 = [];
        //var data3 = [];
        var cat = []; // categories to be shown on x-axis of the graph
        
        window.onload = function () {
            loadGraph();
        }

        function newData(ndata1,ncat) {
            data1 = ndata1.slice();
            cat = ncat.slice();
            document.getElementById('chart1').innerHTML = '';
            loadGraph();
        }

        function loadGraph(){
            var options = {
              chart: {
                height: 350,
                type: 'line',
                zoom: {
                  enabled: false
                }
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                curve: 'straight'
              },
              series: [{
                name: "Line 1",
                data: data1
              }],
              title: {
                text: '',
                align: 'left'
              },
              grid: {
                row: {
                  colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                  opacity: 0.5
                },
              },
              xaxis: {
                categories: cat,
              }
            }

            var chart = new ApexCharts(
              document.querySelector("#chart"),
              options
            );

            chart.render();
          }
  </script>
</body>

</html>

<?php


  

 $dbtype = 'electrocure';
  require_once("opendb.php");
  
             
    
    if($type==1){   // peak and off peak data
        $q = "select peak, offpeak,datetime from cust_kwh_logs where cid = '$id' order by datetime limit 30";
        $result = $conn -> query($q) or die("Query error");
        foreach ($result as $row ) {
          $total = round($row['offpeak'] + $row['peak'],2);
          $graphName = "KWH Graph";

          array_push($data1,$total);
          array_push($data4,date("H:i:a",strtotime($row['datetime'])));
        }
    }
    elseif($type==2){ // kva data
        $q = "select c1,v1,c2,v2,c3,v3,datetime from cust_current_logs where cid = '$id' order by datetime limit 30";
        $result = $conn -> query($q) or die("Query error");
        foreach ($result as $row ) {
          $kva = round($row['c1']*$row['v1']/1000,2) + round($row['c2']*$row['v2']/1000,2) + round($row['c3']*$row['v3']/1000,2);
          $graphName = "KVA Graph";
          array_push($data1, $kva);
          array_push($data4, date("H:i:a",strtotime($row['datetime'])));
        }
    }
    elseif($type==3){ // last 24 hours
        $q = "SELECT hour(datetime), max(peak+offpeak) as kwh, datetime FROM cust_kwh_logs WHERE cid = '$id' AND substring_index(datetime, ' ', 1) = CURDATE() group by hour(datetime)";
        $result = $conn -> query($q) or die("Query error");
        foreach ($result as $row ) {
          $kwh = round($row['kwh'],2);
          $graphName = "KVA Graph";
          array_push($data1, $kwh);
          array_push($data4, date("H:i:a",strtotime($row['datetime'])));
        }
    }
    elseif($type==3){ // last 30 days
        $q = "SELECT day(datetime), max(peak+offpeak) as kwh, datetime FROM cust_kwh_logs WHERE cid = '$id' AND substring_index(datetime, '-', 2) = substring_index(CURDATE(), "-", 2) group by day(datetime)
";
        $result = $conn -> query($q) or die("Query error");
        foreach ($result as $row ) {
          $kva = round($row['c1']*$row['v1']/1000,2) + round($row['c2']*$row['v2']/1000,2) + round($row['c3']*$row['v3']/1000,2);
          $graphName = "KVA Graph";
          array_push($data1, $kva1);
          array_push($data4, date("H:i:a",strtotime($row['datetime'])));
        }
    }

?>
    <script type="text/javascript">
          var js_data1 = [<?php echo '"'.implode('","', $data1).'"' ?>];
          var js_data4 = [<?php echo '"'.implode('","', $data4).'"' ?>];
          var titleID = "<?php echo $graphName; ?>";
            newData(js_data1,js_data4);
        </script>
<?php
  $conn =null;
?> 