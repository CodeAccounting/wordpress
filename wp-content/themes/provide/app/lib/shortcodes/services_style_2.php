<?php

class provide_services_style_2_VC_ShortCode extends provide_VC_ShortCode {

    static $counter = 0;

    public static function provide_services_style_2($atts = NULL) {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Services Style 2", 'provide'),
                "base" => "provide_services_style_2_output",
                "icon" => 'provide_services_style_2_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Services', 'provide'),
                        'param_name' => 'services_style_2_list',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "attach_image",
                                "heading" => esc_html__('Image', 'provide'),
                                "param_name" => "image",
                                "description" => esc_html__('Upload or select image for this feature', 'provide')
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Title', 'provide'),
                                "param_name" => "title",
                                "description" => esc_html__('Enter the title of this feature', 'provide')
                            ),
                            array(
                                "type" => "textarea",
                                "heading" => esc_html__('Description', 'provide'),
                                "param_name" => "desc",
                                "description" => esc_html__('Enter the description of this feature', 'provide')
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Link', 'provide'),
                                "param_name" => "link",
                                "description" => esc_html__('Enter the link of this feature', 'provide')
                            ),
                        )
                    ),
                )
            );
            return apply_filters('provide_services_style_2_output', $return);
        }
    }

    public static function provide_services_style_2_output($atts = NULL, $content = NULL) {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $services_style_2 = json_decode(urldecode($services_style_2_list));
        if (!empty($services_style_2) && count($services_style_2) > 0) {
            $counter = 0;
            ?>
            <div class="provide-fancy-services">
                <div class="row masonary">
            <?php
            foreach ($services_style_2 as $f) {
                $getSrc = wp_get_attachment_image_src($h->provide_set($f, 'image'), 'full');
                if ($counter == 1 || $counter == (count($services_style_2) - 1)) {
                    $animation = 'bounceInDown';
                } else {
                    if ($counter % 3 === 0 && $counter != count($services_style_2)) {
                        $animation = 'bounceInDown';
                    } else {
                        $animation = '';
                    }
                }
                ?>
                        <div class="col-md-4">
                        <?php if ($h->provide_set($f, 'link') != ''): ?>
                                <a href="<?php echo esc_html($h->provide_set($f, 'link')) ?>" title="<?php echo esc_html($h->provide_set($f, 'title')) ?>">
                            <?php endif; ?>
                                <div class="fancy-service wow <?php echo esc_attr($animation) ?>">
                                    <div class="service-icon">
                                        <span>
                <?php if ($h->provide_set($getSrc, '0') != ''): ?>
                                                <img src="<?php echo esc_url($h->provide_set($getSrc, '0')) ?>" alt=""/>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <div class="fancy-inner">
                                        <h3><?php echo esc_html($h->provide_set($f, 'title')) ?></h3>
                                        <p><?php echo esc_html($h->provide_set($f, 'desc')) ?></p>
                                    </div>
                                </div>

                <?php if ($h->provide_set($f, 'link') != ''): ?>
                                </a>
                                <?php endif; ?>
                        </div>
                            <?php
                            $counter++;
                        }
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
