<?php

class provide_CategoryTaxonomy
{

    public function __construct()
    {
        add_filter('cmb2-taxonomy_meta_boxes', array($this, 'provide_RegisterMetabox'));
    }

    public function provide_RegisterMetabox(array $meta_boxes)
    {
        $meta_boxes['category_metabox'] = array(
            'id' => 'category_meta',
            'title' => esc_html__('Additional Fields', 'provide'),
            'object_types' => array('category'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => TRUE,
            'fields' => $this->provide_fields()
        );
        return $meta_boxes;
    }

    public function provide_fields()
    {
        return array(
            array(
                'id' => 'taxIcon',
                'name' => esc_html__('Icon', 'provide'),
                'type' => 'fontawesome_icon'
            ),
            array(
                'name' => esc_html__('Category Background', 'provide'),
                'id' => 'taxBg',
                'type' => 'file',
                'options' => array(
                    'url' => FALSE,
                ),
                'text' => array(
                    'add_upload_file_text' => esc_html__('Upload', 'provide')
                )
            )
        );
    }

}
