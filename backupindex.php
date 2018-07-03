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
    <ul id="diadiem" style="width: 100%; height: 40%">
      
    </ul> 
   
    <script>
      var map;
      var markers = [];
      var infoWindow;
      var locationSelect;

        function initMap() {
          var sydney = {lat: 10.832339, lng: 106.689049};
          // map = new google.maps.Map(document.getElementById('map'), {
          //   center: sydney,
          //   zoom: 11,
          //   mapTypeId: 'roadmap',
          //   mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
          // });
          infoWindow = new google.maps.InfoWindow();

          searchButton = document.getElementById("searchButton").onclick = searchLocations;

          locationSelect = document.getElementById("locationSelect");

          locationSelect.onchange = function() {
            var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
            if (markerNum != "none"){
              google.maps.event.trigger(markers[markerNum], 'click');
            }
          };

            //============================== Try HTML5 geolocation.
           
			    if (navigator.geolocation) {
			      navigator.geolocation.getCurrentPosition(function(position) {
			        var pos = {
			          lat: position.coords.latitude,
			          lng: position.coords.longitude
			        };
					// ajax
           
          getvitri(pos); 
					  $latlng =  $.ajax({
					        type:'POST',
					        url:'getLocation.php',
                  async : false,
					        data:'lat='+pos.lat+'&lng='+pos.lng,
					        // success:function(msg){
					        //     if(msg){
					        //       console.log(msg);
					        //     }else{
					        //         console.log('lỗi ajax xac định vi tri');
					        //     }
					        // }
					    });
            $latlng.then((data)=>{
              console.log(data);

            })


            
					// console.log(JSON.stringify(pos))
			        // infoWindow.setPosition(pos);
			        // infoWindow.setContent('Location found.');
			        // infoWindow.open(map);
			        // map.setCenter(pos);
			      }, function() {
			        handleLocationError(true, infoWindow, map.getCenter());
			      });
			    } else {
			      // Browser doesn't support Geolocation
			      handleLocationError(false, infoWindow, map.getCenter());
			    }
		 //====================== 
        }
        


       function searchLocations() {
       	var vitri = getvitri();
        console.log(JSON.stringify(vitri));
         // var address = document.getElementById("addressInput").value;
         // var geocoder = new google.maps.Geocoder();
         // geocoder.geocode({address: address}, function(results, status) {
         //   if (status == google.maps.GeocoderStatus.OK) {
         //    searchLocationsNear(results[0].geometry.location);
         //   } else {
         //     alert(address + ' not found');
         //   }
         // });
         // 
       }

       // function clearLocations() {
       //   infoWindow.close();
       //   for (var i = 0; i < markers.length; i++) {
       //     markers[i].setMap(null);
       //   }
       //   markers.length = 0;

       //   locationSelect.innerHTML = "";
       //   var option = document.createElement("option");
       //   option.value = "none";
       //   option.innerHTML = "See all results:";
       //   locationSelect.appendChild(option);
       // }

       // function searchLocationsNear(center) {
       //   clearLocations();

       //   var radius = document.getElementById('radiusSelect').value;
       //   var searchUrl = 'storelocator.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius;
       //   downloadUrl(searchUrl, function(data) {
       //     var xml = parseXml(data);
       //     var markerNodes = xml.documentElement.getElementsByTagName("marker");
       //     var bounds = new google.maps.LatLngBounds();
       //     for (var i = 0; i < markerNodes.length; i++) {
       //       var id = markerNodes[i].getAttribute("id");
       //       var name = markerNodes[i].getAttribute("name");
       //       var address = markerNodes[i].getAttribute("address");
       //       var distance = parseFloat(markerNodes[i].getAttribute("distance"));
       //       var latlng = new google.maps.LatLng(
       //            parseFloat(markerNodes[i].getAttribute("lat")),
       //            parseFloat(markerNodes[i].getAttribute("lng")));

       //       createOption(name, distance, i);
       //       createMarker(latlng, name, address);
       //       bounds.extend(latlng);
       //     }
       //     map.fitBounds(bounds);
       //     locationSelect.style.visibility = "visible";
       //     locationSelect.onchange = function() {
       //       var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
       //       google.maps.event.trigger(markers[markerNum], 'click');
       //     };
       //   });
       // }

       // function createMarker(latlng, name, address) {
       //    var html = "<b>" + name + "</b> <br/>" + address;
       //    var marker = new google.maps.Marker({
       //      map: map,
       //      position: latlng
       //    });
       //    google.maps.event.addListener(marker, 'click', function() {
       //      infoWindow.setContent(html);
       //      infoWindow.open(map, marker);
       //    });
       //    markers.push(marker);
       //  }

       // function createOption(name, distance, num) {
       //    var option = document.createElement("option");
       //    option.value = num;
       //    option.innerHTML = name;
       //    locationSelect.appendChild(option);
       // }

       // function downloadUrl(url, callback) {
       //    var request = window.ActiveXObject ?
       //        new ActiveXObject('Microsoft.XMLHTTP') :
       //        new XMLHttpRequest;

       //    request.onreadystatechange = function() {
       //      if (request.readyState == 4) {
       //        request.onreadystatechange = doNothing;
       //        callback(request.responseText, request.status);
       //      }
       //    };

       //    request.open('GET', url, true);
       //    request.send(null);
       // }

       // function parseXml(str) {
       //    if (window.ActiveXObject) {
       //      var doc = new ActiveXObject('Microsoft.XMLDOM');
       //      doc.loadXML(str);
       //      return doc;
       //    } else if (window.DOMParser) {
       //      return (new DOMParser).parseFromString(str, 'text/xml');
       //    }
       // }


        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }


       function doNothing() {}
// show location
function showLocation(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $.ajax({
        type:'POST',
        url:'getLocation.php',
        data:'latitude='+latitude+'&longitude='+longitude,
        success:function(msg){
            if(msg){
               $("#location").html(msg);
            }else{
                $("#location").html('Not Available');
            }
        }
    });
}
function getvitri(pos){
  return pos;
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