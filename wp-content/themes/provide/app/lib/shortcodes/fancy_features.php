<?php

class provide_fancy_features_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_fancy_features($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Fancy Features", 'provide'),
                "base" => "provide_fancy_features_output",
                "icon" => 'provide_fancy_features_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Features', 'provide'),
                        'param_name' => 'fancy_features_list',
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
                                "type" => "textfield",
                                "heading" => esc_html__('Link', 'provide'),
                                "param_name" => "feat_link",
                                "description" => esc_html__('Enter the link of this feature', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_fancy_features_output', $return);
        }
    }

    public static function provide_fancy_features_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '322x219', 'i' => '357x243', 'w' => '429x291');
        $fancy_features = json_decode(urldecode($fancy_features_list));
        if (!empty($fancy_features) && count($fancy_features) > 0) {
            ?>
            <div class="provide-fancy-features overlap">
                <div class="row">
                    <?php
                    foreach ($fancy_features as $f) {
                        if ($h->provide_set($f, 'image') != '') {
                            $getSrc = wp_get_attachment_image_src($h->provide_set($f, 'image'), 'full');
                            $imgSrc = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $h->provide_set($getSrc, '0'), 'c', true);
                            $link = ($h->provide_set($f, 'feat_link')) ? $h->provide_set($f, 'feat_link') : '#';
                            ?>
                            <div class="col-md-4">
                                <div class="fancy-featrure wow fadeIn">
                                    <img src="<?php echo esc_url($imgSrc) ?>" alt=""/>
                                    <div class="fancy-name">
                                        <h4>
                                            <a href="<?php echo esc_url($link); ?>" title="">
                                                <?php echo esc_html($h->provide_set($f, 'title')) ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div><!-- Fancy Features -->
                            </div>
                            <?php
                        }
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
