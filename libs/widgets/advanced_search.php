<?php
class Advanced_Search_widget extends WP_Widget {
    
    function Advanced_Search_widget(){
        $widget_ops = array('classname' => 'advanced_search_sidebar', 'description' => 'Advanced Search Widget');
        $control_ops = array('id_base' => 'advanced_search_widget');
        $this->WP_Widget('advanced_search_widget', 'Wp Estate: Advanced Search', $widget_ops, $control_ops);
    }
    
    function form($instance){
        $defaults = array('title' => 'Advanced Search' );
        $instance = wp_parse_args((array) $instance, $defaults);
        $display='
                <p>
                    <label for="'.$this->get_field_id('title').'">Title:</label>
        </p><p>
                    <input id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" value="'.$instance['title'].'" />
        </p>';
        print $display;
    }


    function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        
        return $instance;
    }



    function widget($args, $instance){
        extract($args);
                $display='';
                $select_tax_action_terms='';
                $select_tax_category_terms='';
                
        $title = apply_filters('widget_title', $instance['title']);

        print $before_widget;

        if($title) {
                    print $before_title.$title.$after_title;
        }else{
                    print '<div class="widget-title-sidebar_blank"></div>';
                }
                
                $pages = get_pages(array(
                    'meta_key' => '_wp_page_template',
                    'meta_value' => 'advanced_search_results.php'
                ));

                if( $pages ){
                    $adv_submit = get_permalink( $pages[0]->ID);
                }else{
                    $adv_submit='';
                }
                
                 $args = array(
                    'hide_empty'    => true  
                 ); 
                 
            
                $show_empty_city_status= esc_html ( get_option('wp_estate_show_empty_city','') );

                if ($show_empty_city_status=='yes'){
                    $args = array(
                        'hide_empty'    => false  
                        ); 
                }
                 
                 
             

                    $taxonomy       =   'property_action_category';
                    $tax_terms      =   get_terms($taxonomy,$args);

                    $taxonomy_cat   =   'property_category';
                    $categories = $tax_terms_categ    =   get_terms($taxonomy_cat,$args);
                     

                    ///////////////////////////////////  select actions
                    $action_select      =   '';
                    $action_select_list =   ' <li role="presentation" data-value="">'. __('All Actions','wpestate').'</li>';

                    foreach ($tax_terms as $tax_term) {      
                        $action_select_list     .=  ' <li role="presentation" data-value="'.$tax_term->slug.'">'. ucwords ( urldecode($tax_term->name )).'</li>';
                      }



                    /////////////////////////////////// select categories
                    $cate_select_list   =  '<li role="presentation" data-value="">'. __('Todos','wpestate').'</li>'; 
                    $categ_select       = '';
                    foreach ($categories as $categ) {                   
                        $cate_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords (urldecode( $categ->name )).'</li>';
                    }


                    /////////////////////////////////// select cities
                    $args = array(
                       'hide_empty'    => false  
                    ); 

                    $select_city        =   '';
                    $select_city_list   =    '<li role="presentation" data-value="all" data-value2="all">'. __('Todas','wpestate').'</li>';
                    $taxonomy           =   'property_city';
                    $tax_terms_city     =   get_terms($taxonomy);

                    foreach ($tax_terms_city as $tax_term) {
                      $string       =   wpestate_limit45 ( sanitize_title ( $tax_term->slug ) );              
                      $slug         =   sanitize_key($string);
                      
                      $select_city_list     .=   '<li role="presentation" data-value="'.$tax_term->slug.'" data-value2="'.$slug.'">'. ucwords ( urldecode($tax_term->name) ).'</li>';
                    }
                    if ($select_city==''){
                          $select_city.= '<option value="">No Cities</option>';
                    }



                    /////////////////////////////////// select areas
                    $select_area        =   '';
                    $select_area_list   =   '<li role="presentation" data-value="all">'.__('All Areas','wpestate').'</li>';
                    $taxonomy           =   'property_area';
                    $tax_terms_area     =   get_terms($taxonomy);

                    foreach ($tax_terms_area as $tax_term) {
                        $term_meta          =  get_option( "taxonomy_$tax_term->term_id");
                        $string       =   wpestate_limit45 ( sanitize_title ( $term_meta['cityparent'] ) );              
                        $slug         =   sanitize_key($string);
                        $select_area_list   .=   '<li role="presentation" data-value="'.$tax_term->slug.'" data-parentcity="' . $slug. '">'. ucwords (urldecode( $tax_term->name) ).'</li>';
                    }     

    
                $adv_search_what        =   get_option('wp_estate_adv_search_what','');
                $adv_search_label       =   get_option('wp_estate_adv_search_label','');
                $adv_search_how         =   get_option('wp_estate_adv_search_how','');
                
                $custom_advanced_search =   get_option('wp_estate_custom_advanced_search','');
                print '<form role="search" method="post"   action="'.$adv_submit.'" >';
                            if($custom_advanced_search=='yes'){
                                   $this->custom_fields_widget($adv_search_what,$action_select_list,$cate_select_list,$select_city_list,$select_area_list,$adv_search_how,$adv_search_label);
                            }else{ // not custom search
                                   $this->normal_fields_widget($action_select_list,$cate_select_list,$select_city_list,$select_area_list,$tax_terms,$tax_terms_area,$tax_terms_city,$tax_terms_categ,$tax_terms_categ);
                  
                            }
                $extended_search = get_option('wp_estate_show_adv_search_extended','');
                if($extended_search=='yes'){            
                    show_extended_search('widget');
                }
                
                print'<button class="wpb_button  wpb_btn-info wpb_btn-large" id="advanced_submit_widget">'.__('Buscar','wpestate').'</button>
                </form>  
                '; 
        print $after_widget;
                
    }
        
        function custom_fields_widget($adv_search_what,$action_select_list,$cate_select_list,$select_city_list,$select_area_list,$adv_search_how,$adv_search_label){
           
                    foreach($adv_search_what as $key=>$search_field){
                                        if($search_field=='none'){
                                            $return_string=''; 
                                        }else if($search_field=='categories'){
                                            $return_string='                                            
                                                    <div class="dropdown form-control" >
                                                        <div data-toggle="dropdown" id="a_sidebar_filter_categ" class="sidebar_filter_menu"> '. __('Tipo de Imóvel','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                                                        <input type="hidden" name="filter_search_type[]" value="">
                                                        <ul id="sidebar_filter_categ" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_sidebar_filter_categ">
                                                        '.$cate_select_list.'
                                                        </ul>        
                                                    </div>';

                                        }else if($search_field=='cities'){
                                            $return_string='
                                                    <div class=" dropdown form-control" >
                                                        <div data-toggle="dropdown" id="sidebar_filter_cities" class="sidebar_filter_menu"> '. __('Praia','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                                                        <input type="hidden" name="advanced_city" value="">
                                                        <ul id="sidebar_filter_city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_cities">
                                                           '. $select_city_list.'
                                                        </ul>        
                                                    </div>  ';
                                        }else {
                                            $slug=str_replace(' ','_',$search_field);
                                            $string       =   wpestate_limit45 ( sanitize_title ($adv_search_label[$key]) );              
                                            $slug         =   sanitize_key($string);
                                            
                                            $label=$adv_search_label[$key];
                                            if (function_exists('icl_translate') ){
                                                $label     =   icl_translate('wpestate','wp_estate_custom_search_'.$label, $label ) ;
                                            }
                
                                            $return_string='
                                            <input type="text" id="'.$slug.'_wid"  name="'.$slug.'"  placeholder="'.$label.'"  class="advanced_select form-control">';
                                            if ( $adv_search_how[$key]=='date bigger' || $adv_search_how[$key]=='date smaller'){
                                                print '<script type="text/javascript">
                                                      //<![CDATA[
                                                      jQuery(document).ready(function(){
                                                              jQuery("#'.$slug.'_wid").datepicker({
                                                                      dateFormat : "yy-mm-dd"
                                                              });
                                                      });
                                                      //]]>
                                                      </script>';
                                            }
                                           } 
                                       print $return_string;
                    } // enf foreach
                    
            }//end custom fields function
         
        
         function normal_fields_widget($action_select_list,$cate_select_list,$select_city_list,$select_area_list,$tax_terms,$tax_terms_area,$tax_terms_city,$tax_terms_categ,$tax_terms_categ){            
                        if( !empty($tax_terms_categ) ){
                             print'                                            
                                <div class="dropdown form-control" >
                                    <div data-toggle="dropdown" id="a_sidebar_filter_categ" class="sidebar_filter_menu"> '. __('Tipo de Imóvel','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                                        <input type="hidden" name="filter_search_type[]" value="">
                                        <ul id="sidebar_filter_categ" class="dropdown-menu filter_menu" role="menu" aria-labelledby="a_sidebar_filter_categ">
                                        '.$cate_select_list.'
                                    </ul>        
                                  </div>';
                        }
                   
                      if( !empty($tax_terms_city) ){
                        print'
                             <div class=" dropdown form-control" >
                                <div data-toggle="dropdown" id="sidebar_filter_cities" class="sidebar_filter_menu"> '. __('Praia','wpestate').' <span class="caret caret_sidebar"></span> </div>           
                                <input type="hidden" name="advanced_city" value="">
                                <ul id="sidebar_filter_city" class="dropdown-menu filter_menu" role="menu" aria-labelledby="sidebar_filter_cities">
                                    '. $select_city_list.'
                                </ul>        
                              </div>  ';
                        }
                    print'    
                    <input type="text" id="adv_rooms_widget" name="advanced_rooms" placeholder="'.__('Pessoas','wpestate').'"      class="advanced_select form-control">
                    <input type="text" id="adv_bath_widget"  name="advanced_bath"  placeholder="'.__('Quartos','wpestate').'"  class="advanced_select form-control">
                    <input type="text" id="adv_codigo_widget"  name="advanced_codigo"  placeholder="'.__('Código','wpestate').'"  class="advanced_select form-control">';
                                               
             
         }
    
}// end class
?>