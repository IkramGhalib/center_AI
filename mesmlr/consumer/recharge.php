<?php session_start();
if( !isset($_SESSION['cid'])){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Recharge Account"?>



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
    <section class="content" style="max-width: 400px;">


	<form method="post">
		<img src="images/recharge.png" width="60%" height="" style="margin-left: 15%">
		<br>
		<br>
		<br>
	    <div class="input-group">
	      <span class="input-group-addon">Scratch Card No: </span>
	      <input id="hidden_code" type="text" class="form-control" maxlength="14" minlength="14" name="hidden_code" placeholder="Enter 14 Digit Hidden Code">
	    </div>
	    <br>
	    <div align="right">
	    	<button class="btn btn-primary" id="recharge" name="recharge" >Recharge</button>
	    	<button class="btn btn-danger" type="Reset">Reset</button>
	    </div>
  	</form>
      
    </section>
<?php
  require_once("opendb.php");
  date_default_timezone_set("Asia/Karachi");
  if(isset($_POST['recharge'])){
    $card = $_POST['hidden_code'];
    $q = "UPDATE topup_cards SET status = 0, used_by = ?, datentime = now() WHERE hidden_code = ? and status = ? ";
    $stmt = $conn->prepare($q);
    $stmt -> execute(array($_SESSION['cid'],$card,"1"));
    if($stmt->rowCount() > 0){
      $amountQuery = "select amount from topup_cards where hidden_code = '".$card."'";
      $amountResult = $conn -> query($amountQuery) or die("Query error");
      foreach ($amountResult as $row) {
        $amount = $row['amount'];
      }
       if($_SESSION['billing_method'] == "prepaid"){  
        $q = "update connections as c1, (select unit_limit from connections where cid = '".$_SESSION['cid']."') as v1 set c1.unit_limit = v1.unit_limit+(select amount from topup_cards where used_by = '".$_SESSION['cid']."' order by datentime desc limit 1)/(select prepaid_unit from tariff order by datetime desc limit 1), c1.bill_paid_on = now(), status = 'on' where cid = '".$_SESSION['cid']."'";
        $stmt = $conn->prepare($q);
        $stmt -> execute();
        echo $q;
       ?>
      <div class="alert alert-success alert-dismissible col">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Your account has been recharged successfully. Check your dashboard for further details. Thanks for recharging your account!
      </div>
      <?php

    }elseif ($_SESSION['billing_method'] == "postpaid") {
      // POSTPAID REACHARGE
        $q = "update connections as c1, (select unit_limit from connections where cid = '".$_SESSION['cid']."') as v1 set c1.unit_limit = v1.unit_limit+(select amount from topup_cards where used_by = '".$_SESSION['cid']."' order by datentime desc limit 1)/(select postpaid_unit from tariff order by datetime desc limit 1) where cid = '".$_SESSION['cid']."'";
        $stmt = $conn->prepare($q);
        $stmt -> execute();

        $query = "update connections set bill_paid_on = now(), status = 'on' where (peak+offpeak) <= unit_limit";
        $stmt1 = $conn->prepare($query);
        $stmt1 -> execute();

        if($stmt1->rowCount() == 1){
          ?>
          <div class="alert alert-success alert-dismissible col">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            Your account has been recharged successfully. Check your dashboard for further details. Thanks for recharging your account!
          </div>
          <?php
        }else{
          ?>  
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Attention!</h4>
                  Your account has been successfully recharged but still your bill is not completely paid. Please pay your complete bill to avoid inconvenience. Check your dashboard for further details.
              </div>
          <?php
        }


       

      }
    }else{
      ?>

      <div class="alert alert-danger alert-dismissible col">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Sorry!</h4>
        Card number is incorrect or has been already used. Try another one. Thank you!
      </div>
      <?php
    }
}
?>

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
<?php $conn = NULL; ?>
</html>
