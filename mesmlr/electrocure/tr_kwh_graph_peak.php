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

window.onload = function() {
//loadGraph();
}

function newData(ndata1, ndata2, ndata3, ncat) {
data1 = ndata1.slice();
data2 = ndata2.slice();
data3 = ndata3.slice();
cat = ncat.slice();
document.getElementById('chart1').innerHTML = '';
loadGraph();
}

function loadGraph() {

var options = {
chart: {
height: 250,
width: 800,
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
name: "VOLTAGE 1",
data: data1
},
{
name: "VOLTAGE 2",
data: data2
}, {
name: "VOLTAGE 3",
data: data3
},

],
title: {
text: titleID,
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
formatter: function(val) {
return val
}
}
}, {
title: {
formatter: function(val) {
return val
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
$q = "SELECT * from pesco_unit_comparison where trid = '$id' order by datetime desc limit 30";
$result= $conn -> query($q) or die("Query error");                          
foreach($result as $row)
{

        $kvar1 = round($row['our_peak_unit'],2);
        $kvar2 = round($row['pesco_peak_unit'],2);
        //$kvar3 = round($row['cval3']*$row['val3']/1000 * sin(acos($row['pf3'])),2);
        $graphName = "CISNR-PESCO Peak Unit Comparison";

        array_push($data1,$kvar1);
        array_push($data2,$kvar2);
        
        array_push($data4,$row['datetime']);                                                
  
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