<?php
  include_once('check.php');
  authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>


  <?php $pageName = "Transformer Faults"?>



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
	<?php //include_once('sidebar.php') ?>

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

      <div id="overflow">
    <table id="example1"  class="table table-responsive table-bordered table-striped">
    <thead class="bg-blue">
    <tr>
    <th scope="col">Module ID</th>
    <th scope="col">Fault Type</th>
    <th scope="col">v1</th>
    <th scope="col">v2</th>
    <th scope="col">v3</th>
    <th scope="col">c1</th>
    <th scope="col">c1</th>
    <th scope="col">c2</th>
    <th scope="col">c3</th>
    <th scope="col">Status</th>
    <th scope="col">Date</th>
    <th scope="col">Resolve Date</th>

    </tr>
    </thead>
    <tbody>

    <?php
        $subdivid = "mes05c1";
        $dbtype = "electrocure";
    require_once("opendb.php");
    $query= "SELECT * from faults limit 1000";
    $result = $conn -> query($query) or die("Query error");
    foreach($result as $row){
    ?>

    <tr>
    <td><?php echo $row ['trid'];  ?></td>
    <td><?php echo $row ['type'];  ?></td>
    <td><?php echo $row ['v1'];  ?></td>
    <td><?php echo $row ['v2'];  ?></td>
    <td><?php echo $row ['v3'];  ?></td>
    <td><?php echo $row ['c1'];  ?></td>
    <td><?php echo $row ['c2'];  ?></td>
    <td><?php echo $row ['c3'];  ?></td>
    <td><?php echo $row ['status'];  ?></td>
    <td><?php echo $row ['datetime'];  ?></td>
    <td><?php echo $row ['resolvedatetime'];  ?></td>


    </tr>

    <?php } ?>

    </tbody>
    <tfoot class="bg-blue">
    <tr>
    <th scope="col">Module ID</th>
    <th scope="col">Fault Type</th>
    <th scope="col">v1</th>
    <th scope="col">v2</th>
    <th scope="col">v3</th>
    <th scope="col">c1</th>
    <th scope="col">c1</th>
    <th scope="col">c2</th>
    <th scope="col">c3</th>
    <th scope="col">Status</th>
    <th scope="col">Date</th>
    <th scope="col">Resolve Date</th>
    </tr>
    </tfoot>
    </table>
  </div>

  <?php $conn= NULL; ?>

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
</body>
</html>
