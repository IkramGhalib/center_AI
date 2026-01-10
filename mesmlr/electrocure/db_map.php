<?php session_start();
if( !isset($_SESSION['userid']) or $_SESSION['role'] != "admin" ){
  echo "<script language='javascript'>window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <?php $pageName = "Distribution Box Map";?>
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
<?php
  include_once("opendb.php");
  $lat = array();
  $long = array();
  $query = "select * from db where longitude !=0 and latitude !=0";
  $result = $conn -> query($query) or die("Query error");
  $result2 = $conn -> query($query) or die("Query error");
?>

  
  <!-- Navbar -->
  <?php include_once('navbar.php') ?>
  <!-- Sidebar -->
  <?php include_once('sidebar.php') ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGdcSfLwqmDVg_HLbYAJo0qkbElSM5_fc&callback=initMap">
    </script>

<script>
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(50);
        
    // Multiple markers location, latitude, and longitude
    var markers = [
        <?php
            foreach($result as $row){
                echo '["'.$row['dbid'].'","'.$row['name'].'", '.$row['latitude'].', '.$row['longitude'].'],';
            }
        ?>
    ];
                        
    // Info window content
    var infoWindowContent = [
        <?php 
            foreach($result2 as $row){ ?>
              
                ['<div class="info_content">' +
                '<h3><?php echo $row['dbid']." | ".$row['name']; ?></h3>' +
                '<p><?php echo $row['description']; ?></p>' + '</div>' 

                ],

        <?php 
        }
        ?>
    ];
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][2], markers[i][3]);
        var dbid = markers[i][0]; 
        
        
        

         var color =  "http://maps.google.com/mapfiles/ms/icons/green-dot.png";


        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: {
              url: color
            },
            title: markers[i][0]
        });
        

        marker.addListener('mouseover', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        marker.addListener('click', (function(marker, i) {
            return function() {
              link = "db_device_dashboard.php?id=";
              window.location.href = link.concat(markers[i][0]);
              
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(12);
        google.maps.event.removeListener(boundsListener);
    });
    
}

// Load initialize function
google.maps.event.addDomListener(window, 'load', initMap);
</script>
<style type="text/css">
  #mapCanvas {
    width: 100%;
    height: 500px;
}
</style>

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
    
    <div id="mapContainer">
      <div id="mapCanvas"></div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include_once('footer.php'); ?>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include_once('script.php'); ?>
</body>
</html>
