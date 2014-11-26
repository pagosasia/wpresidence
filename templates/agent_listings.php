<!-- GET AGENT LISTINGS-->
<?php
global $agent_id;
global $current_user;
global $leftcompare;

get_currentuserinfo();

$userID             =   $current_user->ID;
$user_option        =   'favorites'.$userID;
$curent_fav         =   get_option($user_option);
$show_compare_link  =   'no';
$currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$leftcompare        =   1;

$args = array(
    'post_type'         => 'estate_property',
    'post_status'       => 'publish',
    'paged'             => $paged,
    'posts_per_page'    => 30,
    'meta_key'          => 'prop_featured',
    'orderby'           => 'meta_value',
    'order'             => 'DESC',
    'meta_query'        => array(
                                array(
                                    'key'   => 'property_agent',
                                    'value' => $agent_id,
                                )
                        )
                );

$prop_selection =   new WP_Query($args);
$selected_pins  =   wpestate_listing_pins($args);//call the new pins


if ( $prop_selection->have_posts() ) {
    $show_compare   =   1;
    $compare_submit =   get_compare_link();
    ?>
    <div class="mylistings">
        <?php  get_template_part('templates/compare_list'); ?> 
        <?php   
        print'<h3 class="agent_listings_title">'.__('My Listings','wpestate').'</h3>';
        while ($prop_selection->have_posts()): $prop_selection->the_post();                     
           get_template_part('templates/property_unit');  
        endwhile; ?>
    </div>

<?php        
} ?>
    

<?php wp_localize_script('googlecode_regular', 'googlecode_regular_vars2', array( 'markers2' =>  $selected_pins) ); ?>