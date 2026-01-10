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
	<form>
		<img src="images/recharge.png" width="60%" height="" style="margin-left: 15%">
		<br>
		<br>
		<br>
	    <div class="input-group">
        <span class="input-group-addon">Reference No: &nbsp; &nbsp; &nbsp;</span>
        <input id="msg" type="text" class="form-control" name="msg" placeholder="Enter Connection Reference No.">
      </div>
      <br>
      <div class="input-group">
	      <span class="input-group-addon">Scratch Card No: </span>
	      <input id="msg" type="text" class="form-control" name="msg" placeholder="Enter 14 Digit Hidden Code">
	    </div>
	    <br>
	    <div align="right">
	    	<button class="btn btn-primary">Recharge</button>
	    	<button class="btn btn-danger" type="Reset">Reset</button>
	    </div>
  	</form>











      
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
