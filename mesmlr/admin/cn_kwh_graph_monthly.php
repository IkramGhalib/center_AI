<!DOCTYPE html>
<html lang="en">

<head>
  
<?php

date_default_timezone_set("Asia/Karachi");
$id= $_GET['id'];

//$type = 2;
$data1=array();
$data2=array();
$data3=array();
$data4=array();
$data=array();
$graphName = "";


?>
  <link href="../../assets/styles.css" rel="stylesheet" />
    <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

  <style>
    body{
background-color: #ECF0F5;

    }
    #chart1 {
      max-width: 650zpx;
      margin: 35px auto;
    }
  </style>
</head>

<body bgcolor="#dddddd">
  <div id="chart1">

  </div>

  <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

  <script>
        var data1 = [];
        var data2 = [];
        var data3 = [];
        var cat = []; // categories to be shown on x-axis of the graph
        
        window.onload = function () {
            //loadGraph();
        }

        function newData(ndata1,ndata2,ndata3,ncat) {
            data1 = ndata1.slice();
            data2 = ndata2.slice();
            data3 = ndata3.slice();
            cat = ncat.slice();
            document.getElementById('chart1').innerHTML = '';
            loadGraph();
        }

          function loadGraph(){
                  
           var options = {
            chart: {
                height: 350,
                width: 600,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'  
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            series: [{
                name: 'Peak',
                data: data1
            }, {
                name: 'Off Peak',
                data: data2
            }, {
                name: 'Total KWH',
                data: data3
            }],
            title: {
                text: 'KWH Monthly Logs',
                align: 'left'
            },
            xaxis: {
                categories: cat,
            },
            yaxis: {
                title: {
                    text: 'KWH'
                }
            },
            fill: {
                opacity: 1

            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " Units"
                    }
                }
            }
        }

        var chart = new ApexCharts(
            document.querySelector("#chart1"),
            options
        );

        chart.render();
       
          
          }
    
  </script>
</body>

</html>

<?php


require_once("opendb.php"); 
$q = "select distinct date(datetime) as datetime, peak, offpeak from cust_kwh_logs where cid = '$id' and datetime in (select max(datetime) from cust_kwh_logs where cid ='$id' and datetime > DATE_SUB(now(), INTERVAL 30 DAY) group by day(datetime))";
$result= $conn -> query($q) or die("Query error");                          
foreach($result as $row)
{

        $peak = round($row['peak'],2);
        $offpeak = round($row['offpeak'],2);
        $total = $peak + $offpeak;

        $graphName = "Peak & Off Peak Bar Graph";

        array_push($data1,$peak);
        array_push($data2,$offpeak);
        array_push($data3,$total);
        array_push($data4,$row['datetime']);                                                 
}
    
?>
    <script type="text/javascript"> 
          var js_data1 = [<?php echo '"'.implode('","', $data1).'"' ?>];
          var js_data2 = [<?php echo '"'.implode('","', $data2).'"' ?>];
          var js_data3 = [<?php echo '"'.implode('","', $data3).'"' ?>];
          var js_data4 = [<?php echo '"'.implode('","', $data4).'"' ?>];
          var titleID = "<?php echo $graphName; ?>";
            newData(js_data1,js_data2,js_data3,js_data4);
        </script>
<?php
 $conn =null;
?> 