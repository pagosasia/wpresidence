/*global admin_google_vars*/
/*global google */


var map='';
var selected_city='';
var geocoder;


function initialize()
{
 "use strict";
 geocoder       = new google.maps.Geocoder();
 var myPlace    = new google.maps.LatLng(admin_google_vars.general_latitude, admin_google_vars.general_longitude);
 
 var mapOptions = {
         flat:false,
         noClear:false,
         zoom: 17,
         scrollwheel: true,
         draggable: true,
         center: myPlace,
         mapTypeId: google.maps.MapTypeId.ROADMAP
       };

 map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
 google.maps.visualRefresh = true;

    
var marker=new google.maps.Marker({
  position:myPlace
});
marker.setMap(map);
  
google.maps.event.addListener(map, 'click', function(event) {
  placeMarker(event.latLng);
});
}



function placeMarker(location) {
 "use strict";
  var marker = new google.maps.Marker({
    position: location,
    map: map
  });
  
  var infowindow = new google.maps.InfoWindow({
    content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()  
  });
  
   infowindow.open(map,marker);
   document.getElementById("property_latitude").value=location.lat();
   document.getElementById("property_longitude").value=location.lng();
}


 google.maps.event.addDomListener(document.getElementById('estate_property-googlemap').getElementsByClassName("handlediv")[0], 'click', function () {
     google.maps.event.trigger(map, "resize");
 });



google.maps.event.addDomListener(window, 'load', initialize);
 
     
jQuery('#admin_place_pin').click(function(event){
    event.preventDefault();
    admin_codeAddress();  
});  

 jQuery('#property_citychecklist label').click(function(event){
    selected_city=  jQuery(this).text() ;
}); 
 
 
 
 
 function admin_codeAddress() {
  var address   = document.getElementById('property_address').value;
  var full_addr= address+','+selected_city;
  
  var state     = document.getElementById('property_state').value;
  if(state){
       var full_addr=full_addr +','+state;
  }
 
  var country   = document.getElementById('property_country').value;
  if(country){
       var full_addr=full_addr +','+country;
  }
  
 
  geocoder.geocode( { 'address': full_addr}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });

            var infowindow = new google.maps.InfoWindow({
                content: 'Latitude: ' + results[0].geometry.location.lat() + '<br>Longitude: ' + results[0].geometry.location.lng()  
             });
              
            infowindow.open(map,marker);
            document.getElementById("property_latitude").value=results[0].geometry.location.lat();
            document.getElementById("property_longitude").value=results[0].geometry.location.lng();
    } else {
            alert(admin_google_vars.geo_fails  + status);
    }
  });
}
