<?php

class provide_overlay_blog_VC_ShortCode extends provide_VC_ShortCode {

    public static function provide_overlay_blog($atts = NULL) {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Overlay Blog Posts", 'provide'),
                "base" => "provide_overlay_blog_output",
                "icon" => 'provide_overlay_blog_output.png',
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
                        "heading" => esc_html__("Column:", 'provide'),
                        "param_name" => "columns",
                        "value" => array_flip(array(
                            '' => '',
                            'col-md-6' => esc_html__('Two Column', 'provide'),
                            'col-md-4' => esc_html__('Three Column', 'provide'),
                            'col-md-3' => esc_html__('Four Column', 'provide'),
                            )
                        ),
                        "description" => esc_html__("Choose column for post layout", 'provide')
                    ),
                    array(
                        "type" => "un-number",
                        "heading" => esc_html__('Content Limit', 'provide'),
                        "param_name" => "limit",
                        'min' => '1',
                        'max' => '100',
                        'step' => '1',
                        "description" => esc_html__('Enter post description character limit in digits.', 'provide')
                    ),
                )
            );
            return apply_filters('provide_overlay_blog_output', $return);
        }
    }

    public static function provide_overlay_blog_output($atts = NULL, $content = NULL) {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '270x310', 'i' => '270x310', 'w' => '270x310');
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


                <div class="row">
                    <?php 
                        while($query->have_posts()) : $query->the_post(); 
                        $thumbnail = $h->provide_set(wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'), '0');
                    ?>
                    <div class="<?php echo esc_attr($columns); ?>">
                        <div class="overlay-post">
                            <a href="<?php the_permalink(); ?>" title=""><?php echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true); ?></a>
                            <div class="overlay-detail">
                                <ul class="overlay-meta">
                                    <li><?php echo esc_html(get_the_date(get_option('date_format'))); ?></li>
                                    <li><?php comments_number(); ?></li>
                                </ul>
                                <h4><a href="<?php the_permalink(); ?>" title="<?php the_title() ?>"><?php the_title(); ?></a></h4>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                    <?php $h->provide_pagi(array('total' => $query->max_num_pages)); ?>
                </div>


            <?php
        }
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
