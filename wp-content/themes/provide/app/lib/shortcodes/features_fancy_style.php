<?php

class provide_features_fancy_style_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_features_fancy_style($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Features Fancy Style", 'provide'),
                "base" => "provide_features_fancy_style_output",
                "icon" => 'provide_features_fancy_style_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Title", 'provide'),
                        "param_name" => "title",
                        "description" => esc_html__("Enter the title for this section.", 'provide')
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => esc_html__("Description", 'provide'),
                        "param_name" => "desc",
                        "description" => esc_html__("Enter the description for this section.", 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Button Text", 'provide'),
                        "param_name" => "btn_text",
                        "value" => esc_html__('Read More', 'provide'),
                        "description" => esc_html__("Enter the button text for this section.", 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Button Link", 'provide'),
                        "param_name" => "btn_link",
                        "description" => esc_html__("Enter the button link for this section.", 'provide')
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Side Image", 'provide'),
                        "param_name" => "image",
                        "description" => esc_html__("Upload side image for this section.", 'provide')
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Style", 'provide'),
                        "param_name" => "layout",
                        "value" => array(
                            esc_html__('With Side Image', 'provide') => '',
                            esc_html__('Without Side Image', 'provide') => 'style2',
                        ),
                        "description" => esc_html__("Select style from the list", 'provide')
                    ),
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Feature\'s', 'provide'),
                        'param_name' => 'features_fancy_style',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Feature\'s List', 'provide'),
                                "param_name" => "feature",
                                "description" => esc_html__('Enter the feature', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_features_fancy_style_output', $return);
        }
    }

    public static function provide_features_fancy_style_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $ourFeatures = json_decode(urldecode($features_fancy_style));
        $getSrc = wp_get_attachment_image_src($image, 'full');
        ?>
        <div class="why-we <?php echo esc_attr($layout) ?>">
            <?php if ($h->provide_set($getSrc, '0') != ''): ?>
                <img src="<?php echo esc_url($h->provide_set($getSrc, '0')) ?>" alt=""/>
            <?php endif; ?>
            <div class="why-we-text">
                <h3><?php echo esc_html($title) ?></h3>
                <p><?php echo esc_html($desc) ?></p>
                <?php
                if (!empty($ourFeatures) && count($ourFeatures) > 0) {
                    echo '<ul>';
                    foreach ($ourFeatures as $f) {
                        echo '<li><i class="fa fa-check-circle-o"></i> ' . $h->provide_set($f, 'feature') . '</li>';
                    }
                    echo '</ul>';
                }
                ?>
                <?php if (!empty($btn_text)): ?>
                    <a class="color-btn" href="<?php echo esc_url($btn_link) ?>" title=""><?php echo esc_html($btn_text) ?></a>
                <?php endif; ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
