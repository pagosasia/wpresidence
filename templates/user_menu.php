<?php 
global $current_user;      

get_currentuserinfo();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;  
$add_link               =   get_dasboard_add_listing();
$dash_profile           =   get_dashboard_profile_link();
$dash_favorite          =   get_dashboard_favorites();
$dash_link              =   get_dashboard_link();
$activeprofile          =   '';
$activedash             =   '';
$activeadd              =   '';
$activefav              =   '';
$user_pack              =   get_the_author_meta( 'package_id' , $userID );    
$clientId               =   esc_html( get_option('wp_estate_paypal_client_id','') );
$clientSecret           =   esc_html( get_option('wp_estate_paypal_client_secret','') );  
$user_registered        =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $userID );
$home_url               =   home_url();


if ( basename( get_page_template() ) == 'user_dashboard.php' ){
    $activedash  =   'user_tab_active';    
}else if ( basename( get_page_template() ) == 'user_dashboard_add.php' ){
    $activeadd   =   'user_tab_active';
}else if ( basename( get_page_template() ) == 'user_dashboard_profile.php' ){
    $activeprofile   =   'user_tab_active';
}else if ( basename( get_page_template() ) == 'user_dashboard_favorite.php' ){
    $activefav   =   'user_tab_active';
}
?>


<div class="user_tab_menu">

    <div class="user_dashboard_links">
        <?php if( $dash_profile!=$home_url ){ ?>
            <a href="<?php print $dash_profile;?>"  class="<?php print $activeprofile; ?>"><i class="fa fa-cog"></i> <?php _e('My Profile','wpestate');?></a>
        <?php } ?>
        <?php if( $dash_link!=$home_url ){ ?>
            <a href="<?php print $dash_link;?>"     class="<?php print $activedash; ?>"> <i class="fa fa-map-marker"></i> <?php _e('My Properties List','wpestate');?></a>
        <?php } ?>
        <?php if( $add_link!=$home_url ){ ?>
            <a href="<?php print $add_link;?>"      class="<?php print $activeadd; ?>"> <i class="fa fa-plus"></i><?php _e('Add New Property','wpestate');?></a>  
        <?php } ?>
        <?php if( $dash_favorite!=$home_url ){ ?>
            <a href="<?php print $dash_favorite;?>" class="<?php print $activefav; ?>"><i class="fa fa-heart"></i> <?php _e('Favorites','wpestate');?></a>
        <?php } ?>
        <a href="<?php echo wp_logout_url();?>" title="Logout"><i class="fa fa-power-off"></i> <?php _e('Log Out','wpestate');?></a>
    </div>
      <?php  get_template_part('templates/user_memebership_profile');  ?>
</div>

 