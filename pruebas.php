<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Displaying Text Directions With setPanel()</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 70%;
        width: 50%;
        overflow: auto;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 50%;
        height: 70%;
      }

      #right-panel i {
        font-size: 12px;
      }
      #right-panel {
        height: 70%;
        float: right;
        width: 390px;
        overflow: auto;
        margin-right: 1em;
        margin-bottom: 1em;
      }
      #map {
        margin-right: 600px;
      }
      #floating-panel {
        background: #fff;
        padding: 5px;
        font-size: 14px;
        font-family: Arial;
        border: 1px solid #ccc;
        box-shadow: 0 2px 2px rgba(33, 33, 33, 0.4);
        display: none;
      }
      @media print {
        #map {
          height: 500px;
          margin: 0;
        }
        #right-panel {
          float: right;
          width: auto;
        }
      }
    </style>
  </head>
  <body>
    <div id="floating-panel">
      <strong>Start:</strong>
      <select id="start">
        <option value="-36.738938,-72.993843">PENCO</option>
        <option value="-36.827323,-73.050419">CONCEPCION</option>
        <option value="-36.714722,-73.114022">TALCAHUANO</option>
        <option value="-36.787837,-73.087887">HUALPEN</option>
        <option value="-36.841338,-73.103682">SAN PEDRO DE LA PAZ</option>
        <option value="-36.907388,-73.029180">CHIGUAYANTE</option>
        <option value="-36.617251,-72.957547">TOMÉ</option>
        <option value="-37.174980,-72.937476">SANTA JUANA</option>
        <option value="-37.094333,-73.156148">LOTA</option>
        <option value="-36.975483,-72.938854">HUALQUI</option>
      </select>
      <br>
      <strong>End:</strong>
      <select id="end">
        <option value="-36.738938,-72.993843">PENCO</option>
        <option value="-36.827323,-73.050419">CONCEPCION</option>
        <option value="-36.714722,-73.114022">TALCAHUANO</option>
        <option value="-36.787837,-73.087887">HUALPEN</option>
        <option value="-36.841338,-73.103682">SAN PEDRO DE LA PAZ</option>
        <option value="-36.907388,-73.029180">CHIGUAYANTE</option>
        <option value="-36.617251,-72.957547">TOMÉ</option>
        <option value="-37.174980,-72.937476">SANTA JUANA</option>
        <option value="-37.094333,-73.156148">LOTA</option>
        <option value="-36.975483,-72.938854">HUALQUI</option>
      </select>
    </div>
    <div id="right-panel"></div>
    <div id="map"></div>
    <script>
      function initMap() {
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: {lat: -36.8209235, lng: -73.0357265}
        });
        directionsDisplay.setMap(map);
        directionsDisplay.setPanel(document.getElementById('right-panel'));

        var control = document.getElementById('floating-panel');
        control.style.display = 'block';
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(control);

        var onChangeHandler = function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay);
        };
        document.getElementById('start').addEventListener('change', onChangeHandler);
        document.getElementById('end').addEventListener('change', onChangeHandler);
      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var start = document.getElementById('start').value;
        var end = document.getElementById('end').value;
        directionsService.route({
          origin: start,
          destination: end,
          travelMode: 'DRIVING',
          unitSystem: google.maps.UnitSystem.METRIC,
          provideRouteAlternatives: true,
          drivingOptions: {
            departureTime: new Date(Date.now()),  // for the time N milliseconds from now.
            }
        }, function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5uVpILR1wtCPtuSVDF4wgpNkXQHpQkDA&callback=initMap">
    </script>
  </body>
</html>