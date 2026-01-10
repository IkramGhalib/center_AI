<?php
  include_once('check.php');
  authenticate("view");
?>

<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Distribution Box Consumption Logs"?>



  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $pageName;?></title>
  
 <?php include_once('head.php') ?> 
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  var ifdid = "";
  var ofdid = "";
  var trid = "";
  var dbid = "";
    $(document).ready(function(){
      $("#infeeder").change(function(){
        ifdid = $("#infeeder").val();
        $.ajax({
          url: 'data.php',
          method: 'post',
          data: 'ifdid=' + ifdid
        }).done(function(outfeeders){
          console.log(outfeeders);
          outfeeders = JSON.parse(outfeeders);
          $('#outfeeder').empty();
          $('#outfeeder').append('<option>---SELECT OUT FEEDER---</option>');
           outfeeders.forEach(function(outfeeder){
            $('#outfeeder').append('<option value = '+outfeeder.id+'> '+ outfeeder.name +' </option>')
           })
        })
      })
    });

    $(document).ready(function(){
      $("#outfeeder").change(function(){
        ofdid = $("#outfeeder").val();
        $.ajax({
          url: 'data2.php',
          method: 'post',
          data: 'ofdid=' + ofdid
        }).done(function(transformers){
          console.log(transformers);
          transformers = JSON.parse(transformers);
          $('#transformer').empty();
          $('#transformer').append('<option>---SELECT TRANSFORMER---</option>');
           transformers.forEach(function(transformer){
            $('#transformer').append('<option value = '+ transformer.id +'> '+ transformer.id +' </option>')
           })
        })
      })
    });

    $(document).ready(function(){
      $("#transformer").change(function(){
        trid = $("#transformer").val();
        $.ajax({
          url: 'data3.php',
          method: 'post',
          data: 'trid=' + trid
        }).done(function(dbs){
          console.log(dbs);
          dbs = JSON.parse(dbs);
          $('#db').empty();
          $('#db').append('<option>---SELECT DISTRIBUTION BOX---</option>');
           dbs.forEach(function(db){
            $('#db').append('<option value = '+ db.id +'> '+ db.name +' </option>')
           })
        })
      })
    });

  </script>


</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue sidebar-mini" >
<!-- Site wrapper -->
<div class="wrapper" style="overflow: hidden;">
	
	
	<!-- Navbar -->
	<?php include_once('navbar.php') ?>
	<!-- Sidebar -->
  <aside class="main-sidebar" style="margin-top: <?php echo $sidebarmargin;?>px;">
        <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="overflow-x: scroll;">
          <!-- sidebar menu: : style can be found in sidebar.less -->
         
      <ul class="sidebar-menu">
            
        <li class="header">Select Specific Distribution Boxes</li>
        <br>

          <?php 
          require_once("opendb.php");
          $query = "select fdid, name from feeder";
          $result = $conn -> query($query) or die("Query error");

          if (!$detect->isMobile() and !$detect->isTablet()) {
          
          ?>
          <form id="sidebarform" method="post">
          <select id="infeeder" name="infeeder" class="form-control">
            <option selected="" disabled="">---SELECT IN-FEEDER---</option>
            <?php
            foreach ($result as $row) {
              if($filter != "0G0" && $row['fdid'] == substr(string, start))
              ?>
              <option value="<?php echo $row['fdid']; ?>"><?php echo $row['name']; ?></option>
              <?php
            }
            ?>
          </select>
        
          <br>
          <select id="outfeeder" name="outfeeder" class="form-control">
            <option selected="" disabled="">---SELECT OUT-FEEDER---</option>
          </select>
        
          <br>
          <select id="transformer" name="transformer" class="form-control">
            <option selected="" disabled="">---SELECT TRANSFORMER---</option>
          </select>
          <br>

          <select id="db" name="db" class="form-control">
            <option selected="" disabled="">---SELECT DISTRIBUTION BOX---</option>
          </select>
         <div><b>Date From:</b></div>
          <input type="date" id="fromdate" name="fromdate" class="form-control" placeholder="Logs From">
          <input type="time" id="fromtime" name="fromdate" class="form-control" placeholder="Logs From">

          <div><b>Date To:</b></div>
          <input type="date" id="todate" name="todate" class="form-control" placeholder="Logs to">
          <input type="date" id="totime" name="todate" class="form-control" placeholder="Logs to">

          <br>
          <button style="float: right; margin-right:5px; " class="btn-primary btn" name="submit"> Submit </button>

        </form>
<?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>




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
      <br>
       
       <?php
      if ($detect->isMobile() or $detect->isTablet()) {

        ?>
          <div class="box box-default box-solid collapsed-box">
            <div class="box-header with-border">
              <h3 class="box-title">Select Specific Distribution Box</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: none;">

        <form id="sidebarform" method="post">
          <select id="infeeder" name="infeeder" class="form-control">
            <option selected="" disabled="">---SELECT IN-FEEDER---</option>
            <?php

            foreach ($result as $row) {
              if($filter != "0G0" && $row['fdid'] == substr(string, start))
              ?>
              <option value="<?php echo $row['fdid']; ?>"><?php echo $row['name']; ?></option>
              <?php
            }
            ?>
          </select>
          
          <br>
          <select id="outfeeder" name="outfeeder" class="form-control">
            <option selected="" disabled="">---SELECT OUT-FEEDER---</option>
          </select>
          
          <br>
          <select id="transformer" name="transformer" class="form-control">
            <option selected="" disabled="">---SELECT TRANSFORMER---</option>
          </select>
          
          <br>

          <select id="db" name="db" class="form-control">
            <option selected="" disabled="">---SELECT DISTRIBUTION BOX---</option>
          </select>
          
          <div><b>Date From:</b></div>
          <input type="date" id="fromdate" name="fromdate" class="form-control" placeholder="Logs From">
          <input type="time" id="fromtime" name="fromdate" class="form-control" placeholder="Logs From">

          <div><b>Date To:</b></div>
          <input type="date" id="todate" name="todate" class="form-control" placeholder="Logs to">
          <input type="date" id="totime" name="todate" class="form-control" placeholder="Logs to">

          <br>
          <button style="float: right; margin-right:5px; " class="btn-primary btn" name="submit"> submit </button>

        </form>

            </div>
            <!-- /.box-body -->
          </div>
          
              
        </form>
        <table width="100%" border="0"></table>
      <?php }
 

        require_once("opendb.php"); 
        $filter = $_GET['filter'];

        if(isset($_POST['db'])){
            $id = $_POST['db'];

            if(empty($_POST['todate']) or empty($_POST['fromdate'])){
              $query = "SELECT db_kwh_logs.*, db.name FROM db_kwh_logs ,db WHERE db_kwh_logs.dbid = db.dbid and db_kwh_logs.dbid = '".$id."' and db_kwh_logs.datetime >NOW()-INTERVAL 1 DAY order by db_kwh_logs.datetime desc limit 100";
              ?>

              
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo "Showing Data for Distribution Box <b>'".$id."'</b>"; ?>
              </div>
            
              <?php
            }
            else
            {
              $fromdate = $_POST['fromdate'];
              $todate = $_POST['todate'];

              if(!(empty($_POST['fromtime']) or empty($_POST['totime']))){
                $fromdate = $fromdate ." ". $_POST['fromtime'];
                $todate = $todate ." ". $_POST['totime'];
              }
             $query = "select db_kwh_logs.*,db.name from db_kwh_logs WHERE  dbid = '".$id."' AND db_kwh_logs.dbid = db.dbid, Datetime BETWEEN  '".$fromdate."' AND '".$todate."'";
              ?>

              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo "Showing Data for Distribution Box <b>'".$id."'</b> from date '".$fromdate."' to date '".$todate."'"; ?>
              </div>
            
              <?php
              
            }
          }elseif($filter == '0G0')
          $query= "select db_kwh_logs.*,db.name from db_kwh_logs,db WHERE db_kwh_logs.dbid = db.dbid and db_kwh_logs.datetime >NOW()-INTERVAL 1 DAY order by db_kwh_logs.datetime desc limit 5000";
         else
          $query= "select db_kwh_logs.*,db.name from db_kwh_logs,db WHERE db_kwh_logs.dbid = db.dbid and db_kwh_logs.dbid = '".$filter."' and db_kwh_logs.datetime >NOW()-INTERVAL 1 DAY order by db_kwh_logs.datetime desc limit 5000";

        $result = $conn -> query($query) or die("Query error");
      ?>
      
    <div  id="overflow" style="overflow-x:auto;">
        <table  id="example1" class="table table-responsive table-bordered table-striped" >
        <thead class="bg-blue">
        <tr>
          <th scope="col">Distribution Box ID</th>
          <th scope="col">Name</th>
          <th scope="col">Off Peak</th>
          <th scope="col">Peak</th>
          <th scope="col">Off Peak Units</th>
          <th scope="col">Peak Units</th>
          <th scope="col">Date & Time</th>
          
        </tr>
        </thead>
          
          
        <tbody bgcolor="#FFFFFF">
          
          <?php
          foreach($result as $row){
          ?>
          
          
        <tr>
          <td><?php echo $row ['dbid'];  ?></td>
          <td><?php echo $row ['name'];  ?></td>
          <td><?php echo round($row ['offpeak'],2);  ?></td>
          <td><?php echo round($row ['peak'],2);  ?></td>
          <td><?php echo round($row ['offpkunits'],2);  ?></td>
          <td><?php echo round($row ['pkunits'],2);  ?></td>
          <td><?php echo $row ['Datetime'];  ?></td>
        </tr>
          
          <?php
          }
        ?>
        
          
        </tbody>
        <tfoot class="bg-blue">
        <tr>
          <th scope="col">Distribution Box ID</th>
          <th scope="col">Name</th>
          <th scope="col">Off Peak</th>
          <th scope="col">Peak</th>
          <th scope="col">Off Peak Units</th>
          <th scope="col">Peak Units</th>
          <th scope="col">Date & Time</th>
        </tr>
        </tfoot>

      </table>
      </div>
  <?php $conn= NULL; ?>
    
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

 
   <script>
    $(function () {
    $('#example1').DataTable(
    {"order": [[ 5, "desc" ]]})
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
</html>
