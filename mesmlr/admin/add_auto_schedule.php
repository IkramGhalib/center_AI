
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Add Auto Switching Job"?>



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
	<?php include_once('navbar.php') ?>
	<!-- Sidebar -->
	<?php include_once('sidebar.php') ?>

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
      
    <div class="box box-primary">
      <div class="container">
            <div class="box-header with-border">
              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Device ID</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" list="pumps" name="pumpid" placeholder="Enter Device ID" >
                    <datalist id="pumps">
                      <?php
                        require_once("opendb.php");
                        $query = "select trid, name from transformer order by trid";
                        $result = $conn -> query($query) or die(error);
                        foreach ($result as $row) {
                        ?>
                          <option value="<?php echo $row['trid']; ?>"><?php echo $row['name']; ?></option>
                        <?php    
                        }
                      ?>
                      
                    </datalist>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Daily <input type="checkbox" name="cdaily" value="0"></label>
                  <label class="col-sm-1  control-label">Start Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="daily_start" placeholder="Enter Pump ID" >
                  </div>
                  <label class="col-sm-1  control-label">End Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="daily_end" placeholder="Enter Pump ID" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Monday <input type="checkbox" name="cmon" value="1"></label>
                  <label class="col-sm-1  control-label">Start Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="mon_start" placeholder="Enter Pump ID" >
                  </div>
                  <label class="col-sm-1  control-label">End Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="mon_end" placeholder="Enter Pump ID" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Tuesday <input type="checkbox" name="ctue" value="2"></label>
                  <label class="col-sm-1  control-label">Start Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="tue_start" placeholder="Enter Pump ID" >
                  </div>
                  <label class="col-sm-1  control-label">End Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="tue_end" placeholder="Enter Pump ID" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Wednesday <input type="checkbox" name="cwed" value="3"></label>
                  <label class="col-sm-1  control-label">Start Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="wed_start" placeholder="Enter Pump ID" >
                  </div>
                  <label class="col-sm-1  control-label">End Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="wed_end" placeholder="Enter Pump ID" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Thursday <input type="checkbox" name="cthu" value="4"></label>
                  <label class="col-sm-1  control-label">Start Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="thu_start" placeholder="Enter Pump ID" >
                  </div>
                  <label class="col-sm-1  control-label">End Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="thu_end" placeholder="Enter Pump ID" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Friday <input type="checkbox" name="cfri" value="5"></label>
                  <label class="col-sm-1  control-label">Start Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="fri_start" placeholder="Enter Pump ID" >
                  </div>
                  <label class="col-sm-1  control-label">End Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="fri_end" placeholder="Enter Pump ID" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Saturday <input type="checkbox" name="csat" value="6"></label>
                  <label class="col-sm-1  control-label">Start Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="sat_start" placeholder="Enter Pump ID" >
                  </div>
                  <label class="col-sm-1  control-label">End Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="sat_end" placeholder="Enter Pump ID" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Sunday <input type="checkbox" name="csun" value="7"></label>
                  <label class="col-sm-1  control-label">Start Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="sun_start" placeholder="Enter Pump ID" >
                  </div>
                  <label class="col-sm-1  control-label">End Time</label>
                  <div class="col-sm-4">
                    <input type="time" class="form-control" name="sun_end" placeholder="Enter Pump ID" >
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="reset" class="btn btn-danger">Reset</button>
                <button type="submit" name="submit" class="btn btn-primary pull-right">Add Pump</button>
              </div>
              <!-- /.box-footer -->
            </form>
            </div>
          </div>

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



<?php
  date_default_timezone_set("Asia/Karachi");
  //require_once("opendb");
  $dt = date("Y-m-d");

  if(isset($_POST['submit'])){
    $pumpname   = $_POST['pumpid'];
    $datetime = date('d-m-y H:i:s');

  if(isset($_POST['cdaily'])){
    $start_time=$_POST['daily_start'];
    $off_time=$_POST['daily_end'];
    $repeat = $_POST['cdaily'];
    $q = "INSERT INTO auto_switching (trid, starttime, offtime,actual_ontime,actual_offtime, `repeat`,`Datetime`) VALUES('$pumpname' , '$start_time' , '$off_time','$start_time' , '$off_time', '$repeat',CURTIME())";
    $stmt = $conn->prepare($q);
    $result = $stmt->execute();
    $rcount = $stmt->rowCount();
  }

  if(isset($_POST['cmon']))
  {
    $start_time=$_POST['mon_start'];
    $off_time=$_POST['mon_end'];
    $repeat = $_POST['cmon'];
    $q = "INSERT INTO auto_switching (trid, starttime, offtime,actual_ontime,actual_offtime, `repeat`,`Datetime`) VALUES('$pumpname' , '$start_time' , '$off_time','$start_time' , '$off_time', '$repeat',CURTIME())";
    $stmt = $conn->prepare($q);
    $result = $stmt->execute();
    $rcount = $stmt->rowCount();

  }

  if(isset($_POST['ctue']))
    {
      $start_time=$_POST['tue_start'];
      $off_time=$_POST['tue_end'];
      $repeat = $_POST['ctue'];
      $q = "INSERT INTO auto_switching (trid, starttime, offtime,actual_ontime,actual_offtime, `repeat`,`Datetime`) VALUES('$pumpname' , '$start_time' , '$off_time','$start_time' , '$off_time', '$repeat',CURTIME())";
      $stmt = $conn->prepare($q);
    $result = $stmt->execute();
    $rcount = $stmt->rowCount();

    }


 if(isset($_POST['cwed']))
      {
        $start_time=$_POST['wed_start'];
        $off_time=$_POST['wed_end'];
        $repeat = $_POST['cwed'];
        $q = "INSERT INTO auto_switching (trid, starttime, offtime,actual_ontime,actual_offtime, `repeat`,`Datetime`) VALUES('$pumpname' , '$start_time' , '$off_time','$start_time' , '$off_time', '$repeat',CURTIME())";
        $stmt = $conn->prepare($q);
    $result = $stmt->execute();
    $rcount = $stmt->rowCount();

      }

      
  if(isset($_POST['cthu']))
    {
      $start_time=$_POST['thu_start'];
      $off_time=$_POST['thu_end'];
      $repeat = $_POST['cthu'];
      $q = "INSERT INTO auto_switching (trid, starttime, offtime,actual_ontime,actual_offtime, `repeat`,`Datetime`) VALUES('$pumpname' , '$start_time' , '$off_time','$start_time' , '$off_time', '$repeat',CURTIME())";

      $stmt = $conn->prepare($q);
    $result = $stmt->execute();
    $rcount = $stmt->rowCount();

    }

  if(isset($_POST['cfri']))
    {
      $start_time=$_POST['fri_start'];
      $off_time=$_POST['fri_end'];
      $repeat = $_POST['cfri'];
      $q = "INSERT INTO auto_switching (trid, starttime, offtime,actual_ontime,actual_offtime, `repeat`,`Datetime`) VALUES('$pumpname' , '$start_time' , '$off_time','$start_time' , '$off_time', '$repeat',CURTIME())";

      $stmt = $conn->prepare($q);
    $result = $stmt->execute();
    $rcount = $stmt->rowCount();

    }

  if(isset($_POST['csat']))
    {
      $start_time=$_POST['sat_start'];
      $off_time=$_POST['sat_end'];
      $repeat = $_POST['csat'];
      $q = "INSERT INTO auto_switching (trid, starttime, offtime,actual_ontime,actual_offtime, `repeat`,`Datetime`) VALUES('$pumpname' , '$start_time' , '$off_time','$start_time' , '$off_time', '$repeat',CURTIME())";

      $stmt = $conn->prepare($q);
    $result = $stmt->execute();
    $rcount = $stmt->rowCount();

    }


  if(isset($_POST['csun']))
    {
      $start_time=$_POST['sun_start'];
      $off_time=$_POST['sun_end'];
      $repeat = $_POST['csun'];
      $q = "INSERT INTO auto_switching (trid, starttime, offtime,actual_ontime,actual_offtime, `repeat`,`Datetime`) VALUES('$pumpname' , '$start_time' , '$off_time','$start_time' , '$off_time', '$repeat',CURTIME())";

      $stmt = $conn->prepare($q);
    $result = $stmt->execute();
    $rcount = $stmt->rowCount();

    }
                        echo "<script>window.open('auto_scheduling.php?filter=0G0' , '_self');</script>";

          }

      $conn = NULL;
?>