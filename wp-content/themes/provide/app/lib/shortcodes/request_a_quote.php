<?php

class provide_request_a_quote_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_request_a_quote($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Request A Quote", 'provide'),
                "base" => "provide_request_a_quote_output",
                "icon" => 'provide_request_a_quote_output.png',
                "category" => esc_html__('Provide', 'provide'),
                "params" => array(
					array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Background Image", 'provide'),
                        "param_name" => "background_img",
                        "description" => esc_html__("Upload or select background image.", 'provide')
                    ),
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
                        "value" => esc_html__('Submit', 'provide'),
                        "description" => esc_html__("Enter the button text.", 'provide')
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Side Image", 'provide'),
                        "param_name" => "side_img",
                        "description" => esc_html__("Upload or select side image.", 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Email", 'provide'),
                        "param_name" => "receiving_email",
                        "description" => esc_html__("Get Request on this email that you enter.", 'provide')
                    ),
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Request List', 'provide'),
                        'param_name' => 'request_list',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Request Name', 'provide'),
                                "param_name" => "req_name",
                                "description" => esc_html__('Enter the request name', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_request_a_quote_output', $return);
        }
    }

    public static function provide_request_a_quote_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        provide_Media::provide_singleton()->provide_eq(array('provide-select2'));
        ob_start();
        $reList = json_decode(urldecode($request_list));
        $imgSrc = wp_get_attachment_image_src($side_img, 'full');
		$bgimgSrc = wp_get_attachment_image_src($background_img, 'full');
		$bgimgLink = esc_url($h->provide_set($bgimgSrc, '0'));
        ?>
        <div class="callback" <?php if($bgimgLink != ''): ?> style="background-image: url('<?php echo $bgimgLink; ?>');" <?php endif; ?>>
            <?php if ($h->provide_set($imgSrc, '0') != ''): ?>
                <img src="<?php echo esc_url($h->provide_set($imgSrc, '0')) ?>" alt=""/>
            <?php endif; ?>
            <div class="callback-form">
                <h3><?php echo esc_html($title) ?><i>.</i></h3>
                <p><?php echo esc_html($desc) ?></p>
                <div class="log"></div>
                <form id="req_submit">
                    <div class="row">
                        <?php if (!empty($reList) && count($reList) > 0): ?>
                            <div class="col-md-6">
                                <select id="req_type" class="select">
                                    <?php
                                    foreach ($reList as $l) {
                                        echo '<option value="' . $h->provide_set($l, 'req_name') . '">' . $h->provide_set($l, 'req_name') . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" id="req_rec_email" value="<?php echo esc_attr($receiving_email) ?>"/>
                        <div class="col-md-6"><input id="req_name" type="text" placeholder="<?php esc_html_e('First Name', 'provide') ?>" autocomplete="off"/></div>
                        <div class="col-md-6"><input id="req_email" type="email" placeholder="<?php esc_html_e('Email', 'provide') ?>" autocomplete="off"/></div>
                        <div class="col-md-6"><input id="req_number" type="text" placeholder="<?php esc_html_e('Phone Number', 'provide') ?>" autocomplete="off"/></div>
                        <div class="col-md-6">
                            <button class="color-btn" id="req_submit_button" type="submit"><?php echo esc_html($btn_text) ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
