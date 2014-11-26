<?php

///////////////////////////////////////////////////////////////////////////////////////////
// List features and ammenities
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('estate_listing_features') ):
function estate_listing_features($post_id){
    $return_string='';    
    $counter            =   0;                          
    $feature_list_array =   array();
    $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);
    $total_features     =   round( count( $feature_list_array )/2 );

        
     $show_no_features= esc_html ( get_option('wp_estate_show_no_features','') );

             
             
        if($show_no_features!='no'){
            foreach($feature_list_array as $checker => $value){
                    $counter++;
                    $post_var_name  =   str_replace(' ','_', trim($value) );
                    $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
                    $input_name     =   sanitize_key($input_name);
                         
                    
                    if (function_exists('icl_translate') ){
                        $value     =   icl_translate('wpestate','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
                    }
                                        
                    if (esc_html( get_post_meta($post_id, $input_name, true) ) == 1) {
                         $return_string .= '<div class="listing_detail col-md-4"><i class="fa fa-check"></i>' . trim($value) . '</div>';
                    }else{
                        $return_string  .=  ''; //'<div class="listing_detail col-md-4"><i class="fa fa-times"></i>' . trim($value). '</div>';
                    }
              }
        }else{
             
            foreach($feature_list_array as $checker => $value){
                $post_var_name  =  str_replace(' ','_', trim($value) );
                $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
                $input_name     =   sanitize_key($input_name);
                
                if (function_exists('icl_translate') ){
                    $value     =   icl_translate('wpestate','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
                }
                                    
                if (esc_html( get_post_meta($post_id, $input_name, true) ) == 1) {
                    $return_string .=  '<div class="listing_detail col-md-4"><i class="fa fa-check"></i>' . trim($value) . '</div>';
                }
            }
           
       }
    
    return $return_string;
}
endif; // end   estate_listing_features  




///////////////////////////////////////////////////////////////////////////////////////////
// dashboard favorite listings
///////////////////////////////////////////////////////////////////////////////////////////





if( !function_exists('estate_listing_address') ):
function estate_listing_address($post_id){
    
    $property_address   = esc_html( get_post_meta($post_id, 'property_address', true) );
    $property_city      = get_the_term_list($post_id, 'property_city', '', ', ', '');
    $property_area      = get_the_term_list($post_id, 'property_area', '', ', ', '');
    $property_county    = esc_html( get_post_meta($post_id, 'property_county', true) );
    $property_state     = esc_html(get_post_meta($post_id, 'property_state', true) );
    $property_zip       = esc_html(get_post_meta($post_id, 'property_zip', true) );
    $property_country   = esc_html(get_post_meta($post_id, 'property_country', true) );
    
    $return_string='';
    
    if ($property_address != ''){
        $return_string.='<div class="listing_detail col-md-6"><span class="list-name">'.__('Endereço','wpestate').':</span> ' . $property_address . '</div>'; 
    }
    if ($property_city != ''){
        $return_string.= '<div class="listing_detail col-md-6"><span class="list-name">'.__('Praia','wpestate').':</span> ' .$property_city. '</div>';  
    }  
    
    
    return  $return_string;
}
endif; // end   estate_listing_address  





///////////////////////////////////////////////////////////////////////////////////////////
// dashboard favorite listings
///////////////////////////////////////////////////////////////////////////////////////////




if( !function_exists('estate_listing_details') ):
function estate_listing_details($post_id){
  
    $currency       =   esc_html( get_option('wp_estate_currency_symbol', '') );
    $where_currency =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
    $measure_sys    =   esc_html ( get_option('wp_estate_measure_sys','') ); 
    $property_size  =   intval( get_post_meta($post_id, 'property_size', true) );

    if ($property_size  != '') {
        $property_size  = number_format($property_size) . ' '.$measure_sys.'<sup>2</sup>';
    }

    $property_lot_size = intval( get_post_meta($post_id, 'property_lot_size', true) );

    if ($property_lot_size != '') {
        $property_lot_size = number_format($property_lot_size) . ' '.$measure_sys.'<sup>2</sup>';
    }

    $property_rooms     = floatval ( get_post_meta($post_id, 'property_rooms', true) );
    $property_bedrooms  = floatval ( get_post_meta($post_id, 'property_bedrooms', true) );
    $property_bathrooms = floatval ( get_post_meta($post_id, 'property_bathrooms', true) );     
    $price              = intval   ( get_post_meta($post_id, 'property_price', true) );
    $price_label        = esc_html ( get_post_meta($post_id, 'property_label', true) );  
            
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

    $return_string='';
    if ($price !='' ){ 
        $return_string.='<div class="listing_detail col-md-4"><span class="list-name">'.__('Preço','wpestate'). ':</span> '.$price.' '.$price_label.'</div>';
    }   
    if ($property_rooms != ''){
        $return_string.= '<div class="listing_detail col-md-4"><span class="list-name">'.__('Pessoas','wpestate').':</span> ' . $property_rooms . '</div>'; 
    }      
    if ($property_bedrooms != ''){
        $return_string.= '<div class="listing_detail col-md-4"><span class="list-name">'.__('Quartos','wpestate').':</span> ' . $property_bedrooms . '</div>'; 
    }     
    if ($property_bathrooms != '')    {
        $return_string.= '<div class="listing_detail col-md-4"><span class="list-name">'.__('Banheiros','wpestate').':</span> ' . $property_bathrooms . '</div>'; 
    }      

    
    // Custom Fields 
    $i=0;
    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
           $name =   $custom_fields[$i][0];
           $label=   $custom_fields[$i][1];
           $type =   $custom_fields[$i][2];
       //    $slug =   sanitize_key ( str_replace(' ','_',$name) );
           $slug         =   wpestate_limit45(sanitize_title( $name ));
           $slug         =   sanitize_key($slug);
            
           $value=esc_html(get_post_meta($post_id, $slug, true));
           if (function_exists('icl_translate') ){
                $label     =   icl_translate('wpestate','wp_estate_property_custom_'.$label, $label ) ;
                $value     =   icl_translate('wpestate','wp_estate_property_custom_'.$value, $value ) ;                                      
           }
                                   
           if($value!=''){
               $return_string.= '<div class="listing_detail col-md-4"><span class="list-name">'.ucwords($label).':</span> ' .$value. '</div>'; 
           }
           $i++;       
        }
    }

     //END Custom Fields 

         
         
    return $return_string;
}
endif; // end   estate_listing_details  

if( !function_exists('estate_listing_temporada') ):
function estate_listing_temporada($post_id){
   
  $return_string='';
  $temporadas = array("Ano Novo", "Janeiro", "Carnaval", "Fevereiro", "Março");
  $temporadas_slug = array("ano-novo", "janeiro", "carnaval", "fevereiro", "marco");
  $icone_disponivel = array("Sim" => 'check"></i>Disponível', "Não" => 'times"></i>Indisponível');
  
  for($aux = 0; $aux <5; $aux++){
    $temp_slug = $temporadas_slug[$aux];
    $temporada = $temporadas[$aux];
    
    $diaria = types_render_field($temp_slug."-valor", array($post_id));
    $dias = types_render_field($temp_slug."-dias", array($post_id));
    $disponivel = types_render_field($temp_slug."-disponivel", array($post_id));
    
    $return_string.= '<div class="listing_temporada col-md-12"><span class="list-name">'.$temporada.':</span> R$ '.$diaria.' / diária - Mínimo de '.$dias.' dias<span class="temporada-disponivel"><i class="fa fa-'.$icone_disponivel[$disponivel].'</span></div>';
     
  }      
    
    return $return_string;
}
endif; // end   estate_listing_temporada

if( !function_exists('temporadas_disponiveis') ):
function temporadas_disponiveis($post_id){
   
  $info = array();
  $temporadas_slug = array("ano-novo", "janeiro", "carnaval", "fevereiro", "marco");
  
  for($aux = 0; $aux <5; $aux++){
    $temp_slug = $temporadas_slug[$aux];
    $disponivel = get_post_meta( $post_id, "wpcf-".$temp_slug."-disponivel", true );

    $info[$aux] = $disponivel;     
  }     
    
    return $info;
}
endif; // end   temporadas_disponiveis

?>