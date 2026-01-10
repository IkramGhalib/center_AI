<?php
  include_once('check.php');
  authenticate("view");
?>

<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "PESCO Data Entry"?>



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
	<?php // include_once('sidebar.php') ?>

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
            <div class="box-header with-border">
              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post">
              <div class="box-body">
                <div class="form-group">
                  <?php
                    require_once("opendb.php");
                    $query = "select transformer.trid, transformer.name from transformer";
                    $result = $conn -> query($query) or die(error);
                  ?>
                  <div class="form-group">
                  <label for="exampleInputPassword1">Transformer ID</label>
                    <input type="text" list="trans" id= "transformer" name="transformer" class="form-control" placeholder="Select Transformer" required="">
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
                  <label >PESCO Peak</label>
                  <input type="text" class="form-control" name="peak" id="peak" placeholder="PESCO Peak Units">
                </div>

                <div class="form-group">
                  <label >PESCO Off Peak</label>
                  <input type="text" class="form-control" name="offpeak" id="offpeak" placeholder="PESCO Off Peak Units">
                </div>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
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
  if(isset($_POST['submit']))
  {

    $trid = $_POST['transformer'];
    $pesco_peak = $_POST['peak'];
    $pesco_offpeak = $_POST['offpeak'];
    $connectiondate = date('Y/m/d H:i:s');
    
    $q = "select peak, offpeak from transformer where trid = '".$trid."'";
    $r = $conn -> query($q) or die(error);
    echo $q;
    $peak = 0;
    $offpeak = 0;
    foreach ($r as $row) {
      $peak = $row['peak'];
      $offpeak = $row['offpeak'];
    }

    $query2 = "insert into pesco_unit_comparison (trid, our_peak_unit, our_offpeak_unit, pesco_peak_unit, pesco_offpeak_unit) values('$trid','$peak','$offpeak','$pesco_peak','$pesco_offpeak')";

    try{
  

    $stmt = $conn->prepare($query2);
    $result2 = $stmt->execute();
    $count = $stmt->rowCount();

    if($count > 0){

    echo "<script > window.open('pesco_data_entry.php','_self'); </script>";

    }
    else{
    echo "<script> alert('There was an error adding transformer :".str_replace("'", "\'", $q1.$q2)."'); </script>";

    }

    }
    catch(PDOException $e)
    {
    echo "<script> alert('There was an error in submitting :".str_replace("'", "\'", $query2)."'); </script>";
    }


    }
  $conn= NULL;

?>