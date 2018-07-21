<?php

class provide_modern_team_carousel_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_modern_team_carousel($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Modern Team Carousel With Skill", 'provide'),
                "base" => "provide_modern_team_carousel_output",
                "icon" => 'provide_modern_team_carousel_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Title:", 'provide'),
                        "param_name" => "title",
                        "description" => esc_html__("Enter the title for this section.", 'provide')
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => esc_html__("Description:", 'provide'),
                        "param_name" => "desc",
                        "description" => esc_html__("Enter the description for this section.", 'provide')
                    ),
                    array(
                        "type" => "un-multiselect",
                        "heading" => esc_html__("Select Members", 'provide'),
                        "param_name" => "members",
                        "value" => (new provide_Helper())->provide_posts('pr_team'),
                        "description" => esc_html__('Select team member from the list.', 'provide')
                    ),
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Company Skills', 'provide'),
                        'param_name' => 'skills',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Skill Name', 'provide'),
                                "param_name" => "skill_name",
                                "description" => esc_html__('Enter the skill name', 'provide')
                            ),
                            array(
                                "type" => "un-number",
                                "heading" => esc_html__("Skill Percentage", 'provide'),
                                "param_name" => "skill_percent",
                                "description" => esc_html__("Enter the skill percentage.", 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_modern_team_carousel_output', $return);
        }
    }

    public static function provide_modern_team_carousel_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $skillList = json_decode(urldecode($skills));
        if (!empty($members)) {
            $args = array(
                'post_type' => 'pr_team',
                'post_status' => 'publish',
                'post__in' => explode(',', $members),
                'ignore_sticky_posts' => true,
            );
            $query = new WP_Query($args);
            $counter = $counter2 = 0;
            ?>
            <div class="company-skills">
                <?php
                if ($query->have_posts()) {
                    ?>
                    <div class="team-carousel-wrapper">
                        <div id="team-carousel<?php echo esc_attr(self::$counter) ?>" class="team-carousel">
                            <div class="team-slide">
                                <?php
                                $i = new provide_Imagify();
                                $sizes = array('m' => '352x283', 'i' => '372x300', 'w' => '337x272');
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $designation = $h->provide_m('metaDesignation');
                                    $social = $h->provide_m('metaSocialProfiler');
                                    if (has_post_thumbnail()) {
                                        ?>
                                        <div class="member">
                                            <?php
                                            echo wp_kses($i->provide_thumb($sizes, TRUE, array(TRUE, TRUE, TRUE)), true);
                                            ?>
                                            <div class="member-hover">
                                                <h5><?php the_title() ?></h5>
                                                <i><?php echo esc_html($designation); ?></i>
                                                <?php if (!empty($social) && count($social) > 0): ?>
                                                    <div class="fancy-social">
                                                        <?php
                                                        foreach ($social as $s) {
                                                            echo '<a href="' . esc_url($h->provide_set($s, 'metaProfileLink')) . '" title=""><i class="fa ' . esc_attr($h->provide_set($s, 'metaProfileIcon')) . '"></i></a>';
                                                        }
                                                        ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php
                                        $counter++;
                                        $counter2++;
                                        if ($counter2 == count(explode(',', $members))) {
                                            break;
                                        }
                                        if ($counter % 2 === 0) {
                                            echo '</div><div class="team-slide">';
                                        }
                                    }
                                }
                                wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="about-us">
                    <h2><?php echo esc_html($title) ?></h2>
                    <p><?php echo esc_html($desc) ?></p>
                    <?php
                    if (!empty($skillList) && count($skillList) > 0) {
                        echo '<div class="provide-skills">';
                        foreach ($skillList as $skill) {
                            ?>
                            <div class="provide-bar wow fadeIn">
                                <strong><?php echo esc_html($h->provide_set($skill, 'skill_name')) ?> - (<?php echo esc_html($h->provide_set($skill, 'skill_percent')) ?>%)</strong>
                                <div class="progress">
                                    <div class="progress-bar" style="width:<?php echo esc_html($h->provide_set($skill, 'skill_percent')) ?>%;"></div>
                                </div>
                            </div>
                            <?php
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <?php
            provide_Media::provide_singleton()->provide_eq(array('owl'));
            $loop = (!empty($members)) ? 'true' : 'false';
            $jsOutput = "
            jQuery(window).on('load',function(){
                    jQuery('#team-carousel" . self::$counter . "').owlCarousel({
                        autoplay:true,
                        smartSpeed:1000,
                        loop:" . esc_js($loop) . ",
                        dots:false,
                        nav:true,
                        margin:0,
                        mouseDrag:true,
                        items:2,
                        URLhashListener:true,
                        autoplayHoverPause:true,		        
                        autoHeight:true,
                        onInitialized:centralize,
                        responsive :{
                            1200 :{items:2},		   	
                            980 :{items:2},		   	
                            767 :{items:2},		   	
                            480 :{items:2},		   		
                            0 :{items:1},		   	
                        }
                    });
                   	function centralize(){
                        var company_height = jQuery('.company-skills').innerHeight();
                        var about_height = jQuery('.about-us').innerHeight();
                        var remaining_height = company_height - about_height;
                        var margin_height = remaining_height / 2;
                        jQuery('.about-us').css({
                            'margin-top':margin_height
                        });
                    }
                    });";
            wp_add_inline_script('owl', $jsOutput);
        }
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
