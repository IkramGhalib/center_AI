<!DOCTYPE html>
<html lang="en">
  
<head>
  
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
  <link href="../../assets/styles.css" rel="stylesheet" />
    <!-- Bootstrap 3.3.7 -->
      <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

  <style>
    body{
background-color: #ECF0F5;

    }
    #chart1 {
      
     
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
                width: 550,
                type: 'line',
                zoom: {
                  enabled: false
                },
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                width: [3, 3, 3],
                curve: 'straight',
                dashArray: [0, 0, 0]
              },
              series: [{
                  name: "Series 1",
                  data: data1
                },
                {
                  name: "Series 2",
                  data: data2
                },
                {
                  name: 'Series 3',
                  data: data3
                }
              ],
              title: {
                text:  titleID,
                align: 'left'
              },
              markers: {
                size: 0,

                hover: {
                  sizeOffset: 6
                }
              },
              xaxis: {
                categories: cat,
              },
              tooltip: {
                y: [{
                  title: {
                    formatter: function (val) {
                      return val
                    }
                  }
                }, {
                  title: {
                    formatter: function (val) {
                      return val
                    }
                  }
                }, {
                  title: {
                    formatter: function (val) {
                      return val;
                    }
                  }
                }]
              },
              grid: {
                borderColor: '#f1f1f1',
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


//$subdivid = 'mes05c1';
  //  $dbtype = 'electrocure';
	require_once("opendb.php");
$q = "SELECT * from cust_current_logs where cid = '".$id."' and datetime > now()- interval 1 day limit 20";
$result= $conn -> query($q) or die("Query error");                          
foreach($result as $row)
{
    if($type==0)
    {  //kvar data
        $kvar1 = round($row['c1']*$row['v1']* sin(acos($row['pf1'])),2);
        $kvar2 = round($row['c2']*$row['v2']* sin(acos($row['pf2'])),2);
        $kvar3 = round($row['c3']*$row['v3']* sin(acos($row['pf3'])),2);
        $graphName = "KVAR Graph";

        array_push($data1,$kvar1);
        array_push($data2,$kvar2);
        array_push($data3,$kvar3);
        array_push($data4,$row['datetime']);                                                
    }
    elseif($type==1)
    {   // peak and off peak data
        $offpeak = round($row['offpeak'],2);
        $peak =round($row['peak'],2);
        $total = $offpeak + $peak;
        $graphName = "KWR Graph";

        array_push($data1,$offpeak);
        array_push($data2,$peak);
        array_push($data3,$total);
        array_push($data4,$row['datetime']);
        
    }
    elseif($type==2)
    { // kva data
        $kva1 = round($row['c1']*$row['v1'],2);
        $kva2 = round($row['c2']*$row['v2'],2);
        $kva3 = round($row['c3']*$row['v3'],2);
        $graphName = "KVA Graph";
         array_push($data1, $kva1);
         array_push($data2, $kva2);
         array_push($data3, $kva3);
         array_push($data4, $row['datetime']);
    }
    elseif($type==3)
    {   // peak and off peak data
        $v1 = round($row['v1'],2);
        $v2 =round($row['v2'],2);
        $v3 =round($row['v3'],2);
        $graphName = "Voltage (Volts) Graph";

        array_push($data1,$v1);
        array_push($data2,$v2);
        array_push($data3,$v3);
        array_push($data4,$row['datetime']);
        
    }
    elseif($type==4)
    {   // peak and off peak data
        $c1 = round($row['c1'],2);
        $c2 =round($row['c2'],2);
        $c3 =round($row['c3'],2);
        $graphName = "Current (AMPs) Graph";

        array_push($data1,$c1);
        array_push($data2,$c2);
        array_push($data3,$c3);
        array_push($data4,$row['datetime']);
        
    }
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