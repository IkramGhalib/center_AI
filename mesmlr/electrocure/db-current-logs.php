<?php
 include_once('check.php');
  authenticate("can_view");
  // echo '<pre>';
  // print_r($_SESSION['employee']);
  // exit;
  ?>
?>
<!DOCTYPE html>
<html>
<head>
 <style>
th { font-size: 10px; }
td { font-size: 10px; }

 </style> 

  <?php $pageName = "Distribution Boxes Current Logs"; ?>



  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--title><?php echo $pageName;?></title-->
  
 <?php include_once('head.php');
 $filter = $_GET['filter'];

 ?> 

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
<!-- Left side column. contains the logo and sidebar -->
  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar" style="margin-top: <?php echo $sidebarmargin;?>px;">
        <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="overflow-x: scroll;">
          <!-- sidebar menu: : style can be found in sidebar.less -->
         
      <ul class="sidebar-menu">
            
        <li class="header">Select Specific Distribution Boxes</li>
         <br>
          <?php
          require_once("opendb.php");
          $query = "select dbid, name from db";
          $result = $conn -> query($query) or die("Query error");

          if (!$detect->isMobile() and !$detect->isTablet()) {
          ?>
           <form id="sidebarform" method="post">

             <input type="text" list="dbs" name="db" placeholder="Select Distribution" class="form-control">
          <datalist id="dbs">
            <?php
            foreach ($result as $row) {
              echo "<option value=".$row['dbid'].">".$row['name']."</option>";
            }
            ?>
            
          </datalist>

          <br>
          
          <div style="color: #FFFFFF"><b>Date From:</b></div>
          <input type="date" id="fromdate" name="fromdate" class="form-control" placeholder="Logs From">
          <input type="time" id="fromtime" name="fromtime" class="form-control" placeholder="Logs From">

          
          <div style="color: #FFFFFF"><b>Date To:</b></div>
          <input type="date" id="todate" name="todate" class="form-control" placeholder="Logs to">
          <input type="time" id="totime" name="totime" class="form-control" placeholder="Logs to">

          <br>
          <button style="float: right; margin-right:5px; " class="btn-primary btn" name="submit"> submit </button>

        </form>
      <?php } ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
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

    <section class="content" id="sec">
<?php if ($detect->isMobile() or $detect->isTablet()) {
          
          ?>

          <input type="text" list="dbs" name="db" placeholder="Select Distribution" class="form-control">
          <datalist id="dbs">
            <?php
            foreach ($result as $row) {
              echo "<option value=".$row['dbid'].">".$row['name']."</option>";
            }
            ?>
            
          </datalist>

          <br>
          <div><b>Date and Time From:</b></div>
          <input type="date" id="fromdate" name="fromdate" class="form-control" placeholder="Logs From">
          <input type="time" id="fromtime" name="fromtime" class="form-control" placeholder="Logs From">
          <br>
          <div><b>Date and Time To:</b></div>
          <input type="date" id="todate" name="todate" class="form-control" placeholder="Logs to">
          <input type="time" id="totime" name="totime" class="form-control" placeholder="Logs to">

          <br>
          <button style="float: right; margin-right:5px; " class="btn-primary btn" name="submit"> Submit </button>


            </div>
            <!-- /.box-body -->
          </div>
          
          
        </form>
          <?php } ?>
 
    <div  id="overflow" style=" overflow-x: auto;">
        
        <table  id="example1" class="table table-responsive table-bordered table-striped">
        <thead class="bg-blue">
        <tr>
                  
                  
          <th scope="col">DB ID</th>
          <th scope="col">DB Name</th>        
          <th scope="col">V1</th>
          <th scope="col">V2</th>
          <th scope="col">V3</th>
          <th scope="col">L1C1</th>
          <th scope="col">L1C2</th>
          <th scope="col">L1C3</th>
          <th scope="col">L1Pf1</th>
          <th scope="col">L1Pf2</th>
          <th scope="col">L1Pf3</th>
          <th scope="col">L2C1</th>
          <th scope="col">L2C2</th>
          <th scope="col">L2C3</th>
          <th scope="col">L2Pf1</th>
          <th scope="col">L2Pf2</th>
          <th scope="col">L2Pf3</th>
          <th scope="col">L3C1</th>
          <th scope="col">L3C2</th>
          <th scope="col">L3C3</th>
          <th scope="col">L3Pf1</th>
          <th scope="col">L3Pf2</th>
          <th scope="col">L3Pf3</th>
          <th scope="col">L4C1</th>
          <th scope="col">L4C2</th>
          <th scope="col">L4C3</th>
          <th scope="col">L4Pf1</th>
          <th scope="col">L4Pf2</th>
          <th scope="col">L4Pf3</th>
                    <!--th scope="col">kvar1</th>
          <th scope="col">kvar2</th>
          <th scope="col">kvar3</th-->
          
          <th scope="col">Date & Time</th>
          
        </tr>
        </thead>
          
          
        <tbody bgcolor="#FFFFFF">
          
          <?php
          //include("db/opendb.php");
  
        if(isset($_POST['db'])){
            $id = $_POST['db'];

            if(empty($_POST['todate']) or empty($_POST['fromdate'])){
              $query = "SELECT db_current_logs.*, db.name FROM db_current_logs ,db WHERE db_current_logs.dbid = db.dbid and db_current_logs.dbid = '".$id."' order by db_current_logs.datetime desc limit 100";
              ?>

              
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo "Showing Data for Distribution Box <b>'".$id."'</b>"; ?>
              </div>
            
              <?php
            }
            else
            {
              $fromdate = $_POST['fromdate'];
              $todate = $_POST['todate'];

              if(!(empty($_POST['fromtime']) or empty($_POST['totime']))){
                $fromdate = $fromdate ." ". $_POST['fromtime'];
                $todate = $todate ." ". $_POST['totime'];
              }
             $query = "select db_current_logs.*,db.name from db_current_logs WHERE  dbid = '".$id."' AND db_current_logs.dbid = db.dbid, Datetime BETWEEN  '".$fromdate."' AND '".$todate."'";
              ?>

              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo "Showing Data for Distribution Box <b>'".$id."'</b> from date '".$fromdate."' to date '".$todate."'"; ?>
              </div>
            
              <?php
              
            }
          }elseif($filter == '0G0')
          $query= "select db_current_logs.*,db.name from db_current_logs,db WHERE db_current_logs.dbid = db.dbid and db_current_logs.datetime >NOW()-INTERVAL 1 DAY order by db_current_logs.datetime desc limit 5000";
         else
          $query= "select db_current_logs.*,db.name from db_current_logs,db WHERE db_current_logs.dbid = db.dbid and db_current_logs.dbid = '".$filter."' and db_current_logs.datetime >NOW()-INTERVAL 1 DAY order by db_current_logs.datetime desc limit 5000";

                  
                 
                  //echo $query;
          $result = $conn -> query($query) or die("Query error");
                  $filterid = $filter;
                  json_encode($filterid);
                  foreach($result as $row){
                      if($filter == '0G0')
                  {
                        $dbname = $row['name'];
                        $tname=$row['fname'];
                        
                  }
                      elseif(strlen($filter)==4)
                          $dbname = $row['name'];
                      
                      $kva1 = round($row['v1']*$row['B1U']/1000,2);
                      $kva2 = round($row['v2']*$row['B1M']/1000,2);
                      $kva3 = round($row['v3']*$row['B1L']/1000,2);
          ?>
          
          <?php $feeder='00';?>
        <tr>
          
            <td><?php echo $row['dbid'];  ?></td>
            <td><?php echo $dbname;  ?></td>
                   
          <td><?php echo $row ['v1'];  ?></td>
          <td><?php echo $row ['v2'];  ?></td>
          <td><?php echo $row ['v3'];  ?></td>
          <td><?php echo $row ['line1_c1'];  ?></td>
          <td><?php echo $row ['line1_c2'];  ?></td>
          <td><?php echo $row ['line1_c3'];  ?></td>
          <td><?php echo $row ['line1_pf1'];  ?></td>
          <td><?php echo $row ['line1_pf2'];  ?></td>
          <td><?php echo $row ['line1_pf3'];  ?></td>
          <td><?php echo $row ['line2_c1'];  ?></td>
          <td><?php echo $row ['line2_c2'];  ?></td>
          <td><?php echo $row ['line2_c3'];  ?></td>
          <td><?php echo $row ['line2_pf1'];  ?></td>
          <td><?php echo $row ['line2_pf2'];  ?></td>
          <td><?php echo $row ['line2_pf3'];  ?></td>
          <td><?php echo $row ['line3_c1'];  ?></td>
          <td><?php echo $row ['line3_c2'];  ?></td>
          <td><?php echo $row ['line3_c3'];  ?></td>
          <td><?php echo $row ['line3_pf1'];  ?></td>
          <td><?php echo $row ['line3_pf2'];  ?></td>
          <td><?php echo $row ['line3_pf3'];  ?></td>
          <td><?php echo $row ['line4_c1'];  ?></td>
          <td><?php echo $row ['line4_c2'];  ?></td>
          <td><?php echo $row ['line4_c3'];  ?></td>
          <td><?php echo $row ['line4_pf1'];  ?></td>
          <td><?php echo $row ['line4_pf2'];  ?></td>
          <td><?php echo $row ['line4_pf3'];  ?></td>
          
           <td><?php echo $row ['datetime'];  ?></td>
        
          
        </tr>
          
          <?php
          }
        ?>
            
        </tbody>
        <tfoot class="bg-blue">
        <tr>
                  
         <th scope="col">DB ID</th>
          <th scope="col">DB Name</th>        
          <th scope="col">V1</th>
          <th scope="col">V2</th>
          <th scope="col">V3</th>
          <th scope="col">L1C1</th>
          <th scope="col">L1C2</th>
          <th scope="col">L1C3</th>
          <th scope="col">L1Pf1</th>
          <th scope="col">L1Pf2</th>
          <th scope="col">L1Pf3</th>
          <th scope="col">L2C1</th>
          <th scope="col">L2C2</th>
          <th scope="col">L2C3</th>
          <th scope="col">L2Pf1</th>
          <th scope="col">L2Pf2</th>
          <th scope="col">L2Pf3</th>
          <th scope="col">L3C1</th>
          <th scope="col">L3C2</th>
          <th scope="col">L3C3</th>
          <th scope="col">L3Pf1</th>
          <th scope="col">L3Pf2</th>
          <th scope="col">L3Pf3</th>
          <th scope="col">L4C1</th>
          <th scope="col">L4C2</th>
          <th scope="col">L4C3</th>
          <th scope="col">L4Pf1</th>
          <th scope="col">L4Pf2</th>
          <th scope="col">L4Pf3</th>
                    <!--th scope="col">kvar1</th>
          <th scope="col">kvar2</th>
          <th scope="col">kvar3</th-->
          
          <th scope="col">Date & Time</th>
          
        </tr>
        </tfoot>
        

      </table>
        </div>

         </section>
        
  <?php $conn= NULL; ?>
  
    
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
    var table = $('#example1').DataTable(
        {'order': [
					[28, "desc"]
				],
				'pageLength': 10,
        
           "scrollX": true   
        });
    })
 
      
      
      $(function () {
    $('.wrapper1').on('scroll', function (e) {
        $('.wrapper2').scrollLeft($('.wrapper1').scrollLeft());
    }); 
    $('.wrapper2').on('scroll', function (e) {
        $('.wrapper1').scrollLeft($('.wrapper2').scrollLeft());
    });
});
$(window).on('load', function (e) {
    $('.div1').width(table.width());
    $('.div2').width(table.width());
});
  </script>
</html>
