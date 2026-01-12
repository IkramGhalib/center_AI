<?php
  include_once('check.php');
  authenticate("edit");
?>

<!DOCTYPE html>
<html>
<head>
  

  <?php $pageName = "Assign Consumer to Electrocure"?>



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
            <div class="box-header with-border">
              
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post">
              <div class="box-body">
                <div class="form-group">
                  <?php
                    require_once("opendb.php");
                    $query = "select cid, name from connections where status = 'unassigned'";
                    $result = $conn -> query($query) or die(error);
                  ?>
                  <label>Connection ID</label>
                  
                  <select name="connection" id="connection" class="form-control">
                    <?php
                    foreach ($result as $row) {
                      echo "<option value=".$row['cid'].">".$row['cid']." --- ".$row['name']."</option>";
                    }
                    ?>
                  </select>
                </div>


                <div class="form-group">
                  <label for="exampleInputPassword1">Name</label>
                  <input type="text" class="form-control" name="txtname" placeholder="Enter Name" required="required">
                </div>

                <div class="form-group">
                  <label for="exampleInputPassword1">CNIC</label>
                  <input type="text" class="form-control" name="txtcnic" placeholder="Enter CNIC with out dashes/hyphens (Ex: 1234512345671)" pattern="[0-9]{13}"  required="required">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Address</label>
                  <input type="text" class="form-control" name="txtaddress" placeholder="Enter Address " required="required">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Mobile</label>
                  <input type="text" class="form-control" name="txtmobile" placeholder="Enter Mobile Number (Ex: 923124567890)" pattern="[0-9]{12}" required="required">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Email</label>
                  <input type="email" class="form-control" name="txtemail" placeholder="Enter Email ID (Ex: example@example.com)" required="required">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Billing Method</label>
                  <select name="billing" id="name" class="form-control" placeholder="Select Billing Method" required="required">
                    <option value="prepaid">---Select Billing Method---</option>
                    <option value="prepaid">Prepaid</option>
                    <option value="postpaid">Postpaid</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" name="txtpassword" placeholder="Password (Choose Strong Password)" required="required">
                </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="btnsubmit" class="btn btn-primary">Submit</button>
              </div>
            </form>
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
<?php
  // CODE TO ASSIGN A PERSON TO SPECCIFIC CONNECTION
  
  if (isset($_POST['btnsubmit'])) {
    
    $cid = $_POST['connection'];
    $name = $_POST['txtname'];
    $cnic = $_POST['txtcnic'];
    $address = $_POST['txtaddress'];
    $mobile = $_POST['txtmobile'];
    $email = $_POST['txtemail'];
    $billing_method = $_POST['billing'];
    $password = $_POST['txtpassword'];

    $query = "update connections set assignee_name = '$name', cnic = '$cnic', address = '$address', mobile = '$mobile', email = '$email', billing_method = '$billing_method', password = '$password', status = 'assigned' where cid = '$cid'";
    //echo $query;
    $stmt = $conn->prepare($query);

    try{
      $result = $stmt->execute();
    }
    catch(PDOException $e){
      echo "<script> alert('There was an error Assigning Consumer: Error::".str_replace("'", "\'", $query)."'); </script>";
    }
  }

?>