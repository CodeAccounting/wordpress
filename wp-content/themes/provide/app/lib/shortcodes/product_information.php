<?php

class provide_product_information_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_product_information($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Product Information", 'provide'),
                "base" => "provide_product_information_output",
                "icon" => 'provide_product_information_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Product Features', 'provide'),
                        'param_name' => 'p_f',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Title', 'provide'),
                                "param_name" => "f_title",
                                "description" => esc_html__('Enter the feature title', 'provide')
                            ),
                            array(
                                "type" => "textarea",
                                "heading" => esc_html__('Short Description', 'provide'),
                                "param_name" => "f_desc",
                                "description" => esc_html__('Enter the short description', 'provide')
                            ),
                            array(
                                "type" => "iconpicker",
                                "heading" => esc_html__("Icon", 'provide'),
                                "param_name" => "f_icon",
                                "description" => esc_html__("Select the icon from the list.", 'provide')
                            ),
                        )
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__('Image', 'provide'),
                        "param_name" => "image",
                        "description" => esc_html__('Upload Image for this section', 'provide')
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
                                "param_name" => "t_title",
                                "description" => esc_html__('Enter the title for this toggle', 'provide')
                            ),
                            array(
                                "type" => "textarea",
                                "heading" => esc_html__('Short Description', 'provide'),
                                "param_name" => "t_desc",
                                "description" => esc_html__('Enter the short description for this toggle', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_product_information_output', $return);
        }
    }

    public static function provide_product_information_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $features = json_decode(urldecode($p_f));
        $toggles = json_decode(urldecode($toggle));
        ?>
        <div class="product-information">
            <?php if (!empty($features) && count($features) > 0): ?>
                <div class="provide-infos">
                    <?php
                    foreach ($features as $f) {
                        ?>
                        <div class="pro-info wow zoomIn">
                            <div class="info-detail">
                                <h3><?php echo esc_html($h->provide_set($f, 'f_title')) ?></h3>
                                <p><?php echo esc_html($h->provide_set($f, 'f_desc')) ?></p>
                            </div>
                            <span><i class="<?php echo esc_html($h->provide_set($f, 'f_icon')) ?>"></i></span>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php endif; ?>
            <div class="mockup">
                <?php
                if (!empty($image)) {
                    $getSrc = wp_get_attachment_image_src($image, 'full');
                    if ($h->provide_set($getSrc, '0') != '') {
                        echo '<img src="' . esc_url($h->provide_set($getSrc, '0')) . '" alt=""/>';
                    }
                }
                ?>
            </div>
            <?php if (!empty($features) && count($features) > 0): ?>
                <div class="provide-accordion toggle style3">
                    <?php
                    foreach ($toggles as $t) {
                        $delay = 1000;
                        ?>
                        <div class="toggle-item wow zoomIn" data-wow-delay="<?php echo esc_attr($delay += 100) ?>ms">
                            <h2><?php echo esc_html($h->provide_set($t, 't_title')) ?></h2>
                            <div class="content">
                                <p><?php echo esc_html($h->provide_set($t, 't_desc')) ?></p>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
