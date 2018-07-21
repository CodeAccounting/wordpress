<?php

class provide_PostMetabox
{

    public function __construct()
    {
        add_action('cmb2_init', array($this, 'provide_RegisterMetabox'));
    }

    public function provide_RegisterMetabox()
    {
        $settings = array(
            'id' => 'post_meta',
            'title' => esc_html__('Additional Fields', 'provide'),
            'object_types' => array('post', 'page'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => TRUE,
        );
        $meta = new_cmb2_box($settings);
        $fields = $this->provide_fields();
        foreach ($fields as $field) {
            $meta->add_field($field);
        }
    }

    public function provide_fields()
    {
        return array(
            array(
                'name' => esc_html__('Header Section', 'provide'),
                'id' => 'metaHeader',
                'type' => 'checkbox'
            ),
            array(
                'name' => esc_html__('Header Title', 'provide'),
                'id' => 'metaHeaderTitle',
                'type' => 'text',
                'attributes' => array(
                    'required' => false,
                    'data-conditional-id' => 'metaHeader',
                )
            ),
            array(
                'name' => esc_html__('Header Background', 'provide'),
                'id' => 'metaHeaderBg',
                'type' => 'file',
                'attributes' => array(
                    'required' => false,
                    'data-conditional-id' => 'metaHeader',
                )
            ),
            array(
                'name' => esc_html__('Sidebar Layout', 'provide'),
                'id' => 'metaSidebarLayout',
                'type' => 'radio_img',
                'show_option_none' => FALSE,
                'default' => 'full',
                'options' => array(
                    'left' => '<img src="' . PLUGIN_URI . 'panel/redux-framework/assets/img/2cl.png" />',
                    'right' => '<img src="' . PLUGIN_URI . 'panel/redux-framework/assets/img/2cr.png" />',
                    'full' => '<img src="' . PLUGIN_URI . 'panel/redux-framework/assets/img/1c.png" />'
                )
            ),
            array(
                'name' => esc_html__('Select Sidebar', 'provide'),
                'id' => 'metaSidebar',
                'type' => 'select',
                'options' => provide_sidebar(),
                'attributes' => array(
                    'required' => TRUE,
                    'data-conditional-id' => 'metaSidebarLayout',
                    'data-conditional-value' => json_encode(array('left', 'right'))
                )
            )
        );
    }

}
