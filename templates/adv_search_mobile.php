<?php
$adv_submit             =   get_adv_search_link();
//  show cities or areas that are empty ?
$args = array(
        'hide_empty'    => true  
        ); 

$show_empty_city_status = esc_html ( get_option('wp_estate_show_empty_city','') );
if ($show_empty_city_status=='yes'){
    $args = array(
        'hide_empty'    => false  
        ); 
}


////////////////////////////////////////////////////////////////////////////////  select actions
$taxonomy           =   'property_action_category';
$tax_terms          =   get_terms($taxonomy,$args);
$action_select_list =   ' <li role="presentation" data-value="all">'. __('All Actions','wpestate').'</li>';

foreach ($tax_terms as $tax_term) {
    $action_select_list     .=  ' <li role="presentation" data-value="'.$tax_term->slug.'">'. ucwords ( urldecode($tax_term->name ) ).'</li>';
  }



//////////////////////////////////////////////////////////////////////////////// select categories
$taxonomy_cat       =   'property_category';
$categories         =   get_terms($taxonomy_cat,$args);
$categ_select_list   =  '<li role="presentation" data-value="all">'. __('All Types','wpestate').'</li>'; 

foreach ($categories as $categ) {
    $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).'</li>';
}


//////////////////////////////////////////////////////////////////////////////// select cities
$select_city_list   =    '<li role="presentation" data-value="all" data-value2="all">'. __('All Cities','wpestate').'</li>';
$taxonomy           =   'property_city';
$tax_terms_city     =   get_terms($taxonomy,$args);

foreach ($tax_terms_city as $tax_term) {
    $string       =   wpestate_limit45 ( sanitize_title ( $tax_term->slug ) );              
    $slug         =   sanitize_key($string);
    $select_city_list     .=   '<li role="presentation" data-value="'.$tax_term->slug.'" data-value2="'.$slug.'">'. ucwords ( urldecode( $tax_term->name) ).'</li>';
}



//////////////////////////////////////////////////////////////////////////////// select areas
$select_area_list   =   '<li role="presentation" data-value="all">'.__('All Areas','wpestate').'</li>';
$taxonomy           =   'property_area';
$tax_terms_area     =   get_terms($taxonomy,$args);

foreach ($tax_terms_area as $tax_term) {
    $term_meta=  get_option( "taxonomy_$tax_term->term_id");
    $string       =   wpestate_limit45 ( sanitize_title ( $term_meta['cityparent'] ) );              
    $slug         =   sanitize_key($string);
    $select_area_list .=   '<li role="presentation" data-value="'.$tax_term->slug.'" data-parentcity="' . $slug . '" >'. ucwords  (urldecode( $tax_term->name ) ).'</li>';
}     



$home_small_map_status              =   esc_html ( get_option('wp_estate_home_small_map','') );
$show_adv_search_map_close          =   esc_html ( get_option('wp_estate_show_adv_search_map_close','') );
$class                              =   'hidden';
$class_close                        =   '';




?>


<div id="adv-search-header-mobile"> 
    <i class="fa fa-search"></i>  
    <?php _e('Advanced Search','wpestate');?> 
</div>   




<div class="adv-search-mobile"  id="adv-search-mobile"> 
   
    <form role="search" method="post"   action="<?php print $adv_submit; ?>" >
         
        
        <?php
        $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
        $adv_search_what        =   get_option('wp_estate_adv_search_what','');
        if ( $custom_advanced_search == 'yes'){
            foreach($adv_search_what as $key=>$search_field){
                wpestate_show_search_field_mobile($search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key);
            }
        }else{
        ?>
         

          <div class="dropdown form-control" >
                  <div data-toggle="dropdown" id="adv_actions_mobile" class="filter_menu_trigger" data-value="all"> <?php _e('All Actions','wpestate');?> <span class="caret caret_filter"></span> </div>           
                  <input type="hidden" name="filter_search_action[]" value="">
                  <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_actions_mobile">
                      <?php print $action_select_list;?>
                  </ul>        
          </div>
        
        
           <div class="dropdown form-control" >
                  <div data-toggle="dropdown" id="adv_categ_mobile" class="filter_menu_trigger" data-value="all"> <?php _e('All Types','wpestate');?> <span class="caret caret_filter"></span> </div>           
                  <input type="hidden" name="filter_search_type[]" value="">
                  <ul class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ_mobile">
                      <?php print $categ_select_list;?>
                  </ul>        
            </div> 
        
            <div class="dropdown form-control" >
                  <div data-toggle="dropdown" id="advanced_city_mobile" class="filter_menu_trigger" data-value="all"> <?php _e('All Cities','wpestate');?> <span class="caret caret_filter"></span> </div>           
                  <input type="hidden" name="advanced_city" value="">
                  <ul  class="dropdown-menu filter_menu" id="mobile-adv-city" role="menu" aria-labelledby="advanced_city_mobile">
                      <?php print $select_city_list;?>
                  </ul>        
            </div>  
        
           <div class="dropdown form-control" >
                  <div data-toggle="dropdown" id="advanced_area_mobile" class="filter_menu_trigger" data-value="all"><?php _e('All Areas','wpestate');?><span class="caret caret_filter"></span> </div>           
                  <input type="hidden" name="advanced_area" value="">
                  <ul class="dropdown-menu filter_menu" id="mobile-adv-area" role="menu" aria-labelledby="advanced_area_mobile">
                      <?php print $select_area_list;?>
                  </ul>        
           </div> 
               
            <input type="text" id="adv_rooms_mobile" class="form-control" name="advanced_rooms"  placeholder="<?php _e('Type Bedrooms No.','wpestate');?>" value="" >       
            <input type="text" id="adv_bath_mobile"  class="form-control" name="advanced_bath"   placeholder="<?php _e('Type Bathrooms No.','wpestate');?>" value="">
            <input type="text" id="price_low_mobile" class="form-control  advanced_select" name="price_low"  placeholder="<?php _e('Type Min. Price','wpestate');?>" value=""/>
            <input type="text" id="price_max_mobile" class="form-control  advanced_select" name="price_max"  placeholder="<?php _e('Type Max. Price','wpestate');?>" value=""/>

        <?php
        }
        
        $extended_search= get_option('wp_estate_show_adv_search_extended','');
        if($extended_search=='yes'){            
            show_extended_search('mobile');
        }
        ?>
      
        
        <button class="wpb_button  wpb_btn-info wpb_btn-large" id="advanced_submit_2_mobile"><?php _e('Search Properties','wpestate');?></button>
        <button class="wpb_button  wpb_btn-info wpb_btn-large" id="showinpage_mobile"><?php _e('See first results here ','wpestate');?></button>
        
        
            <span id="results_mobile"> <?php _e('we found','wpestate')?> <span id="results_no_mobile">0</span> <?php _e('results','wpestate')?> </span>
    </form>   
</div>       