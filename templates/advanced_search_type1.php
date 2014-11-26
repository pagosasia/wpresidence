<?php 
global $post;
$adv_search_what            =   get_option('wp_estate_adv_search_what','');
$show_adv_search_visible    =   get_option('wp_estate_show_adv_search_visible','');
$close_class                =   '';
if($show_adv_search_visible=='no'){
    $close_class='adv-search-1-close';
}
if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}

$extended_search    =   get_option('wp_estate_show_adv_search_extended','');
$extended_class     =   '';
if ( $extended_search =='yes' ){
    $extended_class='adv_extended_class';
}
    
?>

<div class="adv-search-1 <?php echo $close_class.' '.$extended_class;?>" id="adv-search-1" data-postid="<?php echo $post_id; ?>"> 
    <div id="adv-search-header-1"> <?php _e('Busca Avançada','wpestate');?></div>   
    <form role="search" method="post"   action="<?php print $adv_submit; ?>" >
                  
        <div class="adv1-holder">
        
        <?php
        $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
        if ( $custom_advanced_search == 'yes'){
            foreach($adv_search_what as $key=>$search_field){
                wpestate_show_search_field($search_field,$action_select_list,$categ_select_list,$select_city_list,$select_area_list,$key);
            }
        }else{
        ?>

        <div class="dropdown form-control" >
            <div data-toggle="dropdown" id="adv_categ" class="filter_menu_trigger" data-value="all"> <?php _e('Tipo de Imóvel','wpestate');?> <span class="caret caret_filter"></span> </div>           
            <input type="hidden" name="filter_search_type[]" value="">
            <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="adv_categ">
                <?php print $categ_select_list;?>
            </ul>        
        </div> 

        <div class="dropdown form-control" >
            <div data-toggle="dropdown" id="advanced_city" class="filter_menu_trigger" data-value="all"> <?php _e('Praia','wpestate');?> <span class="caret caret_filter"></span> </div>           
            <input type="hidden" name="advanced_city" value="">
            <ul  class="dropdown-menu filter_menu" role="menu"  id="adv-search-city" aria-labelledby="advanced_city">
                <?php print $select_city_list;?>
            </ul>        
        </div>  

        <input type="text" id="adv_rooms" class="form-control" name="advanced_rooms" placeholder="<?php _e('Pessoas','wpestate');?>" value="" >       
        <input type="text" id="adv_bath"  class="form-control" name="advanced_bath"   placeholder="<?php _e('Quartos','wpestate');?>" value="">        
        <input type="text" id="price_low" class="form-control advanced_select" name="price_low"  placeholder="<?php _e('Preço mínimo','wpestate');?>" value=""/>
        <input type="text" id="price_max" class="form-control advanced_select" name="price_max"  placeholder="<?php _e('Preço máximo','wpestate');?>" value=""/>

        <?php
        }
        
        if($extended_search=='yes'){
           show_extended_search('adv');
        }
        ?>
        </div>
       
        <input name="submit" type="submit" class="wpb_button  wpb_btn_adv_submit wpb_btn-large" id="advanced_submit_2" value="<?php _e('BUSCAR','wpestate');?>">
              
        <div id="results">
            <?php _e('We found ','wpestate')?> <span id="results_no">0</span> <?php _e('resultados.','wpestate'); ?>  
            <span id="showinpage"> <?php _e('Do you want to load the results now ?','wpestate');?> </span>
        </div>
    </form>   
</div>  