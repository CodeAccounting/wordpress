<?php
$desc = $h->provide_m('metaStyle1Desc');
$customerName = $h->provide_m('metaStyle1CustomerName');
$liveDemo = $h->provide_m('metaStyle1LiveDemo');
$date = $h->provide_m('metaStyle1Date');
$tag = $h->provide_m('metaStyle1Tag');
$gallery = $h->provide_m('metaGallery');
$i = new provide_Imagify();
$sizes = array('m' => '568x570', 'i' => '568x570', 'w' => '568x570');
$noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
?>
    <div class="project-detail-page">
        <?php if (!empty($gallery) && count($gallery) > 0): ?>
            <div class="project-carousel">
                <?php
                foreach ($gallery as $image) {
                    echo '<img src="' . esc_url($image) . '" alt=""/>';
                }
                ?>
            </div><!-- Project Carousel -->
        <?php endif; ?>
        <div class="provide-project-information">
            <div class="project-description">
                <h2><?php the_title() ?></h2>
                <p><?php echo wp_kses($desc, true) ?></p>
                <?php if (!empty($customerName) || !empty($date) || !empty($tag)): ?>
                    <ul>
                        <?php if (!empty($customerName)): ?>
                            <li><strong><?php esc_html_e('CLIENT', 'provide') ?></strong><span><?php echo esc_html($customerName) ?></span></li>
                        <?php endif; ?>
                        <?php if (!empty($date)): ?>
                            <li><strong><?php esc_html_e('DATE', 'provide') ?></strong><span><?php echo $date ?></span></li>
                        <?php endif; ?>
                        <?php if (!empty($tag)): ?>
                            <li><strong><?php esc_html_e('SKILLS', 'provide') ?></strong><span><?php echo esc_html($tag) ?></span></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
                <?php if (!empty($liveDemo)): ?>
                    <a class="yellow-btn" href="<?php echo esc_url($liveDemo) ?>" title=""><?php esc_html_e('View Project', 'provide') ?></a>
                <?php endif; ?>
            </div>
            <div class="project-info-img <?php echo esc_attr($noThumb) ?>">
                <?php
                if (has_post_thumbnail()) {
                    echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
                }
                ?>
            </div>
        </div><!-- Provide Project Information -->
    </div>
<?php
if (!empty($gallery) && count($gallery) > 0) {
    $loop = (count($gallery) > 1) ? 'true' : 'false';
    provide_Media::provide_singleton()->provide_eq(array('owl'));
    $jsOutput = "jQuery('.project-carousel').owlCarousel({
                        autoplay:true,
                        smartSpeed:1000,
                        loop:" . esc_js($loop) . ",
                        dots:true,
                        nav:true,
                        margin:0,
                        mouseDrag:true,
                        items:1,
                        singleItem:true,
                        autoplayHoverPause:true,		        
                        autoHeight:true,
                        animateIn:\"fadeIn\",
                        animateOut:\"fadeOut\"
                    });";
    wp_add_inline_script('owl', $jsOutput);
}