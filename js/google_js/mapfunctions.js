var pin_images=mapfunctions_vars.pin_images;
var images = jQuery.parseJSON(pin_images);
var ipad_time=0;
var infobox_id=0;
var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    };

var mcOptions;
var mcluster;
var clusterStyles;

/////////////////////////////////////////////////////////////////////////////////////////////////
//  set markers... loading pins over map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function setMarkers(map, locations) {
   "use strict";
    var map_open;    
    var myLatLng;
    var selected_id     =   parseInt( jQuery('#gmap_wrapper').attr('data-post_id') );
    if( isNaN(selected_id) ){
        selected_id     =   parseInt( jQuery('#googleMapSlider').attr('data-post_id'),10 );
    }

    var open_height     =   parseInt(mapfunctions_vars.open_height,10);
    var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);
    var boxText         =   document.createElement("div");
    width_browser       =   jQuery(window).width();
    
    infobox_width=700;
    vertical_pan=-215;
    if (width_browser<900){
      infobox_width=500;
    }
    if (width_browser<600){
      infobox_width=400;
    }
    if (width_browser<400){
      infobox_width=200;
    }
 
 
    var myOptions = {
                     content: boxText,
                     disableAutoPan: true,
                     maxWidth: infobox_width,
                     boxClass:"mybox",
                     zIndex: null,			
                     closeBoxMargin: "-13px 0px 0px 0px",
                     closeBoxURL: "",
                     infoBoxClearance: new google.maps.Size(1, 1),
                     isHidden: false,
                     pane: "floatPane",
                     enableEventPropagation: false                   
                  };              
   infoBox = new InfoBox(myOptions);         
                                

    for (var i = 0; i < locations.length; i++) {
        var beach                 = locations[i];
        var id                    = beach[10];
        var lat                   = beach[1];
        var lng                   = beach[2];
        var title                 = beach[0];
        var pin                   = beach[8];
        var counter               = beach[3];
        var image                 = beach[4];
        var price                 = beach[5];
        var single_first_type     = beach[6];          
        var single_first_action   = beach[7];
        var link                  = beach[9];
        var city                  = beach[11];
        var area                  = beach[12];
        var cleanprice            = beach[13];
        var rooms                 = beach[14];
        var baths                 = beach[15];
        var size                  = beach[16];
        var single_first_type_name= beach[17];
        var single_first_action_name= beach[18];
             
        if(mapfunctions_vars.custom_search==='yes'){
            var slug1                 = beach[19];
            var val1                  = beach[20];
            var how1                  = beach[21];
            
            var slug2                 = beach[22];
            var val2                  = beach[23];
            var how2                  = beach[24];
            
            var slug3                 = beach[25];
            var val3                  = beach[26];
            var how3                  = beach[27];
           
            var slug4                 = beach[28];
            var val4                  = beach[29];
            var how4                  = beach[30];
            
            var slug5                 = beach[31];
            var val5                  = beach[32];
            var how5                  = beach[33];
            
            var slug6                 = beach[34];
            var val6                  = beach[35];
            var how6                  = beach[36];
            
            var slug7                 = beach[37];
            var val7                  = beach[38];
            var how7                  = beach[39];
            
            var slug8                 = beach[40];
            var val8                  = beach[41];
            var how8                  = beach[42];
            
          
         } 
         
         createMarker (size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4, slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8,single_first_type_name, single_first_action_name)

        // found the property
        if(selected_id===id){
            found_id=i;
        }
       
       // createMarker (i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice )
    }//end for



    // pan to the latest pin for taxonmy and adv search  
    if(mapfunctions_vars.generated_pins!=='0'){
         myLatLng  = new google.maps.LatLng(lat, lng);
         pan_to_last_pin(myLatLng);
    }
}// end setMarkers


/////////////////////////////////////////////////////////////////////////////////////////////////
//  create marker
/////////////////////////////////////////////////////////////////////////////////////////////////  

function createMarker (size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,slug1,val1,how1,slug2,val2,how2,slug3,val3,how3,slug4,val4,how4,slug5, val5, how5, slug6, val6, how6 ,slug7 ,val7, how7, slug8, val8, how8, single_first_type_name, single_first_action_name ){

    var myLatLng = new google.maps.LatLng(lat,lng);
    if(mapfunctions_vars.custom_search==='yes'){
        
        var marker = new google.maps.Marker({
             position: myLatLng,
             map: map,
             icon: custompin(pin),
             shape: shape,
             title:decodeURIComponent(  title.replace(/\+/g,' ')),
             zIndex: counter,
             image:image,
             price:price,
             category:single_first_type,
             action:single_first_action,
             link:link,
             city:city,
             area:area,
             infoWindowIndex : i,
             rooms:rooms,
             baths:baths,
             size:size,
             cleanprice:cleanprice,
             size:size,
             category_name:single_first_type_name,
             action_name:single_first_action_name,
             slug1: slug1,
             val1: val1,
             howto1:how1,
             slug2:slug2,
             val2: val2,
             howto2:how2,
             slug3:slug3,
             val3: val3,
             howto3:how3,
             slug4:slug4,
             val4: val4,
             howto4:how4,
             slug5:slug5,
             val5: val5,
             howto5:how5,
             slug6:slug6,
             val6: val6,
             howto6:how7,
             slug7:slug7,
             val7: val7,
             howto7:how7,
             slug8:slug8,
             val8: val8,
             howto8:how8
            });
            
    }else{
         var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: custompin(pin),
                shape: shape,
                title: title,
                zIndex: counter,
                image:image,
                price:price,
                category:single_first_type,
                action:single_first_action,
                link:link,
                city:city,
                area:area,
                infoWindowIndex : i,
                rooms:rooms,
                baths:baths,
                cleanprice:cleanprice,
                size:size,
                category_name:single_first_type_name,
                action_name:single_first_action_name
               });
                  
    }

    gmarkers.push(marker);
       
    google.maps.event.addListener(marker, 'click', function(event) {
            
            new_open_close_map(1);

            if(this.image===''){
                 info_image='<img src="' + mapfunctions_vars.path + '/idxdefault.jpg" alt="image" />';
             }else{
                 info_image=this.image;
             }
            
            var category         =   decodeURIComponent ( this.category.replace(/-/g,' ') );
            var action           =   decodeURIComponent ( this.action.replace(/-/g,' ') );
            var category_name    =   decodeURIComponent ( this.category_name.replace(/-/g,' ') );
            var action_name      =   decodeURIComponent ( this.action_name.replace(/-/g,' ') );
            var in_type          =   mapfunctions_vars.in_text;
            if(category==='' || action===''){
                in_type=" ";
            }
            
           var infobaths; 
           if(this.baths!=''){
               infobaths ='<span id="infobath">'+this.baths+'</span>';
           }else{
               infobaths =''; 
           }
           
           var inforooms;
           if(this.rooms!=''){
               inforooms='<span id="inforoom">'+this.rooms+'</span>';
           }else{
               inforooms=''; 
           }
           
           var infosize;
           if(this.size!=''){
               infosize ='<span id="infosize">'+this.size;
               if(mapfunctions_vars.measure_sys==='ft'){
                   infosize = infosize+ ' ft<sup>2</sup>';
               }else{
                   infosize = infosize+' m<sup>2</sup>';
               }
               infosize =infosize+'</span>';
           }else{
               infosize=''; 
           }
        
            infoBox.setContent('<div class="info_details"><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span><a href="'+this.link+'">'+info_image+'</a><a href="'+this.link+'" id="infobox_title">'+this.title+'</a><div class="prop_detailsx">'+category_name+" "+in_type+" "+action_name+'</div><div class="prop_pricex">'+this.price+infosize+infobaths+inforooms+'</div></div>' );
  
            infoBox.open(map, this);    
            map.setCenter(this.position);   

            switch (infobox_width){
              case 700:
                 
                   if(mapfunctions_vars.listing_map === 'top'){
                        map.panBy(100,-150);
                   }else{
                        map.panBy(10,-110);
                   }
                 
                   vertical_off=0;
                   break;
              case 500: 
                   map.panBy(50,-120);
                   break;
              case 400: 
                   map.panBy(100,-220);
                   break;
              case 200: 
                   map.panBy(20,-170);
                   break;               
             }
            
            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                adv_search_click();
            }
            
             close_adv_search();
            });/////////////////////////////////// end event listener
            
if(mapfunctions_vars.generated_pins!=='0'){
    pan_to_last_pin(myLatLng);
}    
            
        
}

function  pan_to_last_pin(myLatLng){
       map.setCenter(myLatLng);   
}


/////////////////////////////////////////////////////////////////////////////////////////////////
//  map set search
/////////////////////////////////////////////////////////////////////////////////////////////////  

function set_google_search(map){
    var input,searchBox,places;
    
    input = (document.getElementById('google-default-search'));
 //   map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);
    searchBox = new google.maps.places.SearchBox(input);
    
   
    google.maps.event.addListener(searchBox, 'places_changed', function() {
    places = searchBox.getPlaces();
        
        if (places.length == 0) {
          return;
        }
        
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
          var image = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
          };

        // Create a marker for each place.
        var marker = new google.maps.Marker({
          map: map,
          icon: image,
          title: place.name,
          position: place.geometry.location
        });

        gmarkers.push(marker);

        bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
  });

  
    google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
    
}




/////////////////////////////////////////////////////////////////////////////////////////////////
//  open close map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function new_open_close_map(type){
    
    if( jQuery('#gmap_wrapper').hasClass('fullmap') ){
        return;
    }
    
    if(mapfunctions_vars.open_close_status !== '1'){ // we can resize map
        
        var current_height  =   jQuery('#googleMap').outerHeight();
        var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);
        var open_height     =   parseInt(mapfunctions_vars.open_height,10);
        var googleMap_h     =   open_height;
        var gmapWrapper_h   =   open_height;
          
        if( infoBox!== null){
            infoBox.close(); 
        }
     
        if ( current_height === closed_height )  {                       
            googleMap_h = open_height;                                
            if (Modernizr.mq('only all and (max-width: 940px)')) {
               gmapWrapper_h = open_height;
            } else {
                jQuery('#gmap-menu').show(); 
                gmapWrapper_h = open_height;
            }
        
            new_show_advanced_search();
            vertical_off=0;
            jQuery('#openmap').empty().append('<i class="fa fa-angle-up"></i>'+mapfunctions_vars.close_map);

        } else if(type===2) {
            jQuery('#gmap-menu').hide();
            jQuery('#advanced_search_map_form').hide();
            googleMap_h = gmapWrapper_h = closed_height;
           
            // hide_advanced_search();
            new_hide_advanced_search();
            vertical_off=150;           
        }

        jQuery('#googleMap').animate({'height': googleMap_h+'px'});
        jQuery('#gmap_wrapper').animate({'height': gmapWrapper_h+'px'},500,function(){
            google.maps.event.trigger(map, "resize");
            map.setOptions({'scrollwheel': true});
            jQuery('#googleMap').addClass('scrollon');
            jQuery('.tooltip').fadeOut("fast");
        });

    }
}





/////////////////////////////////////////////////////////////////////////////////////////////////
//  build map cluter
/////////////////////////////////////////////////////////////////////////////////////////////////   
  function map_cluster(){
       if(mapfunctions_vars.user_cluster==='yes'){
        clusterStyles = [
            {
            textColor: '#ffffff',    
            opt_textColor: '#ffffff',
            url: mapfunctions_vars.path+'/cloud.png',
            height: 72,
            width: 72,
            textSize:15,
           
            }
        ];
        mcOptions = {gridSize: 50,
                    ignoreHidden:true, 
                    maxZoom: mapfunctions_vars.zoom_cluster, 
                    styles: clusterStyles
                };
        mcluster = new MarkerClusterer(map, gmarkers, mcOptions);
        mcluster.setIgnoreHidden(true);
    }
   
  }  
    
    
      
/////////////////////////////////////////////////////////////////////////////////////////////////
/// zoom
/////////////////////////////////////////////////////////////////////////////////////////////////
  
    
if(  document.getElementById('gmapzoomplus') ){
     google.maps.event.addDomListener(document.getElementById('gmapzoomplus'), 'click', function () {      
       var current= parseInt( map.getZoom(),10);
       current++;
       if(current>20){
           current=20;
       }
       map.setZoom(current);
    });  
}
    
    
if(  document.getElementById('gmapzoomminus') ){
     google.maps.event.addDomListener(document.getElementById('gmapzoomminus'), 'click', function () {      
       var current= parseInt( map.getZoom(),10);
       current--;
       if(current<0){
           current=0;
       }
       map.setZoom(current);
    });  
}
        
    
    
/////////////////////////////////////////////////////////////////////////////////////////////////
/// geolocation
/////////////////////////////////////////////////////////////////////////////////////////////////

if(  document.getElementById('geolocation-button') ){
    google.maps.event.addDomListener(document.getElementById('geolocation-button'), 'click', function () {      
         myposition(map);
         close_adv_search();
    });  
}


if(  document.getElementById('mobile-geolocation-button') ){
    google.maps.event.addDomListener(document.getElementById('mobile-geolocation-button'), 'click', function () {   
         myposition(map);
         close_adv_search();
    });  
}


jQuery('#mobile-geolocation-button,#geolocation-button').click(function(){   
     myposition(map);
})



function myposition(map){    
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showMyPosition,errorCallback,{timeout:10000});
    }
    else
    {
        alert(mapfunctions_vars.geo_no_brow);
    }
}


function errorCallback(){
    alert(mapfunctions_vars.geo_no_pos);
}





function showMyPosition(pos){
   
    var shape = {
       coord: [1, 1, 1, 38, 38, 59, 59 , 1],
       type: 'poly'
   }; 
   
   var MyPoint=  new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude);
   map.setCenter(MyPoint);   
   
   var marker = new google.maps.Marker({
             position: MyPoint,
             map: map,
             icon: custompinchild(),
             shape: shape,
             title: '',
             zIndex: 999999999,
             image:'',
             price:'',
             category:'',
             action:'',
             link:'' ,
             infoWindowIndex : 99 ,
             radius: parseInt(mapfunctions_vars.geolocation_radius,10)+' '+mapfunctions_vars.geo_message
            });
    
     var populationOptions = {
      strokeColor: '#67cfd8',
      strokeOpacity: 0.6,
      strokeWeight: 1,
      fillColor: '#67cfd8',
      fillOpacity: 0.2,
      map: map,
      center: MyPoint,
      radius: parseInt(mapfunctions_vars.geolocation_radius,10)
    };
    var cityCircle = new google.maps.Circle(populationOptions);
    
        var label = new Label({
          map: map
        });
        label.bindTo('position', marker);
        label.bindTo('text', marker, 'radius');
        label.bindTo('visible', marker);
        label.bindTo('clickable', marker);
        label.bindTo('zIndex', marker);

}
    
    
    
function custompinchild(){
    "use strict";
    var custom_img;
    if(images['userpin']===''){
        custom_img= mapfunctions_vars.path+'/'+'userpin'+'.png';     
    }else{
        custom_img=images['userpin'];
    }
   
 var   image = {
      url: custom_img, 
      size: new google.maps.Size(59, 59),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(16,59 )
    };
    return image;
  
}



// same thing as above but with ipad double click workaroud solutin
jQuery('#googleMap').click(function(event){
    var time_diff; 
    time_diff=event.timeStamp-ipad_time;
    
    if(time_diff>300){
       // alert(event.timeStamp-ipad_time);
        ipad_time=event.timeStamp;
        if(map.scrollwheel===false){
            map.setOptions({'scrollwheel': true});
            jQuery('#googleMap').addClass('scrollon');
        }else{
            map.setOptions({'scrollwheel': false});
             jQuery('#googleMap').removeClass('scrollon');
        }
        jQuery('.tooltip').fadeOut("fast"); 


        if (Modernizr.mq('only all and (max-width: 1025px)')) {    
           if(map.draggable === false){
                 map.setOptions({'draggable': true});
            }else{
                 map.setOptions({'draggable': false});
            }    
         }
         
     }     
});









/////////////////////////////////////////////////////////////////////////////////////////////////
/// 
/////////////////////////////////////////////////////////////////////////////////////////////////

if( document.getElementById('gmap') ){
    google.maps.event.addDomListener(document.getElementById('gmap'), 'mouseout', function () {           
        map.setOptions({'scrollwheel': true});
        google.maps.event.trigger(map, "resize");
    });  
}     


if(  document.getElementById('search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('search_map_button'), 'click', function () {  
        infoBox.close();
    });  
}



if(  document.getElementById('advanced_search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('advanced_search_map_button'), 'click', function () {  
       infoBox.close();
    }); 
}
 
////////////////////////////////////////////////////////////////////////////////////////////////
/// navigate troguh pins 
///////////////////////////////////////////////////////////////////////////////////////////////

jQuery('#gmap-next').click(function(){
    current_place++;  
    if (current_place>gmarkers.length){
        current_place=1;
    }
    while(gmarkers[current_place-1].visible===false){
        current_place++; 
        if (current_place>gmarkers.length){
            current_place=1;
        }
    }
    
    if( map.getZoom() <15 ){
        map.setZoom(15);
    }
    google.maps.event.trigger(gmarkers[current_place-1], 'click');
});


jQuery('#gmap-prev').click(function(){
    current_place--;
    if (current_place<1){
        current_place=gmarkers.length;
    }
    while(gmarkers[current_place-1].visible===false){
        current_place--; 
        if (current_place>gmarkers.length){
            current_place=1;
        }
    }
    if( map.getZoom() <15 ){
        map.setZoom(15);
    }
    google.maps.event.trigger(gmarkers[current_place-1], 'click');
});








///////////////////////////////////////////////////////////////////////////////////////////////////////////
/// filter pins 
//////////////////////////////////////////////////////////////////////////////////////////////////////////

jQuery('.advanced_action_div li').click(function(){
   var action = jQuery(this).val();
   //alert ('action: '+action);

});





if(  document.getElementById('gmap-menu') ){
    google.maps.event.addDomListener(document.getElementById('gmap-menu'), 'click', function (event) {
        infoBox.close();

        if (event.target.nodeName==='INPUT'){
            category=event.target.className; 

                if(event.target.name==="filter_action[]"){            
                    if(actions.indexOf(category)!==-1){
                        actions.splice(actions.indexOf(category),1);
                    }else{
                        actions.push(category);
                    }
                }

                if(event.target.name==="filter_type[]"){            
                    if(categories.indexOf(category)!==-1){
                        categories.splice(categories.indexOf(category),1);
                    }else{
                        categories.push(category);
                    }
                }

          show(actions,categories);
        }

    }); 
}
  
function visible_or_not(how, slug, value, read){

    if(value!=='' && typeof(value)!=='undefined' ){
        value = value.replace('%',''); 
    }
    if(slug!=='' && typeof(slug)!=='undefined'){
        slug = slug.replace('%',''); 
    }

    // console.log("how: "+how+"  slug: "+slug+" value: "+value+ "  read: "+read)

    if(read==='none'){
        return true;
    }
    if (value !=='' && value !==' ' && value !=='all' ){
       
        var parsevalue = parseInt(value, 10);
        
        if( how === 'greater' ){
            if( slug >=  parsevalue){
               return true
            }else{
               return false;
            }
        } else if( how === 'smaller' ){
         
            slug=parseInt(slug, 10);
            if( slug <= parsevalue ){
               return true;
             
            } else{
                return false;
            }
        } else if( how === 'equal' ){
            if( slug === value || value == 'all' ){
               return true;
            } else{
                return false;
            }
        } else if( how === 'like' ){
            slug = slug.toLowerCase();
            value = value.toLowerCase();
            if(slug.indexOf(value)> -1 ){
                return true;
            } else{
                return false;
            }
        } else if( how === 'date bigger' ){
            
            slug    =   new Date(slug);
            value   =   new Date(value);
            
            if( slug >= value ){
                return true;
            } else{
                return false;
            }
        } else if( how === 'date smaller' ){
            slug    =   new Date(slug);
            value   =   new Date(value);
            
            if( slug <= value ){
                return true;
            } else{
                return false;
            }
        }

        //return false;
    }else{
        return true;
    }
        
}


function get_custom_value(slug){
    var value;
  
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area' ){
        value = jQuery('#'+slug).attr('data-value');
    } else{
        value = jQuery('#'+slug).val() ;
    }
    
    return value;
}
  
  
function show_pins_custom_search(){
    var val1, val2, val3, val4, val5, val6, val7, val8;
    val1 =  get_custom_value (mapfunctions_vars.slugs[0]);
    val2 =  get_custom_value (mapfunctions_vars.slugs[1]);
    val3 =  get_custom_value (mapfunctions_vars.slugs[2]);
    val4 =  get_custom_value (mapfunctions_vars.slugs[3]);
    val5 =  get_custom_value (mapfunctions_vars.slugs[4]);
    val6 =  get_custom_value (mapfunctions_vars.slugs[5]);
    val7 =  get_custom_value (mapfunctions_vars.slugs[6]);
    val8 =  get_custom_value (mapfunctions_vars.slugs[7]);
   
   
   if(typeof(val1)==='undefined'){
       val1='';
   }
   if(typeof(val2)==='undefined'){
       val2='';
   }
   if(typeof(val3)==='undefined'){
       val3='';
   }
   if(typeof(val4)==='undefined'){
       val4='';
   }
   if(typeof(val5)==='undefined'){
       val5='';
   }
   if(typeof(val6)==='undefined'){
       val6='';
   }
   if(typeof(val7)==='undefined'){
       val7='';
   }
   if(typeof(val8)==='undefined'){
       val8='';
   }
 
   
   // console.log ( " val1: "+val1+" val2: "+val2+" val3: "+val3+" val4: "+val4+" val5: "+val5+" val6: "+val6+" val7: "+val7+" val8: "+val8 );
   // val1: rentals val2: all val3: all val4: all val5:  val6:  val7:  val8: 
   
   
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
    
    var results_no  =   0;    
    var bounds = new google.maps.LatLngBounds();
      mcluster.setIgnoreHidden(true);
    if(  typeof gmarkers!=='undefined'){
        for (var i=0; i<gmarkers.length; i++) {  
            
                if ( !visible_or_not(mapfunctions_vars.hows[0], gmarkers[i].val1, val1, mapfunctions_vars.slugs[0]) ){
                    gmarkers[i].setVisible(false);  
                } else if ( !visible_or_not(mapfunctions_vars.hows[1],gmarkers[i].val2, val2, mapfunctions_vars.slugs[1]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[2],gmarkers[i].val3, val3, mapfunctions_vars.slugs[2]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[3],gmarkers[i].val4, val4, mapfunctions_vars.slugs[3]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[4],gmarkers[i].val5, val5, mapfunctions_vars.slugs[4]) ){
                     gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[5],gmarkers[i].val6, val6, mapfunctions_vars.slugs[5]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[6],gmarkers[i].val7, val7, mapfunctions_vars.slugs[6]) ){
                    gmarkers[i].setVisible(false);
                } else if ( !visible_or_not(mapfunctions_vars.hows[7],gmarkers[i].val8, val8, mapfunctions_vars.slugs[7]) ){
                    gmarkers[i].setVisible(false);
                } else{
                    gmarkers[i].setVisible(true);
                    results_no++;
                  
                    bounds.extend( gmarkers[i].getPosition() );           
                }
                
         }//end for   
            mcluster.repaint();        
    }//end if

    if(mapfunctions_vars.generated_pins==='0'){
        if(results_no===0){
            jQuery('#gmap-noresult').show();
            jQuery('#results').hide();
        }else{
            jQuery('#gmap-noresult').hide(); 
            if( !bounds.isEmpty() ){
                map.fitBounds(bounds);
            } 
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(results_no); 
        }
     
                
    }else{
      custom_get_filtering_ajax_result(); 
    }
}  
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
function show_pins() {
    "use strict";
     if(mapfunctions_vars.custom_search==='yes'){
       show_pins_custom_search();
       return;
    }    
    
    
    var results_no  =   0;
    var action      =   jQuery('#adv_actions').attr('data-value');
    var category    =   jQuery('#adv_categ').attr('data-value');
    var city        =   jQuery('#advanced_city').attr('data-value');
    var area        =   jQuery('#advanced_area').attr('data-value');   
    var rooms       =   parseInt( jQuery('#adv_rooms').val(),10 );
    var baths       =   parseInt( jQuery('#adv_bath').val(),10 );
    var min_price   =   parseInt( jQuery('#price_low').val() );
    var price_max   =   parseInt( jQuery('#price_max').val() );
       
    
    if(isNaN(rooms)){
        rooms=0;
    }
    
    if(isNaN(baths)){
        baths=0;
    }
    
     if(isNaN(min_price)){
        min_price=0;
    }
    
     if(isNaN(price_max)){
        price_max=0;
    }
     
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }
        
    var bounds = new google.maps.LatLngBounds();
      mcluster.setIgnoreHidden(true);
    if(  typeof gmarkers!=='undefined'){
   
        for (var i=0; i<gmarkers.length; i++) {
                if(gmarkers[i].action !== action && action!='all' ){
                    gmarkers[i].setVisible(false);        
                }else if ( gmarkers[i].category !== category && category!='all' ) {   
                    gmarkers[i].setVisible(false);
                }else if( gmarkers[i].area !== area && area!='all'  ){
                    gmarkers[i].setVisible(false);
                }else if( gmarkers[i].city !== city  && city!='all'){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].rooms,10) !== rooms  && rooms!==0){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].baths,10 ) !== baths  && baths!==0){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].cleanprice,10 ) < min_price  && min_price!==0){
                    gmarkers[i].setVisible(false);
                }else if( parseInt(gmarkers[i].cleanprice,10 ) > price_max  && price_max!==0){
                     gmarkers[i].setVisible(false);
                }else{
                    gmarkers[i].setVisible(true);
                    results_no++;
                    bounds.extend( gmarkers[i].getPosition() );       
                }                    
        }//end for
       mcluster.repaint();
    }//end if
       
    if(mapfunctions_vars.generated_pins==='0'){
        if(results_no===0){
            jQuery('#gmap-noresult').show();
            jQuery('#results').hide();
        }else{
            jQuery('#gmap-noresult').hide(); 
            if( !bounds.isEmpty() ){
                map.fitBounds(bounds);
            } 
            jQuery("#results, #showinpage,#showinpage_mobile").show();
            jQuery("#results_no").show().empty().append(results_no); 
        }
        
                
    }else{
        get_filtering_ajax_result();  
    }      
}
 

/////////////////////////////////////////////////////////////////////////////////////////////////
/// get pin image
/////////////////////////////////////////////////////////////////////////////////////////////////
function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}


function custompin(image){
    "use strict";    
 
  
    var custom_img;
 
    if(image!==''){
        if(images[image]===''){
            custom_img= mapfunctions_vars.path+'/'+image+'.png';     
        }else{
            custom_img=images[image];
        }
    }else{
         custom_img= mapfunctions_vars.path+'/none.png';   
    }

    if(typeof (custom_img)=== 'undefined'){
        custom_img= mapfunctions_vars.path+'/none.png'; 
    }
   
    image = {
      url: custom_img, 
      size: new google.maps.Size(59, 59),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(16,59 )
    };
    return image;
}



function custompin2(image){
    "use strict";
   
    image = {
      url: mapfunctions_vars.path+'/'+image+'.png',  
      size: new google.maps.Size(59, 59),
      origin: new google.maps.Point(0,0),
      anchor: new google.maps.Point(16,59 )
    };
    return image;
}







/////////////////////////////////////////////////////////////////////////////////////////////////
//// Circle label
/////////////////////////////////////////////////////////////////////////////////////////////////

function Label(opt_options) {
  // Initialization
  this.setValues(opt_options);


  // Label specific
  var span = this.span_ = document.createElement('span');
  span.style.cssText = 'position: relative; left: -50%; top: 8px; ' +
  'white-space: nowrap;  ' +
  'padding: 2px; background-color: white;opacity:0.7';


  var div = this.div_ = document.createElement('div');
  div.appendChild(span);
  div.style.cssText = 'position: absolute; display: none';
};
Label.prototype = new google.maps.OverlayView;


// Implement onAdd
Label.prototype.onAdd = function() {
  var pane = this.getPanes().overlayImage;
  pane.appendChild(this.div_);


  // Ensures the label is redrawn if the text or position is changed.
  var me = this;
  this.listeners_ = [
    google.maps.event.addListener(this, 'position_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'visible_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'clickable_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'text_changed', function() { me.draw(); }),
    google.maps.event.addListener(this, 'zindex_changed', function() { me.draw(); }),
    google.maps.event.addDomListener(this.div_, 'click', function() { 
      if (me.get('clickable')) {
        google.maps.event.trigger(me, 'click');
      }
    })
  ];
};


// Implement onRemove
Label.prototype.onRemove = function() {
  this.div_.parentNode.removeChild(this.div_);


  // Label is removed from the map, stop updating its position/text.
  for (var i = 0, I = this.listeners_.length; i < I; ++i) {
    google.maps.event.removeListener(this.listeners_[i]);
  }
};


// Implement draw
Label.prototype.draw = function() {
  var projection = this.getProjection();
  var position = projection.fromLatLngToDivPixel(this.get('position'));


  var div = this.div_;
  div.style.left = position.x + 'px';
  div.style.top = position.y + 'px';


  var visible = this.get('visible');
  div.style.display = visible ? 'block' : 'none';


  var clickable = this.get('clickable');
  this.span_.style.cursor = clickable ? 'pointer' : '';


  var zIndex = this.get('zIndex');
  div.style.zIndex = zIndex;


  this.span_.innerHTML = this.get('text').toString();
};



/////////////////////////////////////////////////////////////////////////////////////////////////
/// close advanced search
/////////////////////////////////////////////////////////////////////////////////////////////////
function close_adv_search(){
    
}
/*

function close_adv_search(){
    // for advanced search 2
    
    if (!Modernizr.mq('only all and (max-width: 960px)')) {
        if(mapfunctions_vars.adv_search === '2' || mapfunctions_vars.adv_search === 2 ){
            adv_search2=0;
            jQuery('#adv-search-2').fadeOut(50,function(){
                jQuery('#search_wrapper').animate({
                    top:112+"px"
                    },200);             
            });        
            jQuery(this).removeClass('adv2_close');
        }
        
        // for advanced search 2           
        if(mapfunctions_vars.adv_search === '4' || mapfunctions_vars.adv_search === 4){
            adv_search4=0;
            jQuery('#adv-search-4').fadeOut(50,function(){
                    jQuery('#search_wrapper').animate({
                        top:112+"px"
                        },200);
                 });  
            jQuery(this).addClass('adv4_close');
        }
   }
}
*/

//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////


function new_show_advanced_search(){
    jQuery("#search_wrapper").removeClass("hidden");
}

function new_hide_advanced_search(){
    if( mapfunctions_vars.show_adv_search ==='no' ){
        jQuery("#search_wrapper").addClass("hidden"); 
    }

}



/*
function show_advanced_search(closer){
    if (!Modernizr.mq('only all and (max-width: 960px)')) {
         jQuery('#search_map_button,#advanced_search_map_button').show();
         jQuery('#adv-contact-3,#adv-search-header-contact-3,#adv-search-header-3,#adv-search-3').show();
    }
   

    if(closer==='close'){
         close_adv_search();
         if (!Modernizr.mq('only all and (max-width: 960px)')) {
            if(mapfunctions_vars.adv_search === '4' ){
               jQuery('#adv-search-header-4').show();
               jQuery('#adv-search-4').css({display:'none'});
               jQuery('#search_wrapper') .css({top:'112px'});
            }
            if(mapfunctions_vars.adv_search === '2'){            
               jQuery('#adv-search-header-2').show();
               jQuery('#adv-search-2').css({display:'none'});
               jQuery('#search_wrapper') .css({top:'112px'});
       
            }
         }
        
         
         
    }else{
          jQuery('#adv-search-header-4,#adv-search-4').show();
          jQuery('#adv-search-header-2,#adv-search-2').show();
          jQuery('#search_wrapper') .css({top:'200px'});
    }
    
    
    
    
    jQuery('#openmap').addClass('mapopen');
}


//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////

function hide_advanced_search(){
    jQuery('#search_map_button,#search_map_form, #advanced_search_map_button,#advanced_search_map_form').hide();
    jQuery('#adv-search-header-4,#adv-search-4').hide();
    jQuery('#adv-contact-3,#adv-search-header-contact-3,#adv-search-header-3,#adv-search-3').hide();
    jQuery('#adv-search-header-2,#adv-search-2').hide();
     jQuery('#advanced_search_map_form').hide();
   jQuery('#openmap').removeClass('mapopen');
}

*/