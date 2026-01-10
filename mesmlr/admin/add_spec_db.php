<?php
  include_once('check.php');
  authenticate("edit");
?>
<!DOCTYPE html>
<html>
<head>

	


  <?php $pageName = "Add New DB"?>



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
		<div class="panel-heading"> Add New DB </div>
		<div class="panel-body">



	<form method = "POST">

<form method = "POST">

<div class = "form-group row">
<label class="col-sm-2 col-form-label">Transformer ID</label>
<div class="col-sm-6">
	<?php 
			  require("opendb.php");
			date_default_timezone_set("Asia/Karachi");
			$q = "select * from transformer";
			$result = $conn -> query($q) or die("Query error");
			echo"<select name = 'outfeeder' class='form-control'>";
			echo "<option value = '--'>---Select Transformer---</option>";
			foreach($result as $row)
			{
			echo "<option value = '".$row['trid']."'>".$row['trid']."-----".$row['name']."-".$row['description']."</option selected>";
			}
			echo "</select>"; 
			
	?>										
</div>
</div> 
							
												
								<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Capacity (KVA)</label>
									<div class="col-sm-6">                                        
											<input type="text" class="form-control" name = "tcapacity" placeholder = "Distribution Box Capacity" required = "required" />                                  
									</div>
							</div>
							
						
							
							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Distribution Box Type</label>
									<div class="col-sm-6">                                        
											<select name="type" class="form-control">
											<option value="---">Select Distribution Box Type</option>
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
											<input type="text" class="form-control" name = "tlocation" placeholder = "Distribution Box Location" required = "required" />                                  
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

   
            if(isset($_POST['add']))                
            {
						// 	var_dump($_POST);

						$outfeeder = $_POST['outfeeder'];
                echo $outfeeder;
						$q = "select  dbid from db where substring(dbid,1,".strlen($outfeeder).")='".$outfeeder."'";
					$result = $conn->query($q); 
						
						$max=0;
						foreach($result as $row){
                            $id = explode('DB',$row['dbid']);
                            if($max < intval($id[1]))
                                $max = intval($id[1]);
                            
                        }
						// code for incrementing Tr_id 
					
							if($max!=0)
							{
						
							$a =  intval($max)+1;
						
                            if($a < 10)
                            {
                                $db2 ='DB0'.strval($a);
                                $name = 'Distribution Box 0'.strval($a);
                            }
                            else
                            {
                            $db2 ='DB'.strval($a);
                            $name = 'Distribution Box '.strval($a);
                            }
							
							
							var_dump($db2);
							}
						
						else{
							$db2='DB01';
							$name = 'Distribution Box 01';
						}
						
							$outfeeder = $_POST['outfeeder'];

							
								
						 

                $dbid                   = $outfeeder.$db2;//$_POST['tID'];
				//$trid					= $_POST['outfeeder'];
			//	$name					= $POST['tname'];
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
                $connectiondate         = date('Y/m/d H:i:s');
                //$connectiondate         = date('Y/m/d H:i:s');;//$_POST['tcondate'];
               
                
              //  $result->close();
                
				$q = "insert into db (dbid,dbtype,noOfCT, name, description, longitude, latitude, map,connectiondate) values('$dbid','$type','$noCT','$name','$description','$longitude', '$latitude','$map','$connectiondate')";
				
               echo $q;
                $stmt = $conn->prepare($q);
               
      try
      {
           $result = $stmt->execute();
          
         $count = $stmt->rowCount();
     
                  

         if($count > 0){
            $q = "INSERT INTO `connections_db`(`dbid`) values('$dbid')";
             $result = $conn->query($q);

        echo "<script > window.open('add32connections.php?dbid=$dbid','_self'); </script>";
          
         }
         else{
           echo "<script> alert('There was an error adding transformer :".str_replace("'", "\'", $q)."'); </script>";
         }

      }
      catch(PDOException $e)
      {
        echo "<script> alert('There was an error adding transformer :".str_replace("'", "\'", $q)."'); </script>";
      }
                
            }
       $conn= NULL;
?>