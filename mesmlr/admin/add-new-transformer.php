<?php
//   include_once('check.php');
//   authenticate("edit");
?>
<!DOCTYPE html>
<html>
<head>


  <?php $pageName = "Add New Transformer"?>



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
		<div class="panel-heading"> Add New Transformer </div>
		<div class="panel-body">



	<form method = "POST">

<div class = "form-group row">
<label class="col-sm-2 col-form-label">Out Feeder ID</label>
<div class="col-sm-6">
	<?php

			
	        require("opendb.php");
			date_default_timezone_set("Asia/Karachi");

			$q = "select * from outfeeder";

	        $result = $conn -> query($q) or die("Query error");
			echo"<select name = 'outfeeder' class='form-control'>";
			echo "<option value = '--'>Select Out Feeder</option>";
                $farray = array();
			foreach($result as $row)
			{
			echo "<option value = '".$row['fdid']."'>".$row['fdid']."-----".$row['name']."-".$row['description']."</option selected>";
                array_push($farray,array($row['fdid']=>$row['name']));

			}
			echo "</select>";
		//	$conn= NULL;
	?>
</div>
</div>

								<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Capacity (KVA)</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "tcapacity" placeholder = "Transformer Capacity" required = "required" />
									</div>
							</div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">Transformer Location</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "tlocation" placeholder = "Transformer Location" required = "required" />
									</div>
							</div>
                            <div class = "form-group row">
                                <label class = "col-sm-2 col-form-label">LT Connection</label>
                                <div class="col-sm-6">
									<select name = "LTC" class="form-control">
                                        <option value = "--">Select LT Line Connection</option>
                                        <option value = "yes"> Yes</option>
                                        <option value = "no"> No</option>

                                        
                                    </select>
								</div>
                            
                            </div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">LT Length</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "LTlength" placeholder = "LT Length" required = "required" />
									</div>
							</div>

							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">C Resistance</label>
									<div class="col-sm-6">
											<input type="text" class="form-control" name = "CResistance" placeholder = "C Resistance" required = "required" />
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
							<div class = "form-group row">
									<label class="col-sm-2 col-form-label">SIM No.</label>
									<div class="col-sm-6">
											<input type="textarea" class="form-control" name = "simno" placeholder = "Type Sim Number" required = "required" />
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
												<button class="btn btn-primary" onclick="window.location.href = 'transformer-list.php?filter=0G0';">Back to List</button>
											</span>




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

    		//	require_once("opendb.php");


    date_default_timezone_set("Asia/Karachi");

   // $con = new DBCon();


    if(isset($_POST['add']))
    {

        $outfeeder = $_POST['outfeeder'];
		$q = "select substring_index(trid,'R',-1)  as trid from transformer where substring_index(trid,'T',1)='".$outfeeder."'";
                       // echo $q;
		$result = $conn->query($q); 
		
		$max=0;
		foreach($result as $row){
           // echo $row['trid'];
          //  $id = explode('R',$row['trid']);
            if ($max<intval($row['trid']))
            $max = intval($row['trid']);
            
        }
		// code for incrementing Tr_id 
		echo $max;
			if($max!=0)
			{
			//$tr = explode("R",$row['trid']);
			//var_dump($tr);

			$a =  intval($max)+1;
			//var_dump($a);
            if($a < 10)
            {
                $tr2 ='TR0'.strval($a);
                $name = 'Transformer 0'.strval($a);
            }
            else
            {
            $tr2 ='TR'.strval($a);
            $name = 'Transformer '.strval($a);
            }
			
			
			var_dump($tr2);
			}
		
		else{
			$tr2='TR01';
			$name = 'Transformer 01';
		}
		
    
 
//		$subdivision = $_POST['subdivision'];
//		$infeeder = $_POST['infeeder'];
			$outfeeder = $_POST['outfeeder'];

			
				
				 

                $trid                   = $outfeeder.$tr2;
        $location               = $_POST['tlocation'];
        $longitude              = $_POST['long'];
        $latitude               = $_POST['lat'];
        $capacity               = $_POST['tcapacity'];
        $ltlength               = $_POST['LTlength'];
        $CResistance            = $_POST['CResistance'];
        $offpeak                = $_POST['offpk'];
        $pk                     = $_POST['pk'];
        $sim 					= $_POST['simno'];
        $connectiondate         = date('Y/m/d H:i:s');
        
        if($_POST['LTC']=="yes")
        {
            $ltc = 1;
        }
        else
        {
            $ltc = 0;
            
        }
        
        $div_offpk = $offpeak/3;
        $div_pk = $pk/3;
        $q1 = "INSERT INTO transformer (trid,name,longitude,latitude,description,connectiondate,kva_capacity,ltlength,cresistance,c1,c2,c3,v1,v2,v3,pf1,pf2,pf3,datetime, offpeak, peak,kwh_dev_offpeak1,kwh_dev_offpeak2,kwh_dev_offpeak3,kwh_dev_peak1,kwh_dev_peak2,kwh_dev_peak3,kwh_offpeak1,kwh_offpeak2,kwh_offpeak3,kwh_peak1,kwh_peak2,kwh_peak3,LT_flag,sim_no)VALUES
        ('$trid' , '$name'  , '$longitude' , '$latitude'  , '$location'  , '$connectiondate' , '$capacity' ,'$ltlength','$CResistance',0,0,0,0,0,0,0,0,0,'$connectiondate','$offpeak','$pk','$div_offpk','$div_offpk','$div_offpk','$div_pk','$div_pk','$div_pk','$div_offpk','$div_offpk','$div_offpk','$div_pk','$div_pk','$div_pk',$ltc,$sim)";
        echo $q1;

      //  $result1 = $conn -> query($q1) or die("Query error");
        $q2 = "INSERT INTO `tr_kwh_logs`( `trid`, `offpeak`, `peak`, `Datetime`, `offpkunits`, `pkunits`, `val1`, `val2`, `val3`, `cval1`, `cval2`, `cval3`, `pf1`, `pf2`, `pf3`, `kwh1`, `kwh2`, `kwh3`, `pkflg`) VALUES ('$trid','$offpeak','$pk','$connectiondate',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
        //$result2 = $conn -> query($q2) or die("Query error");
		echo $q2;
      $stmt1 = $conn->prepare($q1);
      $stmt2 = $conn->prepare($q2);
               try
      {
           $result1 = $stmt1->execute();
           $result2 = $stmt2->execute();
         $count = $stmt1->rowCount();
         $count = $count + $stmt2->rowCount();
                  

         if($count > 0){
            
        echo "<script > window.open('transformer-list.php?filter=0G0','_self'); </script>";
          
         }
         else{
           echo "<script> alert('There was an error adding transformer :".str_replace("'", "\'", $q1.$q2)."'); </script>";
         }

      }
      catch(PDOException $e)
      {
        echo "<script> alert('There was an error adding transformer :".str_replace("'", "\'", $q1.$q2)."'); </script>";
      }
      

    }
	$conn= NULL;

?>
