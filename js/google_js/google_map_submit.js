/*global google */
/*global Modernizr */
/*global InfoBox */
/*global googlecode_home_vars*/
var geocoder;
var map;
var selected_id         =   '';

var gmarkers = [];

function initialize(){
    "use strict";
    geocoder = new google.maps.Geocoder();
    
    var listing_lat=jQuery('#property_latitude').val();
    var listing_lon=jQuery('#property_longitude').val();
    
    if(listing_lat===''){
        listing_lat=google_map_submit_vars.general_latitude
    }
    
     if(listing_lon===''){
        listing_lon= google_map_submit_vars.general_longitude
    }
    
    var mapOptions = {
             flat:false,
             noClear:false,
             zoom: 17,
             scrollwheel: true,
             draggable: true,
             disableDefaultUI:false,
             center: new google.maps.LatLng( listing_lat, listing_lon),
             mapTypeId: google.maps.MapTypeId.ROADMAP
           };
    map = new google.maps.Map(document.getElementById('googleMapsubmit'), mapOptions);
    google.maps.visualRefresh = true;
    
    var point=new google.maps.LatLng( listing_lat, listing_lon);
    placeSavedMarker(point);
    
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });
}
 


function placeSavedMarker(location) {
 "use strict";
  removeMarkers();
  var marker = new google.maps.Marker({
    position: location,
    map: map
  });
   gmarkers.push(marker);
    
  var infowindow = new google.maps.InfoWindow({
    content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()  
  });
  
   infowindow.open(map,marker);


}


function codeAddress() {
  var address   = document.getElementById('property_address').value;
  //var e = document.getElementById("property_city_submit"); 
  //var city      = e.options[e.selectedIndex].text;
  city=jQuery ("#property_city_submit").val();
 
  var full_addr= address+','+city;
  
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
            alert(google_map_submit_vars.geo_fails + status);
    }
  });
}
















function placeMarker(location) {
 "use strict";
  removeMarkers();
  var marker = new google.maps.Marker({
    position: location,
    map: map
  });
   gmarkers.push(marker);
    
  var infowindow = new google.maps.InfoWindow({
    content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()  
  });
  
   infowindow.open(map,marker);
   document.getElementById("property_latitude").value=location.lat();
   document.getElementById("property_longitude").value=location.lng();

}


 ////////////////////////////////////////////////////////////////////
 /// set markers function
 //////////////////////////////////////////////////////////////////////
 
function removeMarkers(){
    for (i = 0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}

function setMarkers(map, locations) {
 
}// end setMarkers

                         
jQuery('#open_google_submit').click(function(){
     
        setTimeout(function(){
                 initialize();
                google.maps.event.trigger(map, "resize");
        },300)
   
  });
               
    
jQuery('#google_capture').click(function(event){
    event.preventDefault();
    codeAddress();  
});  
    
google.maps.event.addDomListener(window, 'load', initialize);

