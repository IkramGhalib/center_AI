<?php
  include_once('check.php');
  authenticate("edit");
?>
<!DOCTYPE html>
<html>
<head>

  <?php $pageName = "Add New Out Feeder"?>

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

      <div class="panel panel-primary" align="center" style="max-width: 700px">
          <div class="panel-heading"> Add New Out Feeder </div>
          <div class="panel-body">

        <form method = "POST">

            <div class = "form-group row">
            
                <label class="col-sm-2 col-form-label">Out Feeder ID</label>
                
                <div class="col-sm-6">
                                                            
                    <input type="text" class="form-control" name = "fID" placeholder = "Type Feeder ID" required = "required" />
                                                        
                </div>
            
            </div> 

            <div class = "form-group row">
            
                <label class="col-sm-2 col-form-label">Feeder Out Name</label>
                
                <div class="col-sm-6">
                                                            
                    <input type="text" class="form-control" name = "name" placeholder = "Type Name" required = "required" />
                                                        
                </div>
            
            </div> 


                              
          <div class = "form-group row">
            <label class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-6">  <input type="text" name = "description" class="form-control input-sm"> </div>
      </div>

      <div class = "form-group row">
            <label class="col-sm-2 col-form-label">Longitude</label>
            <div class="col-sm-6">  <input type="text" name = "longitude" class="form-control input-sm"> </div>
      </div>

      <div class = "form-group row">
            <label class="col-sm-2 col-form-label">Latitude</label>
            <div class="col-sm-6">  <input type="text" name = "latitude" class="form-control input-sm"> </div>
      </div>

          <div class = "form-group row">
            <label class="col-sm-2 col-form-label">Multiplication Factor Voltage</label>
            <div class="col-sm-6">  <input type="text" name = "mfactorvoltage" class="form-control input-sm"> </div>
          </div>
                      <div class = "form-group row">
            <label class="col-sm-2 col-form-label">Multiplication Factor Current</label>
            <div class="col-sm-6">  <input type="text" name = "mfactorcurrent" class="form-control input-sm"> </div>
          </div>
          <div class = "form-group row">
            <label class="col-sm-2 col-form-label">KVA Capacity</label>
            <div class="col-sm-6">  <input type="text"  name = "kva_capacity" class="form-control input-sm"> </div>
          </div>

          <div class = "form-group row">
            <label class="col-sm-2 col-form-label">SIM No.</label>
            <div class="col-sm-6">  <input type="text"  name = "simno" class="form-control input-sm"> </div>
          </div>
        
            
            
  
            


              <span style="display: inline;"  >                                      
                    <input type="submit" class="btn btn-primary" name = "add" value = "Add" />
               <button class="btn btn-primary" onclick="window.location.href='outfeeder_list.php?filter=0G0'">Back to List</button>
                    </span>               
                
              
                  
                </div>                                   
            </div>
            
                </form>
        
        </div>
      </div>
      </div>
      </div>


    </section>

    <!-- /.content -->
              <!-- ALL PHP CODE -->


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

  require_once("opendb.php"); 
    
    date_default_timezone_set("Asia/Karachi");
    
    
            if(isset($_POST['add']))                
            {
        
                $feederID = $_POST['fID'];
            $name = $_POST['name'];
                $description = $_POST['description'];
        $longitude = $_POST['longitude'];
        $latitude = $_POST['latitude'];
        $mfactorv = $_POST['mfactorvoltage'];
          $mfactorc = $_POST['mfactorcurrent'];
        $kva_capacity = $_POST['kva_capacity'];
        $sim = $_POST['simno'];
        $c_date = date('Y/m/d H:i:s');
                
                $q= "INSERT INTO `outfeeder`(`fdid`, `name`, `longitude`, `latitude`, `map`, `description`, `group`, `sub-maingroup`, `maingroup`, `kva_capacity`, `connectiondate`, `mfactorvoltage`, `mfactorcurrent`, `c1`, `c2`, `c3`, `v1`, `v2`, `v3`, `pf1`, `pf2`, `pf3`, `datetime`, `offpeak`, `peak`, `simno`) VALUES ('".$feederID."','".$name."','".$longitude."','".$latitude."',0,'".$description."',1,1,1,'".$kva_capacity."','".$c_date."','".$mfactorv."','".$mfactorc."',0,0,0,0,0,0,0,0,0,'".$c_date."',0,0, '".$sim."')";
                  echo $q;
                  $result = $conn -> query($q) or die("Query error");

  
                  if($result->rowCount() >0){
                      echo "<script> window.open('outfeeder_list.php?filter=0G0' , '_self'); </script>";
                    }
                    else{
                        echo "<script> alert('There was an error adding out feeder :".str_replace("'", "\'", $q)."'); </script>";
                    }
                
            }
        $conn= NULL;
?>