<?php
$h = new provide_Helper();
$sizes = array('m' => '614x282', 'i' => '970x400', 'w' => '771x537');
$i = new provide_Imagify();
$noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
$desc = $h->provide_m('metaStyle1Desc');
$customerName = $h->provide_m('metaStyle1CustomerName');
$liveDemo = $h->provide_m('metaStyle1LiveDemo');
$category = $h->provide_m('metaStyle1Category');
$date = $h->provide_m('metaStyle1Date');
$tag = $h->provide_m('metaStyle1Tag');
$graphDesc = $h->provide_m('metaGraphDesc');
$graph = $h->provide_m('metaGraph');
if (!empty($graph) && count($graph) > 0) {
    $graphCol = 'col-md-5';
} else {
    $graphCol = 'col-md-12';
}
$afterGraph = $h->provide_m('metaAfterGraphDesc');
$FAQ = $h->provide_m('metaFAQ');
$halfFAQ = (!empty($FAQ) && count($FAQ) > 2) ? round(count($FAQ) / 2) : '';
$counter = 0;
$counter2 = 0;
if ($halfFAQ > 2) {
    $faqCol = 'col-md-6';
} else {
    $faqCol = 'col-md-12';
}
$sponsors = $h->provide_m('metaSponsors');
?>
    <div class="project-detail-page">
        <div class="provide-project-detail <?php echo esc_attr($noThumb) ?>">
            <?php
            if (has_post_thumbnail()) {
                echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
            }
            ?>
            <div class="project-intro">
                <h1><?php the_title() ?></h1>
                <?php echo wpautop($desc, true) ?>
                <?php if (!empty($customerName) || !empty($liveDemo) || !empty($category) || !empty($date) || !empty($tag)): ?>
                    <ul class="project-info">
                        <?php if (!empty($customerName)): ?>
                            <li><strong><?php esc_html_e('Customer', 'provide') ?>:</strong> <span><?php echo esc_html($customerName); ?></span></li>
                        <?php endif; ?>
                        <?php if (!empty($liveDemo)): ?>
                            <li><strong><?php esc_html_e('Live Demo', 'provide') ?>:</strong> <span><?php echo esc_html($liveDemo); ?></span></li>
                        <?php endif; ?>
                        <?php if (!empty($category)): ?>
                            <li><strong><?php esc_html_e('Category', 'provide') ?>:</strong> <span><?php echo esc_html($category); ?></span></li>
                        <?php endif; ?>
                        <?php if (!empty($date)):?>
                            <li><strong><?php esc_html_e('Date', 'provide') ?>:</strong> <span><?php echo $date ?></span></li>
                        <?php endif; ?>
                        <?php if (!empty($tag)): ?>
                            <li><strong><?php esc_html_e('Tags', 'provide') ?>:</strong> <span><?php echo esc_html($tag); ?></span></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
                <?php if (!empty($liveDemo)): ?>
                    <a class="color-btn" href="<?php echo esc_url($liveDemo) ?>" title=""><?php esc_html_e('Launch Project', 'provide') ?></a>
                <?php endif; ?>
            </div>
        </div><!-- Provide Project Detail -->
        <?php if (!empty($graphDesc) || (!empty($graph) && count($graph) > 0)): ?>
            <div class="project-strategies">
                <div class="row">
                    <?php if (!empty($graph) && count($graph) > 0): ?>
                        <div class="col-md-7">
                            <div id="graph"></div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($graphDesc)): ?>
                        <div class="<?php echo esc_attr($graphCol) ?>">
                            <?php echo wpautop($graphDesc, true) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div><!-- Project Strategies -->
        <?php endif; ?>
        <?php if (!empty($afterGraph)): ?>
            <div class="simple-text">
                <?php echo wpautop($afterGraph, true) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($FAQ) && count($FAQ) > 0): ?>
            <div class="row">
                <?php
                if (!empty($FAQ) && count($FAQ) > 0):
                    echo '<div class="' . esc_attr($faqCol) . ' pro-col"><div class="provide-accordion toggle style3">';
                    foreach ($FAQ as $f) {
                        if ($counter == $halfFAQ) {
                            break;
                        }
                        ?>
                        <div class="toggle-item wow zoomIn" data-wow-delay="1000ms">
                            <h2><?php echo esc_html($h->provide_set($f, 'metaFAQTitle')) ?></h2>
                            <div class="content">
                                <p><?php echo esc_html($h->provide_set($f, 'metaFAQDesc')) ?></p>
                            </div>
                        </div>
                        <?php
                        $counter++;
                    }
                    echo '</div></div>';
                endif;
                ?>
                <?php
                if (!empty($FAQ) && count($FAQ) > 0):
                    echo '<div class="' . esc_attr($faqCol) . ' pro-col"><div class="provide-accordion toggle style3">';
                    foreach ($FAQ as $f) {
                        if ($counter2 >= $halfFAQ) {
                            ?>
                            <div class="toggle-item wow zoomIn" data-wow-delay="1000ms">
                                <h2><?php echo esc_html($h->provide_set($f, 'metaFAQTitle')) ?></h2>
                                <div class="content">
                                    <p><?php echo esc_html($h->provide_set($f, 'metaFAQDesc')) ?></p>
                                </div>
                            </div>
                            <?php
                        }
                        $counter2++;
                    }
                    echo '</div></div>';
                endif;
                ?>
            </div>
        <?php endif; ?>
    </div>

<?php if (!empty($sponsors) && count($sponsors) > 0): ?>
    <section>
        <div class="block remove-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 pro-col">
                        <ul class="logos">
                            <?php
                            foreach ($sponsors as $s) {
                                echo '<li><a href="' . esc_url($h->provide_set($s, 'metaSponsorsLink')) . '" title="">
                                <img src="' . esc_url($h->provide_set($s, 'metaSponsorsLogo')) . '" alt=""/>
                                </a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php
if (!empty($graph) && count($graph) > 0) {
    provide_Media::provide_singleton()->provide_eq(array('morris'));
    $data = '';
    foreach ($graph as $g) {
        $data .= "{x: '" . $h->provide_set($g, 'metaGraphYear') . "', y: " . $h->provide_set($g, 'metaGraphStartValue') . ", z: " . $h->provide_set($g, 'metaGraphEndValue') . "}," . PHP_EOL;
    }
    $jsOutput = "jQuery(function () {
                        Morris.Area({
                            element: 'graph',
                            behaveLikeLine: true,
                            data: [
                                " . $data . "
                            ],
                            lineColors: ['#dddddd', '#3fcc81'],
                            xkey: 'x',
                            fillOpacity: 0.5,
                            ykeys: ['y', 'z'],
                            resize: true,
                            labels: ['" . esc_js(esc_html__('Profit', 'provide')) . "', '" . esc_js(esc_html__('Sales', 'provide')) . "']
                        });
                 
                 });";
    wp_add_inline_script('morris', $jsOutput);
}
?>