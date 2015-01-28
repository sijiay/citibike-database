 var map;
 var geocoder;
 var bounds = new google.maps.LatLngBounds();
 var markersArray = [];
 var travelMode;
//var origin;
//var destination = new google.maps.LatLng(47.658335, -122.302662);
var origin1;
var origin2 = new google.maps.LatLng(47.6550, -122.3080); 
var destinationA = new google.maps.LatLng(47.6550, -122.3080);
var destinationB;
var destinationIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000';
var originIcon = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';
        
function initialize() {
  var opts = {
    center: { 
      lat: 40.7127, lng: -74.0059},
      zoom: 15
    };
    map = new google.maps.Map(document.getElementById('map-canvas'), opts);
    geocoder = new google.maps.Geocoder();
  }
  google.maps.event.addDomListener(window, 'load', initialize);

function addMarker(location) {
    var icon;
    geocoder.geocode({'address': location}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        bounds.extend(results[0].geometry.location);
        map.fitBounds(bounds);
        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
          icon: icon
        });
        markersArray.push(marker);
      } else {
        alert('Geocode was not successful for the following reason: '+ status);
      }
    });
}

function createMarker(latlng, name, address) {
    var html = "<b>" + name + "</b> <br/>" + address;
    var marker = new google.maps.Marker({
      map: map,
      position: latlng
    });
    google.maps.event.addListener(marker, 'click', function() {
      infoWindow.setContent(html);
      infoWindow.open(map, marker);
    });
    markers.push(marker);
}

intialize();