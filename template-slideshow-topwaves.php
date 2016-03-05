<?php get_header();
/*
Template Name: Topwaves Slideshow
*/
global $post, $realty_theme_option;

$slideshow_height = get_field( 'slideshow_height', $post->ID );
$slideshow_width = get_field( 'slideshow_width', $post->ID );
$slideshow_custom_height = get_field( 'slideshow_custom_height', $post->ID );
$slideshow_autoplay = get_field( 'slideshow_autoplay', $post->ID );
$slideshow_speed = get_field( 'slideshow_speed', $post->ID );
$slideshow_animation = get_field( 'slideshow_animation', $post->ID );
$slideshow_type = get_field( 'slideshow_type', $post->ID );

$slideshow_navigation = get_field( 'slideshow_navigation', $post->ID );

if ( is_array( $slideshow_navigation ) && in_array( 'arrows', $slideshow_navigation ) ) {
	$slideshow_arrows = true;
} else {
	$slideshow_arrows = false;
}

if ( is_array( $slideshow_navigation ) && in_array( 'dots', $slideshow_navigation ) ) {
	$slideshow_dots = true;
} else {
	$slideshow_dots = false;
}

if ( empty ( $slideshow_speed ) ) {
	$slideshow_speed = 5000;
}

$slideshow_property_type = get_field( 'slideshow_property_type', $post->ID );
$slideshow_property_slides = get_field( 'slideshow_property_slides', $post->ID );
$slideshow_show_latest_properties_amount = get_field( 'slideshow_show_latest_properties_amount', $post->ID );
$slideshow_property_search_form = get_field( 'slideshow_property_search_form', $post->ID );
$latest_number = get_field( 'slideshow_show_latest_properties_number' );
$row_custom_slides = get_field( 'slideshow_custom_slides' );
$custom_slides_count = count( $row_custom_slides );
$property_slides_count = count( $slideshow_property_slides );
$slides_loop = 1;

if ( $latest_number == 1 ) {
	$slides_loop = 0;
}
if ( $custom_slides_count == 1 ) {
	$slides_loop = 0;
}
if ( $property_slides_count == 1 ) {
	$slides_loop = 0;
}

?>

<script>
jQuery(document).ready(function() {

<?php if ( $slideshow_height == "slideshow-height-fullscreen" ) { ?>
windowHeight = jQuery(window).height();
navHeight = jQuery('header.navbar').height();
heightFullscreen = windowHeight - navHeight;
jQuery('#template-slideshow .owl-lazy').css( 'height', heightFullscreen );
<?php } ?>
<?php if ( $slideshow_height == "slideshow-height-custom" ) { ?>
jQuery('#template-slideshow .owl-lazy').css( 'height', <?php echo $slideshow_custom_height; ?> );
<?php } ?>

// Pause autoplay on slide hover, but not on mobile devices.
var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
if ( isMobile ) {
	var slideshowPauseHover = 'false';
} else {
	var slideshowPauseHover = 'true';
}

var slideshow = jQuery('#template-slideshow .slides');

slideshow.owlCarousel({
  items: 1,
//singleItem: true,
  margin: 0,
  lazyLoad: true,
  loop: <?php echo $slides_loop; ?>,
  navContainerClass: 'owl-nav',
  navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
  <?php if ( $slideshow_arrows ) { ?>
  nav: true,
  <?php } else { ?>
  nav: false,
  <?php } ?>
  <?php if ( $slideshow_dots ) { ?>
  dots: true,
  <?php } else { ?>
  dots: false,
  <?php } ?>
  autoHeight: false,
  <?php if ( $slideshow_autoplay == true ) { ?>
  autoplay: true,
  autoplayHoverPause: slideshowPauseHover,
  <?php } ?>
  <?php if ( $slideshow_speed ) { ?>
  autoplayTimeout: <?php echo $slideshow_speed; ?>,
  <?php } ?>
  <?php if ( $slideshow_animation == 'fade' ) { ?>
  animateIn: 'fadeIn',
  animateOut: 'fadeOut',
  <?php } ?>
  <?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
  rtl: true,
  <?php } ?>
});

slideshow.fadeTo(400, 1, function() {
  jQuery('.spinner').remove();
});

jQuery('#template-slideshow').on('click', function() {
  slideshow.trigger('stop.owl.autoplay');
})

});
</script>

<div id="template-slideshow" class="<?php echo $slideshow_height . ' ' . $slideshow_type; ?>">

	<div class="spinner">
	  <div class="bounce1"></div>
	  <div class="bounce2"></div>
	  <div class="bounce3"></div>
	</div>

	<?php if ( $slideshow_property_search_form != 'none' ) { ?>
	<div class="slideshow-search">
		<div class="container">
		<?php
		if ( $slideshow_property_search_form == 'custom' ) {
			get_template_part( 'lib/inc/template/search-form' );
		} else if ( $slideshow_property_search_form == 'mini' ) {
			get_template_part( 'lib/inc/template/search-form-mini' );
		}
		?>
		</div>
	</div>
	<?php } ?>

	<div class="slides">
	<?php

	/* SLIDESHOW TYPE - CUSTOM
	============================== */

	if ( $slideshow_type == "slideshow-type-custom" ) {

		if ( have_rows('slideshow_custom_slides') ) :

			$i = 1;

			while ( have_rows('slideshow_custom_slides') ) : the_row();

				$attachment_id = get_sub_field('custom_slide_background_image_id');
				$slide_title = get_sub_field('custom_slide_title');
				$slide_description = get_sub_field('custom_slide_description');
				$slide_link = get_sub_field('custom_slide_link');
				$slide_color = get_sub_field('custom_slide_color');
				$slide_text_align = get_sub_field('custom_slide_text_alignment');

				$attachment_array = wp_get_attachment_image_src( $attachment_id, $slideshow_width );
				$attachment_url = $attachment_array[0];
				?>

				<div class="slide slide-<?php echo $i;?>" style="text-align:<?php echo $slide_text_align; ?>">

				<style>
				#template-slideshow .slide-<?php echo $i;?> .title, #template-slideshow .slide-<?php echo $i;?> .description {
					color: <?php echo $slide_color; ?>;
				}
				<?php if ( $slide_text_align == 'left' ) { ?>
				#template-slideshow.slideshow-type-custom .slide-<?php echo $i;?> .title:after { left: 0; margin: 0; }
				<?php } else if ( $slide_text_align == 'right' ) { ?>
				#template-slideshow.slideshow-type-custom .slide-<?php echo $i;?> .title:after { left: 100%; margin-left: -60px; }
				<?php }	?>
				</style>

				<?php
				if ( $slideshow_height == "original" ) {
					echo '<img class="owl-lazy" data-src="' . $attachment_url . '" alt="" style="max-width:none" />';
				} else {
					echo '<div class="owl-lazy" data-src="' . $attachment_url . '"></div>';
				}
				?>

				<?php if ( $slideshow_property_search_form == 'none' ) { ?>

				<?php if ( $slide_link ) { echo '<a href="' . $slide_link . '" class="slideshow-content-link">'; } ?>
				<div class="wrapper-out">
					<div class="wrapper<?php if ( $slide_title || $slide_description ) { echo ' slide-has-text'; } ?>">
						<div class="inner<?php if ( $slideshow_property_search_form != 'none' ) { echo ' bottom'; } ?>">
							<div class="container">
									<?php if ( $slide_title ) { echo '<h3 class="title">' . $slide_title . tt_icon_property_video() . '</h3>'; } ?>
									<?php if ( $slideshow_property_search_form == "none" && $slide_description ) { ?>
									<div class="clearfix"></div>
									<div class="description"><?php echo $slide_description; ?></div>
									<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php if ( $slide_link ) { echo '</a>'; } ?>

				<?php } ?>
				</div>
			<?php
			$i++;
			endwhile;

			else :

			 //echo "no rows found";

		endif;

	} // Custom Slideshow


	/* SLIDESHOW TYPE - PROPERTY
	============================== */

	else {

		// Show Featured Properties
		if ( $slideshow_property_type == "property-type-featured" ) {
			$property_slides_args = array(
				'post_type' 			=> 'property',
				'posts_per_page'	=> -1,
				'meta_query' 			=> array(
												     	array(
										           'key' 			=> 'estate_property_featured',
										           'value' 		=> 1,
										           'compare' 	=> 'like',
															)
				)
			);
		}

		// Show Latest .. Properties
		else if ( $slideshow_property_type == "property-type-latest" ) {

			$latest_number = get_field('slideshow_show_latest_properties_number');

			if ( ! empty ( $latest_number ) ) {
				$latest_amount = $latest_number;
			} else {
				$latest_amount = '3';
			}

			$property_slides_args = array(
				'post_type' 			=> 'property',
				'posts_per_page' 	=> $latest_amount,
			);
		}

		// Show Selected Properties
		else {

			$property_slides_id = array();

			if ( have_rows('slideshow_property_slides') ) :

				while ( have_rows('slideshow_property_slides') ) : the_row();

					$property_slides = get_sub_field('property_slide');
					$property_slides_id[] = $property_slides->ID;

				endwhile;

			else :

				echo '<div class="container" style="margin: 50px auto;"><p class="alert alert-info">' . __( 'Please select the "Property Slides" you would like to display here first.', 'tt' ) . '</p></div>';

			endif;

			$property_slides_args = array(
				'post_type' 			=> 'property',
				'post__in' 				=> $property_slides_id,
				'posts_per_page' 	=> count($property_slides_id),
				'orderby' 				=> 'post__in',
			);
		}

		$property_slides = new WP_Query( $property_slides_args );

		if ( $property_slides->have_posts() ) :

			$i = 1;

			while ( $property_slides->have_posts() ) : $property_slides->the_post();
			?>

			<div class="slide slide-<?php echo $i;?>">

			<?php
			$attachment_array = wp_get_attachment_image_src( get_post_thumbnail_id(), $slideshow_width, true );
			$attachment_url = $attachment_array[0];

			if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) {
				$arrow_class = 'arrow-left';
			} else {
				$arrow_class = 'arrow-right';
			}

			if ( $slideshow_height == "slideshow-height-original" ) {
				echo '<img class="owl-lazy" data-src="' . $attachment_url . '" alt="" style="max-width:none" />';
			} else {
				echo '<div class="owl-lazy" data-src="' . $attachment_url . '"></div>';
			}
			?>

			<div class="wrapper-out">
				<div class="wrapper">
					<div class="inner<?php if ( $slideshow_property_search_form != 'none' ) { echo ' bottom'; } ?>">
						<div class="container">
							<?php echo '<h3 class="title"><a href="' . get_the_permalink() . '" class="slideshow-content-link">' . get_the_title() . '</a>' . tt_icon_property_video() . '</h3>'; ?>
							<?php if ( $slideshow_property_search_form == 'none' && get_the_excerpt() ) { ?>
							<div class="clearfix"></div>
							<div class="description">
								<?php the_excerpt(); ?>
								<?php if ( get_the_title() ) {
									echo '<div class="' . $arrow_class . '"></div>';
								}
								$size = get_post_meta( $post->ID, 'estate_property_size', true );
								$size_unit = get_post_meta( $post->ID, 'estate_property_size_unit', true );
								$bedrooms = get_post_meta( $post->ID, 'estate_property_bedrooms', true );
								$bathrooms = get_post_meta( $post->ID, 'estate_property_bathrooms', true );

								echo '<div class="property-data">';
								echo '<div class="property-price">' . tt_property_price() . '</div>';

								echo '<div class="property-details">';
								if ( $bedrooms ) { echo '<i class="fa fa-bed"></i>' . $bedrooms . ' ' . _n( __( 'Bedroom', 'tt'), __( 'Bedrooms', 'tt'), $bedrooms, 'tt' ); }
								if ( $bathrooms ) { echo '<i class="fa fa-tint"></i>' . $bathrooms . ' ' . _n( __( 'Bathroom', 'tt'), __( 'Bathrooms', 'tt'), $bathrooms, 'tt' ); }
								if ( $size ) { echo '<i class="fa fa-expand"></i>' . $size . $size_unit; }
								echo '</div></div>';
								?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>

		</div>
		<?php
		endwhile;
		wp_reset_query();
		endif;

	} // Property Slideshow
	?>

	</div>

</div><!-- #template-slideshow -->

<div class="container">

	<div class="row">

		<?php
		$hide_sidebar = get_post_meta( $post->ID, 'estate_page_hide_sidebar', true );
		// Check for Page Sidebar
		if ( ! $hide_sidebar && is_active_sidebar( 'sidebar_page' ) ) {
			echo '<div class="col-sm-8 col-md-9">';
		} else {
			echo '<div class="col-sm-12">';
		}

		if ( have_posts() ) : while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		endif;
		?>

		</div><!-- .col-sm-x -->

		<?php
		// Check for Page Sidebar
		if ( ! $hide_sidebar && is_active_sidebar( 'sidebar_page' ) ) :
		?>
		<div class="col-sm-4 col-md-3">
			<ul id="sidebar">
				<?php dynamic_sidebar( 'sidebar_page' ); ?>
			</ul>
		</div>
		<?php endif; ?>

	</div><!-- .row -->

</div><!-- .container -->

<?php get_footer(); ?>
