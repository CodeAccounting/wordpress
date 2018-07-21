<?php

class provide_latest_news_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_latest_news($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Latest News", 'provide'),
                "base" => "provide_latest_news_output",
                "icon" => 'provide_latest_news_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "un-multiselect",
                        "heading" => esc_html__('Category', 'provide'),
                        "param_name" => "category",
                        "value" => (new provide_Helper())->provide_cat(array(), false),
                        "description" => esc_html__('Select category for post', 'provide')
                    ),
                    array(
                        "type" => "un-number",
                        "heading" => esc_html__('Number of Posts', 'provide'),
                        "param_name" => "number",
                        'min' => '1',
                        'max' => '100',
                        'step' => '1',
                        "description" => esc_html__('Enter the number of posts to show.', 'provide')
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
                        "type" => "dropdown",
                        "heading" => esc_html__("Column", 'provide'),
                        "param_name" => "col",
                        "value" => array_flip(array(
                                'col-md-6' => esc_html__('2 Column', 'provide'),
                                'col-md-4' => esc_html__('3 Column', 'provide'),
                                'col-md-3' => esc_html__('4 Column', 'provide')
                            )
                        ),
                        "description" => esc_html__("Choose Column from the list", 'provide')
                    ),
                    array(
                        "type"        => "un_toggle",
                        "heading"     => esc_html__( "Show Post Date", 'provide' ),
                        "param_name"  => "post_date",
                        'value'       => 'off',
                        'default_set' => false,
                        'options'     => array(
                            'on' => array(
                                'on'  => esc_html__( 'Yes', 'provide' ),
                                'off' => esc_html__( 'No', 'provide' ),
                            ),
                        ),
                        "description" => esc_html__( "hide/show blog post date", 'provide' ),
                    ),
                    array(
                        "type"        => "un_toggle",
                        "heading"     => esc_html__( "Show Post Author", 'provide' ),
                        "param_name"  => "post_author",
                        'value'       => 'off',
                        'default_set' => false,
                        'options'     => array(
                            'on' => array(
                                'on'  => esc_html__( 'Yes', 'provide' ),
                                'off' => esc_html__( 'No', 'provide' ),
                            ),
                        ),
                        "description" => esc_html__( "hide/show blog post author", 'provide' ),
                    ),
                    array(
                        "type"        => "un_toggle",
                        "heading"     => esc_html__( "Show Post Comments", 'provide' ),
                        "param_name"  => "post_comment",
                        'value'       => 'off',
                        'default_set' => false,
                        'options'     => array(
                            'on' => array(
                                'on'  => esc_html__( 'Yes', 'provide' ),
                                'off' => esc_html__( 'No', 'provide' ),
                            ),
                        ),
                        "description" => esc_html__( "hide/show blog post comments number", 'provide' ),
                    ),
                    array(
                        "type"        => "un_toggle",
                        "heading"     => esc_html__( "Show Post Views", 'provide' ),
                        "param_name"  => "post_views",
                        'value'       => 'off',
                        'default_set' => false,
                        'options'     => array(
                            'on' => array(
                                'on'  => esc_html__( 'Yes', 'provide' ),
                                'off' => esc_html__( 'No', 'provide' ),
                            ),
                        ),
                        "description" => esc_html__( "hide/show blog post comments number", 'provide' ),
                    ),
                )
            );
            return apply_filters('provide_latest_news_output', $return);
        }
    }

    public static function provide_latest_news_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        
        $i = new provide_Imagify();
        $sizes = array('m' => '333x220', 'i' => '303x228', 'w' => '370x279');
        $args = array(
            'post_status' => 'publish',
            'posts_per_page' => $number,
            'ignore_sticky_posts' => true,
        );
        if (!empty($category)) {
            $args['category__in'] = explode(',', $category);
        }
        $args = array_merge($args, $h->provide_queryFilter($sorting, 'post'));
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            ?>
            <div class="latest-news">
                <div class="row">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        $authorName = ucwords(get_the_author());
                        $noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
                        ?>
                        <div class="<?php echo esc_attr($col) ?>">
                            <div class="provide-news wow fadeIn">
                                <div class="news-img <?php echo esc_attr($noThumb) ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
                                        if($post_date == 'on') {
                                            echo '<span>' . strtoupper($h->provide_date(false, 'd M')) . '</span>';
                                        }
                                    }
                                    ?>
                                </div>
                                <h3><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                                <ul class="meta">
                                    <?php if($post_author == 'on') : ?>
                                    <li class="posted-by"><?php esc_html_e('by', 'provide') ?> <a href="<?php echo esc_url($h->provide_authorLink(false)) ?>" title=""><?php echo esc_html($authorName) ?></a></li>
                                    <?php endif; ?>
                                    <?php if($post_comment == 'on') : ?>
                                    <li><i class="fa fa-comments"></i> <?php echo esc_html($h->provide_comments(get_the_ID(), false)) ?></li>
                                    <?php endif; ?>
                                    <?php if($post_views == 'on') : ?>
                                    <li><i class="fa fa-eye"></i> <?php echo esc_html($h->provide_getView(get_the_ID(), false)) ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div><!-- Provide News -->
                        </div>

                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
            <?php
        }
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
