<?php

class provide_our_features_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_our_features($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Our Features", 'provide'),
                "base" => "provide_our_features_output",
                "icon" => 'provide_our_features_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Feature\'s', 'provide'),
                        'param_name' => 'our_features',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "attach_image",
                                "heading" => esc_html__("Image:", 'provide'),
                                "param_name" => "image",
                                "description" => esc_html__("Upload Image for this feature.", 'provide')
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Feature\'s List', 'provide'),
                                "param_name" => "features",
                                "description" => esc_html__('Enter the feature', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_our_features_output', $return);
        }
    }

    public static function provide_our_features_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '322x223', 'i' => '352x244', 'w' => '280x193');
        $ourFeatures = json_decode(urldecode($our_features));
        if (!empty($ourFeatures) && count($ourFeatures) > 0) {
            ?>
            <div class="provide-features">
                <div class="row">
                    <?php
                    foreach ($ourFeatures as $f) {
                        if ($h->provide_set($f, 'image') != '') {
                            $getSrc = wp_get_attachment_image_src($h->provide_set($f, 'image'), 'full');
                            $imgSrc = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $h->provide_set($getSrc, '0'), 'c', true);
                        }
                        $list = explode('|', $h->provide_set($f, 'features'));
                        ?>
                        <div class="col-md-6">
                            <div class="feature wow fadeInLeft" data-wow-duration="2000ms">
                                <?php
                                if ($h->provide_set($f, 'image') != '') {
                                    echo '<img src="' . esc_url($imgSrc) . '" alt=""/>';
                                }
                                if (!empty($list) && count($list) > 0) {
                                    echo '<ul>';
                                    foreach ($list as $l) {
                                        echo '<li>' . $l . '</li>';
                                    }
                                    echo '</ul>';
                                }
                                ?>
                            </div><!-- Feature -->
                        </div>
                        <?php
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
