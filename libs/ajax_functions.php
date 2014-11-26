<?php
add_action('wp_logout','wpestate_go_home');
function wpestate_go_home(){
    wp_redirect( home_url() );
    exit();
}



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Register function
////////////////////////////////////////////////////////////////////////////////

add_action( 'wp_ajax_nopriv_wpestate_update_menu_bar', 'wpestate_update_menu_bar' );  
add_action( 'wp_ajax_wpestate_update_menu_bar', 'wpestate_update_menu_bar' );

if( !function_exists('wpestate_update_menu_bar') ):
    function wpestate_update_menu_bar(){

        $user_id= intval ( $_POST['newuser'] );
  
        if ($user_id!=0 && $user_id!=''){
            
         $add_link               =   get_dasboard_add_listing();
         $dash_profile           =   get_dashboard_profile_link();
         $dash_favorite          =   get_dashboard_favorites();
         $dash_link              =   get_dashboard_link();
         
            $menu='
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print $dash_profile;?>"  class="active_profile"><i class="fa fa-cog"></i>'.__('My Profile','wpestate').'</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print $dash_link;?>"     class="active_dash"><i class="fa fa-map-marker"></i>'.__('My Properties List','wpestate').'</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print $add_link;?>"      class="active_add"><i class="fa fa-plus"></i>'.__('Add New Property','wpestate').'</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php print $dash_favorite;?>" class="active_fav"><i class="fa fa-heart"></i>'.__('Favorites','wpestate').'</a></li>
            <li role="presentation" class="divider"></li>
            <li role="presentation"><a href="'. wp_logout_url().'" title="Logout" class="menulogout"><i class="fa fa-power-off"></i>'.__('Log Out','wpestate').'</a></li>
         
            ';
            $user_small_picture_id      =   get_the_author_meta( 'small_custom_picture' , $user_id,true  );
            if( $user_small_picture_id == '' ){
                $user_small_picture=get_template_directory_uri().'/img/default-user.png';
            }else{
                $user_small_picture=wp_get_attachment_image_src($user_small_picture_id,'user_thumb');

            }
            
              echo json_encode(array('picture'=>$user_small_picture[0], 'menu'=>$menu));    
        }
        die();
    }
endif;

////////////////////////////////////////////////////////////////////////////////
/// New user notification
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_wp_new_user_notification') ):

function wpestate_wp_new_user_notification( $user_id, $plaintext_pass = '' ) {

    $user = new WP_User( $user_id );

    $user_login = stripslashes( $user->user_login );
    $user_email = stripslashes( $user->user_email );

    $message  = sprintf( __('New user registration on %s:','wpestate'), get_option('blogname') ) . "\r\n\r\n";
    $message .= sprintf( __('Username: %s','wpestate'), $user_login ) . "\r\n\r\n";
    $message .= sprintf( __('E-mail: %s','wpestate'), $user_email ) . "\r\n";
                $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
                        'Reply-To: noreply@wpresidence.net' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
    @wp_mail(
      get_option('admin_email'),
      sprintf(__('[%s] New User Registration','wpestate'), get_option('blogname') ),
      $message,
                        $headers
    );

    if ( empty( $plaintext_pass ) )
      return;

    $message  = __('Hi there,','wpestate') . "\r\n\r\n";
    $message .= sprintf( __("Welcome to %s! You can login now using the below credentials: ",'wpestate'), get_option('blogname')) . "\r\n\r\n";
    $message .= sprintf( __('Username: %s','wpestate'), $user_login ) . "\r\n";
    $message .= sprintf( __('Password: %s','wpestate'), $plaintext_pass ) . "\r\n\r\n";
    $message .= sprintf( __('If you have any problems, please contact me at %s.','wpestate'), get_option('admin_email') ) . "\r\n\r\n";
    $message .= __('Thank you!','wpestate');
                $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
                        'Reply-To: noreply@wpresidence.net' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
    wp_mail(
      $user_email,
      sprintf( __('[%s] Your username and password','wpestate'), get_option('blogname') ),
      $message,
                        $headers
    );
  }
        
 endif; // end   wpestate_wp_new_user_notification        
        
 
 
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Register function Topbar
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_register_form_topbar', 'wpestate_ajax_register_form_topbar' );  
add_action( 'wp_ajax_wpestate_ajax_register_form_topbar', 'wpestate_ajax_register_form_topbar' );

if( !function_exists('wpestate_ajax_register_form_topbar') ):
   
function wpestate_ajax_register_form_topbar(){
       
        check_ajax_referer( 'register_ajax_nonce_topbar','security-register');
        $allowed_html   =   array();
        $user_email  =   trim( wp_kses( $_POST['user_email_register'] ,$allowed_html) );
        $user_name   =   trim( wp_kses( $_POST['user_login_register'] ,$allowed_html) );
       
        if (preg_match("/^[0-9A-Za-z_]+$/", $user_name) == 0) {
            print __('Invalid username (do not use special characters or spaces)!','wpestate');
            die();
        }
        
        
        if ($user_email=='' || $user_name==''){
          print __('Username and/or Email field is empty!','wpestate');
          exit();
        }
        
        if(filter_var($user_email,FILTER_VALIDATE_EMAIL) === false) {
             print __('The email doesn\'t look right !','wpestate');
            exit();
        }
        
        $domain = substr(strrchr($user_email, "@"), 1);
        if( !checkdnsrr ($domain) ){
            print __('The email\'s domain doesn\'t look right.','wpestate');
            exit();
        }
        
        
        $user_id     =   username_exists( $user_name );
        if ($user_id){
            print __('Username already exists.  Please choose a new one.','wpestate');
            exit();
         }
        
 
         
        if ( !$user_id and email_exists($user_email) == false ) {
            $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
            $user_id         = wp_create_user( $user_name, $random_password, $user_email );
         
             if ( is_wp_error($user_id) ){
                    print_r($user_id);
             }else{
                   print __('An email with the generated password was sent!','wpestate');
                   wpestate_update_profile($user_id);
                   wpestate_wp_new_user_notification( $user_id, $random_password ) ;
                   if('yes' ==  esc_html ( get_option('wp_estate_user_agent','') )){
                        wpestate_register_as_user($user_name,$user_id);
                   }
             }
             
        } else {
           print __('Email already exists.  Please choose a new one.','wpestate');
        }
        die(); 
              
}

endif; // end   ajax_register_form 

 
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Register function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_register_form', 'wpestate_ajax_register_form' );  
add_action( 'wp_ajax_wpestate_ajax_register_form', 'wpestate_ajax_register_form' );

if( !function_exists('wpestate_ajax_register_form') ):
   
function wpestate_ajax_register_form(){
       
        check_ajax_referer( 'register_ajax_nonce','security-register');
        $allowed_html   =   array();
        $user_email  =   trim( wp_kses ($_POST['user_email_register'],$allowed_html ));
        $user_name   =   trim( wp_kses ($_POST['user_login_register'],$allowed_html ));
       
        if (preg_match("/^[0-9A-Za-z_]+$/", $user_name) == 0) {
            print __('Invalid username (do not use special characters or spaces)!','wpestate');
            die();
        }
        
        
        if ($user_email=='' || $user_name==''){
          print __('Username and/or Email field is empty!','wpestate');
          exit();
        }
        
        if(filter_var($user_email,FILTER_VALIDATE_EMAIL) === false) {
             print __('The email doesn\'t look right !','wpestate');
            exit();
        }
        
        $domain = substr(strrchr($user_email, "@"), 1);
        if( !checkdnsrr ($domain) ){
            print __('The email\'s domain doesn\'t look right.','wpestate');
            exit();
        }
        
        
        $user_id     =   username_exists( $user_name );
        if ($user_id){
            print __('Username already exists.  Please choose a new one.','wpestate');
            exit();
         }
        
 
         
        if ( !$user_id and email_exists($user_email) == false ) {
            $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
            $user_id         = wp_create_user( $user_name, $random_password, $user_email );
         
             if ( is_wp_error($user_id) ){
                    print_r($user_id);
             }else{
                   print __('An email with the generated password was sent!','wpestate');
                   wpestate_update_profile($user_id);
                   wpestate_wp_new_user_notification( $user_id, $random_password ) ;
                   if('yes' ==  esc_html ( get_option('wp_estate_user_agent','') )){
                        wpestate_register_as_user($user_name,$user_id);
                   }
             }
             
        } else {
           print __('Email already exists.  Please choose a new one.','wpestate');
        }
        die(); 
              
}

endif; // end   wpestate_ajax_register_form 

////////////////////////////////////////////////////////////////////////////////
/// register as agent
////////////////////////////////////////////////////////////////////////////////

function  wpestate_register_as_user($user_name,$user_id){
    $post = array(
      'post_title'  => $user_name,
      'post_status' => 'publish', 
      'post_type'       => 'estate_agent' ,
    );
    
    $post_id =  wp_insert_post($post );  
    update_post_meta($post_id, 'user_meda_id', $user_id);
    update_user_meta( $user_id, 'user_agent_id', $post_id) ;
 }
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Login function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_ajax_loginx_form_topbar', 'ajax_loginx_form_topbar' );  
add_action( 'wp_ajax_ajax_loginx_form_topbar', 'ajax_loginx_form_topbar' );  

if( !function_exists('ajax_loginx_form_topbar') ):

function ajax_loginx_form_topbar(){
        if ( is_user_logged_in() ) { 
            echo json_encode(array('loggedin'=>true, 'message'=>__('You are already logged in! redirecting...','wpestate')));   
            exit();
        } 
        check_ajax_referer( 'login_ajax_nonce_topbar', 'security' );
        $allowed_html=array();
        $login_user  =  wp_kses ( $_POST['login_user'], $allowed_html) ;
        $login_pwd   =  wp_kses ( $_POST['login_pwd'] , $allowed_html) ;
       
       
        if ($login_user=='' || $login_pwd==''){      
          echo json_encode(array('loggedin'=>false, 'message'=>__('Username and/or Password field is empty!','wpestate')));   
          exit();
        }
        
        $vsessionid = session_id();
        if (empty($vsessionid)) {session_name('PHPSESSID'); session_start();}


        wp_clear_auth_cookie();
        $info                   = array();
        $info['user_login']     = $login_user;
        $info['user_password']  = $login_pwd;
        $info['remember']       = false;
     
        $user_signon            = wp_signon( $info, false );
      
        
         if ( is_wp_error($user_signon) ){
            echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password!','wpestate')));       
        } else {
         
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            global $current_user;
            $current_user = wp_get_current_user();
    
             
          
             
             
             echo json_encode(array('loggedin'=>true,'newuser'=>$user_signon->ID, 'message'=>__('Login successful, redirecting...','wpestate')));
             wpestate_update_old_users($user_signon->ID);
             
        }
        die(); 
              
}
endif; // end   ajax_loginx_form 


////////////////////////////////////////////////////////////////////////////////
/// Ajax  Login function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_ajax_loginx_form', 'ajax_loginx_form' );  
add_action( 'wp_ajax_ajax_loginx_form', 'ajax_loginx_form' );  

if( !function_exists('ajax_loginx_form') ):

function ajax_loginx_form(){
        if ( is_user_logged_in() ) { 
            echo json_encode(array('loggedin'=>true, 'message'=>__('You are already logged in! redirecting...','wpestate')));   
            exit();
        } 
        check_ajax_referer( 'login_ajax_nonce', 'security-login' );
        $allowed_html   =   array();
        $login_user  =  wp_kses ( $_POST['login_user'],$allowed_html ) ;
        $login_pwd   =  wp_kses ( $_POST['login_pwd'], $allowed_html) ;
        $ispop       =  intval ( $_POST['ispop'] );
       
        if ($login_user=='' || $login_pwd==''){      
          echo json_encode(array('loggedin'=>false, 'message'=>__('Username and/or Password field is empty!','wpestate')));   
          exit();
        }
        wp_clear_auth_cookie();
        $info                   = array();
        $info['user_login']     = $login_user;
        $info['user_password']  = $login_pwd;
        $info['remember']       = true;
        $user_signon            = wp_signon( $info, true );
      
   
         if ( is_wp_error($user_signon) ){
             echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password!','wpestate')));       
        } else {
            global $current_user;
            wp_set_current_user($user_signon->ID);
            do_action('set_current_user');
            $current_user = wp_get_current_user();
            
            
            echo json_encode(array('loggedin'=>true,'ispop'=>$ispop,'newuser'=>$user_signon->ID, 'message'=>__('Login successful, redirecting...','wpestate')));
            wpestate_update_old_users($user_signon->ID);
        }
        die(); 
              
}
endif; // end   ajax_loginx_form 



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Forgot Pass function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_forgot_pass', 'wpestate_ajax_forgot_pass' );  
add_action( 'wp_ajax_wpestate_ajax_forgot_pass', 'wpestate_ajax_forgot_pass' );  

if( !function_exists('wpestate_ajax_forgot_pass') ):
   
function wpestate_ajax_forgot_pass(){
    global $wpdb;

    //    check_ajax_referer( 'login_ajax_nonce', 'security-forgot' );
        $allowed_html   =   array();
        $post_id        =   intval( $_POST['postid'] ) ;
        $forgot_email   =   wp_kses( $_POST['forgot_email'],$allowed_html ) ;
 
       
        if ($forgot_email==''){      
          echo _e('Email field is empty!','wpestate');   
          exit();
        }
   
        //We shall SQL escape the input
        $user_input = trim($forgot_email);
 
        if ( strpos($user_input, '@') ) {
                $user_data = get_user_by( 'email', $user_input );
                if(empty($user_data) || isset( $user_data->caps['administrator'] ) ) {
                    echo'Invalid E-mail address!';
                    exit();
                }
                            
        }
        else {
            $user_data = get_user_by( 'login', $user_input );
            if( empty($user_data) || isset( $user_data->caps['administrator'] ) ) {
               echo'Invalid Username!';
               exit();
            }
        }
          $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;

 
        $key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
        if(empty($key)) {
                //generate reset key
                $key = wp_generate_password(20, false);
                $wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
        }
 
        //emailing password change request details to the user
        $headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $message = __('Someone requested that the password be reset for the following account:','wpestate') . "\r\n\r\n";
        $message .= get_option('siteurl') . "\r\n\r\n";
        $message .= sprintf(__('Username: %s','wpestate'), $user_login) . "\r\n\r\n";
        $message .= __('If this was a mistake, just ignore this email and nothing will happen.','wpestate') . "\r\n\r\n";
        $message .= __('To reset your password, visit the following address:','wpestate') . "\r\n\r\n";
        $message .= wpestate_tg_validate_url($post_id) . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login) . "\r\n";
        if ( $message && !wp_mail($user_email, __('Password Reset Request','wpestate'), $message,  $headers) ) {
                echo "<div class='error'>".__('Email failed to send for some unknown reason.','wpestate')."</div>";
                exit();
        }
        else {
            echo '<div>'.__('We have just sent you an email with Password reset instructions.','wpestate').'</div>';
        }
        die(); 
              
}
endif; // end   wpestate_ajax_forgot_pass 


if( !function_exists('wpestate_tg_validate_url') ):

function wpestate_tg_validate_url($post_id) {

  $page_url = esc_url(get_permalink( $post_id));
  $urlget = strpos($page_url, "?");
  if ($urlget === false) {
    $concate = "?";
  } else {
    $concate = "&";
  }
  return $page_url.$concate;
}

endif; // end   wpestate_tg_validate_url 





////////////////////////////////////////////////////////////////////////////////
/// Ajax  Forgot Pass function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_update_profile', 'wpestate_ajax_update_profile' );  
add_action( 'wp_ajax_wpestate_ajax_update_profile', 'wpestate_ajax_update_profile' );  

if( !function_exists('wpestate_ajax_update_profile') ):
   
   function wpestate_ajax_update_profile(){
        global $current_user;
        get_currentuserinfo();
        $userID         =   $current_user->ID;
        check_ajax_referer( 'profile_ajax_nonce', 'security-profile' );
        $allowed_html   =   array();
        $firstname      =   wp_kses( $_POST['firstname'] ,$allowed_html) ;
        $secondname     =   wp_kses( $_POST['secondname'] ,$allowed_html) ;
        $useremail      =   wp_kses( $_POST['useremail'] ,$allowed_html) ;
        $userphone      =   wp_kses( $_POST['userphone'] ,$allowed_html) ;
        $usermobile     =   wp_kses( $_POST['usermobile'] ,$allowed_html) ;
        $userskype      =   wp_kses( $_POST['userskype'] ,$allowed_html) ;
        $usertitle      =   wp_kses( $_POST['usertitle'] ,$allowed_html) ;
        $about_me       =   wp_kses( $_POST['description'],$allowed_html);
        $profile_image_url_small   = wp_kses($_POST['profile_image_url_small'],$allowed_html);
        $profile_image_url= wp_kses($_POST['profile_image_url'],$allowed_html);       
        $userfacebook   =   wp_kses( $_POST['userfacebook'],$allowed_html);
        $usertwitter    =   wp_kses( $_POST['usertwitter'],$allowed_html);
        $userlinkedin   =   wp_kses( $_POST['userlinkedin'],$allowed_html);
        $userpinterest  =   wp_kses( $_POST['userpinterest'],$allowed_html);
        
        update_user_meta( $userID, 'first_name', $firstname ) ;
        update_user_meta( $userID, 'last_name',  $secondname) ;
        update_user_meta( $userID, 'phone' , $userphone) ;
        update_user_meta( $userID, 'skype' , $userskype) ;
        update_user_meta( $userID, 'title', $usertitle) ;
        update_user_meta( $userID, 'custom_picture',$profile_image_url);
        update_user_meta( $userID, 'small_custom_picture',$profile_image_url_small);     
        update_user_meta( $userID, 'mobile' , $usermobile) ;
        update_user_meta( $userID, 'facebook' , $userfacebook) ;
        update_user_meta( $userID, 'twitter' , $usertwitter) ;
        update_user_meta( $userID, 'linkedin' , $userlinkedin) ;
        update_user_meta( $userID, 'pinterest' , $userpinterest) ;
        update_user_meta( $userID, 'description' , $about_me) ;
        
        $agent_id=get_user_meta( $userID, 'user_agent_id',true);
        if('yes' ==  esc_html ( get_option('wp_estate_user_agent','') )){
            wpestate_update_user_agent ($agent_id, $firstname ,$secondname ,$useremail,$userphone,$userskype,$usertitle,$profile_image_url,$usermobile,$about_me,$profile_image_url_small,$userfacebook,$usertwitter,$userlinkedin,$userpinterest) ;
        }
        
        if($current_user->user_email != $useremail ) {
            $user_id=email_exists( $useremail ) ;
            if ( $user_id){
                _e('The email was not saved because it is used by another user.</br>','wpestate');
            } else{
               $args = array(
                      'ID'         => $userID,
                      'user_email' => $useremail
                  ); 
                 wp_update_user( $args );
            } 
        }
        
       
     
      
        _e('Profile updated','wpestate');
        die(); 
   }
endif; // end   wpestate_ajax_update_profile 
   
/////////////////////////////////////////////////// update user   

if( !function_exists('wpestate_update_user_agent') ):
 function    wpestate_update_user_agent ($agent_id, $firstname ,$secondname ,$useremail,$userphone,$userskype,$usertitle,$profile_image_url,$usermobile,$about_me,$profile_image_url_small,$userfacebook,$usertwitter,$userlinkedin,$userpinterest) {
    
     if($firstname!=='' || $secondname!='' ){
          $post = array(
                    'ID'            => $agent_id,
                    'post_title'    => $firstname.' '.$secondname,
                    'post_content'  => $about_me,
            );
           $post_id =  wp_update_post($post );  
      }
    
            
      update_post_meta($agent_id, 'agent_email',   $useremail);
      update_post_meta($agent_id, 'agent_phone',   $userphone);
      update_post_meta($agent_id, 'agent_mobile',  $usermobile);
      update_post_meta($agent_id, 'agent_skype',   $userskype);
      update_post_meta($agent_id, 'agent_position',  $usertitle);
     
      update_post_meta($agent_id, 'agent_facebook',   $userfacebook);
      update_post_meta($agent_id, 'agent_twitter',   $usertwitter);
      update_post_meta($agent_id, 'agent_linkedin',   $userlinkedin);
      update_post_meta($agent_id, 'agent_pinterest',   $userpinterest);
      
   
      set_post_thumbnail( $agent_id, $profile_image_url_small );
  
 }
endif; // end   ajax_update_profile         
 
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Forgot Pass function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_update_pass', 'wpestate_ajax_update_pass' );  
add_action( 'wp_ajax_wpestate_ajax_update_pass', 'wpestate_ajax_update_pass' );  

if( !function_exists('wpestate_ajax_update_pass') ):
   
   function wpestate_ajax_update_pass(){
        global $current_user;
        get_currentuserinfo();
        $allowed_html   =   array();
        $userID         =   $current_user->ID;    
        $oldpass        =   wp_kses( $_POST['oldpass'] ,$allowed_html) ;
        $newpass        =   wp_kses( $_POST['newpass'] ,$allowed_html) ;
        $renewpass      =   wp_kses( $_POST['renewpass'] ,$allowed_html) ;
        
        if($newpass=='' || $renewpass=='' ){
            _e('The new password is blank','wpestate');
            die();
        }
       
        if($newpass != $renewpass){
            _e('Passwords do not match','wpestate');
            die();
        }
        check_ajax_referer( 'pass_ajax_nonce', 'security-pass' );
        
        $user = get_user_by( 'id', $userID );
        if ( $user && wp_check_password( $oldpass, $user->data->user_pass, $user->ID) ){
             wp_set_password( $newpass, $user->ID );
             _e('Password Updated','wpestate');
        }else{
            _e('Old Password is not correct','wpestate');
        }
     
        die();         
   }
endif; // end   wpestate_ajax_update_pass 



   
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Upload   function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_add_fav', 'wpestate_ajax_add_fav' );  
add_action( 'wp_ajax_wpestate_ajax_add_fav', 'wpestate_ajax_add_fav' );  

if( !function_exists('wpestate_ajax_add_fav') ):

  function wpestate_ajax_add_fav(){
          
        global $current_user;
        get_currentuserinfo();
        $userID         =   $current_user->ID;
        $user_option    =   'favorites'.$userID;
        $post_id        =   intval( $_POST['post_id']);
        
        $curent_fav=get_option($user_option);
        //print '= '. implode (  '/' , $curent_fav ) .' = emd';
        
        if($curent_fav==''){ // if empy / first time
            $fav=array();
            $fav[]=$post_id;
            update_option($user_option,$fav);
             echo json_encode(array('added'=>true, 'response'=>__('addded','wpestate')));
             die();
        }else{
            if ( ! in_array ($post_id,$curent_fav) ){
                $curent_fav[]=$post_id;                  
                update_option($user_option,$curent_fav);
                echo json_encode(array('added'=>true, 'response'=>__('addded','wpestate')));
                die();
            }else{
                if(($key = array_search($post_id, $curent_fav)) !== false) {
                    unset($curent_fav[$key]);
                }
                update_option($user_option,$curent_fav);
                 echo json_encode(array('added'=>false, 'response'=>__('removed','wpestate')));
                 die();
                 
                }
            
        }     
        die();
   }
 endif; // end   wpestate_ajax_add_fav 
 
 
 
 
 
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Show login form
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_show_login_form', 'wpestate_ajax_show_login_form' );  
add_action( 'wp_ajax_wpestate_ajax_show_login_form', 'wpestate_ajax_show_login_form' );  
  
if( !function_exists('wpestate_ajax_show_login_form') ):

  function wpestate_ajax_show_login_form(){
          
      print'
            <!-- Modal -->
            <div class="modal fade" id="loginmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header"> 
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">'.__('You must be logged in to add listings to favorites.','wpestate').'</h4>
                  </div>
                  
                   <div class="modal-body">
                
                  
                    <div id="ajax_login_div">
                    
                        <h3>'.__('Login','wpestate').'</h3>
                        <div class="login_form" id="login-div">
                            <div class="loginalert" id="login_message_area" ></div>
        
                            <div class="loginrow">
                                <input type="text" class="form-control" name="log" id="login_user" placeholder="'.__('Username','wpestate').'" size="20" />
                            </div>

                            <div class="loginrow">
                                <input type="password" class="form-control" name="pwd" placeholder="'.__('Password','wpestate').'" id="login_pwd" size="20" />
                            </div>

                            <input type="hidden" name="loginpop" id="loginpop" value="1"> '. wp_nonce_field( 'login_ajax_nonce', 'security-login' ).'   
                          <button id="wp-login-but" class="wpb_button  wpb_btn-info wpb_btn-large vc_button">'.__('Login','wpestate').'</button>
                
                                <div class="login-links" >
                                <a href="#" id="reveal_register">'.__('Don\'t have an account? Register here!','wpestate').'</a>';


                                    $facebook_status    =   esc_html( get_option('wp_estate_facebook_login','') );
                                    $google_status      =   esc_html( get_option('wp_estate_google_login','') );
                                    $yahoo_status       =   esc_html( get_option('wp_estate_yahoo_login','') );


                                    if($facebook_status=='yes'){
                                        print '<div id="facebooklogin" data-social="facebook"></div>';
                                    }
                                    if($google_status=='yes'){
                                        print '<div id="googlelogin" data-social="google"></div>';
                                    }
                                    if($yahoo_status=='yes'){
                                        print '<div id="yahoologin" data-social="yahoo"></div>';
                                    }


                                 print'
                                 </div> <!-- end login links-->     
                      </div><!-- end login div-->   
                            
                       </div><!-- /.ajax_login_div -->
                        <div id="ajax_register_div">
                        <h3>'.__('Register','wpestate').'</h3>
                            '.do_shortcode('[register_form][/register_form]').'
                            <div class="login-links" id="reveal_login"><a href="#">'.__('Already a member? Sign in!','wpestate').'</div> 
                        </div>
     
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->';

      
        die();

   }
   
endif; // end   wpestate_ajax_show_login_form  
   



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_ajax_filter_listings', 'ajax_filter_listings' );  
add_action( 'wp_ajax_ajax_filter_listings', 'ajax_filter_listings' );

if( !function_exists('ajax_filter_listings') ):
    
    function ajax_filter_listings(){

        global $current_user;
        global $currency;
        global $where_currency;
        global $post;
        global $options;
        get_currentuserinfo();
        $userID                   =   $current_user->ID;
        $user_option              =   'favorites'.$userID;
        $curent_fav               =   get_option($user_option);
        $currency                 =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency           =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array               =   '';   
        $city_array               =   '';
        $action_array             =   '';
        $categ_array              =   '';
        $show_compare             =   1;
        $options                  =   wpestate_page_details(intval($_POST['page_id']));
        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $allowed_html   =   array();
        if (isset($_POST['category_values']) && trim($_POST['category_values']) != __('All Types','wpestate') && $_POST['category_values']!='' ){
            $taxcateg_include   =   sanitize_title ( wp_kses(  $_POST['category_values'],$allowed_html  ) );
            $categ_array=array(
                'taxonomy' => 'property_category',
                'field' => 'slug',
                'terms' => $taxcateg_include
            );
        }
         
     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != __('All Actions','wpestate') ) && $_POST['action_values']!='' ){
            $taxaction_include   =   sanitize_title ( wp_kses(  $_POST['action_values'],$allowed_html  ) );   
            $action_array=array(
                'taxonomy' => 'property_action_category',
                'field' => 'slug',
                'terms' => $taxaction_include
            );
        }

   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) and trim($_POST['city']) != __('All Cities','wpestate') && $_POST['city']) {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $taxcity
            );
        }
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( isset( $_POST['area'] ) && trim($_POST['area']) != __('All Areas','wpestate') && $_POST['area'] ) {
            $taxarea[] = sanitize_title ( wp_kses ($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy' => 'property_area',
                'field' => 'slug',
                'terms' => $taxarea
            );
        }

               
        //////////////////////////////////////////////////////////////////////////////////////
        ///// order details
        //////////////////////////////////////////////////////////////////////////////////////
        $order=wp_kses($_POST['order'],$allowed_html);
        switch ($order){
             case 0:
               $meta_order='prop_featured';
               $meta_directions='DESC';
               break;
           case 1:
               $meta_order='property_price';
               $meta_directions='DESC';
               break;
           case 2:
               $meta_order='property_price';
               $meta_directions='ASC';
               break;
           case 3:
               $meta_order='property_size';
               $meta_directions='DESC';
               break;
           case 4:
               $meta_order='property_size';
               $meta_directions='ASC';
               break;
           case 5:
               $meta_order='property_bedrooms';
               $meta_directions='DESC';
               break;
           case 6:
               $meta_order='property_bedrooms';
               $meta_directions='ASC';
               break;
        }
        $paged      =   intval( $_POST['newpage'] );
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
         
        $args = array(
            'post_type'         => 'estate_property',
            'post_status'       => 'publish',
            'paged'             => $paged,
            'posts_per_page'    => $prop_no,
            'orderby'           => 'meta_value_num', 
            'meta_key'          => $meta_order,
            'order'             => $meta_directions,
            'tax_query'         => array(
                                'relation' => 'AND',
                                        $categ_array,
                                        $action_array,
                                        $city_array,
                                        $area_array
                                )
        );
    
    // print_r($args);
      $prop_selection = new WP_Query($args);
      print '<span id="scrollhere"><span>';  
      $counter = 0;
      if( $prop_selection->have_posts() ){
        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
           get_template_part('templates/property_unit');
        endwhile;
        kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax'); 
      }else{
          print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
      }
      wp_reset_query();
      
            
       die();
  }
  
 endif; // end   ajax_filter_listings_search 
 

////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_get_filtering_ajax_result', 'get_filtering_ajax_result' );  
add_action( 'wp_ajax_get_filtering_ajax_result', 'get_filtering_ajax_result' );

if( !function_exists('get_filtering_ajax_result') ):
    
    function get_filtering_ajax_result(){
        global $post;
        global $current_user;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        $show_compare_only          =   'no';
        get_currentuserinfo();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array =   
        $city_array =  
        $action_array               = '';   
        $categ_array                = '';

        $options        =   wpestate_page_details(intval($_POST['postid']));
      
 
        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////
        $allowed_html   =   array();
        if (isset($_POST['category_values']) && trim($_POST['category_values']) != 'all' ){
            $taxcateg_include   =   sanitize_title ( wp_kses(  $_POST['category_values'] ,$allowed_html ) );
            $categ_array=array(
                'taxonomy' => 'property_category',
                'field' => 'slug',
                'terms' => $taxcateg_include
            );
        }

     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != 'all' ) ){
            $taxaction_include   =   sanitize_title ( wp_kses( $_POST['action_values'],$allowed_html ) );   
            $action_array=array(
                 'taxonomy' => 'property_action_category',
                 'field' => 'slug',
                 'terms' => $taxaction_include
            );
        }

   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) and trim($_POST['city']) != 'all' ) {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy' => 'property_city',
                'field' => 'slug',
                'terms' => $taxcity
            );
        }
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

         if ( isset( $_POST['area'] ) && trim($_POST['area']) != 'all') {
            $taxarea[] = sanitize_title ( wp_kses ($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy' => 'property_area',
                'field' => 'slug',
                'terms' => $taxarea
            );
         }
 
               
         
         
         
         
        $meta_query = $rooms = $baths = $price = array();
        if (isset($_POST['advanced_rooms']) && is_numeric($_POST['advanced_rooms'])) {
            $rooms['key'] = 'property_bedrooms';
            $rooms['value'] = floatval ($_POST['advanced_rooms']);
            $meta_query[] = $rooms;
        }

        if (isset($_POST['advanced_bath']) && is_numeric($_POST['advanced_bath'])) {
            $baths['key'] = 'property_bathrooms';
            $baths['value'] = floatval ($_POST['advanced_bath']);
            $meta_query[] = $baths;
        }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// price filters 
    //////////////////////////////////////////////////////////////////////////////////////
    $price_low ='';
    if( isset($_POST['price_low'])){
       $price_low = intval($_POST['price_low']);
    }

    $price_max='';
    if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
        $price_max         = intval($_POST['price_max']);
        $price['key']      = 'property_price';
        $price['value']    = array($price_low, $price_max);
        $price['type']     = 'numeric';
        $price['compare']  = 'BETWEEN';
        $meta_query[]      = $price;
    }
         
         
         
         
//////////////////////////////////////////////////////////////////////////////////////
///// order details
//////////////////////////////////////////////////////////////////////////////////////
     
        
       
        $args = array(
            'post_type'         => 'estate_property',
            'post_status'       => 'publish',
            'posts_per_page'    =>  '-1',
    
            'meta_query'       => $meta_query,
            'tax_query'         => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array
                                    )
        );
    
        //   print_r($args);
        $prop_selection = new WP_Query($args);
        if( $prop_selection->have_posts() ){
            print $prop_selection->post_count;

        }else{
            print '0';
        }     
        die();
  }
  
 endif; // end   get_filtering_ajax_result 
 
 
 
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_filter_listings_search', 'wpestate_ajax_filter_listings_search' );  
add_action( 'wp_ajax_wpestate_ajax_filter_listings_search', 'wpestate_ajax_filter_listings_search' );

if( !function_exists('wpestate_ajax_filter_listings_search') ):
    
  function wpestate_ajax_filter_listings_search(){
      global $post;
      global $current_user;
      global $options;
      global $show_compare_only;
      global $currency;
      global $where_currency;
      $show_compare_only          =   'no';
      get_currentuserinfo();
      $userID                     =   $current_user->ID;
      $user_option                =   'favorites'.$userID;
      $curent_fav                 =   get_option($user_option);
      $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
      $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
      $area_array =   
      $city_array =  
      $action_array               = '';   
      $categ_array                = '';

      $options        =   wpestate_page_details(intval($_POST['postid']));
      $allowed_html   =   array();
 
        //////////////////////////////////////////////////////////////////////////////////////
        ///// category filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['category_values']) && trim($_POST['category_values']) != 'all' ){
            $taxcateg_include   =   sanitize_title ( wp_kses( $_POST['category_values'] ,$allowed_html ) );
            $categ_array=array(
                'taxonomy'  => 'property_category',
                'field'     => 'slug',
                'terms'     => $taxcateg_include
            );
       }
         
     
                
        //////////////////////////////////////////////////////////////////////////////////////
        ///// action  filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if ( ( isset($_POST['action_values']) && trim($_POST['action_values']) != 'all' ) ){
            $taxaction_include   =   sanitize_title ( wp_kses( $_POST['action_values'] ,$allowed_html) );   
            $action_array=array(
                'taxonomy'  => 'property_action_category',
                'field'     => 'slug',
                'terms'     => $taxaction_include
            );
       }

   
      
        //////////////////////////////////////////////////////////////////////////////////////
        ///// city filters 
        //////////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['city']) and trim($_POST['city']) != 'all' ) {
            $taxcity[] = sanitize_title ( wp_kses($_POST['city'],$allowed_html) );
            $city_array = array(
                'taxonomy'  => 'property_city',
                'field'     => 'slug',
                'terms'     => $taxcity
            );
        }
 
    
        //////////////////////////////////////////////////////////////////////////////////////
        ///// area filters 
        //////////////////////////////////////////////////////////////////////////////////////

         if ( isset( $_POST['area'] ) && trim($_POST['area']) != 'all') {           
            $taxarea[] = sanitize_title ( wp_kses ($_POST['area'],$allowed_html) );
            $area_array = array(
                'taxonomy' => 'property_area',
                'field'    => 'slug',
                'terms'    => $taxarea
            );
        }
 

        $meta_query = $rooms = $baths = $price = array();
        if (isset($_POST['advanced_rooms']) && is_numeric($_POST['advanced_rooms'])) {
            $rooms['key']   = 'property_bedrooms';
            $rooms['value'] = floatval ($_POST['advanced_rooms']);
            $meta_query[]   = $rooms;
        }

        if (isset($_POST['advanced_bath']) && is_numeric($_POST['advanced_bath'])) {
            $baths['key']   = 'property_bathrooms';
            $baths['value'] = floatval ($_POST['advanced_bath']);
            $meta_query[]   = $baths;
        }


    //////////////////////////////////////////////////////////////////////////////////////
    ///// price filters 
    //////////////////////////////////////////////////////////////////////////////////////
    $price_low ='';
    if( isset($_POST['price_low'])){
        $price_low = intval($_POST['price_low']);
    }

    $price_max='';
    if( isset($_POST['price_max'])  && is_numeric($_POST['price_max']) ){
        $price_max          = intval($_POST['price_max']);
        $price['key']       = 'property_price';
        $price['value']     = array($price_low, $price_max);
        $price['type']      = 'numeric';
        $price['compare']   = 'BETWEEN';
        $meta_query[]       = $price;
    }
         
         
         
         
//////////////////////////////////////////////////////////////////////////////////////
///// order details
//////////////////////////////////////////////////////////////////////////////////////
     $meta_order='prop_featured';
     $meta_directions='DESC';   
     if(isset($_POST['order'])) {
        $order=  wp_kses( $_POST['order'],$allowed_html );
        switch ($order){
           case 1:
               $meta_order='property_price';
               $meta_directions='DESC';
               break;
           case 2:
               $meta_order='property_price';
               $meta_directions='ASC';
               break;
           case 3:
               $meta_order='property_size';
               $meta_directions='DESC';
               break;
           case 4:
               $meta_order='property_size';
               $meta_directions='ASC';
               break;
           case 5:
               $meta_order='property_bedrooms';
               $meta_directions='DESC';
               break;
           case 6:
               $meta_order='property_bedrooms';
               $meta_directions='ASC';
               break;
        }
    }
        
        $paged      =   intval($_POST['newpage']);
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
        
        
        $args = array(
            'post_type'         => 'estate_property',
            'post_status'       => 'publish',
            'paged'             => $paged,
            'posts_per_page'    => $prop_no,
            'meta_key'          => $meta_order,
            'order'             => $meta_directions,
            'orderby'           => 'meta_value_num',  
           
            'meta_query'       => $meta_query,
            'tax_query'         => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array
                                    )
        );
    
    //  print_r($args);
      $prop_selection = new WP_Query($args);
     
      $counter          =   0;
      $compare_submit   =   get_compare_link();
      print '<span id="scrollhere"><span>';
      
      if( !is_tax() ){
        print '<div class="compare_ajax_wrapper">';
            get_template_part('templates/compare_list'); 
        print'</div>';     
      }
      
   
      if( $prop_selection->have_posts() ){
        while ($prop_selection->have_posts()): $prop_selection->the_post(); 
           get_template_part('templates/property_unit');
        endwhile;
        kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search'); 
      }else{
          print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
      }

            
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 ////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_custom_adv_ajax_filter_listings_search', 'wpestate_custom_adv_ajax_filter_listings_search' );  
add_action( 'wp_ajax_wpestate_custom_adv_ajax_filter_listings_search', 'wpestate_custom_adv_ajax_filter_listings_search' );

if( !function_exists('wpestate_custom_adv_ajax_filter_listings_search') ):
    
    function wpestate_custom_adv_ajax_filter_listings_search(){
        global $post;
        global $current_user;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
      
        get_currentuserinfo();
        $show_compare_only  =   'no';
        $userID             =   $current_user->ID;
        $user_option        =   'favorites'.$userID;
        $curent_fav         =   get_option($user_option);
        $currency           =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency     =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array         =   '';   
        $city_array         =   ''; 
        $action_array       =   '';   
        $categ_array        =   '';
        $meta_query         =   array();
        $options            =   wpestate_page_details(intval($_POST['postid']));
        $adv_search_what    =   get_option('wp_estate_adv_search_what','');
        $adv_search_how     =   get_option('wp_estate_adv_search_how','');
        $adv_search_label   =   get_option('wp_estate_adv_search_label','');                    
        $adv_search_type    =   get_option('wp_estate_adv_search_type','');

        $allowed_html   =   array();
        $new_key=0;
        foreach($adv_search_what as $key=>$term){
         
        $new_key=$key+1;  
        $new_key='val'.$new_key;
        if($term=='none'){

        }
        else if($term=='categories'){ // for property_category taxonomy

            if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                $taxcateg_include   =   array();
                $taxcateg_include[] =   wp_kses($_POST[$new_key],$allowed_html);
                $categ_array    =   array(
                    'taxonomy'  => 'property_category',
                    'field'     => 'slug',
                    'terms'     => $taxcateg_include
                );
            } 
        } /////////// end if categories


          else if($term=='types'){ // for property_action_category taxonomy
             
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxaction_include   =   array();   

                    $taxaction_include[] = wp_kses($_POST[$new_key],$allowed_html);

                    $action_array=array(
                        'taxonomy'  => 'property_action_category',
                        'field'     => 'slug',
                        'terms'     => $taxaction_include
                    );
                 }
          } //////////// end for property_action_category taxonomy


          else if($term=='cities'){ // for property_city taxonomy
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxcity[]  = wp_kses ($_POST[$new_key],$allowed_html);
                    $city_array = array(
                        'taxonomy' => 'property_city',
                        'field' => 'slug',
                        'terms' => $taxcity
                    );
              }
          } //////////// end for property_city taxonomy

          else if($term=='areas'){ // for property_area taxonomy

                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxarea[]  = wp_kses ( $_POST[$new_key],$allowed_html );
                    $area_array = array(
                        'taxonomy' => 'property_area',
                        'field' => 'slug',
                        'terms' => $taxarea
                    );
                }
          } //////////// end for property_area taxonomy


          else{ 

            // $slug=str_replace(' ','_',$term); 
            // $slug_name=str_replace(' ','-',$adv_search_label[$key]);
            $slug_name         =   wpestate_limit45(sanitize_title( $term ));
            $slug_name         =   sanitize_key($slug_name);
            $slug_name_key     =   $slug_name; 
             if( isset($_POST[$new_key]) && $adv_search_label[$key] != $_POST[$new_key] && $_POST[$new_key] != ''){ // if diffrent than the default values
                      $compare=$search_type=''; 
                      $compare_array=array();
                       //$adv_search_how

                      $compare=$adv_search_how[$key];
                      $slug_name_key=$slug_name;
                         $old_values=array(
                                    'property-price',
                                    'property-label',
                                    'property-size',
                                    'property-lot-size',
                                    'property-rooms',
                                    'property-bedrooms',
                                    'property-bathrooms',
                                    'property-bathrooms',
                                    'property-address',
                                    'property-county',
                                    'property-state',
                                    'property-zip',
                                    'property-country',
                                    'property-status',
                                    );
                                
                        if(  in_array($slug_name,$old_values) ){
                            $slug_name_key=  str_replace('-', '_', $slug_name);
                        }
                                
                     
                      if($compare=='equal'){
                         $compare='='; 
                         $search_type='numeric';
                         $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='greater'){
                          $compare='>='; 
                          $search_type='numeric';
                          $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='smaller'){
                          $compare='<='; 
                          $search_type='numeric';
                          $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='like'){
                          $compare='LIKE'; 
                          $search_type='CHAR';
                          $term_value= wp_kses( $_POST[$new_key],$allowed_html );

                      }else if($compare=='date bigger'){
                          $compare='>='; 
                          $search_type='DATE';
                          $term_value= wp_kses( $_POST[$new_key],$allowed_html );

                      }else if($compare=='date smaller'){
                          $compare='<='; 
                          $search_type='DATE';
                          $term_value= wp_kses( $_POST[$new_key],$allowed_html );
                      }

                      $compare_array['key']        = $slug_name_key;
                      $compare_array['value']      = $term_value;
                      $compare_array['type']       = $search_type;
                      $compare_array['compare']    = $compare;
                      $meta_query[]                = $compare_array;

            }// end if diffrent
          }////////////////// end last else
       } ///////////////////////////////////////////// end for each adv search term

      
      
  

        $paged      =   intval($_POST['newpage']);
        $prop_no    =   intval( get_option('wp_estate_prop_no', '') );
       
        
        $args = array(
          'post_type'           => 'estate_property',
          'post_status'         => 'publish',
          'paged'               => $paged,
          'posts_per_page'      => 30,
          'meta_key'            => 'prop_featured',
          'orderby'             => 'meta_value',
          'order'               => 'DESC',
          'meta_query'          => $meta_query,
          'tax_query'           => array(
                                    'relation' => 'AND',
                                    $categ_array,
                                    $action_array,
                                    $city_array,
                                    $area_array
                                 )
        );
    
       // print_r($args);
        $prop_selection     = new WP_Query($args);

        $counter            =   0;
        $compare_submit     =   get_compare_link();
        print '<span id="scrollhere"><span>';

        if( !is_tax() ){
            print '<div class="compare_ajax_wrapper">';
                get_template_part('templates/compare_list'); 
            print'</div>';     
        }
      
   
        if( $prop_selection->have_posts() ){
            while ($prop_selection->have_posts()): $prop_selection->the_post(); 
               get_template_part('templates/property_unit');
            endwhile;
            kriesi_pagination_ajax($prop_selection->max_num_pages, $range =2,$paged,'pagination_ajax_search'); 
        }else{
            print '<span class="no_results">'. __("We didn't find any results","wpestate").'</>';
        }
        die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 ////////////////////////////////////////////////////////////////////////////////
/// Ajax  Filters
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_custom_adv_get_filtering_ajax_result', 'custom_adv_get_filtering_ajax_result' );  
add_action( 'wp_ajax_custom_adv_get_filtering_ajax_result', 'custom_adv_get_filtering_ajax_result' );

if( !function_exists('custom_adv_get_filtering_ajax_result') ):
    
    function custom_adv_get_filtering_ajax_result(){
        global $post;
        global $current_user;
        global $options;
        global $show_compare_only;
        global $currency;
        global $where_currency;
        $show_compare_only          =   'no';
        $allowed_html   =   array();
        get_currentuserinfo();
        $userID                     =   $current_user->ID;
        $user_option                =   'favorites'.$userID;
        $curent_fav                 =   get_option($user_option);
        $currency                   =   esc_html( get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( get_option('wp_estate_where_currency_symbol', '') );
        $area_array =   
        $city_array =  
        $action_array               = '';   
        $categ_array                = '';
        $meta_query             =   array();
        $options        =   wpestate_page_details(intval($_POST['postid']));

        $adv_search_what    = get_option('wp_estate_adv_search_what','');
        $adv_search_how     = get_option('wp_estate_adv_search_how','');
        $adv_search_label   = get_option('wp_estate_adv_search_label','');                    
        $adv_search_type    = get_option('wp_estate_adv_search_type','');

        
        $new_key=0;
        foreach($adv_search_what as $key=>$term){
         
          $new_key=$key+1;  
          $new_key='val'.$new_key;
          if($term=='none'){

           }
           else if($term=='categories'){ // for property_category taxonomy
                
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxcateg_include   =   array();
                    $taxcateg_include[] =   wp_kses ( $_POST[$new_key],$allowed_html );
                    $categ_array    =array(
                        'taxonomy'  => 'property_category',
                        'field'     => 'slug',
                        'terms'     => $taxcateg_include
                    );
                } 
           } /////////// end if categories


          else if($term=='types'){ // for property_action_category taxonomy
             
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxaction_include   =   array();   
                    $taxaction_include[] =  wp_kses($_POST[$new_key],$allowed_html);
                    $action_array=array(
                        'taxonomy'  => 'property_action_category',
                        'field'     => 'slug',
                        'terms'     => $taxaction_include
                    );
                }
          } //////////// end for property_action_category taxonomy


          else if($term=='cities'){ // for property_city taxonomy
                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxcity[] = wp_kses ($_POST[$new_key],$allowed_html);
                    $city_array = array(
                        'taxonomy'  => 'property_city',
                        'field'     => 'slug',
                        'terms'     => $taxcity
                    );
                }
          } //////////// end for property_city taxonomy

          else if($term=='areas'){ // for property_area taxonomy

                if (isset($_POST[$new_key]) && $_POST[$new_key]!='all' && $_POST[$new_key]!=''){
                    $taxarea[]  =wp_kses($_POST[$new_key],$allowed_html);
                    $area_array = array(
                        'taxonomy'  => 'property_area',
                        'field'     => 'slug',
                        'terms'     => $taxarea
                    );
                }
          } //////////// end for property_area taxonomy


          else{ 

             $slug=str_replace(' ','_',$term); 
             $slug_name=str_replace(' ','-',$adv_search_label[$key]);

             if( isset($_POST[$new_key]) && $adv_search_label[$key] != $_POST[$new_key] && $_POST[$new_key] != ''){ // if diffrent than the default values
                      $compare=$search_type=''; 
                      $compare_array=array();
                       //$adv_search_how

                      $compare=$adv_search_how[$key];

                      if($compare=='equal'){
                         $compare='='; 
                         $search_type='numeric';
                         $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='greater'){
                          $compare='>='; 
                          $search_type='numeric';
                          $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='smaller'){
                          $compare='<='; 
                          $search_type='numeric';
                          $term_value= floatval ( $_POST[$new_key] );

                      }else if($compare=='like'){
                          $compare='LIKE'; 
                          $search_type='CHAR';
                          $term_value= wp_kses( $_POST[$new_key],$allowed_html );

                      }else if($compare=='date bigger'){
                          $compare='>='; 
                          $search_type='DATE';
                          $term_value= wp_kses( $_POST[$new_key],$allowed_html );

                      }else if($compare=='date smaller'){
                          $compare='<='; 
                          $search_type='DATE';
                          $term_value= wp_kses( $_POST[$new_key],$allowed_html );
                      }

                      $compare_array['key']        = $slug;
                      $compare_array['value']      = $term_value;
                      $compare_array['type']       = $search_type;
                      $compare_array['compare']    = $compare;
                      $meta_query[]                = $compare_array;

            }// end if diffrent
          }////////////////// end last else
       } ///////////////////////////////////////////// end for each adv search term

      
        
        $args = array(
        'post_type'         => 'estate_property',
        'post_status'       => 'publish',
        'posts_per_page'    =>  '-1',
          'meta_query'       => $meta_query,
          'tax_query'        => array(
                                     'relation' => 'AND',
                                     $categ_array,
                                     $action_array,
                                     $city_array,
                                     $area_array
                                 )
       );
    
    //  print_r($args);
 
      $prop_selection = new WP_Query($args);
      if( $prop_selection->have_posts() ){
          print $prop_selection->post_count;
       
      }else{
          print '0';
      }

            
       die();
  }
  
 endif; // end   ajax_filter_listings 
 
 
 
////////////////////////////////////////////////////////////////////////////////
///wpestate_custom_fields_join
////////////////////////////////////////////////////////////////////////////////
 
if( !function_exists('wpestate_custom_fields_join') ):

function wpestate_custom_fields_join($wp_join)
{ 
    global $wpdb;
    $wp_join .= " LEFT JOIN (
                    SELECT post_id, meta_value as prop_featured
                    FROM $wpdb->postmeta
                    WHERE meta_key =  'prop_featured' ) AS DD
                    ON $wpdb->posts.ID = DD.post_id ";
    return ($wp_join);
}
 
endif; // end   wpestate_custom_fields_join 
 


////////////////////////////////////////////////////////////////////////////////
/// wpestate_filter_query
////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_filter_query') ):


function wpestate_filter_query( $orderby )
{
    $orderby = " DD.prop_featured  DESC ";
    return $orderby;
}
endif; 
// end   wpestate_filter_query 
 
 
 
 

////////////////////////////////////////////////////////////////////////////////
/// Ajax  Google login form
////////////////////////////////////////////////////////////////////////////////
  add_action( 'wp_ajax_nopriv_wpestate_ajax_google_login', 'wpestate_ajax_google_login' );  
  add_action( 'wp_ajax_wpestate_ajax_google_login', 'wpestate_ajax_google_login' );  
  
  
if( !function_exists('wpestate_ajax_google_login') ):
  
    function wpestate_ajax_google_login(){  
     
    require 'resources/openid.php';
    $allowed_html   =   array();
    $dash_profile   =   get_dashboard_profile_link();
    $login_type     =   wp_kses($_POST['login_type'],$allowed_html);
    try {
        $openid = new LightOpenID( wpestate_get_domain_openid() );
        if(!$openid->mode) {
                if($login_type   ==  'google'){
                   $openid->identity   = 'https://www.google.com/accounts/o8/id'; 
                }else if($login_type ==  'yahoo'){
                   $openid->identity   = 'https://me.yahoo.com'; 
                }else if($login_type ==   'aol'){
                   $openid->identity   = 'http://openid.aol.com/'; 
                }
               
                $openid->required = array(
                        'namePerson',
                        'namePerson/first',
                        'namePerson/last',
                        'contact/email',
                );
                $openid->optional   = array('namePerson', 'namePerson/friendly');         
                $openid->returnUrl  = $dash_profile;
                
                print  $openid->authUrl();
                exit();
                    
        }
    } catch(ErrorException $e) {
        echo $e->getMessage();
    }

      
  }
  
  endif; // end   wpestate_ajax_google_login 

  
  
  
  
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Google login form OAUTH
////////////////////////////////////////////////////////////////////////////////
  add_action( 'wp_ajax_nopriv_wpestate_ajax_google_login_oauth', 'wpestate_ajax_google_login_oauth' );  
  add_action( 'wp_ajax_wpestate_ajax_google_login_oauth', 'wpestate_ajax_google_login_oauth' );  

  
if( !function_exists('wpestate_ajax_google_login_oauth') ):
  
    function wpestate_ajax_google_login_oauth(){  
       
        set_include_path( get_include_path() . PATH_SEPARATOR . get_template_directory().'/libs/resources');
        $google_client_id       =   esc_html ( get_option('wp_estate_google_oauth_api','') );
        $google_client_secret   =   esc_html ( get_option('wp_estate_google_oauth_client_secret','') );
        $google_redirect_url    =   get_dashboard_profile_link();
        $google_developer_key   =   esc_html ( get_option('wp_estate_google_api_key','') );
        
        require_once 'src/Google_Client.php';
        require_once 'src/contrib/Google_Oauth2Service.php';
        
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to WpResidence');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey($google_developer_key);
        $gClient->setScopes('email');
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        print $authUrl = $gClient->createAuthUrl();
        die();
    }
  
endif; // end   wpestate_ajax_google_login 

  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
////////////////////////////////////////////////////////////////////////////////
/// Ajax  Google login form
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_facebook_login', 'wpestate_ajax_facebook_login' );  
add_action( 'wp_ajax_wpestate_ajax_facebook_login', 'wpestate_ajax_facebook_login' );  

  
  if( !function_exists('wpestate_ajax_facebook_login') ):

  function wpestate_ajax_facebook_login(){ 
       
    require 'resources/facebook.php';
    $facebook_api               =   esc_html ( get_option('wp_estate_facebook_api','') );
    $facebook_secret            =   esc_html ( get_option('wp_estate_facebook_secret','') );
    $facebook = new Facebook(array(
        'appId'  => $facebook_api,
        'secret' => $facebook_secret,
        'cookie' => true
     ));
    
    $params = array(
        'redirect_uri' => get_dashboard_profile_link(),
        'scope' => 'email',
        );
        print $loginUrl = $facebook->getLoginUrl($params);
        
        
    die();
  }
  
  endif; // end   wpestate_ajax_facebook_login 
  
  
    
 ////////////////////////////////////////////////////////////////////////////////
/// pay via paypal - per listing
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_listing_pay', 'wpestate_ajax_listing_pay' );  
add_action( 'wp_ajax_wpestate_ajax_listing_pay', 'wpestate_ajax_listing_pay' );  

if( !function_exists('wpestate_ajax_listing_pay') ):  

    function wpestate_ajax_listing_pay(){
    
    global $current_user;
    $is_featured    =   intval($_POST['is_featured']);
    $prop_id        =   intval($_POST['propid']);
    $is_upgrade     =   intval($_POST['is_upgrade']);
    
    get_currentuserinfo();
    $userID =   $current_user->ID;
    $post   =   get_post($prop_id); 
     
    if( $post->post_author != $userID){
        exit('get out of my cloud');
    }
    
    $paypal_status                  =   esc_html( get_option('wp_estate_paypal_api','') );
    $host                           =   'https://api.sandbox.paypal.com';  
    $price_submission               =   floatval( get_option('wp_estate_price_submission','') );
    $price_featured_submission      =   floatval( get_option('wp_estate_price_featured_submission','') );
    $submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
    $pay_description                =   __('Listing payment on ','wpestate').get_bloginfo('url');
    
    if( $is_featured==0 ){
        $total_price =  number_format($price_submission, 2, '.','');
    }else{
         $total_price = $price_submission + $price_featured_submission;
         $total_price = number_format($total_price, 2, '.','');
    }
    
    
    if ($is_upgrade==1){
        $total_price        =  number_format($price_featured_submission, 2, '.','');
        $pay_description    =   __('Upgrade to featured listing on ','wpestate').get_bloginfo('url');
    }
    
    
    if($paypal_status=='live'){
        $host='https://api.paypal.com';
    }
    
    $url                =   $host.'/v1/oauth2/token'; 
    $postArgs           =   'grant_type=client_credentials';
    $token              =   wpestate_get_access_token($url,$postArgs);
    $url                =   $host.'/v1/payments/payment';
    $dash_link          =   get_dashboard_link();
    $processor_link     =   get_procesor_link();
      
     
     $payment = array(
                    'intent' => 'sale',
                    "redirect_urls"=>array(
                            "return_url"=>$processor_link,
                            "cancel_url"=>$dash_link
                        ),
                    'payer' => array("payment_method"=>"paypal"),
                );
    
    
    $payment['transactions'][0] = array(
                                        'amount' => array(
                                            'total' => $total_price,
                                            'currency' => $submission_curency_status,
                                            'details' => array(
                                                'subtotal' => $total_price,
                                                'tax' => '0.00',
                                                'shipping' => '0.00'
                                                )
                                            ),
                                        'description' => $pay_description
                                       );
     // prepare individual items
  

    if ($is_upgrade==1){
            $payment['transactions'][0]['item_list']['items'][] = array(
                                            'quantity' => '1',
                                            'name' => __('Upgrade to Featured Listing','wpestate'),
                                            'price' => $total_price,
                                            'currency' => $submission_curency_status,
                                            'sku' => 'Upgrade Featured Listing',
                                            );
    }else{
           if( $is_featured==0 ){
                $payment['transactions'][0]['item_list']['items'][] = array(
                                                     'quantity' => '1',
                                                     'name' => __('Listing Payment','wpestate'),
                                                     'price' => $total_price,
                                                     'currency' => $submission_curency_status,
                                                     'sku' => 'Paid Listing',

                                                    );
              }
              else{
                  $payment['transactions'][0]['item_list']['items'][] = array(
                                                     'quantity' => '1',
                                                     'name' => __('Listing Payment with Featured option','wpestate'),
                                                     'price' => $total_price,
                                                     'currency' => $submission_curency_status,
                                                     'sku' => 'Featured Paid Listing',
                                                     );

              } // end is featured
    } // end is upgrade
     
     
     
    
        $json = json_encode($payment);
        $json_resp = wpestate_make_post_call($url, $json,$token);
        foreach ($json_resp['links'] as $link) {
                if($link['rel'] == 'execute'){
                        $payment_execute_url = $link['href'];
                        $payment_execute_method = $link['method'];
                } else  if($link['rel'] == 'approval_url'){
                                $payment_approval_url = $link['href'];
                                $payment_approval_method = $link['method'];
                        }
        }





        $executor['paypal_execute']     =   $payment_execute_url;
        $executor['paypal_token']       =   $token;
        $executor['listing_id']         =   $prop_id;
        $executor['is_featured']        =   $is_featured;
        $executor['is_upgrade']         =   $is_upgrade;
        $save_data[$current_user->ID]   =   $executor;
        update_option('paypal_transfer',$save_data);

        print $payment_approval_url;
     
        die();
  }
  endif; // end   wpestate_ajax_listing_pay 
  
  
  
////////////////////////////////////////////////////////////////////////////////
/// pay via paypal - per listing
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_resend_for_approval', 'wpestate_ajax_resend_for_approval' );  
add_action( 'wp_ajax_wpestate_ajax_resend_for_approval', 'wpestate_ajax_resend_for_approval' );  

if( !function_exists('wpestate_ajax_resend_for_approval') ):

  function wpestate_ajax_resend_for_approval(){ 
    
    global $current_user;
    $prop_id        =   intval($_POST['propid']);
    
    get_currentuserinfo();
    $userID =   $current_user->ID;
    $post   =   get_post($prop_id); 
     
    if( $post->post_author != $userID){
        exit('get out of my cloud');
    }
    
     $free_list=get_user_meta($userID, 'package_listings',true);
     
     if($free_list>0 ||  $free_list==-1){
            $prop = array(
               'ID'            => $prop_id,
               'post_type'     => 'estate_property',
               'post_status'   => 'pending'
            );
            wp_update_post($prop );
            update_post_meta($prop_id, 'prop_featured', 0); 
            
            if($free_list!=-1){ // if !unlimited
                update_user_meta($userID, 'package_listings',$free_list-1);
            }
            print __('Sent for approval','wpestate');
            $submit_title   =   get_the_title($prop_id);
            $headers        =   'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
            $message        =    __('Hi there,','wpestate') . "\r\n\r\n";
            $message       .=   sprintf( __("A user has re-submited a new property on  %s! You should go check it out.This is the property title: %s",'wpestate'), get_option('blogname'),$submit_title) . "\r\n\r\n";
 
            wp_mail(get_option('admin_email'),
        sprintf(__('[%s] Expired Listing sent for approval','wpestate'), get_option('blogname')),
                    $message,
                    $headers);
     }else{
         print __('no listings available','wpestate');
     }
     die();
     
  
     
   }
  
 endif; // end   wpestate_ajax_resend_for_approval 
 
 
 
 
//////////////////////////////////////////////////////////////////////////////
/// Ajax adv search contact function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_agent_contact_form', 'wpestate_ajax_agent_contact_form' );  
add_action( 'wp_ajax_wpestate_ajax_agent_contact_form', 'wpestate_ajax_agent_contact_form' );  

if( !function_exists('wpestate_ajax_agent_contact_form') ):

function wpestate_ajax_agent_contact_form(){
    
        // check for POST vars
        $hasError = false; 
        $allowed_html   =   array();
        $to_print='';
        if ( !wp_verify_nonce( $_POST['nonce'], 'ajax-property-contact')) {
            exit("No naughty business please");
        }   
       
        
        if ( isset($_POST['name']) ) {
           if( trim($_POST['name']) =='' || trim($_POST['name']) ==__('Nome','wpestate') ){
               echo json_encode(array('sent'=>false, 'response'=>__('Campo Nome está vazio!','wpestate') ));         
               exit(); 
           }else {
               $name = wp_kses( trim($_POST['name']),$allowed_html );
           }          
        } 

        //Check email
        if ( isset($_POST['email']) || trim($_POST['name']) ==__('E-mail','wpestate') ) {
              if( trim($_POST['email']) ==''){
                    echo json_encode(array('sent'=>false, 'response'=>__('Campo E-mail está vazio','wpestate' ) ) );      
                    exit(); 
              } else if( filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) === false) {
                    echo json_encode(array('sent'=>false, 'response'=>__('E-mail inválido!','wpestate') ) ); 
                    exit();
              } else {
                    $email = wp_kses( trim($_POST['email']),$allowed_html );
              }
        }

        
        
        $phone = wp_kses( trim($_POST['phone']),$allowed_html );
        $subject =__('Contact form from ','wpestate') . home_url() ;

        //Check comments 
        if ( isset($_POST['comment']) ) {
              if( trim($_POST['comment']) =='' || trim($_POST['comment']) ==__('Mensagem','wpestate')){
                echo json_encode(array('sent'=>false, 'response'=>__('Mensagem está vazia!','wpestate') ) ); 
                exit();
              }else {
                $comment = wp_kses($_POST['comment'] ,$allowed_html );
              }
        } 

        $message='';
        
        if(isset($_POST['agentemail'] )){
            if( is_email ( $_POST['agentemail'] ) ){
                $receiver_email = wp_kses ($_POST['agentemail'],$allowed_html) ;
            }
        }
       
        
        $propid=intval($_POST['propid']);
        if($propid!=0){
            $permalink = get_permalink(  $propid );
        }else{
            $permalink = 'contact page';
        }
        
        $message .= __('Nome Cliente','wpestate').": " . $name . "\n\n ".__('E-mail','wpestate').": " . $email . " \n\n ".__('Telefone','wpestate').": " . $phone . " \n\n ".__('Assunto','wpestate').": " . $subject . " \n\n".__('Mensagem','wpestate').": \n " . $comment;
        $message .="\n\n Mensagem enviada de " .$permalink;
        $headers = 'From: No Reply <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n";
        $mail = wp_mail($receiver_email, $subject, $message, $headers);
        
        
        $duplicate_email_adr        =   esc_html ( get_option('wp_estate_duplicate_email_adr','') );
        
        if($duplicate_email_adr!=''){
            $message = $message.' '.__('Mensagem também foi enviada para ','wpestate').$receiver_email;
            wp_mail($duplicate_email_adr, $subject, $message, $headers);
        }
        
        echo json_encode(array('sent'=>true, 'response'=>__('Sua mensagem foi enviada com sucesso. Obrigado.','wpestate') ) ); 

        
      
        die(); 
        
        
}

endif; // end   wpestate_ajax_agent_contact_form 



//////////////////////////////////////////////////////////////////////////////
/// Ajax adv search contact function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_contact_form_footer', 'wpestate_ajax_contact_form_footer' );  
add_action( 'wp_ajax_wpestate_ajax_contact_form_footer', 'wpestate_ajax_contact_form_footer' );  

if( !function_exists('wpestate_ajax_contact_form_footer') ):

function wpestate_ajax_contact_form_footer(){
    
        // check for POST vars
        $hasError = false;
        $to_print='';
        $allowed_html   =   array();
        if ( !wp_verify_nonce( $_POST['nonce'], 'ajax-footer-contact')) {
            exit("No naughty business please");
        }   
          
        
        
        if ( isset($_POST['name']) ) {
           if( trim($_POST['name']) =='' || trim($_POST['name']) ==__('Nome','wpestate') ){
               echo json_encode(array('sent'=>false, 'response'=>__('Campo Nome está vazio!','wpestate') ));         
               exit(); 
           }else {
               $name = wp_kses( trim($_POST['name']),$allowed_html );
           }          
        } 

        //Check email
        if ( isset($_POST['email']) || trim($_POST['name']) ==__('E-mail','wpestate') ) {
              if( trim($_POST['email']) ==''){
                    echo json_encode(array('sent'=>false, 'response'=>__('Campo E-mail está vazio!','wpestate' ) ) );      
                    exit(); 
              } else if( filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) === false) {
                    echo json_encode(array('sent'=>false, 'response'=>__('E-mail inválido!','wpestate') ) ); 
                    exit();
              } else {
                    $email = wp_kses( trim($_POST['email']),$allowed_html );
              }
        }

        
        
        $phone = wp_kses( trim($_POST['phone']),$allowed_html );
     
        //Check comments 
        if ( isset($_POST['contact_coment']) ) {
              if( trim($_POST['contact_coment']) ==''){
                echo json_encode(array('sent'=>false, 'response'=>__('Mensagem está vazia!','wpestate') ) ); 
                exit();
              }else {
                $comment = wp_kses( trim ($_POST['contact_coment'] ) ,$allowed_html);
              }
        } 

       
        if(isset($_POST['agentemail'] )){
            if( is_email ( $_POST['agentemail'] ) ){
                $receiver_email = wp_kses ( $_POST['agentemail'],$allowed_html) ;
            }
        }
       
        
        $message='';
        
        $subject =__('Formulário de contato de ','wpestate') . home_url() ;
        $message .= __('Nome Cliente','wpestate').": ". $name . "\n\n".__('E-mail','wpestate').": " . $email . " \n\n ".__('Telefone','wpestate').": " . $phone . " \n\n ".__("Assunto",'wpestate').": " . $subject . " \n\n".__('Mensagem','wpestate').":\n " . $comment;
        $message .="\n\n ".__('Mensagem enviada pelo contato do rodapé','wpestate');
        $headers = 'From: noreply  <noreply@'.$_SERVER['HTTP_HOST'].'>' . "\r\n".
                        'Reply-To: noreply@wpresidence.net' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
        wp_mail($receiver_email, $subject, $message, $headers);
  
        echo json_encode(array('sent'=>true, 'response'=>__('Sua mensagem foi enviada com sucesso. Obrigado.','wpestate') ) ); 

        
      
        die(); 
        
        
}

endif; // end   ajax_agent_contact_form 





////////////////////////////////////////////////////////////////////////////////
/// Ajax adv search contact function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_contact_form', 'wpestate_ajax_contact_form' );  
add_action( 'wp_ajax_wpestate_ajax_contact_form', 'wpestate_ajax_contact_form' );  

if( !function_exists('wpestate_ajax_contact_form') ):

function wpestate_ajax_contact_form(){
    
        // check for POST vars
        $hasError = false;
        $allowed_html   =   array();
        $to_print='';
        if ( !wp_verify_nonce( $_POST['nonce'], 'ajax-contact')) {
            exit("No naughty business please");
        }   

        if (trim($_POST['name']) == '') {
            $hasError = true;
            $error[] = __('The name field is empty !','wpestate');
        } else {
            $name = wp_kses( trim($_POST['name']),$allowed_html );
        }

        //Check email
        if (trim($_POST['email']) == '') {
            $hasError = true;
            $error[] = __('The email field is empty','wpestate');
        } else if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL) === false) {
            $hasError = true;
            $error[] = __('The email doesn\'t look right !','wpestate');
        } else {
            $email = wp_kses( trim($_POST['email']),$allowed_html );
        }

        $phone = esc_html( trim($_POST['phone']) );
        $subject =__('Contact form from ','wpestate') . home_url() ;

        //Check comments 
        if (trim($_POST['comment']) == '') {
            $hasError = true;
            $error[] = __('Your message is empty !','wpestate');
        } else {
            $comment = wp_kses( trim ($_POST['comment'] ),$allowed_html );
        }

         $message='';
            $receiver_email = is_email ( get_bloginfo('admin_email') );
         if (!$hasError) {
            $message .= __('Client Name','wpestate').": ". $name . "\n\n".__('Email','wpestate').": " . $email . " \n\n ".__('Phone','wpestate').": " . $phone . " \n\n ".__("Subject",'wpestate').": " . $subject . " \n\n".__('Message','wpestate').":\n " . $comment;
            $email_headers = "From: " . $email . " \r\n Reply-To:" . $email;

            $mail = wp_mail($receiver_email, $subject, $message, $email_headers);
            $succes = '<span>'.__('The message was sent !','wpestate').'</span>';
                   
            print $succes;
          
        }else{
             foreach ($error as $mes) {
                $to_print.=$mes . '<br />';
             }
             print $to_print;
        }
        die(); 
        
        
}

endif; // end   wpestate_ajax_contact_form 



////////////////////////////////////////////////////////////////////////////////
/// Ajax  Package Paypal function
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_paypal_pack_generation', 'wpestate_ajax_paypal_pack_generation' );  
add_action( 'wp_ajax_wpestate_ajax_paypal_pack_generation', 'wpestate_ajax_paypal_pack_generation' );  

if( !function_exists('wpestate_ajax_paypal_pack_generation') ):

function wpestate_ajax_paypal_pack_generation(){
    $allowed_html   =   array();
    $packName   =   wp_kses($_POST['packName'],$allowed_html);
    $pack_id    =   $_POST['packId'];
    if(!is_numeric($pack_id)){
        exit();
    }
    
    
    $is_pack = get_posts('post_type=membership_package&p='.$pack_id);
    
    
    if( !empty ( $is_pack ) ) {
            global $current_user;
            get_currentuserinfo(); 
            $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
            $submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
            $paypal_status                  =   esc_html( get_option('wp_estate_paypal_api','') );
          
            $host                           =   'https://api.sandbox.paypal.com';
            if($paypal_status=='live'){
                $host   =   'https://api.paypal.com';
            }
            
            $url        = $host.'/v1/oauth2/token'; 
            $postArgs   = 'grant_type=client_credentials';
            $token      = wpestate_get_access_token($url,$postArgs);
            $url        = $host.'/v1/payments/payment';
            

           $dash_profile_link = get_dashboard_profile_link();


            $payment = array(
                            'intent' => 'sale',
                            "redirect_urls"=>array(
                                "return_url"=>$dash_profile_link,
                                "cancel_url"=>$dash_profile_link
                                ),
                            'payer' => array("payment_method"=>"paypal"),

                );

            
                    $payment['transactions'][0] = array(
                                        'amount' => array(
                                            'total' => $pack_price,
                                            'currency' => $submission_curency_status,
                                            'details' => array(
                                                'subtotal' => $pack_price,
                                                'tax' => '0.00',
                                                'shipping' => '0.00'
                                                )
                                            ),
                                        'description' => $packName.' '.__('membership payment on ','wpestate').get_bloginfo('url')
                                       );

                    //
                    // prepare individual items
                    $payment['transactions'][0]['item_list']['items'][] = array(
                                                            'quantity' => '1',
                                                            'name' => __('Membership Payment','wpestate'),
                                                            'price' => $pack_price,
                                                            'currency' => $submission_curency_status,
                                                            'sku' => $packName.' '.__('Membership Payment','wpestate'),
                                                           );
                   
                    
                    $json = json_encode($payment);
                    $json_resp = wpestate_make_post_call($url, $json,$token);
                    foreach ($json_resp['links'] as $link) {
                            if($link['rel'] == 'execute'){
                                    $payment_execute_url = $link['href'];
                                    $payment_execute_method = $link['method'];
                            } else  if($link['rel'] == 'approval_url'){
                                            $payment_approval_url = $link['href'];
                                            $payment_approval_method = $link['method'];
                                    }
                    }



                    $executor['paypal_execute']     =   $payment_execute_url;
                    $executor['paypal_token']       =   $token;
                    $executor['pack_id']            =   $pack_id;
                    $save_data[$current_user->ID ]  =   $executor;
                    update_option('paypal_pack_transfer',$save_data);
                    print $payment_approval_url;
       }
       die();
}

endif; // end   ajax_paypal_pack_generation  - de la ajax_upload





////////////////////////////////////////////////////////////////////////////////
/// Ajax  Package Paypal function - recuring payments
////////////////////////////////////////////////////////////////////////////////
add_action( 'wp_ajax_nopriv_wpestate_ajax_paypal_pack_recuring_generation', 'wpestate_ajax_paypal_pack_recuring_generation' );  
add_action( 'wp_ajax_wpestate_ajax_paypal_pack_recuring_generation', 'wpestate_ajax_paypal_pack_recuring_generation' );  
   
if( !function_exists('wpestate_ajax_paypal_pack_recuring_generation') ):

function wpestate_ajax_paypal_pack_recuring_generation(){
    $allowed_html=array();
    $packName   =   wp_kses($_POST['packName'],$allowed_html);
    $pack_id    =   $_POST['packId'];
    if(!is_numeric($pack_id)){
        exit();
    }

    $is_pack = get_posts('post_type=membership_package&p='.$pack_id);
    if( !empty ( $is_pack ) ) {
        require('resources/paypalfunctions.php');
        global $current_user;

        get_currentuserinfo(); 
        $pack_price                     =   get_post_meta($pack_id, 'pack_price', true);
        $billing_period                 =   get_post_meta($pack_id, 'biling_period', true);
        $billing_freq                   =   intval(get_post_meta($pack_id, 'billing_freq', true));
        $pack_name                      =   get_the_title($pack_id);
        $submission_curency_status      =   esc_html( get_option('wp_estate_submission_curency','') );
        $paypal_status                  =   esc_html( get_option('wp_estate_paypal_api','') );
        $paymentType                    =   "Sale";
        
        $dash_profile_link              =   get_dashboard_profile_link();
     
        $obj=new paypal_recurring;
        $obj->environment               =   esc_html( get_option('wp_estate_paypal_api','') );
        $obj->paymentType               =   urlencode('Sale');
        $obj->productdesc               =   urlencode($pack_name.__(' package on ','wpestate').get_bloginfo('name') );
        $time                           =   time(); 
        $date                           =   date('Y-m-d H:i:s',$time); 
        $obj->startDate                 =   urlencode($date);
        $obj->billingPeriod             =   urlencode($billing_period);         
        $obj->billingFreq               =   urlencode($billing_freq);                
        $obj->paymentAmount             =   urlencode($pack_price);
        $obj->currencyID                =   urlencode($submission_curency_status);  
        $paypal_api_username            =   ( get_option('wp_estate_paypal_api_username','') );
        $paypal_api_password            =   ( get_option('wp_estate_paypal_api_password','') );
        $paypal_api_signature           =   ( get_option('wp_estate_paypal_api_signature','') );    
        $obj->API_UserName              =   urlencode( $paypal_api_username );
        $obj->API_Password              =   urlencode( $paypal_api_password );
        $obj->API_Signature             =   urlencode( $paypal_api_signature );
        $obj->API_Endpoint              =   "https://api-3t.paypal.com/nvp";
        $obj->returnURL                 =   urlencode($dash_profile_link);
        $obj->cancelURL                 =   urlencode($dash_profile_link);   
        $executor['paypal_execute']     =   '';
        $executor['paypal_token']       =   '';
        $executor['pack_id']            =   $pack_id;
        $executor['recursive']          =   1;
        $executor['date']               =   $date;
        $save_data[$current_user->ID ]  =   $executor;
        update_option('paypal_pack_transfer',$save_data);
         
        $obj->setExpressCheckout();
          

    }
}

endif; // end   wpestate_ajax_paypal_pack_recuring_generation  - de la ajax_upload
?>