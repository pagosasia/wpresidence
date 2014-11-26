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

//////////////////////////////////////////////////////////////////////////////// select categories
$taxonomy_cat       =   'property_category';
$categories         =   get_terms($taxonomy_cat,$args);
$categ_select_list   =  '<li role="presentation" data-value="all">'. __('Tipo de Imóvel','wpestate').'</li>'; 

foreach ($categories as $categ) {
    $categ_select_list     .=   '<li role="presentation" data-value="'.$categ->slug.'">'. ucwords ( urldecode( $categ->name ) ).'</li>';
}

//////////////////////////////////////////////////////////////////////////////// select cities
$select_city_list   =    '<li role="presentation" data-value="all" data-value2="all">'. __('Cidade / Praia','wpestate').'</li>';
$taxonomy           =   'property_city';
$tax_terms_city     =   get_terms($taxonomy,$args);

foreach ($tax_terms_city as $tax_term) {
    $string       =   wpestate_limit45 ( sanitize_title ( $tax_term->slug ) );              
    $slug         =   sanitize_key($string);
    $select_city_list     .=   '<li role="presentation" data-value="'.$tax_term->slug.'" data-value2="'.$slug.'">'. ucwords ( urldecode( $tax_term->name) ).'</li>';
}
  
?>

<div class="search_wrapper" id="search_wrapper" >       
   
        <?php  
           
        if ( isset($post->ID) && is_page($post->ID) &&  basename( get_page_template() ) == 'contact_page.php' ) {
        //
        }else {

         include(locate_template('templates/advanced_search_type1.php'));
        }    
           
        ?>
     
</div><!-- end search wrapper--> 
<!-- END SEARCH CODE -->