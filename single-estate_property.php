<?php
// Index Page
// Wp Estate Pack
get_header();
global $current_user;
global $feature_list_array;
global $propid ;
get_currentuserinfo();
$propid                     =   $post->ID;
$options                    =   wpestate_page_details($post->ID);
$gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
$gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
$unit                       =   esc_html( get_option('wp_estate_measure_sys', '') );
$currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );

if (function_exists('icl_translate') ){
    $where_currency             =   icl_translate('wpestate','wp_estate_where_currency_symbol', esc_html( get_option('wp_estate_where_currency_symbol', '') ) );
    $property_description_text  =   icl_translate('wpestate','wp_estate_property_description_text', esc_html( get_option('wp_estate_property_description_text') ) );
    $property_details_text      =   icl_translate('wpestate','wp_estate_property_details_text', esc_html( get_option('wp_estate_property_details_text') ) );
    $property_features_text     =   icl_translate('wpestate','wp_estate_property_features_text', esc_html( get_option('wp_estate_property_features_text') ) );
    $property_adr_text          =   icl_translate('wpestate','wp_estate_property_adr_text', esc_html( get_option('wp_estate_property_adr_text') ) );    
}else{
    $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $property_description_text  =   esc_html( get_option('wp_estate_property_description_text') );
    $property_details_text      =   esc_html( get_option('wp_estate_property_details_text') );
    $property_features_text     =   esc_html( get_option('wp_estate_property_features_text') );
    $property_adr_text          =   stripslashes ( esc_html( get_option('wp_estate_property_adr_text') ) );
}


$agent_id                   =   '';
$content                    =   '';
$userID                     =   $current_user->ID;
$user_option                =   'favorites'.$userID;
$curent_fav                 =   get_option($user_option);
$favorite_class             =   'isnotfavorite'; 
$favorite_text              =   __('add to favorites','wpestate');
$feature_list               =   esc_html( get_option('wp_estate_feature_list') );
$feature_list_array         =   explode( ',',$feature_list);
$pinteres                   =   array();
$property_city              =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
$property_area              =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
$property_action            =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '');   
$slider_size                =   'small';

if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
        $favorite_class =   'isfavorite';     
        $favorite_text  =   __('favorite','wpestate');
    } 
}

if (has_post_thumbnail()){
    $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
}


if($options['content_class']=='col-md-12'){
    $slider_size='full';
}

?>


<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print $options['content_class'];?> ">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php
        while (have_posts()) : the_post();
            $price          =   intval   ( get_post_meta($post->ID, 'property_price', true) );
            $price_label    =   esc_html ( get_post_meta($post->ID, 'property_label', true) );  
            $image_id       =   get_post_thumbnail_id();
            $image_url      =   wp_get_attachment_image_src($image_id, 'property_full_map');
            $full_img       =   wp_get_attachment_image_src($image_id, 'full');
            $image_url      =   $image_url[0];
            $full_img       =   $full_img [0];     
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
        ?>
        
        <h1 class="entry-title entry-prop"><?php the_title(); ?></h1>   
        <span class="price_area"><?php print $price; ?><?php print ' '.$price_label; ?></span>
        <div class="single-content listing-content">
            
          
             
        <?php            
      

        $status = esc_html( get_post_meta($post->ID, 'property_status', true) );    
        if (function_exists('icl_translate') ){
            $status     =   icl_translate('wpestate','wp_estate_property_status_'.$status, $status ) ;                                      
        }

        ?>
            
            
        <div class="notice_area">           
            
            <div class="property_location">
                <?php 
                $pessoas = get_post_meta($post->ID, 'property_rooms', true);
                $quartos = get_post_meta($post->ID, 'property_bedrooms', true);
                if( $pessoas > 1){
                    $pluralp = "s"; 
                }
                if( $quartos > 1){
                    $pluralq = "s"; 
                }
                
                print '<span class="info-pessoas">'.$pessoas.' pessoa'.$pluralp.'</span>';
                print '<span class="info-quartos">'.$quartos.' quarto'.$pluralq.'</span>';
                ?>
            </div>            
        </div>    
            
        <?php //print 'Status:'.$status.'</br>'; ?>

        <?php get_template_part('templates/listingslider'); ?>
            
         
            
        <?php
            $content = get_the_content();
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);

            if($content!=''){                            
                print $content;     
            }
        ?>
        
            
            <div class="panel-group property-panel" id="accordion_prop_addr">
                <div class="panel panel-default">
                   <div class="panel-heading">
                       <a data-toggle="collapse" data-parent="#accordion_prop_addr" href="#collapseTwo">
                         <h4 class="panel-title">  
                         <?php if($property_adr_text!=''){
                             echo $property_adr_text;
                         } else{
                             _e('Property Address','wpestate');
                         }
                         ?>
                         </h4>    
                       </a>
                   </div>
                   <div id="collapseTwo" class="panel-collapse collapse in">
                     <div class="panel-body">
                     <?php print estate_listing_address($post->ID); ?>
                     </div>
                   </div>
                </div>            
            </div>     



            <div class="panel-group property-panel" id="accordion_prop_details">  
                <div class="panel panel-default">
                    <div class="panel-heading">
                         <?php                      
                         if($property_details_text=='') {
                             print'<a data-toggle="collapse" data-parent="#accordion_prop_details" href="#collapseOne"><h4 class="panel-title" id="prop_det">'.__('Property Details', 'wpestate').'  </h4></a>';
                         }else{
                             print'<a data-toggle="collapse" data-parent="#accordion_prop_details" href="#collapseOne"><h4 class="panel-title"  id="prop_det">'.$property_details_text.'  </h4></a>';
                         }
                         ?>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in">
                      <div class="panel-body">
                      <?php print estate_listing_details($post->ID);?>
                      </div>
                    </div>
                </div>
            </div>



            <!-- Features and Ammenties -->
            <?php 
       
            if ( count( $feature_list_array )!=0 && !count( $feature_list_array )!=1 ){ //  if are features and ammenties

            ?>      
            <div class="panel-group property-panel" id="accordion_prop_features">  
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#accordion_prop_features" href="#collapseThree">
                          <?php
                            if($property_features_text ==''){
                                print '<h4 class="panel-title" id="prop_ame">'.__('Amenities and Features', 'wpestate').'</h4>';
                            }else{
                                print '<h4 class="panel-title" id="prop_ame">'. $property_features_text.'</h4>';
                            }
                          ?>
                        </a>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse in">
                      <div class="panel-body">
                      <?php print estate_listing_features($post->ID); ?>
                      </div>
                    </div>
                </div>
            </div>  
            <?php
            } // end if are features and ammenties
                
            $categorias_imovel =  wp_get_object_terms($post->ID, "property_category");  
            $temporada = false;
            for($aux = 0; $aux < count($categorias_imovel); $aux++){
                if($categorias_imovel[$aux]->slug == 'temporada'){
                    $temporada = true;
                }
            }   
    
            ?>
            <?php if($temporada){ ?> 
            <div class="panel-group property-panel" id="accordion_prop_features">  
                <div class="panel panel-default">
                    <div class="panel-heading temporada">
                        <a data-toggle="collapse" data-parent="#accordion_prop_features" href="#collapseThree">
                          <?php
                            print '<h4 class="panel-title" id="prop_ame">Valores por Temporada</h4>';
                          ?>
                        </a>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse in">
                      <div class="panel-body">
                      <?php print estate_listing_temporada($post->ID); ?> 
                      </div>
                    </div>
                </div>
            </div> 
            <div class="botao-reserva"><a href="reserva-de-imovel?id=<?php echo $post->ID; ?>"><input type="submit" value="Fazer Reserva" class="wpcf7-form-control wpcf7-submit"></a></div>

            <?php print temporadas_disponiveis($post->ID); ?> 

            <?php } ?>
            
            
            <!-- END Features and Ammenties -->
    
        <?php 
        wp_reset_query();

        endwhile; // end of the loop
        $show_compare=1;
        get_template_part ('/templates/agent_area');
        //get_template_part ('/templates/similar_listings');
     
        ?>
        </div><!-- end single content -->
    </div><!-- end 9col container-->
    
<?php  include(locate_template('sidebar.php')); ?>
</div>   

<?php get_footer(); ?>