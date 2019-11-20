<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <script type="text/javascript">
    const g_lng = "<?php echo $longitud; ?>";  
    const g_lat = "<?php echo $latitud; ?>";
    </script>
<body onload="initMap();">
    <div id="map"></div>
    <script>
      var map;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          //center: {lat: g_lat , lng: g_lng},
          center: {lat: 653.689762826358 , lng: 21997.46806667194},
          zoom: 20
        });
      }
    </script>
    <script //src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTDzYPweZynHMj6ZzzLeTXNTlkxfUed-c&callback=initMap"
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTDzYPweZynHMj6ZzzLeTXNTlkxfUed-c"
    async defer></script>
  </body>
</html>