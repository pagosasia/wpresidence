<?php
if( !function_exists('wpestate_new_general_set') ):
function wpestate_new_general_set() {  
   if($_SERVER['REQUEST_METHOD'] === 'POST'){	

        $allowed_html   =   array();
       if( isset( $_POST['add_field_name'] ) ){
            $new_custom=array();  
            foreach( $_POST['add_field_name'] as $key=>$value ){
                $temp_array=array();
                $temp_array[0]=$value;
                $temp_array[1]= wp_kses( $_POST['add_field_label'][sanitize_key($key)] ,$allowed_html);
                $temp_array[2]= wp_kses( $_POST['add_field_type'][sanitize_key($key)] ,$allowed_html);
                $temp_array[3]= wp_kses ( $_POST['add_field_order'][sanitize_key($key)],$allowed_html);
                $new_custom[]=$temp_array;
            }

          
            usort($new_custom,"wpestate_sorting_function");
            update_option( 'wp_estate_custom_fields', $new_custom );   
       }
          
       


        if( isset( $_POST['theme_slider'] ) ){
            update_option( 'wp_estate_theme_slider', true);  
        }
        
       
        foreach($_POST as $variable=>$value){	
            if ($variable!='submit'){
                if ($variable!='add_field_name'&& $variable!='add_field_label' && $variable!='add_field_type' && $variable!='add_field_order' && $variable!= 'adv_search_how' && $variable!='adv_search_what' && $variable!='adv_search_label'){
                    $variable   =   sanitize_key($variable);
                    if($variable=='co_address'){
                        $allowed_html_br=array(
                                'br' => array(),
                                'em' => array(),
                                'strong' => array()
                        );
                        $postmeta   =   wp_kses($value,$allowed_html_br);
                    }else{
                        $postmeta   =   wp_kses($value,$allowed_html);
                    
                    }
                    
                    
                    update_option( wpestate_limit64('wp_estate_'.$variable), $postmeta );                
                }else{
                    update_option( 'wp_estate_'.$variable, $value );
                }	
            }	
        }
        
         if( isset($_POST['is_custom']) && $_POST['is_custom']== 1 && !isset($_POST['add_field_name']) ){
                 update_option( 'wp_estate_custom_fields', '' ); 
         }
}
    
    
$allowed_html   =   array();  
$active_tab = isset( $_GET[ 'tab' ] ) ? wp_kses( $_GET[ 'tab' ],$allowed_html ) : 'general_settings';  

print ' <div class="wrap">
        <form method="post" action="">
        <div class="wpestate-tab-wrapper-container">
        <div class="wpestate-tab-wrapper">';
            print '<div class="ourlogo"><a href="http://wpestate.org/" target="_blank"><img src="'.get_template_directory_uri().'/img/logoadmin.png" alt="logo"></a></div>';
            
            print '<div class="wpestate-tab-item '; 
            print $active_tab == 'general_settings'  ? 'wpestate-tab-active' : '';
            print '"><a href="themes.php?page=libs/theme-admin.php&tab=general_settings">'.__('General Settings','wpestate').'</a></div>';
                
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'social_contact' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=social_contact">'.__('Social & Contact','wpestate').'</a></div>';
           
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'appearance' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=appearance">'.__('Appearance','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'mapsettings' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=mapsettings">'.__('Google Maps Settings','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'membership' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=membership">'.__('Membership & Payment Settings ','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'design' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=design">'.__('Design','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'pin_management' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=pin_management">'.__('Pin Management','wpestate').'</a></div>';
            
            //     print '<div class="wpestate-tab-item ';
            //     print $active_tab == 'icon_management' ? 'wpestate-tab-active' : ''; 
            //     print'"><a href="themes.php?page=libs/theme-admin.php&tab=icon_management">'.__('Icon Management','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'custom_fields' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=custom_fields">'.__('Listings Custom Fields','wpestate').'</a></div>';
         
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'adv_search' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=adv_search">'.__('Advanced Search','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'display_features' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=display_features">'.__('Listings Features & Amenities ','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'listings_labels' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=listings_labels">'.__('Listings Labels','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'theme-slider' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=theme-slider">'.__('Set Theme Slider','wpestate').'</a></div>';
            
            print '<div class="wpestate-tab-item ';
            print $active_tab == 'help_custom' ? 'wpestate-tab-active' : ''; 
            print'"><a href="themes.php?page=libs/theme-admin.php&tab=help_custom">'.__('Help & Custom','wpestate').'</a></div>';
            
       print '</div>';

   

    switch ($active_tab) {
            case "general_settings":
                wpestate_theme_admin_general_settings();
                break;
            case "social_contact":
                wpestate_theme_admin_social();
                break;
              case "appearance":
                wpestate_theme_admin_apperance();
                break;
              case "design":
                wpestate_theme_admin_design();
                break;
              case "help_custom":
                wpestate_theme_admin_help();
                break;
              case "mapsettings":
                wpestate_theme_admin_mapsettings();
                break;
              case "membership":
                wpestate_theme_admin_membershipsettings();
                break;
              case "adv_search":
                wpestate_theme_admin_adv_search();
                break;
              case "pin_management":
                wpestate_show_pins();
                break;
              
              case "custom_fields":
                wpestate_custom_fields();
                break;
              case "display_features":
                wpestate_display_features();
                break;
              case "listings_labels":
                wpestate_display_labels();
                break;   
               case "theme-slider":
                wpestate_theme_slider();
                break;
    }
            
         
     
        
                   
print '</div></form></div>';
}
endif; // end   wpestate_new_general_set  




if( !function_exists('wpestate_show_advanced_search_options') ):

function  wpestate_show_advanced_search_options($i,$adv_search_what){
    $return_string='';

    $curent_value='';
    if(isset($adv_search_what[$i])){
        $curent_value=$adv_search_what[$i];        
    }
    
   // $curent_value=$adv_search_what[$i];
    $admin_submission_array=array('types',
                                  'categories',
                                  'cities',
                                  'areas',
                                  'property price',
                                  'property size',
                                  'property lot size',
                                  'property rooms',
                                  'property bedrooms',
                                  'property bathrooms',
                                  'property address',
                                  'property county',
                                  'property state',
                                  'property zip',
                                  'property country',
                                  'property status'
                                );
    
    foreach($admin_submission_array as $value){

        $return_string.='<option value="'.$value.'" '; 
        if($curent_value==$value){
             $return_string.= ' selected="selected" ';
        }
        $return_string.= '>'.$value.'</option>';    
    }
    
    $i=0;
    $custom_fields = get_option( 'wp_estate_custom_fields', true); 
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){          
            $name =   $custom_fields[$i][0];
            $type =   $custom_fields[$i][1];
            $slug =   str_replace(' ','-',$name);

            $return_string.='<option value="'.$slug.'" '; 
            if($curent_value==$slug){
               $return_string.= ' selected="selected" ';
            }
            $return_string.= '>'.$name.'</option>';    
            $i++;  
        }
    }  
    $slug='none';
    $name='none';
    $return_string.='<option value="'.$slug.'" '; 
    if($curent_value==$slug){
        $return_string.= ' selected="selected" ';
    }
    $return_string.= '>'.$name.'</option>';    

       
    return $return_string;
}
endif; // end   wpestate_show_advanced_search_options  



if( !function_exists('wpestate_show_advanced_search_how') ):
function  wpestate_show_advanced_search_how($i,$adv_search_how){
    $return_string='';
    $curent_value='';
    if (isset($adv_search_how[$i])){
         $curent_value=$adv_search_how[$i];
    }
   
    
    
    $admin_submission_how_array=array('equal',
                                      'greater',
                                      'smaller',
                                      'like',
                                      'date bigger',
                                      'date smaller');
    
    foreach($admin_submission_how_array as $value){
        $return_string.='<option value="'.$value.'" '; 
        if($curent_value==$value){
             $return_string.= ' selected="selected" ';
        }
        $return_string.= '>'.$value.'</option>';    
    }
    return $return_string;
}
endif; // end   wpestate_show_advanced_search_how  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Advanced Search Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_theme_admin_adv_search') ):
function wpestate_theme_admin_adv_search(){
    $cache_array                    =   array('yes','no');  
    
    $custom_advanced_search= get_option('wp_estate_custom_advanced_search','');
    $adv_search_what    = get_option('wp_estate_adv_search_what','');
    $adv_search_how     = get_option('wp_estate_adv_search_how','');
    $adv_search_label   = get_option('wp_estate_adv_search_label','');
    
    
    $custom_advanced_search_select ='';
    $custom_advanced_status= esc_html ( get_option('wp_estate_custom_advanced_search','') );
    $value_array=array('no','yes');

    foreach($value_array as $value){
            $custom_advanced_search_select.='<option value="'.$value.'"';
            if ($custom_advanced_status==$value){
                $custom_advanced_search_select.='selected="selected"';
            }
            $custom_advanced_search_select.='>'.$value.'</option>';
    }
  
    
    $show_adv_search_general_select     =   '';
    $show_adv_search_general            =   get_option('wp_estate_show_adv_search_general','');

    foreach($cache_array as $value){
            $show_adv_search_general_select.='<option value="'.$value.'"';
            if ($show_adv_search_general    ==  $value){
                    $show_adv_search_general_select.=' selected="selected" ';
            }
            $show_adv_search_general_select.='> '.$value.'</option>';
    }
    
    $show_adv_search_slider_select     =   '';
    $show_adv_search_slider            =   get_option('wp_estate_show_adv_search_slider','');

    foreach($cache_array as $value){
            $show_adv_search_slider_select.='<option value="'.$value.'"';
            if ($show_adv_search_slider    ==  $value){
                    $show_adv_search_slider_select.=' selected="selected" ';
            }
            $show_adv_search_slider_select.='> '.$value.'</option>';
    }
    
    
    
    $show_adv_search_visible_select     =   '';
    $show_adv_search_visible            =   get_option('wp_estate_show_adv_search_visible','');

    foreach($cache_array as $value){
            $show_adv_search_visible_select.='<option value="'.$value.'"';
            if ($show_adv_search_visible    ==  $value){
                    $show_adv_search_visible_select.=' selected="selected" ';
            }
            $show_adv_search_visible_select.='> '.$value.'</option>';
    }
    
    
    $show_adv_search_extended_select     =   '';
    $show_adv_search_extended            =   get_option('wp_estate_show_adv_search_extended','');

    foreach($cache_array as $value){
            $show_adv_search_extended_select.='<option value="'.$value.'"';
            if ($show_adv_search_extended    ==  $value){
                    $show_adv_search_extended_select.=' selected="selected" ';
            }
            $show_adv_search_extended_select.='> '.$value.'</option>';
    }
    
    
    
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Advanced Search','wpestate').'</h1>';  
    
    print '
           <table class="form-table">
        
        <tr valign="top">
            <th scope="row"> <label for="custom_advanced_search">'.__('Use Custom Fields For Advanced Search ?','wpestate').'</label></th>
            <td> 
                <select id="custom_advanced_search" name="custom_advanced_search">
                    '.$custom_advanced_search_select.'
                </select> 
            </td>
        </tr>
        
     
        
        <tr valign="top">
            <th scope="row"><label for="show_adv_search_inclose">'.__('Show Advanced Search ?','wpestate').'</label></th>
           
            <td> <select id="show_adv_search_general" name="show_adv_search_general">
                    '.$show_adv_search_general_select.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_adv_search_slider">'.__('Show Advanced Search over sliders or images ?','wpestate').'</label></th>
           
            <td> <select id="show_adv_search_slider" name="show_adv_search_slider">
                    '.$show_adv_search_slider_select.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_adv_search_visible">'.__('Keep Advanced Search visible?','wpestate').'</label></th>
           
            <td> <select id="show_adv_search_visible" name="show_adv_search_visible">
                    '.$show_adv_search_visible_select.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_adv_search_visible">'.__('Show Ammenties and Features fields?','wpestate').'</label></th>
           
            <td> <select id="show_adv_search_extended" name="show_adv_search_extended">
                    '.$show_adv_search_extended_select.'
		 </select>
            </td>
        </tr>
        
        </table>';

    print '<h1 class="wpestate-tabh1">'.__('Custom Fields for Advanced Search','wpestate').'</h1>'; 
    print'    <table class="form-table">
       
         <tr valign="top">
            <th scope="row"></th>
            <td>
            </td>
             <td>  
            </td>
         </tr>
         <tr valign="top">
            <th scope="row"><label for="admin_submission"><strong>'.__('Place in advanced search form','wpestate').'</strong></label></th>          
            <td><strong>'.__('Search field','wpestate').'</strong></td>
            <td><strong>'.__('How it will compare','wpestate').'</strong></td>
            <td><strong>'.__('Label on Front end','wpestate').'</strong></td>
        </tr>'; 
        
    $i=0;
    while( $i < 8 ){
       $i++;
      
       print '
       <tr valign="top">
            <th scope="row"><label for="admin_submission">'.__('Spot no ','wpestate').$i.'</label></th>
           
            <td><select id="adv_search_what'.$i.'" name="adv_search_what[]">';
                print   wpestate_show_advanced_search_options($i-1,$adv_search_what);
	print'	</select>
            </td>
            <td><select id="adv_search_how'.$i.'" name="adv_search_how[]">';
                 print  wpestate_show_advanced_search_how($i-1,$adv_search_how);
        
        $new_val=''; 
        if( isset($adv_search_label[$i-1]) ){
            $new_val=$adv_search_label[$i-1]; 
        }
         
        
        print '	</select>
            </td>
            <td>
                <input type="text" id="adv_search_label'.$i.'" name="adv_search_label[]" value="'.$new_val.'">
            </td>
        </tr>';
    }
 
        
        
        print' </table>
       
        <p style="margin-left:10px;">
         '.__('*Do not duplicate labels and make sure search fields do not contradict themselves','wpestate').'</br>
        '.__('*Labels will not apply for dropdowns fields','wpestate').'</br>
      
        </p>';
        
        print '<h1 class="wpestate-tabh1">'.__('Amenities and Features for Advanced Search','wpestate').'</h1>'; 
        $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
        $feature_list_array =   explode( ',',$feature_list);
       
        $advanced_exteded =  get_option('wp_estate_advanced_exteded');
        
        print ' <p style="margin-left:10px;">  '.__('*Hold CTRL for multiple selection','wpestate').'</p>'
        . '<p style="margin-left:10px;"> <select name="advanced_exteded[]" multiple="multiple" style="height:400px;">';
        foreach($feature_list_array as $checker => $value){
            $post_var_name  =   str_replace(' ','_', trim($value) );
            print '<option value="'.$post_var_name.'"' ;
            if(is_array($advanced_exteded)){
                if( in_array ($post_var_name,$advanced_exteded) ){
                    print ' selected="selected" ';
                } 
            }
            
            print '>'.$value.'</option>';                
        }
        print '</select></p>';
        print'
        <p class="submit">
           <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
        </p>
        
        ';
}
endif; // end   wpestate_theme_admin_adv_search  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Membership Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_membershipsettings') ):
function wpestate_theme_admin_membershipsettings(){
    $price_submission               =   floatval( get_option('wp_estate_price_submission','') );
    $price_featured_submission      =   floatval( get_option('wp_estate_price_featured_submission','') );    
    $paypal_client_id               =   esc_html( get_option('wp_estate_paypal_client_id','') );
    $paypal_client_secret           =   esc_html( get_option('wp_estate_paypal_client_secret','') );
    $paypal_api_username            =   esc_html( get_option('wp_estate_paypal_api_username','') );
    $paypal_api_password            =   esc_html( get_option('wp_estate_paypal_api_password','') );
    $paypal_api_signature           =   esc_html( get_option('wp_estate_paypal_api_signature','') );
    $paypal_rec_email               =   esc_html( get_option('wp_estate_paypal_rec_email','') );
    $free_feat_list                 =   esc_html( get_option('wp_estate_free_feat_list','') );
    $free_mem_list                  =   esc_html( get_option('wp_estate_free_mem_list','') );
    $cache_array                    =   array('yes','no');  
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $free_mem_list_unl='';
    if ( intval( get_option('wp_estate_free_mem_list_unl', '' ) ) == 1){
      $free_mem_list_unl=' checked="checked" ';  
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $paypal_api_select='';
    $paypal_array   =   array( __('sandbox','wpestate'), __('live','wpestate') );
    $paypal_status  =   esc_html( get_option('wp_estate_paypal_api','') );
    
  
    foreach($paypal_array as $value){
	$paypal_api_select.='<option value="'.$value.'"';
	if ($paypal_status==$value){
            $paypal_api_select.=' selected="selected" ';
	}
	$paypal_api_select.='>'.$value.'</option>';
}



    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $submission_curency_array=array('USD','EUR','AUD','BRL','CAD','CZK','DKK','HKD','HUF','ILS','JPY','MYR','MXN','NOK','NZD','PHP','PLN','GBP','SGD','SEK','CHF','TWD','THB','TRY');
    $submission_curency_status = esc_html( get_option('wp_estate_submission_curency','') );
    $submission_curency_symbol='';

    foreach($submission_curency_array as $value){
            $submission_curency_symbol.='<option value="'.$value.'"';
            if ($submission_curency_status==$value){
                $submission_curency_symbol.=' selected="selected" ';
            }
            $submission_curency_symbol.='>'.$value.'</option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $paypal_array=array('no','per listing','membership');
    $paid_submission_symbol='';
    $paid_submission_status= esc_html ( get_option('wp_estate_paid_submission','') );

    foreach($paypal_array as $value){
            $paid_submission_symbol.='<option value="'.$value.'"';
            if ($paid_submission_status==$value){
                    $paid_submission_symbol.=' selected="selected" ';
            }
            $paid_submission_symbol.='>'.$value.'</option>';
    }
    
    

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $admin_submission_symbol='';
    $admin_submission_status= esc_html ( get_option('wp_estate_admin_submission','') );
    
    foreach($cache_array as $value){
            $admin_submission_symbol.='<option value="'.$value.'"';
            if ($admin_submission_status==$value){
                    $admin_submission_symbol.=' selected="selected" ';
            }
            $admin_submission_symbol.='>'.$value.'</option>';
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////
    
    $user_agent_symbol='';
    $user_agent_status= esc_html ( get_option('wp_estate_user_agent','') );
    
    foreach($cache_array as $value){
            $user_agent_symbol.='<option value="'.$value.'"';
            if ($user_agent_status==$value){
                    $user_agent_symbol.=' selected="selected" ';
            }
            $user_agent_symbol.='>'.$value.'</option>';
    }
    
    
    
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Membership & Payment Settings','wpestate').'</h1>';  
    
    print '
        <table class="form-table">
         <tr valign="top">
            <th scope="row"><label for="paid_submission">'.__('Enable Paid Submission via Paypal?','wpestate').'</label></th>
           
            <td> <select id="paid_submission" name="paid_submission">
                    '.$paid_submission_symbol.'
		 </select>
            </td>
        </tr>
        

          <tr valign="top">
            <th scope="row"><label for="admin_submission">'.__('Submited Listings should be approved by admin?','wpestate').'</label></th>
           
            <td> <select id="admin_submission" name="admin_submission">
                    '.$admin_submission_symbol.'
		 </select>
            </td>
        </tr>
        
       <tr valign="top">
            <th scope="row"><label for="user_agent">'.__('Front end registred users should be saved as agents?','wpestate').'</label></th>
           
            <td> <select id="user_agent" name="user_agent">
                    '.$user_agent_symbol.'
		 </select>
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="price_submission">'.__('Price Per Submission','wpestate').'</label></th>
           <td><input  type="text" id="price_submission" name="price_submission"  value="'.$price_submission.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="price_featured_submission">'.__('Price to make the listing featured','wpestate').'</label></th>
           <td><input  type="text" id="price_featured_submission" name="price_featured_submission"  value="'.$price_featured_submission.'"/> </td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="submission_curency">'.__('Currency For Paid Submission','wpestate').'</label></th>
            <td>
                <select id="submission_curency" name="submission_curency">
                    '.$submission_curency_symbol.'
                </select> 
            </td>
        </tr>
        
         <tr valign="top">
            <th scope="row"><label for="paypal_client_id">'.__('Paypal Client id','wpestate').'</label></th>
            <td><input  type="text" id="paypal_client_id" name="paypal_client_id" class="regular-text"  value="'.$paypal_client_id.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_client_secret ">'.__('Paypal Client Secret Key ','wpestate').'</label></th>
            <td><input  type="text" id="paypal_client_secret" name="paypal_client_secret"  class="regular-text" value="'.$paypal_client_secret.'"/> </td>
        </tr>
        
         <tr valign="top">
            <th scope="row"><label for="paypal_api">'.__('Paypal Api ','wpestate').'</label></th>
            <td>
              <select id="paypal_api" name="paypal_api">
                    '.$paypal_api_select.'
                </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_api_username">'.__('Paypal Api User Name ','wpestate').'</label></th>
            <td><input  type="text" id="paypal_api_username" name="paypal_api_username"  class="regular-text" value="'.$paypal_api_username.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_api_password ">'.__('Paypal API Password ','wpestate').'</label></th>
            <td><input  type="text" id="paypal_api_password" name="paypal_api_password"  class="regular-text" value="'.$paypal_api_password.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_api_signature">'.__('Paypal API Signature','wpestate').'</label></th>
            <td><input  type="text" id="paypal_api_signature" name="paypal_api_signature"  class="regular-text" value="'.$paypal_api_signature.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="paypal_rec_email">'.__('Paypal receiving email','wpestate').'</label></th>
            <td><input  type="text" id="paypal_rec_email" name="paypal_rec_email"  class="regular-text" value="'.$paypal_rec_email.'"/> </td>
        </tr>
        
         <tr valign="top">
            <th scope="row"><label for="free_mem_list">'.__('Free Membership - no of listings','wpestate').' </label></th>
            <td>
                <input  type="text" id="free_mem_list" name="free_mem_list" style="margin-right:20px;"  value="'.$free_mem_list.'"/> 
       
                <input type="hidden" name="free_mem_list_unl" value="">
                <input type="checkbox"  id="free_mem_list_unl" name="free_mem_list_unl" value="1" '.$free_mem_list_unl.' />
                <label for="free_mem_list_unl">'.__('Unlimited listings ?','wpestate').'</label>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="free_feat_list">'.__('Free Membership - no of featured listings','wpestate').' </label></th>
            <td>
                <input  type="text" id="free_feat_list" name="free_feat_list" style="margin-right:20px;"    value="'.$free_feat_list.'"/>
              
            </td>
        </tr>

        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes','wpestate').'" />
        </p>  
    ';
    print '</div>';
}
endif; // end   wpestate_theme_admin_membershipsettings  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Map Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_mapsettings') ):
function wpestate_theme_admin_mapsettings(){
    $general_longitude              =   esc_html( get_option('wp_estate_general_longitude') );
    $general_latitude               =   esc_html( get_option('wp_estate_general_latitude') );
    $api_key                        =   esc_html( get_option('wp_estate_api_key') );
    $cache_array                    =   array('yes','no');
    $default_map_zoom               =   intval   ( get_option('wp_estate_default_map_zoom','') );
    $zoom_cluster                   =   esc_html ( get_option('wp_estate_zoom_cluster ','') );
    $hq_longitude                   =   esc_html ( get_option('wp_estate_hq_longitude') );
    $hq_latitude                    =   esc_html ( get_option('wp_estate_hq_latitude') );
    $min_height                     =   intval   ( get_option('wp_estate_min_height','') );
    $max_height                     =   intval   ( get_option('wp_estate_max_height','') );

    
    


    ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    $cache_symbol='';
    $cache_array_status= esc_html ( get_option('wp_estate_cache','') );

    foreach($cache_array as $value){
            $cache_symbol.='<option value="'.$value.'"';
            if ($cache_array_status==$value){
                    $cache_symbol.=' selected="selected" ';
            }
            $cache_symbol.='>'.$value.'</option>';
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $show_filter_map_symbol='';
    $show_filter_map_status= esc_html ( get_option('wp_estate_show_filter_map','') );

    foreach($cache_array as $value){
            $show_filter_map_symbol.='<option value="'.$value.'"';
            if ($show_filter_map_status==$value){
                    $show_filter_map_symbol.=' selected="selected" ';
            }
            $show_filter_map_symbol.='>'.$value.'</option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $home_small_map_symbol='';
    $home_small_map_status= esc_html ( get_option('wp_estate_home_small_map','') );

    foreach($cache_array as $value){
            $home_small_map_symbol.='<option value="'.$value.'"';
            if ($home_small_map_status==$value){
                    $home_small_map_symbol.=' selected="selected" ';
            }
            $home_small_map_symbol.='>'.$value.'</option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $pin_cluster_symbol='';
    $pin_cluster_status= esc_html ( get_option('wp_estate_pin_cluster','') );

    foreach($cache_array as $value){
            $pin_cluster_symbol.='<option value="'.$value.'"';
            if ($pin_cluster_status==$value){
                    $pin_cluster_symbol.=' selected="selected" ';
            }
            $pin_cluster_symbol.='>'.$value.'</option>';
    }
    
    $geolocation_radius         =   esc_html ( get_option('wp_estate_geolocation_radius','') );
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
   /* $geolocation_symbol='';
    $geolocation_status= esc_html ( get_option('wp_estate_geolocation','') );

    foreach($cache_array as $value){
            $geolocation_symbol.='<option value="'.$value.'"';
            if ($geolocation_status==$value){
                    $geolocation_symbol.=' selected="selected" ';
            }
            $geolocation_symbol.='>'.$value.'</option>';
    }
*/
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $idx_symbol='';
    $idx_array_status= esc_html ( get_option('wp_estate_idx_enable','') );

    foreach($cache_array as $value){
            $idx_symbol.='<option value="'.$value.'"';
            if ($idx_array_status==$value){
                    $idx_symbol.=' selected="selected" ';
            }
            $idx_symbol.='>'.$value.'</option>';
    }

     ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $cache_array2=array('no','yes');
    $keep_min_symbol='';
    $keep_min_status= esc_html ( get_option('wp_estate_keep_min','') );
    
    foreach($cache_array2 as $value){
            $keep_min_symbol.='<option value="'.$value.'"';
            if ($keep_min_status==$value){
                    $keep_min_symbol.=' selected="selected" ';
            }
            $keep_min_symbol.='>'.$value.'</option>';
    }
    
    $show_adv_search_symbol_map_close='';
    $show_adv_search_map_close= esc_html ( get_option('wp_estate_show_adv_search_map_close','') );
    
    foreach($cache_array as $value){
            $show_adv_search_symbol_map_close.='<option value="'.$value.'"';
            if ($show_adv_search_map_close==$value){
                    $show_adv_search_symbol_map_close.=' selected="selected" ';
            }
            $show_adv_search_symbol_map_close.='>'.$value.'</option>';
    }
    
     ///////////////////////////////////////////////////////////////////////////////////////////////////////
 
    $show_g_search_symbol='';
    $show_g_search_status= esc_html ( get_option('wp_estate_show_g_search','') );
    
    foreach($cache_array2 as $value){
            $show_g_search_symbol.='<option value="'.$value.'"';
            if ($show_g_search_status==$value){
                    $show_g_search_symbol.=' selected="selected" ';
            }
            $show_g_search_symbol.='>'.$value.'</option>';
    }
    
    
    
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Google Maps Settings','wpestate').'</h1>';  
    
    print '
        <table class="form-table">
        
        <tr valign="top">
           <th scope="row"><label for="api_key">'.__('Google Maps API KEY','wpestate').'</label></th>
           <td><input  type="text" id="api_key" name="api_key" class="regular-text" value="'.$api_key.'"/></td>
        </tr>
          <tr valign="top">
            <th scope="row"></th>
            <td>'.__('The Google Maps JavaScript API v3 does not require an API key to function correctly. However, we strongly encourage you to get  an APIs Console key and post the code in Theme Options. You can get it from <a href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">here</a>','wpestate').'.</td>
        </tr>
        <tr valign="top">
            <th scope="row"> <label for="general_latitude">'.__('Starting Point Latitude','wpestate').'</label></th>
            <td><input  type="text" id="general_latitude"  name="general_latitude"   value="'.$general_latitude.'"/></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"> <label for="general_longitude">'.__('Starting Point Longitude','wpestate').'</label></th>
            <td><input  type="text" id="general_longitude" name="general_longitude"  value="'.$general_longitude.'"/> </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="default_map_zoom">'.__(' Default Map zoom (1 to 20) ','wpestate').'</label></th>
            <td>
                <input type="text" id="default_map_zoom" name="default_map_zoom" value="'.$default_map_zoom.'">   
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="copyright_message">'.__('Use Cache for Google maps ?(*cache will renew it self every 3h)','wpestate').'</label></th>
           
            <td> <select id="cache" name="cache">
                    '.$cache_symbol.'
		 </select>
            </td>
        </tr>
        
      
        
        <tr valign="top">
            <th scope="row"><label for="pin_cluster">'.__('Use Pin Cluster on map','wpestate').'</label></th>
           
            <td> <select id="pin_cluster" name="pin_cluster">
                    '.$pin_cluster_symbol.'
		 </select>
            </td>
        </tr>
        
        
         <tr valign="top">
            <th scope="row"><label for="zoom_cluster">'.__('Maximum zoom level for Cloud Cluster to appear','wpestate').'</label></th>
            <td><input id="zoom_cluster" type="text" size="36" name="zoom_cluster" value="'.$zoom_cluster.'" /></td>       
        </tr>
        
         <tr valign="top">
            <th scope="row"> <label for="hq_latitude">'.__('Contact Page - Company HQ Latitude','wpestate').'</label></th>
            <td><input  type="text" id="hq_latitude"  name="hq_latitude"   value="'.$hq_latitude.'"/></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"> <label for="hq_longitude">'.__('Contact Page - Company HQ Longitude','wpestate').'</label></th>
            <td><input  type="text" id="hq_longitude" name="hq_longitude"  value="'.$hq_longitude.'"/> </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="copyright_message">'.__('Enable dsIDXpress to use the map ','wpestate').'</label></th>          
            <td> <select id="idx_enable" name="idx_enable">
                    '.$idx_symbol.'
		 </select>
            </td>
        </tr>';
        /*
         <tr valign="top">
            <th scope="row"><label for="geolocation">'.__('Enable Geolocation','wpestate').'</label></th>
           
            <td> <select id="geolocation" name="geolocation">
                    '.$geolocation_symbol.'
		 </select>
            </td>
        </tr>
         */        
        print'
         <tr valign="top">
            <th scope="row"><label for="geolocation_radius">'.__('Geolocation Circle over map (in meters)','wpestate').'</label></th>
            <td>  <input id="geolocation_radius" type="text" size="36" name="geolocation_radius" value="'.$geolocation_radius.'" /></td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="min_height">'.__('Height of the Google Map when closed','wpestate').'</label></th>
            <td>  <input id="min_height" type="text" size="36" name="min_height" value="'.$min_height.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="max_height">'.__('Height of Google Map when open','wpestate').'</label></th>
            <td>  <input id="max_height" type="text" size="36" name="max_height" value="'.$max_height.'" /></td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="keep_min">'.__('Force Google Map at the "closed" size ? ','wpestate').'</label></th>
           
            <td> <select id="keep_min" name="keep_min">
                    '.$keep_min_symbol.'
		 </select>
            </td>
        </tr>


        <tr valign="top">
            <th scope="row"><label for="keep_min">'.__('Show Google Search over Map? ','wpestate').'</label></th>
           
            <td> <select id="show_g_search" name="show_g_search">
                    '.$show_g_search_symbol.'
		 </select>
            </td>
        </tr>
        


        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
        </p>  
    ';
    print '</div>';
}
endif; // end   wpestate_theme_admin_mapsettings  



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  General Settings
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_theme_admin_general_settings') ):
function wpestate_theme_admin_general_settings(){
    $cache_array                    =   array('yes','no');
    $social_array                   =   array('no','yes');
    $logo_image                     =   esc_html( get_option('wp_estate_logo_image','') );
    $footer_logo_image              =   esc_html( get_option('wp_estate_footer_logo_image','') );
    $favicon_image                  =   esc_html( get_option('wp_estate_favicon_image','') );
    $google_analytics_code          =   esc_html ( get_option('wp_estate_google_analytics_code','') );
  
    $general_country                =   esc_html( get_option('wp_estate_general_country') );

    $currency_symbol                =   esc_html( get_option('wp_estate_currency_symbol') );
    $front_end_register             =   esc_html( get_option('wp_estate_front_end_register','') );
    $front_end_login                =   esc_html( get_option('wp_estate_front_end_login','') );  
   

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $measure_sys='';
    $measure_array=array( __('feet','wpestate')     =>__('ft','wpestate'),
                          __('meters','wpestate')   =>__('m','wpestate') 
                        );
    
    $measure_array_status= esc_html( get_option('wp_estate_measure_sys','') );

    foreach($measure_array as $key => $value){
            $measure_sys.='<option value="'.$value.'"';
            if ($measure_array_status==$value){
                $measure_sys.=' selected="selected" ';
            }
            $measure_sys.='>'.__('square','wpestate').' '.$key.' - '.$value.'<sup>2</sup></option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $enable_top_bar_symbol='';
    $top_bar_status= esc_html ( get_option('wp_estate_enable_top_bar','') );

    foreach($cache_array as $value){
            $enable_top_bar_symbol.='<option value="'.$value.'"';
            if ($top_bar_status==$value){
                    $enable_top_bar_symbol.=' selected="selected" ';
            }
            $enable_top_bar_symbol.='>'.$value.'</option>';
    }

   





    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $where_currency_symbol          =   '';
    $where_currency_symbol_array    =   array('before','after');
    $where_currency_symbol_status   =   esc_html( get_option('wp_estate_where_currency_symbol') );
    foreach($where_currency_symbol_array as $value){
            $where_currency_symbol.='<option value="'.$value.'"';
            if ($where_currency_symbol_status==$value){
                $where_currency_symbol.=' selected="selected" ';
            }
            $where_currency_symbol.='>'.$value.'</option>';
    }

    
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('General Settings','wpestate').'</h1>';  
    print '<table class="form-table">
        <tr valign="top">
            <th scope="row"><label for="logo_image">'.__('Your Logo','wpestate').'</label></th>
            <td>
	         <input id="logo_image" type="text" size="36" name="logo_image" value="'.$logo_image.'" />
		<input id="logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wpestate').'" />
            </td>
        </tr> 
        
         <tr valign="top">
            <th scope="row"><label for="footer_logo_image">'.__('Retina ready logo (add @2 after the name. For ex logo@2.jpg) ','wpestate').'</label></th>
            <td>
	         <input id="footer_logo_image" type="text" size="36" name="footer_logo_image" value="'.$footer_logo_image.'" />
		<input id="footer_logo_image_button" type="button"  class="upload_button button" value="'.__('Upload Logo','wpestate').'" />
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="favicon_image">'.__('Your Favicon','wpestate').'</label></th>
            <td>
	        <input id="favicon_image" type="text" size="36" name="favicon_image" value="'.$favicon_image.'" />
		<input id="favicon_image_button" type="button"  class="upload_button button" value="'.__('Upload Favicon','wpestate').'" />
            </td>
        </tr> 
        
        
        <tr valign="top">
            <th scope="row"><label for="google_analytics_code">'.__('Google Analytics Tracking id (ex UA-41924406-1)','wpestate').'</label></th>
            <td><input cols="57" rows="2" name="google_analytics_code" id="google_analytics_code" value="'.$google_analytics_code.'"></input></td>
        </tr>
        
    
        
       
          <tr valign="top">
             <th scope="row"><label for="country_list">'.__('Country:','wpestate').'</label></th>
             <td>'.wpestate_general_country_list($general_country).'</td>
        </tr>
        
 
         <tr valign="top">
            <th scope="row"><label for="">'.__('Currency symbol','wpestate').'</label></th>
            <td><input  type="text" id="currency_symbol" name="currency_symbol"  value="'.$currency_symbol.'"/> </td>
        </tr>
       
        <tr valign="top">
            <th scope="row"><label for="">'.__('Where to show the currency symbol?','wpestate').'</label></th>
            <td>
                <select id="where_currency_symbol" name="where_currency_symbol">
                    '.$where_currency_symbol.'
                </select> 
            </td>
        </tr>
        
        
         <tr valign="top">
            <th scope="row"><label for="">'.__('Measurement Unit','wpestate').'</label></th>
            <td> <select id="measure_sys" name="measure_sys">
                    '.$measure_sys.'
		 </select>
            </td>
        </tr>
        
       
        
        </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes','wpestate').'" />
    </p>    
    ';
    
 print '</div>';   
}
endif; // end   wpestate_theme_admin_general_settings  



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Social $  Contact
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_theme_admin_social') ):
function wpestate_theme_admin_social(){
    $fax_ac                     =   esc_html ( get_option('wp_estate_fax_ac','') );
    $skype_ac                   =   esc_html ( get_option('wp_estate_skype_ac','') );
    $telephone_no               =   esc_html ( get_option('wp_estate_telephone_no','') );
    $mobile_no                  =   esc_html ( get_option('wp_estate_mobile_no','') );
    $company_name               =   esc_html ( get_option('wp_estate_company_name','') );
    $email_adr                  =   esc_html ( get_option('wp_estate_email_adr','') );
    $duplicate_email_adr        =   esc_html ( get_option('wp_estate_duplicate_email_adr','') );
    
    $co_address                 =   esc_html ( get_option('wp_estate_co_address','') );
    $facebook_link              =   esc_html ( get_option('wp_estate_facebook_link','') );
    $twitter_link               =   esc_html ( get_option('wp_estate_twitter_link','') );
    $google_link                =   esc_html ( get_option('wp_estate_google_link','') );
    $linkedin_link              =   esc_html ( get_option('wp_estate_linkedin_link','') );
    $pinterest_link             =   esc_html ( get_option('wp_estate_pinterest_link','') );
    
    $twitter_consumer_key       =   esc_html ( get_option('wp_estate_twitter_consumer_key','') );
    $twitter_consumer_secret    =   esc_html ( get_option('wp_estate_twitter_consumer_secret','') );
    $twitter_access_token       =   esc_html ( get_option('wp_estate_twitter_access_token','') );
    $twitter_access_secret      =   esc_html ( get_option('wp_estate_twitter_access_secret','') );
    $twitter_cache_time         =   intval   ( get_option('wp_estate_twitter_cache_time','') );
    $zillow_api_key             =   esc_html ( get_option('wp_estate_zillow_api_key','') );
    $facebook_api               =   esc_html ( get_option('wp_estate_facebook_api','') );
    $facebook_secret            =   esc_html ( get_option('wp_estate_facebook_secret','') );
    $company_contact_image      =   esc_html( get_option('wp_estate_company_contact_image','') );
    
    $google_oauth_api           =   esc_html ( get_option('wp_estate_google_oauth_api','') );
    $google_oauth_client_secret =   esc_html ( get_option('wp_estate_google_oauth_client_secret','') );
    $google_api_key             =   esc_html ( get_option('wp_estate_google_api_key','') );
    
    
    $social_array               =   array('no','yes');
    $facebook_login_select='';
    $facebook_status  =   esc_html( get_option('wp_estate_facebook_login','') );

    foreach($social_array as $value){
            $facebook_login_select.='<option value="'.$value.'"';
            if ($facebook_status==$value){
                $facebook_login_select.=' selected="selected" ';
            }
            $facebook_login_select.='>'.$value.'</option>';
    }


    $google_login_select='';
    $google_status  =   esc_html( get_option('wp_estate_google_login','') );

    foreach($social_array as $value){
            $google_login_select.='<option value="'.$value.'"';
            if ($google_status==$value){
                $google_login_select.=' selected="selected" ';
            }
            $google_login_select.='>'.$value.'</option>';
    }


    $yahoo_login_select='';
    $yahoo_status  =   esc_html( get_option('wp_estate_yahoo_login','') );

    foreach($social_array as $value){
            $yahoo_login_select.='<option value="'.$value.'"';
            if ($yahoo_status==$value){
                $yahoo_login_select.=' selected="selected" ';
            }
            $yahoo_login_select.='>'.$value.'</option>';
    }

    
    
    
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">Social</h1>';
    
    print '<table class="form-table">     
         <tr valign="top">
            <th scope="row"><label for="company_contact_image">'.__('Image for Contact Page','wpestate').'</label></th>
            <td>
	        <input id="company_contact_image" type="text" size="36" name="company_contact_image" value="'.$company_contact_image.'" />
		<input id="company_contact_image_button" type="button"  class="upload_button button" value="'.__('Upload Image','wpestate').'" />
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="company_name">'.__('Company Name','wpestate').'</label></th>
            <td>  <input id="company_name" type="text" size="36" name="company_name" value="'.$company_name.'" /></td>
        </tr>   
        
    	<tr valign="top">
            <th scope="row"><label for="email_adr">'.__('Email','wpestate').'</label></th>
            <td>  <input id="email_adr" type="text" size="36" name="email_adr" value="'.$email_adr.'" /></td>
        </tr>    
        
        <tr valign="top">
            <th scope="row"><label for="duplicate_email_adr">'.__('Send all contact emails to:','wpestate').'</label></th>
            <td>  <input id="duplicate_email_adr" type="text" size="36" name="duplicate_email_adr" value="'.$duplicate_email_adr.'" /></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="telephone_no">'.__('Telephone','wpestate').'</label></th>
            <td>  <input id="telephone_no" type="text" size="36" name="telephone_no" value="'.$telephone_no.'" /></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="mobile_no">'.__('Mobile','wpestate').'</label></th>
            <td>  <input id="mobile_no" type="text" size="36" name="mobile_no" value="'.$mobile_no.'" /></td>
        </tr> 
        
         <tr valign="top">
            <th scope="row"><label for="fax_ac">'.__('Fax','wpestate').'</label></th>
            <td>  <input id="fax_ac" type="text" size="36" name="fax_ac" value="'.$fax_ac.'" /></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="skype_ac">'.__('Skype','wpestate').'</label></th>
            <td>  <input id="skype_ac" type="text" size="36" name="skype_ac" value="'.$skype_ac.'" /></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="co_address">'.__('Address','wpestate').'</label></th>
            <td><textarea cols="57" rows="2" name="co_address" id="co_address">'.$co_address.'</textarea></td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="facebook_link">'.__('Facebook Link','wpestate').'</label></th>
            <td>  <input id="facebook_link" type="text" size="36" name="facebook_link" value="'.$facebook_link.'" /></td>
        </tr>        
        
        <tr valign="top">
            <th scope="row"><label for="twitter_link">'.__('Twitter Page Link','wpestate').'</label></th>
            <td>  <input id="twitter_link" type="text" size="36" name="twitter_link" value="'.$twitter_link.'" /></td>
        </tr>
         
        <tr valign="top">
            <th scope="row"><label for="google_link">'.__('Google+ Link','wpestate').'</label></th>
            <td>  <input id="google_link" type="text" size="36" name="google_link" value="'.$google_link.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="pinterest_link">'.__('Pinterest Link','wpestate').'</label></th>
            <td>  <input id="pinterest_link" type="text" size="36" name="pinterest_link" value="'.$pinterest_link.'" /></td>
        </tr>
        
      <tr valign="top">
            <th scope="row"><label for="linkedin_link">'.__('Linkedin Link','wpestate').'</label></th>
            <td>  <input id="linkedin_link" type="text" size="36" name="linkedin_link" value="'.$linkedin_link.'" /></td>
        </tr>
        

        <tr valign="top">
            <th scope="row"><label for="twitter_consumer_key">'.__('Twitter Consumer Key','wpestate').'</label></th>
            <td>  <input id="twitter_consumer_key" type="text" size="36" name="twitter_consumer_key" value="'.$twitter_consumer_key.'" /></td>
        </tr>
        
         <tr valign="top">
            <th scope="row"><label for="twitter_consumer_secret">'.__('Twitter Consumer Secret','wpestate').'</label></th>
            <td>  <input id="twitter_consumer_secret" type="text" size="36" name="twitter_consumer_secret" value="'.$twitter_consumer_secret.'" /></td>
        </tr>
        
         <tr valign="top">
            <th scope="row"><label for="twitter_access_token">'.__('Twitter Access Token','wpestate').'</label></th>
            <td>  <input id="twitter_account" type="text" size="36" name="twitter_access_token" value="'.$twitter_access_token.'" /></td>
        </tr>
        
         <tr valign="top">
            <th scope="row"><label for="twitter_access_secret">'.__('Twitter Access Token Secret','wpestate').'</label></th>
            <td>  <input id="twitter_access_secret" type="text" size="36" name="twitter_access_secret" value="'.$twitter_access_secret.'" /></td>
        </tr>
        
         <tr valign="top">
            <th scope="row"><label for="twitter_cache_time">'.__('Twitter Cache Time in hours','wpestate').'</label></th>
            <td>  <input id="twitter_cache_time" type="text" size="36" name="twitter_cache_time" value="'.$twitter_cache_time.'" /></td>
        </tr>
         
        <tr valign="top">
            <th scope="row"><label for="facebook_api">'.__('Facebook Api Key (for Facebook login)','wpestate').'</label></th>
            <td>  <input id="facebook_api" type="text" size="36" name="facebook_api" value="'.$facebook_api.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="facebook_secret">'.__('Facebook secret code (for Facebook login) ','wpestate').'</label></th>
            <td>  <input id="facebook_secret" type="text" size="36" name="facebook_secret" value="'.$facebook_secret.'" /></td>
        </tr>
       
        <tr valign="top">
            <th scope="row"><label for="google_oauth_api">'.__('Google OAuth client id (for Google login)','wpestate').'</label></th>
            <td>  <input id="google_oauth_api" type="text" size="36" name="google_oauth_api" value="'.$google_oauth_api.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="google_oauth_client_secret">'.__('Google Client Secret (for Google login)','wpestate').'</label></th>
            <td>  <input id="google_oauth_client_secret" type="text" size="36" name="google_oauth_client_secret" value="'.$google_oauth_client_secret.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="google_api_key">'.__('Google Api key (for Google login)','wpestate').'</label></th>
            <td>  <input id="google_api_key" type="text" size="36" name="google_api_key" value="'.$google_api_key.'" /></td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="facebook_login">'.__('Allow login via Facebook ? ','wpestate').'</label></th>
            <td> <select id="facebook_login" name="facebook_login">
                    '.$facebook_login_select.'
                </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="google_login">'.__('Allow login via Google ?','wpestate').' </label></th>
            <td> <select id="google_login" name="google_login">
                    '.$google_login_select.'
                </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="yahoo_login">'.__('Allow login via Yahoo ? ','wpestate').'</label></th>
            <td> <select id="yahoo_login" name="yahoo_login">
                    '.$yahoo_login_select.'
                </select>
            </td>
        </tr>
    </table>
    <p class="submit">
      <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
    </p>';
print '</div>';
}
endif; // end   wpestate_theme_admin_social  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Apperance
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_apperance') ):
function wpestate_theme_admin_apperance(){
    $cache_array                =   array('yes','no');
    $prop_no                    =   intval   ( get_option('wp_estate_prop_no','') );
    $blog_sidebar_name          =   esc_html ( get_option('wp_estate_blog_sidebar_name','') );
    $zillow_api_key             =   esc_html ( get_option('wp_estate_zillow_api_key','') );  
    $copyright_message          =   esc_html ( get_option('wp_estate_copyright_message','') );

    ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    $show_empty_city_status_symbol='';
    $show_empty_city_status= esc_html ( get_option('wp_estate_show_empty_city','') );

    foreach($cache_array as $value){
            $show_empty_city_status_symbol.='<option value="'.$value.'"';
            if ($show_empty_city_status==$value){
                    $show_empty_city_status_symbol.=' selected="selected" ';
            }
            $show_empty_city_status_symbol.='>'.$value.'</option>';
    }


    $show_top_bar_user_menu_symbol='';
    $show_top_bar_user_menu_status= esc_html ( get_option('wp_estate_show_top_bar_user_menu','') );    
    
    foreach($cache_array as $value){
       $show_top_bar_user_menu_symbol.='<option value="'.$value.'"';
       if ($show_top_bar_user_menu_status==$value){
               $show_top_bar_user_menu_symbol.=' selected="selected" ';
       }
       $show_top_bar_user_menu_symbol.='>'.$value.'</option>';
    }
 
        
    $show_top_bar_user_login_symbol='';
    $show_top_bar_user_login_status= esc_html ( get_option('wp_estate_show_top_bar_user_login','') );    
    
    foreach($cache_array as $value){
       $show_top_bar_user_login_symbol.='<option value="'.$value.'"';
       if ($show_top_bar_user_login_status==$value){
               $show_top_bar_user_login_symbol.=' selected="selected" ';
       }
       $show_top_bar_user_login_symbol.='>'.$value.'</option>';
    }
 
    
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $blog_sidebar_name_select='';
    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { 
        $blog_sidebar_name_select.='<option value="'.($sidebar['id'] ).'"';
            if($blog_sidebar_name==$sidebar['id']){ 
               $blog_sidebar_name_select.=' selected="selected"';
            }
        $blog_sidebar_name_select.=' >'.ucwords($sidebar['name']).'</option>';
    } 
    
   ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $blog_unit          =   esc_html ( get_option('wp_estate_blog_unit','') );
    $blog_unit_select   =   '';
    $blog_unit_array    =   array(
                                'grid'    =>__('grid','wpestate'),
                                'list'      => __('list','wpestate')
                            );
    
    foreach ( $blog_unit_array as $unit=>$label ) { 
        $blog_unit_select.='<option value="'.$unit.'"';
            if( $blog_unit == $unit ){ 
               $blog_unit_select.=' selected="selected"';
            }
        $blog_unit_select.=' >'.$label.'</option>';
    } 
            
    

    ///////////////////////////////////////////////////////////////////////////////////////////////////////    
    $blog_sidebar_select ='';
    $blog_sidebar= esc_html ( get_option('wp_estate_blog_sidebar','') );
    $blog_sidebar_array=array('no sidebar','right','left');

    foreach($blog_sidebar_array as $value){
            $blog_sidebar_select.='<option value="'.$value.'"';
            if ($blog_sidebar==$value){
                    $blog_sidebar_select.='selected="selected"';
            }
            $blog_sidebar_select.='>'.$value.'</option>';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    $general_font_select='';
    $general_font= esc_html ( get_option('wp_estate_general_font','') );
    if($general_font!='x'){
    $general_font_select='<option value="'.$general_font.'">'.$general_font.'</option>';
    }


    ///////////////////////////////////////////////////////////////////////////////////////////////////////
  


    $wide_array=array(
               "1"  =>  __("wide","wpestate"),
               "2"  =>  __("boxed","wpestate")
            );
    $wide_status_symbol     =   '';
    $wide_status_status     =   esc_html(get_option('wp_estate_wide_status',''));
    
    
    foreach($wide_array as $key => $value){
        $wide_status_symbol.='<option value="'.$key.'"';
        if ($wide_status_status == $key){
                $wide_status_symbol.=' selected="selected" ';
        }
        $wide_status_symbol.='> '.$value.'</option>';
    }
  

    $google_fonts_array = array(                          
                                                            "Abel" => "Abel",
                                                            "Abril Fatface" => "Abril Fatface",
                                                            "Aclonica" => "Aclonica",
                                                            "Acme" => "Acme",
                                                            "Actor" => "Actor",
                                                            "Adamina" => "Adamina",
                                                            "Advent Pro" => "Advent Pro",
                                                            "Aguafina Script" => "Aguafina Script",
                                                            "Aladin" => "Aladin",
                                                            "Aldrich" => "Aldrich",
                                                            "Alegreya" => "Alegreya",
                                                            "Alegreya SC" => "Alegreya SC",
                                                            "Alex Brush" => "Alex Brush",
                                                            "Alfa Slab One" => "Alfa Slab One",
                                                            "Alice" => "Alice",
                                                            "Alike" => "Alike",
                                                            "Alike Angular" => "Alike Angular",
                                                            "Allan" => "Allan",
                                                            "Allerta" => "Allerta",
                                                            "Allerta Stencil" => "Allerta Stencil",
                                                            "Allura" => "Allura",
                                                            "Almendra" => "Almendra",
                                                            "Almendra SC" => "Almendra SC",
                                                            "Amaranth" => "Amaranth",
                                                            "Amatic SC" => "Amatic SC",
                                                            "Amethysta" => "Amethysta",
                                                            "Andada" => "Andada",
                                                            "Andika" => "Andika",
                                                            "Angkor" => "Angkor",
                                                            "Annie Use Your Telescope" => "Annie Use Your Telescope",
                                                            "Anonymous Pro" => "Anonymous Pro",
                                                            "Antic" => "Antic",
                                                            "Antic Didone" => "Antic Didone",
                                                            "Antic Slab" => "Antic Slab",
                                                            "Anton" => "Anton",
                                                            "Arapey" => "Arapey",
                                                            "Arbutus" => "Arbutus",
                                                            "Architects Daughter" => "Architects Daughter",
                                                            "Arimo" => "Arimo",
                                                            "Arizonia" => "Arizonia",
                                                            "Armata" => "Armata",
                                                            "Artifika" => "Artifika",
                                                            "Arvo" => "Arvo",
                                                            "Asap" => "Asap",
                                                            "Asset" => "Asset",
                                                            "Astloch" => "Astloch",
                                                            "Asul" => "Asul",
                                                            "Atomic Age" => "Atomic Age",
                                                            "Aubrey" => "Aubrey",
                                                            "Audiowide" => "Audiowide",
                                                            "Average" => "Average",
                                                            "Averia Gruesa Libre" => "Averia Gruesa Libre",
                                                            "Averia Libre" => "Averia Libre",
                                                            "Averia Sans Libre" => "Averia Sans Libre",
                                                            "Averia Serif Libre" => "Averia Serif Libre",
                                                            "Bad Script" => "Bad Script",
                                                            "Balthazar" => "Balthazar",
                                                            "Bangers" => "Bangers",
                                                            "Basic" => "Basic",
                                                            "Battambang" => "Battambang",
                                                            "Baumans" => "Baumans",
                                                            "Bayon" => "Bayon",
                                                            "Belgrano" => "Belgrano",
                                                            "Belleza" => "Belleza",
                                                            "Bentham" => "Bentham",
                                                            "Berkshire Swash" => "Berkshire Swash",
                                                            "Bevan" => "Bevan",
                                                            "Bigshot One" => "Bigshot One",
                                                            "Bilbo" => "Bilbo",
                                                            "Bilbo Swash Caps" => "Bilbo Swash Caps",
                                                            "Bitter" => "Bitter",
                                                            "Black Ops One" => "Black Ops One",
                                                            "Bokor" => "Bokor",
                                                            "Bonbon" => "Bonbon",
                                                            "Boogaloo" => "Boogaloo",
                                                            "Bowlby One" => "Bowlby One",
                                                            "Bowlby One SC" => "Bowlby One SC",
                                                            "Brawler" => "Brawler",
                                                            "Bree Serif" => "Bree Serif",
                                                            "Bubblegum Sans" => "Bubblegum Sans",
                                                            "Buda" => "Buda",
                                                            "Buenard" => "Buenard",
                                                            "Butcherman" => "Butcherman",
                                                            "Butterfly Kids" => "Butterfly Kids",
                                                            "Cabin" => "Cabin",
                                                            "Cabin Condensed" => "Cabin Condensed",
                                                            "Cabin Sketch" => "Cabin Sketch",
                                                            "Caesar Dressing" => "Caesar Dressing",
                                                            "Cagliostro" => "Cagliostro",
                                                            "Calligraffitti" => "Calligraffitti",
                                                            "Cambo" => "Cambo",
                                                            "Candal" => "Candal",
                                                            "Cantarell" => "Cantarell",
                                                            "Cantata One" => "Cantata One",
                                                            "Cardo" => "Cardo",
                                                            "Carme" => "Carme",
                                                            "Carter One" => "Carter One",
                                                            "Caudex" => "Caudex",
                                                            "Cedarville Cursive" => "Cedarville Cursive",
                                                            "Ceviche One" => "Ceviche One",
                                                            "Changa One" => "Changa One",
                                                            "Chango" => "Chango",
                                                            "Chau Philomene One" => "Chau Philomene One",
                                                            "Chelsea Market" => "Chelsea Market",
                                                            "Chenla" => "Chenla",
                                                            "Cherry Cream Soda" => "Cherry Cream Soda",
                                                            "Chewy" => "Chewy",
                                                            "Chicle" => "Chicle",
                                                            "Chivo" => "Chivo",
                                                            "Coda" => "Coda",
                                                            "Coda Caption" => "Coda Caption",
                                                            "Codystar" => "Codystar",
                                                            "Comfortaa" => "Comfortaa",
                                                            "Coming Soon" => "Coming Soon",
                                                            "Concert One" => "Concert One",
                                                            "Condiment" => "Condiment",
                                                            "Content" => "Content",
                                                            "Contrail One" => "Contrail One",
                                                            "Convergence" => "Convergence",
                                                            "Cookie" => "Cookie",
                                                            "Copse" => "Copse",
                                                            "Corben" => "Corben",
                                                            "Cousine" => "Cousine",
                                                            "Coustard" => "Coustard",
                                                            "Covered By Your Grace" => "Covered By Your Grace",
                                                            "Crafty Girls" => "Crafty Girls",
                                                            "Creepster" => "Creepster",
                                                            "Crete Round" => "Crete Round",
                                                            "Crimson Text" => "Crimson Text",
                                                            "Crushed" => "Crushed",
                                                            "Cuprum" => "Cuprum",
                                                            "Cutive" => "Cutive",
                                                            "Damion" => "Damion",
                                                            "Dancing Script" => "Dancing Script",
                                                            "Dangrek" => "Dangrek",
                                                            "Dawning of a New Day" => "Dawning of a New Day",
                                                            "Days One" => "Days One",
                                                            "Delius" => "Delius",
                                                            "Delius Swash Caps" => "Delius Swash Caps",
                                                            "Delius Unicase" => "Delius Unicase",
                                                            "Della Respira" => "Della Respira",
                                                            "Devonshire" => "Devonshire",
                                                            "Didact Gothic" => "Didact Gothic",
                                                            "Diplomata" => "Diplomata",
                                                            "Diplomata SC" => "Diplomata SC",
                                                            "Doppio One" => "Doppio One",
                                                            "Dorsa" => "Dorsa",
                                                            "Dosis" => "Dosis",
                                                            "Dr Sugiyama" => "Dr Sugiyama",
                                                            "Droid Sans" => "Droid Sans",
                                                            "Droid Sans Mono" => "Droid Sans Mono",
                                                            "Droid Serif" => "Droid Serif",
                                                            "Duru Sans" => "Duru Sans",
                                                            "Dynalight" => "Dynalight",
                                                            "EB Garamond" => "EB Garamond",
                                                            "Eater" => "Eater",
                                                            "Economica" => "Economica",
                                                            "Electrolize" => "Electrolize",
                                                            "Emblema One" => "Emblema One",
                                                            "Emilys Candy" => "Emilys Candy",
                                                            "Engagement" => "Engagement",
                                                            "Enriqueta" => "Enriqueta",
                                                            "Erica One" => "Erica One",
                                                            "Esteban" => "Esteban",
                                                            "Euphoria Script" => "Euphoria Script",
                                                            "Ewert" => "Ewert",
                                                            "Exo" => "Exo",
                                                            "Expletus Sans" => "Expletus Sans",
                                                            "Fanwood Text" => "Fanwood Text",
                                                            "Fascinate" => "Fascinate",
                                                            "Fascinate Inline" => "Fascinate Inline",
                                                            "Federant" => "Federant",
                                                            "Federo" => "Federo",
                                                            "Felipa" => "Felipa",
                                                            "Fjord One" => "Fjord One",
                                                            "Flamenco" => "Flamenco",
                                                            "Flavors" => "Flavors",
                                                            "Fondamento" => "Fondamento",
                                                            "Fontdiner Swanky" => "Fontdiner Swanky",
                                                            "Forum" => "Forum",
                                                            "Francois One" => "Francois One",
                                                            "Fredericka the Great" => "Fredericka the Great",
                                                            "Fredoka One" => "Fredoka One",
                                                            "Freehand" => "Freehand",
                                                            "Fresca" => "Fresca",
                                                            "Frijole" => "Frijole",
                                                            "Fugaz One" => "Fugaz One",
                                                            "GFS Didot" => "GFS Didot",
                                                            "GFS Neohellenic" => "GFS Neohellenic",
                                                            "Galdeano" => "Galdeano",
                                                            "Gentium Basic" => "Gentium Basic",
                                                            "Gentium Book Basic" => "Gentium Book Basic",
                                                            "Geo" => "Geo",
                                                            "Geostar" => "Geostar",
                                                            "Geostar Fill" => "Geostar Fill",
                                                            "Germania One" => "Germania One",
                                                            "Give You Glory" => "Give You Glory",
                                                            "Glass Antiqua" => "Glass Antiqua",
                                                            "Glegoo" => "Glegoo",
                                                            "Gloria Hallelujah" => "Gloria Hallelujah",
                                                            "Goblin One" => "Goblin One",
                                                            "Gochi Hand" => "Gochi Hand",
                                                            "Gorditas" => "Gorditas",
                                                            "Goudy Bookletter 1911" => "Goudy Bookletter 1911",
                                                            "Graduate" => "Graduate",
                                                            "Gravitas One" => "Gravitas One",
                                                            "Great Vibes" => "Great Vibes",
                                                            "Gruppo" => "Gruppo",
                                                            "Gudea" => "Gudea",
                                                            "Habibi" => "Habibi",
                                                            "Hammersmith One" => "Hammersmith One",
                                                            "Handlee" => "Handlee",
                                                            "Hanuman" => "Hanuman",
                                                            "Happy Monkey" => "Happy Monkey",
                                                            "Henny Penny" => "Henny Penny",
                                                            "Herr Von Muellerhoff" => "Herr Von Muellerhoff",
                                                            "Holtwood One SC" => "Holtwood One SC",
                                                            "Homemade Apple" => "Homemade Apple",
                                                            "Homenaje" => "Homenaje",
                                                            "IM Fell DW Pica" => "IM Fell DW Pica",
                                                            "IM Fell DW Pica SC" => "IM Fell DW Pica SC",
                                                            "IM Fell Double Pica" => "IM Fell Double Pica",
                                                            "IM Fell Double Pica SC" => "IM Fell Double Pica SC",
                                                            "IM Fell English" => "IM Fell English",
                                                            "IM Fell English SC" => "IM Fell English SC",
                                                            "IM Fell French Canon" => "IM Fell French Canon",
                                                            "IM Fell French Canon SC" => "IM Fell French Canon SC",
                                                            "IM Fell Great Primer" => "IM Fell Great Primer",
                                                            "IM Fell Great Primer SC" => "IM Fell Great Primer SC",
                                                            "Iceberg" => "Iceberg",
                                                            "Iceland" => "Iceland",
                                                            "Imprima" => "Imprima",
                                                            "Inconsolata" => "Inconsolata",
                                                            "Inder" => "Inder",
                                                            "Indie Flower" => "Indie Flower",
                                                            "Inika" => "Inika",
                                                            "Irish Grover" => "Irish Grover",
                                                            "Istok Web" => "Istok Web",
                                                            "Italiana" => "Italiana",
                                                            "Italianno" => "Italianno",
                                                            "Jim Nightshade" => "Jim Nightshade",
                                                            "Jockey One" => "Jockey One",
                                                            "Jolly Lodger" => "Jolly Lodger",
                                                            "Josefin Sans" => "Josefin Sans",
                                                            "Josefin Slab" => "Josefin Slab",
                                                            "Judson" => "Judson",
                                                            "Julee" => "Julee",
                                                            "Junge" => "Junge",
                                                            "Jura" => "Jura",
                                                            "Just Another Hand" => "Just Another Hand",
                                                            "Just Me Again Down Here" => "Just Me Again Down Here",
                                                            "Kameron" => "Kameron",
                                                            "Karla" => "Karla",
                                                            "Kaushan Script" => "Kaushan Script",
                                                            "Kelly Slab" => "Kelly Slab",
                                                            "Kenia" => "Kenia",
                                                            "Khmer" => "Khmer",
                                                            "Knewave" => "Knewave",
                                                            "Kotta One" => "Kotta One",
                                                            "Koulen" => "Koulen",
                                                            "Kranky" => "Kranky",
                                                            "Kreon" => "Kreon",
                                                            "Kristi" => "Kristi",
                                                            "Krona One" => "Krona One",
                                                            "La Belle Aurore" => "La Belle Aurore",
                                                            "Lancelot" => "Lancelot",
                                                            "Lato" => "Lato",
                                                            "League Script" => "League Script",
                                                            "Leckerli One" => "Leckerli One",
                                                            "Ledger" => "Ledger",
                                                            "Lekton" => "Lekton",
                                                            "Lemon" => "Lemon",
                                                            "Lilita One" => "Lilita One",
                                                            "Limelight" => "Limelight",
                                                            "Linden Hill" => "Linden Hill",
                                                            "Lobster" => "Lobster",
                                                            "Lobster Two" => "Lobster Two",
                                                            "Londrina Outline" => "Londrina Outline",
                                                            "Londrina Shadow" => "Londrina Shadow",
                                                            "Londrina Sketch" => "Londrina Sketch",
                                                            "Londrina Solid" => "Londrina Solid",
                                                            "Lora" => "Lora",
                                                            "Love Ya Like A Sister" => "Love Ya Like A Sister",
                                                            "Loved by the King" => "Loved by the King",
                                                            "Lovers Quarrel" => "Lovers Quarrel",
                                                            "Luckiest Guy" => "Luckiest Guy",
                                                            "Lusitana" => "Lusitana",
                                                            "Lustria" => "Lustria",
                                                            "Macondo" => "Macondo",
                                                            "Macondo Swash Caps" => "Macondo Swash Caps",
                                                            "Magra" => "Magra",
                                                            "Maiden Orange" => "Maiden Orange",
                                                            "Mako" => "Mako",
                                                            "Marck Script" => "Marck Script",
                                                            "Marko One" => "Marko One",
                                                            "Marmelad" => "Marmelad",
                                                            "Marvel" => "Marvel",
                                                            "Mate" => "Mate",
                                                            "Mate SC" => "Mate SC",
                                                            "Maven Pro" => "Maven Pro",
                                                            "Meddon" => "Meddon",
                                                            "MedievalSharp" => "MedievalSharp",
                                                            "Medula One" => "Medula One",
                                                            "Megrim" => "Megrim",
                                                            "Merienda One" => "Merienda One",
                                                            "Merriweather" => "Merriweather",
                                                            "Metal" => "Metal",
                                                            "Metamorphous" => "Metamorphous",
                                                            "Metrophobic" => "Metrophobic",
                                                            "Michroma" => "Michroma",
                                                            "Miltonian" => "Miltonian",
                                                            "Miltonian Tattoo" => "Miltonian Tattoo",
                                                            "Miniver" => "Miniver",
                                                            "Miss Fajardose" => "Miss Fajardose",
                                                            "Modern Antiqua" => "Modern Antiqua",
                                                            "Molengo" => "Molengo",
                                                            "Monofett" => "Monofett",
                                                            "Monoton" => "Monoton",
                                                            "Monsieur La Doulaise" => "Monsieur La Doulaise",
                                                            "Montaga" => "Montaga",
                                                            "Montez" => "Montez",
                                                            "Montserrat" => "Montserrat",
                                                            "Moul" => "Moul",
                                                            "Moulpali" => "Moulpali",
                                                            "Mountains of Christmas" => "Mountains of Christmas",
                                                            "Mr Bedfort" => "Mr Bedfort",
                                                            "Mr Dafoe" => "Mr Dafoe",
                                                            "Mr De Haviland" => "Mr De Haviland",
                                                            "Mrs Saint Delafield" => "Mrs Saint Delafield",
                                                            "Mrs Sheppards" => "Mrs Sheppards",
                                                            "Muli" => "Muli",
                                                            "Mystery Quest" => "Mystery Quest",
                                                            "Neucha" => "Neucha",
                                                            "Neuton" => "Neuton",
                                                            "News Cycle" => "News Cycle",
                                                            "Niconne" => "Niconne",
                                                            "Nixie One" => "Nixie One",
                                                            "Nobile" => "Nobile",
                                                            "Nokora" => "Nokora",
                                                            "Norican" => "Norican",
                                                            "Nosifer" => "Nosifer",
                                                            "Nothing You Could Do" => "Nothing You Could Do",
                                                            "Noticia Text" => "Noticia Text",
                                                            "Nova Cut" => "Nova Cut",
                                                            "Nova Flat" => "Nova Flat",
                                                            "Nova Mono" => "Nova Mono",
                                                            "Nova Oval" => "Nova Oval",
                                                            "Nova Round" => "Nova Round",
                                                            "Nova Script" => "Nova Script",
                                                            "Nova Slim" => "Nova Slim",
                                                            "Nova Square" => "Nova Square",
                                                            "Numans" => "Numans",
                                                            "Nunito" => "Nunito",
                                                            "Odor Mean Chey" => "Odor Mean Chey",
                                                            "Old Standard TT" => "Old Standard TT",
                                                            "Oldenburg" => "Oldenburg",
                                                            "Oleo Script" => "Oleo Script",
                                                            "Open Sans" => "Open Sans",
                                                            "Open Sans Condensed" => "Open Sans Condensed",
                                                            "Orbitron" => "Orbitron",
                                                            "Original Surfer" => "Original Surfer",
                                                            "Oswald" => "Oswald",
                                                            "Over the Rainbow" => "Over the Rainbow",
                                                            "Overlock" => "Overlock",
                                                            "Overlock SC" => "Overlock SC",
                                                            "Ovo" => "Ovo",
                                                            "Oxygen" => "Oxygen",
                                                            "PT Mono" => "PT Mono",
                                                            "PT Sans" => "PT Sans",
                                                            "PT Sans Caption" => "PT Sans Caption",
                                                            "PT Sans Narrow" => "PT Sans Narrow",
                                                            "PT Serif" => "PT Serif",
                                                            "PT Serif Caption" => "PT Serif Caption",
                                                            "Pacifico" => "Pacifico",
                                                            "Parisienne" => "Parisienne",
                                                            "Passero One" => "Passero One",
                                                            "Passion One" => "Passion One",
                                                            "Patrick Hand" => "Patrick Hand",
                                                            "Patua One" => "Patua One",
                                                            "Paytone One" => "Paytone One",
                                                            "Permanent Marker" => "Permanent Marker",
                                                            "Petrona" => "Petrona",
                                                            "Philosopher" => "Philosopher",
                                                            "Piedra" => "Piedra",
                                                            "Pinyon Script" => "Pinyon Script",
                                                            "Plaster" => "Plaster",
                                                            "Play" => "Play",
                                                            "Playball" => "Playball",
                                                            "Playfair Display" => "Playfair Display",
                                                            "Podkova" => "Podkova",
                                                            "Poiret One" => "Poiret One",
                                                            "Poller One" => "Poller One",
                                                            "Poly" => "Poly",
                                                            "Pompiere" => "Pompiere",
                                                            "Pontano Sans" => "Pontano Sans",
                                                            "Port Lligat Sans" => "Port Lligat Sans",
                                                            "Port Lligat Slab" => "Port Lligat Slab",
                                                            "Prata" => "Prata",
                                                            "Preahvihear" => "Preahvihear",
                                                            "Press Start 2P" => "Press Start 2P",
                                                            "Princess Sofia" => "Princess Sofia",
                                                            "Prociono" => "Prociono",
                                                            "Prosto One" => "Prosto One",
                                                            "Puritan" => "Puritan",
                                                            "Quantico" => "Quantico",
                                                            "Quattrocento" => "Quattrocento",
                                                            "Quattrocento Sans" => "Quattrocento Sans",
                                                            "Questrial" => "Questrial",
                                                            "Quicksand" => "Quicksand",
                                                            "Qwigley" => "Qwigley",
                                                            "Radley" => "Radley",
                                                            "Raleway" => "Raleway",
                                                            "Rammetto One" => "Rammetto One",
                                                            "Rancho" => "Rancho",
                                                            "Rationale" => "Rationale",
                                                            "Redressed" => "Redressed",
                                                            "Reenie Beanie" => "Reenie Beanie",
                                                            "Revalia" => "Revalia",
                                                            "Ribeye" => "Ribeye",
                                                            "Ribeye Marrow" => "Ribeye Marrow",
                                                            "Righteous" => "Righteous",
                                                            "Rochester" => "Rochester",
                                                            "Rock Salt" => "Rock Salt",
                                                            "Rokkitt" => "Rokkitt",
                                                            "Ropa Sans" => "Ropa Sans",
                                                            "Rosario" => "Rosario",
                                                            "Rosarivo" => "Rosarivo",
                                                            "Rouge Script" => "Rouge Script",
                                                            "Ruda" => "Ruda",
                                                            "Ruge Boogie" => "Ruge Boogie",
                                                            "Ruluko" => "Ruluko",
                                                            "Ruslan Display" => "Ruslan Display",
                                                            "Russo One" => "Russo One",
                                                            "Ruthie" => "Ruthie",
                                                            "Sail" => "Sail",
                                                            "Salsa" => "Salsa",
                                                            "Sancreek" => "Sancreek",
                                                            "Sansita One" => "Sansita One",
                                                            "Sarina" => "Sarina",
                                                            "Satisfy" => "Satisfy",
                                                            "Schoolbell" => "Schoolbell",
                                                            "Seaweed Script" => "Seaweed Script",
                                                            "Sevillana" => "Sevillana",
                                                            "Shadows Into Light" => "Shadows Into Light",
                                                            "Shadows Into Light Two" => "Shadows Into Light Two",
                                                            "Shanti" => "Shanti",
                                                            "Share" => "Share",
                                                            "Shojumaru" => "Shojumaru",
                                                            "Short Stack" => "Short Stack",
                                                            "Siemreap" => "Siemreap",
                                                            "Sigmar One" => "Sigmar One",
                                                            "Signika" => "Signika",
                                                            "Signika Negative" => "Signika Negative",
                                                            "Simonetta" => "Simonetta",
                                                            "Sirin Stencil" => "Sirin Stencil",
                                                            "Six Caps" => "Six Caps",
                                                            "Slackey" => "Slackey",
                                                            "Smokum" => "Smokum",
                                                            "Smythe" => "Smythe",
                                                            "Sniglet" => "Sniglet",
                                                            "Snippet" => "Snippet",
                                                            "Sofia" => "Sofia",
                                                            "Sonsie One" => "Sonsie One",
                                                            "Sorts Mill Goudy" => "Sorts Mill Goudy",
                                                            "Special Elite" => "Special Elite",
                                                            "Spicy Rice" => "Spicy Rice",
                                                            "Spinnaker" => "Spinnaker",
                                                            "Spirax" => "Spirax",
                                                            "Squada One" => "Squada One",
                                                            "Stardos Stencil" => "Stardos Stencil",
                                                            "Stint Ultra Condensed" => "Stint Ultra Condensed",
                                                            "Stint Ultra Expanded" => "Stint Ultra Expanded",
                                                            "Stoke" => "Stoke",
                                                            "Sue Ellen Francisco" => "Sue Ellen Francisco",
                                                            "Sunshiney" => "Sunshiney",
                                                            "Supermercado One" => "Supermercado One",
                                                            "Suwannaphum" => "Suwannaphum",
                                                            "Swanky and Moo Moo" => "Swanky and Moo Moo",
                                                            "Syncopate" => "Syncopate",
                                                            "Tangerine" => "Tangerine",
                                                            "Taprom" => "Taprom",
                                                            "Telex" => "Telex",
                                                            "Tenor Sans" => "Tenor Sans",
                                                            "The Girl Next Door" => "The Girl Next Door",
                                                            "Tienne" => "Tienne",
                                                            "Tinos" => "Tinos",
                                                            "Titan One" => "Titan One",
                                                            "Trade Winds" => "Trade Winds",
                                                            "Trocchi" => "Trocchi",
                                                            "Trochut" => "Trochut",
                                                            "Trykker" => "Trykker",
                                                            "Tulpen One" => "Tulpen One",
                                                            "Ubuntu" => "Ubuntu",
                                                            "Ubuntu Condensed" => "Ubuntu Condensed",
                                                            "Ubuntu Mono" => "Ubuntu Mono",
                                                            "Ultra" => "Ultra",
                                                            "Uncial Antiqua" => "Uncial Antiqua",
                                                            "UnifrakturCook" => "UnifrakturCook",
                                                            "UnifrakturMaguntia" => "UnifrakturMaguntia",
                                                            "Unkempt" => "Unkempt",
                                                            "Unlock" => "Unlock",
                                                            "Unna" => "Unna",
                                                            "VT323" => "VT323",
                                                            "Varela" => "Varela",
                                                            "Varela Round" => "Varela Round",
                                                            "Vast Shadow" => "Vast Shadow",
                                                            "Vibur" => "Vibur",
                                                            "Vidaloka" => "Vidaloka",
                                                            "Viga" => "Viga",
                                                            "Voces" => "Voces",
                                                            "Volkhov" => "Volkhov",
                                                            "Vollkorn" => "Vollkorn",
                                                            "Voltaire" => "Voltaire",
                                                            "Waiting for the Sunrise" => "Waiting for the Sunrise",
                                                            "Wallpoet" => "Wallpoet",
                                                            "Walter Turncoat" => "Walter Turncoat",
                                                            "Wellfleet" => "Wellfleet",
                                                            "Wire One" => "Wire One",
                                                            "Yanone Kaffeesatz" => "Yanone Kaffeesatz",
                                                            "Yellowtail" => "Yellowtail",
                                                            "Yeseva One" => "Yeseva One",
                                                            "Yesteryear" => "Yesteryear",
                                                            "Zeyada" => "Zeyada",
                                                    );

    $font_select='';
    foreach($google_fonts_array as $key=>$value){
        $font_select.='<option value="'.$key.'">'.$value.'</option>';
    }


    $header_array   =   array(
                            'none',
                            'image',
                            'theme slider',
                            'revolution slider',
                            'google map'
                            );
    
    $header_type    =   get_option('wp_estate_header_type','');
    $header_select  =   '';
    
    foreach($header_array as $key=>$value){
       $header_select.='<option value="'.$key.'" ';
       if($key==$header_type){
           $header_select.=' selected="selected" ';
       }
       $header_select.='>'.$value.'</option>'; 
    }


    $global_revolution_slider   =  get_option('wp_estate_global_revolution_slider','');
    $global_header  =   get_option('wp_estate_global_header','');

    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Appearance','wpestate').'</h1>';
    print '<table class="form-table">     
         
        <tr valign="top">
            <th scope="row"><label for="wide_status">'.__('Wide or Boxed?','wpestate').' </label></th>
               <td> <select id="wide_status" name="wide_status">
                    '.$wide_status_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_top_bar_user_menu">'.__('Show top bar widget menu ?','wpestate').' </label></th>
               <td> <select id="show_top_bar_user_menu" name="show_top_bar_user_menu">
                    '.$show_top_bar_user_menu_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="show_top_bar_user_login">'.__('Show user login menu in header ?','wpestate').' </label></th>
               <td> <select id="show_top_bar_user_login" name="show_top_bar_user_login">
                    '.$show_top_bar_user_login_symbol.'
		 </select>
            </td>
        </tr>


        <tr valign="top">
            <th scope="row"><label for="header_type">'.__('Header Type?','wpestate').' </label></th>
               <td> <select id="header_type" name="header_type">
                    '.$header_select.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="global_revolution_slider">'.__('Global Revolution Slider','wpestate').' </label></th>
             <td> 	
               <input type="text" id="global_revolution_slider" name="global_revolution_slider" value="'.$global_revolution_slider.'">   
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="global_header">'.__('Global Header Static Image','wpestate').' </label></th>
             <td> 	
                <input id="global_header" type="text" size="36" name="global_header" value="'.$global_header.'" />
		<input id="global_header_button" type="button"  class="upload_button button" value="'.__('Upload Header Image','wpestate').'" />
            </td>
        </tr>

     


<tr valign="top">
            <th scope="row"><label for="prop_no">'.__('Properties List - Properties number per page','wpestate').'</label></th>
            <td>
                <input type="text" id="prop_no" name="prop_no" value="'.$prop_no.'">   
            </td>
        </tr> 
      
      
        
        <tr valign="top">
            <th scope="row"><label for="show_empty_city">'.__('Show Cities and Areas with 0 properties in advanced search?','wpestate').' </label></th>
               <td> <select id="show_empty_city" name="show_empty_city">
                    '.$show_empty_city_status_symbol.'
		 </select>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="blog_sidebar">'.__('Blog Category/Archive Sidebar Position','wpestate').'</label></th>
            <td><select id="blog_sidebar" name="blog_sidebar">
                    '.$blog_sidebar_select.'
                </select>
            </td>
        </tr> 
              
        <tr valign="top">
            <th scope="row"><label for="blog_sidebar_name">'.__('Blog Category/Archive Sidebar','wpestate').'</label></th>
            <td><select id="blog_sidebar_name" name="blog_sidebar_name">
                    '.$blog_sidebar_name_select.'
                 </select></td>
         </tr>
        
         <tr valign="top">
            <th scope="row"><label for="blog_unit">'.__('Blog Category/Archive List type','wpestate').'</label></th>
            <td><select id="blog_unit" name="blog_unit">
                    '.$blog_unit_select.'
                 </select></td>
         </tr>
        
        <tr valign="top">
            <th scope="row"><label for="general_font">'.__('Main Font','wpestate').'</label></th>
            <td><select id="general_font" name="general_font">
                    '.$general_font_select.'
                    <option value="">- original font -</option>
                    '.$font_select.'                   
		</select>   </td>
         </tr> 
    
       
       
         
         
         <tr valign="top">
            <th scope="row"><label for="copyright_message">'.__('Copyright Message','wpestate').'</label></th>
            <td><textarea cols="57" rows="2" id="copyright_message" name="copyright_message">'.$copyright_message.'</textarea></td>
        </tr>
        
         
        
      
        
         <tr valign="top">
            <th scope="row"><label for="zillow_api_key">'.__('Zillow Api Key','wpestate').'</label></th>
            <td>  <input id="zillow_api_key" type="text" size="36" name="zillow_api_key" value="'.$zillow_api_key.'" /></td>
        </tr>
        
        
        
       
        
      
        
    </table>
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
    </p>';
    print '</div>';
}
endif; // end   wpestate_theme_admin_apperance  




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Design
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_design') ):

function wpestate_theme_admin_design(){ 
    $main_color                     =  esc_html ( get_option('wp_estate_main_color','') );
    $background_color               =  esc_html ( get_option('wp_estate_background_color','') );
    $content_back_color             =  esc_html ( get_option('wp_estate_content_back_color','') );
    $header_color                   =  esc_html ( get_option('wp_estate_header_color','') );
  
    $breadcrumbs_font_color         =  esc_html ( get_option('wp_estate_breadcrumbs_font_color','') );
    $font_color                     =  esc_html ( get_option('wp_estate_font_color','') );
    $link_color                     =  esc_html ( get_option('wp_estate_link_color','') );
    $headings_color                 =  esc_html ( get_option('wp_estate_headings_color','') );
  
    $footer_back_color              =  esc_html ( get_option('wp_estate_footer_back_color','') );
    $footer_font_color              =  esc_html ( get_option('wp_estate_footer_font_color','') );
    $footer_copy_color              =  esc_html ( get_option('wp_estate_footer_copy_color','') );
    $sidebar_widget_color           =  esc_html ( get_option('wp_estate_sidebar_widget_color','') );
    $sidebar_heading_color          =  esc_html ( get_option('wp_estate_sidebar_heading_color','') );
    $sidebar_heading_boxed_color    =  esc_html ( get_option('wp_estate_sidebar_heading_boxed_color','') );
    $menu_font_color                =  esc_html ( get_option('wp_estate_menu_font_color','') );
    $menu_hover_back_color          =  esc_html ( get_option('wp_estate_menu_hover_back_color','') );
    $menu_hover_font_color          =  esc_html ( get_option('wp_estate_menu_hover_font_color','') );
    $agent_color                    =  esc_html ( get_option('wp_estate_agent_color','') );
    $sidebar2_font_color            =  esc_html ( get_option('wp_estate_sidebar2_font_color','') );
    $top_bar_back                   =  esc_html ( get_option('wp_estate_top_bar_back','') );
    $top_bar_font                   =  esc_html ( get_option('wp_estate_top_bar_font','') );
    $adv_search_back_color          =  esc_html ( get_option('wp_estate_adv_search_back_color ','') );
    $adv_search_font_color          =  esc_html ( get_option('wp_estate_adv_search_font_color','') );  
    $box_content_back_color         =  esc_html ( get_option('wp_estate_box_content_back_color','') );
    $box_content_border_color       =  esc_html ( get_option('wp_estate_box_content_border_color','') );
    
    $custom_css                     =  esc_html ( stripslashes( get_option('wp_estate_custom_css','') ) );
    
    $color_scheme_select ='';
    $color_scheme= esc_html ( get_option('wp_estate_color_scheme','') );
    $color_scheme_array=array('no','yes');

    foreach($color_scheme_array as $value){
            $color_scheme_select.='<option value="'.$value.'"';
            if ($color_scheme==$value){
                $color_scheme_select.='selected="selected"';
            }
            $color_scheme_select.='>'.$value.'</option>';
    }

    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Design','wpestate').'</h1>';
    print '<table class="form-table desgintable">     
         <tr valign="top">
            <th scope="row"><label for="color_scheme">'.__('Use Custom Colors ?','wpestate').'</label></th>
            <td><select id="color_scheme" name="color_scheme">
                   '.$color_scheme_select.'
                </select>   
            </td>
         </tr> 
         
        <tr valign="top">
            <th scope="row"><label for="main_color">'.__('Main Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="main_color" maxlength="7" class="inptxt " value="'.$main_color.'"/>
            	<div id="main_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$main_color.';"  ></div></div>
            </td>
        </tr> 

         <tr valign="top">
            <th scope="row"><label for="background_color">'.__('Background Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="background_color" maxlength="7" class="inptxt " value="'.$background_color.'"/>
            	<div id="background_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$background_color.';"  ></div></div>
            </td>
        </tr> 
   
         
        <tr valign="top">
            <th scope="row"><label for="content_back_color">'.__('Content Background Color','wpestate').'</label></th>
            <td>
                <input type="text" name="content_back_color" value="'.$content_back_color.'" maxlength="7" class="inptxt" />
            	<div id="content_back_color" class="colorpickerHolder" ><div class="sqcolor"  style="background-color:#'.$content_back_color.';" ></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="header_color">'.__('Header Background Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="header_color" value="'.$header_color.'" maxlength="7" class="inptxt" />
            	<div id="header_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$header_color.';" ></div></div>
            </td>
        </tr> 
       
     
        <tr valign="top">
            <th scope="row"><label for="breadcrumbs_font_color">'.__('Breadcrumbs, Meta and Second Line Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="breadcrumbs_font_color" value="'.$breadcrumbs_font_color.'" maxlength="7" class="inptxt" />
            	<div id="breadcrumbs_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$breadcrumbs_font_color.';" ></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="font_color">'.__('Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="font_color" value="'.$font_color.'" maxlength="7" class="inptxt" />
            	<div id="font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$font_color.';" ></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="link_color">'.__('Link Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="link_color" value="'.$link_color.'" maxlength="7" class="inptxt" />
            	<div id="link_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$link_color.';" ></div></div>
            </td>
        </tr> 
        
        
        <tr valign="top">
            <th scope="row"><label for="headings_color">'.__('Headings Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="headings_color" value="'.$headings_color.'" maxlength="7" class="inptxt" />
            	<div id="headings_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$headings_color.';" ></div></div>
            </td>
        </tr>
        
     
        <tr valign="top">
            <th scope="row"><label for="footer_back_color">'.__('Footer Background Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="footer_back_color" value="'.$footer_back_color.'" maxlength="7" class="inptxt" />
            	<div id="footer_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_back_color.';" ></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="footer_font_color">'.__('Footer Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="footer_font_color" value="'.$footer_font_color.'" maxlength="7" class="inptxt" />
            	<div id="footer_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_font_color.';" ></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="footer_copy_color">'.__('Footer Copyright Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="footer_copy_color" value="'.$footer_copy_color.'" maxlength="7" class="inptxt" />
            	<div id="footer_copy_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$footer_copy_color.';" ></div></div>
            </td>
        </tr> 
          
          
        <tr valign="top">
            <th scope="row"><label for="sidebar_widget_color">'.__('Sidebar Widget Background Color( for "boxed" widgets)','wpestate').'</label></th>
            <td>
	        <input type="text" name="sidebar_widget_color" value="'.$sidebar_widget_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar_widget_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$sidebar_widget_color.';" ></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="sidebar_heading_boxed_color">'.__('Sidebar Heading Color (boxed widgets)','wpestate').'</label></th>
            <td>
	        <input type="text" name="sidebar_heading_boxed_color" value="'.$sidebar_heading_boxed_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar_heading_boxed_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar_heading_boxed_color.';"></div></div>
            </td>
        </tr>
          
        <tr valign="top">
            <th scope="row"><label for="sidebar_heading_color">'.__('Sidebar Heading Color ','wpestate').'</label></th>
            <td>
	        <input type="text" name="sidebar_heading_color" value="'.$sidebar_heading_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar_heading_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar_heading_color.';"></div></div>
            </td>
        </tr>
          
        <tr valign="top">
            <th scope="row"><label for="sidebar2_font_color">'.__('Sidebar Font color','wpestate').'</label></th>
            <td>
	        <input type="text" name="sidebar2_font_color" value="'.$sidebar2_font_color.'" maxlength="7" class="inptxt" />
            	<div id="sidebar2_font_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$sidebar2_font_color.';"></div></div>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="header_color">'.__('Header Background Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="header_color" value="'.$header_color.'" maxlength="7" class="inptxt" />
            	<div id="header_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$header_color.';" ></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="menu_font_color">'.__('Top Menu Font Color','wpestate').'</label></th>
            <td>
	        <input type="text" name="menu_font_color" value="'.$menu_font_color.'"  maxlength="7" class="inptxt" />
            	<div id="menu_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_font_color.';" ></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="menu_hover_back_color">'.__('Top Menu hover back color','wpestate').'</label></th>
            <td>
	        <input type="text" name="menu_hover_back_color" value="'.$menu_hover_back_color.'"  maxlength="7" class="inptxt" />
           	<div id="menu_hover_back_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_back_color.';"></div></div>
            </td>
        </tr>
          
        <tr valign="top">
            <th scope="row"><label for="menu_hover_font_color">'.__('Top Menu hover font color','wpestate').'</label></th>
            <td>
	        <input type="text" name="menu_hover_font_color" value="'.$menu_hover_font_color.'" maxlength="7" class="inptxt" />
            	<div id="menu_hover_font_color" class="colorpickerHolder" ><div class="sqcolor" style="background-color:#'.$menu_hover_font_color.';" ></div></div>
            </td>
        </tr> 
 
        <tr valign="top">
            <th scope="row"><label for="top_bar_back">'.__('Top Bar Background Color (Header Widget Menu)','wpestate').'</label></th>
            <td>
	         <input type="text" name="top_bar_back" value="'.$top_bar_back.'" maxlength="7" class="inptxt" />
            	<div id="top_bar_back" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$top_bar_back.';"></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="top_bar_font">'.__('Top Bar Font Color (Header Widget Menu)','wpestate').'</label></th>
            <td>
	         <input type="text" name="top_bar_font" value="'.$top_bar_font.'" maxlength="7" class="inptxt" />
            	<div id="top_bar_font" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$top_bar_font.';"></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="adv_search_back_color">'.__('Map Advanced Search Button Background Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="adv_search_back_color" value="'.$adv_search_back_color.'" maxlength="7" class="inptxt" />
            	<div id="adv_search_back_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$adv_search_back_color.';"></div></div>
            </td>
        </tr> 
          
        <tr valign="top">
            <th scope="row"><label for="adv_search_font_color">'.__('Advanced Search Font Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="adv_search_font_color" value="'.$adv_search_font_color.'" maxlength="7" class="inptxt" />
            	<div id="adv_search_font_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$adv_search_font_color.';"></div></div>
            </td>
        </tr> 
        
        <tr valign="top">
            <th scope="row"><label for="box_content_back_color">'.__('Boxed Content Background Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="box_content_back_color" value="'.$box_content_back_color.'" maxlength="7" class="inptxt" />
            	<div id="box_content_back_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$box_content_back_color.';"></div></div>
            </td>
        </tr>
        
        <tr valign="top">
            <th scope="row"><label for="box_content_border_color">'.__('Border Color','wpestate').'</label></th>
            <td>
	         <input type="text" name="box_content_border_color" value="'.$box_content_border_color.'" maxlength="7" class="inptxt" />
            	<div id="box_content_border_color" class="colorpickerHolder"><div class="sqcolor" style="background-color:#'.$box_content_border_color.';"></div></div>
            </td>
        </tr>
         
        <tr valign="top">
            <th scope="row"><label for="custom_css">'.__('Custom Css','wpestate').'</label></th>
            <td><textarea cols="57" rows="5" name="custom_css" id="custom_css">'.$custom_css.'</textarea></td>
        </tr>
        
 </table>    
    <p class="submit">
        <input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes','wpestate').'" />
    </p>';
    print '</div>';
}
endif; // end   wpestate_theme_admin_design  



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///  help and custom
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_theme_admin_help') ):
function wpestate_theme_admin_help(){
    print '<div class="wpestate-tab-container">';
    print '<h1 class="wpestate-tabh1">'.__('Help','wpestate').'</h1>';
    print '<table class="form-table">  
 
         <tr valign="top">
            <td> '.__('For help please go here <a href="http://help.wpresidence.net">help.wpresidence.org</a>. For Theme Support and Customizations please email at annapx0909@gmail.com.','wpestate').'
            </td>             
        </tr>
        
     
         
        <tr valign="top">
            <td>  '.__('Subscribe to our mailing list in order to receive news about new features and theme upgrades. <a href="http://eepurl.com/CP5U5">Subscribe Here!</a>','wpestate').'
            </td>             
        </tr>
        </table>
         <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary"  value="'.__('Save Changes','wpestate').'" />
        </p>
      ';
    print '</div>';
}
endif; // end   wpestate_theme_admin_help  



if( !function_exists('wpestate_general_country_list') ):
    function wpestate_general_country_list($selected){
        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
        $country_select='<select id="general_country" style="width: 200px;" name="general_country">';

        foreach($countries as $country){
            $country_select.='<option value="'.$country.'"';  
            if($selected==$country){
                $country_select.='selected="selected"';
            }
            $country_select.='>'.$country.'</option>';
        }

        $country_select.='</select>';
        return $country_select;
    }
endif; // end   wpestate_general_country_list  


function wpestate_sorting_function($a, $b) {
    return $a[3] - $b[3];
};

?>