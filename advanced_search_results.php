<?php
// Template Name: Advanced Search Results
// Wp Estate Pack

//print_r($_POST);
get_header();
get_currentuserinfo();
$options        =   wpestate_page_details($post->ID);
$show_compare   =   1;
$area_array     =   ''; 
$city_array     =   '';  
$action_array   =   '';
$categ_array    =   '';

$compare_submit         =   get_compare_link();
$currency               =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency         =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$prop_no                =   intval ( get_option('wp_estate_prop_no', '') );
$show_compare_link      =   'yes';
$userID                 =   $current_user->ID;
$user_option            =   'favorites'.$userID;
$curent_fav             =   get_option($user_option);
$custom_advanced_search =   get_option('wp_estate_custom_advanced_search','');
$meta_query             =   array();
           


if($custom_advanced_search==='yes'){ // we have CUSTOM advanced search
    //get custom search fields
    $adv_search_what    = get_option('wp_estate_adv_search_what','');
    $adv_search_how     = get_option('wp_estate_adv_search_how','');
    $adv_search_label   = get_option('wp_estate_adv_search_label','');                    
    $adv_search_type    = get_option('wp_estate_adv_search_type','');


    foreach($adv_search_what as $key=>$term){
        if($term=='none'){
                           
        }
        else if($term=='categories'){ // for property_category taxonomy
                if (isset($_POST['filter_search_type']) && $_POST['filter_search_type'][0]!='all' && $_POST['filter_search_type'][0]!=''){
                    $taxcateg_include   =   array();

                    foreach($_POST['filter_search_type'] as $key=>$value){
                        $taxcateg_include[]= sanitize_title($value);
                    }

                    $categ_array=array(
                         'taxonomy' => 'property_category',
                         'field' => 'slug',
                         'terms' => $taxcateg_include
                    );
                } 
        } /////////// end if categories
       

        else if($term=='types'){ // for property_action_category taxonomy
                if ( ( isset($_POST['filter_search_action']) && $_POST['filter_search_action'][0]!='all' && $_POST['filter_search_action'][0]!='' ) ){
                    $taxaction_include   =   array();   

                    foreach( $_POST['filter_search_action'] as $key=>$value){
                        $taxaction_include[]= sanitize_title ($value);
                    }

                    $action_array=array(
                        'taxonomy'  => 'property_action_category',
                        'field'     => 'slug',
                        'terms'     => $taxaction_include
                    );
                }
        } //////////// end for property_action_category taxonomy


        else if($term=='cities'){ // for property_city taxonomy
                if (isset($_POST['advanced_city']) && $_POST['advanced_city'] != 'all' && $_POST['advanced_city'] != '' ) {
                    $taxcity[]  = sanitize_title ( $_POST['advanced_city'] );
                    $city_array = array(
                        'taxonomy'  => 'property_city',
                        'field'     => 'slug',
                        'terms'     => $taxcity
                    );
                }
        } //////////// end for property_city taxonomy

        else if($term=='areas'){ // for property_area taxonomy

                if (isset($_POST['advanced_area']) && $_POST['advanced_area'] != 'all' &&  $_POST['advanced_area'] != '') {
                    $taxarea[]  = sanitize_title($_POST['advanced_area']);
                    $area_array = array(
                        'taxonomy' => 'property_area',
                        'field' => 'slug',
                        'terms' => $taxarea
                    );
                }
        } //////////// end for property_area taxonomy


        else{ 

         //   $slug_name         =   wpestate_limit45(sanitize_title( $term ));
         //   $slug_name         =   sanitize_key($slug_name);
         //   $slug_name_key     =   $slug_name; 
           
                
            $term         =   str_replace(' ', '_', $term);
            $slug         =   wpestate_limit45(sanitize_title( $term )); 
            $slug         =   sanitize_key($slug); 
            
            $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
            $slug_name    =   sanitize_key($string);
            
                
            if( isset($_POST[$slug_name]) && $adv_search_label[$key] != $_POST[$slug_name] && $_POST[$slug_name] != ''){ // if diffrent than the default values
                    $compare        =   '';
                    $search_type    =   ''; 
                    $compare_array  =   array();
                    $allowed_html   =   array();
                     //$adv_search_how
                    
                 

                    $compare=$adv_search_how[$key];

                    if($compare=='equal'){
                       $compare='='; 
                       $search_type='numeric';
                       $term_value= floatval ( $_POST[$slug_name] );

                    }else if($compare=='greater'){
                        $compare='>='; 
                        $search_type='numeric';
                        $term_value= floatval ( $_POST[$slug_name] );

                    }else if($compare=='smaller'){
                        $compare='<='; 
                        $search_type='numeric';
                        $term_value= floatval ( $_POST[$slug_name] );

                    }else if($compare=='like'){
                        $compare='LIKE'; 
                        $search_type='CHAR';
                        $term_value= wp_kses( $_POST[$slug_name] ,$allowed_html);

                    }else if($compare=='date bigger'){
                        $compare='>='; 
                        $search_type='DATE';
                        $term_value= wp_kses( $_POST[$slug_name],$allowed_html );

                    }else if($compare=='date smaller'){
                        $compare='<='; 
                        $search_type='DATE';
                        $term_value= wp_kses( $_POST[$slug_name],$allowed_html );
                    }

                    $compare_array['key']        = $slug;
                    $compare_array['value']      = $term_value;
                    $compare_array['type']       = $search_type;
                    $compare_array['compare']    = $compare;
                    $meta_query[]                = $compare_array;

          }// end if diffrent
        }////////////////// end last else
     } ///////////////////////////////////////////// end for each adv search term

}else{ // no advanced search
                    
    //////////////////////////////////////////////////////////////////////////////////////
    ///// category filters 
    //////////////////////////////////////////////////////////////////////////////////////

    if (isset($_POST['filter_search_type']) && $_POST['filter_search_type'][0]!='all' && $_POST['filter_search_type'][0]!='' ){
            $taxcateg_include   =   array();

            foreach($_POST['filter_search_type'] as $key=>$value){
                $taxcateg_include[]= sanitize_title ( $value );
            }

            $categ_array=array(
                 'taxonomy'     => 'property_category',
                 'field'        => 'slug',
                 'terms'        => $taxcateg_include
            );
     }

    //////////////////////////////////////////////////////////////////////////////////////
    ///// action  filters 
    //////////////////////////////////////////////////////////////////////////////////////

      if ( ( isset($_POST['filter_search_action']) && $_POST['filter_search_action'][0]!='all' && $_POST['filter_search_action'][0]!='') ){
            $taxaction_include   =   array();   

            foreach( $_POST['filter_search_action'] as $key=>$value){
                $taxaction_include[]    = sanitize_title ( $value );
            }

            $action_array=array(
                 'taxonomy'     => 'property_action_category',
                 'field'        => 'slug',
                 'terms'        => $taxaction_include
            );
     }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// city filters 
    //////////////////////////////////////////////////////////////////////////////////////

     if (isset($_POST['advanced_city']) and $_POST['advanced_city'] != 'all' && $_POST['advanced_city'] != '') {
         $taxcity[] = sanitize_title ( ($_POST['advanced_city']) );
         $city_array = array(
             'taxonomy'     => 'property_city',
             'field'        => 'slug',
             'terms'        => $taxcity
         );
     }

    //////////////////////////////////////////////////////////////////////////////////////
    ///// area filters 
    //////////////////////////////////////////////////////////////////////////////////////

     if (isset($_POST['advanced_area']) and $_POST['advanced_area'] != 'all' && $_POST['advanced_area'] != '') {
         $taxarea[] = sanitize_title (  ($_POST['advanced_area']) );
         $area_array = array(
             'taxonomy'     => 'property_area',
             'field'        => 'slug',
             'terms'        => $taxarea
         );
     }

    //////////////////////////////////////////////////////////////////////////////////////
    ///// rooms and baths filters 
    //////////////////////////////////////////////////////////////////////////////////////

     $meta_query = $rooms = $baths = $price = array();
     if (isset($_POST['advanced_rooms']) && is_numeric($_POST['advanced_rooms'])) {
         $rooms['key'] = 'property_bedrooms';
         $rooms['value'] = floatval ($_POST['advanced_rooms']);
         $meta_query[] = $rooms;
     }

     if (isset($_POST['advanced_bath']) && is_numeric($_POST['advanced_bath'])) {
         $baths['key'] = 'property_bathrooms';
         $baths['value'] = floatval ($_POST['advanced_bath']);
         $meta_query[] = $baths;
     }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// price filters 
    //////////////////////////////////////////////////////////////////////////////////////
    $price_low ='';
    if( isset($_POST['price_low'])){
        $price_low         = intval($_POST['price_low']);
        $price['key']      = 'property_price';
        $price['value']    = $price_low;
        $price['type']     = 'numeric';
        $price['compare']  = '>='; 
        $meta_query[]     = $price;
    }

    $price_max='';
    if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
        $price_max         = intval($_POST['price_max']);
        $price['key']      = 'property_price';
        $price['value']    = $price_max;
        $price['type']     = 'numeric';
        $price['compare']  = '<='; 
        $meta_query[] = $price;
    }

} // end ? custom advnced search
                



//////////////////////////////////////////////////////////////////////////////////////
///// features and ammenities
//////////////////////////////////////////////////////////////////////////////////////

$feature_list_array =   array();
$feature_list       =   esc_html( get_option('wp_estate_feature_list') );
$feature_list_array =   explode( ',',$feature_list);

foreach($feature_list_array as $checker => $value){
    $post_var_name  =   str_replace(' ','_', trim($value) );
    $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
    $input_name     =   sanitize_key($input_name);
                
    if ( isset( $_POST[$input_name] ) && $_POST[$input_name]==1 ){

        $feature=array();
        $feature['key']         = $input_name;
        $feature['value']       = 1;
        $feature['type']        = '=';
        $feature['compare']     = 'CHAR';
        $meta_query[]           = $feature;
    }
}








  $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            if($paged>1){

               $meta_query= get_option('wpestate_pagination_meta_query','');
               $categ_array= get_option('wpestate_pagination_categ_query','');
               $action_array= get_option('wpestate_pagination_action_query','');
               $city_array= get_option('wpestate_pagination_city_query','');
               $area_array=get_option('wpestate_pagination_area_query','');
            }else{
                update_option('wpestate_pagination_meta_query',$meta_query);
                update_option('wpestate_pagination_categ_query',$categ_array);
                update_option('wpestate_pagination_action_query',$action_array);
                update_option('wpestate_pagination_city_query',$city_array);
                update_option('wpestate_pagination_area_query',$area_array);

            }
                            
                            
//////////////////////////////////////////////////////////////////////////////////////
///// compose query 
//////////////////////////////////////////////////////////////////////////////////////
    $args = array(
        'post_type'       => 'estate_property',
        'post_status'     => 'publish',
        'paged'           => $paged,
        'posts_per_page'  => 30,
        'meta_key'        => 'prop_featured',
        'orderby'         => 'meta_value',
        'order'           => 'DESC',
        'meta_query'      => $meta_query,
        'tax_query'       => array(
                                   'relation' => 'AND',
                                   $categ_array,
                                   $action_array,
                                   $city_array,
                                   $area_array
                               )
    );

    $mapargs = array(
        'post_type'     => 'estate_property',
        'post_status'   => 'publish',
        'posts_per_page' => -1,
        'nopaging'      => true,
        'meta_query'    => $meta_query,
        'tax_query'     => array(
                               'relation' => 'AND',
                               $categ_array,
                               $action_array,
                               $city_array,
                               $area_array
                            )
    );

  //  print_r($args);
    add_filter( 'posts_orderby', 'wpestate_my_order' );
    $prop_selection =   new WP_Query($args);
    remove_filter( 'posts_orderby', 'wpestate_my_order' );
    $num = $prop_selection->found_posts;
    $selected_pins  =   wpestate_listing_pins($mapargs);//call the new pins               
?>



<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print $options['content_class'];?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php while (have_posts()) : the_post(); ?>
        <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) == 'yes') { ?>
              <h1 class="entry-title title_prop"><?php the_title(); print " (".$num.")" ?></h1>                
        <?php } ?>
        <div class="single-content"><?php the_content();?></div>
        <?php endwhile; // end of the loop.
        $compare_submit =   get_compare_link();  ?>  
              
        <?php  get_template_part('templates/compare_list'); ?>       
              
        
        <div id="listing_ajax_container"> 
        <?php 

    
   

        if ($prop_selection->have_posts()){    
            while ($prop_selection->have_posts()): $prop_selection->the_post();
                get_template_part('templates/property_unit');
            endwhile;
        }else{   
            print '<div class="bottom_sixty">';
            _e('We didn\'t find any results. Please try again with different search parameters. ','wpestate');
            print '</div>';
        }
        wp_reset_query();
        ?>   
  
        </div>
        <!-- Listings Ends  here --> 
        <?php kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
    
    </div><!-- end 9col container-->
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   

<?php 
wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', 
    array(  
        'markers2'           =>  $selected_pins,
    )
);
get_footer(); 
?>