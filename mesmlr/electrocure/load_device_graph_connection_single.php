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


//$subdivid = 'mes05c1';
  //  $dbtype = 'electrocure';
  require_once("opendb.php");
$q = "SELECT * from cust_current_logs where cid = '".$id."' order by datetime desc limit 20";
$result= $conn -> query($q) or die("Query error");                          
foreach($result as $row)
{
    // if($type==0)
    // {  //kvar data
    //     $kvar1 = round($row['c1']*$row['v1']* sin(acos($row['pf1'])),2);
    //     $graphName = "KVAR Graph";

    //     array_push($data1,$kvar1);
    //     array_push($data4,$row['datetime']);                                                
    // }
    if($type==1)
    { // KWH
        $kwh = round($row['peak']+$row['offpeak'],2);
        $graphName = "KWH Graph";
         array_push($data1, $kwh);
         array_push($data4, $row['datetime']);
    }
    elseif($type==2)
    { // kva data
        $kva1 = round($row['c1']*$row['v1']/1000,2);
        $graphName = "KVA Graph";
         array_push($data1, $kva1);
         array_push($data4, $row['datetime']);
    }
    elseif($type==3)
    {   // peak and off peak data
        $v1 = round($row['v1'],2);
        $graphName = "Voltage (Volts) Graph";
        array_push($data1,$v1);
        array_push($data4,$row['datetime']);
        
    }
    elseif($type==4)
    {   // peak and off peak data
        $c1 = round($row['c1'],2);
        $graphName = "Current (AMPs) Graph";

        array_push($data1,$c1);
        array_push($data4,$row['datetime']);
        
    }
}

?>
    <script type="text/javascript">
          var js_data1 = [<?php echo '"'.implode('","', $data1).'"' ?>];
          var js_data4 = [<?php echo '"'.implode('","', $data4).'"' ?>];
          //alert(js_data4);
          var titleID = "<?php echo $graphName; ?>";
          //js_data1.reverse();
       
          //js_data4.reverse();
            newData(js_data1,js_data4);
        </script>
<?php
$conn =null;
?>