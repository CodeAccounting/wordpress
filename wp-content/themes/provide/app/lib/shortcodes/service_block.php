<?php

class provide_service_block_VC_ShortCode extends provide_VC_ShortCode
{

    public static function provide_service_block($atts = null)
    {
        if ($atts == 'provide_Shortcodes_Map') {
            return array(
                "name" => esc_html__("Service Block", 'provide'),
                "base" => "provide_service_block_output",
                "icon" => 'provide_service_block.png',
                "category" => esc_html__('Provide', 'provide'),
                "as_child" => array('only' => 'provide_services_output'),
                "content_element" => true,
                "show_settings_on_create" => true,
                "is_container" => true,
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => esc_html__("Title:", 'provide'),
                        "param_name" => "title",
                        "description" => esc_html__("Enter the title for this section.", 'provide')
                    ),
                    array(
                        "type" => "textarea",
                        "heading" => esc_html__("Short Description:", 'provide'),
                        "param_name" => "content",
                        "description" => esc_html__("Enter the short description for this section.", 'provide')
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => esc_html__("Icon:", 'provide'),
                        "param_name" => "icon",
                        "description" => esc_html__("Upload Icon for this service.", 'provide')
                    ),
					array(
                        "type" => "textfield",
                        "heading" => esc_html__("Link:", 'provide'),
                        "param_name" => "link",
                        "description" => esc_html__("Enter the link for this section.", 'provide')
                    ),
                )
            );
            return apply_filters('provide_service_block_shortcode', $return);
        }
    }

    public static function provide_service_block_output($atts = null, $content = null)
    {
        $icon = $title = $desc = $link = '';
        extract(shortcode_atts(array(
            'icon' => '',
            'title' => '',
            'desc' => '',
			'link' => ''
        ), $atts));
        global $shortcodeServices;
        $shortcodeServices[] = array('icon' => $icon, 'title' => $title, 'content' => trim(do_shortcode($content)),'link' => $link,);
    }

}
