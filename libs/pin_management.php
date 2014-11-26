<?php

   
////////////////////////////////////////////////////////////////////////////////
/// google map functions - contact pin array creation
////////////////////////////////////////////////////////////////////////////////  

if( !function_exists('wpestate_contact_pin') ):

function wpestate_contact_pin(){
        $place_markers=array();
       
        
        $company_name=esc_html( get_option('wp_estate_company_name','') );
        if($company_name==''){
            $company_name='Company Name';
        }

        $place_markers[0]    =   $company_name;
        $place_markers[1]    =   '';
        $place_markers[2]    =   '';
        $place_markers[3]    =   1;
        $place_markers[4]    =   esc_html(get_option('wp_estate_company_contact_image', '') );
        $place_markers[5]    =   '0';
        $place_markers[6]    =   'address';
        $place_markers[7]    =   'none';
        $place_markers[8]    =   '';
       /*  */
        return json_encode($place_markers);
}    

endif; // end   wpestate_contact_pin  




////////////////////////////////////////////////////////////////////////////////
/// google map functions - pin array creation
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_listing_pins') ):

function wpestate_listing_pins($args=''){

    $counter=0;
    $unit                       =   get_option('wp_estate_measure_sys','');
    $currency                   =   get_option('wp_estate_currency_symbol','');
    $where_currency             =   get_option('wp_estate_where_currency_symbol', '');
    $cache                      =   get_option('wp_estate_cache','');
    $place_markers=$markers     =   array();

    if($cache=='yes'){
        if(!get_transient('prop_list_cached')) { 
                
                if  ( $args==''){
                    $args = array(
                        'post_type'     =>  'estate_property',
                        'post_status'   =>  'publish',
                        'nopaging'      =>  'true'
                     );
                }
               $prop_selection = new WP_Query($args);
               set_transient('prop_list_cached', $prop_selection, 60 * 60 * 3);//store data for 3h 
        }else{
              $prop_selection =get_transient('prop_list_cached');// retrive cached data
        }
        wp_reset_query(); 
    }
    else{  
        if  ( $args==''){
             $args = array(
                       'post_type'      =>  'estate_property',
                       'post_status'    =>  'publish',
                       'nopaging'       =>  'true'
                       );	
        }
        $prop_selection = new WP_Query($args);
        wp_reset_query(); 
    }//end cache
        $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
   


        while($prop_selection->have_posts()): $prop_selection->the_post();

               $the_id      =   get_the_ID();
               ////////////////////////////////////// gathering data for markups
               $gmap_lat    =   esc_html(get_post_meta($the_id, 'property_latitude', true));
               $gmap_long   =   esc_html(get_post_meta($the_id, 'property_longitude', true));

               //////////////////////////////////////  get property type
               $slug        =   array();
               $prop_type   =   array();
               $prop_city   =   array();
               $prop_area   =   array();
               $types       =   get_the_terms($the_id,'property_category' );
               $types_act   =   get_the_terms($the_id,'property_action_category' );
               $city_tax    =   get_the_terms($the_id,'property_city' );
               $area_tax    =   get_the_terms($the_id,'property_area' );
        
               
             
               
                $prop_type_name=array();
                if ( $types && ! is_wp_error( $types ) ) { 
                     foreach ($types as $single_type) {
                        $prop_type[]      = $single_type->slug;
                        $prop_type_name[] = $single_type->name;
                        $slug             = $single_type->slug;
                       }

                $single_first_type= $prop_type[0];   
                $single_first_type_name= $prop_type_name[0]; 
                }else{
                      $single_first_type='';
                      $single_first_type_name='';
                }



                ////////////////////////////////////// get property action
                $prop_action        =   array();
                $prop_action_name   =   array();
                if ( $types_act && ! is_wp_error( $types_act ) ) { 
                      foreach ($types_act as $single_type) {
                        $prop_action[]      = $single_type->slug;
                        $prop_action_name[] = $single_type->name;
                        $slug=$single_type->slug;
                       }
                $single_first_action        = $prop_action[0];
                $single_first_action_name   = $prop_action_name[0];
                }else{
                    $single_first_action='';
                    $single_first_action_name='';
                }


                 /////////////////////////////////////////////////////////////////
                // add city
                if ( $city_tax && ! is_wp_error( $city_tax ) ) { 
                        foreach ($city_tax as $single_city) {
                           $prop_city[] = $single_city->slug;
                          }

                       $city= $prop_city[0];   
                   }else{
                         $city='';
                   }

                ///////////////////////////////////////  //////////////////////// 
                //add area
                 if ( $area_tax && ! is_wp_error( $area_tax ) ) { 
                         foreach ($area_tax as $single_area) {
                            $prop_area[] = $single_area->slug;
                           }

                        $area= $prop_area[0];   
                    }else{
                        $area='';
                    }     



                    // composing name of the pin
                    if($single_first_type=='' || $single_first_action ==''){
                          $pin                   =  sanitize_key(wpestate_limit54($single_first_type.$single_first_action));
                    }else{
                          $pin                   =  sanitize_key(wpestate_limit27($single_first_type)).sanitize_key(wpestate_limit27($single_first_action));
                    }
                    $counter++;

                    //// get price
                    $price          =   intval   ( get_post_meta($the_id, 'property_price', true) );
                    $price_label    =   esc_html ( get_post_meta($the_id, 'property_label', true) );
                    $clean_price    =    intval   ( get_post_meta($the_id, 'property_price', true) );
                    if($price==0){
                        $price='';                        
                    }else{
                        $price=number_format($price);

                        if($where_currency=='before'){
                             $price=$currency.' '.$price;
                         }else{
                             $price=$price.' '.$currency;
                         }
                        $price=$price.'<span class="infocur">'.$price_label.'</span>';
                    }
                    
                    $rooms      =   get_post_meta($the_id, 'property_bedrooms', true);
                    $bathrooms  =   get_post_meta($the_id, 'property_bathrooms', true);  
                    $size       =   get_post_meta($the_id, 'property_size', true);  		
                    if($size!=''){
                       $size =  number_format(intval($size)) ;
                    }
                    
                    $place_markers=array();

                    $place_markers[]    = get_the_title();//0
                    $place_markers[]    = $gmap_lat;//1
                    $place_markers[]    = $gmap_long;//2
                    $place_markers[]    = $counter;//3
                    $place_markers[]    = get_the_post_thumbnail($the_id,'property_map1');////4
                    $place_markers[]    = $price;//5
                    $place_markers[]    = $single_first_type;//6
                    $place_markers[]    = $single_first_action;//7
                    $place_markers[]    = $pin;//8
                    $place_markers[]    = get_permalink();//9
                    $place_markers[]    = $the_id;//10
                    $place_markers[]    = $city;//11
                    $place_markers[]    = $area;//12
                    $place_markers[]    = $clean_price;//13
                    $place_markers[]    = $rooms;//14
                    $place_markers[]    = $bathrooms;//15
                    $place_markers[]    = $size;//16
                    $place_markers[]    = $single_first_type_name;//17
                    $place_markers[]    = $single_first_action_name;//18
                    
                     $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
                     if ( $custom_advanced_search == 'yes'){  
                      //starts from 17
                        $adv_search_what    = get_option('wp_estate_adv_search_what','');
                        $adv_search_how     = get_option('wp_estate_adv_search_how','');
                        $adv_search_label   = get_option('wp_estate_adv_search_label','');                    
                        $adv_search_type    = get_option('wp_estate_adv_search_type','');
    
                        foreach($adv_search_what as $key => $search_field){
                            //$slug=str_replace(' ','_',$search_field); 
                            $slug         =   wpestate_limit45(sanitize_title( $search_field )); 
                            $slug         =   sanitize_key($slug);
              
                            $place_markers[]    = $slug;
                            if ( $slug == "categories" ){
                                $place_markers []   =  $single_first_type;
                            }else if ( $slug == "types" ){
                                $place_markers [] = $single_first_action;
                            }else if ( $slug == "cities" ){
                                $place_markers [] = $city;
                            }else if ( $slug == "areas" ){
                                 $place_markers [] = $area;
                            }else{
                                $old_values=array(
                                    'property-price',
                                    'property-label',
                                    'property-size',
                                    'property-lot-size',
                                    'property-rooms',
                                    'property-bedrooms',
                                    'property-bathrooms',
                                    'property-bathrooms',
                                    'property-address',
                                    'property-county',
                                    'property-state',
                                    'property-zip',
                                    'property-country',
                                    'property-status',
                                    );
                                
                                if(  in_array($slug,$old_values) ){
                                    $slug=  str_replace('-', '_', $slug);
                                }
                              
                                $place_markers []   = get_post_meta($the_id, $slug, true);//17 18 19 20 
                            }
                           
                            $place_markers[]    = $adv_search_how[$key];//21 22                             
                        }                        
                    }
                       
         
                    $markers[]=$place_markers;
                            

        endwhile; 
        wp_reset_query(); 
     // print_r($markers);
        return json_encode($markers);
}
endif; // end   wpestate_listing_pins  


////////////////////////////////////////////////////////////////////////////////
/// google map functions - pin Images array creation
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_pin_images') ):
 
function wpestate_pin_images(){
    $pins=array();
    $taxonomy = 'property_action_category';
    $tax_terms = get_terms($taxonomy);

    $taxonomy_cat = 'property_category';
    $categories = get_terms($taxonomy_cat);
    
     foreach ($tax_terms as $tax_term) {
        $name                    =  sanitize_key( wpestate_limit64('wp_estate_'.$tax_term->slug) );
        $limit54                 =  sanitize_key( wpestate_limit54($tax_term->slug));
        $pins[$limit54]          =  esc_html( get_option($name) ); 
    }
    
    foreach ($categories as $categ) {
        $name                           =   sanitize_key ( wpestate_limit64('wp_estate_'.$categ->slug) );
        $limit54                        =   sanitize_key(wpestate_limit54($categ->slug));
        $pins[$limit54]                 =   esc_html( get_option($name) );
    }
    

    foreach ($tax_terms as $tax_term) {
        foreach ($categories as $categ) {           
            $limit54                    =   sanitize_key ( wpestate_limit27($categ->slug)).sanitize_key(wpestate_limit27($tax_term->slug) );
            $name                       =   'wp_estate_'.$limit54;
            $pins[$limit54]              =   esc_html( get_option($name) ) ;  
        }
    }
    
    $name='wp_estate_idxpin';
    $pins['idxpin']=esc_html( get_option($name) );  
    
    $name='wp_estate_userpin';
    $pins['userpin']=esc_html( get_option($name) );  
    

    return json_encode($pins);
}
endif; // end   wpestate_pin_images 




////////////////////////////////////////////////////////////////////////////////
/// icon functiosn - return array with icons
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_icons') ):

function wpestate_get_icons(){
    $icons          =   array();
    $taxonomy       =   'property_action_category';
    $tax_terms      =   get_terms($taxonomy);
    $taxonomy_cat   =   'property_category';
    $categories     =   get_terms($taxonomy_cat);

  
    // add only actions
    foreach ($tax_terms as $tax_term) {
       $icon_name   =   wpestate_limit64( 'wp_estate_icon'.$tax_term->slug);
       $limit50     =   wpestate_limit50( $tax_term->slug);
       $value       =    esc_html( get_option($icon_name) );
         
       if ( $value == ''){
          $icons[$limit50]  =    get_template_directory_uri().'/css/css-images/'.$tax_term->slug.'icon.png';  
       }else{
          $icons[$limit50]  =    $value;
       }
       
    }

    // add only categories
    foreach ($categories as $categ) { 
        $icon_name    =    wpestate_limit64( 'wp_estate_icon'.$categ->slug);
        $value        =    esc_html( get_option($icon_name) );
        $limit50      =    wpestate_limit50( $categ->slug);
        
        if ( $value == ''){
          $icons[$limit50]  =    get_template_directory_uri().'/css/css-images/'.$categ->slug.'icon.png';  
        }else{
          $icons[$limit50]  =    $value;
        }
    } 


    return json_encode($icons);
}
endif; // end   wpestate_get_icons  




////////////////////////////////////////////////////////////////////////////////
/// hover icon functiosn - return array with icons
////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_get_hover_icons') ):

function wpestate_get_hover_icons(){
    $icons          =   array();
    $taxonomy       =   'property_action_category';
    $tax_terms      =   get_terms($taxonomy);
    $taxonomy_cat   =   'property_category';
    $categories     =   get_terms($taxonomy_cat);

    // add only actions
    foreach ($tax_terms as $tax_term) {
       $hover_icon_name =   'wp_estate_hovericon'.$tax_term->slug;
       $value           =    esc_html( get_option($hover_icon_name) );
       
       if ( $value == ''){
          $icons[$tax_term->slug]  =    get_template_directory_uri().'/css/css-images/'.$tax_term->slug.'iconhover.png';  
       }else{
          $icons[$tax_term->slug]  =    $value;
       }
       
    }

    //
    // add only categories
    foreach ($categories as $categ) {
        $hover_icon_name    =   'wp_estate_hovericon'.$categ->slug;
        $value              =    esc_html( get_option($hover_icon_name) );
        
        if ( $value == ''){
          $icons[$categ->slug]  =    get_template_directory_uri().'/css/css-images/'.$categ->slug.'iconhover.png';  
        }else{
          $icons[$categ->slug]  =    $value;
        }
    } 
       

    return json_encode($icons);
}
endif; // end   wpestate_get_hover_icons  


function wpestate_limit64($stringtolimit){
    return substr($stringtolimit,0,64);
}

function wpestate_limit54($stringtolimit){
    return substr($stringtolimit,0,54);
}

function wpestate_limit50($stringtolimit){ // 14
    return substr($stringtolimit,0,50);
}

function wpestate_limit45($stringtolimit){ // 19
    return substr($stringtolimit,0,45);
}                                   

function wpestate_limit27($stringtolimit){ // 27
    return substr($stringtolimit,0,27);
}    

?>