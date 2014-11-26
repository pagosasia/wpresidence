<?php
global $current_adv_filter_search_label;
global $current_adv_filter_category_label;
global $current_adv_filter_city_label;
global $current_adv_filter_area_label;

$current_name      =   '';
$current_slug      =   '';
$listings_list     =   '';
$show_filter_area  =   get_post_meta($post->ID, 'show_filter_area', true);

if( is_tax() ){
    $show_filter_area = 'yes';
    $current_adv_filter_search_label    =__('All Actions','wpestate');
    $current_adv_filter_category_label  =__('All Types','wpestate');
    $current_adv_filter_city_label      =__('All Cities','wpestate');
    $current_adv_filter_area_label      =__('All Areas','wpestate');
    $taxonmy                            = get_query_var('taxonomy');
//  $term                               = get_query_var( 'name' );
    $term                               = single_cat_title('',false);
    
    if ($taxonmy == 'property_city'){
        $current_adv_filter_city_label = ucwords( str_replace('-',' ',$term) );
    }
    if ($taxonmy == 'property_area'){
        $current_adv_filter_area_label = ucwords( str_replace('-',' ',$term) );
    }
    if ($taxonmy == 'property_category'){
        $current_adv_filter_category_label = ucwords( str_replace('-',' ',$term) );
    }
    if ($taxonmy == 'property_action_category'){
        $current_adv_filter_search_label = ucwords( str_replace('-',' ',$term) );
    }
    
}


$selected_order         = __('Sort by','wpestate');
$listing_filter         = get_post_meta($post->ID, 'listing_filter',true );
$listing_filter_array   = array(
                            "1"=>__('Price High to Low','wpestate'),
                            "2"=>__('Price Low to High','wpestate'),
                            "0"=>__('Default','wpestate')
                        );
    

// show or not empty taxonomies
$args = array(
        'hide_empty'    => true  
        ); 
$show_empty_city_status = esc_html ( get_option('wp_estate_show_empty_city','') );
if ($show_empty_city_status=='yes'){
    $args = array(
        'hide_empty'    => false  
        ); 
}



foreach($listing_filter_array as $key=>$value){
    $listings_list.= '<li role="presentation" data-value="'.$key.'">'.$value.'</li>';

    if($key==$listing_filter){
        $selected_order=$value;
    }
}   
      

$order_class='';
if( $show_filter_area != 'yes' ){
    $order_class=' order_filter_single ';  
}


        
if( $show_filter_area=='yes' ){

        if ( is_tax() ){
            $curent_term    =   get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $current_slug   =   $curent_term->slug;
            $current_name   =   $curent_term->name;
            $current_tax    =   $curent_term->taxonomy; 
        }


        ///////////////////////////////////  select actions
        $taxonomy       =   'property_action_category';
        $tax_terms      =   get_terms($taxonomy,$args);

        $action_select_list =   ' <li role="presentation" data-value="">'. __('All Actions','wpestate').'</li>';
        foreach ($tax_terms as $tax_term) {
            $action_select_list     .=  ' <li role="presentation" data-value="'.$tax_term->slug.'">'. ucwords ( $tax_term->name ).'</li>';
        }

        /////////////////////////////////// select categories
        $taxonomy_cat   =   'property_category';
        $categories     =   get_terms($taxonomy_cat,$args);

        $cate_select_list   =  '<li role="presentation" data-value="">'. __('All Types','wpestate').'</li>'; 
        foreach ($categories as $categ) {
            $cate_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( $categ->name ).'</li>';
        }


        /////////////////////////////////// select cities
      
        $select_city_list   =    '<li role="presentation" data-value="all">'. __('All Cities','wpestate').'</li>';
        $taxonomy           =   'property_city';
        $tax_terms_city     =   get_terms($taxonomy,$args);

        foreach ($tax_terms_city as $tax_term) {
            $string       =   wpestate_limit45 ( sanitize_title ( $tax_term->slug ) );              
            $slug         =   sanitize_key($string);
            $select_city_list     .=   '<li role="presentation" data-value="'.$slug.'">'. ucwords ( $tax_term->name ).'</li>';
        }
        
        


        /////////////////////////////////// select areas
        $select_area_list   =   '<li role="presentation" data-value="all">'.__('All Areas','wpestate').'</li>';
        $taxonomy           =   'property_area';
        $tax_terms_area     =   get_terms($taxonomy,$args);

        foreach ($tax_terms_area as $tax_term) {
            $term_meta=  get_option( "taxonomy_$tax_term->term_id");
            $string       =   wpestate_limit45 ( sanitize_title ( $term_meta['cityparent'] ) );              
            $slug         =   sanitize_key($string);
            $select_area_list .=   '<li role="presentation"  data-value="'.$tax_term->slug.'"  data-parentcity="' . $slug . '">'. ucwords ( $tax_term->name ).'</li>';
        }    
        

}// end if show filter

?>

    <?php if( $show_filter_area=='yes' ){?>
    <div class="listing_filters_head"> 
        <input type="hidden" id="page_idx" value="<?php print $post->ID?>">
      
            <?php     
            if( !empty($tax_terms) ){ ?>
                <div class="dropdown listing_filter_select" >
                  <div data-toggle="dropdown" id="a_filter_action" class="filter_menu_trigger"> <?php print $current_adv_filter_search_label;?> <span class="caret caret_filter"></span> </div>           
                  <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_action">
                      <?php print $action_select_list;?>
                  </ul>        
                </div>
            <?php
            }
            ?>



            <?php
             if( !empty($categories) ){ ?>
                <div class="dropdown listing_filter_select" >
                  <div data-toggle="dropdown" id="a_filter_categ" class="filter_menu_trigger"> <?php print $current_adv_filter_category_label;?> <span class="caret caret_filter"></span> </div>           
                  <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_categ">
                      <?php print $cate_select_list;?>
                  </ul>        
                </div>                           
             <?php   
             }
             ?>


     
        
                <div class="dropdown listing_filter_select" >
                  <div data-toggle="dropdown" id="a_filter_cities" class="filter_menu_trigger"> <?php print $current_adv_filter_city_label;?> <span class="caret caret_filter"></span> </div>           
                  <ul id="filter_city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_cities">
                      <?php print $select_city_list;?>
                  </ul>        
                </div>  
       
                
                <div class="dropdown listing_filter_select" >
                  <div data-toggle="dropdown" id="a_filter_areas" class="filter_menu_trigger"><?php print $current_adv_filter_area_label;?><span class="caret caret_filter"></span> </div>           
                  <ul id="filter_area" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_areas">
                      <?php print $select_area_list;?>
                  </ul>        
                </div> 
       
       
        
        <div class="dropdown listing_filter_select order_filter <?php print $order_class;?>">
             <div data-toggle="dropdown" id="a_filter_order" class="filter_menu_trigger" data-value="1"> <?php print $selected_order; ?> <span class="caret caret_filter"></span> </div>           
             <ul id="filter_order" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_filter_order">
                 <?php print $listings_list; ?>                   
             </ul>        
        </div> 


        <div class="listing_filter_select listing_filter_views">
            <div id="grid_view" class="icon_selected"> 
                <i class="fa fa-th"></i>
            </div>
        </div>

        <div class="listing_filter_select listing_filter_views">
             <div id="list_view">
                 <i class="fa fa-bars"></i>                   
             </div>
        </div>
        
    </div> 
    <?php } ?>      