<!doctype html>
<html><!-- InstanceBegin template="/Templates/Master.dwt" codeOutsideHTMLIsLocked="false" -->
	
	<?php $page_name = "Write Dashboard Name Here!";?>

  <meta http-equiv="refresh" content="300">
<head>
	<meta charset="utf-8">
	<!-- InstanceBeginEditable name="doctitle" -->
	<title><?php echo $page_name; ?></title>

	<!-- InstanceEndEditable -->
	<!-- InstanceBeginEditable name="head" -->
	<!-- InstanceEndEditable -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


	<!-- 		/*All STYLES*/  -->
<style>
		#overflow{
		width: 100%;
		height: 100%;
		}

		#add-new-button{
		position: absolute;
		right:  120px;
		}

		.skin-blue{
		background-color:#ECF0F5;
		}

		thead{
		background-color:#0073B7;
		color:white;
		}
</style>

			<!--ALL LINKS-->
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

</head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<body class="skin-blue">

  <?php require_once('navbar.php');?>

<!-- Left side column. contains the logo and sidebar -->
<div class="content-header" background-color:#000000>

		<section class="content-header">
      <br>
      <br>
      <br>
      <br>

		<h1><b>
		<?php echo $page_name; ?>
		<button id="add-new-button" class="btn btn-primary" onClick="window.location.href='"><b>Return to Dashboard</b></button>

		</b></h1>

		</section>
    <br>

    <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3> 0.0 Volt</h3>

              <p><b>Average Voltage</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>

          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
             <h3>0.0 AMP</h3>

              <p><b>Total Current</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
				<h3>0.0</h3>

              <p><b>Total KVA</b></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>





    </div>
    <div >
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="" width="600" height="400" frameborder="0"></iframe>
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="" width="600" height="400" frameborder="0"></iframe>
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="" width="600" height="400" frameborder="0"></iframe>
        </div>
        <div class="col-lg-5" style=" margin: 10px;">
          <iframe src="" width="600" height="400" frameborder="0"></iframe>
        </div>

    </div>
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>

	<!-- SlimScroll -->
	<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	<script src="bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>

</body>
</html>
