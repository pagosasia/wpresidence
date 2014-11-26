</div><!-- end content_wrapper started in header -->

<footer id="colophon" role="contentinfo">    
    <div id="footer-widget-area" class="row">
       <?php get_sidebar('footer');?>
    </div><!-- #footer-widget-area -->

    <div class="sub_footer">  
        <div class="sub_footer_content">
            <span class="copyright">
                <?php      
                if (function_exists('icl_translate') ){
                    print $property_copy_text      =   icl_translate('wpestate','wp_estate_property_copyright_text', esc_html( get_option('wp_estate_copyright_message') ) );
                }else{
                    print esc_html (get_option('wp_estate_copyright_message', ''));
                }
                ?>
            </span>
		  
		  <a href="http://token.ac" target="_blank"><div id="token-rodape"></div></a>

            <div class="subfooter_menu">
                <?php      
                    wp_nav_menu( array(
                        'menu'              => 'footer_menu',
                        'theme_location'    => 'footer_menu',
                        'depth'             => 1                           
                    ));  
                ?>
            </div>  
        </div>  
    </div>
</footer><!-- #colophon -->


<?php get_template_part('templates/footer_buttons');?>
<?php get_template_part('templates/navigational');?>



<?php wp_footer(); ?>

<?php
$ga = esc_html(get_option('wp_estate_google_analytics_code', ''));
if ($ga != '') { ?>

<script>
    //<![CDATA[
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $ga; ?>', '<?php     echo $_SERVER['SERVER_NAME']; ?>');
  ga('send', 'pageview');
//]]>
</script>

<?php
}
?>

</div> <!-- end class container -->
</div> <!-- end website wrapper -->
</body>
</html>