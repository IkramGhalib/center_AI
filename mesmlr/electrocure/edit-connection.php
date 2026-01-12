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

  <?php $pageName = "Edit Connection"?>

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
		<div class="panel-heading"> Edit Connection </div>
		<div class="panel-body">



	<form method = "POST">
		<?php 
			$id = $_GET['id'];
			include("opendb.php");
			$query = "select * from connections where cid = '".$id."'";
			$result = $conn -> query($query) or die("Query error");

			foreach ($result as $row) {
				
				$dbid = explode("CN", $id);
				
			

		?>


<div class = "form-group row">
<label class="col-sm-2 col-form-label">Distibution Box ID</label>
<div class="col-sm-6">
	

	<input type="text" class="form-control" name = "cname" placeholder = "<?php echo $dbid[0]; ?>" disabled= "disabled" required = "required" />
</div>
</div>
							<div class = "form-group row">

									<label class="col-sm-2 col-form-label">Connection Name</label>

									<div class="col-sm-6">

											<input type="text" class="form-control" name = "cname" value = "<?php echo $row['name']; ?>" required = "required" />

									</div>

							</div>
                            
                            <div class = "form-group row">

									<label class="col-sm-2 col-form-label">Serial Number</label>

									<div class="col-sm-6">

											<input type="text" class="form-control" name = "sn" value = "<?php echo $row['serialNo']; ?>" required = "required" />

									</div>

							</div>

                            <div class = "form-group row">
                            <label class="col-sm-2 col-form-label">Phase</label>
                                <div class="col-sm-6">
                                    
                                    <select id = "phase" name = "phase" class="form-control" onChange="Change();" disabled="disabled">
	                             	<?php 
	                             		if ($row['slot2'] < 0 && $row['slot3'] < 0) {
	                             			?>
	                             			 <option value = '1'> Single </option>
	                             			<?php		
	                             		}
	                             		if ($row['slot2'] > 0 && $row['slot3'] < 0) {
	                             			?>
	                             			<option value = '2'> Two </option>
	                             			<?php 
	                             		}
	                             		if ($row['slot2'] > 0 && $row['slot3'] > 0) {
	                             			?>
	                             			<option value = '3'> Three </option>
	                             			<?php		
	                             		}

	                             	?>

			             </select>
	
                                </div>
                        </div>
			     
							

								<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Tarrif</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "tarrif" placeholder = "Tarrif" required = "required" value="<?php echo $row['tariff']; ?>" />
									</div>
							</div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Description</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "description" placeholder = "Description" required = "required"  value="<?php echo $row['description']; ?>"/>
									</div>
							</div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Multiplication Factor</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "mfactor" placeholder = "Multiplication Factor" required = "required" value="<?php echo $row['mfactor']; ?>"/>
									</div>
							</div>

					

							<div class = "form-group row">

									<label class="col-sm-2 col-form-label">Longitude</label>

									<div class="col-sm-6">

											<input type="text" class="form-control" name = "long" placeholder = "Type Longitude" value="<?php echo $row['longitude']; ?>"/>

									</div>

							</div>

							<div class = "form-group row">

									<label class="col-sm-2 col-form-label">Latitude</label>

									<div class="col-sm-6">

											<input type="text" class="form-control" name = "lat" placeholder = "Type Latitude" value="<?php echo $row['latitude']; ?>" />

									</div>

							</div>



							

							</div>
								<div class = "form-group row" id = "slot1" >
				                  <label class="col-sm-2 col-form-label">Slot 1</label>
				                  <div class="col-sm-6">
				                      <input type="text" class="form-control" name = "slot1" placeholder = "Slot 1" required = "required" value="<?php echo $row['slot1']; ?>"  />
				                  </div>
				              </div>
		              
                            
                            <?php 
                            	if ($row['slot2'] > 0 && $row['slot3'] > 0) {

                            		?>

                            		<div class = "form-group row" id = "slot2" >
						                  <label class="col-sm-2 col-form-label">Slot 2</label>
						                  <div class="col-sm-6">
						                      <input type="text" class="form-control" name = "slot2" placeholder = "Slot 2" required = "required" value="<?php echo $row['slot2']; ?>" />
						                  </div>
						              </div>
						              <div class = "form-group row" id = "slot3" >
						                  <label class="col-sm-2 col-form-label">Slot 3</label>
						                  <div class="col-sm-6">
						                      <input type="text" class="form-control" name = "slot3" placeholder = "Slot 3" required = "required" value="<?php echo $row['slot3']; ?>" />
						                  </div>
						              </div>

                            		<div class = "form-group row" id = "peak1">

									<label class="col-sm-2 col-form-label">Initial Peak Units (Phase 1)</label>

									<div class="col-sm-6">

											<input type="textarea" class="form-control" name = "pk1" placeholder = "Peak Phase 1" required = "required" value="<?php echo $row['kwhpeak1']; ?>"/>
                                    </div>
                            </div>
                            <div class = "form-group row" id = "peak2">

									<label class="col-sm-2 col-form-label">Initial Peak Units (Phase 2)</label>

                                    <div class="col-sm-6">
                                            <input type="textarea" class="form-control" name = "pk2" placeholder = "Peak Phase 2" required = "required" value="<?php echo $row['kwhpeak2']; ?>"/>
                                    </div>
                              </div>
                            <div class = "form-group row" id = "peak3">

									<label class="col-sm-2 col-form-label">Initial Peak Units (Phase 3)</label>

                                    <div class="col-sm-6">
                                            <input type="textarea" class="form-control" name = "pk3" placeholder = "Peak Phase 3" required = "required" value="<?php echo $row['kwhpeak3']; ?>"/>
                                    </div>
                              </div>

							
                             <div class = "form-group row" id = "offpeak1" >

									<label class="col-sm-2 col-form-label">Initial Off Peak Units (Phase 1)</label>

									<div class="col-sm-6">

											<input type="textarea" class="form-control" name = "offpk1" placeholder = "Off Peak Phase 1" required = "required" value="<?php echo $row['kwhoffpeak1']; ?>"/>
                                    </div>
                            </div>
                            <div class = "form-group row" id = "offpeak2">

									<label class="col-sm-2 col-form-label">Initial Off Peak Units (Phase 2)</label>

                                    <div class="col-sm-6">
                                            <input type="textarea" class="form-control" name = "offpk2" placeholder = "Off Peak Phase 2" required = "required" value="<?php echo $row['kwhoffpeak2']; ?>"/>
                                    </div>
                              </div>
                            <div class = "form-group row" id = "offpeak3">

									<label class="col-sm-2 col-form-label">Initial Off Peak Units (Phase 3)</label>

                                    <div class="col-sm-6">
                                            <input type="textarea" class="form-control" name = "offpk3" placeholder = "Off Peak Phase 3" required = "required" value="<?php echo $row['kwhoffpeak3']; ?>" />
                                    </div>
                              </div>

                            		<?php 
                            	}
                            ?>
                            
                            <div class = "form-group row">

									<label class="col-sm-2 col-form-label">Initial Offpeak Units</label>

									<div class="col-sm-6">

											<input type="textarea" class="form-control" name = "offpk" placeholder = "Type Off Peak" required = "required" value="<?php echo $row['offpeak']; ?>" />

									</div>

							</div>
                            <div class = "form-group row">

									<label class="col-sm-2 col-form-label">Initial Peak Units</label>

									<div class="col-sm-6">

											<input type="textarea" class="form-control" name = "pk" placeholder = "Type Peak" required = "required" value="<?php echo $row['peak']; ?>"/>

									</div>
                            
 

							<?php
								}
							?>
								<span style="display: inline;"  >
											<input type="submit" class="btn btn-primary" name = "add" value = "Update" />
												<button class="btn btn-primary" onclick="window.location.href = 'transformer-list.php?filter=0G0';">Back to List</button>
											</span>


            </form>
									</div>
							</div>

					
      </section>
	</div>
</div>
    
  <!-- /.content-wrapper -->

	<?php include_once('footer.php') ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

<!-- ./wrapper -->
<?php include_once('script.php') ?>
</body>

<script type="text/javascript">
  function Change() {
    var num = document.getElementById("phase").value;
    document.getElementById("peak").innerHTML = "";

    for (var i = 1; i <=num; i++) {
    var x = document.createElement("INPUT");
    x.setAttribute("type", "text");
    x.setAttribute("id", "pk"+(i));
    x.setAttribute("placeholder", "Phase "+i);
    x.setAttribute("required", "required");
    x.setAttribute("class", "form-control");
    document.getElementById("peak").appendChild(x);
  }
  document.getElementById("offpeak").innerHTML = "";
  for (var i = 1; i <=num; i++) {
    var x = document.createElement("INPUT");
    x.setAttribute("type", "text");
    x.setAttribute("id", "offpk"+(i));
    x.setAttribute("placeholder", "Phase "+i);
    x.setAttribute("required", "required");
    x.setAttribute("class", "form-control");
    document.getElementById("offpeak").appendChild(x);
    }
  
} 
</script>

<script>
  //   $(function () {
    function changetextbox()
{
    if (document.getElementById("phase").value==='1')
	{
                            document.getElementById("pk2").disable='true';
                             document.getElementById("pk3").disable='true';
    }
     
}
			
 
     
</script>
</html>


<?php

    		//	require_once("opendb.php");


    date_default_timezone_set("Asia/Karachi");

   // $con = new DBCon();


    if(isset($_POST['add']))
    {      
      print_r($_POST);
    	$name = $_POST['cname'];
        $tariff               = $_POST['tarrif'];
        $longitude              = $_POST['long'];
        $latitude               = $_POST['lat'];
        $description               = $_POST['description'];
        $mfactor               = $_POST['mfactor'];

      
		    if ($_POST['slot1'] == "") {
         	$slot1            = -1;
        }else
        {
        	$slot1            = $_POST['slot1'];	
        }
        if (!isset($_POST['slot2']) or $_POST['slot2'] == "") {
         	$slot2            = -1;
        }else
        {
        	$slot2            = $_POST['slot2'];	
        }
        if (!isset($_POST['slot2']) or $_POST['slot3'] == "") {
         	$slot3            = -1;
        }else
        {
        	$slot3            = $_POST['slot3'];	
        }

      	
        $offpeak                = $_POST['offpk'];
        $peak                     = $_POST['pk'];
        $sn = $_POST['sn'];
        $connectiondate         = date('Y-m-d H:i:s');

        $peak_web = $peak/3;
        $offpeak_web = $offpeak/3;
        $user = $_SESSION['userid'];

		$q1 = "UPDATE connections SET name = '$name', longitude = '$longitude', latitude = '$latitude', tariff = '$tariff', mfactor = '$mfactor', description = '$description', slot1 = '$slot1', slot2 = '$slot2', slot3='$slot3', offpeak = '$offpeak', peak = '$peak', serialNo='$sn', kwhoffpeak1_web = '$offpeak_web', kwhoffpeak2_web = '$offpeak_web', kwhoffpeak3_web = '$offpeak_web', kwhpeak1_web = '$peak_web',kwhpeak1_web = '$peak_web', kwhpeak2_web = '$peak_web',kwhpeak3_web = '$peak_web', peak_web = '$peak', offpeak_web=$offpeak, edit_by = '$user', edit_time = CURTIME()  where cid = '".$id."'";

    	echo $q1;
      $stmt1 = $conn->prepare($q1);
  
      try{
        $result1 = $stmt1->execute();
        $count = $stmt1->rowCount();
         
        if($count > 0){
         $split = explode("CN",$id);
          $no = (int)$split[1];
        $q2 = "update connections_db set kwhpeak".$no." = $peak, kwhoffpeak".$no."= $offpeak where dbid = '".$split[0]."'";
          $res = $conn -> query($q2) or die(error);
         echo $q2;
          echo "<script > window.open('connection-list.php?filter=0G0','_self'); </script>";
        }
        else{
          echo "<script> alert('There was an error in editing connection :".str_replace("'", "\'", $q1)."'); </script>";
        }
      }
      catch(PDOException $e)
      {
        echo "<script> alert('There was an error in editing connection :".str_replace("'", "\'", $q1)."'); </script>";
      }
      

    }
	$conn= NULL;

?>
