<?php session_start();
if( !isset($_SESSION['cid'])){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php $pageName = "Recharge History"?>

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
      <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <b>Bus Rapid Transit (BRT) Peshawar</b>
            
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-5 invoice-col">
          
            <?php
                
                require_once("opendb.php");
                date_default_timezone_set("Asia/Karachi");
                $query = "select * from connections where cid = '".$_SESSION['cid']."'";
                $result = $conn -> query($query) or die("Query error");
                foreach ($result as $row) {
            ?>
            <b style="font-size: 20px"><?php echo $row['assignee_name']; ?></b><br>
            <b>Billing Method:</b> <?php echo ucfirst($row['billing_method']); ?><br>
            <b>Reference No:</b> <?php echo $row['cid']; ?><br>
            <b>Address:</b> <?php echo $row['address']; ?><br>
            <b>Email:</b> <?php echo $row['email']; ?><br>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Date: </b> <?php echo date("Y-m-d H:i:s"); ?><br>
          <b>Last Bill Paid: </b> <?php echo $row['bill_paid_on']; ?><br>
        </div>
        <?php 
            } 
          ?>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Recharge Method</th>
              <th>Card Serial No. </th>
              <th>Date Credited</th>
              <th>Amount (PKR)</th>
          
            </tr>
            </thead>
            <tbody>
            <?php 
              $query = "select * from topup_cards where used_by = '".$_SESSION['cid']."'";
              $result = $conn -> query($query) or die("Query error");
              $total_amount = 0;
              foreach ($result as $row) {
                ?>
                <tr>
                  <td>Top-up Card</td>
                  <td><?php echo $row['card_id']; ?></td>
                  <td><?php echo $row['datentime']; ?></td>
                  <td><?php echo $row['amount']; ?></td>
                  

                </tr>

                <?php
                $total_amount += $row['amount'];
              }
            ?>
            
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <div class="table-responsive">
            <table class="table">
              <tbody><tr>
                <th style="width:50%">Total:</th>
                <td>PKR <?php echo $total_amount; ?>/-</td>
              </tr>
            </tbody></table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <?php $conn = NULL; ?>
      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;" onclick="window.print()">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
      </div>
    </section>



    </section>

    <!-- /.content -->


   
  </div>
  <!-- /.content-wrapper -->
  
  <?php //include_once('footer.php') ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include_once('script.php') ?>
</body>
</html>
