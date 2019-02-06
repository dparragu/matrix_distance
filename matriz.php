<!DOCTYPE html>
<html>
  <head>
    <script>
      function recarga(){
        location.href=location.href
      }
      setInterval('recarga()',3600000)
    </script>
    <title>Matriz de distancias</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
      #output {
        font-size: 15px;
      }

    .jumbotron h1{
        text-align: center;
      }

      #tableBody{
        text-align: center;
        width: 100%;
      }


      #map {
        height: 70%;
        width: 40%;
        position: absolute;
        margin-left: 20%;
        margin-top: 10px;
        margin-bottom: 10px;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 100px;
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
        line-height: 20px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 30%;
        height: 70%;
      }

      #right-panel i {
        font-size: 5px;
      }
      #right-panel {
        height: 70%;
        margin-left: 60%;
        width: 390px;
        overflow: auto;
        margin-top: 10px;
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

    <div class="container">
    <div class="row">
    <div class="jumbotron">
    <h1>Matriz de Distancia</h1>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <input class="btn btn-info btn-block" type="button" value="Cálculo Distancia" onclick="location.href='http://localhost/calculadora'"/> 
            <input class="btn btn-info btn-block" type="button" value="Búsqueda Direcciones" onclick="location.href='http://localhost/calculadora/direcciones.html'">
            <input class="btn btn-info btn-block" type="button" value="Matriz" onclick="location.href='http://localhost/calculadora/matriz.php'"/> 
        </div>
    </div>
    <div>
      <div>
        <strong>Fecha y Hora Consulta: </strong><?php echo date ( "d-m-Y H:i:s" , time () ); ?>
      </div>
      <div>
        <strong>Resultados</strong>
      </div>
      
      <p align="center"> 
          <input class="btn btn-success" type="button" value="Exportar Distancias" onclick="location.href='http://localhost/calculadora/exportar.php'"/>
          <input class="btn btn-info" type="button" value="Exportar Rutas Alternativas" onclick="location.href='http://localhost/calculadora/exportar_alt.php'"/>
      </p> 
      <div id="output" style="text-align:center;width:100%">
      </div>
      <div id="test"></div>
     </div>
      
      <div id="floating-panel">
      <strong>Inicio:</strong>
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
      <strong>Destino:</strong>
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
    
  </div>
</div>
    <div id="map"></div>
    <div id="right-panel"></div>

      
    <script>

        
      function initMap() {
        var bounds = new google.maps.LatLngBounds;
        var trafficLayer = new google.maps.TrafficLayer();
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: {lat: -36.8209235, lng: -73.0357265}
        });
        trafficLayer.setMap(map);
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

        var origen1 = {lat: -36.738938, lng: -72.993843};//PENCO
        var origen2 = {lat: -36.827323, lng: -73.050419};//CONCEPCION
        var origen3 = {lat: -36.714722, lng: -73.114022};//TALCAHUANO
        var origen4 = {lat: -36.787837, lng: -73.087887};//HUALPEN
        var origen5 = {lat: -36.841338, lng: -73.103682};//SAN PEDRO DE LA PAZ
        var origen6 = {lat: -36.907388, lng: -73.029180};//CHIGUYANTE
        var origen7 = {lat: -36.617251, lng: -72.957547};//TOME
        var origen8 = {lat: -37.174980, lng: -72.937476};//SANTA JUANA
        var origen9 = {lat: -37.094333, lng: -73.156148};//LOTA
        var origen10 = {lat: -36.975483, lng: -72.938854};//HUALQUI
        var destination1 = {lat: -36.738938, lng: -72.993843};//PENCO
        var destination2 = {lat: -36.827323, lng: -73.050419};//CONCEPCION
        var destination3 = {lat: -36.714722, lng: -73.114022};//TALCAHUANO
        var destination4 = {lat: -36.787837, lng: -73.087887};//HUALPEN
        var destination5 = {lat: -36.841338, lng: -73.103682};//SAN PEDRO DE LA PAZ
        var destination6 = {lat: -36.907388, lng: -73.029180};//CHIGUYANTE
        var destination7 = {lat: -36.617251, lng: -72.957547};//TOME
        var destination8 = {lat: -37.174980, lng: -72.937476};//SANTA JUANA
        var destination9 = {lat: -37.094333, lng: -73.156148};//LOTA
        var destination10 = {lat: -36.975483, lng: -72.938854};//HUALQUI
      
        var geocoder = new google.maps.Geocoder;

        var service = new google.maps.DistanceMatrixService;
        service.getDistanceMatrix({
          origins: [origen1, origen2, origen3, origen4, origen5, origen6, origen7, origen8, origen9, origen10],
          destinations: [destination1, destination2, destination3, destination4, destination5, destination6, destination7, destination8, destination9, destination10],
          travelMode: 'DRIVING',
          unitSystem: google.maps.UnitSystem.METRIC,
          avoidHighways: false,
          avoidTolls: false,
          drivingOptions: {
            departureTime: new Date(Date.now()),  // for the time N milliseconds from now.
            }
          }, function(response, status) {
          if (status !== 'OK') {
            alert('Error was: ' + status);
          } else {
            var originList = response.originAddresses;
            var destinationList = response.destinationAddresses;
            var outputDiv = document.getElementById('output');
            outputDiv.innerHTML = '';
            

            var showGeocodedAddressOnMap = function(asDestination) {

              return function(results, status) {
                if (status === 'OK') {
                  
                } 
              };
            };
            var penco = new Array();
            var concepcion = new Array();
            var talcahuano = new Array();
            var hualpen = new Array();
            var spedro = new Array();
            var chiguayante = new Array();
            var tome = new Array();
            var sjuana = new Array();
            var lota = new Array();
            var hualqui = new Array();

            for (var i = 0; i < originList.length; i++) {
              var results = response.rows[i].elements;
              geocoder.geocode({'address': originList[i]}, showGeocodedAddressOnMap(false));
              for (var j = 0; j < results.length; j++) {
                geocoder.geocode({'address': destinationList[j]}, showGeocodedAddressOnMap(true));
                if(i == 0)
                {
                  penco[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 1)
                {
                  concepcion[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 2)
                {
                  talcahuano[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 3)
                {
                  hualpen[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 4)
                {
                  spedro[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 5)
                {
                  chiguayante[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 6)
                {
                  tome[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 7)
                {
                  sjuana[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 8)
                {
                  lota[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                if(i == 9)
                {
                  hualqui[j] = results[j].distance.text + ' , ' + results[j].duration_in_traffic.text
                }
                //outputDiv.innerHTML += originList[i] + ' a ' + destinationList[j] + ': ' + results[j].distance.text + ' en ' + results[j].duration.text + '<br>';
                $.ajax({
                        type: "POST",
                        dataType: 'html',
                        url: "registro.php",
                        data: "inicio="+originList[i]+"&destino="+destinationList[j]+"&km="+results[j].distance.text+"&estimado="+results[j].duration.text+"&real="+results[j].duration_in_traffic.text,
                        success: function(resp){
                            $('#test').html(resp);
                        }
                    });

              }
            }
            
            var myTableDiv = document.getElementById("output")
            var table = document.createElement('TABLE')
            var tableBody = document.createElement('TBODY')

            table.setAttribute("border", "2");
            table.setAttribute("text-align", "center");
            table.appendChild(tableBody);

            var heading = new Array();
            heading[0] = ""
            heading[1] = "PENCO"
            heading[2] = "CONCEPCION"
            heading[3] = "TALCAHUANO"
            heading[4] = "HUALPEN"
            heading[5] = "SAN PEDRO"
            heading[6] = "CHIGUAYANTE"
            heading[7] = "TOMÉ"
            heading[8] = "SANTA JUANA"
            heading[9] = "LOTA"
            heading[10] = "HUALQUI"

            var tr = document.createElement('TR');
            tableBody.appendChild(tr);
            for (i = 0; i < heading.length; i++) {
                var th = document.createElement('TH')
                th.width = '75';
                th.appendChild(document.createTextNode(heading[i]));
                estilo = "text-align:center; width:190px";
                th.setAttribute("style", estilo);
                tr.appendChild(th);
            }

            for (i = 0; i < heading.length; i++) {
              var tr = document.createElement('TR');
              for (j = 0; j < heading.length-1; j++) {
                if(i == 0){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("PENCO"));
                    tr.appendChild(td);
                  }
                  var td = document.createElement('TD')
                  td.appendChild(document.createTextNode(penco[j]));
                  tr.appendChild(td);
                }

                if(i == 1){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("CONCEPCION"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(concepcion[j]));
                    tr.appendChild(td);
                }

                if(i == 2){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("TALCAHUANO"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(talcahuano[j]));
                    tr.appendChild(td);
                }

                if(i == 3){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("HUALPEN"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(hualpen[j]));
                    tr.appendChild(td);
                }

                if(i == 4){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("SAN PEDRO"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(spedro[j]));
                    tr.appendChild(td);
                }

                if(i == 5){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("CHIGUAYANTE"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(chiguayante[j]));
                    tr.appendChild(td);
                }

                if(i == 6){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("TOME"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(tome[j]));
                    tr.appendChild(td);
                }

                if(i == 7){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("SANTA JUANA"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(sjuana[j]));
                    tr.appendChild(td);
                }

                if(i == 8){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("LOTA"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(lota[j]));
                    tr.appendChild(td);
                }

                if(i == 9){
                  if(j == 0){
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode("HUALQUI"));
                    tr.appendChild(td);
                  }
                    var td = document.createElement('TD')
                    td.appendChild(document.createTextNode(hualqui[j]));
                    tr.appendChild(td);
                }
              }

              tableBody.appendChild(tr);
            }  
            myTableDiv.appendChild(table)
            //confirm("Datos Guardados");
            
          }
        });
      }
      function calculateAndDisplayRoute(directionsService, directionsDisplay) {
        var start = document.getElementById('start').value;
        var end = document.getElementById('end').value;
        //var div = document.getElementById('output');
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
            for(var k=0; k<response.routes.length;k++)
            {
              $.ajax({
                type: "POST",
                dataType: 'html',
                url: "registro_sec.php",
                data: "inicio="+response.routes[k].legs[0].start_address+"&destino="+response.routes[k].legs[0].end_address+"&km="+response.routes[k].legs[0].distance.text+"&estimado="+response.routes[k].legs[0].duration.text+"&real="+response.routes[k].legs[0].duration_in_traffic.text,
                success: function(resp){
                  $('#test').html(resp);
                }
              });
            }
            
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }
      
    </script>
    <script
      src="https://code.jquery.com/jquery-3.3.1.js"
      integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
      crossorigin="anonymous">
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=KEY_GOOGLE&callback=initMap">
    </script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
  </body>
</html>