<?php
class Login_widget extends WP_Widget {
	
	function Login_widget(){
		$widget_ops = array('classname' => 'loginwd_sidebar', 'description' => 'Put the login & register form on sidebar');
		$control_ops = array('id_base' => 'login_widget');
		$this->WP_Widget('login_widget', 'Wp Estate: Login & Register', $widget_ops, $control_ops);
	}
	
	function form($instance){
		$defaults = array();
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $display='';
		
              
		print $before_widget;
                $facebook_status    =   esc_html( get_option('wp_estate_facebook_login','') );
                $google_status      =   esc_html( get_option('wp_estate_google_login','') );
                $yahoo_status       =   esc_html( get_option('wp_estate_yahoo_login','') );
		$mess='';
		$display.='
                <div class="login_sidebar">
                    <h3 class="widget-title-sidebar"  id="login-div-title">'.__('Login','wpestate').'</h3>
                    <div class="login_form" id="login-div">
                        <div class="loginalert" id="login_message_area_wd" >'.$mess.'</div>
                            
                        <input type="text" class="form-control" name="log" id="login_user_wd" placeholder="'.__('Username','wpestate').'"/>
                        <input type="password" class="form-control" name="pwd" id="login_pwd_wd" placeholder="'.__('Password','wpestate').'"/>                       
                        <input type="hidden" name="loginpop" id="loginpop_wd" value="0">
                        '. wp_nonce_field( 'login_ajax_nonce', 'security-login',false,false ).'   

                       
                        <button class="wpb_button  wpb_btn-info wpb_btn-large" id="wp-login-but-wd" >'.__('Login','wpestate').'</button>
                        
                        <div class="login-links">
                            <a href="#" id="widget_register_sw">'.__('Need an account? Register here!','wpestate').'</a>';
                        if($facebook_status=='yes'){
                            $display.='<div id="facebookloginsidebar" data-social="facebook"></div>';
                        }
                        if($google_status=='yes'){
                            $display.='<div id="googleloginsidebar" data-social="google"></div>';
                        }
                        if($yahoo_status=='yes'){
                            $display.='<div id="yahoologinsidebar" data-social="yahoo"></div>';
                        }
                
                    $display.='
                        </div>    
                    </div>
                
              <h3 class="widget-title-sidebar"  id="register-div-title">'.__('Register','wpestate').'</h3>
                <div class="login_form" id="register-div">
                    <div class="loginalert" id="register_message_area_wd" ></div>
                    <input type="text" name="user_login_register" id="user_login_register_wd" class="form-control" placeholder="'.__('Username','wpestate').'"/>
                    <input type="text" name="user_email_register" id="user_email_register_wd" class="form-control" placeholder="'.__('Email','wpestate').'"  />
                    <p id="reg_passmail">'.__('A password will be e-mailed to you','wpestate').'</p>
                    '. wp_nonce_field( 'register_ajax_nonce', 'security-register',false,false ).'   
                    <button class="wpb_button  wpb_btn-info wpb_btn-large" id="wp-submit-register_wd">'.__('Register','wpestate').'</button>

                    <div class="login-links">
                        <a href="#" id="widget_login_sw">'.__('Back to Login','wpestate').'</a>                       
                    </div>   
                 </div>
                </div>';
                
                
                global $current_user;  
                get_currentuserinfo();  
                $userID                 =   $current_user->ID;
                $user_login             =   $current_user->user_login;
                $user_email             =   get_the_author_meta( 'user_email' , $userID );
                
                $activeprofile= $activedash = $activeadd = $activefav ='';
                
                $add_link               =   get_dasboard_add_listing();
                $dash_profile           =   get_dashboard_profile_link(); 
                $dash_link              =   get_dashboard_link();
                $dash_favorite          =   get_dashboard_favorites();
                $home_url               =   home_url();
                $logged_display='
                    <h3 class="widget-title-sidebar" >'.__('Hello ','wpestate'). ' '. $user_login .'  </h3>
                    
                    <ul class="wd_user_menu">';
                    if($home_url!=$dash_profile){
                        $logged_display.='<li> <a href="'.$dash_profile.'"  class="'.$activeprofile.'"><i class="fa fa-cogs"></i>  '.__('My Profile','wpestate').'</a> </li>';
                    }
                    if($home_url!=$dash_link){
                        $logged_display.=' <li> <a href="'.$dash_link.'"     class="'.$activedash.'"><i class="fa fa-map-marker"></i>'.__('My Properties List','wpestate').'</a> </li>';
                    }
                    if($home_url!=$add_link){
                        $logged_display.=' <li> <a href="'.$add_link.'"      class="'.$activeadd.'"><i class="fa fa-plus"></i>'. __('Add New Property','wpestate').'</a> </li>
                      ';
                    }
                    if($home_url!=$dash_favorite){
                        $logged_display.=' <li> <a href="'.$dash_favorite.'" class="'.$activefav.'"><i class="fa fa-heart"></i>'.__('Favorites','wpestate').'</a> </li>';
                    }
                       
                        $logged_display.=' <li> <a href="'.wp_logout_url().'" title="Logout"><i class="fa fa-power-off"></i>'.__('Log Out','wpestate').'</a> </li>   
                    </ul>
                ';
                
               if ( is_user_logged_in() ) {                   
                  print $logged_display;
               }else{
                  print $display; 
               }
               print $after_widget;
	}

}

?>