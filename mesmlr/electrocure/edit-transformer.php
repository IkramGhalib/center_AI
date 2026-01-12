<?php
  include_once('check.php');
  authenticate("can_view");
  // echo '<pre>';
  // print_r($_SESSION['employee']);
  // exit;
  ?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Edit Transformer"?>



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
	<?php //include_once('sidebar.php') ?>

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

    require_once("opendb.php"); 
    date_default_timezone_set("Asia/Karachi");

    
    if(isset($_GET['id']))                
    {
      //  $id= $_GET['id'];
        $id= $_GET['id'];
   $trid = $id;
    $q = "select * from transformer where trid ='$id'";
   //echo $q;
    $result = $conn -> query($q) or die("Query error"); 

//echo $q;
    foreach($result as $row)
      {

    $get_name           = $row['name'];
    $get_longitude      = $row['longitude'];
    $get_latitude         = $row['latitude'];
    $get_description      = $row['description'];
    $get_kva_capacity     = $row['kva_capacity'];
    $get_ltlength         = $row['ltlength'];
    $get_cresistance      = $row['cresistance'];
    $get_kwhpeak          = $row['peak'];
    $get_kwhoffpeak       = $row['offpeak'];
    $get_LTC              = $row['LT_flag'];
    $get_sim              = $row['sim_no'];

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
                  <label class="col-sm-2 col-form-label">Capacity (KVA)</label>
                  <div class="col-sm-6">                                        
                      <input type="text" value="<?php echo $get_kva_capacity; ?>" class="form-control" name = "tcapacity" placeholder = "Transformer Capacity" required = "required" />                                  
                  </div>
            </div>
            <div class = "form-group row">
                 <label class="col-sm-2 col-form-label">LT Line Connected</label>
                <div class="col-sm-6">       
                    <?php
        
                        if($get_LTC == 1)
                        {
                            echo "<input type='checkbox' name='LTC' value='yes' checked> LT Line Connected";  
                        }
                        else
                        {
                            echo "<input type='checkbox' name='LTC' value='yes' > LT Line Connected"; 
                        }
                    ?>
                    
                </div>
           </div>
           <div class = "form-group row">
                  <label class="col-sm-2 col-form-label">LT Length</label>
                  <div class="col-sm-6">                                        
                      <input type="text" value="<?php echo $get_ltlength; ?>" class="form-control" name = "LTlength" placeholder = "LT Length" required = "required" />                                  
                  </div>
              </div>

              <div class = "form-group row">
                  <label class="col-sm-2 col-form-label">C Resistance</label>
                  <div class="col-sm-6">                                        
                      <input type="text" value="<?php echo $get_cresistance; ?>" class="form-control" name = "CResistance" placeholder = "C Resistance" required = "required" />                                  
                  </div>
              </div>
             
      
                <div class = "form-group row">
                  <label class="col-sm-2 col-form-label">Total Peak Units</label>
                  <div class="col-sm-6">                                        
                      <input type="text" value="<?php echo $get_kwhpeak; ?>" class="form-control" name = "peak" placeholder = "peak" required = "required" />                                  
                  </div>
              </div>

              <div class = "form-group row">
                  <label class="col-sm-2 col-form-label">Total Offpeak Units</label>
                  <div class="col-sm-6">                                        
                      <input type="text" value="<?php echo $get_kwhoffpeak; ?>" class="form-control" name = "offpeak" placeholder = "off peak" required = "required" />                                  
                  </div>
              </div>
              
              <div class = "form-group row">

                  <label class="col-sm-2 col-form-label">SIM No.</label>

                  <div class="col-sm-6">

                      <input type="textarea" class="form-control" name = "simno" placeholder = "Type Sim Number" value="<?php echo $get_sim; ?>" required = "required" />

                  </div>

              </div>
                <span style="display: inline;"  >                                      
                      <input type="submit" class="btn btn-primary" name = "add" value = "Update" />
                        <button class="btn btn-primary" onclick="window.location.href = 'transformer-list.php';">Back to List</button>
                      </span>               
                  
                
        
        </form></div>                                 
              
  



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
                $capacity               = $_POST['tcapacity'];
                $ltlength               = $_POST['LTlength'];
                $CResistance            = $_POST['CResistance'];
                $peak                   = $_POST['peak'];
                $offpeak                = $_POST['offpeak'];
                $sim          = $_POST['simno'];
                
            if(isset($_POST['LTC']))
            {
                $LTC = 1;
             
            }
            else
            {
                $LTC = 0;
                if ($get_LTC == 1)
                {
                   $q = "select  count(dbid) as total from db where substring(dbid,1,".strlen($trid).")='".$trid."'";
                     $result = $conn -> query($q) or die("Query error"); 
                    foreach($result as $row)
                    {
                        $total = $row['total'];
                        if ($total == 0)
                        {
                             $dbid                   = $trid.'DB01';//$_POST['tID'];
				//$trid					= $_POST['outfeeder'];
			                $name					= $POST['name'];
                            $description			= $_POST['description'];
                          //  $location               = $_POST['tlocation'];
                            $longitude              = $_POST['long'];
                            $latitude               = $_POST['lat'];
				                    $map				          	= $_POST['map'];
                            $capacity               = $_POST['capacity'];
                            $offpeak                = $_POST['offpeak'];
                            $peak                     = $_POST['peak'];
                            $branches 				= 3;
                            $threephase				= 1;
                            $singlephase 			= 0;
                            $type                   = 1;
                            $noCT                   = 3;
                            $connectiondate         = date('Y/m/d H:i:s');
                        }
                        
                    }
                }
                
                
            }
                
                $div_offpk = $offpeak/3;
                $div_pk = $peak/3;
                
         $q=  "UPDATE transformer SET `name`='$tname', `description`='$description', `longitude`='$longitude', `latitude`='$latitude', kva_capacity='$capacity', ltlength='$ltlength', cresistance='$CResistance' ,offpeak='$offpeak', peak='$peak',kwh_dev_offpeak1='$div_offpk', kwh_dev_offpeak2='$div_offpk', kwh_dev_offpeak3='$div_offpk', kwh_dev_peak1='$div_pk', kwh_dev_peak2='$div_pk', kwh_dev_peak3='$div_pk',kwh_peak1 = '$div_pk',kwh_peak2 = '$div_pk',kwh_peak3 = '$div_pk' ,kwh_offpeak1 = '$div_offpk',kwh_offpeak2 = '$div_offpk',kwh_offpeak3 = '$div_offpk', LT_flag='$LTC' , sim_no='$sim' where trid='$id'";
   
       
      echo $q;
               
                    $result = $conn -> query($q) or die("Query error"); 
            $connectiondate         = date('Y/m/d H:i:s');
    
                    if($result)
                    {
                         $q2 = "INSERT INTO `tr_kwh_logs`( `trid`, `offpeak`, `peak`, `Datetime`, `offpkunits`, `pkunits`, `val1`, `val2`, `val3`, `cval1`, `cval2`, `cval3`, `pf1`, `pf2`, `pf3`, `kwh1`, `kwh2`, `kwh3`, `pkflg`) VALUES ('$trid','$offpeak','$peak','$connectiondate',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
                          //$result2 = $conn -> query($q2) or die("Query error");
                        
                        echo "<script> window.open('transformer-list.php?filter=0G0' , '_self'); </script>";
                       
                            
                    }
                    else
                    {
                        echo "<script> alert('There was an error adding Transformer :".str_replace("'", "\'", $q)."'); </script>";
                    }
                
            }
       $conn = null;
?>