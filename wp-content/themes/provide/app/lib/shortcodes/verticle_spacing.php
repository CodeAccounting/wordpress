<?php

class provide_verticle_spacing_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_verticle_spacing($atts = null)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Verticle Spacing", 'provide'),
                "base" => "provide_verticle_spacing_output",
                "icon" => 'verticle_spacing.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "un-number",
                        "heading" => esc_html__('Height', 'provide'),
                        "param_name" => "height",
                        'min' => '1',
                        'max' => '100',
                        'step' => '1',
                        "description" => esc_html__('Enter the height of this section', 'provide')
                    )
                )
            );
            return apply_filters('provide_verticle_spacing_shortcode', $return);
        }
    }

    public static function provide_verticle_spacing_output($atts = null, $content = null)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        ?>
        <div class="gap" style="height:<?php echo esc_attr($height) ?>px !important;"></div>
        <?php
        $output = ob_get_contents();
        ob_clean();
        return $output;
    }

}
