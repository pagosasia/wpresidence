<?php
// register the custom post type
add_action( 'init', 'wpestate_create_invoice_type' );

if( !function_exists('wpestate_create_invoice_type') ):
function wpestate_create_invoice_type() {
register_post_type( 'wpestate_invoice',
		array(
			'labels' => array(
				'name'          => __( 'Invoices','wpestate'),
				'singular_name' => __( 'Invoices','wpestate'),
				'add_new'       => __('Add New Invoice','wpestate'),
                'add_new_item'          =>  __('Add Invoice','wpestate'),
                'edit'                  =>  __('Edit Invoice' ,'wpestate'),
                'edit_item'             =>  __('Edit Invoice','wpestate'),
                'new_item'              =>  __('New Invoice','wpestate'),
                'view'                  =>  __('View Invoices','wpestate'),
                'view_item'             =>  __('View Invoices','wpestate'),
                'search_items'          =>  __('Search Invoices','wpestate'),
                'not_found'             =>  __('No Invoices found','wpestate'),
                'not_found_in_trash'    =>  __('No Invoices found','wpestate'),
                'parent'                =>  __('Parent Invoice','wpestate')
			),
		'public' => true,
		'has_archive' => true,
		'rewrite' => array('slug' => 'invoice'),
		'supports' => array('title'),
		'can_export' => true,
		'register_meta_box_cb' => 'wpestate_add_pack_invoices',
                 'menu_icon'=>get_template_directory_uri().'/img/invoices.png'
		)
	);
}
endif; // end   wpestate_create_invoice_type  

////////////////////////////////////////////////////////////////////////////////////////////////
// Add Invoice metaboxes
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_pack_invoices') ):
function wpestate_add_pack_invoices() {	
        add_meta_box(  'estate_invoice-sectionid',  __( 'Invoice Details', 'wpestate' ),'wpestate_invoice_details','wpestate_invoice' ,'normal','default');
}
endif; // end   wpestate_add_pack_invoices  



////////////////////////////////////////////////////////////////////////////////////////////////
// Invoice Details
////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_invoice_details') ):

function wpestate_invoice_details( $post ) {
    global $post;
    wp_nonce_field( plugin_basename( __FILE__ ), 'estate_invoice_noncename' );

    $invoice_types      =   array('Listing','Upgrade to Featured','Publish Listing with Featured','Package');
    $invoice_saved      =   esc_html(get_post_meta($post->ID, 'invoice_type', true));
    $invoice_select     =   '<select name="invoice_type"  id="invoice_type">';

    foreach($invoice_types as $type){
        $invoice_select.='<option value="'.$type.'" ';
        if($invoice_saved==$type){
             $invoice_select.=' selected="selected" ';
        }
        $invoice_select.='>'.$type.'</option>';
    }
    $invoice_select.='</select>';


    $invoice_period            =  array('One Time','Recurring');
    $invoice_period_saved      =  esc_html(get_post_meta($post->ID, 'biling_type', true));
    $invoice_period_select     =  '<select name="biling_type"  id="biling_type">';
    
    foreach($invoice_period as $type){
        $invoice_period_select.='<option value="'.$type.'" ';
        if($invoice_period_saved==$type){
             $invoice_period_select.=' selected="selected" ';
        }
        $invoice_period_select.='>'.$type.'</option>';
    }
    $invoice_period_select.='</select>';

    $txn_id=esc_html(get_post_meta($post->ID, 'txn_id', true));

    print'
    <p class="meta-options">
        <strong>'.__('Invoice Id:','wpestate').' </strong>'.$post->ID.'
    </p>

    <p class="meta-options">
        <label for="biling_period">'.__('wpestate','Billing For :').'</label><br />
        '.$invoice_select.'
    </p>

    <p class="meta-options">
        <label for="biling_type">'.__('Billing Type :','wpestate').'</label><br />
        '.$invoice_period_select.'
    </p>

    <p class="meta-options">
        <label for="item_id">'.__('Item Id (Listing or Package id)','wpestate').'</label><br />
        <input type="text" id="item_id" size="58" name="item_id" value="'.  esc_html(get_post_meta($post->ID, 'item_id', true)).'">
    </p>

    <p class="meta-options">
        <label for="item_price">'.__('Item Price','wpestate').'</label><br />
        <input type="text" id="item_price" size="58" name="item_price" value="'.  esc_html(get_post_meta($post->ID, 'item_price', true)).'">
    </p>

    <p class="meta-options">
        <label for="purchase_date">'.__('Purchase Date','wpestate').'</label><br />
        <input type="text" id="purchase_date" size="58" name="purchase_date" value="'.  esc_html(get_post_meta($post->ID, 'purchase_date', true)).'">
    </p>

    <p class="meta-options">
        <label for="buyer_id">'.__('User Id','wpestate').'</label><br />
        <input type="text" id="buyer_id" size="58" name="buyer_id" value="'.  esc_html(get_post_meta($post->ID, 'buyer_id', true)).'">
    </p>
    ';            
    if($txn_id!=''){
        print __('Paypal - Reccuring Payment ID: ','wpestate').$txn_id;
    }
}

endif; // end   wpestate_invoice_details  



/////////////////////////////////////////////////////////////////////////////////////
/// populate the invoice list with extra columns
/////////////////////////////////////////////////////////////////////////////////////

add_filter( 'manage_edit-wpestate_invoice_columns', 'wpestate_invoice_my_columns' );

if( !function_exists('wpestate_invoice_my_columns') ):
function wpestate_invoice_my_columns( $columns ) {
    $slice=array_slice($columns,2,2);
    unset( $columns['comments'] );
    unset( $slice['comments'] );
    $splice=array_splice($columns, 2);   
    $columns['invoice_price']   = __('Price','wpestate');
    $columns['invoice_for']     = __('Billing For','wpestate');
    $columns['invoice_type']    = __('Invoice Type','wpestate');
    $columns['invoice_user']    = __('Purchased by User','wpestate');
    return  array_merge($columns,array_reverse($slice));
}
endif; // end   wpestate_invoice_my_columns  


add_action( 'manage_posts_custom_column', 'wpestate_invoice_populate_columns' );

if( !function_exists('wpestate_invoice_populate_columns') ):
function wpestate_invoice_populate_columns( $column ) {
     $the_id=get_the_ID();
     if ( 'invoice_price' == $column ) {
        echo get_post_meta($the_id, 'item_price', true);
    } 
    
    if ( 'invoice_for' == $column ) {
         echo get_post_meta($the_id, 'invoice_type', true);
    } 
    
    if ( 'invoice_type' == $column ) {
        echo get_post_meta($the_id, 'biling_type', true);
    }
    
    if ( 'invoice_user' == $column ) {
         $user_id= get_post_meta($the_id, 'buyer_id', true);
         $user_info = get_userdata($user_id);
         echo $user_info->user_login;
    }
   
}
endif; // end   wpestate_invoice_populate_columns  


add_filter( 'manage_edit-wpestate_invoice_sortable_columns', 'wpestate_invoice_sort_me' );

if( !function_exists('wpestate_invoice_sort_me') ):
function wpestate_invoice_sort_me( $columns ) {
    $columns['invoice_price']   = 'invoice_price';
    $columns['invoice_user']    = 'invoice_user';
    $columns['invoice_for']     = 'invoice_for';
    $columns['invoice_type']    = 'invoice_type';
    return $columns;
}
endif; // end   wpestate_invoice_sort_me  






/////////////////////////////////////////////////////////////////////////////////////
/// insert invoice 
/////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_insert_invoice') ):
 function wpestate_insert_invoice($billing_for,$type,$pack_id,$date,$user_id,$is_featured,$is_upgrade,$paypal_tax_id){   
    $post = array(
               'post_title'	=> 'Invoice ',
               'post_status'	=> 'publish', 
               'post_type'     => 'wpestate_invoice'
           );
    $post_id =  wp_insert_post($post ); 


    if($type==2){
        $type='Recurring';
    }else{
        $type='One Time';
    }

    $price_submission               =   floatval( get_option('wp_estate_price_submission','') );
    $price_featured_submission      =   floatval( get_option('wp_estate_price_featured_submission','') );

    if($billing_for=='Package'){
        $price= get_post_meta($pack_id, 'pack_price', true);
    }else{
        if($is_upgrade==1){
             $price=$price_featured_submission;
        }else{
            if($is_featured==1){
                $price=$price_featured_submission+$price_submission;
            }else{
                 $price=$price_submission;
            }
        }


    }

    update_post_meta($post_id, 'invoice_type', $billing_for);   
    update_post_meta($post_id, 'biling_type', $type);
    update_post_meta($post_id, 'item_id', $pack_id);
    update_post_meta($post_id, 'item_price',$price);
    update_post_meta($post_id, 'purchase_date', $date);
    update_post_meta($post_id, 'buyer_id', $user_id);
    update_post_meta($post_id, 'txn_id', $paypal_tax_id);
    $my_post = array(
       'ID'             => $post_id,
       'post_title'     => 'Invoice '.$post_id,
    );
    wp_update_post( $my_post );
}
endif; // end   wpestate_insert_invoice  
?>