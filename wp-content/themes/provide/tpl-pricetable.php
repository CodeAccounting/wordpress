<?php
/*
 * Template Name:   Price Table Listing
 * */
$h = new provide_Helper();
$h->provide_header();
$opt = $h->provide_opt();
$h->provide_headerTop(get_the_ID());
$column = $h->provide_column(get_the_ID());
$blog = new provide_blog();
$i = new provide_Imagify();
if ($column == 'col-md-12') {
    $innerCol = 'col-md-4';
} else if ($column == 'col-md-9') {
    $innerCol = 'col-md-6';
}
$sizes = array('m' => '321x262', 'i' => '321x262', 'w' => '321x262');
?>
    <section>
        <div class="block">
            <div class="container">
                <div class="row">
                    <?php $h->provide_themeLeftSidebar(get_the_ID()) ?>
                    <div class="<?php echo esc_attr($column) ?> pro-col">
                        <?php
                        $args = array(
                            'post_type' => 'pr_price_table',
                            'post_status' => 'publish',
                            'posts_per_page' => ( $h->provide_set( $opt, 'optPriceTableoPagination' ) != '' ) ? $h->provide_set( $opt, 'optPriceTableoPagination' ) : get_option( 'posts_per_page' ),
                            'ignore_sticky_posts' => FALSE,
                            'paged' => (isset($wp_query->query['paged'])) ? $wp_query->query['paged'] : 1,
                        );
                        $query = new WP_Query($args);
                        if ($query->have_posts()) {
                            ?>
                            <div class="provide-pricings">
                                <div class="row">
                                    <?php
                                    while ($query->have_posts()) {
                                        $query->the_post();
                                        $noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
                                        $bg = $h->provide_m('metaBG');
                                        $price = $h->provide_m('metaPlanPrice');
                                        $show_plan = $h->provide_m('show_pricing_plan');
                                        $plan = $h->provide_m('metaPlanType');
                                        $symbol = $h->provide_m('metaCurrencySymbol');
                                        $btnText = $h->provide_m('metaButtonText');
                                        $btnLink = $h->provide_m('metaButtonLink');
                                        $features = $h->provide_m('metaPlanFeatures');
                                        $package = $h->provide_m('metaPlanType');
                                        $src = '';
                                        
                                        if (!empty($bg)) {
                                            $src = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $bg, 'c', true);
                                        }else {
                                            $src = provide_Uri. "/partial/images/pricetable-bg.png";
                                        }
                                        ?>
                                        <div class="<?php echo esc_attr($innerCol) ?>">
                                            <div class="price-table" style="background-image: url(<?php echo esc_url($src) ?>)">
                                                <h3>
                                                    <i><?php echo esc_html($symbol) ?></i> <?php echo esc_html($price) ?> <i>
                                                        <?php if($show_plan == 'on') : ?>
                                                            <?php echo ($package) ? '/ '.esc_html(ucfirst(str_replace('_', ' ', $package))) : ''; ?>
                                                        <?php endif; ?>
                                                    </i>
                                                </h3>
                                                <strong><?php the_title() ?></strong>
                                                <?php if (!empty($features) && count($features) > 0): ?>
                                                    <ul>
                                                        <?php
                                                        foreach ($features as $feature) {
                                                            echo '<li>' . $feature . '</li>';
                                                        }
                                                        ?>
                                                    </ul>
                                                <?php endif; ?>
                                                <?php if (!empty($btnText)): ?>
                                                    <a class="dark-btn" href="<?php echo esc_url($btnLink) ?>" title=""><?php echo esc_html($btnText) ?></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    $h->provide_pagi(array('total' => $query->max_num_pages));
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php $h->provide_themeRightSidebar(get_the_ID()) ?>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();
