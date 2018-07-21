<?php
// Template Name:	Contact Us
$h = new provide_Helper();
$h->provide_header();
while (have_posts()) {
    the_post();
    $opt = $h->provide_opt();
    $column = $h->provide_column(get_the_ID(), 'optBlogSingleLayout', 'optBlogSingleSidebar');
    $map = $h->provide_set($opt, 'optContactMap');
    $bg = $h->provide_set($opt, 'optOfficeInfoBg');
    ?>
    <section>
        <div class="gap">
            <div class="container">
                <div class="row">
                    <?php $h->provide_themeLeftSidebar(get_the_ID(), 'optBlogSingleLayout', 'optBlogSingleSidebar') ?>
                    <div class="<?php echo esc_attr($column) ?>">
                        <h2><?php the_title() ?></h2>
                        <p><?php echo esc_html($h->provide_set($opt, 'optContactdesc')) ?></p>
                        <?php
                        if (!empty($map)):
                            provide_Media::provide_singleton()->provide_eq(array('map'));
                            $latlong = explode(',', $map);
                            ?>
                            <div id="canvas"></div>
                            <?php ob_start(); ?>
                            "use strict";
                            //** Map **//
                            function initialize() {
                            var myLatlng=new google.maps.LatLng(<?php echo esc_js($h->provide_set($latlong, '0')) ?>, <?php echo esc_js($h->provide_set($latlong, '1')) ?>);
                            var mapOptions={
                            zoom: 14,
                            disableDefaultUI: true,
                            scrollwheel: false,
                            center: myLatlng
                            }
                            var map=new google.maps.Map(document.getElementById('canvas'), mapOptions);
                            var image='<?php echo esc_url(provide_Uri) ?>partial/images/pointer.png';
                            var myLatLng=new google.maps.LatLng(<?php echo esc_js($h->provide_set($latlong, '0')) ?>, <?php echo esc_js($h->provide_set($latlong, '1')) ?>);
                            var beachMarker=new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            icon: image
                            });

                            }
                            google.maps.event.addDomListener(window, 'load', initialize);
                            <?php
                            $jsOutput = ob_get_contents();
                            ob_end_clean();
                            wp_add_inline_script('map', $jsOutput);
                        endif;
                        ?>
                        <div class="th-contact">
                            <div></div>
                            <form id="contactform">
                                <div class="row">
                                    <input type="hidden" name="receiver" value="<?php echo esc_attr($h->provide_set($opt, 'optContactMail')) ?>">
                                    <div class="col-md-6">
                                        <label class="th-label"><?php esc_html_e('Complete Name', 'provide') ?>*</label>
                                        <input type="text" placeholder="<?php esc_html_e('Complete Name', 'provide') ?>" class="th-textfield" id="complete-name" name="complete_name"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="th-label"><?php esc_html_e('Email', 'provide') ?>*</label>
                                        <input type="email" placeholder="<?php esc_html_e('Email Address', 'provide') ?>" id="email-address" name="email_address" class="th-textfield"/>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="th-label"><?php esc_html_e('Subject', 'provide') ?></label>
                                        <input type="text" placeholder="<?php esc_html_e('Subject', 'provide') ?>" name="subject" class="th-textfield"/>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="th-label"><?php esc_html_e('Message', 'provide') ?>*</label>
                                        <textarea placeholder="<?php esc_html_e('Message', 'provide') ?>" class="th-textarea" id="description" name="description"> </textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <a id="contact" href="javascript:void(0)" class="btn-form" title=""><?php esc_html_e('Contact Now', 'provide') ?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php $h->provide_themeRightSidebar(get_the_ID(), 'optBlogSingleLayout', 'optBlogSingleSidebar') ?>
                </div>
            </div>
        </div>
    </section>
    <?php
}
get_footer();
