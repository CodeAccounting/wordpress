<?php

class provide_TestimonialMetabox
{

    public function __construct()
    {
        add_action('cmb2_init', array($this, 'provide_RegisterMetabox'));
    }

    public function provide_RegisterMetabox()
    {
        $settings = array(
            'id' => 'testimonial_meta',
            'title' => esc_html__('Testimonial', 'provide'),
            'object_types' => array('pr_testimonial'),
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
                'name' => esc_html__('Content', 'provide'),
                'id' => 'metaContent',
                'type' => 'textarea'
            ),
            array(
                'name' => esc_html__('Avatar', 'provide'),
                'id' => 'metaBG',
                'type' => 'file',
                'options' => array(
                    'url' => false,
                ),
                'text' => array(
                    'add_upload_file_text' => esc_html__('Add File', 'provide')
                ),
            ),
            array(
                'name' => esc_html__('Address', 'provide'),
                'id' => 'metaAddress',
                'type' => 'text'
            )
        );
    }

}
