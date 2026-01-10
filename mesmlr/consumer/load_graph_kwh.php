
<?php
  require_once("opendb.php");
  $id = $_GET['id'];
  $type = $_GET['type'];
  $pay = $_GET['pay'];
  $data1 = array();
  $data2 = array();
  $data4 = array();

  $price_query = "select * from tariff order by datetime desc limit 1";
  $price = $conn -> query($price_query) or die(error); 
  foreach ($price as $key) {
    if ($pay == 1)
      $unit = $key['prepaid_unit'];
    elseif($pay == 2)
      $unit = $key['postpaid_unit'];
  }

  if($type==3){ // last 24 hours
      $graphName = "Today's Hourly Graph";
      $q = "SELECT hour(datetime) as dt, max(peak+offpeak) as kwh FROM cust_kwh_logs WHERE cid = '$id' AND substring_index(datetime, ' ', 1) = CURDATE() group by hour(datetime)";
      //echo $q;
      $result = $conn -> query($q) or die("Query error");

      foreach ($result as $row ) {
        $kwh = round($row['kwh'],2);
        

        array_push($data1, $kwh);
        array_push($data2, $kwh*$unit);
        array_push($data4, $row['dt']);
      }
  }
  elseif($type==4){ // last 30 days
      $graphName = "This Month Daily Graph";
      $q = "SELECT day(datetime) as dt, max(peak+offpeak) as kwh FROM cust_kwh_logs WHERE cid = '$id' AND substring_index(datetime, '-', 2) = substring_index(CURDATE(), '-', 2) group by day(datetime)";
      //echo $q;

      $result = $conn -> query($q) or die("Query error");
      foreach ($result as $row ) {
        $kwh = round($row['kwh'],2);

        array_push($data1, $kwh);
        array_push($data2, $kwh*$unit);
        array_push($data4, $row['dt']);
      }
    }
    $conn =null;

?>
  <script type="text/javascript">
    var js_data1 = [<?php echo '"'.implode('","', $data1).'"' ?>];
    console.table(js_data1);
    var js_data2 = [<?php echo '"'.implode('","', $data2).'"' ?>];
    var js_data4 = [<?php echo '"'.implode('","', $data4).'"' ?>];
    var titleID = "<?php echo $graphName; ?>";
    newData(js_data1,js_data2,js_data4);
  </script>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Line, Column &amp; Area</title>
    <link href="../../assets/styles.css" rel="stylesheet" />
    <style>
      #chart {
        max-width: 650px;
        margin: 35px auto;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> 
  </head>
  <body>
     <div id="chart"></div>
    <script>
        var options = {
          series: [{
          name: 'Units Consumed',
          type: 'column',
          data: js_data1
        }, {
          name: 'Estimated Bill',
          type: 'line',
          data: js_data2
        }],
          chart: {
          height: 350,
          type: 'line',
        },
        stroke: {
          width: [0, 3],
          colors:['#F44336']
        },
        title: {
          text: titleID
        },
        dataLabels: {
          enabled: true,
          enabledOnSeries: [1],
          style: {
            colors: ['#F44336']
          }
        },
        labels: js_data4,
        xaxis: {
         
        },
        yaxis: [{
          title: {
            text: 'Units Consumed',
          },
        
        }, {
          opposite: true,
          title: {
            text: 'Estimated Bill'
          }
        }]
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
  </body>
</html>


