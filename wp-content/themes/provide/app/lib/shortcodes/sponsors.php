<?php

class provide_sponsors_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_sponsors($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Sponsors", 'provide'),
                "base" => "provide_sponsors_output",
                "icon" => 'provide_sponsors_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Sponsors', 'provide'),
                        'param_name' => 'sponsors_list',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "attach_image",
                                "heading" => esc_html__('Logo', 'provide'),
                                "param_name" => "logo",
                                "description" => esc_html__('Upload logo of this sponsor', 'provide')
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Webiste Url', 'provide'),
                                "param_name" => "url",
                                "description" => esc_html__('Enter the website url of this sponsor', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_sponsors_output', $return);
        }
    }

    public static function provide_sponsors_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        provide_Media::provide_singleton()->provide_eq(array('provide-select2'));
        ob_start();
        $sponsors = json_decode(urldecode($sponsors_list));
        if (!empty($sponsors) && count($sponsors) > 0) {
            echo '<ul class="logos">';
            foreach ($sponsors as $s) {
                $imgSrc = wp_get_attachment_image_src($h->provide_set($s, 'logo'), 'full');
                if ($h->provide_set($imgSrc, '0') != '') {
                    ?>
                    <li>
                        <a target="_blank" href="<?php echo esc_url($h->provide_set($s, 'url')) ?>" title="">
                            <img src="<?php echo esc_url($h->provide_set($imgSrc, '0')) ?>" alt=""/>
                        </a>
                    </li>
                    <?php
                }
            }
            echo '</ul>';
        }
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
