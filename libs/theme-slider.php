<?php

if( !function_exists('wpestate_theme_slider') ):

function  wpestate_theme_slider(){
    $theme_slider   =   get_option( 'wp_estate_theme_slider', true); 
    $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Theme Slider','wpestate').'</h1>'; 
    print '<p>'. __('*hold CTRL for multiple select','wpestate').'</p>';
    $args = array(      'post_type'         =>  'estate_property',
                        'post_status'       =>  'publish',
                        'paged'             =>  0,
                        'posts_per_page'    =>  -1 
                 );

        $recent_posts = new WP_Query($args);
        print '<select name="theme_slider[]"  id="theme_slider"  multiple="multiple">';
        while ($recent_posts->have_posts()): $recent_posts->the_post();
             $theid=get_the_ID();
             print '<option value="'.$theid.'" ';
             if( is_array($theme_slider) && in_array($theid, $theme_slider) ){
                 print ' selected="selected" ';
             }
             print'>'.get_the_title().'</option>';
        endwhile;
        print '</select>';
        
        print '<p>'. __('Number of milisecons before auto cycling an item (5000=5sec).Put 0 if you don\'t want to autoslide.','wpestate').'</p>';
        print '<p><input  type="text" id="slider_cycle" name="slider_cycle"  value="'.$slider_cycle.'"/> </p>';
      
        print '    
        <p class="submit">
           <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
        </p>
        ';

  
    print '</div>';
}



endif;





if( !function_exists('wpestate_present_theme_slider') ):
    function wpestate_present_theme_slider(){
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $currency       =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        => 'estate_property',
                    'post_status'      => 'publish',
                    'post__in'         => $theme_slider
                  );


        $recent_posts = new WP_Query($args);
        $slider_cycle   =   get_option( 'wp_estate_slider_cycle', true); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        print '<div class="theme_slider_wrapper carousel  slide" data-ride="carousel" data-interval="'.$slider_cycle.'" id="estate-carousel">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
               $theid=get_the_ID();
               $slide= get_the_post_thumbnail( $theid, 'property_full_map',$attr );

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                $measure_sys    =   get_option('wp_estate_measure_sys','');
                $price          =   intval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
                $beds           =   intval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   intval( get_post_meta($theid, 'property_bedrooms', true) );
                $size           =   number_format ( intval( get_post_meta($theid, 'property_size', true) ) );

                if($measure_sys=='ft'){
                    $size.=' '.__('ft','wpestate').'<sup>2</sup>';
                }else{
                    $size.=' '.__('m','wpestate').'<sup>2</sup>';
                }
                
                if ($price != 0) {
                   $price = number_format($price);
                   if ($where_currency == 'before') {
                       $price = $currency . ' ' . $price;
                   } else {
                       $price = $price . ' ' . $currency;
                   }
                }else{
                    $price='';
                }


               $slides.= '
               <div class="item '.$active.'">
                    <a href="'.get_permalink().'"> '.$slide.' </a>
                    <div class="slider-content-wrapper">  
                    <div class="slider-content">

                        <h3><a href="'.get_permalink().'">'.get_the_title().'</a> </h3>
                        <span> '. wpestate_strip_words( get_the_excerpt(),20).' ...<a href="'.get_permalink().'" class="read_more">'.__('Read more','wpestate').'<i class="fa fa-angle-right"></i></a></span>

                         <div class="theme-slider-price">
                              '.$price.' '.$price_label.'  
                              <div class="listing-details">
                                <img src="'.get_template_directory_uri().'/img/icon_bed_slider.png"  alt="listings-beds">'.$beds.'
                                <img src="'.get_template_directory_uri().'/img/icon_bath_slider.png" alt="lsitings_baths">'.$baths.'
                                <img src="'.get_template_directory_uri().'/img/icon_size_slider.png" alt="lsitings_size">'.$size.'
                              </div>
                         </div>

                         <a class="carousel-control-theme-next" href="#estate-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                         <a class="carousel-control-theme-prev" href="#estate-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                    </div> 
                    </div>
                </div>';

               $indicators.= '
               <li data-target="#estate-carousel" data-slide-to="'.($counter).'" class="'. $active.'">

               </li>';

               $counter++;
        endwhile;
        wp_reset_query();
        print '<div class="carousel-inner">
                  '.$slides.'
               </div>

               <ol class="carousel-indicators">
                    '.$indicators.'
               </ol>





               </div>';
    } 
endif;

?>
