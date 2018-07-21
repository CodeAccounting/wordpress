<?php

class provide_simple_feature_list_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_simple_feature_list($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Simple Features List", 'provide'),
                "base" => "provide_simple_feature_list_output",
                "icon" => 'provide_simple_feature_list_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Features', 'provide'),
                        'param_name' => 'simple_feature_list',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Name', 'provide'),
                                "param_name" => "name",
                                "description" => esc_html__('Enter the feature name', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_simple_feature_list_output', $return);
        }
    }

    public static function provide_simple_feature_list_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $list = json_decode(urldecode($simple_feature_list));
        if (!empty($list) && count($list) > 0) {
            echo '<ul class="pro-list">';
            foreach ($list as $l) {
                echo '<li><i class="fa fa-check-circle-o"></i> ' . $h->provide_set($l, 'name') . '</li>';
            }
            echo '</ul>';
        }
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
