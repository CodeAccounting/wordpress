<?php
/*
 * Template Name:   Portfolio Listing Style 2
 * */
$h = new provide_Helper();
$h->provide_header();
$opt = $h->provide_opt();
$h->provide_headerTop(get_the_ID());
$column = $h->provide_column(get_the_ID());
$blog = new provide_blog();
$i = new provide_Imagify();
if ($column == 'col-md-12') {
    $innerCol = 'col-md-3';
} else if ($column == 'col-md-9') {
    $innerCol = 'col-md-4';
}

if ($column == 'col-md-12') {
    $sizes = array(
        array('m' => '322x292', 'i' => '356x323', 'w' => '334x256'),
        array('m' => '322x292', 'i' => '356x323', 'w' => '672x257'),
        array('m' => '322x292', 'i' => '356x323', 'w' => '334x256')
    );
} else if ($column == 'col-md-9') {
    $sizes = array(
        array('m' => '322x292', 'i' => '356x323', 'w' => '248x190'),
        array('m' => '322x292', 'i' => '356x323', 'w' => '500x191'),
        array('m' => '322x292', 'i' => '356x323', 'w' => '248x190')
    );
}
$colsArray = array('col-md-3', 'col-md-6', 'col-md-3');
$lightBox = array('m' => '94x85', 'i' => '94x85', 'w' => '94x85');
provide_Media::provide_singleton()->provide_eq(array('html5lightbox', 'provide-isotope'));
$counter = 0;
?>
    <section>
        <div class="block">
            <div class="">
                <div class="row">
                    <?php $h->provide_themeLeftSidebar(get_the_ID()) ?>
                    <div class="<?php echo esc_attr($column) ?> pro-col">
                        <?php
                        $args = array(
                            'post_type' => 'pr_portfolio',
                            'post_status' => 'publish',
                            'posts_per_page' => ( $h->provide_set( $opt, 'optPortfolio2Pagination' ) != '' ) ? $h->provide_set( $opt, 'optPortfolio2Pagination' ) : get_option( 'posts_per_page' ),
                            'ignore_sticky_posts' => FALSE,
                            'paged' => (isset($wp_query->query['paged'])) ? $wp_query->query['paged'] : 1,
                        );
                        $query = new WP_Query($args);
                        if ($query->have_posts()) {
                            ?>
                            <div class="projects style3">
                                <div class="row">
                                    <div class="masonary">
                                        <?php
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                            $noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
                                            $gallery = $h->provide_m('metaGallery');
                                            $fullSrc = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                                            $lightBoxUrl = (has_post_thumbnail()) ? $i->provide_thumb($lightBox, false, array(TRUE, TRUE, TRUE), $h->provide_set($fullSrc, '0'), 'c', true) : '';
                                            ?>
                                            <div class="<?php echo esc_attr($colsArray[$counter]) ?>">
                                                <div class="provide-project styl2 wow fadeInDown <?php echo esc_attr($noThumb) ?>">
                                                    <?php
                                                    if (has_post_thumbnail()) {
                                                        echo wp_kses($i->provide_thumb($sizes[$counter], TRUE, array(TRUE, TRUE, TRUE)), true);
                                                    }
                                                    ?>
                                                    <div class="project-hover">
                                                        <div class="project-links">
                                                            <a href="<?php the_permalink() ?>" title=""><i class="fa fa-link"></i></a>
                                                            <a class="html5lightbox" data-thumbnail="<?php echo esc_url($lightBoxUrl) ?>" data-group="set1" title="<?php the_title() ?>" href="<?php echo esc_url($h->provide_set($fullSrc, '0')) ?>">
                                                                <i class="fa fa-search"></i>
                                                            </a>
                                                        </div>
                                                        <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $counter++;
                                            if ($counter == '3') {
                                                $counter = 0;
                                            }
                                        }
                                        ?>
                                    </div>
                                    <?php
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
