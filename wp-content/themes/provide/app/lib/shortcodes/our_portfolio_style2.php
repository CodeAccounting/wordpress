<?php

class provide_our_portfolio_style2_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_our_portfolio_style2($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Our Portfolio Style 2", 'provide'),
                "base" => "provide_our_portfolio_style2_output",
                "icon" => 'provide_our_portfolio_style2_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "un-multiselect",
                        "heading" => esc_html__('Category', 'provide'),
                        "param_name" => "category",
                        "value" => (new provide_Helper())->provide_trems(array('taxonomy' => 'portfolio_cat'), true),
                        "description" => esc_html__('Select category for posts', 'provide')
                    ),
                    array(
                        "type" => "un-number",
                        "heading" => esc_html__('Number of Posts', 'provide'),
                        "param_name" => "number",
                        'min' => '1',
                        'max' => '100',
                        'step' => '1',
                        "description" => esc_html__('Enter the number of posts to show. Note: this number is show each category post that you selected.', 'provide')
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Sort By:", 'provide'),
                        "param_name" => "sorting",
                        "value" => array_flip(array(
                                '' => '',
                                'random' => esc_html__('Random posts', 'provide'),
                                'asc_title' => esc_html__('Alphabetical A-Z', 'provide'),
                                'desc_title' => esc_html__('Alphabetical Z-A', 'provide'),
                                'author' => esc_html__('Posted by author', 'provide'),
                                'commented' => esc_html__('Most commented posts', 'provide'),
                                'today' => esc_html__('Today posts', 'provide'),
                                'today_rand' => esc_html__('Random posts today', 'provide'),
                                'weekly' => esc_html__('Weekly posts', 'provide'),
                                'weekly_random' => esc_html__('Random posts from last 7 days', 'provide'),
                                'upcoming' => esc_html__('Future upcoming posts', 'provide'),
                                'popular' => esc_html__('Most popular posts', 'provide'),
                                'reviewed' => esc_html__('Highest rated (review) posts', 'provide'),
                                'featured' => esc_html__('Featured', 'provide'),
                            )
                        ),
                        "description" => esc_html__("Choose Sorting by.", 'provide')
                    ),
                    array(
                        "type" => "un_toggle",
                        "heading" => esc_html__("View All", 'provide'),
                        "param_name" => "view_all",
                        'value' => 'off',
                        'default_set' => FALSE,
                        'options' => array(
                            'on' => array(
                                'on' => esc_html__('Yes', 'provide'),
                                'off' => esc_html__('No', 'provide'),
                            ),
                        ),
                        "description" => esc_html__("Enable view all bottom bar.", 'provide'),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__('View All Text', 'provide'),
                        "param_name" => "v_text",
                        "description" => esc_html__('Enter the text of view all', 'provide'),
                        'dependency' => array(
                            'element' => 'view_all',
                            'value' => array('on')
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Page Link", 'provide'),
                        "param_name" => "v_link",
                        "value" => array_flip((new provide_Helper())->provide_posts('page')),
                        "description" => esc_html__("Select the page for view all portfolio", 'provide'),
                        'dependency' => array(
                            'element' => 'view_all',
                            'value' => array('on')
                        ),
                    ),
                )
            );
            return apply_filters('provide_our_portfolio_style2_output', $return);
        }
    }

    public static function provide_our_portfolio_style2_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        provide_Media::provide_singleton()->provide_eq(array('html5lightbox', 'provide-isotope'));
        ob_start();
        $sizes = array('m' => '322x217', 'i' => '354x239', 'w' => '383x259');
        $lightBox = array('m' => '94x85', 'i' => '94x85', 'w' => '94x85');
        static $_cats = 0;
        $cats = explode(',', $category);
        ?>
        <div class="projects style2">
            <?php
            if (!empty($cats) && count($cats) > 0):
                ?>
                <section class="options style2">
                    <div class="option-isotop">
                        <ul id="filter" class="option-set filters-nav" data-option-key="filter">
                            <li><a href="" class="selected" data-option-value="*"><?php esc_html_e('All', 'provide') ?></a></li>
                            <?php
                            foreach ($cats as $cat):
                                $term = get_term_by('slug', $cat, 'portfolio_cat');
                                $filter = strtolower(str_replace(' ', '_', $term->slug)) . '_' . $_cats;
                                ?>
                                <li>
                                    <a href="#<?php echo esc_attr($filter) ?>" data-option-value=".<?php echo esc_attr($filter) ?>">
                                        <?php echo esc_html(ucwords($term->name)) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </section>
            <?php endif; ?>
            <div class="row">
                <div class="masonary">
                    <?php
                    foreach ($cats as $cat) {
                        $term = get_term_by('slug', $cat, 'portfolio_cat');
                        $filter = strtolower(str_replace(' ', '_', $term->slug)) . '_' . $_cats;
                        $args = array(
                            'post_status' => 'publish',
                            'posts_per_page' => $number,
                            'ignore_sticky_posts' => true,
                        );
                        if (!empty($category)) {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'portfolio_cat',
                                    'terms' => $cat,
                                    'field' => 'slug'
                                )
                            );
                        }
                        $args = array_merge($args, $h->provide_queryFilter($sorting, 'pr_portfolio'));
                        $query = new WP_Query($args);
                        if ($query->have_posts()) {
                            $i = new provide_Imagify();
                            while ($query->have_posts()) {
                                $query->the_post();
                                $noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
                                $fullSrc = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                                $lightBoxUrl = (has_post_thumbnail()) ? $i->provide_thumb($lightBox, false, array(TRUE, TRUE, TRUE), $h->provide_set($fullSrc, '0'), 'c', true) : '';
                                ?>
                                <div class="col-md-4 <?php echo esc_attr($filter) ?>">
                                    <div class="provide-project style3 wow fadeInDown <?php echo esc_attr($noThumb) ?>">
                                        <?php
                                        if (has_post_thumbnail()) {
                                            echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
                                        }
                                        ?>
                                        <div class="project-hover">
                                            <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                                            <div class="project-links">
                                                <a href="<?php the_permalink() ?>" title=""><i class="fa fa-link"></i></a>
                                                <a class="html5lightbox" data-thumbnail="<?php echo esc_url($lightBoxUrl) ?>" data-group="set1" title="<?php the_title() ?>" href="<?php echo esc_url($h->provide_set($fullSrc, '0')) ?>">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            wp_reset_postdata();
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        if ($view_all == 'on'):
            $link = (!empty($v_link)) ? get_page_link($v_link) : '';
            ?>
            <a class="huge-btn" href="<?php echo esc_url($link) ?>" title=""><?php echo esc_html($v_text) ?> <i class="fa fa-arrows-h"></i></a>
            <?php
        endif;
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}