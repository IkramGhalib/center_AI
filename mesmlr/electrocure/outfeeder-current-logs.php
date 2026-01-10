 <?php
  include_once('check.php');
  authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Out Feeder Current Logs"?>



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

<aside class="main-sidebar" style="margin-top: <?php echo $sidebarmargin;?>px;">
        <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="overflow-x: scroll;">
          <!-- sidebar menu: : style can be found in sidebar.less -->
         
      <ul class="sidebar-menu">
            <form  id="sidebarform" method="post">
        <li class="header">Select Specific Transformer</li>
        <br>

          <select class="form-control" name="interval">
            <option value="5" <?php echo (isset($_POST['interval']) and $_POST['interval'] == 5) ? "selected" : ""; ?> >5 Minutes Interval</option>
            <option value="15" <?php echo (isset($_POST['interval']) and $_POST['interval'] == 15) ? "selected" : ""; ?> >15 Minutes Interval</option>
            <option value="30" <?php echo (isset($_POST['interval']) and $_POST['interval'] == 30) ? "selected" : ""; ?> >30 Minutes Interval</option>
          </select>
          
          <br>

          <?php
          require_once("opendb.php");
          if (!$detect->isMobile() and !$detect->isTablet()) {

          
          $query = "select fdid, name from outfeeder";
          $result = $conn -> query($query) or die("Query error");
          ?>

          <input type="text" list="transformers" name="transformer" placeholder="Select Out Feeder" class="form-control">
          <datalist id="transformers">
            <?php
            foreach ($result as $row) {
              echo "<option value=".$row['fdid'].">".$row['name']."</option>";
            }
            ?>
            
          </datalist>

          

          <br>
          <div style="color: #FFFFFF"><b>Date and Time From:</b></div>
            
          <input type="date" id="fromdate" name="fromdate" class="form-control" placeholder="Logs From">
          <input type="time" id="fromtime" name="fromtime" class="form-control" placeholder="Logs From">
          <br>
          <div style="color: #FFFFFF"><b>Date and Time To:</b></div>
          <input type="date" id="todate" name="todate" class="form-control" placeholder="Logs to">
          <input type="time" id="totime" name="totime" class="form-control" placeholder="Logs to">

          <br>
          <button style="float: right; margin-right:5px; " class="btn-primary btn" name="submit"> Submit </button>

        </form>
<?php }
?>

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
    <section class="content">
      <div id="overflow">
       <table id="example1" class="table table-responsive table-bordered table-striped">
          <thead class="bg-blue">
            <tr>
              <th scope="col">Feeder ID</th>
              <th scope="col">Feeder Name</th>
              <th scope="col">v1 (KV)</th>
              <th scope="col">v2 (KV)</th>
              <th scope="col">v3 (KV)</th>
              <th scope="col">c1</th>
              <th scope="col">c2</th>
              <th scope="col">c3</th>
              <th scope="col">pf1</th>
              <th scope="col">pf2</th>
              <th scope="col">pf3</th>
              <th scope="col">KVA1</th>
              <th scope="col">KVA2</th>
              <th scope="col">KVA3</th>
              <th scope="col">Total Kva</th>              
              
              <th scope="col">Date & Time</th>
             
              
        </tr>
                    </thead>
         
         
                    <tbody>
                      
           <?php
            
          //include("db/opendb.php");
            if(isset($_POST['interval'])){
              $interval = $_POST['interval'];
            }else{
              $interval = 5;
            }

          if(isset($_POST['transformer']) and !empty($_POST['transformer'])){
            $id = $_POST['transformer'];

            if(empty($_POST['todate']) or empty($_POST['fromdate'])){

              $query = "SELECT FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(ofd_current_logs.datetime) / ($interval*60)) * ($interval*60)) AS chunk_start, ofd_current_logs.trid, outfeeder.name, max(ofd_current_logs.B1U) as B1U,max(ofd_current_logs.B1M) B1M,max(ofd_current_logs.B1L) AS B1L, avg(ofd_current_logs.v1) AS v1,avg(ofd_current_logs.v2) as v2,avg(ofd_current_logs.v3) as v3, max(ofd_current_logs.pf1) as pf1, max(ofd_current_logs.pf1) as pf2, max(ofd_current_logs.pf3) as pf3 from ofd_current_logs, outfeeder where outfeeder.fdid = ofd_current_logs.trid and ofd_current_logs.trid = '".$id."' and fdid != 'I1F1' GROUP BY trid, chunk_start,name ORDER BY chunk_start desc limit 500";

              
              //$query = "SELECT tr_current_logs.*, transformer.name FROM tr_current_logs ,transformer WHERE tr_current_logs.trid = transformer.trid and tr_current_logs.trid = '".$id."' order by tr_current_logs.datetime desc limit 1500";
              ?>

              
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo "Showing Data for Transformer <b>'".$id."'</b>"; ?>
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
              $query = "SELECT FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(ofd_current_logs.datetime) / ($interval*60)) * ($interval*60)) AS chunk_start, ofd_current_logs.trid, outfeeder.name, max(ofd_current_logs.B1U) as B1U,max(ofd_current_logs.B1M) B1M,max(ofd_current_logs.B1L) AS B1L, avg(ofd_current_logs.v1) AS v1,avg(ofd_current_logs.v2) as v2,avg(ofd_current_logs.v3) as v3, max(ofd_current_logs.pf1) as pf1, max(ofd_current_logs.pf1) as pf2, max(ofd_current_logs.pf3) as pf3 from ofd_current_logs, outfeeder where outfeeder.fdid = ofd_current_logs.trid and ofd_current_logs.trid = '".$id."' AND ofd_current_logs.datetime BETWEEN '".$fromdate."' AND '".$todate."' GROUP BY trid, chunk_start,name ORDER BY chunk_start desc";
              
              ?>

              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                  <?php echo "Showing Data for Transformer <b>'".$id."'</b> from date '".$fromdate."' to date '".$todate."' desc limit 1000"; ?>
              </div>
            
              <?php
              
            }
          }
          else{
          // $query= "SELECT FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(ofd_current_logs.datetime) / ($interval*60)) * ($interval*60)) AS chunk_start, ofd_current_logs.trid, outfeeder.name, max(ofd_current_logs.B1U) as B1U,max(ofd_current_logs.B1M) B1M,max(ofd_current_logs.B1L) AS B1L, avg(ofd_current_logs.v1) AS v1,avg(ofd_current_logs.v2) as v2,avg(ofd_current_logs.v3) as v3, max(ofd_current_logs.pf1) as pf1, max(ofd_current_logs.pf1) as pf2, max(ofd_current_logs.pf3) as pf3 from ofd_current_logs, outfeeder where outfeeder.fdid = ofd_current_logs.trid GROUP BY trid, chunk_start,name ORDER BY chunk_start desc limit 500";
          $query= "SELECT FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(ofd_current_logs.datetime) / ($interval*60)) * ($interval*60)) AS chunk_start, ofd_current_logs.trid, outfeeder.name,MAX(ofd_current_logs.B1U) AS B1U, MAX(ofd_current_logs.B1M) AS B1M, MAX(ofd_current_logs.B1L) AS B1L,AVG(ofd_current_logs.v1) AS v1, AVG(ofd_current_logs.v2) AS v2,AVG(ofd_current_logs.v3) AS v3,MAX(ofd_current_logs.pf1) AS pf1,MAX(ofd_current_logs.pf2) AS pf2,MAX(ofd_current_logs.pf3) AS pf3 FROM ofd_current_logs JOIN outfeeder ON outfeeder.fdid = ofd_current_logs.trid GROUP BY trid, chunk_start, name HAVING AVG(ofd_current_logs.B1U) = 0  AND AVG(ofd_current_logs.B1M) = 0 AND AVG(ofd_current_logs.B1L) = 0 ORDER BY chunk_start DESC LIMIT 500";
        }
          
          
                  //echo $query;
          $result = $conn -> query($query) or die("Query error");
                 
                  foreach($result as $row){
          


                            if($row['pf1']<0.5)
                               $pf1 = 'NC';
                            else
                                $pf1 = $row['pf1'];
                            if($row['pf2']<0.5)
                               $pf2 = 'NC';
                            else
                                $pf2 = $row['pf2'];
                            if($row['pf3']<0.5)
                               $pf3 = 'NC';
                            else
                               $pf3 = $row['pf3'];

                            
                                $c1 = $row ['B1U'];
                             
                                $c2 = $row ['B1M'];
                             

                             
                                $c3 = $row ['B1L'];
                            
            ?>
            
            <tr>
              <td><?php echo $row ['trid'];  ?></td>
              <td><?php echo $row ['name'];  ?></td>
              <td><?php echo round(($row ['v1']),2);  ?></td>
              <td><?php echo round(($row ['v2']),2);  ?></td>
              <td><?php echo round(($row ['v3']),2);  ?></td>
              <td><?php echo $c1;  ?></td>
              <td><?php echo $c2 ; ?></td>
              <td><?php echo $c3; ?></td>
              <td><?php echo $pf1; ?></td>
              <td><?php echo $pf2;?></td>
              <td><?php echo $pf3;?></td>
              
              
              
              <td><?php echo round(($row ['v1'])*($c1),2);  ?></td>
              <td><?php echo round(($row ['v2'])**($c2),2);  ?></td>
              <td><?php echo round(($row ['v3'])($c3),2);  ?></td>
              <td><?php echo round(round(($row ['v1'])*($c1),2)+($row ['v2'])*($c2)+($row ['v3'])*($c3),2);  ?></td>
              
              
              <td><?php echo $row ['chunk_start'];  ?></td>
              
              
        </tr>
            
                      <?php } ?>
            
                    </tbody>
                    <tfoot class="bg-blue">
                      
              <tr>
              <th scope="col">Feeder ID</th>
              <th scope="col">Feeder Name</th>
              <th scope="col">v1 (KV)</th>
              <th scope="col">v2 (KV)</th>
              <th scope="col">v3 (KV)</th>
              <th scope="col">c1</th>
              <th scope="col">c2</th>
              <th scope="col">c3</th>
              <th scope="col">pf1</th>
              <th scope="col">pf2</th>
              <th scope="col">pf3</th>
              <th scope="col">KVA1</th>
              <th scope="col">KVA2</th>
              <th scope="col">KVA3</th>
              <th scope="col">Total Kva</th>              
              
              <th scope="col">Date & Time</th>
             
              
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
  
    <script>
    $(function () {
    $('#example1').DataTable(
        {
            'order': [[ 15, "desc" ]],
           'pageLength': 17
        })
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
<?php include_once('script.php') ?>
</body>
</html>
