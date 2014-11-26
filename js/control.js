/*global $, jQuery, ajaxcalls_vars, document, control_vars, window*/

jQuery(window).scroll(function ($) {
    "use strict";
    var scroll = jQuery(window).scrollTop();
    if (scroll >= 100) {
        if (!Modernizr.mq('only all and (max-width: 1025px)')) {
            jQuery('.logo').addClass('miclogo');
           jQuery(".header_wrapper").addClass("navbar-fixed-top");
           jQuery(".header_wrapper").addClass("customnav");
           jQuery('.contact-box').addClass('islive');
           jQuery('.backtop').addClass('islive');
           jQuery('.barlogo').show();
           jQuery('#user_menu_open').hide();
           
        }
    } else {
        jQuery(".header_wrapper").removeClass("navbar-fixed-top");
        jQuery(".header_wrapper").removeClass("customnav");
        jQuery('.contact-box ').removeClass('islive');
        jQuery('.backtop').removeClass('islive');
        jQuery('.contactformwrapper').addClass('hidden');
        jQuery('.barlogo').hide();
        jQuery('#user_menu_open').hide();
        jQuery('.logo').removeClass('miclogo');
    }
});


jQuery(window).resize(function() {
    "use strict";    
     jQuery('#mobile_menu').hide('10');
});





jQuery(document).ready(function ($) {
    "use strict";
    
    
    $('#adv_extended_options_text_adv ').click(function(){
        $('.adv-search-1.adv_extended_class').css('height','auto');
        $('.adv_extended_class .adv1-holder').css('height','auto');
        $(this).parent().find('.adv_extended_options_text').hide();
        $(this).parent().find('.extended_search_check_wrapper').slideDown();
        $(this).parent().find('#adv_extended_close_adv').show();
    });
    
    $('#adv_extended_close_adv').click(function(){
        $(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        $(this).hide();
        $(this).parent().parent().find('.adv_extended_options_text').show();
        $('.adv-search-1.adv_extended_class').removeAttr('style');
        $('.adv_extended_class .adv1-holder').removeAttr('style');
    });
    
    
    //////////////////////////////////////////////////////////////
    
    $('#adv_extended_options_text_widget').click(function(){
      
        $(this).parent().find('.adv_extended_options_text').hide();
        $(this).parent().find('.extended_search_check_wrapper').slideDown();
        $(this).parent().find('#adv_extended_close_widget').show();
    });
    
    $('#adv_extended_close_widget').click(function(){
        $(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        $(this).hide();
        $(this).parent().parent().find('.adv_extended_options_text').show();
    });
    
    ////////////////////////////////////////////////////////////////////////////////
       $('#adv_extended_options_text_short').click(function(){     
        $(this).parent().find('.adv_extended_options_text').hide();
        $(this).parent().find('.extended_search_check_wrapper').slideDown();
        $(this).parent().find('#adv_extended_close_short').show();
    });
    
    $('#adv_extended_close_short').click(function(){
        $(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        $(this).hide();
        $(this).parent().parent().find('.adv_extended_options_text').show();
    });
    
    
    /////////////////////////////////////////////////////////////////////////////////////
    $('#adv_extended_options_text_mobile').click(function(){      
        $(this).parent().find('.adv_extended_options_text').hide();
        $(this).parent().find('.extended_search_check_wrapper').slideDown();
        $(this).parent().find('#adv_extended_close_mobile').show();
    });
    
    $('#adv_extended_close_mobile').click(function(){
        $(this).parent().parent().find('.extended_search_check_wrapper').slideUp();
        $(this).hide();
        $(this).parent().parent().find('.adv_extended_options_text').show();
    });
    /////////////////////////////////////////////////////////////////////////////////////////
    
    
    
    $('.slider_control_left').click(function(){
        var step_size,margin_left,new_value,last_element,base_value;
        step_size   =   $('.shortcode_slider_list').width();
        margin_left =   parseInt(jQuery('.shortcode_slider_list').css('margin-left'), 10);
        //new_value   =   margin_left+step_size+90;
        new_value   =   margin_left-285;
        base_value  =   -15;
        $('.shortcode_slider_list').css('margin-left',new_value+'px');
        last_element = $('.shortcode_slider_list li:last-child');
        $('.shortcode_slider_list li:last-child').remove();
        $('.shortcode_slider_list').prepend(last_element);
        
        
        $('.shortcode_slider_list').animate({
            'margin-left':base_value
        },800, function() {
           
        });
       
    });
        
   
    $('.slider_control_right').click(function(){
        var step_size,margin_left,new_value, first_element;
        step_size   =   $('.shortcode_slider_list').width();
        margin_left =   parseInt(jQuery('.shortcode_slider_list').css('margin-left'), 10);
        //new_value   =   margin_left-step_size-90;
        new_value   =   margin_left-285;
       
        $('.shortcode_slider_list').animate({
            'margin-left':new_value
        },800, function() {
            first_element = $('.shortcode_slider_list li:nth-child(1)');
            $('.shortcode_slider_list li:nth-child(1)').remove();
            $('.shortcode_slider_list').append(first_element);
            $('.shortcode_slider_list').css('margin-left',-15+'px');
        });
        
        
    });
        
   
    
    
    
    
    
    
    $('#login_user_topbar,#login_pwd_topbar').on('focus', function(e) {
       $('#user_menu_open').addClass('iosfixed');
    });
     
     
     
    $('#estate-carousel .slider-content h3 a,#estate-carousel .slider-content .read_more ').click(function(){
      var new_link;
      new_link =  $(this).attr('href');
      window.open (new_link,'_self',false)
    });
     
     
    ////////////////////////////////////////////////////////////////////////////////////////////
    ///city-area-selection
    ///////////////////////////////////////////////////////////////////////////////////////////
     $('#filter_city li').click(function(event){
        event.preventDefault();
        var pick, value_city, parent, selected_city, is_city, area_value;
        value_city   = String( $(this).attr('data-value') ).toLowerCase();       
        $('#filter_area li').each(function(){
            is_city = String ( $(this).attr('data-parentcity') ).toLowerCase();
            is_city = is_city.replace(" ","-");
           
            area_value   = String ( $(this).attr('data-value') ).toLowerCase();    
            if(is_city === value_city || value_city === 'all' ){
                $(this).show();
            }else{
                $(this).hide();
            }
             
        });
    
    });
        
        
        
    $('#sidebar_filter_city li').click(function(event){
        event.preventDefault();
        var pick, value_city, parent, selected_city, is_city, area_value;
        value_city   = String( $(this).attr('data-value2') ).toLowerCase();
        
        $('#sidebar_filter_area li').each(function(){
            is_city = String ( $(this).attr('data-parentcity') ).toLowerCase();
            is_city = is_city.replace(" ","-");
           
            area_value   = String ( $(this).attr('data-value') ).toLowerCase();    
            if(is_city === value_city || value_city === 'all' ){
                $(this).show();
            }else{
                $(this).hide();
            }
             
        });
    
    });
        

     $('#adv-search-city li').click(function(event){
        event.preventDefault();
        var pick, value_city, parent, selected_city, is_city, area_value;
        value_city   = String( $(this).attr('data-value2') ).toLowerCase();     

        $('#adv-search-area li').each(function(){
            is_city      = String ( $(this).attr('data-parentcity') ).toLowerCase();
            is_city      = is_city.replace(" ","-");
            area_value   = String ( $(this).attr('data-value') ).toLowerCase(); 
         
            if(is_city === value_city || value_city === 'all' ){
                $(this).show();
            }else{
                $(this).hide();
            }
             
        });
    
    });
    
    var all_browsers_stuff;
    
    $('#property_city_submit').change(function(){
        var city_value, area_value;
        city_value=$(this).val();
    
        all_browsers_stuff=$('#property_area_submit_hidden').html();
        $('#property_area_submit').empty().append(all_browsers_stuff);
        $('#property_area_submit option').each(function(){
            area_value=$(this).attr('data-parentcity');
         
            if( city_value ===area_value || area_value==='all'){
              //  $(this).show();        
            }else{
                //$(this).hide();
                 $(this).remove();
            }
        });
    })
    
    
    
        
    
   
     $('#adv_short_select_city li').click(function(event){
        event.preventDefault();
        var pick, value_city, parent, selected_city, is_city, area_value;
        value_city   = String( $(this).attr('data-value2') ).toLowerCase();     
        $('#adv_short_select_area li').each(function(){
            is_city = String ( $(this).attr('data-parentcity') ).toLowerCase();
            is_city = is_city.replace(" ","-");
            area_value   = String ( $(this).attr('data-value') ).toLowerCase();    
            if(is_city === value_city || value_city === 'all' ){
                $(this).show();
            }else{
                $(this).hide();
            }
             
        });
    
    });
        
    $('#mobile-adv-city li').click(function(event){
        event.preventDefault();
        var pick, value_city, parent, selected_city, is_city, area_value;
        value_city   = String( $(this).attr('data-value2') ).toLowerCase();     
    
        $('#mobile-adv-area li').each(function(){
            is_city = String ( $(this).attr('data-parentcity') ).toLowerCase();
            is_city = is_city.replace(" ","-");
            area_value   = String ( $(this).attr('data-value') ).toLowerCase();    
            if(is_city === value_city || value_city ==='all' ){
                $(this).show();
            }else{
                $(this).hide();
            }

        });
    
    });
       
        
    ////////////////////////////////////////////////////////////////////////////////////////////
    ///mobile
    ///////////////////////////////////////////////////////////////////////////////////////////


    $('#adv-search-header-mobile').click(function(){
        $('#adv-search-mobile').toggle('300');
    });


    ////////////////////////////////////////////////////////////////////////////////////////////
    ///navigational links
    ///////////////////////////////////////////////////////////////////////////////////////////

    $('.navigational_links ,.nav-next-wrapper').click(function(){
        var link = $(this).find('a').attr('href');
        window.open (link,'_self',false)
    })

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// featured agent
    ///////////////////////////////////////////////////////////////////////////////////////////
  
  
  
    $('.featured_agent_details_wrapper, .agent-listing-img-wrapper').click(function(){
        var newl= $( this ).attr('data-link');
        window.open (newl,'_self',false)
    });  
    
    $('.see_my_list_featured').click(function(event){
            event.stopPropagation();
    });
  
    ////////////////////////////////////////////////////////////////////////////////////////////
    /// featuerd property
    ///////////////////////////////////////////////////////////////////////////////////////////

    $( '.agent_face' ).hover(
        function() {
            $(this).find('.agent_face_details').fadeIn('500')
        }, function() {
            $(this).find('.agent_face_details').fadeOut('500')
        }
    );
        
    ////////////////////////////////////////////////////////////////////////////////////////////
    /// listings unit navigation
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.property_listing, .agent_unit, .blog_unit').click(function(){
        var link;
        link = $(this).attr('data-link'); 
        window.open(link, '_self');
    });


    $('.related_blog_unit_image').click(function(){
         var link;
        link = $(this).attr('data-related-link'); 
        window.open(link, '_self');
    });

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// user menu
    ///////////////////////////////////////////////////////////////////////////////////////////

    $('#user_menu_u').click(function(event){
        
        if( $('#user_menu_open').is(":visible")){
         
             $('#user_menu_open').removeClass('iosfixed').fadeOut(400); 
        }else{
             $('#user_menu_open').fadeIn(400); 
        }     
        event.stopPropagation();
    });
    

    $(document).click(function(event) {
        var clicka=event.target.id;   
        if( clicka!='login_user_topbar' && clicka!='login_pwd_topbar' && clicka!='user_email_register_topbar' && clicka!='user_login_register_topbar' && clicka!='login_message_area_topbar' && clicka!=='widget_register_topbar' && clicka!=='widget_login_topbar' && clicka!=='wp-login-but-topbar' && clicka!=='facebookloginsidebar_topbar' && clicka!=='googleloginsidebar_topbar'  && clicka!=='yahoologinsidebar_topbar' && clicka!=='wp-submit-register_topbar' ){
           $('#user_menu_open').removeClass('iosfixed').hide(400); 
        } 
        
    });
  
      
    ////////////////////////////////////////////////////////////////////////////////////////////
    /// new controls for upload pictures
    ///////////////////////////////////////////////////////////////////////////////////////////

    jQuery('#imagelist i').click(function(){
          var curent='';  
          jQuery(this).parent().remove();

          jQuery('#imagelist .uploaded_images').each(function(){
             curent=curent+','+jQuery(this).attr('data-imageid'); 
          });
          jQuery('#attachid').val(curent); 

      });

    jQuery('#imagelist img').click(function(){

        jQuery('#imagelist .uploaded_images .thumber').each(function(){
            jQuery(this).remove();
        });

        jQuery(this).parent().append('<i class="fa thumber fa-star"></i>')
        jQuery('#attachthumb').val(   jQuery(this).parent().attr('data-imageid') );
    });   

    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// advanced search widget
    ////////////////////////////////////////////////////////////////////////////////////////////    
    
    $('.advanced_search_sidebar li').click(function (event) {
        event.preventDefault();
        var pick, value, parent;
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();  
        parent.find('.sidebar_filter_menu').text(pick).append('<span class="caret caret_sidebar"></span>').attr('data-value', value);
        parent.find('input').val(value);    
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// mobile search 
    ////////////////////////////////////////////////////////////////////////////////////////////    
    
    $('.adv-search-mobile li').click(function () {
        event.preventDefault();
        var pick, value, parent;
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();  
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value', value);
        parent.find('input').val(value);    
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// generate mobile menu
    ////////////////////////////////////////////////////////////////////////////////////////////    
    
    var build_menu ='<div id="mobile_display"> <span>Menu ...</span> <i class="fa fa-bars"></i></div> <ul id="mobile_menu">';
    $('#access a').each(function() {
       var el = $(this);


       if ($(el).parents('.sub-menu .sub-menu').length >= 1) {
           build_menu=build_menu+"<li class=\"second_level\"><a href="+ el.attr('href')+">-- "+ el.text()+"</a></li>";
       }
       else if ($(el).parents('.sub-menu').length >= 1) {
            build_menu=build_menu+"<li class=\"first_level\"><a href="+ el.attr('href')+">- "+ el.text()+"</a></li>";
       }
       else {
            build_menu=build_menu+"<li><a href="+ el.attr('href')+">"+ el.text()+"</a></li>";
       }

    });
    build_menu =build_menu+"</ul>";
    $('.master_header').append(build_menu);

    $('#mobile_display').click(function(){
        $('#mobile_menu').toggle('400'); 
    });
  
     $('#mobile_menu li').click(function(event){
        event.preventDefault(); 
       var new_location=$(this).find('a').attr('href');
       window.open(new_location, '_self');
    });
    
   
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// 
    ////////////////////////////////////////////////////////////////////////////////////////////    
    
    
    
    $('#switch').click(function () {
        $('.main_wrapper').toggleClass('wide');
    });


    $('#accordion_prop_addr, #accordion_prop_details, #accordion_prop_features, #accordion_prop_temporada').on('shown.bs.collapse', function () {
        $(this).find('h4').removeClass('carusel_closed');
    })
    
    $('#accordion_prop_addr, #accordion_prop_details, #accordion_prop_features, #accordion_prop_temporada').on('hidden.bs.collapse', function () {
        $(this).find('h4').addClass('carusel_closed');
    })
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// advanced search filters
    ////////////////////////////////////////////////////////////////////////////////////////////    
    $('#adv-search-1 li,#advanced_search_shortcode li').click(function () {
        var pick, value, parent;
        pick = $(this).text();
        value = $(this).attr('data-value');
        parent = $(this).parent().parent();
        parent.find('.filter_menu_trigger').text(pick).append('<span class="caret caret_filter"></span>').attr('data-value', value);
        parent.find('input').val(value);
    });

    jQuery('#adv-search-1 li').click(function () {
        show_pins();
    });

    jQuery('#adv_rooms,#adv_bath,#price_low,#price_max').change(function () {
        show_pins();
    });

    jQuery('#adv-search-1 input[type=text]').change(function () {
        show_pins();
    });
    
    $('#showinpage,#showinpage_mobile').click(function (event) {
        
        event.preventDefault();
        if( $('#gmap-full').hasClass('spanselected')){
            $('#gmap-full').trigger('click');
        }
        
        if(mapfunctions_vars.custom_search==='yes'){
            custom_search_start_filtering_ajax(1);
        }else{
            start_filtering_ajax(1);  
        }    
        
    });

    /// ******************** end check
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// advanced search filters
    ////////////////////////////////////////////////////////////////////////////////////////////    

    $('#openmap').click(function(){
        
        if( $(this).find('i').hasClass('fa-angle-down') ){
            $(this).empty().append('<i class="fa fa-angle-up"></i>'+control_vars.close_map);
            
            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                adv_search_click();
            }
            
        }else{
            $(this).empty().append('<i class="fa fa-angle-down"></i>'+control_vars.open_map);
          
        }
        new_open_close_map(2);
    });
  
    
    ///////////////////////////////////////////////////////////////////////////////////////////  
    //////// full screen map
    ////////////////////////////////////////////////////////////////////////////////////////////    
    var wrap_h;
    var map_h;
    
    $('#gmap-full').click(function(){

      
      if(  $('#gmap_wrapper').hasClass('fullmap') ){        
           $('#gmap_wrapper').removeClass('fullmap').css('height',wrap_h+'px');
           $('#googleMap').removeClass('fullmap').css('height',map_h+'px');
           $('#search_wrapper').removeClass('fullscreen_search');
           $('#search_wrapper').removeClass('fullscreen_search_open');
           $('.nav_wrapper').removeClass('hidden');
           $('.content_wrapper').show();
           $('body,html').animate({
                scrollTop: 0
           }, "slow");
           $('#openmap').show();
           $(this).empty().append('<i class="fa fa-arrows-alt"></i>'+control_vars.fullscreen).removeClass('spanselected');
          
          
      }else{
           wrap_h=$('#gmap_wrapper').outerHeight();
           map_h=$('#googleMap').outerHeight();
           $('#gmap_wrapper,#googleMap').css('height','100%').addClass('fullmap');
           $('#search_wrapper').addClass('fullscreen_search');
           $('.nav_wrapper').addClass('hidden');
           $('.content_wrapper').hide();
           $('#openmap').hide();
           $(this).empty().append('<i class="fa fa-square-o"></i>'+control_vars.default).addClass('spanselected');
            
      }
      
     
      google.maps.event.trigger(map, "resize");
      
    });
    
    
    $('#street-view').click(function(){
         toggleStreetView();
    });
    
    
    
    $('#slider_enable_map').click(function(){
        var cur_lat, cur_long, myLatLng;
        
        $('#carousel-listing div').removeClass('slideron');
        $(this).addClass('slideron');
        
        $('#googleMapSlider').show();
        google.maps.event.trigger(map, "resize");
        
        cur_lat     =   jQuery('#googleMapSlider').attr('data-cur_lat');
        cur_long    =   jQuery('#googleMapSlider').attr('data-cur_long');
        myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);
    
        map.setCenter(myLatLng);
        map.panBy(10,-100);
       // map.setZoom(17);
        panorama.setVisible(false); 
        
       $('#gmapzoomminus.smallslidecontrol').show();
       $('#gmapzoomplus.smallslidecontrol').show();
    });
    
    $('#slider_enable_street').click(function(){
        var cur_lat, cur_long, myLatLng;
        
        $('#carousel-listing div').removeClass('slideron');
        $(this).addClass('slideron');
        
        cur_lat     =   jQuery('#googleMapSlider').attr('data-cur_lat');
        cur_long    =   jQuery('#googleMapSlider').attr('data-cur_long');
        myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);
        $('#googleMapSlider').show();
        panorama.setPosition(myLatLng);
        panorama.setVisible(true); 
        $('#gmapzoomminus.smallslidecontrol').hide();
        $('#gmapzoomplus.smallslidecontrol').hide();

    });
  
    $('#slider_enable_slider').click(function(){
        $('#carousel-listing div').removeClass('slideron');
        $(this).addClass('slideron');
        
        $('#googleMapSlider').hide();
        panorama.setVisible(false); 
        
        $('#gmapzoomminus.smallslidecontrol').hide();
        $('#gmapzoomplus.smallslidecontrol').hide();
    });
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////     caption-wrapper
    ///////////////////////////////////////////////////////////////////////////////////////////	       
  
    $('.caption-wrapper').click(function(){
        $(this).toggleClass('closed');   
        $('.carusel-back').toggleClass('rowclosed');
        $('.post-carusel .carousel-indicators').toggleClass('rowclosed');      
    });

    $('#carousel-listing').on('slid.bs.carousel', function () {
        show_capture();
        $('#carousel-listing div').removeClass('slideron');
        $('#slider_enable_slider').addClass('slideron');
    })
    
    $('.carousel-round-indicators li').click(function(){
        $('.carousel-round-indicators li').removeClass('active');
        $(this).addClass('active');
    });
    
    $('.videoitem iframe').click(function(){
        $('.estate_video_control').remove();
    });
    ///////////////////////////////////////////////////////////////////////////////////////
    ////// Advanced search
    /////////////////////////////////////////////////////////////////////////////////////////

    adv_search_click();
 
    $('#adv-search-header-1').click(function(){
        if( document.getElementById("adv_extended_options_text_adv") !== null ) {
             $(this).parent().toggleClass('adv-search-1-close-extended');
        }else{
             $(this).parent().toggleClass('adv-search-1-close');
        }
        
       
    })
   
  
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   tool tips on prop unit
    ///////////////////////////////////////////////////////////////////////////////////////////	       
  
    $( ".share_list, .icon-fav, .compare-action, .dashboad-tooltip").hover(
        function() {
            $( this ).tooltip('show') ;
        }, function() {
            $( this ).tooltip('hide');
        }
    );
        
     $('.share_list').click(function(event){
        event.stopPropagation();
        var sharediv=$(this).parent().find('.share_unit');
        sharediv.toggle();
        $(this).toggleClass('share_on');
     })
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////    nice scroll on page
    ///////////////////////////////////////////////////////////////////////////////////////////	       
  
    $("html").niceScroll({cursorborder:"none" ,cursorcolor:"#393F48",cursorwidth :"12px",background:"#D5D5D5",autohidemode:"true"});  // The document page (body)
    
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   back to top
    ///////////////////////////////////////////////////////////////////////////////////////////	       
           
         
     $('.backtop').click(function(event){
         event.preventDefault();
  
         $('body,html').animate({
                scrollTop: 0
          }, "slow");

     })    
         
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////    footer contact
    ///////////////////////////////////////////////////////////////////////////////////////////	       
         
    $('.contact-box ').click(function(event){
        event.preventDefault();
        $('.contactformwrapper').toggleClass('hidden');
        contact_footer_starter();
    });
         
   
         
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////    add pretty photo
    ///////////////////////////////////////////////////////////////////////////////////////////	
    
    $('.carousel-inner .item').click(function(event){
        event.preventDefault();
    });

    //$(" a[data-pretty='prettyPhoto']").prettyPhoto();
    $("a[rel^='prettyPhoto']").prettyPhoto();



    var mediaQuery = 'has_pretty_photo';
    if (Modernizr.mq('only screen and (max-width: 600px)') || Modernizr.mq('only screen and (max-height: 520px)')) {
        mediaQuery = 'no_pretty_photo';
       //$("a[data-pretty^='prettyPhoto']").unbind('click');
        $("a[rel^='prettyPhoto']").unbind('click');
    }

    //   pretty photo on / off
    mediaQuery = 'has_pretty_photo';

    if ((Modernizr.mq('only screen and (max-width: 600px)') || Modernizr.mq('only screen and (max-height: 520px)')) && mediaQuery === 'has_pretty_photo') {
       // jQuery("a[data-pretty='prettyPhoto']").unbind('click');
         jQuery("a[rel^='prettyPhoto']").unbind('click');
        mediaQuery = 'no_pretty_photo';
    } else if (!Modernizr.mq('only screen and (max-width: 600px)') && !Modernizr.mq('only screen and (max-height: 520px)') && mediaQuery === 'no_pretty_photo') {
        //$("a[data-pretty='prettyPhoto']").prettyPhoto();
          $("a[rel^='prettyPhoto']").prettyPhoto();
        mediaQuery = 'has_pretty_photo';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   widget morgage calculator
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#morg_compute').click(function() {
        
        var intPayPer  = 0;
        var intMthPay  = 0;
        var intMthInt  = 0;
        var intPerFin  = 0;
        var intAmtFin  = 0;
        var intIntRate = 0;
        var intAnnCost = 0;
        var intVal     = 0;
        var salePrice  = 0;

        salePrice = $('#sale_price').val();
        intPerFin = $('#percent_down').val() / 100;

        intAmtFin = salePrice - salePrice * intPerFin;
        intPayPer =  parseInt ($('#term_years').val(),10) * 12;
        intIntRate = parseInt ($('#interest_rate').val(),10);
        intMthInt = intIntRate / (12 * 100);
        intVal = raisePower(1 + intMthInt, -intPayPer);
        intMthPay = intAmtFin * (intMthInt / (1 - intVal));
        intAnnCost = intMthPay * 12;

        $('#am_fin').html("<strong>"+control_vars.morg1+"</strong><br> " + (Math.round(intAmtFin * 100)) / 100 + " ");
        $('#morgage_pay').html("<strong>"+control_vars.morg2+"</strong><br> " + (Math.round(intMthPay * 100)) / 100 + " ");
        $('#anual_pay').html("<strong>"+control_vars.morg3+"</strong><br> " + (Math.round(intAnnCost * 100)) / 100 + " ");
        $('#morg_results').show();
        $('.mortgage_calculator_div').css('height',532+'px');
    });

    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// contact form
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#contact_name, #email, #phone, #comment').focus(function(){
       $(this).val(''); 
    });

    $('#agent_contact_name').focus(function(){
         $(this).val(''); 
    }).focusout(function(){
        var value_field=$(this).val();
        if (value_field===''){
             $(this).val(control_vars.contact_name);
        }
    });

    $('#agent_user_email').focus(function(){
         $(this).val(''); 
    }).focusout(function(){
        var value_field=$(this).val();
        if (value_field===''){
             $(this).val(control_vars.contact_email);
        }
    });

   $('#agent_phone').focus(function(){
         $(this).val(''); 
    }).focusout(function(){
        var value_field=$(this).val();
        if (value_field===''){
             $(this).val(control_vars.contact_phone);
        }
    });


   $('#agent_comment').focus(function(){
         $(this).val(''); 
    }).focusout(function(){
        var value_field=$(this).val();
        if (value_field===''){
             $(this).val(control_vars.contact_comment);
        }
    });


    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// Search widget
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('#searchform input').focus(function(){
      $(this).val(''); 
    }).blur(function(){

    });
   
     /////////////////////////////////////////////////////////////////////////////////////////
     ////// idx widget 
     /////////////////////////////////////////////////////////////////////////////////////////
     
     $('.dsidx-controls a').click(function(){
         sizeContent();         
     });
     
  
    
    
     ///////////////////////////////////////////////////////////////////////////////////////
     ////// Geolocation
     /////////////////////////////////////////////////////////////////////////////////////////
     
     $("#geolocation-button").hover(
            function () {
              $('#tooltip-geolocation').fadeIn();
              $('.tooltip').fadeOut("fast");
            },
            function () {
              $('#tooltip-geolocation').fadeOut();
            }
        );     
         

    ////////////////////////////////////////////////////////////////////////////////////////////
    /// switch from tel to callto  
    ///////////////////////////////////////////////////////////////////////////////////////////
      if (!jQuery.browser.mobile) {
          jQuery('body').on('click', 'a[href^="tel:"]', function() {
                  jQuery(this).attr('href', 
                      jQuery(this).attr('href').replace(/^tel:/, 'callto:'));
          });
      }
    
    
    ////////////////////////////////////////////////////////////////////////////////////////////
    /// adding total for featured listings  
    ///////////////////////////////////////////////////////////////////////////////////////////
    $('.extra_featured').change(function(){
       var parent= $(this).parent();
       var price_regular  = parseFloat( parent.find('.submit-price-no').text(),10 );
       var price_featured = parseFloat( parent.find('.submit-price-featured').text(),10 );
       var total= price_regular+price_featured;

       if( $(this).is(':checked') ){
           parent.find('.submit-price-total').text(total)
       }else{
           //substract from total
            parent.find('.submit-price-total').text(price_regular)
       }
    });
  
  
     ///////////////////////////////////////////////////////////////////////////////////////////
    ///////  resise colums on compare page
    ///////////////////////////////////////////////////////////////////////////////////////////

    $('.compare_wrapper').each(function() {
        var cols = $(this).find('.compare_item_head').length;
        $(this).addClass('compar-' + cols);
    });


    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// contact page form
    ///////////////////////////////////////////////////////////////////////////////////////////
       
    var search_label='';
    $('#agent_contanct_form input[type=text],#agent_contanct_form textarea').focus(function(){
          search_label= $(this).val(); 
          $(this).val(''); 
    }).focusout(function(){
        var value_field=$(this).val();
        if (value_field===''){
             $(this).val(search_label);
        }
    });

    
    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// grid to list view
    ///////////////////////////////////////////////////////////////////////////////////////////


    $('#list_view').click(function(){
         $(this).toggleClass('icon_selected');
         $('#listing_ajax_container').addClass('ajax12');
         $('#grid_view').toggleClass('icon_selected');
        
         
         $('.listing_wrapper').hide().removeClass('col-md-4').removeClass('col-md-3').addClass('col-md-12').fadeIn(400) ;
         $('.the_grid_view').fadeOut(10,function() {
            $('.the_list_view').fadeIn(300);
         });       
     })
     
     $('#grid_view').click(function(){
         var class_type;
         class_type = $('.listing_wrapper:first-of-type').attr('data-org');
         $(this).toggleClass('icon_selected');
         $('#listing_ajax_container').removeClass('ajax12');
         $('#list_view').toggleClass('icon_selected');
         $('.listing_wrapper ').hide().removeClass('col-md-12').addClass('col-md-'+class_type).fadeIn(400); 
         $('.the_list_view').fadeOut(10,function(){
              $('.the_grid_view').fadeIn(300);
         });     
     })
     
     
    ///////////////////////////////////////////////////////////////////////////////////////////
    ///////   compare action
    ///////////////////////////////////////////////////////////////////////////////////////////
    var already_in=[];
    $('.compare-action').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('.prop-compare').show();

        var post_id = $(this).attr('data-pid');
         for(var i = 0; i < already_in.length; i++) {
            if(already_in[i] === post_id) {
                return;
            }
        }
        
        already_in.push(post_id);
      
        
        var post_image = $(this).attr('data-pimage');

        var to_add = '<div class="items_compare" style="display:none;"><img src="' + post_image + '" alt="compare_thumb" class="img-responsive"><input type="hidden" value="' + post_id + '" name="selected_id[]" /></div>';
        $('div.items_compare:first-child').css('background', 'red');
        if (parseInt($('.items_compare').length,10) > 3) {
            $('.items_compare:first').remove();
        }
        $('#submit_compare').before(to_add);
        
        $('#submit_compare').click(function() {
            $('#form_compare').trigger('submit');
        })
    
        $('.items_compare').fadeIn(500);
    });

    $('#submit_compare').click(function() {
        $('#form_compare').trigger('submit');
    })
    
    
    
     /////////////////////////////////////////////////////////////////////////////////////////
     ////// form upload
     /////////////////////////////////////////////////////////////////////////////////////////
       
    $('#form_submit_2,#form_submit_1 ').click(function(){
        var loading_modal;
        window.scrollTo(0, 0);
        loading_modal='<div class="modal fade" id="loadingmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit"><span>'+control_vars.addprop+'</div></div></div></div></div>';
        
        jQuery('body').append(loading_modal);
        jQuery('#loadingmodal').modal();
    });
       
       
       $('#add-new-image').click(function(){
           $('<p><label for="file">New Image:</label><input type="file" name="upload_attachment[]" id="file_featured"></p> ').appendTo('#files_area');
       })
       
       
       
       $('.delete_image').click(function(){
          var image_id=$(this).attr('data-imageid'); 
          
          var curent=$('#images_todelete').val(); 
        if(curent===''){
                 curent=image_id;
           }else{
                 curent=curent+','+image_id;
           }
         
          $('#images_todelete').val(curent) ;     
          $(this).parent().remove();              
      });
  
     /////////////////////////////////////////////////////////////////////////////////////////
     ////// mouse over map tooltip
     /////////////////////////////////////////////////////////////////////////////////////////
       
    $('#googleMap').bind('mousemove', function(e){
       $('.tooltip').css({'top':e.pageY,'left':e.pageX, 'z-index':'1'});
    });

    setTimeout(function(){  $('.tooltip').fadeOut("fast");},10000);
    });




function show_capture(){
    "use strict";
    var position, slideno, slidedif, tomove, curentleft, position;
    jQuery('#googleMapSlider').hide();
    position=parseInt( jQuery('#carousel-listing .carousel-inner .active').index(),10);
    jQuery('#carousel-listing  .caption-wrapper span').removeClass('active');
    jQuery('#carousel-listing  .carousel-round-indicators li').removeClass('active');
    
    jQuery("#carousel-listing  .caption-wrapper span[data-slide-to='"+position+"'] ").addClass('active');
    jQuery("#carousel-listing  .carousel-round-indicators li[data-slide-to='"+position+"'] ").addClass('active');
    slideno=position+1;

    slidedif=slideno*146;
    if( slidedif > 810){
        tomove=810-slidedif;
        jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px");
    }else{
        position = jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px").position();
        curentleft = position.left;

        if( curentleft < 0 ){
            tomove = 0;
            jQuery('.post-carusel .carousel-indicators').css('left',tomove+"px");
        }

    }
        
}

 function raisePower(x, y) {
        return Math.pow(x, y);
    } 
    
    
///////////////////////////////  vimeo player 
/*
jQuery(document).ready(function($) {
    "use strict";
    var has_video;
    function addEvent(element, eventName, callback) {
        (element.addEventListener) ? element.addEventListener(eventName, callback, false) : element.attachEvent(eventName, callback, false);
    }

    function ready(player_id) {
        var froogaloop = $f(player_id);
        froogaloop.addEvent('play', function(data) {
            $('.flexslider').flexslider("pause");
        });
        froogaloop.addEvent('pause', function(data) {
            $('.flexslider').flexslider("play");
        });
    }

    var player = document.getElementById('player_1');
    if (player !== null) {
        has_video = 1;
        $f(player).addEvent('ready', ready);
    } else {
        has_video = 0;
    }

    
});
*/

function shortcode_google_map_load(containermap, lat, long, mapid){
    "use strict";    
  
    var myCenter = new google.maps.LatLng(lat, long);
    var mapOptions = {
             flat:false,
             noClear:false,
             zoom: 15,
             scrollwheel: false,
             draggable: true,
             center: myCenter,
             mapTypeId: google.maps.MapTypeId.ROADMAP,
             streetViewControl:false,
             mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP]
            },
            disableDefaultUI: true
           };
           
    map = new google.maps.Map(document.getElementById(mapid), mapOptions);
    google.maps.visualRefresh = true;
    
    var marker=new google.maps.Marker({
       position: myCenter,
             map: map
    });

    marker.setMap(map);

}

function adv_search_click(){
/*
    jQuery('#adv-search-header-1').click(function(){
    var  bottompos = 0;
        
    if( jQuery('.adv1_close').css('bottom') === '0px'){
        bottompos=-178;
    }

        jQuery('.adv1_close').animate({
            bottom: bottompos+'px'
                }, 350,"linear",function(){
            
                if(bottompos===0){
                    jQuery('.adv1_close').css('z-index', 101);
                }else{
                    jQuery('.adv1_close').css('z-index', 99);
                }
            }
        );
    })
    */
   jQuery('#adv-search-header-1').click(function(){
        jQuery('#search_wrapper').toggleClass('fullscreen_search_open');
   });
   
}

///////////////////////////////////////////////////////////////////////////////////////////
/////// Contact footer
///////////////////////////////////////////////////////////////////////////////////////////
function contact_footer_starter(){
    jQuery('#btn-cont-submit').click(function () {
        var contact_name, contact_email, contact_phone, contact_coment, agent_email, property_id, nonce, ajaxurl;
        contact_name    =   jQuery('#foot_contact_name').val();
        contact_email   =   jQuery('#foot_contact_email').val();
        contact_phone   =   jQuery('#foot_contact_phone').val();
        contact_coment  =   jQuery('#foot_contact_content').val();
        agent_email     =   jQuery('#foot_agent_email').val();
        nonce           =   jQuery('#contact_footer_ajax_nonce').val();
        ajaxurl         =   ajaxcalls_vars.admin_url + 'admin-ajax.php';

        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxurl,
            data: {
                'action'    :   'wpestate_ajax_contact_form_footer',
                'name'      :   contact_name,
                'email'     :   contact_email,
                'phone'     :   contact_phone,
                'contact_coment'   :   contact_coment,
                'agentemail':   agent_email,
                'propid'    :   property_id,
                'nonce'     :   nonce
            },
            success: function (data) {
                if (data.sent) {
                    jQuery('#foot_contact_name').val('');
                    jQuery('#foot_contact_email').val('');
                    jQuery('#foot_contact_phone').val('');
                    jQuery('#foot_contact_content').val('');
                }
                jQuery('#footer_alert-agent-contact').empty().append(data.response);
            },
            error: function (errorThrown) {
            }
        });
    });
}