<?php
$h = new provide_Helper();
$h->provide_header();
while (have_posts()) {
    the_post();
    $opt = $h->provide_opt();
    $h->provide_headerTop(get_the_ID());
    $column = $h->provide_column(get_the_ID());
    if ($column == 'col-md-9') {
        $sizes = array('m' => '614x282', 'i' => '970x400', 'w' => '870x400');
    } else if ($column == 'col-md-12') {
        $sizes = array('m' => '614x282', 'i' => '970x400', 'w' => '1170x400');
    }
    $i = new provide_Imagify();
    $noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
    $contactEmail = $h->provide_m('metaContactEmail');
    $contactNumber = $h->provide_m('metaContactNumber');
    $contactTime = $h->provide_m('metaContactTime');
    $address = $h->provide_m('metaAddress');
    $latitude = $h->provide_set($address, 'latitude');
    $longitude = $h->provide_set($address, 'longitude');
    if (!empty($contactEmail) || !empty($contactNumber) || !empty($contactTime) || $h->provide_set($address, 'address') != '') {
        $mapCol = 'col-md-8';
    } else {
        $mapCol = 'col-md-12';
    }
    provide_Media::provide_singleton()->provide_eq(array('map'));
    ?>
    <section>
        <div class="block">
            <div class="container">
                <div class="row">
                    <?php $h->provide_themeLeftSidebar(get_the_ID()) ?>
                    <div class="<?php echo esc_attr($column) ?> pro-col">
                        <div class="branch branch-detail">
                            <div class="branch-img <?php echo esc_attr($noThumb) ?>">
                                <?php
                                if (has_post_thumbnail()) {
                                    echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
                                }
                                ?>
                            </div>
                            <h2><?php the_title() ?></h2>
                            <?php if ($h->provide_set($address, 'address') != ''): ?>
                                <span class="add"><i class="fa fa-map-marker"></i><?php echo esc_html($h->provide_set($address, 'address')) ?></span>
                            <?php endif; ?>
                            <div class="branch-infos">
                                <div class="row">
                                    <div class="<?php echo esc_attr($mapCol) ?>">
                                        <div class="map">
                                            <div id="map-canvas"></div>
                                        </div>
                                    </div>
                                    <?php if (!empty($contactEmail) || !empty($contactEmail) || !empty($contactEmail) || $h->provide_set($address, 'address') != ''): ?>
                                        <div class="col-md-4">
                                            <div class="header-contact style2">
                                                <?php if (!empty($contactEmail)): ?>
                                                    <div class="info">
                                                        <img src="<?php echo esc_url(provide_Uri . 'partial/images/info2.png') ?>" alt=""/>
                                                        <strong><?php esc_html_e('Contact Email', 'provide') ?> <span><?php echo esc_html($contactEmail) ?></span></strong>
                                                    </div><!-- Info -->
                                                <?php endif; ?>
                                                <?php if (!empty($contactNumber)): ?>
                                                    <div class="info">
                                                        <img src="<?php echo esc_url(provide_Uri . 'partial/images/info3.png') ?>" alt=""/>
                                                        <strong><?php esc_html_e('Phone Number', 'provide') ?> <span><?php echo esc_html($contactNumber) ?></span></strong>
                                                    </div><!-- Info -->
                                                <?php endif; ?>
                                                <?php if (!empty($contactTime)): ?>
                                                    <div class="info">
                                                        <img src="<?php echo esc_url(provide_Uri . 'partial/images/info1.png') ?>" alt=""/>
                                                        <strong><?php esc_html_e('Contact Time', 'provide') ?> <span><?php echo esc_html($contactTime) ?></span></strong>
                                                    </div><!-- Info -->
                                                <?php endif; ?>
                                                <?php if ($h->provide_set($address, 'address') != ''): ?>
                                                    <div class="info">
                                                        <img src="<?php echo esc_url(provide_Uri . 'partial/images/info4.png') ?>" alt=""/>
                                                        <strong><?php esc_html_e('Address', 'provide') ?> <span><?php echo esc_html($h->provide_set($address, 'address')) ?></span></strong>
                                                    </div><!-- Info -->
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div><!-- Branch Infos -->
                            <?php the_content() ?>
                        </div><!-- Branch Detail -->
                    </div>
                    <?php $h->provide_themeRightSidebar(get_the_ID()) ?>
                </div>
            </div>
        </div>
    </section>
    <?php
    $jsOutpt = "
			var myLatlng = new google.maps.LatLng(" . $latitude . " , " . $longitude . ");
			var mapOptions ={
			zoom:14,
			disableDefaultUI:true,
			scrollwheel:false,
			center:myLatlng
			}
			var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

			var image = '';
			var myLatLng = new google.maps.LatLng(" . $latitude . " , " . $longitude . ");
			var beachMarker = new google.maps.Marker({
			  position:myLatLng,
			  map:map,
			  icon:image
			});";
    wp_add_inline_script('map', $jsOutpt);
}
get_footer();
