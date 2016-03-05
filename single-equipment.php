<?php
get_header();
global $post;
global $realty_theme_option;
$hide_sidebar = get_post_meta($post->ID, 'estate_page_hide_sidebar', true);

// Equipments
$eq_gallery = get_field('eq_gallery', $post->ID);
$property_imagesGF = $eq_gallery;
$property_images = get_post_meta($post->ID, 'eq_gallery', true);

$eq_price_prefix = get_field('eq_price_prefix');
$eq_price = get_field('eq_price');
$eq_price_suffix = get_field('eq_price_suffix');
$eq_location = get_field('eq_location');
$eq_agent = get_field('eq_location');
$eq_type = get_field('eq_type');


// Car Variables
$car_price_prefix = get_field('car_price_prefix');
$car_price = get_field('car_price');
$car_price_suffix = get_field('car_price_suffix');
$car_location = get_field('car_location');
$car_type = get_field('car_type');
$car_make = get_field('car_make');
$car_model = get_field('car_model');
$car_year = get_field('car_year');
$car_registration_date = get_field('car_registration_date');
$car_odometer = get_field('car_odometer');
$car_odometer_suffix = get_field('car_odometer_suffix');
$car_next_inspection = get_field('car_next_inspection');
$car_fuel_type = get_field('car_fuel_type');
$car_engine_power_hp = get_field('car_engine_power_hp');
$car_engine_power_kw = get_field('car_engine_power_kw');
$car_engine_size_cc = get_field('car_engine_size_cc');
$car_co2_emission = get_field('car_co2_emission');
$car_tare_mass = get_field('car_tare_mass');
$car_laden_mass = get_field('car_laden_mass');
$car_transmission = get_field('car_transmission');
$car_drive_type = get_field('car_drive_type');
$car_color = get_field('car_color');
$car_door_capacity = get_field('car_door_capacity');
$car_seat_capacity = get_field('car_seat_capacity');
$car_rim_material = get_field('car_rim_material');

// Reusing relestate logic
$social_sharing = $realty_theme_option['property-social-sharing'];
$show_agent_information = $realty_theme_option['property-agent-information'];
$if_show_agent_info = true;
$agent = get_post_meta($post->ID, 'estate_property_custom_agent', true);
$property_contact_information = get_post_meta($post->ID, 'estate_property_contact_information', true);
$show_property_contact_form = $realty_theme_option['property-contact-form'];
$property_image_location = $realty_theme_option['property-image-location'];
$property_video_location = $realty_theme_option['property-video-location'];
//$property_images = get_post_meta($post->ID, 'estate_property_gallery', true);
$featured = get_post_meta($post->ID, 'estate_property_featured', true);
$property_layout = $realty_theme_option['property-layout'];
$property_status = get_the_terms($post->ID, 'property-status');
$single_property_layout = get_post_meta($post->ID, 'estate_property_layout', true);
$property_type = get_the_terms($post->ID, 'vessel_type');
$property_video_id = get_post_meta($post->ID, 'estate_property_video_id', true);
$property_video_provider = get_post_meta($post->ID, 'estate_property_video_provider', true);
$property_title_agent = $realty_theme_option['property-title-agent'];

if (!isset($property_image_width)) {
	$property_image_width = "full";
}

if ($realty_theme_option['property-lightbox'] != "none") {
	$property_zoom = ' zoom';
} else {
	$property_zoom = null;
}

if ($realty_theme_option['property-image-height-fit-or-cut']) {
	$fit_or_cut = $realty_theme_option['property-image-height-fit-or-cut'];
} else {
	$fit_or_cut = null;
}

if ($single_property_layout == "theme_option_setting" || $single_property_layout == "") {
	if ($property_layout == "layout-full-width") {
		$layout = "full-width";
	} else {
		$layout = "boxed";
	}
} else {
	if ($single_property_layout == "full_width") {
		$layout = "full-width";
	} else {
		$layout = "boxed";
	}
}
?>
<?php if ($layout == "full-width") {
	echo '</div>';
} // .container ?>

	<div id="property-layout-<?php echo $layout; ?>">
		<?php
		if ($property_image_location == 'above') {

			include TEMPLATEPATH . '/lib/inc/template/property-slideshow.php';

		}

		// When only video is shown "above"
		if ($property_image_location == 'begin' && $property_video_location == 'above' && $property_video_provider != 'none' && $property_video_id) {
			include TEMPLATEPATH . '/lib/inc/template/property-video.php';
		}
		?>

		<?php
		// Property Title Style
		if ($realty_theme_option['property-title-style']) {
			$property_header_title_style = $realty_theme_option['property-title-style'];
		} else {
			$property_header_title_style = null;
		}


		// Check if property header has no background video and image
		/*
        if ( ( $property_image_location == 'begin' && $property_video_location == 'begin' ) || ( $property_image_location == 'begin' && $property_video_location == 'above' && ( $property_video_provider == 'none' || ! $property_video_id ) ) ) {
            $property_header_media_class = ' no-media';
        } else {
            $property_header_media_class = null;
        }

        // Property Header Meta
        $type = '';
        $property_header_meta = tt_property_price();
        if ( $property_type ) {
            foreach ( $property_type as $type ) {
                $property_header_meta .= ' &middot; ' . $type->name;
                break;
            }
        }
        if ( $property_status ) {
            foreach ( $property_status as $status ) {
                $property_header_meta .= ' &middot; ' . $status->name;
                break;
            }
        }
*/
		?>

		<div class="container">
			<div class="property-meta primary-tooltips">
				<div class="row">
					<?php if ($car_type) : ?>
						<div class="col-sm-4 col-md-3">
							<div class="meta-title"><i class="fa fa-wrench"></i></div>
							<div class="meta-data" data-toggle="tooltip" title=""
								 data-original-title="<?php _e('Vehicle Type'); ?>">
								<?php print $car_type[0]->name; ?></div>
						</div>
					<?php endif; ?>

					<?php if ($car_make) : ?>
						<div class="col-sm-4 col-md-3">
							<div class="meta-title"><i class="fa fa-calendar-o"></i></div>
							<div class="meta-data" data-toggle="tooltip" title=""
								 data-original-title="<?php _e('Vehicle Make'); ?>">
								<?php print $car_make[0]->name; ?></div>
						</div>
					<?php endif; ?>
					<?php if ($car_model) : ?>
						<div class="col-sm-4 col-md-3">
							<div class="meta-title"><i class="fa fa-calendar-o"></i></div>
							<div class="meta-data" data-toggle="tooltip" title=""
								 data-original-title="<?php _e('Vehicle Model'); ?>">
								<?php print $car_model[0]->name; ?></div>
						</div>
					<?php endif; ?>
					<div class="col-sm-4 col-md-3">
						<div class="meta-title"><i class="fa fa-slack"></i></div>
						<div class="meta-data" data-toggle="tooltip"
							 title="<?php _e('Property ID', 'tt'); ?>"><?php echo $post->ID; ?></div>
					</div>
					<?php if (!$realty_theme_option['property-meta-data-hide-print']) : ?>
						<div class="col-sm-4 col-md-3">
							<a href="#" id="print">
								<div class="meta-title"><i class="fa fa-print"></i></div>
								<div class="meta-data"><?php _e('Print this page', 'tt'); ?></div>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div><!-- .property-meta -->

			<div class="row">
				<div class="col-sm-12">
					<div id="main-content" class="content-box">

						<?php if ($property_image_location == 'begin' || $property_video_location == 'begin') {
						if ($property_image_location == 'begin') { ?>
						<section id="property-slider-below">
							<?php } else { ?>
							<section id="property-video">
								<?php }
								if ($property_image_location == 'above') {
									if ($property_video_id && $property_video_location == 'begin') {
										if ($property_video_id && ($property_video_provider == "youtube" || $property_video_provider == "vimeo")) {
											if ($property_video_provider == 'youtube') {
												if (is_ssl()) {
													$property_video_url = 'https://youtube.com/watch?v=' . $property_video_id;
												} else {
													$property_video_url = 'http://youtube.com/watch?v=' . $property_video_id;
												}
											}

											if ($property_video_provider == 'vimeo') {
												if (is_ssl()) {
													$property_video_url = 'https://player.vimeo.com/video/' . $property_video_id;
												} else {
													$property_video_url = 'http://player.vimeo.com/video/' . $property_video_id;
												}
											}
											require_once(ABSPATH . WPINC . '/class-oembed.php');
											$oembed = _wp_oembed_get_object();
											$url_video = $oembed->get_html($property_video_url);
											echo '<div class="fluid-width-video-wrapper">' . $url_video . '</div>';
										}
									}
								} else {

									include TEMPLATEPATH . '/lib/inc/template/property-slideshow.php';

									if ($property_image_location == 'begin' && $realty_theme_option['property-slideshow-navigation-type'] == 'thumbnail') {
										include TEMPLATEPATH . '/lib/inc/template/property-slideshow-thumbnails.php';
									}
								}
								?>

							</section>
							<?php } ?>

							<section id="property-content">
								<?php while (have_posts()) : the_post(); ?>
									<h3 class="section-title"><span><?php _e('Intro'); ?></span></h3>
									<?php the_content(); ?>
								<?php endwhile; // end of the loop. ?>
							</section>

							<?php if($car_price_prefix || $car_price || $car_type || $car_make || $car_model ||
								$car_year || $car_registration_date || $car_odometer || $car_next_inspection || $car_fuel_type ||
								$car_engine_power_hp || $car_engine_power_kw || $car_engine_size_cc || $car_co2_emission ||
								$car_tare_mass || $car_laden_mass || $car_transmission || $car_drive_type || $car_color ||
								$car_door_capacity || $car_seat_capacity || $car_rim_material) : ?>
							<section id="property-features" class="primary-tooltips">
								<h3 class="section-title"><span><?php _e('Properties'); ?></span></h3>
								<div class="row">
									<?php if (!empty($car_type)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Vehicle Type'); ?></h6>
											<p class="tinfotext"><?php echo $car_type[0]->name; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_make)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Vehicle Make'); ?></h6>
											<p class="tinfotext"><?php echo $car_make[0]->name; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_model)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Vehicle Model'); ?></h6>
											<p class="tinfotext"><?php echo $car_model[0]->name; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_year)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Manufacturing Year'); ?></h6>
											<p class="tinfotext"><?php echo $car_year; ?></p>
										</div>
									<?php endif; ?>
								</div>
								<div class="row">
									<?php if (!empty($car_engine_power_hp)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Engine Power - HP'); ?></h6>
											<p class="tinfotext"><?php echo $car_engine_power_hp; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_engine_power_kw)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Engine Power - Kw'); ?></h6>
											<p class="tinfotext"><?php echo $car_engine_power_kw; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_engine_size_cc)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Engine Size in cc'); ?></h6>
											<p class="tinfotext"><?php echo $car_engine_size_cc; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_co2_emission)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Co2 Emission'); ?></h6>
											<p class="tinfotext"><?php echo $car_co2_emission; ?></p>
										</div>
									<?php endif; ?>
								</div>
								<div class="row">
									<?php if (!empty($car_door_capacity)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Door Capacity'); ?></h6>
											<p class="tinfotext"><?php echo $car_door_capacity; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_door_capacity)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Seat Capacity'); ?></h6>
											<p class="tinfotext"><?php echo $car_door_capacity; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_tare_mass)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Tare Mass'); ?></h6>
											<p class="tinfotext"><?php echo $car_tare_mass; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_laden_mass)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Tare Mass'); ?></h6>
											<p class="tinfotext"><?php echo $car_laden_mass; ?></p>
										</div>
									<?php endif; ?>
								</div>
								<div class="row">
									<?php if (!empty($car_odometer)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Odometer'); ?></h6>
											<p class="tinfotext"><?php echo $car_odometer . ' ' . $car_odometer_suffix; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_fuel_type)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Fuel Type'); ?></h6>
											<p class="tinfotext"><?php echo $car_fuel_type[0]->name; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_transmission)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Transmission'); ?></h6>
											<p class="tinfotext"><?php echo $car_transmission; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_drive_type)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Wheel Drive'); ?></h6>
											<p class="tinfotext"><?php echo $car_drive_type; ?></p>
										</div>
									<?php endif; ?>
								</div>
								<div class="row">
									<?php if (!empty($car_color)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Color'); ?></h6>
											<div class="tcolor" style="background-color:<?php echo $car_color;?>"></div>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_next_inspection)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Next Inspection'); ?></h6>
											<p class="tinfotext"><?php echo $car_next_inspection; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_registration_date)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Registration Date'); ?></h6>
											<p class="tinfotext"><?php echo $car_registration_date; ?></p>
										</div>
									<?php endif; ?>
									<?php if (!empty($car_rim_material)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Rim Material'); ?></h6>
											<p class="tinfotext"><?php echo $car_rim_material; ?></p>
										</div>
									<?php endif; ?>
								</div>
								<div class="row">
									<?php if (!empty($car_price)) : ?>
										<div class="col-md-3">
											<h6 class="tinfo"><?php _e('Price'); ?></h6>
											<?php if($car_price == '-1' ) : ?>
												<p class="tinfotext">Price Upon Request</p>
											<?php else : ?>
												<p class="tinfotext"><?php echo $car_price_prefix . ' ' . number_format_i18n($car_price) . ' ' . $car_price_suffix; ?></p>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							</section>
							<?php endif; ?>

							<!--
                    <section id="additional-details">
                        <?php echo '<h3 class="section-title"><span>' . __('General Information') . '</span></h3>'; ?>
                        -->
							<!--
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#additional-0" aria-controls="additional-0" role="tab" data-toggle="tab">Additional information</a></li>
                                <li role="presentation"><a href="#additional-1" aria-controls="additional-1" role="tab" data-toggle="tab">Public Transportation</a></li>
                                <li role="presentation"><a href="#additional-2" aria-controls="additional-2" role="tab" data-toggle="tab">Neighborhood</a></li>
                                <li role="presentation"><a href="#additional-3" aria-controls="additional-3" role="tab" data-toggle="tab">Air Quality</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="additional-0">-</div>
                                <div role="tabpanel" class="tab-pane" id="additional-1">-</div>
                                <div role="tabpanel" class="tab-pane" id="additional-2">-</div>
                                <div role="tabpanel" class="tab-pane" id="additional-3">-</div>
                            </div>

                        </section>
                        -->

							<?php
							// Property Map
							if ($car_location || $google_maps) {
								get_template_part('lib/inc/template/google-map-single-car');
							}
							?>

							<?php
							// Property Social Sharing
							if ($social_sharing) {
								echo '<div class="primary-tooltips">' . tt_social_sharing() . '</div>';
							}
							?>


					</div><!-- #main-container -->

					<?php
					if ($if_show_agent_info == true && $show_agent_information) {

						// Property Settings: If "Assign Agent" Selected, Show His/Her Details, Instead Of "Post Auhor"
						if ($agent) {

							if ($property_title_agent) {
								echo '<h2 class="section-title"><span>' . __($property_title_agent, 'tt') . '</span></h2>';
							}

							$company_name = get_user_meta($agent, 'company_name', true);
							$first_name = get_user_meta($agent, 'first_name', true);
							$last_name = get_user_meta($agent, 'last_name', true);
							$email = get_userdata($agent);
							$email = $email->user_email;
							$office = get_user_meta($agent, 'office_phone_number', true);
							$mobile = get_user_meta($agent, 'mobile_phone_number', true);
							$fax = get_user_meta($agent, 'fax_number', true);
							$website = get_userdata($agent);
							$website = $website->user_url;
							$website_clean = str_replace(array('http://', 'https://'), '', $website);
							$bio = get_user_meta($agent, 'description', true);
							$profile_image = get_user_meta($agent, 'user_image', true);
							$author_profile_url = get_author_posts_url($agent);
							$facebook = get_user_meta($agent, 'custom_facebook', true);
							$twitter = get_user_meta($agent, 'custom_twitter', true);
							$google = get_user_meta($agent, 'custom_google', true);
							$linkedin = get_user_meta($agent, 'custom_linkedin', true);

						} else {

							$company_name = get_the_author_meta('company_name');
							$first_name = get_the_author_meta('first_name');
							$last_name = get_the_author_meta('last_name');
							$email = get_the_author_meta('user_email');
							$office = get_the_author_meta('office_phone_number');
							$mobile = get_the_author_meta('mobile_phone_number');
							$fax = get_the_author_meta('fax_number');
							$website = get_the_author_meta('user_url');
							$website_clean = str_replace(array('http://', 'https://'), '', $website);
							$bio = get_the_author_meta('description');
							$profile_image = get_the_author_meta('user_image');
							$author_profile_url = get_author_posts_url($post->post_author);
							$facebook = get_the_author_meta('custom_facebook');
							$twitter = get_the_author_meta('custom_twitter');
							$google = get_the_author_meta('custom_google');
							$linkedin = get_the_author_meta('custom_linkedin');

						}

						// Author/Agent Information
						if ($show_agent_information && $property_contact_information == "all") {
							if ($if_show_agent_info == true) {

								include TEMPLATEPATH . '/lib/inc/template/agent-information.php';

							} else {

								echo '<p class="alert alert-danger">' . __('You have to be logged-in to view agent details. Click Login/Register in the top menu.', 'tt') . '</p>';
								die;
							}
						} else {
							//echo '<p class="alert alert-danger">' . __( 'You have to be logged-in to view agent details. Click Login/Register in the top menu.', 'tt' ) . '</p>';
						}

					}
					?>
					<?php
					// Check Theme Option + Property Settings For Author Contact Form
					if ($show_property_contact_form && $property_contact_information != "none") {
						include TEMPLATEPATH . '/lib/inc/template/contact-form.php';
					}
					?>

					<script>
						jQuery(document).ready(function () {

							// Pause autoplay on slide hover, but not on mobile devices.
							var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
							if (isMobile) {
								var slideshowPauseHover = 'false';
							} else {
								var slideshowPauseHover = 'true';
							}

							// Property Carousel
							jQuery('#property-carousel').owlCarousel({
								items: 1,
								lazyLoad: true,
								loop: false,
								margin: 0,
								<?php if ( $realty_theme_option['property-slideshow-navigation-type'] == 'thumbnail' ) { ?>
								dots: false,
								nav: false,
								URLhashListener: true,
								<?php } else { ?>
								dots: true,
								nav: false,
								<?php } ?>
								navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
								autoHeight: false,
								autoplayTimeout: 3000,
								<?php if ( $realty_theme_option['property-single-slideshow-autoplay'] == true ) { ?>
								autoplay: true,
								autoplayHoverPause: slideshowPauseHover,
								<?php } ?>
								<?php if ( $realty_theme_option['property-slideshow-animation-type'] == 'fade' ) { ?>
								animateIn: 'fadeIn',
								animateOut: 'fadeOut',
								<?php } ?>
								<?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
								rtl: true,
								<?php } ?>
							});

							// Property Thumbnails Carousel
							jQuery('#property-thumbnails').owlCarousel({
								<?php if ( $realty_theme_option['enable-rtl-support'] || is_rtl() ) { ?>
								rtl: true,
								<?php } ?>
								items: 4,
								lazyLoad: false,
								loop: false,
								margin: 15,
								dots: false,
								nav: true,
								autoHeight: false,
								navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
								responsive: {
									0: {items: 2,},
									768: {items: 3,},
									1200: {items: 4,},
								},
							});

						});
					</script>
				</div><!-- .col-sm-9 -->
			</div><!-- .row -->
		</div>

	</div>

<?php get_footer(); ?>
