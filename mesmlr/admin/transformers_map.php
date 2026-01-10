<?php
  include_once('check.php');
  authenticate("view");
?>
<!DOCTYPE html>
<html>
<head>
  <?php $pageName = "Transformer Map";?>
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
  $query = "select * from transformer where longitude !=0 and latitude !=0";
  $result = $conn -> query($query) or die("Query error");
  $result2 = $conn -> query($query) or die("Query error");
?>

  
  <!-- Navbar -->
  <?php include_once('navbar.php') ?>
  <!-- Sidebar -->
  <?php // include_once('sidebar.php') ?>

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
                echo '["'.$row['trid'].'","'.$row['name'].'", '.$row['latitude'].', '.$row['longitude'].', '.$row['c1'].', '.$row['c2'].', '.$row['c3'].', '.$row['v1'].', '.$row['v2'].', '.$row['v3'].'],';
            }
        ?>
    ];
                        
    // Info window content
    var infoWindowContent = [
        <?php 
            foreach($result2 as $row){ ?>
              
                ['<div class="info_content">' +
                '<h3><?php echo $row['trid']." | ".$row['name']; ?></h3>' +
                '<p><?php echo $row['description']; ?></p>' + '</div>' +
                '<p><?php echo "Capacity = ".$row['kva_capacity']; ?></p>' + '</div>' +
                '<p><?php echo "Currents = ".$row['c1'].", ".$row['c2'].", ".$row['c3']; ?></p>' + '</div>' +
                '<p><?php echo "Voltages = ".$row['v1'].", ".$row['v2'].", ".$row['v3']; ?></p>' + '</div>'

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
        var trid = markers[i][0]; 
        var c1 = markers[i][4];
        var c2 = markers[i][5];
        var c3 = markers[i][6];
        var v1 = markers[i][7];
        var v2 = markers[i][8];
        var v3 = markers[i][9];
        
        var color = "";

        

        if (Math.max(c1,c2,c3)<0.1){
          color = "http://maps.google.com/mapfiles/ms/icons/red-dot.png";
        }else if ( v1 < 150 || v2 < 150 || v3 < 150  ||v1 > 250 || v2 > 250  || v3 > 250) {
          color = "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png"; 
        }
        else{
          color =  "http://maps.google.com/mapfiles/ms/icons/green-dot.png";

        }

        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: {
              url: color
            },
            title: markers[i][0]
        });
        if (Math.max(c1,c2,c3)<0.1 || v1 < 150 || v2 < 150 || v3 < 150  ||v1 > 250 || v2 > 250  || v3 > 250) {
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }

        marker.addListener('mouseover', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        marker.addListener('click', (function(marker, i) {
            return function() {
              link = "transformer_device_dashboard.php?id=";
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
  
  <?php include_once('footer.php') ?>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<?php include_once('script.php') ?>
</body>
</html>