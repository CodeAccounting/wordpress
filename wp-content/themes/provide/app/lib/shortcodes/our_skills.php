<?php

class provide_our_skills_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_our_skills($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Our Skills", 'provide'),
                "base" => "provide_our_skills_output",
                "icon" => 'provide_our_skills_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Style", 'provide'),
                        "param_name" => "layout",
                        "value" => array(
                            esc_html__('Light', 'provide') => '',
                            esc_html__('Dark', 'provide') => 'style2',
                        ),
                        "description" => esc_html__("Select style from the list", 'provide')
                    ),
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Skills', 'provide'),
                        'param_name' => 'our_skills',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Skill Name', 'provide'),
                                "param_name" => "skill_name",
                                "description" => esc_html__('Enter the feature', 'provide')
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
            return apply_filters('provide_our_skills_output', $return);
        }
    }

    public static function provide_our_skills_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $ourSkills = json_decode(urldecode($our_skills));
        $delay = 0;
        if (!empty($ourSkills) && count($ourSkills) > 0) {
            echo '<div class="provide-skills ' . esc_attr($layout) . '">';
            foreach ($ourSkills as $skill) {
                ?>
                <div class="provide-bar wow fadeInRight" data-wow-delay="<?php echo esc_attr($delay += 500) ?>ms">
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
        <?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
