<?php session_start();
if( !isset($_SESSION['cid'])){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php $pageName = "My Profile"?>
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
        <div class="col-md-15">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <div class="widget-user-image">
                <img class="img-circle" src="images/user.jpeg" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <?php
                  require_once("opendb.php");
                  $query = "select * from connections where cid = '".$_SESSION['cid']."'";
                  $result = $conn -> query($query) or die("Query error");
                  foreach ($result as $row) {
                ?>
              <h3 class="widget-user-username"><b><?php echo $row['assignee_name'];?></b></h3>
              <h5 class="widget-user-desc">Write any thing!</h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                
                <li><a href="#">CNIC<span class="pull-right"><?php echo $row['cnic']; ?></span></a></li>
                <li><a href="#">Email<span class="pull-right"><?php echo $row['email']; ?></span></a></li>
                <li><a href="#">Phone no.<span class="pull-right "><?php echo $row['mobile']; ?></span></a></li>
                <li><a href="#">Address<span class="pull-right"><?php echo $row['address']; ?></span></a></li>
                <li><a href="#">Billing Method<span class="pull-right "> <?php echo $row['billing_method']; ?></span></a></li>
                <li><a href="#">Connection Reference No.<span class="pull-right "><?php echo $row['cid']; ?></span></a></li>
                <?php
                  }
                  $conn = NULL;
                ?>
              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
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
