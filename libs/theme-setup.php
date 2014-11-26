<?php
///////////////////////////////////////////////////////////////////////////////////////////
/////// Theme Setup
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wp_estate_setup') ):
function wp_estate_setup() {    
      if (isset($_GET['activated']) && is_admin()){
             ////////////////////  insert comapre and advanced search page
        $page_check = get_page_by_title('Compare Listings');
        if (!isset($page_check->ID)) {
            $my_post = array(
                'post_title' => 'Compare Listings',
                'post_type' => 'page',
                'post_status' => 'publish',
            );
            $new_id = wp_insert_post($my_post);
            update_post_meta($new_id, '_wp_page_template', 'compare_listings.php');
        }
        
        
        ////////////////////  insert comapre and advanced search page 
        $page_check = get_page_by_title('Advanced Search');
        if (!isset($page_check->ID)) {
            $my_post = array(
                'post_title' => 'Advanced Search',
                'post_type' => 'page',
                'post_status' => 'publish',
            );
            $new_id = wp_insert_post($my_post);
            update_post_meta($new_id, '_wp_page_template', 'advanced_search_results.php');
        }
          
        ////////////////////  insert sales and rental categories 
        $actions = array(   'Rentals',
                            'Sales'
                        );

        foreach ($actions as $key) {
            $my_cat = array(
                'description' => $key,
                'slug' => $key
            );

            if(!term_exists($key, 'property_action_category') ){
                wp_insert_term($key, 'property_action_category', $my_cat);
            }
        }

        ////////////////////  insert listings type categories 
        $actions = array(   'Apartments', 
                            'Houses', 
                            'Land', 
                            'Industrial',
                            'Offices',
                            'Retail',
                            'Condos',
                            'Duplexes',
                            'Villas'
                        );

        foreach ($actions as $key) {
            $my_cat = array(
                'description' => $key,
                'slug' => str_replace(' ', '-', $key)
            );
        
            if(!term_exists($key, 'property_category') ){
                wp_insert_term($key, 'property_category', $my_cat);
            }
        }      
      }// end if activated
      
      
        add_option('wp_estate_show_top_bar_user_login','no');
        add_option('wp_estate_show_top_bar_user_menu','no');
        add_option('wp_estate_show_adv_search_general','yes');
       
        add_option('wp_estate_currency_symbol', '$');
        add_option('wp_estate_where_currency_symbol', 'before');
        add_option('wp_estate_measure_sys','ft');
        add_option('wp_estate_facebook_login', 'no');
        add_option('wp_estate_google_login', 'no');
        add_option('wp_estate_yahoo_login', 'no');
        add_option('wp_estate_wide_status', 1);
        add_option('wp_estate_header_type', 4);      
        add_option('wp_estate_prop_no', '12');
        add_option('wp_estate_show_empty_city', 'no');
        add_option('wp_estate_blog_sidebar', 'right');
        add_option('wp_estate_blog_sidebar_name', 'primary-widget-area');
        add_option('wp_estate_blog_unit', 'normal');
        add_option('wp_estate_general_latitude', '40.781711');
        add_option('wp_estate_general_longitude', '-73.955927');
        add_option('wp_estate_default_map_zoom', '15');
        add_option('wp_estate_cache', 'no');
        add_option('wp_estate_show_adv_search_map_close', 'yes');
        add_option('wp_estate_pin_cluster', 'yes');
        add_option('wp_estate_zoom_cluster', 10);
        add_option('wp_estate_hq_latitude', '40.781711');
        add_option('wp_estate_hq_longitude', '-73.955927');
        add_option('wp_estate_idx_enable', 'no');
        add_option('wp_estate_geolocation_radius', 1000);
        add_option('wp_estate_min_height', 300);
        add_option('wp_estate_max_height', 450);
        add_option('wp_estate_keep_min', 'no');

        add_option('wp_estate_paid_submission', 'no');
        add_option('wp_estate_admin_submission', 'yes');
        add_option('wp_estate_user_agent', 'no');
        add_option('wp_estate_price_submission', 0);
        add_option('wp_estate_price_featured_submission', 0);
        add_option('wp_estate_submission_curency', 'USD');
        add_option('wp_estate_paypal_api', 'sandbox');     
        add_option('wp_estate_free_mem_list', 0);
        add_option('wp_estate_free_feat_list', 0);
        
        $custom_fields=array(
                    array('property year','Year Built','date',1),
                    array('property garage','Garages','short text',2),
                    array('property garage size','Garage Size','short text',3),
                    array('property date','Available from','short text',4),
                    array('property basement','Basement','short text',5),
                    array('property external construction','external construction','short text',6),
                    array('property roofing','Roofing','short text',7),
                    );
        add_option( 'wp_estate_custom_fields', $custom_fields); 
        
        add_option('wp_estate_custom_advanced_search', 'no');
        add_option('wp_estate_adv_search_type', 1);
        add_option('wp_estate_show_adv_search', 'yes');
        add_option('wp_estate_show_adv_search_map_close', 'yes');
        add_option('wp_estate_cron_run', time());
        $default_feature_list='attic, gas heat, ocean view, wine cellar, basketball court, gym,pound, fireplace, lake view, pool, back yard, front yard, fenced yard, sprinklers, washer and dryer, deck, balcony, laundry, concierge, doorman, private space, storage, recreation, roof deck';
        add_option('wp_estate_feature_list', $default_feature_list);
        add_option('wp_estate_show_no_features', 'yes');
        
        add_option('wp_estate_property_features_text', 'Property Features');
        add_option('wp_estate_property_description_text', 'Property Description');
        add_option('wp_estate_property_details_text',  'Property Details ');
        $default_status_list='open house, sold';
        add_option('wp_estate_status_list', $default_status_list);
        add_option( 'wp_estate_slider_cycle', 0); 
        
        
        add_option('wp_estate_color_scheme', 'no');
        
        
        add_option('wp_estate_main_color', '3C90BE');
        add_option('wp_estate_background_color', 'f3f3f3');
        add_option('wp_estate_content_back_color', 'ffffff');
        add_option('wp_estate_header_color', 'ffffff');
        add_option('wp_estate_breadcrumbs_font_color', '99a3b1');
        add_option('wp_estate_font_color', '768082');
      
         /* --- */add_option('wp_estate_link_color', '#a171b');
        add_option('wp_estate_headings_color', '434a54');     
        add_option('wp_estate_sidebar_heading_boxed_color', '434a54');
        add_option('wp_estate_sidebar_heading_color', '434a54');
        add_option('wp_estate_sidebar_widget_color', 'fdfdfd');
        add_option('wp_estate_sidebar2_font_color', '888C8E');
        add_option('wp_estate_footer_back_color', '282D33');
        add_option('wp_estate_footer_font_color', '72777F');
        add_option('wp_estate_footer_copy_color', '72777F');
        add_option('wp_estate_menu_font_color', '434a54');
        add_option('wp_estate_menu_hover_back_color', '3C90BE');
        add_option('wp_estate_menu_hover_font_color', 'ffffff');
        add_option('wp_estate_top_bar_back', 'fdfdfd');
        add_option('wp_estate_top_bar_font', '1a171b');
        add_option('wp_estate_adv_search_back_color', 'fdfdfd');
        add_option('wp_estate_adv_search_font_color', '1a171b');
        add_option('wp_estate_box_content_back_color', 'fdfdfd');
        add_option('wp_estate_box_content_border_color', 'f0f0f0');
        add_option('wp_estate_show_g_search', 'no');
        add_option('wp_estate_show_adv_search_extended', 'no');
        
}
endif; // end   wp_estate_setup  
?>