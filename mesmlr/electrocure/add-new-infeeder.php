<?php
  include_once('check.php');
  authenticate("edit");
?><!DOCTYPE html>
<html>
<head>

  <?php $pageName = "Add New In Feeder"?>

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


<div class="content-header">
<div class="panel panel-primary" align="center" style="max-width: 700px">
<div class="panel-heading">Add New In Feeder</div>
<div class="panel-body">

                <!-- FORM -->

<form method = "POST">
  <table width="100%" border="0">
     

        <tr>
          <td class="form-group row">In Feeder Name</td class="form-group row">

          <td class="form-group row"> <input type="text" name = "In_feeder_name" class="form-control input-sm"> </td class="form-group row">

        </tr>

        <tr>
              <td class="form-group row">Description</td class="form-group row">
              <td class="form-group row"> <input type="text" name = "description" class="form-control input-sm"> </td class="form-group row">
        </tr>

        <tr>
              <td class="form-group row">Longitude</td class="form-group row">
              <td class="form-group row"> <input type="text" name = "longitude" class="form-control input-sm"> </td class="form-group row">
        </tr>

        <tr>
              <td class="form-group row">Latitude</td class="form-group row">
              <td class="form-group row"> <input type="text" name = "latitude" class="form-control input-sm"> </td class="form-group row">
        </tr>

            <tr>
              <td class="form-group row">Multiplication Factor Voltage</td class="form-group row">
              <td class="form-group row"> <input type="text" name = "mfactorvoltage" class="form-control input-sm"> </td class="form-group row">
            </tr>
                        <tr>
              <td class="form-group row">Multiplication Factor Current</td class="form-group row">
              <td class="form-group row"> <input type="text" name = "mfactorcurrent" class="form-control input-sm"> </td class="form-group row">
            </tr>
            <tr>
              <td class="form-group row">KVA Capacity</td class="form-group row">
              <td class="form-group row"> <input type="text"  name = "kva_capacity" class="form-control input-sm"> </td class="form-group row">
            </tr>
            <tr>
              <td class="form-group row">SIM No.</td class="form-group row">
              <td class="form-group row"> <input type="text"  name = "simno" class="form-control input-sm"> </td class="form-group row">
            </tr>

            <tr>
              <td class="form-group row">
                </td class="form-group row">
              <td class="form-group row" >
                <br>
                <input type="submit"  name = "add" class="btn btn-primary" value = "Add"/>
                <a href="feeder-list.php?filter=0G0" class="btn btn-primary" >Back to List</a>
              </td class="form-group row">
            </tr>
        </table>
      </form>
    </div>
  </div>
</div>
</div>




    </section>

    <!-- /.content -->
              <!-- ALL PHP CODE -->

<?php
  //  $subdivid = 'mes05c1';
//    $dbtype = 'electrocure';
  require("opendb.php");

  date_default_timezone_set("Asia/Karachi");


  if(isset($_POST['add']))
  {
  $q = "select  MAX(substring_index(fdid,'I',-1)) as fdid from feeder";
      $result = $conn->query($q); 
						
						$max=0;
						foreach($result as $row){
                            if($max < $row['fdid'])
                                $max = $row['fdid'];
                            
                        }
  $feederID        = 'I'.intval($max + 1);
  $name       = $_POST['In_feeder_name'];
  $description      = $_POST['description'];
  $longitude   = $_POST['longitude'];
  $latitude      = $_POST['latitude'];
  $mfactorv       = $_POST['mfactorvoltage'];
    $mfactorc       = $_POST['mfactorcurrent'];
  $kva_capacity         = $_POST['kva_capacity'];
  $sim         = $_POST['simno'];
  $c_date    = date('Y-m-d H:i:s');
  
  $q= "INSERT INTO `feeder`(`fdid`, `name`, `longitude`, `latitude`, `map`, `description`, `group`, `sub-maingroup`, `maingroup`, `kva_capacity`, `connectiondate`, `mfactorvoltage`, `mfactorcurrent`, `c1`, `c2`, `c3`, `v1`, `v2`, `v3`, `pf1`, `pf2`, `pf3`, `datetime`, `offpeak`, `peak`,`sim_no`) VALUES ('".$feederID."','".$name."','".$longitude."','".$latitude."',0,'".$description."',1,1,1,'".$kva_capacity."','".$c_date."','".$mfactorv."','".$mfactorc."',0,0,0,0,0,0,0,0,0,'".$c_date."',0,0,'".$sim."')";

  echo $q;
 // $result = $conn -> query($q) or die("Query error");

 $stmt1 = $conn->prepare($q);
     // $stmt2 = $conn->prepare($q2);
               try
      {
           $result1 = $stmt1->execute();
          // $result2 = $stmt2->execute();
         $count = $stmt1->rowCount();
       //  $count = $count + $stmt2->rowCount();
                  

         if($count > 0){
            
        echo "<script > window.open('feeder-list.php?filter=0G0','_self'); </script>";
          
         }
         else{
           echo "<script> alert('There was an error adding feeder :".str_replace("'", "\'", $q1.$q2)."'); </script>";
         }

      }
      catch(PDOException $e)
      {
        echo "<script> alert('There was an error adding feeder :".str_replace("'", "\'", $q1.$q2)."'); </script>";
      }
      
  }
  $conn= NULL;
?>



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
