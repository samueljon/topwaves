<?php
/**
 * Created by PhpStorm.
 * User: samueljon
 * Date: 28/12/15
 * Time: 18:12
 */

function tw_agents( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'columns'		=> '4',
		'order'			=> 'DESC',
		'limit'         => '0',

	), $atts ) );

	global $realty_theme_option;
	ob_start();

	$all_agents = get_users( array(
		'fields' => 'ID',
		'order' => 'ASC',
		'orderby'=> 'registered',
		'include' => array( 2, 4, 6, 11 ))
	);
	?>

	<div class="row">
	<?php foreach( $all_agents as $agent ) :
		$company_name = get_user_meta( $agent, 'company_name', true );
		$first_name = get_user_meta( $agent, 'first_name', true );
		$last_name = get_user_meta( $agent, 'last_name', true );
		$jobdescription = get_user_meta($agent, 'jobdescription', true );
		$email = get_userdata( $agent );
		$email = $email->user_email;
		$office = get_user_meta( $agent, 'office_phone_number', true );
		$mobile = get_user_meta( $agent, 'mobile_phone_number', true );
		$fax = get_user_meta( $agent, 'fax_number', true );
		$website = get_userdata( $agent );
		$website = $website->user_url;
		$website_clean = str_replace( array( 'http://', 'https://' ), '', $website );
		$bio = get_user_meta( $agent, 'description', true );
		$profile_image = get_user_meta( $agent, 'user_image', true );
		$author_profile_url = get_author_posts_url( $agent );
		$facebook = get_user_meta( $agent, 'custom_facebook', true );
		$twitter = get_user_meta( $agent, 'custom_twitter', true );
		$google = get_user_meta( $agent, 'custom_google', true );
		$linkedin = get_user_meta( $agent, 'custom_linkedin', true );

		if ( $facebook || $twitter || $google || $linkedin || $website) {
			$no_socials = false;
		} else {
			$no_socials = true;
		}

		?>
			<div class="col-lg-3 col-sm-6">
				<div class="card hovercard">
					<div class="cardheader"></div>
					<div class="avatar">
						<?php
						if ( $profile_image ) {
							$profile_image_id = tt_get_image_id( $profile_image );
							$profile_image_array = wp_get_attachment_image_src( $profile_image_id, 'square-400' );
							echo '<img src="' . $profile_image_array[0] . '" alt="" />';
						}
						else {
							echo '<img src="//placehold.it/400x400/eee/ccc/&text=.." alt="" />';
						}
						?>
					</div>
					<div class="info">
						<div class="title">
							<?php
							if ( $first_name && $last_name ) {
								echo '<a target="_blank" href="' . $author_profile_url . '">' . $first_name . ' ' . $last_name . '</a>';
							}
							elseif ($first_name){
								echo '<a target="_blank" href="' . $author_profile_url . '">' . $first_name . '</a>';
							}
							?>
						</div>
						<?php if ( $jobdescription ) : ?><div class="desc"><?php echo $jobdescription; ?></div><?php endif; ?>
						<?php if ( $email && $realty_theme_option['show-agent-email']  ) : ?><div class="desc"><a href="mailto:<?php echo antispambot( $email ); ?>"><?php echo antispambot( $email ); ?></a></div><?php endif; ?>
						<?php if ( $office && $realty_theme_option['show-agent-office'] ) : ?><div class="desc"><?php echo $office; ?></div><?php endif; ?>
						<?php if ( $mobile && $realty_theme_option['show-agent-mobile'] ) : ?><div class="desc"><?php echo $mobile; ?></div><?php endif; ?>
					</div>
					<?php if(!$no_socials) : ?>
					<div class="bottom">
						<?php if (!empty($twitter)) : ?>
						<a class="btn btn-primary btn-twitter btn-sm" href="<?php print $twitter; ?>">
							<i class="fa fa-twitter"></i>
						</a>
						<?php endif; ?>
						<?php if (!empty($google)) : ?>
						<a class="btn btn-danger btn-sm" rel="publisher" href="<?php print $google; ?>">
							<i class="fa fa-google-plus"></i>
						</a>
						<?php endif; ?>
						<?php if (!empty($facebook)) : ?>
						<a class="btn btn-primary btn-sm" rel="publisher"
						   href="<?php print $facebook; ?>">
							<i class="fa fa-facebook"></i>
						</a>
						<?php endif; ?>
						<?php if (!empty($linkedin)) : ?>
						<a class="btn btn-warning btn-sm" rel="publisher" href="<?php print $linkedin; ?>">
							<i class="fa fa-linkedin"></i>
						</a>
						<?php endif; ?>
						<?php if (!empty($website)) : ?>
							<a class="btn btn-warning btn-sm" rel="publisher" href="<?php print $website; ?>">
								<i class="fa fa-link"></i>
							</a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>

			</div>
		<?php endforeach; //End Agent loop ?>
	</div> <!-- row -->
<?php
		return ob_get_clean();

}
add_shortcode('twagents', 'tw_agents');


/*-----------------------------------------------------------------------------------*/
/*  Property Listing
/*-----------------------------------------------------------------------------------*/

	function tw_vessel_listing( $atts, $content = null ) {
		global $realty_theme_option;
		$listing_view = $realty_theme_option['property-listing-default-view'];
		extract( shortcode_atts( array(
			'per_page'									=> '10',
			'columns'										=> '',
			'location'									=> '',
			'status'										=> '',
			'type'											=> '',
			'max_price'									=> '',
			'view'											=> '',
			'show_sorting_toggle_view' 	=> 'hide',
			'sort_by'         					=> 'date-new',
		), $atts ) );

		ob_start();

		// Property Sorting & View
		if ( $show_sorting_toggle_view == 'show' ) {
			echo tt_property_listing_sorting_and_view($sort_by);
		}
?>

	<div id="property-items" class="show-compare<?php echo ' ' . $view; ?>"  data-view="<?php if ( isset( $listing_view ) && $view=='' ) { echo $listing_view; }?>">

<?php
		get_template_part( 'lib/inc/template/property', 'comparison' );

		if ( ! $per_page ) {
			$per_page = 10;
		}

		// Property Query
		if ( is_front_page() ) {
			$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
		} else {
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		}

		$query_properties_args = array(
			'post_type' 			=> 'vessel',
			'posts_per_page' 	=> $per_page,
			'paged' 					=> $paged
		);

		/* TAX QUERIES:
============================== */
$tax_query = array();

if ( $status ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'vessel_status',
		'field' 		=> 'slug',
		'terms'			=> $status
	);
}

if ( $type ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'vessel_type',
		'field' 		=> 'slug',
		'terms'			=> $type
	);
}

// Count Taxonomy Queries + set their relation for search query
$tax_count = count( $tax_query );
if ( $tax_count > 1 ) {
	$tax_query['relation'] = 'AND';
}

$query_properties_args['tax_query'] = $tax_query;

		/* META QUERIES:
============================== */
$meta_query = array();

if( $max_price ) {
	$meta_query[] = array(
		'key' 			=> 'estate_property_price',
		'value' 		=> $max_price,
		'compare'		=> '<=',
		'type' 			=> 'NUMERIC',
	);
}

// Count Meta Queries + set their relation for search query
$meta_count = count( $meta_query );
if ( $meta_count > 1 ) {
	$meta_query['relation'] = 'AND';
}
if ( ! empty( $_GET[ 'order-by' ] ) ) {
	$orderby = $_GET[ 'order-by' ];
}
else {
	$orderby = $sort_by;
}

// By Date (Newest First)
if ( $orderby == 'date-new' ) {
	$query_properties_args['orderby'] = 'date';
	$query_properties_args['order'] = 'DESC';
}

// By Date (Oldest First)
if ( $orderby == 'date-old' ) {
	$query_properties_args['orderby'] = 'date';
	$query_properties_args['order'] = 'ASC';
}

// By Price (Highest First)
if ( $orderby == 'price-high' ) {
	$query_properties_args['meta_key'] = 'estate_property_price';
	$query_properties_args['orderby'] = 'meta_value_num';
	$query_properties_args['order'] = 'ASC';
}

// By Price (Lowest First)
if ( $orderby == 'price-low' ) {
	$query_properties_args['meta_key'] = 'estate_property_price';
	$query_properties_args['orderby'] = 'meta_value_num';
	$query_properties_args['order'] = 'ASC';
}

// By Name (Ascending)
if ( $orderby == 'name-asc' ) {
	$query_properties_args['orderby'] = 'title';
	$query_properties_args['order'] = 'ASC';
}

// By Name (Ascending)
if ( $orderby == 'name-desc' ) {
	$query_properties_args['orderby'] = 'title';
	$query_properties_args['order'] = 'DESC';
}
if ( $orderby == 'featured' ) {
	$query_properties_args['orderby'] = 'meta_value';
	$query_properties_args['order'] = 'DESC';
	$query_properties_args['meta_key'] = 'estate_property_featured';
}

if ( $orderby == 'random' ) {
	$query_properties_args['orderby'] = 'rand';
	$query_properties_args['order'] = '';
}

if ( $meta_count > 0 ) {
	$query_properties_args['meta_query'] = $meta_query;
}
$query_properties = new WP_Query( $query_properties_args );

if ( $query_properties->have_posts() ) :
?>
			<ul class="row list-unstyled">
<?php
	while ( $query_properties->have_posts() ) : $query_properties->the_post();

// Shortcode Columns Setting
if ( isset( $columns ) && $columns == "1" ) {
	echo '<li class="col-md-12">';
}
else if ( isset( $columns ) && $columns == "2" ) {
	echo '<li class="col-md-6">';
}
else if ( isset( $columns ) && $columns == "3" ) {
	echo '<li class="col-lg-4 col-md-6">';
}
else if ( isset( $columns ) && $columns == "4" ) {
	echo '<li class="col-lg-3 col-md-6">';
}
// Theme Options Columns Settings
else {
	global $realty_theme_option;
	$columns_theme_option = $realty_theme_option['property-listing-columns'];
	if ( empty($columns_theme_option) ) {
		echo '<li class="col-md-6">';
	}
	else {
		echo '<li class="' . $columns_theme_option . '">';
	}
}

get_template_part( 'lib/inc/template/vessel', 'item' );

echo '</li>';

endwhile;
?>
			</ul>
			<?php wp_reset_query(); ?>

			<div id="pagination">
<?php
// Built Property Pagination
$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#property-items',
	'format' 			=> '?page=%#%',
	'total' 			=> $query_properties->max_num_pages,
	//'show_all'		=> true,
	'end_size'    => 4,
	'mid_size'    => 2,
	'type'				=> 'list',
	'current'     => $paged,
	'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
	'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
) );
?>
			</div>

<?php
else:
?>
			<div>
				<p class="lead"><?php _e('No Properties Found.', 'tt') ?></p>
			</div>
<?php
endif;
?>

	</div><!-- #property-items -->
<?php
return ob_get_clean();
	}
add_shortcode('vessel_listing', 'tw_vessel_listing');

/**
 * Implements tw_equipment_listing.
 * @param $atts
 * @param null $content
 * @return string
 */
function tw_equipment_listing( $atts, $content = null ) {
	global $realty_theme_option;
	$listing_view = $realty_theme_option['property-listing-default-view'];
	extract( shortcode_atts( array(
		'per_page'									=> '10',
		'columns'										=> '',
		'location'									=> '',
		'status'										=> '',
		'type'											=> '',
		'features'									=> '',
		'max_price'									=> '',
		'min_rooms'									=> '',
		'available_from'						=> '',
		'view'											=> '',
		'show_sorting_toggle_view' 	=> 'hide',
		'sort_by'         					=> 'date-new',
	), $atts ) );

	ob_start();

	// Property Sorting & View
	if ( $show_sorting_toggle_view == 'show' ) {
		echo tt_property_listing_sorting_and_view($sort_by);
	}
?>

	<div id="property-items" class="show-compare<?php echo ' ' . $view; ?>"  data-view="<?php if ( isset( $listing_view ) && $view=='' ) { echo $listing_view; }?>">

<?php
	get_template_part( 'lib/inc/template/property', 'comparison' );

	if ( ! $per_page ) {
		$per_page = 10;
	}

	// Property Query
	if ( is_front_page() ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	} else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}

	$query_properties_args = array(
		'post_type' 			=> 'equipment',
		'posts_per_page' 	=> $per_page,
		'paged' 					=> $paged
	);

		/* TAX QUERIES:
============================== */
$tax_query = array();

if ( $location ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'property-location',
		'field' 		=> 'slug',
		'terms'			=> $location
	);
}

if ( $status ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'property-status',
		'field' 		=> 'slug',
		'terms'			=> $status
	);
}

if ( $type ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'equipment_type',
		'field' 		=> 'slug',
		'terms'			=> $type
	);
}

if ( $features ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'property-features',
		'field' 		=> 'slug',
		'terms'			=> explode( ',', $features ),
		'operator'	=> 'AND'
	);
}

// Count Taxonomy Queries + set their relation for search query
$tax_count = count( $tax_query );
if ( $tax_count > 1 ) {
	$tax_query['relation'] = 'AND';
}

$query_properties_args['tax_query'] = $tax_query;

		/* META QUERIES:
============================== */
$meta_query = array();

if( $max_price ) {
	$meta_query[] = array(
		'key' 			=> 'estate_property_price',
		'value' 		=> $max_price,
		'compare'		=> '<=',
		'type' 			=> 'NUMERIC',
	);
}

if( $min_rooms ) {
	$meta_query[] = array(
		'key' 			=> 'estate_property_rooms',
		'value' 		=> $min_rooms,
		'compare'		=> '>=',
		'type' 			=> 'NUMERIC',
	);
}

if( $available_from ) {
	$meta_query[] = array(
		'key' 			=> 'estate_property_available_from',
		'value' 		=> $available_from,
		'compare'		=> '<=',
		'type' 			=> 'NUMERIC',
	);
}

// Count Meta Queries + set their relation for search query
$meta_count = count( $meta_query );
if ( $meta_count > 1 ) {
	$meta_query['relation'] = 'AND';
}
if ( ! empty( $_GET[ 'order-by' ] ) ) {
	$orderby = $_GET[ 'order-by' ];
}
else {
	$orderby = $sort_by;
}

// By Date (Newest First)
if ( $orderby == 'date-new' ) {
	$query_properties_args['orderby'] = 'date';
	$query_properties_args['order'] = 'DESC';
}

// By Date (Oldest First)
if ( $orderby == 'date-old' ) {
	$query_properties_args['orderby'] = 'date';
	$query_properties_args['order'] = 'ASC';
}

// By Price (Highest First)
if ( $orderby == 'price-high' ) {
	$query_properties_args['meta_key'] = 'estate_property_price';
	$query_properties_args['orderby'] = 'meta_value_num';
	$query_properties_args['order'] = 'ASC';
}

// By Price (Lowest First)
if ( $orderby == 'price-low' ) {
	$query_properties_args['meta_key'] = 'estate_property_price';
	$query_properties_args['orderby'] = 'meta_value_num';
	$query_properties_args['order'] = 'ASC';
}

// By Name (Ascending)
if ( $orderby == 'name-asc' ) {
	$query_properties_args['orderby'] = 'title';
	$query_properties_args['order'] = 'ASC';
}

// By Name (Ascending)
if ( $orderby == 'name-desc' ) {
	$query_properties_args['orderby'] = 'title';
	$query_properties_args['order'] = 'DESC';
}
if ( $orderby == 'featured' ) {
	$query_properties_args['orderby'] = 'meta_value';
	$query_properties_args['order'] = 'DESC';
	$query_properties_args['meta_key'] = 'estate_property_featured';
}

if ( $orderby == 'random' ) {
	$query_properties_args['orderby'] = 'rand';
	$query_properties_args['order'] = '';
}

if ( $meta_count > 0 ) {
	$query_properties_args['meta_query'] = $meta_query;
}
$query_properties = new WP_Query( $query_properties_args );

if ( $query_properties->have_posts() ) :
?>
			<ul class="row list-unstyled">
<?php
	while ( $query_properties->have_posts() ) : $query_properties->the_post();

// Shortcode Columns Setting
if ( isset( $columns ) && $columns == "1" ) {
	echo '<li class="col-md-12">';
}
else if ( isset( $columns ) && $columns == "2" ) {
	echo '<li class="col-md-6">';
}
else if ( isset( $columns ) && $columns == "3" ) {
	echo '<li class="col-lg-4 col-md-6">';
}
else if ( isset( $columns ) && $columns == "4" ) {
	echo '<li class="col-lg-3 col-md-6">';
}
// Theme Options Columns Settings
else {
	global $realty_theme_option;
	$columns_theme_option = $realty_theme_option['property-listing-columns'];
	if ( empty($columns_theme_option) ) {
		echo '<li class="col-md-6">';
	}
	else {
		echo '<li class="' . $columns_theme_option . '">';
	}
}

get_template_part( 'lib/inc/template/equipment', 'item' );

echo '</li>';

endwhile;
?>
			</ul>
			<?php wp_reset_query(); ?>

			<div id="pagination">
<?php
// Built Property Pagination
$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#property-items',
	'format' 			=> '?page=%#%',
	'total' 			=> $query_properties->max_num_pages,
	//'show_all'		=> true,
	'end_size'    => 4,
	'mid_size'    => 2,
	'type'				=> 'list',
	'current'     => $paged,
	'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
	'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
) );
?>
			</div>

<?php
else:
?>
			<div>
				<p class="lead"><?php _e('No Properties Found.', 'tt') ?></p>
			</div>
<?php
endif;
?>

	</div><!-- #property-items -->
<?php
return ob_get_clean();
}
add_shortcode('equipment_listing', 'tw_equipment_listing');

/**
 * Car Listing Short Code.
 *
 * @param $atts
 * @param null $content
 * @return string
 */
function tw_car_listing( $atts, $content = null ) {
	global $realty_theme_option;
	$listing_view = $realty_theme_option['property-listing-default-view'];
	extract(shortcode_atts(array(
		'per_page' 		=> '10',
		'columns' 		=> '',
		'location' 		=> '',
		'status' 		=> '',
		'type' 			=> '',
		'make' 			=> '',
		'model' 		=> '',
		'fuel' 			=> '',
		'max_price'		=> '',
		'view' 			=> '',
		'show_sorting_toggle_view' => 'hide',
		'sort_by' 		=> 'date-new',
	), $atts));

	ob_start();

	// Property Sorting & View
	if ( $show_sorting_toggle_view == 'show' ) {
		echo tt_property_listing_sorting_and_view($sort_by);
	}
?>

	<div id="property-items" class="show-compare<?php echo ' ' . $view; ?>"  data-view="<?php if ( isset( $listing_view ) && $view=='' ) { echo $listing_view; }?>">

<?php
	get_template_part( 'lib/inc/template/property', 'comparison' );

	if ( ! $per_page ) {
		$per_page = 10;
	}

	// Property Query
	if ( is_front_page() ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	} else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}

	$query_properties_args = array(
		'post_type' 			=> 'car',
		'posts_per_page' 	=> $per_page,
		'paged' 					=> $paged
	);

		/* TAX QUERIES:
============================== */
$tax_query = array();

if ( $type ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'car_type',
		'field' 		=> 'slug',
		'terms'			=> $type
	);
}

if ( $make ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'car_make',
		'field' 		=> 'slug',
		'terms'			=> $make,
	);
}

if ( $model ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'car_type',
		'field' 		=> 'slug',
		'terms'			=> $model,
	);
}

if ( $fuel ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'car_fuel',
		'field' 		=> 'slug',
		'terms'			=> $fuel,
	);
}

if ( $status ) {
	$tax_query[]	= array(
		'taxonomy' 	=> 'car_status',
		'field' 		=> 'slug',
		'terms'			=> $status,
	);
}

// Count Taxonomy Queries + set their relation for search query
$tax_count = count( $tax_query );
if ( $tax_count > 1 ) {
	$tax_query['relation'] = 'AND';
}

$query_properties_args['tax_query'] = $tax_query;

		/* META QUERIES:
============================== */
$meta_query = array();

if( $max_price ) {
	$meta_query[] = array(
		'key' 			=> 'estate_property_price',
		'value' 		=> $max_price,
		'compare'		=> '<=',
		'type' 			=> 'NUMERIC',
	);
}


// Count Meta Queries + set their relation for search query
$meta_count = count( $meta_query );
if ( $meta_count > 1 ) {
	$meta_query['relation'] = 'AND';
}
if ( ! empty( $_GET[ 'order-by' ] ) ) {
	$orderby = $_GET[ 'order-by' ];
}
else {
	$orderby = $sort_by;
}

// By Date (Newest First)
if ( $orderby == 'date-new' ) {
	$query_properties_args['orderby'] = 'date';
	$query_properties_args['order'] = 'DESC';
}

// By Date (Oldest First)
if ( $orderby == 'date-old' ) {
	$query_properties_args['orderby'] = 'date';
	$query_properties_args['order'] = 'ASC';
}

// By Price (Highest First)
if ( $orderby == 'price-high' ) {
	$query_properties_args['meta_key'] = 'estate_property_price';
	$query_properties_args['orderby'] = 'meta_value_num';
	$query_properties_args['order'] = 'ASC';
}

// By Price (Lowest First)
if ( $orderby == 'price-low' ) {
	$query_properties_args['meta_key'] = 'estate_property_price';
	$query_properties_args['orderby'] = 'meta_value_num';
	$query_properties_args['order'] = 'ASC';
}

// By Name (Ascending)
if ( $orderby == 'name-asc' ) {
	$query_properties_args['orderby'] = 'title';
	$query_properties_args['order'] = 'ASC';
}

// By Name (Ascending)
if ( $orderby == 'name-desc' ) {
	$query_properties_args['orderby'] = 'title';
	$query_properties_args['order'] = 'DESC';
}
if ( $orderby == 'featured' ) {
	$query_properties_args['orderby'] = 'meta_value';
	$query_properties_args['order'] = 'DESC';
	$query_properties_args['meta_key'] = 'estate_property_featured';
}

if ( $orderby == 'random' ) {
	$query_properties_args['orderby'] = 'rand';
	$query_properties_args['order'] = '';
}

if ( $meta_count > 0 ) {
	$query_properties_args['meta_query'] = $meta_query;
}
$query_properties = new WP_Query( $query_properties_args );

if ( $query_properties->have_posts() ) :
?>
			<ul class="row list-unstyled">
<?php
	while ( $query_properties->have_posts() ) : $query_properties->the_post();

// Shortcode Columns Setting
if ( isset( $columns ) && $columns == "1" ) {
	echo '<li class="col-md-12">';
}
else if ( isset( $columns ) && $columns == "2" ) {
	echo '<li class="col-md-6">';
}
else if ( isset( $columns ) && $columns == "3" ) {
	echo '<li class="col-lg-4 col-md-6">';
}
else if ( isset( $columns ) && $columns == "4" ) {
	echo '<li class="col-lg-3 col-md-6">';
}
// Theme Options Columns Settings
else {
	global $realty_theme_option;
	$columns_theme_option = $realty_theme_option['property-listing-columns'];
	if ( empty($columns_theme_option) ) {
		echo '<li class="col-md-6">';
	}
	else {
		echo '<li class="' . $columns_theme_option . '">';
	}
}

get_template_part( 'lib/inc/template/car', 'item' );

echo '</li>';

endwhile;
?>
			</ul>
			<?php wp_reset_query(); ?>

			<div id="pagination">
<?php
// Built Property Pagination
$big = 999999999; // need an unlikely integer

echo paginate_links( array(
	'base' 				=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ) . '#property-items',
	'format' 			=> '?page=%#%',
	'total' 			=> $query_properties->max_num_pages,
	//'show_all'		=> true,
	'end_size'    => 4,
	'mid_size'    => 2,
	'type'				=> 'list',
	'current'     => $paged,
	'prev_text' 	=> __( '<i class="btn btn-default fa fa-angle-left"></i>', 'tt' ),
	'next_text' 	=> __( '<i class="btn btn-default fa fa-angle-right"></i>', 'tt' ),
) );
?>
			</div>

<?php
else:
?>
			<div>
				<p class="lead"><?php _e('No Properties Found.', 'tt') ?></p>
			</div>
<?php
endif;
?>

	</div><!-- #property-items -->
<?php
return ob_get_clean();
}
add_shortcode('car_listing', 'tw_car_listing');

/**
 * Implements support for svg images in wordpress.
 * @param $mimes
 * @return mixed
 */
function topwaves_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'topwaves_mime_types');

/**
 * Adds field to user profile.
 *
 * @param $profile_fields
 * @return mixed
 */
function modify_contact_methods($profile_fields) {

	// Add new fields
	$profile_fields['jobdescription'] = 'Job Description';
	return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');
