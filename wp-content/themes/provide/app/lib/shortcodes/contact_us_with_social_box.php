<?php

class provide_contact_us_with_social_box_VC_ShortCode extends provide_VC_ShortCode
{
    static $counter = 0;

    public static function provide_contact_us_with_social_box($atts = NULL)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Contact Us With Social Box", 'provide'),
                "base" => "provide_contact_us_with_social_box_output",
                "icon" => 'provide_contact_us_with_social_box_output.png',
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
                        "type" => "attach_image",
                        "heading" => esc_html__("Social Box Background", 'provide'),
                        "param_name" => "box_image",
                        "description" => esc_html__("Upload or select image for social box background.", 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Button Text", 'provide'),
                        "param_name" => "btn_text",
                        "value" => esc_attr__('SEND ME', 'provide'),
                        "description" => esc_html__("Enter the contact form button text.", 'provide')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Email", 'provide'),
                        "param_name" => "receiving_email",
                        "description" => esc_html__("Get Request on this email that you enter.", 'provide')
                    ),
                    array(
                        'type' => 'param_group',
                        "heading" => esc_html__('Social Media', 'provide'),
                        'param_name' => 'media',
                        "show_settings_on_create" => true,
                        'params' => array(
                            array(
                                "type" => "iconpicker",
                                "heading" => esc_html__("Social Icon", 'provide'),
                                "param_name" => "m_icon",
                                "description" => esc_html__("Select the icon from the list.", 'provide')
                            ),
                            array(
                                "type" => "textfield",
                                "heading" => esc_html__('Link', 'provide'),
                                "param_name" => "m_link",
                                "description" => esc_html__('Enter the link of this social media', 'provide')
                            )
                        )
                    ),
                )
            );
            return apply_filters('provide_contact_us_with_social_box_output', $return);
        }
    }

    public static function provide_contact_us_with_social_box_output($atts = NULL, $content = NULL)
    {
        include(provide_Root . 'app/lib/shortcodes/shortcode_atts.php');
        ob_start();
        $i = new provide_Imagify();
        $mList = json_decode(urldecode($media));
        $sizes = array('m' => '644x486', 'i' => '745x563', 'w' => '675x510');
        $imgSrc = (!empty($box_image)) ? wp_get_attachment_image_src($box_image, 'full') : '';
        $boxImageSrc = $i->provide_thumb($sizes, false, array(TRUE, TRUE, TRUE), $h->provide_set($imgSrc, '0'), 'c', true);
        ?>
        <div class="provide-contact">
            <div class="social-contact">
                <?php if (!empty($imgSrc)): ?>
                    <img src="<?php echo esc_url($boxImageSrc) ?>" alt=""/>
                <?php endif; ?>
                <?php
                if (!empty($mList) && count($mList) > 0) {
                    echo '<div class="light-socials">';
                    foreach ($mList as $m) {
                        echo '<a target="_blank" href="' . esc_url($h->provide_set($m, 'm_link')) . '" title=""><i class="' . esc_attr($h->provide_set($m, 'm_icon')) . '"></i></a>';
                    }
                    echo '</div>';
                }
                ?>
            </div><!-- Social Contact -->
            <div class="provide-form">
                <h3 class="elegent-title"><?php echo esc_html($title) ?></h3>
                <p><?php echo esc_html($desc) ?></p>
                <div class="log"></div>
                <form id="cuwsb_form">
                    <div class="row">
                        <input type="hidden" id="cuwsb_receiver" value="<?php echo esc_attr($receiving_email) ?>"/>
                        <div class="col-md-12"><input id="cuwsb_name" type="text" placeholder="<?php echo esc_html__('Name', 'provide') ?>"/></div>
                        <div class="col-md-12"><input id="cuwsb_email" type="email" placeholder="<?php echo esc_html__('Email', 'provide') ?>"/></div>
                        <div class="col-md-12"><textarea id="cuwsb_message" placeholder="<?php echo esc_html__('Connect', 'provide') ?>"></textarea></div>
                        <div class="col-md-12">
                            <button id="cuwsb_submit" class="color-btn"><?php echo esc_html($btn_text) ?></button>
                        </div>
                    </div>
                </form>
            </div><!-- Provide Form -->
        </div><!-- Provide Contact -->

        <?php
        $output = ob_get_contents();
        ob_clean();
        return do_shortcode($output);
    }

}
