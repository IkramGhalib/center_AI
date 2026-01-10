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
                height: 300,
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
                name: 'Non Balanced',
                data: data1
            }, {
                name: 'Balanced',
                data: data2
            }],
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
$q = "SELECT WBNL as bnl, WNL as nl, WK as datetime  FROM balance_load_weekly WHERE trid ='$id'";

$result= $conn -> query($q) or die("Query error");                          
foreach($result as $row)
{

        $nl = round($row['nl'],2);
        $bnl = round($row['bnl'],2);
        //$kvar3 = round($row['cval3']*$row['val3']/1000 * sin(acos($row['pf3'])),2);
        $graphName = "Graph";

        array_push($data1,$nl);
        array_push($data2,$bnl);
        
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