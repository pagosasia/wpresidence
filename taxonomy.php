<?php
get_header();
$options        =   wpestate_page_details($post->ID);
$filtred        =   0;
$show_compare   =   1;
$compare_submit =   get_compare_link();


// get curency , currency position and no of items per page
global $current_user;
get_currentuserinfo();
$currency           =   esc_html( get_option('wp_estate_currency_symbol','') );
$where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol','') );
$prop_no            =   intval( get_option('wp_estate_prop_no','') );
$userID             =   $current_user->ID;
$user_option        =   'favorites'.$userID;
$curent_fav         =   get_option($user_option);


$taxonmy    = get_query_var('taxonomy');
$term       = get_query_var( 'term' );
$tax_array  = array(
                'taxonomy'  => $taxonmy,
                'field'     => 'slug',
                'terms'     => $term
                );
 
$mapargs = array(
            'post_type'  => 'estate_property',
            'nopaging'   => true,
            'tax_query'  => array(
                                  'relation' => 'AND',
                                  $tax_array
                               )
           );

$selected_pins = wpestate_listing_pins($mapargs);//call the new pins  

?>




<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="<?php print $options['content_class'];?> ">
        <?php //get_template_part('templates/ajax_container'); ?>
        
        <h1 class="entry-title title_prop teste"> 
            <?php 
                _e('Imóveis para ','wpestate');print '"';
                single_cat_title();print '" ';
            ?>
        </h1>
        

                          
        <!--Filters starts here-->     
        <?php  get_template_part('templates/property_list_filters'); ?> 
        <!--Filters Ends here-->   
            
        <?php  get_template_part('templates/compare_list'); ?> 
            
        <!-- Listings starts here -->                   
        <?php  get_template_part('templates/spiner'); ?> 
        
        <div id="listing_ajax_container"> 
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array(
                          'post_type'         => 'estate_property',
                          'post_status'       => 'publish',
                          'paged'             => $paged,
                          'posts_per_page'    => $prop_no ,
                          'meta_key'          => 'prop_featured',
                          'orderby'           => 'meta_value',
                          'order'             => 'DESC',
                          'tax_query'  => array(
                               'relation' => 'AND',
                               $tax_array
                            )
                        );	

            add_filter( 'posts_orderby', 'wpestate_my_order' );
            $prop_selection = new WP_Query($args);
            remove_filter( 'posts_orderby', 'wpestate_my_order' );
            $counter = 0;

            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
                 get_template_part('templates/property_unit');;
            endwhile;
            wp_reset_query();               
        ?>
        </div>
        <!-- Listings Ends  here --> 
        
       
        
        <?php kriesi_pagination($prop_selection->max_num_pages, $range =2); ?>       
    
    </div><!-- end 9col container-->
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   

<?php 
wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', array('markers2'           =>  $selected_pins,));
get_footer(); 
?>