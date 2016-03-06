<?php
if(empty($property_images)){

}
?>
<div class="property-image-container <?php if ( ! $property_images ) { echo 'single '; } echo $realty_theme_option['property-image-height'] . ' ' . $fit_or_cut; ?>">

<!--	<div class="spinner">
	  <div class="bounce1"></div>
	  <div class="bounce2"></div>
	  <div class="bounce3"></div>
	</div>-->
	<div id="property-carousel">
		<?php
		$i = 1;

		// Property Video
		if ( $property_video_provider != 'none' && $property_video_id ) {

			if ( ( $property_image_location == 'above' && $property_video_location == 'above' ) || ( $property_image_location == 'begin' && $property_video_location == 'begin' ) ) {
				if ( $property_video_provider == 'youtube' ) {
					if ( is_ssl() ) {
						$property_video_url = 'https://youtube.com/watch?v=' . $property_video_id;
					}
					else {
						$property_video_url = 'http://youtube.com/watch?v=' . $property_video_id;
					}
				}

				if ( $property_video_provider == 'vimeo' ) {
					if ( is_ssl() ) {
						$property_video_url = 'https://player.vimeo.com/video/' . $property_video_id;
					}
					else {
						$property_video_url = 'http://player.vimeo.com/video/' . $property_video_id;
					}
				}
				require_once( ABSPATH . WPINC . '/class-oembed.php' );
				$oembed = _wp_oembed_get_object();
				$url_video=$oembed->get_html( $property_video_url);
				echo '<div class="fluid-width-video-wrapper" data-hash="slide'. $i .'">'. $url_video . '</div>';

				$i++;
			}

		}

		// Gallery Images
		if ( $property_images ) {

			$args = array(
				'post_type' => 'attachment',
				'orderby' => 'post__in',
				'post__in' => $property_images,
				'posts_per_page' => count($property_images)
			);

			$gallery_array = get_posts( $args );
			$main_images = wp_get_attachment_image_src( $gallery_array[0]->ID, $property_image_width );
			$main_images_url = $main_images[0];

			foreach ($gallery_array as $slide) {
				$attachment = wp_get_attachment_image_src( $slide->ID, $property_image_width );
				$attachment_url = $attachment[0];

				if ( $realty_theme_option['property-image-height'] == "original" ) {
					echo '<img data-src="' . $attachment_url . '" alt="" data-mfp-src="' . $attachment_url . '" class="owl-lazy property-image' . $property_zoom . '" title="' . $slide->post_title . '" data-title="' . $slide->post_title . '" data-hash="slide'. $i .'" />';
				} else {
					echo '<div data-src="' . $attachment_url . '" data-image="' . $attachment_url . '" data-mfp-src="' . $attachment_url . '" class="owl-lazy property-image' . $property_zoom . '" title="' . $slide->post_title . '" data-title="' . $slide->post_title . '" data-hash="slide'. $i .'"></div>';
				}

				$i++;
			}

		}

		// Featured Image Only
		else {

			if ( has_post_thumbnail() ) {

				$thumbnail_url_array = wp_get_attachment_image_src(get_post_thumbnail_id(), $property_image_width, true);
				$thumbnail_url = $thumbnail_url_array[0];

				if ( $realty_theme_option['property-image-height'] != "original" ) {
					echo '<div class="property-image' . $property_zoom . '" style="background-image:url(' . $thumbnail_url . ')" data-title="' . wp_get_attachment_meta_data_title() . '" data-image="' . wp_get_attachment_url( get_post_thumbnail_id() ) . '" data-mfp-src="' . wp_get_attachment_url( get_post_thumbnail_id() ) . '" title="' . wp_get_attachment_meta_data_title() . '" data-hash="slide'. $i .'"></div>';
				}

				if ( $realty_theme_option['property-image-height'] == "original" ) {

					$thumbnail_attr = array(
						'class' => 'property-image owl-lazy',
						'title' => wp_get_attachment_meta_data_title(),
						'data-image' => wp_get_attachment_url( get_post_thumbnail_id() ),
						'data-title' => wp_get_attachment_meta_data_title(),
						'data-mfp-src' => wp_get_attachment_url( get_post_thumbnail_id() ),
						'data-src' => wp_get_attachment_url( get_post_thumbnail_id() ),
						'data-hash' => 'slide'. $i,
					);

					the_post_thumbnail( $property_image_width, $thumbnail_attr );

				}

			}

			$i++;

		}
		?>
	</div><!-- #property-carousel -->

</div><!-- .property-image-container -->
