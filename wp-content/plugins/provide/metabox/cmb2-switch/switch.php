<?php

class provide_cmsb2_switch
{

    /**
     * Current version number
     */
    const VERSION = '1.0.0';

    /**
     * Initialize the plugin by hooking into CMB2
     */
    public function __construct()
    {
        add_action('cmb2_render_switch', array($this, 'cmb2_render_switch'), 10, 5);
        add_action('cmb2_sanitize_switch', array($this, 'cmb2_sanitize_switch'), 10, 2);
    }

    /**
     * Add a CMB custom field to allow for the selection FontAwesome Icon
     */
    function cmb2_render_switch($field, $escaped_value, $object_id, $object_type, $field_type_object)
    {
        $this->setup_admin_scripts();
        $default = $field->args['default'];
        $switch = '<div class="cmb2-switch">';
        $conditional_value = (isset($field->args['attributes']['data-conditional-value']) ? 'data-conditional-value="' . esc_attr($field->args['attributes']['data-conditional-value']) . '"' : '');
        $conditional_id = (isset($field->args['attributes']['data-conditional-id']) ? ' data-conditional-id="' . esc_attr($field->args['attributes']['data-conditional-id']) . '"' : '');
        $label_on = (isset($field->args['on']) ? esc_attr($field->args['on']) : 'On');
        $label_off = (isset($field->args['off']) ? esc_attr($field->args['off']) : 'Off');
        if (empty($escaped_value)) {
            $escaped_value = $default;
        }
        $switch .= '<input ' . $conditional_value . $conditional_id . ' type="radio" id="' . $field->args['_id'] . '1" value="on" ' . ($escaped_value == 'on' ? 'checked="checked"' : '') . ' name="' . esc_attr($field->args['_name']) . '" />
    <input ' . $conditional_value . $conditional_id . ' type="radio" id="' . $field->args['_id'] . '2" value="off" ' . (($escaped_value == '' || $escaped_value == 'off') ? 'checked="checked"' : '') . ' name="' . esc_attr($field->args['_name']) . '" />
    <label for="' . $field->args['_id'] . '1" class="cmb2-enable ' . ($escaped_value == 'on' ? 'selected' : '') . '"><span>' . $label_on . '</span></label>
    <label for="' . $field->args['_id'] . '2" class="cmb2-disable ' . (($escaped_value == '' || $escaped_value == 'off') ? 'selected' : '') . '"><span>' . $label_off . '</span></label>';
        $switch .= '</div>';
        $switch .= $field_type_object->_desc(true);
        echo $switch;
    }

    /**
     * Sanitize icon class name
     */
    public function cmb2_sanitize_switch($sanitized_val, $val)
    {
        if (!empty($val)) {
            return sanitize_html_class($val);
        }
        return $sanitized_val;
    }

    protected function setup_admin_scripts()
    {
        $url = PLUGIN_URI . 'metabox/cmb2-switch/';
        wp_enqueue_script('cmb2-switch', $url . 'assets/switch.js', array('jquery'), self::VERSION, true);
        wp_enqueue_style('cmb2-switch', $url . 'assets/switch.css', array(), self::VERSION);
    }
}

new provide_cmsb2_switch();
