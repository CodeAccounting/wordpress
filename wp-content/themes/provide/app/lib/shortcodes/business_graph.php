<?php

class provide_business_graph_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_business_graph($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Business Graph", 'provide'),
                "base" => "provide_business_graph_output",
                "icon" => 'provide_business_graph_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Graph Value', 'provide'),
                        'param_name' => 'business_graph',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "un-number",
                                "heading" => esc_html__('Year', 'provide'),
                                "param_name" => "year",
                                "description" => esc_html__('Enter the year', 'provide')
                            ),
                            array(
                                "type" => "un-number",
                                "heading" => esc_html__('Start Value', 'provide'),
                                "param_name" => "s_val",
                                "description" => esc_html__('Enter the start value', 'provide')
                            ),
                            array(
                                "type" => "un-number",
                                "heading" => esc_html__('End Value', 'provide'),
                                "param_name" => "e_val",
                                "description" => esc_html__('Enter the end value', 'provide')
                            ),
                        )
                    ),
                )
            );
            return apply_filters('provide_business_graph_output', $return);
        }
    }

    public static function provide_business_graph_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $graph = json_decode(urldecode($business_graph));
        if (!empty($graph) && count($graph) > 0) {
            provide_Media::provide_singleton()->provide_eq(array('morris'));
            echo '<div id="graph' . self::$counter . '"></div>';
            $data = '';
            foreach ($graph as $g) {
                $data .= "{x: '" . $h->provide_set($g, 'year') . "', y: " . $h->provide_set($g, 's_val') . ", z: " . $h->provide_set($g, 'e_val') . "}," . PHP_EOL;
            }
            $jsOutput = "jQuery(function () {
                        Morris.Area({
                            element: 'graph" . esc_js(self::$counter) . "',
                            behaveLikeLine: true,
                            data: [
                                " . $data . "
                            ],
                            lineColors: ['#dddddd', '#3fcc81'],
                            xkey: 'x',
                            fillOpacity: 0.5,
                            ykeys: ['y', 'z'],
                            resize: true,
                            labels: ['" . esc_js(esc_html__('Profit', 'provide')) . "', '" . esc_js(esc_html__('Sales', 'provide')) . "']
                        });
                    });";
            wp_add_inline_script('morris', $jsOutput);
        }
        self::$counter++;
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
