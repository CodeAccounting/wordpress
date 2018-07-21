<?php

class provide_PortfolioMetabox
{

    public function __construct()
    {
        add_action('cmb2_init', array($this, 'provide_RegisterMetabox'));
    }

    public function provide_RegisterMetabox()
    {
        $settings = array(
            'id' => 'portfolio_meta',
            'title' => esc_html__('Additional Fields', 'provide'),
            'object_types' => array('pr_portfolio'),
            'context' => 'normal',
            'priority' => 'high',
            'show_names' => TRUE,
        );
        $meta = new_cmb2_box($settings);
        $fields = $this->provide_fields();
        foreach ($fields as $field) {
            $meta->add_field($field);
        }
        $this->provide_groupFields2($meta);
        $fields = $this->provide_fields2();
        foreach ($fields as $field) {
            $meta->add_field($field);
        }
        $this->provide_groupFields3($meta);
        $this->provide_groupFields4($meta);
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
                'name' => esc_html__('Portfolio Single Style', 'provide'),
                'id' => 'metaSingleLayout',
                'type' => 'radio_img',
                'show_option_none' => FALSE,
                'default' => 'one',
                'options' => array(
                    'one' => '<img src="' . PLUGIN_URI . 'panel/redux-framework/assets/img/style1.jpg" />',
                    'two' => '<img src="' . PLUGIN_URI . 'panel/redux-framework/assets/img/style2.jpg" />'
                )
            ),
            array(
                'name' => esc_html__('Project Short Description', 'provide'),
                'id' => 'metaStyle1Desc',
                'type' => 'textarea_small'
            ),
            array(
                'name' => esc_html__('Customer Name', 'provide'),
                'id' => 'metaStyle1CustomerName',
                'type' => 'text'
            ),
            array(
                'name' => esc_html__('Live Demo', 'provide'),
                'id' => 'metaStyle1LiveDemo',
                'type' => 'text_url'
            ),
            array(
                'name' => esc_html__('Category', 'provide'),
                'id' => 'metaStyle1Category',
                'type' => 'text'
            ),
            array(
                'name' => esc_html__('Date', 'provide'),
                'id' => 'metaStyle1Date',
                'type' => 'text_date'
            ),
            array(
                'name' => esc_html__('Tag', 'provide'),
                'id' => 'metaStyle1Tag',
                'type' => 'text'
            ),
            array(
                'name' => esc_html__('Graph Description', 'provide'),
                'id' => 'metaGraphDesc',
                'type' => 'wysiwyg',
                'options' => array(
                    'wpautop' => true,
                    'media_buttons' => false,
                    'textarea_name' => 'metaGraphDesc',
                    'textarea_rows' => get_option('default_post_edit_rows', 10)
                )
            )
        );
    }

    public function provide_groupFields2($meta)
    {

        $group_field_id = $meta->add_field(array(
            'id' => 'metaGraph',
            'type' => 'group',
            'options' => array(
                'group_title' => esc_html__('Graph {#}', 'provide'),
                'add_button' => esc_html__('Add Another', 'provide'),
                'remove_button' => esc_html__('Remove', 'provide'),
                'sortable' => FALSE,
                'closed' => TRUE
            )
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Year', 'provide'),
            'id' => 'metaGraphYear',
            'type' => 'text'
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Start Value', 'provide'),
            'id' => 'metaGraphStartValue',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
            ),
            'sanitization_cb' => 'absint',
            'escape_cb' => 'absint',
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('End Value', 'provide'),
            'id' => 'metaGraphEndValue',
            'type' => 'text',
            'attributes' => array(
                'type' => 'number',
                'pattern' => '\d*',
            ),
            'sanitization_cb' => 'absint',
            'escape_cb' => 'absint',
        ));
    }

    public function provide_fields2()
    {
        return array(
            array(
                'name' => esc_html__('After Graph Description', 'provide'),
                'id' => 'metaAfterGraphDesc',
                'type' => 'wysiwyg',
                'options' => array(
                    'wpautop' => true,
                    'media_buttons' => false,
                    'textarea_name' => 'metaAfterGraphDesc',
                    'textarea_rows' => get_option('default_post_edit_rows', 10)
                )
            ),
            array(
                'name' => esc_html__('Gallery', 'provide'),
                'id' => 'metaGallery',
                'type' => 'file_list'
            )
        );
    }

    public function provide_groupFields3($meta)
    {
        $group_field_id = $meta->add_field(array(
            'id' => 'metaFAQ',
            'type' => 'group',
            'options' => array(
                'group_title' => esc_html__('FAQ {#}', 'provide'),
                'add_button' => esc_html__('Add Another', 'provide'),
                'remove_button' => esc_html__('Remove', 'provide'),
                'sortable' => FALSE,
                'closed' => TRUE
            )
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Title', 'provide'),
            'id' => 'metaFAQTitle',
            'type' => 'text'
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Description', 'provide'),
            'id' => 'metaFAQDesc',
            'type' => 'textarea_small'
        ));
    }

    public function provide_groupFields4($meta)
    {
        $group_field_id = $meta->add_field(array(
            'id' => 'metaSponsors',
            'type' => 'group',
            'options' => array(
                'group_title' => esc_html__('Sponsors {#}', 'provide'),
                'add_button' => esc_html__('Add Another', 'provide'),
                'remove_button' => esc_html__('Remove', 'provide'),
                'sortable' => FALSE,
                'closed' => TRUE
            )
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Logo', 'provide'),
            'id' => 'metaSponsorsLogo',
            'type' => 'file',
            'options' => array(
                'url' => false,
            )
        ));
        $meta->add_group_field($group_field_id, array(
            'name' => esc_html__('Link', 'provide'),
            'id' => 'metaSponsorsLink',
            'type' => 'text'
        ));
    }

}
