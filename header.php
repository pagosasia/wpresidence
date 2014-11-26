<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
    <?php
    // Print the <title> tag based on what is being viewed
    global $page, $paged;
    wp_title( '|', true, 'right' );

    // Add the blog name.
    bloginfo( 'name' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        echo " | $site_description";

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        echo ' | ' . sprintf( __( 'Page %s', 'wpestate' ), max( $paged, $page ) );
    ?>
</title>



<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 
<?php 
$favicon        =   esc_html( get_option('wp_estate_favicon_image','') );

if ( $favicon!='' ){
    echo '<link rel="shortcut icon" href="'.$favicon.'" type="image/x-icon" />';
} else {
    echo '<link rel="shortcut icon" href="'.get_template_directory_uri().'/img/favicon.gif" type="image/x-icon" />';
}


$wide_class      =   '';
$wide_status     =   esc_html(get_option('wp_estate_wide_status',''));
if($wide_status==1){
    $wide_class="wide";
}
wp_head();
$general_font   = esc_html( get_option('wp_estate_general_font', '') );
$custom_css     = stripslashes  ( get_option('wp_estate_custom_css')  );
$color_scheme   = esc_html( get_option('wp_estate_color_scheme', '') );

if ($general_font != '' || $color_scheme == 'yes' || $custom_css != ''){
    echo "<style type='text/css'>" ;
    if ($general_font != '') {
      require_once ('libs/custom_general_font.php');
    }
  

    if ($color_scheme == 'yes') {
       require_once ('libs/customcss.php');    
    }
    print $custom_css;
   echo "</style>";  
}
?>
</head>


<body <?php body_class(); ?>>  
<div class="website-wrapper">
<div class="container main_wrapper <?php print $wide_class;?> ">
    
    
    <div class="master_header <?php print $wide_class;?>">
        
        <?php   
        if(esc_html ( get_option('wp_estate_show_top_bar_user_menu','') )=="yes"){
            get_template_part( 'templates/top_bar' ); 
        } ?>
       
        <div class="header_wrapper">
            <div class="header_wrapper_inside">
                <div class="logo">
                    <a href="<?php echo home_url('','login');?>">
                        <?php  
                        $logo=get_option('wp_estate_logo_image','');
                        if ( $logo!='' ){
                           print '<img src="'.$logo.'" class="img-responsive" alt="logo"/>';	
                        } else {
                           print '<img class="img-responsive" src="'. get_template_directory_uri().'/img/logo.png" alt="logo"/>';
                        }
                        ?>
                    </a>
                </div>   

              
                <?php 
                if(esc_html ( get_option('wp_estate_show_top_bar_user_login','') )=="yes"){
                   get_template_part('templates/top_user_menu');  
                }
                ?>    
                <nav id="access" role="navigation">
                    <?php  wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
                </nav><!-- #access -->
                </div>
        </div>

     </div> 
  
  <?php if(is_front_page()){ echo '<div id="img-topo-home"></div>'; } ?>
  
  <?php get_template_part( 'header_media' ); ?>   
    <div class="container content_wrapper">