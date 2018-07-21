<?php

class provide_ProductMetabox
{

    public function __construct()
    {
        add_action('cmb2_init', array($this, 'provide_RegisterMetabox'));
    }

    public function provide_RegisterMetabox()
    {
        $settings = array(
            'id' => 'product_meta',
            'title' => esc_html__('Additional Fields', 'provide'),
            'object_types' => array('product'),
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
        );
    }

}
