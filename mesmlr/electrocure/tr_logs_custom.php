<?php session_start();
if( !isset($_SESSION['userid']) or $_SESSION['role'] != "admin" ){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Transformer Raw Logs Custom"?>



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
      
      <div class="box box-primary">
            <br>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="row">
                <div class="form-group col-md-4" style="margin-left: 10px">
                  <label for="exampleInputEmail1">Transformer ID</label>
                  <input type="text" class="form-control" id="transformerid" name="transformerid" placeholder="Enter Transformer ID">
                </div>
                <div class="form-group col-md-3">
                  <label for="exampleInputPassword1">Date From</label>
                  <input type="Date" class="form-control" id="datefrom" name="datefrom">
                </div>
                <div class="form-group col-md-4">
                  <label for="exampleInputPassword1">Date To</label>
                  <input type="Date" class="form-control" id="dateto" name="dateto">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="sub" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          
          <?php 
            $result = "";
          if(isset($_POST['sub'])){

            require_once("opendb.php");
            $trid = $_POST['transformerid'];
            $from = $_POST['datefrom'];
            $to = $_POST['dateto'];

            //echo $trid;
            //echo $from;
            //echo $to;

            $query = "SELECT * FROM `raw_user_current_log` WHERE moduleid = '$trid' AND server_date_time BETWEEN '$from' AND '$to'";
            //echo $query;
            $result = $conn -> query($query) or die("Query error");

            echo "<div style='overflow-x: scroll;'>";
          }
          else{
           echo "<div style='overflow-x: scroll;' hidden='hidden'>" ;
          }


          ?>
          
          <table id="example1"  class="table table-responsive table-bordered table-striped" >
            <thead class="bg-blue">
              <tr>
                <th scope="col">Transformer Id</th>
                <th scope="col">Packet Date Time</th>
                <th scope="col">v_red</th>
                <th scope="col">v_blue</th>
                <th scope="col">v_yellow</th>
                <th scope="col">i1</th>
                <th scope="col">i2</th>
                <th scope="col">i3</th>
                <th scope="col">i4</th>
                <th scope="col">i5</th>
                <th scope="col">i6</th>
                <th scope="col">i7</th>
                <th scope="col">i8</th>
                <th scope="col">i9</th>
                <th scope="col">i10</th>
                <th scope="col">i11</th>
                <th scope="col">i12</th>
                <th scope="col">i13</th>
                <th scope="col">i15</th>
                <th scope="col">i16</th>
                <th scope="col">i17</th>
                <th scope="col">i18</th>
                <th scope="col">i19</th>
                <th scope="col">i20</th>
                <th scope="col">i21</th>
                <th scope="col">i22</th>
                <th scope="col">i23</th>
                <th scope="col">i24</th>
                <th scope="col">i25</th>
                <th scope="col">i26</th>
                <th scope="col">i27</th>
                <th scope="col">i28</th>
                <th scope="col">i29</th>
                <th scope="col">i30</th>
                <th scope="col">i31</th>
                <th scope="col">i32</th>
                <th scope="col">pf1</th>
                <th scope="col">pf2</th>
                <th scope="col">pf3</th>
                <th scope="col">pf4</th>
                <th scope="col">pf5</th>
                <th scope="col">pf6</th>
                <th scope="col">pf7</th>
                <th scope="col">pf8</th>
                <th scope="col">pf9</th>
                <th scope="col">pf10</th>
                <th scope="col">pf11</th>
                <th scope="col">pf12</th>
                <th scope="col">pf13</th>
                <th scope="col">pf14</th>
                <th scope="col">pf15</th>
                <th scope="col">pf16</th>
                <th scope="col">pf17</th>
                <th scope="col">pf18</th>
                <th scope="col">pf19</th>
                <th scope="col">pf20</th>
                <th scope="col">pf21</th>
                <th scope="col">pf22</th>
                <th scope="col">pf23</th>
                <th scope="col">pf24</th>
                <th scope="col">pf25</th>
                <th scope="col">pf26</th>
                <th scope="col">pf27</th>
                <th scope="col">pf28</th>
                <th scope="col">pf29</th>
                <th scope="col">pf30</th>
                <th scope="col">pf31</th>
                <th scope="col">pf32</th>
                <th scope="col">ServerDateTime</th>

              </tr>
            </thead>
            <tbody>
              

            <?php
                foreach ($result as $row) {
                    ?>
                    <tr>
                <td><?php echo $row['moduleid']; ?> </td>
                <td><?php echo $row['packet_date_time']; ?> </td>
                <td><?php echo $row['v_red']; ?> </td>
                <td><?php echo $row['v_blue']; ?> </td>
                <td><?php echo $row['v_yellow']; ?> </td>
                <td><?php echo $row['i1']; ?> </td>
                <td><?php echo $row['i2']; ?> </td>
                <td><?php echo $row['i3']; ?> </td>
                <td><?php echo $row['i4']; ?> </td>
                <td><?php echo $row['i5']; ?> </td>
                <td><?php echo $row['i6']; ?> </td>
                <td><?php echo $row['i7']; ?> </td>
                <td><?php echo $row['i8']; ?> </td>
                <td><?php echo $row['i9']; ?> </td>
                <td><?php echo $row['i10']; ?> </td>
                <td><?php echo $row['i11']; ?> </td>
                <td><?php echo $row['i12']; ?> </td>
                <td><?php echo $row['i13']; ?> </td>
                <td><?php echo $row['i15']; ?> </td>
                <td><?php echo $row['i16']; ?> </td>
                <td><?php echo $row['i17']; ?> </td>
                <td><?php echo $row['i18']; ?> </td>
                <td><?php echo $row['i19']; ?> </td>
                <td><?php echo $row['i20']; ?> </td>
                <td><?php echo $row['i21']; ?> </td>
                <td><?php echo $row['i22']; ?> </td>
                <td><?php echo $row['i23']; ?> </td>
                <td><?php echo $row['i24']; ?> </td>
                <td><?php echo $row['i25']; ?> </td>
                <td><?php echo $row['i26']; ?> </td>
                <td><?php echo $row['i27']; ?> </td>
                <td><?php echo $row['i28']; ?> </td>
                <td><?php echo $row['i29']; ?> </td>
                <td><?php echo $row['i30']; ?> </td>
                <td><?php echo $row['i31']; ?> </td>
                <td><?php echo $row['i32']; ?> </td>
                <td><?php echo $row['pf1']; ?> </td>
                <td><?php echo $row['pf2']; ?> </td>
                <td><?php echo $row['pf3']; ?> </td>
                <td><?php echo $row['pf4']; ?> </td>
                <td><?php echo $row['pf5']; ?> </td>
                <td><?php echo $row['pf6']; ?> </td>
                <td><?php echo $row['pf7']; ?> </td>
                <td><?php echo $row['pf8']; ?> </td>
                <td><?php echo $row['pf9']; ?> </td>
                <td><?php echo $row['pf10']; ?> </td>
                <td><?php echo $row['pf11']; ?> </td>
                <td><?php echo $row['pf12']; ?> </td>
                <td><?php echo $row['pf13']; ?> </td>
                <td><?php echo $row['pf14']; ?> </td>
                <td><?php echo $row['pf15']; ?> </td>
                <td><?php echo $row['pf16']; ?> </td>
                <td><?php echo $row['pf17']; ?> </td>
                <td><?php echo $row['pf18']; ?> </td>
                <td><?php echo $row['pf19']; ?> </td>
                <td><?php echo $row['pf20']; ?> </td>
                <td><?php echo $row['pf21']; ?> </td>
                <td><?php echo $row['pf22']; ?> </td>
                <td><?php echo $row['pf23']; ?> </td>
                <td><?php echo $row['pf24']; ?> </td>
                <td><?php echo $row['pf25']; ?> </td>
                <td><?php echo $row['pf26']; ?> </td>
                <td><?php echo $row['pf27']; ?> </td>
                <td><?php echo $row['pf28']; ?> </td>
                <td><?php echo $row['pf29']; ?> </td>
                <td><?php echo $row['pf30']; ?> </td>
                <td><?php echo $row['pf31']; ?> </td>
                <td><?php echo $row['pf32']; ?> </td>
                <td><?php echo $row['server_date_time']; ?> </td>
              </tr>
                    <?php
                }
            ?>
            </tbody>
            <tfoot class="bg-blue">
              <tr>
                            <th scope="col">Transformer Id</th>
                <th scope="col">Packet Date Time</th>
                <th scope="col">v_red</th>
                <th scope="col">v_blue</th>
                <th scope="col">v_yellow</th>
                <th scope="col">i1</th>
                <th scope="col">i2</th>
                <th scope="col">i3</th>
                <th scope="col">i4</th>
                <th scope="col">i5</th>
                <th scope="col">i6</th>
                <th scope="col">i7</th>
                <th scope="col">i8</th>
                <th scope="col">i9</th>
                <th scope="col">i10</th>
                <th scope="col">i11</th>
                <th scope="col">i12</th>
                <th scope="col">i13</th>
                <th scope="col">i15</th>
                <th scope="col">i16</th>
                <th scope="col">i17</th>
                <th scope="col">i18</th>
                <th scope="col">i19</th>
                <th scope="col">i20</th>
                <th scope="col">i21</th>
                <th scope="col">i22</th>
                <th scope="col">i23</th>
                <th scope="col">i24</th>
                <th scope="col">i25</th>
                <th scope="col">i26</th>
                <th scope="col">i27</th>
                <th scope="col">i28</th>
                <th scope="col">i29</th>
                <th scope="col">i30</th>
                <th scope="col">i31</th>
                <th scope="col">i32</th>
                <th scope="col">pf1</th>
                <th scope="col">pf2</th>
                <th scope="col">pf3</th>
                <th scope="col">pf4</th>
                <th scope="col">pf5</th>
                <th scope="col">pf6</th>
                <th scope="col">pf7</th>
                <th scope="col">pf8</th>
                <th scope="col">pf9</th>
                <th scope="col">pf10</th>
                <th scope="col">pf11</th>
                <th scope="col">pf12</th>
                <th scope="col">pf13</th>
                <th scope="col">pf14</th>
                <th scope="col">pf15</th>
                <th scope="col">pf16</th>
                <th scope="col">pf17</th>
                <th scope="col">pf18</th>
                <th scope="col">pf19</th>
                <th scope="col">pf20</th>
                <th scope="col">pf21</th>
                <th scope="col">pf22</th>
                <th scope="col">pf23</th>
                <th scope="col">pf24</th>
                <th scope="col">pf25</th>
                <th scope="col">pf26</th>
                <th scope="col">pf27</th>
                <th scope="col">pf28</th>
                <th scope="col">pf29</th>
                <th scope="col">pf30</th>
                <th scope="col">pf31</th>
                <th scope="col">pf32</th>
                <th scope="col">ServerDateTime</th>

            
            </tr>
            </tfoot>
            </table>
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
</html>
