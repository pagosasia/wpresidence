<?php
require_once 'resources/wp_bootstrap_navwalker.php';

if( !function_exists('wpestate_insert_attachment') ):
function wpestate_insert_attachment($file_handler,$post_id,$setthumb='false') {

    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload( $file_handler, $post_id );

    if ($setthumb) update_post_meta($post_id,'_thumbnail_id',$attach_id);
    return $attach_id;
} 
endif;

/////////////////////////////////////////////////////////////////////////////////
// order by filter featured
///////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_get_measure_unit') ):
function wpestate_get_measure_unit() {
    $measure_sys    =   esc_html ( get_option('wp_estate_measure_sys','') ); 
            
    if($measure_sys=='feet'){
        return 'ft<sup>2</sup>';
    }else{ 
        return 'm<sup>2</sup>';
    }              
}
endif;
/////////////////////////////////////////////////////////////////////////////////
// order by filter featured
///////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_my_order') ):
function wpestate_my_order($orderby) { 
    global $wpdb; 
    global $table_prefix;
    $orderby = $table_prefix.'postmeta.meta_value DESC, '.$table_prefix.'posts.ID DESC';
    return $orderby;
}    

endif; // end   wpestate_my_order  

////////////////////////////////////////////////////////////////////////////////////////
/////// Pagination
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('kriesi_pagination') ):

function kriesi_pagination($pages = '', $range = 2){  
 
     $showitems = ($range * 2)+1;  
     global $paged;
     if(empty($paged)) $paged = 1;


     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo '<ul class="pagination pagination_nojax">';
         echo "<li class=\"roundleft\"><a href='".get_pagenum_link($paged - 1)."'><i class=\"fa fa-angle-left\"></i></a></li>";
      
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 if ($paged == $i){
                    print '<li class="active"><a href="'.get_pagenum_link($i).'" >'.$i.'</a><li>';
                 }else{
                    print '<li><a href="'.get_pagenum_link($i).'" >'.$i.'</a><li>';
                 }
             }
         }
         
         $prev_page= get_pagenum_link($paged + 1);
         if ( ($paged +1) > $pages){
            $prev_page= get_pagenum_link($paged );
         }else{
             $prev_page= get_pagenum_link($paged + 1);
         }
     
         
         echo "<li class=\"roundright\"><a href='".$prev_page."'><i class=\"fa fa-angle-right\"></i></a><li></ul>";
     }
}
endif; // end   kriesi_pagination  

////////////////////////////////////////////////////////////////////////////////////////
/////// Pagination Custom
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('kriesi_pagination_ajax') ):

function kriesi_pagination_ajax($pages = '', $range = 2,$paged,$where)
{  
    $showitems = ($range * 2)+1;  

     if(1 != $pages)
     {
         echo '<ul class="pagination '.$where.'">';
         if($paged!=1){
             $prev_page=$paged-1;
         }else{
             $prev_page=1;
         }
         echo "<li class=\"roundleft\"><a href='".get_pagenum_link($paged - 1)."' data-future='".$prev_page."'><i class=\"fa fa-angle-left\"></i></a></li>";
      
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 if ($paged == $i){
                    print '<li class="active"><a href="'.get_pagenum_link($i).'" data-future="'.$i.'">'.$i.'</a><li>';
                 }else{
                    print '<li><a href="'.get_pagenum_link($i).'" data-future="'.$i.'">'.$i.'</a><li>';
                 }
             }
         }
         
         $prev_page= get_pagenum_link($paged + 1);
         if ( ($paged +1) > $pages){
            $prev_page= get_pagenum_link($paged );
             echo "<li class=\"roundright\"><a href='".$prev_page."' data-future='".$paged."'><i class=\"fa fa-angle-right\"></i></a><li>"; 
         }else{
             $prev_page= get_pagenum_link($paged + 1);
             echo "<li class=\"roundright\"><a href='".$prev_page."' data-future='".($paged+1)."'><i class=\"fa fa-angle-right\"></i></a><li>"; 
         }
     
         
        
         echo "</ul>\n";
     }
}
endif; // end   kriesi_pagination  

///////////////////////////////////////////////////////////////////////////////////////////
/////// Look for images in post and add the rel="prettyPhoto"
///////////////////////////////////////////////////////////////////////////////////////////

add_filter('the_content', 'pretyScan');

if( !function_exists('pretyScan') ):
function pretyScan($content) {
    global $post;
    $pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
    $replacement = '<a$1href=$2$3.$4$5 data-pretty="prettyPhoto" title="' . $post->post_title . '"$6>';
    $content = preg_replace($pattern, $replacement, $content);
    return $content;
}
endif; // end   pretyScan  






////////////////////////////////////////////////////////////////////////////////
/// force html5 validation -remove category list rel atttribute
////////////////////////////////////////////////////////////////////////////////    

add_filter( 'wp_list_categories', 'wpestate_remove_category_list_rel' );
add_filter( 'the_category', 'wpestate_remove_category_list_rel' );

if( !function_exists('wpestate_remove_category_list_rel') ):
function wpestate_remove_category_list_rel( $output ) {
    // Remove rel attribute from the category list
    return str_replace( ' rel="category tag"', '', $output );
}
endif; // end   wpestate_remove_category_list_rel  



////////////////////////////////////////////////////////////////////////////////
/// avatar url
////////////////////////////////////////////////////////////////////////////////    

if( !function_exists('wpestate_get_avatar_url') ):
function wpestate_get_avatar_url($get_avatar) {
    preg_match("/src='(.*?)'/i", $get_avatar, $matches);
    return $matches[1];
}
endif; // end   wpestate_get_avatar_url  



////////////////////////////////////////////////////////////////////////////////
///  get current map height
////////////////////////////////////////////////////////////////////////////////   

if( !function_exists('get_current_map_height') ):
function get_current_map_height($post_id){
    
   if ( $post_id == '' || is_home() ) {
        $min_height =   intval ( get_option('wp_estate_min_height','') );
   } else{
        $min_height =   intval ( (get_post_meta($post_id, 'min_height', true)) );
        if($min_height==0){
              $min_height =   intval ( get_option('wp_estate_min_height','') );
        }
   }    
   return $min_height;
}
endif; // end   get_current_map_height  



////////////////////////////////////////////////////////////////////////////////
///  get  map open height
////////////////////////////////////////////////////////////////////////////////   

if( !function_exists('get_map_open_height') ):
function get_map_open_height($post_id){
    
   if ( $post_id == '' || is_home() ) {
        $max_height =   intval ( get_option('wp_estate_max_height','') );
   } else{
        $max_height =   intval ( (get_post_meta($post_id, 'max_height', true)) );
        if($max_height==0){
            $max_height =   intval ( get_option('wp_estate_max_height','') );
        }
   }
    
   return $max_height;
}
endif; // end   get_map_open_height  





////////////////////////////////////////////////////////////////////////////////
///  get  map open/close status 
////////////////////////////////////////////////////////////////////////////////   

if( !function_exists('get_map_open_close_status') ):
function get_map_open_close_status($post_id){    
   if ( $post_id == '' || is_home() ) {
        $keep_min =  esc_html( get_option('wp_estate_keep_min','' ) ) ;
   } else{
        $keep_min =  esc_html ( (get_post_meta($post_id, 'keep_min', true)) );
   }
    
   if ($keep_min == 'yes'){
       $keep_min=1; // map is forced at closed
   }else{
       $keep_min=0; // map is free for resize
   }
   
   return $keep_min;
}
endif; // end   get_map_open_close_status  




////////////////////////////////////////////////////////////////////////////////
///  get  map  longitude
////////////////////////////////////////////////////////////////////////////////   
if( !function_exists('get_page_long') ):
function get_page_long($post_id){
      $header_type  =   get_post_meta ( $post_id ,'header_type', true);
      if( $header_type==5 ){
        $page_long  = esc_html( get_post_meta($post_id, 'page_custom_long', true) );          
      }
      else{
        $page_long  = esc_html( get_option('wp_estate_general_longitude','') );
      }
      return $page_long;   
}  
endif; // end   get_page_long  




////////////////////////////////////////////////////////////////////////////////
///  get  map  lattitudine
////////////////////////////////////////////////////////////////////////////////  

if( !function_exists('get_page_lat') ):
function get_page_lat($post_id){
      $header_type  =   get_post_meta ( $post_id ,'header_type', true);
      if( $header_type==5 ){
        $page_lat  = esc_html( get_post_meta($post_id, 'page_custom_lat', true) );
      }
      else{
        $page_lat = esc_html( get_option('wp_estate_general_latitude','') );
      }
      return $page_lat;
    
              
}  
endif; // end   get_page_lat  

////////////////////////////////////////////////////////////////////////////////
///  get  map  zoom
////////////////////////////////////////////////////////////////////////////////  

if( !function_exists('get_page_zoom') ):
function get_page_zoom($post_id){
      $header_type  =   get_post_meta ( $post_id ,'header_type', true);
      if( $header_type==5 ){
        $page_zoom  =  get_post_meta($post_id, 'page_custom_zoom', true);
      }
      else{
        $page_zoom = esc_html( get_option('wp_estate_default_map_zoom','') );
      }
      return $page_zoom;
    
              
}  
endif; // end   get_page_lat  


///////////////////////////////////////////////////////////////////////////////////////////
// advanced search link
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('get_adv_search_link') ):
function get_adv_search_link(){   
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'advanced_search_results.php'
        ));

    if( $pages ){
        $adv_submit = get_permalink( $pages[0]->ID);
    }else{
        $adv_submit='';
    }
    
    return $adv_submit;
}
endif; // end   get_adv_search_link  




///////////////////////////////////////////////////////////////////////////////////////////
// compare link
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('get_compare_link') ):

function get_compare_link(){
   $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'compare_listings.php'
        ));

    if( $pages ){
        $compare_submit = get_permalink( $pages[0]->ID);
    }else{
        $compare_submit='';
    }
    
    return $compare_submit;
}

endif; // end   get_compare_link  




///////////////////////////////////////////////////////////////////////////////////////////
// dasboaord link
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('get_dashboard_link') ):
function get_dashboard_link(){
    $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'user_dashboard.php'
        ));

    if( $pages ){
        $dash_link = get_permalink( $pages[0]->ID);
    }else{
        $dash_link=home_url();
    }  
    
    return $dash_link;
}
endif; // end   get_dashboard_link  




///////////////////////////////////////////////////////////////////////////////////////////
// procesor link
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('get_procesor_link') ):
function get_procesor_link(){
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'processor.php'
            ));

    if( $pages ){
        $processor_link = get_permalink( $pages[0]->ID);
    }else{
        $processor_link=home_url();
    }
    
    return $processor_link;
}
endif; // end   get_procesor_link  




///////////////////////////////////////////////////////////////////////////////////////////
// dashboard profile link
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('get_dashboard_profile_link') ):
function get_dashboard_profile_link(){
    $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'user_dashboard_profile.php'
        ));
    
    if( $pages ){
        $dash_link = get_permalink( $pages[0]->ID);
    }else{
        $dash_link=home_url();
    }  
    
    return $dash_link;
}
endif; // end   get_dashboard_profile_link  





///////////////////////////////////////////////////////////////////////////////////////////
// dashboard add listing
///////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('get_dasboard_add_listing') ):
function get_dasboard_add_listing(){
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'user_dashboard_add.php'
            ));

    if( $pages ){
        $add_link = get_permalink( $pages[0]->ID);
    }else{
        $add_link=home_url();
    }
    return $add_link;
}
endif; // end   get_dasboard_add_listing  




///////////////////////////////////////////////////////////////////////////////////////////
// dashboard favorite listings
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('get_dashboard_favorites') ):

function get_dashboard_favorites(){
 $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => 'user_dashboard_favorite.php'
            ));

    if( $pages ){
        $dash_favorite = get_permalink( $pages[0]->ID);
    }else{
        $dash_favorite=home_url();
    }    
    return $dash_favorite;
}
endif; // end   get_dashboard_favorites  





///////////////////////////////////////////////////////////////////////////////////////////
// return video divs for sliders
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('custom_vimdeo_video') ):
function custom_vimdeo_video($video_id) {
       
return $return_string = '
    <div style="max-width:100%;" class="video">
       <iframe id="player_1" src="http://player.vimeo.com/video/' . $video_id . '?api=1&amp;player_id=player_1"      allowFullScreen></iframe>
    </div>';

}
endif; // end   custom_vimdeo_video  


if( !function_exists('custom_youtube_video') ):
function  custom_youtube_video($video_id){

    return $return_string='
        <div style="max-width:100%;" class="video">
            <iframe id="player_2" title="YouTube video player" src="http://www.youtube.com/embed/' . $video_id  . '?wmode=transparent&amp;rel=0"  ></iframe>
        </div>';

}
endif; // end   custom_youtube_video  



function get_video_thumb($post_id){
    $video_id    = esc_html( get_post_meta($post_id, 'embed_video_id', true) );
    $video_type = esc_html( get_post_meta($post_id, 'embed_video_type', true) );
    
    if($video_type=='vimeo'){
         $hash2 = ( wp_remote_get("http://vimeo.com/api/v2/video/$video_id.php") );
         $pre_tumb=(unserialize ( $hash2['body']) );
         $video_thumb=$pre_tumb[0]['thumbnail_medium'];                                        
    }else{
        $video_thumb = 'http://img.youtube.com/vi/' . $video_id . '/0.jpg';
    }
    return $video_thumb;
    
}




function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

///////////////////////////////////////////////////////////////////////////////////////////
/////// Show advanced search fields
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_show_search_field') ):
         
 function  wpestate_show_search_field($search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key){
            $adv_search_what        =   get_option('wp_estate_adv_search_what','');
            $adv_search_label       =   get_option('wp_estate_adv_search_label','');
            $adv_search_how         =   get_option('wp_estate_adv_search_how','');

           
            $return_string='';
            if($search_field=='none'){
                $return_string=''; 
            }
            else if($search_field=='types'){
                $return_string='
                <div class="dropdown form-control">
                    <div data-toggle="dropdown" id="adv_actions" class="filter_menu_trigger" data-value="all">'
                        .__('All Actions','wpestate').'<span class="caret caret_filter"></span>
                    </div>           
                    <input type="hidden" name="filter_search_action[]" value="">

                    <ul class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions">
                        '.$action_select_list.'
                    </ul>        
                </div>';
                    
            }else if($search_field=='categories'){
                    
                $return_string='
                <div class="dropdown  form-control">
                    <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="all">'
                    .__('All Types','wpestate').' <span class="caret caret_filter"></span>
                    </div>           
                    <input type="hidden" name="filter_search_type[]" value="">
                                                              
                    <ul class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                      '.$categ_select_list.'
                    </ul>        
                </div>';

            }  else if($search_field=='cities'){
                    
                $return_string='
                <div class="dropdown  form-control">
                    <div data-toggle="dropdown" id="advanced_city" class="filter_menu_trigger" data-value="all">'
                        . __('All Cities','wpestate').' <span class="caret caret_filter"></span>
                    </div>           
                    <input type="hidden" name="advanced_city" value="">
                    <ul  id="adv-search-city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="advanced_city">
                        '.$select_city_list.'
                    </ul>        
                </div> ';
                
           }   else if($search_field=='areas'){

                $return_string='
                <div class="dropdown  form-control">
                    <div data-toggle="dropdown" id="advanced_area" class="filter_menu_trigger" data-value="all">'
                        .__('All Areas','wpestate').'<span class="caret caret_filter"></span>
                    </div>           
                    <input type="hidden" name="advanced_area" value="">
                    <ul id="adv-search-area" class="dropdown-menu filter_menu" role="menu" aria-labelledby="advanced_area">
                        '.$select_area_list.'
                    </ul>        
                </div>';
                
            }   else {
              
                //$slug       =   wpestate_limit45 ( sanitize_title ( $search_field )); 
                //$slug       =   sanitize_key($slug);            
                $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
                $slug         =   sanitize_key($string);
                
                $label=$adv_search_label[$key];
                if (function_exists('icl_translate') ){
                    $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$label, $label ) ;
                }
              
                $return_string='<input type="text" id="'.$slug.'"  name="'.$slug.'" placeholder="'.$label.'" value=""  class="advanced_select  form-control" />';

                if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller'){
                    print '<script type="text/javascript">
                          //<![CDATA[
                          jQuery(document).ready(function(){
                                  jQuery("#'.$slug.'").datepicker({
                                          dateFormat : "yy-mm-dd"
                                  });
                          });
                          //]]>
                          </script>';
                }
           

            } 
            print $return_string;
         }
endif; // 


if( !function_exists('wpestate_show_search_field_mobile') ):
         
 function  wpestate_show_search_field_mobile($search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key){
            $adv_search_what        =   get_option('wp_estate_adv_search_what','');
            $adv_search_label       =   get_option('wp_estate_adv_search_label','');
            $adv_search_how         =   get_option('wp_estate_adv_search_how','');

            $return_string='';
            if($search_field=='none'){
                $return_string=''; 
            }
            else if($search_field=='types'){
                  $return_string='
                  <div class="dropdown form-control">
                  <div data-toggle="dropdown" id="adv_actions_mobile" class="filter_menu_trigger" data-value="all">'.__('All Actions','wpestate').'<span class="caret caret_filter"></span> </div>           
                     <input type="hidden" name="filter_search_action[]" value="">
                                                          
                    <ul class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions_mobile">
                      '.$action_select_list.'
                    </ul>        
                  </div>';
                    
            }else if($search_field=='categories'){
                    
                  $return_string='
                  <div class="dropdown form-control">
                  <div data-toggle="dropdown" id="adv_categ_mobile" class="filter_menu_trigger" data-value="all">'.__('All Types','wpestate').' <span class="caret caret_filter"></span> </div>           
                    <input type="hidden" name="filter_search_type[]" value="">
                                                              
                    <ul class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ_mobile">
                      '.$categ_select_list.'
                    </ul>        
                  </div>';

            }  else if($search_field=='cities'){
                    
                    $return_string='
                    <div class="dropdown form-control">
                        <div data-toggle="dropdown" id="advanced_city_mobile" class="filter_menu_trigger" data-value="all">'. __('All Cities','wpestate').' <span class="caret caret_filter"></span> </div>           
                        <input type="hidden" name="advanced_city" value="">
                        <ul id="mobile-adv-city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="advanced_city_mobile">
                            '.$select_city_list.'
                        </ul>        
                    </div> ';
                
           }   else if($search_field=='areas'){

                    $return_string='
                    <div class="dropdown form-control">
                        <div data-toggle="dropdown" id="advanced_area_mobile" class="filter_menu_trigger" data-value="all">'.__('All Areas','wpestate').'<span class="caret caret_filter"></span> </div>           
                        <input type="hidden" name="advanced_area" value="">
                        <ul id="mobile-adv-area"  class="dropdown-menu filter_menu" role="menu" aria-labelledby="advanced_area_mobile">
                            '.$select_area_list.'
                        </ul>        
                   </div>  ';
                
            }    else {
                 // $slug=str_replace(' ','_',$search_field);
                    $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
                    $slug         =   sanitize_key($string);
                    
                    $label=$adv_search_label[$key];
                    if (function_exists('icl_translate') ){
                        $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$label, $label ) ;
                    }
                    
                    $random_id=rand(1,999);
                    $return_string='<input type="text" id="'.$slug.$random_id.'" name="'.$slug.'" placeholder="'.$label.'" value=""  class="advanced_select form-control">';
                    if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller'){
                        print '<script type="text/javascript">
                            //<![CDATA[
                            jQuery(document).ready(function(){
                                    jQuery("#'.$slug.'").datepicker({
                                            dateFormat : "yy-mm-dd"
                                    });
                            });
                            //]]>
                            </script>';
                    }
           

            } 
            print $return_string;
         }
endif; //



function show_extended_search($tip){
    print '<div class="adv_extended_options_text" id="adv_extended_options_text_'.$tip.'">'.__('More Search Options','wpestate').'</div>';
           print '<div class="extended_search_check_wrapper">';
           print '<span id="adv_extended_close_'.$tip.'"><i class="fa fa-times"></i></span>';

           $advanced_exteded   =   get_option( 'wp_estate_advanced_exteded', true); 

           foreach($advanced_exteded as $checker => $value){
               $post_var_name  =   str_replace(' ','_', trim($value) );
               $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
               $input_name     =   sanitize_key($input_name);

               if (function_exists('icl_translate') ){
                   $value     =   icl_translate('wpestate','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
               }

              $value= str_replace('_',' ', trim($value) );
               print '<div class="extended_search_checker"><input type="checkbox" id="'.$input_name.$tip.'" name="'.$input_name.'" value="1" ><label for="'.$input_name.$tip.'">'.$value. '</label></div>';

           }

    print '</div>';    
}



?>