<?php
get_header();
global $post;
global $realty_theme_option;
$hide_sidebar = get_post_meta( $post->ID, 'estate_page_hide_sidebar', true );

// Minimal Information
$vessel_length = get_field('vessel_length');
$vessel_location = get_field('estate_property_google_maps');
$vessel_built = get_field('vessel_built');
$vessel_material = get_field('vessel_material');

//General Information
$vessel_yard = get_field('vessel_yard');
$vessel_designer = get_field('vessel_designer');
$vessel_hull_shape = get_field('vessel_hull_shape');
$vessel_hull_material = get_field('vessel_hull_material');
$vessel_superstructure_material = get_field('vessel_superstructure_material');
$vessel_construction_method = get_field('vessel_construction_method');
$vessel_steering_system = get_field('vessel_steering_system');
$vessel_windows = get_field('vessel_windows');
$vessel_displacement = get_field('vessel_displacement');
$vessel_ballast = get_field('vessel_ballast');
$vessel_airdraft = get_field('vessel_airdraft');
$vessel_registered = get_field('vessel_registered');
$vessel_colour = get_field('vessel_colour');
$vessel_certificates = get_field('vessel_certificates');
$vessel_certification = get_field('vessel_certification');
$vessel_suitable_for = get_field('vessel_suitable_for');
$vessel_general_information = get_field('vessel_general_information');
$vessel_additional_information = get_field('vessel_additional_information');

// Reusing relestate logic
$social_sharing = $realty_theme_option['property-social-sharing'];
$show_agent_information = $realty_theme_option['property-agent-information'];
$if_show_agent_info = true;
$agent = get_post_meta( $post->ID, 'estate_property_custom_agent', true );
$property_contact_information = get_post_meta( $post->ID, 'estate_property_contact_information', true );
$show_property_contact_form = $realty_theme_option['property-contact-form'];
$property_image_location = $realty_theme_option['property-image-location'];
$property_video_location = $realty_theme_option['property-video-location'];
$property_images = get_post_meta( $post->ID, 'estate_property_gallery', true );
$featured = get_post_meta( $post->ID, 'estate_property_featured', true );
$property_layout = $realty_theme_option['property-layout'];
$property_status = get_the_terms( $post->ID, 'property-status' );
$single_property_layout = get_post_meta( $post->ID, 'estate_property_layout', true );
$property_type = get_the_terms( $post->ID, 'vessel_type' );
$property_video_id = get_post_meta( $post->ID, 'estate_property_video_id', true );
$property_video_provider = get_post_meta( $post->ID, 'estate_property_video_provider', true );
$property_title_agent = $realty_theme_option['property-title-agent'];

if ( ! isset( $property_image_width ) ) {
    $property_image_width = "full";
}

if ( $realty_theme_option['property-lightbox'] != "none" ) {
    $property_zoom = ' zoom';
} else {
    $property_zoom = null;
}

if ( $realty_theme_option['property-image-height-fit-or-cut'] ) {
    $fit_or_cut = $realty_theme_option['property-image-height-fit-or-cut'];
} else {
    $fit_or_cut = null;
}

if ( $single_property_layout == "theme_option_setting" || $single_property_layout == "" ) {
    if ( $property_layout == "layout-full-width" ) {
        $layout = "full-width";
    } else {
        $layout = "boxed";
    }
} else {
    if ( $single_property_layout == "full_width" ) {
        $layout = "full-width";
    } else {
        $layout = "boxed";
    }
}
?>
<?php if ( $layout == "full-width" ) { echo '</div>'; } // .container ?>

    <div id="property-layout-<?php echo $layout; ?>">
        <?php
        if ( $property_image_location == 'above' ) {

            include TEMPLATEPATH . '/lib/inc/template/property-slideshow.php';

        }

        // When only video is shown "above"
        if ( $property_image_location == 'begin' && $property_video_location == 'above' && $property_video_provider != 'none' && $property_video_id ) {
            include TEMPLATEPATH . '/lib/inc/template/property-video.php';
        }
        ?>

        <?php
        // Property Title Style
        if ( $realty_theme_option['property-title-style'] ) {
            $property_header_title_style = $realty_theme_option['property-title-style'];
        }
        else {
            $property_header_title_style = null;
        }


        // Check if property header has no background video and image
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

        ?>

    <div class="container">
        <div class="property-meta primary-tooltips">
            <div class="row">
                <?php if($vessel_length) : ?>
                    <div class="col-sm-4 col-md-3">
                        <div class="meta-title"><i class="fa fa-expand"></i></div>
                        <div class="meta-data" data-toggle="tooltip" title="" data-original-title="<?php _e( 'Size', 'tt' ); ?>"><?php print $vessel_length; ?></div>
                    </div>
                <?php endif; ?>

                <?php if($vessel_location) : ?>
                <div class="col-sm-4 col-md-3">
                    <div class="meta-title"><i class="fa fa-map-o"></i></div>
                    <div class="meta-data" data-toggle="tooltip" title="" data-original-title="<?php _e( 'Location', 'tt' ); ?>"><?php print $vessel_location['address']; ?></div>
                </div>
                <?php endif; ?>
                <?php if($vessel_built) : ?>
                <div class="col-sm-4 col-md-3">
                    <div class="meta-title"><i class="fa fa-calendar-o"></i></div>
                    <div class="meta-data" data-toggle="tooltip" title="" data-original-title="<?php _e('Built'); ?>"><?php print $vessel_built; ?></div>
                </div>
                <?php endif; ?>
                <?php if($vessel_material) : ?>
                <div class="col-sm-4 col-md-3">
                    <div class="meta-title"><i class="fa fa-wrench"></i></div>
                    <div class="meta-data" data-toggle="tooltip" title="" data-original-title="<?php _e('Building Material'); ?>"><?php print $vessel_material; ?></div>
                </div>
                <?php endif; ?>
                <div class="col-sm-4 col-md-3">
                    <div class="meta-title"><i class="fa fa-slack"></i></div>
                    <div class="meta-data" data-toggle="tooltip" title="<?php _e( 'Property ID', 'tt' ); ?>"><?php echo $post->ID; ?></div>
                </div>
                <?php if ( ! $realty_theme_option['property-meta-data-hide-print'] ) : ?>
                <div class="col-sm-4 col-md-3">
                    <a href="#" id="print">
                        <div class="meta-title"><i class="fa fa-print"></i></div>
                        <div class="meta-data"><?php _e( 'Print this page', 'tt' ); ?></div>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div><!-- .property-meta -->

        <div class="row">
            <div class="col-sm-12">
                <div id="main-content" class="content-box">

                    <?php if ( $property_image_location == 'begin' || $property_video_location == 'begin' ) {
                    if ( $property_image_location == 'begin' ) { ?>
                    <section id="property-slider-below">
                        <?php } else { ?>
                        <section id="property-video">
                            <?php }
                            if( $property_image_location == 'above' ){
                                if ( $property_video_id && $property_video_location == 'begin') {
                                    if ( $property_video_id && ( $property_video_provider == "youtube" || $property_video_provider == "vimeo" ) ) {
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
                                        $url_video = $oembed->get_html( $property_video_url );
                                        echo '<div class="fluid-width-video-wrapper">'. $url_video . '</div>';
                                    }
                                }
                            } else {

                                include TEMPLATEPATH . '/lib/inc/template/property-slideshow.php';

                                if ( $property_image_location == 'begin' && $realty_theme_option['property-slideshow-navigation-type'] == 'thumbnail' ) {
                                    include TEMPLATEPATH . '/lib/inc/template/property-slideshow-thumbnails.php';
                                }
                            }
                            ?>
                        </section>
                        <?php } ?>

                    <section id="property-content">
                    <?php while ( have_posts() ) : the_post(); ?>
                            <h3 class="section-title"><span><?php _e('Intro'); ?></span></h3>
                            <?php the_content(); ?>
                    <?php endwhile; // end of the loop. ?>
                    </section>

                    <section id="property-features" class="primary-tooltips">
                        <h3 class="section-title"><span><?php _e('Properties'); ?></span></h3>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="tinfo">Yard</h6>
                                <p class="tinfotext"><?php echo $vessel_yard;?></p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="tinfo">Designer / Architect</h6>
                                <p class="tinfotext"><?php echo $vessel_designer;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="tinfo">Hull shape</h6>
                                <p class="tinfotext"><?php echo $vessel_hull_shape;?></p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="tinfo">Hull material</h6>
                                <p class="tinfotext"><?php echo $vessel_hull_material;?></p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="tinfo">Deck material</h6>
                                <p class="tinfotext"><?php echo $vessel_hull_material;?></p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="tinfo">Superstructure material</h6>
                                <p class="tinfotext"><?php echo $vessel_hull_material;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="tinfo">Displacement (approx.)</h6>
                                <p class="tinfotext"><?php echo $vessel_displacement;?></p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="tinfo">Ballast (approx.)</h6>
                                <p class="tinfotext"><?php echo $vessel_ballast;?></p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="tinfo">Airdraft (approx.)</h6>
                                <p class="tinfotext"><?php echo $vessel_airdraft;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="tinfo">Registered</h6>
                                <p class="tinfotext"><?php echo $vessel_registered;?></p>
                            </div>
                            <div class="col-md-3">
                                <h6 class="tinfo">RCD / CE Certification</h6>
                                <p class="tinfotext"><?php echo $vessel_certification;?></p>
                            </div>
                            <div class="col-md-4">
                                <h6 class="tinfo">Certificates</h6>
                                <p class="tinfotext"><?php echo $vessel_certificates;?></p>
                            </div>
                        </div>
                        <h6 class="tinfo">Colour</h6>
                        <p class="tinfotext"><?php echo $vessel_colour;?></p>
                        <h6 class="tinfo">Construction method:</h6>
                        <?php if( have_rows('vessel_construction_method') ): ?>
                            <ul class="list-unstyled row">
                                <?php while( have_rows('vessel_construction_method') ): the_row(); ?>
                                    <li  class="col-sm-4 col-md-3 tinfotext"><i class="fa fa-check"></i><?php the_sub_field('sub_construction_method'); ?></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                        <h6 class="tinfo">Steering system</h6>
                        <?php if( have_rows('vessel_steering_system') ): ?>
                            <ul class="list-unstyled row">
                                <?php while( have_rows('vessel_steering_system') ): the_row(); ?>
                                    <li  class="col-sm-4 col-md-3 tinfotext"><i class="fa fa-check"></i><?php the_sub_field('sub_steering_system'); ?></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                        <h6 class="tinfo">Windows</h6>
                        <?php if( have_rows('vessel_windows') ): ?>
                            <ul class="list-unstyled row">
                                <?php while( have_rows('vessel_windows') ): the_row(); ?>
                                    <li  class="col-sm-4 col-md-3 tinfotext"><i class="fa fa-check"></i><?php the_sub_field('sub_vessel_window'); ?></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>

                        <h6 class="tinfo">Suitable for / as</h6>
                        <?php if( have_rows('vessel_suitable_for') ): ?>
                            <ul class="list-unstyled row">
                                <?php while( have_rows('vessel_suitable_for') ) : the_row(); ?>
                                    <li  class="col-sm-4 col-md-3 tinfotext"><i class="fa fa-check"></i><?php the_sub_field('sub_suitable_for'); ?></li>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="tinfo">General information</h6>
                                <p class="tinfotext"><?php echo $vessel_general_information;?></p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="tinfo">Additional information</h6>
                                <p class="tinfotext"><?php echo $vessel_additional_information;?></p>
                            </div>
                        </div>
                    </section>


                    <section id="additional-details">
                        <?php echo '<h3 class="section-title"><span>' . __('General Information') . '</span></h3>'; ?>
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
                        -->
                    </section>

                    <?php
                    // Property Map
                    if ( $vessel_location || $google_maps ) {
                    get_template_part( 'lib/inc/template/google-map-single-property' );
                    }
                    ?>
                    <!--<section id="location">
                        <h3 class="section-title"><span>Staðsetning</span></h3><p class="text-muted">20 Stamford Street, London, United Kingdom</p>
                        <div id="map-wrapper" class="map-wrapper">

                            <div id="map-controls" class="map-controls">
                                <a href="#" class="control zoom-in" id="zoom-in" data-toggle="tooltip" title="" data-original-title="Zoom In"><i class="fa fa-plus"></i></a>
                                <a href="#" class="control zoom-out" id="zoom-out" data-toggle="tooltip" title="" data-original-title="Zoom Out"><i class="fa fa-minus"></i></a>
                                <a href="#" class="control map-type" id="map-type" data-toggle="tooltip" title="" data-original-title="Map Type">
                                    <i class="fa fa-image"></i>
                                    <ul class="list-unstyled">
                                        <li id="map-type-roadmap">Roadmap</li>
                                        <li id="map-type-satellite">Gervitungl</li>
                                        <li id="map-type-hybrid">Hybrid</li>
                                        <li id="map-type-terrain">Terrain</li>
                                    </ul>
                                </a>
                                <a href="#" class="control" id="current-location" data-toggle="tooltip" title="" data-original-title="Radíus: 1000m"><i class="fa fa-crosshairs"></i> Núverandi staðsetning</a>
                            </div>

                            <div id="google-map" class="google-map" style="position: relative; overflow: hidden; transform: translateZ(0px); background-color: rgb(229, 227, 223);">
                                <div class="gm-style" style="position: absolute; left: 0px; top: 0px; overflow: hidden; width: 100%; height: 100%; z-index: 0;">
                                    <div style="position: absolute; left: 0px; top: 0px; overflow: hidden; width: 100%; height: 100%; z-index: 0; cursor: url(&quot;http://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;) 8 8, default;">
                                        <div style="position: absolute; left: 0px; top: 0px; z-index: 1; width: 100%; transform-origin: 0px 0px 0px; transform: matrix(1, 0, 0, 1, 0, 0);"><div style="transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 100; width: 100%;">
                                                <div style="position: absolute; left: 0px; top: 0px; z-index: 0;"><div aria-hidden="true" style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;">
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 485px; top: 64px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 229px; top: 64px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 485px; top: -192px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 485px; top: 320px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 741px; top: 64px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 229px; top: 320px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 229px; top: -192px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 741px; top: -192px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 741px; top: 320px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 997px; top: 64px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: -27px; top: 64px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: -27px; top: -192px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 997px; top: -192px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: -27px; top: 320px;"></div>
                                                        <div style="width: 256px; height: 256px; transform: translateZ(0px); position: absolute; left: 997px; top: 320px;"></div>
                                                    </div></div></div><div style="transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 101; width: 100%;"></div>
                                            <div style="transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 102; width: 100%;"></div>
                                            <div style="transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 103; width: 100%;">
                                                <div style="position: absolute; left: 0px; top: 0px; z-index: -1;">
                                                    <div aria-hidden="true"
                                                         style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;">
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 485px; top: 64px;">
                                                            <canvas draggable="false" height="512" width="512"
                                                                    style="-webkit-user-select: none; position: absolute; left: 0px; top: 0px; height: 256px; width: 256px;"></canvas>
                                                        </div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 229px; top: 64px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 485px; top: -192px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 485px; top: 320px;">
                                                            <canvas draggable="false" height="512" width="512"
                                                                    style="-webkit-user-select: none; position: absolute; left: 0px; top: 0px; height: 256px; width: 256px;"></canvas>
                                                        </div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 741px; top: 64px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 229px; top: 320px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 229px; top: -192px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 741px; top: -192px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 741px; top: 320px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 997px; top: 64px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: -27px; top: 64px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: -27px; top: -192px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 997px; top: -192px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: -27px; top: 320px;"></div>
                                                        <div
                                                            style="width: 256px; height: 256px; overflow: hidden; transform: translateZ(0px); position: absolute; left: 997px; top: 320px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="position: absolute; left: 0px; top: 0px; z-index: 0;">
                                                <div aria-hidden="true"
                                                     style="position: absolute; left: 0px; top: 0px; z-index: 1; visibility: inherit;">
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 229px; top: 64px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8186!3i5447!2m3!1e0!2sm!3i336004997!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 485px; top: 320px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8187!3i5448!2m3!1e0!2sm!3i336004973!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 485px; top: -192px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8187!3i5446!2m3!1e0!2sm!3i336005044!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 741px; top: 64px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8188!3i5447!2m3!1e0!2sm!3i336004900!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 485px; top: 64px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8187!3i5447!2m3!1e0!2sm!3i336004973!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 229px; top: -192px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8186!3i5446!2m3!1e0!2sm!3i336005044!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 229px; top: 320px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8186!3i5448!2m3!1e0!2sm!3i336004997!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 741px; top: -192px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8188!3i5446!2m3!1e0!2sm!3i336005044!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 741px; top: 320px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8188!3i5448!2m3!1e0!2sm!3i336004900!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 997px; top: 64px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8189!3i5447!2m3!1e0!2sm!3i336004900!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: -27px; top: 64px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8185!3i5447!2m3!1e0!2sm!3i336004997!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: -27px; top: -192px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8185!3i5446!2m3!1e0!2sm!3i336005044!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 997px; top: -192px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8189!3i5446!2m3!1e0!2sm!3i336005044!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: -27px; top: 320px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8185!3i5448!2m3!1e0!2sm!3i336004997!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                    <div
                                                        style="transform: translateZ(0px); position: absolute; left: 997px; top: 320px; width: 256px; height: 256px; transition: opacity 200ms ease-out;">
                                                        <img
                                                            src="http://maps.googleapis.com/maps/vt?pb=!1m4!1m3!1i14!2i8189!3i5448!2m3!1e0!2sm!3i336004684!3m9!2sis!3sUS!5e18!12m1!1e47!12m3!1e37!2m1!1ssmartmaps!4e0!5m1!5f2"
                                                            draggable="false"
                                                            style="-webkit-user-select: none; border: 0px; padding: 0px; margin: 0px; width: 256px; height: 256px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            style="position: absolute; left: 0px; top: 0px; z-index: 2; width: 100%; height: 100%;"></div>
                                        <div
                                            style="position: absolute; left: 0px; top: 0px; z-index: 3; width: 100%; transform-origin: 0px 0px 0px; transform: matrix(1, 0, 0, 1, 0, 0);">
                                            <div
                                                style="transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 104; width: 100%;"></div>
                                            <div
                                                style="transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 105; width: 100%;"></div>
                                            <div
                                                style="transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 106; width: 100%;"></div>
                                            <div
                                                style="transform: translateZ(0px); position: absolute; left: 0px; top: 0px; z-index: 107; width: 100%;">
                                                <div class="infoBox"
                                                     style="transform: translateZ(0px); position: absolute; visibility: visible; width: 300px; left: 506.547px; bottom: -259.83px;">
                                                    <img
                                                        src="http://topwaves.is.dev/wp-content/themes/realty/lib/images/close.png"
                                                        align="right"
                                                        style=" position: relative; cursor: pointer; margin: 2px;">
                                                    <div class="map-marker-wrapper">
                                                        <div class="map-marker-container">
                                                            <div class="arrow-down"></div>
                                                            <img width="600" height="300"
                                                                 src="http://topwaves.is.dev/wp-content/uploads/2015/10/property-9-600x300.jpg"
                                                                 class="attachment-property-thumb size-property-thumb wp-post-image"
                                                                 alt="property-9">
                                                            <div class="content"><h5 class="title">Apartment On
                                                                    Stamford</h5>3.000 kr.&nbsp;per month
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        style="margin-left: 5px; margin-right: 5px; z-index: 1000000; position: absolute; left: 0px; bottom: 0px;">
                                        <a target="_blank"
                                           href="https://maps.google.com/maps?ll=51.515162,-0.105181&amp;z=14&amp;t=m&amp;hl=is&amp;gl=US&amp;mapclient=apiv3"
                                           title="Smelltu til að sjá þetta svæði á Google kortum"
                                           style="position: static; overflow: visible; float: none; display: inline;">
                                            <div style="width: 66px; height: 26px; cursor: pointer;"><img
                                                    src="http://maps.gstatic.com/mapfiles/api-3/images/google4_hdpi.png"
                                                    draggable="false"
                                                    style="position: absolute; left: 0px; top: 0px; width: 66px; height: 26px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px;">
                                            </div>
                                        </a></div>
                                    <div
                                        style="padding: 15px 21px; border: 1px solid rgb(171, 171, 171); font-family: Roboto, Arial, sans-serif; color: rgb(34, 34, 34); box-shadow: rgba(0, 0, 0, 0.2) 0px 4px 16px; z-index: 10000002; display: none; width: 256px; height: 148px; position: absolute; left: 390px; top: 110px; background-color: white;">
                                        <div style="padding: 0px 0px 10px; font-size: 16px;">Kortagögn</div>
                                        <div style="font-size: 13px;">Kortagögn ©2016 Google</div>
                                        <div
                                            style="width: 13px; height: 13px; overflow: hidden; position: absolute; opacity: 0.7; right: 12px; top: 12px; z-index: 10000; cursor: pointer;">
                                            <img src="http://maps.gstatic.com/mapfiles/api-3/images/mapcnt6.png"
                                                 draggable="false"
                                                 style="position: absolute; left: -2px; top: -336px; width: 59px; height: 492px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px;">
                                        </div>
                                    </div>
                                    <div class="gmnoprint"
                                         style="z-index: 1000001; position: absolute; right: 210px; bottom: 0px; width: 126px;">
                                        <div draggable="false" class="gm-style-cc" style="-webkit-user-select: none;">
                                            <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                                <div style="width: 1px;"></div>
                                                <div
                                                    style="width: auto; height: 100%; margin-left: 1px; background-color: rgb(245, 245, 245);"></div>
                                            </div>
                                            <div
                                                style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right;">
                                                <a style="color: rgb(68, 68, 68); text-decoration: none; cursor: pointer; display: none;">Kortagögn</a><span
                                                    style="">Kortagögn ©2016 Google</span></div>
                                        </div>
                                    </div>
                                    <div class="gmnoscreen" style="position: absolute; right: 0px; bottom: 0px;">
                                        <div
                                            style="font-family: Roboto, Arial, sans-serif; font-size: 11px; color: rgb(68, 68, 68); direction: ltr; text-align: right; background-color: rgb(245, 245, 245);">
                                            Kortagögn ©2016 Google
                                        </div>
                                    </div>
                                    <div class="gmnoprint gm-style-cc" draggable="false"
                                         style="z-index: 1000001; -webkit-user-select: none; position: absolute; right: 116px; bottom: 0px;">
                                        <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                            <div style="width: 1px;"></div>
                                            <div
                                                style="width: auto; height: 100%; margin-left: 1px; background-color: rgb(245, 245, 245);"></div>
                                        </div>
                                        <div
                                            style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right;">
                                            <a href="https://www.google.com/intl/is_US/help/terms_maps.html"
                                               target="_blank"
                                               style="text-decoration: none; cursor: pointer; color: rgb(68, 68, 68);">Notkunarskilmálar</a>
                                        </div>
                                    </div>
                                    <div draggable="false" class="gm-style-cc"
                                         style="-webkit-user-select: none; position: absolute; right: 0px; bottom: 0px;">
                                        <div style="opacity: 0.7; width: 100%; height: 100%; position: absolute;">
                                            <div style="width: 1px;"></div>
                                            <div
                                                style="width: auto; height: 100%; margin-left: 1px; background-color: rgb(245, 245, 245);"></div>
                                        </div>
                                        <div
                                            style="position: relative; padding-right: 6px; padding-left: 6px; font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); white-space: nowrap; direction: ltr; text-align: right;">
                                            <a target="_new" title="Tilkynna Google um villur á vegakorti eða loftmynd"
                                               href="https://www.google.com/maps/@51.5151616,-0.1051815,14z/data=!10m1!1e1!12b1?source=apiv3&amp;rapsrc=apiv3"
                                               style="font-family: Roboto, Arial, sans-serif; font-size: 10px; color: rgb(68, 68, 68); text-decoration: none; position: relative;">Tilkynna
                                                um villu á korti</a></div>
                                    </div>
                                    <div class="gmnoprint" draggable="false" controlwidth="32" controlheight="40"
                                         style="margin: 5px; -webkit-user-select: none; position: absolute; top: 0px; left: 0px;">
                                        <div controlwidth="32" controlheight="40"
                                             style="cursor: url(&quot;http://maps.gstatic.com/mapfiles/openhand_8_8.cur&quot;) 8 8, default; position: absolute; left: 0px; top: 0px;">
                                            <div aria-label="Stjórnun Þrándar í Street View"
                                                 style="width: 32px; height: 40px; overflow: hidden; position: absolute; left: 0px; top: 0px;">
                                                <img
                                                    src="http://maps.gstatic.com/mapfiles/api-3/images/cb_scout2_hdpi.png"
                                                    draggable="false"
                                                    style="position: absolute; left: -9px; top: -102px; width: 1028px; height: 214px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px;">
                                            </div>
                                            <div aria-label="Þrándur er óvirkur"
                                                 style="width: 32px; height: 40px; overflow: hidden; position: absolute; left: 0px; top: 0px; visibility: hidden;">
                                                <img
                                                    src="http://maps.gstatic.com/mapfiles/api-3/images/cb_scout2_hdpi.png"
                                                    draggable="false"
                                                    style="position: absolute; left: -107px; top: -102px; width: 1028px; height: 214px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px;">
                                            </div>
                                            <div aria-label="Þrándur er ofan á kortinu"
                                                 style="width: 32px; height: 40px; overflow: hidden; position: absolute; left: 0px; top: 0px; visibility: hidden;">
                                                <img
                                                    src="http://maps.gstatic.com/mapfiles/api-3/images/cb_scout2_hdpi.png"
                                                    draggable="false"
                                                    style="position: absolute; left: -58px; top: -102px; width: 1028px; height: 214px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px;">
                                            </div>
                                            <div aria-label="Stjórnun Þrándar í Street View"
                                                 style="width: 32px; height: 40px; overflow: hidden; position: absolute; left: 0px; top: 0px; visibility: hidden;">
                                                <img
                                                    src="http://maps.gstatic.com/mapfiles/api-3/images/cb_scout2_hdpi.png"
                                                    draggable="false"
                                                    style="position: absolute; left: -205px; top: -102px; width: 1028px; height: 214px; -webkit-user-select: none; border: 0px; padding: 0px; margin: 0px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a class="view-on-google-maps-link" href="https://www.google.com/maps/preview?q=20+Stamford+Street,+London,+United+Kingdom" target="_blank">Skoða á Google Maps</a>

                        </div>

                    </section>-->

                    <?php
                    // Property Social Sharing
                    if ( $social_sharing ) {
                    echo '<div class="primary-tooltips">' . tt_social_sharing() . '</div>';
                    }
                    ?>


                </div><!-- #main-container -->

                <?php
                if ( $if_show_agent_info == true && $show_agent_information ) {

                    // Property Settings: If "Assign Agent" Selected, Show His/Her Details, Instead Of "Post Auhor"
                    if ( $agent ) {

                        if ( $property_title_agent ) {
                            echo '<h2 class="section-title"><span>' . __( $property_title_agent, 'tt' ) . '</span></h2>';
                        }

                        $company_name = get_user_meta( $agent, 'company_name', true );
                        $first_name = get_user_meta( $agent, 'first_name', true );
                        $last_name = get_user_meta( $agent, 'last_name', true );
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

                    }	else {

                        $company_name = get_the_author_meta( 'company_name' );
                        $first_name = get_the_author_meta( 'first_name' );
                        $last_name = get_the_author_meta( 'last_name' );
                        $email = get_the_author_meta('user_email');
                        $office = get_the_author_meta('office_phone_number');
                        $mobile = get_the_author_meta('mobile_phone_number');
                        $fax = get_the_author_meta('fax_number');
                        $website = get_the_author_meta('user_url');
                        $website_clean = str_replace( array( 'http://', 'https://' ), '', $website );
                        $bio = get_the_author_meta('description');
                        $profile_image = get_the_author_meta('user_image');
                        $author_profile_url = get_author_posts_url( $post->post_author );
                        $facebook = get_the_author_meta( 'custom_facebook' );
                        $twitter = get_the_author_meta( 'custom_twitter' );
                        $google = get_the_author_meta( 'custom_google' );
                        $linkedin = get_the_author_meta( 'custom_linkedin' );

                    }

                    // Author/Agent Information
                    if ( $show_agent_information && $property_contact_information == "all" ) {
                        if($if_show_agent_info == true){

                            include TEMPLATEPATH . '/lib/inc/template/agent-information.php';

                        }
                        else {

                            echo '<p class="alert alert-danger">' . __( 'You have to be logged-in to view agent details. Click Login/Register in the top menu.', 'tt' ) . '</p>';
                            die;
                        }
                    }
                    else {
                        //echo '<p class="alert alert-danger">' . __( 'You have to be logged-in to view agent details. Click Login/Register in the top menu.', 'tt' ) . '</p>';
                    }

                }
                ?>
                <?php
                // Check Theme Option + Property Settings For Author Contact Form
                if ( $show_property_contact_form && $property_contact_information != "none" ) {
                    include TEMPLATEPATH . '/lib/inc/template/contact-form.php';
                }
                ?>

                <script>
                    jQuery(document).ready(function() {

                        // Pause autoplay on slide hover, but not on mobile devices.
                        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                        if ( isMobile ) {
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
                            navText: 		['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
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
                            items:      4,
                            lazyLoad:   false,
                            loop:       false,
                            margin:     15,
                            dots:       false,
                            nav:        true,
                            autoHeight: false,
                            navText: 		['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
                            responsive: {
                                0: { items: 2, },
                                768: { items: 3, },
                                1200: { items: 4, },
                            },
                        });

                    });
                </script>
            </div><!-- .col-sm-9 -->
        </div><!-- .row -->
    </div>

</div>

<?php get_footer(); ?>