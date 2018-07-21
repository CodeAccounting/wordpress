<?php

class provide_our_team_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_our_team($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Our Team", 'provide'),
                "base" => "provide_our_team_output",
                "icon" => 'provide_our_team_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Column", 'provide'),
                        "param_name" => "column",
                        "value" => array(
                            esc_html__('4 Col', 'provide') => 'col-md-3',
                            esc_html__('3 Col', 'provide') => 'col-md-4',
                        ),
                        "description" => esc_html__("Select column from the list", 'provide')
                    ),
                    array(
                        "type" => "un-multiselect",
                        "heading" => esc_html__("Select Post", 'provide'),
                        "param_name" => "post",
                        "value" => (new provide_Helper())->provide_posts('pr_team'),
                        "description" => esc_html__("Select team member from the list", 'provide')
                    )
                )
            );
            return apply_filters('provide_our_team_output', $return);
        }
    }

    public static function provide_our_team_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '322x367', 'i' => '343x391', 'w' => '270x308');
        $args = array(
            'post_type' => 'pr_team',
            'post_status' => 'publish',
            'ignore_sticky_posts' => true,
            'post__in' => explode(',', $post)
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            ?>
            <div class="provide-team">
                <div class="row">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                        $noThumb = (!has_post_thumbnail()) ? 'no-thumbnail' : '';
                        $designation = $h->provide_m('metaDesignation');
                        $social = $h->provide_m('metaSocialProfiler');
                        ?>
                        <div class="<?php echo esc_attr($column) ?>">
                            <div class="provide-member wow flipInY" data-wow-delay="1000ms">
                                <div class="member-img <?php echo esc_attr($noThumb) ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
                                    }
                                    ?>
                                    <?php if (!empty($social) && count($social) > 0): ?>
                                        <div class="social">
                                            <?php
                                            foreach ($social as $s) {
                                                echo '<a href="' . esc_url($h->provide_set($s, 'metaProfileLink')) . '" title=""><i class="fa ' . esc_attr($h->provide_set($s, 'metaProfileIcon')) . '"></i></a>';
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h4><a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a></h4>
                                <i><?php echo esc_html($designation) ?></i>
                            </div><!-- Member -->
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
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
