<?php 
global $realty_theme_option;
$copyright = $realty_theme_option['copyright'];
$hide_footer_widgets = get_post_meta( $post->ID, 'estate_page_hide_footer_widgets', true );
?>

<?php if ( ! is_page_template( 'template-slideshow.php' ) && ! is_page_template( 'template-intro.php' ) && ! is_page_template( 'template-home-properties-map.php' ) && ! is_page_template( 'template-property-search.php' ) && ! is_page_template( 'template-map-vertical.php' ) ) {  ?>
</div><!-- .container -->
<?php } ?>

<?php 
if ( is_page_template( 'template-intro.php' ) || is_page_template( 'template-map-vertical.php' ) ) {
	$show_footer = false;
} else {
	$show_footer = true;
}
?>

<?php if ( $show_footer ) { ?>
<footer id="footer">
    <?php if ( ! $hide_footer_widgets) { ?>
		<?php if ( is_active_sidebar( 'sidebar_footer_1' ) || is_active_sidebar( 'sidebar_footer_2' ) || is_active_sidebar( 'sidebar_footer_3' ) ) { ?>
        <div id="footer-top">
            <div class="container">	
                <div class="row whitebox">
                <?php
                // Check for Footer Column 1
                if ( is_active_sidebar( 'sidebar_footer_1' ) ) : 
                    echo '<div class="col-sm-6"><ul class="list-unstyled">';
                    dynamic_sidebar( 'sidebar_footer_1' );
                    echo '</ul></div>';				
                endif; 
                // Check for Footer Column 2
                if ( is_active_sidebar( 'sidebar_footer_2' ) ) : 
                    echo '<div class="col-sm-4"><ul class="list-unstyled">';
                    dynamic_sidebar( 'sidebar_footer_2' );
                    echo '</ul></div>';				
                endif; 
                // Check for Footer Column 3

                if ( is_active_sidebar( 'sidebar_footer_3' ) ) : 
                    echo '<div class="col-sm-2"><ul class="list-unstyled">';
                    dynamic_sidebar( 'sidebar_footer_3' );
                    echo '</ul></div>';				
                endif;
                ?>
                </div>			
            </div>
        </div>
	<?php } } ?>
	
	<div id="footer-bottom">
		<div class="container">
			<div class="row">
			
				<div class="col-sm-6">		
					<?php
					if ( has_nav_menu('footer') ) {	wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => 'menu-footer', 'depth' => '1' ) ); }
					if ( $copyright ) { echo '<div id="copyright">' .$copyright . '</div>'; } 
					?>
				</div>
				
				<div class="col-sm-6 social-transparent">
					<?php
					$facebook = $realty_theme_option['social-facebook'];
					$twitter = $realty_theme_option['social-twitter'];
					$google = $realty_theme_option['social-google'];
					$linkedin = $realty_theme_option['social-linkedin'];
					$pinterest = $realty_theme_option['social-pinterest'];
					$instagram = $realty_theme_option['social-instagram'];
					$youtube = $realty_theme_option['social-youtube'];
					$skype = $realty_theme_option['social-skype'];

					if ( $facebook ) { ?>
					<a href="<?php echo $facebook; ?>" <?php if($realty_theme_option['social-open-new-tab']){ echo "target='_blank'"; } ?>><i class="fa fa-facebook"></i></a>
					<?php }
					if ( $twitter ) { ?>
					<a href="<?php echo $twitter; ?>" <?php if($realty_theme_option['social-open-new-tab']){ echo "target='_blank'"; } ?>><i class="fa fa-twitter"></i></a>
					<?php }
					if ( $google ) { ?>
					<a href="<?php echo $google; ?>" <?php if($realty_theme_option['social-open-new-tab']){ echo "target='_blank'"; } ?>><i class="fa fa-google-plus"></i></a>
					<?php }
					if ( $linkedin ) { ?>
					<a href="<?php echo $linkedin; ?>" <?php if($realty_theme_option['social-open-new-tab']){ echo "target='_blank'"; } ?>><i class="fa fa-linkedin"></i></a>
					<?php }
					if ( $pinterest ) { ?>
					<a href="<?php echo $pinterest; ?>" <?php if($realty_theme_option['social-open-new-tab']){ echo "target='_blank'"; } ?>><i class="fa fa-pinterest"></i></a>
					<?php }
					if ( $instagram ) { ?>
					<a href="<?php echo $instagram; ?>" <?php if($realty_theme_option['social-open-new-tab']){ echo "target='_blank'"; } ?>><i class="fa fa-instagram"></i></a>
					<?php }
					if ( $youtube ) { ?>
					<a href="<?php echo $youtube; ?>" <?php if($realty_theme_option['social-open-new-tab']){ echo "target='_blank'"; } ?>><i class="fa fa-youtube"></i></a>
					<?php }
					if ( $skype ) { ?>
					<a href="<?php echo $skype; ?>" <?php if($realty_theme_option['social-open-new-tab']){ echo "target='_blank'"; } ?>><i class="fa fa-skype"></i></a>
					<?php }
					if ( $realty_theme_option['footer-property-search-button'] ) { ?><a href="#" id="property-search-button" data-toggle="modal" data-target="#search-modal"><i class="fa fa-search"></i></a>
					<?php }
					if ( $realty_theme_option['footer-show-up-button'] ) { ?>
					<a href="#" id="up"><i class="fa fa-angle-up"></i></a>
					<?php } ?>
				</div>
				
			</div>
		</div>
	</div>
	
</footer>

<?php if ( $realty_theme_option['footer-property-search-button'] ) { ?>
<div id="search-modal" class="modal fade" role="dialog" aria-labelledby="search-modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e( 'Close', 'tt' ); ?></span></button>
      </div>
      <div class="modal-body">
      	<h3 id="search-modal-label" class="section-title text-center"><span><?php _e( 'Property Search', 'tt' ); ?></span></h3><br />
        <?php get_template_part( 'lib/inc/template/search-form' ); ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>

<?php } ?>

<?php if( ! is_user_logged_in() && ! $realty_theme_option['disable-header-login-register-bar'] ) { get_template_part( 'lib/inc/template/login-modal' ); } ?>

<?php wp_footer(); ?>

<?php if ( $realty_theme_option['site-layout'] == "boxed" && ! is_page_template( 'template-map-vertical.php' ) ) { ?>
<div id="boxed-layout">
<?php } ?>

</body>
</html>