<?php
function tt_google_maps_api_single_property() {

global $post, $realty_theme_option;
$property_id = $post->ID;

// Check For Property Submit Page Template
if ( is_page_template( 'template-property-submit.php' ) && isset( $_GET['edit'] ) && ! empty( $_GET['edit'] ) ) {
	$property_id = $_GET['edit'];
}
$google_maps = get_post_meta( $property_id, 'eq_location', true );

if ( ! empty( $google_maps ) ) {
	$address = $google_maps['address'];
	if ( $google_maps['lat'] ) {
		$address_latitude = $google_maps['lat'];
  } else {
		$address_latitude = '51.5286416';
	}
	if ( $google_maps['lng'] ) {
		$address_longitude = $google_maps['lng'];
	} else {
		$address_longitude = '-0.1015987';
	}
}

if ( has_post_thumbnail( $property_id ) ) {
	$property_thumbnail = get_the_post_thumbnail( $property_id, 'property-thumb' );
}	else {
	$property_thumbnail = '<img src="//placehold.it/300x150/eee/ccc/&text=.." />';
}

if ( empty( $realty_theme_option['property-submit-default-address-latitude'] ) ) {
	$latitude = '51.5286416';
} else {
	$latitude = $realty_theme_option['property-submit-default-address-latitude'];
}

if ( empty( $realty_theme_option['property-submit-default-address-longitude'] ) ) {
	$longitude = '-0.1015987';
} else {
	$longitude = $realty_theme_option['property-submit-default-address-longitude'];
}
?>

<script>
var map, marker;

function initMap() {

	var mapOptions = {
	  center: new google.maps.LatLng( <?php echo $latitude . ',' . $longitude; ?>),
	  zoom: 12,
	  scrollwheel: false,
	  streetViewControl: true,
		disableDefaultUI: true
	};

	map = new google.maps.Map(document.getElementById('google-map'), mapOptions);
	<?php
	global $realty_theme_option;
	if ( $realty_theme_option['style-your-map'] == true ) { ?>
		if (map_options.map_style!=='') {
			var styles = JSON.parse(map_options.map_style);
			map.setOptions( { styles: styles } );
		}
	<?php } ?>
    <?php echo tt_mapMarkers(); ?>
	var marker = new google.maps.Marker({
    map: map,
    position: new google.maps.LatLng( <?php echo $latitude . ',' . $longitude; ?>),
    icon: customIcon,
    title: '<?php the_title(); ?>',
		<?php if ( is_page_template( 'template-property-submit.php' ) ) { ?>
    draggable: true
		<?php } ?>
  });

	var propertyThumbnail = '<?php echo $property_thumbnail; ?>';
	var propertyThumbnail=propertyThumbnail.replace(/'/g, '&quot;');
	<?php if($realty_theme_option['price-thousands-separator']=="'") { ?>
    			var propertyPrice = "<?php echo tt_property_price(); ?>";
	<?php } else { ?>
				var propertyPrice = '<?php echo tt_property_price(); ?>';
	<?php } ?>
    var propertyPrice=propertyPrice.replace(/'/g, '&quot;');
    var propertyTitle = '<?php echo '<h5 class="title">'. get_the_title( $property_id ) . '</h5>'; ?>';
    var propertyTitle=propertyTitle.replace(/'/g, '&quot;');
	// http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/docs/reference.html
	var infobox = new InfoBox({
	  content: 	'<div class="map-marker-wrapper">'+
    						'<div class="map-marker-container">'+
	    						'<div class="arrow-down"></div>'+
									propertyThumbnail+
									'<div class="content">'+
									propertyTitle+
									propertyPrice+
									'</div>'+
								'</div>'+
					    '</div>',
	  disableAutoPan: false,
	  pixelOffset: new google.maps.Size(-33, -90),
	  zIndex: null,
	  alignBottom: true,
	  closeBoxURL: "<?php echo TT_LIB_URI . '/images/close.png'; ?>",
	  infoBoxClearance: new google.maps.Size(50, 50)
	});
	<?php
	// Check If We Have LatLng Coordinates From Google Maps
	if ( $google_maps ) {
	?>
	//alert("got latlng");
	function getLatLng(callback) {
		latLng = new google.maps.LatLng(<?php echo $address_latitude; ?>, <?php echo $address_longitude; ?>);
		callback(latLng);
	}
	<?php
	}
	// Fallback When No LatLng Found. Which Is Usually The Case When Doing A Bulk Import
	else {
	?>
	//alert("no latlng");
	<?php if ( is_page_template( 'template-property-submit.php' ) ) { ?>
	var address = jQuery('input#property-address').value;
	<?php } else { ?>
	var address = '<?php echo $address; ?>';
	<?php } ?>

	// Get latLng from property address and grab it with callback, as geocode calls asynchonous
  function getLatLng(callback) {
	  var geocoder = new google.maps.Geocoder();
	  if ( geocoder ) {
		  geocoder.geocode( { 'address': address}, function(results, status ) {
		    if (status == google.maps.GeocoderStatus.OK) {
		    	latLng = results[0].geometry.location;
		    	callback(latLng);
		    }
		    <?php if ( !is_page_template( 'template-property-submit.php' ) ) { ?>
		    else {
			    //alert("Geocoder failed due to: " + status);
		    }
		    <?php } ?>
		  });
	  }
  }

  <?php } ?>

  getLatLng(function(latLng) {

	  marker.setPosition(latLng);
	  map.setCenter(latLng);
	  <?php
	  global $realty_theme_option;
	  if( $realty_theme_option['map-default-zoom-level'] ) {
		  echo 'map.setZoom(' . $realty_theme_option['map-default-zoom-level'] . ');';
	  }
	  else {
		  echo 'map.setZoom(14);';
	  }
	  ?>
   	infobox.open(map, marker);
	map.panBy(0,-150);
   	google.maps.event.addListener(marker, 'click', function() {
	  	infobox.open(map, marker);
	});

  });

	// Maps Fully Loaded: Hide + Remove Spinner
	google.maps.event.addListenerOnce(map, 'idle', function() {
		jQuery('.spinner').fadeTo(800, 0.5);
		setTimeout(function() {
		  jQuery('.spinner').remove();
		}, 800);
	});

	<?php
	// User Property Submit
	if ( is_page_template( 'template-property-submit.php' ) ) { ?>
	// https://developers.google.com/maps/documentation/javascript/examples/places-autocomplete
  var autocompleteInput = document.getElementById('property-address');
  var autocomplete = new google.maps.places.Autocomplete(autocompleteInput);

  // Autocomplete
  google.maps.event.addListener(autocomplete, 'place_changed', function() {

    infobox.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }

    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    // Update Property Coordinates
    var newCoordinates = String( place.geometry.location );
    newCoordinates = newCoordinates.substring( 1, newCoordinates.length-1 );
    //alert( newCoordinates );
    jQuery('#property-coordinates').val(newCoordinates);

  });

  // After Marker Has Been Dragged To Exact Location
  google.maps.event.addListener(marker, 'dragend', function() {
    var newCoordinatesAfterDragging = String( marker.getPosition() );
    newCoordinatesAfterDragging = newCoordinatesAfterDragging.substring( 1, newCoordinatesAfterDragging.length-1 );
    //alert( newCoordinatesAfterDragging );
    jQuery('#property-coordinates').val(newCoordinatesAfterDragging);
	});
  <?php } ?>

}

google.maps.event.addDomListener(window, 'load', initMap);
google.maps.event.addDomListener(window, 'resize', initMap);
</script>

<?php
}
add_action( 'wp_footer', 'tt_google_maps_api_single_property', 20 );
?>

<section id="location">
<?php
global $realty_theme_option;
$property_title_map = $realty_theme_option['property-title-map'];
//if ( is_page_template( 'template-property-submit.php' ) && isset( $_GET['edit'] ) && ! empty( $_GET['edit'] ) ) {
	$google_maps = get_post_meta( $post->ID, 'eq_location', true );
	if ( isset( $google_maps ) ) {
		$address = $google_maps['address'];
	}
//}
if ( $property_title_map && ! is_page_template( 'template-property-submit.php' ) ) {
	echo '<h3 class="section-title"><span>' . __($property_title_map, "tt") . '</span></h3>';
	if ( $address ) {
	 echo '<p class="text-muted">' . $address . '</p>';
	}
}
?>

<div id="map-wrapper" class="map-wrapper">

	<div id="map-controls" class="map-controls">
		<a href="#" class="control zoom-in" id="zoom-in" data-toggle="tooltip" title="<?php _e( 'Zoom In', 'tt' ); ?>"><i class="fa fa-plus"></i></a>
		<a href="#" class="control zoom-out" id="zoom-out" data-toggle="tooltip" title="<?php _e( 'Zoom Out', 'tt' ); ?>"><i class="fa fa-minus"></i></a>
		<a href="#" class="control map-type" id="map-type" data-toggle="tooltip" title="<?php _e( 'Map Type', 'tt' ); ?>">
			<i class="fa fa-image"></i>
			<ul class="list-unstyled">
				<li id="map-type-roadmap"><?php _e( 'Roadmap', 'tt' ); ?></li>
				<li id="map-type-satellite"><?php _e( 'Satellite', 'tt' ); ?></li>
				<li id="map-type-hybrid"><?php _e( 'Hybrid', 'tt' ); ?></li>
				<li id="map-type-terrain"><?php _e( 'Terrain', 'tt' ); ?></li>
			</ul>
		</a>
		<a href="#" class="control" id="current-location" data-toggle="tooltip" title="<?php _e( 'Radius: 1000m', 'tt' ); ?>"><i class="fa fa-crosshairs"></i> <?php _e( 'Current Location', 'tt' ); ?></a>
	</div>

	<div id="google-map" class="google-map">
		<div class="spinner">
		  <div class="bounce1"></div>
		  <div class="bounce2"></div>
		  <div class="bounce3"></div>
		</div>
	</div>

	<?php if ( ! is_page_template( 'template-property-submit.php' ) ) { ?>
	<a class="view-on-google-maps-link" href="https://www.google.com/maps/preview?q=<?php $maplink = str_replace(' ', '+', $address); echo $maplink; ?>" target="_blank"><?php _e( 'View on Google Maps', 'tt' ); ?></a>
	<?php } ?>

</div>

</section>
