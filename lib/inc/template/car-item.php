<?php
$property_type = get_the_terms( $post->ID, 'property-type' );
$property_status = get_the_terms( $post->ID, 'property-status' );
$property_location = get_the_terms( $post->ID, 'property-location' );
$property_featured = get_post_meta( $post->ID, 'estate_property_featured', true );
$property_status_update = get_post_meta( $post->ID, 'estate_property_status_update', true );
$google_maps = get_post_meta( $post->ID, 'estate_property_google_maps', true );
$address = '';
if ( !tt_is_array_empty( $google_maps) ) {
	$address = $google_maps['address'];
}
$size = get_post_meta( $post->ID, 'estate_property_size', true );
$size_unit = get_post_meta( $post->ID, 'estate_property_size_unit', true );
$rooms = get_post_meta( $post->ID, 'estate_property_rooms', true );
$bedrooms = get_post_meta( $post->ID, 'estate_property_bedrooms', true );
$bathrooms = get_post_meta( $post->ID, 'estate_property_bathrooms', true );
$last_updated_on=date_i18n(get_option( 'date_format' ),strtotime($post->post_modified));

// Minimal Information
$vessel_length = get_field('vessel_length');
$car_type = get_field('car_type');
$car_make = get_field('car_make');
$car_model = get_field('car_model');
$vessel_location = get_field('estate_property_google_maps');
$vessel_built = get_field('vessel_built');
$vessel_material = get_field('vessel_material');

global $realty_theme_option;
?>
<div class="property-item primary-tooltips<?php if ( $property_featured && $realty_theme_option['property-featured-listing-layout']!='featured-tag-view') { echo ' featured'; } echo ' ' . $realty_theme_option['property-listing-title-position']; ?>">

	<a href="<?php echo get_permalink($post->ID); ?>">
		
		<?php if ($realty_theme_option['property-listing-title-position'] == 'title-above-image') { ?>
		<div class="property-title">
			<?php if ( $property_featured && $realty_theme_option['property-featured-listing-layout'] != 'featured-title-view' ) { ?>
			<div class="property-tag tag-left">
				<i class="fa fa-star"></i>
			</div>
			<?php } ?>
			<h3 class="title"><?php the_title(); ?></h3>
			<h4 class="address"><?php echo $address; ?></h4>
		</div>
		
		<?php } ?>
		
		<figure class="property-thumbnail">
			<?php 
			$columns = $realty_theme_option['property-listing-columns'];
			
			// Use A Different Thumbnail Dimension For 4 Column Grid
			if ( $columns == "col-lg-3 col-md-6" ) {
				if ( has_post_thumbnail() ) { 
					the_post_thumbnail( 'thumbnail-400-300' );
				}	
				else {
					echo '<img src ="//placehold.it/400x300/eee/ccc/&text=.." />';
				}
			}
			// Default Property Thumbnail Dimension
			else {
				if ( has_post_thumbnail() ) { 
					the_post_thumbnail( 'property-thumb' );
				}	
				else {
					echo '<img src ="//placehold.it/600x300/eee/ccc/&text=.." />';
				}
			}
			
			if ( $property_status_update && $realty_theme_option['property-listing-status-tag'] ) { ?>
			<div class="property-tag tag-right">
				<?php echo $property_status_update; ?>
			</div>
			<?php } ?>
			<figcaption>
			
				<div class="property-excerpt">
					<?php 
					if ( $property_type || $property_status || $property_location ) { 
						$property_meta = array();
					?>
					<div class="subtitle hide">
						<?php 
						if ( $property_type ) { 
							foreach ( $property_type as $type ) { 
								$property_meta[] = '<span class="type">' . $type->name . '</span>'; break; 
							} 
						}
						if ( $property_status ) { 
							foreach ( $property_status as $status ) { 
								$property_meta[] = '<span class="status">' . $status->name . '</span>'; break; 
							} 
						}
						/*
						if ( $property_location ) {
							foreach ( $property_location as $location ) { 
								$property_meta[] = '<span class="location">' . $location->name . '</span>'; break; 
							} 
						}
						*/
						echo join( ' <span>&middot</span> ', $property_meta );
						?>
					</div>
					<?php } ?>
					
					<?php the_excerpt(); ?>
				</div>
				
				<?php if ( $realty_theme_option['property-listing-title-position'] != 'title-above-image' ) { ?>
				<div class="property-title">
					<h3 class="title"><?php the_title(); ?></h3>
					<h4 class="address"><?php echo $address; ?></h4>
				</div>
				<?php if ( $property_featured && $realty_theme_option['property-featured-listing-layout'] != 'featured-title-view' ) { ?>
				<div class="property-tag tag-left">
					<i class="fa fa-star"></i>
				</div>
				<?php } ?>
				<?php if ( $property_status_update && $realty_theme_option['property-listing-status-tag'] ) { ?>
				<div class="property-tag tag-right">
					<?php echo $property_status_update; ?>
				</div>
				<?php } ?>
				<?php } ?>
				
			</figcaption>
		</figure>
	</a>
	
	<div class="property-content">
		<?php 
		// Default Listing Fields
		if ( $realty_theme_option['property-listing-type'] != "custom" && ( $car_type||$car_make||$car_model ) ) { ?>
		<div class="property-meta clearfix">
			<?php
			if ( ! empty( $car_type ) ) { ?>
				<div>
					<div class="meta-title"><i class="fa fa-expand"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Vehicle Type' ); ?>">
                        <?php
                        $term = $car_type[0];
                        echo $term->name; ?>
                    </div>
				</div>
			<?php }
			if ( ! empty( $car_make ) ) { ?>
				<div>
					<div class="meta-title"><i class="fa fa-calendar-o"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Vehicle Make' ); ?>">
                        <?php
                        $term = get_term( $car_make[0] , 'car_make' );
                        echo $term->name; ?>
                    </div>
				</div>
			<?php }
			if ( ! empty( $car_model ) ) { ?>
				<div>
					<div class="meta-title"><i class="fa fa-wrench"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php echo __( 'Vehicle Model' ); ?>">
                        <?php
                        $term = $car_model[0];
                        echo $term->name; ?>
                        </div>
				</div>
			<?php } ?>
		</div>
		<?php 
		}
		// Use Custom Listing Fields
		if ( $realty_theme_option['property-listing-type'] == "custom" ) { ?>
		<div class="property-meta clearfix">
			<?php
			$property_custom_listing_field = $realty_theme_option['property-custom-listing-field'];
			$property_custom_listing_icon_class = $realty_theme_option['property-custom-listing-icon-class'];
			$property_custom_listing_label = $realty_theme_option['property-custom-listing-label'];
			$property_custom_listing_label_plural = $realty_theme_option['property-custom-listing-label-plural'];
			$property_custom_listing_tooltip = $realty_theme_option['property-custom-listing-tooltip'];

			$i = 0;
			
			foreach ( $property_custom_listing_field as $field_type ) {
				
				$field = get_post_meta( $post->ID, $field_type, true );
				
				if ( $field_type == "estate_property_available_from" ) {
					$field = date_i18n(get_option( 'date_format' ),strtotime($field));
				}
				if ( $field_type == "estate_property_updated" ) {
					$field = $last_updated_on;
				}
				if ( $field_type == "estate_property_views" ) {
					$field = tt_get_property_views($post->ID);
				}
				if ( $field_type == "estate_property_size" ) {
					$size_unit = get_post_meta( $post->ID, 'estate_property_size_unit', true );
					$field = $field . ' ' . $size_unit;
				}
				if ( $field_type == "estate_property_id" ) {
					if ( $realty_theme_option['property-id-type'] == "post_id" ) {
						$field = $post->ID;
					}
					else {
						$field = get_post_meta( $post->ID, 'estate_property_id', true );
					}
				}
				?>
				
				<div>
					<div class="meta-title"><i class="fa <?php echo $property_custom_listing_icon_class[$i]; ?>"></i></div>
					<div class="meta-data" data-toggle="tooltip" title="<?php echo _n( __( $property_custom_listing_label[$i], 'tt' ), __( $property_custom_listing_label_plural[$i], 'tt' ), $field, 'tt' ); ?>">
						<?php
						echo $field;
						if ( $property_custom_listing_tooltip[$i] == false ) {
							echo ' ' . _n( __( $property_custom_listing_label[$i], 'tt' ), __( $property_custom_listing_label_plural[$i], 'tt' ), $field, 'tt' );
						}
						?>
					</div>
				</div>
				
				<?php 
				$i++;
			}
		?>
		</div>
		<?php }	?>
		
		<div class="property-price">
			<?php 
			if ( $property_status_update || $property_status ) {			
				if ( $property_status_update ) {
					echo '<span class="property-status" data-toggle="tooltip" title="' . __( 'Status', 'tt' ) . '">' . __( $property_status_update, 'tt' ) . '</span>';
				}
				else {
					if ( $property_status ) { 
						foreach ( $property_status as $status ) { 
							echo '<span class="property-status" data-toggle="tooltip" title="' . __( 'Status', 'tt' ) . '">' . $status->name . '</span>';
							break;
						} 
					}	
				}			
			}

			// Property Icons

			if ( $realty_theme_option['enable-social-on-listing'] ){
				$encode_url = urlencode(get_permalink());
				$encode_title = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
				?>
				<div class="share-unit" style="display: none;">
					<a class="social-facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $encode_url; ?>&amp;t=<?php echo $encode_title; ?>"><i class="fa fa-facebook"></i></a>
					<a target="_blank" class="social-twitter" href="http://twitter.com/home?status=<?php echo $encode_title; ?>+<?php echo $encode_url; ?>"><i class="fa fa-twitter"></i></a>
					<a class="social-google" target="_blank" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i></a> 
					<a class="social-pinterest" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;description=<?php echo $encode_url; ?>"><i class="fa fa-pinterest-p"></i></a>
				</div>
				<i class="fa fa-share-alt share-property" data-toggle="tooltip" data-original-title="<?php _e( 'Share', 'tt' ) ?>" title="<?php _e( 'Share', 'tt' ) ?>"></i>
				<?php
			}
			
			// echo tt_icon_property_featured();
			if ( get_post_status( $post->ID ) == "publish" ) {
				echo tt_icon_new_property();
				echo tt_add_remove_favorites();
			}
			echo tt_icon_property_video();
			
			$disable_property_comparison = $realty_theme_option['property-comparison-disabled'];
			
			if ( get_post_status($post->ID) == "publish" && ! $disable_property_comparison ) {
				echo '<i class="fa fa-plus compare-property" data-compare-id="' . get_the_ID() . '" data-toggle="tooltip" title="' . __( 'Compare', 'tt' ) . '"></i>'; 
			}
			
			// Property Submit Listing
			if ( is_user_logged_in() && is_page_template( 'template-property-submit-listing.php' ) ) { ?>
				<a href="<?php the_permalink(); ?>"><i class="fa fa-pencil" data-toggle="tooltip" title="<?php _e( 'Edit Property', 'tt' ); ?>"></i></a>
				<?php if ( get_post_status($post->ID) == "publish" ) { ?>
					<a href="<?php echo get_the_permalink(); ?>" target="_blank"><i class="fa fa-check" data-toggle="tooltip" title="<?php _e( 'Published', 'tt' ); ?>"></i></a>
					<?php 
					$paypal_payment_status = get_post_meta( $post->ID, 'property_payment_status', true );				
					if ( isset( $paypal_payment_status ) && $paypal_payment_status == "Completed" ) {
						echo '<i class="fa fa-usd" data-toggle="tooltip" title="' . __( 'Paid', 'tt' ) . '"></i>';
					}
					echo '<a href="#" class="delete-property" data-property-id="' . $post->ID . '"><i class="fa fa-trash" data-toggle="tooltip" title="' . __( 'Delete Property', 'tt' ) . '"></i></a>';
				}
				else if ( get_post_status($post->ID) == "draft" ) { ?>
				<a href="<?php echo the_permalink(); ?>" target="_blank"><i class="fa fa-eye" data-toggle="tooltip" title="<?php _e( 'Draft', 'tt' ); ?>"></i></a>
				<?php 
				echo '<a href="#" class="delete-property" data-property-id="' . $post->ID . '"><i class="fa fa-trash" data-toggle="tooltip" title="' . __( 'Delete Property', 'tt' ) . '"></i></a>';
				}
				else if ( get_post_status($post->ID) == "pending" ) { ?>
          <a href="<?php echo the_permalink(); ?>" target="_blank"><i class="fa fa-clock-o" data-toggle="tooltip" title="<?php _e( 'Pending', 'tt' ); ?>"></i></a>
          <?php
          echo '<a href="#" class="delete-property" data-property-id="' . $post->ID . '"><i class="fa fa-trash" data-toggle="tooltip" title="' . __( 'Delete Property', 'tt' ) . '"></i></a>';
          echo tt_paypal_payment_button( $post->ID);
                    
					if ( $realty_theme_option['enable-stripe-payments'] ) {
						echo '<div class="price-tag">';
						tt_stripe_payment_form($post->ID);
						echo '</div><div class="clearfix"></div>';
					}
				}
				?>
			<?php }	?>
			<div class="price-tag"><?php echo tt_property_price(); ?></div>
			<div class="clearfix"></div>
		</div>
	</div>
	
</div>