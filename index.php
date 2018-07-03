<!DOCTYPE html >
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <script src="jquery.min.js"></script>
    <title>Creating a Store Locator on Google Maps</title>
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
  <body style="margin:0px; padding:0px;" onload="initMap()">
    <div>
         <label for="raddressInput">Search location:</label>
         <input type="text" id="addressInput" size="15"/>
        <label for="radiusSelect">Radius:</label>
        <select id="radiusSelect" label="Radius">
          <option value="50" selected>50 kms</option>
          <option value="30">30 kms</option>
          <option value="20">20 kms</option>
          <option value="10">10 kms</option>
        </select>

        <input type="button" id="searchButton" value="Search"/>
    </div>
    <div><select id="locationSelect" style="width: 10%; visibility: hidden"></select></div>
    <div id="map" style="width: 100%; height: 40%">
    </div>
    <pre id="output" style="width: 100%; height: 40%">
      
    </pre > 
   
    <script>
      var map;
      var markers = [];
      var infoWindow;
      var markersArray = [];

        function initMap() {
             var destinationIcon = 'https://chart.googleapis.com/chart?' +
            'chst=d_map_pin_letter&chld=D|FF0000|000000';
            var originIcon = 'https://chart.googleapis.com/chart?' +
                'chst=d_map_pin_letter&chld=O|FFFF00|000000';
            var map = new google.maps.Map(document.getElementById('map'), {
              center: {lat: 55.53, lng: 9.4},
              zoom: 10
            });
          //var sydney = {lat: 10.832339, lng: 106.689049};
          var infoWindow = new google.maps.InfoWindow();
           var bounds = new google.maps.LatLngBounds;
            //============================== Try HTML5 geolocation.
           
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
          // ajax
           
  
            $latlng =  $.ajax({
                  type:'POST',
                  url:'getLocation.php',
                  async : false,
                  data:'lat='+pos.lat+'&lng='+pos.lng,
              });
            //su ly khoi yeu cau thanh cong
            $latlng.then((data)=>{

              var point = JSON.parse(data);
              console.log(point.length);
               var arr = [];
               var origin = pos;
               for (var i =0; i < point.length; i++) {
                 arr.push({'lat':parseFloat(point[i].lat),'lng':parseFloat(point[i].lng)}); 
                 
               }
               // mã hóa địa ly
                var geocoder = new google.maps.Geocoder;
              // ma trận khoảng cách
                var service = new google.maps.DistanceMatrixService;
              //
              service.getDistanceMatrix({

                  origins: [origin] ,
                  destinations: arr,
                  travelMode: 'DRIVING',
                  unitSystem: google.maps.UnitSystem.METRIC,
                  avoidHighways: false,
                  avoidTolls: false

                 },(response, status)=>{
                      if (status !== 'OK') {
                  alert('Error was: ' + status);

                  } else {
              var originList = response.originAddresses;
              var destinationList = response.destinationAddresses;
              var outputDiv = document.getElementById('output');
              outputDiv.innerHTML = '';
              deleteMarkers(markersArray);

              var showGeocodedAddressOnMap = function(asDestination) {
                var icon = asDestination ? destinationIcon : originIcon;
                  return function(results, status) {
                    if (status === 'OK') {
                      map.fitBounds(bounds.extend(results[0].geometry.location));
                      markersArray.push(new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        icon: icon
                      }));
                    } else {
                      alert('Geocode was not successful due to: ' + status);
                    }
                  };
                };

                  for (var i = 0; i < originList.length; i++) {
                    var results = response.rows[i].elements;
                    geocoder.geocode({'address': originList[i]},
                        showGeocodedAddressOnMap(false));
                    for (var j = 0; j < results.length; j++) {
                      geocoder.geocode({'address': destinationList[j]},
                          showGeocodedAddressOnMap(true));
                      outputDiv.innerHTML += originList[i] + ' to ' + destinationList[j] +
                          ': ' + results[j].distance.text + ' in ' +
                          results[j].duration.text + '<br>';
                    }
                  }
                  
                }

              })//service.getDistanceMatrix

            })//then ajax
        
            }, function() {
              handleLocationError(true, infoWindow, map.getCenter());
            });
          } else {
            handleLocationError(false, infoWindow, map.getCenter());
          }
     //====================== 
        }
        function deleteMarkers(markersArray) {
        for (var i = 0; i < markersArray.length; i++) {
          markersArray[i].setMap(null);
        }
        markersArray = [];
      }
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }



  
      var map;
      var markers = [];
      var infoWindow;
      var markersArray = [];

        function initMap() {
             var destinationIcon = 'https://chart.googleapis.com/chart?' +
            'chst=d_map_pin_letter&chld=D|FF0000|000000';
            var originIcon = 'https://chart.googleapis.com/chart?' +
                'chst=d_map_pin_letter&chld=O|FFFF00|000000';
            var map = new google.maps.Map(document.getElementById('map'), {
              center: {lat: 55.53, lng: 9.4},
              zoom: 10
            });
          //var sydney = {lat: 10.832339, lng: 106.689049};
          var infoWindow = new google.maps.InfoWindow();
           var bounds = new google.maps.LatLngBounds;
            //============================== Try HTML5 geolocation.
           
			    if (navigator.geolocation) {
			      navigator.geolocation.getCurrentPosition(function(position) {
			        var pos = {
			          lat: position.coords.latitude,
			          lng: position.coords.longitude
			        };
					// ajax
           
  
					  $latlng =  $.ajax({
					        type:'POST',
					        url:'getLocation.php',
                  async : false,
					        data:'lat='+pos.lat+'&lng='+pos.lng,
					    });
            //su ly khoi yeu cau thanh cong
            $latlng.then((data)=>{

              var point = JSON.parse(data);
              console.log(point.length);
              console.log(data);
               var arr = [];
               var origin = pos;
               for (var i =0; i < point.length; i++) {
                 arr.push({'lat':parseFloat(point[i].lat),'lng':parseFloat(point[i].lng)}); 
                 
               }
               // mã hóa địa ly
                var geocoder = new google.maps.Geocoder;
              // ma trận khoảng cách
                var service = new google.maps.DistanceMatrixService;
              //
              service.getDistanceMatrix({

                  origins: [origin] ,
                  destinations: arr,
                  travelMode: 'DRIVING',
                  unitSystem: google.maps.UnitSystem.METRIC,
                  avoidHighways: false,
                  avoidTolls: false

                 },(response, status)=>{
                      if (status !== 'OK') {
                  alert('Error was: ' + status);

                  } else {
              var originList = response.originAddresses;
              var destinationList = response.destinationAddresses;
              var outputDiv = document.getElementById('output');
              outputDiv.innerHTML = '';
              deleteMarkers(markersArray);

              var showGeocodedAddressOnMap = function(asDestination) {
                var icon = asDestination ? destinationIcon : originIcon;
                  return function(results, status) {
                    if (status === 'OK') {
                      map.fitBounds(bounds.extend(results[0].geometry.location));
                      markersArray.push(new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                        icon: icon
                      }));
                    } else {
                      alert('Geocode was not successful due to: ' + status);
                    }
                  };
                };

                  for (var i = 0; i < originList.length; i++) {
                    var results = response.rows[i].elements;
                    geocoder.geocode({'address': originList[i]},
                        showGeocodedAddressOnMap(false));
                    for (var j = 0; j < results.length; j++) {
                      geocoder.geocode({'address': destinationList[j]},
                          showGeocodedAddressOnMap(true));
                      outputDiv.innerHTML += originList[i] + ' to ' + destinationList[j] +
                          ': ' + results[j].distance.text + ' in ' +
                          results[j].duration.text + '<br>';
                    }
                  }

                }

              })//service.getDistanceMatrix

            })//then ajax
				
			      }, function() {
			        handleLocationError(true, infoWindow, map.getCenter());
			      });
			    } else {
			      handleLocationError(false, infoWindow, map.getCenter());
			    }
		 //====================== 
        }
        function deleteMarkers(markersArray) {
        for (var i = 0; i < markersArray.length; i++) {
          markersArray[i].setMap(null);
        }
        markersArray = [];
      }
        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }



  </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKXadc2u1qTifRpwZ9Bn13Gr48HRbOlQA&callback=initMap">
    </script>
  </body>
</html>

<?php


//lấy vi trí của người dùng.




?>