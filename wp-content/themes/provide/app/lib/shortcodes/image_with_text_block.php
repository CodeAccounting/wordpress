<?php

class provide_image_with_text_block_VC_ShortCode extends provide_VC_ShortCode
{
    public static function provide_image_with_text_block($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Image With Text Block", 'provide'),
                "base" => "provide_image_with_text_block_output",
                "icon" => 'provide_image_with_text_block_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
                    array(
                        "type" => "textarea_html",
                        "heading" => esc_html__("Content", 'provide'),
                        "param_name" => "content",
                        "description" => esc_html__("Enter the content for this section.", 'provide')
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Image", 'provide'),
                        "param_name" => "image",
                        "description" => esc_html__("Upload or select image for this section.", 'provide')
                    )
                )
            );
            return apply_filters('provide_image_with_text_block_output', $return);
        }
    }

    public static function provide_image_with_text_block_output($atts = NULL, $content = NULL)
    {
        $h = new provide_Helper();
        $image = '';
        extract(shortcode_atts(array(
            'image' => ''
        ), $atts));
        ob_start();
        $i = new provide_Imagify();
        $sizes = array('m' => '614x330', 'i' => '720x387', 'w' => '1170x468');
        $atts['content'] = $content;
        ?>
        <div class="simple-text">
            <div class="abt-img">
                <?php
                if (!empty($image)) {
                    $getSrc = wp_get_attachment_image_src($image, 'full');
                    $src = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $h->provide_set($getSrc, '0'), 'c', true);
                    echo '<img src="' . esc_url($src) . '" alt=""/>';
                }
                ?>
            </div>
            <?php echo wpautop($content, true); ?>
        </div>
        <?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
