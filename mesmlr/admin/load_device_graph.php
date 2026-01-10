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
                  name: "Line 1",
                  data: data1
                },
                {
                  name: "Line 2",
                  data: data2
                },
                {
                  name: 'Line 3',
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



	require_once("opendb.php");

    if($type==0)
    {  //kvar data
      $q = "SELECT * from tr_current_logs where trid = '".$id."' order by id desc limit 20";
      $result= $conn -> query($q) or die("Query error");                          
      foreach($result as $row)
      {
        $kvar1 = round($row['B1U']*$row['v1']/1000* sin(acos($row['pf1'])),2);
        $kvar2 = round($row['B1M']*$row['v2']/1000* sin(acos($row['pf2'])),2);
        $kvar3 = round($row['B1L']*$row['v3']/1000* sin(acos($row['pf3'])),2);
        $graphName = "KVAR Graph";

        array_push($data1,$kvar1);
        array_push($data2,$kvar2);
        array_push($data3,$kvar3);
        array_push($data4,$row['datetime']); 
        }                                               
    }
    elseif($type==1)
    {   // peak and off peak data
      $q = "SELECT * from tr_kwh_logs where trid = '".$id."' order by id desc limit 20";
      $result= $conn -> query($q) or die("Query error");                          
      foreach($result as $row)
      {
        $offpeak = round($row['offpeak_dev'],2);
        $peak =round($row['peak_dev'],2);
        $total = $offpeak + $peak;
        $graphName = "KWR Graph";

        array_push($data1,$offpeak);
        array_push($data2,$peak);
        array_push($data3,$total);
        array_push($data4,$row['datetime']);
        } 
    }
    elseif($type==2)
    { // kva data
      $q = "SELECT * from tr_current_logs where trid = '".$id."' order by id desc limit 20";
      $result= $conn -> query($q) or die("Query error");                          
      foreach($result as $row)
      {
        $kva1 = round($row['B1U']*$row['v1']/1000,2);
        $kva2 = round($row['B1M']*$row['v2']/1000,2);
        $kva3 = round($row['B1L']*$row['v3']/1000,2);
        $graphName = "KVA Graph";
         array_push($data1, $kva1);
         array_push($data2, $kva2);
         array_push($data3, $kva3);
         array_push($data4, $row['datetime']);
      }
    }
    elseif($type==3)
    {   // voltage
      $q = "SELECT * from tr_current_logs where trid = '".$id."' order by id desc limit 20";
      $result= $conn -> query($q) or die("Query error");                          
      foreach($result as $row)
      {
        $val1 = round($row['v1'],2);
        $val2 =round($row['v2'],2);
        $val3 =round($row['v3'],2);
        $graphName = "Voltage (Volts) Graph";

        array_push($data1,$val1);
        array_push($data2,$val2);
        array_push($data3,$val3);
        array_push($data4,$row['datetime']);
       } 
    }
    elseif($type==4)
    {   // currents data
      $q = "SELECT * from tr_current_logs where trid = '".$id."' order by id desc limit 20";
      $result= $conn -> query($q) or die("Query error");                          
      foreach($result as $row)
      {
        $cval1 = round($row['B1U'],2);
        $cval2 =round($row['B1M'],2);
        $cval3 =round($row['B1L'],2);
        $graphName = "Current (AMPs) Graph";

        array_push($data1,$cval1);
        array_push($data2,$cval2);
        array_push($data3,$cval3);
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
          	newData(js_data1.reverse(),js_data2.reverse(),js_data3.reverse(),js_data4.reverse());
        </script>
<?php
$conn =null;
?>