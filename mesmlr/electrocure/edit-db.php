<?php
  include_once('check.php');
  authenticate("edit");
?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Edit DB"?>



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
    <div class="panel-heading"> Edit Transformer </div>
    <div class="panel-body">


              <!-- ALL PHP CODE -->

<?php

    require("opendb.php"); 
    date_default_timezone_set("Asia/Karachi");

    
    if(isset($_GET['id']))                
    {
//        $id= $_GET['id'];
        $id= $_GET['id'];
   
    $q = "select * from db where dbid ='$id'";
   //echo $q;
    $result = $conn -> query($q) or die("Query error"); 

//echo $q;
    foreach($result as $row)
      {

    $get_name             = $row['name'];
    $get_longitude        = $row['longitude'];
    $get_latitude         = $row['latitude'];
    $get_description      = $row['description'];
    $get_ct               = $row['noOFCT'];
    $get_sn               = $row['serialNo'];
    $get_sim              = $row['sim_no'];
    //$get_kva_capacity     = $row['kva_capacity'];
   

    }
        
    }
?>

  <form method = "POST">

          <div class = "form-group row">
              
              <label class="col-sm-2 col-form-label">Name</label>
              
              <div class="col-sm-6">
                                                          
                  <input type="textarea" value="<?php echo $get_name; ?>" class="form-control" name = "name" placeholder = "Type Description" required = "required" />
                                                      
              </div>
          
          </div>  
           <div class = "form-group row">
              
              <label class="col-sm-2 col-form-label">Serail Number</label>
              
              <div class="col-sm-6">
                                                          
                  <input type="textarea" value="<?php echo $get_sn; ?>" class="form-control" name = "sn" placeholder = "Type Serial Number" required = "required" />
                                                      
              </div>
          
          </div>  

            <div class = "form-group row">
              
              <label class="col-sm-2 col-form-label">Description</label>
              
              <div class="col-sm-6">
                                                          
                  <input type="textarea" value="<?php echo $get_description; ?>" class="form-control" name = "description" placeholder = "Type Description" required = "required" />
                                                      
              </div>
          
          </div>
          
      
          <div class = "form-group row">
              
              <label class="col-sm-2 col-form-label">Longitude</label>
              
              <div class="col-sm-6">
                                                          
                  <input type="text" value="<?php echo $get_longitude; ?>" class="form-control" name = "long" placeholder = "Type Longitude" />
                                                      
              </div>
          
          </div>
          
          <div class = "form-group row">
              <label class="col-sm-2 col-form-label">Latitude</label>
              <div class="col-sm-6">
                  <input type="text" value="<?php echo $get_latitude; ?>" class="form-control" name = "lat" placeholder = "Type Latitude" />
              </div>
          </div>
          
         <div class = "form-group row">
              <label class="col-sm-2 col-form-label">No of CTs</label>
              <div class="col-sm-6">
                  <input type="text" value="<?php echo $get_ct; ?>" class="form-control" name = "ct" placeholder = "Type Latitude" />
              </div>

                  </div>

                  <div class = "form-group row">
                  <label class="col-sm-2 col-form-label">SIM No.</label>
                  <div class="col-sm-6">
                      <input type="textarea" class="form-control" name = "simno" value="<?php echo $get_sim; ?>" placeholder = "Type Sim Number" required = "required" />
                  </div>
              </div>  

                  <span style="display: inline;"  >                                      
                      <input type="submit" class="btn btn-primary" name = "add" value = "Update" />
                        <button class="btn btn-primary" onclick="window.location.href = 'transformer-list.php';">Back to List</button>
                      </span>                                    
 
              
          </form>
  
  </div>
</div>
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

    
            if(isset($_POST['add']))                
            {
            //  var_dump($_POST);

            

        
                $tname                  = $_POST['name'];
                $description            = $_POST['description'];
                $longitude              = $_POST['long'];
                $latitude               = $_POST['lat'];
                $cts                    = $_POST['ct'];
                $sn                     = $_POST['sn'];
                $sim                    = $_POST['simno'];
                
                
         $q=  "UPDATE db SET `name`='$tname', `description`='$description', `longitude`='$longitude', `latitude`='$latitude', `noOFCT` = '$cts', serialNo='$sn', sim_no='$sim' where dbid='$id'";
   
       
      //  echo $q;
               
                    $result = $conn -> query($q) or die("Query error"); 

    
                    if($result)
                    {
                        
                        echo "<script> window.open('db-list.php?filter=0G0' , '_self'); </script>";
                            
                    }
                    else
                    {
                        echo "<script> alert('There was an error adding Transformer :".str_replace("'", "\'", $q)."'); </script>";
                    }
                
            }
       $conn = null;
?>