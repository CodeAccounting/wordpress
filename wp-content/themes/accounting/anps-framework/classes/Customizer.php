<?php 
class Anps_Customizer {
    public static function customizer_register($wp_customize) { 
        /* Include custom controls */
        include_once 'customizer_controls/anps_divider_control.php';
        include_once 'customizer_controls/anps_desc_control.php';
        include_once 'customizer_controls/anps_sidebar_control.php';
        /* Add theme options panel */
        $wp_customize->add_panel('anps_customizer', array('title' =>'Theme options', 'description' => 'Theme options'));
        /* Theme options sections (categories) */
        $wp_customize->add_section('anps_colors', array('title' =>'Main theme colors', 'description' => 'Not satisfied with the premade color schemes? Here you can set your custom colors.', 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_button_colors', array('title' =>'Button colors', 'description' => 'Button colors', 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_typography', array('title' =>'Typography', 'description' => 'Typography', 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_page_layout', array('title' =>'Page layout', 'description' => 'Page layout', 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_page_setup', array('title' =>'Page setup', 'description' => 'Page setup', 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_header', array('title' =>'Header options', 'description' => 'Header options', 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_footer', array('title' =>'Footer options', 'description' => 'Footer options', 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_woocommerce', array('title' =>'Woocommerce', 'description' => 'Woocommerce', 'panel'=>'anps_customizer'));
        $wp_customize->add_section('anps_logos', array('title' =>'Logos', 'description' => 'If you would like to use your logo and favicon, upload them to your theme here', 'panel'=>'anps_customizer'));
        /* END Theme options sections (categories) */
        //Color management (main theme and buttons) settings 
        Anps_Customizer::color_management($wp_customize);
        //Typography settings
        Anps_Customizer::typography($wp_customize);
        //Page layout settings
        Anps_Customizer::page_layout($wp_customize);
        //Page layout settings
        Anps_Customizer::page_setup($wp_customize);
        //Header options
        Anps_Customizer::header_options($wp_customize);
        //Footer options
        Anps_Customizer::footer_options($wp_customize);
        //Woocommerce
        Anps_Customizer::woocommerce($wp_customize);
        //Logos
        Anps_Customizer::logos($wp_customize);
    }
    /* Color management settings */
    private static function color_management($wp_customize) {
        /* Main theme colors */
        //text color
        $wp_customize->add_setting('text_color', array('default'=>get_option('text_color', '#727272'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'text_color', array('label' => 'Text color', 'section' => 'anps_colors', 'settings'=>'text_color')));
        //primary color
        $wp_customize->add_setting('primary_color', array('default'=>get_option('primary_color', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array('label' => 'Primary color', 'section' => 'anps_colors', 'settings'=>'primary_color')));
        //hovers color
        $wp_customize->add_setting('hovers_color', array('default'=>get_option('hovers_color', '#3178bf'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'hovers_color', array('label' => 'Hovers color', 'section' => 'anps_colors', 'settings'=>'hovers_color')));
        //menu text color
        $wp_customize->add_setting('menu_text_color', array('default'=>get_option('menu_text_color', '#000'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'menu_text_color', array('label' => 'Menu text color', 'section' => 'anps_colors', 'settings'=>'menu_text_color')));
        //headings color
        $wp_customize->add_setting('headings_color', array('default'=>get_option('headings_color', '#000'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'headings_color', array('label' => 'Headings color', 'section' => 'anps_colors', 'settings'=>'headings_color')));
        //Top bar text color
        $wp_customize->add_setting('top_bar_color', array('default'=>get_option('top_bar_color', '#c1c1c1'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'top_bar_color', array('label' => 'Top bar color', 'section' => 'anps_colors', 'settings'=>'top_bar_color')));
        //Top bar background color
        $wp_customize->add_setting('top_bar_bg_color', array('default'=>get_option('top_bar_bg_color', '#f9f9f9'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'top_bar_bg_color', array('label' => 'Top bar background color', 'section' => 'anps_colors', 'settings'=>'top_bar_bg_color')));
        //Footer background color
        $wp_customize->add_setting('footer_bg_color', array('default'=>get_option('footer_bg_color', '#0f0f0f'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_bg_color', array('label' => 'Footer background color', 'section' => 'anps_colors', 'settings'=>'footer_bg_color')));
        //Copyright footer text color
        $wp_customize->add_setting('copyright_footer_text_color', array('default'=>get_option('copyright_footer_text_color', '#c4c4c4'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'copyright_footer_text_color', array('label' => 'Copyright footer text color', 'section' => 'anps_colors', 'settings'=>'copyright_footer_text_color')));
        //Copyright footer background color
        $wp_customize->add_setting('copyright_footer_bg_color', array('default'=>get_option('copyright_footer_bg_color', '#242424'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'copyright_footer_bg_color', array('label' => 'Copyright footer background color', 'section' => 'anps_colors', 'settings'=>'copyright_footer_bg_color')));
        //Footer text color
        $wp_customize->add_setting('footer_text_color', array('default'=>get_option('footer_text_color', '#c4c4c4'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_text_color', array('label' => 'Footer text color', 'section' => 'anps_colors', 'settings'=>'footer_text_color')));
        //Footer divider color
        $wp_customize->add_setting('footer_divider_color', array('default'=>get_option('footer_divider_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer_divider_color', array('label' => 'Footer divider color', 'section' => 'anps_colors', 'settings'=>'footer_divider_color')));
        //Page header background color
        $wp_customize->add_setting('nav_background_color', array('default'=>get_option('nav_background_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'nav_background_color', array('label' => 'Page header background color', 'section' => 'anps_colors', 'settings'=>'nav_background_color')));
        //Main divider color
        $wp_customize->add_setting('main_divider_color', array('default'=>get_option('main_divider_color', ''), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'main_divider_color', array('label' => 'Main divider color', 'section' => 'anps_colors', 'settings'=>'main_divider_color')));
        //Submenu background color
        $wp_customize->add_setting('submenu_background_color', array('default'=>get_option('submenu_background_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'submenu_background_color', array('label' => 'Submenu background color', 'section' => 'anps_colors', 'settings'=>'submenu_background_color')));
        //Submenu text color
        $wp_customize->add_setting('submenu_text_color', array('default'=>get_option('submenu_text_color', '#000'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'submenu_text_color', array('label' => 'Submenu text color', 'section' => 'anps_colors', 'settings'=>'submenu_text_color')));
        //Side submenu background color 
        $wp_customize->add_setting('side_submenu_background_color', array('default'=>get_option('side_submenu_background_color', ''), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'side_submenu_background_color', array('label' => 'Side submenu background color', 'section' => 'anps_colors', 'settings'=>'side_submenu_background_color')));
        //Side submenu text color
        $wp_customize->add_setting('side_submenu_text_color', array('default'=>get_option('side_submenu_text_color', ''), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'side_submenu_text_color', array('label' => 'Side submenu text color', 'section' => 'anps_colors', 'settings'=>'side_submenu_text_color')));
        //Side submenu text hover color
        $wp_customize->add_setting('side_submenu_text_hover_color', array('default'=>get_option('side_submenu_text_hover_color', ''), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'side_submenu_text_hover_color', array('label' => 'Side submenu text hover color', 'section' => 'anps_colors', 'settings'=>'side_submenu_text_hover_color')));
        //Icon shortcode heading hover color
        $wp_customize->add_setting('icon_shortcode_text_hover_color', array('default'=>get_option('icon_shortcode_text_hover_color', '#3178bf'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'icon_shortcode_text_hover_color', array('label' => 'Icon shortcode heading hover color', 'section' => 'anps_colors', 'settings'=>'icon_shortcode_text_hover_color')));
        //Shopping cart item number background color
        $wp_customize->add_setting('anps_woo_cart_items_number_bg_color', array('default'=>get_option('anps_woo_cart_items_number_bg_color', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_woo_cart_items_number_bg_color', array('label' => 'Shopping cart item number background color', 'section' => 'anps_colors', 'settings'=>'anps_woo_cart_items_number_bg_color')));
        //Shoping cart item number text color
        $wp_customize->add_setting('anps_woo_cart_items_number_color', array('default'=>get_option('anps_woo_cart_items_number_color', ''), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'anps_woo_cart_items_number_color', array('label' => 'Shoping cart item number text color', 'section' => 'anps_colors', 'settings'=>'anps_woo_cart_items_number_color')));     
        /* END Main theme colors */
        /* Button colors */
        /* Default button description */
        $wp_customize->add_setting('anps_normal_button_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_normal_button_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_normal_button_desc', 'label'=>'Normal button', 'description'=>'Next 4 colors define normal button.')));
        //Default button background
        $wp_customize->add_setting('default_button_bg', array('default'=>get_option('default_button_bg', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'default_button_bg', array('label' => 'Normal button background', 'section' => 'anps_button_colors', 'settings'=>'default_button_bg')));
        //Default button color
        $wp_customize->add_setting('default_button_color', array('default'=>get_option('default_button_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'default_button_color', array('label' => 'Normal button color', 'section' => 'anps_button_colors', 'settings'=>'default_button_color')));
        //Default button hover background
        $wp_customize->add_setting('default_button_hover_bg', array('default'=>get_option('default_button_hover_bg', '#3178bf'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'default_button_hover_bg', array('label' => 'Normal button hover background', 'section' => 'anps_button_colors', 'settings'=>'default_button_hover_bg')));
        //Default button hover color
        $wp_customize->add_setting('default_button_hover_color', array('default'=>get_option('default_button_hover_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'default_button_hover_color', array('label' => 'Normal button hover color', 'section' => 'anps_button_colors', 'settings'=>'default_button_hover_color')));
        /* END Default button */
        
        /* Button style-1 */
        $wp_customize->add_setting('anps_button_style_1_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_button_style_1_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_button_style_1_desc', 'label'=>'Button style 1', 'description'=>'Next 4 colors define button style 1.')));
        //Button style 1 background
        $wp_customize->add_setting('style_1_button_bg', array('default'=>get_option('style_1_button_bg', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_1_button_bg', array('label' => 'Button style 1 background', 'section' => 'anps_button_colors', 'settings'=>'style_1_button_bg')));
        //Button style 1 color
        $wp_customize->add_setting('style_1_button_color', array('default'=>get_option('style_1_button_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_1_button_color', array('label' => 'Button style 1 color', 'section' => 'anps_button_colors', 'settings'=>'style_1_button_color')));
        //Button style 1 hover background
        $wp_customize->add_setting('style_1_button_hover_bg', array('default'=>get_option('style_1_button_hover_bg', '#3178bf'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_1_button_hover_bg', array('label' => 'Button style 1 hover background', 'section' => 'anps_button_colors', 'settings'=>'style_1_button_hover_bg')));
        //Button style 1 hover color
        $wp_customize->add_setting('style_1_button_hover_color', array('default'=>get_option('style_1_button_hover_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_1_button_hover_color', array('label' => 'Button style 1 hover color', 'section' => 'anps_button_colors', 'settings'=>'style_1_button_hover_color')));
        /* END Button style-1 */
        
        /* Button style-2 */
        $wp_customize->add_setting('anps_button_style_2_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_button_style_2_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_button_style_2_desc', 'label'=>'Button style 2', 'description'=>'Next 4 colors define button style 2.')));
        //Button style 2 background
        $wp_customize->add_setting('style_2_button_bg', array('default'=>get_option('style_2_button_bg', '#000000'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_2_button_bg', array('label' => 'Button style 2 background', 'section' => 'anps_button_colors', 'settings'=>'style_2_button_bg')));
        //Button style 2 color
        $wp_customize->add_setting('style_2_button_color', array('default'=>get_option('style_2_button_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_2_button_color', array('label' => 'Button style 2 color', 'section' => 'anps_button_colors', 'settings'=>'style_2_button_color')));
        //Button style 2 hover background
        $wp_customize->add_setting('style_2_button_hover_bg', array('default'=>get_option('style_2_button_hover_bg', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_2_button_hover_bg', array('label' => 'Button style 2 hover background', 'section' => 'anps_button_colors', 'settings'=>'style_2_button_hover_bg')));
        //Button style 2 hover color
        $wp_customize->add_setting('style_2_button_hover_color', array('default'=>get_option('style_2_button_hover_color', '#000'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_2_button_hover_color', array('label' => 'Button style 2 hover color', 'section' => 'anps_button_colors', 'settings'=>'style_2_button_hover_color')));
        /* END Button style-2 */
        
        /* Button style-3 */
        $wp_customize->add_setting('anps_button_style_3_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_button_style_3_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_button_style_3_desc', 'label'=>'Button style 3', 'description'=>'Next 4 colors define button style 3.')));
        //Button style 3 background
        $wp_customize->add_setting('style_3_button_color', array('default'=>get_option('style_3_button_color', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_3_button_color', array('label' => 'Button style 3 color', 'section' => 'anps_button_colors', 'settings'=>'style_3_button_color')));
        //Button style 3 color
        $wp_customize->add_setting('style_3_button_hover_bg', array('default'=>get_option('style_3_button_hover_bg', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_3_button_hover_bg', array('label' => 'Button style 3 hover background', 'section' => 'anps_button_colors', 'settings'=>'style_3_button_hover_bg')));
        //Button style 3 hover background
        $wp_customize->add_setting('style_3_button_hover_color', array('default'=>get_option('style_3_button_hover_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_3_button_hover_color', array('label' => 'Button style 3 hover color', 'section' => 'anps_button_colors', 'settings'=>'style_3_button_hover_color')));
        //Button style 3 hover color
        $wp_customize->add_setting('style_3_button_border_color', array('default'=>get_option('style_3_button_border_color', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_3_button_border_color', array('label' => 'Button style 3 border color', 'section' => 'anps_button_colors', 'settings'=>'style_3_button_border_color')));
        /* END Button style-3 */
        
        /* Button style-4 */
        $wp_customize->add_setting('anps_button_style_4_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_button_style_4_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_button_style_4_desc', 'label'=>'Button style 4', 'description'=>'Next 2 colors define button style 4.')));
        //Button style 4 color
        $wp_customize->add_setting('style_4_button_color', array('default'=>get_option('style_4_button_color', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_4_button_color', array('label' => 'Button style 4 colorr', 'section' => 'anps_button_colors', 'settings'=>'style_4_button_color')));
        //Button style 4 hover color
        $wp_customize->add_setting('style_4_button_hover_color', array('default'=>get_option('style_4_button_hover_color', '#3178bf'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_4_button_hover_color', array('label' => 'Button style 4 hover color', 'section' => 'anps_button_colors', 'settings'=>'style_4_button_hover_color')));
        /* END Button style-4 */
        
        /* Button slider */
        $wp_customize->add_setting('anps_button_slider_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_button_slider_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_button_slider_desc', 'label'=>'Button slider', 'description'=>'Next 4 colors define button slider.')));
        //Button slider background
        $wp_customize->add_setting('style_slider_button_bg', array('default'=>get_option('style_slider_button_bg', '#26507a'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_slider_button_bg', array('label' => 'Button slider background', 'section' => 'anps_button_colors', 'settings'=>'style_slider_button_bg')));
        //Button slider color
        $wp_customize->add_setting('style_slider_button_color', array('default'=>get_option('style_slider_button_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_slider_button_color', array('label' => 'Button slider color', 'section' => 'anps_button_colors', 'settings'=>'style_slider_button_color')));
        //Button slider hover background
        $wp_customize->add_setting('style_slider_button_hover_bg', array('default'=>get_option('style_slider_button_hover_bg', '#3178bf'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_slider_button_hover_bg', array('label' => 'Button slider hover background', 'section' => 'anps_button_colors', 'settings'=>'style_slider_button_hover_bg')));
        //Button slider hover color
        $wp_customize->add_setting('style_slider_button_hover_color', array('default'=>get_option('style_slider_button_hover_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_slider_button_hover_color', array('label' => 'Button slider hover color', 'section' => 'anps_button_colors', 'settings'=>'style_slider_button_hover_color')));
        /* END Button slider */
        
        /* Button style-5 */
        $wp_customize->add_setting('anps_button_style_5_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_button_style_5_desc', array('section' => 'anps_button_colors', 'settings'=>'anps_button_style_5_desc', 'label'=>'Button style 5', 'description'=>'Next 4 colors define button style 5.')));
        //Button style 5 background
        $wp_customize->add_setting('style_style_5_button_bg', array('default'=>get_option('style_style_5_button_bg', '#c3c3c3'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_style_5_button_bg', array('label' => 'Button style 5 background', 'section' => 'anps_button_colors', 'settings'=>'style_style_5_button_bg')));
        //Button style 5 color
        $wp_customize->add_setting('style_style_5_button_color', array('default'=>get_option('style_style_5_button_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_style_5_button_color', array('label' => 'Button style 5 color', 'section' => 'anps_button_colors', 'settings'=>'style_style_5_button_color')));
        //Button style 5 hover background
        $wp_customize->add_setting('style_style_5_button_hover_bg', array('default'=>get_option('style_style_5_button_hover_bg', '#737373'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_style_5_button_hover_bg', array('label' => 'Button style 5 hover background', 'section' => 'anps_button_colors', 'settings'=>'style_style_5_button_hover_bg')));
        //Button style 5 hover color
        $wp_customize->add_setting('style_style_5_button_hover_color', array('default'=>get_option('style_style_5_button_hover_color', '#fff'), 'type'=>'option', 'sanitize_callback'=>'sanitize_hex_color', 'sanitize_js_callback'=>'maybe_hash_hex_color', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'style_style_5_button_hover_color', array('label' => 'Button style 5 hover color', 'section' => 'anps_button_colors', 'settings'=>'style_style_5_button_hover_color')));
        /* END Button style-5 */
        
        /* END Button colors */
    }
    /* Typography settings */
    private static function typography($wp_customize) {
        /* še manjka za izbiranje fontov */
        //Body font size
        $wp_customize->add_setting('body_font_size', array('default'=>get_option('body_font_size', '14'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('body_font_size', array('label'=>'Body font size', 'settings' => 'body_font_size', 'section' => 'anps_typography'));
        //Menu font size
        $wp_customize->add_setting('menu_font_size', array('default'=>get_option('menu_font_size', '14'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('menu_font_size', array('label'=>'Menu font size', 'settings' => 'menu_font_size', 'section' => 'anps_typography'));
        //Content heading 1 font size
        $wp_customize->add_setting('h1_font_size', array('default'=>get_option('h1_font_size', '31'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('h1_font_size', array('label'=>'Content heading 1 font size', 'settings' => 'h1_font_size', 'section' => 'anps_typography'));
        //Content heading 2 font size
        $wp_customize->add_setting('h2_font_size', array('default'=>get_option('h2_font_size', '24'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('h2_font_size', array('label'=>'Content heading 2 font size', 'settings' => 'h2_font_size', 'section' => 'anps_typography'));
        //Content heading 3 font size
        $wp_customize->add_setting('h3_font_size', array('default'=>get_option('h3_font_size', '21'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('h3_font_size', array('label'=>'Content heading 3 font size', 'settings' => 'h3_font_size', 'section' => 'anps_typography'));
        //Content heading 4 font size
        $wp_customize->add_setting('h4_font_size', array('default'=>get_option('h4_font_size', '18'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('h4_font_size', array('label'=>'Content heading 4 font size', 'settings' => 'h4_font_size', 'section' => 'anps_typography'));
        //Content heading 5 font size
        $wp_customize->add_setting('h5_font_size', array('default'=>get_option('h5_font_size', '16'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('h5_font_size', array('label'=>'Content heading 5 font size', 'settings' => 'h5_font_size', 'section' => 'anps_typography'));
        //Page heading 1 font size
        $wp_customize->add_setting('page_heading_h1_font_size', array('default'=>get_option('page_heading_h1_font_size', '48'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('page_heading_h1_font_size', array('label'=>'Page heading 1 font size', 'settings' => 'page_heading_h1_font_size', 'section' => 'anps_typography'));
        //Single blog page heading 1 font size
        $wp_customize->add_setting('blog_heading_h1_font_size', array('default'=>get_option('blog_heading_h1_font_size', '28'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('blog_heading_h1_font_size', array('label'=>'Single blog page heading 1 font size', 'settings' => 'blog_heading_h1_font_size', 'section' => 'anps_typography'));
    }
    /* Page layout settings */
    private static function page_layout($wp_customize) {
        $anps_data = get_option('anps_acc_info');
        //Page sidebar description
        $wp_customize->add_setting('anps_page_sidebar_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_page_sidebar_desc', array('section' => 'anps_page_layout', 'settings'=>'anps_page_sidebar_desc', 'label'=>'Page Sidebars', 'description'=>'This will change the default sidebar value on all pages. It can be changed on each page individually.')));
        //Page left sidebar
        $wp_customize->add_setting('anps_page_sidebar_left', array('type'=>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control(new Anps_Sidebar_Control($wp_customize, 'anps_page_sidebar_left', array('section' => 'anps_page_layout', 'settings'=>'anps_page_sidebar_left', 'label'=>'Page sidebar left')));
        //Page right sidebar
        $wp_customize->add_setting('anps_page_sidebar_right', array('type'=>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control(new Anps_Sidebar_Control($wp_customize, 'anps_page_sidebar_right', array('section' => 'anps_page_layout', 'settings'=>'anps_page_sidebar_right', 'label'=>'Page sidebar right')));
        //Post sidebar description
        $wp_customize->add_setting('anps_post_sidebar_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_post_sidebar_desc', array('section' => 'anps_page_layout', 'settings'=>'anps_post_sidebar_desc', 'label'=>'Post Sidebars', 'description'=>'This will change the default sidebar value on all posts. It can be changed on each post individually.')));
        //Post left sidebar
        $wp_customize->add_setting('anps_post_sidebar_left', array('type'=>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control(new Anps_Sidebar_Control($wp_customize, 'anps_post_sidebar_left', array('section' => 'anps_page_layout', 'settings'=>'anps_post_sidebar_left', 'label'=>'Post sidebar left')));
        //Post right sidebar
        $wp_customize->add_setting('anps_post_sidebar_right', array('type'=>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control(new Anps_Sidebar_Control($wp_customize, 'anps_post_sidebar_right', array('section' => 'anps_page_layout', 'settings'=>'anps_post_sidebar_right', 'label'=>'Post sidebar right')));
        //Disable page title, breadcrumbs and background
        $wp_customize->add_setting('anps_disable_heading', array('default'=>anps_get_option($anps_data, 'disable_heading'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_disable_heading', array('section'=>'anps_page_layout', 'type'=>'checkbox', 'label'=>'Disable page title, breadcrumbs and background', 'settings'=>'anps_disable_heading'));
        //divider heading
        $wp_customize->add_setting('anps_heading_divider', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Divider_Control($wp_customize, 'anps_heading_divider', array('section' => 'anps_page_layout', 'settings'=>'anps_heading_divider')));     
        //Breadcrumbs
        $wp_customize->add_setting('anps_breadcrumbs', array('default'=>anps_get_option($anps_data, 'breadcrumbs'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_breadcrumbs', array('section'=>'anps_page_layout', 'type'=>'checkbox', 'label'=>'Enable Bredcrumbs', 'settings'=>'anps_breadcrumbs'));
    }
    /* Page setup */
    private static function page_setup($wp_customize) {
        //Excerpt length
        $wp_customize->add_setting('anps_coming_soon', array('default'=>get_option('anps_coming_soon'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_coming_soon', array('label'=>'Coming soon page', 'type'=>'dropdown-pages', 'settings' => 'anps_coming_soon', 'section' => 'anps_page_setup'));
        //404 error page
        $wp_customize->add_setting('anps_error_page', array('default'=>get_option('anps_error_page'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_error_page', array('label'=>'404 error page', 'type'=>'dropdown-pages', 'settings' => 'anps_error_page', 'section' => 'anps_page_setup'));
        
        /* Portfolio */
        $wp_customize->add_setting('anps_portfolio_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_portfolio_desc', array('section' => 'anps_page_setup', 'settings'=>'anps_portfolio_desc', 'label'=>'Portfolio settings', 'description'=>'Here you can select single portfolio style.')));
        //Portfolio single style
        $wp_customize->add_setting('portfolio_single', array('default'=>get_option('portfolio_single'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('portfolio_single', array(
            'label'=>'Portfolio single style', 
            'type'=>'select', 
            'settings' =>'portfolio_single', 
            'section' =>'anps_page_setup',
            'choices' =>array(
                'style-1'=>'Style 1',
                'style-2'=>'Style 2'
            )
        ));
        /* END Portfolio*/
        
        //Post meta title and description 
        $wp_customize->add_setting('anps_post_meta_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_post_meta_desc', array('section' => 'anps_page_setup', 'settings'=>'anps_post_meta_desc', 'label'=>'Disable Post meta elements', 'description'=>'This allows you to disable post meta on all blog elements and pages. By default no field is checked, so that all meta elements are displayed.')));
        //comments checkbox
        $wp_customize->add_setting('anps_post_meta_comments', array('default'=>get_option('anps_post_meta_comments', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_post_meta_comments', array('section'=>'anps_page_setup', 'type'=>'checkbox', 'label'=>'Comments', 'settings'=>'anps_post_meta_comments'));
        //categories checkbox
        $wp_customize->add_setting('anps_post_meta_categories', array('default'=>get_option('anps_post_meta_categories', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_post_meta_categories', array('section'=>'anps_page_setup', 'type'=>'checkbox', 'label'=>'Categories', 'settings'=>'anps_post_meta_categories'));
        //author checkbox
        $wp_customize->add_setting('anps_post_meta_author', array('default'=>get_option('anps_post_meta_author', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_post_meta_author', array('section'=>'anps_page_setup', 'type'=>'checkbox', 'label'=>'Author', 'settings'=>'anps_post_meta_author'));
        //date checkbox
        $wp_customize->add_setting('anps_post_meta_date', array('default'=>get_option('anps_post_meta_date', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html', 'transport'=>'refresh'));
        $wp_customize->add_control('anps_post_meta_date', array('section'=>'anps_page_setup', 'type'=>'checkbox', 'label'=>'Date', 'settings'=>'anps_post_meta_date'));
    }
    /* Header options */
    private static function header_options($wp_customize) {
        /* General top menu settings */
        $wp_customize->add_setting('anps_general_top_menu_settings', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_general_top_menu_settings', array('section' => 'anps_header', 'settings'=>'anps_general_top_menu_settings', 'label'=>'General Top Menu Settings', 'description'=>'Here you can set top bar, above menu bar, sticky menu and other settings.')));
        //Display top bar?
        $wp_customize->add_setting('topmenu_style', array('default'=>get_option('topmenu_style'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('topmenu_style', array(
            'label' => 'Display top bar?',
            'section' => 'anps_header',
            'type' => 'select',
            'choices' => array(
                '1' => 'Yes',             
                '2' => 'Only on tablet/mobile',
                '4' => 'Only on desktop',
                '3' => 'No'
            )
        ));
        //Above nav bar
        $wp_customize->add_setting('anps_above_nav_bar', array('default'=>get_option('anps_above_nav_bar'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_above_nav_bar', array(
            'label' => 'Display above menu bar?',
            'section' => 'anps_header',
            'type' => 'select',
            'choices' => array(
                '1' => 'Yes',
                '0' => 'No'
            )
        ));
        //Menu
        $wp_customize->add_setting('menu_style', array('default'=>get_option('menu_style'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('menu_style', array(
            'label' => 'Menu',
            'section' => 'anps_header',
            'type' => 'select',
            'choices' => array(
                '1' => 'Normal',
                '2' => 'Description'
            )
        ));
        //Menu center
        $wp_customize->add_setting('menu_center', array('default'=>get_option('menu_center'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('menu_center', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>'Menu center', 'settings'=>'menu_center'));
        //Sticky menu
        $wp_customize->add_setting('sticky_menu', array('default'=>get_option('sticky_menu'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('sticky_menu', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>'Sticky menu', 'settings'=>'sticky_menu')); 
        //Display search icon in menu (desktop)?
        $wp_customize->add_setting('search_icon', array('default'=>get_option('search_icon', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('search_icon', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>'Display search icon in menu (desktop)?', 'settings'=>'search_icon'));  
        //Display search on mobile and tablets?
        $wp_customize->add_setting('search_icon_mobile', array('default'=>get_option('search_icon_mobile', '1'), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('search_icon_mobile', array('section'=>'anps_header', 'type'=>'checkbox', 'label'=>'Display search on mobile and tablets?', 'settings'=>'search_icon_mobile'));    
        /* END General top menu settings */
        
        /* Main menu settings */
        $wp_customize->add_setting('anps_main_menu_settings_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_main_menu_settings_desc', array('section' => 'anps_header', 'settings'=>'anps_main_menu_settings_desc', 'label'=>'Main menu settings', 'description'=>'')));
        //Dropdown selection states
        $wp_customize->add_setting('anps_main_menu_selection', array('default'=>get_option('anps_main_menu_selection'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_main_menu_selection', array(
            'label' => 'Dropdown selection states',
            'section' => 'anps_header',
            'type' => 'select',
            'choices' => array(
                '0' => 'Hover color & bottom border',
                '1' => 'Hover color'
            )
        ));
        /* END Main menu settings */
    }
    /* Footer options */
    private static function footer_options($wp_customize) {
        /* Prefooter description */
        $wp_customize->add_setting('anps_prefooter_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_prefooter_desc', array('section' => 'anps_footer', 'settings'=>'anps_prefooter_desc', 'label'=>'Prefooter options', 'description'=>'')));
        //enable prefooter
        $wp_customize->add_setting('prefooter', array('default'=>get_option('prefooter', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('prefooter', array('section'=>'anps_footer', 'type'=>'checkbox', 'label'=>'Enable prefooter', 'settings'=>'prefooter'));
        //PreFooter columns
        $wp_customize->add_setting('prefooter_style', array('default'=>get_option('prefooter_style', '0'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('prefooter_style', array(
            'label' => 'PreFooter columns',
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '0' => '*** Select ***',
                '5' => '2/3 + 1/3',
                '6' => '1/3 + 2/3',
                '2' => '2 columns',
                '3' => '3 columns',
                '4' => '4 columns'
            )
        ));
        /* END Prefooter description */
        
        /* Footer description */
        $wp_customize->add_setting('anps_footer_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_footer_desc', array('section' => 'anps_footer', 'settings'=>'anps_footer_desc', 'label'=>'Footer options', 'description'=>'')));
        //disable footer
        $wp_customize->add_setting('footer_disable', array('default'=>get_option('footer_disable', ''), 'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('footer_disable', array('section'=>'anps_footer', 'type'=>'checkbox', 'label'=>'Disable footer', 'settings'=>'footer_disable'));
        //Footer columns
        $wp_customize->add_setting('footer_style', array('default'=>get_option('footer_style', '0'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('footer_style', array(
            'label' => 'Footer columns',
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '0' => '*** Select ***',
                '2' => '2 columns',
                '3' => '3 columns',
                '4' => '4 columns'
            )
        ));
        //Footer style
        $wp_customize->add_setting('anps_footer_style', array('default'=>get_option('anps_footer_style', '1'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('anps_footer_style', array(
            'label' => 'Footer style',
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '1' => 'style 1',
                '2' => 'style 2',
                '3' => 'style 3'
            )
        ));
        //Copyright footer
        $wp_customize->add_setting('copyright_footer', array('default'=>get_option('copyright_footer'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('copyright_footer', array(
            'label' => 'Copyright footer',
            'section' => 'anps_footer',
            'type' => 'select',
            'choices' => array(
                '0' => '*** Select ***',
                '1' => '1 columns',
                '2' => '2 columns'
            )
        ));
    }  
        /* Woocommerce */
    private static function woocommerce($wp_customize) {
        //display shopping cart icon in header
        $wp_customize->add_setting('shopping_cart_header', array('default'=>get_option('shopping_cart_header', 'shop_only'),'type' =>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control('shopping_cart_header', array(
            'label' => 'Display shopping cart icon in header?',
            'section' => 'anps_woocommerce',
            'type' => 'select',
            'choices' => array(
                'hide' => 'Never display',
                'shop_only' => 'Only on Woo pages',
                'always' => 'Display everywhere'
            )
        ));
    }
    /* Logos */
    private static function logos($wp_customize) {
        /* Get old data */
        $anps_media_data = get_option('anps_media_info');
        
        /* Heading background */
        $wp_customize->add_setting('anps_heading_bg_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_heading_bg_desc', array('section' => 'anps_logos', 'settings'=>'anps_heading_bg_desc', 'label'=>'Heading background', 'description'=>'Heading background on page and search page.')));
        //Page heading bg
        $wp_customize->add_setting('anps_heading_bg', array('default'=>anps_get_option($anps_media_data, 'heading_bg'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_heading_bg', array('label'=>'Page heading background', 'section'=>'anps_logos', 'settings'=>'anps_heading_bg')));
        //Search page heading bg
        $wp_customize->add_setting('anps_search_heading_bg', array('default'=>anps_get_option($anps_media_data, 'search_heading_bg'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_search_heading_bg', array('label'=>'Search page heading background', 'section'=>'anps_logos', 'settings'=>'anps_search_heading_bg')));
        /* END Heading background */
        
        /* Favicon and logos */
        $wp_customize->add_setting('anps_logos_desc', array('type'=>'option', 'sanitize_callback' => 'esc_html'));
        $wp_customize->add_control(new Anps_Desc_Control($wp_customize, 'anps_logos_desc', array('section' => 'anps_logos', 'settings'=>'anps_logos_desc', 'label'=>'Favicon and logos', 'description'=>'If you would like to use your logo and favicon, upload them to your theme here.')));
        //Logo
        $wp_customize->add_setting('anps_logo', array('default'=>anps_get_option($anps_media_data, 'logo'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_logo', array('label'=>'Logo', 'section'=>'anps_logos', 'settings'=>'anps_logo')));
        //Sticky logo
        $wp_customize->add_setting('anps_sticky_logo', array('default'=>anps_get_option($anps_media_data, 'sticky_logo'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_sticky_logo', array('label'=>'Sticky logo', 'section'=>'anps_logos', 'settings'=>'anps_sticky_logo')));
        //Favicon
        $wp_customize->add_setting('anps_favicon', array('default'=>anps_get_option($anps_media_data, 'favicon'), 'type' =>'option', 'sanitize_callback' => 'esc_url_raw', 'transport'=>'refresh'));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'anps_favicon', array('label'=>'Favicon', 'section'=>'anps_logos', 'settings'=>'anps_favicon')));
        /* END Favicon and logos */
    }
}
add_action('customize_register', array('Anps_Customizer', 'customizer_register'));