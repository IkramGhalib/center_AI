<?php
//   include_once('check.php');
//   authenticate("can_edit");
?>
<!DOCTYPE html>
<html>
<head>


  <?php $pageName = "Add New Power Logger"?>



  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $pageName;?></title>

 <?php include_once('head.php') ?>

</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue sidebar-mini"  >
<!-- Site wrapper -->
<div class="wrapper">


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
		<div class="panel-heading"> Add New DB </div>
		<div class="panel-body">



	<form method = "POST">

<form method = "POST">

							
								<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Power Logger ID</label>
									<div class="col-sm-6">                                        
											<input type="text" class="form-control" name = "plid" placeholder = "Power Logger ID" required = "required" />                                  
									</div>
							</div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Power Logger Name</label>
									<div class="col-sm-6">                                        
											<input type="text" class="form-control" name = "plname" placeholder = "Power Logger Name" required = "required" />                                  
									</div>
							</div>

								<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Capacity (KVA)</label>
									<div class="col-sm-6">                                        
											<input type="text" class="form-control" name = "tcapacity" placeholder = "Power Logger Capacity" required = "required" />                                  
									</div>
							</div>
							
						
							
							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Power Logger Type</label>
									<div class="col-sm-6">                                        
											<select name="type" class="form-control">
											<option value="---">Select Power Logger Type</option>
											<option value="0">Single Phase with CT</option>
											<option value="1">Three Phase with CT</option>
											<option value="2">Single Phase without line CT</option>
											<option value="3">Three Phase without line CT</option>
											</select>                                  
									</div>
							</div>
                            <div class = "form-group row">
									<label class="col-sm-2 col-form-label">No of CTs</label>
									<div class="col-sm-6">                                        
											<input type="text" class="form-control" name = "noCT" placeholder = "No of CTs" required = "required" />                                  
									</div>
							</div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Location</label>
									<div class="col-sm-6">                                        
											<input type="text" class="form-control" name = "tlocation" placeholder = "Power Logger Location" required = "required" />                                  
									</div>
							</div>

							
							<div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Longitude</label>
									
									<div class="col-sm-6">
																															
											<input type="text" class="form-control" name = "long" placeholder = "Type Longitude" />
																													
									</div>
							
							</div>
							
							<div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Latitude</label>
									
									<div class="col-sm-6">
																															
											<input type="text" class="form-control" name = "lat" placeholder = "Type Latitude" />
																													
									</div>
							
							</div>
							
							<div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Map</label>
									
									<div class="col-sm-6">
																															
											<input type="text" class="form-control" name = "tmap" placeholder = "Type Map" />
																													
									</div>
							
							</div>
							
								
							<div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Description</label>
									
									<div class="col-sm-6">
																															
											<input type="textarea" class="form-control" name = "description" placeholder = "Type Description" required = "required" />
																													
									</div>
							
							</div>

							<div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Single Phase Users</label>
									
									<div class="col-sm-6">
																															
											<input type="text" class="form-control" name = "singlephase" placeholder = "No Of Single Phase Users on DB" required = "required" />
																													
									</div>
							
							</div>

							<div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Three Phase Users</label>
									
									<div class="col-sm-6">
																															
											<input type="text" class="form-control" name = "threephase" placeholder = "No Of Three Phase Users on DB" required = "required" />
																													
									</div>
							
							</div>
							
							<div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Initial Offpeak Units</label>
									
									<div class="col-sm-6">
																															
											<input type="textarea" class="form-control" name = "offpk" placeholder = "Type Off Peak" required = "required" />
																													
									</div>
							
							</div>
                            <div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Initial Peak Units</label>
									
									<div class="col-sm-6">
																															
											<input type="textarea" class="form-control" name = "pk" placeholder = "Type Peak" required = "required" />
																													
									</div>
							
							</div>
				
								<span style="display: inline;"  >                                      
											<input type="submit" class="btn btn-primary" name = "add" value = "Add" />
												<button class="btn btn-primary" onclick="window.location.href = 'distribution-box-list.php';">Back to List</button>
											</span>								
									
								
										
									</div>                                   
							</div>
							
					</form>
	
	</div>
</div>
</div>
</div>


<script src="bower_components/jquery/dist/jquery.min.js"></script>

	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

	<script>
	$.widget.bridge('uibutton', $.ui.button);
	</script>

	<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

	<script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>


	<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

	<script src="bower_components/fastclick/lib/fastclick.js"></script>

	<script src="dist/js/app.min.js" type="text/javascript"></script>

	<script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
	<script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>


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
					
	<script>
	document.querySelector("#today").valueAsDate = new Date();

	</script> 
	<script>
	$('#timeformat').timepicker({ 'timeFormat': 'H:i:s' });

</script> 

</body>
</html>

<?php

   				require_once("opendb.php");
            if(isset($_POST['add']))                
            {
						// 	var_dump($_POST);

						
						
							$dbid = $_POST['plid'];
							$plname = $_POST['plname'];

							
								

				$description			= $_POST['description'];
                $location               = $_POST['tlocation'];
                $longitude              = $_POST['long'];
                $latitude               = $_POST['lat'];
				$map					= $_POST['tmap'];
                $capacity               = $_POST['tcapacity'];
                $offpeak                = $_POST['offpk'];
                $pk                     = $_POST['pk'];
                $type                   = $_POST['type'];
                $noCT                   = $_POST['noCT'];
                $threephase				= $_POST['threephase'];
                $singlephase			=$_POST['singlephase'];
                $connectiondate         = date('Y/m/d H:i:s');
                //$connectiondate         = date('Y/m/d H:i:s');;//$_POST['tcondate'];
               
                
              //  $result->close();
                
				$q = "insert into db (dbid,name,dbtype,noOfCT, description, longitude, latitude, map,connectiondate) values('$dbid','$plname','$type','$noCT','$description','$longitude', '$latitude','$map','$connectiondate')";


				
               echo $q;
                $stmt = $conn->prepare($q);
               
      try
      {
           $result = $stmt->execute();
          
         $count = $stmt->rowCount();
     
                  

         if($count > 0){

            $q_db = "INSERT INTO `db_status`(`dbid`) values('$dbid')";
			echo $q_db;
             $result = $conn->query($q_db) or die(error);


            if ($threephase != 0 or $singlephase != 0) {

            	$q1 = "INSERT INTO .`connections` (`cid`, `name`, `longitude`, `latitude`, `slot1`, `slot2`, `slot3`, `tariff`, `totalmeters`, `mfactor`, `description`, `connectiondate`, `c1`, `c2`, `c3`, `pf1`, `pf2`, `pf3`, `v1`, `v2`, `v3`, `kwhoffpeak1`, `kwhoffpeak2`, `kwhoffpeak3`, `kwhpeak1`, `kwhpeak2`, `kwhpeak3`, `offpeak`, `peak`, `datetime`, `serialNo`, `assignee_name`, `cnic`, `address`, `mobile`, `email`, `billing_method`, `username`, `password`, `unit_limit`, `status`) VALUES";

	            $i = 1;
	            $j=1;
	            //three phase connections
	            if ($threephase !=0) {
	            	for(; $j<$threephase; $j++){
	            		$cid = $dbid."CN".$j;
	            		$cname = "Connection ".$j; 
	            		$slot1 = $i;
	            		$slot2 = $i+1;
	            		$slot3 = $i+2;
	            		$q1 .= "('$cid', '$cname', '0', '0', $slot1, $slot2, $slot3, '0', '1', '0', 'Three Phase', CURRENT_TIMESTAMP, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', CURRENT_TIMESTAMP, NULL, '', '', '', '', '', 'postpaid', '$cid', '123', '0', 'off'),";
	            	$i = $i+3;
	            	}
	            	
	            	$cid = $dbid."CN".$j;
	            	$cname = "Connection ".$j; 
	            	$slot1 = $i;
            		$slot2 = $i+1;
            		$slot3 = $i+2;
	            	$q1 .= "('$cid', '$cname', '0', '0',  $slot1, $slot2, $slot3, '0', '1', '0', 'Three Phase', CURRENT_TIMESTAMP, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', CURRENT_TIMESTAMP, NULL, '', '', '', '', '', 'postpaid', '$cid', '123', '0', 'off')";

	            	if ($singlephase != 0) {
	            		$q1 .= ","; 	            		
	            		$j++;
	            	}
	            	$i = $i+3;
	            }
	            

	            //single phase connection
	            if ($singlephase !=0) {
	            for(; $j<$singlephase+$threephase; $j++){
	            	
	            	$cid = $dbid."CN".$j;
	            	$cname = "Connection ".$j; 
		            $q1 .= "('$cid', '$cname', '0', '0', '$i', '-1', '-1', '0', '1', '0', 'Single Phase', CURRENT_TIMESTAMP, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', CURRENT_TIMESTAMP, NULL, '', '', '', '', '', 'postpaid', '$cid', '123', '0', 'off'),";
		            $i++;
	            }
	            	$cid = $dbid."CN".$j;
	            	$cname = "Connection ".$j; 
	            $q1 .= "('$cid', '$cname', '0', '0', '$i', '-1', '-1', '0', '1', '0', 'Single Phase', CURRENT_TIMESTAMP, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', CURRENT_TIMESTAMP, NULL, '', '', '', '', '', 'postpaid', '$cid', '123', '0', 'off')";
	        	}

	            echo $q1;
	            $result = $conn->query($q1) or die(error);
	            
            }

            

            
             
        echo "<script > window.open('db-list.php?filter=0G0','_self'); </script>";
          
         }
         else{
           echo "<script> alert('There was an error adding Power Logger:".str_replace("'", "\'", $q)."'); </script>";
         }

      }
      catch(PDOException $e)
      {
        echo "<script> alert('There was an error adding Power Logger :".str_replace("'", "\'", $q1)."'); </script>";
      }
                
            }
       $conn= NULL;
?>