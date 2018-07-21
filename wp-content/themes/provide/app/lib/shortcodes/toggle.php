<?php

class provide_toggle_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_toggle($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Toggle", 'provide'),
                "base" => "provide_toggle_output",
                "icon" => 'provide_toggle_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__('Toggle Style', 'provide'),
                        "param_name" => "style",
                        "value" => array(
                            esc_html__('style 1', 'provide') => '',
                            esc_html__('style 2', 'provide') => 'style2',
                            esc_html__('style 3', 'provide') => 'style3'
                        ),
                        "description" => esc_html__('Select the toggle style from the list', 'provide')
                    ),
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Toggle\'s', 'provide'),
                        'param_name' => 'toggle',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Toggle Title', 'provide'),
                                "param_name" => "title",
                                "description" => esc_html__('Enter the title for this toggle', 'provide')
                            ),
                            array(
                                "type" => "attach_image",
                                "heading" => esc_html__("Image:", 'provide'),
                                "param_name" => "image",
                                "description" => esc_html__("Upload Image for this toggle.", 'provide')
                            ),
                            array(
                                "type" => "textarea",
                                "heading" => esc_html__('Short Content', 'provide'),
                                "param_name" => "desc",
                                "description" => esc_html__('Enter the content for this toggle', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_toggle_output', $return);
        }
    }

    public static function provide_toggle_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '125x82', 'i' => '125x82', 'w' => '125x82');
        $toggles = json_decode(urldecode($toggle));
        if (!empty($toggles) && count($toggles) > 0) {
            ?>
            <div class="provide-accordion toggle <?php echo esc_attr($style) ?>">
                <?php
                foreach ($toggles as $t) {
                    if ($h->provide_set($t, 'image') != '') {
                        $getSrc = wp_get_attachment_image_src($h->provide_set($t, 'image'), 'full');
                        $imgSrc = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $h->provide_set($getSrc, '0'), 'c', true);
                    }
                    ?>
                    <div class="toggle-item">
                        <h2><?php echo esc_html($h->provide_set($t, 'title')) ?></h2>
                        <div class="content">
                            <?php
                            if ($h->provide_set($t, 'image') != '') {
                                if ($h->provide_set($getSrc, '0') != '') {
                                    echo '<img class="alignleft" src="' . esc_url($imgSrc) . '" alt=""/>';
                                }
                            }
                            ?>
                            <p><?php echo esc_html($h->provide_set($t, 'desc')) ?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
