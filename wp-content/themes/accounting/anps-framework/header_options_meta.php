<?php
add_action('add_meta_boxes', 'anps_header_options_add_custom_box');
add_action('save_post', 'anps_header_options_save_postdata');

function anps_header_options_add_custom_box() {
    add_meta_box('anps_spacing_options_meta', esc_html__('Spacing options', 'construction'), 'anps_display_meta_box_spacing_options', 'page', 'side', 'core');       
}
/* Footer margin */
function anps_display_meta_box_spacing_options($post) {
    $footer_value = get_post_meta($post->ID, $key ='anps_header_options_footer_margin', $single = true );
    $footer_margin_checked = checked($footer_value, 'on', false);
    $data = '';
    $data .= '<ul>';
    $data .= '<li>';
    $data .= '<label class="selectit">';
    $data .= "<input id='anps_header_options_footer_margin' name='anps_header_options_footer_margin' type='checkbox' $footer_margin_checked>";
    $data .= esc_html__('Remove Footer Margin', 'construction');
    $data .= '</label>';
    $data .= '</li>';
    $data .= '</ul>';
    echo wp_kses($data, array(
        'ul' => array(),
        'li' => array(),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id' => array(),
            'name' => array(),
            'type' => array(),
            'checked' => array(),
        )
    ));
}
function anps_header_options_save_postdata($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (empty($_POST)) {
        return;
    }
    if(!$_POST['post_ID']) {
        if(!$post_id) {
            return;
        } else {
            $_POST['post_ID'] = $post_id;
        }
    }
    $post_ID = $_POST['post_ID'];
    //footer
    if (!isset($_POST['anps_header_options_footer_margin'])) {
        $_POST['anps_header_options_footer_margin'] = '';
    }
    //save data
    $data_footer = $_POST['anps_header_options_footer_margin']; 
    add_post_meta($post_ID, 'anps_header_options_footer_margin', $data_footer, true) or update_post_meta($post_ID, 'anps_header_options_footer_margin', $data_footer);
}