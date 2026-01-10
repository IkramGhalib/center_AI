<?php
  // include_once('check.php');
  // authenticate("edit");
?>
<!DOCTYPE html>
<html>
<head>


  <?php $pageName = "Add New Connection";?>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $pageName;?></title>

 <?php include_once('head.php'); ?>

</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
<!-- the fixed layout is not compatible with sidebar-mini -->
<body class="hold-transition skin-blue sidebar-mini" >
<!-- Site wrapper -->
<div class="wrapper" style="overflow: hidden;">


	<!-- Navbar -->
	<?php include_once('navbar.php'); ?>
	<!-- Sidebar -->
	<?php include_once('sidebar.php'); ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper" style="margin-top: <?php echo $contentmargin; ?>px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <b><?php echo $pageName;
          //    require_once("opendb.php");
            ?></b>

      </h1>
      <ol class="breadcrumb">
        <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?php echo $pageName;?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

<div class="panel panel-primary" align="center" style="max-width: 700px">
		<div class="panel-heading"> Add New Connection </div>
		<div class="panel-body">



		
	<form method = "POST">

<div class = "form-group row">
<label class="col-sm-2 col-form-label">Distibution Box ID</label>
<div class="col-sm-6">
	<?php
	      require("opendb.php");
		date_default_timezone_set("Asia/Karachi");
    //        echo $conn;
			
			
			$query = "select * from db where linesassigned < 32";
			
	        $result = $conn -> query($query) or die("Query error");
			echo"<select name = 'DB' class='form-control'>";
			echo "<option value = '--'>-----Select Distribution Box------</option>";
           	foreach($result as $row)
			{
			echo "<option value = '".$row['dbid']."'>".$row['dbid']."-----".$row['name']."-".$row['description']."</option selected>";
           	}
			echo "</select>";
	?>
</div>
</div>

<!--
							<div class = "form-group row">

									<label class="col-sm-2 col-form-label">Feeder In ID</label>

									<div class="col-sm-6">

											<input type="text" class="form-control" name = "fID" placeholder = "Type Feeder ID" required = "required" />

									</div>

							</div>
-->
							<div class = "form-group row">

									<label class="col-sm-2 col-form-label">Connection Name</label>

									<div class="col-sm-6">

											<input type="text" class="form-control" name = "cname" placeholder = "Type Name" required = "required" />

									</div>

							</div>
                            <div class = "form-group row">

									<label class="col-sm-2 col-form-label">Serial Number</label>

									<div class="col-sm-6">

											<input type="text" class="form-control" name = "sn" placeholder = "Type Serial Number" required = "required" />

									</div>

							</div>

              <script type="text/javascript">
                function changeTextbox(){
                  var num = document.getElementById("phase").value;
                  var slot1 = document.getElementById("slot1");
                  var slot2 = document.getElementById("slot2");
                  var slot3 = document.getElementById("slot3");

                  


                  if (num == 1) {
                    slot1.style.display = "block";
                    peak.style.display = "block";
                    offpeak.style.display = "block";
                    slot2.style.display = "none";
                    slot3.style.display = "none";
                    peak1.style.display = "none";
                    offpeak1.style.display = "none";
                    peak2.style.display = "none";
                    offpeak2.style.display = "none";
                    peak3.style.display = "none";
                    offpeak3.style.display = "none";

                  }else if(num == 3){
                    peak.style.display = "none";
                    offpeak.style.display = "none";

                    slot1.style.display = "block";
                    slot2.style.display = "block";
                    slot3.style.display = "block";
                    peak1.style.display = "block";
                    offpeak1.style.display = "block";
                    peak2.style.display = "block";
                    offpeak2.style.display = "block";
                    peak3.style.display = "block";
                    offpeak3.style.display = "block";


                  }else{
                    slot1.style.display = "none";
                    slot2.style.display = "none";
                    slot3.style.display = "none";

                    peak.style.display = "none";
                    offpeak.style.display = "none";
                    
                    peak1.style.display = "none";
                    offpeak1.style.display = "none";
                    peak2.style.display = "none";
                    offpeak2.style.display = "none";
                    peak3.style.display = "none";
                    offpeak3.style.display = "none";
                  }

                  

                }

              </script>
                            <div class = "form-group row">
                            <label class="col-sm-2 col-form-label">Phase</label>
                                <div class="col-sm-6">
                                    
	                             
                                <select id= "phase" name = "phase" class="form-control" onchange="changeTextbox()">
			                         <option value = "0">Select Phase</option>
                                     <option value = "1"> Single </option>
                                     <option value = "3"> Three </option>
              

			                     </select>
	
                                </div>
                        </div>
			     
							<!--div class = "form-group row">

									<label class="col-sm-2 col-form-label">Voltage Multiplying Factor</label>

									<div class="col-sm-6">

											<input type="text" class="form-control" name = "vmf" placeholder = "Type Voltage Multiplying Factor" required = "required" />

									</div>

							</div-->
              <div class = "form-group row" id = "slot1" hidden="hidden">
                  <label class="col-sm-2 col-form-label">Slot 1</label>
                  <div class="col-sm-6">
                      <input type="text" class="form-control" name = "slot1" placeholder = "Slot 1" required = "required" />
                  </div>
              </div>
              <div class = "form-group row" id = "slot2" hidden="hidden">
                  <label class="col-sm-2 col-form-label">Slot 2</label>
                  <div class="col-sm-6">
                      <input type="text" class="form-control" name = "slot2" placeholder = "Slot 2" required = "required" value="-1"/>
                  </div>
              </div>
              <div class = "form-group row" id = "slot3" hidden="hidden">
                  <label class="col-sm-2 col-form-label">Slot 3</label>
                  <div class="col-sm-6">
                      <input type="text" class="form-control" name = "slot3" placeholder = "Slot 3" required = "required" value="-1"/>
                  </div>
              </div>
								<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Tarrif</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "tarrif" placeholder = "Tarrif" required = "required" />
									</div>
							</div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Description</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "description" placeholder = "Description" required = "required" />
									</div>
							</div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Multiplication Factor</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "mfactor" placeholder = "Multiplication Factor" required = "required" />
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


							

							<div class = "form-group row" id = "peak" hidden="hidden">

									<label class="col-sm-2 col-form-label">Initial Offpeak Units</label>

									<div class="col-sm-6">

											<input type="textarea" class="form-control" name = "offpk" placeholder = "Type Off Peak" required = "required" value="0"/>

									</div>

							</div>
                            <div class = "form-group row" id = "offpeak" hidden="hidden">

									<label class="col-sm-2 col-form-label">Initial Peak Units</label>

									<div class="col-sm-6">

											<input type="textarea" class="form-control" name = "pk" placeholder = "Type Peak" required = "required" value="0"/>

									</div>

							</div>
                            
                            <div class = "form-group row" id = "peak1" hidden="hidden">

									<label class="col-sm-2 col-form-label">Initial Peak Units (Phase 1)</label>

									<div class="col-sm-6">

											<input type="textarea" class="form-control" name = "pk1" placeholder = "Peak Phase 1" required = "required" value="0"/>
                                    </div>
                            </div>
                            <div class = "form-group row" id = "peak2" hidden="hidden">

									<label class="col-sm-2 col-form-label">Initial Peak Units (Phase 2)</label>

                                    <div class="col-sm-6">
                                            <input type="textarea" class="form-control" name = "pk2" placeholder = "Peak Phase 2" required = "required" value="0"/>
                                    </div>
                              </div>
                            <div class = "form-group row" id = "peak3" hidden="hidden">

									<label class="col-sm-2 col-form-label">Initial Peak Units (Phase 3)</label>

                                    <div class="col-sm-6">
                                            <input type="textarea" class="form-control" name = "pk3" placeholder = "Peak Phase 3" required = "required" value="0" />
                                    </div>
                              </div>

							
                             <div class = "form-group row" id = "offpeak1" hidden="hidden">

									<label class="col-sm-2 col-form-label">Initial Off Peak Units (Phase 1)</label>

									<div class="col-sm-6">

											<input type="textarea" class="form-control" name = "offpk1" placeholder = "Off Peak Phase 1" required = "required" value="0"/>
                                    </div>
                            </div>
                            <div class = "form-group row" id = "offpeak2" hidden="hidden">

									<label class="col-sm-2 col-form-label">Initial Off Peak Units (Phase 2)</label>

                                    <div class="col-sm-6">
                                            <input type="textarea" class="form-control" name = "offpk2" placeholder = "Off Peak Phase 2" required = "required" value="0"value="0"/>
                                    </div>
                              </div>
                            <div class = "form-group row" id = "offpeak3" hidden="hidden">

									<label class="col-sm-2 col-form-label">Initial Off Peak Units (Phase 3)</label>

                                    <div class="col-sm-6">
                                            <input type="textarea" class="form-control" name = "offpk3" placeholder = "Off Peak Phase 3" required = "required" value="0"/>
                                    </div>
                              </div>
				<!--      <div class = "form-group row">

									<label class="col-sm-2 col-form-label">Connection Date</label>

									<div class="col-sm-6">

											<input id="today" type="date" class="form-control" name = "fcondate" required = "required"  />

									</div>

							</div> -->



								<span style="display: inline;"  >
											<input type="submit" class="btn btn-primary" name = "add" value = "Add" />
												<button class="btn btn-primary" onclick="window.location.href = 'connection-list.php?filter=0G0';">Back to List</button>
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
</html>


<?php

    		//	require_once("opendb.php");


//date_default_timezone_set("Asia/Karachi");

   // $con = new DBCon();


    if(isset($_POST['add']))
    {

        $dbid = $_POST['DB'];
						$q = "select substring_index(cid,'N',-1)  as cid from connections where substring_index(cid,'C',1)='".$dbid."'";
                       // echo $q;
						$result = $conn->query($q); 
						
						$max=0;
						foreach($result as $row){
                           // echo $row['trid'];
                          //  $id = explode('R',$row['trid']);
                            if ($max<intval($row['cid']))
                            $max = intval($row['cid']);
                            
                        }
						// code for incrementing Tr_id 
			//		echo $max;
							if($max!=0)
							{
							//$tr = explode("R",$row['trid']);
							//var_dump($tr);

							$a =  intval($max)+1;
							//var_dump($a);
                            if($a < 10)
                            {
                                $tr2 ='CN0'.strval($a);
                              //  $name = 'Transformer 0'.strval($a);
                            }
                            else
                            {
                            $tr2 ='CN'.strval($a);
                       //     $name = 'Transformer '.strval($a);
                            }
							
							
							var_dump($tr2);
							}
						
						else{
							$tr2='CN01';
							//$name = 'Transformer 01';
						}
						
				    
		 	 
				//		$subdivision = $_POST['subdivision'];
				//		$infeeder = $_POST['infeeder'];
						//	$outfeeder = $_POST['outfeeder'];

							
								
						 
          $name = $_POST['cname'];
          $phase                  = $_POST['phase'];
                $cid                   = $dbid.$tr2;
        $q = "select linesassigned from db where dbid = '".$dbid."'";
     //   echo $q;
            $result = $conn->query($q); 
        foreach($result as $row)
        {
            $count = $row['linesassigned'];
        }

        $tariff               = $_POST['tarrif'];
        $longitude              = $_POST['long'];
        $latitude               = $_POST['lat'];
        $description               = $_POST['description'];
        $mfactor               = $_POST['mfactor'];
      
        $offpeak                = $_POST['offpk'];
        $peak                     = $_POST['pk'];
       
        $kwhoffpeak1      = $_POST['offpk1'];
        $kwhoffpeak2      = $_POST['offpk2'];
        $kwhoffpeak3      = $_POST['offpk3'];
        $kwhpeak1         = $_POST['pk1'];
        $kwhpeak2         = $_POST['pk2'];
        $kwhpeak3         = $_POST['pk3'];
        $slot1            = $_POST['slot1'];
        $slot2            = $_POST['slot2'];
        $slot3            = $_POST['slot3'];

        $sn =$_POST['sn'];
        $connectiondate         = date('Y-m-d H:i:s');;//$_POST['tcondate'];
        $user = $_SESSION['userid'];

        $q1 = "INSERT INTO `connections`(`cid`, `name`, `longitude`, `latitude`, `slot1`, `slot2`, `slot3`, `tariff`, `totalmeters`, `mfactor`, `description`, `connectiondate`, `c1`, `c2`, `c3`, `pf1`, `pf2`, `pf3`, `v1`, `v2`, `v3`, `kwhoffpeak1`, `kwhoffpeak2`, `kwhoffpeak3`, `kwhpeak1`, `kwhpeak2`, `kwhpeak3`, `offpeak`, `peak`, `datetime`,`serialNo`,`edit_by`,`edit_time`) VALUES('$cid','$name','$longitude','$latitude','$slot1','$slot2','$slot3','$tariff','0','$mfactor','$description','$connectiondate','0','0','0','0','0','0','0','0','0','$kwhoffpeak1','$kwhoffpeak2','$kwhoffpeak3','$kwhpeak1','$kwhpeak2','$kwhpeak3','$offpeak','$peak','$connectiondate','$sn','$user',NOW())";

        echo $q1;
      //  $result1 = $conn -> query($q1) or die("Query error");
    //    $q2 = "INSERT INTO `tr_kwh_logs`( `trid`, `offpeak`, `peak`, `Datetime`, `offpkunits`, `pkunits`, `val1`, `val2`, `val3`, `cval1`, `cval2`, `cval3`, `pf1`, `pf2`, `pf3`, `kwh1`, `kwh2`, `kwh3`, `pkflg`) VALUES ('$trid','$offpeak','$pk','$connectiondate',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
    //    $result2 = $conn -> query($q2) or die("Query error");

      $stmt1 = $conn->prepare($q1);
    //  $stmt2 = $conn->prepare($q2);
            
           $result1 = $stmt1->execute();
        //   $result2 = $stmt2->execute();
         $count1 = $stmt1->rowCount();
                   echo $count1;
        // $count = $count + $stmt2->rowCount();
                  

         if($count1 > 0){
             $q = "update db set linesassigned = '".$count."' where dbid = '".$dbid."'";
            $result = $conn->query($q); 
        echo "<script > window.open('connection-list.php?filter=0G0','_self'); </script>";
          
         }
         else{
           echo "<script> alert('There was an error adding connection :".str_replace("'", "\'", $q1)."'); </script>";
         }

      
      

    }
	$conn= NULL;

?>

