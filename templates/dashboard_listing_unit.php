<?php
global $edit_link;
global $token;
global $processor_link;
global $paid_submission_status;
global $submission_curency_status;
global $price_submission;


$post_id                    =   get_the_ID();
$preview                    =   wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'property_listings');
$edit_link                  =   add_query_arg( 'listing_edit', $post_id, $edit_link ) ;
$post_status                =   get_post_status($post_id);
$property_address           =   esc_html ( get_post_meta($post_id, 'property_address', true) );
$property_city              =   get_the_term_list($post_id, 'property_city', '', ', ', '') ;
$property_category          =   get_the_term_list($post_id, 'property_category', '', ', ', '');
$property_action_category   =   get_the_term_list($post_id, 'property_action_category', '', ', ', '');
$price_label                =   esc_html ( get_post_meta($post_id, 'property_label', true) );
$price                      =   intval( get_post_meta($post->ID, 'property_price', true) );
$currency                   =   esc_html( get_option('wp_estate_submission_curency', '') );
$currency_title             =   esc_html( get_option('wp_estate_currency_symbol', '') );
$where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
$status                     =   '';
$link                       =   '';
$pay_status                 =   '';
$is_pay_status              =   '';
$paid_submission_status     =   esc_html ( get_option('wp_estate_paid_submission','') );
$price_submission           =   floatval( get_option('wp_estate_price_submission','') );
$price_featured_submission  =   floatval( get_option('wp_estate_price_featured_submission','') );

if ($price != 0) {
   $price = number_format($price);
   
   if ($where_currency == 'before') {
       $price_title =   $currency_title . ' ' . $price;
       $price       =   $currency . ' ' . $price;
   } else {
       $price_title = $price . ' ' . $currency_title;
       $price       = $price . ' ' . $currency;
     
   }
}else{
    $price='';
    $price_title='';
}



if($post_status=='expired'){ 
    $status='<span class="label label-danger">'.__('Expired','wpestate').'</span>';
}else if($post_status=='publish'){ 
    $link=get_permalink();
    $status='<span class="label label-success">'.__('Published','wpestate').'</span>';
}else{
    $link='';
    $status='<span class="label label-info">'.__('Waiting for approval','wpestate').'</span>';
}


if ($paid_submission_status=='per listing'){
    $pay_status    = get_post_meta(get_the_ID(), 'pay_status', true);
    if($pay_status=='paid'){
        $is_pay_status.='<span class="label label-success">'.__('Paid','wpestate').'</span>';
    }
    if($pay_status=='not paid'){
        $is_pay_status.='<span class="label label-info">'.__('Not Paid','wpestate').'</span>';
    }
}
$featured  = intval  ( get_post_meta($post->ID, 'prop_featured', true) );
?>




<div class="col-md-12 dasboard-prop-listing">
   <div class="blog_listing_image">
       <?php
        if($featured==1){
                print '<div class="featured_div"></div>';
        }
        if (has_post_thumbnail($post_id)){
        ?>
            <a href="<?php print $link; ?>"><img  src="<?php  print $preview[0]; ?>"  alt="slider-thumb" /></a>
        <?php 
        } 
        ?>
   </div>
    

    <div class="prop-info">
         <div class="user_dashboard_status">
            <?php print $status.$is_pay_status;?>      
        </div>
                
        <h4 class="listing_title">
            <a href="<?php print $link; ?>"><?php the_title(); ?></a> 
        </h4>
        
        <div class="user_dashboard_listed">
            <?php print __('Price','wpestate').': <span class="price_label"> '. $price_title.' '.$price_label.'</span>';?>
        </div>
        
        <div class="user_dashboard_listed">
            <?php _e('Listed in','wpestate');?>  
            <?php print $property_action_category; ?> 
            <?php if( $property_action_category!='') {
                    print' '.__('and','wpestate').' ';
                    } 
                  print $property_category;?>                     
        </div>
        
        <div class="user_dashboard_listed">
            <?php print __('City','wpestate').': ';?>            
            <?php print get_the_term_list($post_id, 'property_city', '', ', ', '');?>
            <?php print ', '.__('Area','wpestate').': '?>
            <?php print get_the_term_list($post_id, 'property_area', '', ', ', '');?>          
        </div>
        
        <div class="info-container">
            <a  data-original-title="<?php _e('Edit property','wpestate');?>"   class="dashboad-tooltip" href="<?php  print $edit_link;?>"><i class="fa fa-pencil-square-o editprop"></i></a>
            <a  data-original-title="<?php _e('Delete property','wpestate');?>" class="dashboad-tooltip" onclick="return confirm(' <?php echo __('Are you sure you wish to delete ','wpestate').get_the_title(); ?>?')" href="<?php print add_query_arg( 'delete_id', $post_id, $_SERVER['REQUEST_URI'] );?>"><i class="fa fa-times deleteprop"></i></a>  
         
            <?php $pay_status    = get_post_meta($post_id, 'pay_status', true);
                if( $post_status == 'expired' ){ 
                   print'<span data-original-title="'.__('Resend for approval','wpestate').'" class="dashboad-tooltip resend_pending" data-listingid="'.$post_id.'"><i class="fa fa-upload deleteprop"></i></span>';   
                }else{

                     if($paid_submission_status=='membership'){
                          if ( intval(get_post_meta($post_id, 'prop_featured', true))==1){
                               print '<span class="label label-success">'.__('Property is featured','wpestate').'</span>';       
                          }
                          else{
                              print ' <span  data-original-title="'.__('Set as featured, *Listings set as featured are substracted from your package','wpestate').'" class="dashboad-tooltip make_featured" data-postid="'.$post_id.'" ><i class="fa fa-star favprop"></i></span>';
                          }
                     }

                     if($paid_submission_status=='per listing'){
                          if($pay_status!='paid' ){
                              print' 
                                     <div class="listing_submit">
                                     '.__('Submission Fee','wpestate').': <span class="submit-price submit-price-no">'.$price_submission.'</span><span class="submit-price"> '.$currency.'</span></br>
                                     <input type="checkbox" class="extra_featured" name="extra_featured" style="display:block;" value="1" >
                                     '.__('Featured Fee','wpestate').': <span class="submit-price submit-price-featured">'.$price_featured_submission.'</span><span class="submit-price"> '.$currency.'</span> </br>
                                     '.__('Total Fee','wpestate').': <span class="submit-price submit-price-total">'.$price_submission.'</span> <span class="submit-price">'.$currency.'</span>  </br> 
                                     <div class="listing_submit_normal label label-danger" data-listingid="'.$post_id.'">'.__('Pay with Paypal','wpestate').'</div>
                                    </div>'; 
                          }else{
                               if ( intval(get_post_meta($post_id, 'prop_featured', true))==1){
                                    print '<span class="label label-success">'.__('Property is featured','wpestate').'</span>';  
                               }else{
                                    print'<span class="listing_upgrade label label-danger" data-listingid="'.$post_id.'">'.__('Upgrade to featured','wpestate').' - '.$price_featured_submission.' '.$currency.'</span>'; 
                               } 
                           }
                    }

                }?>
        </div>
    </div>  
 </div>