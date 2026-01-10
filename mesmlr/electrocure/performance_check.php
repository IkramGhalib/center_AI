<?php
  include_once('check.php');
  authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Performance Check"; ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $pageName;?></title>
  
 <?php include_once('head.php') ?> 
 
</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue sidebar-mini" >
<!-- Site wrapper -->
<div class="wrapper" style="overflow: hidden;">
	
	
	<!-- Navbar -->
	<?php include_once('navbar.php'); ?>
	<!-- Sidebar -->
	<?php //include_once('sidebar.php'); ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  
  <div class="content-wrapper" style="margin-top: <?php echo $contentmargin?>px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <b><?php echo $pageName;?></b>
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageName;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
      <div class="col-12">
          <div class="box box-default collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Select Transformer to View Stats</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
            </div>
            <div class="box-body" style="display: none;">
              <form method="post" action="">
              <div class="form-group">
                  <?php
                    include_once("opendb.php");
                    $query = "select * from transformer";
                    $result = $conn -> query($query) or die(error);
                  ?>
                  <div class="col-sm-12">
                    <input type="text" list="trans" name="transformer" class="form-control" placeholder="Select Transformer">
                    <datalist id="trans">
                      <?php
                        foreach ($result as $row) {
                          echo "<option value='".$row['trid']."'>".$row['name']."</option>";
                        }
                      ?>
                    </datalist>
                  </div>
              </div>
              <div class="form-group">
              <label class="col-sm-12">Date & Time From</label>
                  <div class="col-sm-12">
                    <input type="date" name="datefrom" class="form-control" placeholder="">
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-12">
                    <input type="time" name="timefrom" class="form-control" placeholder="">
                  </div>
              </div>

              <div class="form-group">
              <label class="col-sm-12">Date & Time To</label>
                  <div class="col-sm-12">
                    <input type="date" name="dateto" class="form-control"  placeholder="">
                  </div>
              </div>
              <div class="form-group">
                  <div class="col-sm-12">
                    <input type="time" name="timeto" class="form-control" placeholder="">
                  </div>
              </div>
              <button type="submit" class="btn btn-primary pull-right" name="submit">Submit</button>
              </form>

            </div>
          </div>
        </div>


        <?php
        
        if (isset($_POST['submit']) and isset($_POST['transformer'])) {
          $transformer = $_POST['transformer'];
          $datefrom  = $_POST['datefrom'];
          $dateto  = $_POST['dateto'];
          $timefrom = $_POST['timefrom'];
          $timeto = $_POST['timeto'];

          if (!empty($datefrom)) {
            if (!empty($timefrom)) {
              $datefrom = $datefrom ." ". $_POST['timefrom'];
            }

            if (!empty($dateto)) {
              if (!empty($timeto)) {
                $dateto = $dateto ." ". $_POST['timeto'];
              }
              $query = "SELECT trid,offline_entry, count(*) as count FROM `transformer_delay_logs` where trid = '".$transformer."' AND datetime BETWEEN '".$datefrom."' AND '".$dateto."'";
            }

              $query = "SELECT trid,offline_entry, count(*) as count FROM `transformer_delay_logs` where trid = '".$transformer."' AND datetime BETWEEN '".$datefrom."' AND now()";
  
          }else{
            $query = "SELECT trid,offline_entry, count(*) as count FROM `transformer_delay_logs` where trid= '".$transformer."' group by offline_entry";
          }

        

       
        $result = $conn -> query($query) or die(error);
        $data = array();

        foreach ($result as $row) {
            array_push($data, array($row['trid'], $row['offline_entry'], $row['count']));
        }

        $graph_data = array(array(0,0),array(1,0),array(2,0),array(3,0),array(4,0),array(5,0),array(6,0));
        $greater5 = 0;
        for ($i=0; $i < sizeof($data) ; $i++) { 
            for ($j=0; $j < sizeof($graph_data); $j++) { 
                if ($data[$i][1] == $graph_data[$j][0]) {
                    $graph_data[$j][1] = $data[$i][2];
                }
            }

            if ($data[$i][1] > 6) {
                $graph_data[6][1] += $data[$i][2];
                
            }
        }
 
  
    ?>
    <div class="row">
     <div id="chart" class="col-md-6 col-md-offset-3">
    </div>
    </div>
   
    <div id="overflow" style="overflow-x:auto;">
    <table id="example1"  class="table table-responsive table-bordered table-striped">
      <thead class="bg-primary">
        <tr>
          <th scope="col">Transformer ID</th>
          <th scope="col">Delay Time</th>
          <th scope="col">Occurred</th>
          <th scope="col">Total Delay</th>
        </tr>
      </thead>
      <tbody>
        <?php
            for ($i=0; $i < sizeof($data) ; $i++) { 
                echo "<tr><td>".$data[$i][0]."</td><td>".$data[$i][1]." Minutes</td><td>".$data[$i][2]." Times</td><td>".$data[$i][1]*$data[$i][2]." Minutes</td></tr>";
            }
        ?>
    </tbody>
    <tfoot class="bg-primary">
      <tr>
        <th scope="col">Transformer ID</th>
        <th scope="col">Delay Time</th>
        <th scope="col">Occurred</th>
        <th scope="col">Total Delay</th>
      </tr>
    </tfoot>
    </table>



    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

    <script>
    window.onload = function () {
        loadgraph();
    }

    var data1 = <?php echo json_encode(array_column($graph_data, 1));?>;

    function loadgraph(){
        var options = {
            chart: {
                height: 350,
                width: 600,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: true,
                
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            series: [{
                name: 'Delay',
                data: data1
            }],
            xaxis: {
                categories: ["No Delay", "1 Min", "2 Min", "3 Min", "4 Min", "5 Min", "Greater than 5"],
                position: 'bottom',
                labels: {
                    offsetY: 0,

                },
                
                
                tooltip: {
                    enabled: true,
                    offsetY: -35,
                }
            },
            fill: {
                gradient: {
                    shade: 'light',
                    type: "horizontal",
                    shadeIntensity: 0.25,
                    gradientToColors: undefined,
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [50, 0, 100, 100]
                },
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function (val) {
                        return val + " Times";
                    }
                }

            },
            title: {
                text: '',
                floating: true,
                offsetY: 320,
                align: 'center',
                style: {
                    color: '#444'
                }
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#chart"),
            options
        );

        chart.render();
    }
    </script>



<?php


  }

?>






      
    </section>

    <!-- /.content -->


   
  </div>
  <!-- /.content-wrapper -->
  
	<?php include_once('footer.php') ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include_once('script.php') ?>
</body>
</html>
<script>
    $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : false,
    'ordering'    : true,
    'info'        : true,
    'autoWidth'   : false
    })
    })
</script>