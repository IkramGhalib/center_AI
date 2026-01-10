<?php
//   include_once('check.php');
//   authenticate("edit");
?><!doctype html>
<html><!-- InstanceBegin template="/Templates/Master.dwt" codeOutsideHTMLIsLocked="false" -->

	<head>
		
		<meta charset="utf-8"> 
		<!-- InstanceBeginEditable name="doctitle" -->
			<title>Add New Out Feeder</title>
		<?php $page_type = "Transformer";?>
		<!-- InstanceEndEditable -->
		<!-- InstanceBeginEditable name="head" -->
		<!-- InstanceEndEditable --> 
			<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<style>

	/*Now the CSS*/
	* {margin: 0; padding: 0;}

	#overflow{
	width: 100%;
	height: 400px;
	overflow: scroll;  
	}

	.tree ul {
	padding-top: 20px;
	position: relative;
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
	}

	.tree li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;

	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
	}

	/*We will use ::before and ::after to draw the connectors*/

	.tree li::before, .tree li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid black;
	width: 50%; height: 20px;


	}
	.tree li::after{


	right: auto; left: 50%;
	border-left: 1px solid black;
	}

	/*We need to remove left-right connectors from elements with 
	any siblings*/
	.tree li:only-child::after, .tree li:only-child::before {
	display: none;

	}

	/*Remove space from the top of single children*/
	.tree li:only-child{ padding-top: 0;
	}

	/*Remove left connector from first child and 
	right connector from last child*/
	.tree li:first-child::before, .tree li:last-child::after{
	border: 0 none
	;
	}
	/*Adding back the vertical connector to the last nodes*/
	.tree li:last-child::before{
	border-right: 1px solid black;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;

	}
	.tree li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;

	}

	/*Time to add downward connectors from parents*/
	.tree ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid black;
	width: 0; height: 20px;

	}

	.tree li a{
	border: 1px solid black;
	padding: 5px 10px;
	text-decoration: none;
	color:black;
	font-family: arial, verdana, tahoma;
	font-size: 14px;
	display: inline-block;
	background-color:#FFFFFF;

	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;

	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
	}

	/*Time for some hover effects*/
	/*We will apply the hover effect the the lineage of the element also*/
	.tree li a:hover, .tree li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
	}
	/*Connector styles on hover*/
	.tree li a:hover+ul li::after, 
	.tree li a:hover+ul li::before, 
	.tree li a:hover+ul::before, 
	.tree li a:hover+ul ul::before{
	border-color:#000000;
	}
	.panel-heading{
	font-size:18px;
	font-weight:bold;
	}

	.btn.btn-primary {
	background-color:#cccccc; /* Green */
	color:black;
	border: none;
	padding: 7px 17px 7px 17px;
	text-align: center;
	margin-left: 17px;
	font-size: 16px;
	}
</style>

			 <!-- ALL LINKS--> 
<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	
<body class="skin-blue">

<header class="main-header">

	<!-- Logo -->
	<a href="#" class="logo"> <b>Electrocure </b></a>
	<!-- Header Navbar: style can be found in header.less -->      

	<nav class="navbar navbar-inverse">
	<div class="container-fluid">

	<ul class="nav navbar-nav">
	<li><a href="feeder_dashboard.php">Dashboard</a></li>
				  <li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"> In Feeders
					<span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li><a href="feeder-list.php?filter=0G0">In Feeders List</a></li>
					  <li><a href="feeder-current-logs.php?filter=0G0">In Feeders Current Logs</a></li>
					  <!--li><a href="feeder-kwh-logs.php?filter=0G0">In Feeders KWH Logs</a></li-->
					</ul>
				  </li>
				 <li  class="active" class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Out Feeders  >> Add
					<span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li  class="active"><a href="outfeeder-list.php">Out Feeders List</a></li>
					  <li><a href="outfeeder-current-logs.php?filter=0G0">Out Feeders Current Logs</a></li>
					  <!--li><a href="outfeeder-kwh-logs.php?filter=0G0">Out Feeders KWH Logs</a></li-->
					</ul>
				  </li>  
					<li  class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">Transformers
					<span class="caret"></span></a>
					<ul class="dropdown-menu">
					  <li><a href="transformer-list.php?filter=0G0">Transformers List >> Add</a></li>
					  <li><a href="transformer-current-logs.php?filter=0G0">Transformers Current Logs</a></li>
					  <!--li ><a href="transformer-kwh-logs.php?filter=0G0">Transformers KWH Logs</a></li-->
					</ul>
				  </li>
					
					<li><a href="faults.php">Faults</a></li>
					 <li ><a href="./waterscada/login.php">WaterScada</a></li>
		
	</ul>
	</div>
	</nav>
</header>


      <!--ASIDE  
      <aside class="main-sidebar">
        
        <section class="sidebar">

          
          <ul class="sidebar-menu">
            
			  <li class="header">MAIN NAVIGATION</li>
			  
			  <li class=" treeview">
              	<a href="feeder-dashboard.html">
                	<i class="fa fa-dashboard"></i> <span>Feeders Dashboard</span> 
              	</a>
			  </li>
			  
			  
			  <li class=" treeview">
              	<a href="#">
                	<i class="fa  fa-check-square-o"></i> <span>PAGE 1</span> 
              	</a>
			  </li>
			  
			   <li class=" treeview">
              <a href="#">
                <i class="fa fa-flag"></i>
                <span>PAGE 2</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
				   <ul class="treeview-menu">
                
				<li class="" ><a href=""><i class="fa fa-list-ol"></i>NAV 1</a></li>
				
                <li class="" ><a href=""><i class="fa fa-flag-o"></i> NAV 2</a></li>
              </ul>
            </li>
			</ul>
			 
		  </section>
    
      </aside>

 -->


<div class="content-header">
</section>
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


			<!--        <div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Transformer ID</label>
									
									<div class="col-sm-6">
																															
											<input type="text" class="form-control" name = "fOID" placeholder = "Type Pump ID" required = "required" />
																													
									</div>
							
							</div> -->

							<!--div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Transformer Name</label>
									
									<div class="col-sm-6">
																															
											<input type="text" class="form-control" name = "tname" placeholder = "Transformer Name" required = "required" />
																													
									</div>
							
							</div-->
							
							<!--div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Voltage Multiplying Factor</label>
									
									<div class="col-sm-6">
																															
											<input type="text" class="form-control" name = "vmf" placeholder = "Type Voltage Multiplying Factor" required = "required" />
																													
									</div>
							
							</div-->
																
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
					
							
							
				<!--      <div class = "form-group row">
							
									<label class="col-sm-2 col-form-label">Connection Date</label>
									
									<div class="col-sm-6">
																															
											<input id="today" type="date" class="form-control" name = "fcondate" required = "required"  />
																													
									</div>
							
							</div> -->
							
		

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

   // $subdivid = 'mes30c1';
	//require_once("opendb.php"); 
    
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
                
                $q=	"INSERT INTO `outfeeder`(`fdid`, `name`, `longitude`, `latitude`, `map`, `description`, `group`, `sub-maingroup`, `maingroup`, `kva_capacity`, `connectiondate`, `mfactorvoltage`, `mfactorcurrent`, `c1`, `c2`, `c3`, `v1`, `v2`, `v3`, `pf1`, `pf2`, `pf3`, `datetime`, `offpeak`, `peak`, `simno`) VALUES ('".$feederID."','".$name."','".$longitude."','".$latitude."',0,'".$description."',1,1,1,'".$kva_capacity."','".$c_date."','".$mfactorv."','".$mfactorc."',0,0,0,0,0,0,0,0,0,'".$c_date."',0,0, '".$sim."')";
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